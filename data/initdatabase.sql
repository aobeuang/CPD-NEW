-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: localhost    Database: codeignitor
-- ------------------------------------------------------
-- Server version	5.6.22

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
-- Table structure for table `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ai`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `acl_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `acl_actions` (`action_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl`
--

LOCK TABLES `acl` WRITE;
/*!40000 ALTER TABLE `acl` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_actions`
--

DROP TABLE IF EXISTS `acl_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_actions` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `action_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `acl_actions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `acl_categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_actions`
--

LOCK TABLES `acl_actions` WRITE;
/*!40000 ALTER TABLE `acl_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_categories`
--

DROP TABLE IF EXISTS `acl_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `category_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  UNIQUE KEY `category_desc` (`category_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_categories`
--

LOCK TABLES `acl_categories` WRITE;
/*!40000 ALTER TABLE `acl_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_sessions`
--

DROP TABLE IF EXISTS `auth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_sessions` (
  `id` varchar(40) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_sessions`
--

LOCK TABLES `auth_sessions` WRITE;
/*!40000 ALTER TABLE `auth_sessions` DISABLE KEYS */;
INSERT INTO `auth_sessions` VALUES ('4b0962f45637252112c0b19f75abdc040c393ed4',1,'2016-07-29 00:32:11','2016-07-28 17:37:30','127.0.0.1','Firefox 47.0 on Mac OS X'),('1c20d5a0dfd1b4f364553deed5111d8eb32d342d',3004374188,'2016-07-28 19:05:54','2016-07-28 15:26:16','127.0.0.1','Firefox 47.0 on Mac OS X');
/*!40000 ALTER TABLE `auth_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('03b2e02cbc4d3dfca7bc7ec4404a665e1efd6edd','127.0.0.1',1469698556,'__ci_last_regenerate|i:1469698556;'),('7f04eded81d06db4ae2aee16cc517a2217dee8d1','127.0.0.1',1469699067,'__ci_last_regenerate|i:1469698870;'),('ed3895dfccbec97dc76f142e60240212864a5b17','127.0.0.1',1469699358,'__ci_last_regenerate|i:1469699237;'),('ea9789dbb45cc43dbddc84ed79753d208156f164','127.0.0.1',1469699814,'__ci_last_regenerate|i:1469699544;'),('354e5bca8f453ca931ab6eaa5455c5e8f8d72918','127.0.0.1',1469700012,'__ci_last_regenerate|i:1469699882;'),('ba9b7cd555ba88e7c328aac756e05aeee279bee2','127.0.0.1',1469700234,'__ci_last_regenerate|i:1469700234;'),('5a05c896a671d0e41a3dd53166fca3957c891bf7','127.0.0.1',1469700941,'__ci_last_regenerate|i:1469700891;'),('da840d2ae5ae1a040a1fcb8b54dd3f4d1c035263','127.0.0.1',1469701864,'__ci_last_regenerate|i:1469701566;'),('28eff14d7bb4c7efe9cc71faff05e6c80323486c','127.0.0.1',1469702007,'__ci_last_regenerate|i:1469701901;'),('3451dd6d5cc8c8c8f9aba93974eb7b7b49d283a6','127.0.0.1',1469702750,'__ci_last_regenerate|i:1469702468;'),('c9cd48214128cd6b10a5eeeaff6964560bdb49ce','127.0.0.1',1469703073,'__ci_last_regenerate|i:1469702781;'),('a572bf11e5902ab3433941c17ae69618d2abbac6','127.0.0.1',1469703207,'__ci_last_regenerate|i:1469703093;'),('6f22c16c8e9ffaaa7af8e6789b944f7fd541f97d','127.0.0.1',1469703644,'__ci_last_regenerate|i:1469703474;'),('dac50a780186fe0862956fc0f4b46648cb394fd4','127.0.0.1',1469704464,'__ci_last_regenerate|i:1469704170;'),('a4d43fbfd577d4569e49ef8b3216db2b3487d2fb','127.0.0.1',1469704982,'__ci_last_regenerate|i:1469704717;'),('7893386c626bae9fdba123b620aa1dd720628d34','127.0.0.1',1469705589,'__ci_last_regenerate|i:1469705301;'),('2e570aae046a42691d2196595d1f3feaf0b0ee9b','127.0.0.1',1469705953,'__ci_last_regenerate|i:1469705681;'),('fb8ae83588ea91ead3546c7b641511103a95dba5','127.0.0.1',1469706246,'__ci_last_regenerate|i:1469706014;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 18:40:14\";}\";'),('b3a5ef0ea80df12d9b695590d18e3760dc4750b2','127.0.0.1',1469706946,'__ci_last_regenerate|i:1469706699;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 18:40:14\";}\";'),('653a899a0e49af5f1c9d366ab0721ca72b8a9530','127.0.0.1',1469707401,'__ci_last_regenerate|i:1469707125;'),('f71c07567998037e01ae0bf90ef24bc753dbd9f5','127.0.0.1',1469707804,'__ci_last_regenerate|i:1469707554;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('3d2223fac5032e7b92e858c126f2ef4ee4339106','127.0.0.1',1469707616,'__ci_last_regenerate|i:1469707616;'),('b13522865a44c22ba10c9484b093153f0c93f362','127.0.0.1',1469708565,'__ci_last_regenerate|i:1469708277;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('2681b01e087b69e7b7a5f63eb7816346d92a9a8f','127.0.0.1',1469708872,'__ci_last_regenerate|i:1469708582;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('1fef9d82c3ef768e7a5301eba167e6578a69d24b','127.0.0.1',1469709342,'__ci_last_regenerate|i:1469709054;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('4d5bd347d95ed0fd2a5fe70aac3f8faece2bccee','127.0.0.1',1469709572,'__ci_last_regenerate|i:1469709406;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('4c97db1f9da7a4a3f39feeab742ef64cde99e171','127.0.0.1',1469709786,'__ci_last_regenerate|i:1469709785;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('35eed36faf10204b039a6a2f8978e0b602b40706','127.0.0.1',1469710667,'__ci_last_regenerate|i:1469710374;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('d68b1e3066b527d0502fba01f8de2a4e159bb5e4','127.0.0.1',1469710972,'__ci_last_regenerate|i:1469710685;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('50cf7baf9e34683d203760bf987469cd2ed167c0','127.0.0.1',1469711261,'__ci_last_regenerate|i:1469711020;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('2b6c9a4c0d2f0695fe5b94b2e8028b4f2908705c','127.0.0.1',1469711449,'__ci_last_regenerate|i:1469711355;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('2ebc7609c1f1a7d2d0412a3c8f860847cc1e6400','127.0.0.1',1469711783,'__ci_last_regenerate|i:1469711695;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('fac116aa21ab065f6c7319e64e589efe1a7c1490','127.0.0.1',1469712274,'__ci_last_regenerate|i:1469712262;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('577100801b657a319fabc954c7cda6733a309f92','127.0.0.1',1469712996,'__ci_last_regenerate|i:1469712762;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('eee88eb43cf72d2c29d117ad916cbd377936ddd5','127.0.0.1',1469713371,'__ci_last_regenerate|i:1469713109;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('4f47d78788e83de18653c499c6705821471023aa','127.0.0.1',1469713920,'__ci_last_regenerate|i:1469713727;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('c346f6f545f49bd06f4c8b04efde847842ef093e','127.0.0.1',1469714343,'__ci_last_regenerate|i:1469714244;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('1c20d5a0dfd1b4f364553deed5111d8eb32d342d','127.0.0.1',1469719652,'__ci_last_regenerate|i:1469719576;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('e00c18e09df882962d067f80bd929e2e4fdea58a','127.0.0.1',1469720332,'__ci_last_regenerate|i:1469720102;auth_identifiers|s:83:\"a:2:{s:7:\"user_id\";s:10:\"3004374188\";s:10:\"login_time\";s:19:\"2016-07-28 19:05:54\";}\";'),('49c514ec0695994ab700a96338d899f7074a63aa','127.0.0.1',1469720786,'__ci_last_regenerate|i:1469720561;'),('0b7aa62a9e82472e9e98f98071adc7072580907a','127.0.0.1',1469721247,'__ci_last_regenerate|i:1469720976;'),('ea278c245b9e9730405412898dd8ef6a0b103502','127.0.0.1',1469721734,'__ci_last_regenerate|i:1469721386;'),('7a9fdd919b58134922a818a570eee636d364c6bb','127.0.0.1',1469721954,'__ci_last_regenerate|i:1469721740;'),('5e0737d9141500ffe51c790ab3c0b549d5dad5f6','127.0.0.1',1469723275,'__ci_last_regenerate|i:1469723174;'),('c16a299ae61744c7c0171a64cbe73ea746494149','127.0.0.1',1469723886,'__ci_last_regenerate|i:1469723529;'),('524b3f9d06c25091fd34ec99ddae91c708748945','127.0.0.1',1469724158,'__ci_last_regenerate|i:1469723929;'),('ce1a60c0021a1704fcb382d4af644578da552779','127.0.0.1',1469724703,'__ci_last_regenerate|i:1469724408;'),('2cb7a19c11c90348a647c9d223d48fd270f8bf04','127.0.0.1',1469725039,'__ci_last_regenerate|i:1469724713;'),('e225a5b0c1c7ea4dd8611971179d2ad5b5686eee','127.0.0.1',1469725338,'__ci_last_regenerate|i:1469725046;'),('815fde023fc195c6b8b6faeb07802d4d41a26c1b','127.0.0.1',1469725511,'__ci_last_regenerate|i:1469725412;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"2\";s:10:\"login_time\";s:19:\"2016-07-29 00:03:32\";}\";'),('f3d20592214b36381553eaedc7e2dd5577020f15','127.0.0.1',1469725968,'__ci_last_regenerate|i:1469725728;'),('bfdcf2858b2ccc0aa237515a55a270df150aa6bf','127.0.0.1',1469726395,'__ci_last_regenerate|i:1469726088;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"3\";s:10:\"login_time\";s:19:\"2016-07-29 00:14:48\";}\";'),('d945a6b8a0e5b9690ed6cbe1784d65b1de093b1f','127.0.0.1',1469726789,'__ci_last_regenerate|i:1469726559;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"3\";s:10:\"login_time\";s:19:\"2016-07-29 00:22:39\";}\";'),('801f14b21651d8069a681fad4fbbdba6dfb3b66c','127.0.0.1',1469727398,'__ci_last_regenerate|i:1469727131;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"1\";s:10:\"login_time\";s:19:\"2016-07-29 00:32:11\";}\";'),('4b0962f45637252112c0b19f75abdc040c393ed4','127.0.0.1',1469727541,'__ci_last_regenerate|i:1469727450;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"1\";s:10:\"login_time\";s:19:\"2016-07-29 00:32:11\";}\";'),('e3c92864e7ff8ff8996107762bd65eed75ba04e7','127.0.0.1',1469728849,'__ci_last_regenerate|i:1469728513;auth_identifiers|s:73:\"a:2:{s:7:\"user_id\";s:1:\"1\";s:10:\"login_time\";s:19:\"2016-07-29 00:32:11\";}\";'),('2fa240e71f992c389a4adf761cc5da494818cdff','127.0.0.1',1469729018,'__ci_last_regenerate|i:1469728881;'),('09b86a4132a152f9fdaa5d3f738e2c29abdd1b1b','127.0.0.1',1469729571,'__ci_last_regenerate|i:1469729383;'),('a8196540362b54459cf252c4522c61c86de69c85','127.0.0.1',1469729905,'__ci_last_regenerate|i:1469729717;'),('8c09122db18da4d1b07b980eb91b34e7b83bf479','127.0.0.1',1469730364,'__ci_last_regenerate|i:1469730022;'),('60648d233cedabc8fef51a9cd73f1120a218f22e','127.0.0.1',1469730648,'__ci_last_regenerate|i:1469730367;'),('7f2d0b63f9220ce305b8ea4f7cedec1e803c68eb','127.0.0.1',1469732373,'__ci_last_regenerate|i:1469730986;'),('6878756b65e203ef27dc96ba1592ac8a1bb1042b','127.0.0.1',1469732669,'__ci_last_regenerate|i:1469732377;'),('0cd902b0f244dda11323fdce852eca147ad1ce1f','127.0.0.1',1469732981,'__ci_last_regenerate|i:1469732692;'),('e5193c6d9a3840da2de42043d3e0c7a7dc748a3d','127.0.0.1',1469733366,'__ci_last_regenerate|i:1469733068;'),('5b7571a74486dfa3d711bb886c03d0c3ec1cab86','127.0.0.1',1469733659,'__ci_last_regenerate|i:1469733371;'),('48dfe8f4d2ddcc9d385c82b3172ffdbac4bd33ef','127.0.0.1',1469733738,'__ci_last_regenerate|i:1469733692;');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (0,'??????? ????????????',NULL,NULL,NULL,NULL,NULL,NULL),(103,'Atelier graphique','40.32.2555','54, rue Royale',NULL,'Nantes',NULL,'44000'),(112,'Signal Gift Stores','7025551838','8489 Strong St.',NULL,'Las Vegas','NV','83030'),(114,'Australian Collectors, Co.','03 9520 4555','636 St Kilda Road','Level 3','Melbourne','Victoria','3004'),(119,'La Rochelle Gifts','40.67.8555','67, rue des Cinquante Otages',NULL,'Nantes',NULL,'44000'),(121,'Baane Mini Imports','07-98 9555','Erling Skakkes gate 78',NULL,'Stavern',NULL,'4110'),(124,'Mini Gifts Distributors Ltd.','4155551450','5677 Strong St.',NULL,'San Rafael','CA','97562'),(125,'Havel & Zbyszek Co','(26) 642-7555','ul. Filtrowa 68',NULL,'Warszawa',NULL,'01-012'),(128,'Blauer See Auto, Co.','+49 69 66 90 2555','Lyonerstr. 34',NULL,'Frankfurt',NULL,'60528'),(129,'Mini Wheels Co.','6505555787','5557 North Pendale Street',NULL,'San Francisco','CA','94217'),(131,'Land of Toys Inc.','2125557818','897 Long Airport Avenue',NULL,'NYC','NY','10022'),(141,'Euro+ Shopping Channel','(91) 555 94 44','C/ Moralzarzal, 86',NULL,'Madrid',NULL,'28034'),(144,'Volvo Model Replicas, Co','0921-12 3555','Berguvsvägen  8',NULL,'Luleå',NULL,'S-958 22'),(145,'Danish Wholesale Imports','31 12 3555','Vinbæltet 34',NULL,'Kobenhavn',NULL,'1734'),(146,'Saveley & Henriot, Co.','78.32.5555','2, rue du Commerce',NULL,'Lyon',NULL,'69004'),(148,'Dragon Souveniers, Ltd.','+65 221 7555','Bronz Sok.','Bronz Apt. 3/6 Tesvikiye','Singapore',NULL,'079903'),(151,'Muscle Machine Inc','2125557413','4092 Furth Circle','Suite 400','NYC','NY','10022'),(157,'Diecast Classics Inc.','2155551555','7586 Pompton St.',NULL,'Allentown','PA','70267'),(161,'Technics Stores Inc.','6505556809','9408 Furth Circle',NULL,'Burlingame','CA','94217'),(166,'Handji Gifts& Co','+65 224 1555','106 Linden Road Sandown','2nd Floor','Singapore',NULL,'069045'),(167,'Herkku Gifts','+47 2267 3215','Brehmen St. 121','PR 334 Sentrum','Bergen',NULL,'N 5804'),(168,'American Souvenirs Inc','2035557845','149 Spinnaker Dr.','Suite 101','New Haven','CT','97823'),(169,'Porto Imports Co.','(1) 356-5555','Estrada da saúde n. 58',NULL,'Lisboa',NULL,'1756'),(171,'Daedalus Designs Imports','20.16.1555','184, chaussée de Tournai',NULL,'Lille',NULL,'59000'),(172,'La Corne D\'abondance, Co.','(1) 42.34.2555','265, boulevard Charonne',NULL,'Paris',NULL,'75012'),(173,'Cambridge Collectables Co.','6175555555','4658 Baden Av.',NULL,'Cambridge','MA','51247'),(175,'Gift Depot Inc.','2035552570','25593 South Bay Ln.',NULL,'Bridgewater','CT','97562'),(177,'Osaka Souveniers Co.','+81 06 6342 5555','1-6-20 Dojima',NULL,'Kita-ku','Osaka',' 530-0003'),(181,'Vitachrome Inc.','2125551500','2678 Kingston Rd.','Suite 101','NYC','NY','10022'),(186,'Toys of Finland, Co.','90-224 8555','Keskuskatu 45',NULL,'Helsinki',NULL,'21240'),(187,'AV Stores, Co.','(171) 555-1555','Fauntleroy Circus',NULL,'Manchester',NULL,'EC2 5NT'),(189,'Clover Collections, Co.','+353 1862 1555','25 Maiden Lane','Floor No. 4','Dublin',NULL,'2'),(198,'Auto-Moto Classics Inc.','6175558428','16780 Pompton St.',NULL,'Brickhaven','MA','58339'),(201,'UK Collectables, Ltd.','(171) 555-2282','12, Berkeley Gardens Blvd',NULL,'Liverpool',NULL,'WX1 6LT'),(202,'Canadian Gift Exchange Network','(604) 555-3392','1900 Oak St.',NULL,'Vancouver','BC','V3F 2K1'),(204,'Online Mini Collectables','6175557555','7635 Spinnaker Dr.',NULL,'Brickhaven','MA','58339'),(205,'Toys4GrownUps.com','6265557265','78934 Hillside Dr.',NULL,'Pasadena','CA','90003'),(206,'Asian Shopping Network, Co','+612 9411 1555','Suntec Tower Three','8 Temasek','Singapore',NULL,'038988'),(209,'Mini Caravy','88.60.1555','24, place Kléber',NULL,'Strasbourg',NULL,'67000'),(211,'King Kong Collectables, Co.','+852 2251 1555','Bank of China Tower','1 Garden Road','Central Hong Kong',NULL,NULL),(216,'Enaco Distributors','(93) 203 4555','Rambla de Cataluña, 23',NULL,'Barcelona',NULL,'08022'),(219,'Boards & Toys Co.','3105552373','4097 Douglas Av.',NULL,'Glendale','CA','92561'),(223,'Natürlich Autos','0372-555188','Taucherstraße 10',NULL,'Cunewalde',NULL,'01307'),(227,'Heintze Collectables','86 21 3555','Smagsloget 45',NULL,'Århus',NULL,'8200'),(233,'Québec Home Shopping Network','(514) 555-8054','43 rue St. Laurent',NULL,'Montréal','Québec','H1J 1C3'),(237,'ANG Resellers','(91) 745 6555','Gran Vía, 1',NULL,'Madrid',NULL,'28001'),(239,'Collectable Mini Designs Co.','7605558146','361 Furth Circle',NULL,'San Diego','CA','91217'),(240,'giftsbymail.co.uk','(198) 555-8888','Garden House','Crowther Way 23','Cowes','Isle of Wight','PO31 7PJ'),(242,'Alpha Cognac','61.77.6555','1 rue Alsace-Lorraine',NULL,'Toulouse',NULL,'31000'),(247,'Messner Shopping Network','069-0555984','Magazinweg 7',NULL,'Frankfurt',NULL,'60528'),(249,'Amica Models & Co.','011-4988555','Via Monte Bianco 34',NULL,'Torino',NULL,'10100'),(250,'Lyon Souveniers','+33 1 46 62 7555','27 rue du Colonel Pierre Avia',NULL,'Paris',NULL,'75508'),(256,'Auto Associés & Cie.','30.59.8555','67, avenue de l\'Europe',NULL,'Versailles',NULL,'78000'),(259,'Toms Spezialitäten, Ltd','0221-5554327','Mehrheimerstr. 369',NULL,'Köln',NULL,'50739'),(260,'Royal Canadian Collectables, Ltd.','(604) 555-4555','23 Tsawassen Blvd.',NULL,'Tsawassen','BC','T2F 8M4'),(273,'Franken Gifts, Co','089-0877555','Berliner Platz 43',NULL,'München',NULL,'80805'),(276,'Anna\'s Decorations, Ltd','02 9936 8555','201 Miller Street','Level 15','North Sydney','NSW','2060'),(278,'Rovelli Gifts','035-640555','Via Ludovico il Moro 22',NULL,'Bergamo',NULL,'24100'),(282,'Souveniers And Things Co.','+61 2 9495 8555','Monitor Money Building','815 Pacific Hwy','Chatswood','NSW','2067'),(286,'Marta\'s Replicas Co.','6175558555','39323 Spinnaker Dr.',NULL,'Cambridge','MA','51247'),(293,'BG&E Collectables','+41 26 425 50 01','Rte des Arsenaux 41 ',NULL,'Fribourg',NULL,'1700'),(298,'Vida Sport, Ltd','0897-034555','Grenzacherweg 237',NULL,'Genève',NULL,'1203'),(299,'Norway Gifts By Mail, Co.','+47 2212 1555','Drammensveien 126A','PB 211 Sentrum','Oslo',NULL,'N 0106'),(303,'Schuyler Imports','+31 20 491 9555','Kingsfordweg 151',NULL,'Amsterdam',NULL,'1043 GR'),(307,'Der Hund Imports','030-0074555','Obere Str. 57',NULL,'Berlin',NULL,'12209'),(311,'Oulu Toy Supplies, Inc.','981-443655','Torikatu 38',NULL,'Oulu',NULL,'90110'),(314,'Petit Auto','(02) 5554 67','Rue Joseph-Bens 532',NULL,'Bruxelles',NULL,'B-1180'),(319,'Mini Classics','9145554562','3758 North Pendale Street',NULL,'White Plains','NY','24067'),(320,'Mini Creations Ltd.','5085559555','4575 Hillside Dr.',NULL,'New Bedford','MA','50553'),(321,'Corporate Gift Ideas Co.','6505551386','7734 Strong St.',NULL,'San Francisco','CA','94217'),(323,'Down Under Souveniers, Inc','+64 9 312 5555','162-164 Grafton Road','Level 2','Auckland  ',NULL,NULL),(324,'Stylish Desk Decors, Co.','(171) 555-0297','35 King George',NULL,'London',NULL,'WX3 6FW'),(328,'Tekni Collectables Inc.','2015559350','7476 Moss Rd.',NULL,'Newark','NJ','94019'),(333,'Australian Gift Network, Co','61-7-3844-6555','31 Duncan St. West End',NULL,'South Brisbane','Queensland','4101'),(334,'Suominen Souveniers','+358 9 8045 555','Software Engineering Center','SEC Oy','Espoo',NULL,'FIN-02271'),(335,'Cramer Spezialitäten, Ltd','0555-09555','Maubelstr. 90',NULL,'Brandenburg',NULL,'14776'),(339,'Classic Gift Ideas, Inc','2155554695','782 First Street',NULL,'Philadelphia','PA','71270'),(344,'CAF Imports','+34 913 728 555','Merchants House','27-30 Merchant\'s Quay','Madrid',NULL,'28023'),(347,'Men \'R\' US Retailers, Ltd.','2155554369','6047 Douglas Av.',NULL,'Los Angeles','CA','91003'),(348,'Asian Treasures, Inc.','2967 555','8 Johnstown Road',NULL,'Cork','Co. Cork',NULL),(350,'Marseille Mini Autos','91.24.4555','12, rue des Bouchers',NULL,'Marseille',NULL,'13008'),(353,'Reims Collectables','26.47.1555','59 rue de l\'Abbaye',NULL,'Reims',NULL,'51100'),(356,'SAR Distributors, Co','+27 21 550 3555','1250 Pretorius Street',NULL,'Hatfield','Pretoria','0028'),(357,'GiftsForHim.com','64-9-3763555','199 Great North Road',NULL,'Auckland',NULL,NULL),(361,'Kommission Auto','0251-555259','Luisenstr. 48',NULL,'Münster',NULL,'44087'),(362,'Gifts4AllAges.com','6175559555','8616 Spinnaker Dr.',NULL,'Boston','MA','51003'),(363,'Online Diecast Creations Co.','6035558647','2304 Long Airport Avenue',NULL,'Nashua','NH','62005'),(369,'Lisboa Souveniers, Inc','(1) 354-2555','Jardim das rosas n. 32',NULL,'Lisboa',NULL,'1675'),(376,'Precious Collectables','0452-076555','Hauptstr. 29',NULL,'Bern',NULL,'3012'),(379,'Collectables For Less Inc.','6175558555','7825 Douglas Av.',NULL,'Brickhaven','MA','58339'),(381,'Royale Belge','(071) 23 67 2555','Boulevard Tirou, 255',NULL,'Charleroi',NULL,'B-6000'),(382,'Salzburg Collectables','6562-9555','Geislweg 14',NULL,'Salzburg',NULL,'5020'),(385,'Cruz & Sons Co.','+63 2 555 3587','15 McCallum Street','NatWest Center #13-03','Makati City',NULL,'1227 MM'),(386,'L\'ordine Souveniers','0522-556555','Strada Provinciale 124',NULL,'Reggio Emilia',NULL,'42100'),(398,'Tokyo Collectables, Ltd','+81 3 3584 0555','2-2-8 Roppongi',NULL,'Minato-ku','Tokyo','106-0032'),(406,'Auto Canal+ Petit','(1) 47.55.6555','25, rue Lauriston',NULL,'Paris',NULL,'75016'),(409,'Stuttgart Collectable Exchange','0711-555361','Adenauerallee 900',NULL,'Stuttgart',NULL,'70563'),(412,'Extreme Desk Decorations, Ltd','04 499 9555','101 Lambton Quay','Level 11','Wellington',NULL,NULL),(415,'Bavarian Collectables Imports, Co.',' +49 89 61 08 9555','Hansastr. 15',NULL,'Munich',NULL,'80686'),(424,'Classic Legends Inc.','2125558493','5905 Pompton St.','Suite 750','NYC','NY','10022'),(443,'Feuer Online Stores, Inc','0342-555176','Heerstr. 22',NULL,'Leipzig',NULL,'04179'),(447,'Gift Ideas Corp.','2035554407','2440 Pompton St.',NULL,'Glendale','CT','97561'),(448,'Scandinavian Gift Ideas','0695-34 6555','Åkergatan 24',NULL,'Bräcke',NULL,'S-844 67'),(450,'The Sharp Gifts Warehouse','4085553659','3086 Ingle Ln.',NULL,'San Jose','CA','94217'),(452,'Mini Auto Werke','7675-3555','Kirchgasse 6',NULL,'Graz',NULL,'8010'),(455,'Super Scale Inc.','2035559545','567 North Pendale Street',NULL,'New Haven','CT','97823'),(456,'Microscale Inc.','2125551957','5290 North Pendale Street','Suite 200','NYC','NY','10022'),(458,'Corrida Auto Replicas, Ltd','(91) 555 22 82','C/ Araquil, 67',NULL,'Madrid',NULL,'28023'),(459,'Warburg Exchange','0241-039123','Walserweg 21',NULL,'Aachen',NULL,'52066'),(462,'FunGiftIdeas.com','5085552555','1785 First Street',NULL,'New Bedford','MA','50553'),(465,'Anton Designs, Ltd.','+34 913 728555','c/ Gobelas, 19-1 Urb. La Florida',NULL,'Madrid',NULL,'28023'),(471,'Australian Collectables, Ltd','61-9-3844-6555','7 Allen Street',NULL,'Glen Waverly','Victoria','3150'),(473,'Frau da Collezione','+39 022515555','20093 Cologno Monzese','Alessandro Volta 16','Milan',NULL,NULL),(475,'West Coast Collectables Co.','3105553722','3675 Furth Circle',NULL,'Burbank','CA','94019'),(477,'Mit Vergnügen & Co.','0621-08555','Forsterstr. 57',NULL,'Mannheim',NULL,'68306'),(480,'Kremlin Collectables, Co.','+7 812 293 0521','2 Pobedy Square',NULL,'Saint Petersburg',NULL,'196143'),(481,'Raanan Stores, Inc','+ 972 9 959 8555','3 Hagalim Blv.',NULL,'Herzlia',NULL,'47625'),(484,'Iberia Gift Imports, Corp.','(95) 555 82 82','C/ Romero, 33',NULL,'Sevilla',NULL,'41101'),(486,'Motor Mint Distributors Inc.','2155559857','11328 Douglas Av.',NULL,'Philadelphia','PA','71270'),(487,'Signal Collectibles Ltd.','4155554312','2793 Furth Circle',NULL,'Brisbane','CA','94217'),(489,'Double Decker Gift Stores, Ltd','(171) 555-7555','120 Hanover Sq.',NULL,'London',NULL,'12333'),(495,'Diecast Collectables','6175552555','6251 Ingle Ln.',NULL,'Boston','MA','51003'),(496,'Kelly\'s Gift Shop','+64 9 5555500','Arenales 1938 3\'A\'',NULL,'Auckland  ',NULL,NULL),(2333,'ณัฐกรณ์ วงศ์สายเชื้อ',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denied_access`
--

DROP TABLE IF EXISTS `denied_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denied_access` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denied_access`
--

LOCK TABLES `denied_access` WRITE;
/*!40000 ALTER TABLE `denied_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `denied_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips_on_hold`
--

DROP TABLE IF EXISTS `ips_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips_on_hold`
--

LOCK TABLES `ips_on_hold` WRITE;
/*!40000 ALTER TABLE `ips_on_hold` DISABLE KEYS */;
/*!40000 ALTER TABLE `ips_on_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lands`
--

DROP TABLE IF EXISTS `lands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lands` (
  `land_id` int(10) NOT NULL AUTO_INCREMENT,
  `address1` varchar(128) DEFAULT NULL,
  `address2` varchar(128) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `postal_code` varchar(15) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `identification_id` varchar(45) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`land_id`),
  UNIQUE KEY `identification_id_UNIQUE` (`identification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lands`
--

LOCK TABLES `lands` WRITE;
/*!40000 ALTER TABLE `lands` DISABLE KEYS */;
INSERT INTO `lands` VALUES (1,'12234',NULL,NULL,NULL,406,NULL,NULL,'dsvv',NULL,'a08c9-042a8037-980x653.jpg');
/*!40000 ALTER TABLE `lands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_errors`
--

DROP TABLE IF EXISTS `login_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_errors` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_errors`
--

LOCK TABLES `login_errors` WRITE;
/*!40000 ALTER TABLE `login_errors` DISABLE KEYS */;
INSERT INTO `login_errors` VALUES (10,'test','127.0.0.1','2016-07-29 00:12:40'),(9,'test','127.0.0.1','2016-07-29 00:12:31');
/*!40000 ALTER TABLE `login_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `username_or_email_on_hold`
--

DROP TABLE IF EXISTS `username_or_email_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `username_or_email_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `username_or_email_on_hold`
--

LOCK TABLES `username_or_email_on_hold` WRITE;
/*!40000 ALTER TABLE `username_or_email_on_hold` DISABLE KEYS */;
/*!40000 ALTER TABLE `username_or_email_on_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `auth_level` tinyint(3) unsigned NOT NULL,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `passwd` varchar(60) NOT NULL,
  `passwd_recovery_code` varchar(60) DEFAULT NULL,
  `passwd_recovery_date` datetime DEFAULT NULL,
  `passwd_modified_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`name`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@example.com',9,'0','$2y$11$WGzGp7nhIqy9uvqjEgFYnO94NfTZAdb1f9SMJmnydEUJE7/WKavuS',NULL,NULL,NULL,'2016-07-29 00:32:11','2016-07-28 18:39:13','2016-07-28 17:32:11',NULL),(3,'test','ณัฐกรณ์ วงศ์สายเชื้อ',9,'0','$2y$11$1362tK/Tfr9m.EMvWKRaQ.BeLWJgtj6EvPpQdzVhHPZ84RYg9Fqdy',NULL,NULL,'2016-07-29 00:22:01','2016-07-29 00:22:39','0000-00-00 00:00:00','2016-07-28 17:22:39',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-29  2:22:46
