-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2018 at 09:24 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `softphone-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `dh_account`
--

CREATE TABLE `dh_account` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_salt` varchar(10) NOT NULL,
  `is_active` int(1) NOT NULL COMMENT '0=chưa active, 1=active',
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dh_account`
--

INSERT INTO `dh_account` (`id`, `phone`, `password`, `password_salt`, `is_active`, `created`) VALUES
(5, '841679361752', '45e6a4a86b4782ecdb3d7674693723f2', 'vvo8i2U7jL', 1, 1519373321);

-- --------------------------------------------------------

--
-- Table structure for table `dh_cache`
--

CREATE TABLE `dh_cache` (
  `id` int(11) NOT NULL,
  `cacheId` varchar(250) NOT NULL,
  `data` blob NOT NULL,
  `modified` int(11) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dh_account`
--
ALTER TABLE `dh_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dh_cache`
--
ALTER TABLE `dh_cache`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dh_account`
--
ALTER TABLE `dh_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dh_cache`
--
ALTER TABLE `dh_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
