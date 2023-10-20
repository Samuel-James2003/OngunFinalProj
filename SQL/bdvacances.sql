-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2023 at 01:03 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdvacances`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--

DROP TABLE IF EXISTS `t_category`;
CREATE TABLE IF NOT EXISTS `t_category` (
  `CatID` int(11) NOT NULL AUTO_INCREMENT,
  `CName` varchar(50) NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_chat`
--

DROP TABLE IF EXISTS `t_chat`;
CREATE TABLE IF NOT EXISTS `t_chat` (
  `ChatID` int(11) NOT NULL AUTO_INCREMENT,
  `DateCreated` datetime NOT NULL,
  PRIMARY KEY (`ChatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_chatlink`
--

DROP TABLE IF EXISTS `t_chatlink`;
CREATE TABLE IF NOT EXISTS `t_chatlink` (
  `ChatLinkID` int(11) NOT NULL AUTO_INCREMENT,
  `ChatID` int(11) NOT NULL,
  `PersonID` int(11) NOT NULL,
  PRIMARY KEY (`ChatLinkID`),
  KEY `t_chat-t_chatlink` (`ChatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_chatmessage`
--

DROP TABLE IF EXISTS `t_chatmessage`;
CREATE TABLE IF NOT EXISTS `t_chatmessage` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `ChatID` int(11) NOT NULL,
  `PersonID` int(11) NOT NULL,
  `CMContent` text,
  `DateSent` datetime DEFAULT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `t_chat-t_chatmessage` (`ChatID`),
  KEY `t_person-t_chatmessage` (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_contract`
--

DROP TABLE IF EXISTS `t_contract`;
CREATE TABLE IF NOT EXISTS `t_contract` (
  `ContractID` int(11) NOT NULL AUTO_INCREMENT,
  `isDoneClient` tinyint(4) NOT NULL,
  `isDoneWorker` tinyint(4) NOT NULL,
  `isDone` tinyint(4) NOT NULL,
  PRIMARY KEY (`ContractID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_job`
--

DROP TABLE IF EXISTS `t_job`;
CREATE TABLE IF NOT EXISTS `t_job` (
  `JobID` int(11) NOT NULL AUTO_INCREMENT,
  `CatID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `ContractID` int(11) NOT NULL,
  PRIMARY KEY (`JobID`),
  KEY `t_contract-t_job` (`CatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

DROP TABLE IF EXISTS `t_menu`;
CREATE TABLE IF NOT EXISTS `t_menu` (
  `MenuID` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(50) NOT NULL,
  PRIMARY KEY (`MenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`MenuID`, `MenuName`) VALUES
(1, 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `t_notifcationtype`
--

DROP TABLE IF EXISTS `t_notifcationtype`;
CREATE TABLE IF NOT EXISTS `t_notifcationtype` (
  `NotTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `NotID` int(11) NOT NULL,
  `NotType` varchar(50) NOT NULL,
  PRIMARY KEY (`NotTypeID`),
  KEY `t_notifacation-t_notificationtype` (`NotID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_notification`
--

DROP TABLE IF EXISTS `t_notification`;
CREATE TABLE IF NOT EXISTS `t_notification` (
  `NotID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  `JobID` int(11) NOT NULL,
  `RecievedDate` datetime NOT NULL,
  PRIMARY KEY (`NotID`),
  KEY `t_job-t_notification` (`JobID`),
  KEY `t_person-t_notification` (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_person`
--

DROP TABLE IF EXISTS `t_person`;
CREATE TABLE IF NOT EXISTS `t_person` (
  `PersonID` int(11) NOT NULL AUTO_INCREMENT,
  `pName` varchar(50) NOT NULL,
  `pSurname` varchar(50) NOT NULL,
  `pAddress` varchar(50) NOT NULL,
  `pPassword` varchar(150) NOT NULL,
  `pEmail` varchar(50) NOT NULL,
  PRIMARY KEY (`PersonID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_person`
--

INSERT INTO `t_person` (`PersonID`, `pName`, `pSurname`, `pAddress`, `pPassword`, `pEmail`) VALUES
(2, 'Samuel', 'James', '304 Forkwood Trl', '$2y$10$hkuzoz1zDWrCcv6ERJ69L.AhjpU2LzRYMpFow2iC.Gg7wPrl/pZoy', 'samueljames.2003@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `t_persontype`
--

DROP TABLE IF EXISTS `t_persontype`;
CREATE TABLE IF NOT EXISTS `t_persontype` (
  `PersTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  PRIMARY KEY (`PersTypeID`),
  KEY `t_person-t_persontype` (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_pivcontract`
--

DROP TABLE IF EXISTS `t_pivcontract`;
CREATE TABLE IF NOT EXISTS `t_pivcontract` (
  `PiCoID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  `ContractID` int(11) NOT NULL,
  PRIMARY KEY (`PiCoID`),
  KEY `t_person-t_pivcontract` (`PersonID`),
  KEY `t_contract-t_pivcontract` (`ContractID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_submenu`
--

DROP TABLE IF EXISTS `t_submenu`;
CREATE TABLE IF NOT EXISTS `t_submenu` (
  `SubMenuD` int(11) NOT NULL AUTO_INCREMENT,
  `MenuID` int(11) NOT NULL,
  `SMName` varchar(50) NOT NULL,
  `SubMenuLink` varchar(50) NOT NULL,
  PRIMARY KEY (`SubMenuD`),
  KEY `t_menu-t_submenu` (`MenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_submenu`
--

INSERT INTO `t_submenu` (`SubMenuD`, `MenuID`, `SMName`, `SubMenuLink`) VALUES
(1, 1, 'Hi', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `t_type`
--

DROP TABLE IF EXISTS `t_type`;
CREATE TABLE IF NOT EXISTS `t_type` (
  `TypeID` int(11) NOT NULL AUTO_INCREMENT,
  `tName` varchar(50) NOT NULL,
  PRIMARY KEY (`TypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_category`
--
ALTER TABLE `t_category`
  ADD CONSTRAINT `t_cat-t_job` FOREIGN KEY (`CatID`) REFERENCES `t_job` (`JobID`);

--
-- Constraints for table `t_chatlink`
--
ALTER TABLE `t_chatlink`
  ADD CONSTRAINT `t_chat-t_chatlink` FOREIGN KEY (`ChatID`) REFERENCES `t_chat` (`ChatID`);

--
-- Constraints for table `t_chatmessage`
--
ALTER TABLE `t_chatmessage`
  ADD CONSTRAINT `t_chat-t_chatmessage` FOREIGN KEY (`ChatID`) REFERENCES `t_chat` (`ChatID`),
  ADD CONSTRAINT `t_person-t_chatmessage` FOREIGN KEY (`PersonID`) REFERENCES `t_person` (`PersonID`);

--
-- Constraints for table `t_job`
--
ALTER TABLE `t_job`
  ADD CONSTRAINT `t_contract-t_job` FOREIGN KEY (`CatID`) REFERENCES `t_contract` (`ContractID`);

--
-- Constraints for table `t_notifcationtype`
--
ALTER TABLE `t_notifcationtype`
  ADD CONSTRAINT `t_notifacation-t_notificationtype` FOREIGN KEY (`NotID`) REFERENCES `t_notification` (`NotID`);

--
-- Constraints for table `t_notification`
--
ALTER TABLE `t_notification`
  ADD CONSTRAINT `t_job-t_notification` FOREIGN KEY (`JobID`) REFERENCES `t_job` (`JobID`),
  ADD CONSTRAINT `t_person-t_notification` FOREIGN KEY (`PersonID`) REFERENCES `t_person` (`PersonID`);

--
-- Constraints for table `t_persontype`
--
ALTER TABLE `t_persontype`
  ADD CONSTRAINT `t_person-t_persontype` FOREIGN KEY (`PersonID`) REFERENCES `t_person` (`PersonID`);

--
-- Constraints for table `t_pivcontract`
--
ALTER TABLE `t_pivcontract`
  ADD CONSTRAINT `t_contract-t_pivcontract` FOREIGN KEY (`ContractID`) REFERENCES `t_contract` (`ContractID`),
  ADD CONSTRAINT `t_person-t_pivcontract` FOREIGN KEY (`PersonID`) REFERENCES `t_person` (`PersonID`);

--
-- Constraints for table `t_submenu`
--
ALTER TABLE `t_submenu`
  ADD CONSTRAINT `t_menu-t_submenu` FOREIGN KEY (`MenuID`) REFERENCES `t_menu` (`MenuID`);

--
-- Constraints for table `t_type`
--
ALTER TABLE `t_type`
  ADD CONSTRAINT `t_persontype-t_type` FOREIGN KEY (`TypeID`) REFERENCES `t_persontype` (`PersTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
