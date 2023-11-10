-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 nov. 2023 à 10:06
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `touiteur`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `idImage` int(5) NOT NULL,
  `cheminImage` varchar(100) DEFAULT NULL,
  `descriptionImage` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notation`
--

CREATE TABLE `notation` (
  `idTouite` int(5) NOT NULL,
  `idUtil` int(5) NOT NULL,
  `note` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivretag`
--

CREATE TABLE `suivretag` (
  `idUtil` int(5) NOT NULL,
  `idTag` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivreutil`
--

CREATE TABLE `suivreutil` (
  `idUtil` int(5) NOT NULL,
  `idUtilSuivi` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `idTag` int(5) NOT NULL,
  `libelleTag` varchar(50) DEFAULT NULL,
  `descriptionTag` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tag2touite`
--

CREATE TABLE `tag2touite` (
  `idTag` int(5) DEFAULT NULL,
  `idTouite` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `touite`
--

CREATE TABLE `touite` (
  `idTouite` int(5) NOT NULL,
  `idUtil` int(5) NOT NULL,
  `idImage` int(5) DEFAULT NULL,
  `texteTouite` varchar(235) DEFAULT NULL,
  `datePubli` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user2like`
--

CREATE TABLE `user2like` (
  `idUtil` int(5) NOT NULL,
  `idTouite` int(5) NOT NULL,
  `dlike` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `util`
--

CREATE TABLE `util` (
  `idUtil` int(5) NOT NULL,
  `nomUtil` varchar(30) DEFAULT NULL,
  `prenomUtil` varchar(30) DEFAULT NULL,
  `emailUtil` varchar(256) DEFAULT NULL,
  `passwd` varchar(256) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`idImage`);

--
-- Index pour la table `notation`
--
ALTER TABLE `notation`
  ADD PRIMARY KEY (`idTouite`,`idUtil`);

--
-- Index pour la table `suivretag`
--
ALTER TABLE `suivretag`
  ADD PRIMARY KEY (`idUtil`,`idTag`);

--
-- Index pour la table `suivreutil`
--
ALTER TABLE `suivreutil`
  ADD PRIMARY KEY (`idUtil`,`idUtilSuivi`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`idTag`);

--
-- Index pour la table `touite`
--
ALTER TABLE `touite`
  ADD PRIMARY KEY (`idTouite`);

--
-- Index pour la table `user2like`
--
ALTER TABLE `user2like`
  ADD PRIMARY KEY (`idUtil`,`idTouite`);

--
-- Index pour la table `util`
--
ALTER TABLE `util`
  ADD PRIMARY KEY (`idUtil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `idImage` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `idTag` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `touite`
--
ALTER TABLE `touite`
  MODIFY `idTouite` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `util`
--
ALTER TABLE `util`
  MODIFY `idUtil` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
