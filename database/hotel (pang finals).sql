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
-- Table structure for table `audit_log`
--

DROP TABLE IF EXISTS `audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int DEFAULT NULL,
  `details` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_log`
--

LOCK TABLES `audit_log` WRITE;
/*!40000 ALTER TABLE `audit_log` DISABLE KEYS */;
INSERT INTO `audit_log` VALUES (1,NULL,'INSERT','users',1,'New user created: admin',NULL,'2025-10-14 08:00:06'),(2,2,'INSERT','users',2,'New user created: Sumi',NULL,'2025-10-14 08:05:33'),(3,2,'INSERT','reservations',1,'New reservation created for room: 1',NULL,'2025-10-14 08:06:35'),(4,2,'INSERT','reservations',2,'New reservation created for room: 3',NULL,'2025-10-14 08:08:23'),(5,5,'INSERT','users',5,'New user created: admin1',NULL,'2025-10-14 08:19:23'),(6,7,'INSERT','users',7,'New user created: Kes',NULL,'2025-10-14 09:02:04'),(7,2,'INSERT','reservations',3,'New reservation created for room: 2',NULL,'2025-10-14 10:05:15'),(8,2,'INSERT','reservations',4,'New reservation created for room: 6',NULL,'2025-10-14 10:33:26'),(9,2,'INSERT','reservations',5,'New reservation created for room: 4',NULL,'2025-10-14 10:33:47'),(10,7,'INSERT','reservations',6,'New reservation created for room: 5',NULL,'2025-10-14 11:13:39'),(11,7,'INSERT','reservations',7,'New reservation created for room: 4',NULL,'2025-10-14 11:27:32'),(12,8,'INSERT','users',8,'New user created: manager1',NULL,'2025-10-14 12:16:40'),(13,9,'INSERT','users',9,'New user created: staff1',NULL,'2025-10-14 12:16:40'),(14,2,'INSERT','reservations',10,'New reservation created for room: 5',NULL,'2025-10-17 07:00:28'),(15,2,'INSERT','reservations',11,'New reservation created for room: 9',NULL,'2025-10-18 16:15:04'),(16,2,'INSERT','reservations',12,'New reservation created for room: 6',NULL,'2025-10-18 16:23:53'),(17,2,'INSERT','reservations',13,'New reservation created for room: 8',NULL,'2025-10-18 16:45:51'),(18,2,'INSERT','reservations',14,'New reservation created for room: 5',NULL,'2025-11-03 16:24:14'),(19,2,'INSERT','reservations',15,'New reservation created for room: 6',NULL,'2025-11-03 16:41:59'),(20,2,'INSERT','reservations',16,'New reservation created for room: 5',NULL,'2025-11-03 17:00:51'),(21,2,'INSERT','reservations',17,'New reservation created for room: 1',NULL,'2025-11-03 17:27:42'),(22,2,'INSERT','reservations',18,'New reservation created for room: 1',NULL,'2025-11-03 17:28:04'),(23,2,'INSERT','reservations',19,'New reservation created for room: 11',NULL,'2025-11-04 16:35:19'),(24,2,'INSERT','reservations',20,'New reservation created for room: 11',NULL,'2025-11-04 16:38:42'),(25,2,'INSERT','reservations',21,'New reservation created for room: 10',NULL,'2025-11-04 16:39:56'),(26,2,'INSERT','reservations',22,'New reservation created for room: 6',NULL,'2025-11-04 16:44:31'),(27,2,'INSERT','reservations',23,'New reservation created for room: 3',NULL,'2025-11-04 16:47:14'),(28,2,'INSERT','reservations',24,'New reservation created for room: 1',NULL,'2025-11-04 18:28:46'),(29,10,'INSERT','users',10,'New user created: Ian',NULL,'2025-11-04 19:07:17');
/*!40000 ALTER TABLE `audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `type` enum('booking_confirmation','payment','reminder','cancellation','general') NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,'Your reservation (ID: 1) has been created successfully. Check-in: 2025-10-16, Check-out: 2025-10-25','booking_confirmation',0,'2025-10-14 08:06:35'),(2,2,'Payment of $13500.00 has been processed successfully for reservation ID: 1','payment',0,'2025-10-14 08:06:42'),(3,2,'Your reservation (ID: 1) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:06:42'),(4,2,'Your reservation (ID: 2) has been created successfully. Check-in: 2025-10-17, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-14 08:08:23'),(5,2,'Payment of $35000.00 has been processed successfully for reservation ID: 2','payment',0,'2025-10-14 08:08:27'),(6,2,'Your reservation (ID: 2) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:08:27'),(7,2,'Your reservation (ID: 2) status has been updated to: pending','general',0,'2025-10-14 08:22:09'),(8,2,'Payment of $35000.00 has been processed successfully for reservation ID: 2','payment',0,'2025-10-14 08:25:53'),(9,2,'Your reservation (ID: 2) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 08:25:54'),(10,2,'Your reservation (ID: 3) has been created successfully. Check-in: 2025-10-15, Check-out: 2025-10-24','booking_confirmation',0,'2025-10-14 10:05:15'),(11,2,'Payment of $13500.00 has been processed successfully for reservation ID: 3','payment',0,'2025-10-14 10:05:28'),(12,2,'Your reservation (ID: 3) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 10:05:28'),(13,2,'Your reservation (ID: 4) has been created successfully. Check-in: 2025-10-18, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-14 10:33:26'),(14,2,'Your reservation (ID: 5) has been created successfully. Check-in: 2025-10-16, Check-out: 2025-10-24','booking_confirmation',0,'2025-10-14 10:33:47'),(15,7,'Your reservation (ID: 6) has been created successfully. Check-in: 2025-10-14, Check-out: 2025-10-15','booking_confirmation',0,'2025-10-14 11:13:39'),(16,7,'Your reservation (ID: 7) has been created successfully. Check-in: 2025-10-14, Check-out: 2025-10-15','booking_confirmation',0,'2025-10-14 11:27:32'),(17,7,'Payment of $2500.00 has been processed successfully for reservation ID: 7','payment',0,'2025-10-14 11:27:51'),(18,7,'Your reservation (ID: 7) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 11:27:51'),(19,2,'Payment of $20000.00 has been processed successfully for reservation ID: 5','payment',0,'2025-10-14 11:28:16'),(20,2,'Your reservation (ID: 5) status has been updated to: confirmed','booking_confirmation',0,'2025-10-14 11:28:16'),(21,7,'Your reservation (ID: 7) status has been updated to: checked_out','general',0,'2025-10-14 11:31:41'),(22,2,'Your reservation (ID: 10) has been created successfully. Check-in: 2025-10-18, Check-out: 2025-10-25','booking_confirmation',0,'2025-10-17 07:00:28'),(23,2,'Your reservation (ID: 10) status has been updated to: confirmed','booking_confirmation',0,'2025-10-17 08:04:35'),(24,2,'Your reservation (ID: 10) status has been updated to: pending','general',0,'2025-10-17 08:04:38'),(25,2,'Your reservation (ID: 10) status has been updated to: cancelled','cancellation',0,'2025-10-17 08:04:51'),(26,2,'Your reservation (ID: 4) status has been updated to: cancelled','cancellation',0,'2025-10-17 08:04:59'),(27,2,'Your reservation (ID: 5) status has been updated to: checked_in','general',0,'2025-10-18 14:57:34'),(28,2,'Your reservation (ID: 5) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 15:03:02'),(29,2,'Your reservation (ID: 5) status has been updated to: checked_in','general',0,'2025-10-18 15:03:06'),(30,2,'Your reservation (ID: 11) has been created successfully. Check-in: 2025-11-14, Check-out: 2025-11-19','booking_confirmation',0,'2025-10-18 16:15:04'),(31,2,'Payment of $7500.00 has been processed successfully for reservation ID: 11','payment',0,'2025-10-18 16:15:14'),(32,2,'Your reservation (ID: 11) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 16:15:15'),(33,2,'Your reservation (ID: 12) has been created successfully. Check-in: 2025-10-20, Check-out: 2025-10-23','booking_confirmation',0,'2025-10-18 16:23:53'),(34,2,'Your reservation (ID: 12) status has been updated to: cancelled','cancellation',0,'2025-10-18 16:24:06'),(35,2,'Your reservation (ID: 13) has been created successfully. Check-in: 2025-10-23, Check-out: 2025-10-31','booking_confirmation',0,'2025-10-18 16:45:51'),(36,2,'Payment of $56000.00 has been processed successfully for reservation ID: 13','payment',0,'2025-10-18 16:45:56'),(37,2,'Your reservation (ID: 13) status has been updated to: confirmed','booking_confirmation',0,'2025-10-18 16:45:56'),(38,2,'Your reservation (ID: 14) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-15','booking_confirmation',0,'2025-11-03 16:24:14'),(39,2,'Payment of $40000.00 has been processed successfully for reservation ID: 14','payment',0,'2025-11-03 16:25:17'),(40,2,'Your reservation (ID: 14) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 16:25:17'),(41,2,'Your reservation (ID: 15) has been created successfully. Check-in: 2025-12-04, Check-out: 2025-12-06','booking_confirmation',0,'2025-11-03 16:41:59'),(42,2,'Payment of $6000.00 has been processed successfully for reservation ID: 15','payment',0,'2025-11-03 16:42:08'),(43,2,'Your reservation (ID: 15) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 16:42:08'),(44,2,'Your reservation (ID: 16) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-14','booking_confirmation',0,'2025-11-03 17:00:51'),(45,2,'Payment of $36000.00 has been processed successfully for reservation ID: 16','payment',0,'2025-11-03 17:01:00'),(46,2,'Your reservation (ID: 16) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 17:01:00'),(47,2,'Your reservation (ID: 17) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-03 17:27:42'),(48,2,'Payment of $1500.00 has been processed successfully for reservation ID: 17','payment',0,'2025-11-03 17:27:45'),(49,2,'Your reservation (ID: 17) status has been updated to: confirmed','booking_confirmation',0,'2025-11-03 17:27:45'),(50,2,'Your reservation (ID: 18) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-08','booking_confirmation',0,'2025-11-03 17:28:04'),(51,2,'Payment of $1500.00 has been processed successfully for reservation ID: 18','payment',0,'2025-11-04 14:17:28'),(52,2,'Your reservation (ID: 18) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 14:17:28'),(53,2,'Payment of $1500.00 has been processed successfully for reservation ID: 18','payment',0,'2025-11-04 14:18:11'),(54,2,'Your reservation (ID: 19) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-21','booking_confirmation',0,'2025-11-04 16:35:19'),(55,2,'Payment of $49000.00 has been processed successfully for reservation ID: 19','payment',0,'2025-11-04 16:35:30'),(56,2,'Your reservation (ID: 19) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:35:30'),(57,2,'Payment of $49000.00 has been processed successfully for reservation ID: 19','payment',0,'2025-11-04 16:38:17'),(58,2,'Your reservation (ID: 20) has been created successfully. Check-in: 2025-11-22, Check-out: 2025-11-29','booking_confirmation',0,'2025-11-04 16:38:42'),(59,2,'Payment of $24500.00 has been processed successfully for reservation ID: 20','payment',0,'2025-11-04 16:38:46'),(60,2,'Your reservation (ID: 20) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:38:46'),(61,2,'Payment of $24500.00 has been processed successfully for reservation ID: 20','payment',0,'2025-11-04 16:39:44'),(62,2,'Your reservation (ID: 21) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-04 16:39:56'),(63,2,'Payment of $1500.00 has been processed successfully for reservation ID: 21','payment',0,'2025-11-04 16:40:01'),(64,2,'Your reservation (ID: 21) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:40:01'),(65,2,'Payment of $1500.00 has been processed successfully for reservation ID: 21','payment',0,'2025-11-04 16:41:04'),(66,2,'Your reservation (ID: 22) has been created successfully. Check-in: 2025-11-05, Check-out: 2025-11-06','booking_confirmation',0,'2025-11-04 16:44:31'),(67,2,'Payment of $3000.00 has been processed successfully for reservation ID: 22','payment',0,'2025-11-04 16:44:34'),(68,2,'Your reservation (ID: 22) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 16:44:34'),(69,2,'Payment of $3000.00 has been processed successfully for reservation ID: 22','payment',0,'2025-11-04 16:46:56'),(70,2,'Your reservation (ID: 23) has been created successfully. Check-in: 2025-11-06, Check-out: 2025-11-13','booking_confirmation',0,'2025-11-04 16:47:14'),(71,2,'Your reservation (ID: 22) status has been updated to: checked_out','general',0,'2025-11-04 17:43:21'),(72,2,'Your reservation (ID: 22) status has been updated to: checked_in','general',0,'2025-11-04 17:43:31'),(73,2,'Your reservation (ID: 24) has been created successfully. Check-in: 2025-11-07, Check-out: 2025-11-08','booking_confirmation',0,'2025-11-04 18:28:46'),(74,2,'Payment of $1500.00 has been processed successfully for reservation ID: 24','payment',0,'2025-11-04 18:28:54'),(75,2,'Your reservation (ID: 24) status has been updated to: confirmed','booking_confirmation',0,'2025-11-04 18:28:54'),(76,2,'Your reservation (ID: 13) status has been updated to: checked_out','general',0,'2025-11-04 19:28:25'),(77,2,'Your reservation (ID: 1) status has been updated to: checked_out','general',0,'2025-11-04 19:28:49'),(78,2,'Your reservation (ID: 12) status has been updated to: checked_out','general',0,'2025-11-04 19:28:53'),(79,2,'Your reservation (ID: 14) status has been updated to: checked_in','general',0,'2025-11-04 19:29:05'),(80,2,'Your reservation (ID: 3) status has been updated to: checked_out','general',0,'2025-11-04 19:29:22'),(81,2,'Your reservation (ID: 17) status has been updated to: checked_in','general',0,'2025-11-04 19:29:28');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `reservation_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','credit_card','debit_card','online') NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `reservation_id` (`reservation_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,13500.00,'cash','completed','TXN17604292026563','2025-10-14 08:06:42'),(4,3,13500.00,'cash','completed','TXN17604363288053','2025-10-14 10:05:28'),(5,7,2500.00,'cash','completed','TXN17604412711255','2025-10-14 11:27:51'),(6,5,20000.00,'cash','completed','TXN17604412969013','2025-10-14 11:28:16'),(7,11,7500.00,'cash','completed','TXN17608041143463','2025-10-18 16:15:14'),(8,13,56000.00,'credit_card','completed','TXN17608059565888','2025-10-18 16:45:56'),(9,14,40000.00,'debit_card','completed','TXN17621871177564','2025-11-03 16:25:17'),(10,15,6000.00,'online','completed','TXN17621881287985','2025-11-03 16:42:08'),(12,17,1500.00,'credit_card','completed','TXN17621908658652','2025-11-03 17:27:45'),(17,20,24500.00,'cash','completed','TXN17622743264981','2025-11-04 16:38:46'),(18,20,24500.00,'cash','completed','TXN17622743848782','2025-11-04 16:39:44'),(23,24,1500.00,'debit_card','completed','TXN17622809341026','2025-11-04 18:28:54');
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
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `room_id` int NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') DEFAULT 'pending',
  `special_requests` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservation_id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,2,1,'2025-10-16','2025-10-25',13500.00,'checked_out','','2025-10-14 08:06:35','2025-11-04 19:28:49'),(3,2,2,'2025-10-15','2025-10-24',13500.00,'checked_out','','2025-10-14 10:05:15','2025-11-04 19:29:22'),(4,2,6,'2025-10-18','2025-10-31',39000.00,'cancelled','','2025-10-14 10:33:26','2025-10-17 08:04:59'),(5,2,4,'2025-10-16','2025-10-24',20000.00,'checked_in','','2025-10-14 10:33:47','2025-10-18 15:03:06'),(6,7,5,'2025-10-14','2025-10-15',4000.00,'pending','','2025-10-14 11:13:39','2025-10-14 11:13:39'),(7,7,4,'2025-10-14','2025-10-15',2500.00,'checked_out','','2025-10-14 11:27:32','2025-10-14 11:31:41'),(10,2,5,'2025-10-18','2025-10-25',28000.00,'cancelled','','2025-10-17 07:00:28','2025-10-17 08:04:51'),(11,2,9,'2025-11-14','2025-11-19',7500.00,'confirmed','extra towels please','2025-10-18 16:15:04','2025-10-18 16:15:15'),(12,2,6,'2025-10-20','2025-10-23',9000.00,'checked_out','','2025-10-18 16:23:53','2025-11-04 19:28:53'),(13,2,8,'2025-10-23','2025-10-31',56000.00,'checked_out','extra tissues','2025-10-18 16:45:51','2025-11-04 19:28:25'),(14,2,5,'2025-11-05','2025-11-15',40000.00,'checked_in','','2025-11-03 16:24:14','2025-11-04 19:29:05'),(15,2,6,'2025-12-04','2025-12-06',6000.00,'confirmed','','2025-11-03 16:41:59','2025-11-03 16:42:08'),(17,2,1,'2025-11-05','2025-11-06',1500.00,'checked_in','','2025-11-03 17:27:42','2025-11-04 19:29:28'),(20,2,11,'2025-11-22','2025-11-29',24500.00,'confirmed','','2025-11-04 16:38:42','2025-11-04 16:38:46'),(23,2,3,'2025-11-06','2025-11-13',17500.00,'pending','','2025-11-04 16:47:14','2025-11-04 16:47:14'),(24,2,1,'2025-11-07','2025-11-08',1500.00,'confirmed','','2025-11-04 18:28:46','2025-11-04 18:28:54');
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
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_types` (
  `room_type_id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  `description` text,
  `base_price` decimal(10,2) NOT NULL,
  `max_occupancy` int NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_archived` int DEFAULT '0',
  PRIMARY KEY (`room_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,'Standard','Comfortable room with basic amenities',1500.00,2,NULL,'2025-10-14 08:00:06',0),(2,'Deluxe','Spacious room with premium amenities',2500.00,2,NULL,'2025-10-14 08:00:06',0),(3,'Suite','Luxury suite with separate living area',4000.00,4,NULL,'2025-10-14 08:00:06',0),(4,'Family Room','Large room perfect for families',3000.00,8,NULL,'2025-10-14 08:00:06',0),(5,'Premium','Premium room high costs',7000.00,4,NULL,'2025-10-18 15:00:11',1),(6,'Solo','Beautiful solo room for 1 person',1500.00,1,'uploads/room_types/room_68f3b24bd48b9.jpg','2025-10-18 15:29:15',0),(7,'Twin Room','a single room but comes with two beds',3500.00,4,'uploads/room_types/room_690a25e45ece5.jpg','2025-11-04 16:12:20',0);
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(10) NOT NULL,
  `room_type_id` int NOT NULL,
  `floor` int NOT NULL,
  `status` enum('available','occupied','maintenance','reserved') DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_archived` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `room_number` (`room_number`),
  KEY `room_type_id` (`room_type_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`room_type_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'101',1,1,'occupied','2025-10-14 08:00:06',0),(2,'102',1,1,'available','2025-10-14 08:00:06',0),(3,'201',2,2,'reserved','2025-10-14 08:00:06',0),(4,'202',2,2,'occupied','2025-10-14 08:00:06',0),(5,'301',3,3,'occupied','2025-10-14 08:00:06',0),(6,'401',4,4,'available','2025-10-14 08:00:06',0),(7,'203',2,4,'available','2025-10-14 08:21:34',0),(8,'501',5,5,'available','2025-10-18 15:00:38',1),(9,'602',6,6,'reserved','2025-10-18 15:29:28',0),(10,'304',1,5,'reserved','2025-11-04 16:10:06',0),(11,'901',7,9,'reserved','2025-11-04 16:14:03',0),(12,'807',6,9,'available','2025-11-04 18:05:54',0);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','staff','customer') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sumi','$2y$10$6o3bnLjNXzztlcMzVtZdtOlDuHf48Q4gGVAfJXyMo74nyIPafIkoK','johnnoelorano@gmail.com','John Noel Orano','09923139504','customer','2025-10-14 08:05:33','2025-11-04 18:28:36',1,'2025-11-05 02:28:36'),(5,'admin1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin1@hotel.com','System Administrator','1234567890','admin','2025-10-14 08:19:23','2025-11-04 17:02:24',1,'2025-11-05 01:02:24'),(7,'Kes','$2y$10$QgTQHKwkY89B5fn38svBfOxOz/TsziGE6/VgObqJA2kSODYunjYqi','almondtofu@gmail.com','Kestrel Macagba','09923139504','staff','2025-10-14 09:02:04','2025-11-04 17:02:40',0,'2025-10-14 17:02:04'),(8,'manager1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','manager@hotel.com','Hotel Manager','1234567891','manager','2025-10-14 12:16:40','2025-11-04 19:32:28',1,'2025-11-05 03:32:28'),(9,'staff1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','staff@hotel.com','Hotel Staff','1234567892','staff','2025-10-14 12:16:40','2025-11-04 19:23:53',1,'2025-11-05 03:23:53'),(10,'Ian','$2y$10$zs73VMQIFQcEBg.Bd7/RSeBi9vGOO6Hq4EI4V.rJcklZC7EgjRune','Ianmatthewbsis2023@gmail.com','Ian Matthew Payawal','09123456789','customer','2025-11-04 19:07:17','2025-11-04 19:07:45',1,'2025-11-05 03:07:45');
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
-- Temporary view structure for view `vw_active_room_types`
--

DROP TABLE IF EXISTS `vw_active_room_types`;
/*!50001 DROP VIEW IF EXISTS `vw_active_room_types`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_active_room_types` AS SELECT 
 1 AS `room_type_id`,
 1 AS `type_name`,
 1 AS `description`,
 1 AS `base_price`,
 1 AS `max_occupancy`,
 1 AS `image_path`,
 1 AS `is_archived`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_active_rooms`
--

DROP TABLE IF EXISTS `vw_active_rooms`;
/*!50001 DROP VIEW IF EXISTS `vw_active_rooms`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_active_rooms` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `room_type_id`,
 1 AS `is_archived`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_active_users`
--

DROP TABLE IF EXISTS `vw_active_users`;
/*!50001 DROP VIEW IF EXISTS `vw_active_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_active_users` AS SELECT 
 1 AS `user_id`,
 1 AS `username`,
 1 AS `password`,
 1 AS `email`,
 1 AS `full_name`,
 1 AS `phone`,
 1 AS `role`,
 1 AS `is_active`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_all_room_types`
--

DROP TABLE IF EXISTS `vw_all_room_types`;
/*!50001 DROP VIEW IF EXISTS `vw_all_room_types`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_all_room_types` AS SELECT 
 1 AS `room_type_id`,
 1 AS `type_name`,
 1 AS `description`,
 1 AS `base_price`,
 1 AS `max_occupancy`,
 1 AS `image_path`,
 1 AS `is_archived`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_all_rooms`
--

DROP TABLE IF EXISTS `vw_all_rooms`;
/*!50001 DROP VIEW IF EXISTS `vw_all_rooms`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_all_rooms` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_archived_room_types`
--

DROP TABLE IF EXISTS `vw_archived_room_types`;
/*!50001 DROP VIEW IF EXISTS `vw_archived_room_types`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_archived_room_types` AS SELECT 
 1 AS `room_type_id`,
 1 AS `type_name`,
 1 AS `description`,
 1 AS `base_price`,
 1 AS `max_occupancy`,
 1 AS `image_path`,
 1 AS `is_archived`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_archived_rooms`
--

DROP TABLE IF EXISTS `vw_archived_rooms`;
/*!50001 DROP VIEW IF EXISTS `vw_archived_rooms`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_archived_rooms` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `room_type_id`,
 1 AS `is_archived`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_basic_reservation_info`
--

DROP TABLE IF EXISTS `vw_basic_reservation_info`;
/*!50001 DROP VIEW IF EXISTS `vw_basic_reservation_info`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_basic_reservation_info` AS SELECT 
 1 AS `reservation_id`,
 1 AS `room_id`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_current_occupancy`
--

DROP TABLE IF EXISTS `vw_current_occupancy`;
/*!50001 DROP VIEW IF EXISTS `vw_current_occupancy`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_current_occupancy` AS SELECT 
 1 AS `reservation_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `full_name`,
 1 AS `phone`,
 1 AS `check_in_date`,
 1 AS `check_out_date`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_daily_revenue_report`
--

DROP TABLE IF EXISTS `vw_daily_revenue_report`;
/*!50001 DROP VIEW IF EXISTS `vw_daily_revenue_report`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_daily_revenue_report` AS SELECT 
 1 AS `date`,
 1 AS `bookings`,
 1 AS `revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_dashboard_stats`
--

DROP TABLE IF EXISTS `vw_dashboard_stats`;
/*!50001 DROP VIEW IF EXISTS `vw_dashboard_stats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_dashboard_stats` AS SELECT 
 1 AS `available_rooms`,
 1 AS `occupied_rooms`,
 1 AS `pending_reservations`,
 1 AS `confirmed_reservations`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_month_revenue`
--

DROP TABLE IF EXISTS `vw_month_revenue`;
/*!50001 DROP VIEW IF EXISTS `vw_month_revenue`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_month_revenue` AS SELECT 
 1 AS `revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_monthly_report`
--

DROP TABLE IF EXISTS `vw_monthly_report`;
/*!50001 DROP VIEW IF EXISTS `vw_monthly_report`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_monthly_report` AS SELECT 
 1 AS `month`,
 1 AS `bookings`,
 1 AS `revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_monthly_revenue_report`
--

DROP TABLE IF EXISTS `vw_monthly_revenue_report`;
/*!50001 DROP VIEW IF EXISTS `vw_monthly_revenue_report`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_monthly_revenue_report` AS SELECT 
 1 AS `month`,
 1 AS `bookings`,
 1 AS `revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_occupancy_count`
--

DROP TABLE IF EXISTS `vw_occupancy_count`;
/*!50001 DROP VIEW IF EXISTS `vw_occupancy_count`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_occupancy_count` AS SELECT 
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_paid_reservations`
--

DROP TABLE IF EXISTS `vw_paid_reservations`;
/*!50001 DROP VIEW IF EXISTS `vw_paid_reservations`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_paid_reservations` AS SELECT 
 1 AS `reservation_id`,
 1 AS `full_name`,
 1 AS `email`,
 1 AS `phone`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `check_in_date`,
 1 AS `check_out_date`,
 1 AS `total_amount`,
 1 AS `status`,
 1 AS `special_requests`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_paid_reservations_count`
--

DROP TABLE IF EXISTS `vw_paid_reservations_count`;
/*!50001 DROP VIEW IF EXISTS `vw_paid_reservations_count`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_paid_reservations_count` AS SELECT 
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_payment_method_report`
--

DROP TABLE IF EXISTS `vw_payment_method_report`;
/*!50001 DROP VIEW IF EXISTS `vw_payment_method_report`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_payment_method_report` AS SELECT 
 1 AS `payment_method`,
 1 AS `count`,
 1 AS `total`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_recent_users`
--

DROP TABLE IF EXISTS `vw_recent_users`;
/*!50001 DROP VIEW IF EXISTS `vw_recent_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_recent_users` AS SELECT 
 1 AS `user_id`,
 1 AS `username`,
 1 AS `email`,
 1 AS `full_name`,
 1 AS `phone`,
 1 AS `role`,
 1 AS `is_active`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_reservation_details`
--

DROP TABLE IF EXISTS `vw_reservation_details`;
/*!50001 DROP VIEW IF EXISTS `vw_reservation_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_reservation_details` AS SELECT 
 1 AS `reservation_id`,
 1 AS `user_id`,
 1 AS `room_id`,
 1 AS `check_in_date`,
 1 AS `check_out_date`,
 1 AS `total_amount`,
 1 AS `status`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_room_count`
--

DROP TABLE IF EXISTS `vw_room_count`;
/*!50001 DROP VIEW IF EXISTS `vw_room_count`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_room_count` AS SELECT 
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_room_detail_by_id`
--

DROP TABLE IF EXISTS `vw_room_detail_by_id`;
/*!50001 DROP VIEW IF EXISTS `vw_room_detail_by_id`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_room_detail_by_id` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `price_per_night`,
 1 AS `capacity`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_room_stats`
--

DROP TABLE IF EXISTS `vw_room_stats`;
/*!50001 DROP VIEW IF EXISTS `vw_room_stats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_room_stats` AS SELECT 
 1 AS `available`,
 1 AS `occupied`,
 1 AS `maintenance`,
 1 AS `reserved`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_room_type_revenue_report`
--

DROP TABLE IF EXISTS `vw_room_type_revenue_report`;
/*!50001 DROP VIEW IF EXISTS `vw_room_type_revenue_report`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_room_type_revenue_report` AS SELECT 
 1 AS `type_name`,
 1 AS `total_bookings`,
 1 AS `total_revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_rooms_count`
--

DROP TABLE IF EXISTS `vw_rooms_count`;
/*!50001 DROP VIEW IF EXISTS `vw_rooms_count`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_rooms_count` AS SELECT 
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_available_rooms`
--

DROP TABLE IF EXISTS `vw_staff_available_rooms`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_available_rooms`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_available_rooms` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_latest_reservations`
--

DROP TABLE IF EXISTS `vw_staff_latest_reservations`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_latest_reservations`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_latest_reservations` AS SELECT 
 1 AS `reservation_id`,
 1 AS `full_name`,
 1 AS `phone`,
 1 AS `email`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `check_in_date`,
 1 AS `check_out_date`,
 1 AS `total_amount`,
 1 AS `status`,
 1 AS `special_requests`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_pending_reservations`
--

DROP TABLE IF EXISTS `vw_staff_pending_reservations`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_pending_reservations`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_pending_reservations` AS SELECT 
 1 AS `reservation_id`,
 1 AS `full_name`,
 1 AS `phone`,
 1 AS `email`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `check_in_date`,
 1 AS `check_out_date`,
 1 AS `total_amount`,
 1 AS `status`,
 1 AS `special_requests`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_rooms_all`
--

DROP TABLE IF EXISTS `vw_staff_rooms_all`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_all`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_rooms_all` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `max_occupancy`,
 1 AS `description`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_rooms_available`
--

DROP TABLE IF EXISTS `vw_staff_rooms_available`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_available`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_rooms_available` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `max_occupancy`,
 1 AS `description`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_rooms_maintenance`
--

DROP TABLE IF EXISTS `vw_staff_rooms_maintenance`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_maintenance`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_rooms_maintenance` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `max_occupancy`,
 1 AS `description`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_rooms_occupied`
--

DROP TABLE IF EXISTS `vw_staff_rooms_occupied`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_occupied`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_rooms_occupied` AS SELECT 
 1 AS `room_id`,
 1 AS `room_number`,
 1 AS `type_name`,
 1 AS `base_price`,
 1 AS `floor`,
 1 AS `status`,
 1 AS `max_occupancy`,
 1 AS `description`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_stats`
--

DROP TABLE IF EXISTS `vw_staff_stats`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_stats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_stats` AS SELECT 
 1 AS `available_rooms`,
 1 AS `occupied_rooms`,
 1 AS `pending_reservations`,
 1 AS `today_checkins`,
 1 AS `today_checkouts`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_staff_total_pending_count`
--

DROP TABLE IF EXISTS `vw_staff_total_pending_count`;
/*!50001 DROP VIEW IF EXISTS `vw_staff_total_pending_count`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_staff_total_pending_count` AS SELECT 
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_today_revenue`
--

DROP TABLE IF EXISTS `vw_today_revenue`;
/*!50001 DROP VIEW IF EXISTS `vw_today_revenue`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_today_revenue` AS SELECT 
 1 AS `revenue`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_user_details`
--

DROP TABLE IF EXISTS `vw_user_details`;
/*!50001 DROP VIEW IF EXISTS `vw_user_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_user_details` AS SELECT 
 1 AS `user_id`,
 1 AS `full_name`,
 1 AS `email`,
 1 AS `phone`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_user_notifications`
--

DROP TABLE IF EXISTS `vw_user_notifications`;
/*!50001 DROP VIEW IF EXISTS `vw_user_notifications`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_user_notifications` AS SELECT 
 1 AS `notification_id`,
 1 AS `user_id`,
 1 AS `message`,
 1 AS `is_read`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_user_phone_check`
--

DROP TABLE IF EXISTS `vw_user_phone_check`;
/*!50001 DROP VIEW IF EXISTS `vw_user_phone_check`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_user_phone_check` AS SELECT 
 1 AS `user_id`,
 1 AS `phone`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_user_reservations`
--

DROP TABLE IF EXISTS `vw_user_reservations`;
/*!50001 DROP VIEW IF EXISTS `vw_user_reservations`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_user_reservations` AS SELECT 
 1 AS `reservation_id`,
 1 AS `user_id`,
 1 AS `room_id`,
 1 AS `check_in_date`,
 1 AS `check_out_date`,
 1 AS `total_amount`,
 1 AS `status`,
 1 AS `created_at`,
 1 AS `room_number`,
 1 AS `type_name`*/;
