-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2013 at 10:03 AM
-- Server version: 5.5.16
-- PHP Version: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smb`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` text,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `date`, `description`, `featured`, `status`, `createdby`, `editedby`, `createdon`, `editedon`, `lang`) VALUES
(1, 'artikl-11', '2013-02-07 00:00:00', 'tekst artikla 1', 0, 1, 1, 1, '2013-02-07 09:15:05', '2013-02-08 14:41:35', 2),
(2, 'artikl-2', '2013-02-07 09:15:17', 'tekst artikla 2', 0, 1, 1, 1, '2013-02-07 09:15:05', '2013-02-07 09:15:05', 1),
(4, 'artikl-4', '2013-02-07 09:15:41', 'tekst artikla 4', 0, 0, 1, 1, '2013-02-07 09:15:05', '2013-02-07 09:15:05', 1),
(5, 'Artikl 5', '2013-02-15 00:00:00', 'Artikl 5', 0, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(6, 'ljkljklj', '2013-07-02 00:00:00', 'lkjkljklj', 0, 0, 1, 1, '2013-02-13 15:43:56', '2013-02-13 15:43:56', 1),
(7, 'Featured Article', '2013-02-21 00:00:00', 'Test za FA', 1, 0, 1, 1, '2013-02-21 09:31:07', '2013-02-21 09:31:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `short_desc` varchar(200) DEFAULT NULL,
  `description` text,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `short_desc`, `description`, `createdby`, `editedby`, `createdon`, `editedon`, `status`, `image_id`, `lang`) VALUES
(1, 'Torte', 'Short cat torte', 'Kategorija torti', 1, 1, '2013-02-21 15:05:21', '2013-02-21 15:05:21', 1, 0, 1),
(2, 'Torte2', 'Short cat torte2', 'Kategorija torti2', 1, 1, '2013-02-21 15:05:46', '2013-02-21 15:05:46', 1, NULL, 1),
(10, 'ghjpic', 'ghjk', 'tzuo', 1, 1, '2013-02-25 10:50:04', '2013-02-25 10:50:04', 0, NULL, 1),
(12, '3 Proizvoda', 'kjhkjhkjhkjhkjh', 'hkjhkjhkjhkjh', 1, 1, '2013-02-26 10:32:09', '2013-02-26 10:32:09', 1, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categorytoproduct`
--

CREATE TABLE IF NOT EXISTS `categorytoproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `categorytoproduct`
--

INSERT INTO `categorytoproduct` (`id`, `category_id`, `product_id`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(2, 2, 1, 1, 1, '2013-02-21 15:07:13', '2013-02-21 15:07:13'),
(16, 10, 3, 1, 1, '2013-02-25 10:50:04', '2013-02-25 10:50:04'),
(17, 12, 2, 1, 1, '2013-02-26 10:32:10', '2013-02-26 10:32:10'),
(18, 12, 1, 1, 1, '2013-02-26 10:32:10', '2013-02-26 10:32:10'),
(19, 12, 4, 1, 1, '2013-02-26 10:32:10', '2013-02-26 10:32:10'),
(44, 1, 2, 1, 1, '2013-02-26 11:15:41', '2013-02-26 11:15:41'),
(45, 1, 3, 1, 1, '2013-02-26 11:15:41', '2013-02-26 11:15:41'),
(46, 1, 4, 1, 1, '2013-02-26 11:15:41', '2013-02-26 11:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `oib` int(11) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `booking_email` varchar(50) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `oib`, `country`, `county`, `city`, `zip_code`, `address1`, `address2`, `phone`, `mobile_phone`, `fax`, `contact_email`, `booking_email`, `createdby`, `editedby`, `createdon`, `editedon`, `lang`) VALUES
(1, 'Kontakt1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(256) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `img`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(9, '0301007.56.jpg', 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35'),
(10, 'Map_of_Dune.png', 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35'),
(11, 'slut_troll_comic.jpg', 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35'),
(13, 'kolac1.jpg', 1, 1, '2013-02-22 09:25:43', '2013-02-22 09:25:43'),
(14, 'kolac2.jpg', 1, 1, '2013-02-22 09:25:43', '2013-02-22 09:25:43'),
(22, '0301007.56.jpg', 1, 1, '2013-02-28 09:40:26', '2013-02-28 09:40:26'),
(23, 'Map_of_Dune.png', 1, 1, '2013-02-28 09:40:26', '2013-02-28 09:40:26'),
(33, 'Map_of_Dune.png', 1, 1, '2013-03-04 10:28:09', '2013-03-04 10:28:09'),
(34, 'Vrsar.jpg', 1, 1, '2013-03-04 10:28:09', '2013-03-04 10:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `imgtopage`
--

CREATE TABLE IF NOT EXISTS `imgtopage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `imgtopage`
--

INSERT INTO `imgtopage` (`id`, `page_id`, `image_id`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(1, 15, 9, 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35'),
(2, 15, 10, 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35'),
(3, 15, 11, 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `imgtoproduct`
--

CREATE TABLE IF NOT EXISTS `imgtoproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `imgtoproduct`
--

INSERT INTO `imgtoproduct` (`id`, `product_id`, `image_id`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(2, 1, 13, 1, 1, '2013-02-22 09:25:43', '2013-02-22 09:25:43'),
(3, 1, 14, 1, 1, '2013-02-22 09:25:43', '2013-02-22 09:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`id`, `iso`, `lang`) VALUES
(1, 'en', 'English'),
(2, 'hr', 'Hrvatski'),
(3, 'it', 'Italiano'),
(4, 'de', 'Deutsch');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE IF NOT EXISTS `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `inc_in_header` tinyint(1) DEFAULT '0',
  `inc_in_footer` tinyint(1) DEFAULT '0',
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `page_id`, `sort`, `inc_in_header`, `inc_in_footer`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(2, 17, 2, 1, 0, 1, 1, '2013-02-15 09:56:52', '2013-02-20 12:48:12'),
(3, 19, 2, 1, 0, 1, 1, '2013-02-15 09:57:17', '2013-02-20 09:09:58'),
(4, 20, 1, 1, 0, 1, 1, '2013-02-15 09:57:56', '2013-02-20 10:04:15'),
(5, 21, 3, 0, 1, 1, 1, '2013-02-15 10:04:49', '2013-02-20 09:09:58'),
(6, 22, 5, 0, 0, 1, 1, '2013-02-18 11:59:44', '2013-02-18 11:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `contents` varchar(100) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `status`, `title`, `contents`, `createdby`, `editedby`, `createdon`, `editedon`, `lang`) VALUES
(14, 1, 'PageWOimages', 'LOLI', 1, 1, '2013-02-13 16:58:08', '2013-02-13 16:58:08', 1),
(15, 1, 'PageWimages', 'BOLI', 1, 1, '2013-02-13 16:59:35', '2013-02-13 16:59:35', 3),
(16, 0, 'jkl', 'jkl', 1, 1, '2013-02-15 09:56:51', '2013-02-15 09:56:51', 1),
(18, 0, 'jkl22', 'jkl', 1, 1, '2013-02-15 09:57:17', '2013-02-15 09:57:17', 1),
(20, 0, '20ENG', 'jkl', 1, 1, '2013-02-15 09:57:56', '2013-02-19 15:21:18', 1),
(21, 1, '21CRO', 'Particle Zero One Zero', 1, 1, '2013-02-15 10:04:49', '2013-02-19 15:24:21', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `short_desc` varchar(200) DEFAULT NULL,
  `description` text,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `short_desc`, `description`, `createdby`, `editedby`, `createdon`, `editedon`, `status`, `lang`) VALUES
(1, 'Torta', 'Short za tortu', 'Super fina torta od čokolade koju će mi Tamara napraviti kada se vrati iz Pule :-)', 1, 1, '2013-02-21 11:15:35', '2013-02-22 09:25:43', 1, 2),
(2, 'Kolač', 'hjk', 'hjk', 1, 1, '2013-02-25 09:30:31', '2013-02-25 09:30:31', 0, 1),
(3, 'Pita', 'jkl', 'jkl', 1, 1, '2013-02-25 09:30:48', '2013-02-25 09:30:48', 0, 3),
(4, 'Sladoled', 'hkj', 'hkj', 1, 1, '2013-02-25 09:31:08', '2013-02-25 09:31:08', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `meta_desc` text,
  `meta_keywords` varchar(256) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  `lang` int(11) NOT NULL,
  `webimg_id` int(11) DEFAULT NULL,
  `mailimg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `meta_desc`, `meta_keywords`, `createdby`, `editedby`, `createdon`, `editedon`, `lang`, `webimg_id`, `mailimg_id`) VALUES
(10, 'Kontakt s jednom slsl', 'nnnnmm', 'nn', 1, 1, '2013-02-28 10:15:49', '2013-03-04 10:13:12', 2, NULL, NULL),
(11, 'Kontakt s dvije sl', 'hkjhhhg', 'hkj', 1, 1, '2013-02-28 10:17:02', '2013-03-04 10:13:04', 1, NULL, 26),
(12, 'Novi', 'uio', 'uio', 1, 1, '2013-03-04 10:09:52', '2013-03-04 10:09:52', 4, NULL, NULL),
(13, 'tal', 'jlk', 'jkl', 1, 1, '2013-03-04 10:28:08', '2013-03-04 10:28:08', 3, 33, 34);

-- --------------------------------------------------------

--
-- Table structure for table `settingstocontact`
--

CREATE TABLE IF NOT EXISTS `settingstocontact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `createdby` int(11) DEFAULT NULL,
  `editedby` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `editedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `settingstocontact`
--

INSERT INTO `settingstocontact` (`id`, `settings_id`, `contact_id`, `createdby`, `editedby`, `createdon`, `editedon`) VALUES
(11, 12, 1, 1, 1, '2013-03-04 10:09:52', '2013-03-04 10:09:52'),
(12, 11, 1, 1, 1, '2013-03-04 10:13:04', '2013-03-04 10:13:04'),
(13, 10, 1, 1, 1, '2013-03-04 10:13:12', '2013-03-04 10:13:12'),
(14, 13, 1, 1, 1, '2013-03-04 10:28:09', '2013-03-04 10:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`) VALUES
(1, 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `name`, `lastname`, `user_id`) VALUES
(1, 'Pero', 'Perić', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `imgtopage`
--
ALTER TABLE `imgtopage`
  ADD CONSTRAINT `imgtopage_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `imgtopage_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

--
-- Constraints for table `imgtoproduct`
--
ALTER TABLE `imgtoproduct`
  ADD CONSTRAINT `imgtoproduct_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `imgtoproduct_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

--
-- Constraints for table `userdata`
--
ALTER TABLE `userdata`
  ADD CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
