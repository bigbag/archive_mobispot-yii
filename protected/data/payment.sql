-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `payment` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `payment`;

DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `amount` char(50) NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `request_id` text NOT NULL,
  `invoice_id` text,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`),
  KEY `wallet_id` (`wallet_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lost`;
CREATE TABLE `lost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_id` int(11) NOT NULL,
  `payment_id` varchar(20) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `loyalty`;
CREATE TABLE `loyalty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `terms_id` varchar(512) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `rules` int(11) NOT NULL DEFAULT '0',
  `interval` int(11) NOT NULL DEFAULT '1',
  `amount` varchar(32) NOT NULL DEFAULT '0',
  `threshold` varchar(32) NOT NULL DEFAULT '0',
  `desc` text,
  `creation_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `stop_date` datetime NOT NULL,
  `img` varchar(512) DEFAULT NULL,
  `part_limit` int(10) unsigned DEFAULT NULL,
  `sharing_type` int(10) unsigned DEFAULT NULL,
  `data` text,
  `coupon_class` varchar(64) DEFAULT NULL,
  `target_url` varchar(1024) DEFAULT NULL,
  `limit` int(10) unsigned DEFAULT NULL,
  `timeout` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `bonus_count` int(10) unsigned DEFAULT NULL,
  `soc_block` text,
  `bonus_limit` int(10) unsigned DEFAULT NULL,
  `link` varchar(1024) DEFAULT NULL,
  `control_value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `payment_card`;
CREATE TABLE `payment_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `pan` varchar(128) NOT NULL,
  `token` text NOT NULL,
  `type` varchar(128) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sms_info`;
CREATE TABLE `sms_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wallet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_sms` datetime DEFAULT NULL,
  `day_count` int(11) DEFAULT NULL,
  `phone` varchar(64) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `wallet_id` (`wallet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wallet`;
CREATE TABLE `wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(32) NOT NULL,
  `hard_id` varchar(128) DEFAULT NULL,
  `name` varchar(150) NOT NULL DEFAULT 'My Spot',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `discodes_id` int(7) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `blacklist` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_id` (`payment_id`),
  KEY `user_id` (`user_id`),
  KEY `blacklist` (`blacklist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wallet_loyalty`;
CREATE TABLE `wallet_loyalty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `loyalty_id` bigint(20) unsigned NOT NULL,
  `summ` char(50) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `part_count` int(10) unsigned DEFAULT NULL,
  `bonus_count` int(10) unsigned DEFAULT NULL,
  `bonus_limit` int(10) unsigned DEFAULT NULL,
  `checked` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2014-08-17 15:43:54
