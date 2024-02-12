-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 12 fév. 2024 à 17:51
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `TestAPI`
--
CREATE DATABASE IF NOT EXISTS `TestAPI` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TestAPI`;

-- --------------------------------------------------------

--
-- Structure de la table `Joueurs`
--

CREATE TABLE `Joueurs` (
  `Id` int(11) NOT NULL,
  `NomJoueur` varchar(255) DEFAULT NULL,
  `ThemeChoisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Joueurs`
--

INSERT INTO `Joueurs` (`Id`, `NomJoueur`, `ThemeChoisi`) VALUES
(4, 'Simon', 'Fantasy Médiévale'),
(5, 'Simon', 'Horreur'),
(6, 'Jean Pierre', 'Horreur'),
(7, 'Simon', 'Science-Fiction'),
(8, 'Simon', 'Survie'),
(26, 'dd', 'Post-Apocalyptique'),
(51, 'S', 'Survie'),
(52, 'e', 'Horreur');

-- --------------------------------------------------------

--
-- Structure de la table `openaikey`
--

CREATE TABLE `openaikey` (
  `id` int(11) NOT NULL,
  `key` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `openaikey`
--

INSERT INTO `openaikey` (`id`, `key`) VALUES
(1, 'sk-f4qM7FLjx17lY0D4hrRVT3BlbkFJI8sMz1T5JuWKdZXOhtv');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Joueurs`
--
ALTER TABLE `Joueurs`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `openaikey`
--
ALTER TABLE `openaikey`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Joueurs`
--
ALTER TABLE `Joueurs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `openaikey`
--
ALTER TABLE `openaikey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
