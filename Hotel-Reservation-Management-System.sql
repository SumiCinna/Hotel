CREATE DATABASE  IF NOT EXISTS `hotel_reservation_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `hotel_reservation_system`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: hotel_reservation_system
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `audit_log`
--

LOCK TABLES `audit_log` WRITE;
/*!40000 ALTER TABLE `audit_log` DISABLE KEYS */;
INSERT INTO `audit_log` VALUES (1,NULL,'INSERT','users',1,'New user created: admin',NULL,'2025-10-14 08:00:06'),(2,2,'INSERT','users',2,'New user created: Sumi',NULL,'2025-10-14 08:05:33'),(3,2,'INSERT','reservations',1,'New reservation created for room: 1',NULL,'2025-10-14 08:06:35'),(4,2,'INSERT','reservations',2,'New reservation created for room: 3',NULL,'2025-10-14 08:08:23'),(5,5,'INSERT','users',5,'New user created: admin1',NULL,'2025-10-14 08:19:23'),(6,7,'INSERT','users',7,'New user created: Kes',NULL,'2025-10-14 09:02:04'),(7,2,'INSERT','reservations',3,'New reservation created for room: 2',NULL,'2025-10-14 10:05:15'),(8,2,'INSERT','reservations',4,'New reservation created for room: 6',NULL,'2025-10-14 10:33:26'),(9,2,'INSERT','reservations',5,'New reservation created for room: 4',NULL,'2025-10-14 10:33:47'),(10,7,'INSERT','reservations',6,'New reservation created for room: 5',NULL,'2025-10-14 11:13:39'),(11,7,'INSERT','reservations',7,'New reservation created for room: 4',NULL,'2025-10-14 11:27:32'),(12,8,'INSERT','users',8,'New user created: manager1',NULL,'2025-10-14 12:16:40'),(13,9,'INSERT','users',9,'New user created: staff1',NULL,'2025-10-14 12:16:40'),(14,2,'INSERT','reservations',10,'New reservation created for room: 5',NULL,'2025-10-17 07:00:28'),(15,2,'INSERT','reservations',11,'New reservation created for room: 9',NULL,'2025-10-18 16:15:04'),(16,2,'INSERT','reservations',12,'New reservation created for room: 6',NULL,'2025-10-18 16:23:53'),(17,2,'INSERT','reservations',13,'New reservation created for room: 8',NULL,'2025-10-18 16:45:51'),(18,2,'INSERT','reservations',14,'New reservation created for room: 5',NULL,'2025-11-03 16:24:14'),(19,2,'INSERT','reservations',15,'New reservation created for room: 6',NULL,'2025-11-03 16:41:59'),(20,2,'INSERT','reservations',16,'New reservation created for room: 5',NULL,'2025-11-03 17:00:51'),(21,2,'INSERT','reservations',17,'New reservation created for room: 1',NULL,'2025-11-03 17:27:42'),(22,2,'INSERT','reservations',18,'New reservation created for room: 1',NULL,'2025-11-03 17:28:04'),(23,2,'INSERT','reservations',19,'New reservation created for room: 11',NULL,'2025-11-04 16:35:19'),(24,2,'INSERT','reservations',20,'New reservation created for room: 11',NULL,'2025-11-04 16:38:42'),(25,2,'INSERT','reservations',21,'New reservation created for room: 10',NULL,'2025-11-04 16:39:56'),(26,2,'INSERT','reservations',22,'New reservation created for room: 6',NULL,'2025-11-04 16:44:31'),(27,2,'INSERT','reservations',23,'New reservation created for room: 3',NULL,'2025-11-04 16:47:14'),(28,2,'INSERT','reservations',24,'New reservation created for room: 1',NULL,'2025-11-04 18:28:46'),(29,10,'INSERT','users',10,'New user created: Ian',NULL,'2025-11-04 19:07:17'),(30,2,'INSERT','reservations',25,'New reservation created for room: 3',NULL,'2025-11-05 23:50:24'),(31,2,'INSERT','reservations',26,'New reservation created for room: 1',NULL,'2025-11-06 00:01:27'),(32,2,'INSERT','reservations',27,'New reservation created for room: 8',NULL,'2025-11-06 00:27:10'),(33,2,'INSERT','reservations',28,'New reservation created for room: 5',NULL,'2025-11-06 01:00:40'),(34,2,'INSERT','reservations',29,'New reservation created for room: 5',NULL,'2025-11-06 01:00:58'),(35,2,'INSERT','reservations',30,'New reservation created for room: 5',NULL,'2025-11-06 01:01:34'),(36,2,'INSERT','reservations',31,'New reservation created for room: 1',NULL,'2025-11-06 01:30:52');
/*!40000 ALTER TABLE `audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,'Your reservation (ID: 1) has been created successfully. Check-in: 2025-10-16, Check-out: 2025-10-25','booking_confirmation',0,'2025-10-14 08:06:35'),(2,2,'Payment of $13500.00 has been processed successfully for reservation ID: 1','payment',0,'2025-10-14 08:06:42'),(3,2,'Your reservation (ID: 1) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:06:42'),(4,2,'Your reservation (ID: 2) has been created successfully. Check-in: 2025-10-17, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-14 08:08:23'),(5,2,'Payment of $35000.00 has been processed successfully for reservation ID: 2','payment',0,'2025-10-14 08:08:27'),(6,2,'Your reservation (ID: 2) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:08:27'),(7,2,'Your reservation (ID: 2) status has been updated to: pending','general',0,'2025-10-14 08:22:09'),(8,2,'Payment of $35000.00 has been processed successfully for reservation ID: 2','payment',0,'2025-10-14 08:25:53'),(9,2,'Your reservation (ID: 2) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:25:54'),(10,2,'Your reservation (ID: 3) has been created successfully. Check-in: 2025-10-15, Check-out: 2025-10-24','booking_confirmation',0,'2025-10-14 10:05:15'),(11,2,'Payment of $13500.00 has been processed successfully for reservation ID: 3','payment',0,'2025-10-14 10:05:28'),(12,2,'Your reservation (ID: 3) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 10:05:28'),(13,2,'Your reservation (ID: 4) has been created successfully. Check-in: 2025-10-18, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-14 10:33:26'),(14,2,'Your reservation (ID: 5) has been created successfully. Check-in: 2025-10-16, Check-out: 2025-10-24','booking_confirmation',0,'2025-10-14 10:33:47'),(15,7,'Your reservation (ID: 6) has been created successfully. Check-in: 2025-10-14, Check-out: 2025-10-15','booking_confirmation',0,'2025-10-14 11:13:39'),(16,7,'Your reservation (ID: 7) has been created successfully. Check-in: 2025-10-14, Check-out: 2025-10-15','booking_confirmation',0,'2025-10-14 11:27:32'),(17,7,'Payment of $2500.00 has been processed successfully for reservation ID: 7','payment',0,'2025-10-14 11:27:51'),(18,7,'Your reservation (ID: 7) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 11:27:51'),(19,2,'Payment of $20000.00 has been processed successfully for reservation ID: 5','payment',0,'2025-10-14 11:28:16'),(20,2,'Your reservation (ID: 5) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 11:28:16'),(21,7,'Your reservation (ID: 7) status has been updated to: checked_out','general',0,'2025-10-14 11:31:41'),(22,2,'Your reservation (ID: 10) has been created successfully. Check-in: 2025-10-18, Check-out: 2025-10-25','booking_confirmation',0,'2025-10-17 07:00:28'),(23,2,'Your reservation (ID: 10) status has been updated to: confirmed','booking_confirmation',0,'2025-10-17 08:04:35'),(24,2,'Your reservation (ID: 10) status has been updated to: pending','general',0,'2025-10-17 08:04:38'),(25,2,'Your reservation (ID: 10) status has been updated to: cancelled','cancellation',0,'2025-10-17 08:04:51'),(26,2,'Your reservation (ID: 4) status has been updated to: cancelled','cancellation',0,'2025-10-17 08:04:59'),(27,2,'Your reservation (ID: 5) status has been updated to: checked_in','general',0,'2025-10-18 14:57:34'),(28,2,'Your reservation (ID: 5) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 15:03:02'),(29,2,'Your reservation (ID: 5) status has been updated to: checked_in','general',0,'2025-10-18 15:03:06'),(30,2,'Your reservation (ID: 11) has been created successfully. Check-in: 2025-11-14, Check-out: 2025-11-19','booking_confirmation',0,'2025-10-18 16:15:04'),(31,2,'Payment of $7500.00 has been processed successfully for reservation ID: 11','payment',0,'2025-10-18 16:15:14'),(32,2,'Your reservation (ID: 11) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 16:15:15'),(33,2,'Your reservation (ID: 12) has been created successfully. Check-in: 2025-10-20, Check-out: 2025-10-23','booking_confirmation',0,'2025-10-18 16:23:53'),(34,2,'Your reservation (ID: 12) status has been updated to: cancelled','cancellation',0,'2025-10-18 16:24:06'),(35,2,'Your reservation (ID: 13) has been created successfully. Check-in: 2025-10-23, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-18 16:45:51'),(36,2,'Payment of $56000.00 has been processed successfully for reservation ID: 13','payment',0,'2025-10-18 16:45:56'),(37,2,'Your reservation (ID: 13) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 16:45:56'),(38,2,'Your reservation (ID: 14) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-15','booking_confirmation',0,'2025-11-03 16:24:14'),(39,2,'Payment of $40000.00 has been processed successfully for reservation ID: 14','payment',0,'2025-11-03 16:25:17'),(40,2,'Your reservation (ID: 14) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 16:25:17'),(41,2,'Your reservation (ID: 15) has been created successfully. Check-in: 2025-12-04, Check-out: 2025-12-06','booking_confirmation',0,'2025-11-03 16:41:59'),(42,2,'Payment of $6000.00 has been processed successfully for reservation ID: 15','payment',0,'2025-11-03 16:42:08'),(43,2,'Your reservation (ID: 15) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 16:42:08'),(44,2,'Your reservation (ID: 16) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-14','booking_confirmation',0,'2025-11-03 17:00:51'),(45,2,'Payment of $36000.00 has been processed successfully for reservation ID: 16','payment',0,'2025-11-03 17:01:00'),(46,2,'Your reservation (ID: 16) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 17:01:00'),(47,2,'Your reservation (ID: 17) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-03 17:27:42'),(48,2,'Payment of $1500.00 has been processed successfully for reservation ID: 17','payment',0,'2025-11-03 17:27:45'),(49,2,'Your reservation (ID: 17) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 17:27:45'),(50,2,'Your reservation (ID: 18) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-08','booking_confirmation',0,'2025-11-03 17:28:04'),(51,2,'Payment of $1500.00 has been processed successfully for reservation ID: 18','payment',0,'2025-11-04 14:17:28'),(52,2,'Your reservation (ID: 18) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 14:17:28'),(53,2,'Payment of $1500.00 has been processed successfully for reservation ID: 18','payment',0,'2025-11-04 14:18:11'),(54,2,'Your reservation (ID: 19) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-21','booking_confirmation',0,'2025-11-04 16:35:19'),(55,2,'Payment of $49000.00 has been processed successfully for reservation ID: 19','payment',0,'2025-11-04 16:35:30'),(56,2,'Your reservation (ID: 19) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:35:30'),(57,2,'Payment of $49000.00 has been processed successfully for reservation ID: 19','payment',0,'2025-11-04 16:38:17'),(58,2,'Your reservation (ID: 20) has been created successfully. Check-in: 2025-11-22, Check-out: 2025-11-29','booking_confirmation',0,'2025-11-04 16:38:42'),(59,2,'Payment of $24500.00 has been processed successfully for reservation ID: 20','payment',0,'2025-11-04 16:38:46'),(60,2,'Your reservation (ID: 20) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:38:46'),(61,2,'Payment of $24500.00 has been processed successfully for reservation ID: 20','payment',0,'2025-11-04 16:39:44'),(62,2,'Your reservation (ID: 21) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-04 16:39:56'),(63,2,'Payment of $1500.00 has been processed successfully for reservation ID: 21','payment',0,'2025-11-04 16:40:01'),(64,2,'Your reservation (ID: 21) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:40:01'),(65,2,'Payment of $1500.00 has been processed successfully for reservation ID: 21','payment',0,'2025-11-04 16:41:04'),(66,2,'Your reservation (ID: 22) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-04 16:44:31'),(67,2,'Payment of $3000.00 has been processed successfully for reservation ID: 22','payment',0,'2025-11-04 16:44:34'),(68,2,'Your reservation (ID: 22) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:44:34'),(69,2,'Payment of $3000.00 has been processed successfully for reservation ID: 22','payment',0,'2025-11-04 16:46:56'),(70,2,'Your reservation (ID: 23) has been created successfully. Check-in: 2025-11-06, Check-out: 2025-11-13','booking_confirmation',0,'2025-11-04 16:47:14'),(71,2,'Your reservation (ID: 22) status has been updated to: checked_out','general',0,'2025-11-04 17:43:21'),(72,2,'Your reservation (ID: 22) status has been updated to: checked_in','general',0,'2025-11-04 17:43:31'),(73,2,'Your reservation (ID: 24) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-08','booking_confirmation',0,'2025-11-04 18:28:46'),(74,2,'Payment of $1500.00 has been processed successfully for reservation ID: 24','payment',0,'2025-11-04 18:28:54'),(75,2,'Your reservation (ID: 24) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 18:28:54'),(76,2,'Your reservation (ID: 13) status has been updated to: checked_out','general',0,'2025-11-04 19:28:25'),(77,2,'Your reservation (ID: 1) status has been updated to: checked_out','general',0,'2025-11-04 19:28:49'),(78,2,'Your reservation (ID: 12) status has been updated to: checked_out','general',0,'2025-11-04 19:28:53'),(79,2,'Your reservation (ID: 14) status has been updated to: checked_in','general',0,'2025-11-04 19:29:05'),(80,2,'Your reservation (ID: 3) status has been updated to: checked_out','general',0,'2025-11-04 19:29:22'),(81,2,'Your reservation (ID: 17) status has been updated to: checked_in','general',0,'2025-11-04 19:29:28'),(82,2,'Payment of $17502.00 has been processed successfully for reservation ID: 23','payment',0,'2025-11-05 23:40:47'),(83,2,'Your reservation (ID: 23) status has been updated to: pending_approval','general',0,'2025-11-05 23:40:47'),(84,2,'Your reservation (ID: 25) has been created successfully. Check-in: 2025-11-06, Check-out: 2025-11-08','booking_confirmation',0,'2025-11-05 23:50:24'),(85,2,'Your reservation (ID: 23) status has been updated to: confirmed','booking_confirmation',0,'2025-11-05 23:54:40'),(86,2,'Payment of $6000.00 has been processed successfully for reservation ID: 25','payment',0,'2025-11-05 23:56:30'),(87,2,'Your reservation (ID: 25) status has been updated to: pending_approval','general',0,'2025-11-05 23:56:30'),(88,2,'Your reservation (ID: 25) status has been updated to: confirmed','booking_confirmation',0,'2025-11-06 00:00:30'),(89,2,'Your reservation (ID: 26) has been created successfully. Check-in: 2025-11-21, Check-out: 2025-11-29','booking_confirmation',0,'2025-11-06 00:01:27'),(90,2,'Payment of $13000.00 has been processed successfully for reservation ID: 26','payment',0,'2025-11-06 00:01:33'),(91,2,'Your reservation (ID: 26) status has been updated to: pending_approval','general',0,'2025-11-06 00:01:33'),(92,2,'Your reservation (ID: 26) status has been updated to: confirmed','booking_confirmation',0,'2025-11-06 00:01:48'),(93,2,'Your reservation (ID: 27) has been created successfully. Check-in: 2025-11-06, Check-out: 2025-11-07','booking_confirmation',0,'2025-11-06 00:27:10'),(94,2,'Payment of $9000.00 has been processed successfully for reservation ID: 27','payment',0,'2025-11-06 00:29:23'),(95,2,'Your reservation (ID: 27) status has been updated to: pending_approval','general',0,'2025-11-06 00:29:23'),(96,2,'Your reservation (ID: 27) status has been updated to: confirmed','booking_confirmation',0,'2025-11-06 00:45:08'),(97,2,'Your reservation (ID: 17) status has been updated to: checked_out','general',0,'2025-11-06 00:47:53'),(98,2,'Your reservation (ID: 28) has been created successfully. Check-in: 2025-11-15, Check-out: 2025-11-16','booking_confirmation',0,'2025-11-06 01:00:40'),(99,2,'Your reservation (ID: 29) has been created successfully. Check-in: 2025-11-21, Check-out: 2025-11-22','booking_confirmation',0,'2025-11-06 01:00:58'),(100,2,'Your reservation (ID: 29) status has been updated to: cancelled','cancellation',0,'2025-11-06 01:01:04'),(101,2,'Your reservation (ID: 30) has been created successfully. Check-in: 2025-11-21, Check-out: 2025-11-24','booking_confirmation',0,'2025-11-06 01:01:34'),(102,2,'Your reservation (ID: 15) status has been updated to: checked_in','general',0,'2025-11-06 01:10:39'),(103,2,'Your reservation (ID: 27) status has been updated to: checked_in','general',0,'2025-11-06 01:11:04'),(104,2,'Your reservation (ID: 25) status has been updated to: checked_in','general',0,'2025-11-06 01:11:30'),(105,2,'Your reservation (ID: 30) status has been updated to: cancelled','cancellation',0,'2025-11-06 01:12:15'),(106,2,'Your reservation (ID: 24) status has been updated to: checked_out','general',0,'2025-11-06 01:14:25'),(107,2,'Your reservation (ID: 31) has been created successfully. Check-in: 2025-11-14, Check-out: 2025-11-15','booking_confirmation',0,'2025-11-06 01:30:52'),(108,2,'Payment of $2000.00 has been processed successfully for reservation ID: 31','payment',0,'2025-11-06 01:31:03'),(109,2,'Your reservation (ID: 31) status has been updated to: pending_approval','general',0,'2025-11-06 01:31:03'),(110,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:41:12'),(111,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:43:02'),(112,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:43:03'),(113,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:43:07'),(114,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:43:10'),(115,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:44:56'),(116,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:44:58'),(117,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:45:03'),(118,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:45:04'),(119,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:46:51'),(120,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:46:52'),(121,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:46:55'),(122,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:46:59'),(123,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:47:46'),(124,2,'Your reservation (ID: 31) status has been updated to: checked_in','general',0,'2025-11-06 01:47:47'),(125,2,'Your reservation (ID: 31) status has been updated to: pending','general',0,'2025-11-06 01:47:53');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,13500.00,'cash','completed','TXN17604292026563','2025-10-14 08:06:42'),(4,3,13500.00,'cash','completed','TXN17604363288053','2025-10-14 10:05:28'),(5,7,2500.00,'cash','completed','TXN17604412711255','2025-10-14 11:27:51'),(6,5,20000.00,'cash','completed','TXN17604412969013','2025-10-14 11:28:16'),(7,11,7500.00,'cash','completed','TXN17608041143463','2025-10-18 16:15:14'),(8,13,56000.00,'credit_card','completed','TXN17608059565888','2025-10-18 16:45:56'),(9,14,40000.00,'debit_card','completed','TXN17621871177564','2025-11-03 16:25:17'),(10,15,6000.00,'online','completed','TXN17621881287985','2025-11-03 16:42:08'),(12,17,1500.00,'credit_card','completed','TXN17621908658652','2025-11-03 17:27:45'),(17,20,24500.00,'cash','completed','TXN17622743264981','2025-11-04 16:38:46'),(18,20,24500.00,'cash','completed','TXN17622743848782','2025-11-04 16:39:44'),(23,24,1500.00,'debit_card','completed','TXN17622809341026','2025-11-04 18:28:54'),(24,23,17502.00,'cash','completed','TXN17623860475927','2025-11-05 23:40:47'),(25,25,6000.00,'online','completed','TXN17623869903069','2025-11-05 23:56:30'),(26,26,13000.00,'credit_card','completed','TXN17623872933573','2025-11-06 00:01:33'),(27,27,9000.00,'online','completed','TXN17623889639994','2025-11-06 00:29:23'),(28,31,2000.00,'online','completed','TXN17623926634615','2025-11-06 01:31:03');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_after_payment_insert` AFTER INSERT ON `payments` FOR EACH ROW BEGIN
    DECLARE v_user_id INT;
    
    SELECT user_id INTO v_user_id
    FROM reservations
    WHERE reservation_id = NEW.reservation_id;
    
    IF NEW.payment_status = 'completed' THEN
        INSERT INTO notifications (user_id, message, type)
        VALUES (v_user_id,
                CONCAT('Payment of $', NEW.amount, ' has been processed successfully for reservation ID: ', NEW.reservation_id),
                'payment');
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,2,1,'2025-10-16','2025-10-25',13500.00,'checked_out','','2025-10-14 08:06:35','2025-11-04 19:28:49'),(3,2,2,'2025-10-15','2025-10-24',13500.00,'checked_out','','2025-10-14 10:05:15','2025-11-04 19:29:22'),(4,2,6,'2025-10-18','2025-10-31',39000.00,'cancelled','','2025-10-14 10:33:26','2025-10-17 08:04:59'),(5,2,4,'2025-10-16','2025-10-24',20000.00,'checked_in','','2025-10-14 10:33:47','2025-10-18 15:03:06'),(6,7,5,'2025-10-14','2025-10-15',4000.00,'pending','','2025-10-14 11:13:39','2025-10-14 11:13:39'),(7,7,4,'2025-10-14','2025-10-15',2500.00,'checked_out','','2025-10-14 11:27:32','2025-10-14 11:31:41'),(10,2,5,'2025-10-18','2025-10-25',28000.00,'cancelled','','2025-10-17 07:00:28','2025-10-17 08:04:51'),(11,2,9,'2025-11-14','2025-11-19',7500.00,'confirmed','extra towels please','2025-10-18 16:15:04','2025-10-18 16:15:15'),(12,2,6,'2025-10-20','2025-10-23',9000.00,'checked_out','','2025-10-18 16:23:53','2025-11-04 19:28:53'),(13,2,8,'2025-10-23','2025-10-31',56000.00,'checked_out','extra tissues','2025-10-18 16:45:51','2025-11-04 19:28:25'),(14,2,5,'2025-11-05','2025-11-15',40000.00,'checked_in','','2025-11-03 16:24:14','2025-11-04 19:29:05'),(15,2,6,'2025-12-04','2025-12-06',6000.00,'checked_in','','2025-11-03 16:41:59','2025-11-06 01:10:39'),(17,2,1,'2025-11-05','2025-11-06',1500.00,'checked_out','','2025-11-03 17:27:42','2025-11-06 00:47:53'),(20,2,11,'2025-11-22','2025-11-29',24500.00,'confirmed','','2025-11-04 16:38:42','2025-11-04 16:38:46'),(23,2,3,'2025-11-06','2025-11-13',17500.00,'confirmed','','2025-11-04 16:47:14','2025-11-05 23:54:40'),(24,2,1,'2025-11-07','2025-11-08',1500.00,'checked_out','','2025-11-04 18:28:46','2025-11-06 01:14:25'),(25,2,3,'2025-11-06','2025-11-08',5000.00,'checked_in','','2025-11-05 23:50:24','2025-11-06 01:11:30'),(26,2,1,'2025-11-21','2025-11-29',12000.00,'confirmed','','2025-11-06 00:01:27','2025-11-06 00:01:48'),(27,2,8,'2025-11-06','2025-11-07',7000.00,'checked_in','2 waters','2025-11-06 00:27:10','2025-11-06 01:11:04'),(28,2,5,'2025-11-15','2025-11-16',4000.00,'pending','','2025-11-06 01:00:40','2025-11-06 01:00:40'),(29,2,5,'2025-11-21','2025-11-22',4000.00,'cancelled','','2025-11-06 01:00:58','2025-11-06 01:01:04'),(30,2,5,'2025-11-21','2025-11-24',12000.00,'cancelled','','2025-11-06 01:01:34','2025-11-06 01:12:15'),(31,2,1,'2025-11-14','2025-11-15',1500.00,'pending','','2025-11-06 01:30:52','2025-11-06 01:47:53');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_after_reservation_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    INSERT INTO notifications (user_id, message, type)
    VALUES (NEW.user_id, 
            CONCAT('Your reservation (ID: ', NEW.reservation_id, ') has been created successfully. Check-in: ', NEW.check_in_date, ', Check-out: ', NEW.check_out_date),
            'booking_confirmation');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_reservation_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    INSERT INTO audit_log (user_id, action, table_name, record_id, details)
    VALUES (NEW.user_id, 'INSERT', 'reservations', NEW.reservation_id, CONCAT('New reservation created for room: ', NEW.room_id));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_after_reservation_status_update` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO notifications (user_id, message, type)
        VALUES (NEW.user_id,
                CONCAT('Your reservation (ID: ', NEW.reservation_id, ') status has been updated to: ', NEW.status),
                CASE
                    WHEN NEW.status = 'cancelled' THEN 'cancellation'
                    WHEN NEW.status = 'confirmed' THEN 'booking_confirmation'
                    ELSE 'general'
                END);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_update_room_status_on_confirm` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
    IF OLD.status != NEW.status THEN
        IF NEW.status = 'confirmed' THEN
            UPDATE rooms SET status = 'reserved' WHERE room_id = NEW.room_id;
        ELSEIF NEW.status = 'checked_in' THEN
            UPDATE rooms SET status = 'occupied' WHERE room_id = NEW.room_id;
        ELSEIF NEW.status IN ('checked_out', 'cancelled') THEN
            UPDATE rooms SET status = 'available' WHERE room_id = NEW.room_id;
        END IF;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,'Standard','Comfortable room with basic amenities',1500.00,2,NULL,'2025-10-14 08:00:06',0),(2,'Deluxe','Spacious room with premium amenities',2500.00,2,NULL,'2025-10-14 08:00:06',0),(3,'Suite','Luxury suite with separate living area',4000.00,4,NULL,'2025-10-14 08:00:06',0),(4,'Family Room','Large room perfect for families',3000.00,8,NULL,'2025-10-14 08:00:06',0),(5,'Premium','Premium room high costs',7000.00,4,NULL,'2025-10-18 15:00:11',0),(6,'Solo','Beautiful solo room for 1 person',1500.00,1,'uploads/room_types/room_68f3b24bd48b9.jpg','2025-10-18 15:29:15',1),(7,'Twin Room','a single room but comes with two beds',3500.00,4,'uploads/room_types/room_690a25e45ece5.jpg','2025-11-04 16:12:20',1);
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'101',1,1,'occupied','2025-10-14 08:00:06',0),(2,'102',1,1,'maintenance','2025-10-14 08:00:06',0),(3,'201',2,2,'occupied','2025-10-14 08:00:06',0),(4,'202',2,2,'occupied','2025-10-14 08:00:06',0),(5,'301',3,3,'available','2025-10-14 08:00:06',0),(6,'401',4,4,'occupied','2025-10-14 08:00:06',0),(7,'203',2,4,'available','2025-10-14 08:21:34',0),(8,'501',5,5,'occupied','2025-10-18 15:00:38',0),(9,'602',6,6,'available','2025-10-18 15:29:28',1),(10,'304',1,5,'available','2025-11-04 16:10:06',0),(11,'901',7,9,'available','2025-11-04 16:14:03',1),(12,'807',6,9,'available','2025-11-04 18:05:54',1),(13,'109',6,1,'available','2025-11-11 10:15:05',1);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sumi','$2y$10$6o3bnLjNXzztlcMzVtZdtOlDuHf48Q4gGVAfJXyMo74nyIPafIkoK','johnnoelorano@gmail.com','John Noel Orano','09923139504','customer','2025-10-14 08:05:33','2025-12-17 16:13:17',0,'2025-11-11 17:52:48'),(5,'admin1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin1@hotel.com','System Administrator','1234567890','admin','2025-10-14 08:19:23','2025-12-17 16:13:17',0,'2025-11-11 18:59:53'),(7,'Kes','$2y$10$QgTQHKwkY89B5fn38svBfOxOz/TsziGE6/VgObqJA2kSODYunjYqi','almondtofu@gmail.com','Kestrel Macagba','09923139504','staff','2025-10-14 09:02:04','2025-11-04 17:02:40',0,'2025-10-14 17:02:04'),(8,'manager1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','manager@hotel.com','Hotel Manager','1234567891','manager','2025-10-14 12:16:40','2025-12-06 16:13:16',0,'2025-11-06 09:48:47'),(9,'staff1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','staff@hotel.com','Hotel Staff','1234567892','staff','2025-10-14 12:16:40','2025-12-17 16:13:17',0,'2025-11-11 18:59:41'),(10,'Ian','$2y$10$zs73VMQIFQcEBg.Bd7/RSeBi9vGOO6Hq4EI4V.rJcklZC7EgjRune','Ianmatthewbsis2023@gmail.com','Ian Matthew Payawal','09123456789','customer','2025-11-04 19:07:17','2025-12-05 16:13:16',0,'2025-11-05 03:07:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (user_id, action, table_name, record_id, details)
    VALUES (NEW.user_id, 'INSERT', 'users', NEW.user_id, CONCAT('New user created: ', NEW.username));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'hotel_reservation_system'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `auto_deactivate_inactive_users` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `auto_deactivate_inactive_users` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-19 00:13:16' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE users 
SET is_active = 0 
WHERE is_active = 1 
AND last_login IS NOT NULL 
AND last_login < DATE_SUB(NOW(), INTERVAL 1 MONTH) */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'hotel_reservation_system'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_add_room` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_room`(
    IN p_room_number VARCHAR(3),
    IN p_room_type_id INT,
    IN p_floor VARCHAR(3),
    OUT p_result VARCHAR(100)
)
BEGIN
    DECLARE v_count INT;
    
    SELECT COUNT(*) INTO v_count 
    FROM rooms 
    WHERE room_number = p_room_number;
    
    IF v_count > 0 THEN
        SET p_result = 'ERROR:Room number already exists!';
    ELSE
        INSERT INTO rooms (room_number, room_type_id, floor, status, is_archived) 
        VALUES (p_room_number, p_room_type_id, p_floor, 'available', 0);
        SET p_result = 'SUCCESS:Room added successfully!';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_add_room_type` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_room_type`(
    IN p_type_name VARCHAR(20),
    IN p_description VARCHAR(50),
    IN p_base_price DECIMAL(8,2),
    IN p_max_occupancy INT,
    IN p_image_path VARCHAR(255),
    OUT p_result VARCHAR(100)
)
BEGIN
    DECLARE v_count INT;
    
    SELECT COUNT(*) INTO v_count 
    FROM room_types 
    WHERE type_name = p_type_name;
    
    IF v_count > 0 THEN
        SET p_result = 'ERROR:Room type already exists!';
    ELSE
        INSERT INTO room_types (type_name, description, base_price, max_occupancy, image_path, is_archived) 
        VALUES (p_type_name, p_description, p_base_price, p_max_occupancy, p_image_path, 0);
        SET p_result = 'SUCCESS:Room type added successfully!';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_approve_reservation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_approve_reservation`(
    IN p_reservation_id INT,
    OUT p_success BOOLEAN,
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_success = FALSE;
        SET p_message = 'Error approving reservation';
    END;
    
    START TRANSACTION;
    
    -- Check if reservation exists and is pending
    IF NOT EXISTS (SELECT 1 FROM reservations WHERE reservation_id = p_reservation_id) THEN
        SET p_success = FALSE;
        SET p_message = 'Reservation not found';
        ROLLBACK;
    ELSE
        UPDATE reservations 
        SET status = 'confirmed' 
        WHERE reservation_id = p_reservation_id;
        
        COMMIT;
        SET p_success = TRUE;
        SET p_message = 'Reservation approved successfully';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_archive_room` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_archive_room`(
    IN p_room_id INT,
    IN p_is_archived TINYINT,
    OUT p_result VARCHAR(100)
)
BEGIN
    DECLARE v_count INT;
    
    IF p_is_archived = 1 THEN
        SELECT COUNT(*) INTO v_count 
        FROM rooms 
        WHERE room_id = p_room_id 
        AND (status = 'reserved' OR status = 'occupied');
        
        IF v_count > 0 THEN
            SET p_result = 'ERROR:Cannot archive a reserved or occupied room!';
        ELSE
            UPDATE rooms 
            SET is_archived = p_is_archived 
            WHERE room_id = p_room_id;
            SET p_result = 'SUCCESS:Room archived successfully!';
        END IF;
    ELSE
        UPDATE rooms 
        SET is_archived = p_is_archived 
        WHERE room_id = p_room_id;
        SET p_result = 'SUCCESS:Room restored successfully!';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_archive_room_type` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_archive_room_type`(
    IN p_room_type_id INT,
    IN p_is_archived TINYINT,
    OUT p_result VARCHAR(100)
)
BEGIN
    DECLARE v_count INT;
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
        SET p_result = 'ERROR:Error processing room type!';
    END;
    
    IF p_is_archived = 1 THEN
        SELECT COUNT(*) INTO v_count 
        FROM rooms r 
        WHERE r.room_type_id = p_room_type_id 
        AND (r.status = 'reserved' OR r.status = 'occupied') 
        AND r.is_archived = 0;
        
        IF v_count > 0 THEN
            SET p_result = 'ERROR:Cannot archive room type with reserved or occupied rooms!';
        ELSE
            START TRANSACTION;
            
            UPDATE rooms 
            SET is_archived = 1 
            WHERE room_type_id = p_room_type_id 
            AND is_archived = 0;
            
            UPDATE room_types 
            SET is_archived = 1 
            WHERE room_type_id = p_room_type_id;
            
            COMMIT;
            SET p_result = 'SUCCESS:Room type and its rooms archived successfully!';
        END IF;
    ELSE
        START TRANSACTION;
        
        UPDATE room_types 
        SET is_archived = 0 
        WHERE room_type_id = p_room_type_id;
        
        UPDATE rooms 
        SET is_archived = 0 
        WHERE room_type_id = p_room_type_id 
        AND is_archived = 1;
        
        COMMIT;
        SET p_result = 'SUCCESS:Room type and its rooms restored successfully!';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_cancel_reservation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cancel_reservation`(
    IN p_reservation_id INT,
    IN p_user_id INT
)
BEGIN
    UPDATE reservations 
    SET status = 'cancelled' 
    WHERE reservation_id = p_reservation_id 
    AND user_id = p_user_id 
    AND status = 'pending';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_check_date_conflict` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_check_date_conflict`(
    IN p_room_id INT,
    IN p_check_in DATE,
    IN p_check_out DATE
)
BEGIN
    SELECT COUNT(*) as conflict_count
    FROM reservations
    WHERE room_id = p_room_id
    AND status IN ('confirmed', 'checked_in', 'pending')
    AND (
        (p_check_in BETWEEN check_in_date AND DATE_SUB(check_out_date, INTERVAL 1 DAY))
        OR (p_check_out BETWEEN DATE_ADD(check_in_date, INTERVAL 1 DAY) AND check_out_date)
        OR (check_in_date BETWEEN p_check_in AND DATE_SUB(p_check_out, INTERVAL 1 DAY))
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_check_phone_exists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_check_phone_exists`(
    IN p_phone VARCHAR(20)
)
BEGIN
    SELECT user_id, phone
    FROM users
    WHERE phone = p_phone AND phone IS NOT NULL AND phone != '';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_create_notification` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_notification`(
    IN p_user_id INT,
    IN p_message TEXT,
    IN p_type ENUM('booking_confirmation', 'payment', 'reminder', 'cancellation', 'general')
)
BEGIN
    INSERT INTO notifications (user_id, message, type)
    VALUES (p_user_id, p_message, p_type);
    SELECT LAST_INSERT_ID() AS notification_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_create_reservation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_reservation`(
    IN p_user_id INT,
    IN p_room_id INT,
    IN p_check_in DATE,
    IN p_check_out DATE,
    IN p_special_requests TEXT
)
BEGIN
    DECLARE v_base_price DECIMAL(10, 2);
    DECLARE v_total_amount DECIMAL(10, 2);
    DECLARE v_nights INT;
    
    SELECT DATEDIFF(p_check_out, p_check_in) INTO v_nights;
    
    SELECT rt.base_price INTO v_base_price
    FROM rooms r
    JOIN room_types rt ON r.room_type_id = rt.room_type_id
    WHERE r.room_id = p_room_id;
    
    SET v_total_amount = v_base_price * v_nights;
    
    INSERT INTO reservations (user_id, room_id, check_in_date, check_out_date, total_amount, special_requests, status)
    VALUES (p_user_id, p_room_id, p_check_in, p_check_out, v_total_amount, p_special_requests, 'pending');
    
    SELECT LAST_INSERT_ID() AS reservation_id, v_total_amount AS total_amount;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_all_active_rooms` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_active_rooms`()
BEGIN
    SELECT 
        r.room_id,
        r.room_number,
        r.room_type_id,
        r.floor,
        r.status,
        r.is_archived as room_archived,
        rt.type_name,
        rt.description,
        rt.base_price,
        rt.max_occupancy,
        rt.image_path,
        rt.is_archived as type_archived
    FROM rooms r
    INNER JOIN room_types rt ON r.room_type_id = rt.room_type_id
    WHERE r.is_archived = 0 
    AND rt.is_archived = 0 
    AND r.status != 'maintenance';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_all_reservations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_reservations`(
    IN p_status VARCHAR(20)
)
BEGIN
    IF p_status IS NULL OR p_status = 'all' THEN
        SELECT r.reservation_id, u.full_name, u.email, r.check_in_date, r.check_out_date,
               r.total_amount, r.status, rm.room_number, rt.type_name, r.created_at
        FROM reservations r
        JOIN users u ON r.user_id = u.user_id
        JOIN rooms rm ON r.room_id = rm.room_id
        JOIN room_types rt ON rm.room_type_id = rt.room_type_id
        ORDER BY r.created_at DESC;
    ELSE
        SELECT r.reservation_id, u.full_name, u.email, r.check_in_date, r.check_out_date,
               r.total_amount, r.status, rm.room_number, rt.type_name, r.created_at
        FROM reservations r
        JOIN users u ON r.user_id = u.user_id
        JOIN rooms rm ON r.room_id = rm.room_id
        JOIN room_types rt ON rm.room_type_id = rt.room_type_id
        WHERE r.status = p_status
        ORDER BY r.created_at DESC;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_all_rooms_with_availability` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_rooms_with_availability`(
    IN p_room_type_id INT
)
BEGIN
    IF p_room_type_id IS NULL THEN
        SELECT 
            r.room_id,
            r.room_number,
            r.floor,
            r.status,
            rt.room_type_id,
            rt.type_name,
            rt.base_price,
            rt.max_occupancy,
            rt.description
        FROM rooms r
        JOIN room_types rt ON r.room_type_id = rt.room_type_id
        WHERE rt.is_archived = 0
        ORDER BY r.room_number;
    ELSE
        SELECT 
            r.room_id,
            r.room_number,
            r.floor,
            r.status,
            rt.room_type_id,
            rt.type_name,
            rt.base_price,
            rt.max_occupancy,
            rt.description
        FROM rooms r
        JOIN room_types rt ON r.room_type_id = rt.room_type_id
        WHERE rt.is_archived = 0
        AND rt.room_type_id = p_room_type_id
        ORDER BY r.room_number;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_available_rooms` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_available_rooms`(
    IN p_check_in DATE,
    IN p_check_out DATE,
    IN p_room_type_id INT
)
BEGIN
    SELECT r.room_id, r.room_number, rt.type_name, rt.description, rt.base_price, rt.max_occupancy, r.floor
    FROM rooms r
    JOIN room_types rt ON r.room_type_id = rt.room_type_id
    WHERE r.status = 'available'
    AND (p_room_type_id IS NULL OR r.room_type_id = p_room_type_id)
    AND r.room_id NOT IN (
        SELECT room_id FROM reservations
        WHERE status IN ('confirmed', 'checked_in')
        AND (
            (p_check_in BETWEEN check_in_date AND check_out_date)
            OR (p_check_out BETWEEN check_in_date AND check_out_date)
            OR (check_in_date BETWEEN p_check_in AND p_check_out)
        )
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_basic_reservation_info` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_basic_reservation_info`(
    IN p_reservation_id INT
)
BEGIN
    SELECT 
        reservation_id, 
        room_id, 
        status 
    FROM 
        vw_basic_reservation_info
    WHERE 
        reservation_id = p_reservation_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_dashboard_stats` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_dashboard_stats`()
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM rooms WHERE status = 'available') AS available_rooms,
        (SELECT COUNT(*) FROM rooms WHERE status = 'occupied') AS occupied_rooms,
        (SELECT COUNT(*) FROM reservations WHERE status = 'pending') AS pending_reservations,
        (SELECT COUNT(*) FROM reservations WHERE status = 'confirmed') AS confirmed_reservations,
        (SELECT COALESCE(SUM(total_price), 0) FROM reservations WHERE DATE(created_at) = CURDATE()) AS today_revenue,
        (SELECT COALESCE(SUM(total_price), 0) FROM reservations WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) AS month_revenue;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_reservations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservations`(
    IN p_filter VARCHAR(50),
    IN p_search VARCHAR(255),
    IN p_offset INT,
    IN p_per_page INT
)
BEGIN
    SET @query = 'SELECT res.reservation_id, res.room_id, u.full_name, u.phone, u.email, r.room_number, rt.type_name, 
                  res.check_in_date, res.check_out_date, res.total_amount, res.status, res.created_at, res.special_requests 
                  FROM reservations res 
                  JOIN users u ON res.user_id = u.user_id 
                  JOIN rooms r ON res.room_id = r.room_id 
                  JOIN room_types rt ON r.room_type_id = rt.room_type_id 
                  WHERE 1=1';
    
    IF p_filter != 'all' THEN
        SET @query = CONCAT(@query, ' AND res.status = "', p_filter, '"');
    END IF;
    
    IF p_search != '' THEN
        SET @query = CONCAT(@query, ' AND (u.full_name LIKE "%', p_search, '%" OR u.phone LIKE "%', p_search, '%" OR r.room_number LIKE "%', p_search, '%" OR res.reservation_id LIKE "%', p_search, '%")');
    END IF;
    
    SET @query = CONCAT(@query, ' ORDER BY res.created_at DESC LIMIT ', p_offset, ', ', p_per_page);
    
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_reservations_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservations_count`(
    IN p_filter VARCHAR(50),
    IN p_search VARCHAR(255)
)
BEGIN
    SET @query = 'SELECT COUNT(*) as count 
                  FROM reservations res 
                  JOIN users u ON res.user_id = u.user_id 
                  JOIN rooms r ON res.room_id = r.room_id 
                  JOIN room_types rt ON r.room_type_id = rt.room_type_id 
                  WHERE 1=1';
    
    IF p_filter != 'all' THEN
        SET @query = CONCAT(@query, ' AND res.status = "', p_filter, '"');
    END IF;
    
    IF p_search != '' THEN
        SET @query = CONCAT(@query, ' AND (u.full_name LIKE "%', p_search, '%" OR u.phone LIKE "%', p_search, '%" OR r.room_number LIKE "%', p_search, '%" OR res.reservation_id LIKE "%', p_search, '%")');
    END IF;
    
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_reservation_details` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservation_details`(
    IN p_reservation_id INT,
    IN p_user_id INT
)
BEGIN
    SELECT *
    FROM vw_reservation_details
    WHERE reservation_id = p_reservation_id AND user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_room_reservations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_room_reservations`(
    IN p_room_id INT
)
BEGIN
    SELECT check_in_date, check_out_date, status
    FROM reservations
    WHERE room_id = p_room_id
    AND status IN ('confirmed', 'checked_in', 'pending')
    AND check_out_date >= CURDATE()
    ORDER BY check_in_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_room_types` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_room_types`()
BEGIN
    SELECT room_type_id, type_name, description, base_price, max_occupancy, is_archived
    FROM room_types
    ORDER BY type_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_room_type_reservations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_room_type_reservations`(IN p_room_type_id INT)
BEGIN
    SELECT DISTINCT r.check_in_date, r.check_out_date, r.status
    FROM reservations r
    JOIN rooms rm ON r.room_id = rm.room_id
    WHERE rm.room_type_id = p_room_type_id
    AND r.status IN ('pending', 'confirmed', 'checked_in')
    AND r.check_out_date >= CURDATE()
    ORDER BY r.check_in_date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_users` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_users`(
    IN p_search VARCHAR(255),
    IN p_role VARCHAR(50),
    IN p_per_page INT,
    IN p_offset INT
)
BEGIN
    SET @query = 'SELECT user_id, username, email, full_name, phone, role, is_active, created_at FROM users WHERE 1=1';
    
    IF p_search != '' THEN
        SET @query = CONCAT(@query, ' AND (username LIKE "%', p_search, '%" OR email LIKE "%', p_search, '%" OR full_name LIKE "%', p_search, '%" OR phone LIKE "%', p_search, '%")');
    END IF;
    
    IF p_role != '' THEN
        SET @query = CONCAT(@query, ' AND role = "', p_role, '"');
    END IF;
    
    SET @query = CONCAT(@query, ' ORDER BY created_at DESC LIMIT ', p_per_page, ' OFFSET ', p_offset);
    
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_users_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_users_count`(
    IN p_search VARCHAR(255),
    IN p_role VARCHAR(50)
)
BEGIN
    SET @query = 'SELECT COUNT(*) as total FROM users WHERE 1=1';
    
    IF p_search != '' THEN
        SET @query = CONCAT(@query, ' AND (username LIKE "%', p_search, '%" OR email LIKE "%', p_search, '%" OR full_name LIKE "%', p_search, '%" OR phone LIKE "%', p_search, '%")');
    END IF;
    
    IF p_role != '' THEN
        SET @query = CONCAT(@query, ' AND role = "', p_role, '"');
    END IF;
    
    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_by_username` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_by_username`(IN p_username VARCHAR(255))
BEGIN
    SELECT user_id, username, password, email, full_name, phone, role, is_active
    FROM vw_active_users
    WHERE username = p_username;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_details` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_details`(
    IN p_user_id INT
)
BEGIN
    SELECT *
    FROM vw_user_details
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_reservations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_reservations`(
    IN p_user_id INT
)
BEGIN
    SELECT r.reservation_id, r.check_in_date, r.check_out_date, r.total_amount, r.status,
           r.special_requests, rm.room_number, rt.type_name, r.created_at
    FROM reservations r
    JOIN rooms rm ON r.room_id = rm.room_id
    JOIN room_types rt ON rm.room_type_id = rt.room_type_id
    WHERE r.user_id = p_user_id
    ORDER BY r.created_at DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_reservations_paginated` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_reservations_paginated`(
    IN p_user_id INT,
    IN p_limit INT,
    IN p_offset INT
)
BEGIN
    SELECT * 
    FROM vw_user_reservations
    WHERE user_id = p_user_id
    ORDER BY created_at DESC
    LIMIT p_limit OFFSET p_offset;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_reservation_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_reservation_count`(IN p_user_id INT)
BEGIN
    SELECT COUNT(*) as total 
    FROM reservations 
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_payment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_payment`(
    IN p_reservation_id INT,
    IN p_amount DECIMAL(10, 2),
    IN p_payment_method VARCHAR(50),
    IN p_transaction_id VARCHAR(100)
)
BEGIN
    INSERT INTO payments (reservation_id, amount, payment_method, payment_status, transaction_id, payment_date)
    VALUES (p_reservation_id, p_amount, p_payment_method, 'completed', p_transaction_id, NOW());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_mark_notification_read` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mark_notification_read`(
    IN p_notification_id INT
)
BEGIN
    UPDATE notifications
    SET is_read = TRUE
    WHERE notification_id = p_notification_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_process_payment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_process_payment`(
    IN p_reservation_id INT,
    IN p_amount DECIMAL(10, 2),
    IN p_payment_method ENUM('cash', 'credit_card', 'debit_card', 'online'),
    IN p_transaction_id VARCHAR(100)
)
BEGIN
    INSERT INTO payments (reservation_id, amount, payment_method, payment_status, transaction_id)
    VALUES (p_reservation_id, p_amount, p_payment_method, 'completed', p_transaction_id);
    
    UPDATE reservations
    SET status = 'confirmed'
    WHERE reservation_id = p_reservation_id;
    
    SELECT LAST_INSERT_ID() AS payment_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_register_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_register_user`(
    IN p_username VARCHAR(30),
    IN p_password_hash VARCHAR(255),
    IN p_email VARCHAR(100),
    IN p_full_name VARCHAR(60),
    IN p_phone VARCHAR(20),
    IN p_role VARCHAR(20)
)
BEGIN
    DECLARE user_exists INT DEFAULT 0;
    
    SELECT COUNT(*) INTO user_exists
    FROM users
    WHERE username = p_username OR email = p_email;
    
    IF user_exists > 0 THEN
        SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = 'Username or email already exists';
    ELSE
        INSERT INTO users (username, password, email, full_name, phone, role)
        VALUES (p_username, p_password_hash, p_email, p_full_name, p_phone, p_role);
        
        SELECT LAST_INSERT_ID() AS user_id, 'Registration successful' AS message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_last_login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_last_login`(IN p_user_id INT)
BEGIN
    UPDATE users SET last_login = NOW() WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_reservation_status` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_reservation_status`(
    IN p_reservation_id INT,
    IN p_status VARCHAR(50)
)
BEGIN
    UPDATE reservations
    SET status = p_status
    WHERE reservation_id = p_reservation_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_room_status` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_room_status`(
    IN p_room_id INT,
    IN p_status VARCHAR(20),
    OUT p_result VARCHAR(255)
)
BEGIN
    DECLARE room_exists INT;
    DECLARE current_status VARCHAR(20);
    
    -- Check if room exists and get current status
    SELECT COUNT(*) INTO room_exists
    FROM rooms 
    WHERE room_id = p_room_id AND is_archived = 0;
    
    IF room_exists = 0 THEN
        SET p_result = 'ERROR:Room not found or is archived';
    ELSE
        -- Get current status separately
        SELECT status INTO current_status
        FROM rooms 
        WHERE room_id = p_room_id;
        
        IF current_status IN ('reserved', 'occupied') AND p_status = 'maintenance' THEN
            SET p_result = 'ERROR:Cannot set reserved or occupied room to maintenance';
        ELSE
            UPDATE rooms 
            SET status = p_status 
            WHERE room_id = p_room_id;
            
            IF p_status = 'maintenance' THEN
                SET p_result = 'SUCCESS:Room set to maintenance mode';
            ELSEIF p_status = 'available' THEN
                SET p_result = 'SUCCESS:Room set to available';
            ELSE
                SET p_result = CONCAT('SUCCESS:Room status updated to ', p_status);
            END IF;
        END IF;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_user_admin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_user_admin`(
    IN p_user_id INT,
    IN p_role VARCHAR(50),
    IN p_is_active TINYINT
)
BEGIN
    UPDATE users 
    SET role = p_role, 
        is_active = p_is_active 
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-31 12:50:18
