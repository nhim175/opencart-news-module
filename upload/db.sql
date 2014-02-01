-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 30, 2013 at 02:07 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opencart`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_e_category`
--

CREATE TABLE IF NOT EXISTS `oc_e_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `oc_e_category`
--

INSERT INTO `oc_e_category` (`category_id`, `category_title`) VALUES
(1, 'asdasdsad'),
(5, 'jklm');

-- --------------------------------------------------------

--
-- Table structure for table `oc_e_post`
--

CREATE TABLE IF NOT EXISTS `oc_e_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` text,
  `post_content` text,
  `post_img` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `oc_e_post`
--

INSERT INTO `oc_e_post` (`post_id`, `post_title`, `post_content`, `post_img`, `status`, `post_date`) VALUES
(3, 'This is a title', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://localhost/opencart/image/data/homepage-banner2.jpg&quot; style=&quot;width: 460px; height: 240px;&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;br /&gt;\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;br /&gt;\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;br /&gt;\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;br /&gt;\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;br /&gt;\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', 'data/130916_women_knit_04-xxm.jpg', 1, '2013-10-25 09:22:17'),
(6, 'This is also a title', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;br /&gt;\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;br /&gt;\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;br /&gt;\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;br /&gt;\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;br /&gt;\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;\r\n', 'data/thumb3.jpg', 1, '2013-10-25 10:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `oc_e_post_category`
--

CREATE TABLE IF NOT EXISTS `oc_e_post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `oc_e_post_category`
--

INSERT INTO `oc_e_post_category` (`id`, `post_id`, `category_id`) VALUES
(1, 3, 5),
(4, 6, 5);
