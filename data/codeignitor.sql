-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2016 at 08:26 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeignitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl`
--

CREATE TABLE IF NOT EXISTS `acl` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ai`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_actions`
--

CREATE TABLE IF NOT EXISTS `acl_actions` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `action_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_categories`
--

CREATE TABLE IF NOT EXISTS `acl_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `category_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  UNIQUE KEY `category_desc` (`category_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_sessions`
--

CREATE TABLE IF NOT EXISTS `auth_sessions` (
  `id` varchar(40) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_sessions`
--

INSERT INTO `auth_sessions` (`id`, `user_id`, `login_time`, `modified_at`, `ip_address`, `user_agent`) VALUES
('4b0962f45637252112c0b19f75abdc040c393ed4', 1, '2016-07-29 00:32:11', '2016-07-28 17:37:30', '127.0.0.1', 'Firefox 47.0 on Mac OS X'),
('1c20d5a0dfd1b4f364553deed5111d8eb32d342d', 3004374188, '2016-07-28 19:05:54', '2016-07-28 15:26:16', '127.0.0.1', 'Firefox 47.0 on Mac OS X'),
('d172fe0402e96073ee5af961d3292fb693fc1340', 1, '2016-07-29 15:12:44', '2016-07-29 08:12:44', '::1', 'Internet Explorer 7.0 on Windows 8'),
('daf184260075e4c0b7f4c6d3ef58db6a2a7f4b89', 1, '2016-07-29 16:19:57', '2016-07-29 10:06:02', '::1', 'Firefox 47.0 on Windows 8'),
('f0d1f3c177a310dcd2682b3c386c9f2b7a3b2272', 1, '2016-08-01 13:49:42', '2016-08-01 10:08:42', '::1', 'Firefox 47.0 on Windows 8'),
('868b8e30178679504d40dcca5c45d5ac6c0317d2', 1, '2016-08-02 09:01:56', '2016-08-02 03:22:38', '::1', 'Firefox 47.0 on Windows 8'),
('029e23a1394f8fe3b4ceb0b999f92536444e52e3', 1, '2016-08-02 11:48:39', '2016-08-02 08:13:03', '::1', 'Firefox 47.0 on Windows 8'),
('cdebe69d41f6c2f622ba1d32807fbe3675a07860', 1, '2016-08-03 09:29:29', '2016-08-03 10:31:02', '::1', 'Firefox 47.0 on Windows 8'),
('16352bba9cf8e9bbab8f96f2a3805aa33133515c', 1, '2016-08-04 10:13:35', '2016-08-04 04:18:43', '::1', 'Firefox 47.0 on Windows 8'),
('605c176e75508f1eeb69cda6a634e1d2bff06a17', 1, '2016-08-04 16:26:55', '2016-08-04 10:55:01', '::1', 'Firefox 47.0 on Windows 8'),
('e5e2568d711f5f7daf52ebba516299696b6c08b5', 1, '2016-08-08 08:50:11', '2016-08-08 09:28:56', '::1', 'Firefox 47.0 on Windows 8'),
('0ea22dacf5a8ad0fff8a50a5a2b2144b80f4c00f', 1, '2016-08-09 10:31:44', '2016-08-09 03:31:44', '::1', 'Firefox 47.0 on Windows 8'),
('f1692828cb89b4829655da4f71c5fd891e3e3210', 1, '2016-08-09 12:05:09', '2016-08-09 05:05:09', '::1', 'Firefox 47.0 on Windows 8'),
('08dadd2cb0ca35fd9ddb1cd5c9fb8bd2c6fa7604', 1, '2016-08-09 14:14:56', '2016-08-09 07:14:56', '::1', 'Firefox 47.0 on Windows 8'),
('fd7c2fed0dc43dff62ee2b50b60560fa3748619c', 1, '2016-08-09 14:22:18', '2016-08-09 07:36:35', '::1', 'Firefox 47.0 on Windows 8'),
('da88020a412644fa65fa325b6f9a44920aa521b9', 1, '2016-08-09 15:21:38', '2016-08-09 08:21:38', '::1', 'Firefox 47.0 on Windows 8'),
('1fe96037eb9c3f3c68e19eafda465219cac02f38', 1, '2016-08-09 15:47:24', '2016-08-09 09:57:29', '::1', 'Firefox 47.0 on Windows 8'),
('f3ed4a1cca2f4235c7aa8df2d3cac199d13da4a6', 1, '2016-08-10 09:29:56', '2016-08-10 02:49:07', '::1', 'Firefox 47.0 on Windows 8'),
('739fedfd624e87af0e303e2b17f9d2adacd6728b', 1, '2016-08-10 14:00:43', '2016-08-10 08:35:32', '::1', 'Firefox 47.0 on Windows 8'),
('5bb7d2fc28679435cfee03af7fb86f31b8393972', 1, '2016-08-11 09:24:28', '2016-08-11 02:24:29', '::1', 'Firefox 47.0 on Windows 8'),
('94be20d7536f70e219806a373c198bc14649d3db', 1, '2016-08-11 10:42:23', '2016-08-11 04:29:32', '::1', 'Firefox 47.0 on Windows 8'),
('e589dcecfd0af2669287c1e5b6c0d556658ae507', 1, '2016-08-11 12:04:34', '2016-08-11 09:53:36', '::1', 'Firefox 47.0 on Windows 8'),
('787a0049e9fb839a4584335d93778790ea01d2f2', 1, '2016-08-15 09:17:32', '2016-08-15 09:03:41', '::1', 'Firefox 47.0 on Windows 8'),
('df960fab5d53a8ea0ffebea7af5bdd10f0b874c4', 1, '2016-08-16 08:55:26', '2016-08-16 06:18:21', '::1', 'Firefox 47.0 on Windows 8');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('404567c33ca839edad1616939b7f37b000d50b2d', '::1', 1471320183, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332303138333b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('e04d7b1880ef03750a488ae3d55fdea7463337ad', '::1', 1471319153, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331383934383b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('b5729aafe1259849eee05e6d8a6f29d9ff91f115', '::1', 1471318759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331383634373b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('d675f1489700b8c41b259e87d17668cc433d7ff6', '::1', 1471318081, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331383032303b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('e4a0bd3445b8318ad83bd47cbac7a5d6f9825279', '::1', 1471317979, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331373731303b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('aa9d46d5a68b9620df43e16d481de2ffa3a0872b', '::1', 1471317664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331373338303b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('a62f6bb7b9c19880745e618d63383232f6c22de0', '::1', 1471316600, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331363438313b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('191fa63da5c26b254d5aa9be9e3f2b50f156888b', '::1', 1471315932, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331353833323b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('65c911b474f097b119a000a8308f288a251c8fc6', '::1', 1471315697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331353433353b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('c5d03f39c75edbcb1c52956f409f9ee87b0828b8', '::1', 1471315222, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331353038383b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('076255d1e6aabb867f5da5747db30505681660bd', '::1', 1471314798, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331343730333b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('9ebd565aca881dd5d53a0d20646d7bed52375179', '::1', 1471314535, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331343336313b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('10d288741529ae137493ff275d98c3c0272a760d', '::1', 1471314249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313331343031303b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('91b1619bdce38c74f677ad616fd621afb17ad06b', '::1', 1471324570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332343136383b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('df960fab5d53a8ea0ffebea7af5bdd10f0b874c4', '::1', 1471328306, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332383330313b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('34730b0a92ce4e9c9ebc4123bbbf0af97380fc74', '::1', 1471323501, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332333530303b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('56b464eecd4a3d674c532bee449cce2ad30f1858', '::1', 1471323445, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332333132373b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('a223ed32ec07fc3609a589b8b85d955761f8f1d7', '::1', 1471323064, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332323831333b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('ffab76f6c0bff357ede7d3373f726c8bbe836826', '::1', 1471321986, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332313639353b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('330945e9ff113215e75931d6b87345281ffa4746', '::1', 1471321267, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332313233363b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b),
('4d592d53abd1f886921a708a540021f9ae99c664', '::1', 1471320864, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437313332303631323b617574685f6964656e746966696572737c733a37333a22613a323a7b733a373a22757365725f6964223b733a313a2231223b733a31303a226c6f67696e5f74696d65223b733a31393a22323031362d30382d31362030383a35353a3236223b7d223b617574685f757365725f69647c733a313a2231223b617574685f757365726e616d657c733a353a2261646d696e223b617574685f6c6576656c7c733a313a2239223b617574685f726f6c657c733a353a2261646d696e223b617574685f656d61696c7c4e3b);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` bigint(13) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `phone`, `address1`, `address2`, `city`, `state`, `postal_code`) VALUES
(0, '??????? ????????????', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'Atelier graphique', '40.32.2555', '54, rue Royale', NULL, 'Nantes', NULL, '44000'),
(112, 'Signal Gift Stores', '7025551838', '8489 Strong St.', NULL, 'Las Vegas', 'NV', '83030'),
(114, 'Australian Collectors, Co.', '03 9520 4555', '636 St Kilda Road', 'Level 3', 'Melbourne', 'Victoria', '3004'),
(119, 'La Rochelle Gifts', '40.67.8555', '67, rue des Cinquante Otages', NULL, 'Nantes', NULL, '44000'),
(121, 'Baane Mini Imports', '07-98 9555', 'Erling Skakkes gate 78', NULL, 'Stavern', NULL, '4110'),
(124, 'Mini Gifts Distributors Ltd.', '4155551450', '5677 Strong St.', NULL, 'San Rafael', 'CA', '97562'),
(125, 'Havel & Zbyszek Co', '(26) 642-7555', 'ul. Filtrowa 68', NULL, 'Warszawa', NULL, '01-012'),
(128, 'Blauer See Auto, Co.', '+49 69 66 90 2555', 'Lyonerstr. 34', NULL, 'Frankfurt', NULL, '60528'),
(129, 'Mini Wheels Co.', '6505555787', '5557 North Pendale Street', NULL, 'San Francisco', 'CA', '94217'),
(131, 'Land of Toys Inc.', '2125557818', '897 Long Airport Avenue', NULL, 'NYC', 'NY', '10022'),
(141, 'Euro+ Shopping Channel', '(91) 555 94 44', 'C/ Moralzarzal, 86', NULL, 'Madrid', NULL, '28034'),
(144, 'Volvo Model Replicas, Co', '0921-12 3555', 'Berguvsvägen  8', NULL, 'Luleå', NULL, 'S-958 22'),
(145, 'Danish Wholesale Imports', '31 12 3555', 'Vinbæltet 34', NULL, 'Kobenhavn', NULL, '1734'),
(146, 'Saveley & Henriot, Co.', '78.32.5555', '2, rue du Commerce', NULL, 'Lyon', NULL, '69004'),
(148, 'Dragon Souveniers, Ltd.', '+65 221 7555', 'Bronz Sok.', 'Bronz Apt. 3/6 Tesvikiye', 'Singapore', NULL, '079903'),
(151, 'Muscle Machine Inc', '2125557413', '4092 Furth Circle', 'Suite 400', 'NYC', 'NY', '10022'),
(157, 'Diecast Classics Inc.', '2155551555', '7586 Pompton St.', NULL, 'Allentown', 'PA', '70267'),
(161, 'Technics Stores Inc.', '6505556809', '9408 Furth Circle', NULL, 'Burlingame', 'CA', '94217'),
(166, 'Handji Gifts& Co', '+65 224 1555', '106 Linden Road Sandown', '2nd Floor', 'Singapore', NULL, '069045'),
(167, 'Herkku Gifts', '+47 2267 3215', 'Brehmen St. 121', 'PR 334 Sentrum', 'Bergen', NULL, 'N 5804'),
(168, 'American Souvenirs Inc', '2035557845', '149 Spinnaker Dr.', 'Suite 101', 'New Haven', 'CT', '97823'),
(169, 'Porto Imports Co.', '(1) 356-5555', 'Estrada da saúde n. 58', NULL, 'Lisboa', NULL, '1756'),
(171, 'Daedalus Designs Imports', '20.16.1555', '184, chaussée de Tournai', NULL, 'Lille', NULL, '59000'),
(172, 'La Corne D''abondance, Co.', '(1) 42.34.2555', '265, boulevard Charonne', NULL, 'Paris', NULL, '75012'),
(173, 'Cambridge Collectables Co.', '6175555555', '4658 Baden Av.', NULL, 'Cambridge', 'MA', '51247'),
(175, 'Gift Depot Inc.', '2035552570', '25593 South Bay Ln.', NULL, 'Bridgewater', 'CT', '97562'),
(177, 'Osaka Souveniers Co.', '+81 06 6342 5555', '1-6-20 Dojima', NULL, 'Kita-ku', 'Osaka', ' 530-0003'),
(181, 'Vitachrome Inc.', '2125551500', '2678 Kingston Rd.', 'Suite 101', 'NYC', 'NY', '10022'),
(186, 'Toys of Finland, Co.', '90-224 8555', 'Keskuskatu 45', NULL, 'Helsinki', NULL, '21240'),
(187, 'AV Stores, Co.', '(171) 555-1555', 'Fauntleroy Circus', NULL, 'Manchester', NULL, 'EC2 5NT'),
(189, 'Clover Collections, Co.', '+353 1862 1555', '25 Maiden Lane', 'Floor No. 4', 'Dublin', NULL, '2'),
(198, 'Auto-Moto Classics Inc.', '6175558428', '16780 Pompton St.', NULL, 'Brickhaven', 'MA', '58339'),
(201, 'UK Collectables, Ltd.', '(171) 555-2282', '12, Berkeley Gardens Blvd', NULL, 'Liverpool', NULL, 'WX1 6LT'),
(202, 'Canadian Gift Exchange Network', '(604) 555-3392', '1900 Oak St.', NULL, 'Vancouver', 'BC', 'V3F 2K1'),
(204, 'Online Mini Collectables', '6175557555', '7635 Spinnaker Dr.', NULL, 'Brickhaven', 'MA', '58339'),
(205, 'Toys4GrownUps.com', '6265557265', '78934 Hillside Dr.', NULL, 'Pasadena', 'CA', '90003'),
(206, 'Asian Shopping Network, Co', '+612 9411 1555', 'Suntec Tower Three', '8 Temasek', 'Singapore', NULL, '038988'),
(209, 'Mini Caravy', '88.60.1555', '24, place Kléber', NULL, 'Strasbourg', NULL, '67000'),
(211, 'King Kong Collectables, Co.', '+852 2251 1555', 'Bank of China Tower', '1 Garden Road', 'Central Hong Kong', NULL, NULL),
(216, 'Enaco Distributors', '(93) 203 4555', 'Rambla de Cataluña, 23', NULL, 'Barcelona', NULL, '08022'),
(219, 'Boards & Toys Co.', '3105552373', '4097 Douglas Av.', NULL, 'Glendale', 'CA', '92561'),
(223, 'Natürlich Autos', '0372-555188', 'Taucherstraße 10', NULL, 'Cunewalde', NULL, '01307'),
(227, 'Heintze Collectables', '86 21 3555', 'Smagsloget 45', NULL, 'Århus', NULL, '8200'),
(233, 'Québec Home Shopping Network', '(514) 555-8054', '43 rue St. Laurent', NULL, 'Montréal', 'Québec', 'H1J 1C3'),
(237, 'ANG Resellers', '(91) 745 6555', 'Gran Vía, 1', NULL, 'Madrid', NULL, '28001'),
(239, 'Collectable Mini Designs Co.', '7605558146', '361 Furth Circle', NULL, 'San Diego', 'CA', '91217'),
(240, 'giftsbymail.co.uk', '(198) 555-8888', 'Garden House', 'Crowther Way 23', 'Cowes', 'Isle of Wight', 'PO31 7PJ'),
(242, 'Alpha Cognac', '61.77.6555', '1 rue Alsace-Lorraine', NULL, 'Toulouse', NULL, '31000'),
(247, 'Messner Shopping Network', '069-0555984', 'Magazinweg 7', NULL, 'Frankfurt', NULL, '60528'),
(249, 'Amica Models & Co.', '011-4988555', 'Via Monte Bianco 34', NULL, 'Torino', NULL, '10100'),
(250, 'Lyon Souveniers', '+33 1 46 62 7555', '27 rue du Colonel Pierre Avia', NULL, 'Paris', NULL, '75508'),
(256, 'Auto Associés & Cie.', '30.59.8555', '67, avenue de l''Europe', NULL, 'Versailles', NULL, '78000'),
(259, 'Toms Spezialitäten, Ltd', '0221-5554327', 'Mehrheimerstr. 369', NULL, 'Köln', NULL, '50739'),
(260, 'Royal Canadian Collectables, Ltd.', '(604) 555-4555', '23 Tsawassen Blvd.', NULL, 'Tsawassen', 'BC', 'T2F 8M4'),
(273, 'Franken Gifts, Co', '089-0877555', 'Berliner Platz 43', NULL, 'München', NULL, '80805'),
(276, 'Anna''s Decorations, Ltd', '02 9936 8555', '201 Miller Street', 'Level 15', 'North Sydney', 'NSW', '2060'),
(278, 'Rovelli Gifts', '035-640555', 'Via Ludovico il Moro 22', NULL, 'Bergamo', NULL, '24100'),
(282, 'Souveniers And Things Co.', '+61 2 9495 8555', 'Monitor Money Building', '815 Pacific Hwy', 'Chatswood', 'NSW', '2067'),
(286, 'Marta''s Replicas Co.', '6175558555', '39323 Spinnaker Dr.', NULL, 'Cambridge', 'MA', '51247'),
(293, 'BG&E Collectables', '+41 26 425 50 01', 'Rte des Arsenaux 41 ', NULL, 'Fribourg', NULL, '1700'),
(298, 'Vida Sport, Ltd', '0897-034555', 'Grenzacherweg 237', NULL, 'Genève', NULL, '1203'),
(299, 'Norway Gifts By Mail, Co.', '+47 2212 1555', 'Drammensveien 126A', 'PB 211 Sentrum', 'Oslo', NULL, 'N 0106'),
(303, 'Schuyler Imports', '+31 20 491 9555', 'Kingsfordweg 151', NULL, 'Amsterdam', NULL, '1043 GR'),
(307, 'Der Hund Imports', '030-0074555', 'Obere Str. 57', NULL, 'Berlin', NULL, '12209'),
(311, 'Oulu Toy Supplies, Inc.', '981-443655', 'Torikatu 38', NULL, 'Oulu', NULL, '90110'),
(314, 'Petit Auto', '(02) 5554 67', 'Rue Joseph-Bens 532', NULL, 'Bruxelles', NULL, 'B-1180'),
(319, 'Mini Classics', '9145554562', '3758 North Pendale Street', NULL, 'White Plains', 'NY', '24067'),
(320, 'Mini Creations Ltd.', '5085559555', '4575 Hillside Dr.', NULL, 'New Bedford', 'MA', '50553'),
(321, 'Corporate Gift Ideas Co.', '6505551386', '7734 Strong St.', NULL, 'San Francisco', 'CA', '94217'),
(323, 'Down Under Souveniers, Inc', '+64 9 312 5555', '162-164 Grafton Road', 'Level 2', 'Auckland  ', NULL, NULL),
(324, 'Stylish Desk Decors, Co.', '(171) 555-0297', '35 King George', NULL, 'London', NULL, 'WX3 6FW'),
(328, 'Tekni Collectables Inc.', '2015559350', '7476 Moss Rd.', NULL, 'Newark', 'NJ', '94019'),
(333, 'Australian Gift Network, Co', '61-7-3844-6555', '31 Duncan St. West End', NULL, 'South Brisbane', 'Queensland', '4101'),
(334, 'Suominen Souveniers', '+358 9 8045 555', 'Software Engineering Center', 'SEC Oy', 'Espoo', NULL, 'FIN-02271'),
(335, 'Cramer Spezialitäten, Ltd', '0555-09555', 'Maubelstr. 90', NULL, 'Brandenburg', NULL, '14776'),
(339, 'Classic Gift Ideas, Inc', '2155554695', '782 First Street', NULL, 'Philadelphia', 'PA', '71270'),
(344, 'CAF Imports', '+34 913 728 555', 'Merchants House', '27-30 Merchant''s Quay', 'Madrid', NULL, '28023'),
(347, 'Men ''R'' US Retailers, Ltd.', '2155554369', '6047 Douglas Av.', NULL, 'Los Angeles', 'CA', '91003'),
(348, 'Asian Treasures, Inc.', '2967 555', '8 Johnstown Road', NULL, 'Cork', 'Co. Cork', NULL),
(350, 'Marseille Mini Autos', '91.24.4555', '12, rue des Bouchers', NULL, 'Marseille', NULL, '13008'),
(353, 'Reims Collectables', '26.47.1555', '59 rue de l''Abbaye', NULL, 'Reims', NULL, '51100'),
(356, 'SAR Distributors, Co', '+27 21 550 3555', '1250 Pretorius Street', NULL, 'Hatfield', 'Pretoria', '0028'),
(357, 'GiftsForHim.com', '64-9-3763555', '199 Great North Road', NULL, 'Auckland', NULL, NULL),
(361, 'Kommission Auto', '0251-555259', 'Luisenstr. 48', NULL, 'Münster', NULL, '44087'),
(362, 'Gifts4AllAges.com', '6175559555', '8616 Spinnaker Dr.', NULL, 'Boston', 'MA', '51003'),
(363, 'Online Diecast Creations Co.', '6035558647', '2304 Long Airport Avenue', NULL, 'Nashua', 'NH', '62005'),
(369, 'Lisboa Souveniers, Inc', '(1) 354-2555', 'Jardim das rosas n. 32', NULL, 'Lisboa', NULL, '1675'),
(376, 'Precious Collectables', '0452-076555', 'Hauptstr. 29', NULL, 'Bern', NULL, '3012'),
(379, 'Collectables For Less Inc.', '6175558555', '7825 Douglas Av.', NULL, 'Brickhaven', 'MA', '58339'),
(381, 'Royale Belge', '(071) 23 67 2555', 'Boulevard Tirou, 255', NULL, 'Charleroi', NULL, 'B-6000'),
(382, 'Salzburg Collectables', '6562-9555', 'Geislweg 14', NULL, 'Salzburg', NULL, '5020'),
(385, 'Cruz & Sons Co.', '+63 2 555 3587', '15 McCallum Street', 'NatWest Center #13-03', 'Makati City', NULL, '1227 MM'),
(386, 'L''ordine Souveniers', '0522-556555', 'Strada Provinciale 124', NULL, 'Reggio Emilia', NULL, '42100'),
(398, 'Tokyo Collectables, Ltd', '+81 3 3584 0555', '2-2-8 Roppongi', NULL, 'Minato-ku', 'Tokyo', '106-0032'),
(406, 'Auto Canal+ Petit', '(1) 47.55.6555', '25, rue Lauriston', NULL, 'Paris', NULL, '75016'),
(409, 'Stuttgart Collectable Exchange', '0711-555361', 'Adenauerallee 900', NULL, 'Stuttgart', NULL, '70563'),
(412, 'Extreme Desk Decorations, Ltd', '04 499 9555', '101 Lambton Quay', 'Level 11', 'Wellington', NULL, NULL),
(415, 'Bavarian Collectables Imports, Co.', ' +49 89 61 08 9555', 'Hansastr. 15', NULL, 'Munich', NULL, '80686'),
(424, 'Classic Legends Inc.', '2125558493', '5905 Pompton St.', 'Suite 750', 'NYC', 'NY', '10022'),
(443, 'Feuer Online Stores, Inc', '0342-555176', 'Heerstr. 22', NULL, 'Leipzig', NULL, '04179'),
(447, 'Gift Ideas Corp.', '2035554407', '2440 Pompton St.', NULL, 'Glendale', 'CT', '97561'),
(448, 'Scandinavian Gift Ideas', '0695-34 6555', 'Åkergatan 24', NULL, 'Bräcke', NULL, 'S-844 67'),
(450, 'The Sharp Gifts Warehouse', '4085553659', '3086 Ingle Ln.', NULL, 'San Jose', 'CA', '94217'),
(452, 'Mini Auto Werke', '7675-3555', 'Kirchgasse 6', NULL, 'Graz', NULL, '8010'),
(455, 'Super Scale Inc.', '2035559545', '567 North Pendale Street', NULL, 'New Haven', 'CT', '97823'),
(456, 'Microscale Inc.', '2125551957', '5290 North Pendale Street', 'Suite 200', 'NYC', 'NY', '10022'),
(458, 'Corrida Auto Replicas, Ltd', '(91) 555 22 82', 'C/ Araquil, 67', NULL, 'Madrid', NULL, '28023'),
(459, 'Warburg Exchange', '0241-039123', 'Walserweg 21', NULL, 'Aachen', NULL, '52066'),
(462, 'FunGiftIdeas.com', '5085552555', '1785 First Street', NULL, 'New Bedford', 'MA', '50553'),
(465, 'Anton Designs, Ltd.', '+34 913 728555', 'c/ Gobelas, 19-1 Urb. La Florida', NULL, 'Madrid', NULL, '28023'),
(471, 'Australian Collectables, Ltd', '61-9-3844-6555', '7 Allen Street', NULL, 'Glen Waverly', 'Victoria', '3150'),
(473, 'Frau da Collezione', '+39 022515555', '20093 Cologno Monzese', 'Alessandro Volta 16', 'Milan', NULL, NULL),
(475, 'West Coast Collectables Co.', '3105553722', '3675 Furth Circle', NULL, 'Burbank', 'CA', '94019'),
(477, 'Mit Vergnügen & Co.', '0621-08555', 'Forsterstr. 57', NULL, 'Mannheim', NULL, '68306'),
(480, 'Kremlin Collectables, Co.', '+7 812 293 0521', '2 Pobedy Square', NULL, 'Saint Petersburg', NULL, '196143'),
(481, 'Raanan Stores, Inc', '+ 972 9 959 8555', '3 Hagalim Blv.', NULL, 'Herzlia', NULL, '47625'),
(484, 'Iberia Gift Imports, Corp.', '(95) 555 82 82', 'C/ Romero, 33', NULL, 'Sevilla', NULL, '41101'),
(486, 'Motor Mint Distributors Inc.', '2155559857', '11328 Douglas Av.', NULL, 'Philadelphia', 'PA', '71270'),
(487, 'Signal Collectibles Ltd.', '4155554312', '2793 Furth Circle', NULL, 'Brisbane', 'CA', '94217'),
(489, 'Double Decker Gift Stores, Ltd', '(171) 555-7555', '120 Hanover Sq.', NULL, 'London', NULL, '12333'),
(495, 'Diecast Collectables', '6175552555', '6251 Ingle Ln.', NULL, 'Boston', 'MA', '51003'),
(496, 'Kelly''s Gift Shop', '+64 9 5555500', 'Arenales 1938 3''A''', NULL, 'Auckland  ', NULL, NULL),
(2333, 'ณัฐกรณ์ วงศ์สายเชื้อ', NULL, NULL, NULL, NULL, NULL, NULL),
(2147483647, 'first1', 'last1', '1234567810', '1\\1', '2\\1', 'bangkok', '*2!A*'),
(1234567891012, 'first2', 'last2', '1234567811', '1\\2', '3\\2', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891013, 'first3', 'last3', '1234567812', '1\\3', '4\\3', 'bangkok', 'ตลิ่งชัน'),
(1234567891014, 'first4', 'last4', '1234567813', '1\\4', '2\\2', 'กรุงเทพ', 'คลองตัน'),
(1234567891015, 'first5', 'last5', '1234567814', '1\\5', '3\\3', 'bangkok', 'บางกะปิ'),
(1234567891016, 'first6', 'last6', '1234567815', '1\\6', '4\\4', 'กรุงเทพ', 'สามแสน'),
(1234567891017, 'first7', 'last7', '1234567816', '1\\7', '2\\3', 'bangkok', 'ปทุมวัน'),
(1234567891018, 'first8', 'last8', '1234567817', '1\\8', '3\\4', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891019, 'first9', 'last9', '1234567818', '1\\9', '4\\5', 'bangkok', 'คลองตัน'),
(1234567891020, 'first10', 'last10', '1234567819', '1\\10', '2\\4', 'กรุงเทพ', 'บางกะปิ'),
(1234567891021, 'first11', 'last11', '1234567820', '1\\11', '3\\5', 'bangkok', 'สามแสน'),
(1234567891022, 'first12', 'last12', '1234567821', '1\\12', '4\\6', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891023, 'first13', 'last13', '1234567822', '1\\13', '2\\5', 'bangkok', 'ตลิ่งชัน'),
(1234567891024, 'first14', 'last14', '1234567823', '1\\14', '3\\6', 'กรุงเทพ', 'คลองตัน'),
(1234567891025, 'first15', 'last15', '1234567824', '1\\15', '4\\7', 'bangkok', 'บางกะปิ'),
(1234567891026, 'first16', 'last16', '1234567825', '1\\16', '2\\6', 'กรุงเทพ', 'สามแสน'),
(1234567891027, 'first17', 'last17', '1234567826', '1\\17', '3\\7', 'bangkok', 'ปทุมวัน'),
(1234567891028, 'first18', 'last18', '1234567827', '1\\18', '4\\8', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891029, 'first19', 'last19', '1234567828', '1\\19', '2\\7', 'bangkok', 'คลองตัน'),
(1234567891030, 'first20', 'last20', '1234567829', '1\\20', '3\\8', 'กรุงเทพ', 'บางกะปิ'),
(1234567891031, 'first21', 'last21', '1234567830', '1\\21', '4\\9', 'bangkok', 'สามแสน'),
(1234567891032, 'first22', 'last22', '1234567831', '1\\22', '2\\8', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891033, 'first23', 'last23', '1234567832', '1\\23', '3\\9', 'bangkok', 'ตลิ่งชัน'),
(1234567891034, 'first24', 'last24', '1234567833', '1\\24', '4\\10', 'กรุงเทพ', 'คลองตัน'),
(1234567891035, 'first25', 'last25', '1234567834', '1\\25', '2\\9', 'bangkok', 'บางกะปิ'),
(1234567891036, 'first26', 'last26', '1234567835', '1\\26', '3\\10', 'กรุงเทพ', 'สามแสน'),
(1234567891037, 'first27', 'last27', '1234567836', '1\\27', '4\\11', 'bangkok', 'ปทุมวัน'),
(1234567891038, 'first28', 'last28', '1234567837', '1\\28', '2\\10', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891039, 'first29', 'last29', '1234567838', '1\\29', '3\\11', 'bangkok', 'คลองตัน'),
(1234567891040, 'first30', 'last30', '1234567839', '1\\30', '4\\12', 'กรุงเทพ', 'บางกะปิ'),
(1234567891041, 'first31', 'last31', '1234567840', '1\\31', '2\\11', 'bangkok', 'สามแสน'),
(1234567891042, 'first32', 'last32', '1234567841', '1\\32', '3\\12', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891043, 'first33', 'last33', '1234567842', '1\\33', '4\\13', 'bangkok', 'ตลิ่งชัน'),
(1234567891044, 'first34', 'last34', '1234567843', '1\\34', '2\\12', 'กรุงเทพ', 'คลองตัน'),
(1234567891045, 'first35', 'last35', '1234567844', '1\\35', '3\\13', 'bangkok', 'บางกะปิ'),
(1234567891046, 'first36', 'last36', '1234567845', '1\\36', '4\\14', 'กรุงเทพ', 'สามแสน'),
(1234567891047, 'first37', 'last37', '1234567846', '1\\37', '2\\13', 'bangkok', 'ปทุมวัน'),
(1234567891048, 'first38', 'last38', '1234567847', '1\\38', '3\\14', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891049, 'first39', 'last39', '1234567848', '1\\39', '4\\15', 'bangkok', 'คลองตัน'),
(1234567891050, 'first40', 'last40', '1234567849', '1\\40', '2\\14', 'กรุงเทพ', 'บางกะปิ'),
(1234567891051, 'first41', 'last41', '1234567850', '1\\41', '3\\15', 'bangkok', 'สามแสน'),
(1234567891052, 'first42', 'last42', '1234567851', '1\\42', '4\\16', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891053, 'first43', 'last43', '1234567852', '1\\43', '2\\15', 'bangkok', 'ตลิ่งชัน'),
(1234567891054, 'first44', 'last44', '1234567853', '1\\44', '3\\16', 'กรุงเทพ', 'คลองตัน'),
(1234567891055, 'first45', 'last45', '1234567854', '1\\45', '4\\17', 'bangkok', 'บางกะปิ'),
(1234567891056, 'first46', 'last46', '1234567855', '1\\46', '2\\16', 'กรุงเทพ', 'สามแสน'),
(1234567891057, 'first47', 'last47', '1234567856', '1\\47', '3\\17', 'bangkok', 'ปทุมวัน'),
(1234567891058, 'first48', 'last48', '1234567857', '1\\48', '4\\18', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891059, 'first49', 'last49', '1234567858', '1\\49', '2\\17', 'bangkok', 'คลองตัน'),
(1234567891060, 'first50', 'last50', '1234567859', '1\\50', '3\\18', 'กรุงเทพ', 'บางกะปิ'),
(1234567891061, 'first51', 'last51', '1234567860', '1\\51', '4\\19', 'bangkok', 'สามแสน'),
(1234567891062, 'first52', 'last52', '1234567861', '1\\52', '2\\18', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891063, 'first53', 'last53', '1234567862', '1\\53', '3\\19', 'bangkok', 'ตลิ่งชัน'),
(1234567891064, 'first54', 'last54', '1234567863', '1\\54', '4\\20', 'กรุงเทพ', 'คลองตัน'),
(1234567891065, 'first55', 'last55', '1234567864', '1\\55', '2\\19', 'bangkok', 'บางกะปิ'),
(1234567891066, 'first56', 'last56', '1234567865', '1\\56', '3\\20', 'กรุงเทพ', 'สามแสน'),
(1234567891067, 'first57', 'last57', '1234567866', '1\\57', '4\\21', 'bangkok', 'ปทุมวัน'),
(1234567891068, 'first58', 'last58', '1234567867', '1\\58', '2\\20', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891069, 'first59', 'last59', '1234567868', '1\\59', '3\\21', 'bangkok', 'คลองตัน'),
(1234567891070, 'first60', 'last60', '1234567869', '1\\60', '4\\22', 'กรุงเทพ', 'บางกะปิ'),
(1234567891071, 'first61', 'last61', '1234567870', '1\\61', '2\\21', 'bangkok', 'สามแสน'),
(1234567891072, 'first62', 'last62', '1234567871', '1\\62', '3\\22', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891073, 'first63', 'last63', '1234567872', '1\\63', '4\\23', 'bangkok', 'ตลิ่งชัน'),
(1234567891074, 'first64', 'last64', '1234567873', '1\\64', '2\\22', 'กรุงเทพ', 'คลองตัน'),
(1234567891075, 'first65', 'last65', '1234567874', '1\\65', '3\\23', 'bangkok', 'บางกะปิ'),
(1234567891076, 'first66', 'last66', '1234567875', '1\\66', '4\\24', 'กรุงเทพ', 'สามแสน'),
(1234567891077, 'first67', 'last67', '1234567876', '1\\67', '2\\23', 'bangkok', 'ปทุมวัน'),
(1234567891078, 'first68', 'last68', '1234567877', '1\\68', '3\\24', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891079, 'first69', 'last69', '1234567878', '1\\69', '4\\25', 'bangkok', 'คลองตัน'),
(1234567891080, 'first70', 'last70', '1234567879', '1\\70', '2\\24', 'กรุงเทพ', 'บางกะปิ'),
(1234567891081, 'first71', 'last71', '1234567880', '1\\71', '3\\25', 'bangkok', 'สามแสน'),
(1234567891082, 'first72', 'last72', '1234567881', '1\\72', '4\\26', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891083, 'first73', 'last73', '1234567882', '1\\73', '2\\25', 'bangkok', 'ตลิ่งชัน'),
(1234567891084, 'first74', 'last74', '1234567883', '1\\74', '3\\26', 'กรุงเทพ', 'คลองตัน'),
(1234567891085, 'first75', 'last75', '1234567884', '1\\75', '4\\27', 'bangkok', 'บางกะปิ'),
(1234567891086, 'first76', 'last76', '1234567885', '1\\76', '2\\26', 'กรุงเทพ', 'สามแสน'),
(1234567891087, 'first77', 'last77', '1234567886', '1\\77', '3\\27', 'bangkok', 'ปทุมวัน'),
(1234567891088, 'first78', 'last78', '1234567887', '1\\78', '4\\28', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891089, 'first79', 'last79', '1234567888', '1\\79', '2\\27', 'bangkok', 'คลองตัน'),
(1234567891090, 'first80', 'last80', '1234567889', '1\\80', '3\\28', 'กรุงเทพ', 'บางกะปิ'),
(1234567891091, 'first81', 'last81', '1234567890', '1\\81', '4\\29', 'bangkok', 'สามแสน'),
(1234567891092, 'first82', 'last82', '1234567891', '1\\82', '2\\28', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891093, 'first83', 'last83', '1234567892', '1\\83', '3\\29', 'bangkok', 'ตลิ่งชัน'),
(1234567891094, 'first84', 'last84', '1234567893', '1\\84', '4\\30', 'กรุงเทพ', 'คลองตัน'),
(1234567891095, 'first85', 'last85', '1234567894', '1\\85', '2\\29', 'bangkok', 'บางกะปิ'),
(1234567891096, 'first86', 'last86', '1234567895', '1\\86', '3\\30', 'กรุงเทพ', 'สามแสน'),
(1234567891097, 'first87', 'last87', '1234567896', '1\\87', '4\\31', 'bangkok', 'ปทุมวัน'),
(1234567891098, 'first88', 'last88', '1234567897', '1\\88', '2\\30', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891099, 'first89', 'last89', '1234567898', '1\\89', '3\\31', 'bangkok', 'คลองตัน'),
(1234567891100, 'first90', 'last90', '1234567899', '1\\90', '4\\32', 'กรุงเทพ', 'บางกะปิ'),
(1234567891101, 'first91', 'last91', '1234567900', '1\\91', '2\\31', 'bangkok', 'สามแสน'),
(1234567891102, 'first92', 'last92', '1234567901', '1\\92', '3\\32', 'กรุงเทพ', 'ปทุมวัน'),
(1234567891103, 'first93', 'last93', '1234567902', '1\\93', '4\\33', 'bangkok', 'ตลิ่งชัน'),
(1234567891104, 'first94', 'last94', '1234567903', '1\\94', '2\\32', 'กรุงเทพ', 'คลองตัน'),
(1234567891105, 'first95', 'last95', '1234567904', '1\\95', '3\\33', 'bangkok', 'บางกะปิ'),
(1234567891106, 'first96', 'last96', '1234567905', '1\\96', '4\\34', 'กรุงเทพ', 'สามแสน'),
(1234567891107, 'first97', 'last97', '1234567906', '1\\97', '2\\33', 'bangkok', 'ปทุมวัน'),
(1234567891108, 'first98', 'last98', '1234567907', '1\\98', '3\\34', 'กรุงเทพ', 'ตลิ่งชัน'),
(1234567891109, 'first99', 'last99', '1234567908', '1\\99', '4\\35', 'bangkok', 'คลองตัน'),
(1234567891110, 'first100', 'last100', '1234567909', '1\\100', '2\\34', 'กรุงเทพ', 'บางกะปิ');

-- --------------------------------------------------------

--
-- Table structure for table `denied_access`
--

CREATE TABLE IF NOT EXISTS `denied_access` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ips_on_hold`
--

CREATE TABLE IF NOT EXISTS `ips_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lands`
--

CREATE TABLE IF NOT EXISTS `lands` (
  `land_id` int(10) NOT NULL AUTO_INCREMENT,
  `address1` varchar(128) DEFAULT NULL,
  `address2` varchar(128) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `postal_code` varchar(15) DEFAULT NULL,
  `rai` int(11) NOT NULL,
  `ngan` int(11) NOT NULL,
  `meters` int(11) NOT NULL,
  `customer_id` bigint(13) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `identification_id` varchar(45) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`land_id`),
  UNIQUE KEY `identification_id_UNIQUE` (`identification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `lands`
--

INSERT INTO `lands` (`land_id`, `address1`, `address2`, `state`, `postal_code`, `rai`, `ngan`, `meters`, `customer_id`, `created_at`, `updated_at`, `identification_id`, `city`, `image_path`) VALUES
(1, '12234', NULL, NULL, NULL, 0, 0, 0, 406, NULL, NULL, 'dsvv', NULL, 'a08c9-042a8037-980x653.jpg'),
(2, '3\\2', '1\\2', 'ฟหกดดเส', '25164', 1188, 4, 45, 1234567891012, NULL, NULL, 'DIfirst2', 'N/A', 'N/A'),
(3, '4\\3', '1\\3', 'bangkok', '25164', 2, 3, 85, 1234567891013, NULL, NULL, 'DIfirst3', 'N/A', 'N/A'),
(4, '2\\2', '1\\4', 'กรุงเทพ', '25164', 3, 4, 168, 1234567891014, NULL, NULL, 'DIfirst4', 'N/A', 'N/A'),
(5, '3\\3', '1\\5', 'bangkok', '25164', 4, 2, 43, 1234567891015, NULL, NULL, 'DIfirst5', 'N/A', 'N/A'),
(6, '4\\4', '1\\6', 'กรุงเทพ', '25164', 85, 1, 69, 1234567891016, NULL, NULL, 'DIfirst6', 'N/A', 'N/A'),
(7, '2\\3', '1\\7', 'bangkok', '25164', 168, 4, 70, 1234567891017, NULL, NULL, 'DIfirst7', 'N/A', 'N/A'),
(8, '3\\4', '1\\8', 'กรุงเทพ', '25164', 43, 1, 10, 1234567891018, NULL, NULL, 'DIfirst8', 'N/A', 'N/A'),
(9, '4\\5', '1\\9', 'bangkok', '25164', 69, 3, 3, 1234567891019, NULL, NULL, 'DIfirst9', 'N/A', 'N/A'),
(10, '2\\4', '1\\10', 'กรุงเทพ', '25164', 70, 4, 0, 1234567891020, NULL, NULL, 'DIfirst10', 'N/A', 'N/A'),
(11, '3\\5', '1\\11', 'bangkok', '25164', 10, 4, 13, 1234567891021, NULL, NULL, 'DIfirst11', 'N/A', 'N/A'),
(12, '4\\6', '1\\12', 'กรุงเทพ', '25164', 9, 4, 75, 1234567891022, NULL, NULL, 'DIfirst12', 'N/A', 'N/A'),
(13, '2\\5', '1\\13', 'bangkok', '25164', 1, 4, 350, 1234567891023, NULL, NULL, 'DIfirst13', 'N/A', 'N/A'),
(14, '3\\6', '1\\14', 'กรุงเทพ', '25164', 2, 4, 333, 1234567891024, NULL, NULL, 'DIfirst14', 'N/A', 'N/A'),
(15, '4\\7', '1\\15', 'bangkok', '25164', 3, 4, 46, 1234567891025, NULL, NULL, 'DIfirst15', 'N/A', 'N/A'),
(16, '2\\6', '1\\16', 'กรุงเทพ', '25164', 4, 5, 126, 1234567891026, NULL, NULL, 'DIfirst16', 'N/A', 'N/A'),
(17, '3\\7', '1\\17', 'bangkok', '25164', 5, 5, 354, 1234567891027, NULL, NULL, 'DIfirst17', 'N/A', 'N/A'),
(18, '4\\8', '1\\18', 'กรุงเทพ', '25164', 6, 5, 362, 1234567891028, NULL, NULL, 'DIfirst18', 'N/A', 'N/A'),
(19, '2\\7', '1\\19', 'bangkok', '25164', 7, 5, 362, 1234567891029, NULL, NULL, 'DIfirst19', 'N/A', 'N/A'),
(20, '3\\8', '1\\20', 'กรุงเทพ', '25164', 8, 5, 396, 1234567891030, NULL, NULL, 'DIfirst20', 'N/A', 'N/A'),
(21, '4\\9', '1\\21', 'bangkok', '25164', 9, 6, 43, 1234567891031, NULL, NULL, 'DIfirst21', 'N/A', 'N/A'),
(22, '2\\8', '1\\22', 'กรุงเทพ', '25164', 10, 6, 46, 1234567891032, NULL, NULL, 'DIfirst22', 'N/A', 'N/A'),
(23, '3\\9', '1\\23', 'bangkok', '25164', 11, 6, 49, 1234567891033, NULL, NULL, 'DIfirst23', 'N/A', 'N/A'),
(24, '4\\10', '1\\24', 'กรุงเทพ', '25164', 12, 6, 53, 1234567891034, NULL, NULL, 'DIfirst24', 'N/A', 'N/A'),
(25, '2\\9', '1\\25', 'bangkok', '25164', 13, 6, 13, 1234567891035, NULL, NULL, 'DIfirst25', 'N/A', 'N/A'),
(26, '3\\10', '1\\26', 'กรุงเทพ', '25164', 14, 7, 75, 1234567891036, NULL, NULL, 'DIfirst26', 'N/A', 'N/A'),
(27, '4\\11', '1\\27', 'bangkok', '25164', 15, 7, 350, 1234567891037, NULL, NULL, 'DIfirst27', 'N/A', 'N/A'),
(28, '2\\10', '1\\28', 'กรุงเทพ', '25164', 16, 7, 333, 1234567891038, NULL, NULL, 'DIfirst28', 'N/A', 'N/A'),
(29, '3\\11', '1\\29', 'bangkok', '25164', 17, 7, 46, 1234567891039, NULL, NULL, 'DIfirst29', 'N/A', 'N/A'),
(30, '4\\12', '1\\30', 'กรุงเทพ', '25164', 18, 7, 126, 1234567891040, NULL, NULL, 'DIfirst30', 'N/A', 'N/A'),
(31, '2\\11', '1\\31', 'bangkok', '25164', 19, 8, 354, 1234567891041, NULL, NULL, 'DIfirst31', 'N/A', 'N/A'),
(32, '3\\12', '1\\32', 'กรุงเทพ', '25164', 20, 8, 362, 1234567891042, NULL, NULL, 'DIfirst32', 'N/A', 'N/A'),
(33, '4\\13', '1\\33', 'bangkok', '25164', 21, 8, 362, 1234567891043, NULL, NULL, 'DIfirst33', 'N/A', 'N/A'),
(34, '2\\12', '1\\34', 'กรุงเทพ', '25164', 22, 8, 396, 1234567891044, NULL, NULL, 'DIfirst34', 'N/A', 'N/A'),
(35, '3\\13', '1\\35', 'bangkok', '25164', 23, 8, 43, 1234567891045, NULL, NULL, 'DIfirst35', 'N/A', 'N/A'),
(36, '4\\14', '1\\36', 'กรุงเทพ', '25164', 24, 9, 46, 1234567891046, NULL, NULL, 'DIfirst36', 'N/A', 'N/A'),
(37, '2\\13', '1\\37', 'bangkok', '25164', 25, 9, 49, 1234567891047, NULL, NULL, 'DIfirst37', 'N/A', 'N/A'),
(38, '3\\14', '1\\38', 'กรุงเทพ', '25164', 26, 9, 53, 1234567891048, NULL, NULL, 'DIfirst38', 'N/A', 'N/A'),
(39, '4\\15', '1\\39', 'bangkok', '25164', 27, 9, 46, 1234567891049, NULL, NULL, 'DIfirst39', 'N/A', 'N/A'),
(40, '2\\14', '1\\40', 'กรุงเทพ', '25164', 28, 9, 49, 1234567891050, NULL, NULL, 'DIfirst40', 'N/A', 'N/A'),
(41, '3\\15', '1\\41', 'bangkok', '25164', 29, 10, 53, 1234567891051, NULL, NULL, 'DIfirst41', 'N/A', 'N/A'),
(42, '4\\16', '1\\42', 'กรุงเทพ', '25164', 30, 10, 13, 1234567891052, NULL, NULL, 'DIfirst42', 'N/A', 'N/A'),
(43, '2\\15', '1\\43', 'bangkok', '25164', 31, 10, 75, 1234567891053, NULL, NULL, 'DIfirst43', 'N/A', 'N/A'),
(44, '3\\16', '1\\44', 'กรุงเทพ', '25164', 32, 10, 350, 1234567891054, NULL, NULL, 'DIfirst44', 'N/A', 'N/A'),
(45, '4\\17', '1\\45', 'bangkok', '25164', 33, 10, 333, 1234567891055, NULL, NULL, 'DIfirst45', 'N/A', 'N/A'),
(46, '2\\16', '1\\46', 'กรุงเทพ', '25164', 34, 11, 46, 1234567891056, NULL, NULL, 'DIfirst46', 'N/A', 'N/A'),
(47, '3\\17', '1\\47', 'bangkok', '25164', 35, 11, 126, 1234567891057, NULL, NULL, 'DIfirst47', 'N/A', 'N/A'),
(48, '4\\18', '1\\48', 'กรุงเทพ', '25164', 36, 11, 354, 1234567891058, NULL, NULL, 'DIfirst48', 'N/A', 'N/A'),
(49, '2\\17', '1\\49', 'bangkok', '25164', 37, 11, 362, 1234567891059, NULL, NULL, 'DIfirst49', 'N/A', 'N/A'),
(50, '3\\18', '1\\50', 'กรุงเทพ', '25164', 38, 11, 75, 1234567891060, NULL, NULL, 'DIfirst50', 'N/A', 'N/A'),
(51, '4\\19', '1\\51', 'bangkok', '25164', 39, 12, 350, 1234567891061, NULL, NULL, 'DIfirst51', 'N/A', 'N/A'),
(52, '2\\18', '1\\52', 'กรุงเทพ', '25164', 40, 12, 333, 1234567891062, NULL, NULL, 'DIfirst52', 'N/A', 'N/A'),
(53, '3\\19', '1\\53', 'bangkok', '25164', 41, 12, 46, 1234567891063, NULL, NULL, 'DIfirst53', 'N/A', 'N/A'),
(54, '4\\20', '1\\54', 'กรุงเทพ', '25164', 42, 12, 126, 1234567891064, NULL, NULL, 'DIfirst54', 'N/A', 'N/A'),
(55, '2\\19', '1\\55', 'bangkok', '25164', 43, 12, 354, 1234567891065, NULL, NULL, 'DIfirst55', 'N/A', 'N/A'),
(56, '3\\20', '1\\56', 'กรุงเทพ', '25164', 44, 13, 362, 1234567891066, NULL, NULL, 'DIfirst56', 'N/A', 'N/A'),
(57, '4\\21', '1\\57', 'bangkok', '25164', 45, 13, 362, 1234567891067, NULL, NULL, 'DIfirst57', 'N/A', 'N/A'),
(58, '2\\20', '1\\58', 'กรุงเทพ', '25164', 46, 13, 396, 1234567891068, NULL, NULL, 'DIfirst58', 'N/A', 'N/A'),
(59, '3\\21', '1\\59', 'bangkok', '25164', 47, 13, 43, 1234567891069, NULL, NULL, 'DIfirst59', 'N/A', 'N/A'),
(60, '4\\22', '1\\60', 'กรุงเทพ', '25164', 48, 13, 46, 1234567891070, NULL, NULL, 'DIfirst60', 'N/A', 'N/A'),
(61, '2\\21', '1\\61', 'bangkok', '25164', 49, 14, 49, 1234567891071, NULL, NULL, 'DIfirst61', 'N/A', 'N/A'),
(62, '3\\22', '1\\62', 'กรุงเทพ', '25164', 50, 14, 13, 1234567891072, NULL, NULL, 'DIfirst62', 'N/A', 'N/A'),
(63, '4\\23', '1\\63', 'bangkok', '25164', 51, 14, 75, 1234567891073, NULL, NULL, 'DIfirst63', 'N/A', 'N/A'),
(64, '2\\22', '1\\64', 'กรุงเทพ', '25164', 52, 14, 350, 1234567891074, NULL, NULL, 'DIfirst64', 'N/A', 'N/A'),
(65, '3\\23', '1\\65', 'bangkok', '25164', 53, 14, 333, 1234567891075, NULL, NULL, 'DIfirst65', 'N/A', 'N/A'),
(66, '4\\24', '1\\66', 'กรุงเทพ', '25164', 54, 15, 46, 1234567891076, NULL, NULL, 'DIfirst66', 'N/A', 'N/A'),
(67, '2\\23', '1\\67', 'bangkok', '25164', 55, 15, 126, 1234567891077, NULL, NULL, 'DIfirst67', 'N/A', 'N/A'),
(68, '3\\24', '1\\68', 'กรุงเทพ', '25164', 56, 15, 354, 1234567891078, NULL, NULL, 'DIfirst68', 'N/A', 'N/A'),
(69, '4\\25', '1\\69', 'bangkok', '25164', 57, 15, 362, 1234567891079, NULL, NULL, 'DIfirst69', 'N/A', 'N/A'),
(70, '2\\24', '1\\70', 'กรุงเทพ', '25164', 58, 15, 75, 1234567891080, NULL, NULL, 'DIfirst70', 'N/A', 'N/A'),
(71, '3\\25', '1\\71', 'bangkok', '25164', 59, 16, 350, 1234567891081, NULL, NULL, 'DIfirst71', 'N/A', 'N/A'),
(72, '4\\26', '1\\72', 'กรุงเทพ', '25164', 60, 16, 333, 1234567891082, NULL, NULL, 'DIfirst72', 'N/A', 'N/A'),
(73, '2\\25', '1\\73', 'bangkok', '25164', 61, 16, 46, 1234567891083, NULL, NULL, 'DIfirst73', 'N/A', 'N/A'),
(74, '3\\26', '1\\74', 'กรุงเทพ', '25164', 62, 16, 362, 1234567891084, NULL, NULL, 'DIfirst74', 'N/A', 'N/A'),
(75, '4\\27', '1\\75', 'bangkok', '25164', 63, 16, 362, 1234567891085, NULL, NULL, 'DIfirst75', 'N/A', 'N/A'),
(76, '2\\26', '1\\76', 'กรุงเทพ', '25164', 64, 17, 396, 1234567891086, NULL, NULL, 'DIfirst76', 'N/A', 'N/A'),
(77, '3\\27', '1\\77', 'bangkok', '25164', 65, 17, 43, 1234567891087, NULL, NULL, 'DIfirst77', 'N/A', 'N/A'),
(78, '4\\28', '1\\78', 'กรุงเทพ', '25164', 66, 17, 46, 1234567891088, NULL, NULL, 'DIfirst78', 'N/A', 'N/A'),
(79, '2\\27', '1\\79', 'bangkok', '25164', 67, 17, 49, 1234567891089, NULL, NULL, 'DIfirst79', 'N/A', 'N/A'),
(80, '3\\28', '1\\80', 'กรุงเทพ', '25164', 68, 17, 13, 1234567891090, NULL, NULL, 'DIfirst80', 'N/A', 'N/A'),
(81, '4\\29', '1\\81', 'bangkok', '25164', 69, 18, 75, 1234567891091, NULL, NULL, 'DIfirst81', 'N/A', 'N/A'),
(82, '2\\28', '1\\82', 'กรุงเทพ', '25164', 70, 18, 350, 1234567891092, NULL, NULL, 'DIfirst82', 'N/A', 'N/A'),
(83, '3\\29', '1\\83', 'bangkok', '25164', 71, 18, 333, 1234567891093, NULL, NULL, 'DIfirst83', 'N/A', 'N/A'),
(84, '4\\30', '1\\84', 'กรุงเทพ', '25164', 72, 18, 46, 1234567891094, NULL, NULL, 'DIfirst84', 'N/A', 'N/A'),
(85, '2\\29', '1\\85', 'bangkok', '25164', 73, 18, 126, 1234567891095, NULL, NULL, 'DIfirst85', 'N/A', 'N/A'),
(86, '3\\30', '1\\86', 'กรุงเทพ', '25164', 74, 19, 354, 1234567891096, NULL, NULL, 'DIfirst86', 'N/A', 'N/A'),
(87, '4\\31', '1\\87', 'bangkok', '25164', 75, 19, 362, 1234567891097, NULL, NULL, 'DIfirst87', 'N/A', 'N/A'),
(88, '2\\30', '1\\88', 'กรุงเทพ', '25164', 76, 19, 75, 1234567891098, NULL, NULL, 'DIfirst88', 'N/A', 'N/A'),
(89, '3\\31', '1\\89', 'bangkok', '25164', 77, 19, 350, 1234567891099, NULL, NULL, 'DIfirst89', 'N/A', 'N/A'),
(90, '4\\32', '1\\90', 'กรุงเทพ', '25164', 78, 19, 333, 1234567891100, NULL, NULL, 'DIfirst90', 'N/A', 'N/A'),
(91, '2\\31', '1\\91', 'bangkok', '25164', 79, 20, 46, 1234567891101, NULL, NULL, 'DIfirst91', 'N/A', 'N/A'),
(92, '3\\32', '1\\92', 'กรุงเทพ', '25164', 80, 20, 362, 1234567891102, NULL, NULL, 'DIfirst92', 'N/A', 'N/A'),
(93, '4\\33', '1\\93', 'bangkok', '25164', 81, 20, 396, 1234567891103, NULL, NULL, 'DIfirst93', 'N/A', 'N/A'),
(94, '2\\32', '1\\94', 'กรุงเทพ', '25164', 82, 20, 43, 1234567891104, NULL, NULL, 'DIfirst94', 'N/A', 'N/A'),
(95, '3\\33', '1\\95', 'bangkok', '25164', 83, 20, 46, 1234567891105, NULL, NULL, 'DIfirst95', 'N/A', 'N/A'),
(96, '4\\34', '1\\96', 'กรุงเทพ', '25164', 84, 21, 49, 1234567891106, NULL, NULL, 'DIfirst96', 'N/A', 'N/A'),
(97, '2\\33', '1\\97', 'bangkok', '25164', 85, 21, 13, 1234567891107, NULL, NULL, 'DIfirst97', 'N/A', 'N/A'),
(98, '3\\34', '1\\98', 'กรุงเทพ', '25164', 86, 21, 75, 1234567891108, NULL, NULL, 'DIfirst98', 'N/A', 'N/A'),
(99, '4\\35', '1\\99', 'bangkok', '25164', 87, 21, 350, 1234567891109, NULL, NULL, 'DIfirst99', 'N/A', 'N/A'),
(100, '2\\34', '1\\100', 'กรุงเทพ', '25164', 1188, 21, 333, 1234567891110, NULL, NULL, 'DIfirst100', 'N/A', 'N/A'),
(101, 'N/A', 'N/A', 'N/A', 'N/A', 0, 0, 17906, 0, NULL, NULL, 'N/A', 'N/A', 'N/A'),
(103, '3\\2', '1\\2', 'กุงเทพ', '25164', 1, 4, 45, 1234567891012, NULL, NULL, 'DIfirst101', 'N/A', 'N/A'),
(104, '4\\3', '1\\3', 'bangkok', '25164', 2, 3, 85, 1234567891013, NULL, NULL, 'DIfirst102', 'N/A', 'N/A'),
(105, '2\\2', '1\\4', 'กุงเทพ', '25164', 3, 4, 168, 1234567891014, NULL, NULL, 'DIfirst103', 'N/A', 'N/A'),
(106, '3\\3', '1\\5', 'bangkok', '25164', 4, 2, 43, 1234567891015, NULL, NULL, 'DIfirst104', 'N/A', 'N/A'),
(107, '4\\4', '1\\6', 'กุงเทพ', '25164', 85, 1, 69, 1234567891016, NULL, NULL, 'DIfirst105', 'N/A', 'N/A'),
(108, '2\\3', '1\\7', 'bangkok', '25164', 168, 4, 70, 1234567891017, NULL, NULL, 'DIfirst106', 'N/A', 'N/A'),
(109, '3\\4', '1\\8', 'กุงเทพ', '25164', 43, 1, 10, 1234567891018, NULL, NULL, 'DIfirst107', 'N/A', 'N/A'),
(110, '4\\5', '1\\9', 'bangkok', '25164', 69, 3, 3, 1234567891019, NULL, NULL, 'DIfirst108', 'N/A', 'N/A'),
(111, '2\\4', '1\\10', 'กุงเทพ', '25164', 70, 4, 0, 1234567891020, NULL, NULL, 'DIfirst109', 'N/A', 'N/A'),
(112, '3\\5', '1\\11', 'bangkok', '25164', 10, 4, 13, 1234567891021, NULL, NULL, 'DIfirst110', 'N/A', 'N/A'),
(113, '4\\6', '1\\12', 'กุงเทพ', '25164', 9, 4, 75, 1234567891022, NULL, NULL, 'DIfirst111', 'N/A', 'N/A'),
(114, '2\\5', '1\\13', 'bangkok', '25164', 1, 4, 350, 1234567891023, NULL, NULL, 'DIfirst112', 'N/A', 'N/A'),
(115, '3\\6', '1\\14', 'กุงเทพ', '25164', 2, 4, 333, 1234567891024, NULL, NULL, 'DIfirst113', 'N/A', 'N/A'),
(116, '4\\7', '1\\15', 'bangkok', '25164', 3, 4, 46, 1234567891025, NULL, NULL, 'DIfirst114', 'N/A', 'N/A'),
(117, '2\\6', '1\\16', 'กุงเทพ', '25164', 4, 5, 126, 1234567891026, NULL, NULL, 'DIfirst115', 'N/A', 'N/A'),
(118, '3\\7', '1\\17', 'bangkok', '25164', 5, 5, 354, 1234567891027, NULL, NULL, 'DIfirst116', 'N/A', 'N/A'),
(119, '4\\8', '1\\18', 'กุงเทพ', '25164', 6, 5, 362, 1234567891028, NULL, NULL, 'DIfirst117', 'N/A', 'N/A'),
(120, '2\\7', '1\\19', 'bangkok', '25164', 7, 5, 362, 1234567891029, NULL, NULL, 'DIfirst118', 'N/A', 'N/A'),
(121, '3\\8', '1\\20', 'กุงเทพ', '25164', 8, 5, 396, 1234567891030, NULL, NULL, 'DIfirst119', 'N/A', 'N/A'),
(122, '4\\9', '1\\21', 'bangkok', '25164', 9, 6, 43, 1234567891031, NULL, NULL, 'DIfirst120', 'N/A', 'N/A'),
(123, '2\\8', '1\\22', 'กุงเทพ', '25164', 10, 6, 46, 1234567891032, NULL, NULL, 'DIfirst121', 'N/A', 'N/A'),
(124, '3\\9', '1\\23', 'bangkok', '25164', 11, 6, 49, 1234567891033, NULL, NULL, 'DIfirst122', 'N/A', 'N/A'),
(125, '4\\10', '1\\24', 'กุงเทพ', '25164', 12, 6, 53, 1234567891034, NULL, NULL, 'DIfirst123', 'N/A', 'N/A'),
(126, '2\\9', '1\\25', 'bangkok', '25164', 13, 6, 13, 1234567891035, NULL, NULL, 'DIfirst124', 'N/A', 'N/A'),
(127, '3\\10', '1\\26', 'กุงเทพ', '25164', 14, 7, 75, 1234567891036, NULL, NULL, 'DIfirst125', 'N/A', 'N/A'),
(128, '4\\11', '1\\27', 'bangkok', '25164', 15, 7, 350, 1234567891037, NULL, NULL, 'DIfirst126', 'N/A', 'N/A'),
(129, '2\\10', '1\\28', 'กุงเทพ', '25164', 16, 7, 333, 1234567891038, NULL, NULL, 'DIfirst127', 'N/A', 'N/A'),
(130, '3\\11', '1\\29', 'bangkok', '25164', 17, 7, 46, 1234567891039, NULL, NULL, 'DIfirst128', 'N/A', 'N/A'),
(131, '4\\12', '1\\30', 'กุงเทพ', '25164', 18, 7, 126, 1234567891040, NULL, NULL, 'DIfirst129', 'N/A', 'N/A'),
(132, '2\\11', '1\\31', 'bangkok', '25164', 19, 8, 354, 1234567891041, NULL, NULL, 'DIfirst130', 'N/A', 'N/A'),
(133, '3\\12', '1\\32', 'กุงเทพ', '25164', 20, 8, 362, 1234567891042, NULL, NULL, 'DIfirst131', 'N/A', 'N/A'),
(134, '4\\13', '1\\33', 'bangkok', '25164', 21, 8, 362, 1234567891043, NULL, NULL, 'DIfirst132', 'N/A', 'N/A'),
(135, '2\\12', '1\\34', 'กุงเทพ', '25164', 22, 8, 396, 1234567891044, NULL, NULL, 'DIfirst133', 'N/A', 'N/A'),
(136, '3\\13', '1\\35', 'bangkok', '25164', 23, 8, 43, 1234567891045, NULL, NULL, 'DIfirst134', 'N/A', 'N/A'),
(137, '4\\14', '1\\36', 'กุงเทพ', '25164', 24, 9, 46, 1234567891046, NULL, NULL, 'DIfirst135', 'N/A', 'N/A'),
(138, '2\\13', '1\\37', 'bangkok', '25164', 25, 9, 49, 1234567891047, NULL, NULL, 'DIfirst136', 'N/A', 'N/A'),
(139, '3\\14', '1\\38', 'กุงเทพ', '25164', 26, 9, 53, 1234567891048, NULL, NULL, 'DIfirst137', 'N/A', 'N/A'),
(140, '4\\15', '1\\39', 'bangkok', '25164', 27, 9, 46, 1234567891049, NULL, NULL, 'DIfirst138', 'N/A', 'N/A'),
(141, '2\\14', '1\\40', 'กุงเทพ', '25164', 28, 9, 49, 1234567891050, NULL, NULL, 'DIfirst139', 'N/A', 'N/A'),
(142, '3\\15', '1\\41', 'bangkok', '25164', 29, 10, 53, 1234567891051, NULL, NULL, 'DIfirst140', 'N/A', 'N/A'),
(143, '4\\16', '1\\42', 'กุงเทพ', '25164', 30, 10, 13, 1234567891052, NULL, NULL, 'DIfirst141', 'N/A', 'N/A'),
(144, '2\\15', '1\\43', 'bangkok', '25164', 31, 10, 75, 1234567891053, NULL, NULL, 'DIfirst142', 'N/A', 'N/A'),
(145, '3\\16', '1\\44', 'กุงเทพ', '25164', 32, 10, 350, 1234567891054, NULL, NULL, 'DIfirst143', 'N/A', 'N/A'),
(146, '4\\17', '1\\45', 'bangkok', '25164', 33, 10, 333, 1234567891055, NULL, NULL, 'DIfirst144', 'N/A', 'N/A'),
(147, '2\\16', '1\\46', 'กุงเทพ', '25164', 34, 11, 46, 1234567891056, NULL, NULL, 'DIfirst145', 'N/A', 'N/A'),
(148, '3\\17', '1\\47', 'bangkok', '25164', 35, 11, 126, 1234567891057, NULL, NULL, 'DIfirst146', 'N/A', 'N/A'),
(149, '4\\18', '1\\48', 'กุงเทพ', '25164', 36, 11, 354, 1234567891058, NULL, NULL, 'DIfirst147', 'N/A', 'N/A'),
(150, '2\\17', '1\\49', 'bangkok', '25164', 37, 11, 362, 1234567891059, NULL, NULL, 'DIfirst148', 'N/A', 'N/A'),
(151, '3\\18', '1\\50', 'กุงเทพ', '25164', 38, 11, 75, 1234567891060, NULL, NULL, 'DIfirst149', 'N/A', 'N/A'),
(152, '4\\19', '1\\51', 'bangkok', '25164', 39, 12, 350, 1234567891061, NULL, NULL, 'DIfirst150', 'N/A', 'N/A'),
(153, '2\\18', '1\\52', 'กุงเทพ', '25164', 40, 12, 333, 1234567891062, NULL, NULL, 'DIfirst151', 'N/A', 'N/A'),
(154, '3\\19', '1\\53', 'bangkok', '25164', 41, 12, 46, 1234567891063, NULL, NULL, 'DIfirst152', 'N/A', 'N/A'),
(155, '4\\20', '1\\54', 'กุงเทพ', '25164', 42, 12, 126, 1234567891064, NULL, NULL, 'DIfirst153', 'N/A', 'N/A'),
(156, '2\\19', '1\\55', 'bangkok', '25164', 43, 12, 354, 1234567891065, NULL, NULL, 'DIfirst154', 'N/A', 'N/A'),
(157, '3\\20', '1\\56', 'กุงเทพ', '25164', 44, 13, 362, 1234567891066, NULL, NULL, 'DIfirst155', 'N/A', 'N/A'),
(158, '4\\21', '1\\57', 'bangkok', '25164', 45, 13, 362, 1234567891067, NULL, NULL, 'DIfirst156', 'N/A', 'N/A'),
(159, '2\\20', '1\\58', 'กุงเทพ', '25164', 46, 13, 396, 1234567891068, NULL, NULL, 'DIfirst157', 'N/A', 'N/A'),
(160, '3\\21', '1\\59', 'bangkok', '25164', 47, 13, 43, 1234567891069, NULL, NULL, 'DIfirst158', 'N/A', 'N/A'),
(161, '4\\22', '1\\60', 'กุงเทพ', '25164', 48, 13, 46, 1234567891070, NULL, NULL, 'DIfirst159', 'N/A', 'N/A'),
(162, '2\\21', '1\\61', 'bangkok', '25164', 49, 14, 49, 1234567891071, NULL, NULL, 'DIfirst160', 'N/A', 'N/A'),
(163, '3\\22', '1\\62', 'กุงเทพ', '25164', 50, 14, 13, 1234567891072, NULL, NULL, 'DIfirst161', 'N/A', 'N/A'),
(164, '4\\23', '1\\63', 'bangkok', '25164', 51, 14, 75, 1234567891073, NULL, NULL, 'DIfirst162', 'N/A', 'N/A'),
(165, '2\\22', '1\\64', 'กุงเทพ', '25164', 52, 14, 350, 1234567891074, NULL, NULL, 'DIfirst163', 'N/A', 'N/A'),
(166, '3\\23', '1\\65', 'bangkok', '25164', 53, 14, 333, 1234567891075, NULL, NULL, 'DIfirst164', 'N/A', 'N/A'),
(167, '4\\24', '1\\66', 'กุงเทพ', '25164', 54, 15, 46, 1234567891076, NULL, NULL, 'DIfirst165', 'N/A', 'N/A'),
(168, '2\\23', '1\\67', 'bangkok', '25164', 55, 15, 126, 1234567891077, NULL, NULL, 'DIfirst166', 'N/A', 'N/A'),
(169, '3\\24', '1\\68', 'กุงเทพ', '25164', 56, 15, 354, 1234567891078, NULL, NULL, 'DIfirst167', 'N/A', 'N/A'),
(170, '4\\25', '1\\69', 'bangkok', '25164', 57, 15, 362, 1234567891079, NULL, NULL, 'DIfirst168', 'N/A', 'N/A'),
(171, '2\\24', '1\\70', 'กุงเทพ', '25164', 58, 15, 75, 1234567891080, NULL, NULL, 'DIfirst169', 'N/A', 'N/A'),
(172, '3\\25', '1\\71', 'bangkok', '25164', 59, 16, 350, 1234567891081, NULL, NULL, 'DIfirst170', 'N/A', 'N/A'),
(173, '4\\26', '1\\72', 'กุงเทพ', '25164', 60, 16, 333, 1234567891082, NULL, NULL, 'DIfirst171', 'N/A', 'N/A'),
(174, '2\\25', '1\\73', 'bangkok', '25164', 61, 16, 46, 1234567891083, NULL, NULL, 'DIfirst172', 'N/A', 'N/A'),
(175, '3\\26', '1\\74', 'กุงเทพ', '25164', 62, 16, 362, 1234567891084, NULL, NULL, 'DIfirst173', 'N/A', 'N/A'),
(176, '4\\27', '1\\75', 'bangkok', '25164', 63, 16, 362, 1234567891085, NULL, NULL, 'DIfirst174', 'N/A', 'N/A'),
(177, '2\\26', '1\\76', 'กุงเทพ', '25164', 64, 17, 396, 1234567891086, NULL, NULL, 'DIfirst175', 'N/A', 'N/A'),
(178, '3\\27', '1\\77', 'bangkok', '25164', 65, 17, 43, 1234567891087, NULL, NULL, 'DIfirst176', 'N/A', 'N/A'),
(179, '4\\28', '1\\78', 'กุงเทพ', '25164', 66, 17, 46, 1234567891088, NULL, NULL, 'DIfirst177', 'N/A', 'N/A'),
(180, '2\\27', '1\\79', 'bangkok', '25164', 67, 17, 49, 1234567891089, NULL, NULL, 'DIfirst178', 'N/A', 'N/A'),
(181, '3\\28', '1\\80', 'กุงเทพ', '25164', 68, 17, 13, 1234567891090, NULL, NULL, 'DIfirst179', 'N/A', 'N/A'),
(182, '4\\29', '1\\81', 'bangkok', '25164', 69, 18, 75, 1234567891091, NULL, NULL, 'DIfirst180', 'N/A', 'N/A'),
(183, '2\\28', '1\\82', 'กุงเทพ', '25164', 70, 18, 350, 1234567891092, NULL, NULL, 'DIfirst181', 'N/A', 'N/A'),
(184, '3\\29', '1\\83', 'bangkok', '25164', 71, 18, 333, 1234567891093, NULL, NULL, 'DIfirst182', 'N/A', 'N/A'),
(185, '4\\30', '1\\84', 'กุงเทพ', '25164', 72, 18, 46, 1234567891094, NULL, NULL, 'DIfirst183', 'N/A', 'N/A'),
(186, '2\\29', '1\\85', 'bangkok', '25164', 73, 18, 126, 1234567891095, NULL, NULL, 'DIfirst184', 'N/A', 'N/A'),
(187, '3\\30', '1\\86', 'กุงเทพ', '25164', 74, 19, 354, 1234567891096, NULL, NULL, 'DIfirst185', 'N/A', 'N/A'),
(188, '4\\31', '1\\87', 'bangkok', '25164', 75, 19, 362, 1234567891097, NULL, NULL, 'DIfirst186', 'N/A', 'N/A'),
(189, '2\\30', '1\\88', 'กุงเทพ', '25164', 76, 19, 75, 1234567891098, NULL, NULL, 'DIfirst187', 'N/A', 'N/A'),
(190, '3\\31', '1\\89', 'bangkok', '25164', 77, 19, 350, 1234567891099, NULL, NULL, 'DIfirst188', 'N/A', 'N/A'),
(191, '4\\32', '1\\90', 'กุงเทพ', '25164', 78, 19, 333, 1234567891100, NULL, NULL, 'DIfirst189', 'N/A', 'N/A'),
(192, '2\\31', '1\\91', 'bangkok', '25164', 79, 20, 46, 1234567891101, NULL, NULL, 'DIfirst190', 'N/A', 'N/A'),
(193, '3\\32', '1\\92', 'กุงเทพ', '25164', 80, 20, 362, 1234567891102, NULL, NULL, 'DIfirst191', 'N/A', 'N/A'),
(194, '4\\33', '1\\93', 'bangkok', '25164', 81, 20, 396, 1234567891103, NULL, NULL, 'DIfirst192', 'N/A', 'N/A'),
(195, '2\\32', '1\\94', 'กุงเทพ', '25164', 82, 20, 43, 1234567891104, NULL, NULL, 'DIfirst193', 'N/A', 'N/A'),
(196, '3\\33', '1\\95', 'bangkok', '25164', 83, 20, 46, 1234567891105, NULL, NULL, 'DIfirst194', 'N/A', 'N/A'),
(197, '4\\34', '1\\96', 'กุงเทพ', '25164', 84, 21, 49, 1234567891106, NULL, NULL, 'DIfirst195', 'N/A', 'N/A'),
(198, '2\\33', '1\\97', 'bangkok', '25164', 85, 21, 13, 1234567891107, NULL, NULL, 'DIfirst196', 'N/A', 'N/A'),
(199, '3\\34', '1\\98', 'กุงเทพ', '25164', 86, 21, 75, 1234567891108, NULL, NULL, 'DIfirst197', 'N/A', 'N/A'),
(200, '4\\35', '1\\99', 'bangkok', '25164', 87, 21, 350, 1234567891109, NULL, NULL, 'DIfirst198', 'N/A', 'N/A'),
(201, '2\\34', '1\\100', 'กุงเทพ', '25164', 88, 21, 333, 1234567891110, NULL, NULL, 'DIfirst199', 'N/A', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `login_errors`
--

CREATE TABLE IF NOT EXISTS `login_errors` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `login_errors`
--

INSERT INTO `login_errors` (`ai`, `username_or_email`, `ip_address`, `time`) VALUES
(26, 'admin', '::1', '2016-08-09 15:47:09'),
(25, 'admin', '::1', '2016-08-09 15:47:01');

-- --------------------------------------------------------

--
-- Stand-in structure for view `report`
--
CREATE TABLE IF NOT EXISTS `report` (
`customer_id` bigint(13)
,`customer_name` varchar(50)
,`phone` varchar(50)
,`address1` varchar(50)
,`address2` varchar(50)
,`city` varchar(50)
,`state` varchar(50)
,`postal_code` varchar(15)
);
-- --------------------------------------------------------

--
-- Table structure for table `username_or_email_on_hold`
--

CREATE TABLE IF NOT EXISTS `username_or_email_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `auth_level`, `banned`, `passwd`, `passwd_recovery_code`, `passwd_recovery_date`, `passwd_modified_at`, `last_login`, `created_at`, `modified_at`, `email`) VALUES
(1, 'admin', 'admin@example.com', 9, '0', '$2y$11$WGzGp7nhIqy9uvqjEgFYnO94NfTZAdb1f9SMJmnydEUJE7/WKavuS', NULL, NULL, NULL, '2016-08-16 08:55:26', '2016-07-28 18:39:13', '2016-08-16 01:55:26', NULL),
(3, 'test', 'ณัฐกรณ์ วงศ์สายเชื้อ', 9, '0', '$2y$11$1362tK/Tfr9m.EMvWKRaQ.BeLWJgtj6EvPpQdzVhHPZ84RYg9Fqdy', NULL, NULL, '2016-07-29 00:22:01', '2016-07-29 00:22:39', '0000-00-00 00:00:00', '2016-07-28 17:22:39', NULL);

-- --------------------------------------------------------

--
-- Structure for view `report`
--
DROP TABLE IF EXISTS `report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report` AS select `customers`.`customer_id` AS `customer_id`,`customers`.`customer_name` AS `customer_name`,`customers`.`phone` AS `phone`,`customers`.`address1` AS `address1`,`customers`.`address2` AS `address2`,`customers`.`city` AS `city`,`customers`.`state` AS `state`,`customers`.`postal_code` AS `postal_code` from (`lands` join `customers` on((`lands`.`customer_id` <> `customers`.`customer_id`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acl`
--
ALTER TABLE `acl`
  ADD CONSTRAINT `acl_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `acl_actions` (`action_id`) ON DELETE CASCADE;

--
-- Constraints for table `acl_actions`
--
ALTER TABLE `acl_actions`
  ADD CONSTRAINT `acl_actions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `acl_categories` (`category_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
