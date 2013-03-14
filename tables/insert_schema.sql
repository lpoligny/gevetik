-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 14 Mars 2013 à 16:02
-- Version du serveur: 5.5.29
-- Version de PHP: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: 'gevetik'
--

--
-- Contenu de la table 'article'
--

INSERT INTO article (article_id, evenement_id, titre, `resume`, nombre_page, extra_page, keywords) VALUES
(1, 1, 'Arch Linux', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 0, 'Linux Geek Open'),
(2, 1, 'Ubuntu', 'A BANIR !!! Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 2, 'Linux Libre smatphone'),
(3, 2, 'Windows 8', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 3, 0, 'Windows fail mort '),
(4, 2, 'Window phone ', 'Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?', 5, 3, 'phone smartphone windows');

--
-- Contenu de la table 'auteur'
--

INSERT INTO auteur (auteur_id, paiement_id, prenom_auteur, nom_auteur, email_auteur) VALUES
(1, NULL, 'Auteur1', 'NOM1', 'auteur1@mail.fr'),
(2, NULL, 'Auteur2', 'NOM2', 'auteur2@mail.fr'),
(3, NULL, 'Auteur3', 'NOM3', 'auteur3@mail.fr'),
(4, NULL, 'Auteur4', 'NOM4', 'auteur4@mail.fr'),
(5, NULL, 'Auteur5', 'NOM5', 'auteur5@mail.fr');

--
-- Contenu de la table 'categorie'
--

INSERT INTO categorie (categorie_id, evenement_id, nom_categorie) VALUES
(1, 1, 'Etudiant'),
(2, 1, 'IEEE'),
(3, 2, 'Etudiant'),
(4, 2, 'IEEE');

--
-- Contenu de la table 'evenement'
--

INSERT INTO evenement (evenement_id, organisateur_id, nom_evenement, remise, date_remise, date_debut_evenement, date_fin_evenement) VALUES
(1, 1, 'Open Source', 10, '2013-06-05', '2013-09-03', '2013-09-04'),
(2, 2, 'Microsoft Security', 20, '2013-07-16', '2013-12-19', '2013-12-19');

--
-- Contenu de la table 'option'
--

INSERT INTO `option` (option_id, categorie_id, nom_option, prix_unitaire, quantite_minimum, quantite_maximum) VALUES
(1, 1, 'CD', 20.00, 1, 5),
(2, 1, 'Repas', 30.00, 0, 5),
(3, 2, 'CD', 20.00, 1, 50),
(4, 2, 'Gala', 40.00, 0, 4);

--
-- Contenu de la table 'option_paiement'
--

INSERT INTO option_paiement (option_paiement_id, paiement_id, option_id, quantite) VALUES
(1, 16, 1, 3),
(2, 17, 2, 2),
(3, 18, 3, 5),
(4, 19, 4, 10);

--
-- Contenu de la table 'organisateur'
--

INSERT INTO organisateur (organisateur_id, prenom_organisateur, nom_organisateur, email_organisateur) VALUES
(1, 'Benjamin', 'RABILLER', 'ben@mail.fr'),
(2, 'Laurent', 'POLIGNY', 'laurent@mail.fr');

--
-- Contenu de la table 'page_payee'
--

INSERT INTO page_payee (article_id, auteur_id, extra_page_payee) VALUES
(1, 1, 0),
(2, 2, 1),
(2, 3, 1),
(3, 4, 0),
(3, 5, 0),
(4, 2, 0),
(4, 5, 2);

--
-- Contenu de la table 'paiement'
--

INSERT INTO paiement (paiement_id, reservation_id, auteur_id, `type`, validation, total) VALUES
(7, NULL, 1, 'CB', 0, 200.00),
(8, NULL, 2, 'Virement', 1, 300.00),
(9, NULL, 3, 'CB', 0, 450.00),
(10, NULL, 4, 'CB', 0, 250.00),
(15, NULL, 5, 'Cheque', 1, 1500.00),
(16, 1, NULL, 'CB', 0, 50.00),
(17, 2, NULL, 'CB', 0, 100.00),
(18, 3, NULL, 'CB', 0, 300.00),
(19, 4, NULL, 'Cheque', 1, 125.00);

--
-- Contenu de la table 'participant'
--

INSERT INTO participant (participant_id, prenom_participant, nom_participant, email_participant) VALUES
(1, 'Participant1', 'NOMP1', 'participant1@mail.fr'),
(2, 'Participant2', 'NOMP2', 'participant2@mail.fr'),
(3, 'Participant3', 'NOMP3', 'participant3@mail.fr'),
(4, 'Participant4', 'NOMP4', 'participant4@mail.fr');

--
-- Contenu de la table 'reservation'
--

INSERT INTO reservation (reservation_id, evenement_id, paiement_id, participant_id) VALUES
(1, 1, 16, 1),
(2, 1, 17, 2),
(3, 2, 18, 3),
(4, 2, 19, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
