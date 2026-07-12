#!/usr/bin/env python3
"""
Script untuk menambahkan kolom tanggal_penetapan ke file SQL existing
Semua data nomor SK yang sudah ada akan diberi tanggal penetapan: 2025-12-31
"""

import re
import sys
from datetime import datetime

# Konfigurasi
SOURCE_FILE = "/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok.sql"
OUTPUT_FILE = "/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok_updated.sql"
BACKUP_FILE = "/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok.sql.backup"
DEFAULT_DATE = "2025-12-31"

def print_header():
    print("=" * 80)
    print("  UPDATE FILE SQL - TAMBAH KOLOM TANGGAL_PENETAPAN")
    print("=" * 80)
    print(f"Source File : {SOURCE_FILE}")
    print(f"Output File : {OUTPUT_FILE}")
    print(f"Backup File : {BACKUP_FILE}")
    print(f"Default Date: {DEFAULT_DATE}")
    print("=" * 80)

def backup_source_file():
    """Backup file original"""
    print("\n[1/4] Membuat backup file original...")
    try:
        with open(SOURCE_FILE, 'r', encoding='utf-8') as src:
            content = src.read()
        with open(BACKUP_FILE, 'w', encoding='utf-8') as bak:
            bak.write(content)
        print(f"     ✓ Backup berhasil: {BACKUP_FILE}")
        return True
    except Exception as e:
        print(f"     ✗ Error backup: {e}")
        return False

def process_sql_file():
    """Proses file SQL untuk menambahkan kolom tanggal_penetapan"""
    print("\n[2/4] Memproses file SQL...")
    
    try:
        with open(SOURCE_FILE, 'r', encoding='utf-8') as f:
            lines = f.readlines()
        
        output_lines = []
        in_tb_sk_create = False
        in_tb_sk_insert = False
        insert_buffer = []
        
        for i, line in enumerate(lines):
            # Deteksi CREATE TABLE tb_sk
            if "CREATE TABLE `tb_sk`" in line:
                in_tb_sk_create = True
                output_lines.append(line)
                continue
            
            # Jika sedang di CREATE TABLE tb_sk
            if in_tb_sk_create:
                # Tambahkan kolom tanggal_penetapan sebelum created_at
                if "`created_at`" in line and "datetime" in line:
                    # Tambahkan kolom baru
                    indent = "  "
                    output_lines.append(f"{indent}`tanggal_penetapan` date NOT NULL DEFAULT '{DEFAULT_DATE}',\n")
                    print(f"     ✓ Kolom tanggal_penetapan ditambahkan di CREATE TABLE")
                
                output_lines.append(line)
                
                # Akhir CREATE TABLE
                if "ENGINE=" in line or ") ENGINE=" in line:
                    in_tb_sk_create = False
                continue
            
            # Deteksi INSERT INTO tb_sk
            if "INSERT INTO `tb_sk`" in line:
                in_tb_sk_insert = True
                
                # Ubah column list
                if "(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `created_at`" in line:
                    line = line.replace(
                        "(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `created_at`",
                        "(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `tanggal_penetapan`, `created_at`"
                    )
                    print(f"     ✓ Column list INSERT INTO tb_sk diupdate")
                
                output_lines.append(line)
                continue
            
            # Jika sedang di INSERT tb_sk VALUES
            if in_tb_sk_insert:
                # Pattern: (721, 'PG260109252936', 7, '0237.2', '2026-01-19 08:15:02'),
                # Ubah menjadi: (721, 'PG260109252936', 7, '0237.2', '2025-12-31', '2026-01-19 08:15:02'),
                
                # Regex pattern untuk mendeteksi VALUES row
                pattern = r"\((\d+),\s*'(PG\d+)',\s*(\d+),\s*'([^']+)',\s*'(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})'\)"
                
                if re.search(pattern, line):
                    # Replace dengan menambahkan tanggal_penetapan
                    line = re.sub(
                        pattern,
                        rf"(\1, '\2', \3, '\4', '{DEFAULT_DATE}', '\5')",
                        line
                    )
                
                output_lines.append(line)
                
                # Cek akhir INSERT
                if line.strip().endswith(';'):
                    in_tb_sk_insert = False
                    print(f"     ✓ Data INSERT tb_sk diupdate dengan tanggal_penetapan")
                continue
            
            # Baris lainnya
            output_lines.append(line)
        
        # Tulis ke file output
        with open(OUTPUT_FILE, 'w', encoding='utf-8') as f:
            f.writelines(output_lines)
        
        print(f"     ✓ File output dibuat: {OUTPUT_FILE}")
        return True, len(output_lines)
        
    except Exception as e:
        print(f"     ✗ Error proses file: {e}")
        return False, 0

def verify_output():
    """Verifikasi hasil output"""
    print("\n[3/4] Verifikasi hasil...")
    
    try:
        with open(OUTPUT_FILE, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Cek kolom tanggal_penetapan ada di CREATE TABLE
        if "`tanggal_penetapan` date NOT NULL" in content:
            print("     ✓ Kolom tanggal_penetapan ada di CREATE TABLE")
        else:
            print("     ✗ Kolom tanggal_penetapan TIDAK DITEMUKAN di CREATE TABLE")
            return False
        
        # Cek tanggal_penetapan ada di INSERT
        count_date = content.count(f"'{DEFAULT_DATE}'")
        if count_date > 0:
            print(f"     ✓ Tanggal {DEFAULT_DATE} ditemukan {count_date} kali")
        else:
            print(f"     ✗ Tanggal {DEFAULT_DATE} TIDAK DITEMUKAN di INSERT")
            return False
        
        # Cek struktur INSERT sudah benar
        if "(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `tanggal_penetapan`, `created_at`" in content:
            print("     ✓ Struktur INSERT INTO tb_sk sudah benar")
        else:
            print("     ✗ Struktur INSERT INTO tb_sk BELUM BENAR")
            return False
        
        return True
        
    except Exception as e:
        print(f"     ✗ Error verifikasi: {e}")
        return False

def print_summary():
    """Print ringkasan hasil"""
    print("\n[4/4] Ringkasan")
    print("=" * 80)
    print("✓ File SQL berhasil diupdate!")
    print("")
    print("File yang dibuat:")
    print(f"  - Backup : {BACKUP_FILE}")
    print(f"  - Output : {OUTPUT_FILE}")
    print("")
    print("Perubahan yang dilakukan:")
    print(f"  1. Tambah kolom `tanggal_penetapan` date NOT NULL DEFAULT '{DEFAULT_DATE}'")
    print(f"  2. Update semua INSERT dengan tanggal_penetapan = '{DEFAULT_DATE}'")
    print("")
    print("Langkah selanjutnya:")
    print("  1. Review file output untuk memastikan tidak ada error")
    print("  2. BACKUP DATABASE Anda!")
    print("  3. Import file SQL yang baru:")
    print(f"     mysql -u root -p db_tenaga_kerja_dlh < {OUTPUT_FILE}")
    print("")
    print("=" * 80)

def main():
    print_header()
    
    # Step 1: Backup
    if not backup_source_file():
        print("\n✗ Proses dibatalkan karena gagal backup")
        sys.exit(1)
    
    # Step 2: Process
    success, line_count = process_sql_file()
    if not success:
        print("\n✗ Proses dibatalkan karena gagal memproses file")
        sys.exit(1)
    
    # Step 3: Verify
    if not verify_output():
        print("\n✗ Proses dibatalkan karena verifikasi gagal")
        sys.exit(1)
    
    # Step 4: Summary
    print_summary()
    
    print("\n✓ Proses selesai dengan sukses!")

if __name__ == "__main__":
    main()
