-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2023 at 09:15 AM
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
-- Database: `rumahdrone_gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `gudang_payment`
--

CREATE TABLE `gudang_payment` (
  `no_ref` int(11) NOT NULL,
  `sc_order_id` varchar(25) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `id_metode_pembayaran` int(11) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `tanggal_cancel` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_part`
--

CREATE TABLE `jenis_part` (
  `id` int(11) NOT NULL,
  `jenis_part` varchar(20) NOT NULL,
  `code_jp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_produk`
--

CREATE TABLE `jenis_produk` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_jp` int(11) NOT NULL,
  `code_jp` int(11) NOT NULL,
  `no_urut_sku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL,
  `code_kategori` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` int(11) NOT NULL,
  `jenis_pembayaran` varchar(20) NOT NULL,
  `bank_pembayaran` varchar(20) NOT NULL,
  `no_rek` int(50) NOT NULL,
  `nama_akun` varchar(50) NOT NULL,
  `media_pembayaran` varchar(50) NOT NULL,
  `id_akun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `part_pinjam`
--

CREATE TABLE `part_pinjam` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sub_produk_id` int(11) NOT NULL,
  `tanggal_pinjam` int(11) NOT NULL,
  `tanggal_kembali` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `no_resi` int(11) NOT NULL,
  `kondisi_diterima` varchar(50) NOT NULL,
  `link_doc` varchar(255) NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `qty_real` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_eksternal`
--

CREATE TABLE `produk_eksternal` (
  `id` int(11) NOT NULL,
  `supplier_gudang_id` int(11) NOT NULL,
  `produk_gudang_sku` varchar(20) NOT NULL,
  `sku_eksternal` varchar(50) NOT NULL,
  `nama_eksternal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_gudang`
--

CREATE TABLE `produk_gudang` (
  `id` int(11) NOT NULL,
  `seri_drone_id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `nama_part` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `srp_internal` int(11) NOT NULL,
  `srp_global` int(11) NOT NULL,
  `tanggal_update` datetime NOT NULL,
  `tanggal_disable` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_keluar`
--

CREATE TABLE `produk_keluar` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sub_produk_id` int(11) NOT NULL,
  `no_nota` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `tanggal_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resi`
--

CREATE TABLE `resi` (
  `no_resi` varchar(50) NOT NULL,
  `sc_order_id` varchar(25) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `estimasi_tanggal_datang` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seri_drone`
--

CREATE TABLE `seri_drone` (
  `id` int(11) NOT NULL,
  `nama_drone` varchar(50) NOT NULL,
  `code_nd` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_cart_detail`
--

CREATE TABLE `shop_cart_detail` (
  `id` int(11) NOT NULL,
  `sc_order_id` int(11) NOT NULL,
  `sku` varchar(25) NOT NULL,
  `jenis_part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_pcs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_chart`
--

CREATE TABLE `shop_chart` (
  `order_id` varchar(25) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sku` varchar(25) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tanggal_belanja` datetime NOT NULL,
  `tanggal_update` datetime NOT NULL,
  `tanggal_dihapus` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_img`
--

CREATE TABLE `sku_img` (
  `id` int(11) NOT NULL,
  `sku_pg_id` int(11) NOT NULL,
  `nama_img` varchar(255) NOT NULL,
  `alt_img` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname`
--

CREATE TABLE `stock_opname` (
  `id` int(11) NOT NULL,
  `sub_produk_id` int(11) NOT NULL,
  `status_so` int(11) NOT NULL,
  `keterangan` int(11) NOT NULL,
  `tanggal_so` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_produk`
--

CREATE TABLE `sub_produk` (
  `id` int(11) NOT NULL,
  `produk_gudang_id` int(11) NOT NULL,
  `jenis_part_id` int(11) NOT NULL,
  `id_item` varchar(11) NOT NULL,
  `hpp_pcs` int(11) NOT NULL,
  `ongkir_pcs` int(11) NOT NULL,
  `pajak_pcs` int(11) NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `telephone` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_item`
--

CREATE TABLE `supplier_item` (
  `supplier_id` int(11) NOT NULL,
  `produk_gudang_sku` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gudang_payment`
--
ALTER TABLE `gudang_payment`
  ADD PRIMARY KEY (`no_ref`);

--
-- Indexes for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_eksternal`
--
ALTER TABLE `produk_eksternal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_gudang`
--
ALTER TABLE `produk_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seri_drone`
--
ALTER TABLE `seri_drone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_cart_detail`
--
ALTER TABLE `shop_cart_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_chart`
--
ALTER TABLE `shop_chart`
  ADD PRIMARY KEY (`order_id`,`employee_id`,`supplier_id`,`sku`);

--
-- Indexes for table `sku_img`
--
ALTER TABLE `sku_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_produk`
--
ALTER TABLE `sub_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supplier_item`
--
ALTER TABLE `supplier_item`
  ADD PRIMARY KEY (`supplier_id`,`produk_gudang_sku`),
  ADD KEY `produk_gudang_sku` (`produk_gudang_sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gudang_payment`
--
ALTER TABLE `gudang_payment`
  MODIFY `no_ref` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk_eksternal`
--
ALTER TABLE `produk_eksternal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk_gudang`
--
ALTER TABLE `produk_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seri_drone`
--
ALTER TABLE `seri_drone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_cart_detail`
--
ALTER TABLE `shop_cart_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_img`
--
ALTER TABLE `sku_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_produk`
--
ALTER TABLE `sub_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `supplier_item`
--
ALTER TABLE `supplier_item`
  ADD CONSTRAINT `supplier_item_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `supplier_item_ibfk_2` FOREIGN KEY (`produk_gudang_sku`) REFERENCES `produk_gudang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
