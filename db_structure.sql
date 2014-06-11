# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.34)
# Database: final
# Generation Time: 2014-06-11 10:35:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table follows
# ------------------------------------------------------------

CREATE TABLE `follows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `who` int(11) DEFAULT NULL,
  `follow` tinyint(1) DEFAULT '1',
  `who2` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shotguns
# ------------------------------------------------------------

CREATE TABLE `shotguns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `who` int(11) DEFAULT NULL,
  `shotgun` tinyint(1) DEFAULT '1',
  `what` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `description` mediumtext,
  `picture` varchar(255) DEFAULT '_assets/images/profile/default.jpg',
  `facebook_id` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset` varchar(255) DEFAULT NULL,
  `removed` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wishes
# ------------------------------------------------------------

CREATE TABLE `wishes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `wishlist` int(11) DEFAULT NULL,
  `name` mediumtext,
  `picture` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `price` tinytext,
  `currency` tinytext,
  `origin` mediumtext,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(11) DEFAULT '0',
  `extension` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wishlists
# ------------------------------------------------------------

CREATE TABLE `wishlists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `name` mediumtext,
  `slug` mediumtext,
  `private` int(11) DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(11) DEFAULT '0',
  `extension` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
