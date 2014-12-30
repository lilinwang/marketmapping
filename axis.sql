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

--
-- Dumping data for table `axis`
--

INSERT INTO `axis` (`axis_id`, `axis_name`, `axis_count`) VALUES
(1, 'high price', 1),
(2, 'high value', 1),
(3, 'high quality', 1),
(4, 'high salary', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
