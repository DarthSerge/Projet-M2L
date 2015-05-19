-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 19 Mai 2015 à 21:17
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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `getFormations`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFormations`(IN `id` INT, IN `statut` VARCHAR(25))
    SQL SECURITY INVOKER
BEGIN
	SELECT form_id FROM participe WHERE user_id = id AND part_statut = statut;
END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `calculJours`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `calculJours`(`id` INT) RETURNS int(11)
    SQL SECURITY INVOKER
BEGIN
	SET @dateDebut = (SELECT form_date_debut FROM formation WHERE form_id = id);

	SET @dateFin = (SELECT form_date_fin FROM formation WHERE form_id = id);

	SET @nbJours = (DATEDIFF(@dateFin, @dateDebut) - (WEEK(@dateFin) - WEEK(@dateDebut)) * 2);

    RETURN @nbJours + 1;
END$$

DROP FUNCTION IF EXISTS `getCredits`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getCredits`(`id` INT) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
	SET @creditsTotaux = (SELECT param_valeur FROM parametres WHERE param_libelle='credits');
    
            
    SET @creditsUtilises = (SELECT SUM(form_cout_credit) FROM formation WHERE form_id IN (SELECT form_id FROM participe WHERE user_id = id AND part_statut <> 'annulee'));

    RETURN IF((@creditsUtilises IS NULL), @creditsTotaux, (@creditsTotaux - @creditsUtilises));
END$$

DROP FUNCTION IF EXISTS `getJours`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getJours`(`nb` INT) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
	SET @joursTotaux = (SELECT param_valeur FROM parametres WHERE param_libelle='jours');
    
    SET @joursUtilises = nb;

    RETURN (@joursTotaux - @joursUtilises);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_libelle` varchar(100) NOT NULL,
  `form_contenu` varchar(250) NOT NULL,
  `form_date_debut` date NOT NULL,
  `form_date_fin` date NOT NULL,
  `form_lieu` varchar(25) NOT NULL,
  `form_prerequis` varchar(25) NOT NULL,
  `form_cout_credit` int(11) NOT NULL,
  `prest_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`form_id`),
  KEY `FK_formation_prest_id` (`prest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`form_id`, `form_libelle`, `form_contenu`, `form_date_debut`, `form_date_fin`, `form_lieu`, `form_prerequis`, `form_cout_credit`, `prest_id`) VALUES
(1, 'Ninja 101', 'contenu ninja', '2015-04-29', '2015-04-14', 'Tijuana', 'Que nenni', 150, 1),
(2, 'Formation nulle', 'contenu nul', '2015-04-22', '2015-04-24', 'Loin', 'Rien', 325, 1),
(3, 'Formation pourrie', 'contenu pourri', '2015-04-23', '2015-04-15', 'Loin', 'Rien', 124, 1),
(4, 'Formation inutile', 'contenu inutile', '2015-04-25', '2015-04-28', 'Loin', 'Rien', 1, 1),
(5, 'Formation kikoo', 'contenu kikoo', '2015-04-26', '2015-04-30', 'N''importe où', 'Osef', 3782, 1);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

DROP TABLE IF EXISTS `parametres`;
CREATE TABLE IF NOT EXISTS `parametres` (
  `param_libelle` varchar(50) NOT NULL,
  `param_valeur` int(11) NOT NULL,
  PRIMARY KEY (`param_libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `parametres`
--

INSERT INTO `parametres` (`param_libelle`, `param_valeur`) VALUES
('credits', 5000),
('jours', 15);

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `part_statut` varchar(20) NOT NULL,
  PRIMARY KEY (`form_id`,`user_id`),
  KEY `FK_participe_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `participe`
--

INSERT INTO `participe` (`form_id`, `user_id`, `part_statut`) VALUES
(1, 2, 'demandee'),
(2, 2, 'annulee'),
(3, 2, 'terminee'),
(4, 2, 'encours'),
(5, 2, 'terminee');

-- --------------------------------------------------------

--
-- Structure de la table `prestataire`
--

DROP TABLE IF EXISTS `prestataire`;
CREATE TABLE IF NOT EXISTS `prestataire` (
  `prest_id` int(11) NOT NULL AUTO_INCREMENT,
  `prest_raison_sociale` varchar(50) NOT NULL,
  `prest_adresse` varchar(150) NOT NULL,
  `prest_telephone` varchar(10) NOT NULL,
  `prest_siret` varchar(32) NOT NULL,
  PRIMARY KEY (`prest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `prestataire`
--

INSERT INTO `prestataire` (`prest_id`, `prest_raison_sociale`, `prest_adresse`, `prest_telephone`, `prest_siret`) VALUES
(1, 'KirikouIT', '69 rue du poulet, 78500, Sartrouville', '0892310001', 'dswxvbhnj523');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(50) NOT NULL,
  `user_mdp` varchar(75) NOT NULL,
  `user_mail` varchar(250) NOT NULL,
  `user_actif` tinyint(1) NOT NULL,
  `user_admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_user_id_1` (`user_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_mdp`, `user_mail`, `user_actif`, `user_admin`) VALUES
(1, 'serge', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'sergepopolov@yopmail.com', 1, NULL),
(2, 'pipoulefifou', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'pipou@lefifou.com', 1, 1);

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

DELIMITER $$
--
-- Événements
--
DROP EVENT `majFormationTerminee`$$
CREATE DEFINER=`root`@`localhost` EVENT `majFormationTerminee` ON SCHEDULE EVERY 1 DAY STARTS '2015-04-20 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE participe SET part_statut='terminee' WHERE part_statut='encours' AND form_id IN (SELECT form_id FROM formation WHERE form_date_fin = SUBDATE(CURDATE(),1))$$

DROP EVENT `majFormationEnCours`$$
CREATE DEFINER=`root`@`localhost` EVENT `majFormationEnCours` ON SCHEDULE EVERY 1 DAY STARTS '2015-04-20 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE participe SET part_statut='encours' WHERE part_statut='acceptee' AND form_id IN (SELECT form_id FROM formation WHERE 		form_date_debut = DATE(NOW()))$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
