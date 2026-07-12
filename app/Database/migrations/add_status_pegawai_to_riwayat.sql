-- Migration: Menambahkan status pegawai (percobaan/aktif) dan gaji pokok
-- Tanggal: 2026-01-12

-- Menambahkan kolom status_pegawai dan gaji_pokok
ALTER TABLE `tb_riwayat_pekerjaan` 
ADD COLUMN `status_pegawai` ENUM('Percobaan', 'Aktif') NOT NULL DEFAULT 'Aktif' AFTER `jenis_pegawai`,
ADD COLUMN `gaji_pokok` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `status`,
ADD COLUMN `masa_percobaan_mulai` DATE NULL AFTER `gaji_pokok`,
ADD COLUMN `masa_percobaan_selesai` DATE NULL AFTER `masa_percobaan_mulai`;

-- Update data existing: set gaji_pokok sama dengan gaji yang ada
UPDATE `tb_riwayat_pekerjaan` 
SET `gaji_pokok` = CAST(`gaji` AS DECIMAL(15,2))
WHERE `gaji` != '' AND `gaji` IS NOT NULL;

-- Komentar untuk dokumentasi
-- status_pegawai: Status pegawai apakah dalam masa percobaan atau sudah aktif
-- gaji_pokok: Gaji 100% yang seharusnya diterima pegawai
-- gaji: Gaji yang diterima (80% jika percobaan, 100% jika aktif)
-- masa_percobaan_mulai: Tanggal mulai masa percobaan (diisi otomatis dari tmt_kerja jika status percobaan)
-- masa_percobaan_selesai: Tanggal selesai masa percobaan (3 bulan dari mulai)
