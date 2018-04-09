-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2018 at 11:39 AM
-- Server version: 5.7.20
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `token` varchar(32) DEFAULT NULL,
  `is_active` int(1) NOT NULL COMMENT '0=chưa active, 1=active',
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `dh_phonebook`
--

CREATE TABLE `dh_phonebook` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `name` varchar(25) NOT NULL,
  `phone_owner` varchar(25) NOT NULL,
  `phone_owner_id` int(11) NOT NULL
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
-- Indexes for table `dh_phonebook`
--
ALTER TABLE `dh_phonebook`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dh_account`
--
ALTER TABLE `dh_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `dh_cache`
--
ALTER TABLE `dh_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT for table `dh_phonebook`
--
ALTER TABLE `dh_phonebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5574;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
