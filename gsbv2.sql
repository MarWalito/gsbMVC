-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 03 nov. 2021 à 11:32
-- Version du serveur :  5.7.26
-- Version de PHP : 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

DROP TABLE IF EXISTS `fichefrais`;
CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
('456a', '202109', 0, '0.00', '2021-10-07', 'CL'),
('456a', '202110', 0, '0.00', '2021-11-02', 'CL'),
('456a', '202111', 0, '0.00', '2021-11-02', 'CR'),
('789b', '202111', 0, '0.00', '2021-11-03', 'CR'),
('a131', '202109', 0, '0.00', '2021-10-07', 'CL'),
('a131', '202110', 0, '0.00', '2021-10-07', 'CR'),
('b34', '202110', 0, '0.00', '2021-10-07', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

DROP TABLE IF EXISTS `fraisforfait`;
CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.65'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

DROP TABLE IF EXISTS `lignefraisforfait`;
CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('456a', '202109', 'ETP', 10),
('456a', '202109', 'KM', 10),
('456a', '202109', 'NUI', 101),
('456a', '202109', 'REP', 102),
('456a', '202110', 'ETP', 10),
('456a', '202110', 'KM', 10),
('456a', '202110', 'NUI', 10),
('456a', '202110', 'REP', 10),
('456a', '202111', 'ETP', 20),
('456a', '202111', 'KM', 20),
('456a', '202111', 'NUI', 20),
('456a', '202111', 'REP', 20),
('789b', '202111', 'ETP', 0),
('789b', '202111', 'KM', 0),
('789b', '202111', 'NUI', 0),
('789b', '202111', 'REP', 0),
('a131', '202109', 'ETP', 0),
('a131', '202109', 'KM', 0),
('a131', '202109', 'NUI', 0),
('a131', '202109', 'REP', 0),
('a131', '202110', 'ETP', 10),
('a131', '202110', 'KM', 10),
('a131', '202110', 'NUI', 10),
('a131', '202110', 'REP', 10),
('b34', '202110', 'ETP', 0),
('b34', '202110', 'KM', 0),
('b34', '202110', 'NUI', 0),
('b34', '202110', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

DROP TABLE IF EXISTS `lignefraishorsforfait`;
CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, '456a', '202111', 'Stylo Bic Rouge', '2021-01-22', '50.00');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(100) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `typeUtilisateur` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `typeUtilisateur`) VALUES
('456a', 'oui', 'oui', 'oui', '5898fc860300e228dcd54c0b1045b5fa0dcda502', 'oui', NULL, NULL, NULL, 'C'),
('789b', 'non', 'non', 'non', '37031f99ac78580c9f82e04fa237d295ea10ca41', NULL, NULL, NULL, '2021-11-03', 'V'),
('a131', 'Villechalane', 'Louis', 'lvillachane', '3abf9eb797afe468902101efe6b4b00f7d50802a', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', NULL),
('a17', 'Andre', 'David', 'dandre', '12e0b9be32932a8028b0ef0432a0a0a99421f745', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', NULL),
('a55', 'Bedos', 'Christian', 'cbedos', 'a34b9dfadee33917a63c3cdebdc9526230611f0b', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', NULL),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'f1c1d39e9898f3202a2eaa3dc38ae61575cd77ad', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', NULL),
('b13', 'Bentot', 'Pascal', 'pbentot', '178e1efaf000fdf2267edc43fad2a65197a0ab10', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', NULL),
('b16', 'Bioret', 'Luc', 'lbioret', 'ab7fa51f9bf8fde35d9e5bcc5066d3b71dda00d2', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', NULL),
('b19', 'Bunisset', 'Francis', 'fbunisset', 'aa710ca3a1f12234bc2872aa0a6f88d6cf896ae4', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', NULL),
('b25', 'Bunisset', 'Denise', 'dbunisset', '40ff56dc0525aa08de29eba96271997a91e7d405', '23 rue Manin', '75019', 'paris', '2010-12-05', NULL),
('b28', 'Cacheux', 'Bernard', 'bcacheux', '51a4fac4890def1ef8605f0b2e6554c86b2eb919', '114 rue Blanche', '75017', 'Paris', '2009-11-12', NULL),
('b34', 'Cadic', 'Eric', 'ecadic', '2ed5ee95d2588be3650a935ff7687dee46d70fc8', '123 avenue de la République', '75011', 'Paris', '2008-09-23', NULL),
('b4', 'Charoze', 'Catherine', 'ccharoze', '8b16cf71ab0842bd871bce99a1ba61dd7e9d4423', '100 rue Petit', '75019', 'Paris', '2005-11-12', NULL),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '7ddda57eca7a823c85ac0441adf56928b47ece76', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', NULL),
('b59', 'Cottin', 'Vincenne', 'vcottin', '2f95d1cac7b8e7459376bf36b93ae7333026282d', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', NULL),
('c14', 'Daburon', 'François', 'fdaburon', '5c7cc4a7f0123460c29c84d8f8a73bc86184adbb', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', NULL),
('c3', 'De', 'Philippe', 'pde', '03b03872dd570959311f4fb9be01788e4d1a2abf', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', NULL),
('c54', 'Debelle', 'Michel', 'mdebelle', '1fa95c2fac5b14c6386b73cbe958b663fc66fdfa', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', NULL),
('d13', 'Debelle', 'Jeanne', 'jdebelle', '18c2cad6adb7cee7884f70108cfd0a9b448be9be', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', NULL),
('d51', 'Debroise', 'Michel', 'mdebroise', '46b609fe3aaa708f5606469b5bc1c0fa85010d76', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', NULL),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'abc20ea01dabd079ddd63fd9006e7232e442973c', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', NULL),
('e24', 'Desnost', 'Pierre', 'pdesnost', '8eaa8011ec8aa8baa63231a21d12f4138ccc1a3d', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', NULL),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '55072fa16c988da8f1fb31e40e4ac5f325ac145d', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', NULL),
('e49', 'Duncombe', 'Claude', 'cduncombe', '577576f0b2c56c43b596f701b782870c8742c592', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', NULL),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', 'cc0fb4115bb04c613fd1b95f4792fc44f07e9f4f', '25 place de la gare', '23200', 'Gueret', '1995-09-01', NULL),
('e52', 'Eynde', 'Valérie', 'veynde', 'd06ace8d729693904c304625e6a6fab6ab9e9746', '3 Grand Place', '13015', 'Marseille', '1999-11-01', NULL),
('f21', 'Finck', 'Jacques', 'jfinck', '6d8b2060b60132d9bdb09d37913fbef637b295f2', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', NULL),
('f39', 'Frémont', 'Fernande', 'ffremont', 'aa45efe9ecbf37db0089beeedea62ceb57db7f17', '4 route de la mer', '13012', 'Allauh', '1998-10-01', NULL),
('f4', 'Gest', 'Alain', 'agest', '1af7dedacbbe8ce324e316429a816daeff4c542f', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `FicheFrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FicheFrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `LigneFraisForfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `LigneFraisForfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `LigneFraisHorsForfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
