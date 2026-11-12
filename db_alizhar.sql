-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2026 at 06:53 AM
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
-- Database: `db_alizhar`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id_item` int(11) NOT NULL,
  `kode_aset` varchar(50) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `kondisi` varchar(50) DEFAULT 'Layak Pakai',
  `status_item` varchar(50) DEFAULT 'Tersedia di Gudang',
  `id_ruangan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id_item`, `kode_aset`, `nama_item`, `kategori`, `kondisi`, `status_item`, `id_ruangan`) VALUES
(1, 'ITPC2026001', 'PC Dell Optiplex', 'PC', 'Layak Pakai', 'Rusak', NULL),
(2, 'ITMN2026001', 'Monitor Epson', 'Monitor', 'Layak Pakai', 'Terpasang', 1),
(3, 'ITMN2026002', 'Monitor LG Cadangan', 'Monitor', 'Layak Pakai', 'Terpasang', 1),
(4, 'ITPR2026001', 'Proyektor Epson EB-X400', 'Proyektor', 'Layak Pakai', 'Terpasang', 1),
(5, 'ITPR2026002', 'Proyektor InFocus Cadangan', 'Proyektor', 'Layak Pakai', 'Tersedia di Gudang', NULL),
(6, 'ITMK2026001', 'Mouse & Keyboard Logitech', 'Keyboard/Mouse', 'Layak Pakai', 'Terpasang', 1),
(7, 'ITMK2026002', 'Mouse & Keyboard Cadangan', 'Keyboard/Mouse', 'Layak Pakai', 'Tersedia di Gudang', NULL),
(8, 'ITPC20220003', 'ENlight, i5-7200, 4GB DDR4 RAM, 120GB SSD', 'PC', 'Layak Pakai', 'Terpasang', 2);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kerusakan`
--

CREATE TABLE `laporan_kerusakan` (
  `id_laporan` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `deskripsi_kendala` text NOT NULL,
  `status_laporan` varchar(20) DEFAULT 'Pending',
  `tanggal_lapor` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `laporan_kerusakan`
--

INSERT INTO `laporan_kerusakan` (`id_laporan`, `id_ruangan`, `id_item`, `deskripsi_kendala`, `status_laporan`, `tanggal_lapor`) VALUES
(1, 2, 2, 'blur, focus slider msh gk bisa', 'Selesai', '2026-11-12 12:24:50'),
(2, 2, 1, 'gk post', 'Selesai', '2026-11-12 12:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`) VALUES
(1, 'SD 204-C (Kelas 3C)'),
(2, 'SD 205-A (Kelas 4A)'),
(3, 'Ruang Gudang IT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indexes for table `laporan_kerusakan`
--
ALTER TABLE `laporan_kerusakan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_item` (`id_item`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laporan_kerusakan`
--
ALTER TABLE `laporan_kerusakan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD CONSTRAINT `inventaris_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE SET NULL;

--
-- Constraints for table `laporan_kerusakan`
--
ALTER TABLE `laporan_kerusakan`
  ADD CONSTRAINT `laporan_kerusakan_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`),
  ADD CONSTRAINT `laporan_kerusakan_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `inventaris` (`id_item`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
