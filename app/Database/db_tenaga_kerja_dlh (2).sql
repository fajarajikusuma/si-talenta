-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2025 at 07:05 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `tb_kepala`
--

CREATE TABLE `tb_kepala` (
  `id_kepala` int NOT NULL,
  `id_unit_kerja` int NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_kepala` text NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_kepala`
--

INSERT INTO `tb_kepala` (`id_kepala`, `id_unit_kerja`, `nip`, `nama_kepala`, `jabatan`, `keterangan`, `status`) VALUES
(3, 3, '121212121212121212', 'Wawan', 'Kepala Bidang KPS', 'Kabid pada bidang kebersihan dan pengelolaan sampah', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nama_pekerjaan`
--

CREATE TABLE `tb_nama_pekerjaan` (
  `id_nama_pekerjaan` int NOT NULL,
  `pekerjaan` text NOT NULL,
  `uraian_kerja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `status` enum('Terverifikasi','Menunggu','Tidak Aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `penginput` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(5, 'PPKL', 'Unit Organisasi Pengendalian Pencemaran dan Kerusakan Lingkungan Dinas Lingkungan Hidup Kota Pekalongan');

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
  ADD PRIMARY KEY (`id_pekerja`);

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
  MODIFY `id_kepala` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  MODIFY `id_nama_pekerjaan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unit_kerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
