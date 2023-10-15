-- MySQL dump 10.13  Distrib 8.0.31, for Linux (aarch64)
--
-- Host: localhost    Database: yt_dev
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_bin DEFAULT 'no title',
  `body` varchar(1024) COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `register_token` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `register_token_sent_at` timestamp NULL DEFAULT NULL,
  `register_token_verified_at` timestamp NULL DEFAULT NULL,
  `status` int DEFAULT '0',
  `password` varchar(64) COLLATE utf8mb4_bin DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `reset_token_sent_at` timestamp NULL DEFAULT NULL,
  `reset_token_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (14,'むらかみ','murakami@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$84qCyB2xT5Hav9k.IVXf5ubUNme4hnNcQJjgjcOzhnBRFGr96E2qy','31e84711a092c15ffab7d7451917deceb0df180343856537c0db8db1a8f2d3f2','2023-10-11 06:33:07','2023-10-11 06:34:22','2023-03-19 00:23:20','2023-10-11 06:34:22'),(15,'interview-アーカイブ','hr@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$dRfcB02pF2gcKtR.4GUuQeMwmbX0qoxw56bw9ThuvP7wpxF8XJiPK',NULL,NULL,NULL,'2023-03-21 11:28:57','2023-10-10 09:48:41'),(17,'村上','aaaaa@aaaa.cm',NULL,NULL,NULL,1,'$2y$10$lgLisaQPrsElzpHeVK44Kewf76axtQQvbnIWJBxT5Jz394N8JJrru',NULL,NULL,NULL,'2023-03-21 13:14:40','2023-10-10 09:48:41'),(18,'interview-アーカイブ','sdogogjkg@co.com',NULL,NULL,NULL,1,'$2y$10$EBepO5j34ULKCDPBzgawaus/V4j.zqMrQ.rNxeXSb71d2So92t78a',NULL,NULL,NULL,'2023-03-21 13:49:51','2023-10-10 09:48:41'),(19,'aaa','hr@ps.nippon-foundation.or.jppp',NULL,NULL,NULL,1,'$2y$10$1QLVF8nuuv1O1f0CgcxQzOBTw.qAgQv3g/pklxKOul8SeIR5NwwCm',NULL,NULL,NULL,'2023-03-21 15:11:51','2023-10-10 09:48:41'),(20,'murakami','murakami+test@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$Zf9mLPa6sUz954pPu/UgiuJkYkyDlK2Rv/TKmv1ofNCijRfsFthka',NULL,NULL,NULL,'2023-06-11 20:44:45','2023-10-10 09:48:41'),(21,'村上','new@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$ej.e8Ij7DB/O76XrYsKzKuSm9MhMjAJC4tW/u17v/JDDNo0Q4Jqye',NULL,NULL,NULL,'2023-06-11 20:50:28','2023-10-10 09:48:41'),(22,'むらかみ','sdogogjkg@co.comrrrrr',NULL,NULL,NULL,1,'$2y$10$riG97YEx/Uuc2kfMeCL12uf/XPnXX6Re8JXlQWSTJl14uEjMhzCoG',NULL,NULL,NULL,'2023-06-11 20:57:19','2023-10-10 09:48:41'),(23,'村上','aaaaa@aaaa.cmaa',NULL,NULL,NULL,1,'$2y$10$5uLYVwC.Hwr47sVPg1NbeelqVbjWvCt9pDHSHCD8fYbT4CNghlGw6',NULL,NULL,NULL,'2023-06-11 21:18:59','2023-10-10 09:48:41'),(24,'むらかみ','sdogogjkg@co.compp',NULL,NULL,NULL,1,'$2y$10$xj1mA8UKJR.pmpBWq5eNG.V4H6hz.nb/swcF1vmSDyhkX.cMBtQ66',NULL,NULL,NULL,'2023-06-11 21:19:12','2023-10-10 09:48:41'),(25,'新聖','murakami+ddd@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$roCpBBRnzyaUbNqFp3nMW.xBrzF5vMakeSnJZUDuSYl7NiVBZ9THW',NULL,NULL,NULL,'2023-06-17 09:46:29','2023-10-10 09:48:41'),(26,'あああ','murakamiaaa@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$QsrlhX6E2zZlEa2wQ/c.Qed0pz5XszDHxBIHd.E4ozPsMQcDFHUrS',NULL,NULL,NULL,'2023-06-17 11:59:28','2023-10-10 09:48:41'),(27,'いいい1','testaaa@kokochie.jp',NULL,NULL,NULL,1,'$2y$10$sHo5s66f.aIVau97CP4M7uPo/VALoDl8wOktDQ71nRW9/2Bgr3g0i',NULL,NULL,NULL,'2023-06-17 12:12:42','2023-10-10 09:48:41'),(28,'111','murakamibbb@kokochie.jpq',NULL,NULL,NULL,1,'$2y$10$lGMs4rn6Yb2zjPMzuliisOfz.HOAtTAVnA7Vl2qNClwxMaRRHnBxy',NULL,NULL,NULL,'2023-06-17 12:13:35','2023-10-10 09:48:41'),(29,'むらかみ','hrppp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$0wotgJmBPeOgoisjEVlJPem6SODKyAJVWoDwmjgXR8u3V/hRoyA1i',NULL,NULL,NULL,'2023-06-19 18:55:07','2023-10-10 09:48:41'),(33,'むらかみ','hrppsssp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$vilDpRh6fXMA4pJFFTZLO.Khl2sYMSMQdh2WHUHVquwDDql4FUT3K',NULL,NULL,NULL,'2023-06-19 18:58:46','2023-10-10 09:48:41'),(35,'むらかみ','hrppssddsp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$pWzdctzbfSb9nAqRbole8eA/o/mpUbhmisW7Knsba67lYCl6gwn9i',NULL,NULL,NULL,'2023-06-19 18:59:29','2023-10-10 09:48:41'),(37,'むらかみ','hrppssssddsp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$/SKISoZg/6sMh5XWddkcjOtyyzKtI6.3It5tTE/vw9Ap6kyJQI0LC',NULL,NULL,NULL,'2023-06-19 19:01:35','2023-10-10 09:48:41'),(39,'むらかみ','hrppssrrssddsp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$HWpIzqQQX70SCgIfbxGvTuyxbCDP7kKXhsdesrH8MPVMCnpXmjo86',NULL,NULL,NULL,'2023-06-19 19:03:01','2023-10-10 09:48:41'),(40,'むらかみ','hrppssrrssvvddsp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$vnZy0Dj7T.b2LAwynaq2LOCAsvqe881E4zvTSZriqdBL8Qr.Mjctq',NULL,NULL,NULL,'2023-06-19 19:04:08','2023-10-10 09:48:41'),(41,'むらかみ','hrppsseerrssvvddsp@ps.nippon-foundation.or.jp',NULL,NULL,NULL,1,'$2y$10$Fu84wnCg4ssUemJMM.MYrumeW/ysfyXku3dzUW7l7kJOUQbb5vUWW',NULL,NULL,NULL,'2023-06-19 19:05:06','2023-10-10 09:48:41'),(42,NULL,'ionfoisuuifnsdf@kokochie.jp','109be529384f0b771482f73899e9b10a42b8943ece30b924c24805c4fd2c76f2','2023-07-14 09:31:30',NULL,1,NULL,NULL,NULL,NULL,'2023-07-14 18:31:30','2023-10-10 09:48:41'),(43,NULL,'ionfoisuuionoifnsdf@kokochie.jp','b39e9bc8fa61e7c58772286515dcde216b5dd8c0dc1c95acc9e53312544071ff','2023-07-14 09:33:57',NULL,1,NULL,NULL,NULL,NULL,'2023-07-14 18:33:57','2023-10-10 09:48:41'),(44,NULL,'sdinoinoogogjkg@co.comrrr','4745520b69980e3a2a40cdf2ce5aec11be8ea5c92a93d232fad6c085f0f590be','2023-07-14 09:35:23',NULL,1,NULL,NULL,NULL,NULL,'2023-07-14 18:35:23','2023-10-10 09:48:41'),(45,NULL,'test@test.com','1a80af8a0a5ee029784ae2d3c2a5c08c9ed6aee74f0a3f3ea0f9ff6836a9ee1d','2023-07-30 11:33:25',NULL,1,NULL,NULL,NULL,NULL,'2023-07-30 20:33:25','2023-10-10 09:48:41'),(46,NULL,'testppp@test.com','d357f041180cff996797218f2dd85db763c5e9a4b6ab768fb06827a379450b53','2023-07-30 11:38:27',NULL,1,NULL,NULL,NULL,NULL,'2023-07-30 20:38:27','2023-10-10 09:48:41'),(47,NULL,'tmp@kokochie.jp','d7d8d08c8a360d3668713cca8309037dbc49a5415895e0baf4140e39a7e77d32','2023-08-01 09:02:08',NULL,1,NULL,NULL,NULL,NULL,'2023-08-01 18:02:08','2023-10-10 09:48:41'),(48,NULL,'tmp01@kokochie.jp','ce464fff68171b7d93d44cf6cdf71c47613e4253cb602b62f37bfbe5dce28b44','2023-08-01 09:10:33',NULL,0,NULL,NULL,NULL,NULL,'2023-08-01 18:10:33','2023-08-01 09:10:33'),(49,NULL,'tmp02@kokochie.jp','ba54f9ad541562c3c8474fca731eb81a04158e0a87a8153535a8ea1509a0768d','2023-08-01 09:17:33','2023-08-01 09:21:18',1,'$2y$10$61VNdF1AGAA.csbIl2Exd.te7zUMOE.X20sZEjTDwQGwiZcryZRNe','f5cd40238165f6d4f0b76c1aeff95e7778dca59dbd13334699343ba4acb93b35','2023-08-13 05:48:48',NULL,'2023-08-01 18:17:33','2023-08-13 05:48:48'),(50,NULL,'aaaaa@kokochie.jp','ef65cc987ca9b22e8af7a1f32cc99148bb839e4c81a9887ee984b88051f6ee08','2023-08-01 09:41:50','2023-08-01 09:42:09',1,'$2y$10$kcz5e9YJNsEoW1jPtZHV2.aSISj41pkj8hRnEmHX/plM1Bk48GxHm',NULL,NULL,NULL,'2023-08-01 18:41:50','2023-08-01 09:42:09'),(51,NULL,'tmp001@kokochie.jp','a9b2fad2f5d26aeb4f176bd12af8641c2e10903db9794a1c804659eed58fb71d','2023-08-09 11:03:43','2023-08-09 11:07:11',1,'$2y$10$P2duK/afwF4WJD4azMqCue1nmdoNzJ/MGjjCmgm3v6hJtX0e15esK','45bb0a1d6c6a8bcba2d6830cb10c43a6bb1b5dc57782aa67b6cc56f072848c48','2023-08-13 05:42:04','2023-08-13 05:42:21','2023-08-09 20:03:43','2023-08-13 05:42:21'),(52,NULL,'testeetet@test.com','a943ecd1a9d258dc1905e0ce4c4132ce942cc4802adbf11ce2faf4b68c332fa6','2023-10-10 03:30:34',NULL,0,NULL,NULL,NULL,NULL,'2023-10-10 12:30:34','2023-10-10 03:30:34'),(53,NULL,'murakami+teodo@kokochie.jp','e6ced464ec05fc667ccd01a50d55f3e5eb3561f4b279172f6c0fe3b2a2ff01b8','2023-10-10 03:43:38','2023-10-10 03:47:54',1,'$2y$10$7Bj7Vc7rMVFCHCwoJT6Rw.sJqbQk8TzvMOF9sc52ycyRBEf8SVxQW',NULL,NULL,NULL,'2023-10-10 12:43:38','2023-10-10 03:47:54'),(54,NULL,'murakami+ppeioeno@kokochie.jp','325e618c82ea82b303c758825a8d4fb08fca1f55bd96ed2dc3004b7ddd02f68e','2023-10-10 03:48:50','2023-10-10 04:03:54',1,'$2y$10$NlS3Ai.NRVKw8r4qwwditOOTPDWC44CVTse4y1kNgQR2xVcaHZw0a',NULL,NULL,NULL,'2023-10-10 12:48:50','2023-10-10 04:03:54'),(55,NULL,'murakamiioniono@kokochie.jp','7ab81383e4983dd6f24f593e73504131d1c6fddac560d911158c99105aadcfa8','2023-10-10 04:04:02','2023-10-10 04:14:07',1,'$2y$10$qcILzEtEkoC6bJ7xxmruh.XXvm0BfqFcj/LScQpiOmUA/jxKcg0oy',NULL,NULL,NULL,'2023-10-10 13:04:02','2023-10-10 04:14:07'),(56,NULL,'murakamiioninon@kokochie.jp','73434a38b1c73bab946adc3eaf3695a102fa2aa59e303365522a1c850c043bcd','2023-10-10 04:14:24','2023-10-10 04:18:51',1,'$2y$10$zEliQC1k2rT6nN69/siAnu5u14VtDZbXCbunVlm7dYTFmrnhafA9u',NULL,NULL,NULL,'2023-10-10 13:14:24','2023-10-10 04:18:51'),(57,NULL,'tmp00ino1@kokochie.jp','ae92f6cc3025d308f7e17233847aa1a2279ae1a964abc42067c19e29ab980096','2023-10-10 04:21:05','2023-10-10 04:21:21',1,'$2y$10$wXiXibEvqLFgAT/PmRrFaeUmn.R3ytGZkXaTFAkwpaaENVYoLgGGm',NULL,NULL,NULL,'2023-10-10 13:21:05','2023-10-10 04:21:21'),(58,NULL,'murionkami@kokochie.jp','f4591c8ec3b5a97ee9ee2b4cf716111d32eeb0fee86beec4c0db23e89329f2ad','2023-10-11 05:26:26',NULL,0,NULL,NULL,NULL,NULL,'2023-10-11 14:26:26','2023-10-11 05:26:26');
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

-- Dump completed on 2023-10-15 18:36:33
