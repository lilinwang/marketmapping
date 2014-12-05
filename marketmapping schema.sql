-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2014 at 06:30 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `marketmapping`
--
CREATE DATABASE IF NOT EXISTS `marketmapping` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `marketmapping`;

-- --------------------------------------------------------

--
-- Table structure for table `acquisitions`
--

CREATE TABLE IF NOT EXISTS `acquisitions` (
  `company_permalink` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_category_list` varchar(255) DEFAULT NULL,
  `company_market` varchar(255) DEFAULT NULL,
  `company_country_code` varchar(20) DEFAULT NULL,
  `company_state_code` varchar(20) DEFAULT NULL,
  `company_region` varchar(50) DEFAULT NULL,
  `company_city` varchar(50) DEFAULT NULL,
  `acquirer_permalink` varchar(255) DEFAULT NULL,
  `acquirer_name` varchar(255) DEFAULT NULL,
  `acquirer_category_list` varchar(255) DEFAULT NULL,
  `acquirer_market` varchar(255) DEFAULT NULL,
  `acquirer_country_code` varchar(20) DEFAULT NULL,
  `acquirer_state_code` varchar(20) DEFAULT NULL,
  `acquirer_region` varchar(50) DEFAULT NULL,
  `acquirer_city` varchar(50) DEFAULT NULL,
  `acquired_at` date DEFAULT NULL,
  `acquired_month` varchar(20) DEFAULT NULL,
  `acquired_quarter` varchar(20) DEFAULT NULL,
  `acquired_year` year(4) DEFAULT NULL,
  `price_amount` bigint(20) DEFAULT NULL,
  `price_currency_code` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55241 ;

-- --------------------------------------------------------

--
-- Table structure for table `axis`
--

CREATE TABLE IF NOT EXISTS `axis` (
  `axis_id` int(11) NOT NULL AUTO_INCREMENT,
  `axis_name` varchar(255) NOT NULL,
  `axis_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`axis_id`),
  UNIQUE KEY `axis_name` (`axis_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `permalink` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `homepage_url` varchar(255) DEFAULT NULL,
  `category_list` varchar(255) DEFAULT NULL,
  `market` varchar(255) DEFAULT NULL,
  `funding_total_usd` bigint(20) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `state_code` varchar(20) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `funding_rounds` tinyint(4) DEFAULT NULL,
  `founded_at` date DEFAULT NULL,
  `founded_month` date DEFAULT NULL,
  `founded_quarter` varchar(20) DEFAULT NULL,
  `founded_year` year(4) DEFAULT NULL,
  `first_funding_at` date DEFAULT NULL,
  `last_funding_at` date DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='company' AUTO_INCREMENT=46416 ;

-- --------------------------------------------------------

--
-- Table structure for table `industry_metric`
--

CREATE TABLE IF NOT EXISTS `industry_metric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industry` varchar(50) NOT NULL,
  `metric` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE IF NOT EXISTS `investments` (
  `company_permalink` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_category_list` varchar(255) DEFAULT NULL,
  `company_market` varchar(255) DEFAULT NULL,
  `company_country_code` varchar(20) DEFAULT NULL,
  `company_state_code` varchar(20) DEFAULT NULL,
  `company_region` varchar(50) DEFAULT NULL,
  `company_city` varchar(50) DEFAULT NULL,
  `investor_permalink` varchar(255) DEFAULT NULL,
  `investor_name` varchar(255) DEFAULT NULL,
  `investor_category_list` varchar(255) DEFAULT NULL,
  `investor_market` varchar(255) DEFAULT NULL,
  `investor_country_code` varchar(20) DEFAULT NULL,
  `investor_state_code` varchar(20) DEFAULT NULL,
  `investor_region` varchar(50) DEFAULT NULL,
  `investor_city` varchar(50) DEFAULT NULL,
  `funding_round_permalink` varchar(255) DEFAULT NULL,
  `funding_round_type` varchar(50) DEFAULT NULL,
  `funding_round_code` varchar(20) DEFAULT NULL,
  `funded_at` date DEFAULT NULL,
  `funded_month` varchar(20) DEFAULT NULL,
  `funded_quarter` varchar(20) DEFAULT NULL,
  `funded_year` year(4) DEFAULT NULL,
  `raised_amount_usd` bigint(20) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106875 ;

-- --------------------------------------------------------

--
-- Table structure for table `rounds`
--

CREATE TABLE IF NOT EXISTS `rounds` (
  `company_permalink` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_category_list` varchar(255) DEFAULT NULL,
  `company_market` varchar(255) DEFAULT NULL,
  `company_country_code` varchar(20) DEFAULT NULL,
  `company_state_code` varchar(20) DEFAULT NULL,
  `company_region` varchar(50) DEFAULT NULL,
  `company_city` varchar(50) DEFAULT NULL,
  `funding_round_permalink` varchar(255) DEFAULT NULL,
  `funding_round_type` varchar(50) DEFAULT NULL,
  `funding_round_code` varchar(20) DEFAULT NULL,
  `funded_at` date DEFAULT NULL,
  `funded_month` varchar(20) DEFAULT NULL,
  `funded_quarter` varchar(20) DEFAULT NULL,
  `funded_year` year(4) DEFAULT NULL,
  `raised_amount_usd` bigint(20) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78385 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
