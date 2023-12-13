-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 04:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `akunlaundry`
--

CREATE TABLE `akunlaundry` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `namalayanan` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idpesanan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `namapelanggan` varchar(50) NOT NULL,
  `namalayanan` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `pembayaran` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `username` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `totalhari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akunlaundry`
--
ALTER TABLE `akunlaundry`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `layanan1` (`namalayanan`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idpesanan`),
  ADD KEY `username1` (`username`),
  ADD KEY `layanan` (`namalayanan`),
  ADD KEY `tanggal` (`tanggal`);

--
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD KEY `username2` (`username`),
  ADD KEY `tanggal` (`tanggal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `layanan`
--
ALTER TABLE `layanan`
  ADD CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `akunlaundry` (`username`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `layanan` FOREIGN KEY (`namalayanan`) REFERENCES `layanan` (`namalayanan`),
  ADD CONSTRAINT `username1` FOREIGN KEY (`username`) REFERENCES `akunlaundry` (`username`);

--
-- Constraints for table `profit`
--
ALTER TABLE `profit`
  ADD CONSTRAINT `tanggal` FOREIGN KEY (`tanggal`) REFERENCES `pesanan` (`tanggal`),
  ADD CONSTRAINT `username2` FOREIGN KEY (`username`) REFERENCES `akunlaundry` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
