-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2024 at 09:44 AM
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
-- Database: `rumahdrone_produk`
--

-- --------------------------------------------------------

--
-- Table structure for table `kios_kelengkapan_second_list`
--

CREATE TABLE `kios_kelengkapan_second_list` (
  `pivot_qc_id` int(11) NOT NULL,
  `qc_id` int(11) DEFAULT NULL,
  `produk_kelengkapan_id` int(11) DEFAULT NULL,
  `kios_produk_second_id` int(11) DEFAULT NULL,
  `kondisi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `harga_satuan` int(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_kelengkapan_second_list`
--

INSERT INTO `kios_kelengkapan_second_list` (`pivot_qc_id`, `qc_id`, `produk_kelengkapan_id`, `kios_produk_second_id`, `kondisi`, `keterangan`, `serial_number`, `harga_satuan`, `status`) VALUES
(1, 7, 6, 1, 'Kondisi 1', 'Keterangan 1', 'SecSN1', 2222000, 'On Sell'),
(2, 7, 7, 1, 'Kondisi 2', 'Keternagan 2', 'SecSN2', 2222000, 'On Sell'),
(3, 7, 7, 2, 'Kondisi 3', 'Keterangan 3', 'SecSN3', 2222000, 'On Sell'),
(4, 8, 6, NULL, NULL, NULL, NULL, NULL, 'Belum QC'),
(5, 8, 7, NULL, NULL, NULL, NULL, NULL, 'Belum QC');

-- --------------------------------------------------------

--
-- Table structure for table `produk_jenis`
--

CREATE TABLE `produk_jenis` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `jenis_produk` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_jenis`
--

INSERT INTO `produk_jenis` (`id`, `kategori_id`, `jenis_produk`, `created_at`, `updated_at`) VALUES
(3, 3, 'DJI MAVIC 3 PRO', '2023-12-14 20:28:20', '2023-12-14 20:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `produk_kategori`
--

CREATE TABLE `produk_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_kategori`
--

INSERT INTO `produk_kategori` (`id`, `nama`) VALUES
(1, 'Agriculture'),
(2, 'Consumer'),
(3, 'Enterprise'),
(4, 'Handheld');

-- --------------------------------------------------------

--
-- Table structure for table `produk_kelengkapan`
--

CREATE TABLE `produk_kelengkapan` (
  `id` int(11) NOT NULL,
  `produk_jenis_id` int(11) NOT NULL,
  `kelengkapan` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_kelengkapan`
--

INSERT INTO `produk_kelengkapan` (`id`, `produk_jenis_id`, `kelengkapan`, `created_at`, `updated_at`) VALUES
(6, 3, 'Dji Mavic 3 Intelligent Flight Battery', '2023-12-14 20:28:20', '2024-01-26 00:45:46'),
(7, 3, 'Dji Mavic 3 100w Battery Charging Hub', '2023-12-14 20:28:20', '2024-01-26 00:45:46'),
(8, 3, 'Dji 65w Car Charger', '2023-12-14 20:28:20', '2023-12-14 20:28:20'),
(9, 3, 'Dji Mavic 3 Low-noise Propeller (pair)', '2023-12-14 20:28:20', '2023-12-14 20:28:20'),
(10, 3, 'Dji Convertible Carrying Bag', '2023-12-14 20:28:20', '2023-12-14 20:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `produk_status`
--

CREATE TABLE `produk_status` (
  `id` int(11) NOT NULL,
  `status_produk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_status`
--

INSERT INTO `produk_status` (`id`, `status_produk`) VALUES
(1, 'Part Baru'),
(2, 'Part Bekas'),
(3, 'Produk Baru'),
(4, 'Produk Bekas');

-- --------------------------------------------------------

--
-- Table structure for table `produk_sub_jenis`
--

CREATE TABLE `produk_sub_jenis` (
  `id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `produk_type_id` int(11) NOT NULL,
  `paket_penjualan` varchar(255) NOT NULL,
  `berat` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_sub_jenis`
--

INSERT INTO `produk_sub_jenis` (`id`, `jenis_id`, `produk_type_id`, `paket_penjualan`, `berat`, `created_at`, `updated_at`) VALUES
(11, 3, 1, 'FLY MORE COMBO KIT', 5, '2023-12-15 21:47:44', '2023-12-15 21:47:44'),
(12, 3, 5, 'COMBO RC PRO', 6, '2023-12-17 19:16:54', '2023-12-17 19:16:54'),
(13, 3, 1, 'CLASSIC', 5, '2024-02-20 23:53:25', '2024-02-20 23:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `produk_sub_kelengkapan`
--

CREATE TABLE `produk_sub_kelengkapan` (
  `produk_sub_jenis_id` int(11) NOT NULL,
  `produk_kelengkapan_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_sub_kelengkapan`
--

INSERT INTO `produk_sub_kelengkapan` (`produk_sub_jenis_id`, `produk_kelengkapan_id`, `quantity`) VALUES
(11, 6, 1),
(11, 7, 1),
(11, 8, 2),
(11, 9, 3),
(11, 10, 3),
(12, 6, 1),
(12, 7, 2),
(13, 6, 2),
(13, 7, 1),
(13, 9, 2),
(13, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk_type`
--

CREATE TABLE `produk_type` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_type`
--

INSERT INTO `produk_type` (`id`, `type`, `code`) VALUES
(1, 'Drone', 'DR'),
(2, 'Handheld', 'HH'),
(3, 'Goggles', 'GG'),
(4, 'Accessories', 'ACC'),
(5, 'Remote Controller', 'RC'),
(6, 'Battery', 'BTR');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_kios_kategori`
--

CREATE TABLE `supplier_kios_kategori` (
  `supplier_kios_id` int(11) DEFAULT NULL,
  `produk_kategori_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_kios_kategori`
--

INSERT INTO `supplier_kios_kategori` (`supplier_kios_id`, `produk_kategori_id`) VALUES
(1, 3),
(1, 2),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_kios_sub`
--

CREATE TABLE `supplier_kios_sub` (
  `supplier_kios_id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `nilai` int(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_kios_sub`
--

INSERT INTO `supplier_kios_sub` (`supplier_kios_id`, `sub_jenis_id`, `nilai`) VALUES
(1, 11, 2666000),
(1, 12, 2000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kios_kelengkapan_second_list`
--
ALTER TABLE `kios_kelengkapan_second_list`
  ADD PRIMARY KEY (`pivot_qc_id`),
  ADD KEY `qc_id` (`qc_id`),
  ADD KEY `produk_kelengkapan_id` (`produk_kelengkapan_id`);

--
-- Indexes for table `produk_jenis`
--
ALTER TABLE `produk_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_kategori`
--
ALTER TABLE `produk_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_kelengkapan`
--
ALTER TABLE `produk_kelengkapan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_status`
--
ALTER TABLE `produk_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_sub_jenis`
--
ALTER TABLE `produk_sub_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_sub_kelengkapan`
--
ALTER TABLE `produk_sub_kelengkapan`
  ADD PRIMARY KEY (`produk_sub_jenis_id`,`produk_kelengkapan_id`),
  ADD KEY `produk_kelengkapan_id` (`produk_kelengkapan_id`);

--
-- Indexes for table `produk_type`
--
ALTER TABLE `produk_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_kios_kategori`
--
ALTER TABLE `supplier_kios_kategori`
  ADD KEY `supplier_kios_id` (`supplier_kios_id`),
  ADD KEY `produk_kategori_id` (`produk_kategori_id`);

--
-- Indexes for table `supplier_kios_sub`
--
ALTER TABLE `supplier_kios_sub`
  ADD KEY `sub_jenis_id` (`sub_jenis_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kios_kelengkapan_second_list`
--
ALTER TABLE `kios_kelengkapan_second_list`
  MODIFY `pivot_qc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk_jenis`
--
ALTER TABLE `produk_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk_kategori`
--
ALTER TABLE `produk_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk_kelengkapan`
--
ALTER TABLE `produk_kelengkapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produk_status`
--
ALTER TABLE `produk_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk_sub_jenis`
--
ALTER TABLE `produk_sub_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `produk_type`
--
ALTER TABLE `produk_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kios_kelengkapan_second_list`
--
ALTER TABLE `kios_kelengkapan_second_list`
  ADD CONSTRAINT `kios_kelengkapan_second_list_ibfk_1` FOREIGN KEY (`qc_id`) REFERENCES `rumahdrone_kios`.`kios_qc_produk_second` (`id`),
  ADD CONSTRAINT `kios_kelengkapan_second_list_ibfk_2` FOREIGN KEY (`produk_kelengkapan_id`) REFERENCES `produk_kelengkapan` (`id`);

--
-- Constraints for table `produk_sub_kelengkapan`
--
ALTER TABLE `produk_sub_kelengkapan`
  ADD CONSTRAINT `produk_sub_kelengkapan_ibfk_1` FOREIGN KEY (`produk_sub_jenis_id`) REFERENCES `produk_sub_jenis` (`id`),
  ADD CONSTRAINT `produk_sub_kelengkapan_ibfk_2` FOREIGN KEY (`produk_kelengkapan_id`) REFERENCES `produk_kelengkapan` (`id`);

--
-- Constraints for table `supplier_kios_kategori`
--
ALTER TABLE `supplier_kios_kategori`
  ADD CONSTRAINT `supplier_kios_kategori_ibfk_1` FOREIGN KEY (`supplier_kios_id`) REFERENCES `rumahdrone_kios`.`supplier_kios` (`id`),
  ADD CONSTRAINT `supplier_kios_kategori_ibfk_2` FOREIGN KEY (`produk_kategori_id`) REFERENCES `produk_kategori` (`id`);

--
-- Constraints for table `supplier_kios_sub`
--
ALTER TABLE `supplier_kios_sub`
  ADD CONSTRAINT `supplier_kios_sub_ibfk_1` FOREIGN KEY (`supplier_kios_id`) REFERENCES `rumahdrone_kios`.`supplier_kios` (`id`),
  ADD CONSTRAINT `supplier_kios_sub_ibfk_2` FOREIGN KEY (`sub_jenis_id`) REFERENCES `produk_sub_jenis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
