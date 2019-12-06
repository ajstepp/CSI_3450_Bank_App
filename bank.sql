-- phpMyAdmin SQL Dump
-- version 4.0.9deb1.lucid~ppa.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2019 at 11:20 PM
-- Server version: 5.5.52-0ubuntu0.12.04.1-log
-- PHP Version: 5.3.10-1ubuntu3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajstepp`
--
CREATE DATABASE IF NOT EXISTS `ajstepp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ajstepp`;

-- --------------------------------------------------------

--
-- Table structure for table `ACCOUNTS`
--

CREATE TABLE IF NOT EXISTS `ACCOUNTS` (
  `ACCOUNT_NUMBER` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ACCOUNT_START_DATE` date NOT NULL,
  `CURRENT_BALANCE` double NOT NULL,
  `MEMBERS_MEMBER_ID` int(11) NOT NULL,
  PRIMARY KEY (`ACCOUNT_NUMBER`),
  KEY `fk_ACCOUNTS_MEMBERS1_idx` (`MEMBERS_MEMBER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ACCOUNTS`
--

INSERT INTO `ACCOUNTS` (`ACCOUNT_NUMBER`, `ACCOUNT_START_DATE`, `CURRENT_BALANCE`, `MEMBERS_MEMBER_ID`) VALUES
(3, '2019-10-29', 2382.92, 3),
(8, '2019-11-28', 12435, 2),
(11, '2019-12-03', 4000, 19),
(14, '2019-12-05', 45, 26);

-- --------------------------------------------------------

--
-- Table structure for table `ADDRESSES`
--

CREATE TABLE IF NOT EXISTS `ADDRESSES` (
  `ADDRESS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `STREET_NAME` varchar(45) NOT NULL,
  `HOUSE_NUM` int(11) NOT NULL,
  `ZIP_CODE` int(11) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  PRIMARY KEY (`ADDRESS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ADDRESSES`
--

INSERT INTO `ADDRESSES` (`ADDRESS_ID`, `STREET_NAME`, `HOUSE_NUM`, `ZIP_CODE`, `STATE`) VALUES
(1, 'Chantilly Dr.', 39538, 48313, 'MI'),
(2, 'Bank Dr.', 84328, 48313, 'MI'),
(3, 'Vibes St.', 58392, 48612, 'MI'),
(4, 'Rodson', 49282, 48309, 'AZ'),
(5, 'Hell', 9, 48312, 'MI'),
(6, 'mo', 2, 2, 'mi'),
(7, 'Library Dr', 100, 48309, 'MI'),
(8, 'Heaven St', 1234, 12345, 'CA'),
(9, 'l', 2, 2, 'mi'),
(10, 'testing st', 59100, 48313, 'MI'),
(11, 'movies dr', 0, 0, 'ND');

-- --------------------------------------------------------

--
-- Table structure for table `BANKS`
--

CREATE TABLE IF NOT EXISTS `BANKS` (
  `BANK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ADDRESSES_ADDRESS_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`BANK_ID`),
  KEY `fk_BANKS_ADDRESSES1_idx` (`ADDRESSES_ADDRESS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `BANKS`
--

INSERT INTO `BANKS` (`BANK_ID`, `ADDRESSES_ADDRESS_ID`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `BANK_LOANS`
--

CREATE TABLE IF NOT EXISTS `BANK_LOANS` (
  `BANKS_BANK_ID` int(11) NOT NULL,
  `LOANS_TRANSACTIONS_TRANSACTION_ID` int(11) NOT NULL,
  `LOANS_LOAN_TYPE_LOAN_TYPE_ID` int(11) NOT NULL,
  `BANK_PROJECTED_RETURN` double DEFAULT NULL,
  `MEMBERS_MEMBER_ID` int(11) NOT NULL,
  PRIMARY KEY (`BANKS_BANK_ID`,`LOANS_TRANSACTIONS_TRANSACTION_ID`,`LOANS_LOAN_TYPE_LOAN_TYPE_ID`,`MEMBERS_MEMBER_ID`),
  KEY `fk_BANKS_has_LOANS_LOANS1_idx` (`LOANS_TRANSACTIONS_TRANSACTION_ID`,`LOANS_LOAN_TYPE_LOAN_TYPE_ID`),
  KEY `fk_BANKS_has_LOANS_BANKS1_idx` (`BANKS_BANK_ID`),
  KEY `fk_BANK_LOANS_MEMBERS1_idx` (`MEMBERS_MEMBER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LOANS`
--

CREATE TABLE IF NOT EXISTS `LOANS` (
  `TRANSACTIONS_TRANSACTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CURRENT_BALANCE` double DEFAULT NULL,
  `INTEREST_RATE` double NOT NULL,
  `START_DATE` date NOT NULL,
  `TERM` int(11) NOT NULL,
  `END_DATE` date DEFAULT NULL,
  `LOAN_TYPE_LOAN_TYPE_ID` int(11) NOT NULL,
  PRIMARY KEY (`TRANSACTIONS_TRANSACTION_ID`,`LOAN_TYPE_LOAN_TYPE_ID`),
  KEY `fk_LOANS_LOAN_TYPE1_idx` (`LOAN_TYPE_LOAN_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `LOANS`
--

INSERT INTO `LOANS` (`TRANSACTIONS_TRANSACTION_ID`, `CURRENT_BALANCE`, `INTEREST_RATE`, `START_DATE`, `TERM`, `END_DATE`, `LOAN_TYPE_LOAN_TYPE_ID`) VALUES
(16, NULL, 12, '2019-12-03', 12, NULL, 1),
(22, NULL, 19, '2019-12-06', 12, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `LOAN_TYPE`
--

CREATE TABLE IF NOT EXISTS `LOAN_TYPE` (
  `LOAN_TYPE_ID` int(11) NOT NULL,
  `LOAN_TYPE_DESCRIPTION` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`LOAN_TYPE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LOAN_TYPE`
--

INSERT INTO `LOAN_TYPE` (`LOAN_TYPE_ID`, `LOAN_TYPE_DESCRIPTION`) VALUES
(1, 'Mortgage'),
(2, 'Car');

-- --------------------------------------------------------

--
-- Table structure for table `MEMBERS`
--

CREATE TABLE IF NOT EXISTS `MEMBERS` (
  `MEMBER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MEMBER_FNAME` varchar(45) NOT NULL,
  `MEMBER_LNAME` varchar(45) NOT NULL,
  `MEMBER_PHONE` varchar(20) DEFAULT NULL,
  `MEMBER_DOB` date NOT NULL,
  `ADDRESSES_ADDRESS_ID` int(10) unsigned NOT NULL,
  `BANKS_BANK_ID` int(11) NOT NULL,
  PRIMARY KEY (`MEMBER_ID`),
  UNIQUE KEY `CUSTOMER_ID_UNIQUE` (`MEMBER_ID`),
  KEY `fk_CUSTOMERS_ADDRESSES1_idx` (`ADDRESSES_ADDRESS_ID`),
  KEY `fk_CUSTOMERS_BANKS1_idx` (`BANKS_BANK_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `MEMBERS`
--

INSERT INTO `MEMBERS` (`MEMBER_ID`, `MEMBER_FNAME`, `MEMBER_LNAME`, `MEMBER_PHONE`, `MEMBER_DOB`, `ADDRESSES_ADDRESS_ID`, `BANKS_BANK_ID`) VALUES
(2, 'Braylen', 'Lucas', '(248) 249-1358', '1996-11-02', 4, 1),
(3, 'Bert', 'Guerra', '(586) 587-3423', '1998-10-31', 3, 1),
(18, 'Andrew', 'Stepp', '(586) 524-7668', '1996-09-21', 1, 1),
(19, 'Hunter', 'Glod', '(586) 391-2311', '1998-06-26', 1, 1),
(26, 'James', 'Thisguy', '(586) 999-9999', '1998-07-19', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TRANSACTIONS`
--

CREATE TABLE IF NOT EXISTS `TRANSACTIONS` (
  `TRANSACTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSACTION_AMOUNT` double NOT NULL,
  `TRANSACTION_TIME` timestamp NULL DEFAULT NULL,
  `ACCOUNTS_ACCOUNT_NUMBER` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TRANSACTION_ID`),
  KEY `fk_TRANSACTIONS_ACCOUNTS1_idx` (`ACCOUNTS_ACCOUNT_NUMBER`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `TRANSACTIONS`
--

INSERT INTO `TRANSACTIONS` (`TRANSACTION_ID`, `TRANSACTION_AMOUNT`, `TRANSACTION_TIME`, `ACCOUNTS_ACCOUNT_NUMBER`) VALUES
(10, -50, '2019-12-02 02:53:53', 8),
(11, -43, '2019-12-02 02:54:30', 8),
(12, -300, '2019-12-03 14:35:18', 3),
(13, 10000, '2019-12-03 14:37:42', 11),
(14, -12000, '2019-12-03 14:38:06', 11),
(16, 9000, '2019-12-04 06:19:19', 8),
(17, -15, '2019-12-05 12:15:58', 8),
(18, 2000, '2019-12-05 12:20:09', 8),
(19, 1000, '2019-12-05 14:59:19', 8),
(22, 2600, '2019-12-05 16:02:38', 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ACCOUNTS`
--
ALTER TABLE `ACCOUNTS`
  ADD CONSTRAINT `fk_ACCOUNTS_MEMBERS1` FOREIGN KEY (`MEMBERS_MEMBER_ID`) REFERENCES `MEMBERS` (`MEMBER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `BANKS`
--
ALTER TABLE `BANKS`
  ADD CONSTRAINT `fk_BANKS_ADDRESSES1` FOREIGN KEY (`ADDRESSES_ADDRESS_ID`) REFERENCES `ADDRESSES` (`ADDRESS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `BANK_LOANS`
--
ALTER TABLE `BANK_LOANS`
  ADD CONSTRAINT `fk_BANKS_has_LOANS_BANKS1` FOREIGN KEY (`BANKS_BANK_ID`) REFERENCES `BANKS` (`BANK_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_BANKS_has_LOANS_LOANS1` FOREIGN KEY (`LOANS_TRANSACTIONS_TRANSACTION_ID`, `LOANS_LOAN_TYPE_LOAN_TYPE_ID`) REFERENCES `LOANS` (`TRANSACTIONS_TRANSACTION_ID`, `LOAN_TYPE_LOAN_TYPE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_BANK_LOANS_MEMBERS1` FOREIGN KEY (`MEMBERS_MEMBER_ID`) REFERENCES `MEMBERS` (`MEMBER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LOANS`
--
ALTER TABLE `LOANS`
  ADD CONSTRAINT `fk_LOANS_LOAN_TYPE1` FOREIGN KEY (`LOAN_TYPE_LOAN_TYPE_ID`) REFERENCES `LOAN_TYPE` (`LOAN_TYPE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LOANS_TRANSACTIONS1` FOREIGN KEY (`TRANSACTIONS_TRANSACTION_ID`) REFERENCES `TRANSACTIONS` (`TRANSACTION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `MEMBERS`
--
ALTER TABLE `MEMBERS`
  ADD CONSTRAINT `fk_CUSTOMERS_ADDRESSES1` FOREIGN KEY (`ADDRESSES_ADDRESS_ID`) REFERENCES `ADDRESSES` (`ADDRESS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CUSTOMERS_BANKS1` FOREIGN KEY (`BANKS_BANK_ID`) REFERENCES `BANKS` (`BANK_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `TRANSACTIONS`
--
ALTER TABLE `TRANSACTIONS`
  ADD CONSTRAINT `fk_TRANSACTIONS_ACCOUNTS1` FOREIGN KEY (`ACCOUNTS_ACCOUNT_NUMBER`) REFERENCES `ACCOUNTS` (`ACCOUNT_NUMBER`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
