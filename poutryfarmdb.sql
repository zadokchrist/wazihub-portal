-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2018 at 06:17 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poutryfarmdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `stocktable`
--

DROP TABLE IF EXISTS `stocktable`;
CREATE TABLE IF NOT EXISTS `stocktable` (
  `Recordid` int(11) NOT NULL AUTO_INCREMENT,
  `Stocktype` varchar(1000) NOT NULL,
  `Qty` varchar(10) NOT NULL,
  `StockDate` date NOT NULL,
  `TimeOfDay` varchar(100) NOT NULL,
  PRIMARY KEY (`Recordid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocktable`
--

INSERT INTO `stocktable` (`Recordid`, `Stocktype`, `Qty`, `StockDate`, `TimeOfDay`) VALUES
(1, 'Chicken Feed', '2', '2018-12-13', 'Morning');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
