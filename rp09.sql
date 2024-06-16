-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 16 juin 2024 à 12:19
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rp09`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenance`
--

CREATE TABLE `appartenance` (
  `num_app` int(11) NOT NULL,
  `num_prog` int(11) DEFAULT NULL,
  `num_phase` int(11) DEFAULT NULL,
  `num_bp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `appartenance`
--

INSERT INTO `appartenance` (`num_app`, `num_prog`, `num_phase`, `num_bp`) VALUES
(4, 3, 1, 4),
(5, 3, 3, 5),
(6, 2, 3, 6),
(10, 1, 3, 10),
(11, 1, 3, 11),
(12, 1, 3, 12),
(13, 1, 3, 13),
(15, 1, 3, 15),
(16, 1, 3, 16),
(17, 1, 3, 17),
(18, 1, 3, 18),
(19, 1, 1, 19),
(20, 1, 1, 20),
(21, 1, 1, 21),
(22, 1, 1, 22);

-- --------------------------------------------------------

--
-- Structure de la table `bonnespratique`
--

CREATE TABLE `bonnespratique` (
  `num_bp` int(11) NOT NULL,
  `test_bp` text,
  `utilisation_bp` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `bonnespratique`
--

INSERT INTO `bonnespratique` (`num_bp`, `test_bp`, `utilisation_bp`) VALUES
(2, 'oui', 1),
(4, 'décollage d\'un avion', 1),
(5, 'decollage', 1),
(6, 'vol long utiliser 1 ou 2', 1),
(10, 'creertest <test>avec option -c ou -p selon besoin', 1),
(11, 'modini <test>', 1),
(12, 'Modification du fichier conf dans sgse_proc si nécessaire', 1),
(13, 'Mettre à jour le fichier configuration/hw/<test>.dsc', 1),
(15, 'Vérifier que dans configuration/ctx, le fichier SADM_sensor_fea.dat a la valeur true pour les variables : - PRINT, Time, SADM_position.', 1),
(16, 'Mettre une instruction set_1553_Error pour chaque instrument PL utilisé : Set_1553_Error (\"1\", \"TIMEOUT\"); /* POSEIDON 1  = 1, POSEIDON 2 = 4 */ Set_1553_Error (\"7\", \"TIMEOUT\"); /* DORIS 1 = 7, DORIS 2 = 10 */', 1),
(17, 'Autoriser l\'utilisation de la FDTM durant le test', 1),
(18, 'Modifier la configuration du RM en cas de reconfiguration inattendue durant le test', 1),
(19, 'Vérifier que outputs et outputs_ctx sont accessibles en écriture', 1),
(20, 'Vérifier la présence du fichier de configuration du simulateur 1553 dans le répertoire input (fichier tvw.155) si cette fonction est utilisée', 1),
(21, 'Vérifier que l\'alimentation du DHU est ON', 1),
(22, 'ana_fonc <test> -c -v', 1);

-- --------------------------------------------------------

--
-- Structure de la table `bp_motcles`
--

CREATE TABLE `bp_motcles` (
  `num_bpmotcles` int(11) NOT NULL,
  `num_bp` int(11) DEFAULT '0',
  `num_cles` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bp_motcles`
--

INSERT INTO `bp_motcles` (`num_bpmotcles`, `num_bp`, `num_cles`) VALUES
(4, 2, 4),
(5, 2, 3),
(6, 2, 5),
(7, 2, 1),
(10, 4, 6),
(11, 4, 7),
(12, 4, 8),
(13, 4, 9),
(14, 5, 6),
(15, 5, 10),
(16, 5, 11),
(17, 5, 12),
(18, 6, 13),
(19, 6, 14),
(20, 6, 15),
(21, 6, 16),
(31, 10, 15),
(32, 11, 15),
(33, 12, 15),
(34, 13, 15),
(36, 15, 15),
(37, 16, 18),
(38, 16, 19),
(39, 17, 15),
(40, 17, 20),
(41, 18, 15),
(42, 18, 21),
(43, 19, 15),
(44, 20, 18),
(45, 21, 15),
(46, 22, 15);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `num_log` int(11) NOT NULL,
  `message` text,
  `type` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`num_log`, `message`, `type`, `date`, `nom`) VALUES
