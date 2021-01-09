-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2021 at 03:22 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ProjekTAKripto`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_file`
--

CREATE TABLE `tb_file` (
  `id_file` int(11) NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `kunci_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_file`
--

INSERT INTO `tb_file` (`id_file`, `nama_file`, `id_pengguna`, `kunci_file`) VALUES
(1, 'Modul_Retrofit.pdf.enc', 1, '7033570533421419016687392023069077931062550426026607137848158159541205618368065762946213400803134788169101172095773485656244324581420827252406933549598493');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kunci_rsa`
--

CREATE TABLE `tb_kunci_rsa` (
  `id_kunci` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `kunci_public` text NOT NULL,
  `kunci_modulus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kunci_rsa`
--

INSERT INTO `tb_kunci_rsa` (`id_kunci`, `id_pengguna`, `kunci_public`, `kunci_modulus`) VALUES
(1, 1, '11002847122832298423137687686728580449219856589664764449187379365852960019392730392007129661757702788212711133989909420267409329178491666941226139094389817', '10049804308749180279325659417872893204045972107259956955533037575144946665597116321228995396226532049919632540741144005477123254004594181070045394249241537');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `email_pengguna` varchar(100) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `password_pengguna` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `email_pengguna`, `nama_pengguna`, `password_pengguna`) VALUES
(1, 'aldi@gmail.com', 'aldi', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_file`
--
ALTER TABLE `tb_file`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_kunci_rsa`
--
ALTER TABLE `tb_kunci_rsa`
  ADD PRIMARY KEY (`id_kunci`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email_pengguna` (`email_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_file`
--
ALTER TABLE `tb_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kunci_rsa`
--
ALTER TABLE `tb_kunci_rsa`
  MODIFY `id_kunci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_file`
--
ALTER TABLE `tb_file`
  ADD CONSTRAINT `tb_file_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kunci_rsa`
--
ALTER TABLE `tb_kunci_rsa`
  ADD CONSTRAINT `tb_kunci_rsa_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
