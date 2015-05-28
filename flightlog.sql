-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2015 at 03:45 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eklv`
--

-- --------------------------------------------------------

--
-- Table structure for table `flightlog`
--

CREATE TABLE IF NOT EXISTS `flightlog` (
  `flight_id` int(11) NOT NULL AUTO_INCREMENT,
  `flight_date` date NOT NULL,
  `airfield` varchar(200) NOT NULL,
  `alt_setting` varchar(200) NOT NULL,
  `unit` varchar(200) NOT NULL,
  PRIMARY KEY (`flight_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `flightlog`
--

INSERT INTO `flightlog` (`flight_id`, `flight_date`, `airfield`, `alt_setting`, `unit`) VALUES
(5, '2015-04-30', 'EKLV', 'QFE', 'm'),
(4, '2015-04-26', 'EKLV', 'QFE', 'm'),
(6, '2015-05-01', 'EKLV', 'QFE', 'm'),
(7, '2015-05-02', 'EKLV', 'QFE', 'm'),
(8, '2015-05-03', 'EKLV', 'QFE', 'm'),
(9, '2015-05-08', 'EKLV', 'QFE', 'm'),
(10, '2015-05-10', 'EKLV', 'QFE', 'm'),
(11, '2015-05-14', 'EKLV', 'QFE', 'm'),
(12, '2015-05-15', 'EKLV', 'QFE', 'm'),
(13, '2015-05-17', 'EKLV', 'QFE', 'm'),
(14, '2015-05-20', 'EKLV', 'QFE', 'm'),
(15, '2015-05-21', 'EKLV', 'QFE', 'm'),
(16, '2015-05-22', 'EKLV', 'QFE', 'm'),
(17, '2015-05-23', 'EKLV', 'QFE', 'm'),
(18, '2015-05-24', 'EKLV', 'QFE', 'm'),
(19, '2015-05-26', '', '', ''),
(20, '2015-05-27', '', '', ''),
(21, '2015-05-15', 'EKLV', 'QFE', 'm'),
(22, '2015-05-15', 'EKLV', 'QFE', 'm'),
(23, '2015-05-15', 'EKLV', 'QFE', 'm'),
(24, '2015-05-15', 'EKLV', 'QFE', 'm'),
(25, '2015-05-15', 'EKLV', 'QFE', 'm');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
