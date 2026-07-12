-- ============================================================================
-- QUERY SQL UNTUK TESTING DAN VERIFIKASI
-- Perbaikan Fitur Nomor SK dan Cetak SK
-- ============================================================================

-- ============================================================================
-- 1. VERIFIKASI STRUKTUR TABEL
-- ============================================================================

-- Cek struktur tabel tb_sk (harus ada kolom tanggal_penetapan)
DESC tb_sk;

-- Cek index yang ada
SHOW INDEX FROM tb_sk;

-- Expected Output:
-- - Kolom: tanggal_penetapan (Type: date, Null: NO)
-- - Index: idx_tanggal_penetapan pada kolom tanggal_penetapan


-- ============================================================================
-- 2. VERIFIKASI DATA SETELAH MIGRATION
-- ============================================================================

-- Cek semua data SK (10 data terakhir)
SELECT 
    id_sk,
    id_pekerja,
    id_no_sk,
    nomor_sk,
    tanggal_penetapan,
    created_at
FROM tb_sk 
ORDER BY id_sk DESC 
LIMIT 10;

-- Cek apakah ada data dengan tanggal_penetapan NULL (harusnya 0)
SELECT COUNT(*) as jumlah_null 
FROM tb_sk 
WHERE tanggal_penetapan IS NULL;

-- Cek distribusi tanggal penetapan
SELECT 
    tanggal_penetapan,
    COUNT(*) as jumlah_sk
FROM tb_sk
GROUP BY tanggal_penetapan
ORDER BY tanggal_penetapan DESC;


-- ============================================================================
-- 3. VERIFIKASI DATA PEGAWAI
-- ============================================================================

-- Cek pegawai yang sudah memiliki nomor SK
SELECT 
    dp.id_pekerja,
    dp.nama,
    dp.status_pekerja,
    sk.nomor_sk,
    sk.tanggal_penetapan
FROM tb_data_pekerja dp
INNER JOIN tb_sk sk ON dp.id_pekerja = sk.id_pekerja
WHERE dp.status_pekerja = 'Terverifikasi'
ORDER BY dp.nama;

-- Cek pegawai yang BELUM memiliki nomor SK
SELECT 
    dp.id_pekerja,
    dp.nama,
    dp.status_pekerja
FROM tb_data_pekerja dp
LEFT JOIN tb_sk sk ON dp.id_pekerja = sk.id_pekerja
WHERE dp.status_pekerja = 'Terverifikasi'
  AND sk.id_sk IS NULL
ORDER BY dp.nama;

-- Hitung jumlah pegawai dengan dan tanpa SK
SELECT 
    'Sudah Ada SK' as status,
    COUNT(DISTINCT dp.id_pekerja) as jumlah
FROM tb_data_pekerja dp
INNER JOIN tb_sk sk ON dp.id_pekerja = sk.id_pekerja
WHERE dp.status_pekerja = 'Terverifikasi'
UNION ALL
SELECT 
    'Belum Ada SK' as status,
    COUNT(dp.id_pekerja) as jumlah
FROM tb_data_pekerja dp
LEFT JOIN tb_sk sk ON dp.id_pekerja = sk.id_pekerja
WHERE dp.status_pekerja = 'Terverifikasi'
  AND sk.id_sk IS NULL;


-- ============================================================================
-- 4. DETEKSI MASALAH: CEK DUPLIKASI NOMOR SK
-- ============================================================================

-- Cek duplikasi nomor SK dalam satu tahun
SELECT 
    nomor_sk,
    id_no_sk,
    COUNT(*) as jumlah_duplikasi
FROM tb_sk
GROUP BY nomor_sk, id_no_sk
HAVING COUNT(*) > 1;

-- Expected Output: Tidak ada hasil (0 rows)
-- Jika ada hasil, berarti ada duplikasi yang perlu diperbaiki


-- ============================================================================
-- 5. VERIFIKASI NOMOR SK UNTUK TAHUN TERTENTU
-- ============================================================================

-- Ganti [ID_NO_SK] dengan id_no_sk yang ingin dicek (misal: 7)
SET @id_no_sk_check = 7;

-- Cek detail nomor SK untuk tahun tertentu
SELECT 
    sk.id_sk,
    sk.id_pekerja,
    dp.nama,
    sk.nomor_sk,
    sk.tanggal_penetapan,
    nsk.tahun,
    nsk.kode_sk,
    nsk.nomor_utama
FROM tb_sk sk
INNER JOIN tb_data_pekerja dp ON sk.id_pekerja = dp.id_pekerja
INNER JOIN tb_no_sk nsk ON sk.id_no_sk = nsk.id_no_sk
WHERE sk.id_no_sk = @id_no_sk_check
ORDER BY sk.tanggal_penetapan DESC, dp.nama ASC;

-- Cek urutan nomor per tanggal penetapan
SELECT 
    tanggal_penetapan,
    nomor_sk,
    COUNT(*) as jumlah
FROM tb_sk
WHERE id_no_sk = @id_no_sk_check
GROUP BY tanggal_penetapan, nomor_sk
ORDER BY tanggal_penetapan, nomor_sk;


-- ============================================================================
-- 6. VERIFIKASI DATA UNTUK CETAK SK
-- ============================================================================

-- Cek data lengkap untuk cetak SK (join semua tabel)
SELECT 
    dp.id_pekerja,
    dp.nama,
    dp.status_pekerja,
    sk.nomor_sk,
    sk.tanggal_penetapan,
    nsk.kode_sk,
    nsk.nomor_utama,
    nsk.tahun,
    uk.unit_kerja,
    np.pekerjaan
