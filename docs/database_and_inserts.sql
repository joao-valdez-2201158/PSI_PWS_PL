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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airplanes`
--

LOCK TABLES `airplanes` WRITE;
/*!40000 ALTER TABLE `airplanes` DISABLE KEYS */;
INSERT INTO `airplanes` VALUES (25,'B737','Boeing',150),(26,'A380','Airbus',150),(27,'A380','Airbus',150);
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airplanesstopovers`
--

LOCK TABLES `airplanesstopovers` WRITE;
/*!40000 ALTER TABLE `airplanesstopovers` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airports`
--

LOCK TABLES `airports` WRITE;
/*!40000 ALTER TABLE `airports` DISABLE KEYS */;
INSERT INTO `airports` VALUES (4,'Indra Ghandi','New Deli',545646,'nd@air.com'),(5,'Ponta Delgada','Acores',54545455,'ac@air.com'),(6,'Sa Carneiro','Porto',456465,'op@air.com'),(7,'Portela','Lisboa',546464,'lis@air.com'),(8,'Washington DC','Washington',545646874,'ws@air.com'),(9,'Algarve','Faro',564654654,'fa@air.com'),(10,'JFK','New York',56456456,'jfk@air.com'),(12,'Bombay Airport','Bombay',23123,'b@air.com'),(13,'Guarulhos','Sao Paulo',56456343,'g@air.com'),(14,'Barajas ','Madrid',33456543,'ba@air.com'),(15,'DeGaule','Paris',34565543,'pa@air.com'),(16,'Berlim','Berlim',337565543,'be@air.com'),(17,'Roma','Roma',93565543,'beh@air.com'),(18,'Xangai','Xangai',93756553,'beh@air.com'),(19,'Moscovo','Moscovo',93756553,'beh@air.com'),(20,'Praga','Praga',7565543,'beh@air.com'),(21,'Amsterdan','Amsterdan',93756553,'beh@air.com'),(22,'Londres','Londres',9365543,'beh@air.com'),(23,'Cabo Verde','Cabo Verde',937565543,'beh@air.com'),(24,'Cairo','Cairo',9375543,'beh@air.com'),(25,'Tunisia','Tunisia',37565843,'beh@air.com'),(26,'Tokyo','Tokyo',64564565,'tok@gmail.com'),(27,'Casa Blanca','Marrocos',454564,'cb@gmail.com'),(28,'Barcelona','Barcelona',545545,'barcelona@gmail.com'),(29,'Rio de Janeiro','Rio de Janeiro',55454545,'rio@gmail.com'),(30,'Curitiba','Curitiba',54545,'curitiba@gmail.com'),(31,'Manaus','Manaus',1545454,'man@gmail.com'),(33,'Madagascar','Madagascar',34234344,'beh@air.com'),(36,'Malta','Malta',34204344,'beh@air.com'),(39,'Milao','Milao',34234344,'beh@air.com');
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
) ENGINE=InnoDB AUTO_INCREMENT=233364 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flights`
--

LOCK TABLES `flights` WRITE;
/*!40000 ALTER TABLE `flights` DISABLE KEYS */;
INSERT INTO `flights` VALUES (233351,800,10),(233356,300,0),(233357,900,0),(233358,600,0),(233359,800,0),(233360,500,0),(233361,500,0),(233362,500,0),(233363,500,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stopovers`
--

LOCK TABLES `stopovers` WRITE;
/*!40000 ALTER TABLE `stopovers` DISABLE KEYS */;
INSERT INTO `stopovers` VALUES (32,'2021-07-13','2021-07-14','15:45:00','17:45:00',5000,233351,7,10,25,300,0),(33,'2021-07-15','2021-07-16','16:46:00','14:50:00',7000,233351,10,12,26,500,0),(44,'2021-07-14','2021-07-14','15:30:00','16:25:00',300,233356,4,9,25,150,0),(46,'2021-07-15','2021-07-15','19:32:00','21:32:00',500,233356,9,6,26,150,0),(47,'2021-07-14','2021-07-15','15:41:00','15:39:00',50000,233357,8,5,26,600,0),(48,'2021-07-16','2021-07-17','15:42:00','19:38:00',50000,233357,5,13,26,300,0),(49,'2021-07-14','2021-07-14','15:02:00','19:59:00',500,233358,14,15,25,200,0),(50,'2021-07-15','2021-07-15','17:59:00','21:00:00',500,233358,15,16,25,200,0),(51,'2021-07-16','2021-07-16','16:00:00','20:00:00',500,233358,16,17,26,200,0),(52,'2021-07-16','2021-07-17','19:01:00','19:01:00',50000,233359,18,19,26,400,0),(53,'2021-07-17','2021-07-17','20:02:00','20:02:00',20200,233359,19,20,25,300,0),(54,'2021-07-18','2021-07-18','16:04:00','20:03:00',5000,233359,20,21,26,100,0),(55,'2021-07-21','2021-07-21','16:04:00','19:04:00',5000,233360,22,23,25,200,0),(56,'2021-07-22','2021-07-22','18:05:00','22:05:00',5000,233360,23,24,26,200,0),(57,'2021-07-23','2021-07-23','18:05:00','16:09:00',2000,233360,24,25,26,100,0),(58,'2021-07-21','2021-07-22','20:07:00','18:08:00',5000,233361,26,29,26,500,0),(59,'2021-07-15','2021-07-16','19:08:00','16:13:00',50000,233362,27,30,26,500,0),(60,'2021-07-15','2021-07-16','20:09:00','20:09:00',50000,233363,28,31,26,500,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=523 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (16,'JP. Check-In','1988-01-20',545465122,'op','11d8c28a64490a987612f2332502467f','Happyness Street',961556457,'op@gmail.com','op',492,NULL),(44,'Joao P. Valdez','1985-06-26',235497789,'jpvaldez26','68d60f78978061d508a4bfdc351b92f2','Hope Street',969419408,'jpvaldez26@gmail.com','admin',0,NULL),(47,'JP. Marketing','1985-02-06',235497789,'mark','ea82410c7a9991816b5eeeebe195e20a','Third Street',969419408,'mark@gmail.com','mark',0,NULL),(48,'JP. Gest','2021-06-03',235497789,'gest','6dc7ad42f970b8b3eb2f8641927d00cb','Love Street',969419408,'gest@gmail.com','gest',0,NULL),(49,'Ordinary User','1900-07-01',1236549987,'user','ee11cbb19052e40b07aac0ca060c23ee','Under the Bridge',963214569,'user@gmail.com','user',0,NULL);
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

-- Dump completed on 2021-07-12 16:18:01
