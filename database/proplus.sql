-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2023 at 04:34 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `backset`
--

CREATE TABLE `backset` (
  `url` varchar(100) NOT NULL,
  `sessiontime` varchar(4) DEFAULT NULL,
  `footer` varchar(50) DEFAULT NULL,
  `themesback` varchar(2) DEFAULT NULL,
  `responsive` varchar(2) DEFAULT NULL,
  `namabisnis1` tinytext NOT NULL,
  `tipenota` int(1) NOT NULL,
  `l153n53` int(11) NOT NULL,
  `loginbg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backset`
--

INSERT INTO `backset` (`url`, `sessiontime`, `footer`, `themesback`, `responsive`, `namabisnis1`, `tipenota`, `l153n53`, `loginbg`) VALUES
('http://localhost/indotory', '1000', 'admin', '1', '0', 'Indotory Pro Plus', 4, 2, 'page/images/pos.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `no` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `sku` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT 'NULL',
  `brand` text NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `hargabeli` int(10) NOT NULL,
  `hargajual` int(11) NOT NULL,
  `terjual` int(11) NOT NULL,
  `terbeli` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `retur` int(10) NOT NULL,
  `stokmin` int(10) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `expired` date NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `lokasi` varchar(20) NOT NULL,
  `keterangan` varchar(200) DEFAULT 'NULL',
  `supplier` text NOT NULL,
  `avatar` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`no`, `kode`, `sku`, `nama`, `kategori`, `brand`, `barcode`, `hargabeli`, `hargajual`, `terjual`, `terbeli`, `sisa`, `retur`, `stokmin`, `ukuran`, `warna`, `expired`, `satuan`, `lokasi`, `keterangan`, `supplier`, `avatar`) VALUES
(1, '000001', 'SKU01', 'Dell 6510 Core i7 / NVIDIA/hdd 320/4gb', 'LAPTOP', 'DELL', 'IDWARE01', 3133900, 3750000, 0, 0, 2, 0, 1, 'L', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Dell', 'dist/upload/index.jpg'),
(2, '000002', 'SKU02', 'HP8440p corei5 m520/hdd320/ram4', 'LAPTOP', 'HP', 'IDWARE02', 2748900, 3250000, 0, 0, 3, 0, 2, 'M', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Dell,HP', 'dist/upload/index.jpg'),
(3, '000003', 'SKU03', 'HP core i5 m520/4gb/320gb (dikirim HP8440 JUGA)', 'LAPTOP', 'HP', 'IDWARE03', 2748900, 3250000, 0, 0, 4, 0, 3, 'S', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(4, '000004', 'SKU04', 'HARDDISK EXTERNAL 500Gb SEAGATE', 'DISK', 'SEAGATE', 'IDWARE04', 533000, 635000, 0, 0, 5, 0, 4, 'L', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Seagate', 'dist/upload/index.jpg'),
(5, '000005', 'SKU05', 'HARDDISK EXTERNAL 1TB SEAGATE', 'DISK', 'SEAGATE', 'IDWARE05', 828100, 850000, 0, 0, 6, 0, 5, 'M', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Seagate', 'dist/upload/index.jpg'),
(6, '000006', 'SKU06', 'MOUSE LOGITECH B100', 'AKSESORIS', 'LOGITECH', 'IDWARE06', 100000, 125000, 0, 0, 7, 0, 6, 'S', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(7, '000007', 'SKU07', 'KABEL HDMI 3 METER', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE07', 44000, 85000, 0, 0, 8, 0, 7, 'L', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(8, '000008', 'SKU08', 'Monitor Varro 19 Inch', 'MONITOR', 'VARRO', 'IDWARE08', 923000, 990000, 0, 0, 9, 0, 8, 'M', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Varro', 'dist/upload/index.jpg'),
(9, '000009', 'SKU09', 'Kabel Hdmi 1.5m', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE09', 14000, 35000, 0, 0, 10, 0, 9, 'S', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(10, '000010', 'SKU10', 'Adaptor 2a 12v For DVR Dan CCTV', 'LISTRIK', 'UNIVERSAL', 'IDWARE10', 29500, 50000, 0, 0, 11, 0, 10, 'L', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Broco,advan', 'dist/upload/index.jpg'),
(11, '000011', 'SKU11', 'Power Supply Jaring CCTV 12v/10a', 'LISTRIK', 'UNIVERSAL', 'IDWARE11', 104000, 150000, 0, 0, 12, 0, 11, 'M', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(12, '000012', 'SKU12', 'Cctv Cabang 4', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE12', 10000, 3000, 0, 0, 13, 0, 12, 'S', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(13, '000013', 'SKU13', 'Poe Kabel Splitter Injector SET', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE13', 23000, 50000, 0, 0, 14, 0, 13, 'L', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(14, '000014', 'SKU14', 'Jack Bnc Cctv', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE14', 4500, 5000, 0, 0, 15, 0, 14, 'M', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(15, '000015', 'SKU15', 'Jack Bnc Cctv TAIWAN', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE15', 5700, 5000, 0, 0, 16, 0, 15, 'S', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(16, '000016', 'SKU16', 'Conector Sambungan Untuk Cctv BNC', 'KABEL KONEKTOR', 'UNIVERSAL', 'IDWARE16', 9000, 10000, 0, 0, 17, 0, 16, 'L', 'hijau', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', '', 'dist/upload/index.jpg'),
(17, '000017', 'SKU17', 'Lampu Bardi 9W', 'SMARTHOME', 'BARDI', 'IDWARE17', 142500, 185000, 0, 0, 18, 0, 17, 'M', 'merah', '0000-00-00', 'pcs', 'AAB2', 'Laci AA', 'Bardi', 'dist/upload/index.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang_setting`
--

CREATE TABLE `barang_setting` (
  `view_sku` int(1) NOT NULL,
  `view_nama` int(1) NOT NULL,
  `view_hbeli` int(1) NOT NULL,
  `view_hjual` int(1) NOT NULL,
  `view_stok` int(1) NOT NULL,
  `view_terjual` int(1) NOT NULL,
  `view_kategori` int(1) NOT NULL,
  `view_lokasi` int(1) NOT NULL,
  `view_warna` int(1) NOT NULL,
  `view_ukuran` int(1) NOT NULL,
  `view_merek` int(1) NOT NULL,
  `view_expired` int(1) NOT NULL,
  `view_satuan` int(1) NOT NULL,
  `kode` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_setting`
--

INSERT INTO `barang_setting` (`view_sku`, `view_nama`, `view_hbeli`, `view_hjual`, `view_stok`, `view_terjual`, `view_kategori`, `view_lokasi`, `view_warna`, `view_ukuran`, `view_merek`, `view_expired`, `view_satuan`, `kode`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 99);

-- --------------------------------------------------------

--
-- Table structure for table `barang_setting_barcode`
--

CREATE TABLE `barang_setting_barcode` (
  `label_atas` int(1) NOT NULL,
  `label_bawah` int(1) NOT NULL,
  `jml_kolom` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_setting_barcode`
--

INSERT INTO `barang_setting_barcode` (`label_atas`, `label_bawah`, `jml_kolom`) VALUES
(1, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `bayar`
--

CREATE TABLE `bayar` (
  `nota` varchar(20) NOT NULL,
  `tglbayar` date DEFAULT NULL,
  `jam` varchar(10) NOT NULL,
  `bayar` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `kembali` int(11) DEFAULT NULL,
  `keluar` int(11) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `persendiskon` int(2) NOT NULL,
  `diskon` int(10) NOT NULL,
  `persenpajak` int(2) NOT NULL,
  `pajak` int(10) NOT NULL,
  `biaya` int(10) NOT NULL,
  `no` int(11) NOT NULL,
  `tipebayar` varchar(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `nota` varchar(20) NOT NULL,
  `tglbeli` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `supplier` varchar(20) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE `buy` (
  `nota` varchar(20) NOT NULL,
  `nopo` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `tglsale` date DEFAULT NULL,
  `biaya` int(10) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `sudahbayar` int(11) NOT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `diterima` varchar(50) NOT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buy_hutang`
--

CREATE TABLE `buy_hutang` (
  `nota` varchar(10) NOT NULL,
  `faktur` varchar(20) NOT NULL,
  `kreditur` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `due` date NOT NULL,
  `hutang` int(10) NOT NULL,
  `sudahbayar` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buy_payment`
--

CREATE TABLE `buy_payment` (
  `kode` varchar(10) NOT NULL,
  `nota` varchar(10) NOT NULL,
  `kreditur` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(10) NOT NULL,
  `metode` varchar(20) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chmenu`
--

CREATE TABLE `chmenu` (
  `userjabatan` varchar(20) NOT NULL,
  `menu1` varchar(1) DEFAULT '0',
  `menu2` varchar(1) DEFAULT '0',
  `menu3` varchar(1) DEFAULT '0',
  `menu4` varchar(1) DEFAULT '0',
  `menu5` varchar(1) DEFAULT '0',
  `menu6` varchar(1) DEFAULT '0',
  `menu7` varchar(1) DEFAULT '0',
  `menu8` varchar(1) DEFAULT '0',
  `menu9` varchar(1) DEFAULT '0',
  `menu10` varchar(1) DEFAULT '0',
  `menu11` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chmenu`
--

INSERT INTO `chmenu` (`userjabatan`, `menu1`, `menu2`, `menu3`, `menu4`, `menu5`, `menu6`, `menu7`, `menu8`, `menu9`, `menu10`, `menu11`) VALUES
('admin', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5'),
('coba-coba', '0', '3', '0', '0', '0', '0', '0', '0', '0', '0', ''),
('Kasir', '0', '4', '2', '1', '0', '0', '2', '1', '0', '0', ''),
('User', '', '', '', '1', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `nama` varchar(100) DEFAULT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `pajakppn` int(2) NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`nama`, `tagline`, `alamat`, `notelp`, `signature`, `pajakppn`, `avatar`, `no`) VALUES
('PLAZA ATK', 'Belanja untuk Belajar', 'Jl PEMANDIAN TIMUR KM 7 SUROTRUNAN ALIAN KEBUMEN', '08112808287', 'Terima Kasih sudah Belanja di Plaza ATK\r\nSelamat Belajar', 0, 'dist/upload/logo.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dataretur`
--

CREATE TABLE `dataretur` (
  `nota` varchar(10) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` int(10) NOT NULL,
  `hargaakhir` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `nama` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`nama`, `avatar`, `tanggal`, `isi`, `id`) VALUES
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1),
('Fatur', 'dist/upload/png-transparent-graphic-logo-line-pertamina-text-area.png', '2023-04-08', '<h1>TESooo</h1>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoicebeli`
--

CREATE TABLE `invoicebeli` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `terima` int(10) NOT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoicejual`
--

CREATE TABLE `invoicejual` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `diskon_persen` int(2) NOT NULL,
  `diskon_harga` int(10) NOT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `retur` varchar(3) NOT NULL,
  `harga_asli` int(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoicejual_old`
--

CREATE TABLE `invoicejual_old` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `modal` int(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode`, `nama`, `no`) VALUES
('0001', 'admin', 28),
('0004', 'Kasir', 39),
('0005', 'ADMIN 1', 40);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `namauser` varchar(50) NOT NULL,
  `tgl` date NOT NULL,
  `jam` varchar(10) NOT NULL,
  `kodebarang` varchar(10) NOT NULL,
  `sisa` int(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `no` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operasional`
--

CREATE TABLE `operasional` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kasir` varchar(20) DEFAULT NULL,
  `tipe` varchar(30) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operasional_tipe`
--

CREATE TABLE `operasional_tipe` (
  `Kode` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operasional_tipe`
--

INSERT INTO `operasional_tipe` (`Kode`, `nama`, `no`) VALUES
('0002', 'Listrik', 4),
('0003', 'Sewa Bangunan', 5),
('0004', 'Pajak', 6),
('0005', 'Operasional Toko', 7),
('0007', 'Rumah Tangga', 9),
('0008', 'Pajak Kebesihan', 10),
('0009', 'Kurir Ekpedisi', 11),
('0010', 'Gaji', 12);

-- --------------------------------------------------------

--
-- Table structure for table `operasional_view`
--

CREATE TABLE `operasional_view` (
  `kode_view` int(1) NOT NULL,
  `nama_view` int(1) NOT NULL,
  `tipe_view` int(1) NOT NULL,
  `tgl_view` int(1) NOT NULL,
  `biaya_view` int(1) NOT NULL,
  `ket_view` int(1) NOT NULL,
  `opsi_view` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operasional_view`
--

INSERT INTO `operasional_view` (`kode_view`, `nama_view`, `tipe_view`, `tgl_view`, `biaya_view`, `ket_view`, `opsi_view`) VALUES
(0, 0, 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `nama` varchar(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`nama`, `tipe`, `no`) VALUES
('BCA', 'bank', 2),
('BRI', 'bank', 3),
('MANDIRI', 'bank', 4),
('Transfer', 'pay', 6),
('Hutang', 'pay', 7),
('Non Tunai', 'pay', 8);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `tipe` int(1) NOT NULL,
  `nota` varchar(10) NOT NULL,
  `cara` varchar(20) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `payday` date NOT NULL,
  `no` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kode` varchar(20) NOT NULL,
  `tgldaftar` date DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(70) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `idpelanggan` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pin`
--

CREATE TABLE `pin` (
  `pin` varchar(255) NOT NULL,
  `ubah` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pin`
--

INSERT INTO `pin` (`pin`, `ubah`) VALUES
('10470c3b4b1fed12c3baac014be15fac67c6e815', 2);

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `nota` varchar(10) NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `tgl` date NOT NULL,
  `due` date NOT NULL,
  `pelanggan` varchar(10) NOT NULL,
  `modal` int(10) NOT NULL,
  `total` int(10) NOT NULL,
  `diskon` int(10) NOT NULL,
  `potongan` int(10) NOT NULL,
  `biayatambahan` int(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `oleh` varchar(50) NOT NULL,
  `notainvoice` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_list`
--

CREATE TABLE `quotation_list` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `modal` int(10) NOT NULL,
  `conv` int(1) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `kode` varchar(10) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`kode`, `bank`, `norek`, `nama`, `no`) VALUES
('0002', 'Mandiri', '90000000', 'devita', 4);

-- --------------------------------------------------------

--
-- Table structure for table `retur`
--

CREATE TABLE `retur` (
  `nota` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `dana` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `petugas` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `nota` varchar(20) NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `tglsale` date DEFAULT NULL,
  `duedate` date NOT NULL,
  `subtotal` int(10) DEFAULT NULL,
  `diskon_persen` int(2) NOT NULL,
  `diskon` int(10) NOT NULL,
  `pajak_persen` int(2) NOT NULL,
  `pajak` int(10) NOT NULL,
  `biaya_nama` varchar(30) NOT NULL,
  `biaya` int(10) NOT NULL,
  `total` int(10) NOT NULL,
  `modalbeli` int(10) NOT NULL,
  `pelanggan` varchar(200) DEFAULT NULL,
  `kasir` varchar(100) DEFAULT NULL,
  `salesman` varchar(10) NOT NULL,
  `sales_komisi` int(10) NOT NULL,
  `sudahbayar` int(10) NOT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `status` varchar(11) NOT NULL,
  `diterima` varchar(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payment`
--

CREATE TABLE `sale_payment` (
  `kode` varchar(10) NOT NULL,
  `nota` varchar(10) NOT NULL,
  `pelanggan` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(10) NOT NULL,
  `metode` varchar(20) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stokretur`
--

CREATE TABLE `stokretur` (
  `kode` varchar(100) NOT NULL,
  `stok` int(7) NOT NULL,
  `no` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `nota` varchar(10) NOT NULL,
  `cabang` varchar(2) NOT NULL,
  `tgl` date NOT NULL,
  `pelanggan` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar_daftar`
--

CREATE TABLE `stok_keluar_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `nota` varchar(10) NOT NULL,
  `cabang` varchar(2) NOT NULL,
  `tgl` date NOT NULL,
  `supplier` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk_daftar`
--

CREATE TABLE `stok_masuk_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_sesuai`
--

CREATE TABLE `stok_sesuai` (
  `nota` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `oleh` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_sesuai_daftar`
--

CREATE TABLE `stok_sesuai_daftar` (
  `nota` varchar(10) NOT NULL,
  `kode_brg` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `sebelum` int(10) NOT NULL,
  `sesudah` int(10) NOT NULL,
  `selisih` int(10) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kode` varchar(20) NOT NULL,
  `tgldaftar` date DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(70) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `nota` varchar(10) NOT NULL,
  `nosurat` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_pelanggan` varchar(10) NOT NULL,
  `tujuan` varchar(30) NOT NULL,
  `notelp` varchar(20) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `driver` varchar(20) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `oleh` varchar(50) NOT NULL,
  `no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksibeli`
--

CREATE TABLE `transaksibeli` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hargaakhir` int(11) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksimasuk`
--

CREATE TABLE `transaksimasuk` (
  `nota` varchar(20) NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `diskon_persen` int(2) NOT NULL,
  `diskon_harga` int(10) NOT NULL,
  `hargabeli` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `retur` varchar(3) NOT NULL,
  `harga_asli` int(10) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userna_me` varchar(20) NOT NULL,
  `pa_ssword` varchar(70) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `tglaktif` date DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userna_me`, `pa_ssword`, `nama`, `alamat`, `nohp`, `tgllahir`, `tglaktif`, `jabatan`, `avatar`, `no`) VALUES
('admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin', 'alamat', '111', '2020-02-02', '2020-02-02', 'admin', 'dist/upload/avatar.png', 57);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backset`
--
ALTER TABLE `backset`
  ADD PRIMARY KEY (`url`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `jenis` (`kategori`);

--
-- Indexes for table `barang_setting`
--
ALTER TABLE `barang_setting`
  ADD PRIMARY KEY (`view_sku`);

--
-- Indexes for table `barang_setting_barcode`
--
ALTER TABLE `barang_setting_barcode`
  ADD PRIMARY KEY (`label_atas`);

--
-- Indexes for table `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indexes for table `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `buy_hutang`
--
ALTER TABLE `buy_hutang`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `buy_payment`
--
ALTER TABLE `buy_payment`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `chmenu`
--
ALTER TABLE `chmenu`
  ADD PRIMARY KEY (`userjabatan`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `dataretur`
--
ALTER TABLE `dataretur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD KEY `id` (`id`);

--
-- Indexes for table `invoicebeli`
--
ALTER TABLE `invoicebeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `invoicejual`
--
ALTER TABLE `invoicejual`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `invoicejual_old`
--
ALTER TABLE `invoicejual_old`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no4` (`no`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `operasional`
--
ALTER TABLE `operasional`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `operasional_view`
--
ALTER TABLE `operasional_view`
  ADD PRIMARY KEY (`kode_view`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indexes for table `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`ubah`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `quotation_list`
--
ALTER TABLE `quotation_list`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`nota`),
  ADD KEY `no` (`no`);

--
-- Indexes for table `sale_payment`
--
ALTER TABLE `sale_payment`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stokretur`
--
ALTER TABLE `stokretur`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_sesuai`
--
ALTER TABLE `stok_sesuai`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `stok_sesuai_daftar`
--
ALTER TABLE `stok_sesuai_daftar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `no3` (`no`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `transaksibeli`
--
ALTER TABLE `transaksibeli`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `no` (`no`),
  ADD KEY `username` (`kode`),
  ADD KEY `kdbarang` (`harga`);

--
-- Indexes for table `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  ADD PRIMARY KEY (`nota`,`kode`),
  ADD KEY `barang` (`nama`),
  ADD KEY `no5_2` (`no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userna_me`),
  ADD KEY `no` (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bayar`
--
ALTER TABLE `bayar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beli`
--
ALTER TABLE `beli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy`
--
ALTER TABLE `buy`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_hutang`
--
ALTER TABLE `buy_hutang`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_payment`
--
ALTER TABLE `buy_payment`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dataretur`
--
ALTER TABLE `dataretur`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoicebeli`
--
ALTER TABLE `invoicebeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoicejual`
--
ALTER TABLE `invoicejual`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoicejual_old`
--
ALTER TABLE `invoicejual_old`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mutasi`
--
ALTER TABLE `mutasi`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operasional`
--
ALTER TABLE `operasional`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operasional_tipe`
--
ALTER TABLE `operasional_tipe`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_list`
--
ALTER TABLE `quotation_list`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `retur`
--
ALTER TABLE `retur`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payment`
--
ALTER TABLE `sale_payment`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stokretur`
--
ALTER TABLE `stokretur`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_keluar_daftar`
--
ALTER TABLE `stok_keluar_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_masuk_daftar`
--
ALTER TABLE `stok_masuk_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_sesuai`
--
ALTER TABLE `stok_sesuai`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_sesuai_daftar`
--
ALTER TABLE `stok_sesuai_daftar`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksibeli`
--
ALTER TABLE `transaksibeli`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
