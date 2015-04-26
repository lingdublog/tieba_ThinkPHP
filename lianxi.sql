-- MySQL dump 10.13  Distrib 5.5.40, for Win32 (x86)
--
-- Host: localhost    Database: lianxi
-- ------------------------------------------------------
-- Server version	5.5.40

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
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` char(20) COLLATE utf8_bin NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '0',
  `age` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'小明',0,18),(2,'小里',0,19),(3,'反反复复',1,19),(4,'反反复复',1,19),(5,'反反复复',1,19),(6,'望各位',1,19),(7,'望各位',1,19);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `pubtime` int(20) NOT NULL,
  `author` varchar(12) COLLATE utf8_bin NOT NULL,
  `replyer` varchar(12) COLLATE utf8_bin NOT NULL,
  `replytime` int(20) NOT NULL,
  `replynum` int(10) NOT NULL DEFAULT '0',
  `pic` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'第一个','阿斯达克感受',0,'','',0,0,NULL),(2,'这才是第一个','请问各位十多个',1429954839,'五个A','',0,0,NULL),(3,'我也来发一篇','阿斯钢我二哥',1429954930,'五个B','',0,0,NULL),(4,'我了落叶','阿瑟了多久1234124',1430014627,'五个C','',0,0,NULL),(5,'了另一个','为官方图我二哥',1430039141,'五个C','五个C',1430042449,1,NULL),(6,'11111111','11111111111111111',1430048830,'五个C','',0,0,'undefined'),(7,'22222222222','22222222222222222222',1430048940,'五个C','',0,0,'undefined'),(8,'33333333','33333333333',1430048994,'五个C','',0,0,'undefined'),(9,'555555','55555555555',1430053828,'五个C','五个C',1430055973,2,'d7fb264ccece798629db607a701e19ca_logo1.jpg');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(2000) COLLATE utf8_bin NOT NULL,
  `pubtime` int(20) NOT NULL,
  `author` varchar(12) COLLATE utf8_bin NOT NULL,
  `postid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reply`
--

LOCK TABLES `reply` WRITE;
/*!40000 ALTER TABLE `reply` DISABLE KEYS */;
INSERT INTO `reply` VALUES (1,'这是回帖1',1430017558,'五个B',4),(2,'这是回帖2',1430019362,'五个A',4),(3,'这是回帖2',1430019479,'五个A',4),(4,'这样才怪。。。',1430019662,'五个A',3),(5,'爱是客户端过来点',1430019731,'五个A',3),(6,'什么时候',1430019798,'五个A',2),(7,'先回一个',1430039119,'五个C',2),(8,'里拉屎了看到刚回来',1430042249,'五个C',5),(9,'里拉屎了看到刚回来',1430042249,'五个C',5),(10,'里拉屎了看到刚回来',1430042249,'五个C',5),(11,'去死啊',1430042449,'五个C',5),(12,'<script>alert(1);</script>',1430055639,'五个C',9),(13,'<script>alert(2);</script>',1430055973,'五个C',9);
/*!40000 ALTER TABLE `reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `nickname` varchar(12) COLLATE utf8_bin NOT NULL,
  `regtime` int(20) NOT NULL,
  `userId` varchar(32) COLLATE utf8_bin NOT NULL,
  `score` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'aaaa','b59c67bf196a4758191e42f76670ceba','1429953852',74,'',3),(2,'aaaaa','b0baee9d279d34fa1dfd71aadb908c3f','五个A',1429954212,'594f803b380a41396ed63dca39503542',4),(3,'bbbbb','b0baee9d279d34fa1dfd71aadb908c3f','五个B',1429954893,'a21075a36eeddd084e17611a238c7101',3),(4,'ccccc','b0baee9d279d34fa1dfd71aadb908c3f','五个C',1429955585,'67c762276bced09ee4df0ed537d164ea',20);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-26 21:47:49
