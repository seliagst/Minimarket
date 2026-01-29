-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 07:17 AM
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
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `jumlah`, `gambar`) VALUES
(6, 'Apel Merah', 9000, '28012026095641_images_(4).jpg'),
(7, 'Jeruk', 800, '28012026114030_images_(5).jpg'),
(8, 'Kiwi', 680, '28012026114110_images_(6).jpg'),
(9, 'Anggur Muscat', 390, '28012026114202_images_(7).jpg'),
(10, 'Anggur Ungu', 560, '28012026114237_images_(8).jpg'),
(11, 'Semangka Merah', 876, '28012026114310_images_(9).jpg'),
(12, 'Semangka Kuning', 567, '28012026114359_Blog-Semangka-Kuning.jpg'),
(13, 'Melon', 780, '28012026114453_images_(10).jpg'),
(14, 'Alpukat', 670, '28012026114506_istockphoto-1482149278-612x612.jpg'),
(15, 'Buah Naga', 800, '28012026114645_images_(11).jpg'),
(16, 'Salak', 1290, '28012026114740_image.jpg'),
(17, 'Rambutan', 12098, '28012026114806_manfaat-buah-rambutan-2_169.jpeg'),
(18, 'Mangga', 170, '28012026114904_images_(12).jpg'),
(19, 'Manggis', 780, '28012026114918_images_(13).jpg'),
(20, 'Cimory Bites Strw', 90, '28012026115023_CimoryYogurtBitesStrawberry120gr_e99343c1-0fd5-4b36-bdf0-edda252b9f76_900x900.jpg'),
(21, 'Cimory Salted Caramel', 89, '28012026115110_images_(14).jpg'),
(22, 'Cimory Squezee', 87, '28012026115143_CimoryYogurtSqueezeMangoStickyRiceYoghurt1_6fa524e6-bb5f-444e-b983-fbf31056ddc8_900x900.png'),
(23, 'FF Strw', 87, '28012026115236_ProductFrisianflaguhtstrawberry2.webp'),
(24, 'FF Coconut', 76, '28012026115305_images_(15).jpg'),
(25, 'FF Kental Manis', 650, '28012026115339_1_A13300001631_20250505132032954_base.jpg'),
(26, 'Tepung Segitiga Biru', 87, '28012026115428_images_(16).jpg'),
(27, 'Sasa Tepung', 56, '28012026115501_desiccated_coconut_31.png'),
(28, 'Tepung Rose Brand', 2, '28012026115533_images_(17).jpg'),
(29, 'Bimoli MG', 4, '28012026115608_1_A09350001879_20211001113946725_base.jpg'),
(30, 'Rose Brand MG', 12, '28012026115657_images_(18).jpg'),
(31, 'Sania MG', 1, '28012026115715_Minyak-sania-1-liter-pouch.webp'),
(32, 'Fortune MG', 40, '28012026115732_e598bcfb-c5bf-413c-8084-a89ce6e83fed.jpg'),
(33, 'FresTea', 98, '28012026115835_images_(19).jpg'),
(34, 'Hydro Coco', 0, '28012026115918_5def8b5d-3f05-4ab4-9b6d-e5b950340e9c.jpg'),
(35, 'Fruit Tea', 98, '28012026115932_images_(20).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama_karyawan`, `nomor_telepon`, `alamat`, `username`, `password`, `role`) VALUES
(1, 'admin', '986554', 'Jakarta', 'admin', 'admin', 'admin'),
(8, 'Seli', '09985', 'Pati', 'seli8', 'seli76', 'karyawan'),
(9, 'agustusin', '098774', 'Kartasura, Sukoharjo, SUrakarta, Jateng, Indo', 'ags', 'agsss', 'karyawan'),
(10, 'Ahmad Muhammad', '07653443', 'Semarang, Jawa Tengah, Indonesia', 'admin2', 'admin2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
