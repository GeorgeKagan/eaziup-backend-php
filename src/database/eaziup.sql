-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.2.7-MariaDB-10.2.7+maria~jessie - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for lumen
CREATE DATABASE IF NOT EXISTS `lumen` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lumen`;

-- Dumping structure for table lumen.applications
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `project_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_project_id` (`user_id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users'' applications for projects';

-- Data exporting was unselected.
-- Dumping structure for table lumen.cats
CREATE TABLE IF NOT EXISTS `cats` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.
-- Dumping structure for table lumen.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table lumen.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `country_id` tinyint(3) unsigned DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `addr1` varchar(50) NOT NULL,
  `addr2` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `comp_desc` text DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `cat_id` tinyint(3) unsigned DEFAULT NULL,
  `desc` text NOT NULL,
  `full_desc` text NOT NULL,
  `tech_reqs` text NOT NULL,
  `dev_reqs` text NOT NULL,
  `os_reqs` set('win','linux','macos','winMobile','android','ios') DEFAULT NULL,
  `logo_json` text DEFAULT '{}' COMMENT 'Refs to images stored remotely',
  `design_json` text DEFAULT '{}' COMMENT 'Refs to images stored remotely',
  `design_outline` text NOT NULL,
  `start_date` date NOT NULL,
  `dev_count` tinyint(3) unsigned NOT NULL,
  `milestones_json` text NOT NULL DEFAULT '{}',
  `status` enum('pending','approved','in_work','done','removed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `country_id` (`country_id`),
  KEY `start_date` (`start_date`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
