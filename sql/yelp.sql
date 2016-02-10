-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 10 Février 2016 à 17:02
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `yelp`
--

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
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
-- Structure de la table `location`
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `location`
--

INSERT INTO `location` (`loc_id`, `loc_name`, `loc_type`, `loc_adresse`, `loc_ville`, `loc_img_ville`, `loc_description`, `loc_gps_lat`, `loc_gps_long`, `loc_cp`) VALUES
(1, 'exki', '', '', '', NULL, '', NULL, NULL, ''),
(2, 'vapa', '', '', '', NULL, '', NULL, NULL, ''),
(3, 'bxbxcvbn', '', '', '', NULL, '', NULL, NULL, ''),
(4, 'ccccc', '', '', '', NULL, '', NULL, NULL, ''),
(5, 'tyeryery', '', '', '', NULL, '', NULL, NULL, ''),
(6, 'upiopiopiop', '', '', '', NULL, '', NULL, NULL, ''),
(7, 'hjlhjll', '', '', '', NULL, '', NULL, NULL, ''),
(8, 'mmmmmmm', '', '', '', NULL, '', NULL, NULL, ''),
(9, 'ssssssssssssssss', '', '', '', NULL, '', NULL, NULL, ''),
(10, 'xxxxxxxxxxxxxx', '', '', '', NULL, '', NULL, NULL, ''),
(11, 'dddddddddddddd', '', '', '', NULL, '', NULL, NULL, ''),
(12, 'fffffffffffffffffffffff', 'hdfhdfh', 'hdfhfdh', 'dhfdfh', NULL, '0', NULL, NULL, '0'),
(13, 'uuuuuuuuuu', 'cbxcb', 'xcbxcb', 'fgdsfgdgf', NULL, '0', NULL, NULL, '0'),
(14, 'xxxxxxxxxxxxxxxxx', 'hghgh', 'dfhdfh', 'jghjjgjgj', NULL, '0', NULL, NULL, '0'),
(15, 'wwwwwwwwww', 'wwww', 'wwwwwww', 'wwww', NULL, '0', NULL, NULL, '0'),
(16, 'egegegegeg', 'ssss', 'sssgg', 'dgg', NULL, '0', NULL, NULL, '0'),
(17, 'uyuyyuyuyu', 'ey', 'eqsf', 'QSF', NULL, '0', NULL, NULL, '0'),
(18, 'mklmlk', 'khk', 'vb,vb', 'vb,,', NULL, '0', NULL, NULL, '0'),
(19, 'jjjjjjjh', 'jhg', 'jhg', 'kgh', NULL, 'kghk', NULL, NULL, 'kjgh'),
(20, 'hotel', 'hotel', '28 avenue de la gare', 'Diekirch', NULL, 'hotel', 49.8660289, NULL, '9233'),
(21, 'rr', 'rr', '69 rue du clopp', 'rodange', NULL, 'jk', 49.5448694, 5.8349565, '4810'),
(22, 'yu', 'jgh', '9 avenue des hauts-fourneaux', 'belval luxembourg', NULL, 'gj', 49.5024421, 5.9492336, '4362'),
(23, 'test', 'resto', '69, rue du clopp', 'rodange luxembourg', NULL, 'test sur bd de Yuyu', 49.5448694, 5.8349565, '4810'),
(24, 'Macash', 'truc', '9 rue des haut fourneaux', 'Esch luxembourg', NULL, 'Truc', 49.5024818, 5.9492153, ''),
(25, 'yuouyo', 'hjkljhl', '16 avenue de la gare', 'luxembourg', NULL, 'ghghk', 49.6006284, 6.1330855, '1616'),
(26, 'kjhk', 'jklhj', '11 avenue de la gare', 'luxembourg', NULL, 'fsd', 49.6042645, 6.1333644, '1611');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `rol_id` int(10) unsigned NOT NULL,
  `rol_name` enum('user','editor','admin') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`rol_id`, `rol_name`) VALUES
(1, 'user'),
(2, 'editor'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `usr`
--

CREATE TABLE IF NOT EXISTS `usr` (
  `usr_id` int(10) unsigned NOT NULL,
  `role_rol_id` int(10) unsigned NOT NULL,
  `usr_email` varchar(50) DEFAULT NULL,
  `usr_password` varchar(255) DEFAULT NULL,
  `usr_date_of_creation` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usr`
--

INSERT INTO `usr` (`usr_id`, `role_rol_id`, `usr_email`, `usr_password`, `usr_date_of_creation`) VALUES
(8, 2, 'maghnia.dib.pro@gmail.com', '$2y$10$BBVQrhpRTpqAej4CroIawORfSd.XQ1/EPVb4AUyw9tkG3fjJmSqbW', '2016-02-09 12:08:51'),
(9, 3, 'perfect_sapphire@hotmail.com', '$2y$10$gMS7tURspBXLvD0Zf5/WiuGnz2.E3IyCq9xf0SOD5KyB962RCrpQy', '2016-02-09 12:09:30'),
(10, 2, 'deltgen.david@gmail.com', '$2y$10$KOjTSEdXLMveZx9XoM4SuO1th1AAgoQPz9my7GwmVkl0VFtm/s61S', '2016-02-09 12:09:45'),
(11, 1, 'toto@yahoo.fr', '$2y$10$ylGOJHW8i5niNRAv5lheQeT1PN/3nJc6YOY5kARinj5fF6DgLNyJy', '2016-02-09 14:25:29'),
(12, 1, 'tata@yahoo.fr', '$2y$10$DdkxOfvaJmtwyzM6jNLnXudrZoTHBQNNBsg1yPU35p98rpmPgwQzK', '2016-02-09 15:31:49'),
(13, 1, 'toto@yahoo.fr', 'maghnia2015', '2016-02-10 16:00:47'),
(14, 1, 'rapphi@gmail.com', 'rapphimi2015', '2016-02-10 16:02:31'),
(15, 1, 'toutou@gmail.com', '$2y$10$WddOjUlbS5ZuGmy3p6BU1.Y20IcxZa2EhlOHUAk5Q2aaDBZQkHst.', '2016-02-10 16:11:43');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `evaluation_FKIndex1` (`usr_id`),
  ADD KEY `evaluation_FKIndex2` (`location_loc_id`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rol_id`);

--
-- Index pour la table `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `usr_FKIndex1` (`role_rol_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluation_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `loc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `usr`
--
ALTER TABLE `usr`
  MODIFY `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