SET character_set_client = @saved_cs_client;

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
    SELECT r.room_id, r.room_number, rt.type_name, rt.description, rt.base_price, rt.max_occupancy, r.floor, r.status
    FROM rooms r
    JOIN room_types rt ON r.room_type_id = rt.room_type_id
    WHERE (p_room_type_id IS NULL OR r.room_type_id = p_room_type_id)
    ORDER BY r.room_number;
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
    IN p_status VARCHAR(50),
    IN p_room_id INT
)
BEGIN
    UPDATE rooms 
    SET status = p_status 
    WHERE room_id = p_room_id;
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

--
-- Final view structure for view `vw_active_room_types`
--

/*!50001 DROP VIEW IF EXISTS `vw_active_room_types`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_active_room_types` AS select `room_types`.`room_type_id` AS `room_type_id`,`room_types`.`type_name` AS `type_name`,`room_types`.`description` AS `description`,`room_types`.`base_price` AS `base_price`,`room_types`.`max_occupancy` AS `max_occupancy`,`room_types`.`image_path` AS `image_path`,`room_types`.`is_archived` AS `is_archived` from `room_types` where (`room_types`.`is_archived` = 0) order by `room_types`.`type_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_active_rooms`
--

/*!50001 DROP VIEW IF EXISTS `vw_active_rooms`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_active_rooms` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`r`.`room_type_id` AS `room_type_id`,`r`.`is_archived` AS `is_archived` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`r`.`is_archived` = 0) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_active_users`
--

/*!50001 DROP VIEW IF EXISTS `vw_active_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_active_users` AS select `users`.`user_id` AS `user_id`,`users`.`username` AS `username`,`users`.`password` AS `password`,`users`.`email` AS `email`,`users`.`full_name` AS `full_name`,`users`.`phone` AS `phone`,`users`.`role` AS `role`,`users`.`is_active` AS `is_active` from `users` where (`users`.`is_active` = true) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_all_room_types`
--

/*!50001 DROP VIEW IF EXISTS `vw_all_room_types`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_all_room_types` AS select `room_types`.`room_type_id` AS `room_type_id`,`room_types`.`type_name` AS `type_name`,`room_types`.`description` AS `description`,`room_types`.`base_price` AS `base_price`,`room_types`.`max_occupancy` AS `max_occupancy`,`room_types`.`image_path` AS `image_path`,`room_types`.`is_archived` AS `is_archived` from `room_types` order by `room_types`.`type_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_all_rooms`
--

/*!50001 DROP VIEW IF EXISTS `vw_all_rooms`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_all_rooms` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_archived_room_types`
--

/*!50001 DROP VIEW IF EXISTS `vw_archived_room_types`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_archived_room_types` AS select `room_types`.`room_type_id` AS `room_type_id`,`room_types`.`type_name` AS `type_name`,`room_types`.`description` AS `description`,`room_types`.`base_price` AS `base_price`,`room_types`.`max_occupancy` AS `max_occupancy`,`room_types`.`image_path` AS `image_path`,`room_types`.`is_archived` AS `is_archived` from `room_types` where (`room_types`.`is_archived` = 1) order by `room_types`.`type_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_archived_rooms`
--

/*!50001 DROP VIEW IF EXISTS `vw_archived_rooms`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_archived_rooms` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`r`.`room_type_id` AS `room_type_id`,`r`.`is_archived` AS `is_archived` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`r`.`is_archived` = 1) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_basic_reservation_info`
--

/*!50001 DROP VIEW IF EXISTS `vw_basic_reservation_info`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_basic_reservation_info` AS select `reservations`.`reservation_id` AS `reservation_id`,`reservations`.`room_id` AS `room_id`,`reservations`.`status` AS `status` from `reservations` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_current_occupancy`
--

/*!50001 DROP VIEW IF EXISTS `vw_current_occupancy`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_current_occupancy` AS select `res`.`reservation_id` AS `reservation_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`u`.`full_name` AS `full_name`,`u`.`phone` AS `phone`,`res`.`check_in_date` AS `check_in_date`,`res`.`check_out_date` AS `check_out_date` from (((`reservations` `res` join `rooms` `r` on((`res`.`room_id` = `r`.`room_id`))) join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) join `users` `u` on((`res`.`user_id` = `u`.`user_id`))) where ((`res`.`status` = 'checked_in') or ((`res`.`status` = 'confirmed') and (`r`.`status` = 'reserved'))) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_daily_revenue_report`
--

/*!50001 DROP VIEW IF EXISTS `vw_daily_revenue_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_daily_revenue_report` AS select cast(`p`.`payment_date` as date) AS `date`,count(distinct `p`.`reservation_id`) AS `bookings`,sum(`p`.`amount`) AS `revenue` from `payments` `p` where ((`p`.`payment_status` = 'completed') and (`p`.`payment_date` >= (curdate() - interval 30 day))) group by cast(`p`.`payment_date` as date) order by `date` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_dashboard_stats`
--

/*!50001 DROP VIEW IF EXISTS `vw_dashboard_stats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_dashboard_stats` AS select (select count(0) from `rooms` where (`rooms`.`status` = 'available')) AS `available_rooms`,(select count(0) from `rooms` where (`rooms`.`status` = 'occupied')) AS `occupied_rooms`,(select count(0) from `reservations` where (`reservations`.`status` = 'pending')) AS `pending_reservations`,(select count(0) from `reservations` where (`reservations`.`status` = 'confirmed')) AS `confirmed_reservations` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_month_revenue`
--

/*!50001 DROP VIEW IF EXISTS `vw_month_revenue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_month_revenue` AS select coalesce(sum(`p`.`amount`),0) AS `revenue` from `payments` `p` where ((month(`p`.`payment_date`) = month(curdate())) and (year(`p`.`payment_date`) = year(curdate())) and (`p`.`payment_status` = 'completed')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_monthly_report`
--

/*!50001 DROP VIEW IF EXISTS `vw_monthly_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_monthly_report` AS select date_format(`p`.`payment_date`,'%Y-%m') AS `month`,count(distinct `p`.`reservation_id`) AS `bookings`,sum(`p`.`amount`) AS `revenue` from `payments` `p` where ((`p`.`payment_date` >= (curdate() - interval 6 month)) and (`p`.`payment_status` = 'completed')) group by date_format(`p`.`payment_date`,'%Y-%m') order by `month` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_monthly_revenue_report`
--

/*!50001 DROP VIEW IF EXISTS `vw_monthly_revenue_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_monthly_revenue_report` AS select date_format(`p`.`payment_date`,'%Y-%m') AS `month`,count(distinct `p`.`reservation_id`) AS `bookings`,sum(`p`.`amount`) AS `revenue` from `payments` `p` where ((`p`.`payment_status` = 'completed') and (`p`.`payment_date` >= (curdate() - interval 12 month))) group by date_format(`p`.`payment_date`,'%Y-%m') order by `month` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_occupancy_count`
--

/*!50001 DROP VIEW IF EXISTS `vw_occupancy_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_occupancy_count` AS select count(0) AS `count` from `reservations` `res` where ((`res`.`status` = 'checked_in') or ((`res`.`status` = 'confirmed') and exists(select 1 from `rooms` `r` where ((`r`.`room_id` = `res`.`room_id`) and (`r`.`status` = 'reserved'))))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_paid_reservations`
--

/*!50001 DROP VIEW IF EXISTS `vw_paid_reservations`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_paid_reservations` AS select `res`.`reservation_id` AS `reservation_id`,`u`.`full_name` AS `full_name`,`u`.`email` AS `email`,`u`.`phone` AS `phone`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`res`.`check_in_date` AS `check_in_date`,`res`.`check_out_date` AS `check_out_date`,`res`.`total_amount` AS `total_amount`,`res`.`status` AS `status`,`res`.`special_requests` AS `special_requests`,`res`.`created_at` AS `created_at` from ((((`reservations` `res` join `users` `u` on((`res`.`user_id` = `u`.`user_id`))) join `rooms` `r` on((`res`.`room_id` = `r`.`room_id`))) join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) join `payments` `p` on((`res`.`reservation_id` = `p`.`reservation_id`))) where (`p`.`payment_status` = 'completed') order by `res`.`created_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_paid_reservations_count`
--

/*!50001 DROP VIEW IF EXISTS `vw_paid_reservations_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_paid_reservations_count` AS select count(distinct `res`.`reservation_id`) AS `count` from (`reservations` `res` join `payments` `p` on((`res`.`reservation_id` = `p`.`reservation_id`))) where (`p`.`payment_status` = 'completed') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_payment_method_report`
--

/*!50001 DROP VIEW IF EXISTS `vw_payment_method_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_payment_method_report` AS select `payments`.`payment_method` AS `payment_method`,count(0) AS `count`,sum(`payments`.`amount`) AS `total` from `payments` where (`payments`.`payment_status` = 'completed') group by `payments`.`payment_method` order by `total` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_recent_users`
--

/*!50001 DROP VIEW IF EXISTS `vw_recent_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_recent_users` AS select `users`.`user_id` AS `user_id`,`users`.`username` AS `username`,`users`.`email` AS `email`,`users`.`full_name` AS `full_name`,`users`.`phone` AS `phone`,`users`.`role` AS `role`,`users`.`is_active` AS `is_active`,`users`.`created_at` AS `created_at` from `users` order by `users`.`created_at` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_reservation_details`
--

/*!50001 DROP VIEW IF EXISTS `vw_reservation_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_reservation_details` AS select `r`.`reservation_id` AS `reservation_id`,`r`.`user_id` AS `user_id`,`r`.`room_id` AS `room_id`,`r`.`check_in_date` AS `check_in_date`,`r`.`check_out_date` AS `check_out_date`,`r`.`total_amount` AS `total_amount`,`r`.`status` AS `status`,`rm`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price` from ((`reservations` `r` join `rooms` `rm` on((`r`.`room_id` = `rm`.`room_id`))) join `room_types` `rt` on((`rm`.`room_type_id` = `rt`.`room_type_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_room_count`
--

/*!50001 DROP VIEW IF EXISTS `vw_room_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_room_count` AS select count(0) AS `count` from `rooms` where (`rooms`.`is_archived` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_room_detail_by_id`
--

/*!50001 DROP VIEW IF EXISTS `vw_room_detail_by_id`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_room_detail_by_id` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`rt`.`base_price` AS `price_per_night`,`rt`.`max_occupancy` AS `capacity` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_room_stats`
--

/*!50001 DROP VIEW IF EXISTS `vw_room_stats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_room_stats` AS select (select count(0) from `rooms` where (`rooms`.`status` = 'available')) AS `available`,(select count(0) from `rooms` where (`rooms`.`status` = 'occupied')) AS `occupied`,(select count(0) from `rooms` where (`rooms`.`status` = 'maintenance')) AS `maintenance`,(select count(0) from `rooms` where (`rooms`.`status` = 'reserved')) AS `reserved` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_room_type_revenue_report`
--

/*!50001 DROP VIEW IF EXISTS `vw_room_type_revenue_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_room_type_revenue_report` AS select `rt`.`type_name` AS `type_name`,count(`res`.`reservation_id`) AS `total_bookings`,sum(`res`.`total_amount`) AS `total_revenue` from ((`reservations` `res` join `rooms` `r` on((`res`.`room_id` = `r`.`room_id`))) join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`res`.`status` <> 'cancelled') group by `rt`.`type_name` order by `total_revenue` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_rooms_count`
--

/*!50001 DROP VIEW IF EXISTS `vw_rooms_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_rooms_count` AS select count(0) AS `count` from `rooms` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_available_rooms`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_available_rooms`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_available_rooms` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where ((`r`.`status` = 'available') and (`r`.`is_archived` = 0) and (`rt`.`is_archived` = 0)) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_latest_reservations`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_latest_reservations`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_latest_reservations` AS select `res`.`reservation_id` AS `reservation_id`,`u`.`full_name` AS `full_name`,`u`.`phone` AS `phone`,`u`.`email` AS `email`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`res`.`check_in_date` AS `check_in_date`,`res`.`check_out_date` AS `check_out_date`,`res`.`total_amount` AS `total_amount`,`res`.`status` AS `status`,`res`.`special_requests` AS `special_requests` from (((`reservations` `res` join `users` `u` on((`res`.`user_id` = `u`.`user_id`))) join `rooms` `r` on((`res`.`room_id` = `r`.`room_id`))) join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) order by `res`.`created_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_pending_reservations`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_pending_reservations`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_pending_reservations` AS select `res`.`reservation_id` AS `reservation_id`,`u`.`full_name` AS `full_name`,`u`.`phone` AS `phone`,`u`.`email` AS `email`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`res`.`check_in_date` AS `check_in_date`,`res`.`check_out_date` AS `check_out_date`,`res`.`total_amount` AS `total_amount`,`res`.`status` AS `status`,`res`.`special_requests` AS `special_requests` from (((`reservations` `res` join `users` `u` on((`res`.`user_id` = `u`.`user_id`))) join `rooms` `r` on((`res`.`room_id` = `r`.`room_id`))) join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where ((`res`.`status` = 'pending') or (`res`.`status` = 'confirmed')) order by `res`.`check_in_date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_rooms_all`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_rooms_all` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`rt`.`max_occupancy` AS `max_occupancy`,`rt`.`description` AS `description` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_rooms_available`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_available`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_rooms_available` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`rt`.`max_occupancy` AS `max_occupancy`,`rt`.`description` AS `description` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`r`.`status` = 'available') order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_rooms_maintenance`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_maintenance`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_rooms_maintenance` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`rt`.`max_occupancy` AS `max_occupancy`,`rt`.`description` AS `description` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`r`.`status` = 'maintenance') order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_rooms_occupied`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_rooms_occupied`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_rooms_occupied` AS select `r`.`room_id` AS `room_id`,`r`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name`,`rt`.`base_price` AS `base_price`,`r`.`floor` AS `floor`,`r`.`status` AS `status`,`rt`.`max_occupancy` AS `max_occupancy`,`rt`.`description` AS `description` from (`rooms` `r` join `room_types` `rt` on((`r`.`room_type_id` = `rt`.`room_type_id`))) where (`r`.`status` = 'occupied') order by `r`.`room_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_stats`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_stats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_stats` AS select (select count(0) from `rooms` where ((`rooms`.`status` = 'available') and (`rooms`.`is_archived` = 0))) AS `available_rooms`,(select count(0) from `rooms` where (`rooms`.`status` = 'occupied')) AS `occupied_rooms`,(select count(0) from `reservations` where (`reservations`.`status` = 'pending')) AS `pending_reservations`,(select count(0) from `reservations` where (cast(`reservations`.`check_in_date` as date) = curdate())) AS `today_checkins`,(select count(0) from `reservations` where (cast(`reservations`.`check_out_date` as date) = curdate())) AS `today_checkouts` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_staff_total_pending_count`
--

/*!50001 DROP VIEW IF EXISTS `vw_staff_total_pending_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_staff_total_pending_count` AS select count(0) AS `count` from `reservations` where ((`reservations`.`status` = 'pending') or (`reservations`.`status` = 'confirmed')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_today_revenue`
--

/*!50001 DROP VIEW IF EXISTS `vw_today_revenue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_today_revenue` AS select coalesce(sum(`p`.`amount`),0) AS `revenue` from `payments` `p` where ((cast(`p`.`payment_date` as date) = curdate()) and (`p`.`payment_status` = 'completed')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_user_details`
--

/*!50001 DROP VIEW IF EXISTS `vw_user_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_user_details` AS select `users`.`user_id` AS `user_id`,`users`.`full_name` AS `full_name`,`users`.`email` AS `email`,`users`.`phone` AS `phone` from `users` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_user_notifications`
--

/*!50001 DROP VIEW IF EXISTS `vw_user_notifications`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_user_notifications` AS select `notifications`.`notification_id` AS `notification_id`,`notifications`.`user_id` AS `user_id`,`notifications`.`message` AS `message`,`notifications`.`is_read` AS `is_read`,`notifications`.`created_at` AS `created_at` from `notifications` order by `notifications`.`created_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_user_phone_check`
--

/*!50001 DROP VIEW IF EXISTS `vw_user_phone_check`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_user_phone_check` AS select `users`.`user_id` AS `user_id`,`users`.`phone` AS `phone` from `users` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_user_reservations`
--

/*!50001 DROP VIEW IF EXISTS `vw_user_reservations`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_user_reservations` AS select `r`.`reservation_id` AS `reservation_id`,`r`.`user_id` AS `user_id`,`r`.`room_id` AS `room_id`,`r`.`check_in_date` AS `check_in_date`,`r`.`check_out_date` AS `check_out_date`,`r`.`total_amount` AS `total_amount`,`r`.`status` AS `status`,`r`.`created_at` AS `created_at`,`rm`.`room_number` AS `room_number`,`rt`.`type_name` AS `type_name` from ((`reservations` `r` join `rooms` `rm` on((`r`.`room_id` = `rm`.`room_id`))) join `room_types` `rt` on((`rm`.`room_type_id` = `rt`.`room_type_id`))) order by `r`.`created_at` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-05  3:38:50
