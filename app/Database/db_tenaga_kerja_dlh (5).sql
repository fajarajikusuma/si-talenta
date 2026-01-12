-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2025 at 07:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
-- Table structure for table `tb_dasar_hukum`
--

CREATE TABLE `tb_dasar_hukum` (
  `id` int NOT NULL,
  `nama_dasar_hukum` text NOT NULL,
  `nomor` text NOT NULL,
  `tahun` text NOT NULL,
  `tentang` text NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_data_pekerja`
--

CREATE TABLE `tb_data_pekerja` (
  `id_pekerja` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(133) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rt/rw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `desa/kelurahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `kecamatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `kota_tinggal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `provinsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `kode_pos` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ktp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pendidikan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gelar_depan` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gelar_belakang` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ijasah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status_pekerja` enum('Terverifikasi','Menunggu','Tidak Aktif','Pensiun') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_data_pekerja`
--

INSERT INTO `tb_data_pekerja` (`id_pekerja`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `rt/rw`, `desa/kelurahan`, `kecamatan`, `kota_tinggal`, `provinsi`, `kode_pos`, `ktp`, `pendidikan`, `jurusan`, `gelar_depan`, `gelar_belakang`, `ijasah`, `status_pekerja`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PG250518171715', '3327111704020001', 'FAJAR AJI KUSUMA', 'Pemalang', '2002-04-17', 'L', 'Sawahrejo Utara', '43/08', 'Tegalsari Timur', 'Ampelgading', 'Pemalang', 'Jawa Tengah', '52364', 'KTPPG2505181717151747797608_48043a11b956e3331749.jpg', 'S1', 'Teknik Informatika', '-', 'S.Kom.', 'IJAZAHPG2505181717151747797426_d6c19bb0dcf6368e5244.pdf', 'Terverifikasi', '', '2025-05-18 14:38:45', '2025-06-11 06:50:41', '0000-00-00 00:00:00'),
('PG250518237001', '3375044307670003', 'SARJO', 'Pemalang', '2002-02-18', 'L', 'Pemalang', '21/02', 'Pekalongan', 'Pekalongan Utara', 'Pemalang', 'Jawa Tengah', '41231', 'KTPPG250518237001.jpg', 'S1', 'Hukum', '-', 'S.H.', 'IJAZAHPG250518237001.pdf', 'Tidak Aktif', 'Mundur', '2025-05-18 04:32:04', '2025-05-21 14:13:47', '0000-00-00 00:00:00'),
('PG250518940823', '3375033101780010', 'ERWIN BIYANTORO', 'Pekalongan', '1965-07-07', 'L', 'Jl. Progo', '21/11', 'Kandeman', 'Batang Kulon', 'Batang', 'Jawa Tengah', '52364', 'KTPPG250518940823.jpg', 'SMK', 'Teknik Kendaraan Ringan', '-', '-', 'IJAZAHPG250518940823.pdf', 'Pensiun', '', '2025-05-18 14:44:41', '2025-05-19 01:28:58', '0000-00-00 00:00:00'),
('PG250519278166', '3325022406940004', 'KISWANTO', 'Batang', '1970-07-15', 'L', 'Jl. Kusuma Bangsa', '21/11', 'Pekalongan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '41231', 'KTPPG250519278166.jpeg', 'SMA', 'IPA', '-', '-', 'IJAZAHPG250519278166.pdf', 'Terverifikasi', '', '2025-05-19 05:12:30', '2025-06-23 08:45:31', '0000-00-00 00:00:00'),
('PG250521179441', '3375010603910003', 'BAGUS JIWAN NIZAL SAPUTRA', 'Pekalongan', '1991-03-06', 'L', 'Tirto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Manajemen', '-', 'S.M.', NULL, 'Terverifikasi', '', '2025-05-21 01:34:28', '2025-06-12 00:29:14', '0000-00-00 00:00:00'),
('PG250521769296', '3375015405840006', 'MEILIYA ISMIYATI', 'Pekalongan', '1984-05-14', 'P', 'Kedungwuni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Akuntansi', '-', 'S.Ak.', NULL, 'Terverifikasi', '', '2025-05-21 01:20:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250521769297', '1803105111870003', 'MUROHATI', 'Kotabumi', '1987-11-11', 'P', 'Jenggot', '03/05', 'Jenggot', 'Pekalongan Selatan', 'Pekalongan', 'Jawa tengah', '51156', 'KTPPG2505217692971750664393_ddf5c86b9f87b9852da1.png', 'S1', 'Pendidikan Islam', '-', 'S.Pd.i.', 'IJAZAHPG2505217692971750664393_01d304330da66dceb487.png', 'Terverifikasi', '', '2025-05-21 01:20:45', '2025-06-23 07:39:53', '0000-00-00 00:00:00'),
('PG250521893788', '3375033101780012', 'DEDY JUNAIDY', 'Batang', '2025-01-07', 'L', 'Batanf', '21/02', 'Kandeman', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '41231', 'KTPPG2505218937881747817546_abdc57e92fa4671c35a4.jpeg', 'SMK', 'Teknik Kendaraan Ringan', '-', '-', 'IJAZAHPG2505218937881747817546_ebd92cb63b3f55263d75.pdf', 'Menunggu', '', '2025-05-21 08:52:26', '2025-05-27 01:56:52', '0000-00-00 00:00:00'),
('PG250521918404', '3375033101780019', 'FATMAWATI', 'Pekalongan', '2025-05-21', 'P', 'sada', '09/33', 'Pekalongan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '41231', 'KTPPG2505219184041747818630_eb3c97958d978dd624bf.jpeg', 'SMA', 'IPA', '-', '-', 'IJAZAHPG2505219184041747818630_ca5f54c72300b14f9e7d.pdf', 'Menunggu', '', '2025-05-21 09:10:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kepala`
--

CREATE TABLE `tb_kepala` (
  `id_kepala` int NOT NULL,
  `id_unit_kerja` int NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_kepala` text NOT NULL,
  `jabatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan_short` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kepala`
--

INSERT INTO `tb_kepala` (`id_kepala`, `id_unit_kerja`, `nip`, `nama_kepala`, `jabatan`, `jabatan_short`, `keterangan`, `status`) VALUES
(8, 9, '197012141990031004', 'Dr. SRI BUDI SANTOSO, M.Si.', 'Kepala Dinas Lingkungan Hidup', 'Kepala', 'Kadin Pada DLH Kota Pekalongan', 'Aktif'),
(9, 1, '197606072000122004', 'DWI YUNIASTUTI, S.KM., M.M.', 'Sekretaris Dinas Lingkungan Hidup', 'Sekretaris', 'Sekdin Pada DLH Kota Pekalongan', 'Aktif'),
(10, 3, '196808161990031009', 'ADI SETIAWAN, S.E.', 'Kepala Bidang Kebesihan dan Pengelolaan Sampah', 'Kepala Bidang', 'Kabid Pada Bidang Kebesihan dan Pengelolaan Sampah', 'Aktif'),
(11, 5, '197806032005011012', 'ADI USNAN, S.E.', 'Kepala Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Kepala Bidang', 'Kabid Pada Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Aktif'),
(12, 2, '197808282011012002', 'SOFIANA, S.T.', 'Plt. Kepala Bidang Tata Lingkungan dan Penaatan Hukum Lingkungan', 'Plt. Kepala Bidang', 'Pelaksana Tugas Kabid Taling Pada Bidang Taling', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nama_pekerjaan`
--

CREATE TABLE `tb_nama_pekerjaan` (
  `id_nama_pekerjaan` int NOT NULL,
  `pekerjaan` text NOT NULL,
  `uraian_kerja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_nama_pekerjaan`
--

INSERT INTO `tb_nama_pekerjaan` (`id_nama_pekerjaan`, `pekerjaan`, `uraian_kerja`) VALUES
(2, 'Tenaga Administrasi', 'Bertanggung jawab mengelola dokumen, melakukan pencatatan, pengarsipan, entri data, serta mendukung kelancaran operasional administratif sesuai prosedur yang berlaku di lingkungan kerja'),
(9, 'Petugas Angkutan Sampah', 'Petugas Angkutan Sampah adalah tenaga yang bertugas mengumpulkan, mengangkut, dan membuang sampah dari lokasi-lokasi penampungan ke tempat pembuangan akhir guna menjaga kebersihan lingkungan sesuai standar operasional.'),
(96, 'Marketing', 'Merancang strategi pemasaran dan promosi produk'),
(97, 'Programmer', 'Membuat dan mengembangkan aplikasi perangkat lunak'),
(98, 'Desainer Grafis', 'Membuat desain visual untuk media cetak dan digital'),
(99, 'Customer Service', 'Melayani keluhan dan permintaan pelanggan'),
(100, 'Akuntan', 'Mengelola pembukuan dan laporan keuangan'),
(101, 'HRD', 'Mengatur rekrutmen dan pengembangan karyawan'),
(103, 'Content Writer', 'Menulis artikel dan konten untuk website'),
(109, 'Teknisi IT', 'Memelihara dan memperbaiki perangkat keras komputer'),
(110, 'Supervisor', 'Mengawasi dan mengkoordinasi tim kerja'),
(111, 'Administrator', 'Mengelola administrasi kantor dan dokumen'),
(112, 'Tukang Sapu', 'Menyapu Jalan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_perpanjangan_kontrak`
--

CREATE TABLE `tb_perpanjangan_kontrak` (
  `id` int NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `surat_permohonan` text NOT NULL,
  `surat_kinerja` text NOT NULL,
  `kir_dokter` text NOT NULL,
  `skck` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat_pekerjaan`
--

CREATE TABLE `tb_riwayat_pekerjaan` (
  `id` int NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `id_nama_pekerjaan` int NOT NULL,
  `jenis_pegawai` varchar(111) NOT NULL,
  `id_unit_kerja` int NOT NULL,
  `tahun` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tmt_kerja` date NOT NULL,
  `tst_kerja` date NOT NULL,
  `status` enum('Terverifikasi','Menunggu','Tidak Aktif','Pensiun') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gaji` text NOT NULL,
  `uraian_pekerjaan` text NOT NULL,
  `sk_spt` text NOT NULL,
  `sk_pks` text NOT NULL,
  `penginput` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_riwayat_pekerjaan`
--

INSERT INTO `tb_riwayat_pekerjaan` (`id`, `id_pekerja`, `id_nama_pekerjaan`, `jenis_pegawai`, `id_unit_kerja`, `tahun`, `tmt_kerja`, `tst_kerja`, `status`, `gaji`, `uraian_pekerjaan`, `sk_spt`, `sk_pks`, `penginput`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'PG250518237001', 2, 'Kontrak Dinas', 1, '2025', '2025-05-18', '2025-05-21', 'Terverifikasi', '', '', '', '', 'Admin', '2025-05-18 04:32:04', '2025-05-20 05:31:35', '0000-00-00 00:00:00'),
(10, 'PG250518940823', 9, 'Kontrak Dinas', 3, '2025', '2025-05-18', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Admin', '2025-05-18 14:44:41', '2025-05-19 01:28:58', '0000-00-00 00:00:00'),
(11, 'PG250519278166', 9, 'Kontrak Dinas', 3, '2025', '2025-05-19', '2025-12-31', 'Menunggu', '', '', '', '', 'Admin', '2025-05-19 05:12:30', '2025-05-27 01:54:25', '0000-00-00 00:00:00'),
(24, 'PG250521769296', 2, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-05-23', 'Tidak Aktif', '', '', '', '', 'Admin', '2025-05-21 01:20:45', '2025-05-24 23:06:50', '0000-00-00 00:00:00'),
(28, 'PG250521179441', 2, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-06-10', 'Terverifikasi', '', '', '', '', 'Admin', '2025-05-21 01:34:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'PG250521893788', 111, 'Kontrak Dinas', 1, '2025', '2025-05-21', '2025-12-31', 'Menunggu', '', '', '', '', 'Admin', '2025-05-21 08:52:26', '2025-05-27 01:56:52', '0000-00-00 00:00:00'),
(33, 'PG250521918404', 9, 'Kontrak Dinas', 3, '2025', '2025-05-21', '2025-12-31', 'Menunggu', '', '', '', '', 'Admin', '2025-05-21 09:10:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'PG250521769296', 100, 'Kontrak Dinas', 1, '2025', '2025-05-24', '2025-06-03', 'Terverifikasi', '', '', '', '', 'Admin', '2025-05-24 23:06:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'PG250521769296', 100, 'Kontrak Dinas', 1, '2025', '2025-06-04', '2025-12-31', 'Terverifikasi', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'PG250518171715', 2, 'Kontak Dinas', 1, '2023', '2023-01-01', '2023-12-31', 'Tidak Aktif', '', '', '', '', 'Fajar Aji Ku', '2025-06-16 08:56:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'PG250518171715', 2, 'Kontak Dinas', 1, '2022', '2022-01-01', '2022-12-31', 'Tidak Aktif', '', '', '', '', 'Fajar Aji Ku', '2025-06-16 08:56:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'PG250518171715', 101, 'Kontak Dinas', 1, '2021', '2021-01-01', '2021-12-31', 'Tidak Aktif', '23', 'A', '1750302304_175ea22b49e76fe5a084.pdf', '1750302778_5ef5349689717520370a.pdf', 'Fajar Aji Ku', '2025-06-18 00:57:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 'PG250518171715', 2, 'Kontrak Dinas', 1, '2024', '2024-01-01', '2024-12-31', 'Tidak Aktif', '', '', '', '', 'Fajar Aji Ku', '2025-06-19 03:20:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 'PG250518171715', 2, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-06-18', 'Tidak Aktif', '', '', '', '', 'Kuspriyono', '2025-06-19 04:09:27', '2025-06-19 04:45:33', '0000-00-00 00:00:00'),
(172, 'PG250518171715', 97, 'Kontrak Dinas', 1, '2025', '2025-06-19', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-06-19 04:45:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 'PG250521769297', 2, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '2050000', 'Menghimpun dan menyusun bahan perencanaan program dan anggaran;\r\nMenginput program dan anggaran kedalam sistem;\r\nMelaksanakan urusan kearsipan dan dokumantasi;\r\nMelaksanakan pengelolaan dan penatausahaan sarana prasarana /BMD;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau SEKRETARIS dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan/Pimpinan.', '', '', 'Ayub Najeb', '2025-06-23 07:18:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit_kerja`
--

CREATE TABLE `tb_unit_kerja` (
  `id_unit_kerja` int NOT NULL,
  `unit_kerja` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_unit_kerja`
--

INSERT INTO `tb_unit_kerja` (`id_unit_kerja`, `unit_kerja`, `keterangan`) VALUES
(1, 'Sekretariat', 'Unit Organisasi Sekretariat Dinas Lingkungan Hidup Kota Pekalongan'),
(2, 'Taling', 'Unit Organisasi Tata Lingkungan dan Penaatan Hukum Lingkungan Dinas Lingkungan Hidup Kota Pekalongan'),
(3, 'KPS', 'Unit Organisasi Kebersihan dan Pengelolaan Sampah Dinas Lingkungan Hidup Kota Pekalongan'),
(5, 'PPKL', 'Unit Organisasi Pengendalian Pencemaran dan Kerusakan Lingkungan Dinas Lingkungan Hidup Kota Pekalongan'),
(9, 'Dinas Lingkungan Hidup', 'Salah Satu OPD Kota Pekalongan Pada Bidang Lingkungan Hidup');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int NOT NULL,
  `id_unit_kerja` int NOT NULL,
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
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `id_unit_kerja`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `foto`, `username`, `password`, `level`, `status`) VALUES
(1, 9, 'Fajar Aji Kusuma', 'dlhkotapekalongan@gmail.com', '085733332431', 'Desa Tegalsari Timur RT 43 RW 08', '1749535299_3d5ef6a17d37497ec117.webp', 'fajar_aji', '$2y$10$C3rmF3V1H0A6LHeprtR7ZerelqzswM4n2Nasr/uSNcdiHs06YPS5S', 'admin', 'Aktif'),
(3, 1, 'Kuspriyono', 'kuspriyonosupri@gmail.com', '087823231212', 'Batang', '1749606066_5d15c6bb93f2f31b53dc.png', 'kuspriyono_dlh', '$2y$10$RtrjgtWeg0/0TPgNfpEogeK4pbADqMiS7Z4NPzqGpa/n3FJBud1LC', 'user', 'Aktif'),
(4, 9, 'Ayub Najeb', 'moh.ayub17@gmail.com', '085183113370', 'Pekalongan', '1749715130_65e516d1930339ac3833.jpg', 'ayub', '$2y$10$mfx1OyCD30j7r/wHuYiVouIQNI.bL7jAlKYbH2EghVChP8lDLIhh.', 'admin', 'Aktif'),
(5, 3, 'Yusuf Feriyanto', 'matahatikita86@gmail.com', '087867678989', 'Pekalongan', '1750670858_793ea210ace099117498.jpg', 'ucup', '$2y$10$/ivS/E/IJVkaWlNSFHxsVeVLecH.PpYI5PAtlJEcOZbL45CIa3tue', 'user', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dasar_hukum`
--
ALTER TABLE `tb_dasar_hukum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_data_pekerja`
--
ALTER TABLE `tb_data_pekerja`
  ADD PRIMARY KEY (`id_pekerja`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `tb_kepala`
--
ALTER TABLE `tb_kepala`
  ADD PRIMARY KEY (`id_kepala`),
  ADD KEY `id_unit_kerja` (`id_unit_kerja`);

--
-- Indexes for table `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  ADD PRIMARY KEY (`id_nama_pekerjaan`);

--
-- Indexes for table `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pekerja` (`id_pekerja`);

--
-- Indexes for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nama_pekerjaan` (`id_nama_pekerjaan`) USING BTREE,
  ADD KEY `id_unit_kerja` (`id_unit_kerja`) USING BTREE,
  ADD KEY `id_pekerja` (`id_pekerja`) USING BTREE;

--
-- Indexes for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  ADD PRIMARY KEY (`id_unit_kerja`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_unit_kerja` (`id_unit_kerja`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dasar_hukum`
--
ALTER TABLE `tb_dasar_hukum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kepala`
--
ALTER TABLE `tb_kepala`
  MODIFY `id_kepala` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  MODIFY `id_nama_pekerjaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unit_kerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kepala`
--
ALTER TABLE `tb_kepala`
  ADD CONSTRAINT `tb_kepala_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  ADD CONSTRAINT `tb_perpanjangan_kontrak_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_2` FOREIGN KEY (`id_nama_pekerjaan`) REFERENCES `tb_nama_pekerjaan` (`id_nama_pekerjaan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_3` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
