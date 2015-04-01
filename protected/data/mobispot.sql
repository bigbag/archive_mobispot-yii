-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `mobispot` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mobispot`;

DROP TABLE IF EXISTS `discodes`;
CREATE TABLE `discodes` (
  `id` int(7) NOT NULL,
  `premium` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `premium` (`premium`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lang`;
CREATE TABLE `lang` (
  `name` varchar(10) NOT NULL,
  `desc` varchar(150) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mail_template`;
CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `desc` text NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `subject` varchar(300) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phone`;
CREATE TABLE `phone` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(32) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `brand` varchar(64) NOT NULL,
  `year` varchar(4) DEFAULT NULL,
  `page` varchar(256) DEFAULT NULL,
  `os_id` bigint(20) unsigned DEFAULT NULL,
  `phone_turn_nfc` varchar(1025) DEFAULT NULL,
  `has_trouble` tinyint(1) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phone_os`;
CREATE TABLE `phone_os` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `turn_nfc` varchar(1025) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `soc_token`;
CREATE TABLE `soc_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `soc_id` varchar(512) DEFAULT NULL,
  `soc_email` varchar(512) DEFAULT NULL,
  `user_token` varchar(512) DEFAULT NULL,
  `token_secret` varchar(512) DEFAULT NULL,
  `token_expires` bigint(20) unsigned DEFAULT NULL,
  `is_tech` tinyint(1) DEFAULT NULL,
  `allow_login` tinyint(1) DEFAULT NULL,
  `soc_username` varchar(128) DEFAULT NULL,
  `refresh_token` varchar(1024) DEFAULT NULL,
  `write_access` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot`;
CREATE TABLE `spot` (
  `discodes_id` int(7) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `user_id` int(11) DEFAULT NULL,
  `barcode` varchar(32) DEFAULT NULL,
  `premium` int(1) NOT NULL,
  `status` int(2) NOT NULL,
  `generated_date` datetime NOT NULL,
  `registered_date` datetime DEFAULT NULL,
  `removed_date` datetime DEFAULT NULL,
  `pass` varchar(4) DEFAULT NULL,
  `code128` varchar(128) DEFAULT NULL,
  `hard_type` varchar(128) NOT NULL DEFAULT '1',
  PRIMARY KEY (`discodes_id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `hard_type` (`hard_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_block`;
CREATE TABLE `spot_block` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(256) NOT NULL,
  `discodes_id` bigint(20) unsigned DEFAULT NULL,
  `fails` int(10) unsigned DEFAULT NULL,
  `blocked_until` timestamp NULL DEFAULT NULL,
  `whitelist` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_color`;
CREATE TABLE `spot_color` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `show` int(4) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_content`;
CREATE TABLE `spot_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discodes_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'en' COMMENT 'en',
  `spot_type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `spot_type_id` (`spot_type_id`),
  KEY `discodes_id` (`discodes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_hard`;
CREATE TABLE `spot_hard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `show` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_hard_type`;
CREATE TABLE `spot_hard_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `hard_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `pattern_id` int(11) DEFAULT NULL,
  `show` int(11) NOT NULL DEFAULT '0',
  `image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_pattern`;
CREATE TABLE `spot_pattern` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `show` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL,
  `creation_date` datetime NOT NULL,
  `lastvisit` datetime DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `vkontakte_id` varchar(200) DEFAULT NULL,
  `facebook_id` varchar(200) DEFAULT NULL,
  `twitter_id` varchar(200) DEFAULT NULL,
  `google_oauth_id` varchar(200) DEFAULT NULL,
  `foursquare_token` varchar(256) DEFAULT NULL,
  `foursquare_id` varchar(256) DEFAULT NULL,
  `instagram_id` varchar(256) DEFAULT NULL,
  `instagram_media_id` varchar(2048) DEFAULT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'ru',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `lang` (`lang`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `lang` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `sex` int(2) NOT NULL DEFAULT '0',
  `birthday` varchar(10) DEFAULT NULL,
  `photo` text,
  PRIMARY KEY (`user_id`),
  KEY `sex` (`sex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `coupon_access`;
CREATE TABLE `coupon_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discodes_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2014-08-17 15:44:01

DROP TABLE IF EXISTS `transport_type`;
CREATE TABLE `transport_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `img` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spot_troika`;
CREATE TABLE `spot_troika` (
  `discodes_id` int(7) NOT NULL,
  PRIMARY KEY (`discodes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