FROM tb_data_pekerja dp
INNER JOIN tb_sk sk ON dp.id_pekerja = sk.id_pekerja
INNER JOIN tb_no_sk nsk ON sk.id_no_sk = nsk.id_no_sk
LEFT JOIN tb_riwayat_pekerjaan rp ON dp.id_pekerja = rp.id_pekerja 
    AND rp.status = 'Terverifikasi'
LEFT JOIN tb_unit_kerja uk ON rp.id_unit_kerja = uk.id_unit_kerja
LEFT JOIN tb_nama_pekerjaan np ON rp.id_nama_pekerjaan = np.id_nama_pekerjaan
WHERE dp.status_pekerja = 'Terverifikasi'
  AND nsk.tahun = YEAR(CURDATE())
ORDER BY dp.nama
LIMIT 10;


-- ============================================================================
-- 7. STATISTIK NOMOR SK
-- ============================================================================

-- Statistik per tahun
SELECT 
    nsk.tahun,
    nsk.kode_sk,
    nsk.nomor_utama,
    COUNT(sk.id_sk) as jumlah_sk_digenerate
FROM tb_no_sk nsk
LEFT JOIN tb_sk sk ON nsk.id_no_sk = sk.id_no_sk
GROUP BY nsk.id_no_sk
ORDER BY nsk.tahun DESC;

-- Statistik per tanggal penetapan (tahun berjalan)
SELECT 
    sk.tanggal_penetapan,
    COUNT(*) as jumlah_sk,
    MIN(sk.nomor_sk) as nomor_awal,
    MAX(sk.nomor_sk) as nomor_akhir
FROM tb_sk sk
INNER JOIN tb_no_sk nsk ON sk.id_no_sk = nsk.id_no_sk
WHERE nsk.tahun = YEAR(CURDATE())
GROUP BY sk.tanggal_penetapan
ORDER BY sk.tanggal_penetapan DESC;


-- ============================================================================
-- 8. QUERY UNTUK TROUBLESHOOTING
-- ============================================================================

-- Jika perlu reset nomor SK untuk testing (HATI-HATI!)
-- PASTIKAN BACKUP DULU SEBELUM MENJALANKAN!
-- 
-- DELETE FROM tb_sk WHERE id_no_sk = [ID_NO_SK];

-- Jika perlu hapus nomor SK untuk tanggal tertentu
-- PASTIKAN BACKUP DULU SEBELUM MENJALANKAN!
-- 
-- DELETE FROM tb_sk 
-- WHERE id_no_sk = [ID_NO_SK] 
--   AND tanggal_penetapan = '[TANGGAL]';

-- Update tanggal penetapan untuk data tertentu (jika perlu koreksi)
-- PASTIKAN BACKUP DULU SEBELUM MENJALANKAN!
-- 
-- UPDATE tb_sk 
-- SET tanggal_penetapan = '[TANGGAL_BARU]'
-- WHERE id_sk = [ID_SK];


-- ============================================================================
-- 9. QUERY UNTUK MONITORING
-- ============================================================================

-- Monitor aktivitas generate nomor SK hari ini
SELECT 
    DATE(created_at) as tanggal_generate,
    COUNT(*) as jumlah_sk_dibuat
FROM tb_sk
WHERE DATE(created_at) = CURDATE()
GROUP BY DATE(created_at);

-- Monitor nomor SK yang baru dibuat (7 hari terakhir)
SELECT 
    sk.id_sk,
    sk.id_pekerja,
    dp.nama,
    sk.nomor_sk,
    sk.tanggal_penetapan,
    sk.created_at
FROM tb_sk sk
INNER JOIN tb_data_pekerja dp ON sk.id_pekerja = dp.id_pekerja
WHERE sk.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
ORDER BY sk.created_at DESC;


-- ============================================================================
-- 10. QUERY UNTUK LAPORAN
-- ============================================================================

-- Laporan nomor SK per unit kerja
SELECT 
    uk.unit_kerja,
    COUNT(sk.id_sk) as jumlah_sk,
    MIN(sk.tanggal_penetapan) as tanggal_penetapan_awal,
    MAX(sk.tanggal_penetapan) as tanggal_penetapan_akhir
FROM tb_sk sk
INNER JOIN tb_data_pekerja dp ON sk.id_pekerja = dp.id_pekerja
INNER JOIN tb_riwayat_pekerjaan rp ON dp.id_pekerja = rp.id_pekerja
INNER JOIN tb_unit_kerja uk ON rp.id_unit_kerja = uk.id_unit_kerja
WHERE rp.status = 'Terverifikasi'
GROUP BY uk.id_unit_kerja
ORDER BY uk.unit_kerja;

-- Laporan nomor SK per pekerjaan
SELECT 
    np.pekerjaan,
    COUNT(sk.id_sk) as jumlah_sk
FROM tb_sk sk
INNER JOIN tb_data_pekerja dp ON sk.id_pekerja = dp.id_pekerja
INNER JOIN tb_riwayat_pekerjaan rp ON dp.id_pekerja = rp.id_pekerja
INNER JOIN tb_nama_pekerjaan np ON rp.id_nama_pekerjaan = np.id_nama_pekerjaan
WHERE rp.status = 'Terverifikasi'
GROUP BY np.id_nama_pekerjaan
ORDER BY COUNT(sk.id_sk) DESC;


-- ============================================================================
-- CATATAN PENTING
-- ============================================================================
-- 
-- 1. Selalu BACKUP database sebelum menjalankan query UPDATE/DELETE
-- 2. Gunakan query SELECT terlebih dahulu untuk verifikasi sebelum UPDATE/DELETE
-- 3. Untuk query yang berbahaya (UPDATE/DELETE), pastikan kondisi WHERE benar
-- 4. Monitor error log aplikasi di: writable/logs/
-- 5. Jika ragu, konsultasikan dengan DBA atau administrator sistem
-- 
-- ============================================================================
