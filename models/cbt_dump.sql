-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: CBT
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

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
-- Table structure for table `Administrator`
--

DROP TABLE IF EXISTS `Administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Administrator` (
  `username` varchar(255) NOT NULL DEFAULT 'admin',
  `firstName` char(100) NOT NULL DEFAULT 'Admin',
  `lastName` char(100) NOT NULL DEFAULT 'Admin',
  `imageUrl` varchar(255) DEFAULT '/images/admin.png',
  `pw` varchar(255) NOT NULL DEFAULT '$2y$10$B9gGv1ohRO.KubkLY1gyGuwmc0.SNdBYMME8cYsuvVDpC6YdBwNny',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Administrator`
--

LOCK TABLES `Administrator` WRITE;
/*!40000 ALTER TABLE `Administrator` DISABLE KEYS */;
INSERT INTO `Administrator` VALUES ('admin','Admin','Admin','/images/admin.png','$2y$10$B9gGv1ohRO.KubkLY1gyGuwmc0.SNdBYMME8cYsuvVDpC6YdBwNny');
/*!40000 ALTER TABLE `Administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Course`
--

DROP TABLE IF EXISTS `Course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
  `courseTitle` varchar(255) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  PRIMARY KEY (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course`
--

LOCK TABLES `Course` WRITE;
/*!40000 ALTER TABLE `Course` DISABLE KEYS */;
INSERT INTO `Course` VALUES (1,'Electromagnetic Wave Theory','EEG 509'),(2,'Database Management','CPE 502'),(3,'Signals and Systems','EEG 203'),(4,'Computer Networking Fundamentals','CPE 510');
/*!40000 ALTER TABLE `Course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Course_Examiner`
--

DROP TABLE IF EXISTS `Course_Examiner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course_Examiner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `Course_Examiner_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Examiner` (`username`),
  CONSTRAINT `Course_Examiner_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `Course` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course_Examiner`
--

LOCK TABLES `Course_Examiner` WRITE;
/*!40000 ALTER TABLE `Course_Examiner` DISABLE KEYS */;
INSERT INTO `Course_Examiner` VALUES (1,'jane_osoba',1),(2,'jane_osoba',2),(3,'ayo_ph',1),(4,'ayo_ph',2),(5,'ayo_ph',4);
/*!40000 ALTER TABLE `Course_Examiner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Course_Student`
--

DROP TABLE IF EXISTS `Course_Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course_Student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `Course_Student_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Student` (`username`),
  CONSTRAINT `Course_Student_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `Course` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course_Student`
--

LOCK TABLES `Course_Student` WRITE;
/*!40000 ALTER TABLE `Course_Student` DISABLE KEYS */;
INSERT INTO `Course_Student` VALUES (1,'150408502',1),(2,'150408502',2),(3,'150408502',3),(4,'130408502',2);
/*!40000 ALTER TABLE `Course_Student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Exam`
--

DROP TABLE IF EXISTS `Exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Exam` (
  `examId` int(11) NOT NULL AUTO_INCREMENT,
  `instruction` varchar(255) DEFAULT NULL,
  `timeDuration` time NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `lastModified` datetime NOT NULL,
  `courseId` int(11) DEFAULT NULL,
  PRIMARY KEY (`examId`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `Exam_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `Course` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Exam`
--

LOCK TABLES `Exam` WRITE;
/*!40000 ALTER TABLE `Exam` DISABLE KEYS */;
INSERT INTO `Exam` VALUES (1,' Attempt all questions. You have 1 hour. If your time runs out, your answers are submitted automatically.','00:45:00',1,'0000-00-00 00:00:00','2019-12-31 04:05:38',1),(2,'Answer just 1 question in 45 minutes. If your time runs out, your answers are submitted automatically.','00:45:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',2),(3,'You have 25 minutes. Do what you can. If your time runs out, your answers are submitted automatically.','00:25:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',3),(4,' Answer just one question','00:10:00',1,'2019-12-06 17:33:42','2019-12-06 17:33:42',4);
/*!40000 ALTER TABLE `Exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Examiner`
--

DROP TABLE IF EXISTS `Examiner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Examiner` (
  `username` varchar(255) NOT NULL,
  `firstName` char(100) NOT NULL,
  `lastName` char(100) NOT NULL,
  `imageUrl` varchar(255) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `pw` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Examiner`
--

LOCK TABLES `Examiner` WRITE;
/*!40000 ALTER TABLE `Examiner` DISABLE KEYS */;
INSERT INTO `Examiner` VALUES ('ayo_ph','Ayo','Popoola-Herbert','/images/examiner_male.png','male','$2y$10$7s3vhwb/S5k4TgDIvnud3eLVTKaE9XospRMiXHna.3eF8FX5JlLbe'),('jane_osoba','Jane','Osoba','/images/examiner_female.png','female','$2y$10$7s3vhwb/S5k4TgDIvnud3eLVTKaE9XospRMiXHna.3eF8FX5JlLbe');
/*!40000 ALTER TABLE `Examiner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question`
--

DROP TABLE IF EXISTS `Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Question` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `option5` varchar(255) DEFAULT NULL,
  `answer` varchar(255) NOT NULL,
  `examId` int(11) DEFAULT NULL,
  PRIMARY KEY (`questionId`),
  KEY `examId` (`examId`),
  CONSTRAINT `Question_ibfk_1` FOREIGN KEY (`examId`) REFERENCES `Exam` (`examId`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES (1,'What is Kirchoff\'s Voltage Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(2,'What is Kirchoff\'s Current Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(3,'What is Kirchoff\'s Voltage Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(4,'What is Kirchoff\'s Current Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(5,'What is Kirchoff\'s Voltage Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(6,'What is Kirchoff\'s Current Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(7,'What is Kirchoff\'s Voltage Law?','The sum of all voltages is zero.','It states that the total current around a closed loop must be zero.','It states that the total voltage around a closed loop must be zero.','A and C above','None of the above','It states that the total voltage around a closed loop must be zero.',1),(8,'Normalization solves the problem of?','Data redundancy','Insert anomaly','Delete anomaly','Update anomaly','All of the above','All of the above',2),(9,'MySQL is a type of _____ database?','relational','non-relational','object-oriented','heirachical','MongoDB','relational',2),(10,'Normalization solves the problem of?','Data redundancy','Insert anomaly','Delete anomaly','Update anomaly','All of the above','All of the above',2),(11,'MySQL is a type of _____ database?','relational','non-relational','object-oriented','heirachical','MongoDB','relational',2),(12,'Normalization solves the problem of?','Data redundancy','Insert anomaly','Delete anomaly','Update anomaly','All of the above','All of the above',2),(13,'MySQL is a type of _____ database?','relational','non-relational','object-oriented','heirachical','MongoDB','relational',2),(14,'Normalization solves the problem of?','Data redundancy','Insert anomaly','Delete anomaly','Update anomaly','All of the above','All of the above',2),(15,'MySQL is a type of _____ database?','relational','non-relational','object-oriented','heirachical','MongoDB','relational',2),(16,'Which of the following is an even signal?','x(t)=sin(wt)','y(t)=sin(wt+2)','z(t)=cos(wt)','A and B above','None of the above','z(t)=cos(wt)',3),(17,'How is the discrete time impulse function defined in terms of the step function?','d[n] = u[n+1] â€“ u[n]','d[n] = u[n] â€“ u[n-2]','d[n] = u[n] â€“ u[n-1]','d[n] = u[n+1] â€“ u[n-1]','d[n] = u[n+1] â€“ u[n-12]','d[n] = u[n] â€“ u[n-1]',3),(18,'A system with memory which anticipates future values of input is called _________ ','Non-causal System ','Non-anticipative System','Causal System','Static System ','Stable system','Non-causal System',3),(19,'Determine the nature of the system: y(n)=x(-n).','Causal','Non-causal','Causal for all positive values of n','Non-causal for negative values of n','None of the above','Non-causal',3),(20,'Which of the following is an even signal?','x(t)=sin(wt)','y(t)=sin(wt+2)','z(t)=cos(wt)','A and B above','None of the above','z(t)=cos(wt)',3),(21,'How is the discrete time impulse function defined in terms of the step function?','d[n] = u[n+1] â€“ u[n]','d[n] = u[n] â€“ u[n-2]','d[n] = u[n] â€“ u[n-1]','d[n] = u[n+1] â€“ u[n-1]','d[n] = u[n+1] â€“ u[n-12]','d[n] = u[n] â€“ u[n-1]',3),(22,'A system with memory which anticipates future values of input is called _________ ','Non-causal System ','Non-anticipative System','Causal System','Static System ','Stable system','Non-causal System',3),(23,'Determine the nature of the system: y(n)=x(-n).','Causal','Non-causal','Causal for all positive values of n','Non-causal for negative values of n','None of the above','Non-causal',3),(24,' What is an electric field?','A force surrounding a charge','An area with grass around electricity','A field with an electric fence','A force to reckon with','None of the above','A force surrounding a charge',4);
/*!40000 ALTER TABLE `Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student`
--

DROP TABLE IF EXISTS `Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student` (
  `username` varchar(15) NOT NULL,
  `firstName` char(100) NOT NULL,
  `lastName` char(100) NOT NULL,
  `imageUrl` varchar(255) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `pw` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student`
--

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;
INSERT INTO `Student` VALUES ('130408016','Feyisola','Adelaja','/images/student_female_2.jpg','female','$2y$10$pnqojnaPkOnCB4B79PFNrexxO2GRhV6PrcgP/1yayZNQ1DFXI48z6'),('130408502','Omi','Obi','/images/student_male.jpg','male','$2y$10$7s3vhwb/S5k4TgDIvnud3eLVTKaE9XospRMiXHna.3eF8FX5JlLbe'),('150408502','Karen','Okonkwo','/images/student_female_3.jpg','female','$2y$10$7s3vhwb/S5k4TgDIvnud3eLVTKaE9XospRMiXHna.3eF8FX5JlLbe');
/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student_Result`
--

DROP TABLE IF EXISTS `Student_Result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student_Result` (
  `studentId` varchar(255) NOT NULL,
  `examId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `scoreOverall` int(11) NOT NULL,
  `submitTime` datetime NOT NULL,
  PRIMARY KEY (`studentId`,`examId`),
  KEY `examId` (`examId`),
  CONSTRAINT `Student_Result_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `Student` (`username`),
  CONSTRAINT `Student_Result_ibfk_2` FOREIGN KEY (`examId`) REFERENCES `Exam` (`examId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student_Result`
--

LOCK TABLES `Student_Result` WRITE;
/*!40000 ALTER TABLE `Student_Result` DISABLE KEYS */;
INSERT INTO `Student_Result` VALUES ('150408502',1,4,7,'2019-12-31 04:04:44');
/*!40000 ALTER TABLE `Student_Result` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-21 13:26:22
