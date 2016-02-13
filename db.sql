-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: mysql.labranet.jamk.fi    Database: H3173_3
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comment` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT,
  `CommenterId` int(11) NOT NULL,
  `Comment` varchar(2400) NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `fk_Comment_User1_idx` (`CommenterId`),
  CONSTRAINT `fk_Comment_User1` FOREIGN KEY (`CommenterId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comment`
--

LOCK TABLES `Comment` WRITE;
/*!40000 ALTER TABLE `Comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `Comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CommentTarget`
--

DROP TABLE IF EXISTS `CommentTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommentTarget` (
  `User_UserId` int(11) NOT NULL,
  `Comment_CommentId` int(11) NOT NULL,
  PRIMARY KEY (`User_UserId`,`Comment_CommentId`),
  KEY `fk_User_has_Comment_Comment1_idx` (`Comment_CommentId`),
  KEY `fk_User_has_Comment_User1_idx` (`User_UserId`),
  CONSTRAINT `fk_User_has_Comment_User1` FOREIGN KEY (`User_UserId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Comment_Comment1` FOREIGN KEY (`Comment_CommentId`) REFERENCES `Comment` (`CommentId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommentTarget`
--

LOCK TABLES `CommentTarget` WRITE;
/*!40000 ALTER TABLE `CommentTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `CommentTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crag`
--

DROP TABLE IF EXISTS `Crag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crag` (
  `CragId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Lat` varchar(45) NOT NULL,
  `Lon` varchar(45) NOT NULL,
  PRIMARY KEY (`CragId`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crag`
--

LOCK TABLES `Crag` WRITE;
/*!40000 ALTER TABLE `Crag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Crag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CragCommentTarget`
--

DROP TABLE IF EXISTS `CragCommentTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CragCommentTarget` (
  `CommentId` int(11) NOT NULL,
  `CragId` int(11) NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `fk_table1_Comment1_idx` (`CommentId`),
  KEY `fk_table1_Crag1_idx` (`CragId`),
  CONSTRAINT `fk_table1_Comment1` FOREIGN KEY (`CommentId`) REFERENCES `Comment` (`CommentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_Crag1` FOREIGN KEY (`CragId`) REFERENCES `Crag` (`CragId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CragCommentTarget`
--

LOCK TABLES `CragCommentTarget` WRITE;
/*!40000 ALTER TABLE `CragCommentTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `CragCommentTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CragImageTarget`
--

DROP TABLE IF EXISTS `CragImageTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CragImageTarget` (
  `ImageId` int(11) NOT NULL,
  `CragId` int(11) NOT NULL,
  PRIMARY KEY (`ImageId`),
  KEY `fk_CragImageTarget_Image1_idx` (`ImageId`),
  KEY `fk_CragImageTarget_Crag1` (`CragId`),
  CONSTRAINT `fk_CragImageTarget_Crag1` FOREIGN KEY (`CragId`) REFERENCES `Crag` (`CragId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CragImageTarget_Image1` FOREIGN KEY (`ImageId`) REFERENCES `Image` (`ImageId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CragImageTarget`
--

LOCK TABLES `CragImageTarget` WRITE;
/*!40000 ALTER TABLE `CragImageTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `CragImageTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Image`
--

DROP TABLE IF EXISTS `Image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Image` (
  `ImageId` int(11) NOT NULL AUTO_INCREMENT,
  `UploaderId` int(11) NOT NULL,
  `ServerLocation` varchar(255) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Width` int(11) NOT NULL,
  `Height` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` varchar(2400) DEFAULT NULL,
  PRIMARY KEY (`ImageId`),
  UNIQUE KEY `Name_UNIQUE` (`FileName`),
  KEY `fk_Image_User1_idx` (`UploaderId`),
  CONSTRAINT `fk_Image_User1` FOREIGN KEY (`UploaderId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Image`
--

LOCK TABLES `Image` WRITE;
/*!40000 ALTER TABLE `Image` DISABLE KEYS */;
INSERT INTO `Image` VALUES (1,1,'/images/','matinnaama.jpg',800,600,NULL,NULL);
/*!40000 ALTER TABLE `Image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Practice`
--

DROP TABLE IF EXISTS `Practice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Practice` (
  `PracticeId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `IsOutside` tinyint(1) NOT NULL,
  PRIMARY KEY (`PracticeId`),
  KEY `fk_Practice_User1_idx` (`UserId`),
  CONSTRAINT `fk_Practice_User1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Practice`
--

LOCK TABLES `Practice` WRITE;
/*!40000 ALTER TABLE `Practice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Practice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Route`
--

DROP TABLE IF EXISTS `Route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Route` (
  `RouteId` int(11) NOT NULL AUTO_INCREMENT,
  `CragId` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Grade` int(11) NOT NULL,
  `Description` varchar(743) DEFAULT NULL,
  PRIMARY KEY (`RouteId`),
  UNIQUE KEY `Name_UNIQUE` (`Name`),
  KEY `fk_Route_Crag1_idx` (`CragId`),
  CONSTRAINT `fk_Route_Crag1` FOREIGN KEY (`CragId`) REFERENCES `Crag` (`CragId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Route`
--

LOCK TABLES `Route` WRITE;
/*!40000 ALTER TABLE `Route` DISABLE KEYS */;
/*!40000 ALTER TABLE `Route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RouteCommentTarget`
--

DROP TABLE IF EXISTS `RouteCommentTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RouteCommentTarget` (
  `CommentId` int(11) NOT NULL,
  `RouteId` int(11) NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `fk_table2_Comment1_idx` (`CommentId`),
  KEY `fk_table2_Route1_idx` (`RouteId`),
  CONSTRAINT `fk_table2_Comment1` FOREIGN KEY (`CommentId`) REFERENCES `Comment` (`CommentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table2_Route1` FOREIGN KEY (`RouteId`) REFERENCES `Route` (`RouteId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RouteCommentTarget`
--

LOCK TABLES `RouteCommentTarget` WRITE;
/*!40000 ALTER TABLE `RouteCommentTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `RouteCommentTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RouteImageTarget`
--

DROP TABLE IF EXISTS `RouteImageTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RouteImageTarget` (
  `ImageId` int(11) NOT NULL,
  `RouteId` int(11) NOT NULL,
  `StartX` int(11) DEFAULT NULL,
  `StartY` int(11) DEFAULT NULL,
  `EndX` int(11) DEFAULT NULL,
  `EndY` int(11) DEFAULT NULL,
  PRIMARY KEY (`ImageId`,`RouteId`),
  KEY `fk_Image_has_Route_Route1_idx` (`RouteId`),
  KEY `fk_Image_has_Route_Image1_idx` (`ImageId`),
  CONSTRAINT `fk_Image_has_Route_Image1` FOREIGN KEY (`ImageId`) REFERENCES `Image` (`ImageId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Image_has_Route_Route1` FOREIGN KEY (`RouteId`) REFERENCES `Route` (`RouteId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RouteImageTarget`
--

LOCK TABLES `RouteImageTarget` WRITE;
/*!40000 ALTER TABLE `RouteImageTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `RouteImageTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Pwd` varchar(255) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `IsEmailPublic` tinyint(1) NOT NULL DEFAULT '1',
  `NickName` varchar(255) DEFAULT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `Sex` varchar(10) DEFAULT NULL,
  `HomePage` varchar(45) DEFAULT NULL,
  `ShoeBrand` varchar(20) DEFAULT NULL,
  `ShoeModel` varchar(20) DEFAULT NULL,
  `ShoeSize` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Email_UNIQUE` (`Email`),
  UNIQUE KEY `NickName_UNIQUE` (`NickName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'6b694e8cf87fc88d392ed8ebf81d9385','matti@matti.fi',1,'matti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserCommentTarget`
--

DROP TABLE IF EXISTS `UserCommentTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserCommentTarget` (
  `CommentId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`CommentId`,`UserId`),
  KEY `fk_Comment_has_User_User1_idx` (`UserId`),
  KEY `fk_Comment_has_User_Comment1_idx` (`CommentId`),
  CONSTRAINT `fk_Comment_has_User_Comment1` FOREIGN KEY (`CommentId`) REFERENCES `Comment` (`CommentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comment_has_User_User1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserCommentTarget`
--

LOCK TABLES `UserCommentTarget` WRITE;
/*!40000 ALTER TABLE `UserCommentTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserCommentTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserImageTarget`
--

DROP TABLE IF EXISTS `UserImageTarget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserImageTarget` (
  `UserId` int(11) NOT NULL,
  `ImageId` int(11) NOT NULL,
  PRIMARY KEY (`UserId`,`ImageId`),
  KEY `fk_User_has_Image_Image2_idx` (`ImageId`),
  KEY `fk_User_has_Image_User2_idx` (`UserId`),
  CONSTRAINT `fk_User_has_Image_User2` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Image_Image2` FOREIGN KEY (`ImageId`) REFERENCES `Image` (`ImageId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserImageTarget`
--

LOCK TABLES `UserImageTarget` WRITE;
/*!40000 ALTER TABLE `UserImageTarget` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserImageTarget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserProfileImage`
--

DROP TABLE IF EXISTS `UserProfileImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserProfileImage` (
  `UserId` int(11) NOT NULL,
  `ImageId` int(11) NOT NULL,
  PRIMARY KEY (`UserId`,`ImageId`),
  KEY `fk_UserProfileImage_Image1_idx` (`ImageId`),
  CONSTRAINT `fk_UserProfileImage_User1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserProfileImage_Image1` FOREIGN KEY (`ImageId`) REFERENCES `Image` (`ImageId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserProfileImage`
--

LOCK TABLES `UserProfileImage` WRITE;
/*!40000 ALTER TABLE `UserProfileImage` DISABLE KEYS */;
INSERT INTO `UserProfileImage` VALUES (1,1);
/*!40000 ALTER TABLE `UserProfileImage` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-10 13:27:39
