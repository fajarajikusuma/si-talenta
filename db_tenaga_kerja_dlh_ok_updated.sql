-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 12 Jul 2026 pada 04.10
-- Versi server: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tenaga_kerja_dlh`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dasar_hukum`
--

CREATE TABLE `tb_dasar_hukum` (
  `id` int(11) NOT NULL,
  `nama_dasar_hukum` text NOT NULL,
  `nomor` text NOT NULL,
  `tahun` text NOT NULL,
  `tentang` text NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_dasar_hukum`
--

INSERT INTO `tb_dasar_hukum` (`id`, `nama_dasar_hukum`, `nomor`, `tahun`, `tentang`, `upload_dokumen`, `status`) VALUES
(1, 'Peraturan Daerah', '11', '2024', 'Anggaran Pendapatan dan Belanja Daerah Kota Pekalongan Tahun Anggaran 2025', '1751359019_306d31cc6bcd2580bdf4.pdf', 'Tidak Aktif'),
(2, 'Peraturan Wali Kota ', '47', '2024', 'Penjabaran Anggaran Pendapatan dan Belanja Daerah Kota Pekalongan Tahun Anggaran 2025', '1751359699_92de9d70a0ca4f65fef4.pdf', 'Tidak Aktif'),
(3, 'Peraturan Daerah', '10', '2025', 'Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2026', '1768443288_9cb448472f580f303124.pdf', 'Aktif 1'),
(4, 'Peraturan Wali Kota', '48', '2025', 'Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2026', '1768443338_defe668ea777941e5064.pdf', 'Aktif 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_pekerja`
--

CREATE TABLE `tb_data_pekerja` (
  `id_pekerja` char(14) NOT NULL,
  `nik` char(16) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(30) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` varchar(133) DEFAULT NULL,
  `rt/rw` text DEFAULT NULL,
  `desa/kelurahan` text DEFAULT NULL,
  `kecamatan` text DEFAULT NULL,
  `kota_tinggal` text DEFAULT NULL,
  `provinsi` text DEFAULT NULL,
  `kode_pos` varchar(12) DEFAULT NULL,
  `ktp` text DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `gelar_depan` varchar(12) DEFAULT NULL,
  `gelar_belakang` varchar(12) DEFAULT NULL,
  `ijasah` text DEFAULT NULL,
  `status_pekerja` enum('Terverifikasi','Menunggu','Tidak Aktif','Pensiun') NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_data_pekerja`
--

INSERT INTO `tb_data_pekerja` (`id_pekerja`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `rt/rw`, `desa/kelurahan`, `kecamatan`, `kota_tinggal`, `provinsi`, `kode_pos`, `ktp`, `pendidikan`, `jurusan`, `gelar_depan`, `gelar_belakang`, `ijasah`, `status_pekerja`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PG260109252897', '3327111704020001', 'Fajar Aji Kusuma', 'Pemalang', '2002-04-17', 'L', 'Tegalsari Timur', '43/08', 'Tegalsari Timur', 'Ampelgading', 'Pemalang', 'Jawa Tengah', '52364', '', 'S1', 'Teknik Informatika', '-', 'S.Kom.', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:17:39', '0000-00-00 00:00:00'),
('PG260109252898', '3375012908810002', 'Triono', 'Pekalongan', '1981-08-29', 'L', 'Pekuncen', '02/06', 'Pekuncen', 'Wiradesa', 'Pekalongan', 'Jawa Tengah', '51152', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:25:35', '0000-00-00 00:00:00'),
('PG260109252899', '3375012209670003', 'Slamet Tukon', '-', '1967-09-22', '', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Pensiun', '', '2026-01-09 03:42:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG260109252900', '3375030909670008', 'Amat Muhidin', '-', '1967-09-09', '', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Pensiun', '', '2026-01-09 03:42:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG260109252901', '3326160702960041', 'Muhammad Tomy Abdul Haris', 'Pekalongan', '1996-02-07', 'L', 'Pekuncen', '01/01', 'Pekuncen', 'Wiradesa', 'Pekalongan', 'Jawa Tengah', '51152', '', 'SMK', 'Teknik Kendaraan Ringan', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:29:16', '0000-00-00 00:00:00'),
('PG260109252902', '3375010107790150', 'Bambang Setiaji', 'Pekalongan ', '1979-07-01', 'L', 'Kergon Gg 5a - 3b', '05/15', 'Bendan Kergon', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51113', '', 'SMA', 'Mesin Tenaga', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:08:05', '0000-00-00 00:00:00'),
('PG260109252903', '3326142604680003', 'Abd. Aziz', 'Pekalongan ', '1970-04-25', 'L', '-', '-', '-', '-', '-', '-', '-', '', 'SMP', '-', '-', '-', '', 'Tidak Aktif', 'Undur Diri', '2026-01-09 03:42:22', '2026-01-19 01:14:17', '0000-00-00 00:00:00'),
('PG260109252904', '3375017010920008', 'Friessanti Adi Valindyasari', 'Pekalongan', '1992-10-30', 'P', 'Jl. Berlian No.21', '01/09', 'Podosugih', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51111', '', 'S1', 'Sains', '-', 'S.Si.', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:48:55', '0000-00-00 00:00:00'),
('PG260109252905', '3375020710960003', 'Chafidh Rochmatullah', 'Pekalongan ', '1996-10-07', 'L', 'Klego Bantaran Gg 3 No 172', '03/07', 'Klego', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51124', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:01:28', '0000-00-00 00:00:00'),
('PG260109252906', '3375021405750003', 'Kalimin', 'Pekalongan ', '1975-05-13', 'L', 'Jl. Otto Iskandar Dinata Gg 4', '01/05', 'Sokorejo', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51129', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:12:51', '0000-00-00 00:00:00'),
('PG260109252907', '3375031303750005', 'Mursalin', 'Batang', '1975-03-13', 'L', 'Degayu', '03/01', 'Degayu', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51148', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:28:22', '0000-00-00 00:00:00'),
('PG260109252908', '3375010309790006', 'Iwan Santosa', 'Cirebon', '1979-09-03', 'L', 'Klaster Sathia Medono B 16', '07/10', 'Medono', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51111', '', 'SMA', 'IPS', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:11:03', '0000-00-00 00:00:00'),
('PG260109252909', '3375010911850002', 'Ali Akbar', 'Jakarta', '1985-11-09', 'L', 'Pesindon GG 2A No 4', '06/12', 'Bendan Kergon', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51115', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:06:53', '0000-00-00 00:00:00'),
('PG260109252910', '3375014803890004', 'Nurmalita', 'Pekalongan', '1989-03-08', 'P', 'Pasirsari', '05/05', 'Pasirkratonkramat', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51117', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:23:07', '0000-00-00 00:00:00'),
('PG260109252911', '3375044212890004', 'Sri Wijayanti', 'Pekalongan ', '1989-12-02', 'P', 'Dk. Kalibogor', '07/04', 'Penangkan', 'Wonotunggal', 'Batang', 'Jawa Tengah', '51253', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:35:53', '0000-00-00 00:00:00'),
('PG260109252912', '3375032404020001', 'Slamet Muzafak', 'Pekalongan ', '2002-04-24', 'L', 'Jl. H. Usman', '07/12', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SMK', 'Bisnis Daring dan Pemasaran', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:25:23', '0000-00-00 00:00:00'),
('PG260109252913', '3375035309860002', 'Purwati', 'Pekalongan ', '1985-09-13', 'P', 'Jl. Tentara Pelajar Gg 7c', '05/02', 'Kandang Panjang', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51144', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:20:53', '0000-00-00 00:00:00'),
('PG260109252914', '3375021805850005', 'Asrofudin', 'Pekalongan ', '1985-05-18', 'L', 'Landungsari Gg 15 No 27', '02/12', 'Noyontaansari', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51129', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:31:23', '0000-00-00 00:00:00'),
('PG260109252915', '3375032403830004', 'Muchammad Fariz', 'Pekalongan ', '1983-03-24', 'L', 'Kraton Lor Gang 4 A No 1', '01/07', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:33:33', '0000-00-00 00:00:00'),
('PG260109252916', '3375041109840005', 'Zaenal', 'Pekalongan', '1984-09-11', 'L', 'Yosorejo', '05/06', 'Kuripan Yosorejo', 'Pekalongan Selatan', 'Pekalongan', 'Jawa Tengah', '51135', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:30:57', '0000-00-00 00:00:00'),
('PG260109252917', '3375031606680007', 'Wasmuri', 'Pekalongan ', '1968-06-16', 'L', 'Degayu', '02/09', 'Degayu', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51148', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:18:55', '0000-00-00 00:00:00'),
('PG260109252918', '3375031607010005', 'Muhammad Muttaqin', 'Pekalongan ', '2001-07-16', 'L', 'Kraton Lor Gg. 3a', '03/06', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SMK', 'Teknik dan Bisnis Sepeda Motor', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:41:59', '0000-00-00 00:00:00'),
('PG260109252919', '3375024710980004', 'Sabila Oktaviani Putri', 'Perempuan ', '1998-10-07', 'P', 'Poncol Gg. Kemuning No. 38', '05/09', 'Poncol', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SMK', 'Administrasi Perkantoran', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:27:35', '0000-00-00 00:00:00'),
('PG260109252920', '3375031102960006', 'Widiyanto', 'Pekalongan ', '1998-02-11', 'L', 'Jl. Pantai Sari Perumahan Nelayan No. 75', '05/09', 'Panjang Baru', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51141', '', 'SMA', 'IPS', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:06:13', '0000-00-00 00:00:00'),
('PG260109252921', '3375032605890001', 'Radna Pambudhi', 'Pekalongan ', '1989-05-26', 'L', 'Jl. Dwikorano 26 Yosorejo Gg 6a', '01/09', 'Kuripan Yosorejo', 'Pekalongan Selatan', 'Pekalongan', 'Jawa Tengah', '51135', '', 'S1', 'Pendidikan', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:47:47', '0000-00-00 00:00:00'),
('PG260109252922', '3375030707720008', 'Fatchurohman', 'Pekalongan ', '1972-07-07', 'L', 'Jl. Kanver 4 - 136', '06/09', 'Krapyak', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51147', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:11:27', '0000-00-00 00:00:00'),
('PG260109252923', '3375026505730001', 'Anita Uslifa', 'Pekalongan ', '1973-05-25', 'P', 'Poncol Gg Bugenvil', '04/11', 'Poncol', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SMA', 'Ilmu-Ilmu Sosial', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-22 07:39:24', '0000-00-00 00:00:00'),
('PG260109252924', '3375035706810001', 'Masro\'ah', 'Pekalongan ', '1981-06-17', 'P', 'Jl. Pramuka No.22', '07/15', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:03:15', '0000-00-00 00:00:00'),
('PG260109252925', '3375030309980001', 'Slamet Mulyono', 'Pekalongan ', '1998-09-03', 'L', 'Bandengan', '02/03', 'Bandengan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51143', '', 'SMA', 'Teknik Transmisi Tenaga Listrik', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:23:34', '0000-00-00 00:00:00'),
('PG260109252926', '3375032806850008', 'Arif Budiono', 'Pekalongan ', '1985-06-29', 'L', 'Jl. Progo Dukuh Gudang No. 1', '01/03', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SMA', 'Akuntansi', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:58:39', '0000-00-00 00:00:00'),
('PG260109252927', '3326150201880001', 'Sutaji', 'Pekalongan', '1988-01-02', 'L', 'Pabean', '05/13', 'Padukuhan Kraton', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51146', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:26:47', '0000-00-00 00:00:00'),
('PG260109252928', '3375030308800005', 'Ady Laksono', 'Pekalongan ', '1980-08-03', 'L', 'Jl. Kencono Wungu 5 D/26', '02/09', 'Kandang Panjang', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51149', '', 'SMK', 'Perdagangan', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:35:40', '0000-00-00 00:00:00'),
('PG260109252929', '3375015708810008', 'Indah Elliana', 'Pekalongan ', '1981-08-17', 'P', 'Kebulen Gg 12 No 9', '02/14', 'Sapuro Kebulen', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51112', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:36:36', '0000-00-00 00:00:00'),
('PG260109252930', '3326162512720041', 'Taufik Rahman', 'Pekalongan ', '1972-12-25', 'L', 'Perum Bwb Il Blok Ac.4', '05/10', 'Pekuncen', 'Wiradesa', 'Pekalongan', 'Jawa Tengah', '51152', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:20:38', '0000-00-00 00:00:00'),
('PG260109252931', '3375022606910006', 'Agung Wibowo', 'Pekalongan ', '1991-06-25', 'L', 'Pulomas No 11', '04/12', 'Noyontaansari', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51129', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:09:14', '0000-00-00 00:00:00'),
('PG260109252932', '3375033007020005', 'Irfan Ali', 'Pekalongan', '2002-07-30', 'L', 'Slamaran Kel. Degayu', '01/09', 'Degayu', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51148', '', 'SMA', 'IPS', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:56:25', '0000-00-00 00:00:00'),
('PG260109252933', '3375030107060001', 'Nurochim', 'Pekalongan ', '2006-07-01', 'L', 'Jl. Labuhan I Clumprit', '05/07', 'Degayu', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51148', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:43:11', '0000-00-00 00:00:00'),
('PG260109252934', '3375012311980003', 'Khaerul Umam', 'Pekalongan ', '1998-11-23', 'L', 'Jl. Pramuka No. 102', '07/04', 'Pasirkratonkramat', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51117', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 01:25:26', '0000-00-00 00:00:00'),
('PG260109252935', '3375021412780001', 'Zamproni', 'Pekalongan ', '1978-12-14', 'L', 'Jl. Kebonsari', '01/15', 'Setono', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SMA', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:39:20', '0000-00-00 00:00:00'),
('PG260109252936', '3375030112940006', 'Achmad Zakaria', 'Pekalongan ', '1994-12-01', 'L', 'Salam Manis', '04/06', 'Kandang Panjang', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51149', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:21:47', '0000-00-00 00:00:00'),
('PG260109252937', '3375021812810002', 'Suprianto', 'Pekalongan ', '1981-12-18', 'L', 'Poncol Gang 7 No 42', '05/02', 'Poncol', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SMK', 'Akuntansi', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:16:46', '0000-00-00 00:00:00'),
('PG260109252938', '3318101501930003', 'Galih Prasetya', 'Pekalongan ', '1992-10-21', 'L', 'Perum Citra Harmoni', '02/04', 'Rowobelang', 'Batang', 'Batang', 'Jawa Tengah', '51216', '', 'SMK', 'Teknik Otomotif Kendaraan Ringan', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 07:50:53', '0000-00-00 00:00:00'),
('PG260109252939', '3375033009990002', 'Reza Yahya', 'Pekalongan ', '1999-09-30', 'L', 'Panjang Wetan Gg 1-4', '02/07', 'Panjang Wetan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51141', '', 'SMK', 'Teknik Pengelasan', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 08:15:09', '0000-00-00 00:00:00'),
('PG260109252941', '3375032602790002', 'Nidhom Adinata', 'Pekalongan ', '1979-02-26', 'L', 'Jl. Ulin 4 No.7 Slamaran', '01/12', 'Krapyak', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51147', '', 'SMK', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-14 00:46:06', '0000-00-00 00:00:00'),
('PG260109252942', '3375023008670004', 'Rokhim', '-', '1967-08-30', '', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Pensiun', '', '2026-01-09 03:42:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG260109252943', '3375020506670003', 'Abdul Rozak', '-', '1967-06-05', '', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Pensiun', '', '2026-01-09 03:42:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG260109252944', '3327052503950008', 'Jamal Adi Prasetiyo', 'Pemalang', '1995-03-25', 'L', 'Pendowo', '06/01', 'Pendowo', 'Bodeh', 'Pemalang', 'Jawa Tengah', '52365', '', 'S1', 'Teknik Kimia', '-', 'S.T.', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:14:39', '0000-00-00 00:00:00'),
('PG260109252945', '3325124101010003', 'Vina Aida Roza', 'Batang', '2001-01-01', 'P', 'Menguneng', '15/04', 'Menguneng', 'Warungasem', 'Batang', 'Jawa Tengah', '51252', '', 'S1', 'Kimia', '-', 'S.Si.', '', 'Tidak Aktif', 'Mengundurkan Diri', '2026-01-09 03:42:22', '2026-07-06 12:22:23', '0000-00-00 00:00:00'),
('PG260109252946', '3375031902970003', 'Rizqi Tri Atmaja', 'Pekalongan', '1997-02-19', 'L', 'Citra Harmoni Jl. Harmoni 4 No 12', '02/04', 'Rowobelang', 'Batang', 'Batang', 'Jawa Tengah', '51216', '', 'S1', 'Manajemen', '-', 'S.M.', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:45:52', '0000-00-00 00:00:00'),
('PG260109252947', '3326172509960002', 'Dhimas Abimanyu', 'Bogor', '1996-09-25', 'L', 'Jl. Kusuma Bangsa Gg. Pahlawan 3/45', '04/01', 'Panjang Baru', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51141', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:40:04', '0000-00-00 00:00:00'),
('PG260109252948', '3375026912900006', 'Esti Herti', 'Pekalongan', '1990-11-29', 'P', 'Noyontaan Gg. 12 A', '01/07', 'Noyontaansari', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51129', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:49:01', '0000-00-00 00:00:00'),
('PG260109252949', '3375022707800004', 'Edy Santoso', 'Pekalongan', '1980-07-28', 'L', 'Jl. Dr. Wahidin Noyontaansari Gg 8 No 11', '05/03', 'Noyontaansari', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51129', '', 'SMA', 'IPS', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:37:54', '0000-00-00 00:00:00'),
('PG260109252950', '3326152409870004', 'Saiful Bahri', 'Pekalongan', '1987-09-24', 'L', 'Panjang Baru', '04/01', 'Panjang Baru', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51141', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:42:02', '0000-00-00 00:00:00'),
('PG260109252951', '3375023008960006', 'Choirul Umam', 'Pekalongan', '1996-08-30', 'L', 'Jl. Otto Iskandardinata', '03/04', 'Kali Baros', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51128', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:23:43', '0000-00-00 00:00:00'),
('PG260109252952', '3375022812040002', 'Aulia Triska Prasojo', 'Pekalongan', '2004-12-28', 'L', 'Jl. Truntum Klego GG 3', '03/02', 'Klego', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '57385', '', 'SMA', 'Multimedia', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:28:49', '0000-00-00 00:00:00'),
('PG260109252953', '3375021507740003', 'Mudakir', 'Pekalongan', '1974-07-15', 'L', 'Poncol Gang Gambir', '07/07', 'Poncol', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:39:52', '0000-00-00 00:00:00'),
('PG260109252954', '3375012902760006', 'Kusnanto', 'Pekalongan', '1976-02-29', 'L', 'Jl. Kh. Mas Mansyur GG XI No 2', '02/06', 'Bendan Kergon', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51113', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:56:05', '0000-00-00 00:00:00'),
('PG260109252955', '3375040705980006', 'M. Lutfi', 'Pekalongan', '1998-05-07', 'L', 'Dk Bogor', '01/06', 'Depok', 'Siwalan', 'Pekalongan', 'Jawa Tengah', '51137', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:50:53', '0000-00-00 00:00:00'),
('PG260109252956', '3375020708930005', 'Nurohman', 'Pekalongan', '1993-08-07', 'L', 'Jl. Hos Cokroaminoto Gang 23 No 11', '01/04', 'Kuripan Kertoharjo', 'Pekalongan Selatan', 'Pekalongan', 'Jawa Tengah', '51134', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:23:38', '0000-00-00 00:00:00'),
('PG260109252957', '3375030312740003', 'Muhammad Ali', 'Tegal', '1974-12-03', 'L', 'Panjang Wetan Gg 2 No 6', '03/07', 'Panjang Wetan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '51144', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:08:39', '0000-00-00 00:00:00'),
('PG260109252958', '3375012403940004', 'Adi Kurniawan', 'Pekalongan', '1994-03-24', 'L', 'Jl. Kramatsari Ill Gg. 13 No 43', '01/11', 'Pasirkratonkramat', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51117', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:33:04', '0000-00-00 00:00:00'),
('PG260109252959', '3375022009790003', 'M. Akrommudin', 'Pekalongan', '1979-09-20', 'L', 'Dk Menguneng Kebaton', '13/4', 'Desa Menguneng', 'Kec. Warungasem', 'Kab. Batang', 'Jawa Tengah ', '51252', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-21 08:40:53', '0000-00-00 00:00:00'),
('PG260109252960', '3375021001980005', 'Muhammad Romadhon', 'Pekalongan', '1998-01-10', 'L', 'Poncol Gumuk Asri No 6', '01/11', 'Poncol', 'Pekalongan Timur', 'Pekalongan', 'Jawa Tengah', '51122', '', 'SD', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 03:52:13', '0000-00-00 00:00:00'),
('PG260109252961', '3402061503780003', 'Supriyanto', 'Bantul', '1978-03-15', 'L', 'Kuripan Lor GG 4', '07/01', 'Kuripan Yosorejo', 'Pekalongan Selatan', 'Pekalongan', 'Jawa Tengah', '51135', '', 'SMP', '-', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:32:23', '0000-00-00 00:00:00'),
('PG260109252962', '3375012203890007', 'Nurul Khafidhin', 'Pekalongan', '1989-03-22', 'L', 'Kebulen GG 6 No 13', '01/13', 'Sapuro Kebulen', 'Pekalongan Barat', 'Pekalongan', 'Jawa Tengah', '51119', '', 'SMA', 'IPS', '-', '-', '', 'Terverifikasi', '', '2026-01-09 03:42:22', '2026-01-13 02:20:47', '0000-00-00 00:00:00'),
('PG260129995530', '3375042501050003', 'Ulil Amri', 'Pekalongan', '2006-01-25', 'L', 'Buaran Gang 1 No 73', '04/01', 'Buaran Kradenan ', 'Pekalongan Selatan', 'Pekalongan', 'Jawa Tengah', '51132', 'KTPPG2601299955301769657447_f4df0fe26fc5be1021ba.pdf', 'SMP', '-', '-', '-', 'IJAZAHPG2601299955301769657447_a4f2206ecdf85f8b507b.pdf', 'Terverifikasi', '', '2026-01-29 03:30:47', '2026-05-19 02:22:49', '0000-00-00 00:00:00'),
('PG260709582949', '3327114309010003', 'Isna Septiana', 'Pemalang', '2001-09-03', 'P', 'Losari', '006/005', 'Losari', 'Ampelgading', 'Pemalang', 'Jawa Tengah', '52364', 'KTPPG2607095829491783566838_4f2a203462ecbcd2cafc.pdf', 'S1', 'Kimia', '-', 'S.Si.', 'IJAZAHPG2607095829491783566838_0a123c78bbec41b50af1.pdf', 'Terverifikasi', '', '2026-07-09 03:13:58', '2026-07-10 13:04:22', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kepala`
--

CREATE TABLE `tb_kepala` (
  `id_kepala` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_kepala` text NOT NULL,
  `jabatan` text NOT NULL,
  `jabatan_short` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kepala`
--

INSERT INTO `tb_kepala` (`id_kepala`, `id_unit_kerja`, `nip`, `nama_kepala`, `jabatan`, `jabatan_short`, `keterangan`, `status`) VALUES
(8, 9, '196711091996031002', 'JOKO PURNOMO, S.T.', 'Kepala Dinas Lingkungan Hidup', 'Kepala', 'Kadin Pada DLH Kota Pekalongan', 'Aktif'),
(9, 1, '197606072000122004', 'DWI YUNIASTUTI, S.KM., M.M.', 'Sekretaris Dinas Lingkungan Hidup', 'Sekretaris', 'Sekdin Pada DLH Kota Pekalongan', 'Aktif'),
(10, 3, '196808161990031009', 'ADI SETIAWAN, S.E.', 'Kepala Bidang Kebesihan dan Pengelolaan Sampah', 'Kepala Bidang', 'Kabid Pada Bidang Kebesihan dan Pengelolaan Sampah', 'Aktif'),
(11, 5, '197806032005011012', 'ADI USNAN, S.E.', 'Kepala Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Kepala Bidang', 'Kabid Pada Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Aktif'),
(12, 2, '197808282011012002', 'AGUS KURNIAWAN, S.Akun.', 'Kepala Bidang Tata Lingkungan dan Penaatan Hukum Lingkungan', 'Kepala Bidang', 'Kepala Bidang Taling Pada Bidang Taling', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nama_pekerjaan`
--

CREATE TABLE `tb_nama_pekerjaan` (
  `id_nama_pekerjaan` int(11) NOT NULL,
  `pekerjaan` text NOT NULL,
  `uraian_kerja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_nama_pekerjaan`
--

INSERT INTO `tb_nama_pekerjaan` (`id_nama_pekerjaan`, `pekerjaan`, `uraian_kerja`) VALUES
(114, 'Tenaga Administrasi', 'Mengelola dan mendukung administrasi perkantoran serta pencatatan data.'),
(115, 'Tenaga Kebersihan Taman Hutan Raya (TAHURA)', 'Menjaga kebersihan dan kenyamanan lingkungan TAHURA.'),
(116, 'Tenaga Kebersihan Perapihan Pohon', 'Membersihkan area sekitar pohon dan merapikan ranting atau dedaunan yang mengganggu.'),
(117, 'Petugas Keamanan', 'Menjaga keamanan dan ketertiban di lingkungan kerja.'),
(128, 'Pengemudi Angkutan Sampah', 'Petugas yang bertanggung jawab mengoperasikan kendaraan pengangkut sampah untuk mengumpulkan dan mengangkut sampah dari tempat - tempat pembuangan sampah sementara ke tempet pembuangan akhir'),
(129, 'Kru Angkutan Sampah', 'Petugas yang bertanggung jawab untuk mengumpulkan dan mengangkut sampah dari tempat-tempat pembuangan sampah sementara ke tempat pembuangan akhir'),
(130, 'Petugas Depo', 'Petugas yang bertanggung jawab mengelola dan mengawasi kegiatan didepo sampah yaitu tempat pengumpulan dan pengolahan sampah sementara sebelum diangkut ke tempat pembuangan akhir'),
(131, 'Petugas Patroli', 'Petugas yang bertanggung jawab melakukan pengawasan dan pemantauan terhadap kegiatan pembuangan sampah diwilayah tertentu'),
(132, 'Tenaga Administrasi Bank Sampah', 'Petugas yang bertanggung jawab mengelola Administrasi dan operasional bank sampah induk'),
(133, 'Petugas Pengelola Bank Sampah', 'Petugas yang bertanggung jawab mengelola dan mengawasi kegiatan operasional Bank sampah induk'),
(134, 'Petugas Jaga Malam Bank Sampah', 'Petugas yang bertanggung jawab menjaga keamanan dan mengawasi kegiatan dibank sampah pada malam hari'),
(135, 'Petugas TPA', 'Petugas yang bertanggung jawab menjaga kebersihan di lingkungan TPA'),
(136, 'Petugas Jaga Malam TPA', 'Petugas yang bertanggung jawab menjaga keamanan dan mengawasi kegiatan di TPA  pada malam hari'),
(137, 'Petugas Penyapu Jalan', 'Petugas yang bertanggung jawab membersihkan jalan dari sampah, debu dan kotoran lainnya dengan sapu agar bersih dan aman bagi pengguna jalan'),
(138, 'Petugas Kebersihan Depo/TPS', '-'),
(139, 'Petugas Angkutan Sampah', '-'),
(140, 'Petugas Kebersihan TPA', '-'),
(141, 'Tenaga Pengelola Bank Sampah Induk', '-'),
(142, 'Petugas Jogokali', '-'),
(143, 'Tenaga Analis Laboratorium', '-'),
(144, 'Petugas Taman', '-'),
(145, 'Petugas Pengelola IPAL', '-'),
(146, 'Petugas Truk Sedot Limbah', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_no_sk`
--

CREATE TABLE `tb_no_sk` (
  `id_no_sk` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `kode_sk` text NOT NULL,
  `nomor_utama` varchar(50) NOT NULL,
  `awalan_nomor` int(11) NOT NULL,
  `tanggal_penetapan` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_no_sk`
--

INSERT INTO `tb_no_sk` (`id_no_sk`, `tahun`, `kode_sk`, `nomor_utama`, `awalan_nomor`, `tanggal_penetapan`, `created_at`, `updated_at`) VALUES
(7, 2026, '000.3', '0237', 62, '2025-12-31', '2026-01-19 01:09:07', '2026-01-19 08:15:02'),
(8, 2026, '000.3', '0238', 1, '2026-07-12', '2026-07-12 10:00:00', '2026-07-12 10:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_perpanjangan_kontrak`
--

CREATE TABLE `tb_perpanjangan_kontrak` (
  `id` int(11) NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `surat_permohonan` text NOT NULL,
  `surat_kinerja` text NOT NULL,
  `kir_dokter` text NOT NULL,
  `skck` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_riwayat_pekerjaan`
--

CREATE TABLE `tb_riwayat_pekerjaan` (
  `id` int(11) NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `id_nama_pekerjaan` int(11) NOT NULL,
  `jenis_pegawai` varchar(111) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `tahun` char(4) NOT NULL,
  `tmt_kerja` date NOT NULL,
  `tst_kerja` date NOT NULL,
  `status` enum('Terverifikasi','Menunggu','Tidak Aktif','Pensiun') NOT NULL,
  `gaji` text NOT NULL,
  `uraian_pekerjaan` text NOT NULL,
  `sk_spt` text NOT NULL,
  `sk_pks` text NOT NULL,
  `penginput` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_riwayat_pekerjaan`
--

INSERT INTO `tb_riwayat_pekerjaan` (`id`, `id_pekerja`, `id_nama_pekerjaan`, `jenis_pegawai`, `id_unit_kerja`, `tahun`, `tmt_kerja`, `tst_kerja`, `status`, `gaji`, `uraian_pekerjaan`, `sk_spt`, `sk_pks`, `penginput`, `created_at`, `updated_at`, `deleted_at`) VALUES
(404, 'PG260109252897', 114, 'Kontrak Dinas', 1, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '2050000', 'Melaksanakan urusan kearsipan dan dokumentasi;\r\nMelaksanakan pemeliharaan arsip dan dokumen;\r\nMelaksanakan pengelolaan ruang rapat, perpustakaan dan ruang audio visual;\r\nMelaksanakan pemeliharaan jaringan dan koneksi Internet, dan publikasi dinas;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau Sekretaris dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan/pimpinan;', '', '', 'Kuspriyono', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(405, 'PG260109252898', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '2007000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintah atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(406, 'PG260109252899', 128, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(407, 'PG260109252900', 130, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(409, 'PG260109252902', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintah atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(410, 'PG260109252903', 134, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-01-19', 'Tidak Aktif', '0', '-', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-20 10:47:49', '0000-00-00 00:00:00'),
(411, 'PG260109252904', 132, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1700000', 'Melaksanakan administrasi Bank Sampah Induk ;\r\nMelakukan pelayanan Bank Sampah Induk ;\r\nMelaksanakan kebersihan kantor Bank Sampah Induk dan lingkungannya ;\r\nMenjaga Aset Bank Sampah Induk ;\r\nMenjaga peralatan kerja /barang inventaris Dinas Lingkungan Hidup yang dalam penugasanya sesuai bidang ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(412, 'PG260109252905', 138, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Membersihkan area tempat pembuangan sampah sementara (depo);\r\nMelakukan pemilahan sampah ;\r\nMelakukan pemeliharaan, perawatan dan perbaikan peralatan kebersihan dan   pengangkutan sampah;\r\nMembantu pemindahan sampah dari kendaraan sampah ke Armada Pengangkut sampah ;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintahkan atasan; ', '', '', 'Kurniyawati', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(413, 'PG260109252906', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang ;\r\nMelaksanakan tugas lain yang diperintah atasan;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(414, 'PG260109252907', 140, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu lingkungan TPA  yang sudah menjadi tanggung jawab penugasan;\r\nMelaksanakan pilah sampah di TPA;\r\nMembersihkan rumput yang tumbuh di lingkungan bangunan TPA;\r\nMelaksanakan kebersihan bangunan/gedung di TPA ;\r\nMembersihkan saluran bangunan/gedung TPA degayu;\r\nMemelihara peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintahkan atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(415, 'PG260109252908', 140, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu lingkungan TPA  yang sudah menjadi tanggung jawab penugasan;\r\nMelaksanakan pilah sampah di TPA;\r\nMembersihkan rumput yang tumbuh di lingkungan bangunan TPA;\r\nMelaksanakan kebersihan bangunan/gedung di TPA;\r\nMembersihkan saluran bangunan/gedung TPA degayu;\r\nMemelihara peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintahkan atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(416, 'PG260109252909', 140, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu lingkungan TPA  yang sudah menjadi tanggung jawab penugasan ;\r\nMelaksanakan pilah sampah di TPA;\r\nMembersihkan rumput yang tumbuh di lingkungan bangunan TPA;\r\nMelaksanakan kebersihan bangunan/gedung di TPA;\r\nMembersihkan saluran bangunan/gedung TPA degayu;\r\nMemelihara peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintahkan atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(417, 'PG260109252910', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\n Membersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(418, 'PG260109252911', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(419, 'PG260109252912', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(420, 'PG260109252913', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan  ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(421, 'PG260109252914', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Membersihkan area tempat pembuangan sampah sementara (depo);\r\nMelakukan pemilahan sampah ;\r\nMelakukan pemeliharaan, perawatan dan perbaikan peralatan kebersihan dan pengangkutan sampah ;\r\nMembantu pemindahan sampah dari kendaraan sampah ke Armada Pengangkut sampah ;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Kurniyawati', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(422, 'PG260109252915', 140, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'menyapu lingkungan TPA  yang sudah menjadi tanggung jawab penugasan ;\r\nmelaksanakan pilah sampah di TPA ;\r\nmembersihkan rumput yang tumbuh di lingkungan bangunan TPA ;\r\nmelaksanakan kebersihan bangunan/gedung di TPA ;\r\nmembersihkan saluran bangunan/gedung TPA degayu ;\r\nmemelihara peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nmelaksanakan tugas lain yang diperintahkan atasan  ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(423, 'PG260109252916', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(424, 'PG260109252917', 140, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Melaksanakan piket penjagaan sesuai jadwal piket yang telah di tentukan ;\r\nMelaksanakan patroli keamanan lingkungan TPA Degayu sesuai prosedur;\r\nMengawasi keberadaan sarana dan prasarana yang ada di TPA Degayu;\r\nMengidentifikasi keluar masuk tamu,pegawai,kendaraan dan barang dilingkungan TPA Degayu ;\r\nMengatur lalu lintas kendaraan dan barang di TPA Degayu ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(425, 'PG260109252918', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMenyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(426, 'PG260109252919', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\n Membersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(427, 'PG260109252920', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\n Melakukan pilah sampah di armada ;\r\n Membersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan  ;\r\nMembersihkan armada setelah digunakan  ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(428, 'PG260109252921', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\n Membersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(429, 'PG260109252922', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas  ;\r\nMelaksanakan tugas lain yang diperintah atasan;', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(430, 'PG260109252923', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(431, 'PG260109252924', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(432, 'PG260109252925', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(433, 'PG260109252926', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(434, 'PG260109252927', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(435, 'PG260109252928', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(436, 'PG260109252929', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\n Memelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas  ;\r\nMelaksanakan tugas lain yang diperintah atasan  ;\r\n', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(437, 'PG260109252930', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\n menjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(438, 'PG260109252931', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan;', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(439, 'PG260109252932', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(440, 'PG260109252933', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan;', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(441, 'PG260109252934', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nngemudi Armada;\r\n Memasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(442, 'PG260109252935', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\n Membersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan  ;\r\nmenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(443, 'PG260109252936', 137, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menyapu badan jalan,bahu jalan dan trotoar pada  ruas jalan yang menjadi tanggung jawab penugasan ;\r\nMembersihkan rumput yang tumbuh dibahu jalan dan trotoar ;\r\nMembersihkan / menyapu sisa-sisa sampah yang berserakan di sekitar tempat sampah yang berada di trotoar jalan ;\r\nMemelihara peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penugasannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintah atasan ;', '', '', 'Kurniyawati', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(444, 'PG260109252937', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(445, 'PG260109252938', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(446, 'PG260109252939', 139, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', ' Menjadi anggota kru armada pengangkut sampah dibawah koordinator Pengemudi Armada ;\r\nMemasukkan sampah dari tempat sampah atau tempat penampungan sampah (TPS) ke armada sesuai dengan rute layanan ;\r\nMelakukan pilah sampah di armada ;\r\nMembersihkan sisa sampah dititik-titik lokasi pengambilan sampah yang menjadi rute layanan ;\r\nMembersihkan armada setelah digunakan ;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;\r\n', '', '', 'Fajar Aji Kusuma', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(448, 'PG260109252941', 133, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1300000', 'Petugas mengumpulkan sampah dengan prosedur yang benar ;\r\nPetugas memilah sampah yang masuk ke Bank Samph Induk ;\r\nPetugas melakukan penimbangan sampah ;\r\nPetugas mengisi buku tabungan dan memberikan kepada penyetor sampah di Bank Sampah Induk ;\r\nPetugas melakukan jual kepada pihak ke tiga (pengepul/Rongsok);\r\nMenjaga peralatan kerja / barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan ;', '', '', 'Admin', '2026-01-09 03:42:22', '2026-01-23 01:32:13', '0000-00-00 00:00:00'),
(449, 'PG260109252942', 133, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(450, 'PG260109252943', 115, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(451, 'PG260109252944', 143, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '2050000', 'Sebagai tenaga analis laboratorium lingkungan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMengadministrasi pelaksanaan rencana kegiatan pengelolaan laboratorium lingkungan sesuai dengan lingkup tugasnya;\r\nMenghimpun bahan penyusunan Dokumen Sistem Mutu Laboratorium, Standar Operasional Prosedur dan Standar Pelayanan laboratorium lingkungan DLH Kota Pekalongan;\r\nMenghimpun dan menyusun bahan perencanaan dan pemeliharaan perlengkapan dan peralatan laboratorium lingkungan;\r\nMenghimpun bahan penyusunan rencana dan pelaksanaan peningkatan mutu serta pengembangan pelayanan laboratorium lingkungan;\r\nMelaksanakan tugas pengambilan contoh uji dan pengujian sesuai dengan parameter yang menjadi tanggung jawabnya; \r\nMelaksanakan kegiatan stock opname kebutuhan bahan, reagen, perlengkapan pemeriksaaan/analisis dan peralatan laboratorium lingkungan;\r\nMelaksanakan pengkajian ulang sistem manajemen mutu laboratorium dan Audit Internal;\r\nMelaksanakan pemeliharaan peralatan dan perlengkapan laboratorium lingkungan;\r\nMelaksanakan pengelolaan limbah cair dan TPS limbah B3 laboratorium lingkungan;\r\nMenjaga kebersihan laboratorium lingkungan;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(452, 'PG260109252945', 143, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-07-06', 'Tidak Aktif', '2050000', 'Sebagai tenaga analis laboratorium lingkungan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMengadministrasi pelaksanaan rencana kegiatan pengelolaan laboratorium lingkungan sesuai dengan lingkup tugasnya;\r\nMenghimpun bahan penyusunan Dokumen Sistem Mutu Laboratorium, Standar Operasional Prosedur dan Standar Pelayanan laboratorium lingkungan DLH Kota Pekalongan;\r\nMenghimpun dan menyusun bahan perencanaan dan pemeliharaan perlengkapan dan peralatan laboratorium lingkungan;\r\nMenghimpun bahan penyusunan rencana dan pelaksanaan peningkatan mutu serta pengembangan pelayanan laboratorium lingkungan;\r\nMelaksanakan tugas pengambilan contoh uji dan pengujian sesuai dengan parameter yang menjadi tanggung jawabnya; \r\nMelaksanakan kegiatan stock opname kebutuhan bahan, reagen, perlengkapan pemeriksaaan/analisis dan peralatan laboratorium lingkungan;\r\nMelaksanakan pengkajian ulang sistem manajemen mutu laboratorium dan Audit Internal;\r\nMelaksanakan pemeliharaan peralatan dan perlengkapan laboratorium lingkungan;\r\nMelaksanakan pengelolaan limbah cair dan TPS limbah B3 laboratorium lingkungan;\r\nMenjaga kebersihan laboratorium lingkungan;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-06-20 02:20:28', '0000-00-00 00:00:00'),
(453, 'PG260109252946', 144, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Admin', '2026-01-09 03:42:22', '2026-01-23 00:53:02', '0000-00-00 00:00:00'),
(454, 'PG260109252947', 144, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(455, 'PG260109252948', 144, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(456, 'PG260109252949', 144, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(457, 'PG260109252950', 144, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(458, 'PG260109252951', 115, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1400000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di kawasan Tahura secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di kawasan Tahura secara rutin;\r\nMengelola sampah organik dan memilah sampah anorganik;\r\nMelakukan kegiatan pembibitan tanaman keras (seperti bintaro, dll), mencatat stok bibit tanaman dan melaporkan jumlahnya tiap bulan;\r\nMelakukan kegiatan penanaman pohon di kawasan Tahura sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset/ sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(459, 'PG260109252952', 115, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1400000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di kawasan Tahura secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di kawasan Tahura secara rutin;\r\nMengelola sampah organik dan memilah sampah anorganik;\r\nMelakukan kegiatan pembibitan tanaman keras (seperti bintaro, dll), mencatat stok bibit tanaman dan melaporkan jumlahnya tiap bulan;\r\nMelakukan kegiatan penanaman pohon di kawasan Tahura sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset/ sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(460, 'PG260109252953', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(461, 'PG260109252954', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(462, 'PG260109252955', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(463, 'PG260109252956', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(464, 'PG260109252957', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(465, 'PG260109252958', 116, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Menyiapkan kendaraan dan peralatan kerja sebelum melaksanakan pekerjaan;\r\nMelaksanakan tugas perapihan dan/ atau penebangan pohon yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMelaksanakan tugas penanaman dan pemeliharaan tanaman/ pohon di sempadan jalan yang masuk dalam kewenangan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMembersihkan lokasi setelah melaksanakan perapihan dan/ atau penebangan pohon;\r\nMembersihkan dan merawat kendaraan serta peralatan kerja setelah melaksanakan pekerjaan;\r\nMelaporkan kegiatan perapihan dan/ atau penebangan pohon setiap hari (lokasi dan jumlah pohon yang dirapihkan dan/ atau ditebang);\r\nMelaksanakan tugas penebangan pohon tumbang dan perapihan pohon di tempat rawan, diluar hari / jam dinas sesuai intruksi pimpinan;\r\nMenjaga peralatan kerja/ barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(466, 'PG260109252959', 145, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Mengoperasikan Instalasi Pengolah Air Limbah dari awal sampai akhir pengolahan berjalan lancar;\r\nMembersihkan area IPAL dan merawat sarana prasarana IPAL setiap hari kerja;\r\nMencatat debit harian limbah cair yang dikeluarkan IPAL;\r\nMemastikan alat penghitung debit berjalan lancar dan melaporkan hasil pencatatan debit harian setiap bulan;\r\nMemastikan Instalasi Pengolah Air Limbah berjalan optimal dan melaporkan kerusakan atau hal yang mengganggu berjalannya operasional IPAL;\r\nMengetahui dan memahami fungsi kerja setiap unit pengolahan dan cara perawatannya;\r\nMelayani pengolahan limbah cair warga, mencatat dan melaporkan keatasan/ Dinas Lingkungan Hidup;\r\nMengamankan dan bertanggung jawab atas aset dan sarana prasarana yang ada di IPAL;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam tanggung jawabnya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau KEPALA BIDANG dalam pelaksanaan tugas.\r\n', '', '', 'Admin', '2026-01-09 03:42:22', '2026-01-21 08:37:43', '0000-00-00 00:00:00'),
(467, 'PG260109252960', 146, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Sebagai tenaga analis laboratorium lingkungan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMengadministrasi pelaksanaan rencana kegiatan pengelolaan laboratorium lingkungan sesuai dengan lingkup tugasnya;\r\nMenghimpun bahan penyusunan Dokumen Sistem Mutu Laboratorium, Standar Operasional Prosedur dan Standar Pelayanan laboratorium lingkungan DLH Kota Pekalongan;\r\nMenghimpun dan menyusun bahan perencanaan dan pemeliharaan perlengkapan dan peralatan laboratorium lingkungan;\r\nMenghimpun bahan penyusunan rencana dan pelaksanaan peningkatan mutu serta pengembangan pelayanan laboratorium lingkungan;\r\nMelaksanakan tugas pengambilan contoh uji dan pengujian sesuai dengan parameter yang menjadi tanggung jawabnya; \r\nMelaksanakan kegiatan stock opname kebutuhan bahan, reagen, perlengkapan pemeriksaaan/analisis dan peralatan laboratorium lingkungan;\r\nMelaksanakan pengkajian ulang sistem manajemen mutu laboratorium dan Audit Internal;\r\nMelaksanakan pemeliharaan peralatan dan perlengkapan laboratorium lingkungan;\r\nMelaksanakan pengelolaan limbah cair dan TPS limbah B3 laboratorium lingkungan;\r\nMenjaga kebersihan laboratorium lingkungan;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00');
INSERT INTO `tb_riwayat_pekerjaan` (`id`, `id_pekerja`, `id_nama_pekerjaan`, `jenis_pegawai`, `id_unit_kerja`, `tahun`, `tmt_kerja`, `tst_kerja`, `status`, `gaji`, `uraian_pekerjaan`, `sk_spt`, `sk_pks`, `penginput`, `created_at`, `updated_at`, `deleted_at`) VALUES
(468, 'PG260109252961', 142, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Membersihkan sampah di sungai baik yang berada di bantaran sungai atau di badan sungai;\r\nMelakukan pemilahan sampah anorganik laku jual, mencatat tiap minggunya dan melaporkan jumlah berat sampah terkurangi tiap bulanya;\r\nMencatat sampah terambil tiap hari dari sungai perkontainer/tond;\r\nMengambil sampah pada unit jaring jaring sampah yang telah terpasang;\r\nMerapikan pohon-pohon yang mengarah ke badan sungai.\r\nMelakukan patroli kebersihan, pembuangan air limbah di sepanjang aliran sungai;\r\nMelakukan perawatan kapal dan memastikan kapal dapat beroprasional;\r\nMengamankan dan bertanggung jawab atas aset/ sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaanya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau atasan langsungnya dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(469, 'PG260109252962', 142, 'Kontrak Dinas', 5, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Membersihkan sampah di sungai baik yang berada di bantaran sungai atau di badan sungai;\r\nMelakukan pemilahan sampah anorganik laku jual, mencatat tiap minggunya dan melaporkan jumlah berat sampah terkurangi tiap bulanya;\r\nMencatat sampah terambil tiap hari dari sungai perkontainer/tond;\r\nMengambil sampah pada unit jaring jaring sampah yang telah terpasang;\r\nMerapikan pohon-pohon yang mengarah ke badan sungai.\r\nMelakukan patroli kebersihan, pembuangan air limbah di sepanjang aliran sungai;\r\nMelakukan perawatan kapal dan memastikan kapal dapat beroprasional;\r\nMengamankan dan bertanggung jawab atas aset/ sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaanya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau atasan langsungnya dalam pelaksanaan tugas.', '', '', 'Faza Mustafid', '2026-01-09 03:42:22', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(472, 'PG260109252901', 138, 'Kontrak Dinas', 3, '2026', '2026-01-01', '2026-12-31', 'Terverifikasi', '1900000', 'Membersihkan area tempat pembuangan sampah sementara (depo);\r\nMelakukan pemilahan sampah ;\r\nMelakukan pemeliharaan, perawatan dan perbaikan peralatan kebersihan dan   pengangkutan sampah;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas ;\r\nMelaksanakan tugas lain yang diperintahkan atasan; ', '', '', 'Kurniyawati', '2026-01-12 08:27:31', '2026-01-14 13:07:25', '0000-00-00 00:00:00'),
(473, 'PG260129995530', 144, 'Kontrak Dinas', 5, '2026', '2026-05-04', '2026-12-31', 'Terverifikasi', '1900000', 'Melakukan kegiatan pemeliharaan dan perawatan tanaman dan pohon di Taman secara rutin;\r\nMelakukan kegiatan pembersihan sampah dan rumput liar di Taman secara rutin;\r\nMelakukan kegiatan pembibitan tanaman;\r\nMelakukan kegiatan penanaman pohon di Taman sebagai upaya pelestarian ruang terbuka hijau;\r\nMengamankan dan bertanggung jawab atas aset atau sarana dan prasarana yang ada;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau WAKIL PIHAK KESATU dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan atau pimpinan.', '', '', 'Admin', '2026-01-29 03:30:47', '2026-05-19 02:37:15', '0000-00-00 00:00:00'),
(474, 'PG260709582949', 143, 'Kontrak Dinas', 5, '2026', '2026-07-09', '2026-12-31', 'Terverifikasi', '2050000', 'Sebagai tenaga analis laboratorium lingkungan Dinas Lingkungan Hidup Kota Pekalongan;\r\nMengadministrasi pelaksanaan rencana kegiatan pengelolaan laboratorium lingkungan sesuai dengan lingkup tugasnya;\r\nMenghimpun bahan penyusunan Dokumen Sistem Mutu Laboratorium, Standar Operasional Prosedur dan Standar Pelayanan laboratorium lingkungan DLH Kota Pekalongan;\r\nMenghimpun dan menyusun bahan perencanaan dan pemeliharaan perlengkapan dan peralatan laboratorium lingkungan;\r\nMenghimpun bahan penyusunan rencana dan pelaksanaan peningkatan mutu serta pengembangan pelayanan laboratorium lingkungan;\r\nMelaksanakan tugas pengambilan contoh uji dan pengujian sesuai dengan parameter yang menjadi tanggung jawabnya; \r\nMelaksanakan kegiatan stock opname kebutuhan bahan, reagen, perlengkapan pemeriksaaan/analisis dan peralatan laboratorium lingkungan;\r\nMelaksanakan pengkajian ulang sistem manajemen mutu laboratorium dan Audit Internal;\r\nMelaksanakan pemeliharaan peralatan dan perlengkapan laboratorium lingkungan;\r\nMelaksanakan pengelolaan limbah cair dan TPS limbah B3 laboratorium lingkungan;\r\nMenjaga kebersihan laboratorium lingkungan;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU dalam pelaksanaan tugas', '', '', 'Faza Mustafid', '2026-07-09 03:13:58', '2026-07-09 04:10:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sk`
--

CREATE TABLE `tb_sk` (
  `id_sk` int(11) NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `id_no_sk` int(11) NOT NULL,
  `nomor_sk` varchar(50) NOT NULL,
  `tanggal_penetapan` date NOT NULL DEFAULT '2025-12-31',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sk`
--

INSERT INTO `tb_sk` (`id_sk`, `id_pekerja`, `id_no_sk`, `nomor_sk`, `tanggal_penetapan`, `created_at`) VALUES
(721, 'PG260109252936', 7, '0237.2', '2025-12-31', '2026-01-19 08:15:02'),
(722, 'PG260109252958', 7, '0237.3', '2025-12-31', '2026-01-19 08:15:02'),
(723, 'PG260109252928', 7, '0237.4', '2025-12-31', '2026-01-19 08:15:02'),
(724, 'PG260109252931', 7, '0237.5', '2025-12-31', '2026-01-19 08:15:02'),
(725, 'PG260109252909', 7, '0237.6', '2025-12-31', '2026-01-19 08:15:02'),
(726, 'PG260109252923', 7, '0237.7', '2025-12-31', '2026-01-19 08:15:02'),
(727, 'PG260109252926', 7, '0237.8', '2025-12-31', '2026-01-19 08:15:02'),
(728, 'PG260109252914', 7, '0237.9', '2025-12-31', '2026-01-19 08:15:02'),
(729, 'PG260109252952', 7, '0237.10', '2025-12-31', '2026-01-19 08:15:02'),
(730, 'PG260109252902', 7, '0237.11', '2025-12-31', '2026-01-19 08:15:02'),
(731, 'PG260109252905', 7, '0237.12', '2025-12-31', '2026-01-19 08:15:02'),
(732, 'PG260109252951', 7, '0237.13', '2025-12-31', '2026-01-19 08:15:02'),
(733, 'PG260109252947', 7, '0237.14', '2025-12-31', '2026-01-19 08:15:02'),
(734, 'PG260109252949', 7, '0237.15', '2025-12-31', '2026-01-19 08:15:02'),
(735, 'PG260109252948', 7, '0237.16', '2025-12-31', '2026-01-19 08:15:02'),
(736, 'PG260109252897', 7, '0237.17', '2025-12-31', '2026-01-19 08:15:02'),
(737, 'PG260109252922', 7, '0237.18', '2025-12-31', '2026-01-19 08:15:02'),
(738, 'PG260109252904', 7, '0237.19', '2025-12-31', '2026-01-19 08:15:02'),
(739, 'PG260109252938', 7, '0237.20', '2025-12-31', '2026-01-19 08:15:02'),
(740, 'PG260109252929', 7, '0237.21', '2025-12-31', '2026-01-19 08:15:02'),
(741, 'PG260109252932', 7, '0237.22', '2025-12-31', '2026-01-19 08:15:02'),
(742, 'PG260109252908', 7, '0237.23', '2025-12-31', '2026-01-19 08:15:02'),
(743, 'PG260109252944', 7, '0237.24', '2025-12-31', '2026-01-19 08:15:02'),
(744, 'PG260109252906', 7, '0237.25', '2025-12-31', '2026-01-19 08:15:02'),
(745, 'PG260109252934', 7, '0237.26', '2025-12-31', '2026-01-19 08:15:02'),
(746, 'PG260109252954', 7, '0237.27', '2025-12-31', '2026-01-19 08:15:02'),
(747, 'PG260109252959', 7, '0237.28', '2025-12-31', '2026-01-19 08:15:02'),
(748, 'PG260109252955', 7, '0237.29', '2025-12-31', '2026-01-19 08:15:02'),
(749, 'PG260109252924', 7, '0237.30', '2025-12-31', '2026-01-19 08:15:02'),
(750, 'PG260109252915', 7, '0237.31', '2025-12-31', '2026-01-19 08:15:02'),
(751, 'PG260109252953', 7, '0237.32', '2025-12-31', '2026-01-19 08:15:02'),
(752, 'PG260109252957', 7, '0237.33', '2025-12-31', '2026-01-19 08:15:02'),
(753, 'PG260109252918', 7, '0237.34', '2025-12-31', '2026-01-19 08:15:02'),
(754, 'PG260109252960', 7, '0237.35', '2025-12-31', '2026-01-19 08:15:02'),
(755, 'PG260109252901', 7, '0237.36', '2025-12-31', '2026-01-19 08:15:02'),
(756, 'PG260109252907', 7, '0237.37', '2025-12-31', '2026-01-19 08:15:02'),
(757, 'PG260109252941', 7, '0237.38', '2025-12-31', '2026-01-19 08:15:02'),
(758, 'PG260109252910', 7, '0237.39', '2025-12-31', '2026-01-19 08:15:02'),
(759, 'PG260109252933', 7, '0237.40', '2025-12-31', '2026-01-19 08:15:02'),
(760, 'PG260109252956', 7, '0237.41', '2025-12-31', '2026-01-19 08:15:02'),
(761, 'PG260109252962', 7, '0237.42', '2025-12-31', '2026-01-19 08:15:02'),
(762, 'PG260109252913', 7, '0237.43', '2025-12-31', '2026-01-19 08:15:02'),
(763, 'PG260109252921', 7, '0237.44', '2025-12-31', '2026-01-19 08:15:02'),
(764, 'PG260109252939', 7, '0237.45', '2025-12-31', '2026-01-19 08:15:02'),
(765, 'PG260109252946', 7, '0237.46', '2025-12-31', '2026-01-19 08:15:02'),
(766, 'PG260109252919', 7, '0237.47', '2025-12-31', '2026-01-19 08:15:02'),
(767, 'PG260109252950', 7, '0237.48', '2025-12-31', '2026-01-19 08:15:02'),
(768, 'PG260109252925', 7, '0237.49', '2025-12-31', '2026-01-19 08:15:02'),
(769, 'PG260109252912', 7, '0237.50', '2025-12-31', '2026-01-19 08:15:02'),
(770, 'PG260109252911', 7, '0237.51', '2025-12-31', '2026-01-19 08:15:02'),
(771, 'PG260109252937', 7, '0237.52', '2025-12-31', '2026-01-19 08:15:02'),
(772, 'PG260109252961', 7, '0237.53', '2025-12-31', '2026-01-19 08:15:02'),
(773, 'PG260109252927', 7, '0237.54', '2025-12-31', '2026-01-19 08:15:02'),
(774, 'PG260109252930', 7, '0237.55', '2025-12-31', '2026-01-19 08:15:02'),
(775, 'PG260109252898', 7, '0237.56', '2025-12-31', '2026-01-19 08:15:02'),
(776, 'PG260109252945', 7, '0237.57', '2025-12-31', '2026-01-19 08:15:02'),
(777, 'PG260109252917', 7, '0237.58', '2025-12-31', '2026-01-19 08:15:02'),
(778, 'PG260109252920', 7, '0237.59', '2025-12-31', '2026-01-19 08:15:02'),
(779, 'PG260109252916', 7, '0237.60', '2025-12-31', '2026-01-19 08:15:02'),
(780, 'PG260109252935', 7, '0237.61', '2025-12-31', '2026-01-19 08:15:02'),
(781, 'PG260129995530', 7, '0237.62', '2025-12-31', '2026-01-29 10:36:41'),
(782, 'PG260709582949', 8, '0238.1', '2026-07-12', '2026-07-12 10:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_unit_kerja`
--

CREATE TABLE `tb_unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL,
  `unit_kerja` text NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_unit_kerja`
--

INSERT INTO `tb_unit_kerja` (`id_unit_kerja`, `unit_kerja`, `detail`) VALUES
(1, 'Sekretariat', 'Sekretariat Dinas Lingkungan Hidup Kota Pekalongan'),
(2, 'Taling', 'Bidang Tata Lingkungan dan Penaatan Hukum Lingkungan Dinas Lingkungan Hidup Kota Pekalongan'),
(3, 'KPS', 'Bidang Kebersihan dan Pengelolaan Sampah Dinas Lingkungan Hidup Kota Pekalongan'),
(5, 'PPKL-RTH', 'Bidang Pengendalian Pencemaran dan Kerusakan Lingkungan dan Pengelolaan RTH Dinas Lingkungan Hidup Kota Pekalongan'),
(9, 'Dinas Lingkungan Hidup', 'Salah Satu OPD Kota Pekalongan Pada Bidang Lingkungan Hidup');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `nama_lengkap` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `alamat` text NOT NULL,
  `foto` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `status` enum('Aktif','Menunggu','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `id_unit_kerja`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `foto`, `username`, `password`, `level`, `status`) VALUES
(1, 9, 'Fajar Aji Kusuma', 'dlhkotapekalongan@gmail.com', '085733332431', 'Desa Tegalsari Timur RT 43 RW 08', '1751502830_e7c2e9dbb2c81d730f83.png', 'fajar', '$2y$10$bOuaBE/cyiKavIJKcJPsD.JYYesXsH5e93ccw3f7x6LxgExb4iqoS', 'admin', 'Aktif'),
(3, 1, 'Kuspriyono', 'kuspriyonosupri@gmail.com', '087823231212', 'Batang', '1749606066_5d15c6bb93f2f31b53dc.png', 'kuspriyono_dlh', '$2y$10$RtrjgtWeg0/0TPgNfpEogeK4pbADqMiS7Z4NPzqGpa/n3FJBud1LC', 'user', 'Aktif'),
(4, 9, 'Ayub Najeb', 'moh.ayub17@gmail.com', '085183113370', 'Pekalongan', '1749715130_65e516d1930339ac3833.jpg', 'ayub', '$2y$10$mfx1OyCD30j7r/wHuYiVouIQNI.bL7jAlKYbH2EghVChP8lDLIhh.', 'admin', 'Aktif'),
(5, 3, 'Yusuf Feriyanto', 'matahatikita86@gmail.com', '087867678989', 'Pekalongan', '1750670858_793ea210ace099117498.jpg', 'ucup', '$2y$10$FXc.iJDqV46BW2boP/ozT.TqKM/BxLbEoqe8DU8Twamd/WFISMdeS', 'user', 'Aktif'),
(6, 5, 'Faza Mustafid', 'faza@gmail.com', '089898989898', 'Pekalongan', '1752739051_521f44c7ae03b588f22b.webp', 'faza', '$2y$10$nNuX3RgoaEFxd/x9p4mTx.NYm2.XQQAmxX1StEpoz5ud4lEN9mVDO', 'user', 'Aktif'),
(7, 3, 'Kurniyawati', 'kurniyawati795@gmail.com', '085211086273', 'Jl.Pantai Sari Rt.01/Rw.10 Kel.Panjang Baru  ', '1753152577_1e05c707a82f68a2112e.jpg', 'nia', '$2y$10$wEF/2TUre0SeTdsFMhnFTexHxQNKbRMql80cziKy3XczS23Jh7d8q', 'user', 'Aktif'),
(8, 9, 'Admin', 'admin@gmail.com', '0000000000000', 'Tegalsari Timur', '1767931271_5f59141251e4dd631552.png', 'admin', '$2y$10$A1fLSCkAyCYh2RZknXaHdueU3DE5bMUuGm/E9Xs35QTBVNHQqfih.', 'admin', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_dasar_hukum`
--
ALTER TABLE `tb_dasar_hukum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_data_pekerja`
--
ALTER TABLE `tb_data_pekerja`
  ADD PRIMARY KEY (`id_pekerja`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indeks untuk tabel `tb_kepala`
--
ALTER TABLE `tb_kepala`
  ADD PRIMARY KEY (`id_kepala`),
  ADD KEY `id_unit_kerja` (`id_unit_kerja`);

--
-- Indeks untuk tabel `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  ADD PRIMARY KEY (`id_nama_pekerjaan`);

--
-- Indeks untuk tabel `tb_no_sk`
--
ALTER TABLE `tb_no_sk`
  ADD PRIMARY KEY (`id_no_sk`),
  ADD UNIQUE KEY `uk_tahun` (`tahun`);

--
-- Indeks untuk tabel `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pekerja` (`id_pekerja`);

--
-- Indeks untuk tabel `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nama_pekerjaan` (`id_nama_pekerjaan`) USING BTREE,
  ADD KEY `id_unit_kerja` (`id_unit_kerja`) USING BTREE,
  ADD KEY `id_pekerja` (`id_pekerja`) USING BTREE;

--
-- Indeks untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  ADD PRIMARY KEY (`id_sk`),
  ADD UNIQUE KEY `id_pekerja` (`id_pekerja`),
  ADD KEY `id_no_sk` (`id_no_sk`);

--
-- Indeks untuk tabel `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  ADD PRIMARY KEY (`id_unit_kerja`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_unit_kerja` (`id_unit_kerja`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_dasar_hukum`
--
ALTER TABLE `tb_dasar_hukum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kepala`
--
ALTER TABLE `tb_kepala`
  MODIFY `id_kepala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  MODIFY `id_nama_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT untuk tabel `tb_no_sk`
--
ALTER TABLE `tb_no_sk`
  MODIFY `id_no_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=475;

--
-- AUTO_INCREMENT untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=782;

--
-- AUTO_INCREMENT untuk tabel `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_kepala`
--
ALTER TABLE `tb_kepala`
  ADD CONSTRAINT `tb_kepala_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`);

--
-- Ketidakleluasaan untuk tabel `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  ADD CONSTRAINT `tb_perpanjangan_kontrak_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`);

--
-- Ketidakleluasaan untuk tabel `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`),
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_2` FOREIGN KEY (`id_nama_pekerjaan`) REFERENCES `tb_nama_pekerjaan` (`id_nama_pekerjaan`),
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_3` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`);

--
-- Ketidakleluasaan untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  ADD CONSTRAINT `tb_sk_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_sk_ibfk_2` FOREIGN KEY (`id_no_sk`) REFERENCES `tb_no_sk` (`id_no_sk`);

--
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
