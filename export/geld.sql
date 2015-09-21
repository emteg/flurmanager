-- MySQL dump 10.13  Distrib 5.6.14, for Win32 (x86)
--
-- Host: localhost    Database: c4
-- ------------------------------------------------------
-- Server version	5.6.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `geld`
--

DROP TABLE IF EXISTS `geld`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `geld`
--

LOCK TABLES `geld` WRITE;
/*!40000 ALTER TABLE `geld` DISABLE KEYS */;
INSERT INTO `geld` VALUES (1,'Anfangsbetrag','2014-03-16',-8.00,0,1,1),(2,'Anfangsbetrag','2014-03-16',25.98,0,1,2),(3,'Anfangsbetrag','2014-03-17',52.30,0,1,3),(4,'Anfangsbetrag','2014-03-17',0.13,0,1,4),(5,'Anfangsbetrag','2014-03-17',-7.70,0,1,8),(6,'Anfangsbetrag','2014-03-17',0.00,0,1,5),(7,'Anfangsbetrag','2014-03-17',1.60,0,1,6),(8,'Anfangsbetrag','2014-03-17',-5.04,0,1,9),(9,'Anfangsbetrag','2014-03-17',10.26,0,1,7),(10,'Anfangsbetrag','2014-03-17',26.77,0,1,10),(11,'Anfangsbetrag','2014-03-17',3.80,0,1,11),(12,'Anfangsbetrag','2014-03-17',7.14,0,1,12),(13,'Anfangsbetrag','2014-03-17',0.00,0,1,13),(14,'Anfangsbetrag','2014-03-17',-7.30,0,1,14),(15,'Anfangsbetrag','2014-03-17',79.73,0,1,15),(16,'Anfangsbetrag','2014-03-17',8.48,0,1,16),(17,'Anfangsbetrag','2014-03-17',0.00,0,1,17),(18,'Anfangsbetrag','2014-03-17',258.83,1,0,0),(19,'FlureinkÃ¤ufe','2014-03-22',9.11,0,1,14),(20,'Endbetrag','2014-03-23',-0.13,1,1,4),(21,'Fluressen','2014-03-28',-6.83,0,1,14),(22,'Fluressen','2014-03-28',-6.83,0,1,10),(23,'Fluressen','2014-03-28',-3.32,0,1,7),(25,'Fluressen','2014-03-28',20.31,0,1,2),(26,'Flurbeitrag','2014-04-01',-7.70,0,1,8),(66,'Zwiebeln','2014-04-02',1.29,0,1,14),(67,'Zwiebeln','2014-04-02',0.59,0,1,12),(68,'Zwiebeln','2014-04-02',0.89,0,1,10),(69,'Zwiebeln','2014-04-02',0.59,0,1,12),(70,'Zucker','2014-04-02',0.79,0,1,10),(71,'Zwiebeln','2014-04-02',0.59,0,1,12),(72,'Zwiebeln und Knoblauch','2014-04-02',1.20,0,1,2),(73,'Einzahlung','2014-04-06',30.00,1,1,10);
/*!40000 ALTER TABLE `geld` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-11 16:09:24
