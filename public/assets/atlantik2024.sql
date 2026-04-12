-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 avr. 2024 à 16:13
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `atlantik2024`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `IDENTIFIANT` varchar(40) NOT NULL,
  `MOTDEPASSE` varchar(60) NOT NULL,
  `PROFIL` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bateau`
--

CREATE TABLE `bateau` (
  `NOBATEAU` int(11) NOT NULL,
  `NOM` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bateau`
--

INSERT INTO `bateau` (`NOBATEAU`, `NOM`) VALUES
(1, 'Kor’ Ant'),
(2, 'Ar Solen'),
(3, 'Al’xi'),
(4, 'Luce isle'),
(5, 'Maëllys');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `LETTRECATEGORIE` char(1) NOT NULL,
  `LIBELLE` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`LETTRECATEGORIE`, `LIBELLE`) VALUES
('A', 'Passager'),
('B', 'Véh.inf.2m'),
('C', 'Véh.sup.2m');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `NOCLIENT` int(11) NOT NULL,
  `NOM` varchar(60) NOT NULL,
  `PRENOM` varchar(60) NOT NULL,
  `ADRESSE` varchar(128) NOT NULL,
  `CODEPOSTAL` int(11) NOT NULL,
  `VILLE` varchar(80) NOT NULL,
  `TELEPHONEFIXE` varchar(16) DEFAULT NULL,
  `TELEPHONEMOBILE` varchar(16) DEFAULT NULL,
  `MEL` varchar(80) DEFAULT NULL,
  `MOTDEPASSE` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`NOCLIENT`, `NOM`, `PRENOM`, `ADRESSE`, `CODEPOSTAL`, `VILLE`, `TELEPHONEFIXE`, `TELEPHONEMOBILE`, `MEL`, `MOTDEPASSE`) VALUES
