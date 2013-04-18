-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 18 Avril 2013 à 14:59
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.3-1ubuntu9.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gevetik`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`) VALUES
(1, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `titre` varchar(250) NOT NULL,
  `resume` text NOT NULL,
  `nombre_page` int(10) NOT NULL DEFAULT '0',
  `extra_page` int(10) NOT NULL DEFAULT '0',
  `keywords` text NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `FK_evenement` (`evenement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `article`
--


-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`categorie_id`),
  UNIQUE KEY `unique` (`nom_categorie`,`evenement_id`),
  KEY `FK_evemement` (`evenement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `categorie`
--


-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `evenement_id` int(10) NOT NULL AUTO_INCREMENT,
  `nom_evenement` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `remise` int(10) NOT NULL DEFAULT '0',
  `date_remise` date NOT NULL,
  `date_soumission_debut` date NOT NULL,
  `date_soumission_fin` date NOT NULL,
  `date_acceptation` date NOT NULL,
  `date_acceptation_definitive` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`evenement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`evenement_id`, `nom_evenement`, `description`, `remise`, `date_remise`, `date_soumission_debut`, `date_soumission_fin`, `date_acceptation`, `date_acceptation_definitive`, `date_debut`, `date_fin`, `visible`) VALUES
(2, 'foot', '0000-00-00', 0, '2013-03-15', '2013-03-30', '2013-10-02', '2013-05-10', '2014-05-06', '2015-08-10', '2013-04-11', 0),
(3, 'Billard', 'Billard', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(4, 'Laser Game', '3 parties de laser game Ã  Evry', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(5, 'Anniversaire', 'FÃªte d''anniversaire', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2013-08-19', '2013-08-20', 0);

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire_finances`
--

CREATE TABLE IF NOT EXISTS `gestionnaire_finances` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `gestionnaire_finances`
--

INSERT INTO `gestionnaire_finances` (`id`, `login`, `password`) VALUES
(2, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');

-- --------------------------------------------------------

--
-- Structure de la table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `option_id` int(10) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(10) NOT NULL,
  `nom_option` varchar(50) NOT NULL,
  `prix_unitaire` float(10,2) NOT NULL DEFAULT '0.00',
  `quantite_minimum` int(10) NOT NULL DEFAULT '0',
  `quantite_maximum` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `unique` (`categorie_id`,`nom_option`),
  KEY `FK_categorie` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `option`
--


-- --------------------------------------------------------

--
-- Structure de la table `option_paiement`
--

CREATE TABLE IF NOT EXISTS `option_paiement` (
  `option_paiement_id` int(10) NOT NULL AUTO_INCREMENT,
  `paiement_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `quantite` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_paiement_id`),
  KEY `FK_paiement_option_paiement` (`paiement_id`),
  KEY `FK_option_option_paiement` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `option_paiement`
--


-- --------------------------------------------------------

--
-- Structure de la table `organisateur`
--

CREATE TABLE IF NOT EXISTS `organisateur` (
  `organisateur_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `participant_id` int(10) NOT NULL,
  `nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`organisateur_id`),
  UNIQUE KEY `UNIQUE` (`evenement_id`,`participant_id`),
  KEY `FK_participant_organisateur` (`participant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `organisateur`
--

INSERT INTO `organisateur` (`organisateur_id`, `evenement_id`, `participant_id`, `nom_role`) VALUES
(1, 2, 1, 'Orga');

-- --------------------------------------------------------

--
-- Structure de la table `page_payee`
--

CREATE TABLE IF NOT EXISTS `page_payee` (
  `page_payee_id` int(10) NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL,
  `auteur_id` int(10) NOT NULL,
  `paiement_id` int(10) NOT NULL,
  `extra_page_payee` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_payee_id`),
  UNIQUE KEY `unique` (`article_id`,`auteur_id`),
  KEY `FK_auteur_page_payee` (`auteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `page_payee`
--


-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `paiement`
--

INSERT INTO `paiement` (`paiement_id`, `reference_paiement`, `page_payee_id`, `reservation_id`, `type`, `validation`, `total`) VALUES
(2, 'PAY2013', 1, 0, 'cheque', 1, 100.00),
(3, 'PAY2013/03/21', 0, 0, 'CB', 1, 1000.00);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `participant_id` int(10) NOT NULL AUTO_INCREMENT,
  `prenom_participant` varchar(50) NOT NULL,
  `nom_participant` varchar(50) NOT NULL,
  `email_participant` varchar(100) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  `profession` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`participant_id`),
  UNIQUE KEY `unique` (`email_participant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`participant_id`, `prenom_participant`, `nom_participant`, `email_participant`, `mot_de_passe`, `profession`) VALUES
(1, 'Jonathan', 'THIRION', 'jonathan.thirion2@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', ''),
(2, 'Harry', 'Potter', 'harry.potter@ens.poudlard.uk', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `paiement_id` int(10) NOT NULL,
  `participant_id` int(10) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  UNIQUE KEY `unique` (`evenement_id`,`participant_id`,`paiement_id`),
  KEY `FK_paiement_reservation` (`paiement_id`),
  KEY `FK_participant_reservation` (`participant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `evenement_id`, `paiement_id`, `participant_id`) VALUES
(1, 2, 2, 1),
(2, 2, 3, 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`);

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `FK_evemement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `FK_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `option_paiement`
--
ALTER TABLE `option_paiement`
  ADD CONSTRAINT `FK_option_option_paiement` FOREIGN KEY (`option_id`) REFERENCES `option` (`option_id`),
  ADD CONSTRAINT `FK_paiement_option_paiement` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`);

--
-- Contraintes pour la table `organisateur`
--
ALTER TABLE `organisateur`
  ADD CONSTRAINT `FK_evenement_organisateur` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`),
  ADD CONSTRAINT `FK_participant_organisateur` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`);

--
-- Contraintes pour la table `page_payee`
--
ALTER TABLE `page_payee`
  ADD CONSTRAINT `FK_article_page_payee` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`),
  ADD CONSTRAINT `FK_auteur_page_payee` FOREIGN KEY (`auteur_id`) REFERENCES `participant` (`participant_id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_evenement_reservation` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`),
  ADD CONSTRAINT `FK_paiement_reservation` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`),
  ADD CONSTRAINT `FK_participant_reservation` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`);
