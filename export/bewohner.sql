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
-- Table structure for table `bewohner`
--

DROP TABLE IF EXISTS `bewohner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bewohner`
--

LOCK TABLES `bewohner` WRITE;
/*!40000 ALTER TABLE `bewohner` DISABLE KEYS */;
INSERT INTO `bewohner` VALUES (1,'Edouard','FouchÃ©','1992-11-29',1,2,2,'Maennlich',0),(2,'Daniel','HÃ¼ckstÃ¤dt','1987-08-15',1,1,1,'Maennlich',1),(3,'Abdu','Abdelrhaman','',1,0,3,'Maennlich',0),(4,'Maxim','Lapis','',0,0,0,'Unbekannt',0),(5,'Bao','Ngoc','',0,0,0,'Unbekannt',0),(6,'Aygen','Selcuk','1990-04-07',1,4,0,'Maennlich',0),(7,'Stefan','Maier','1985-09-11',1,2,1,'Maennlich',1),(8,'Felipe','','',0,0,4,'Maennlich',0),(9,'Julia','Stindl','1992-01-17',2,5,1,'Weiblich',1),(10,'Alex','Busch','1991-08-18',1,3,1,'Weiblich',1),(11,'Mathias','Kredler','',0,0,0,'Unbekannt',0),(12,'Martin','Napiwotzky','1986-05-04',2,2,1,'Maennlich',1),(13,'Zrinka','BoÄkaj','',1,4,7,'Weiblich',0),(14,'Matthias','Grabowski','1986-02-26',1,1,1,'Maennlich',1),(15,'Daniel','Rojas','1988-02-17',1,1,1,'Maennlich',1),(16,'Lei','Chen','1992-10-24',1,1,0,'Maennlich',1),(17,'Pushkar','Deshpande','',0,0,0,'Unbekannt',0),(18,'Alexandru','Lesi','1990-07-24',1,2,6,'Maennlich',1),(19,'Xinhu','Liu','1990-05-09',1,2,5,'Maennlich',0);
/*!40000 ALTER TABLE `bewohner` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-11 16:09:23
