-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 09:44 AM
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
-- Table structure for table `tb_data_pekerja`
--

CREATE TABLE `tb_data_pekerja` (
  `id_pekerja` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tempat_lahir` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` varchar(133) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rt/rw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `desa/kelurahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kecamatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kota_tinggal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `provinsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kode_pos` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ktp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pendidikan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jurusan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gelar_depan` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gelar_belakang` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ijasah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_data_pekerja`
--

INSERT INTO `tb_data_pekerja` (`id_pekerja`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `rt/rw`, `desa/kelurahan`, `kecamatan`, `kota_tinggal`, `provinsi`, `kode_pos`, `ktp`, `pendidikan`, `jurusan`, `gelar_depan`, `gelar_belakang`, `ijasah`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PG250518171715', '3327111704020001', 'FAJAR AJI KUSUMA', 'Pemalang', '2002-04-17', 'L', 'Sawahrejo Utara', '43/08', 'Tegalsari Timur', 'Ampelgading', 'Pemalang', 'Jawa Tengah', '52364', 'KTPPG250518171715.png', 'S1', 'Teknik Informatika', '-', 'S.Kom.', 'IJAZAHPG250518171715.pdf', '2025-05-18 14:38:45', '2025-05-20 05:23:52', '0000-00-00 00:00:00'),
('PG250518237001', '3375044307670003', 'SARJO', 'Pemalang', '2002-02-18', 'L', 'Pemalang', '21/02', 'Pekalongan', 'Pekalongan Utara', 'Pemalang', 'Jawa Tengah', '41231', 'KTPPG250518237001.jpg', 'S1', 'Hukum', '-', 'S.H.', 'IJAZAHPG250518237001.pdf', '2025-05-18 04:32:04', '2025-05-18 14:31:22', '0000-00-00 00:00:00'),
('PG250518531527', '1212121212121212', 'AWAN HARTA NOEGROHO', 'Batang', '2025-05-18', 'L', 'asdasdas', '21/02', 'Kandeman', 'Batang Kulon', 'Batang', 'Jawa Tengah', '41231', 'KTPPG250518531527.png', 'S1', 'Teknik Lingkungan', '-', 'S.T.', 'IJAZAHPG250518531527.pdf', '2025-05-18 04:30:14', '2025-05-18 11:08:22', '2025-05-18 11:28:59'),
('PG250518940823', '3375033101780010', 'ERWIN BIYANTORO', 'Pekalongan', '1965-07-07', 'L', 'Jl. Progo', '21/11', 'Kandeman', 'Batang Kulon', 'Batang', 'Jawa Tengah', '52364', 'KTPPG250518940823.jpg', 'SMK', 'Teknik Kendaraan Ringan', '-', '-', 'IJAZAHPG250518940823.pdf', '2025-05-18 14:44:41', '2025-05-19 01:28:58', '0000-00-00 00:00:00'),
('PG250519278166', '3325022406940004', 'KISWANTO', 'Batang', '1970-07-15', 'L', 'Jl. Kusuma Bangsa', '21/11', 'Pekalongan', 'Pekalongan Utara', 'Pekalongan', 'Jawa Tengah', '41231', 'KTPPG250519278166.jpeg', 'SMA', 'IPA', '-', '-', 'IJAZAHPG250519278166.pdf', '2025-05-19 05:12:30', '2025-05-20 02:10:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kepala`
--

CREATE TABLE `tb_kepala` (
  `id_kepala` int NOT NULL,
  `id_unit_kerja` int NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_kepala` text NOT NULL,
  `jabatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_kepala`
--

INSERT INTO `tb_kepala` (`id_kepala`, `id_unit_kerja`, `nip`, `nama_kepala`, `jabatan`, `keterangan`, `status`) VALUES
(8, 9, '197012141990031004', 'Dr. SRI BUDI SANTOSO, M.Si.', 'Kepala Dinas Lingkungan Hidup', 'Kadin Pada DLH Kota Pekalongan', 'Aktif'),
(9, 1, '197606072000122004', 'DWI YUNIASTUTI, S.KM., M.M.', 'Sekretaris Dinas Lingkungan Hidup', 'Sekdin Pada DLH Kota Pekalongan', 'Aktif'),
(10, 3, '196808161990031009', 'ADI SETIAWAN, S.E.', 'Kepala Bidang Kebesihan dan Pengelolaan Sampah', 'Kabid Pada Bidang Kebesihan dan Pengelolaan Sampah', 'Aktif'),
(11, 5, '197806032005011012', 'ADI USNAN, S.E.', 'Kepala Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Kabid Pada Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Aktif'),
(12, 2, '197808282011012002', 'SOFIANA, S.T.', 'Plt. Kepala Bidang Tata Lingkungan dan Penaatan Hukum Lingkungan', 'Pelaksana Tugas Kabid Taling Pada Bidang Taling', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nama_pekerjaan`
--

CREATE TABLE `tb_nama_pekerjaan` (
  `id_nama_pekerjaan` int NOT NULL,
  `pekerjaan` text NOT NULL,
  `uraian_kerja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `tb_riwayat_pekerjaan`
--

CREATE TABLE `tb_riwayat_pekerjaan` (
  `id` int NOT NULL,
  `id_pekerja` char(14) NOT NULL,
  `id_nama_pekerjaan` int NOT NULL,
  `jenis_pegawai` varchar(111) NOT NULL,
  `id_unit_kerja` int NOT NULL,
  `tahun` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tmt_kerja` date NOT NULL,
  `tst_kerja` date NOT NULL,
  `status` enum('Terverifikasi','Menunggu','Tidak Aktif','Pensiun') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `penginput` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_riwayat_pekerjaan`
--

INSERT INTO `tb_riwayat_pekerjaan` (`id`, `id_pekerja`, `id_nama_pekerjaan`, `jenis_pegawai`, `id_unit_kerja`, `tahun`, `tmt_kerja`, `tst_kerja`, `status`, `keterangan`, `penginput`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'PG250518531527', 2, 'Kontrak Dinas', 1, '2025', '2025-05-01', '2025-12-31', 'Terverifikasi', '', 'Admin', '2025-05-18 04:30:14', '2025-05-18 11:08:22', '2025-05-18 11:28:59'),
(8, 'PG250518237001', 2, 'Kontrak Dinas', 1, '2025', '2025-05-18', '2025-12-31', 'Tidak Aktif', 'Mengundurkan Diri', 'Admin', '2025-05-18 04:32:04', '2025-05-20 05:31:35', '0000-00-00 00:00:00'),
(9, 'PG250518171715', 2, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', 'Admin', '2025-05-18 14:38:45', '2025-05-20 05:23:52', '0000-00-00 00:00:00'),
(10, 'PG250518940823', 9, 'Kontrak Dinas', 3, '2025', '2025-05-18', '2025-12-31', 'Pensiun', '', 'Admin', '2025-05-18 14:44:41', '2025-05-19 01:28:58', '0000-00-00 00:00:00'),
(11, 'PG250519278166', 9, 'Kontrak Dinas', 3, '2025', '2025-05-19', '2025-12-31', 'Menunggu', 'Mengundurkan Diri', 'Admin', '2025-05-19 05:12:30', '2025-05-20 05:25:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit_kerja`
--

CREATE TABLE `tb_unit_kerja` (
  `id_unit_kerja` int NOT NULL,
  `unit_kerja` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `nama_lengkap` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `alamat` text NOT NULL,
  `foto` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `status` enum('Aktif','Menunggu','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unit_kerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kepala`
--
ALTER TABLE `tb_kepala`
  ADD CONSTRAINT `tb_kepala_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_data_pekerja` (`id_pekerja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_2` FOREIGN KEY (`id_nama_pekerjaan`) REFERENCES `tb_nama_pekerjaan` (`id_nama_pekerjaan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tb_riwayat_pekerjaan_ibfk_3` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
