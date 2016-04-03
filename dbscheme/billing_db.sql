-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2016 at 05:19 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `billingclone`
--

-- --------------------------------------------------------

--
-- Table structure for table `akquises`
--

CREATE TABLE IF NOT EXISTS `akquises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kundenname` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `kundenemail` varchar(255) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `erstkontaktdatum` datetime NOT NULL,
  `kontaktmedium` varchar(255) NOT NULL,
  `kundentypologie` varchar(255) NOT NULL,
  `shopsystem` varchar(255) NOT NULL,
  `arbeitsinhalt` varchar(255) NOT NULL,
  `referenz` varchar(255) NOT NULL,
  `resultat` varchar(255) NOT NULL,
  `absagegrund` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `salutation` varchar(30) DEFAULT NULL,
  `companyname` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `city` varchar(70) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `fax` varchar(80) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `www` varchar(100) DEFAULT NULL,
  `ustid` varchar(50) DEFAULT NULL,
  `taxnumber` varchar(50) DEFAULT NULL,
  `description` longtext,
  `bankaccountholder` varchar(50) DEFAULT NULL,
  `bankaccountnumber` varchar(50) DEFAULT NULL,
  `bankaccountcode` varchar(50) DEFAULT NULL,
  `bankaccountiban` varchar(50) DEFAULT NULL,
  `bankaccountswift` varchar(50) DEFAULT NULL,
  `bankname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `billingaddress` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `emailsignature` mediumtext NOT NULL,
  `email_sie` mediumtext NOT NULL,
  `email_du` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `loginname` varchar(50) NOT NULL,
  `password` longtext NOT NULL,
  `salutation` varchar(30) DEFAULT NULL,
  `companyname` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `city` varchar(70) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `fax` varchar(80) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `handy` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_salutation` varchar(100) NOT NULL,
  `email_firstname` varchar(100) NOT NULL,
  `email_lastname` varchar(100) NOT NULL,
  `www` varchar(100) DEFAULT NULL,
  `ustid` varchar(50) DEFAULT NULL,
  `description` longtext,
  `zugangsdaten` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `billingaddress` varchar(50) DEFAULT NULL,
  `billable` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `customer_rate` varchar(50) NOT NULL,
  `zdata` longtext NOT NULL,
  `taxtrate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;



-- --------------------------------------------------------

--
-- Table structure for table `customer_blogs`
--

CREATE TABLE IF NOT EXISTS `customer_blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tickets`
--

CREATE TABLE IF NOT EXISTS `customer_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` longtext,
  `comment` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `taxrate` double DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `minutes` double DEFAULT NULL,
  `price_rate` varchar(30) NOT NULL,
  `active` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `draftinvoiceitems`
--

CREATE TABLE IF NOT EXISTS `draftinvoiceitems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` varchar(50) DEFAULT NULL,
  `amountnet` double DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` longtext,
  `quantity` int(11) DEFAULT NULL,
  `taxrate` double DEFAULT NULL,
  `sortorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoiceitems`
--

CREATE TABLE IF NOT EXISTS `invoiceitems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoiceid` varchar(50) DEFAULT NULL,
  `amountnet` double DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` longtext,
  `quantity` double NOT NULL,
  `taxrate` double DEFAULT NULL,
  `sortorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `freeinvoiceid` varchar(50) DEFAULT NULL,
  `invoicedate` varchar(50) DEFAULT NULL,
  `amountnet` double DEFAULT NULL,
  `amounttax` double DEFAULT NULL,
  `taxrate` double DEFAULT NULL,
  `amounttotal` double DEFAULT NULL,
  `invoice_status_id` int(11) DEFAULT NULL,
  `invoice_type_id` int(100) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `emailsent` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;


-- --------------------------------------------------------

--
-- Table structure for table `invoice_statuses`
--

CREATE TABLE IF NOT EXISTS `invoice_statuses` (
  `id` int(10) unsigned NOT NULL,
  `invoicestatus` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_statuses`
--

INSERT INTO `invoice_statuses` (`id`, `invoicestatus`) VALUES
  (0, 'Entwurf'),
  (1, 'Bezahlt'),
  (3, 'Versendet');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_texts`
--

CREATE TABLE IF NOT EXISTS `invoice_texts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(50) DEFAULT NULL,
  `invoice_text_type_id` varchar(50) DEFAULT NULL,
  `text` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;


-- --------------------------------------------------------

--
-- Table structure for table `invoice_text_types`
--

CREATE TABLE IF NOT EXISTS `invoice_text_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(150) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `invoice_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `invoice_text_types`
--

INSERT INTO `invoice_text_types` (`id`, `type`, `description`, `invoice_type_id`) VALUES
  (1, 'salutation', 'Anrede', 0),
  (2, 'complimentary_close', 'Grussformel Rechnung', 0),
  (3, 'additional_notes', 'Zusatzinfo', 0),
  (4, 'subject', 'Betreff', 0),
  (5, 'address', 'Adresse', 0),
  (6, 'salutation', NULL, 1),
  (7, 'complimentary_close', NULL, 1),
  (8, 'additional_notes', NULL, 1),
  (9, 'subject', NULL, 1),
  (10, 'address', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_types`
--

CREATE TABLE IF NOT EXISTS `invoice_types` (
  `id` int(10) unsigned NOT NULL,
  `invoicetype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_types`
--

INSERT INTO `invoice_types` (`id`, `invoicetype`) VALUES
  (0, 'invoice'),
  (1, 'offer');

-- --------------------------------------------------------

--
-- Table structure for table `textdrafts`
--

CREATE TABLE IF NOT EXISTS `textdrafts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `textdraft` longtext,
  `field` varchar(50) DEFAULT NULL,
  `invoice_type_id` int(10) DEFAULT NULL,
  `invoice_text_type_id` int(10) DEFAULT NULL,
  `defaultvalue` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `textdrafts`
--

INSERT INTO `textdrafts` (`id`, `title`, `textdraft`, `field`, `invoice_type_id`, `invoice_text_type_id`, `defaultvalue`) VALUES
  (1, 'Standard Salutation Rechnung', 'Hallo Sie,\r\ntest test', 'salutation', 0, 1, NULL),
  (2, 'grussformel rechnung', 'test', NULL, 0, 2, NULL),
  (3, 'zusatzinfo rechnung', 'zusatz tesxt', NULL, 0, 3, NULL),
  (5, 'Standard Salutation Angebot', 'Hallo Sie,\r\ntest test', 'salutation', 1, 1, NULL),
  (6, 'grussformel', 'test', 'bottom', 1, 2, NULL),
  (7, 'zusatzinfo', NULL, 'bottom_additional', 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;