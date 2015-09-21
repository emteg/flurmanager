-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jun 2014 um 16:29
-- Server Version: 5.6.14
-- PHP-Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `c4`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `belegung`
--

CREATE TABLE `belegung` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `BewohnerId` int(11) NOT NULL,
  `Zimmer` smallint(6) NOT NULL,
  `Start` date NOT NULL,
  `Ende` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewohner`
--

CREATE TABLE `bewohner` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Vorname` varchar(30) NOT NULL,
  `Nachname` varchar(30) NOT NULL,
  `Geburtstag` varchar(10) NOT NULL,
  `HochschuleId` int(11) NOT NULL,
  `StudienfachId` int(11) NOT NULL,
  `NationalitaetId` int(11) NOT NULL,
  `Geschlecht` enum('Unbekannt','Maennlich','Weiblich') NOT NULL,
  `IstBildungsInlaender` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Vorname` (`Vorname`,`Nachname`,`Geburtstag`),
  KEY `Vorname_2` (`Vorname`),
  KEY `Nachname` (`Nachname`),
  FULLTEXT KEY `Nachname_2` (`Nachname`),
  FULLTEXT KEY `Vorname_3` (`Vorname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geld`
--

CREATE TABLE `geld` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Betreff` varchar(100) NOT NULL,
  `Datum` varchar(10) NOT NULL,
  `Betrag` decimal(6,2) NOT NULL,
  `IstGeld` tinyint(1) NOT NULL,
  `IstGuthaben` tinyint(1) NOT NULL,
  `BewohnerId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Datum` (`Datum`),
  KEY `BewohnerId` (`BewohnerId`),
  KEY `IstGuthaben` (`IstGuthaben`),
  KEY `IstGeld` (`IstGeld`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hochschule`
--

CREATE TABLE `hochschule` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nationalitaet`
--

CREATE TABLE `nationalitaet` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `studienfach`
--

CREATE TABLE `studienfach` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bewohnerId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `passwort` varchar(100) NOT NULL,
  `istAktiviert` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `bewohnerId` (`bewohnerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
