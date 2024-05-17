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
-- Database: `rumahdrone_kios`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_recap`
--

CREATE TABLE `daily_recap` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `keperluan_id` int(11) DEFAULT NULL,
  `barang_cari` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_recap`
--

INSERT INTO `daily_recap` (`id`, `employee_id`, `customer_id`, `jenis_id`, `sub_jenis_id`, `keperluan_id`, `barang_cari`, `keterangan`, `status_id`, `created_at`, `updated_at`) VALUES
(3, 3, 9, 3, 11, 2, 'Drone', 'Ikut PO tanggal 6-6-6666', 4, '2024-02-16 00:36:19', '2024-02-16 00:36:19'),
(4, 3, 10, 4, 13, 3, 'Drone', 'Mau jual drone harga gak masuk', 1, '2024-02-23 20:11:46', '2024-02-23 20:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `history_order`
--

CREATE TABLE `history_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `nilai` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_order`
--

INSERT INTO `history_order` (`id`, `order_id`, `sub_jenis_id`, `quantity`, `nilai`, `created_at`, `updated_at`) VALUES
(13, 9, 11, 6, 2666000, '2023-12-20 01:24:05', '2023-12-20 20:00:11'),
(14, 9, 12, 6, 2000000, '2023-12-20 01:24:05', '2023-12-20 20:00:11'),
(17, 20, 11, 5, 3000000, '2023-12-26 21:14:38', '2023-12-26 21:56:25'),
(18, 20, 12, 6, 2000000, '2023-12-26 21:14:38', '2023-12-26 21:58:20'),
(19, 22, 11, 4, 19300000, '2024-02-17 01:22:56', '2024-03-15 23:50:49'),
(20, 22, 13, 6, 4200000, '2024-03-15 23:50:49', '2024-03-15 23:50:49'),
(21, 22, 13, 6, 4200000, '2024-03-15 23:56:27', '2024-03-15 23:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `kios_akun_rd`
--

CREATE TABLE `kios_akun_rd` (
  `id` int(11) NOT NULL,
  `nama_akun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_akun_rd`
--

INSERT INTO `kios_akun_rd` (`id`, `nama_akun`) VALUES
(1, 'BCA Kios'),
(2, 'BCA PT Odo Multi Aero'),
(3, 'BCA PT Rumah Drone'),
(4, 'BCA Repair'),
(5, 'BNI'),
(6, 'Mandiri'),
(7, 'Mandiri PT Odo Multi Aero'),
(8, 'Mandiri PT Rumah Drone'),
(9, 'Kas Tunai'),
(10, 'Bukalapak'),
(11, 'Shopee'),
(12, 'Tokopedia');

-- --------------------------------------------------------

--
-- Table structure for table `kios_image_paket_baru`
--

CREATE TABLE `kios_image_paket_baru` (
  `id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `use_for` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `link_drive` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_image_paket_baru`
--

INSERT INTO `kios_image_paket_baru` (`id`, `sub_jenis_id`, `use_for`, `nama`, `link_drive`, `created_at`, `updated_at`) VALUES
(1, 13, 'Paket', '4506cbf60137f93bf13c293c8493daf4.png', 'https://drive.google.com/file/d/11cW-qoMZ9cFkRH_v-6nQfpSgq9IeVoJZ/view?usp=drivesdk', '2024-02-20 23:53:42', '2024-02-20 23:53:42'),
(2, 13, 'Kelengkapan', 'home-repair.png', 'https://drive.google.com/file/d/12-igWNn2YQ-ntfUIXe62zOMvpxZhH4ES/view?usp=drivesdk', '2024-02-20 23:53:42', '2024-02-20 23:53:42'),
(3, 13, 'Kelengkapan', 'home-repair-3d.png', 'https://drive.google.com/file/d/1ua8UFyX-4rJRf97VhlBDwNf1yC7b-W_Q/view?usp=drivesdk', '2024-02-20 23:53:42', '2024-02-20 23:53:42'),
(4, 13, 'Kelengkapan', 'svg.png', 'https://drive.google.com/file/d/1cIONqapAD6SFECttKmLj7vGxR4-T6Bwt/view?usp=drivesdk', '2024-02-20 23:53:42', '2024-02-20 23:53:42');

-- --------------------------------------------------------

--
-- Table structure for table `kios_image_paket_second`
--

CREATE TABLE `kios_image_paket_second` (
  `id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `use_for` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `link_drive` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kios_komplain_second`
--

CREATE TABLE `kios_komplain_second` (
  `id` int(11) NOT NULL,
  `kios_qc_produk_second_id` int(11) NOT NULL,
  `biaya_retur` int(11) DEFAULT NULL,
  `biaya_negoisasi` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kios_marketplace`
--

CREATE TABLE `kios_marketplace` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_marketplace`
--

INSERT INTO `kios_marketplace` (`id`, `nama`) VALUES
(1, 'Tokopedia'),
(2, 'Shopee'),
(3, 'Facebook'),
(4, 'Komunitas'),
(5, 'Partner');

-- --------------------------------------------------------

--
-- Table structure for table `kios_metode_pembayaran_second`
--

CREATE TABLE `kios_metode_pembayaran_second` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `media_pembayaran` varchar(20) NOT NULL,
  `no_rek` varchar(30) NOT NULL,
  `nama_akun` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_metode_pembayaran_second`
--

INSERT INTO `kios_metode_pembayaran_second` (`id`, `customer_id`, `media_pembayaran`, `no_rek`, `nama_akun`, `created_at`, `updated_at`) VALUES
(1, 12, 'BCA', '8732812666', 'Oke Gas Aha', '2024-03-20 23:49:54', '2024-03-20 23:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `kios_payment`
--

CREATE TABLE `kios_payment` (
  `id` int(11) NOT NULL,
  `order_type` varchar(20) NOT NULL,
  `order_id` int(11) NOT NULL,
  `metode_pembayaran_id` int(11) DEFAULT NULL,
  `jenis_pembayaran` varchar(50) DEFAULT NULL,
  `nilai` int(11) NOT NULL DEFAULT 0,
  `ongkir` int(20) NOT NULL DEFAULT 0,
  `pajak` int(20) NOT NULL DEFAULT 0,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(25) NOT NULL,
  `tanggal_request` varchar(20) DEFAULT NULL,
  `tanggal_payment` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_payment`
--

INSERT INTO `kios_payment` (`id`, `order_type`, `order_id`, `metode_pembayaran_id`, `jenis_pembayaran`, `nilai`, `ongkir`, `pajak`, `keterangan`, `status`, `tanggal_request`, `tanggal_payment`, `created_at`, `updated_at`) VALUES
(1, 'Baru', 9, 1, 'Pembelian Barang, Ongkir', 27996000, 166000, 0, 'Coba Req Payment', 'Paid', '23/12/2023 14:29:51', '2023-12-23 14:30:11', '2023-12-20 20:00:11', '2023-12-23 00:29:55'),
(2, 'Baru', 20, 1, 'Pembelian Barang, Ongkir', 27000000, 666000, 0, 'Coba beli drone baru', 'Paid', '02/03/2024 11:41:01', '2024-03-03 04:41:11', '2023-12-26 21:58:21', '2024-03-01 21:41:11'),
(6, 'Baru', 22, 1, 'Pembelian Barang, Ongkir', 102400000, 66000, 0, 'Restock drone baru bulan maret', 'Paid', '16/03/2024 15:38:38', '2024-03-16 14:38:10', '2024-03-16 00:31:47', '2024-03-16 01:38:40'),
(17, 'Bekas', 23, 1, 'Pembelian Barang, Ongkir', 4300000, 26000, 0, NULL, 'Unpaid', '2024-03-23 13:45:27', NULL, '2024-03-22 21:09:23', '2024-03-22 23:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `kios_produk`
--

CREATE TABLE `kios_produk` (
  `id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `produk_img_id` int(11) DEFAULT NULL,
  `srp` int(11) DEFAULT 0,
  `harga_promo` int(11) DEFAULT 0,
  `start_promo` varchar(20) DEFAULT NULL,
  `end_promo` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_produk`
--

INSERT INTO `kios_produk` (`id`, `sub_jenis_id`, `produk_img_id`, `srp`, `harga_promo`, `start_promo`, `end_promo`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, NULL, 31300000, 0, NULL, NULL, 'Ready', '2024-01-05 21:00:48', '2024-03-18 01:46:46'),
(8, 12, NULL, 2700000, 0, NULL, NULL, 'Ready', '2024-01-06 02:11:24', '2024-02-19 20:56:12'),
(9, 13, 1, 5700000, 0, NULL, NULL, 'Ready', '2024-02-21 07:06:27', '2024-03-18 01:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `kios_produk_second`
--

CREATE TABLE `kios_produk_second` (
  `id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `produk_image_id` int(11) DEFAULT NULL,
  `srp` int(11) NOT NULL,
  `cc_produk_second` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kios_qc_produk_second`
--

CREATE TABLE `kios_qc_produk_second` (
  `id` int(11) NOT NULL,
  `order_second_id` int(11) NOT NULL,
  `tanggal_qc` varchar(20) DEFAULT NULL,
  `tanggal_filter` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_qc_produk_second`
--

INSERT INTO `kios_qc_produk_second` (`id`, `order_second_id`, `tanggal_qc`, `tanggal_filter`, `created_at`, `updated_at`) VALUES
(7, 7, '06/03/2024 15:12:16', '07/03/2024 10:38:44', '2024-01-15 20:00:36', '2024-03-06 20:38:44'),
(22, 23, NULL, NULL, '2024-03-22 21:09:23', '2024-03-22 21:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `kios_recap_keperluan`
--

CREATE TABLE `kios_recap_keperluan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_recap_keperluan`
--

INSERT INTO `kios_recap_keperluan` (`id`, `nama`) VALUES
(1, 'Aerial'),
(2, 'Beli'),
(3, 'Jual'),
(4, 'Repair'),
(5, 'Technical Support');

-- --------------------------------------------------------

--
-- Table structure for table `kios_recap_status`
--

CREATE TABLE `kios_recap_status` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_recap_status`
--

INSERT INTO `kios_recap_status` (`id`, `nama`) VALUES
(1, 'Belum Deal'),
(2, 'Closing'),
(3, 'Deal'),
(4, 'Follow Up'),
(5, 'Lanjur Repair'),
(6, 'Pre Order'),
(7, 'Produk Kosong'),
(8, 'Tidak Deal'),
(9, 'Transaksi Kosong');

-- --------------------------------------------------------

--
-- Table structure for table `kios_status_komplain`
--

CREATE TABLE `kios_status_komplain` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_status_komplain`
--

INSERT INTO `kios_status_komplain` (`id`, `nama`) VALUES
(1, 'Refund Transfer'),
(2, 'Refund Deposit'),
(3, 'Pengiriman Balik');

-- --------------------------------------------------------

--
-- Table structure for table `kios_supplier_komplain`
--

CREATE TABLE `kios_supplier_komplain` (
  `id` int(11) NOT NULL,
  `validasi_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `bank_transfer` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_supplier_komplain`
--

INSERT INTO `kios_supplier_komplain` (`id`, `validasi_id`, `quantity`, `keterangan`, `bank_transfer`, `status`, `created_at`, `updated_at`) VALUES
(7, 13, 3, '', NULL, 'Refund Deposit', '2024-01-06 02:11:24', '2024-01-09 01:33:22'),
(8, 17, 2, NULL, NULL, 'Kurang', '2024-03-19 23:27:32', '2024-03-19 23:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `kios_transaksi`
--

CREATE TABLE `kios_transaksi` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `ongkir` int(11) DEFAULT 0,
  `discount` int(11) DEFAULT 0,
  `tax` int(11) DEFAULT 0,
  `total_harga` int(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_transaksi`
--

INSERT INTO `kios_transaksi` (`id`, `employee_id`, `customer_id`, `metode_pembayaran`, `ongkir`, `discount`, `tax`, `total_harga`, `created_at`, `updated_at`) VALUES
(3, 3, 9, '1', NULL, 6999, 957000, 8699999, '2024-03-15 01:08:19', '2024-03-15 01:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `kios_transaksi_detail`
--

CREATE TABLE `kios_transaksi_detail` (
  `id` int(11) NOT NULL,
  `kios_transaksi_id` int(11) NOT NULL,
  `jenis_transaksi` varchar(20) NOT NULL,
  `kios_produk_id` int(11) NOT NULL,
  `serial_number_id` int(11) NOT NULL,
  `harga_jual` int(20) NOT NULL,
  `harga_promo` int(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kios_transaksi_detail`
--

INSERT INTO `kios_transaksi_detail` (`id`, `kios_transaksi_id`, `jenis_transaksi`, `kios_produk_id`, `serial_number_id`, `harga_jual`, `harga_promo`, `created_at`, `updated_at`) VALUES
(3, 3, 'Baru', 11, 1, 6000000, 5999999, '2024-03-15 01:08:19', '2024-03-15 01:08:19'),
(4, 3, 'Baru', 12, 26, 2700000, 0, '2024-03-15 01:08:19', '2024-03-15 01:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran_supplier`
--

CREATE TABLE `metode_pembayaran_supplier` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `media_pembayaran` varchar(20) NOT NULL,
  `no_rek` varchar(30) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_pembayaran_supplier`
--

INSERT INTO `metode_pembayaran_supplier` (`id`, `supplier_id`, `media_pembayaran`, `no_rek`, `nama_akun`, `created_at`, `updated_at`) VALUES
(1, 1, 'BCA', '0888562154834', 'Daniel', '2023-12-22 00:47:51', '2023-12-22 00:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembelian_second`
--

CREATE TABLE `metode_pembelian_second` (
  `id` int(11) NOT NULL,
  `metode_pembelian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_pembelian_second`
--

INSERT INTO `metode_pembelian_second` (`id`, `metode_pembelian`) VALUES
(1, 'Offline'),
(3, 'Online Direct Transfer'),
(4, 'Online DP'),
(5, 'Online Pending Payment'),
(6, 'Shopee'),
(7, 'Tokopedia');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `supplier_kios_id` int(11) NOT NULL,
  `link_drive` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `supplier_kios_id`, `link_drive`, `status`, `created_at`, `updated_at`) VALUES
(9, 1, 'https://drive.google.com/drive/folders/1DOgErgV1spUrQ4hSO9fFXBedeQlRg1PU?usp=sharing', 'Tervalidasi', '2023-12-20 01:23:58', '2023-12-20 20:00:11'),
(20, 1, 'https://drive.google.com/drive/folders/1B0fKu_XmsbZScec8W2O9mOgEuRv17RWP?usp=sharing', 'InRD', '2023-12-26 21:14:30', '2024-03-19 23:27:32'),
(22, 1, 'https://drive.google.com/drive/folders/10dRbq34fvaT9S2G-DYwW4ltjgBrH8eit?usp=sharing', 'InRD', '2024-02-17 01:22:48', '2024-03-18 01:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `nilai` int(11) DEFAULT 0,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `sub_jenis_id`, `quantity`, `nilai`, `status`, `created_at`, `updated_at`) VALUES
(13, 9, 11, 4, 2666000, 'Done', '2023-12-20 01:24:05', '2024-01-05 21:00:49'),
(14, 9, 12, 3, 2000000, 'Done', '2023-12-20 01:24:05', '2024-01-09 01:33:22'),
(17, 20, 11, 5, 3000000, 'Kurang', '2023-12-26 21:14:38', '2024-03-19 23:27:32'),
(18, 20, 12, 6, 2000000, 'Done', '2023-12-26 21:14:38', '2024-03-19 23:27:04'),
(19, 22, 11, 4, 19300000, 'Done', '2024-02-17 01:22:56', '2024-03-18 01:39:52'),
(21, 22, 13, 6, 4200000, 'Done', '2024-03-15 23:56:27', '2024-03-18 01:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_second`
--

CREATE TABLE `order_second` (
  `id` int(11) NOT NULL,
  `come_from` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `asal_id` int(11) NOT NULL,
  `metode_pembelian_id` int(11) NOT NULL,
  `sub_jenis_id` int(11) NOT NULL,
  `status_pembayaran` varchar(50) NOT NULL,
  `biaya_pembelian` int(20) NOT NULL DEFAULT 0,
  `biaya_ongkir` int(11) DEFAULT 0,
  `tanggal_pembelian` varchar(20) NOT NULL,
  `link_drive` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_second`
--

INSERT INTO `order_second` (`id`, `come_from`, `customer_id`, `asal_id`, `metode_pembelian_id`, `sub_jenis_id`, `status_pembayaran`, `biaya_pembelian`, `biaya_ongkir`, `tanggal_pembelian`, `link_drive`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Customer', 9, 5, 1, 12, 'Paid', 6666000, 0, '15-01-2024', '', 'InRD', '2024-01-15 20:00:36', '2024-03-06 20:38:44'),
(23, 'Hunting', 12, 1, 3, 13, 'Unpaid', 4300000, 0, '03/23/2024', 'https://drive.google.com/drive/folders/1nOHO9Mr7Y7rIaCP3OXdtA4twaNndoa5C?usp=sharing', 'Waiting For Payment', '2024-03-22 21:09:12', '2024-03-22 21:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `serial_number`
--

CREATE TABLE `serial_number` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `validasi_id` int(11) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serial_number`
--

INSERT INTO `serial_number` (`id`, `produk_id`, `validasi_id`, `serial_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'sn1', 'Sold', '2024-01-05 21:00:48', '2024-03-15 01:08:19'),
(2, 1, 3, 'sn2', 'Ready', '2024-01-05 21:00:48', '2024-01-05 21:00:48'),
(3, 1, 3, 'sn3', 'Ready', '2024-01-05 21:00:48', '2024-01-31 19:32:22'),
(4, 1, 3, 'sn4', 'Ready', '2024-01-05 21:00:49', '2024-01-05 21:00:49'),
(5, 1, 3, 'sn5', 'Ready', '2024-01-05 21:00:49', '2024-01-05 21:00:49'),
(6, 1, 3, 'sn6', 'Ready', '2024-01-05 21:00:49', '2024-01-05 21:00:49'),
(25, 8, 13, 'SN666', 'Ready', '2024-01-06 02:11:24', '2024-01-06 02:11:24'),
(26, 8, 13, 'DS666', 'Sold', '2024-01-06 02:11:24', '2024-03-15 01:08:19'),
(27, 8, 13, 'KD666', 'Ready', '2024-01-06 02:11:24', '2024-01-06 02:11:24'),
(28, 1, 14, '1581F67QC23B3014K72T', 'Ready', '2024-03-18 01:39:52', '2024-03-18 01:39:52'),
(29, 1, 14, '1581F6Z9C23B1003E98F', 'Ready', '2024-03-18 01:39:52', '2024-03-18 01:39:52'),
(30, 1, 14, '1581F6Z9C23A7003A1KE', 'Ready', '2024-03-18 01:39:52', '2024-03-18 01:39:52'),
(31, 1, 14, '1581F5YHX235Q0021PWN', 'Ready', '2024-03-18 01:39:52', '2024-03-18 01:39:52'),
(32, 9, 15, '3YTBKCA004020V', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(33, 9, 15, '3YTBKCF00404FQ', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(34, 9, 15, '3YTBKCF00403DK', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(35, 9, 15, '1581F6N8C237S0032G5E', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(36, 9, 15, '1581F6Z9C239P00395BV', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(37, 9, 15, '11UDH13R700382', 'Ready', '2024-03-18 01:41:00', '2024-03-18 01:41:00'),
(38, 8, 16, '1581F5YHX23BT0027C8M', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(39, 8, 16, '1581F6Z9C23C1003HT0Q', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(40, 8, 16, '1581F6Z9C23B1003EC11', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(41, 8, 16, '1581F5YHX23A40024GX3', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(42, 8, 16, '1581F5YHX23A40024GU6', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(43, 8, 16, '1581F6N8C239J0034GEM', 'Ready', '2024-03-19 23:27:04', '2024-03-19 23:27:04'),
(44, 1, 17, '3YTBKCF00403VV', 'Ready', '2024-03-19 23:27:32', '2024-03-19 23:27:32'),
(45, 1, 17, '3YTBKCF00403N5', 'Ready', '2024-03-19 23:27:32', '2024-03-19 23:27:32'),
(46, 1, 17, '3YTBKCA004020V', 'Ready', '2024-03-19 23:27:32', '2024-03-19 23:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `status_pembayaran`
--

CREATE TABLE `status_pembayaran` (
  `id` int(11) NOT NULL,
  `status_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pembayaran`
--

INSERT INTO `status_pembayaran` (`id`, `status_pembayaran`) VALUES
(1, 'DP'),
(2, 'Paid'),
(3, 'Unpaid'),
(4, 'Refund');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_kios`
--

CREATE TABLE `supplier_kios` (
  `id` int(11) NOT NULL,
  `pic_name` varchar(100) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `npwp` varchar(100) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  `alamat_lengkap` varchar(255) NOT NULL,
  `deposit` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_kios`
--

INSERT INTO `supplier_kios` (`id`, `pic_name`, `nama_perusahaan`, `npwp`, `no_telpon`, `alamat_lengkap`, `deposit`, `created_at`, `updated_at`) VALUES
(1, 'Daniel', 'Rumah Drone', 'ini npwp', '6285156519066', 'ini alamat', '6000000', '2023-12-11 20:52:52', '2024-01-09 01:33:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_recap`
--
ALTER TABLE `daily_recap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_order`
--
ALTER TABLE `history_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_akun_rd`
--
ALTER TABLE `kios_akun_rd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_image_paket_baru`
--
ALTER TABLE `kios_image_paket_baru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_image_paket_second`
--
ALTER TABLE `kios_image_paket_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_komplain_second`
--
ALTER TABLE `kios_komplain_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_marketplace`
--
ALTER TABLE `kios_marketplace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_metode_pembayaran_second`
--
ALTER TABLE `kios_metode_pembayaran_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_payment`
--
ALTER TABLE `kios_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_produk`
--
ALTER TABLE `kios_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_produk_second`
--
ALTER TABLE `kios_produk_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_qc_produk_second`
--
ALTER TABLE `kios_qc_produk_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_recap_keperluan`
--
ALTER TABLE `kios_recap_keperluan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_recap_status`
--
ALTER TABLE `kios_recap_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_status_komplain`
--
ALTER TABLE `kios_status_komplain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_supplier_komplain`
--
ALTER TABLE `kios_supplier_komplain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_transaksi`
--
ALTER TABLE `kios_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kios_transaksi_detail`
--
ALTER TABLE `kios_transaksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_pembayaran_supplier`
--
ALTER TABLE `metode_pembayaran_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_pembelian_second`
--
ALTER TABLE `metode_pembelian_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_second`
--
ALTER TABLE `order_second`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `serial_number`
--
ALTER TABLE `serial_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_pembayaran`
--
ALTER TABLE `status_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_kios`
--
ALTER TABLE `supplier_kios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_recap`
--
ALTER TABLE `daily_recap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history_order`
--
ALTER TABLE `history_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `kios_akun_rd`
--
ALTER TABLE `kios_akun_rd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kios_image_paket_baru`
--
ALTER TABLE `kios_image_paket_baru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kios_image_paket_second`
--
ALTER TABLE `kios_image_paket_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kios_komplain_second`
--
ALTER TABLE `kios_komplain_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kios_marketplace`
--
ALTER TABLE `kios_marketplace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kios_metode_pembayaran_second`
--
ALTER TABLE `kios_metode_pembayaran_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kios_payment`
--
ALTER TABLE `kios_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kios_produk`
--
ALTER TABLE `kios_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kios_produk_second`
--
ALTER TABLE `kios_produk_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kios_qc_produk_second`
--
ALTER TABLE `kios_qc_produk_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kios_recap_keperluan`
--
ALTER TABLE `kios_recap_keperluan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kios_recap_status`
--
ALTER TABLE `kios_recap_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kios_status_komplain`
--
ALTER TABLE `kios_status_komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kios_supplier_komplain`
--
ALTER TABLE `kios_supplier_komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kios_transaksi`
--
ALTER TABLE `kios_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kios_transaksi_detail`
--
ALTER TABLE `kios_transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `metode_pembayaran_supplier`
--
ALTER TABLE `metode_pembayaran_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `metode_pembelian_second`
--
ALTER TABLE `metode_pembelian_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_second`
--
ALTER TABLE `order_second`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `serial_number`
--
ALTER TABLE `serial_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `status_pembayaran`
--
ALTER TABLE `status_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier_kios`
--
ALTER TABLE `supplier_kios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
