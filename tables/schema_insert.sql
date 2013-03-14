-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 14 Mars 2013 à 15:46
-- Version du serveur: 5.5.29
-- Version de PHP: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gevetik`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`article_id`, `evenement_id`, `titre`, `resume`, `nombre_page`, `extra_page`, `keywords`) VALUES
(1, 1, 'Arch Linux', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 0, 'Linux Geek Open'),
(2, 1, 'Ubuntu', 'A BANIR !!! Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 2, 'Linux Libre smatphone'),
(3, 2, 'Windows 8', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 3, 0, 'Windows fail mort '),
(4, 2, 'Window phone ', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 3, 'phone smartphone windows');

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE IF NOT EXISTS `auteur` (
  `auteur_id` int(10) NOT NULL AUTO_INCREMENT,
  `paiement_id` int(10) DEFAULT NULL,
  `prenom_auteur` varchar(50) NOT NULL,
  `nom_auteur` varchar(50) NOT NULL,
  `email_auteur` varchar(100) NOT NULL,
  PRIMARY KEY (`auteur_id`),
  UNIQUE KEY `unique` (`email_auteur`),
  KEY `FK_paiement_auteur` (`paiement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `auteur`
--

INSERT INTO `auteur` (`auteur_id`, `paiement_id`, `prenom_auteur`, `nom_auteur`, `email_auteur`) VALUES
(1, NULL, 'Auteur1', 'NOM1', 'auteur1@mail.fr'),
(2, NULL, 'Auteur2', 'NOM2', 'auteur2@mail.fr'),
(3, NULL, 'Auteur3', 'NOM3', 'auteur3@mail.fr'),
(4, NULL, 'Auteur4', 'NOM4', 'auteur4@mail.fr'),
(5, NULL, 'Auteur5', 'NOM5', 'auteur5@mail.fr');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `evenement_id` int(10) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`categorie_id`),
  KEY `FK_evemement` (`evenement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `evenement_id`, `nom_categorie`) VALUES
(1, 1, 'Etudiant'),
(2, 1, 'IEEE'),
(3, 2, 'Etudiant'),
(4, 2, 'IEEE');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `evenement_id` int(10) NOT NULL AUTO_INCREMENT,
  `organisateur_id` int(10) NOT NULL DEFAULT '0',
  `nom_evenement` varchar(50) NOT NULL,
  `remise` int(10) NOT NULL DEFAULT '0',
  `date_remise` date NOT NULL,
  `date_debut_evenement` date NOT NULL,
  `date_fin_evenement` date NOT NULL,
  PRIMARY KEY (`evenement_id`),
  KEY `FK_organisateur` (`organisateur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`evenement_id`, `organisateur_id`, `nom_evenement`, `remise`, `date_remise`, `date_debut_evenement`, `date_fin_evenement`) VALUES
