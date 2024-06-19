-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 12:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'Fadil', '123'),
(2, 'Fachri', '456');

-- --------------------------------------------------------

--
-- Table structure for table `instansi_pkl`
--

CREATE TABLE `instansi_pkl` (
  `id_instansi` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `pembimbing_eksternal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instansi_pkl`
--

INSERT INTO `instansi_pkl` (`id_instansi`, `nama`, `alamat`, `pembimbing_eksternal`) VALUES
(3, 'Kantor Camat', 'Jl Gunung Nona', 'Ammang Father'),
(4, 'PDAM', 'Ratu langit', 'Hafiz 30 Juz'),
(5, 'Peternakan', 'Veteran Selatan', 'Charles'),
(6, 'ICT', '--', 'Ilham'),
(7, 'Suzuki Finance', '-', 'Vandjk'),
(8, 'Bosowa', 'Jl. Sudirman', 'David');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `kehadiran` enum('Hadir','Alpha','Izin','Sakit') NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL,
  `dokumentasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`id_jurnal`, `id_siswa`, `kehadiran`, `tanggal`, `deskripsi`, `dokumentasi`) VALUES
(1, 19, 'Hadir', '2024-06-12', 'Hari ini saya memperbaiki PC dan memasang kabel jaringan', '-'),
(2, 19, 'Hadir', '2024-06-11', 'ketiduran', '-');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `link_laporan` varchar(255) NOT NULL,
  `id_siswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `link_laporan`, `id_siswa`) VALUES
(1, 'https://www.instagram.com/_fcrii/', 19),
(2, '-', 19);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` enum('Pembimbing','Admin','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `status`) VALUES
('fadhil@gmail.com', 'f', 'Pembimbing'),
('Latto@gmail.com', '12', 'Admin'),
('Ray@hmail.com', '11', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing`
--

CREATE TABLE `pembimbing` (
  `id_pembimbing` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembimbing`
--

INSERT INTO `pembimbing` (`id_pembimbing`, `nama`, `nip`, `jurusan`) VALUES
(2, 'Ibrahim ', '19028266', 'Rekayasa Perangkat Lunak'),
(3, 'Fadhil s.kom', '008976541', 'Las Mesin'),
(4, 'Angga', '1908362368', 'Teknik Las Pesawat');

-- --------------------------------------------------------

--
-- Table structure for table `pivot_pkl`
--

CREATE TABLE `pivot_pkl` (
  `id_siswa` int(11) NOT NULL,
  `id_pembimbing` int(11) NOT NULL,
  `id_instansi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pivot_pkl`
--

INSERT INTO `pivot_pkl` (`id_siswa`, `id_pembimbing`, `id_instansi`) VALUES
(19, 2, 3),
(19, 2, 4),
(20, 4, 6),
(21, 4, 3),
(23, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama`, `nis`, `kelas`, `jurusan`) VALUES
(19, 'Fachri', '22357', 'XI', 'RPL'),
(20, 'Alkawsar', '22355', 'XI', 'RPL'),
(21, 'Rahman', '22351', 'XI', 'RPL'),
(22, 'Ardi', '2259', 'XI', 'RPL'),
(23, 'Fatir', '22668', 'XI', 'RPL'),
(24, 'Farel', '22363', 'XI ', 'RPL'),
(26, 'Fadhil', '22897', 'XI ', 'RPL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `instansi_pkl`
--
ALTER TABLE `instansi_pkl`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD PRIMARY KEY (`id_pembimbing`);

--
-- Indexes for table `pivot_pkl`
--
ALTER TABLE `pivot_pkl`
  ADD PRIMARY KEY (`id_siswa`,`id_pembimbing`,`id_instansi`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_instansi` (`id_instansi`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `instansi_pkl`
--
ALTER TABLE `instansi_pkl`
  MODIFY `id_instansi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembimbing`
--
ALTER TABLE `pembimbing`
  MODIFY `id_pembimbing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pivot_pkl`
--
ALTER TABLE `pivot_pkl`
  ADD CONSTRAINT `pivot_pkl_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pivot_pkl_ibfk_2` FOREIGN KEY (`id_pembimbing`) REFERENCES `pembimbing` (`id_pembimbing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pivot_pkl_ibfk_3` FOREIGN KEY (`id_instansi`) REFERENCES `instansi_pkl` (`id_instansi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
