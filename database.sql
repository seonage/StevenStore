-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2014 at 01:03 PM
-- Server version: 5.0.96
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lins_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE IF NOT EXISTS `Customers` (
  `Email` varchar(30) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(2) NOT NULL,
  `ZipCode` varchar(5) NOT NULL,
  PRIMARY KEY  (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`Email`, `FirstName`, `LastName`, `Password`, `Address`, `City`, `State`, `ZipCode`) VALUES
('joecustomer@yahoo.com', 'Joe', 'Customer', 'e2e46bc2c7035c560aaf7a0537c12da528158aa4', '321 Fake Street', 'Cedar Grove', 'NJ', '07709'),
('RowdyRonda@yahoo.com', 'Ronda', 'Rousey', 'e7b9288198bf5c2de34fa947cc1ca8a0e79a8512', '93 Nowhere Ave', 'Santa Monica', 'CA', '90402');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE IF NOT EXISTS `Orders` (
  `Row` int(10) NOT NULL,
  `OrderID` int(20) NOT NULL,
  `CustomerEmail` varchar(30) NOT NULL,
  `OrderTime` varchar(30) NOT NULL,
  `ProductOrdered` varchar(30) NOT NULL,
  `Quantity` int(3) NOT NULL,
  UNIQUE KEY `Row` (`Row`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`Row`, `OrderID`, `CustomerEmail`, `OrderTime`, `ProductOrdered`, `Quantity`) VALUES
(1, 660354474, 'joecustomer@yahoo.com', 'January 07, 2014, 21:53:40', 'BrkUltLiBluGi', 2),
(2, 409001292, 'joecustomer@yahoo.com', 'January 07, 2014, 22:09:39', 'BrkUltLiBluGi', 2),
(3, 1235947011, 'joecustomer@yahoo.com', 'January 07, 2014, 22:10:09', 'BrkUltLiBluGi', 1),
(4, 1235947011, 'joecustomer@yahoo.com', 'January 07, 2014, 22:10:09', 'RevBoxGlove', 1),
(5, 802227305, 'joecustomer@yahoo.com', 'January 13, 2014, 22:51:25', 'RevHeadGrChekProt', 2),
(6, 1818735203, 'joecustomer@yahoo.com', 'January 21, 2014, 19:26:43', 'RevBoxGlove', 1),
(7, 1818735203, 'joecustomer@yahoo.com', 'January 21, 2014, 19:26:43', 'KorClassWhiGi', 1),
(8, 213050971, 'RowdyRonda@yahoo.com', 'January 22, 2014, 18:10:03', 'RevHeadGrChekProt', 2),
(9, 213050971, 'RowdyRonda@yahoo.com', 'January 22, 2014, 18:10:03', 'KorClassWhiGi', 1),
(10, 600677892, 'joecustomer@yahoo.com', 'January 25, 2014, 21:32:30', 'KorClassWhiGi', 10),
(11, 600677892, 'joecustomer@yahoo.com', 'January 25, 2014, 21:32:30', 'RevBoxGlove', 1),
(12, 2116034997, 'joecustomer@yahoo.com', 'January 28, 2014, 20:09:41', 'RevBoxGlove', 1),
(13, 312987236, 'RowdyRonda@yahoo.com', 'January 29, 2014, 17:40:37', 'SevFightMitts', 1),
(14, 312987236, 'RowdyRonda@yahoo.com', 'January 29, 2014, 17:40:37', 'ScarmGalaShorts', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `Product_ID` varchar(30) NOT NULL,
  `Product_Category` varchar(30) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`Product_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`Product_ID`, `Product_Category`, `Product_Name`, `Price`) VALUES
('KorClassWhiGi', 'Gi', 'Koral Classic White Gi', '169.90'),
('RevHeadGrChekProt', 'Headgear', 'Revgear Head Gear with Cheek Protection', '79.99'),
('RevBoxGlove', 'Gloves', 'Revgear Original Leather Boxing Gloves', '59.99'),
('BrkUltLiBluGi', 'Gi', 'Breakpoint Ultra Light Blue Gi', '74.99'),
('BrkWrlBraGi', 'Gi', 'Breakpoint World Series Gi', '189.85'),
('GameEliGi', 'Gi', 'Gameness Elite Gi', '198.99'),
('SubHemSensGi', 'Gi', 'Submission Hemp Sensation Gi', '159.99'),
('FujiForCamGi', 'Gi', 'Fuji Force Camouflage Gi', '148.88'),
('HayaIkuHead', 'Headgear', 'Hayabusa Ikusa Headgear', '99.99'),
('VenAbsoHead', 'Headgear', 'Venum Absolute 2.0 Headgear', '94.99'),
('BadBoyProFull', 'Headgear', 'Bad Boy Pro Series Full Face Head Guard', '79.99'),
('RingMexHead', 'Headgear', 'Ringside Mexi-Flex Head Gear', '69.99'),
('SevFigGear', 'Headgear', 'Seven Fight Headgear', '59.99'),
('UfcMmaGlove', 'Gloves', 'UFC MMA Gloves', '29.99'),
('BadBoyGelGlove', 'Gloves', 'Bad Boy Pro Series Gloves', '74.99'),
('CenCreMMAGlove', 'Gloves', 'Century CREED MMA Training Glove', '69.99'),
('RingProStyTech', 'Gloves', 'Ringside Pro Style IMF Tech Training Gloves', '119.99'),
('FairTraGloves', 'Gloves', 'Fairtex Training Gloves', '99.99'),
('MosFiShort', 'Shorts', 'Moskova Fight Shorts', '54.99'),
('VenSharCorrSho', 'Shorts', 'Venum Sharp Corra Fight Shorts', '67.99'),
('BullTerMushSho', 'Shorts', 'Bull Terrier Mushin 2.0 Fight Shorts', '58.99'),
('TapPerShort', 'Shorts', 'TapouT Performance Fight Shorts', '59.99'),
('ScarmGalaShorts', 'Shorts', 'Scramble Galactica Shorts', '64.99'),
('GracUndShorts', 'Shorts', 'Gracie Jiu-Jitsu Undercover Fight Shorts', '44.99'),
('SevFightMitts', 'Mitts', 'Seven Fight Gear Punch Mitts', '74.99'),
('WindTradMitt', 'Mitts', 'Windy Traditional Punch Mitts', '76.99'),
('TriuDeathMitts', 'Mitts', 'Triumph United Death Star Micro Mitts', '84.99'),
('ComSpoMitts', 'Mitts', 'Combat Sports Elongated Punch Mitts', '79.99'),
('RevAirMitts', 'Mitts', 'Revgear Air Mitts', '69.99'),
('CenCreeMitts', 'Mitts', 'Century CREED Long Focus Mitts', '89.99');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `Email` varchar(30) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY  (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Email`, `Type`, `FirstName`, `LastName`, `Password`) VALUES
('slin@mmamart.com', 'Admin', 'Steven', 'Lin', '733aa03fdd44bf8e5018a0a892dffe981207827f'),
('tazriley@mmamart.com', 'Admin', 'Taz', 'Riley', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684'),
('bethpelsar@mmamart.com', 'Admin', 'Beth', 'Pelsar', '7e0d1332d623ea74efc445ac776b73b048e4a49e'),
('dhardy@mmamart.com', 'Employee', 'Dan', 'Hardy', 'e69cba74c47c08ab6bed7d4422f37fdff4975172'),
('tonytorres@mmamart.com', 'Manager', 'Tony', 'Torres', 'afaed75406bd414820cea4a5119f90c259c05755');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
