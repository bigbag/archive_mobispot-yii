-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `stack` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `stack`;

DROP TABLE IF EXISTS `alarm_stack`;
CREATE TABLE `alarm_stack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `emails` text NOT NULL,
  `interval` int(11) NOT NULL DEFAULT '86400',
  `count` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `card`;
CREATE TABLE `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_id` int(11) NOT NULL,
  `payment_id` varchar(32) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `likes_stack`;
CREATE TABLE `likes_stack` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token_id` bigint(20) unsigned NOT NULL,
  `loyalty_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senders` text NOT NULL,
  `recipients` text NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `attach` text,
  `creation_date` datetime NOT NULL,
  `lock` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`lock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `report_stack`;
CREATE TABLE `report_stack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `firm_id` int(11) NOT NULL,
  `emails` text NOT NULL,
  `excel` int(1) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `interval` int(11) NOT NULL DEFAULT '0',
  `details` text,
  `launch_date` datetime DEFAULT NULL,
  `check_summ` text NOT NULL,
  `lock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2014-08-17 15:44:10