(1, 1, 'Open Source', 10, '2013-06-05', '2013-09-03', '2013-09-04'),
(2, 2, 'Microsoft Security', 20, '2013-07-16', '2013-12-19', '2013-12-19');

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
  KEY `FK_categorie` (`categorie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `option`
--

INSERT INTO `option` (`option_id`, `categorie_id`, `nom_option`, `prix_unitaire`, `quantite_minimum`, `quantite_maximum`) VALUES
(1, 1, 'CD', 20.00, 1, 5),
(2, 1, 'Repas', 30.00, 0, 5),
(3, 2, 'CD', 20.00, 1, 50),
(4, 2, 'Gala', 40.00, 0, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `option_paiement`
--

INSERT INTO `option_paiement` (`option_paiement_id`, `paiement_id`, `option_id`, `quantite`) VALUES
(1, 16, 1, 3),
(2, 17, 2, 2),
(3, 18, 3, 5),
(4, 19, 4, 10);

-- --------------------------------------------------------

--
-- Structure de la table `organisateur`
--

CREATE TABLE IF NOT EXISTS `organisateur` (
  `organisateur_id` int(10) NOT NULL AUTO_INCREMENT,
  `prenom_organisateur` varchar(50) NOT NULL,
  `nom_organisateur` varchar(50) NOT NULL,
  `email_organisateur` varchar(100) NOT NULL,
  PRIMARY KEY (`organisateur_id`),
  UNIQUE KEY `unique` (`email_organisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `organisateur`
--

INSERT INTO `organisateur` (`organisateur_id`, `prenom_organisateur`, `nom_organisateur`, `email_organisateur`) VALUES
(1, 'Benjamin', 'RABILLER', 'ben@mail.fr'),
(2, 'Laurent', 'POLIGNY', 'laurent@mail.fr');

-- --------------------------------------------------------

--
-- Structure de la table `page_payee`
--

CREATE TABLE IF NOT EXISTS `page_payee` (
  `article_id` int(10) NOT NULL,
  `auteur_id` int(10) NOT NULL,
  `extra_page_payee` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`auteur_id`),
  KEY `FK_auteur_page_payee` (`auteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `page_payee`
--

INSERT INTO `page_payee` (`article_id`, `auteur_id`, `extra_page_payee`) VALUES
(1, 1, 0),
(2, 2, 1),
(2, 3, 1),
(3, 4, 0),
(3, 5, 0),
(4, 2, 0),
(4, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE IF NOT EXISTS `paiement` (
  `paiement_id` int(10) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(10) DEFAULT '0',
  `auteur_id` int(10) DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `validation` tinyint(4) NOT NULL DEFAULT '0',
  `total` float(10,2) NOT NULL,
  PRIMARY KEY (`paiement_id`),
  KEY `FK_auteur` (`auteur_id`),
  KEY `FK_reservation` (`reservation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `paiement`
--

INSERT INTO `paiement` (`paiement_id`, `reservation_id`, `auteur_id`, `type`, `validation`, `total`) VALUES
(7, NULL, 1, 'CB', 0, 200.00),
(8, NULL, 2, 'Virement', 1, 300.00),
(9, NULL, 3, 'CB', 0, 450.00),
(10, NULL, 4, 'CB', 0, 250.00),
(15, NULL, 5, 'Cheque', 1, 1500.00),
(16, 1, NULL, 'CB', 0, 50.00),
(17, 2, NULL, 'CB', 0, 100.00),
(18, 3, NULL, 'CB', 0, 300.00),
(19, 4, NULL, 'Cheque', 1, 125.00);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `participant_id` int(10) NOT NULL AUTO_INCREMENT,
  `prenom_participant` varchar(50) NOT NULL,
  `nom_participant` varchar(50) NOT NULL,
  `email_participant` varchar(100) NOT NULL,
  PRIMARY KEY (`participant_id`),
  UNIQUE KEY `unique` (`email_participant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`participant_id`, `prenom_participant`, `nom_participant`, `email_participant`) VALUES
(1, 'Participant1', 'NOMP1', 'participant1@mail.fr'),
(2, 'Participant2', 'NOMP2', 'participant2@mail.fr'),
(3, 'Participant3', 'NOMP3', 'participant3@mail.fr'),
(4, 'Participant4', 'NOMP4', 'participant4@mail.fr');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `evenement_id`, `paiement_id`, `participant_id`) VALUES
(1, 1, 16, 1),
(2, 1, 17, 2),
(3, 2, 18, 3),
(4, 2, 19, 4);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`);

--
-- Contraintes pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD CONSTRAINT `FK_paiement_auteur` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`);

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `FK_evemement` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `FK_organisateur` FOREIGN KEY (`organisateur_id`) REFERENCES `organisateur` (`organisateur_id`);

--
-- Contraintes pour la table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `FK_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`);

--
-- Contraintes pour la table `option_paiement`
--
ALTER TABLE `option_paiement`
  ADD CONSTRAINT `FK_option_option_paiement` FOREIGN KEY (`option_id`) REFERENCES `option` (`option_id`),
  ADD CONSTRAINT `FK_paiement_option_paiement` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`);

--
-- Contraintes pour la table `page_payee`
--
ALTER TABLE `page_payee`
  ADD CONSTRAINT `FK_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`),
  ADD CONSTRAINT `FK_auteur_page_payee` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`auteur_id`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`auteur_id`),
  ADD CONSTRAINT `FK_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_evenement_reservation` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`evenement_id`),
  ADD CONSTRAINT `FK_paiement_reservation` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`paiement_id`),
  ADD CONSTRAINT `FK_participant_reservation` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
