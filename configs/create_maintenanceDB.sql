-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 16, 2019 at 11:10 AM
-- Server version: 5.5.60
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maintenance`
--
CREATE DATABASE IF NOT EXISTS `maintenance` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maintenance`;

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `id` int(3) NOT NULL,
  `username` varchar(32) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `gLabel` varchar(255) NOT NULL,
  `refreshToken` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `mailDomain` varchar(64) NOT NULL,
  `maintenanceRecipient` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kundenCID`
--

CREATE TABLE `kundenCID` (
  `id` int(32) NOT NULL,
  `lieferantCID` int(32) NOT NULL,
  `kundenCID` varchar(254) NOT NULL,
  `protected` varchar(16) NOT NULL,
  `kunde` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lieferantCID`
--

CREATE TABLE `lieferantCID` (
  `id` int(11) NOT NULL,
  `lieferant` int(32) NOT NULL,
  `derenCID` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `maintenancedb`
--

CREATE TABLE `maintenancedb` (
  `id` int(11) NOT NULL,
  `maileingang` datetime DEFAULT NULL,
  `receivedmail` varchar(256) DEFAULT NULL,
  `bearbeitetvon` varchar(128) DEFAULT NULL,
  `lieferant` int(11) NOT NULL,
  `derenCIDid` varchar(256) DEFAULT NULL,
  `maintenancedate` datetime NOT NULL,
  `startDateTime` datetime DEFAULT NULL,
  `endDateTime` datetime DEFAULT NULL,
  `timezone` varchar(64) DEFAULT NULL,
  `postponed` varchar(256) NOT NULL,
  `notes` varchar(8192) NOT NULL,
  `mailSentAt` datetime DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  `inBearbeitung` tinyint(1) NOT NULL DEFAULT '0',
  `updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedBy` varchar(64) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `cancelled` tinyint(1) NOT NULL,
  `betroffeneKunden` varchar(256) NOT NULL,
  `betroffeneCIDs` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `persistence`
--

CREATE TABLE `persistence` (
  `id` int(2) NOT NULL,
  `serviceuser` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kundenCID`
--
ALTER TABLE `kundenCID`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lieferantCID`
--
ALTER TABLE `lieferantCID`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenancedb`
--
ALTER TABLE `maintenancedb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_lieferant` (`lieferant`),
  ADD KEY `index_derenCIDid` (`derenCIDid`);

--
-- Indexes for table `persistence`
--
ALTER TABLE `persistence`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lieferantCID`
--
ALTER TABLE `lieferantCID`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenancedb`
--
ALTER TABLE `maintenancedb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
