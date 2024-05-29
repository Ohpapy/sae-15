-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listing the structure of the database for rp09
DROP DATABASE IF EXISTS `rp09`;
CREATE DATABASE IF NOT EXISTS `rp09` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `rp09`;

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `num_ut` int(11) NOT NULL AUTO_INCREMENT,
  `login_ut` varchar(50) NOT NULL,
  `nom_ut` varchar(100) DEFAULT NULL,
  `mdp_ut` varchar(255) DEFAULT NULL,
  `acces_ut` tinyint(1) DEFAULT NULL,
  `bloque_ut` tinyint(1) DEFAULT NULL,
  `tentative_ut` int(11) DEFAULT NULL,
  `presence_ut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`num_ut`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `num_prog` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prog` text,
  PRIMARY KEY (`num_prog`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `num_log` int(11) NOT NULL AUTO_INCREMENT,
  `message` TEXT DEFAULT NULL,
  `type` TEXT DEFAULT NULL,
  PRIMARY KEY (`num_logs`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `phase`;
CREATE TABLE IF NOT EXISTS `phase` (
  `num_phase` int(11) NOT NULL AUTO_INCREMENT,
  `nom_phase` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`num_phase`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `motcles`;
CREATE TABLE IF NOT EXISTS `motcles` (
  `num_cles` int(11) NOT NULL AUTO_INCREMENT,
  `mot` text,
  PRIMARY KEY (`num_cles`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `bonnespratique`;
CREATE TABLE IF NOT EXISTS `bonnespratique` (
  `num_bp` int(11) NOT NULL AUTO_INCREMENT,
  `test_bp` text,
  `utilisation_bp` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`num_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `bp_motcles`;
CREATE TABLE IF NOT EXISTS `bp_motcles` (
  `num_bpmotcles` int(11) NOT NULL AUTO_INCREMENT,
  `num_bp` int(11) DEFAULT '0',
  `num_cles` int(11) DEFAULT '0',
  PRIMARY KEY (`num_bpmotcles`),
  KEY `num_bp` (`num_bp`),
  KEY `num_cles` (`num_cles`),
  CONSTRAINT `FK__bonnespratique` FOREIGN KEY (`num_bp`) REFERENCES `bonnespratique` (`num_bp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__motcles` FOREIGN KEY (`num_cles`) REFERENCES `motcles` (`num_cles`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `appartenance`;
CREATE TABLE IF NOT EXISTS `appartenance` (
  `num_app` int(11) NOT NULL AUTO_INCREMENT,
  `num_prog` int(11) DEFAULT NULL,
  `num_phase` int(11) DEFAULT NULL,
  `num_bp` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_app`),
  KEY `num_phase` (`num_phase`),
  KEY `num_bp` (`num_bp`),
  KEY `num_prog` (`num_prog`),
  CONSTRAINT `Appartenance_ibfk_2` FOREIGN KEY (`num_phase`) REFERENCES `phase` (`num_phase`),
  CONSTRAINT `Appartenance_ibfk_3` FOREIGN KEY (`num_bp`) REFERENCES `bonnespratique` (`num_bp`),
  CONSTRAINT `FK_appartenance_programme` FOREIGN KEY (`num_prog`) REFERENCES `programme` (`num_prog`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;


INSERT INTO `motcles` (`num_cles`, `mot`) VALUES
	(1, 'mathis'),
	(2, 'hello'),
	(3, 'bye');

INSERT INTO `phase` (`num_phase`, `nom_phase`) VALUES
	(1, 'analyse');
INSERT INTO `phase` (`num_phase`, `nom_phase`) VALUES
	(2, 'execution');
INSERT INTO `phase` (`num_phase`, `nom_phase`) VALUES
	(3, 'programmation');
INSERT INTO `phase` (`num_phase`, `nom_phase`) VALUES
	(4, 'codage');

INSERT INTO `programme` (`num_prog`, `nom_prog`) VALUES
	(1, 'PROG_1');
INSERT INTO `programme` (`num_prog`, `nom_prog`) VALUES
	(2, 'PROG_2');
INSERT INTO `programme` (`num_prog`, `nom_prog`) VALUES
	(3, 'GENERIQUE');


INSERT INTO `bonnespratique` (`num_bp`, `test_bp`, `utilisation_bp`) VALUES
	(1, 'test', 1),
	(2, 'test2', 1);

INSERT INTO `utilisateur` (`num_ut`, `login_ut`, `nom_ut`, `mdp_ut`, `acces_ut`, `bloque_ut`, `tentative_ut`, `presence_ut`) VALUES
	(1, 'admin', 'Mathis', '$2y$10$.OE6z63KaYqRGzpt5uGGcebJTajPVhnU1JE7wGkpZgNyIfxVNO9xS', 15, 0, 0, 0);

INSERT INTO `appartenance` (`num_app`, `num_prog`, `num_phase`, `num_bp`) VALUES
	(1, 1, 1, 1);
