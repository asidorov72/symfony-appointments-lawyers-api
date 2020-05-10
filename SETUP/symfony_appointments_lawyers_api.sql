-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for symfony_appointments_lawyers_api
CREATE DATABASE IF NOT EXISTS `symfony_appointments_lawyers_api` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `symfony_appointments_lawyers_api`;

-- Dumping structure for table symfony_appointments_lawyers_api.appointment
CREATE TABLE IF NOT EXISTS `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lawyer_id` int(11) NOT NULL,
  `citizen_id` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `appointment_datetime` datetime NOT NULL,
  `duration_mins` int(11) NOT NULL,
  `appointment_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appointment_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appointment_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony_appointments_lawyers_api.appointment: ~4 rows (approximately)
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` (`id`, `lawyer_id`, `citizen_id`, `status`, `payment_status`, `date`, `appointment_datetime`, `duration_mins`, `appointment_title`, `appointment_desc`, `appointment_type`) VALUES
	(2, 1, 9, 'rejected', 'paid', '2020-05-10 17:23:00', '2020-05-18 17:00:00', 60, NULL, 'Consultation', 'meeting'),
	(5, 1, 8, 'pending', 'pending', '2020-05-10 12:54:22', '2020-05-16 12:00:00', 60, NULL, 'test meeting', 'meeting'),
	(6, 1, 8, 'pending', 'pending', '2020-05-10 15:24:37', '2020-05-18 12:00:00', 60, NULL, 'test meeting', 'meeting'),
	(7, 1, 8, 'pending', 'pending', '2020-05-10 16:57:40', '2020-05-19 12:00:00', 60, NULL, 'test meeting', 'meeting');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;

