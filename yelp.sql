-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2016 at 02:13 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yelp`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE IF NOT EXISTS `evaluation` (
  `evaluation_id` int(10) unsigned NOT NULL,
  `location_loc_id` int(10) unsigned NOT NULL,
  `usr_id` int(10) unsigned NOT NULL,
  `eval_note` int(10) unsigned DEFAULT NULL,
  `eval_comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `loc_id` int(10) unsigned NOT NULL,
  `loc_name` varchar(50) DEFAULT NULL,
  `loc_type` varchar(50) DEFAULT NULL,
  `loc_adresse` varchar(50) DEFAULT NULL,
  `loc_ville` varchar(50) DEFAULT NULL,
  `loc_img_ville` varchar(50) DEFAULT NULL,
  `loc_description` varchar(50) DEFAULT NULL,
  `loc_gps_lat` double DEFAULT NULL,
  `loc_gps_long` double DEFAULT NULL,
  `loc_cp` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `rol_id` int(10) unsigned NOT NULL,
  `rol_name` enum('user','editor','admin') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rol_id`, `rol_name`) VALUES
(1, 'user'),
(2, 'editor'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE IF NOT EXISTS `usr` (
  `usr_id` int(10) unsigned NOT NULL,
  `role_rol_id` int(10) unsigned NOT NULL,
  `usr_email` varchar(50) DEFAULT NULL,
  `usr_password` varchar(50) DEFAULT NULL,
  `usr_date_of_creation` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`usr_id`, `role_rol_id`, `usr_email`, `usr_password`, `usr_date_of_creation`) VALUES
(3, 2, 'maghnia.dib.pro@gmail.com', '$2y$10$zwsUlaWwnYam7q2ZH8OAYeJoUKVQLG4RG3oOdEH78HQ', '2016-02-08 14:10:14'),
(4, 3, 'perfect_sapphire@hotmail.com', '$2y$10$P/LHVRlaZ9kM/V84K4B3d.jX1cyyi1z4qFpBDf2ctRb', '2016-02-08 14:11:06'),
(5, 2, 'deltgen.david@gmail.com', '$2y$10$t3hgpy3FJTsNG3NCV702Nul4Xbqonoqy0z9BpRX/A4g', '2016-02-08 14:11:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `evaluation_FKIndex1` (`usr_id`),
  ADD KEY `evaluation_FKIndex2` (`location_loc_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indexes for table `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `usr_FKIndex1` (`role_rol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluation_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `loc_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
