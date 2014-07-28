-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: test_3enib
-- ------------------------------------------------------
-- Server version	5.5.37-0+wheezy1

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
-- Table structure for table `3enib_companies`
--

DROP TABLE IF EXISTS `3enib_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `photo_filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` text COLLATE utf8_unicode_ci NOT NULL,
  `expertise` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '&nbsp;',
  `SIRET` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avatar_filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_companies`
--

LOCK TABLES `3enib_companies` WRITE;
/*!40000 ALTER TABLE `3enib_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_documents`
--

DROP TABLE IF EXISTS `3enib_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `visibility` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_documents`
--

LOCK TABLES `3enib_documents` WRITE;
/*!40000 ALTER TABLE `3enib_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_migrations`
--

DROP TABLE IF EXISTS `3enib_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_migrations`
--

LOCK TABLES `3enib_migrations` WRITE;
/*!40000 ALTER TABLE `3enib_migrations` DISABLE KEYS */;
INSERT INTO `3enib_migrations` VALUES ('2014_06_28_223001_release',1);
/*!40000 ALTER TABLE `3enib_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_notifications`
--

DROP TABLE IF EXISTS `3enib_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_notifications`
--

LOCK TABLES `3enib_notifications` WRITE;
/*!40000 ALTER TABLE `3enib_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_passoword_reminders`
--

DROP TABLE IF EXISTS `3enib_passoword_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_passoword_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `passoword_reminders_email_index` (`email`),
  KEY `passoword_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_passoword_reminders`
--

LOCK TABLES `3enib_passoword_reminders` WRITE;
/*!40000 ALTER TABLE `3enib_passoword_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_passoword_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_posts`
--

DROP TABLE IF EXISTS `3enib_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_posts`
--

LOCK TABLES `3enib_posts` WRITE;
/*!40000 ALTER TABLE `3enib_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_project_student_pivot`
--

DROP TABLE IF EXISTS `3enib_project_student_pivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_project_student_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_state` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_project_student_pivot`
--

LOCK TABLES `3enib_project_student_pivot` WRITE;
/*!40000 ALTER TABLE `3enib_project_student_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_project_student_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_projects`
--

DROP TABLE IF EXISTS `3enib_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `required_skills` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `remuneration` float(8,2) NOT NULL DEFAULT '0.00',
  `estimated_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_projects`
--

LOCK TABLES `3enib_projects` WRITE;
/*!40000 ALTER TABLE `3enib_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `3enib_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_students`
--

DROP TABLE IF EXISTS `3enib_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `speciality` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `photo_filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '&nbsp;',
  `avatar_filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cv_filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `secu` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '&nbsp;',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_students`
--

LOCK TABLES `3enib_students` WRITE;
/*!40000 ALTER TABLE `3enib_students` DISABLE KEYS */;
INSERT INTO `3enib_students` VALUES (1,'','Admin','','','&nbsp;','','','','&nbsp;',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `3enib_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3enib_users`
--

DROP TABLE IF EXISTS `3enib_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3enib_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `own_id` int(11) NOT NULL,
  `own_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin` int(11) NOT NULL DEFAULT '0',
  `hash_verification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3enib_users`
--

LOCK TABLES `3enib_users` WRITE;
/*!40000 ALTER TABLE `3enib_users` DISABLE KEYS */;
INSERT INTO `3enib_users` VALUES (1,'admin@enib.fr','$2y$10$2VfKiAFOvelllPPygcChTu5Ic1wx1PaKevmD45Qw/83ULr3YDTX2C',1,'student','0000-00-00 00:00:00','2014-07-28 12:51:22',1,'','Q2EWYHUfLhWVy9sF9nYFHdjm5yhQJy7vtKmZb3YjXQUVr0KyVque8F9Ip8cN',1);
/*!40000 ALTER TABLE `3enib_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-28 16:56:20
