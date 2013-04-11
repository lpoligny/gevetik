-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.1.53-community-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-04-11 17:44:36
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for gevetik
CREATE DATABASE IF NOT EXISTS `gevetik` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gevetik`;


-- Dumping structure for table gevetik.article
CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `titre` varchar(250) NOT NULL,
  `resume` text NOT NULL,
  `nombre_page` int(10) NOT NULL DEFAULT '0',
  `extra_page` int(10) NOT NULL DEFAULT '0',
  `keywords` text NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `FK_evenement` (`evenement_id`),
  CONSTRAINT `FK_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL,
  `slug_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`categorie_id`),
  UNIQUE KEY `unique` (`slug_categorie`,`evenement_id`),
  KEY `FK_evemement` (`evenement_id`),
  CONSTRAINT `FK_evemement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.evenement
CREATE TABLE IF NOT EXISTS `evenement` (
  `evenement_id` int(10) NOT NULL AUTO_INCREMENT,
  `nom_evenement` varchar(50) NOT NULL,
  `slug_evenement` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `adresse` text NOT NULL,
  `remise` int(10) NOT NULL DEFAULT '0',
  `date_remise` date NOT NULL,
  `date_soumission_debut` date NOT NULL,
  `date_soumission_fin` date NOT NULL,
  `date_acceptation` date NOT NULL,
  `date_acceptation_definitive` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`evenement_id`),
  UNIQUE KEY `unique` (`slug_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.gestionnaire_finances
CREATE TABLE IF NOT EXISTS `gestionnaire_finances` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.option
CREATE TABLE IF NOT EXISTS `option` (
  `option_id` int(10) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(10) NOT NULL,
  `nom_option` varchar(50) NOT NULL,
  `slug_option` varchar(50) NOT NULL,
  `prix_unitaire` float(10,2) NOT NULL DEFAULT '0.00',
  `quantite_minimum` int(10) NOT NULL DEFAULT '0',
  `quantite_maximum` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `unique` (`slug_option`,`categorie_id`),
  KEY `FK_categorie` (`categorie_id`),
  CONSTRAINT `FK_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.option_paiement
CREATE TABLE IF NOT EXISTS `option_paiement` (
  `option_paiement_id` int(10) NOT NULL AUTO_INCREMENT,
  `paiement_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `quantite` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_paiement_id`),
  KEY `FK_paiement_option_paiement` (`paiement_id`),
  KEY `FK_option_option_paiement` (`option_id`),
  CONSTRAINT `FK_paiement_option_paiement` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_option_option_paiement` FOREIGN KEY (`option_id`) REFERENCES `option` (`option_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.organisateur
CREATE TABLE IF NOT EXISTS `organisateur` (
  `organisateur_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `participant_id` int(10) NOT NULL,
  `nom_role` varchar(50) NOT NULL DEFAULT '',
  `est_organisateur` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`organisateur_id`),
  UNIQUE KEY `UNIQUE` (`evenement_id`,`participant_id`),
  KEY `FK_participant_organisateur` (`participant_id`),
  CONSTRAINT `FK_evenement_organisateur` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_participant_organisateur` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.page_payee
CREATE TABLE IF NOT EXISTS `page_payee` (
  `page_payee_id` int(10) NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL,
  `auteur_id` int(10) NOT NULL,
  `paiement_id` int(10) NOT NULL,
  `extra_page_payee` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_payee_id`),
  UNIQUE KEY `unique` (`article_id`,`auteur_id`),
  KEY `FK_auteur_page_payee` (`auteur_id`),
  CONSTRAINT `FK_article_page_payee` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`),
  CONSTRAINT `FK_auteur_page_payee` FOREIGN KEY (`auteur_id`) REFERENCES `participant` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.paiement
CREATE TABLE IF NOT EXISTS `paiement` (
  `paiement_id` int(10) NOT NULL AUTO_INCREMENT,
  `reference_paiement` varchar(50) NOT NULL,
  `page_payee_id` int(10) NOT NULL DEFAULT '0',
  `reservation_id` int(10) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `validation` tinyint(4) NOT NULL DEFAULT '0',
  `total` float(10,2) NOT NULL,
  PRIMARY KEY (`paiement_id`),
  UNIQUE KEY `unique` (`reference_paiement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.participant
CREATE TABLE IF NOT EXISTS `participant` (
  `participant_id` int(10) NOT NULL AUTO_INCREMENT,
  `prenom_participant` varchar(50) NOT NULL,
  `nom_participant` varchar(50) NOT NULL,
  `email_participant` varchar(100) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  PRIMARY KEY (`participant_id`),
  UNIQUE KEY `unique` (`email_participant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gevetik.reservation
CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `paiement_id` int(10) NOT NULL,
  `participant_id` int(10) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  UNIQUE KEY `unique` (`evenement_id`,`participant_id`,`paiement_id`),
  KEY `FK_paiement_reservation` (`paiement_id`),
  KEY `FK_participant_reservation` (`participant_id`),
  CONSTRAINT `FK_evenement_reservation` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`),
  CONSTRAINT `FK_paiement_reservation` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`),
  CONSTRAINT `FK_participant_reservation` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
