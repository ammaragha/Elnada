-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2020 at 08:16 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elnada`
--

-- --------------------------------------------------------

--
-- Table structure for table `box`
--

CREATE TABLE `box` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `type` tinyint(4) NOT NULL,
  `price` double(10,5) NOT NULL,
  `cNumber` int(10) NOT NULL,
  `kiloPrice` double(10,5) NOT NULL,
  `wieght` double(10,5) NOT NULL,
  `remWieght` double(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--


--
-- Table structure for table `buy`
--

CREATE TABLE `buy` (
  `bID` int(11) NOT NULL,
  `boxID` int(11) NOT NULL,
  `number` int(10) NOT NULL,
  `wieght` double(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buy`
--



--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `totalPrice` double(10,5) NOT NULL,
  `date` DATE NOT NULL DEFAULT current_timestamp(),
  `time` TIME NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buyer`
--



--
-- Table structure for table `day`
--

CREATE TABLE `day` (
  `date` date NOT NULL DEFAULT current_timestamp(),
  `gain` double(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_2` (`date`,`type`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `buy`
--
ALTER TABLE `buy`
  ADD KEY `bID` (`bID`),
  ADD KEY `type` (`boxID`);

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`),
  ADD key `date` (`date`);

--
-- Indexes for table `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `box`
--
ALTER TABLE `box`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buy`
--
ALTER TABLE `buy`
  ADD CONSTRAINT `buy_ibfk_1` FOREIGN KEY (`bID`) REFERENCES `buyer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buy_ibfk_2` FOREIGN KEY (`boxID`) REFERENCES `box` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `box`
  ADD CONSTRAINT `box_ibfk_1` FOREIGN KEY (`date`) REFERENCES `day` (`date`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`date`) REFERENCES `day` (`date`) ON DELETE CASCADE ON UPDATE CASCADE;
  
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
