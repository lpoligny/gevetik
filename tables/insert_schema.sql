-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 26 Mars 2013 à 18:11
-- Version du serveur: 5.5.29
-- Version de PHP: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gevetik`
--

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`article_id`, `evenement_id`, `titre`, `resume`, `nombre_page`, `extra_page`, `keywords`) VALUES
(1, 1, 'OLSR Protocol Enhancement Through Mobility Integration', 'There exist many problems encountered in Mobile Networks such as security, energy, bandwidth and routing problems. All these problems are caused by the high mobility of nodes. The objective of this paper is to propose a new way for nodes’ mobility measuring based on OLSR Protocol. The parameter ? used in the formula of nodes mobility calculation in the Mob-OLSR protocol is automated, and a new version of Mob-OLSR called Mob-2-OLSR is introduced. This version helps improving the network performance. The impact of mobility and pause time on the behavior of \r\nthe three versions of OLSR protocol: standard OLSR, Mob-OLSR, and Mob-2-OLSR is also examined.', 3, 0, 'Mob OLSR ; Mobility ; Wireless Network ; Quality of Service'),
(2, 2, 'An Angle-based Dissimilarity for Accelerating the Clustering of Dynamic Data in Networks', 'Mining time series data is of great significance in various areas. In order to efficiently find representative patterns in these data sets, this paper focuses on the definition of a valid dissimilarity and the acceleration of partitioning clustering, a common technique used to discover typical shapes of time series. Following the analysis of adopting the angle between two time series as the measure of dissimilarity, our definition, which is invariant to specific transformations, has been proposed. Moreover, our dissimilarity obeys the triangle inequality with specific restrictions. This property can be employed to accelerate clustering. An integrated algorithm is proposed. Experiments show that the angle-based dissimilarity captures the essence of time series patterns that are invariant to amplitude scaling. In addition, our algorithm provides a feasible way to update cluster centers, as well as an effective approach to accelerating clustering. Our accelerated algorithm reduces the number of dissimilarity calculations by almost an order of magnitude.', 5, 2, 'Time Series Data ; Dissimilarity Measure ; Clustering Acceleration ; Triangle Inequality'),
(3, 1, ' Dynamic Model of Steer-by-wire System for Driver Handwheel Feedback', 'Recent advances towards steer-by-wire technology have promised significant improvements in vehicle handling performance and safety. This technology inspired from aeronautics, consists in replacing the traditional mechanical linkages and/or hydraulic power assist with electrical equivalents. This paper describes the adopted approach for development of a new dynamic model of a Steer-by-wire system with hydraulic assistance in the case of stopped vehicle. The aim is to establish dynamic equations of the forces and torques exchanged between handwheel and the front wheels during steering operations. Some simulation results are provided. The proposed model will be experimented using a prototype equipped with handwheel feedback system. ', 5, 1, 'Steer-by-wire ; Dynamic model ; handwheel'),
(4, 2, 'Estimating Storage Requirements for Wind Power Plants', 'Wind power generation in electric power systems increased in the past years because of the huge technology advances and is still going up, but it can’t be forgotten that the wind is an intermittent power source. This is why the need of storing the energy came up. Moreover, the price of the storage is quite high. This work aims to investigate the optimal amount of energy storage necessary to keep the energy output constant to feed the grid. To do so, a research in different kinds of technology storages is made. Then, the best one due to their cost, lifetime, efficiency, energy density and some special requirements is selected. After that, four places all over Spain are selected and their wind profile is evaluated. In this evaluation the amount of days in which there is not enough wind or there is too much wind are counted. Also the average wind speed during this time is calculated. After that, a specific wind power model is selected and some calculations are done. Then the average power output and the needed capacity storage are estimated. Finally, after selecting an appropriate storage model, the results are obtained and presented.', 5, 0, 'wind power generation ; energy storage ; energy density ; wind power model');

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `evenement_id`, `nom_categorie`) VALUES
(1, 1, 'IEEE'),
(2, 1, 'Etudiant'),
(3, 2, 'IEEE'),
(4, 2, 'Etudiant');

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`evenement_id`, `organisateur_id`, `nom_evenement`, `description`, `remise`, `date_remise`, `date_soumission_debut`, `date_soumission_fin`, `date_acceptation`, `date_acceptation_definitive`, `date_debut`, `date_fin`) VALUES
(1, 1, 'Open Source', 'Nec piget dicere avide magis hanc insulam populum Romanum invasisse quam iuste. Ptolomaeo enim rege foederato nobis et socio ob aerarii nostri angustias iusso sine ulla culpa proscribi ideoque hausto veneno voluntaria morte deleto et tributaria facta est et velut hostiles eius exuviae classi inpositae in urbem advectae sunt per Catonem, nunc repetetur ordo gestorum.', 50, '2013-03-28', '2013-04-01', '2013-04-14', '2013-04-16', '2013-04-23', '2013-05-01', '2013-05-28'),
(2, 2, 'Security', 'Unde Rufinus ea tempestate praefectus praetorio ad discrimen trusus est ultimum. ire enim ipse compellebatur ad militem, quem exagitabat inopia simul et feritas, et alioqui coalito more in ordinarias dignitates asperum semper et saevum, ut satisfaceret atque monstraret, quam ob causam annonae convectio sit impedita.', 15, '2013-08-01', '2013-08-08', '2013-08-14', '2013-08-21', '2013-08-28', '2013-09-02', '2013-09-09');

--
-- Contenu de la table `gestionnaire_finances`
--

INSERT INTO `gestionnaire_finances` (`id`, `login`, `password`) VALUES
(1, 'compta@mail.fr', 'password');

--
-- Contenu de la table `option`
--

INSERT INTO `option` (`option_id`, `categorie_id`, `nom_option`, `prix_unitaire`, `quantite_minimum`, `quantite_maximum`) VALUES
(1, 1, 'Repas', 15.00, 0, 4),
(2, 1, 'Gala', 30.50, 0, 4),
(3, 2, 'Repas', 15.00, 1, 10),
(4, 2, 'Gala', 30.50, 2, 10),
(5, 2, 'CD', 10.00, 5, 30),
(6, 3, 'Repas', 10.00, 2, 4),
(7, 4, 'Repas', 25.00, 0, 10),
(8, 4, 'Gala', 35.00, 0, 5),
(9, 4, 'CD', 15.00, 1, 30);

--
-- Contenu de la table `option_paiement`
--

INSERT INTO `option_paiement` (`option_paiement_id`, `paiement_id`, `option_id`, `quantite`) VALUES
(1, 6, 1, 2),
(2, 6, 2, 3),
(3, 8, 3, 1),
(4, 8, 4, 4);

--
-- Contenu de la table `page_payee`
--

INSERT INTO `page_payee` (`page_payee_id`, `article_id`, `auteur_id`, `paiement_id`, `extra_page_payee`) VALUES
(1, 1, 1, 1, 0),
(2, 2, 2, 2, 1),
(3, 2, 3, 3, 1),
(4, 3, 4, 4, 1),
(5, 4, 4, 5, 0);

--
-- Contenu de la table `paiement`
--

INSERT INTO `paiement` (`paiement_id`, `reference_paiement`, `page_payee_id`, `reservation_id`, `type`, `validation`, `total`) VALUES
(1, 'reference1', 1, 0, 'CB', 1, 300.00),
(2, 'reference2', 2, 0, 'CB', 1, 500.00),
(3, 'reference3', 3, 0, 'Cheque', 0, 600.00),
(4, 'reference4', 4, 0, 'Virement', 1, 300.00),
(5, 'reference5', 5, 0, 'CB', 1, 300.00),
(6, 'reference6', 0, 3, 'CB', 1, 150.00),
(8, 'reference7', 0, 4, 'CB', 1, 60.00);

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`participant_id`, `prenom_participant`, `nom_participant`, `email_participant`, `mot_de_passe`) VALUES
(1, 'participant1', 'NOMP1', 'p1@mail.fr', 'pass1'),
(2, 'participant2', 'NOMP2', 'p2@mail.fr', 'pass2'),
(3, 'participant3', 'NOMP3', 'p3@mail.fr', 'pass3'),
(4, 'participant4', 'NOMP4', 'p4@mail.fr', 'pass4'),
(5, 'participant5', 'NOMP5', 'p5@mail.fr', 'pass5'),
(6, 'participant6', 'NOMP6', 'p6@mail.fr', 'pass6');

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `evenement_id`, `paiement_id`, `participant_id`) VALUES
(3, 1, 6, 5),
(4, 2, 8, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
