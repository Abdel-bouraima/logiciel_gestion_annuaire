-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 12 jan. 2021 à 18:50
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annuaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
CREATE TABLE IF NOT EXISTS `actualite` (
  `NumActu` int(11) NOT NULL AUTO_INCREMENT,
  `Contenu` varchar(255) NOT NULL,
  `DateActu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Publication` tinyint(1) NOT NULL DEFAULT '0',
  `Login` varchar(255) NOT NULL COMMENT 'Login de celui qui a posté le message',
  PRIMARY KEY (`NumActu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`NumActu`, `Contenu`, `DateActu`, `Publication`, `Login`) VALUES
(1, 'Lancement officiel du site de la webtv le 19/11/2017.\r\nSoyez présent.', '2017-11-22 17:48:15', 0, 'admin'),
(2, 'Affichage des listes des agents inscripteurs pour le service scolarité', '2017-11-22 17:50:11', 1, 'admin'),
(3, 'Démarrage des inscriptions prévu pour le 04 prochain\r\n', '2017-11-22 17:50:45', 0, 'admin'),
(4, 'Passation de pouvoir entre l\'ancienne équipe rectorale et  la nouvelle.', '2017-11-22 19:24:26', 1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `Matricule` int(11) NOT NULL,
  PRIMARY KEY (`Login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`Login`, `Password`, `Role`, `Matricule`) VALUES
('admin', 'admin', '1', 0),
('login', 'login', '0', 0);

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

DROP TABLE IF EXISTS `affecter`;
CREATE TABLE IF NOT EXISTS `affecter` (
  `Matricule` int(11) NOT NULL,
  `RefEntite` int(11) NOT NULL,
  `RefService` int(11) NOT NULL,
  `Poste` varchar(255) NOT NULL,
  PRIMARY KEY (`Matricule`,`RefEntite`,`RefService`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `affecter`
--

INSERT INTO `affecter` (`Matricule`, `RefEntite`, `RefService`, `Poste`) VALUES
(24, 10, 3, 'Administrateur réseaux');

-- --------------------------------------------------------

--
-- Structure de la table `bureau`
--

DROP TABLE IF EXISTS `bureau`;
CREATE TABLE IF NOT EXISTS `bureau` (
  `RefBureau` int(11) NOT NULL AUTO_INCREMENT,
  `LibelBureau` varchar(255) NOT NULL,
  `LieuBureau` varchar(255) NOT NULL,
  PRIMARY KEY (`RefBureau`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bureau`
--

INSERT INTO `bureau` (`RefBureau`, `LibelBureau`, `LieuBureau`) VALUES
(1, 'Bureau 2', 'Rectorat annexe UAC'),
(3, 'SRH', 'Batiment ifri 2ème étage'),
(4, 'Sécrétariat VR-AARU', 'Rectorat annexe UAC étage'),
(6, 'bureau9', 'Rectorat annexe de l\'UAC'),
(7, 'Sécrétariat', 'ANGERS');

-- --------------------------------------------------------

--
-- Structure de la table `entite`
--

DROP TABLE IF EXISTS `entite`;
CREATE TABLE IF NOT EXISTS `entite` (
  `RefEntite` int(11) NOT NULL AUTO_INCREMENT,
  `LibelEntite` varchar(255) NOT NULL,
  `InfoEntite` text NOT NULL,
  `ContactEntite` varchar(255) NOT NULL,
  `LieuEntite` varchar(40) NOT NULL,
  PRIMARY KEY (`RefEntite`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entite`
--

INSERT INTO `entite` (`RefEntite`, `LibelEntite`, `InfoEntite`, `ContactEntite`, `LieuEntite`) VALUES
(1, 'VR-AARU', 'Vice rectorat chargé des affaires académiques et des relations universitaires', '21 78 65 32', 'UAC'),
(2, 'EPAC', 'École polytechnique d\'Abomey-Calavi', '64 41 76 98', 'UAC'),
(3, 'FLASH', 'Faculté des Lettres Arts et Sciences Humaines', '97 87 54 10', 'Université de Parakou');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `Matricule` bigint(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `Grade` varchar(40) NOT NULL,
  `Telephone` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Autorisation` tinyint(1) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Adresse` varchar(40) NOT NULL,
  `NoteService` varchar(50) NOT NULL,
  `DatEmbauche` date NOT NULL,
  `RefBureau` varchar(255) NOT NULL,
  PRIMARY KEY (`Matricule`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Matricule`, `Nom`, `Prenom`, `Photo`, `Grade`, `Telephone`, `Email`, `Autorisation`, `Type`, `Adresse`, `NoteService`, `DatEmbauche`, `RefBureau`) VALUES
(1, 'DOVONOU', 'Michelle', '', '', '97 17 45 82', 'micho@hotmail.com', 0, 'administratif', 'PK 10', '587', '2016-09-07', ''),
(3, 'OYETOLA', 'Victor', 'OYETOLAVictor.png', '', '97 25 14 89', 'oyetolavictor@uac.bj', 1, 'Administratif', 'Akpakpa', '14 du 25/03/2010', '2010-03-25', ''),
(4, 'SINSIN', 'Augustin Brice', 'SINSIN_Augustin Brice.jpg', 'Professeur', '21 00 00 01', 'sinsinbrice@uac.bj', 1, 'Administratif', 'Calavi', '58', '1999-11-10', ''),
(7, 'BELLO', 'Ganiath', 'BELLO_Ganiath.jpg', '', '97 85 47 10', 'ganiathbello@uac.bj', 0, 'Administratif', 'Kindonou', '1', '2016-09-07', ''),
(8, 'BONI', 'Yayi ', 'BONI_Yayi.jpg', 'Dr.', '97 00 00 01', 'boni@yayi', 1, 'Administratif', 'Cadjehoun', '1', '2015-11-11', ''),
(9, 'MARTINEZ', 'Florence', 'MARTINEZ_Florence.jpg', '', '0943864321', 'florence.martinez@hotmail.com', 0, '', 'Rue ponts des cé, Angers 49000', '12 du 5/03/19', '2019-04-01', ''),
(10, 'BOBANGA', 'Cyr', 'BOBANGA_Cyr.jpg', '', '069600185 - 0758343531', 'bnjueui@gmail.com', 0, '', '20 rue de la parcheminerie 49100 Angers', 'xtrtrtr', '2019-02-07', ''),
(11, 'MOI', 'Toi', 'MOI_Toi.jpg', '', '06 54 21 30 08', 'toi.moi@yahoo.fr', 1, '', '12 allée paul bertin', '654086Y', '2020-09-01', '');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `RefService` int(11) NOT NULL AUTO_INCREMENT,
  `RefEntite` int(11) NOT NULL,
  `LibelService` varchar(255) NOT NULL,
  `InfoService` text NOT NULL,
  `ContactService` varchar(255) NOT NULL,
  PRIMARY KEY (`RefService`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`RefService`, `RefEntite`, `LibelService`, `InfoService`, `ContactService`) VALUES
(1, 3, 'Département Anglais', '-', ' 62 10 54 55'),
(2, 1, 'Service de la Scolarité', '--', '97 56 54 21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
