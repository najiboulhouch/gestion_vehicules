-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour db_vehicules_v2
CREATE DATABASE IF NOT EXISTS `db_vehicules_v2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_vehicules_v2`;

-- Listage de la structure de la table db_vehicules_v2. carburant
CREATE TABLE IF NOT EXISTS `carburant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_carburant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.carburant : ~3 rows (environ)
/*!40000 ALTER TABLE `carburant` DISABLE KEYS */;
INSERT INTO `carburant` (`id`, `nom_carburant`) VALUES
	(1, 'Diesel'),
	(2, 'Essence'),
	(3, 'Hybride');
/*!40000 ALTER TABLE `carburant` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. client
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.client : ~5 rows (environ)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `nom_client`, `adresse`, `tel`, `email`) VALUES
	(1, 'NAJIB', 'Route Kenitra, Résidence Kenza', '564545', 'developersgroups@gmail.com'),
	(3, 'najib OULHOUCH', '309,rue ahmed\r\ncsdfsd', '0653804562', 'developersgroups@gmail.com'),
	(4, 'najib OULHOUCH', '309,rue ahmed\r\ncsdfsd', '0653804562', 'developersgroups@gmail.com'),
	(5, 'NAJIB', 'Route Kenitra, Résidence Kenza\r\nBloc B, Imm M, App 3, SALE', '0653804562', 'najib.oulhouch@gmail.com'),
	(6, 'najib OULHOUCH', '309,rue ahmed\r\ncsdfsd', '0653804562', 'developersgroups@gmail.com');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `voiure_id` int(11) NOT NULL,
  `date_rdv` date NOT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EEAA67D19EB6921` (`client_id`),
  KEY `IDX_6EEAA67D3F50211E` (`voiure_id`),
  CONSTRAINT `FK_6EEAA67D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  CONSTRAINT `FK_6EEAA67D3F50211E` FOREIGN KEY (`voiure_id`) REFERENCES `voiture` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.commande : ~5 rows (environ)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`id`, `client_id`, `voiure_id`, `date_rdv`, `commentaire`) VALUES
	(1, 1, 2, '2016-01-01', 'ddd'),
	(2, 3, 1, '2021-09-20', 'fsdfsd'),
	(3, 4, 1, '2021-09-20', 'fsdfsd'),
	(4, 5, 1, '2021-09-20', 'sdfsdfsd'),
	(5, 6, 1, '2021-09-20', 'dsqdqsd');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. couleur
CREATE TABLE IF NOT EXISTS `couleur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_couleur` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.couleur : ~5 rows (environ)
/*!40000 ALTER TABLE `couleur` DISABLE KEYS */;
INSERT INTO `couleur` (`id`, `nom_couleur`) VALUES
	(1, 'Noire'),
	(2, 'Rouge'),
	(3, 'Blanche'),
	(4, 'Grise'),
	(5, 'Vert');
/*!40000 ALTER TABLE `couleur` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table db_vehicules_v2.doctrine_migration_versions : ~3 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20210914231901', '2021-09-14 23:20:02', 9220),
	('DoctrineMigrations\\Version20210918211259', '2021-09-18 21:15:30', 3453),
	('DoctrineMigrations\\Version20210920085820', '2021-09-20 08:58:42', 829);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modele_id` int(11) NOT NULL,
  `nom_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FAC14B70A` (`modele_id`),
  CONSTRAINT `FK101455454` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.image : ~2 rows (environ)
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` (`id`, `modele_id`, `nom_image`) VALUES
	(1, 1, 'images/classA.jpg'),
	(2, 1, 'images/clio4.jpg');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. marque
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.marque : ~4 rows (environ)
/*!40000 ALTER TABLE `marque` DISABLE KEYS */;
INSERT INTO `marque` (`id`, `nom_marque`) VALUES
	(1, 'Dacia'),
	(2, 'Renault'),
	(3, 'Peugeot'),
	(4, 'Mercedes');
/*!40000 ALTER TABLE `marque` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. modele
CREATE TABLE IF NOT EXISTS `modele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque_id` int(11) NOT NULL,
  `nom_modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_100285584827B9B2` (`marque_id`),
  CONSTRAINT `FK_100285584827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.modele : ~8 rows (environ)
/*!40000 ALTER TABLE `modele` DISABLE KEYS */;
INSERT INTO `modele` (`id`, `marque_id`, `nom_modele`) VALUES
	(1, 2, 'Clio 4'),
	(2, 2, 'Clio3'),
	(3, 2, 'Mégane 1'),
	(4, 2, 'Mégane 2'),
	(5, 2, 'Mégane 3'),
	(6, 1, 'Logan'),
	(7, 1, 'Sandero'),
	(8, 1, 'Duster');
/*!40000 ALTER TABLE `modele` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. option
CREATE TABLE IF NOT EXISTS `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voiture_id` int(11) NOT NULL,
  `prix_option` decimal(10,0) NOT NULL,
  `nom_prix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8600B0181A8BA` (`voiture_id`),
  CONSTRAINT `FK_5A8600B0181A8BA` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.option : ~0 rows (environ)
/*!40000 ALTER TABLE `option` DISABLE KEYS */;
/*!40000 ALTER TABLE `option` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.user : ~1 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `phone`) VALUES
	(1, 'najib.oulhouch@gmail.com', '["ROLE_ADMIN"]', '$2y$13$.c/yIU/Bkml3g3CiPTqE5uWY5T8XQBuGzee0rzYXfw7ob0GlZQ9KC', 'najib', '0653804562');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Listage de la structure de la table db_vehicules_v2. voiture
CREATE TABLE IF NOT EXISTS `voiture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `couleur_id` int(11) NOT NULL,
  `carburant_id` int(11) NOT NULL,
  `modele_id` int(11) NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `km` int(11) NOT NULL,
  `date_construction` date NOT NULL,
  `etat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_mise_en_vente` date NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `promotion` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E9E2810FC31BA576` (`couleur_id`),
  KEY `IDX_E9E2810F32DAAD24` (`carburant_id`),
  KEY `IDX_E9E2810FAC14B70A` (`modele_id`),
  CONSTRAINT `FK_E9E2810F32DAAD24` FOREIGN KEY (`carburant_id`) REFERENCES `carburant` (`id`),
  CONSTRAINT `FK_E9E2810FAC14B70A` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`),
  CONSTRAINT `FK_E9E2810FC31BA576` FOREIGN KEY (`couleur_id`) REFERENCES `couleur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table db_vehicules_v2.voiture : ~6 rows (environ)
/*!40000 ALTER TABLE `voiture` DISABLE KEYS */;
INSERT INTO `voiture` (`id`, `couleur_id`, `carburant_id`, `modele_id`, `prix`, `km`, `date_construction`, `etat`, `date_mise_en_vente`, `disponibilite`, `promotion`, `description`) VALUES
	(1, 3, 1, 8, 150000, 0, '2021-09-15', 'Neuve', '2021-09-15', 0, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste l'),
	(2, 3, 2, 1, 100000, 0, '2021-09-15', 'Neuve', '2021-09-15', 0, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?'),
	(3, 4, 1, 6, 120000, 0, '2021-09-15', 'Neuve', '2021-09-15', 0, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?'),
	(4, 2, 1, 7, 130000, 150000, '2021-09-15', 'Ocasion', '2021-09-15', 0, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?'),
	(5, 2, 1, 7, 100000, 5455, '2021-09-15', 'Neuve', '2021-09-15', 1, 20, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?'),
	(6, 2, 1, 7, 120000, 0, '2021-09-15', 'Neuve', '2021-09-15', 0, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?');
/*!40000 ALTER TABLE `voiture` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
