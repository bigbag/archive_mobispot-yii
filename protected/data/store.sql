-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `store` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `store`;

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `target_first_name` varchar(128) DEFAULT NULL,
  `target_last_name` varchar(128) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `zip` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `delivery`;
CREATE TABLE `delivery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `period` varchar(256) DEFAULT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `demo_kit_list`;
CREATE TABLE `demo_kit_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `spot_type` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `demo_kit_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `demo_kit_order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `demo_kit_order`;
CREATE TABLE `demo_kit_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `zip` varchar(16) DEFAULT NULL,
  `shipping` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `country` varchar(128) DEFAULT NULL,
  `payment` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `order_list`;
CREATE TABLE `order_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_product` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(1024) NOT NULL,
  `size_name` varchar(1024) NOT NULL,
  `price` float NOT NULL,
  `surface` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`),
  CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `caption` varchar(128) NOT NULL,
  `MeanType` int(11) DEFAULT NULL,
  `EMoneyType` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) DEFAULT NULL,
  `photo` text,
  `description` varchar(2048) DEFAULT NULL,
  `color` varchar(2048) DEFAULT NULL,
  `size` varchar(2048) NOT NULL,
  `name` varchar(128) NOT NULL,
  `surface` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `promo_code`;
CREATE TABLE `promo_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  `products` text NOT NULL,
  `discount` int(11) NOT NULL,
  `expires` bigint(20) unsigned NOT NULL,
  `is_multifold` tinyint(1) DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `store_order`;
CREATE TABLE `store_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(20) unsigned NOT NULL,
  `delivery` bigint(20) unsigned DEFAULT NULL,
  `delivery_data` text,
  `payment` varchar(1024) DEFAULT NULL,
  `payment_data` text,
  `status` int(11) NOT NULL,
  `promo_id` bigint(20) unsigned DEFAULT NULL,
  `buy_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_customer` (`id_customer`),
  CONSTRAINT `store_order_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2014-08-17 15:43:47
