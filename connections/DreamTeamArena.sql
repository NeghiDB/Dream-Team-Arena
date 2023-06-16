-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2023 at 04:05 PM
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
-- Database: `dreamteamarena`
--
CREATE DATABASE IF NOT EXISTS `dreamteamarena` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dreamteamarena`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `AccountsID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `TransactionType` varchar(255) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`AccountsID`),
  KEY `UserID_fk` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `FeedbackID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Text` text NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`FeedbackID`),
  KEY `feedback_fk1` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `MatchID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `HomeTeamID` int(11) DEFAULT NULL,
  `AwayTeamID` int(11) DEFAULT NULL,
  `Result` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MatchID`),
  KEY `matches_fk1` (`HomeTeamID`),
  KEY `matches_fk2` (`AwayTeamID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `PlayerID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Club` varchar(255) NOT NULL,
  `PlayerPoint` varchar(255) NOT NULL DEFAULT '0',
  `Available` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`PlayerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playerperformance`
--

DROP TABLE IF EXISTS `playerperformance`;
CREATE TABLE IF NOT EXISTS `playerperformance` (
  `PlayerPerformanceID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `PlayerID` int(11) NOT NULL,
  `GoalsScored` int(11) NOT NULL DEFAULT '0',
  `Assists` int(11) NOT NULL DEFAULT '0',
  `YellowCards` int(11) NOT NULL DEFAULT '0',
  `RedCards` int(11) NOT NULL DEFAULT '0',
  `CleanSheet` int(11) NOT NULL DEFAULT '0',
  `Minute` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`PlayerPerformanceID`),
  KEY `playerperformance_fk1` (`PlayerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `players`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
`playerid` int(10) unsigned
,`FullName` varchar(511)
,`Position` varchar(255)
,`Club` varchar(255)
,`PlayerPoint` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `TeamID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `TeamName` varchar(255) NOT NULL,
  `OwnerID` int(11) NOT NULL,
  `PlayerID1` int(11) DEFAULT NULL,
  `PlayerID2` int(11) DEFAULT NULL,
  `PlayerID3` int(11) DEFAULT NULL,
  `PlayerID4` int(11) DEFAULT NULL,
  `PlayerID5` int(11) DEFAULT NULL,
  `PlayerID6` int(11) DEFAULT NULL,
  `PlayerID7` int(11) DEFAULT NULL,
  `PlayerID8` int(11) DEFAULT NULL,
  `PlayerID9` int(11) DEFAULT NULL,
  `PlayerID10` int(11) DEFAULT NULL,
  `PlayerID11` int(11) DEFAULT NULL,
  `Points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TeamID`),
  KEY `team_fk1` (`PlayerID1`),
  KEY `team_fk2` (`PlayerID2`),
  KEY `team_fk3` (`PlayerID3`),
  KEY `team_fk4` (`PlayerID4`),
  KEY `team_fk5` (`PlayerID5`),
  KEY `team_fk6` (`PlayerID6`),
  KEY `team_fk7` (`PlayerID7`),
  KEY `team_fk8` (`PlayerID8`),
  KEY `team_fk9` (`PlayerID9`),
  KEY `team_fk10` (`PlayerID10`),
  KEY `team_fk11` (`PlayerID11`),
  KEY `team_fk12` (`OwnerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) NOT NULL,
  `PhoneNumber` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `OTP` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `Password` varchar(255) NOT NULL,
  `Amount` varchar(255) NOT NULL DEFAULT '0',
  `AccountNumber` varchar(255) DEFAULT NULL,
  `BankName` varchar(255) DEFAULT NULL,
  `Win` int(11) NOT NULL DEFAULT '0',
  `Draw` int(11) NOT NULL DEFAULT '0',
  `Loss` int(11) NOT NULL DEFAULT '0',
  `Plays` int(11) DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UniqueUserName` (`UserName`),
  UNIQUE KEY `UniqueEmail` (`Email`),
  UNIQUE KEY `UniquePhoneNumber` (`PhoneNumber`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

DROP TABLE IF EXISTS `withdrawal`;
CREATE TABLE IF NOT EXISTS `withdrawal` (
  `WithdrawalID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `UserID` int(10) UNSIGNED NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sent` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`WithdrawalID`),
  KEY `withdrawal_fk1` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `players`
--
DROP TABLE IF EXISTS `players`;

DROP VIEW IF EXISTS `players`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `players`  AS SELECT `player`.`PlayerID` AS `playerid`, concat(`player`.`LastName`,' ',`player`.`FirstName`) AS `FullName`, `player`.`Position` AS `Position`, `player`.`Club` AS `Club`, `player`.`PlayerPoint` AS `PlayerPoint` FROM `player` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
