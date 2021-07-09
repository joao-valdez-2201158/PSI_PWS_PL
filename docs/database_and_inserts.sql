-- MySQL dump 10.13  Distrib 5.7.31, for Win64 (x86_64)
--
-- Host: localhost    Database: travel_flight_air
-- ------------------------------------------------------
-- Server version	5.7.31

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
-- Table structure for table `airplanes`
--

DROP TABLE IF EXISTS `airplanes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airplanes` (
  `id_airplane` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) DEFAULT NULL,
  `airplanetype` varchar(45) NOT NULL,
  `lotation` int(11) NOT NULL,
  PRIMARY KEY (`id_airplane`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airplanes`
--

LOCK TABLES `airplanes` WRITE;
/*!40000 ALTER TABLE `airplanes` DISABLE KEYS */;
INSERT INTO `airplanes` VALUES (25,'B737','Boeing',400),(26,'A380','Airbus',400);
/*!40000 ALTER TABLE `airplanes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airplanesstopovers`
--

DROP TABLE IF EXISTS `airplanesstopovers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airplanesstopovers` (
  `id_airplanesstopovers` int(11) NOT NULL AUTO_INCREMENT,
  `id_airplane` int(11) NOT NULL,
  `id_stopover` int(11) NOT NULL,
  `passengers_quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_airplanesstopovers`),
  KEY `id_airplane_fk_idx` (`id_airplane`),
  KEY `id_stopover_fk_idx` (`id_stopover`),
  CONSTRAINT `id_airplanesstopovers_airplane_fk` FOREIGN KEY (`id_airplane`) REFERENCES `airplanes` (`id_airplane`),
  CONSTRAINT `id_airplanesstopovers_stopover_fk` FOREIGN KEY (`id_stopover`) REFERENCES `stopovers` (`id_stopover`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airplanesstopovers`
--

LOCK TABLES `airplanesstopovers` WRITE;
/*!40000 ALTER TABLE `airplanesstopovers` DISABLE KEYS */;
INSERT INTO `airplanesstopovers` VALUES (9,25,11,1),(10,25,11,2);
/*!40000 ALTER TABLE `airplanesstopovers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airports`
--

DROP TABLE IF EXISTS `airports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airports` (
  `id_airport` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `localization` varchar(255) NOT NULL,
  `telephone` int(50) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_airport`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airports`
--

LOCK TABLES `airports` WRITE;
/*!40000 ALTER TABLE `airports` DISABLE KEYS */;
INSERT INTO `airports` VALUES (4,'Indra Ghandi','New Deli',545646546,'nd@air.com'),(5,'Ponta Delgada','Acores',54545455,'ac@air.com'),(6,'Sa Carneiro','Porto',456465,'op@air.com'),(7,'Portela','Lisboa',546464,'lis@air.com'),(8,'Washington DC','Washington',545646874,'ws@air.com'),(9,'Algarve','Faro',564654654,'fa@air.com'),(10,'JFK','New York',56456456,'jfk@air.com'),(12,'Bombay Airport','Bombay',23123,'b@air.com');
/*!40000 ALTER TABLE `airports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flights`
--

DROP TABLE IF EXISTS `flights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flights` (
  `id_flight` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `discount` float DEFAULT '0',
  PRIMARY KEY (`id_flight`)
) ENGINE=InnoDB AUTO_INCREMENT=233343 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flights`
--

LOCK TABLES `flights` WRITE;
/*!40000 ALTER TABLE `flights` DISABLE KEYS */;
INSERT INTO `flights` VALUES (233337,1200,0),(233338,1000,0),(233339,50,0),(233340,70,0),(233341,500,0),(233342,2000,0);
/*!40000 ALTER TABLE `flights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stopovers`
--

DROP TABLE IF EXISTS `stopovers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stopovers` (
  `id_stopover` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_departure` date NOT NULL,
  `date_of_arrival` date NOT NULL,
  `hour_of_departure` time NOT NULL,
  `hour_of_arrival` time NOT NULL,
  `distance` float NOT NULL,
  `id_flight` int(45) NOT NULL,
  `id_departure_airport` int(11) NOT NULL,
  `id_destination_airport` int(11) NOT NULL,
  `id_airplane` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` float DEFAULT '0',
  PRIMARY KEY (`id_stopover`),
  KEY `fk_id_flight_idx` (`id_flight`),
  KEY `id_airport_departure_fk_idx` (`id_departure_airport`),
  KEY `id_airport_destination_fk_idx` (`id_destination_airport`),
  KEY `id_airplane_fk_idx` (`id_airplane`),
  CONSTRAINT `id_airplane_fk` FOREIGN KEY (`id_airplane`) REFERENCES `airplanes` (`id_airplane`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_airport_departure_fk` FOREIGN KEY (`id_departure_airport`) REFERENCES `airports` (`id_airport`),
  CONSTRAINT `id_airport_destination_fk` FOREIGN KEY (`id_destination_airport`) REFERENCES `airports` (`id_airport`),
  CONSTRAINT `id_flight_fk` FOREIGN KEY (`id_flight`) REFERENCES `flights` (`id_flight`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stopovers`
--

LOCK TABLES `stopovers` WRITE;
/*!40000 ALTER TABLE `stopovers` DISABLE KEYS */;
INSERT INTO `stopovers` VALUES (11,'2021-06-25','2021-06-26','19:33:00','19:36:00',555555,233337,6,7,25,NULL,0),(12,'2021-06-01','2021-06-02','20:20:00','05:18:00',55555,233338,5,6,25,NULL,0),(13,'2021-06-30','2021-07-01','10:46:00','09:50:00',20000,233339,4,5,25,NULL,0),(14,'2021-07-14','2021-07-15','10:48:00','09:54:00',40000,233340,7,8,25,NULL,0),(15,'2021-06-04','2021-06-05','04:00:00','10:00:00',40000,233337,5,6,25,NULL,0),(16,'2021-06-15','2021-07-16','19:29:00','21:25:00',50000,233339,8,7,26,NULL,0),(17,'2021-07-09','2021-07-09','23:06:00','23:06:00',1200,233341,7,6,25,NULL,0),(18,'2021-07-09','2021-07-09','23:07:00','23:07:00',1200,233337,6,8,26,NULL,0);
/*!40000 ALTER TABLE `stopovers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `price` float NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `check_in` tinyint(4) DEFAULT NULL,
  `check_in_return` tinyint(4) DEFAULT NULL,
  `id_departure_flight` int(11) NOT NULL,
  `id_return_flight` int(11) DEFAULT NULL,
  `discount_value` float DEFAULT '0',
  PRIMARY KEY (`id_ticket`),
  KEY `id_user_fk_idx` (`id_user`),
  KEY `fk_tickets_flights1_idx` (`id_departure_flight`),
  KEY `fk_tickets_flights2_idx` (`id_return_flight`),
  CONSTRAINT `fk_tickets_flights1` FOREIGN KEY (`id_departure_flight`) REFERENCES `flights` (`id_flight`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_flights2` FOREIGN KEY (`id_return_flight`) REFERENCES `flights` (`id_flight`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=396 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (393,15,2400,'2021-06-09','10:00:02',1,1,233337,233338,0),(394,36,1200,'2021-07-05','10:12:43',1,0,233337,NULL,0),(395,36,1200,'2021-07-08','10:12:43',NULL,NULL,233337,NULL,0);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `birthday_date` date NOT NULL,
  `nif` int(45) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `address` varchar(45) NOT NULL,
  `telephone` int(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL,
  `points` int(11) DEFAULT '0',
  `userscol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (15,'Joao P. Valdez','1985-06-26',235497789,'jpvaldez26','68d60f78978061d508a4bfdc351b92f2','Hope Street',969419408,'jpvaldez26@gmail.com','admin',0,NULL),(16,'Check-In Operator','1988-01-20',545465122,'op','11d8c28a64490a987612f2332502467f','Happyness Street',961556457,'op@gmail.com','op',0,NULL),(35,'Marketing Director','1977-07-07',1243,'mark','ea82410c7a9991816b5eeeebe195e20a','3rd Street',963552221,'mark@flight.com','mark',0,NULL),(36,'user','2021-07-01',12312312,'user','ee11cbb19052e40b07aac0ca060c23ee','user',2134,'asd','user',0,NULL),(37,'Flight Manager','1985-02-22',233666444,'gest','6dc7ad42f970b8b3eb2f8641927d00cb','Godfree Street',965448877,'gest@flight.com','gest',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-10  0:05:39
