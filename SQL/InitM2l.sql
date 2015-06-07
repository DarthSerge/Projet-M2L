-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 07 Juin 2015 à 22:48
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `calculJours`(IN `id` INT)
    SQL SECURITY INVOKER
BEGIN
  SET @dateDebut = (SELECT form_date_debut FROM formation WHERE form_id = id);

  SET @dateFin = (SELECT form_date_fin FROM formation WHERE form_id = id);

  SET @nbJours = (DATEDIFF(@dateFin, @dateDebut) - (WEEK(@dateFin) - WEEK(@dateDebut)) * 2);

    SELECT @nbJours + 1 AS jours;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCredits`(IN `id` INT)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  SET @creditsTotaux = (SELECT param_valeur FROM parametres WHERE param_libelle='credits');
    
            
    SET @creditsUtilises = (SELECT SUM(form_cout_credit) FROM formation WHERE form_id IN (SELECT form_id FROM participe WHERE user_id = id AND part_statut <> 'annulee'));

    SELECT
      CASE 
        WHEN @creditsUtilises IS NULL THEN @creditsTotaux
        ELSE  (@creditsTotaux - @creditsUtilises)
        END AS credit;          
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFormations`(IN `id` INT, IN `statut` VARCHAR(25))
    SQL SECURITY INVOKER
BEGIN
  SELECT form_id FROM participe WHERE user_id = id AND part_statut = statut;
END$$

CREATE DEFINER=`root`@`admin` PROCEDURE `getJours`(IN `id` INT)
    SQL SECURITY INVOKER
BEGIN
  SELECT 
      (SELECT param_valeur FROM parametres WHERE param_libelle = 'jours') -       SUM(DATEDIFF(f.form_date_fin,f.form_date_debut)-              ((WEEK(f.form_date_fin) - WEEK(f.form_date_debut)) * 2)+1) AS jours
    FROM
      participe p
      INNER JOIN formation f ON f.form_id = p.form_id WHERE p.user_id = id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`form_id`, `form_libelle`, `form_contenu`, `form_date_debut`, `form_date_fin`, `form_lieu`, `form_prerequis`, `form_cout_credit`, `prest_id`) VALUES
(1, 'BackOffice', 'Contenu de la première formation', '2015-04-01', '2015-04-06', 'Paris', 'Base PHP', 300, 1),
(2, 'Interface Web', 'Contenu de la deuxième formation', '2015-06-04', '2015-06-07', 'Cergy', 'Connaissance HTML et CSS', 325, 1),
(3, 'Bureautique', 'Contenu de la troisième formation', '2015-06-12', '2015-06-20', 'Monaco', 'Suite Office', 150, 1),
(4, 'Formation 4', 'Contenu de la quatrième formation', '2015-06-20', '2015-07-28', 'Bogota', 'Suite Office', 275, 2),
(5, 'C++', 'Contenu de la cinquième formation', '2015-07-13', '2015-08-18', 'New York', 'Base de la programmation', 850, 2),
(6, 'Algorythmie Avancée', 'Contenu de la sixième formation', '2015-07-15', '2015-08-29', 'Lyon', 'Base de l''Algorythmie', 400, 1);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

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
(1, 2, 'terminee'),
(2, 2, 'validee'),
(3, 2, 'demandee');

-- --------------------------------------------------------

--
-- Structure de la table `prestataire`
--

CREATE TABLE IF NOT EXISTS `prestataire` (
  `prest_id` int(11) NOT NULL AUTO_INCREMENT,
  `prest_raison_sociale` varchar(50) NOT NULL,
  `prest_adresse` varchar(150) NOT NULL,
  `prest_telephone` varchar(10) NOT NULL,
  `prest_siret` varchar(32) NOT NULL,
  PRIMARY KEY (`prest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `prestataire`
--

INSERT INTO `prestataire` (`prest_id`, `prest_raison_sociale`, `prest_adresse`, `prest_telephone`, `prest_siret`) VALUES
(1, 'NoLoSe', '69 rue du kiwi, 78500, Sartrouville', '0892310001', 'ZG21FE325EFE'),
(2, 'KirikouIT', '69 rue du poulet, 93000, Montreuil', '0235698745', 'HJ84GR652CDE');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(50) NOT NULL,
  `user_mdp` varchar(75) NOT NULL,
  `user_mail` varchar(250) NOT NULL,
  `user_actif` tinyint(1) NOT NULL,
  `user_admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_user_id_1` (`user_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_mdp`, `user_mail`, `user_actif`, `user_admin`) VALUES
(1, 'serge', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'sergepopolov@yopmail.com', 1, 1),
(2, 'pipoulefifou', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'pipou@lefifou.com', 1, 0),
(3, 'employeUn', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'emp1@mail.com', 1, 0),
(4, 'employeDeux', 'eb2b0f82d5d1235eb5d5b8524ac3956e', 'emp2@mail.com', 1, 0);

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
CREATE DEFINER=`root`@`localhost` EVENT `majFormationTerminee` ON SCHEDULE EVERY 1 DAY STARTS '2015-04-20 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE participe SET part_statut='terminee' WHERE part_statut='encours' AND form_id IN (SELECT form_id FROM formation WHERE form_date_fin = SUBDATE(CURDATE(),1))$$

CREATE DEFINER=`root`@`localhost` EVENT `majFormationEnCours` ON SCHEDULE EVERY 1 DAY STARTS '2015-04-20 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE participe SET part_statut='encours' WHERE part_statut='acceptee' AND form_id IN (SELECT form_id FROM formation WHERE     form_date_debut = DATE(NOW()))$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