(1, 'TIPREZ', 'Yann', '15 rue de l\'industrie', 19290, 'PEYRELEVADE', '02.96.10.10.10', '06.96.10.10.10', 'tiprez@rabelais.fr', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOBATEAU` int(11) NOT NULL,
  `CAPACITEMAX` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`LETTRECATEGORIE`, `NOBATEAU`, `CAPACITEMAX`) VALUES
('A', 1, 100),
('A', 2, 200),
('A', 3, 300),
('A', 4, 400),
('A', 5, 500),
('B', 1, 10),
('B', 2, 20),
('B', 3, 30),
('B', 4, 40),
('B', 5, 50),
('C', 1, 1),
('C', 2, 2),
('C', 3, 3),
('C', 4, 4),
('C', 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrer`
--

CREATE TABLE `enregistrer` (
  `NORESERVATION` int(11) NOT NULL,
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOTYPE` smallint(6) NOT NULL,
  `QUANTITERESERVEE` int(11) NOT NULL,
  `QUANTITEEMBARQUEE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enregistrer`
--

INSERT INTO `enregistrer` (`NORESERVATION`, `LETTRECATEGORIE`, `NOTYPE`, `QUANTITERESERVEE`, `QUANTITEEMBARQUEE`) VALUES
(1, 'A', 1, 2, 0),
(1, 'A', 2, 1, 0),
(1, 'A', 3, 2, 0),
(1, 'B', 2, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `liaison`
--

CREATE TABLE `liaison` (
  `NOLIAISON` int(11) NOT NULL,
  `NOPORT_DEPART` int(11) NOT NULL,
  `NOSECTEUR` int(11) NOT NULL,
  `NOPORT_ARRIVEE` int(11) NOT NULL,
  `DISTANCE` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liaison`
--

INSERT INTO `liaison` (`NOLIAISON`, `NOPORT_DEPART`, `NOSECTEUR`, `NOPORT_ARRIVEE`, `DISTANCE`) VALUES
(1, 1, 3, 2, 8.30),
(2, 2, 3, 1, 9.00),
(3, 1, 3, 3, 8.00),
(4, 3, 3, 1, 7.90),
(5, 6, 6, 7, 7.70),
(6, 7, 6, 6, 7.40);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `NOIDENTIFIANT` smallint(6) NOT NULL,
  `SITE_PB` varchar(20) DEFAULT NULL,
  `RANG_PB` varchar(128) DEFAULT NULL,
  `IDENTIFIANT_PB` varchar(20) DEFAULT NULL,
  `CLEHMAC_PB` varchar(255) DEFAULT NULL,
  `ENPRODUCTION` tinyint(1) DEFAULT NULL,
  `MELSITE` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `passager`
--

CREATE TABLE `passager` (
  `NORESERVATION` int(11) NOT NULL,
  `NUMERO` smallint(6) NOT NULL,
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOTYPE` smallint(6) NOT NULL,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(50) NOT NULL,
  `DATENAISSANCE` date NOT NULL,
  `EMBARQUE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `NOPERIODE` smallint(6) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`NOPERIODE`, `DATEDEBUT`, `DATEFIN`) VALUES
(1, '2020-06-07', '2020-09-15'),
(2, '2020-09-16', '2021-06-15'),
(3, '2021-06-16', '2021-09-15'),
(4, '2021-09-16', '2022-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `port`
--

CREATE TABLE `port` (
  `NOPORT` int(11) NOT NULL,
  `NOM` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `port`
--

INSERT INTO `port` (`NOPORT`, `NOM`) VALUES
(1, 'Quiberon'),
(2, 'Le Palais'),
(3, 'Sauzon'),
(4, 'Vannes'),
(5, 'Port St Gildas'),
(6, 'Lorient'),
(7, 'Port-Tudy');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `NORESERVATION` int(11) NOT NULL,
  `NOTRAVERSEE` int(11) NOT NULL,
  `NOCLIENT` int(11) NOT NULL,
  `DATEHEURE` datetime NOT NULL,
  `MONTANTTOTAL` double(5,2) NOT NULL,
  `PAYE` tinyint(1) NOT NULL,
  `MODEREGLEMENT` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`NORESERVATION`, `NOTRAVERSEE`, `NOCLIENT`, `DATEHEURE`, `MONTANTTOTAL`, `PAYE`, `MODEREGLEMENT`) VALUES
(1, 1, 1, '2021-04-28 19:20:00', 209.10, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

CREATE TABLE `secteur` (
  `NOSECTEUR` int(11) NOT NULL,
  `NOM` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `secteur`
--

INSERT INTO `secteur` (`NOSECTEUR`, `NOM`) VALUES
(1, 'Aix'),
(2, 'Batz'),
(3, 'Belle-Ile-en-Mer'),
(4, 'Bréhat'),
(5, 'Houat'),
(6, 'Ile de Groix'),
(7, 'Molène'),
(8, 'Ouessant'),
(9, 'Sein'),
(10, 'Yeu');

-- --------------------------------------------------------

--
-- Structure de la table `tarifer`
--

CREATE TABLE `tarifer` (
  `NOPERIODE` smallint(6) NOT NULL,
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOTYPE` smallint(6) NOT NULL,
  `NOLIAISON` int(11) NOT NULL,
  `TARIF` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tarifer`
--

INSERT INTO `tarifer` (`NOPERIODE`, `LETTRECATEGORIE`, `NOTYPE`, `NOLIAISON`, `TARIF`) VALUES
(1, 'A', 1, 1, 17.00),
(1, 'A', 2, 1, 10.10),
(1, 'A', 3, 1, 4.60),
(1, 'B', 1, 1, 76.00),
(1, 'B', 2, 1, 119.00),
(1, 'C', 1, 1, 179.00),
(1, 'C', 2, 1, 195.00),
(1, 'C', 3, 1, 258.00),
(2, 'A', 1, 1, 18.00),
(2, 'A', 2, 1, 11.10),
(2, 'A', 3, 1, 5.60),
(2, 'B', 1, 1, 86.00),
(2, 'B', 2, 1, 129.00),
(2, 'C', 1, 1, 189.00),
(2, 'C', 2, 1, 205.00),
(2, 'C', 3, 1, 268.00),
(3, 'A', 1, 1, 20.00),
(3, 'A', 2, 1, 13.10),
(3, 'A', 3, 1, 7.00),
(3, 'B', 1, 1, 95.00),
(3, 'B', 2, 1, 142.00),
(3, 'C', 1, 1, 208.00),
(3, 'C', 2, 1, 226.00),
(3, 'C', 3, 1, 295.00),
(4, 'A', 1, 1, 19.00),
(4, 'A', 2, 1, 12.10),
(4, 'A', 3, 1, 6.40),
(4, 'B', 1, 1, 91.00),
(4, 'B', 2, 1, 136.00),
(4, 'C', 1, 1, 199.00),
(4, 'C', 2, 1, 216.00),
(4, 'C', 3, 1, 282.00);

-- --------------------------------------------------------

--
-- Structure de la table `traversee`
--

CREATE TABLE `traversee` (
  `NOTRAVERSEE` int(11) NOT NULL,
  `NOLIAISON` int(11) NOT NULL,
  `NOBATEAU` int(11) NOT NULL,
  `DATEHEUREDEPART` datetime NOT NULL,
  `DATEHEUREARRIVEE` datetime NOT NULL,
  `CLOTUREEMBARQUEMENT` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `traversee`
--

INSERT INTO `traversee` (`NOTRAVERSEE`, `NOLIAISON`, `NOBATEAU`, `DATEHEUREDEPART`, `DATEHEUREARRIVEE`, `CLOTUREEMBARQUEMENT`) VALUES
(1, 1, 1, '2021-07-10 07:45:00', '2021-07-10 09:00:00', 0),
(2, 1, 2, '2021-07-10 09:45:00', '2021-07-10 11:00:00', 0),
(3, 1, 3, '2021-07-10 11:45:00', '2021-07-10 13:00:00', 0),
(4, 1, 4, '2021-07-10 13:45:00', '2021-07-10 15:00:00', 0),
(5, 1, 1, '2021-07-10 15:45:00', '2021-07-10 17:00:00', 0),
(6, 1, 2, '2021-07-10 17:45:00', '2021-07-10 19:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOTYPE` smallint(6) NOT NULL,
  `LIBELLE` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`LETTRECATEGORIE`, `NOTYPE`, `LIBELLE`) VALUES
('A', 1, 'Adulte'),
('A', 2, 'Junior 8 à 18 ans'),
('A', 3, 'Enfant 0 à 7 ans'),
('B', 1, 'Voiture long.inf.4m'),
('B', 2, 'Voiture long.inf.5m'),
('C', 1, 'Fourgon'),
('C', 2, 'Camping Car'),
('C', 3, 'Camion');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `NORESERVATION` int(11) NOT NULL,
  `IMMATRICULATION` varchar(15) NOT NULL,
  `LETTRECATEGORIE` char(1) NOT NULL,
  `NOTYPE` smallint(6) NOT NULL,
  `EMBARQUE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`IDENTIFIANT`);

--
-- Index pour la table `bateau`
--
ALTER TABLE `bateau`
  ADD PRIMARY KEY (`NOBATEAU`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`LETTRECATEGORIE`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NOCLIENT`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`LETTRECATEGORIE`,`NOBATEAU`),
  ADD KEY `I_FK_CONTENIR_CATEGORIE` (`LETTRECATEGORIE`),
  ADD KEY `I_FK_CONTENIR_BATEAU` (`NOBATEAU`);

--
-- Index pour la table `enregistrer`
--
ALTER TABLE `enregistrer`
  ADD PRIMARY KEY (`NORESERVATION`,`LETTRECATEGORIE`,`NOTYPE`),
  ADD KEY `I_FK_ENREGISTRER_RESERVATION` (`NORESERVATION`),
  ADD KEY `I_FK_ENREGISTRER_TYPE` (`LETTRECATEGORIE`,`NOTYPE`);

--
-- Index pour la table `liaison`
--
ALTER TABLE `liaison`
  ADD PRIMARY KEY (`NOLIAISON`),
  ADD KEY `I_FK_LIAISON_PORT_DEPART` (`NOPORT_DEPART`),
  ADD KEY `I_FK_LIAISON_SECTEUR` (`NOSECTEUR`),
  ADD KEY `I_FK_LIAISON_PORT_ARRIVEE` (`NOPORT_ARRIVEE`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`NOIDENTIFIANT`);

--
-- Index pour la table `passager`
--
ALTER TABLE `passager`
  ADD PRIMARY KEY (`NORESERVATION`,`NUMERO`),
  ADD KEY `I_FK_PASSAGER_TYPE` (`LETTRECATEGORIE`,`NOTYPE`),
  ADD KEY `I_FK_PASSAGER_RESERVATION` (`NORESERVATION`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`NOPERIODE`);

--
-- Index pour la table `port`
--
ALTER TABLE `port`
  ADD PRIMARY KEY (`NOPORT`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`NORESERVATION`),
  ADD KEY `I_FK_RESERVATION_TRAVERSEE` (`NOTRAVERSEE`),
  ADD KEY `I_FK_RESERVATION_CLIENT` (`NOCLIENT`);

--
-- Index pour la table `secteur`
--
ALTER TABLE `secteur`
  ADD PRIMARY KEY (`NOSECTEUR`);

--
-- Index pour la table `tarifer`
--
ALTER TABLE `tarifer`
  ADD PRIMARY KEY (`NOPERIODE`,`LETTRECATEGORIE`,`NOTYPE`,`NOLIAISON`),
  ADD KEY `I_FK_TARIFER_PERIODE` (`NOPERIODE`),
  ADD KEY `I_FK_TARIFER_TYPE` (`LETTRECATEGORIE`,`NOTYPE`),
  ADD KEY `I_FK_TARIFER_LIAISON` (`NOLIAISON`);

--
-- Index pour la table `traversee`
--
ALTER TABLE `traversee`
  ADD PRIMARY KEY (`NOTRAVERSEE`),
  ADD KEY `I_FK_TRAVERSEE_LIAISON` (`NOLIAISON`),
  ADD KEY `I_FK_TRAVERSEE_BATEAU` (`NOBATEAU`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`LETTRECATEGORIE`,`NOTYPE`),
  ADD KEY `I_FK_TYPE_CATEGORIE` (`LETTRECATEGORIE`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`NORESERVATION`,`IMMATRICULATION`),
  ADD KEY `I_FK_VEHICULE_TYPE` (`LETTRECATEGORIE`,`NOTYPE`),
  ADD KEY `I_FK_VEHICULE_RESERVATION` (`NORESERVATION`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bateau`
--
ALTER TABLE `bateau`
  MODIFY `NOBATEAU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `NOCLIENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `liaison`
--
ALTER TABLE `liaison`
  MODIFY `NOLIAISON` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `port`
--
ALTER TABLE `port`
  MODIFY `NOPORT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `NORESERVATION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `secteur`
--
ALTER TABLE `secteur`
  MODIFY `NOSECTEUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `traversee`
--
ALTER TABLE `traversee`
  MODIFY `NOTRAVERSEE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `FK_CONTENIR_BATEAU` FOREIGN KEY (`NOBATEAU`) REFERENCES `bateau` (`NOBATEAU`),
  ADD CONSTRAINT `FK_CONTENIR_CATEGORIE` FOREIGN KEY (`LETTRECATEGORIE`) REFERENCES `categorie` (`LETTRECATEGORIE`);

--
-- Contraintes pour la table `enregistrer`
--
ALTER TABLE `enregistrer`
  ADD CONSTRAINT `FK_ENREGISTRER_RESERVATION` FOREIGN KEY (`NORESERVATION`) REFERENCES `reservation` (`NORESERVATION`),
  ADD CONSTRAINT `FK_ENREGISTRER_TYPE` FOREIGN KEY (`LETTRECATEGORIE`,`NOTYPE`) REFERENCES `type` (`LETTRECATEGORIE`, `NOTYPE`);

--
-- Contraintes pour la table `liaison`
--
ALTER TABLE `liaison`
  ADD CONSTRAINT `FK_LIAISON_PORT_ARRIVEE` FOREIGN KEY (`NOPORT_ARRIVEE`) REFERENCES `port` (`NOPORT`),
  ADD CONSTRAINT `FK_LIAISON_PORT_DEPART` FOREIGN KEY (`NOPORT_DEPART`) REFERENCES `port` (`NOPORT`),
  ADD CONSTRAINT `FK_LIAISON_SECTEUR` FOREIGN KEY (`NOSECTEUR`) REFERENCES `secteur` (`NOSECTEUR`);

--
-- Contraintes pour la table `passager`
--
ALTER TABLE `passager`
  ADD CONSTRAINT `FK_PASSAGER_RESERVATION` FOREIGN KEY (`NORESERVATION`) REFERENCES `reservation` (`NORESERVATION`),
  ADD CONSTRAINT `FK_PASSAGER_TYPE` FOREIGN KEY (`LETTRECATEGORIE`,`NOTYPE`) REFERENCES `type` (`LETTRECATEGORIE`, `NOTYPE`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_RESERVATION_CLIENT` FOREIGN KEY (`NOCLIENT`) REFERENCES `client` (`NOCLIENT`),
  ADD CONSTRAINT `FK_RESERVATION_TRAVERSEE` FOREIGN KEY (`NOTRAVERSEE`) REFERENCES `traversee` (`NOTRAVERSEE`);

--
-- Contraintes pour la table `tarifer`
--
ALTER TABLE `tarifer`
  ADD CONSTRAINT `FK_TARIFER_LIAISON` FOREIGN KEY (`NOLIAISON`) REFERENCES `liaison` (`NOLIAISON`),
  ADD CONSTRAINT `FK_TARIFER_PERIODE` FOREIGN KEY (`NOPERIODE`) REFERENCES `periode` (`NOPERIODE`),
  ADD CONSTRAINT `FK_TARIFER_TYPE` FOREIGN KEY (`LETTRECATEGORIE`,`NOTYPE`) REFERENCES `type` (`LETTRECATEGORIE`, `NOTYPE`);

--
-- Contraintes pour la table `traversee`
--
ALTER TABLE `traversee`
  ADD CONSTRAINT `FK_TRAVERSEE_BATEAU` FOREIGN KEY (`NOBATEAU`) REFERENCES `bateau` (`NOBATEAU`),
  ADD CONSTRAINT `FK_TRAVERSEE_LIAISON` FOREIGN KEY (`NOLIAISON`) REFERENCES `liaison` (`NOLIAISON`);

--
-- Contraintes pour la table `type`
--
ALTER TABLE `type`
  ADD CONSTRAINT `FK_TYPE_CATEGORIE` FOREIGN KEY (`LETTRECATEGORIE`) REFERENCES `categorie` (`LETTRECATEGORIE`);

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_VEHICULE_RESERVATION` FOREIGN KEY (`NORESERVATION`) REFERENCES `reservation` (`NORESERVATION`),
  ADD CONSTRAINT `FK_VEHICULE_TYPE` FOREIGN KEY (`LETTRECATEGORIE`,`NOTYPE`) REFERENCES `type` (`LETTRECATEGORIE`, `NOTYPE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
