/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ symbnb /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE symbnb;

DROP TABLE IF EXISTS anonce;
CREATE TABLE `anonce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `introduction` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chambres` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_66C18BC60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_66C18BC60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=415 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS booking;
CREATE TABLE `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booker_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `amount` double NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E00CEDDE8B7E4006` (`booker_id`),
  KEY `IDX_E00CEDDE4F34D596` (`ad_id`),
  CONSTRAINT `FK_E00CEDDE4F34D596` FOREIGN KEY (`ad_id`) REFERENCES `anonce` (`id`),
  CONSTRAINT `FK_E00CEDDE8B7E4006` FOREIGN KEY (`booker_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=616 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS comment;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anonce_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `rating` double DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C6C1A7768` (`anonce_id`),
  KEY `IDX_9474526C60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_9474526C60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9474526C6C1A7768` FOREIGN KEY (`anonce_id`) REFERENCES `anonce` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS doctrine_migration_versions;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS image;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anonce_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045F6C1A7768` (`anonce_id`),
  CONSTRAINT `FK_C53D045F6C1A7768` FOREIGN KEY (`anonce_id`) REFERENCES `anonce` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1490 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS role;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS role_user;
CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `IDX_332CA4DDD60322AC` (`role_id`),
  KEY `IDX_332CA4DDA76ED395` (`user_id`),
  CONSTRAINT `FK_332CA4DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_332CA4DDD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `introduction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;