-- Dumping structure for table symfony_appointments_lawyers_api.citizen
CREATE TABLE IF NOT EXISTS `citizen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_66EE2EB5E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony_appointments_lawyers_api.citizen: ~8 rows (approximately)
/*!40000 ALTER TABLE `citizen` DISABLE KEYS */;
INSERT INTO `citizen` (`id`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `title`, `postal_code`, `postal_address`, `country`, `date_of_birth`) VALUES
	(1, 'dnB1cGtpbkBnbWFpbC5jb206MTIzNDU=', 'vpupkin@gmail.com', 'Vasya', 'Pupkin', '89890808080808080', 'Mr.', NULL, NULL, NULL, '1972-12-01'),
	(3, 'dmFzeWEucHVwa2luQGdtYWlsLmNvbToxMjM0NQ==', 'vasya.pupkin@gmail.com', 'Vasya', 'Pupkin', '+35988 7409673', 'Mr.', NULL, NULL, NULL, '1972-12-01'),
	(5, 'ZXhhbXBsZUB0ZXN0bWFpbC5jb206MTIzNDU=', 'example@testmail.com', 'Test', 'Test', '+35988 7409673', 'Mrs.', NULL, NULL, NULL, '1980-04-05'),
	(6, 'dGVzdC50ZXN0QHRlc3RtYWlsLmNvbToxMjM0NQ==', 'test.test@testmail.com', 'Testtest', 'Test', '+35988 7409673', 'Mr.', NULL, NULL, NULL, '1980-04-05'),
	(7, 'a2tra2tAdGVzdG1haWwuY29tOjEyMzQ1', 'kkkkk@testmail.com', 'Testtest', 'Test', '+35988 7409673', 'Mr.', NULL, NULL, NULL, '1980-04-05'),
	(8, 'ZXhhbXBsZS5leGFtcGxlQHRlc3RtYWlsLmNvbToxMjM0NQ==', 'example.example@testmail.com', 'Example', 'Test', '+35988 7409673', 'Mr.', NULL, NULL, NULL, '1980-04-05'),
	(9, 'c3VwZXIubWFyaW9AdGVzdG1haWwuY29tOjEyMzQ1', 'super.mario@testmail.com', 'Mario', 'Super', '+35988999999', 'Mr.', NULL, NULL, 'Italy', '1975-03-25'),
	(10, 'c3VwZXIubWFyaW8yQHRlc3RtYWlsLmNvbToxMjM0NQ==', 'super.mario2@testmail.com', 'Mario', 'Supersuper', '+35988999999', 'Mr.', NULL, NULL, NULL, '1975-03-25'),
	(11, 'c3VwZXJwdXBlci5tYXJpb0B0ZXN0bWFpbC5jb206MTIzNDU=', 'superpuper.mario@testmail.com', 'Mario', 'Superpuper', '+35988999999', 'Mr.', NULL, NULL, NULL, '1975-03-25');
/*!40000 ALTER TABLE `citizen` ENABLE KEYS */;

-- Dumping structure for table symfony_appointments_lawyers_api.lawyer
CREATE TABLE IF NOT EXISTS `lawyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lawyer_license_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lawyer_license_issue_date` date NOT NULL,
  `lawyer_license_expire_date` date NOT NULL,
  `lawyer_license_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lawyer_degree` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_lawyer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_66437141E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony_appointments_lawyers_api.lawyer: ~10 rows (approximately)
/*!40000 ALTER TABLE `lawyer` DISABLE KEYS */;
INSERT INTO `lawyer` (`id`, `email`, `password`, `first_name`, `last_name`, `phone_number`, `title`, `postal_code`, `postal_address`, `country`, `date_of_birth`, `company_name`, `lawyer_license_number`, `lawyer_license_issue_date`, `lawyer_license_expire_date`, `lawyer_license_name`, `lawyer_degree`, `type_of_lawyer`) VALUES
	(1, 'isaak.katz@gmail.com', 'aXNhYWsua2F0ekBnbWFpbC5jb206MTIzNDU=', 'Isaak', 'Katz', '+359878454006', 'Mr.', '1137', 'sfdsagdsfg', 'Bulgaria', '1973-11-10', 'Test license', '432454534', '2010-11-24', '2010-11-24', NULL, 'professor', 'family'),
	(2, 'lee.coopera@test.com', 'bGVlLmNvb3BlcmFAdGVzdC5jb206MTIzNDU=', 'Lee', 'Cooper', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', NULL, '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2023-05-09', NULL, 'professor', 'family'),
	(4, 'lee.cooper@gmail.com', 'bGVlLmNvb3BlckBnbWFpbC5jb206MTIzNDU=', 'Lee', 'Cooper', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', NULL, '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2023-05-09', NULL, 'professor', 'family'),
	(5, 'example.lawyer@test.com', 'ZXhhbXBsZS5sYXd5ZXJAdGVzdC5jb206MTIzNDU=', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2023-05-09', NULL, 'professor', 'family'),
	(6, 'example_lawyer@test.com', 'ZXhhbXBsZV9sYXd5ZXJAdGVzdC5jb206MTIzNDU=', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2023-05-09', NULL, 'professor', 'family'),
	(7, 'example___lawyer@test.com', 'ZXhhbXBsZV9fX2xhd3llckB0ZXN0LmNvbToxMjM0NQ==', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-07', NULL, 'professor', 'family'),
	(8, 'examplelawyer99@test.com', 'ZXhhbXBsZWxhd3llcjk5QHRlc3QuY29tOjEyMzQ1', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-07', NULL, 'professor', 'family'),
	(9, 'examplelawyer8@test.com', 'ZXhhbXBsZWxhd3llcjhAdGVzdC5jb206MTIzNDU=', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-06', NULL, 'professor', 'family'),
	(10, 'examplelawyer899@test.com', 'ZXhhbXBsZWxhd3llcjg5OUB0ZXN0LmNvbToxMjM0NQ==', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-06', NULL, 'professor', 'family'),
	(11, 'examplelawyer89999@test.com', 'ZXhhbXBsZWxhd3llcjg5OTk5QHRlc3QuY29tOjEyMzQ1', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-07', NULL, 'professor', 'family'),
	(12, 'exaasfsdg@test.com', 'ZXhhYXNmc2RnQHRlc3QuY29tOjEyMzQ1', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-09', NULL, 'professor', 'family'),
	(13, 'exaasfsdkkkkkg@test.com', 'ZXhhYXNmc2Rra2tra2dAdGVzdC5jb206MTIzNDU=', 'Example', 'lawyer', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-10', NULL, 'professor', 'family'),
	(14, 'hitry.zhuk@test.com', 'aGl0cnkuemh1a0B0ZXN0LmNvbToxMjM0NQ==', 'Zhuk', 'Zhuchara', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-15', NULL, 'professor', 'family'),
	(15, 'hitry.zhuk5@test.com', 'aGl0cnkuemh1azVAdGVzdC5jb206MTIzNDU=', 'Zhuk', 'Zhuchara', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-15', NULL, 'professor', 'family'),
	(16, 'hitry.zhuk65@test.com', 'aGl0cnkuemh1azY1QHRlc3QuY29tOjEyMzQ1', 'Zhuk', 'Zhuchara', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-15', NULL, 'professor', 'family'),
	(17, 'hitry.zhuk.hristo@test.com', 'aGl0cnkuemh1ay5ocmlzdG9AdGVzdC5jb206MTIzNDU=', 'Zhuk', 'Zhuchara', '+359878454006', 'Mr.', '1137', 'ul. Zlatna qbylka 1', 'UK', '1980-04-05', 'Example Lawyer & Co.', '268fab92-3418-4da3-a1f0-1d6b5a297760', '2010-11-24', '2020-05-15', NULL, 'professor', 'family');
/*!40000 ALTER TABLE `lawyer` ENABLE KEYS */;

-- Dumping structure for table symfony_appointments_lawyers_api.migration_versions
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony_appointments_lawyers_api.migration_versions: ~2 rows (approximately)
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
	('20200510132007', '2020-05-10 13:20:23'),
	('20200510144136', '2020-05-10 14:41:46');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;

-- Dumping structure for table symfony_appointments_lawyers_api.token
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `uuid_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `citizen_id` int(11) DEFAULT NULL,
  `lawyer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table symfony_appointments_lawyers_api.token: ~5 rows (approximately)
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` (`id`, `date`, `uuid_token`, `citizen_id`, `lawyer_id`) VALUES
	(8, '2020-05-10 14:28:49', '21aa5ad9-8408-4123-858d-69e56b710ef3', NULL, 1),
	(10, '2020-05-10 14:29:37', '11531ee8-ddd7-4039-b9dd-184759a2c166', 1, NULL),
	(12, '2020-05-10 14:30:36', '73dc6599-69db-40ad-a019-2a4227e68394', 5, NULL),
	(14, '2020-05-10 15:12:04', '31fcafa7-4913-4efb-8953-1e09c0f6dde5', NULL, 2),
	(17, '2020-05-10 16:57:02', '73d01f3d-dd11-43fe-9276-94864a3a9d0b', NULL, 4);
/*!40000 ALTER TABLE `token` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
