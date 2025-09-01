-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Sep 2025 pada 08.33
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
(1, 'Peraturan Daerah', '11', '2024', 'Anggaran Pendapatan dan Belanja Daerah Kota Pekalongan Tahun Anggaran 2025', '1751359019_306d31cc6bcd2580bdf4.pdf', 'Aktif 1'),
(2, 'Peraturan Wali Kota ', '47', '2024', 'Penjabaran Anggaran Pendapatan dan Belanja Daerah Kota Pekalongan Tahun Anggaran 2025', '1751359699_92de9d70a0ca4f65fef4.pdf', 'Aktif 2');

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
('PG250717344519', '3326125011920003', 'SUKMANDARI HERSANDINI', 'Pekalongan', '1992-11-10', 'P', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'MANAJEMEN HUTAN', '-', 'S. Hut.', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344520', '3375022105730005', 'SYAEFUDIN', 'Pekalongan', '1973-05-21', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344521', '3375023008670004', 'ROKHIM', 'Pekalongan', '1967-08-30', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344522', '3375011005000010', 'MUHAMMAD FAJRUL FALAH', 'Pekalongan', '2000-05-10', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMK', 'TEKNIK KOMPUTER DAN INFORMATIKA', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344523', '3375042909930006', 'WIWIT SETYO BUDI', 'Pekalongan', '1993-09-29', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344524', '3375012210030001', 'ABDILLAH MAULANA AKBAR', 'Pekalongan', '2003-10-20', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMK', 'TEKNIK OTOMOTIF', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344525', '3375023008960006', 'CHOIRUL UMAM', 'Pekalongan', '1996-08-30', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344526', '3326192905020001', 'FIKIH AL HIDHIR', 'Pekalongan', '2002-05-29', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMA', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344527', '3375022812040002', 'AULIA TRISKA PRASOJO', 'Pekalongan', '2004-12-28', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMK', 'TEKNIK MESIN', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344528', '3375032606700001', 'TARSONO', 'Pekalongan', '1970-06-26', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344529', '3326150912820001', 'MUNAFAL', 'Pekalongan', '1982-12-09', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344530', '3327130707910014', 'LUKMAN KHAKIM', 'Pekalongan', '1991-07-07', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMA', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344531', '3375033001720001', 'AGUS SUPRIYANTO', 'Pekalongan', '1972-01-30', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344532', '3375020204880003', 'JA\'FAR', 'Pekalongan', '1988-04-02', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344533', '3375012108940002', 'AGUS SETIAWAN', 'Pekalongan', '1994-08-21', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMK', 'TEKNIK KOMPUTER DAN INFORMATIKA', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344534', '3375022109820003', 'ZAENAL SODIKIN', 'Pekalongan', '1982-09-21', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344535', '3375023107960003', 'BADRUZ ZAMAN', 'Pekalongan', '1996-07-31', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMP', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250717344536', '3375022712950006', 'MUCHAMMAD NUR CHOLIQ', 'Pekalongan', '1995-12-27', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SD', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878717', '3375015405840006', 'MEILIYA ISMIYATI', 'Pekalongan', '1984-05-14', 'P', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Akuntansi', '-', 'S. E.', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878718', '3327111704020001', 'FAJAR AJI KUSUMA', 'Pemalang', '2002-04-17', 'L', 'Tegalsari Timur', '43/08', 'Tegalsari Timur', 'Ampelgading', 'Pemalang', 'Jawa Tengah', '52364', 'KTPPG2507218787181753096217_39c122a4af33e0721b85.jpg', 'S1', 'Teknik Informatika', '-', 'S. Kom.', 'IJAZAHPG2507218787181753096217_2ba018104569bc4253a2.pdf', 'Terverifikasi', '', '2025-07-21 08:58:01', '2025-07-21 13:10:31', '0000-00-00 00:00:00'),
('PG250721878719', '1803105111870003', 'MUROHATI', 'Kotabumi', '1987-11-11', 'P', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Pendidikan Agama Islam', '-', 'S. Pd.I.', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878720', '3375010603910003', 'BAGUS JIWAN NIZAL SAPUTRA', 'Pekalongan', '1991-03-06', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Manajemen', '-', 'S. M.', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878721', '3375036110910001', 'AMALIA CHUSNIANA', 'Pekalongan', '1991-10-21', 'P', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Ekonomi Manajemen', '-', 'S. E.', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878722', '3375032306940002', 'LEONARDO ARISKA', 'Pekalongan', '1994-05-23', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S1', 'Ilmu Hukum', '-', 'S. H.', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878723', '3326150703870002', 'HENDRI SETIAWAN', 'Pekalongan', '1987-03-07', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMA', 'Paket C IPS', '-', '-', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PG250721878724', '3375033007680003', 'JAYA GUNA', 'Pekalongan', '1968-07-30', 'L', 'Pekalongan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SMA', '-', '-', '-', NULL, 'Terverifikasi', '', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(8, 9, '197012141990031004', 'Dr. SRI BUDI SANTOSO, M.Si.', 'Kepala Dinas Lingkungan Hidup', 'Kepala', 'Kadin Pada DLH Kota Pekalongan', 'Aktif'),
(9, 1, '197606072000122004', 'DWI YUNIASTUTI, S.KM., M.M.', 'Sekretaris Dinas Lingkungan Hidup', 'Sekretaris', 'Sekdin Pada DLH Kota Pekalongan', 'Aktif'),
(10, 3, '196808161990031009', 'ADI SETIAWAN, S.E.', 'Kepala Bidang Kebesihan dan Pengelolaan Sampah', 'Kepala Bidang', 'Kabid Pada Bidang Kebesihan dan Pengelolaan Sampah', 'Aktif'),
(11, 5, '197806032005011012', 'ADI USNAN, S.E.', 'Kepala Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Kepala Bidang', 'Kabid Pada Bidang Pengendalian, Pencemaran Dan Kerusakan Lingkungan Dan Pengelolaan RTH', 'Aktif'),
(12, 2, '197808282011012002', 'SOFIANA, S.T.', 'Plt. Kepala Bidang Tata Lingkungan dan Penaatan Hukum Lingkungan', 'Plt. Kepala Bidang', 'Pelaksana Tugas Kabid Taling Pada Bidang Taling', 'Aktif');

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
(137, 'Petugas Penyapu Jalan', 'Petugas yang bertanggung jawab membersihkan jalan dari sampah, debu dan kotoran lainnya dengan sapu agar bersih dan aman bagi pengguna jalan');

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
  `penginput` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_riwayat_pekerjaan`
--

INSERT INTO `tb_riwayat_pekerjaan` (`id`, `id_pekerja`, `id_nama_pekerjaan`, `jenis_pegawai`, `id_unit_kerja`, `tahun`, `tmt_kerja`, `tst_kerja`, `status`, `gaji`, `uraian_pekerjaan`, `sk_spt`, `sk_pks`, `penginput`, `created_at`, `updated_at`, `deleted_at`) VALUES
(174, 'PG250717344519', 114, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 'PG250717344520', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 'PG250717344521', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 'PG250717344522', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 'PG250717344523', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 'PG250717344524', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 'PG250717344525', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 'PG250717344526', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 'PG250717344527', 115, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 'PG250717344528', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 'PG250717344529', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 'PG250717344530', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 'PG250717344531', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 'PG250717344532', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 'PG250717344533', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 'PG250717344534', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 'PG250717344535', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 'PG250717344536', 116, 'Kontrak Dinas', 5, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Fajar Aji Ku', '2025-07-17 07:54:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 'PG250721878717', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 'PG250721878718', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '2050000', 'Melaksanakan urusan keasipan dan dokumentasi;\r\nMelaksanakan pemeliharaan arsip dan dokumen;\r\nMelaksanakan pengelolaan ruang rapat, perpustakaan dan ruang audio visual;\r\nMelaksanakan pemeliharaan jaringan dan koneksi Internet, pengelolaan SIM dan publikasi dinas;\r\nMenjaga peralatan kerja/barang inventaris Dinas Lingkungan Hidup yang dalam penguasaannya sesuai bidang tugas PIHAK KEDUA;\r\nMelaksanakan koordinasi aktif dengan PIHAK KESATU atau SEKRETARIS dalam pelaksanaan tugas;\r\nMelaksanakan tugas lain yang diberikan oleh atasan/pimpinan', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 'PG250721878719', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 'PG250721878720', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 'PG250721878721', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 'PG250721878722', 114, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 'PG250721878723', 117, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 'PG250721878724', 117, 'Kontrak Dinas', 1, '2025', '2025-01-01', '2025-12-31', 'Terverifikasi', '', '', '', '', 'Kuspriyono', '2025-07-21 08:58:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(6, 5, 'M. Faza Mustafid', 'faza@gmail.com', '089898989898', 'Pekalongan', '1752739051_521f44c7ae03b588f22b.webp', 'faza', '$2y$10$3z0N/nE7OCi3doqlc.Kb1.Knqig1SeNznm1UP0jtNat.llNop.YD.', 'user', 'Aktif'),
(7, 3, 'Kurniyawati', 'kurniyawati795@gmail.com', '085211086273', 'Jl.Pantai Sari Rt.01/Rw.10 Kel.Panjang Baru  ', '1753152577_1e05c707a82f68a2112e.jpg', 'nia', '$2y$10$w5Tuys6Pk0B6FoukXjVwIudwFQryCVdgcHQ02UyB9KSXbIIjB5YvK', 'user', 'Aktif');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_kepala`
--
ALTER TABLE `tb_kepala`
  MODIFY `id_kepala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_nama_pekerjaan`
--
ALTER TABLE `tb_nama_pekerjaan`
  MODIFY `id_nama_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT untuk tabel `tb_perpanjangan_kontrak`
--
ALTER TABLE `tb_perpanjangan_kontrak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_riwayat_pekerjaan`
--
ALTER TABLE `tb_riwayat_pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT untuk tabel `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tb_unit_kerja` (`id_unit_kerja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