(83, 'Déconnexion de Mathis', 'SUPPRESSION UTILISATEUR', '2024-06-11 08:37:50', 'Mathis'),
(84, 'l\' utilisateur s\'est trompé: Mathis', 'MOT DE PASSE INCORRECT', '2024-06-11 08:37:54', NULL),
(85, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 08:07:47', 'Mathis'),
(86, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 11:01:51', 'Mathis'),
(87, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 11:11:29', 'Mathis'),
(88, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 11:20:00', 'Mathis'),
(89, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 11:36:21', 'Mathis'),
(90, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 11:44:35', 'Mathis'),
(91, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 13:27:47', 'Mathis'),
(92, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 13:42:04', 'Mathis'),
(93, 'Une bonne pratique a été créée avec cet ID: 28', 'CRÉATION BONNE PRATIQUE', '2024-06-12 13:49:18', 'Mathis'),
(94, 'Une bp a été supprimée avec cet ID: 3', 'SUPPRESSION BP', '2024-06-12 13:49:48', 'Mathis'),
(95, 'Une bp a été supprimée avec cet ID: 23', 'SUPPRESSION BP', '2024-06-12 13:49:50', 'Mathis'),
(96, 'Une bp a été supprimée avec cet ID: 24', 'SUPPRESSION BP', '2024-06-12 13:49:51', 'Mathis'),
(97, 'Une bp a été remise en utilisation avec cet ID: 25', 'REMISE EN UTILISATION BP', '2024-06-12 13:49:52', 'Mathis'),
(98, 'Une bp a été supprimée avec cet ID: 26', 'SUPPRESSION BP', '2024-06-12 13:49:53', 'Mathis'),
(99, 'Une bp a été supprimée avec cet ID: 27', 'SUPPRESSION BP', '2024-06-12 13:49:55', 'Mathis'),
(100, 'Une bp a été supprimée avec cet ID: 28', 'SUPPRESSION BP', '2024-06-12 13:49:56', 'Mathis'),
(101, 'Une bp a été supprimée avec cet ID: 25', 'SUPPRESSION BP', '2024-06-12 13:50:07', 'Mathis'),
(102, 'Un nouvel utilisateur a été créé avec cet ID: 4 son login est: create', 'CRÉATION UTILISATEUR', '2024-06-12 13:50:59', 'Mathis'),
(103, 'Un nouvel utilisateur a été créé avec cet ID: 5 son login est: supp', 'CRÉATION UTILISATEUR', '2024-06-12 13:51:26', 'Mathis'),
(104, 'Un utilisateur a été supprimé avec cet ID: 0 son login était: ', 'SUPPRESSION UTILISATEUR', '2024-06-12 13:51:31', 'Mathis'),
(105, 'Un nouvel utilisateur a été créé avec cet ID: 6 son login est: modif', 'CRÉATION UTILISATEUR', '2024-06-12 13:51:49', 'Mathis'),
(106, 'Un utilisateur a été mis à jour avec ce login: ', 'MISE À JOUR UTILISATEUR', '2024-06-12 13:52:01', 'Mathis'),
(107, 'Un nouveau programme a été créée avec cet ID4 son nom est: fff', 'CRÉATION PROGRAMME', '2024-06-12 13:52:07', 'Mathis'),
(108, 'Un programme a été supprimé son num est: 4', 'SUPPRESION PROGRAMME', '2024-06-12 13:52:11', 'Mathis'),
(109, 'La forme des mots de passe a été changée', 'MODIFICATION FORME MOT DE PASSE', '2024-06-12 13:52:54', 'Mathis'),
(110, 'Erreur pour la création utilisateur le mot de passe ne convien pas', 'ERREUR CREATION UTILISATEUR', '2024-06-12 13:54:14', 'Mathis'),
(111, 'La forme des mots de passe a été changée', 'MODIFICATION FORME MOT DE PASSE', '2024-06-12 13:54:20', 'Mathis'),
(112, 'Erreur pour la création utilisateur le mot de passe ne convien pas', 'ERREUR CREATION UTILISATEUR', '2024-06-12 13:54:36', 'Mathis'),
(113, 'La forme des mots de passe a été changée', 'MODIFICATION FORME MOT DE PASSE', '2024-06-12 13:54:47', 'Mathis'),
(114, 'Un nouvel utilisateur a été créé avec cet ID: 7 son login est: bloque', 'CRÉATION UTILISATEUR', '2024-06-12 13:54:59', 'Mathis'),
(115, 'Un nouvel utilisateur a été créé avec cet ID: 8 son login est: supp', 'CRÉATION UTILISATEUR', '2024-06-12 13:55:28', 'Mathis'),
(116, 'Un nouveau programme a été créée avec cet ID5 son nom est: Nouveau', 'CRÉATION PROGRAMME', '2024-06-12 13:55:45', 'Mathis'),
(117, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 14:37:47', 'Mathis'),
(118, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 14:53:43', 'Mathis'),
(119, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-12 15:06:07', 'Mathis'),
(120, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-14 11:33:54', 'Mathis'),
(121, 'Erreur pour la création utilisateur le mot de passe ne convien pas', 'ERREUR CREATION UTILISATEUR', '2024-06-14 11:36:58', 'Mathis'),
(122, 'Déconnexion de Mathis', 'SUPPRESSION UTILISATEUR', '2024-06-14 11:38:02', 'Mathis'),
(123, 'l\' utilisateur s\'est trompé: bloque', 'MOT DE PASSE INCORRECT', '2024-06-14 11:38:10', NULL),
(124, 'l\' utilisateur s\'est trompé: bloque', 'MOT DE PASSE INCORRECT', '2024-06-14 11:38:19', NULL),
(125, 'l\' utilisateur s\'est trompé: bloque', 'MOT DE PASSE INCORRECT', '2024-06-14 11:38:30', NULL),
(126, 'Un utilisateur est bloquébloque', 'BLOCAGE UTILISATEUR', '2024-06-14 11:38:31', NULL),
(127, 'Un utilisateur essaye de ce connecter avec un compet bloqué: ', 'TENTATIVE DE CONNEXION', '2024-06-14 11:38:56', NULL),
(128, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-14 11:39:01', 'Mathis'),
(129, 'Un utilisateur a été débloqué avec ce login: ', 'UTILISATEUR DÉBLOQUÉ', '2024-06-14 11:39:09', 'Mathis'),
(130, 'Un utilisateur a été débloqué avec ce login: ', 'UTILISATEUR DÉBLOQUÉ', '2024-06-14 11:39:13', 'Mathis'),
(131, 'Un utilisateur a été débloqué avec ce login: ', 'UTILISATEUR DÉBLOQUÉ', '2024-06-14 11:40:07', 'Mathis'),
(132, 'Un utilisateur est connecté: Mathis', 'UTILISATEUR CONNECTÉ', '2024-06-16 12:14:08', 'Mathis');

-- --------------------------------------------------------

--
-- Structure de la table `mdp`
--

CREATE TABLE `mdp` (
  `num_car` int(11) NOT NULL,
  `caractere` int(11) NOT NULL,
  `chiffre` int(11) NOT NULL,
  `majuscule` int(11) NOT NULL,
  `minuscule` int(11) NOT NULL,
  `carac` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `mdp`
--

INSERT INTO `mdp` (`num_car`, `caractere`, `chiffre`, `majuscule`, `minuscule`, `carac`) VALUES
(1, 5, 0, 0, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `motcles`
--

CREATE TABLE `motcles` (
  `num_cles` int(11) NOT NULL,
  `mot` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `motcles`
--

INSERT INTO `motcles` (`num_cles`, `mot`) VALUES
(1, 'tom'),
(2, 'mathis'),
(3, 'mot3'),
(4, 'prog'),
(5, 'non'),
(6, 'avion'),
(7, 'roue'),
(8, 'aeroport'),
(9, 'aile'),
(10, 'kayak'),
(11, 'thales'),
(12, 'depart'),
(13, '1'),
(14, '2'),
(15, 'tous'),
(16, 'boisson'),
(17, 'test'),
(18, 'PL'),
(19, 'POS3'),
(20, 'deploiement'),
(21, 'MeO'),
(22, 'bou'),
(23, 'azdcazcea'),
(24, 'azecazeazecace'),
(25, 'bonnepartique');

-- --------------------------------------------------------

--
-- Structure de la table `phase`
--

CREATE TABLE `phase` (
  `num_phase` int(11) NOT NULL,
  `nom_phase` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `phase`
--

INSERT INTO `phase` (`num_phase`, `nom_phase`) VALUES
(1, 'execution'),
(2, 'analyse\r\n'),
(3, 'codage\r\n'),
(4, 'programmation\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

CREATE TABLE `programme` (
  `num_prog` int(11) NOT NULL,
  `nom_prog` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `programme`
--

INSERT INTO `programme` (`num_prog`, `nom_prog`) VALUES
(1, 'PROG_1'),
(2, 'PROG_2'),
(3, 'GENERIQUE'),
(5, 'Nouveau');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `num_ut` int(11) NOT NULL,
  `login_ut` varchar(50) NOT NULL,
  `nom_ut` varchar(100) DEFAULT NULL,
  `mdp_ut` varchar(255) DEFAULT NULL,
  `acces_ut` tinyint(1) DEFAULT NULL,
  `bloque_ut` tinyint(1) DEFAULT NULL,
  `tentative_ut` int(11) DEFAULT NULL,
  `presence_ut` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`num_ut`, `login_ut`, `nom_ut`, `mdp_ut`, `acces_ut`, `bloque_ut`, `tentative_ut`, `presence_ut`) VALUES
(1, 'admin', 'Mathis', '$2y$10$.OE6z63KaYqRGzpt5uGGcebJTajPVhnU1JE7wGkpZgNyIfxVNO9xS', 15, 0, 0, 0),
(3, 'user', 'user', '$2y$10$LckjQW4yfRoCCQ.bua0iDO6.zCFoLDf9Dm3JL8VRphlQGh36s3edq', 1, 0, 0, 0),
(4, 'create', 'Creation', '$2y$10$zD8KrvF.nV/nf6tPagG8zuG/UZI.RaNYIDLGDJX.5nRh2fIgEZtI2', 15, 0, 0, 0),
(6, 'modif', 'modifier', '$2y$10$2H8M6YFz1UdJjPaAAPqD8uyGxNumb.y2a7cpUAXc26738O/9/gJXq', 15, 0, 0, 0),
(7, 'bloque', 'bloque', '$2y$10$uvJCSsdNLepQB1E67PyI..bEaHt9S7yuuYZqDxCpeTDA/flVcGx5G', 15, 1, 3, 0),
(8, 'supp', 'supp', '$2y$10$BorcSdh3eOek6HtPS0ug0.2Cs4ARVXFVBxW2mS4oDkvwAxnUPPwiG', 15, 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartenance`
--
ALTER TABLE `appartenance`
  ADD PRIMARY KEY (`num_app`),
  ADD KEY `num_phase` (`num_phase`),
  ADD KEY `num_bp` (`num_bp`),
  ADD KEY `num_prog` (`num_prog`);

--
-- Index pour la table `bonnespratique`
--
ALTER TABLE `bonnespratique`
  ADD PRIMARY KEY (`num_bp`);

--
-- Index pour la table `bp_motcles`
--
ALTER TABLE `bp_motcles`
  ADD PRIMARY KEY (`num_bpmotcles`),
  ADD KEY `num_bp` (`num_bp`),
  ADD KEY `num_cles` (`num_cles`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`num_log`);

--
-- Index pour la table `mdp`
--
ALTER TABLE `mdp`
  ADD PRIMARY KEY (`num_car`);

--
-- Index pour la table `motcles`
--
ALTER TABLE `motcles`
  ADD PRIMARY KEY (`num_cles`);

--
-- Index pour la table `phase`
--
ALTER TABLE `phase`
  ADD PRIMARY KEY (`num_phase`);

--
-- Index pour la table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`num_prog`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`num_ut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appartenance`
--
ALTER TABLE `appartenance`
  MODIFY `num_app` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `bonnespratique`
--
ALTER TABLE `bonnespratique`
  MODIFY `num_bp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `bp_motcles`
--
ALTER TABLE `bp_motcles`
  MODIFY `num_bpmotcles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `num_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT pour la table `mdp`
--
ALTER TABLE `mdp`
  MODIFY `num_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `motcles`
--
ALTER TABLE `motcles`
  MODIFY `num_cles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `phase`
--
ALTER TABLE `phase`
  MODIFY `num_phase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `programme`
--
ALTER TABLE `programme`
  MODIFY `num_prog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `num_ut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenance`
--
ALTER TABLE `appartenance`
  ADD CONSTRAINT `Appartenance_ibfk_2` FOREIGN KEY (`num_phase`) REFERENCES `phase` (`num_phase`),
  ADD CONSTRAINT `Appartenance_ibfk_3` FOREIGN KEY (`num_bp`) REFERENCES `bonnespratique` (`num_bp`),
  ADD CONSTRAINT `FK_appartenance_programme` FOREIGN KEY (`num_prog`) REFERENCES `programme` (`num_prog`);

--
-- Contraintes pour la table `bp_motcles`
--
ALTER TABLE `bp_motcles`
  ADD CONSTRAINT `FK__bonnespratique` FOREIGN KEY (`num_bp`) REFERENCES `bonnespratique` (`num_bp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__motcles` FOREIGN KEY (`num_cles`) REFERENCES `motcles` (`num_cles`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
