-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2014 at 01:47 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs4345`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE IF NOT EXISTS `authentication` (
  `empID` int(11) NOT NULL AUTO_INCREMENT,
  `psswdHash` varchar(255) DEFAULT NULL,
  `userName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`empID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`empID`, `psswdHash`, `userName`) VALUES
(1, '$2y$10$8Xdgt3c6m6KDTEWSna9SAuyd0/F0qnhiw/P881qNgHlSkfuJZ1S6O', 'alex.roate.1'),
(2, '$2y$10$rEKQqDfmoKWZK4Oq47m1eu6XSkUP2EeEXQfLeS8vPxebXvidawoJq', 'jonathan.murphy.2'),
(3, '$2y$10$eXUD6KV4nSSHosM0UH2aBOAmsRVE46HFGVEave/AZL7e9Tg/ZrRyW', 'nick.revels.3');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyName` varchar(100) DEFAULT NULL,
  `isIndividual` bit(1) DEFAULT b'0',
  `dateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isAdminUser` bit(1) DEFAULT b'0',
  `lName` varchar(25) NOT NULL DEFAULT 'NULL',
  `fName` varchar(25) NOT NULL DEFAULT 'NULL',
  `locationID` int(11) DEFAULT NULL,
  `dateEmployed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locationID` (`locationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `isAdminUser`, `lName`, `fName`, `locationID`, `dateEmployed`) VALUES
(1, b'1', 'Roate', 'Alex', NULL, '2014-11-11 00:00:00'),
(2, b'1', 'Murphy', 'Jonathan', NULL, '2014-11-11 00:00:00'),
(3, b'1', 'Revels', 'Nick', NULL, '2014-11-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locationName` varchar(50) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `streetAddr1` varchar(50) DEFAULT NULL,
  `streetAddr2` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Locations we have across the US' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` bigint(20) DEFAULT '0',
  `dateCreated` datetime DEFAULT NULL,
  `mime` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fileData` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table for pictures for points of contact' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pointofcontact`
--

CREATE TABLE IF NOT EXISTS `pointofcontact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyID` int(11) DEFAULT NULL,
  `fName` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `pictureID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companyID` (`companyID`),
  KEY `pictureID` (`pictureID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) DEFAULT NULL,
  `pointOfContactId` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `followUpReq` bit(1) DEFAULT b'0',
  `type` char(1) DEFAULT NULL COMMENT 'I = inquiry ; S = Sale',
  `resultInSale` bit(1) DEFAULT b'0',
  `notes` mediumtext,
  `followUpTransID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employeeId` (`employeeId`),
  KEY `pointOfContactId` (`pointOfContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For interactions with clients' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `mime` varchar(50) DEFAULT NULL,
  `size` bigint(20) DEFAULT '0',
  `fileData` blob,
  `dateCreated` datetime DEFAULT NULL,
  `transactionID` int(11) DEFAULT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`),
  KEY `transactionID` (`transactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table for storing uploaded pdfs' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`id`) REFERENCES `authentication` (`empID`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`locationID`) REFERENCES `location` (`id`);

--
-- Constraints for table `pointofcontact`
--
ALTER TABLE `pointofcontact`
  ADD CONSTRAINT `pointofcontact_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `pointofcontact_ibfk_2` FOREIGN KEY (`pictureID`) REFERENCES `picture` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`pointOfContactId`) REFERENCES `pointofcontact` (`id`);

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`transactionID`) REFERENCES `transaction` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
