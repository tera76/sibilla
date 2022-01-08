-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: db    Database: my_andreamatera
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Table structure for table `syb_log`
--

DROP TABLE IF EXISTS `syb_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request` varchar(255) DEFAULT NULL,
  `response` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `syb_log`
--

LOCK TABLES `syb_log` WRITE;
/*!40000 ALTER TABLE `syb_log` DISABLE KEYS */;
INSERT INTO `syb_log` VALUES (97,'[{\"name\":\"login\",\"parameters\":{\"authenticationCode\":\"1976\"}},{\"name\":\"log\"}]','{\"response\":[{\"from\":\"log\",\"values\":{\"message\":\"logged action performed\"}}]}','2020-01-25 04:15:02'),(98,'[{\"name\":\"login\",\"parameters\":{\"authenticationCode\":\"1976\"}},{\"name\":\"test\"},{\"name\":\"log\"}]','{\"response\":[{\"from\":\"test\",\"values\":{\"testActionStatus\":\"true\"}},{\"from\":\"log\",\"values\":{\"message\":\"logged action performed\"}}]}','2020-01-25 04:15:02');
/*!40000 ALTER TABLE `syb_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `syb_test`
--

DROP TABLE IF EXISTS `syb_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syb_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `json_state` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `syb_test`
--

LOCK TABLES `syb_test` WRITE;
/*!40000 ALTER TABLE `syb_test` DISABLE KEYS */;
INSERT INTO `syb_test` VALUES (1,'ddd1'),(2,'ddd2'),(3,'ddd3'),(4,'ddd1'),(5,'ddd2'),(6,'ddd3');
/*!40000 ALTER TABLE `syb_test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-25  5:19:58
