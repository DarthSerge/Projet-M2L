-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 12 Avril 2015 à 10:43
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `m2l`
--
CREATE DATABASE IF NOT EXISTS `m2l` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `m2l`;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_date_debut` date DEFAULT NULL,
  `form_date_fin` date DEFAULT NULL,
  `form_lieu` varchar(25) DEFAULT NULL,
  `form_prerequis` varchar(25) DEFAULT NULL,
  `form_etat` int(11) DEFAULT NULL,
  `form_cout_credit` int(11) DEFAULT NULL,
  `prest_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`form_id`),
  KEY `FK_formation_prest_id` (`prest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

CREATE TABLE IF NOT EXISTS `participe` (
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`form_id`,`user_id`),
  KEY `FK_participe_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prestataire`
--

CREATE TABLE IF NOT EXISTS `prestataire` (
  `prest_id` int(11) NOT NULL AUTO_INCREMENT,
  `prest_raison_sociale` varchar(50) DEFAULT NULL,
  `prest_adresse` varchar(150) DEFAULT NULL,
  `prest_telephone` varchar(10) DEFAULT NULL,
  `prest_siret` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`prest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(50) DEFAULT NULL,
  `user_mdp` varchar(75) DEFAULT NULL,
  `user_mail` varchar(250) DEFAULT NULL,
  `user_actif` tinyint(1) DEFAULT NULL,
  `user_credit_dispo` int(11) DEFAULT NULL,
  `user_admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_user_id_1` (`user_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_mdp`, `user_mail`, `user_actif`, `user_credit_dispo`, `user_admin`) VALUES
(1, 'serge', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'sergepopolov@yopmail.com', 1, 50, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `FK_formation_prest_id` FOREIGN KEY (`prest_id`) REFERENCES `prestataire` (`prest_id`);

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `FK_participe_form_id` FOREIGN KEY (`form_id`) REFERENCES `formation` (`form_id`),
  ADD CONSTRAINT `FK_participe_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
