#!/bin/bash

# ============================================================================
# Script untuk update file SQL existing dengan tambahan kolom tanggal_penetapan
# ============================================================================
# Tujuan: Mengubah file db_tenaga_kerja_dlh_ok.sql untuk menambahkan
#         kolom tanggal_penetapan dengan nilai default 2025-12-31
# ============================================================================

SOURCE_FILE="/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok.sql"
OUTPUT_FILE="/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok_updated.sql"
BACKUP_FILE="/var/www/dlhapps/si-talenta/db_tenaga_kerja_dlh_ok.sql.backup"

# Warna untuk output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}============================================================================${NC}"
echo -e "${YELLOW}  UPDATE FILE SQL DENGAN KOLOM TANGGAL_PENETAPAN${NC}"
echo -e "${YELLOW}============================================================================${NC}"

# Cek file source ada
if [ ! -f "$SOURCE_FILE" ]; then
    echo -e "${RED}Error: File $SOURCE_FILE tidak ditemukan!${NC}"
    exit 1
fi

echo -e "${GREEN}✓ File source ditemukan${NC}"

# Backup file original
echo -e "${YELLOW}Membuat backup file original...${NC}"
cp "$SOURCE_FILE" "$BACKUP_FILE"
echo -e "${GREEN}✓ Backup dibuat: $BACKUP_FILE${NC}"

# Proses file SQL
echo -e "${YELLOW}Memproses file SQL...${NC}"

# Buat file output baru
cat "$SOURCE_FILE" | awk '
BEGIN {
    in_tb_sk_create = 0
    in_tb_sk_insert = 0
    default_date = "2025-12-31"
}

# Deteksi CREATE TABLE tb_sk
/CREATE TABLE `tb_sk`/ {
    in_tb_sk_create = 1
    print $0
    next
}

# Jika sedang di dalam CREATE TABLE tb_sk
in_tb_sk_create == 1 {
    # Cek jika ada kolom created_at
    if ($0 ~ /`created_at`.*datetime/) {
        # Tambahkan kolom tanggal_penetapan sebelum created_at
        print "  `tanggal_penetapan` date NOT NULL DEFAULT '\''2025-12-31'\'',"
    }
    
    # Print baris original
    print $0
    
    # Cek akhir CREATE TABLE
    if ($0 ~ /ENGINE=/) {
        in_tb_sk_create = 0
    }
    next
}

# Deteksi INSERT INTO tb_sk
/INSERT INTO `tb_sk`/ {
    in_tb_sk_insert = 1
    
    # Ubah kolom list untuk include tanggal_penetapan
    if ($0 ~ /\(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `created_at`/) {
        gsub(/\(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `created_at`/, 
             "(`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `tanggal_penetapan`, `created_at`")
    }
    print $0
    next
}

# Jika sedang di dalam INSERT VALUES tb_sk
in_tb_sk_insert == 1 {
    # Tambahkan tanggal_penetapan ke setiap VALUES
    if ($0 ~ /^\([0-9]+, '\''PG[0-9]+'\''/) {
        # Pattern: (721, 'PG260109252936', 7, '0237.2', '2026-01-19 08:15:02'),
        # Menjadi: (721, 'PG260109252936', 7, '0237.2', '2025-12-31', '2026-01-19 08:15:02'),
        gsub(/, '\''([0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2})'\''\)/, 
             ", '\''2025-12-31'\'', '\''\1'\'')")
    }
    
    print $0
    
    # Cek akhir INSERT (baris yang diakhiri dengan ;)
    if ($0 ~ /;$/) {
        in_tb_sk_insert = 0
    }
    next
}

# Print baris lainnya apa adanya
{
    print $0
}
' > "$OUTPUT_FILE"

echo -e "${GREEN}✓ File berhasil diproses${NC}"

# Verifikasi hasil
echo -e "${YELLOW}Verifikasi hasil...${NC}"

# Cek apakah kolom tanggal_penetapan sudah ditambahkan
if grep -q "tanggal_penetapan" "$OUTPUT_FILE"; then
    echo -e "${GREEN}✓ Kolom tanggal_penetapan berhasil ditambahkan${NC}"
else
    echo -e "${RED}✗ Kolom tanggal_penetapan TIDAK ditemukan!${NC}"
    exit 1
fi

# Cek jumlah baris INSERT dengan tanggal_penetapan
count_old=$(grep -c "INSERT INTO \`tb_sk\`" "$SOURCE_FILE" || echo 0)
count_new=$(grep -c "2025-12-31" "$OUTPUT_FILE" | grep tb_sk || echo 0)

echo -e "${GREEN}✓ File output dibuat: $OUTPUT_FILE${NC}"
echo ""
echo -e "${YELLOW}============================================================================${NC}"
echo -e "${YELLOW}  HASIL PROSES${NC}"
echo -e "${YELLOW}============================================================================${NC}"
echo -e "File Original: $SOURCE_FILE"
echo -e "File Backup  : $BACKUP_FILE"
echo -e "File Output  : $OUTPUT_FILE"
echo ""
echo -e "${GREEN}Proses selesai!${NC}"
echo ""
echo -e "${YELLOW}Langkah selanjutnya:${NC}"
echo "1. Review file output: $OUTPUT_FILE"
echo "2. Jika sudah benar, backup database"
echo "3. Import file baru:"
echo "   mysql -u root -p db_tenaga_kerja_dlh < $OUTPUT_FILE"
echo ""
echo -e "${YELLOW}============================================================================${NC}"
