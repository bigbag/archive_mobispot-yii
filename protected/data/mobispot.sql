-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: mobispot
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext,
  `path` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Ссылки в футтере','Блок ссылок в футтере, отображаються на всех страницах сайта','/src/Mobispot/ApplicationBundle/Resources/views/Areas/footer_links.html.twig'),(2,'Ссылки в футтере','Блок ссылок в футтере, отображаються на всех страницах сайта','/src/Mobispot/ApplicationBundle/Resources/views/Areas/footer_links.html.twig');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block`
--

DROP TABLE IF EXISTS `block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block`
--

LOCK TABLES `block` WRITE;
/*!40000 ALTER TABLE `block` DISABLE KEYS */;
INSERT INTO `block` VALUES (2,'roundabout','Карусель круглых баннеров на главной'),(3,'banner_footer','Баннеры внизу главной страницы');
/*!40000 ALTER TABLE `block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_bricks`
--

DROP TABLE IF EXISTS `block_bricks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block_bricks` (
  `block_id` int(11) NOT NULL,
  `brick_id` int(11) NOT NULL,
  PRIMARY KEY (`block_id`,`brick_id`),
  UNIQUE KEY `UNIQ_7DF8B5CC8558682` (`brick_id`),
  KEY `IDX_7DF8B5CCE9ED820C` (`block_id`),
  CONSTRAINT `FK_7DF8B5CC8558682` FOREIGN KEY (`brick_id`) REFERENCES `brick` (`id`),
  CONSTRAINT `FK_7DF8B5CCE9ED820C` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_bricks`
--

LOCK TABLES `block_bricks` WRITE;
/*!40000 ALTER TABLE `block_bricks` DISABLE KEYS */;
INSERT INTO `block_bricks` VALUES (2,3),(2,4),(2,5),(2,6),(2,7),(3,8),(3,9),(3,10);
/*!40000 ALTER TABLE `block_bricks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brick`
--

DROP TABLE IF EXISTS `brick`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content_en` longtext,
  `description` longtext NOT NULL,
  `title_ru` varchar(100) DEFAULT NULL,
  `title_en` varchar(100) DEFAULT NULL,
  `content_ru` longtext,
  `link` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brick`
--

LOCK TABLES `brick` WRITE;
/*!40000 ALTER TABLE `brick` DISABLE KEYS */;
INSERT INTO `brick` VALUES (3,'roundabout_personal','Post information about yourself in spots and share it with anyone you want.','Личные споты, кнопка из карусели','Личные споты','Personal spots','Размещайте в спотах информацию о себе и делитесь ей с теми, с кем считаете нужным.',NULL,'roundabout_personal.png'),(4,'roundabout_links','Provide access to the necessary websites, documents, and services without long searches and time-consuming navigation through site menus.','Быстрые ссылки, кнопка из карусели','Быстрые ссылки','Quick links','Дайте доступ к нужным веб-страницам, документам и сервисам без долгого поиска и блуждания по меню сайтов.',NULL,NULL),(5,'roundabout_pets','Rest assured – your pet will be found and returned to you if lost. Or just tell everyone about the qualities and achievements of your pet.','Питомцы, кнопка из карусели','Домашние животные','Pets','Будьте уверены в том, что Ваш любимец будет найден и возвращен в случае потери. Или просто расскажите всем о его достоинствах и достижениях.',NULL,'roundabout_pets.png'),(6,'roundabout_communication','Tell existing and potential customers more about your business or find out what makes them unhappy.','Общение с клиентами, кнопка из карусели','Общение с клиентами','Communication with customers','Расскажите существующим и потенциальным клиентам больше о своем бизнесе или узнайте, чем они недовольны.',NULL,NULL),(7,'roundabout_discount','Create and flexibly customize your own discount programs. Do not miss out on potential customers – they are at arm\'\'s length from your coupon.','Купоны и скидки, кнопка из карусели','Купоны и скидки','Coupons and discounts','Создавайте и гибко настраивайте свои дисконтные программы. Не дайте потенциальному клиенту пройти мимо, ведь он на расстоянии вытянутой руки от Вашего купона.',NULL,NULL),(8,'banner_footer_phones',NULL,'Модели телефонов, баннер на главной внизу.','Модели телефонов, работающие со спотами','Cell phone models that work with spots',NULL,'phones',NULL),(9,'banner_footer_spots',NULL,'Выбери свой спот, баннер на главной внизу.','Выбери свой спот','Pick your spot',NULL,'spots',NULL),(10,'banner_footer_business',NULL,'Мобиспот для бизнеса, баннер на главной внизу.','Мобиспот для бизнеса','Mobispot for business',NULL,'business',NULL);
/*!40000 ALTER TABLE `brick` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `comment` longtext NOT NULL,
  `spot_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'dfdf','0','dfd','dfd',823450,'2012-07-04'),(2,'sdsd','0','0','sds',343116,'2012-07-05');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date_first` date NOT NULL,
  `date_last` date NOT NULL,
  `time_first` time NOT NULL,
  `time_last` time NOT NULL,
  `image` varchar(200) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'ererer','2012-07-04','2013-07-04','01:01:00','01:03:00','/uploads/coupon_2fe7db6470bffbd7bc5511761103ca80.jpg',343116,0),(2,'ererer','2012-07-04','2013-07-04','01:01:00','01:03:00','/uploads/coupon_2fe7db6470bffbd7bc5511761103ca80.jpg',690713,0),(3,'ererer','2012-07-04','2013-07-04','01:01:00','01:03:00','/uploads/coupon_2fe7db6470bffbd7bc5511761103ca80.jpg',823450,0);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dis_codes`
--

DROP TABLE IF EXISTS `dis_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dis_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `control_code` smallint(6) NOT NULL,
  `is_vowel` tinyint(1) NOT NULL,
  `is_premium` tinyint(1) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `action` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `is_primary` (`is_premium`),
  KEY `is_vowel` (`is_vowel`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=823451 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dis_codes`
--

LOCK TABLES `dis_codes` WRITE;
/*!40000 ALTER TABLE `dis_codes` DISABLE KEYS */;
INSERT INTO `dis_codes` VALUES (343116,'34yU3I1e16',2,1,0,2,'0000-00-00 00:00:00',6,' копия'),(424199,'iYa42E4199',2,1,0,2,'0000-00-00 00:00:00',1,' копия копия'),(466097,'4ei660Y9u7',2,1,0,2,'0000-00-00 00:00:00',3,' копия копия'),(534356,'53I4a3E56Y',2,1,0,2,'0000-00-00 00:00:00',2,' копия'),(616412,'i6YU1i6412',2,1,0,2,'0000-00-00 00:00:00',5,' копия копия копия'),(678902,'6r7t8b9n02',2,0,0,2,'0000-00-00 00:00:00',5,' копия копия копия копия'),(690713,'6m907P13HP',2,0,0,2,'0000-00-00 00:00:00',1,' copy'),(751296,'751y2a9iU6',2,1,0,2,'0000-00-00 00:00:00',2,''),(775597,'Fr77v55h97',2,0,0,2,'0000-00-00 00:00:00',3,' copy'),(813085,'Z81zj30M85',2,0,0,2,'0000-00-00 00:00:00',4,' копия'),(823450,'8D2Q345t0v',2,0,0,2,'2012-07-04 12:54:18',5,' копия');
/*!40000 ALTER TABLE `dis_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_num` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `response` longtext NOT NULL,
  `locale` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_question`
--

DROP TABLE IF EXISTS `faq_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `question` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_question`
--

LOCK TABLES `faq_question` WRITE;
/*!40000 ALTER TABLE `faq_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_auth_attempts`
--

DROP TABLE IF EXISTS `fos_user_auth_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_auth_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_auth_attempts`
--

LOCK TABLES `fos_user_auth_attempts` WRITE;
/*!40000 ALTER TABLE `fos_user_auth_attempts` DISABLE KEYS */;
INSERT INTO `fos_user_auth_attempts` VALUES (1,2130706433,1340370715);
/*!40000 ALTER TABLE `fos_user_auth_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_group`
--

DROP TABLE IF EXISTS `fos_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_583D1F3E5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_group`
--

LOCK TABLES `fos_user_group` WRITE;
/*!40000 ALTER TABLE `fos_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_user`
--

DROP TABLE IF EXISTS `fos_user_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `username_canonical` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_canonical` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `two_step_code` varchar(255) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `photo_personal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C560D76192FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_C560D761A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_C560D76114B78418` (`photo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_user`
--

LOCK TABLES `fos_user_user` WRITE;
/*!40000 ALTER TABLE `fos_user_user` DISABLE KEYS */;
INSERT INTO `fos_user_user` VALUES (1,'admin','admin','admin@test.ru','admin@test.ru',1,'emr42v18cq0oo0c8wc4oskw40ckw0ck','saOcdNGJEr4Wcc1YvsyYv4p4cE6MwHNSfPBr0gHVIqcfYdCBbDkRnoUmNFqP09wwXvBGPhyaJj8WlebIyy20fg==','2012-06-04 12:46:39',0,0,NULL,'5f5bzvc46jk0sg80cgc8kgs4wso04gc88c8ksgs0wo8ocwksgo','2012-05-31 19:07:08','a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,'2012-05-29 17:44:32','2012-06-04 12:46:39','male',NULL,NULL,'test','1999-05-02 00:00:00',NULL,0),(2,'test','test','test@test.ru','test@test.ru',1,'mokt005do004k84w8gcg44skgkc8cg0','/RHeoxEACuswEwJNqhp5U1KEjs6EclEXlgk3tuD6ZHpZIwKRnHM28DdSUAMdgIXDxXzSPdXBvau0DUbrhYIxOA==','2012-07-11 18:07:08',0,0,NULL,'1sltnmt8oba8gw0ockcwkkok8s0sgkos840swosgkwcsgkcgsg',NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,'2012-06-17 12:21:27','2012-07-11 18:07:08',NULL,'/uploads/personal_184317902767a44070305c6d45ccfd97.jpg',NULL,'test@test.ru',NULL,'ru',1);
/*!40000 ALTER TABLE `fos_user_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_user_group`
--

DROP TABLE IF EXISTS `fos_user_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_B3C77447A76ED395` (`user_id`),
  KEY `IDX_B3C77447FE54D947` (`group_id`),
  CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`),
  CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_user_group`
--

LOCK TABLES `fos_user_user_group` WRITE;
/*!40000 ALTER TABLE `fos_user_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_user_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legal` longtext NOT NULL,
  `tech_feat` longtext NOT NULL,
  `auxiliary` longtext NOT NULL,
  `locale` varchar(126) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info`
--

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inform`
--

DROP TABLE IF EXISTS `inform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(200) NOT NULL,
  `web_site` varchar(200) NOT NULL,
  `contact_face` varchar(200) NOT NULL,
  `propasals` longtext NOT NULL,
  `points` longtext NOT NULL,
  `spot_id` int(11) NOT NULL,
  `views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inform`
--

LOCK TABLES `inform` WRITE;
/*!40000 ALTER TABLE `inform` DISABLE KEYS */;
INSERT INTO `inform` VALUES (1,'wewew','http://www.yandex.ru','wew','a:2:{i:0;a:2:{s:4:\"name\";s:4:\"pr_0\";s:5:\"value\";s:3:\"wew\";}i:1;a:2:{s:4:\"name\";s:4:\"pr_1\";s:5:\"value\";s:4:\"wewe\";}}','a:2:{i:0;a:2:{s:4:\"name\";s:4:\"po_0\";s:5:\"value\";s:4:\"wewe\";}i:1;a:2:{s:4:\"name\";s:4:\"po_1\";s:5:\"value\";s:2:\"we\";}}',678902,1);
/*!40000 ALTER TABLE `inform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lang_yaml`
--

DROP TABLE IF EXISTS `lang_yaml`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lang_yaml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lang_yaml`
--

LOCK TABLES `lang_yaml` WRITE;
/*!40000 ALTER TABLE `lang_yaml` DISABLE KEYS */;
INSERT INTO `lang_yaml` VALUES (1,'en','Валидация профайла пользователя','/src/Mobispot/ApplicationBundle/Resources/translations/profile.en.yml');
/*!40000 ALTER TABLE `lang_yaml` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spot_id` int(11) NOT NULL,
  `link` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20120529172318'),('20120529173311'),('20120531105545'),('20120531120012'),('20120531132210'),('20120601161337'),('20120604125604'),('20120605122817'),('20120605215044'),('20120606120446'),('20120606153712'),('20120606154555'),('20120606155456'),('20120606180804'),('20120607172015'),('20120608155843'),('20120609112726'),('20120609115024'),('20120609124648'),('20120613121010'),('20120613155017'),('20120613160708'),('20120614111038'),('20120614112251'),('20120615120935'),('20120617121105'),('20120619103733'),('20120619172352'),('20120620165030'),('20120620180614'),('20120621115111'),('20120621154405'),('20120622161752'),('20120622161833'),('20120622162405'),('20120622164022'),('20120623213947'),('20120624101348'),('20120625085648'),('20120625140529'),('20120625160858'),('20120625170235'),('20120626152232'),('20120626175945'),('20120626180446'),('20120626180701'),('20120627115022'),('20120627121037'),('20120627160849'),('20120628131130'),('20120628165957'),('20120702155546'),('20120703121010');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modes_type`
--

DROP TABLE IF EXISTS `modes_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modes_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spot_type` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `mode_num` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5309CB8079E3D9DA` (`spot_type`),
  CONSTRAINT `FK_5309CB8079E3D9DA` FOREIGN KEY (`spot_type`) REFERENCES `spot_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modes_type`
--

LOCK TABLES `modes_type` WRITE;
/*!40000 ALTER TABLE `modes_type` DISABLE KEYS */;
INSERT INTO `modes_type` VALUES (1,1,'Friendly',1),(2,1,'Official',2),(3,3,'Exhibition',1),(4,3,'Lost',2);
/*!40000 ALTER TABLE `modes_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `text_en` longtext,
  `title_ru` varchar(100) NOT NULL,
  `title_en` varchar(100) NOT NULL,
  `text_ru` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (10,'business','<p>fdfdfdfd</p>','Мобиспот для бизнеса','Mobispot for business','<p><a title=\"ya.ru\" href=\"ya.ru\">sds</a></p>'),(11,'spots',NULL,'Выбери свой спот','Pick your spot',NULL),(12,'phones',NULL,'Модели телефонов, работающие со спотами','Cell phone models that work with spots',NULL),(24,'terms_add',NULL,'Вспомогательная юридическая информация','Additional Legal Information',NULL),(23,'terms_teh',NULL,'Технические особенности','Technical features',NULL),(21,'terms_mob',NULL,'Правила использования','Terms of use',NULL),(22,'terms',NULL,'Юридическая информация','Legal information',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_sv` varchar(250) NOT NULL,
  `name_en` varchar(250) NOT NULL,
  `name_mode` int(11) NOT NULL,
  `photo_1` varchar(250) NOT NULL,
  `photo_1_mode` int(11) NOT NULL,
  `photo_2` varchar(250) NOT NULL,
  `photo_2_mode` int(11) NOT NULL,
  `email_1` varchar(250) NOT NULL,
  `email_1_mode` int(11) NOT NULL,
  `email_2` varchar(250) NOT NULL,
  `email_2_mode` int(11) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `phone_mode` int(11) NOT NULL,
  `skype` varchar(200) NOT NULL,
  `skype_mode` int(11) NOT NULL,
  `icq` varchar(20) NOT NULL,
  `icq_mode` int(11) NOT NULL,
  `social` varchar(250) NOT NULL,
  `social_mode` int(11) NOT NULL,
  `twitter` varchar(250) NOT NULL,
  `twitter_mode` int(11) NOT NULL,
  `institution_sv` varchar(250) NOT NULL,
  `institution_en` varchar(250) NOT NULL,
  `institution_mode` int(11) NOT NULL,
  `emailing` varchar(200) NOT NULL,
  `emailing_mode` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `add_comment` int(11) NOT NULL,
  `mode` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (1,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,775597,'ru',0,1),(2,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,823450,'ru',0,1),(3,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,813085,'ru',0,1),(4,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,775597,'ru',0,1),(5,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,343116,'ru',0,1),(6,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,616412,'ru',0,1),(7,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,424199,'ru',0,1),(8,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,466097,'ru',0,1),(9,'','',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'',0,'','',0,'',0,534356,'ru',0,1);
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_modes`
--

DROP TABLE IF EXISTS `personal_modes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_modes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spot_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `email_1` int(11) NOT NULL,
  `email_2` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `photo_1` int(11) NOT NULL,
  `photo_2` int(11) NOT NULL,
  `skype` int(11) NOT NULL,
  `icq` int(11) NOT NULL,
  `twitter` int(11) NOT NULL,
  `social` int(11) NOT NULL,
  `institution` int(11) NOT NULL,
  `emailing` int(11) NOT NULL,
  `mode_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_modes`
--

LOCK TABLES `personal_modes` WRITE;
/*!40000 ALTER TABLE `personal_modes` DISABLE KEYS */;
INSERT INTO `personal_modes` VALUES (1,813085,22,1444,23232,1,1,2,1,2,1,1,1,1,1),(2,813085,2,1,3,1,2,1,1,1,1,1,3,2,2),(3,823450,22,1444,23232,1,1,2,1,2,1,1,1,1,1),(4,823450,2,1,3,1,2,1,1,1,1,1,3,2,2),(5,775597,22,1444,23232,1,1,2,1,2,1,1,1,1,1),(6,775597,2,1,3,1,2,1,1,1,1,1,3,2,2),(7,343116,0,0,0,0,0,0,0,0,0,0,0,0,1),(8,616412,0,0,0,0,0,0,0,0,0,0,0,0,1),(9,343116,0,0,0,0,0,0,0,0,0,0,0,0,2),(10,616412,0,0,0,0,0,0,0,0,0,0,0,0,2),(11,424199,0,0,0,0,0,0,0,0,0,0,0,0,1),(12,424199,0,0,0,0,0,0,0,0,0,0,0,0,2),(13,466097,0,0,0,0,0,0,0,0,0,0,0,0,1),(14,534356,0,0,0,0,0,0,0,0,0,0,0,0,1),(15,466097,0,0,0,0,0,0,0,0,0,0,0,0,2),(16,534356,0,0,0,0,0,0,0,0,0,0,0,0,2),(17,690713,0,0,0,0,0,0,0,0,0,0,0,0,1),(18,690713,0,0,0,0,0,0,0,0,0,0,0,0,2);
/*!40000 ALTER TABLE `personal_modes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pets`
--

DROP TABLE IF EXISTS `pets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_sv` varchar(250) NOT NULL,
  `message_en` varchar(250) NOT NULL,
  `message_mode` int(11) NOT NULL,
  `photo_1` varchar(250) NOT NULL,
  `photo_1_mode` int(11) NOT NULL,
  `photo_2` varchar(250) NOT NULL,
  `photo_2_mode` int(11) NOT NULL,
  `nickname_sv` varchar(250) NOT NULL,
  `nickname_en` varchar(250) NOT NULL,
  `nickname_mode` int(11) NOT NULL,
  `name_ped_sv` varchar(250) NOT NULL,
  `name_ped_en` varchar(250) NOT NULL,
  `name_ped_mode` int(11) NOT NULL,
  `phone_1` varchar(50) NOT NULL,
  `phone_1_mode` int(11) NOT NULL,
  `phone_2` varchar(50) NOT NULL,
  `phone_2_mode` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `email_mode` int(11) NOT NULL,
  `regalia_sv` varchar(250) NOT NULL,
  `regalia_en` varchar(250) NOT NULL,
  `regalia_mode` int(11) NOT NULL,
  `info_vac_sv` varchar(255) NOT NULL,
  `info_vac_en` varchar(255) NOT NULL,
  `info_vac_mode` int(11) NOT NULL,
  `feat_beh_sv` varchar(255) NOT NULL,
  `feat_beh_en` varchar(255) NOT NULL,
  `feat_beh_mode` int(11) NOT NULL,
  `feat_feed_sv` varchar(255) NOT NULL,
  `feat_feed_en` varchar(255) NOT NULL,
  `feat_feed_mode` int(11) NOT NULL,
  `mark_sv` varchar(255) NOT NULL,
  `mark_en` varchar(255) NOT NULL,
  `mark_mode` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `mode` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `add_comment` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pets`
--

LOCK TABLES `pets` WRITE;
/*!40000 ALTER TABLE `pets` DISABLE KEYS */;
INSERT INTO `pets` VALUES (1,'111111111111111','22222222222222222',1,'/uploads/pet_photo_cda3e1d4299c81cae55ca91f8a043757.jpg',1,'/uploads/pet_photo_eb0d262ba7eb9f235976fa39a819d5f8.jpg',1,'1111111111111111111','22222222222222222',1,'1111111111111111111','22222222222222',1,'333333333333333',1,'3333333333',1,'3333333333333333333',1,'1111111111111111111111','2222222222222222222',1,'11111111111111111','22222222222222222',1,'111111111111111111','222222222222222222',1,'1111111111111111','12222222222222222222',1,'1111111111111111111','2222222222222222',1,'en',2,690713,0),(2,'','',1,'pet_photo_62c155c7d455992799340f9172da0a70.jpg',1,'pet_photo_8e071bea979cc204e9b6e86a7407d70c.jpg',1,'','',1,'','',1,'',1,'',1,'',1,'','',1,'','',1,'','',1,'','',1,'','',1,'ru',1,616412,0),(3,'','',0,'',0,'',0,'','',0,'','',0,'',0,'',0,'',0,'','',0,'','',0,'','',0,'','',0,'','',0,'ru',1,775597,0),(4,'','',0,'',0,'',0,'','',0,'','',0,'',0,'',0,'',0,'','',0,'','',0,'','',0,'','',0,'','',0,'ru',1,813085,0),(5,'','',0,'',0,'',0,'','',0,'','',0,'',0,'',0,'',0,'','',0,'','',0,'','',0,'','',0,'','',0,'ru',1,823450,0),(6,'','',0,'',0,'',0,'','',0,'','',0,'',0,'',0,'',0,'','',0,'','',0,'','',0,'','',0,'','',0,'ru',1,751296,0),(7,'','',0,'',0,'',0,'','',0,'','',0,'',0,'',0,'',0,'','',0,'','',0,'','',0,'','',0,'','',0,'ru',1,534356,0);
/*!40000 ALTER TABLE `pets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pets_modes`
--

DROP TABLE IF EXISTS `pets_modes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pets_modes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` int(11) NOT NULL,
  `photo_1` int(11) NOT NULL,
  `photo_2` int(11) NOT NULL,
  `nickname` int(11) NOT NULL,
  `name_ped` int(11) NOT NULL,
  `phone_1` int(11) NOT NULL,
  `phone_2` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `regalia` int(11) NOT NULL,
  `info_vac` int(11) NOT NULL,
  `feat_beh` int(11) NOT NULL,
  `feat_feed` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `mode_num` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pets_modes`
--

LOCK TABLES `pets_modes` WRITE;
/*!40000 ALTER TABLE `pets_modes` DISABLE KEYS */;
INSERT INTO `pets_modes` VALUES (1,0,1,1,1,0,1,1,1,1,1,1,0,0,1,690713),(2,0,1,1,0,1,1,1,1,1,1,1,1,1,2,690713),(3,0,0,0,0,0,0,0,0,0,0,0,0,0,1,616412),(4,0,0,0,0,0,0,0,0,0,0,0,0,0,2,616412),(5,0,0,0,0,0,0,0,0,0,0,0,0,0,1,775597),(6,0,0,0,0,0,0,0,0,0,0,0,0,0,1,813085),(7,0,0,0,0,0,0,0,0,0,0,0,0,0,2,775597),(8,0,0,0,0,0,0,0,0,0,0,0,0,0,2,813085),(9,0,0,0,0,0,0,0,0,0,0,0,0,0,1,823450),(10,0,0,0,0,0,0,0,0,0,0,0,0,0,2,823450),(11,0,0,0,0,0,0,0,0,0,0,0,0,0,1,751296),(12,0,0,0,0,0,0,0,0,0,0,0,0,0,1,534356),(13,0,0,0,0,0,0,0,0,0,0,0,0,0,2,751296),(14,0,0,0,0,0,0,0,0,0,0,0,0,0,2,534356);
/*!40000 ALTER TABLE `pets_modes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_feedback`
--

DROP TABLE IF EXISTS `settings_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `comment` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_feedback`
--

LOCK TABLES `settings_feedback` WRITE;
/*!40000 ALTER TABLE `settings_feedback` DISABLE KEYS */;
INSERT INTO `settings_feedback` VALUES (1,1,1,0,1,823450),(2,0,0,0,0,616412),(3,0,0,0,0,678902),(4,1,0,0,1,343116);
/*!40000 ALTER TABLE `settings_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spot_type`
--

DROP TABLE IF EXISTS `spot_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spot_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ru` varchar(255) NOT NULL,
  `en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spot_type`
--

LOCK TABLES `spot_type` WRITE;
/*!40000 ALTER TABLE `spot_type` DISABLE KEYS */;
INSERT INTO `spot_type` VALUES (1,'Личный','Personal'),(2,'Ссылка','Link'),(3,'Питомец','Pet'),(4,'Купон','Coupon'),(5,'Информация','Info'),(6,'Обратная связь','Feedback');
/*!40000 ALTER TABLE `spot_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicarious_agent`
--

DROP TABLE IF EXISTS `vicarious_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicarious_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spot_id_idx` (`spot_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicarious_agent`
--

LOCK TABLES `vicarious_agent` WRITE;
/*!40000 ALTER TABLE `vicarious_agent` DISABLE KEYS */;
INSERT INTO `vicarious_agent` VALUES (1,813085,2,'2012-06-26 19:02:36');
/*!40000 ALTER TABLE `vicarious_agent` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-14 19:07:57
