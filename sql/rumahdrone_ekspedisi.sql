-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 10:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumahdrone_ekspedisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `id` int(11) NOT NULL,
  `ekspedisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekspedisi`
--

INSERT INTO `ekspedisi` (`id`, `ekspedisi`) VALUES
(1, 'Gojek'),
(2, 'JNT'),
(3, 'Lion Parcel'),
(4, 'Paxel'),
(5, 'Pos'),
(6, 'Sentral Cargo'),
(7, 'Sicepat'),
(8, 'Travel');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_layanan`
--

CREATE TABLE `jenis_layanan` (
  `id` int(11) NOT NULL,
  `ekspedisi_id` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_layanan`
--

INSERT INTO `jenis_layanan` (`id`, `ekspedisi_id`, `nama_layanan`) VALUES
(1, 1, 'Express'),
(2, 1, 'Reguler'),
(3, 2, 'Cargo'),
(4, 2, 'Xpress'),
(5, 3, 'Bosspack'),
(6, 3, 'Jagopack'),
(7, 3, 'Regpack');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_barang`
--

CREATE TABLE `penerimaan_barang` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `pengiriman_ekspedisi_id` int(11) NOT NULL,
  `kondisi_barang` varchar(255) NOT NULL,
  `total_paket` int(11) NOT NULL,
  `tanggal_diterima` varchar(20) NOT NULL,
  `link_img_resi` varchar(255) NOT NULL,
  `link_img_paket` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerimaan_barang`
--

INSERT INTO `penerimaan_barang` (`id`, `employee_id`, `pengiriman_ekspedisi_id`, `kondisi_barang`, `total_paket`, `tanggal_diterima`, `link_img_resi`, `link_img_paket`, `created_at`, `updated_at`) VALUES
(4, 4, 3, 'Peyot dikit gak ngaruh', 1, '2023-12-29', '', 'https://drive.google.com/file/d/1X8xdDVFtso88J0E3LcMlSpNkom7t2f33/view?usp=drivesdk', '2023-12-29 02:44:20', '2023-12-29 02:44:20'),
(5, 3, 13, 'aman sentosa', 1, '03/06/2024', 'https://drive.google.com/file/d/1EqSmS8QxlEqC2frSKAckh1sIrbX_pd58/view?usp=drivesdk', 'https://drive.google.com/file/d/1VkjbdQ9HfceC8V0eto6MNRrvk2PB95K4/view?usp=drivesdk', '2024-03-18 01:05:36', '2024-03-18 01:05:36'),
(8, 3, 6, 'Lecet Dikit', 1, '03/07/2024', 'https://drive.google.com/file/d/16eTsKEX1ECZe4P45Uvb-obOE2KAePnCJ/view?usp=drivesdk', 'https://drive.google.com/file/d/1fDsLgEABqsTV-n6pH0GVNEE9dFbWKWMp/view?usp=drivesdk', '2024-03-19 00:19:22', '2024-03-19 00:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_ekspedisi`
--

CREATE TABLE `pengiriman_ekspedisi` (
  `id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `ekspedisi_id` int(11) DEFAULT NULL,
  `no_resi` varchar(100) DEFAULT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `status_order` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman_ekspedisi`
--

INSERT INTO `pengiriman_ekspedisi` (`id`, `divisi_id`, `order_id`, `ekspedisi_id`, `no_resi`, `no_faktur`, `status_order`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 9, 6, '19LP1703123903446', NULL, 'Baru', 'InRD', '2023-12-23 00:29:55', '2024-01-06 02:11:24'),
(6, 1, 20, 3, '19LP1709168361276', 'ini no faktur', 'Baru', 'InRD', '2024-03-01 21:41:12', '2024-03-19 23:27:32'),
(13, 1, 22, 3, '19LP1704413347872', NULL, 'Baru', 'InRD', '2024-03-16 01:38:40', '2024-03-18 01:41:00'),
(15, 1, 23, NULL, NULL, NULL, 'Bekas', 'Belum Dikirim', '2024-03-22 21:09:23', '2024-03-22 21:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `validasi_barang`
--

CREATE TABLE `validasi_barang` (
  `id` int(11) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `pengiriman_barang_id` int(11) NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validasi_barang`
--

INSERT INTO `validasi_barang` (`id`, `order_list_id`, `pengiriman_barang_id`, `quantity_received`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(3, 13, 3, 6, NULL, 'Done', '2024-01-05 21:00:48', '2024-01-05 21:00:48'),
(13, 14, 3, 3, NULL, 'Kurang', '2024-01-06 02:11:24', '2024-01-06 02:11:24'),
(14, 19, 13, 4, NULL, 'Done', '2024-03-18 01:39:52', '2024-03-18 01:39:52'),
(15, 21, 13, 6, NULL, 'Done', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(16, 18, 6, 6, NULL, 'Done', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(17, 17, 6, 3, NULL, 'Kurang', '2024-03-19 23:27:32', '2024-03-19 23:27:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaan_barang`
--
ALTER TABLE `penerimaan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengiriman_ekspedisi`
--
ALTER TABLE `pengiriman_ekspedisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validasi_barang`
--
ALTER TABLE `validasi_barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penerimaan_barang`
--
ALTER TABLE `penerimaan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengiriman_ekspedisi`
--
ALTER TABLE `pengiriman_ekspedisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `validasi_barang`
--
ALTER TABLE `validasi_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
