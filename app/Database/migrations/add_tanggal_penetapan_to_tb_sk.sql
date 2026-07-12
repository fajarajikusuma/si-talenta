-- ============================================================================
-- MIGRATION: Menambahkan kolom tanggal_penetapan ke tabel tb_sk
-- ============================================================================
-- Tujuan: Mendukung pengelolaan nomor SK berdasarkan tanggal penetapan yang berbeda
-- Versi: 2.0
-- Tanggal: 2025-01-XX
-- 
-- PENTING: 
-- 1. BACKUP DATABASE SEBELUM MENJALANKAN MIGRATION INI!
-- 2. Jalankan migration ini sebelum menggunakan fitur generate nomor SK yang baru
-- 3. Verifikasi hasil migration dengan query SELECT setelah selesai
-- ============================================================================

-- LANGKAH 1: Tambahkan kolom tanggal_penetapan (NULL terlebih dahulu untuk data lama)
ALTER TABLE `tb_sk` 
ADD COLUMN `tanggal_penetapan` DATE NULL AFTER `nomor_sk`,
ADD INDEX `idx_tanggal_penetapan` (`tanggal_penetapan`);

-- LANGKAH 2: Update data historis yang sudah ada
-- Set tanggal_penetapan ke tanggal created_at untuk menjaga konsistensi data lama
UPDATE `tb_sk` 
SET `tanggal_penetapan` = DATE(`created_at`) 
WHERE `tanggal_penetapan` IS NULL;

-- LANGKAH 3: Ubah kolom menjadi NOT NULL setelah semua data ter-update
ALTER TABLE `tb_sk` 
MODIFY COLUMN `tanggal_penetapan` DATE NOT NULL;

-- ============================================================================
-- VERIFIKASI MIGRATION
-- ============================================================================
-- Jalankan query berikut untuk memverifikasi migration berhasil:

-- 1. Cek struktur tabel
-- DESC tb_sk;

-- 2. Cek data sudah ter-update
-- SELECT id_sk, id_pekerja, nomor_sk, tanggal_penetapan, created_at 
-- FROM tb_sk 
-- ORDER BY id_sk DESC 
-- LIMIT 10;

-- 3. Cek tidak ada data NULL
-- SELECT COUNT(*) as jumlah_null 
-- FROM tb_sk 
-- WHERE tanggal_penetapan IS NULL;
-- (Hasilnya harus 0)

-- ============================================================================
-- ROLLBACK (JIKA DIPERLUKAN)
-- ============================================================================
-- HATI-HATI: Rollback akan menghapus kolom tanggal_penetapan
-- Pastikan backup database sudah ada sebelum rollback!
-- 
-- Untuk rollback, jalankan query berikut:
-- 
-- ALTER TABLE `tb_sk` 
-- DROP INDEX `idx_tanggal_penetapan`,
-- DROP COLUMN `tanggal_penetapan`;
-- 
-- ============================================================================
