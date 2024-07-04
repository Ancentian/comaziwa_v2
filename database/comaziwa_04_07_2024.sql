-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for comaziwa
CREATE DATABASE IF NOT EXISTS `comaziwa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `comaziwa`;

-- Dumping structure for table comaziwa.agents
CREATE TABLE IF NOT EXISTS `agents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agents_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.agents: ~3 rows (approximately)
INSERT INTO `agents` (`id`, `name`, `email`, `phone_no`, `address`, `created_at`, `updated_at`) VALUES
	(1, 'Sandys Lartey', 'sandys.lartey@jpcannassociates.com', '23354249800', '58 Nsawam Road', '2023-11-03 10:45:13', '2023-11-03 10:46:03'),
	(2, 'Ben laryea', 'ben.laryea92@gmail.com', '0244218288', '75 MINISTRIES ROAD', '2024-01-16 16:54:36', '2024-01-16 16:54:36'),
	(3, 'Edmund Toffey', 'edtoffey@proton.me', '0202368640', '75 MINISTRIES ROAD', '2024-01-29 12:58:29', '2024-01-29 12:58:29');

-- Dumping structure for table comaziwa.agent_payments
CREATE TABLE IF NOT EXISTS `agent_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` bigint unsigned NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_payments_agent_id_foreign` (`agent_id`),
  CONSTRAINT `agent_payments_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.agent_payments: ~0 rows (approximately)
INSERT INTO `agent_payments` (`id`, `agent_id`, `date`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 1, '2024-01-29', 4.00, '2024-01-29 12:59:59', '2024-01-29 12:59:59');

-- Dumping structure for table comaziwa.allowances
CREATE TABLE IF NOT EXISTS `allowances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `allowances_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `allowances_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.allowances: ~14 rows (approximately)
INSERT INTO `allowances` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Responsibility Allowance', 'percentage', 12.50, '2023-11-01 12:27:16', '2023-11-01 12:27:16'),
	(2, 4, 'Transport Subsidies', 'percentage', 15.00, '2023-11-01 12:28:12', '2023-11-01 12:28:12'),
	(3, 4, 'Lunch Subsidy', 'percentage', 12.50, '2023-11-01 12:29:02', '2023-11-01 12:29:02'),
	(4, 4, 'Clothing Allowance', 'fixed', 500.00, '2023-11-01 12:29:37', '2024-01-16 17:05:02'),
	(26, 3, 'Launch Subsidy', 'fixed', 200.00, '2024-01-15 08:51:06', '2024-01-15 08:51:06'),
	(27, 3, 'Clothing Allowance', 'fixed', 500.00, '2024-01-15 08:51:37', '2024-01-15 08:51:37'),
	(28, 3, 'Medical Allowance', 'percentage', 15.00, '2024-01-15 08:52:02', '2024-01-15 08:52:02'),
	(37, 4, 'Risk Allowance', 'percentage', 15.00, '2024-01-16 17:04:29', '2024-01-16 17:04:29'),
	(38, 127, 'House Allowance', 'fixed', 6000.00, '2024-03-13 08:15:06', '2024-03-13 08:15:06'),
	(39, 110, 'Travelling Allowance', 'fixed', 300.00, '2024-04-03 12:37:29', '2024-04-03 12:37:29'),
	(40, 110, 'Hotel Accommodation', 'fixed', 200.00, '2024-04-03 12:39:14', '2024-04-03 12:39:14'),
	(41, 110, 'Fuel Allowance', 'fixed', 150.00, '2024-04-03 12:44:27', '2024-04-03 12:44:27'),
	(42, 237, 'House Allowance', 'fixed', 5000.00, '2024-06-04 03:08:31', '2024-06-04 03:08:31'),
	(43, 238, 'House allowances', 'fixed', 5000.00, '2024-06-18 04:45:22', '2024-06-18 04:45:22');

-- Dumping structure for table comaziwa.annual_tax_rates
CREATE TABLE IF NOT EXISTS `annual_tax_rates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` int NOT NULL,
  `band_1` varchar(50) NOT NULL,
  `band_2` varchar(50) NOT NULL,
  `band_3` varchar(50) NOT NULL,
  `band_4` varchar(50) NOT NULL,
  `band_5` varchar(50) NOT NULL,
  `band_6` varchar(50) NOT NULL,
  `band_7` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table comaziwa.annual_tax_rates: ~2 rows (approximately)
INSERT INTO `annual_tax_rates` (`id`, `year`, `band_1`, `band_2`, `band_3`, `band_4`, `band_5`, `band_6`, `band_7`, `created_at`, `updated_at`) VALUES
	(1, 2023, '["402","0"]', '["110","5"]', '["130","10"]', '["3000","17.5"]', '["16395","25"]', '["20000","30"]', '["50000","35"]', '2024-03-26 00:16:17', '2024-03-26 00:16:17'),
	(2, 2024, '["490","0"]', '["110","5"]', '["130","10"]', '["3166.67","17.5"]', '["16000","25"]', '["30520","30"]', '["50000","35"]', '2024-03-25 23:49:22', '2024-03-25 23:49:22');

-- Dumping structure for table comaziwa.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `punch_in` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `punch_out` text COLLATE utf8mb4_unicode_ci,
  `punch_in_status` tinyint(1) NOT NULL DEFAULT '0',
  `punch_out_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `attendances_tenant_id_foreign` (`tenant_id`),
  KEY `attendances_employee_id_foreign` (`employee_id`),
  CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.attendances: ~30 rows (approximately)
INSERT INTO `attendances` (`id`, `created_at`, `updated_at`, `tenant_id`, `employee_id`, `date`, `punch_in`, `punch_out`, `punch_in_status`, `punch_out_status`) VALUES
	(3, '2024-02-06 10:44:32', '2024-02-06 10:44:32', 4, 158, '2024-02-06', '["2024-02-06 10:44:32"]', NULL, 1, 0),
	(4, '2024-02-12 09:04:34', '2024-02-12 09:04:34', 4, 172, '2024-02-12', '["2024-02-12 09:04:34"]', NULL, 1, 0),
	(5, '2024-02-13 08:17:22', '2024-02-13 08:17:22', 4, 172, '2024-02-13', '["2024-02-13 08:17:22"]', NULL, 1, 0),
	(6, '2024-02-14 09:45:43', '2024-02-14 09:47:26', 4, 172, '2024-02-14', '["2024-02-14 09:45:43","2024-02-14 09:47:26"]', '["2024-02-14 09:45:59"]', 1, 0),
	(7, '2024-02-15 08:24:10', '2024-02-15 08:24:36', 4, 172, '2024-02-15', '["2024-02-15 08:24:10","2024-02-15 08:24:36"]', '["2024-02-15 08:24:21"]', 1, 0),
	(8, '2024-02-17 10:18:44', '2024-02-17 10:18:53', 4, 172, '2024-02-17', '["2024-02-17 10:18:44"]', '["2024-02-17 10:18:53"]', 0, 1),
	(9, '2024-02-26 08:17:07', '2024-02-26 08:17:24', 158, 158, '2024-02-26', '["2024-02-26 08:17:07","2024-02-26 08:17:24"]', '["2024-02-26 08:17:19"]', 1, 0),
	(10, '2024-02-27 12:40:29', '2024-02-27 12:40:57', 158, 158, '2024-02-27', '["2024-02-27 12:40:29","2024-02-27 12:40:40"]', '["2024-02-27 12:40:34","2024-02-27 12:40:57"]', 0, 1),
	(11, '2024-03-04 08:00:47', '2024-03-04 08:00:47', 172, 172, '2024-03-04', '["2024-03-04 08:00:47"]', NULL, 1, 0),
	(12, '2024-03-05 12:56:19', '2024-03-05 12:56:19', 172, 172, '2024-03-05', '["2024-03-05 12:56:19"]', NULL, 1, 0),
	(13, '2024-03-08 07:55:06', '2024-03-08 07:55:06', 172, 172, '2024-03-08', '["2024-03-08 07:55:06"]', NULL, 1, 0),
	(14, '2024-03-12 10:02:39', '2024-03-12 10:02:56', 172, 172, '2024-03-12', '["2024-03-12 10:02:39"]', '["2024-03-12 10:02:56"]', 0, 1),
	(15, '2024-04-02 16:59:31', '2024-04-02 16:59:54', 162, 162, '2024-04-02', '["2024-04-02 16:59:31"]', '["2024-04-02 16:59:54"]', 0, 1),
	(16, '2024-04-03 12:35:07', '2024-04-03 12:35:24', 150, 150, '2024-04-03', '["2024-04-03 12:35:07"]', '["2024-04-03 12:35:24"]', 0, 1),
	(17, '2024-04-03 12:35:41', '2024-04-03 12:35:41', 172, 172, '2024-04-03', '["2024-04-03 12:35:41"]', NULL, 1, 0),
	(20, '2024-04-09 07:25:45', '2024-04-09 07:25:45', 162, 162, '2024-04-09', '["2024-04-09 07:25:45"]', NULL, 1, 0),
	(21, '2024-04-10 08:14:14', '2024-04-10 08:14:44', 162, 162, '2024-04-10', '["2024-04-10 08:14:14","2024-04-10 08:14:44"]', '["2024-04-10 08:14:30"]', 1, 0),
	(22, '2024-04-12 12:28:48', '2024-04-12 12:28:48', 162, 162, '2024-04-12', '["2024-04-12 12:28:48"]', NULL, 1, 0),
	(23, '2024-04-15 07:03:42', '2024-04-15 17:10:43', 162, 162, '2024-04-15', '["2024-04-15 07:03:42","2024-04-15 17:10:35"]', '["2024-04-15 07:03:49","2024-04-15 17:10:43"]', 0, 1),
	(24, '2024-04-16 07:10:16', '2024-04-16 07:10:16', 162, 162, '2024-04-16', '["2024-04-16 07:10:16"]', NULL, 1, 0),
	(25, '2024-04-17 07:03:29', '2024-04-17 07:03:29', 162, 162, '2024-04-17', '["2024-04-17 07:03:29"]', NULL, 1, 0),
	(26, '2024-04-18 06:45:22', '2024-04-18 06:45:22', 162, 162, '2024-04-18', '["2024-04-18 06:45:22"]', NULL, 1, 0),
	(27, '2024-04-19 07:21:07', '2024-04-19 07:21:07', 162, 162, '2024-04-19', '["2024-04-19 07:21:07"]', NULL, 1, 0),
	(28, '2024-04-22 07:11:26', '2024-04-22 07:11:26', 162, 162, '2024-04-22', '["2024-04-22 07:11:26"]', NULL, 1, 0),
	(29, '2024-04-22 11:42:21', '2024-04-22 11:42:21', 172, 172, '2024-04-22', '["2024-04-22 11:42:21"]', NULL, 1, 0),
	(30, '2024-04-23 07:09:27', '2024-04-23 07:09:27', 162, 162, '2024-04-23', '["2024-04-23 07:09:27"]', NULL, 1, 0),
	(31, '2024-04-25 08:51:14', '2024-04-25 08:51:21', 162, 162, '2024-04-25', '["2024-04-25 08:51:14"]', '["2024-04-25 08:51:21"]', 0, 1),
	(32, '2024-05-02 07:02:54', '2024-05-02 07:02:54', 162, 162, '2024-05-02', '["2024-05-02 07:02:54"]', NULL, 1, 0),
	(33, '2024-05-06 08:00:44', '2024-05-06 08:00:44', 162, 162, '2024-05-06', '["2024-05-06 08:00:44"]', NULL, 1, 0),
	(34, '2024-05-07 09:02:43', '2024-05-07 09:02:43', 162, 162, '2024-05-07', '["2024-05-07 09:02:43"]', NULL, 1, 0);

-- Dumping structure for table comaziwa.banks
CREATE TABLE IF NOT EXISTS `banks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banks_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `banks_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.banks: ~0 rows (approximately)
INSERT INTO `banks` (`id`, `tenant_id`, `bank_name`, `created_at`, `updated_at`) VALUES
	(1, 239, 'KCB', '2024-06-29 14:10:34', '2024-06-29 14:10:35');

-- Dumping structure for table comaziwa.benefits_in_kinds
CREATE TABLE IF NOT EXISTS `benefits_in_kinds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `benefits_in_kinds_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `benefits_in_kinds_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.benefits_in_kinds: ~5 rows (approximately)
INSERT INTO `benefits_in_kinds` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Company Vehicle Only', 'fixed', 500.00, '2023-11-03 11:00:58', '2023-11-03 11:00:58'),
	(2, 4, 'Fuel', 'fixed', 250.00, '2023-11-03 11:01:47', '2023-11-03 11:01:47'),
	(9, 4, 'Accommodation', 'fixed', 750.00, '2024-01-16 17:05:58', '2024-01-16 17:05:58'),
	(10, 237, 'Medical Cover', 'fixed', 50000.00, '2024-06-04 03:08:59', '2024-06-04 03:08:59'),
	(11, 238, 'Bonus', 'fixed', 1000.00, '2024-06-18 04:44:45', '2024-06-18 04:44:45');

-- Dumping structure for table comaziwa.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_cat_name_unique` (`cat_name`),
  KEY `categories_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.categories: ~3 rows (approximately)
INSERT INTO `categories` (`id`, `tenant_id`, `cat_name`, `description`, `created_at`, `updated_at`) VALUES
	(3, 239, 'Test Cate', NULL, '2024-07-02 14:55:05', '2024-07-02 14:55:05'),
	(4, 239, 'Molases', NULL, '2024-07-02 19:00:21', '2024-07-02 19:00:21'),
	(5, 239, 'Test Cat', NULL, '2024-07-02 19:38:52', '2024-07-02 19:38:52');

-- Dumping structure for table comaziwa.collection_centers
CREATE TABLE IF NOT EXISTS `collection_centers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `center_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grader_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collection_centers_center_name_unique` (`center_name`),
  KEY `collection_centers_tenant_id_foreign` (`tenant_id`),
  KEY `collection_centers_grader_id_foreign` (`grader_id`),
  CONSTRAINT `collection_centers_grader_id_foreign` FOREIGN KEY (`grader_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `collection_centers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.collection_centers: ~2 rows (approximately)
INSERT INTO `collection_centers` (`id`, `tenant_id`, `center_name`, `grader_id`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Makima', 180, '2024-06-29 10:46:48', '2024-06-29 10:46:48'),
	(2, 239, 'Makimaa', 180, '2024-06-29 10:47:30', '2024-06-29 10:47:30');

-- Dumping structure for table comaziwa.company_profiles
CREATE TABLE IF NOT EXISTS `company_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssni_est` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `land_line` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_settings` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2024',
  PRIMARY KEY (`id`),
  KEY `company_profiles_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `company_profiles_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.company_profiles: ~6 rows (approximately)
INSERT INTO `company_profiles` (`id`, `tenant_id`, `name`, `ssni_est`, `address`, `email`, `tel_no`, `logo`, `created_at`, `updated_at`, `tin`, `secondary_email`, `land_line`, `tax_settings`) VALUES
	(1, 3, 'KACANN', 'CO20064587', '58 Nsawam Road', 'KAKYEA@YAHOO.COM', '+233302974302', '24390878.jpg', '2023-11-01 10:44:40', '2024-01-15 08:46:17', 'CO20064587', 'KAKYEA@YAHOO.COM', '+233302974302', '2'),
	(2, 4, 'JPCANN ASSOCIATES LIMITED', 'JPCANN ASSOCIATES LIMITED', '58 NSAWAM ROAD, KOKOMLEMLE, ACCRA', 'info@jpcannassociates.com', '0501335818', '2131164496.jpg', '2023-11-01 10:51:40', '2024-01-15 14:48:06', 'JPCANN ASSOCIATES LIMITED', 'info@jpcannassociates.com', '0302974302', '2'),
	(24, 110, 'Cannyzer Global Enterprise', 'A047709180038', 'Elephant Street, Amasaman', 'cannyzer1@gmail.com', '+233545950291', '1928435423.jpg', '2024-01-18 12:02:21', '2024-01-18 12:02:21', 'P00 01812785', 'cannyzer1@gmail.com', NULL, '2'),
	(25, 127, 'Fort Sort Innovations LTD', 'K3494234U', 'Westcom Point, Westlands', 'daniel.mutuku404@gmail.com', '0717576900', '1492730179.png', '2024-02-12 06:31:05', '2024-02-13 01:24:19', 'FKN34KK43', 'daniel.mutuku404@gmail.com', '4828838834', '2'),
	(41, 237, 'Coding Sniper', '765', '109', 'it@cowango.org', '0746054572', '', '2024-06-04 02:52:10', '2024-06-04 02:52:10', '456', 'ancentmbithi8@gmail.com', '00012', '2'),
	(42, 238, 'Newdawn Nonwoven', 'NFTGHJT56EDF344', '24779 00100', 'dedank660@gmail.com', '0724654191', '', '2024-06-18 04:27:10', '2024-06-18 04:27:10', '455FTDSEFGGYU67', 'dedank660@gmail.com', NULL, '2024'),
	(43, 239, 'Ancent', '244343', 'Moi Avenue, Nairobi-Kenya.', 'testmeail@ancent.com', '0747954284', '', '2024-06-29 05:28:27', '2024-06-29 05:28:27', 'Fortsort', 'testmfail@ancent.com', '0450012', '2024');

-- Dumping structure for table comaziwa.contracts
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contracts_tenant_id_foreign` (`tenant_id`),
  KEY `contracts_employee_id_foreign` (`employee_id`),
  CONSTRAINT `contracts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contracts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.contracts: ~4 rows (approximately)
INSERT INTO `contracts` (`id`, `tenant_id`, `employee_id`, `file`, `created_at`, `updated_at`) VALUES
	(1, 4, 13, 'Jonathan-prince-cann-.pdf', '2023-11-03 11:11:36', '2023-11-03 11:11:36'),
	(3, 238, 179, 'Liz-kagotho-.xls', '2024-06-19 09:04:02', '2024-06-19 09:04:02'),
	(4, 238, 179, 'Liz-kagotho-.pdf', '2024-06-19 09:04:29', '2024-06-19 09:04:29'),
	(5, 127, 174, 'Daniel-mutuku-.pdf', '2024-06-25 00:13:45', '2024-06-25 00:13:45');

-- Dumping structure for table comaziwa.contract_types
CREATE TABLE IF NOT EXISTS `contract_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `contract_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.contract_types: ~22 rows (approximately)
INSERT INTO `contract_types` (`id`, `tenant_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Corporate Office', '2023-11-01 12:23:15', '2023-11-01 12:23:15'),
	(2, 4, 'Business Development', '2023-11-01 12:23:25', '2023-11-01 12:23:25'),
	(3, 4, 'Business Advisory', '2023-11-01 12:23:35', '2023-11-01 12:23:35'),
	(4, 4, 'Operations', '2023-11-01 12:23:41', '2023-11-01 12:23:41'),
	(5, 4, 'IT & Media', '2023-11-01 12:23:58', '2023-11-01 12:23:58'),
	(6, 4, 'Account & Finance', '2023-11-01 12:24:11', '2023-11-01 12:24:11'),
	(7, 4, 'Training Support', '2023-11-01 12:24:33', '2023-11-01 12:24:33'),
	(36, 3, 'Finance and Accounts', '2024-01-15 08:47:24', '2024-01-15 08:47:24'),
	(37, 3, 'Marketing', '2024-01-15 08:47:31', '2024-01-15 08:47:31'),
	(43, 110, 'Administration Department', '2024-01-20 11:50:48', '2024-01-20 11:53:13'),
	(44, 110, 'Account Department', '2024-01-20 11:51:30', '2024-01-20 11:51:30'),
	(45, 110, 'Health and safety Department', '2024-01-20 11:51:59', '2024-01-20 11:51:59'),
	(46, 110, 'Human Resource Department', '2024-01-20 11:52:35', '2024-01-20 11:52:35'),
	(47, 110, 'Human Resource Department', '2024-01-20 11:52:35', '2024-01-20 11:52:35'),
	(48, 127, 'Tech', '2024-02-12 06:35:40', '2024-02-12 06:35:40'),
	(49, 237, 'IT Department', '2024-06-04 03:10:09', '2024-06-04 03:10:09'),
	(50, 238, 'ICT', '2024-06-18 04:38:52', '2024-06-18 04:38:52'),
	(51, 238, 'Production', '2024-06-18 04:39:03', '2024-06-18 04:39:03'),
	(52, 238, 'Reception', '2024-06-18 04:39:22', '2024-06-18 04:39:22'),
	(53, 238, 'Sales & Marketing', '2024-06-18 04:39:43', '2024-06-18 04:39:43'),
	(54, 238, 'Embroidery', '2024-06-18 04:39:58', '2024-06-18 04:39:58'),
	(55, 238, 'Management', '2024-06-19 09:16:47', '2024-06-19 09:16:47'),
	(56, 239, 'Milk Collection', '2024-06-29 09:57:58', '2024-06-29 09:57:58'),
	(57, 239, 'Administration', '2024-06-29 09:58:08', '2024-06-29 09:58:08');

-- Dumping structure for table comaziwa.deductions
CREATE TABLE IF NOT EXISTS `deductions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deductions_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `deductions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.deductions: ~0 rows (approximately)

-- Dumping structure for table comaziwa.emails
CREATE TABLE IF NOT EXISTS `emails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emails_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `emails_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.emails: ~27 rows (approximately)
INSERT INTO `emails` (`id`, `tenant_id`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
	(1, 110, 'chriscann2023@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:40', '2024-02-07 11:42:40'),
	(2, 110, 'joefoli.jf5@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:40', '2024-02-07 11:42:40'),
	(3, 110, 'chriscann2023@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:42', '2024-02-07 11:42:42'),
	(4, 110, 'joefoli.jf5@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:42', '2024-02-07 11:42:42'),
	(5, 4, 'sandys.lartey@jpcannassociates.com', 'TRAINING ON FULL STCK DEVELOPMENT', 'Please advise on dates you will be ready for a training on Full Stack Development and programming.\r\nRegards\r\nJonathan', 0, '2024-03-12 08:54:11', '2024-03-12 08:54:11'),
	(6, 4, 'tracey.cann@jpcannassociates.com', 'TRAINING ON FULL STCK DEVELOPMENT', 'Please advise on dates you will be ready for a training on Full Stack Development and programming.\r\nRegards\r\nJonathan', 0, '2024-03-12 08:54:11', '2024-03-12 08:54:11'),
	(7, 4, 'edmund.toffey@jpcannassociates.com', 'TRAINING ON FULL STCK DEVELOPMENT', 'Please advise on dates you will be ready for a training on Full Stack Development and programming.\r\nRegards\r\nJonathan', 0, '2024-03-12 08:54:11', '2024-03-12 08:54:11'),
	(8, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:41', '2024-03-25 10:07:41'),
	(9, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:47', '2024-03-25 10:07:47'),
	(10, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:49', '2024-03-25 10:07:49'),
	(11, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:51', '2024-03-25 10:07:51'),
	(12, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:51', '2024-03-25 10:07:51'),
	(13, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:54', '2024-03-25 10:07:54'),
	(14, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:54', '2024-03-25 10:07:54'),
	(15, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:55', '2024-03-25 10:07:55'),
	(16, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:58', '2024-03-25 10:07:58'),
	(17, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:07:58', '2024-03-25 10:07:58'),
	(18, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:01', '2024-03-25 10:08:01'),
	(19, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:02', '2024-03-25 10:08:02'),
	(20, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:02', '2024-03-25 10:08:02'),
	(21, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:05', '2024-03-25 10:08:05'),
	(22, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:19', '2024-03-25 10:08:19'),
	(23, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:19', '2024-03-25 10:08:19'),
	(24, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:20', '2024-03-25 10:08:20'),
	(25, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:21', '2024-03-25 10:08:21'),
	(26, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:24', '2024-03-25 10:08:24'),
	(27, 4, 'edmund.toffey@jpcannassoiates.com', 'work', 'Dear StaffBe notified that your February 2024 Salary has been paid to your designated bank.Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.RegardsManagement', 0, '2024-03-25 10:08:24', '2024-03-25 10:08:24');

-- Dumping structure for table comaziwa.email_settings
CREATE TABLE IF NOT EXISTS `email_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_security` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_settings_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `email_settings_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.email_settings: ~0 rows (approximately)

-- Dumping structure for table comaziwa.email_templates
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_templates_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `email_templates_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.email_templates: ~0 rows (approximately)
INSERT INTO `email_templates` (`id`, `tenant_id`, `name`, `template`, `created_at`, `updated_at`) VALUES
	(4, 4, 'Monthly Salary Payment - February 2024', '<p>Dear Staff</p><p>Be notified that your February 2024 Salary has been paid to your designated bank.</p><p>Kindly ensure that you have received such. If there are any challenges after 3 days kindly alert HR and Finance to follow up on your behalf.</p><p>Regards</p><p>Management</p>', '2024-03-12 09:00:12', '2024-03-12 09:00:12');

-- Dumping structure for table comaziwa.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_shortcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type` bigint unsigned NOT NULL DEFAULT '0',
  `nok_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nok_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin_configured` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  UNIQUE KEY `employees_phone_no_unique` (`phone_no`),
  UNIQUE KEY `employees_staff_no_unique` (`staff_no`),
  UNIQUE KEY `employees_ssn_unique` (`ssn`),
  UNIQUE KEY `employees_account_no_unique` (`account_no`),
  KEY `employees_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `employees_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.employees: ~25 rows (approximately)
INSERT INTO `employees` (`id`, `tenant_id`, `name`, `email`, `phone_no`, `staff_no`, `position`, `dob`, `bank_name`, `branch_name`, `branch_shortcode`, `account_no`, `created_at`, `updated_at`, `password`, `ssn`, `contract_type`, `nok_name`, `nok_phone`, `address`, `is_admin_configured`) VALUES
	(13, 4, 'JONATHAN PRINCE CANN', 'j.cann@jpcannassociates.com', '+233241121761', 'JPC1001', 'CEO', '1980-11-03', 'ECOBANK', 'Ring Road', '4006', '400645878952', '2023-11-03 10:54:29', '2024-04-04 09:27:56', '$2y$10$p99vVFO/49YGV6hsm9zN2.rqKGtZA/fI07UoHMj7gcwRDbh.PdlLG', 'CO1254879', 1, 'JO GYATA', '+23345698745', '58 NSAWAM ROAD', 1),
	(14, 4, 'Sandys Lartey', 'sandys.lartey@jpcannassociates.com', '0504249800', 'JPC1004', 'IT Manager', '1988-11-22', 'Stanbic', 'NIA', '10021', '9040000529405', '2023-11-03 13:09:44', '2024-04-05 07:19:02', '$2y$10$SOe.rMIO2X4eo.22CWUGUuasFtEryvIjMiQXH3sMMkOHaNrWbE0Iq', 'CB389854652', 5, 'Sandra Lartey', '+233248294863', NULL, 0),
	(15, 4, 'Tracey Cann', 'tracey.cann@jpcannassociates.com', '0501335818', 'JPC1002', 'Director, Business Development', '1981-06-10', 'UBA', 'Ring', '7005', '876985224', '2023-11-03 13:14:47', '2024-03-01 09:46:17', '$2y$10$ZY66.hF0TaqwhxApbYoVYurfJ.LLifn5JneBVwaoLUH7/pvC4PWCK', 'CC45258577', 0, 'Kirtsy', '0501626969', '51 Lower McCarthy Hill', 1),
	(22, 4, 'Benjamin Laryea', 'benjamin.laryea@jpcannassociates.com', '0501457253', 'JPC1006', 'Account and logistics Officer', '1992-06-09', 'Stanbic', 'Makola', '1007', '9040003311884', '2023-11-21 11:48:15', '2024-04-04 09:25:13', '$2y$10$SikWJ6oE5Ik2KVah7cFd8uNqC/7q8isrTMg6aC0lqXqaqycgHiVaa', '30818E08839', 6, 'Joshua Laryea', '0272623315', 'A66/5 Chorkor Chemunaa', 0),
	(149, 3, 'Enoch Mensah', 'enoch.mensah@jpcannassociates.com', '+233302974302', 'OGSL10001', 'Finance Officer', '1975-02-12', 'Stanbic Bank Ghana', 'ATUABO', '10023', '40054789545', '2024-01-15 08:48:07', '2024-01-15 08:48:07', '$2y$10$HlkvvD9/HWLtd93TXFODs.kxwxju3DL.UaUnzS5ysvkehneXx9ZdO', 'SE5466998788', 0, 'Indhira Ghandi', '+233111111111', '58 Nsawam Road', 0),
	(150, 4, 'Ernest Awuku', 'ernest.awuku@jpcannassociates.com', '+233244218288', 'JPC1007', 'Training Operations Manager', '1981-11-21', 'ABSA', 'Dansoman', '30107', '1065081', '2024-01-15 14:47:25', '2024-04-03 12:50:14', '$2y$10$ZvQ/FWDRFugphZ9ZBjJPoOMRbjJ9I2xUga0.z2ZcHMpTF6uStg2/G', 'C018111210112', 7, 'Brianna Nana Ama Awukubea Awuku', '+233244218288', 'No. A140/4, Kelee Street, Laterbiokoshie', 0),
	(155, 4, 'Elma Johnson', 'elma.johnson@jpcannassociates.com', '0501637305', 'JPC1008', 'Senior Business Development Officer', '1988-04-20', 'Stanbic', 'Accra Main', '190101', '9040000094778', '2024-01-16 17:18:40', '2024-04-09 08:40:05', '$2y$10$C1C0VLf/Y6KnGycBjvjmGuOHbWYAYKoIJ7dS6bcYQSvkwvpOGMTxy', 'JP100001545', 2, 'Micheal Johnson', 'Micheal Johnson', NULL, 0),
	(156, 4, 'Prince Amazing Diamond', 'prince.diamond@jpcannassociates.com', '+233504249700', '1009', 'Senior Business Development Officer', '1986-07-22', 'Stanbic', 'NIA', '190105', '9040004359512', '2024-01-16 17:18:43', '2024-04-03 16:00:20', '$2y$10$GOi42hpnIn84MwYnuq7QI.CwJ.pZnSqwRz/xmtB1pYldRUkTQ52KG', 'D138607220012', 0, 'Bless Kofi Diamond', 'Bless Kofi Diamond', NULL, 0),
	(157, 4, 'Gabriel Gyimah', 'gabriel.gyimah@jpcannassociates.com', '+233501335819', 'JPC1010', 'Transport Officer', '', 'UMB', 'Accra Main', '100101', '0022056217014', '2024-01-16 17:18:45', '2024-01-16 17:18:45', '$2y$10$OPPfOft9sRrbXU.QP76IPeZtOCldmY1rvOySsI9QDko2NV7Mdk9O.', 'JP100001547', 0, 'Comfort Gyimah', 'Comfort Gyimah', NULL, 0),
	(158, 4, 'Emmanuel Brako Apau', 'emmanuel.brakoapau@jpcannassociates.com', '+233501454082', 'JPC1011', 'IT Support Officer', '1993-07-08', 'Stanbic', 'Accra Mall', '190104', '9040009529556', '2024-01-16 17:18:46', '2024-04-03 11:42:36', '$2y$10$3FgTmRijNBNTuaMgW9YmyeK1aHcrOgCrgGsW9QYgisLDqHsWHuEda', 'GHA712274553', 0, 'Samuel Odei Apau', 'Samuel Odei Apau', NULL, 1),
	(159, 4, 'Dorinda Osei Baffour', 'dorinda.oseibaffour@jpcannassociates.com', '+233501622082', 'JPC1013', 'Senior Administrative Assistance', '1996-05-21', 'First Atlantic', 'Head Office', '170101', '0087412701010', '2024-01-16 17:18:47', '2024-04-03 14:36:37', '$2y$10$R7r.j1qmyFTkGDBXeZ11GeQYP7/1OZZ.Pdm13NthjirqsEWjXRz9G', 'JP100001548', 0, 'Stephen Osei sarfo Ntow', 'Stephen Osei sarfo Ntow', NULL, 0),
	(160, 4, 'Ato Amakye Sam', 'atoamakye.sam@jpcannassociates.com', '+233501569736', 'JPC1014', 'Business Advisory Officer', '1995-06-17', 'Stanbic Bank Ghana', 'Tema Community 1', '190118', '9040008697471', '2024-01-16 17:18:49', '2024-04-03 14:36:47', '$2y$10$jeq6hobfaoaXN2xBUKVU3u.a43cZflldRtnqlrKpBTn9gFe20lkry', 'GHA-717809634-9', 0, 'Esi Kum Sam', 'Esi Kum Sam', 'Winneba', 0),
	(161, 4, 'Evans Archer Fevlo', 'evansarcher.fevlo@jpcannassociates.com', '+233501622081', 'JPC1015', 'Multi Media and Web Designer', '1991-03-16', 'Access', 'Sefwi Wiawso', '280403', '0301628115571', '2024-01-16 17:18:50', '2024-04-03 16:24:23', '$2y$10$p1sEASFSxzLkbI.vbZvpvex3wruv9mQ1aFz58RBoV41seJzgTHpry', 'JP100001549', 0, 'Mary Fevlo', 'Mary Fevlo', 'Kotobabi, Accra', 0),
	(162, 4, 'Mary Arum Arum', 'mary.arum@jpcannassociates.com', '+233500788300', 'JPC1016', 'Training Support Officer', '2002-06-15', 'GCB', 'Circle', '40127', '1391010040912', '2024-01-16 17:18:51', '2024-04-02 16:58:43', '$2y$10$FqqH9K2rw6K1gvxGxm32Qe9CASrfggwWvYEaaQFSBwWcVHL/6gKQC', 'GHA-727404962', 0, 'Houma Ruth Charles', '0548293144', 'Madina- Upsa( Sel Fuel Station)', 0),
	(163, 4, 'Samuel Nanka-Bruce', 'samuel.bruce@jpcannassociates.com', '+233543965319', 'JPC1017', 'Security', '', 'Stanbic', 'Dansoman', '190116', '9040006882425', '2024-01-16 17:18:52', '2024-01-16 17:18:52', '$2y$10$Jq.Rb6T13XTB.W5bra3DG.MqvjpZE/Vy/BD9q8MUMd4MRpAtJHlL6', 'JP100001550', 0, 'Victor Nanka-Bruce', 'Victor Nanka-Bruce', NULL, 0),
	(164, 110, 'Christine Mawutor Folikorkor', 'chriscann2023@gmail.com', '0242819122', '1733668', 'Head of administration', '1986-10-27', 'Absa Bank', 'Hohoe Branch', '040', '0401016023', '2024-01-20 12:11:49', '2024-01-20 12:11:49', '$2y$10$hSLSODTwr4ktusOw0p3LK.H0yHfW64fwQgH4vOmgJZzuuRRDWIBOS', 'D068610270046', 0, 'Joseph Folikorkor', '0257128544', 'Elephant Street, Amasaman', 0),
	(165, 110, 'Joseph Yao Folikorkor', 'joefoli.jf5@gmail.com', '0257128544', '4834090', 'Head of Safety', '1988-06-16', 'Stanbic Bank', 'Achimota Mall', '904', '9040011109092', '2024-01-20 13:01:23', '2024-01-20 13:01:23', '$2y$10$3PM4J6.1h6y6PgaT9OKpRuVXzIqIYB4TwDTG7DQNIUFX5uEPEAg5a', 'D068806160034', 0, 'Daniel Folikorkor', '0249718532', 'Elephant Street, Amasaman', 0),
	(170, 110, 'Ruth Cann', 'Ruth.cann@mofad.gov.gh', '0244632515', '5023090', 'Human Resource manager', '1980-10-22', 'Stanbic Bank', 'Achimota Mall', '904', '9040011108082', '2024-01-23 15:02:23', '2024-01-23 15:02:23', '$2y$10$v6d3pgXI84e91B97bDGCiexVcc/vLKlvYSOqAtVKrjzD3Xibc1.7y', 'D068610280045', 0, 'Emmanuel Cann', '+233 24 425 4878', 'Dansoman ssnit flats', 0),
	(171, 4, 'Francis Tagoe', 'francis.tagoe@jpcannassociates.com', '0501454083', 'JPC19988', 'Assistant Manager, Business Development', '1989-12-03', 'Stanbic', 'NIA', '10021', '9040002634389', '2024-01-29 11:23:42', '2024-04-15 07:50:15', '$2y$10$3AzpjfMJIXxCBQ55hefRsuJuKj5vnVUYMnKUM48oox1UrIstdwZHy', 'JP10066666', 0, 'Priscilla Tagoe', '0557354118', 'Homowo Street', 0),
	(172, 4, 'Edmund Toffey', 'edmund.toffey@jpcannassociates.com', '0202368640', 'JPC1045', 'NSP IT', '2001-01-30', 'ADB', 'SPINTEX', '5001', '2546669988', '2024-01-29 12:16:58', '2024-03-01 09:49:22', '$2y$10$nn75ayAWdsH/TM1.aVOs7uFHZPECE6BwpFOASVSCuFHSlhx9KLyNm', 'CX125455455', 5, 'EDWIN TOFFEY', '0240128940', '75 MINISTRIES ROAD', 1),
	(174, 127, 'Daniel Mutuku', 'daniel.mutuku404@gmail.com', '0717576900', '5204679', 'Software Developer', '2024-02-12', 'Equity', 'Nairobi', '063', '0392439434043', '2024-02-12 06:46:39', '2024-02-20 21:00:01', '$2y$10$RGGKM8N.RThVCBi4FYMtVOpV2YzSFInpbQ3d2fq2hHLx7n8Suczuy', 'SDSK44NVKD3', 0, 'Fred', '0717576900', 'Westcom Point, Westlands', 1),
	(176, 127, 'Ancent Mario', 'ancentmbithi8@gmail.com', '0795974284', '8796679', 'IT officer', '2024-02-25', 'KCB', 'Nairobi', '215', '1271223300', '2024-03-13 08:23:20', '2024-04-05 16:18:55', '$2y$10$vWopJdf7nt0ZMKXU8NfCTeH12P9h4HSQ450A6fsH/bF/E2WPJE9zK', '400785', 0, 'Maxwell', '0747954284', 'Moi Avenue, Nairobi-Kenya.', 0),
	(177, 4, 'Jona Cann', 'jonathan.cann@jpcannassociates.com', '0501335817', '7650241', 'COORDINATOR', '1971-03-01', 'Ecobank', 'Ridge', '124555', '140002545878', '2024-04-04 09:46:12', '2024-04-04 09:48:25', '$2y$10$u/PrbSIejFjLdA65kSlJ8evf3YOY0wG/uabdqyjN28ROd.NZ3ds/y', 'SE25478988', 0, 'Peter', '+233501335817', '58 Nsawam Road', 1),
	(178, 237, 'Ancent Mwalyo', 'marionmbithi@gmail.com', '0705974284', '3028777', 'Software Developer', '2000-02-04', 'KCB', 'Nairobi', '215', '12712233001', '2024-06-04 03:12:57', '2024-06-04 03:12:57', '$2y$10$3TQ0NqdH/Nsck.vjRqtHmOk8gyf1GM4yMU5D/XixJpfAjBJtlvxK.', '100987', 0, 'Majesty', '0729303852', '759', 0),
	(179, 238, 'LIZ KAGOTHO', 'liz@gmail.com', '0725452430', '8636122', 'operator', '1995-05-19', 'family bank', 'limuru', '000', '047000011111', '2024-06-19 08:57:30', '2024-06-19 08:57:30', '$2y$10$aUHk6Ct0Dv6OLHxpPUakb.3VwWRZv.0d1XgUyG9pWGE//pWBZE.zy', '111', 0, 'kagotho', '0', '0', 0),
	(180, 239, 'Milk Grader', 'ancent.mario8@gmail.com', '0747954284', '5899136', 'Grader', '2024-06-01', 'KCB', 'Nairobi', '215', '000401223345', '2024-06-29 09:59:34', '2024-06-29 09:59:34', '$2y$10$yeoQpBRpmFRRxwP8SIuxF.hkkiLV5QbmnI1PLwFxd/QlwdPly32oq', '45456785', 0, 'Majesty', '0729303852', 'Moi Avenue, Nairobi-Kenya.', 0);

-- Dumping structure for table comaziwa.employee_groups
CREATE TABLE IF NOT EXISTS `employee_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_salary` double(8,2) NOT NULL,
  `max_salary` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_groups_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `employee_groups_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.employee_groups: ~0 rows (approximately)

-- Dumping structure for table comaziwa.employee_payslips
CREATE TABLE IF NOT EXISTS `employee_payslips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `source_id` bigint unsigned NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `itemvalue` double(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `employee_payslips_employee_id_foreign` (`employee_id`),
  CONSTRAINT `employee_payslips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.employee_payslips: ~92 rows (approximately)
INSERT INTO `employee_payslips` (`id`, `employee_id`, `source_id`, `type`, `value`, `created_at`, `updated_at`, `itemvalue`) VALUES
	(1, 13, 0, 'basic_salary', 1000.00, '2023-11-03 10:57:15', '2024-01-29 15:50:22', 0.00),
	(2, 13, 1, 'allowance', 150.00, '2023-11-03 10:57:15', '2024-01-29 15:50:22', 15.00),
	(3, 13, 2, 'allowance', 100.00, '2023-11-03 10:57:15', '2024-01-29 15:50:22', 10.00),
	(4, 13, 3, 'allowance', 125.00, '2023-11-03 10:57:15', '2024-01-29 15:50:22', 12.50),
	(5, 13, 4, 'allowance', 500.00, '2023-11-03 10:57:15', '2024-02-06 08:33:08', 500.00),
	(6, 13, 1, 'statutory_ded', 55.00, '2023-11-03 10:57:15', '2024-01-29 15:50:22', 5.50),
	(7, 13, 1, 'nonstatutory_ded', 50.00, '2023-11-03 10:57:15', '2023-11-03 10:57:15', 50.00),
	(8, 14, 0, 'basic_salary', 1000.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 0.00),
	(9, 14, 1, 'allowance', 0.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 0.00),
	(10, 14, 2, 'allowance', 0.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 0.00),
	(11, 14, 3, 'allowance', 0.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 0.00),
	(12, 14, 4, 'allowance', 350.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 350.00),
	(13, 14, 1, 'benefit', 500.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 500.00),
	(14, 14, 2, 'benefit', 250.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 250.00),
	(15, 14, 1, 'statutory_ded', 0.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 0.00),
	(16, 14, 1, 'nonstatutory_ded', 50.00, '2023-11-03 13:09:59', '2023-11-03 13:09:59', 50.00),
	(17, 15, 0, 'basic_salary', 1000.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 0.00),
	(18, 15, 1, 'allowance', 0.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 0.00),
	(19, 15, 2, 'allowance', 0.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 0.00),
	(20, 15, 3, 'allowance', 0.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 0.00),
	(21, 15, 4, 'allowance', 350.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 350.00),
	(22, 15, 1, 'benefit', 500.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 500.00),
	(23, 15, 2, 'benefit', 250.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 250.00),
	(24, 15, 1, 'statutory_ded', 0.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 0.00),
	(25, 15, 1, 'nonstatutory_ded', 50.00, '2023-11-03 13:15:02', '2023-11-03 13:15:02', 50.00),
	(59, 22, 0, 'basic_salary', 1500.00, '2023-11-21 12:04:35', '2023-11-21 12:06:03', 0.00),
	(60, 22, 1, 'allowance', 75.00, '2023-11-21 12:04:35', '2023-11-21 12:06:03', 5.00),
	(61, 22, 2, 'allowance', 150.00, '2023-11-21 12:04:35', '2023-11-21 12:06:03', 10.00),
	(62, 22, 3, 'allowance', 150.00, '2023-11-21 12:04:35', '2023-11-21 12:06:03', 10.00),
	(63, 22, 4, 'allowance', 350.00, '2023-11-21 12:04:35', '2023-11-21 12:04:35', 350.00),
	(64, 22, 1, 'benefit', 500.00, '2023-11-21 12:04:35', '2023-11-21 12:04:35', 500.00),
	(65, 22, 2, 'benefit', 250.00, '2023-11-21 12:04:35', '2023-11-21 12:04:35', 250.00),
	(66, 22, 1, 'statutory_ded', 82.50, '2023-11-21 12:04:35', '2023-11-21 12:06:03', 5.50),
	(67, 22, 1, 'nonstatutory_ded', 100.00, '2023-11-21 12:04:35', '2023-11-21 12:04:35', 100.00),
	(69, 149, 0, 'basic_salary', 1000.00, '2024-01-15 08:49:02', '2024-01-15 08:49:02', 0.00),
	(70, 149, 26, 'allowance', 200.00, '2024-01-15 08:54:37', '2024-01-15 08:54:37', 200.00),
	(71, 149, 27, 'allowance', 500.00, '2024-01-15 08:54:37', '2024-01-15 08:54:37', 500.00),
	(72, 149, 28, 'allowance', 150.00, '2024-01-15 08:54:37', '2024-01-15 08:54:37', 150.00),
	(73, 149, 12, 'statutory_ded', 55.00, '2024-01-15 08:54:37', '2024-01-15 08:54:37', 55.00),
	(74, 149, 13, 'statutory_ded', 10.00, '2024-01-15 08:54:37', '2024-01-15 08:54:37', 10.00),
	(83, 150, 0, 'basic_salary', 1000.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 0.00),
	(84, 150, 1, 'allowance', 150.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 15.00),
	(85, 150, 2, 'allowance', 150.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 15.00),
	(86, 150, 3, 'allowance', 100.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 10.00),
	(87, 150, 4, 'allowance', 500.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 500.00),
	(88, 150, 37, 'allowance', 50.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 5.00),
	(89, 150, 1, 'benefit', 500.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 500.00),
	(90, 150, 2, 'benefit', 250.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 250.00),
	(91, 150, 9, 'benefit', 750.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 750.00),
	(92, 150, 1, 'statutory_ded', 55.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 5.50),
	(93, 150, 1, 'nonstatutory_ded', 50.00, '2024-01-16 17:16:02', '2024-01-16 17:16:02', 50.00),
	(94, 164, 0, 'basic_salary', 1000.00, '2024-01-20 12:16:17', '2024-01-20 12:16:17', 0.00),
	(95, 165, 0, 'basic_salary', 1300.00, '2024-01-20 13:01:58', '2024-01-20 13:01:58', 0.00),
	(96, 170, 0, 'basic_salary', 3000.00, '2024-01-23 15:06:16', '2024-01-23 15:06:16', 0.00),
	(97, 170, 14, 'statutory_ded', 0.00, '2024-01-23 15:06:16', '2024-01-23 15:06:16', 0.00),
	(98, 171, 0, 'basic_salary', 1000.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 0.00),
	(99, 171, 1, 'allowance', 50.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 5.00),
	(100, 171, 2, 'allowance', 120.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 12.00),
	(101, 171, 3, 'allowance', 150.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 15.00),
	(102, 171, 4, 'allowance', 500.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 500.00),
	(103, 171, 37, 'allowance', 55.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 5.50),
	(104, 171, 1, 'benefit', 500.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 500.00),
	(105, 171, 2, 'benefit', 250.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 250.00),
	(106, 171, 9, 'benefit', 750.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 750.00),
	(107, 171, 1, 'statutory_ded', 55.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 5.50),
	(108, 171, 1, 'nonstatutory_ded', 50.00, '2024-01-29 11:30:15', '2024-01-29 11:30:15', 50.00),
	(109, 171, 2, 'nonstatutory_ded', 1000.00, '2024-01-29 11:34:38', '2024-01-29 11:39:58', 1000.00),
	(110, 171, 3, 'nonstatutory_ded', 50.00, '2024-01-29 11:39:58', '2024-01-29 11:39:58', 5.00),
	(111, 172, 0, 'basic_salary', 1000.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(112, 172, 1, 'allowance', 50.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 5.00),
	(113, 172, 2, 'allowance', 50.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 5.00),
	(114, 172, 3, 'allowance', 50.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 5.00),
	(115, 172, 4, 'allowance', 100.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 100.00),
	(116, 172, 37, 'allowance', 50.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 5.00),
	(117, 172, 1, 'benefit', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(118, 172, 2, 'benefit', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(119, 172, 9, 'benefit', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(120, 172, 1, 'statutory_ded', 55.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 5.50),
	(121, 172, 1, 'nonstatutory_ded', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(122, 172, 2, 'nonstatutory_ded', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(123, 172, 3, 'nonstatutory_ded', 0.00, '2024-01-29 12:18:54', '2024-01-29 12:18:54', 0.00),
	(124, 13, 37, 'allowance', 100.00, '2024-01-29 13:05:45', '2024-02-06 08:33:08', 10.00),
	(125, 13, 1, 'benefit', 500.00, '2024-01-29 13:05:45', '2024-01-29 13:05:45', 500.00),
	(126, 13, 2, 'benefit', 250.00, '2024-01-29 13:05:45', '2024-01-29 13:05:45', 250.00),
	(127, 13, 9, 'benefit', 750.00, '2024-01-29 13:05:45', '2024-01-29 13:05:45', 750.00),
	(128, 13, 2, 'nonstatutory_ded', 500.00, '2024-01-29 13:05:45', '2024-02-06 08:33:08', 500.00),
	(129, 13, 3, 'nonstatutory_ded', 50.00, '2024-01-29 13:05:45', '2024-01-29 15:50:22', 5.00),
	(131, 174, 0, 'basic_salary', 49999.99, '2024-02-12 06:46:52', '2024-02-12 06:46:52', 0.00),
	(132, 174, 15, 'statutory_ded', 2750.00, '2024-02-13 06:51:01', '2024-02-13 06:51:01', 2750.00),
	(135, 176, 0, 'basic_salary', 59999.97, '2024-03-13 08:23:44', '2024-03-13 08:23:44', 0.00),
	(136, 176, 38, 'allowance', 6000.00, '2024-03-13 08:23:44', '2024-03-13 08:23:44', 6000.00),
	(137, 176, 15, 'statutory_ded', 0.00, '2024-03-13 08:23:44', '2024-03-13 08:23:44', 0.00);

-- Dumping structure for table comaziwa.employee_permissions
CREATE TABLE IF NOT EXISTS `employee_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.employee_permissions: ~0 rows (approximately)

-- Dumping structure for table comaziwa.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `approval_status` tinyint(1) NOT NULL DEFAULT '0',
  `supervisor` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_tenant_id_foreign` (`tenant_id`),
  KEY `expenses_type_id_foreign` (`type_id`),
  KEY `expenses_employee_id_foreign` (`employee_id`),
  KEY `fk_supervisor` (`supervisor`),
  CONSTRAINT `expenses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_supervisor` FOREIGN KEY (`supervisor`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.expenses: ~13 rows (approximately)
INSERT INTO `expenses` (`id`, `tenant_id`, `type_id`, `employee_id`, `date`, `purpose`, `amount`, `payment_status`, `approval_status`, `supervisor`, `created_at`, `updated_at`) VALUES
	(4, 4, 4, 172, 'vist a client', 'vist a client', 150.00, 1, 1, NULL, '2024-01-29 14:02:53', '2024-01-29 14:05:53'),
	(5, 4, 3, 172, '2024-02-05', 'food to eat', 2000.00, 1, 1, NULL, '2024-02-05 15:02:01', '2024-02-06 12:28:35'),
	(6, 4, 1, 150, '2024-01-30', 'Training at Kumasi for SIC', 1500.00, 1, 1, NULL, '2024-02-06 12:29:03', '2024-02-26 16:13:51'),
	(7, 4, 6, 158, '2024-02-06', 'Fuel used in corporate errands.', 250.00, 1, 1, NULL, '2024-02-06 12:29:38', '2024-02-06 12:34:02'),
	(8, 127, 21, 174, '2024-02-13', 'dddddddddddddddddd', 200.00, 1, 1, NULL, '2024-02-19 19:13:00', '2024-02-19 19:13:54'),
	(9, 4, 2, 172, '2024-02-20', 'Testing', 150.00, 1, 1, NULL, '2024-02-19 19:21:33', '2024-02-26 16:13:40'),
	(10, 4, 10, 158, '2024-02-26', 'Compay errand', 100.00, 0, 2, NULL, '2024-02-27 12:46:03', '2024-03-13 12:28:49'),
	(11, 127, 21, 176, '2024-03-13', 'fffffffffffff', 200.00, 0, 0, NULL, '2024-03-13 08:30:48', '2024-03-13 08:30:48'),
	(12, 127, 21, 174, '2024-03-20', 'ssssssssssss', 80.00, 0, 0, 174, '2024-03-21 19:26:04', '2024-03-21 19:26:04'),
	(13, 4, 6, 158, '2024-03-22', 'drove to tema for a training. (test)', 150.00, 0, 1, 13, '2024-03-22 13:37:32', '2024-04-03 12:46:12'),
	(14, 4, 3, 158, '2024-03-22', 'bought food', 100.00, 0, 1, 172, '2024-03-22 13:42:46', '2024-05-13 08:05:43'),
	(15, 4, 1, 172, '2024-04-02', 'Working from Clients location', 250.00, 1, 1, 158, '2024-04-03 12:38:16', '2024-04-03 12:43:01'),
	(16, 4, 1, 172, '2024-04-23', 'to have a good sleep', 1500.00, 0, 0, 158, '2024-04-22 11:43:29', '2024-04-22 11:43:29');

-- Dumping structure for table comaziwa.expense_types
CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `expense_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.expense_types: ~15 rows (approximately)
INSERT INTO `expense_types` (`id`, `tenant_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Hotel Accommodation', '2023-11-01 12:24:51', '2023-11-01 12:24:51'),
	(2, 4, 'Transport Allowance', '2023-11-01 12:25:05', '2023-11-01 12:25:05'),
	(3, 4, 'Meals', '2023-11-01 12:25:16', '2023-11-01 12:25:16'),
	(4, 4, 'Medical Claims', '2023-11-01 12:25:26', '2023-11-01 12:25:26'),
	(6, 4, 'Fuel Allocation', '2023-11-21 12:55:37', '2023-11-21 12:55:37'),
	(8, 4, 'Overtime', '2023-11-21 12:56:11', '2023-11-21 12:56:11'),
	(10, 4, 'Per Diem', '2023-11-21 12:56:22', '2023-11-21 12:56:22'),
	(21, 127, 'Running Costs', '2024-02-19 19:12:35', '2024-02-19 19:12:35'),
	(22, 110, 'Travelling Expenses', '2024-04-03 12:45:33', '2024-04-03 12:45:33'),
	(23, 110, 'Accommodation Expenses', '2024-04-03 12:45:57', '2024-04-03 12:45:57'),
	(24, 237, 'Fuel', '2024-06-04 03:09:59', '2024-06-04 03:09:59'),
	(25, 238, 'Logistics', '2024-06-18 04:41:59', '2024-06-18 04:41:59'),
	(26, 238, 'Airtime', '2024-06-18 04:42:10', '2024-06-18 04:42:10'),
	(27, 238, 'Internet', '2024-06-18 04:42:21', '2024-06-18 04:42:21'),
	(28, 238, 'delivery', '2024-06-19 09:17:18', '2024-06-19 09:17:18');

-- Dumping structure for table comaziwa.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table comaziwa.farmers
CREATE TABLE IF NOT EXISTS `farmers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `farmerID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` date DEFAULT NULL,
  `dob` date NOT NULL,
  `center_id` bigint unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mpesa_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nok_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nok_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `farmers_farmerid_unique` (`farmerID`),
  KEY `farmers_tenant_id_foreign` (`tenant_id`),
  KEY `farmers_center_id_foreign` (`center_id`),
  KEY `farmers_bank_id_foreign` (`bank_id`),
  CONSTRAINT `farmers_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `farmers_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `farmers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.farmers: ~0 rows (approximately)
INSERT INTO `farmers` (`id`, `tenant_id`, `fname`, `mname`, `lname`, `id_number`, `farmerID`, `contact1`, `contact2`, `gender`, `join_date`, `dob`, `center_id`, `location`, `marital_status`, `status`, `education_level`, `bank_id`, `bank_branch`, `acc_name`, `acc_number`, `mpesa_number`, `nok_name`, `nok_phone`, `relationship`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Ancent', 'Njoki', 'Mutuma', '33366869', 'MDC/002', '099877788', '888888', 'male', '2024-06-03', '2024-05-27', 1, 'TRM', 'single', '1', '4', 1, 'Meru', 'Alice Nkatha', '44444444', '4444444444', 'Majesty', '0747954284', 'brother', '2024-06-29 14:02:10', '2024-07-01 02:57:09'),
	(2, 239, 'Philemon', NULL, 'Makori', '33366878', 'MDC/0023', '07869996886', NULL, 'Male', '2024-07-02', '2024-06-30', 1, 'MERU', 'single', '1', '4', 1, 'Embu', 'Alice Nkatha', '444444444454', '4444444444', 'Majesty', '0729303852', 'mother', '2024-07-01 02:54:40', '2024-07-01 02:54:40');

-- Dumping structure for table comaziwa.inventories
CREATE TABLE IF NOT EXISTS `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `buying_price` double(8,2) NOT NULL DEFAULT '0.00',
  `selling_price` double(8,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alert_quantity` double(8,2) NOT NULL DEFAULT '5.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventories_name_unique` (`name`),
  KEY `inventories_tenant_id_foreign` (`tenant_id`),
  KEY `inventories_category_id_foreign` (`category_id`),
  KEY `inventories_unit_id_foreign` (`unit_id`),
  KEY `inventories_created_by_foreign` (`created_by`),
  CONSTRAINT `inventories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventories_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `product_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.inventories: ~4 rows (approximately)
INSERT INTO `inventories` (`id`, `tenant_id`, `category_id`, `unit_id`, `name`, `quantity`, `buying_price`, `selling_price`, `status`, `created_by`, `created_at`, `updated_at`, `description`, `alert_quantity`) VALUES
	(1, 239, 3, 1, 'Credit Card', 12.00, 200.00, 300.00, '1', NULL, '2024-07-02 17:31:37', '2024-07-02 19:31:06', 'rrrrrrrrrrrr', 5.00),
	(2, 239, 4, 1, 'Molasses 20L', 23.00, 4500.00, 5000.00, '1', NULL, '2024-07-02 19:01:12', '2024-07-03 17:12:25', '44444444444', 5.00),
	(3, 239, 5, 3, 'Cat Feeds', 30.00, 590.00, 650.00, '1', NULL, '2024-07-03 15:42:08', '2024-07-03 15:52:35', NULL, 5.00),
	(4, 239, 3, 3, 'Kunta Kinte', 10.00, 990.00, 1200.00, '1', NULL, '2024-07-03 15:51:01', '2024-07-03 17:10:56', '4444', 5.00);

-- Dumping structure for table comaziwa.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.jobs: ~0 rows (approximately)

-- Dumping structure for table comaziwa.leaves
CREATE TABLE IF NOT EXISTS `leaves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remaining_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reasons` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `supervisor_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaves_tenant_id_foreign` (`tenant_id`),
  KEY `leaves_employee_id_foreign` (`employee_id`),
  KEY `fk_supervisor_id` (`supervisor_id`),
  CONSTRAINT `fk_supervisor_id` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `leaves_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.leaves: ~19 rows (approximately)
INSERT INTO `leaves` (`id`, `tenant_id`, `created_at`, `updated_at`, `employee_id`, `type`, `date_from`, `date_to`, `remaining_days`, `reasons`, `status`, `supervisor_id`) VALUES
	(24, 127, '2024-02-13 00:48:10', '2024-02-13 01:35:06', 174, '2', '2024-02-01', '2024-02-03', '21', 'jjjj', 1, NULL),
	(25, 127, '2024-02-19 19:36:19', '2024-02-19 19:51:00', 174, '2', '2024-02-19', '2024-02-21', '19', 'dsfkd', 1, NULL),
	(26, 127, '2024-02-19 20:21:02', '2024-02-20 18:34:16', 174, '2', '2024-02-24', '2024-02-27', '17', 'rrrrrrrrrrffffff', 0, NULL),
	(27, 127, '2024-02-19 20:21:33', '2024-02-20 18:32:43', 174, '1', '2024-02-20', '2024-02-25', '90', 'fffffffffffff', 0, NULL),
	(29, 127, '2024-02-20 10:48:05', '2024-02-20 10:48:05', 174, '1', '2024-02-21', '2024-02-24', '88', 'fffffffffffff', 0, NULL),
	(31, 127, '2024-02-20 18:34:59', '2024-02-20 20:36:25', 174, '1', '2024-02-21', '2024-02-23', '19', 'hhhhhhhhhhhhh', 0, NULL),
	(33, 4, '2024-02-25 08:13:01', '2024-03-13 12:24:48', 158, '4', '2024-02-26', '2024-03-01', '21', 'Attending a church function.', 2, NULL),
	(34, 4, '2024-02-25 08:13:04', '2024-03-13 12:24:56', 158, '4', '2024-02-26', '2024-03-01', '21', 'Attending a church function.', 2, NULL),
	(36, 4, '2024-03-12 08:15:20', '2024-03-13 12:26:23', 161, '4', '2024-03-25', '2024-04-02', '21', 'Want to use this period to go for medical checkup in Takoradi.', 2, NULL),
	(37, 4, '2024-03-12 08:15:22', '2024-03-13 12:26:35', 161, '4', '2024-03-25', '2024-04-02', '21', 'Want to use this period to go for medical checkup in Takoradi.', 2, NULL),
	(38, 127, '2024-03-21 19:25:15', '2024-03-21 19:25:15', 174, '1', '2024-03-22', '2024-03-23', '80', 'dddddddd', 0, 174),
	(39, 4, '2024-03-22 13:29:57', '2024-03-26 09:31:52', 172, '4', '2024-03-25', '2024-03-29', '21', 'to rest', 1, 13),
	(40, 4, '2024-03-22 13:32:49', '2024-03-26 09:35:38', 172, '5', '2024-03-25', '2024-04-17', '91', 'wife has given birth to twins', 2, 172),
	(42, 4, '2024-04-04 10:03:37', '2024-04-04 10:03:37', 177, '7', '2024-04-08', '2024-04-12', '10', 'Exams', 0, 15),
	(43, 4, '2024-04-09 08:15:18', '2024-04-09 08:15:18', 161, '4', '2024-03-25', '2024-04-03', '21', 'For medical Checkup in Takoradi', 0, 15),
	(44, 4, '2024-04-09 08:31:32', '2024-04-09 08:31:32', 155, '4', '2024-03-05', '2024-03-25', '21', 'Exams', 0, 15),
	(45, 4, '2024-04-09 08:32:45', '2024-04-09 08:32:45', 162, '4', '2024-03-04', '2024-03-08', '21', 'Rest from work due to a mental breakdown', 0, 15),
	(46, 4, '2024-04-24 12:28:24', '2024-04-24 12:28:24', 155, '6', '2024-04-18', '2024-04-18', '5', 'Sick', 0, 15),
	(47, 238, '2024-06-19 09:27:48', '2024-06-19 09:28:21', 179, '15', '2024-06-19', '2024-06-29', '90', 'maternity', 1, NULL);

-- Dumping structure for table comaziwa.leave_types
CREATE TABLE IF NOT EXISTS `leave_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `type_name` varchar(20) NOT NULL,
  `leave_days` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table comaziwa.leave_types: ~15 rows (approximately)
INSERT INTO `leave_types` (`id`, `tenant_id`, `type_name`, `leave_days`, `created_at`, `updated_at`) VALUES
	(1, 127, 'Maternity.', 90, '2024-02-12 23:33:35', '2024-02-12 23:33:35'),
	(2, 127, 'Annual', 21, '2024-02-12 23:30:47', '2024-02-12 23:30:47'),
	(4, 4, 'Annual Leave', 21, '2024-02-19 08:59:04', '2024-02-19 08:59:04'),
	(5, 4, 'Maternity Leave', 91, '2024-02-19 08:59:20', '2024-02-19 08:59:20'),
	(6, 4, 'Medical Leave', 5, '2024-02-19 08:59:38', '2024-02-19 08:59:38'),
	(7, 4, 'Study Leave', 10, '2024-02-19 08:59:52', '2024-02-19 08:59:52'),
	(8, 127, 'Paternity', 14, '2024-03-13 08:14:28', '2024-03-13 08:14:28'),
	(9, 127, 'SPA', 1, '2024-03-13 08:18:13', '2024-03-13 08:18:13'),
	(10, 110, 'Matenity Leave', 20, '2024-04-03 12:52:40', '2024-04-03 12:52:40'),
	(11, 110, 'Sick Leave', 7, '2024-04-03 12:54:33', '2024-04-03 12:54:33'),
	(12, 237, 'Paternity', 14, '2024-06-04 03:10:22', '2024-06-04 03:10:22'),
	(13, 237, 'Maternity', 90, '2024-06-04 03:10:33', '2024-06-04 03:10:33'),
	(14, 238, 'Sick leave', 10, '2024-06-18 04:40:21', '2024-06-18 04:40:21'),
	(15, 238, 'Maternity Leave', 90, '2024-06-18 04:40:54', '2024-06-18 04:40:54'),
	(16, 238, 'Paternity Leave', 14, '2024-06-18 04:41:26', '2024-06-18 04:41:26');

-- Dumping structure for table comaziwa.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.migrations: ~65 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_06_03_011935_add_custom_fields_to_users_table', 1),
	(6, '2023_06_03_013115_create_company_profiles_table', 1),
	(7, '2023_06_03_013154_create_payment_modes_table', 1),
	(8, '2023_06_03_013231_create_subscription_plans_table', 1),
	(9, '2023_06_03_013249_create_contract_types_table', 1),
	(10, '2023_06_03_013300_create_salary_types_table', 1),
	(11, '2023_06_03_013314_create_allowances_table', 1),
	(12, '2023_06_03_013332_create_tax_bands_table', 1),
	(13, '2023_06_03_013344_create_deductions_table', 1),
	(14, '2023_06_03_013401_create_benefits_in_kinds_table', 1),
	(15, '2023_06_03_013425_create_statutory_deductions_table', 1),
	(16, '2023_06_03_013453_create_non_statutory_deductions_table', 1),
	(17, '2023_06_03_013518_create_employee_groups_table', 1),
	(18, '2023_06_03_013538_create_employees_table', 1),
	(19, '2023_06_06_032621_add_password_field_to_employees', 1),
	(20, '2023_06_07_021245_create_employee_payslips_table', 1),
	(21, '2023_06_07_091918_create_packages_table', 1),
	(22, '2023_06_07_092651_create_subscriptions_table', 1),
	(23, '2023_06_08_000305_add_itemvalue_row_to_employee_payslips', 1),
	(24, '2023_06_08_151248_create_projects_table', 1),
	(25, '2023_06_08_152038_create_tasks_table', 1),
	(26, '2023_06_09_204459_create_leaves_table', 1),
	(27, '2023_06_09_204521_create_attendances_table', 1),
	(28, '2023_06_11_133237_add_fields_to_projects_table', 1),
	(29, '2023_06_11_133244_add_fields_to_tasks_table', 1),
	(30, '2023_06_13_145548_add_fields_to_leaves_table', 1),
	(31, '2023_06_16_030753_add_new_fields_to_employees_table', 2),
	(32, '2023_06_16_035958_create_pay_slips_table', 3),
	(33, '2023_06_16_214041_create_contracts_table', 3),
	(34, '2023_06_17_221406_add_fields_to_attendances_table', 4),
	(35, '2023_06_18_231047_add_status_to_attendance_table', 5),
	(36, '2023_06_22_165642_add_field_to_leaves_table', 6),
	(37, '2023_06_23_101122_create_emails_table', 7),
	(38, '2023_06_23_220937_create_email_settings_table', 8),
	(39, '2023_06_24_084234_create_jobs_table', 8),
	(40, '2023_07_04_183214_add_fields_to_users_table', 9),
	(41, '2023_07_11_154334_create_expense_types_table', 10),
	(42, '2023_07_11_171748_create_expenses_table', 10),
	(43, '2023_07_12_044625_create_permission_tables', 11),
	(44, '2023_07_12_052850_add_more_fields_to_company_profiles_table', 12),
	(45, '2023_07_12_174000_add_more_fields_to_users_table', 13),
	(46, '2023_07_12_205202_add_staf_no_to_packages_table', 14),
	(47, '2023_07_12_210417_add_is_system_to_packages_table', 15),
	(48, '2023_07_12_210513_add_is_system_field_to_packages_table', 16),
	(49, '2023_07_13_003553_create_trainings_table', 17),
	(50, '2023_07_13_022658_create_training_requests_table', 17),
	(51, '2023_07_13_072538_add_contract_types_to_employees_table', 18),
	(52, '2023_07_13_081857_add_fields_to_training_requests_table', 19),
	(53, '2023_07_13_090459_add_is_invited_to_training_requests_table', 20),
	(54, '2023_07_14_143635_more_fields_on_employees_table', 21),
	(55, '2023_07_15_010123_add_is_system_to_users_table', 22),
	(56, '2023_07_14_192059_create_agents_table', 23),
	(57, '2023_07_14_200747_create_agent_payments_table', 23),
	(58, '2023_07_14_201216_add_fields_to_users_table', 23),
	(59, '2023_07_15_211705_create_email_templates_table', 24),
	(60, '2023_07_18_085953_modify_field_nullable_in_subscriptions_table', 25),
	(61, '2023_08_08_195958_add_is_hidden_field_to_packages_table', 26),
	(62, '2023_08_08_203014_add_is_hidden_to_packages_table', 27),
	(63, '2024_02_16_203522_create_employees_permissions_table', 28),
	(64, '2024_02_16_203933_create_employee_assigned_permissions_table', 29),
	(65, '2024_02_16_204133_create_employee_permissions_table', 30),
	(66, '2024_02_16_204435_create_employee_assigned_permissions_table', 31),
	(67, '2024_02_19_014958_add_field_to_employees_table', 32),
	(68, '2024_06_29_100345_create_collection_centers_table', 32),
	(69, '2024_06_29_115303_create_banks_table', 33),
	(70, '2024_06_29_124520_create_farmers_table', 34),
	(71, '2024_06_29_165813_create_farmers_table', 35),
	(72, '2024_06_30_121318_create_milk_collections_table', 36),
	(73, '2024_07_02_034742_create_milk_collections_table', 37),
	(74, '2024_07_02_125752_create_categories_table', 38),
	(75, '2024_07_02_162253_create_product_units_table', 39),
	(76, '2024_07_02_163638_create_inventories_table', 39),
	(77, '2024_07_02_172113_create_store_sales_table', 40),
	(78, '2024_07_02_200656_add_field_to_inventories_table', 41),
	(79, '2024_07_03_132315_create_store_sales_table', 42),
	(80, '2024_07_03_134637_create_store_sales_table', 43),
	(81, '2024_07_03_140142_create_store_sales_table', 44),
	(82, '2024_07_03_185602_add_field_to_inventories_table', 45);

-- Dumping structure for table comaziwa.milk_collections
CREATE TABLE IF NOT EXISTS `milk_collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned NOT NULL,
  `center_id` bigint unsigned NOT NULL,
  `collection_date` date NOT NULL,
  `morning` double(8,2) DEFAULT NULL,
  `evening` double(8,2) DEFAULT NULL,
  `rejected` double(8,2) DEFAULT NULL,
  `total` double(8,2) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milk_collections_tenant_id_foreign` (`tenant_id`),
  KEY `milk_collections_farmer_id_foreign` (`farmer_id`),
  KEY `milk_collections_center_id_foreign` (`center_id`),
  KEY `milk_collections_user_id_foreign` (`user_id`),
  CONSTRAINT `milk_collections_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collections_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collections_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.milk_collections: ~2 rows (approximately)
INSERT INTO `milk_collections` (`id`, `tenant_id`, `farmer_id`, `center_id`, `collection_date`, `morning`, `evening`, `rejected`, `total`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 1, '2024-06-04', 45.00, 40.00, 10.00, 75.00, 180, NULL, '2024-07-02 01:46:53'),
	(5, 239, 1, 1, '2024-07-01', 45.00, 0.00, 0.00, 45.00, 180, '2024-07-02 01:47:18', '2024-07-02 01:47:18'),
	(6, 239, 2, 1, '2024-07-01', 34.00, 0.00, 0.00, 34.00, 180, '2024-07-02 01:47:18', '2024-07-02 01:47:18');

-- Dumping structure for table comaziwa.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table comaziwa.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.model_has_roles: ~0 rows (approximately)

-- Dumping structure for table comaziwa.non_statutory_deductions
CREATE TABLE IF NOT EXISTS `non_statutory_deductions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `non_statutory_deductions_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `non_statutory_deductions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.non_statutory_deductions: ~5 rows (approximately)
INSERT INTO `non_statutory_deductions` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Staff Welfare', 'fixed', 50.00, '2023-11-01 12:25:54', '2023-11-01 12:25:54'),
	(2, 4, 'Staff Loan Deductions', 'fixed', 1000.00, '2024-01-29 11:32:51', '2024-01-29 11:38:22'),
	(3, 4, 'Union Dues', 'percentage', 5.00, '2024-01-29 11:35:43', '2024-01-29 11:35:43'),
	(4, 237, 'Loan', 'fixed', 2000.00, '2024-06-04 03:09:46', '2024-06-04 03:09:46'),
	(5, 238, 'Newdawn Sacco', 'fixed', 200.00, '2024-06-18 04:43:01', '2024-06-18 04:43:01');

-- Dumping structure for table comaziwa.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `annual_price` decimal(10,2) NOT NULL,
  `module` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `staff_no` bigint unsigned NOT NULL DEFAULT '0',
  `is_system` bigint unsigned NOT NULL DEFAULT '0',
  `is_hidden` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.packages: ~5 rows (approximately)
INSERT INTO `packages` (`id`, `name`, `price`, `annual_price`, `module`, `created_at`, `updated_at`, `staff_no`, `is_system`, `is_hidden`) VALUES
	(1, 'Enterprise', 1000.00, 10000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-05 20:35:41', '2024-02-13 05:58:24', 100, 0, 0),
	(2, 'Corporate', 750.00, 7500.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-05 20:36:02', '2024-02-13 05:58:47', 50, 0, 0),
	(3, 'SME+', 500.00, 5000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-12 17:53:55', '2024-02-13 05:58:59', 30, 1, 0),
	(12, 'SME', 300.00, 3000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-08-08 22:15:31', '2024-02-13 05:59:12', 15, 0, 0),
	(13, 'Sole', 0.00, 0.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2024-01-29 12:44:47', '2024-02-06 11:51:25', 2, 0, 0);

-- Dumping structure for table comaziwa.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.password_reset_tokens: ~4 rows (approximately)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('currytoffey30@gmail.com', 'cjwgZBf5yQIxdb2Es9Ct0FqNpPxfQdoHUYzBbsBoH3Nc7ZibzCcthXnj7pdh33EQ', '2024-04-22 11:36:02'),
	('emmanuel.brakoapau@jpcannassociates.com', 'ZhbG6t9SRPmNm1Eyaz9vrlnAbVXbd2aJkw336M0nM0KlWVWVz3yUUhwc8pG6cvGv', '2024-02-29 09:47:01'),
	('evansarcher.fevlo@jpcannassociates.com', 'zchLuIQQFY8hCuRQVGPczE8DchaaVWQWaWNDUKGYvQZVnRNZFPNCT1Wsm9x9QX15', '2024-03-13 13:32:10'),
	('superadmin@ghpayroll.net', 'yrZIqgDoYTvsHCZtn2es75L1XCYi1IkZJ1ChCwV9OxsG0X6nIVFOo8LHTZIyPVBq', '2024-01-15 13:55:32');

-- Dumping structure for table comaziwa.payment_modes
CREATE TABLE IF NOT EXISTS `payment_modes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.payment_modes: ~0 rows (approximately)

-- Dumping structure for table comaziwa.pay_slips
CREATE TABLE IF NOT EXISTS `pay_slips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `basic_salary` double(8,2) NOT NULL,
  `paye` double(8,2) NOT NULL,
  `net_pay` double(8,2) NOT NULL,
  `pay_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_on` timestamp NULL DEFAULT NULL,
  `paid_status` bigint unsigned NOT NULL DEFAULT '0',
  `allowances` text COLLATE utf8mb4_unicode_ci,
  `benefits` text COLLATE utf8mb4_unicode_ci,
  `statutory_deductions` text COLLATE utf8mb4_unicode_ci,
  `nonstatutory_deductions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pay_slips_tenant_id_foreign` (`tenant_id`),
  KEY `pay_slips_employee_id_foreign` (`employee_id`),
  CONSTRAINT `pay_slips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pay_slips_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.pay_slips: ~7 rows (approximately)
INSERT INTO `pay_slips` (`id`, `tenant_id`, `employee_id`, `basic_salary`, `paye`, `net_pay`, `pay_period`, `paid_on`, `paid_status`, `allowances`, `benefits`, `statutory_deductions`, `nonstatutory_deductions`, `created_at`, `updated_at`) VALUES
	(3, 3, 149, 1000.00, 218.53, 1566.47, '2024-01', NULL, 0, '[{"name":"Launch Subsidy","value":200,"id":26},{"name":"Clothing Allowance","value":500,"id":27},{"name":"Medical Allowance","value":150,"id":28}]', '[]', '[{"name":"SSF - Employee","value":55,"id":12},{"name":"Union Dues","value":10,"id":13}]', '[]', '2024-01-15 08:55:15', '2024-01-15 08:55:15'),
	(5, 110, 164, 1000.00, 176.30, 823.70, '2024-01', NULL, 0, '[]', '[]', '[]', '[]', '2024-01-20 12:21:16', '2024-01-20 12:21:16'),
	(6, 110, 165, 1300.00, 133.65, 1166.35, '2024-01', NULL, 0, '[]', '[]', '[]', '[]', '2024-01-20 13:05:03', '2024-01-20 13:05:03'),
	(7, 110, 170, 3000.00, 431.15, 2568.85, '2024-01', NULL, 0, '[]', '[]', '[{"name":"SSNIT","value":0,"id":14}]', '[]', '2024-01-23 15:07:35', '2024-01-23 15:07:35'),
	(8, 4, 13, 1000.00, 504.65, 2315.35, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":150,"id":1},{"name":"Transport Subsidies","value":100,"id":2},{"name":"Lunch Subsidy","value":125,"id":3},{"name":"Clothing Allowance","value":500,"id":4},{"name":"Risk Allowance","value":100,"id":37}]', '[{"name":"Company Vehicle Only","value":500,"id":1},{"name":"Fuel","value":250,"id":2},{"name":"Accommodation","value":750,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":50,"id":1},{"name":"Staff Loan Deductions","value":500,"id":2},{"name":"Union Dues","value":50,"id":3}]', '2024-01-29 13:06:10', '2024-02-06 08:34:17'),
	(9, 4, 172, 1000.00, 229.55, 1015.45, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":50,"id":1},{"name":"Transport Subsidies","value":50,"id":2},{"name":"Lunch Subsidy","value":50,"id":3},{"name":"Clothing Allowance","value":100,"id":4},{"name":"Risk Allowance","value":50,"id":37}]', '[{"name":"Company Vehicle Only","value":0,"id":1},{"name":"Fuel","value":0,"id":2},{"name":"Accommodation","value":0,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":0,"id":1},{"name":"Staff Loan Deductions","value":0,"id":2},{"name":"Union Dues","value":0,"id":3}]', '2024-01-29 14:13:38', '2024-01-29 14:13:38'),
	(10, 127, 174, 49999.99, 12806.15, 34443.84, '2024-01', NULL, 0, '[]', '[]', '[{"name":"SSF - Employee","value":2750,"id":15}]', '[]', '2024-02-13 06:51:19', '2024-02-13 06:51:19');

-- Dumping structure for table comaziwa.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.permissions: ~14 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'add.system.admin', 'web', '2023-07-18 02:25:31', '2023-07-18 02:25:31'),
	(2, 'assign.roles', 'web', '2023-07-18 02:25:31', '2023-07-18 02:25:31'),
	(3, 'delete.system.admin', 'web', '2023-07-18 02:25:32', '2023-07-18 02:25:32'),
	(4, 'edit.system.admin', 'web', '2023-07-18 02:25:32', '2023-07-18 02:25:32'),
	(5, 'add.client', 'web', '2023-07-18 02:25:33', '2023-07-18 02:25:33'),
	(6, 'assign.agent', 'web', '2023-07-18 02:25:33', '2023-07-18 02:25:33'),
	(7, 'edit.client', 'web', '2023-07-18 02:25:33', '2023-07-18 02:25:33'),
	(8, 'extend.expiry.dates', 'web', '2023-07-18 02:25:33', '2023-07-18 02:25:33'),
	(9, 'edit.user.package', 'web', '2023-07-18 02:25:33', '2023-07-18 02:25:33'),
	(10, 'delete.client', 'web', '2023-07-18 02:25:34', '2023-07-18 02:25:34'),
	(11, 'add.package', 'web', '2023-07-18 02:25:34', '2023-07-18 02:25:34'),
	(12, 'edit.package', 'web', '2023-07-18 02:25:34', '2023-07-18 02:25:34'),
	(13, 'delete.package', 'web', '2023-07-18 02:25:34', '2023-07-18 02:25:34'),
	(14, 'view.revenue.reports', 'web', '2023-07-18 02:25:34', '2023-07-18 02:25:34');

-- Dumping structure for table comaziwa.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table comaziwa.product_units
CREATE TABLE IF NOT EXISTS `product_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_units_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `product_units_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.product_units: ~2 rows (approximately)
INSERT INTO `product_units` (`id`, `tenant_id`, `unit_name`, `unit_code`, `description`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Litre', 'ml', 'Woooow', '2024-07-02 15:12:11', '2024-07-02 15:30:02'),
	(3, 239, 'meter', 'M', 'rrrrrrrrrr', '2024-07-02 19:43:00', '2024-07-02 19:43:00');

-- Dumping structure for table comaziwa.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_leader` bigint unsigned NOT NULL,
  `project_team` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `progress` double(8,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `projects_tenant_id_foreign` (`tenant_id`),
  KEY `projects_team_leader_foreign` (`team_leader`),
  CONSTRAINT `projects_team_leader_foreign` FOREIGN KEY (`team_leader`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `projects_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.projects: ~3 rows (approximately)
INSERT INTO `projects` (`id`, `created_at`, `updated_at`, `tenant_id`, `title`, `start_date`, `due_date`, `priority`, `team_leader`, `project_team`, `progress`, `notes`) VALUES
	(1, '2023-11-03 11:08:45', '2023-11-03 11:08:45', 4, 'Payroll Ghana Customisation', '2023-11-03', '2023-11-06', 'high', 13, '["13"]', 50.00, 'Contact Daniel to make the few changes suggested'),
	(4, '2024-01-29 11:59:15', '2024-01-29 11:59:29', 4, 'Performance Management & Appraisal', '2024-01-29', '2024-01-29', 'high', 150, '["14","15","171"]', 43.00, 'Testing our Project and Task functionalities on PayrollGhana'),
	(5, '2024-06-19 09:10:11', '2024-06-19 09:10:11', 238, 'swiss', '2024-06-17', '2024-06-19', 'medium', 179, '["179"]', 50.00, 'to complete');

-- Dumping structure for table comaziwa.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.roles: ~7 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(3, 'Superadmin', 'web', '2023-07-12 21:08:35', '2023-07-12 21:08:35'),
	(4, 'Finance Manager', 'web', '2023-07-18 10:46:48', '2023-07-18 10:46:48'),
	(5, 'Admin', 'web', '2023-08-05 14:23:27', '2023-08-05 14:23:27'),
	(6, 'IT Support', 'web', '2023-10-11 12:01:07', '2023-10-11 12:01:07'),
	(7, 'HR', 'web', '2023-11-03 10:40:50', '2023-11-03 10:40:50'),
	(8, 'Agents', 'web', '2024-01-16 16:44:44', '2024-01-16 16:44:44'),
	(9, 'CLIENT MANAGER', 'web', '2024-02-17 21:18:13', '2024-02-17 21:18:13');

-- Dumping structure for table comaziwa.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.role_has_permissions: ~50 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 3),
	(2, 3),
	(3, 3),
	(4, 3),
	(5, 3),
	(6, 3),
	(7, 3),
	(8, 3),
	(9, 3),
	(10, 3),
	(11, 3),
	(12, 3),
	(13, 3),
	(5, 4),
	(6, 4),
	(7, 4),
	(8, 4),
	(9, 4),
	(11, 4),
	(12, 4),
	(2, 5),
	(5, 5),
	(6, 5),
	(7, 5),
	(8, 5),
	(9, 5),
	(10, 5),
	(11, 5),
	(12, 5),
	(13, 5),
	(2, 6),
	(4, 6),
	(5, 6),
	(6, 6),
	(7, 6),
	(8, 6),
	(9, 6),
	(11, 6),
	(12, 6),
	(5, 8),
	(7, 8),
	(8, 8),
	(5, 9),
	(6, 9),
	(7, 9),
	(8, 9),
	(9, 9),
	(10, 9),
	(11, 9),
	(12, 9);

-- Dumping structure for table comaziwa.salary_types
CREATE TABLE IF NOT EXISTS `salary_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salary_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `salary_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.salary_types: ~0 rows (approximately)

-- Dumping structure for table comaziwa.statutory_deductions
CREATE TABLE IF NOT EXISTS `statutory_deductions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statutory_deductions_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `statutory_deductions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.statutory_deductions: ~16 rows (approximately)
INSERT INTO `statutory_deductions` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'SSF - Employee', 'percentage', 5.50, '2023-11-01 12:26:30', '2023-11-01 12:26:30'),
	(12, 3, 'SSF - Employee', 'percentage', 5.50, '2024-01-15 08:52:28', '2024-01-15 08:52:28'),
	(13, 3, 'Union Dues', 'fixed', 10.00, '2024-01-15 08:52:49', '2024-01-15 08:52:49'),
	(14, 110, 'SSNIT', 'percentage', 13.50, '2024-01-20 14:05:23', '2024-01-20 14:05:23'),
	(15, 127, 'SSF - Employee', 'percentage', 5.50, '2024-02-13 06:50:26', '2024-02-19 13:07:15'),
	(16, 110, 'SSF - Employee', 'percentage', 5.50, '2024-02-15 16:06:42', '2024-02-15 16:06:42'),
	(17, 174, 'SSF - Employee', 'percentage', 5.50, '2024-02-19 14:26:32', '2024-02-19 14:26:32'),
	(18, 172, 'SSF - Employee', 'percentage', 5.50, '2024-03-04 07:58:35', '2024-03-04 07:58:35'),
	(21, 158, 'SSF - Employee', 'percentage', 5.50, '2024-04-03 11:43:50', '2024-04-03 11:43:50'),
	(22, 198, 'SSF - Employee', 'percentage', 5.50, '2024-04-03 12:08:30', '2024-04-03 12:08:30'),
	(23, 237, 'SSF - Employee', 'percentage', 5.50, '2024-06-04 03:05:48', '2024-06-04 03:05:48'),
	(24, 237, 'NHIF', 'fixed', 1500.00, '2024-06-04 03:09:15', '2024-06-04 03:09:15'),
	(25, 238, 'SSF - Employee', 'percentage', 5.50, '2024-06-18 04:29:14', '2024-06-18 04:29:14'),
	(26, 238, 'SHA', 'percentage', 2.00, '2024-06-18 04:43:38', '2024-06-18 04:43:38'),
	(27, 238, 'NHIF', 'percentage', 0.80, '2024-06-18 04:44:01', '2024-06-18 04:44:01'),
	(28, 238, 'PAYE', 'percentage', 2.50, '2024-06-18 04:44:20', '2024-06-18 04:44:20'),
	(29, 239, 'SSF - Employee', 'percentage', 5.50, '2024-06-29 07:00:25', '2024-06-29 07:00:25');

-- Dumping structure for table comaziwa.store_sales
CREATE TABLE IF NOT EXISTS `store_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `center_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `order_date` date NOT NULL,
  `qty` int NOT NULL,
  `unit_cost` decimal(8,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_sales_tenant_id_foreign` (`tenant_id`),
  KEY `store_sales_center_id_foreign` (`center_id`),
  KEY `store_sales_farmer_id_foreign` (`farmer_id`),
  KEY `store_sales_category_id_foreign` (`category_id`),
  KEY `store_sales_item_id_foreign` (`item_id`),
  KEY `store_sales_user_id_foreign` (`user_id`),
  CONSTRAINT `store_sales_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `store_sales_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `store_sales_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `store_sales_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `store_sales_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `store_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.store_sales: ~0 rows (approximately)
INSERT INTO `store_sales` (`id`, `tenant_id`, `center_id`, `farmer_id`, `category_id`, `item_id`, `order_date`, `qty`, `unit_cost`, `total_cost`, `payment_mode`, `description`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 2, 4, 2, '2024-07-03', 4, 5000.00, 20000.00, '1', NULL, 239, 0, '2024-07-03 12:15:01', '2024-07-03 12:15:01'),
	(2, 239, 1, 2, 3, 1, '2024-07-03', 4, 300.00, 1200.00, '1', NULL, 239, 0, '2024-07-03 12:15:01', '2024-07-03 12:15:01'),
	(3, 239, 1, 1, 4, 2, '2024-07-03', 1, 5000.00, 5000.00, '1', NULL, 239, 0, '2024-07-03 12:16:42', '2024-07-03 12:16:42'),
	(4, 239, 1, 1, 3, 1, '2024-07-03', 2, 300.00, 600.00, '1', NULL, 239, 0, '2024-07-03 12:16:42', '2024-07-03 12:16:42'),
	(5, 239, 1, 2, 5, 3, '2024-07-03', 4, 650.00, 2600.00, '1', NULL, 239, 0, '2024-07-03 15:43:22', '2024-07-03 15:43:22'),
	(6, 239, 1, 2, 5, 3, '2024-07-03', 4, 650.00, 2600.00, '1', NULL, 239, 0, '2024-07-03 15:44:41', '2024-07-03 15:44:41'),
	(7, 239, 1, 1, 3, 4, '2024-07-02', 23, 1200.00, 27600.00, 'Select Payment Mode', NULL, 239, 0, '2024-07-03 15:53:16', '2024-07-03 15:53:16');

-- Dumping structure for table comaziwa.subscriptions
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `amount_paid` double(8,2) NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_tenant_id_foreign` (`tenant_id`),
  KEY `subscriptions_package_id_foreign` (`package_id`),
  CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.subscriptions: ~3 rows (approximately)
INSERT INTO `subscriptions` (`id`, `tenant_id`, `package_id`, `type`, `amount_paid`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
	(1, 4, 2, 'monthly', 20.00, '2023-12-01 00:00', '2023-12-31', '2023-11-03 11:20:09', '2023-11-03 11:20:09'),
	(2, 4, 2, 'monthly', 20.00, '2023-12-31 00:00', '2024-01-30', '2023-11-21 11:33:09', '2023-11-21 11:33:09'),
	(4, 127, 1, 'annual', 10000.00, '2024-03-13 00:00', '2025-03-13', '2024-02-13 06:36:00', '2024-02-13 06:36:00');

-- Dumping structure for table comaziwa.subscription_plans
CREATE TABLE IF NOT EXISTS `subscription_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_days` int NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.subscription_plans: ~0 rows (approximately)

-- Dumping structure for table comaziwa.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `project_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_to` bigint unsigned NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_tenant_id_foreign` (`tenant_id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.tasks: ~2 rows (approximately)
INSERT INTO `tasks` (`id`, `created_at`, `updated_at`, `tenant_id`, `project_id`, `title`, `assigned_to`, `priority`, `status`, `notes`) VALUES
	(1, '2023-11-03 11:09:54', '2023-11-03 11:09:54', 4, 1, 'Make changes', 13, 'high', 'inprogress', 'Make changes as suggested'),
	(3, '2024-01-29 12:01:04', '2024-06-19 09:11:09', 4, 5, 'Distribute 360 Appraisal', 179, 'medium', 'complete', 'Kindly send the link for Staff 360 Appraisal on Teams so staff can complete the forms and submit by close of day today.');

-- Dumping structure for table comaziwa.trainings
CREATE TABLE IF NOT EXISTS `trainings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vendor` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trainings_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `trainings_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.trainings: ~11 rows (approximately)
INSERT INTO `trainings` (`id`, `tenant_id`, `name`, `type`, `start_date`, `end_date`, `description`, `status`, `created_at`, `updated_at`, `vendor`, `time`, `location`) VALUES
	(4, 110, 'Health and safety Training Sessions', 'compulsory', '2024-03-05', '2024-03-10', 'To educate workers on the importance of health and safety at work with its regulations and compliance. This sessions involves with taken each participants through a physical hands-on demonstrations.', 0, '2024-01-20 13:33:38', '2024-02-27 10:50:39', 'Cannyzer Global Enterprise', '09:00', 'Within the Office Premises'),
	(5, 4, 'Performance  Appraisal Training', 'compulsory', '2024-01-28', '2024-01-29', 'Compulsory for all supervisors and managers', 0, '2024-01-29 12:05:11', '2024-01-29 12:05:11', 'JPCann', '08:00', 'Accra'),
	(6, 4, 'Growth Mindset', 'compulsory', '2024-02-05', '2024-02-05', 'Attend training', 0, '2024-02-06 12:06:21', '2024-02-06 12:19:47', 'JPCann', '08:00', 'JPCann Premises'),
	(7, 127, 'Demo', 'compulsory', '2024-02-12', '2024-02-14', 'kskewe', 0, '2024-02-12 10:59:58', '2024-02-12 10:59:58', 'Demo', '13:59', 'Virtual'),
	(8, 127, 'Demo', 'compulsory', '2024-02-12', '2024-02-12', 'DSKDKk', 0, '2024-02-12 12:01:25', '2024-02-12 12:01:25', 'Demo', '15:06', 'Virtual'),
	(9, 110, 'Health and safety Training', 'compulsory', '2024-02-14', '2024-02-16', 'Employees will be taken through a physical demonstration on accident related cases at work and how to handle reporting and action of cases.', 0, '2024-02-12 13:01:37', '2024-02-12 13:01:37', 'Cannyzer Global Enterprise', '09:00', 'At the Office Premises'),
	(10, 127, 'Operating Systems', 'compulsory', '2024-02-20', '2024-02-21', 'Come Prepared', 0, '2024-02-19 17:34:16', '2024-02-19 17:34:32', 'Coding Sniper', '20:33', 'Castle Gardens'),
	(11, 127, 'Demo 1', 'compulsory', '2024-03-14', '2024-03-16', 'eeeeeeeeeeeeee', 0, '2024-03-13 08:19:06', '2024-03-13 08:19:06', 'Ancent Events', '11:18', 'Nairobi County'),
	(12, 127, 'Demo 2', 'compulsory', '2024-03-18', '2024-03-18', 'dddddddddd', 0, '2024-03-13 08:21:17', '2024-03-13 08:21:17', 'Ancent Events', '14:21', 'Nairobi KICC'),
	(13, 110, 'Health and safety', 'compulsory', '2024-04-08', '2024-04-10', 'To educate workers on the importance of health and safety at work with its regulations and compliance. This sessions involves with taken each participants through a physical hands-on demonstrations.', 0, '2024-03-28 12:50:55', '2024-03-28 12:50:55', 'Cannyzer Global Enterprise', '09:00', 'Within the Office Premises'),
	(14, 4, 'SEO Optimization', 'compulsory', '2024-04-08', '2024-04-12', 'TEST', 0, '2024-04-03 12:52:38', '2024-04-03 12:52:38', 'JPCANN ASSOCIATES LIMITED', '09:00', 'KOKOMLEMLE');

-- Dumping structure for table comaziwa.training_requests
CREATE TABLE IF NOT EXISTS `training_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `training_id` bigint unsigned NOT NULL,
  `approval_status` int NOT NULL DEFAULT '0',
  `completion_status` int NOT NULL DEFAULT '0',
  `certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_invited` int NOT NULL DEFAULT '0',
  `decline_reasons` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `training_requests_training_id_foreign` (`training_id`),
  KEY `training_requests_employee_id_foreign` (`employee_id`),
  CONSTRAINT `training_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `training_requests_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.training_requests: ~28 rows (approximately)
INSERT INTO `training_requests` (`id`, `created_at`, `updated_at`, `employee_id`, `training_id`, `approval_status`, `completion_status`, `certificate`, `is_invited`, `decline_reasons`) VALUES
	(6, '2024-01-20 13:34:17', '2024-02-27 11:07:17', 164, 4, 1, 1, NULL, 1, NULL),
	(7, '2024-01-20 13:34:18', '2024-02-27 11:09:21', 165, 4, 1, 1, '#165-joseph-yao-folikorkor_health-and-safety-training-sessions.pdf', 1, NULL),
	(8, '2024-01-23 15:16:49', '2024-02-27 11:08:03', 170, 4, 1, 1, NULL, 1, NULL),
	(9, '2024-01-29 12:05:55', '2024-02-06 12:21:31', 14, 5, 1, 1, NULL, 1, NULL),
	(11, '2024-01-29 12:05:58', '2024-02-06 12:21:41', 150, 5, 1, 1, NULL, 1, NULL),
	(12, '2024-01-29 12:05:58', '2024-01-29 12:05:58', 14, 5, 1, 0, NULL, 1, NULL),
	(13, '2024-01-29 12:05:59', '2024-01-29 12:05:59', 155, 5, 1, 0, NULL, 1, NULL),
	(15, '2024-01-29 12:06:01', '2024-01-29 12:06:01', 150, 5, 1, 0, NULL, 1, NULL),
	(16, '2024-01-29 12:06:02', '2024-01-29 12:06:02', 155, 5, 1, 0, NULL, 1, NULL),
	(19, '2024-01-29 14:04:07', '2024-02-06 12:22:41', 172, 5, 1, 1, NULL, 0, NULL),
	(20, '2024-02-06 12:07:36', '2024-02-06 12:07:36', 14, 6, 0, 0, NULL, 1, NULL),
	(21, '2024-02-06 12:07:38', '2024-04-03 12:43:06', 150, 6, 1, 0, NULL, 1, NULL),
	(22, '2024-02-06 12:07:39', '2024-05-06 12:36:42', 158, 6, 1, 0, NULL, 1, NULL),
	(23, '2024-02-06 12:07:41', '2024-04-03 12:41:35', 172, 6, 1, 0, NULL, 1, NULL),
	(24, '2024-02-06 12:10:56', '2024-04-03 12:49:12', 158, 5, 1, 1, '#158-emmanuel-brako-apau_performance--appraisal-training.pdf', 0, NULL),
	(27, '2024-02-12 11:03:12', '2024-02-19 19:45:05', 174, 7, 1, 1, NULL, 1, NULL),
	(28, '2024-02-12 12:02:05', '2024-02-19 19:46:42', 174, 8, 1, 1, '#174-daniel-mutuku_demo.pdf', 0, NULL),
	(29, '2024-02-12 13:02:24', '2024-02-27 11:09:01', 164, 9, 1, 1, NULL, 1, NULL),
	(30, '2024-02-12 13:02:28', '2024-02-27 11:08:38', 164, 9, 1, 1, NULL, 1, NULL),
	(31, '2024-02-19 17:34:52', '2024-02-19 17:34:52', 174, 10, 1, 0, NULL, 1, NULL),
	(32, '2024-02-19 17:34:55', '2024-02-19 17:34:55', 174, 10, 1, 0, NULL, 1, NULL),
	(33, '2024-03-13 08:25:01', '2024-03-13 08:25:01', 176, 11, 0, 0, NULL, 0, NULL),
	(34, '2024-03-13 08:26:04', '2024-03-18 19:55:40', 176, 8, 1, 0, NULL, 1, 'ddddddddddddd'),
	(35, '2024-03-28 12:52:28', '2024-03-28 12:52:28', 164, 13, 1, 0, NULL, 1, NULL),
	(36, '2024-03-28 12:52:29', '2024-03-28 12:52:29', 165, 13, 1, 0, NULL, 1, NULL),
	(37, '2024-03-28 12:52:30', '2024-03-28 12:52:30', 170, 13, 1, 0, NULL, 1, NULL),
	(38, '2024-04-04 10:06:00', '2024-04-04 10:06:00', 177, 5, 0, 0, NULL, 0, NULL),
	(39, '2024-04-04 10:06:06', '2024-04-04 10:06:06', 177, 6, 0, 0, NULL, 0, NULL);

-- Dumping structure for table comaziwa.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_id` bigint unsigned DEFAULT NULL,
  `expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL DEFAULT '0',
  `is_system` int NOT NULL DEFAULT '0',
  `agent_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_package_id_foreign` (`package_id`),
  CONSTRAINT `users_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.users: ~167 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone_number`, `type`, `package_id`, `expiry_date`, `role_id`, `is_system`, `agent_id`) VALUES
	(1, 'Superadmin', 'superadmin@gmail.com', NULL, '$2y$10$6P8zt4fkmdg4cwNzWHs3au82GQMThLG1nFN12TROZklWZVFtB.3nS', NULL, '2023-10-31 01:47:26', '2023-10-31 01:47:26', '0717576900', 'superadmin', 3, '2023-11-30', 0, 1, '0'),
	(2, 'Jonathan Can', 'advisor3ghana@gmail.com', NULL, '$2y$10$nvYJ/jjCMnIL.GjhXoSL3OjVX1N.Nfa6VKD/4KJim0O62pWGV4I1m', NULL, '2023-11-01 10:18:00', '2023-11-01 10:18:00', '0501335817', 'superadmin', NULL, NULL, 3, 0, '0'),
	(3, 'Kobina Akyea', 'KAKYEA@YAHOO.COM', NULL, '$2y$10$3zza6Awez.LiE997zIWG..9TdwZOOFfpULCizxOcNQI53rlEO7fou', NULL, '2023-11-01 10:44:40', '2024-01-15 08:33:44', '0501335817', 'client', 2, '2024-12-31', 0, 0, '1'),
	(4, 'Tracey Cann', 'tracey.cann@jpcannassociates.com', NULL, '$2y$10$LC9tjGixKDzyoqhpcCfROOGSvPoRqVaOAiVqsSw0xvha7g9/92G.2', NULL, '2023-11-01 10:51:40', '2024-04-08 12:59:03', '0501335818', 'client', 2, '2024-12-31', 0, 0, '1'),
	(25, 'Demo', 'it@cowango.org', NULL, '$2y$10$6P8zt4fkmdg4cwNzWHs3au82GQMThLG1nFN12TROZklWZVFtB.3nS', NULL, '2023-11-21 11:29:59', '2024-02-28 15:52:35', '0501457253', 'client', 13, '2024-03-29', 0, 0, '0'),
	(41, 'Winston', 'michelle@hultine.com', NULL, '$2y$10$sZRmMRQ28UrXxY5mrt4NJO5WC2nk7VOzRpVyvOHYChq47iIiyNInG', NULL, '2023-12-01 15:04:36', '2024-01-16 16:56:09', '1', 'client', 3, '2023-12-31', 0, 0, '2'),
	(47, 'Aviana', 'esopro32@gmail.com', NULL, '$2y$10$TP.UwPuuu2wSq0OM8VOJdeJs.cAnLREIAu7NHfczp.1OlgObCa1Ra', NULL, '2023-12-02 19:07:45', '2023-12-02 19:07:45', '1', 'client', 3, '2024-01-01', 0, 0, '0'),
	(55, 'pvyVpVXJVsnvYYw', 'mersal.markt@gmail.com', NULL, '$2y$10$MUZH23nMDfnAP/bwFjGLY.FXAATJJjXKTG2eV3kgG/XrbYRibJRb.', NULL, '2023-12-09 07:56:34', '2023-12-09 07:56:34', '1', 'client', 3, '2024-01-08', 0, 0, '0'),
	(56, 'yIxlbRKVEsOwL', 'gcassidy11@verizon.net', NULL, '$2y$10$J4CZjI1.PdeGcB41cZerAOFulRtY7gomRtDlYDvwvpkqd9BJSAsZi', NULL, '2023-12-09 17:15:04', '2023-12-09 17:15:04', '1', 'client', 3, '2024-01-08', 0, 0, '0'),
	(58, 'ABvXoVBDXfvL', 'NxfRnR.pdpccmj@flexduck.click', NULL, '$2y$10$TGOAyPrO9BkTKJiFmXTUI.ot/4yWq3dL8o6wFQRB5L8h634KohXBy', NULL, '2023-12-14 21:17:54', '2023-12-14 21:17:54', '1', 'client', 3, '2024-01-13', 0, 0, '0'),
	(59, 'nwepusKJFlXOBJzJO', 'cpsorrentino7@icloud.com', NULL, '$2y$10$of50ynCjs5LfQuJHwLaHVOTU5fWzsSFOubZOI9IHpYiCtvv1uIYTm', NULL, '2023-12-14 21:32:38', '2023-12-14 21:32:38', '1', 'client', 3, '2024-01-13', 0, 0, '0'),
	(60, 'Vincenzo', 'jhnDEi.mtjdcc@sandcress.xyz', NULL, '$2y$10$i6egZ/XQTbR20w5XVFqZ6.EkogrZ1YBbmad9OrzZELFM.0cDasCIC', NULL, '2023-12-17 16:13:32', '2023-12-17 16:13:32', '1', 'client', 3, '2024-01-16', 0, 0, '0'),
	(61, 'Novah', 'akordus@badgerlabs.com', NULL, '$2y$10$8lTfuwdX3Iiwj1mY3uPXyuEJPenRdxXegCzuWOybNAtToDjSRV9Em', NULL, '2023-12-17 16:17:38', '2023-12-17 16:17:38', '1', 'client', 3, '2024-01-16', 0, 0, '0'),
	(62, 'Talon', 'queeny95006@gmail.com', NULL, '$2y$10$niQPP6VVJnO5f2KkXfg4Puq3SU8dDrPtLlSvSaDBNv.XyKb6Wg6y2', NULL, '2023-12-17 20:28:19', '2023-12-17 20:28:19', '1', 'client', 3, '2024-01-16', 0, 0, '0'),
	(63, 'Rowan', 'melissaborges83@hotmail.com', NULL, '$2y$10$B2DwZu7GX8CG9epulnaap.yQiWRWRYxhiuUAHhLk2y.3RBKGdMT.m', NULL, '2023-12-18 10:26:18', '2023-12-18 10:26:18', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(64, 'Amari', 'charmmishaweathers@yahoo.com', NULL, '$2y$10$kjcF0SVWTmsizWtkLAhqeuPPXRthKg1G1/HphwVtZ49M9oM9EcuG.', NULL, '2023-12-18 15:01:20', '2023-12-18 15:01:20', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(65, 'bTfwOfqXLa', 'juliamarsh75@yahoo.com', NULL, '$2y$10$P9g6OZO3yzK54ct0lhTrwuE3RQBKHrNGRhGDW.cNGGQoS3IU6hhj2', NULL, '2023-12-18 16:54:20', '2023-12-18 16:54:20', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(66, 'Madisyn', 'ifuentes@cfhgroup.com', NULL, '$2y$10$vUeh3GDQDPD9ZnlG35ASAOUJwMa4H82ookGnK2AH5/TGj0LtjDobe', NULL, '2023-12-18 18:09:43', '2023-12-18 18:09:43', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(67, 'WTEUMMIwuAp', 'erin.vanderzanden@gmail.com', NULL, '$2y$10$XzZYCPQtGKMfHYmhJdryCOK3jIeD.QKv8jJu3rL6LyaXiEco2SYLa', NULL, '2023-12-18 23:03:55', '2023-12-18 23:03:55', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(68, 'Elina', 'qa1.deftsoft@gmail.com', NULL, '$2y$10$ON85NtnRsz7Wllt7oj5jEOLu.gbdOAiaMRRV5Okai3u9k1omOHdaW', NULL, '2023-12-18 23:32:47', '2023-12-18 23:32:47', '1', 'client', 3, '2024-01-17', 0, 0, '0'),
	(69, 'zzcDpqFixDXiOn', 'tacel75@gmail.com', NULL, '$2y$10$FAava.eQNCM0HZ.lYZcFVuPuu7aVbxVy31x4ZY/A8zZg.n/SGNZuy', NULL, '2023-12-19 02:53:03', '2023-12-19 02:53:03', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(70, 'Dilan', 'tomaszbarbachen@gmail.com', NULL, '$2y$10$6Qy5I0M8xRDH6UUB2DWZUegXBHJmxZeIk2GiN5gBWtMWG9.nCu0RC', NULL, '2023-12-19 03:58:23', '2023-12-19 03:58:23', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(71, 'Macy', 'jcollinson76@gmail.com', NULL, '$2y$10$myhQMigJulUt7LKgmdZvluHZm7Jxa.z7SQBXXAXgHc7m2kUBpBco.', NULL, '2023-12-19 13:56:06', '2023-12-19 13:56:06', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(72, 'htJJVHquQuJAjJX', 'pajohnso@ncsu.edu', NULL, '$2y$10$/M6AKhe8HoFniXBkjtuYGOG.vXAjcC4E38kKMTrE0G92/tEns8IT6', NULL, '2023-12-19 17:06:11', '2023-12-19 17:06:11', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(73, 'Amelia', 'abqmalenurse@gmail.com', NULL, '$2y$10$qZeVtO6HC.Kz6k6bslSOQuoqJPF1Jgl8kxWvsmMwJZZg8oOsqZKFG', NULL, '2023-12-19 17:08:49', '2023-12-19 17:08:49', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(74, 'Armani', 'superiorcomfort713@gmail.com', NULL, '$2y$10$IyesvUEwPhi2Xs0vNc9wXOtAVO40LV5SuJ11FHWGMP/accQ.G6BgG', NULL, '2023-12-19 20:27:09', '2023-12-19 20:27:09', '1', 'client', 3, '2024-01-18', 0, 0, '0'),
	(75, 'Rio', 'frankvacanti@att.net', NULL, '$2y$10$CwT2p2LkZqFmKP.k0WjZd.tmknXfD968D9rcO3I1cW5zPGM.utS6q', NULL, '2023-12-20 00:31:44', '2023-12-20 00:31:44', '1', 'client', 3, '2024-01-19', 0, 0, '0'),
	(76, 'Marcus', 'danpoland@gmail.com', NULL, '$2y$10$L0lH9LIEHIHORIDTe1OdquDaSaE4mpmKNia4vwfEQE.Wj8DcxySEu', NULL, '2023-12-20 04:32:35', '2023-12-20 04:32:35', '1', 'client', 3, '2024-01-19', 0, 0, '0'),
	(77, 'Nova', 'al.rochette@wanadoo.fr', NULL, '$2y$10$Up1V1kEWd9v7KHcz1GseIuiYaPQ3tFOf7QLgO1AFuOIGObBWRhLe.', NULL, '2023-12-20 13:22:58', '2023-12-20 13:22:58', '1', 'client', 3, '2024-01-19', 0, 0, '0'),
	(78, 'jXXirlYtjWzRc', 'e.30@hotmail.fr', NULL, '$2y$10$o3llFFTt2IWsBb73LwFgauI089pyLqMaZ/tQD4ARl7a59coPQtHha', NULL, '2023-12-20 21:37:29', '2023-12-20 21:37:29', '1', 'client', 3, '2024-01-19', 0, 0, '0'),
	(79, 'WAmPDLhMcMXls', 'mishabales@outlook.com', NULL, '$2y$10$p2XtQ/tRwM7udnrIztopzu/ctYu1j6QAsrzN1Qs3Lp0O7Bdp4jC/W', NULL, '2023-12-21 18:22:27', '2023-12-21 18:22:27', '1', 'client', 3, '2024-01-20', 0, 0, '0'),
	(80, 'WwUNxIsLifxjT', 'laramespence@gmail.com', NULL, '$2y$10$uQ/0eLtIcdCTx9pS/1ZuKe01gqR92Ua/DQs9iBJhbAnf8lRM7.nxS', NULL, '2023-12-21 23:31:25', '2023-12-21 23:31:25', '1', 'client', 3, '2024-01-20', 0, 0, '0'),
	(81, 'Danny', 'Pmumtw.bcqpmht@flexduck.click', NULL, '$2y$10$aRs6Jj9bC6mei8BzcByLCeky0G5p0NvFnUJBIGdUgdNrk25TQ.s2.', NULL, '2024-01-07 19:17:27', '2024-01-07 19:17:27', '1', 'client', 3, '2024-02-06', 0, 0, '0'),
	(82, 'Lyric', 'judithfpt@gmail.com', NULL, '$2y$10$YHnccyV3hJHTv3wojUrIbuMvno1gNCBGGfEFoUBA5qmt0iLNyr.su', NULL, '2024-01-07 23:27:39', '2024-01-07 23:27:39', '1', 'client', 3, '2024-02-06', 0, 0, '0'),
	(83, 'Mya', 'jzaremba@zbblaw.com', NULL, '$2y$10$tgFze9fHa1nUrEJRyip4JOICUBVuB5xR6Kjo1E66wIhY2mOpmsgV.', NULL, '2024-01-08 11:54:34', '2024-01-08 11:54:34', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(84, 'Anderson', 'troy@gfmpartnersllc.com', NULL, '$2y$10$GXW/SKlzyoP9VX9zMA6C.e3IdgVp6/3aDEcg3oUe1GaCT0b8XfCOy', NULL, '2024-01-08 13:01:58', '2024-01-08 13:01:58', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(85, 'Barbara', 'vbuxvbuxlol12@gmail.com', NULL, '$2y$10$hMnMoIKUj0LhJ2.kqZ0QQO/pi.aGTloTlPSbssdjszqqHpTSxn4ti', NULL, '2024-01-08 17:37:47', '2024-01-08 17:37:47', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(86, 'Opal', 'k100@ebuyclub.com', NULL, '$2y$10$M4aCTI1r3JlnjE6ViSCMOuEHbDyt.iF3CLmdFDIpZekx0zxiVIWNm', NULL, '2024-01-08 20:00:36', '2024-01-08 20:00:36', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(87, 'Kylie', 'iellouze@misfat.com.tn', NULL, '$2y$10$/ZB0MxvJTUyz6nGmf7poBO3c6smcY9Vj3cJU9QLKO.M48g/qX2.hO', NULL, '2024-01-08 21:44:06', '2024-01-08 21:44:06', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(88, 'Kinslee', 'kelseywilliston@gmail.com', NULL, '$2y$10$gpyM0CS8jtm68uksUctlE.Y48ZWRxjFrWySfqflrDdYijszTVmZOq', NULL, '2024-01-08 23:30:10', '2024-01-08 23:30:10', '1', 'client', 3, '2024-02-07', 0, 0, '0'),
	(89, 'Bentley', 'richardcarruth@gmail.com', NULL, '$2y$10$Nk/QHkrRnkq4Wcl1CyawOua.bHZCIBAia5SOR3Q9DfQFrECMQDmKO', NULL, '2024-01-09 00:45:53', '2024-01-09 00:45:53', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(90, 'Asher', 'hotstreet81@yahoo.com', NULL, '$2y$10$9g34cZifOisWBuTjLqyPZubWEsFnb6f3lXnt7pnM.af3/g3dFRF8q', NULL, '2024-01-09 02:30:35', '2024-01-09 02:30:35', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(91, 'Wrenlee', 'fish692161@aol.com', NULL, '$2y$10$HMB8emUlvYk/rjXbssv4j.CDGd4HWegPLEh3MpH2/0fc/xxVzKate', NULL, '2024-01-09 03:51:39', '2024-01-09 03:51:39', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(92, 'Makai', 'stephen@jbbakery.com', NULL, '$2y$10$lBXJQTnYcQOtcGfJMOSRB.k.Jcf7CmIaxLFHW5sJmT/sV7YA2j.cy', NULL, '2024-01-09 05:05:25', '2024-01-09 05:05:25', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(93, 'Azaria', 'cori@kerrfamily.net', NULL, '$2y$10$4VU2g0wY1kFTu6JpZU.qBe87FxGQUwosXnXflHGLlFiH/qUGBRmyu', NULL, '2024-01-09 06:33:19', '2024-01-09 06:33:19', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(94, 'Sutton', 'twmains@gmail.com', NULL, '$2y$10$EvWZlYDa9.rzK7C5inKsQuydtwg791bhF5pyIFHWCSfqzhIDXTrQq', NULL, '2024-01-09 08:17:28', '2024-01-09 08:17:28', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(95, 'Jacob', 'dschmitt@therosatigroup.com', NULL, '$2y$10$ki099aimwwD3ZA9aCfeDteHskCduabfeYosIhk4N0F76Wwlc39cqe', NULL, '2024-01-09 10:22:43', '2024-01-09 10:22:43', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(96, 'Kinslee', 'vscroggs@hotmail.com', NULL, '$2y$10$Yv5YADy8S8TG1WQTI40ls.z1fPSw0yvcJ7Yyp9DbgxacWnEPwZKmS', NULL, '2024-01-09 11:44:36', '2024-01-09 11:44:36', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(97, 'Kamiyah', 'shamilton@waltersdimmick.com', NULL, '$2y$10$JpQwz3PMee3Hmnc1XKILH.zZj0p8KRPKnuOHj1GUKQWJzKRwoCYp2', NULL, '2024-01-09 15:40:28', '2024-01-09 15:40:28', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(98, 'Caleb', 'westiesthree@yahoo.com', NULL, '$2y$10$NFSIPHWuEWaqS.EDyN1DCO3gzSrlJG4tzmRjf4pXZw8rskYtQxJGC', NULL, '2024-01-09 19:10:03', '2024-01-09 19:10:03', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(99, 'Jayson', 'vicky@jkirschnerlaw.com', NULL, '$2y$10$vJR6vjJ8Si3tcdrTVKuf..qOHLXPDoZ5E7E6g7LOA2yidBTuoj4jK', NULL, '2024-01-09 20:58:06', '2024-01-09 20:58:06', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(100, 'Aliana', 'shnhome@hrnursery.com', NULL, '$2y$10$u5a1oJ.qJN9qLjGInEnPA.zvqeC25KCVuF1YxdVC3ghGoG2D2/gsa', NULL, '2024-01-09 21:59:36', '2024-01-09 21:59:36', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(101, 'Byron', 'ssinomad@windstream.net', NULL, '$2y$10$O9Ikk3.Ya2mz3FjZmocHXu/mtEIUjIMlZ8NQKfOb5DAcJwY9QU.cS', NULL, '2024-01-09 23:16:11', '2024-01-09 23:16:11', '1', 'client', 3, '2024-02-08', 0, 0, '0'),
	(102, 'Forrest', 'sb@stircincy.com', NULL, '$2y$10$GCAHMXN0vqZfFY6Gf.hwh.MHc4TeuFwMHvWAHXHT3cmlXUHi2cF32', NULL, '2024-01-10 00:49:42', '2024-01-10 00:49:42', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(103, 'Mya', 'admin@viceventuresllc.com', NULL, '$2y$10$l.huLO8k/Gt4z7dCa7KAXOBisyCVPEWqtDmzLyDjSH4M4lkJRBhNa', NULL, '2024-01-10 03:50:14', '2024-01-10 03:50:14', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(104, 'Van', 'chattins@aol.com', NULL, '$2y$10$SKbjRJQvkOPg.fBdwkq1gOuEnyodJnFOmknUJkkVGMp9Nfetojb.S', NULL, '2024-01-10 04:47:10', '2024-01-10 04:47:10', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(105, 'Khari', 'mrnakbohr@gmail.com', NULL, '$2y$10$RCr5NkGAwlMxKdTCmKzFoOvmkJ5MEf800K87p9FWUkkwJr7DIPKpS', NULL, '2024-01-10 05:45:39', '2024-01-10 05:45:39', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(106, 'Ethan', 'accountspayable@qbdfl.com', NULL, '$2y$10$wJ71FUbmZQ4X2QGH8Tibm.aKka0AtU/Biq.lKPIuHDNliBAcE7O1a', NULL, '2024-01-10 07:48:48', '2024-01-10 07:48:48', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(107, 'Brooklynn', 'phil@lugopartners.com', NULL, '$2y$10$/CP3bx8ukABAU2jB3yopY.bZarWP0QhPiPGD61pW57di9ur.KQFye', NULL, '2024-01-10 09:07:03', '2024-01-10 09:07:03', '1', 'client', 3, '2024-02-09', 0, 0, '0'),
	(108, 'Ernest Awuku', 'ernieakuffo@gmail.com', NULL, '$2y$10$9PRkuhLmbVvyovwxkVEWhuuzmQrbT1i3TNEOuIY4vc/xKeFWhsDo2', NULL, '2024-01-15 13:45:02', '2024-02-02 13:52:19', '0244218288', 'client', 3, '2024-02-14', 0, 0, '0'),
	(110, 'Ebenezer Cann', 'cannyzer1@gmail.com', NULL, '$2y$10$eOesFY6fSzXhzaNjzYm9Auiip4PbSjWpO1UrKy7eGRPstBD5GzKgq', NULL, '2024-01-18 11:51:42', '2024-04-03 11:43:00', '0545950291', 'client', 13, '2024-03-19', 0, 0, '0'),
	(111, 'John Kofi Nketia', 'johnnananketia@gmail.com', NULL, '$2y$10$5yMMkA7zdsrgY5ZOZaoffO7jE/eDnECXiv.2kAI1M7YTigcs9Kyjy', NULL, '2024-01-18 12:43:35', '2024-01-18 12:43:35', '0557089074', 'client', 3, '2024-02-17', 0, 0, '0'),
	(112, 'Kyle', 'RwjiUA.mqbwhjw@sandcress.xyz', NULL, '$2y$10$CKWgaUGxoEv8Z3aK61A4Xes7fINCN.qubqNyWX5oGMifkpK04nzLq', NULL, '2024-01-25 00:07:24', '2024-01-25 00:07:24', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(113, 'Zara', 'jfrousso@globetrotter.qc.ca', NULL, '$2y$10$5Lrvfps1lUzf5J2OEl7Mkehy8S.DNuLeWpYJikNMStpULz2xksug.', NULL, '2024-01-25 18:13:20', '2024-01-25 18:13:20', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(114, 'Angie', 'mikem@landstarcak.com', NULL, '$2y$10$Al/F0KQPeIJs7pue4JKj4uyexerN9zfiX7j4jwJefMDCh315kDJbm', NULL, '2024-01-25 23:12:07', '2024-01-25 23:12:07', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(115, 'Brooks', 'toniandamandacleaning@gmail.com', NULL, '$2y$10$dg3l...7vt4vRfIXQ7ABNe5tsKSH9kkpB/.fafvCxo/bCmB2/E1Ky', NULL, '2024-01-26 01:37:34', '2024-01-26 01:37:34', '1', 'client', 3, '2024-02-25', 0, 0, '0'),
	(116, 'EBTndNhXUSZtq', 'vladimirbp5@outlook.com', NULL, '$2y$10$NTMwQ.XGIEnLc1DXR8tvg.sHNCe30oipHmeoXOGYq8Yp1xkqUFPfG', NULL, '2024-01-26 19:13:36', '2024-01-26 19:13:36', '2651012405', 'client', 3, '2024-02-25', 0, 0, '0'),
	(118, 'vJlGwqTfsDX', 'kgoodman9438@gmail.com', NULL, '$2y$10$bBPDU6XofiRsbWxYbOq0IOKlccaS.wlhpmc4aEedMZX851p7ucuiu', NULL, '2024-02-05 13:18:49', '2024-02-05 13:18:49', '6343768111', 'client', 3, '2024-03-06', 0, 0, '0'),
	(119, 'Chelsea Tiban-Ye', 'chelsea.tibanye@jpcannassociates.com', NULL, '$2y$10$XYeyM3NNOs2SbZs/N5JZHOKjAjiGMDWGRB0kenJYunCJg.kh7dssC', NULL, '2024-02-06 08:56:13', '2024-02-06 08:56:13', '0501890182', 'superadmin', NULL, NULL, 4, 0, '0'),
	(120, 'Edmund Toffey', 'edmund.toffey@jpcannassociates.com', NULL, '$2y$10$MMNDzBWHthQR6deykOm/ROUWxteXYuGbGHCKs415RAU861TOwSaoq', NULL, '2024-02-06 08:59:54', '2024-03-26 12:41:11', '0558313156', 'superadmin', NULL, NULL, 5, 0, '0'),
	(121, 'Michael', 'sandys.lartey74@gmail.com', NULL, '$2y$10$xmno0AJUIgUqVoJ0au/kleokqwso5KevC49IM.4zpLt8/So7DMCGW', NULL, '2024-02-06 11:28:23', '2024-02-06 11:28:23', '2330501335818', 'client', 3, '2024-03-07', 0, 0, '0'),
	(122, 'Michael', 'kwasi.atta2014@gmail.com', NULL, '$2y$10$mOLDQzIBtdACIXtyasr1Uu3UB.qyuYdg9oiccwRK14EDYAFNEZGuW', NULL, '2024-02-06 11:32:29', '2024-02-06 11:32:29', '23330504249800', 'client', 3, '2024-03-07', 0, 0, '0'),
	(123, 'OGSL', 'KAKYEAGH@GMAIL.COM', NULL, '$2y$10$pk2i0BBhiGukBW7ADny66.Qcb54rewSVVDkLDJ5s9WzNQXAXhEc6y', NULL, '2024-02-06 11:46:06', '2024-02-06 11:46:06', '0241121761', 'client', 3, '2024-03-07', 0, 0, '0'),
	(124, 'Penny', 'RqttHJ.qcdqcdp@flexduck.click', NULL, '$2y$10$Q9RUsnlNoUGD/b5PVxqGSep7AHg8IWn77eWD8lVNerH1J2810Bf0u', NULL, '2024-02-10 01:48:19', '2024-02-10 01:48:19', '1', 'client', 3, '2024-03-11', 0, 0, '0'),
	(125, 'Axton', 'tripathisomil27@gmail.com', NULL, '$2y$10$qv1BIm/W.ZM5wm0sAVZcc.648wpbb8cLX3tmKlPIDtUovfhbGMYPa', NULL, '2024-02-10 01:48:35', '2024-02-10 01:48:35', '1', 'client', 3, '2024-03-11', 0, 0, '0'),
	(126, 'Michael Avevorh', 'bluevelscompany@gmail.com', NULL, '$2y$10$asPvFBWsFtSIwkumBS0aI.w8r9E2ct8uOav5qmBPE9JmaxLYj8whe', NULL, '2024-02-10 11:12:18', '2024-02-10 11:12:18', '0545629414', 'client', 3, '2024-03-11', 0, 0, '0'),
	(127, 'Daniel Mutuku', 'daniel.mutuku404@gmail.com', NULL, '$2y$10$G6MZMOnMt6Qc23Xt6SzuiuExfQQwGLiwtQhNoVNIFDK4yQpyIkGnK', NULL, '2024-02-12 06:31:05', '2024-02-13 06:36:00', '0717576900', 'client', 1, '2025-03-13', 0, 0, '0'),
	(128, 'Aliya', 'SeeqKQ.mwmtmwb@borasca.xyz', NULL, '$2y$10$GQGFY6.C85nLanRN6sf8euWAsSqH67j9IkGw5iB3wKGdESAVWtxnq', NULL, '2024-02-12 19:06:04', '2024-02-12 19:06:04', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(129, 'Adonis', 'jcarter@axiommarketinggroup.net', NULL, '$2y$10$.ykuFWadePF0uz4tQucxGOOiR4mlBAdbs4NkjzYib4vcXa515OQKS', NULL, '2024-02-12 19:07:39', '2024-02-12 19:07:39', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(130, 'Chelsea', 'andrew.formica@henderson.com', NULL, '$2y$10$MwwRgVmw.An8Vln7XfgTmenccx/XFucwtPcy.1XfpgaVPOIfHsGoS', NULL, '2024-02-12 20:00:25', '2024-02-12 20:00:25', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(131, 'Keith', 'fadehouse3@yahoo.com', NULL, '$2y$10$R8QxlHNzyfd8dNdiWqzRM.3uPUUN95zYwAnxmomvA7pai2e7u4Fiu', NULL, '2024-02-12 21:19:23', '2024-02-12 21:19:23', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(132, 'Raphael', 'jstringer414@yahoo.com', NULL, '$2y$10$kF9LnCj4VlZy49nnAiGDTub.AcXKejDVD6zIxOgBVNmoWZl7qDPGu', NULL, '2024-02-12 22:05:12', '2024-02-12 22:05:12', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(133, 'Maximo', 'jay@spring-lake.com', NULL, '$2y$10$IYdig0U2vgFNApsuDZf.4ekKnblHzHI0WNLA.zwq4NXRdnrY/h7Ue', NULL, '2024-02-12 23:02:38', '2024-02-12 23:02:38', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(134, 'Daniela', 'bgirlgumdrop@gmail.com', NULL, '$2y$10$9QSzDCIHKYm01oiUAFJrieqEY5gnrOJoSn9FyENTRxPQqd7Rwbe6C', NULL, '2024-02-12 23:53:39', '2024-02-12 23:53:39', '1', 'client', 3, '2024-03-13', 0, 0, '0'),
	(135, 'Hector', 'kanupatel01@gmail.com', NULL, '$2y$10$0PGOiKoo8X9BS7w6fSN0j.9WnSDiBze5HoC/mKi1kUSr.Y0q7OUWy', NULL, '2024-02-13 00:28:02', '2024-02-13 00:28:02', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(136, 'Harry', 'drlotz@drlotz.net', NULL, '$2y$10$5cJqWsczFblC9FdqM/FOP.84bjMmJjlekmKg1wpyV4MVdqABTGsjS', NULL, '2024-02-13 02:41:53', '2024-02-13 02:41:53', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(137, 'Giovanni', 'john@anchorstorageusa.com', NULL, '$2y$10$fnMB/C1vidiOhZ6lcBeaRO/bJJOWXtF9bdnkER5STGBXeSAfqg/A2', NULL, '2024-02-13 04:06:48', '2024-02-13 04:06:48', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(138, 'Wyatt', 'info@highfashionfabrics.com', NULL, '$2y$10$iu4JLLO6/1x4scfFrTvggeg35BD1SpCIME7uqmU5EpqSqR2vn88hq', NULL, '2024-02-13 06:02:20', '2024-02-13 06:02:20', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(139, 'Elliott', 'pmartin@houstonproperties.com', NULL, '$2y$10$fNjgDNMkEqbOL17hc2Muoe.oMwWCZ2oK5acWjButUPEteDGR3pLtO', NULL, '2024-02-13 09:15:03', '2024-02-13 09:15:03', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(140, 'Layton', 'jomjar@gmail.com', NULL, '$2y$10$rqrpWiPKF0uYAy/V16oaUORUeB4xZ1RAmEmq0TeJCvMCki6Uqfy3a', NULL, '2024-02-13 11:38:30', '2024-02-13 11:38:30', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(141, 'Ernest Anokye-Gyan', 'payroll@biwadgroup.com.gh', NULL, '$2y$10$R2A9eJST855adpwR4xvtyuE/ESZaIuTSKxejj5flddLaziL2pKu7e', NULL, '2024-02-13 12:25:04', '2024-02-13 12:25:04', '0575511033', 'client', 3, '2024-03-14', 0, 0, '0'),
	(142, 'Charlotte', 'sreed005@cfl.rr.com', NULL, '$2y$10$4CVj/IWOB5TMN4FBwtZ6/OTxuxrKJsZMGID3zvAfotimVQYwgyvY6', NULL, '2024-02-13 13:29:25', '2024-02-13 13:29:25', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(143, 'TNZFvAKXRu', 'todd.dotson1979@yahoo.com', NULL, '$2y$10$t.CK7QttTIYC9TEYupvefOfzhToAldivq95pDbYxWcThE7Z/tlrWq', NULL, '2024-02-13 14:13:33', '2024-02-13 14:13:33', '7579257031', 'client', 3, '2024-03-14', 0, 0, '0'),
	(144, 'Beckham', 'hyqmet.mece@mass.gov', NULL, '$2y$10$hLHZJ298VnsF.KbZXi8iP.0OjG9LbO6TO5LlWRBuQEho0KkPGkxQC', NULL, '2024-02-13 17:05:14', '2024-02-13 17:05:14', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(145, 'Caden', 'keirahomar@gmail.com', NULL, '$2y$10$Kc9njrKLR.z0dt2m6v2QUeM6Ka7vt8NG0Esfiw738n2O.gDAIxJB6', NULL, '2024-02-13 18:57:31', '2024-02-13 18:57:31', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(146, 'Jesus', 'maheshkatkam05@gmail.com', NULL, '$2y$10$di.ZFjdYmFHN7b3zZaGCdegokzuPg5gkXkEFoMXX1aORFh9X3pkkS', NULL, '2024-02-13 20:33:37', '2024-02-13 20:33:37', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(147, 'Zhuri', 'georgiatelecominstallation@yahoo.com', NULL, '$2y$10$gn7hDfZflkrMMAncmHZB.ObZqnMHJ302MZqbq506cAV7JfUL4mGhu', NULL, '2024-02-13 21:40:09', '2024-02-13 21:40:09', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(148, 'Marco', 'clemence@ahhcflorida.com', NULL, '$2y$10$/zkN7nrVN9s5779mJ11nbOsq3bThW1m9qFNfDWt9F6ryhsGh0M7X6', NULL, '2024-02-13 22:59:00', '2024-02-13 22:59:00', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(149, 'Aliya', 'pcobb12@gmail.com', NULL, '$2y$10$Itc6PyWM/TK2DEIFq8.KBupCpRya2lImxrETfcFX7wRA9FMhWF6OC', NULL, '2024-02-13 23:50:44', '2024-02-13 23:50:44', '1', 'client', 3, '2024-03-14', 0, 0, '0'),
	(150, 'Jeremias', 'wilkesed@gmail.com', NULL, '$2y$10$ZvLY5FuBPA9NHJ.Wr769u.oNo82KdgiuY/s825P0d/1z9te6gTUee', NULL, '2024-02-14 00:35:21', '2024-02-14 00:35:21', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(151, 'Sloane', 'kimgagnon79@gmail.com', NULL, '$2y$10$rodtB7.MJ4XdgOc3VzYM3u7pRDxgsENvq2LjzGt/vLiZv6xP6HMTy', NULL, '2024-02-14 01:28:55', '2024-02-14 01:28:55', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(152, 'Winston', 'livefreeordie300blk@gmail.com', NULL, '$2y$10$M2rJ7WqDH94bR2qfds.9vehRbDGEWaFnh77DSkP9aoK7gRJ620nF.', NULL, '2024-02-14 03:08:37', '2024-02-14 03:08:37', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(153, 'Denver', 'tyson.brice@maryland.gov', NULL, '$2y$10$cPtJxn0x3T/ovOxQqS81ZOo93y4lO9fObAaktSoS8ruo7AvOWzSz2', NULL, '2024-02-14 07:38:41', '2024-02-14 07:38:41', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(154, 'Sabrina', 'tom@committed2service.com', NULL, '$2y$10$ZkasmwJpK/FqYhL0WMPTieljTlUbo9ltjSjfHv.ma.dhZmDHHlqLm', NULL, '2024-02-14 18:24:17', '2024-02-14 18:24:17', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(155, 'Landyn', 'svhoehnke@mac.com', NULL, '$2y$10$pDbpQdR64IZMDkN9dgwdLuRuoXZ/8SHZJ/sYCF.Gf2qtEH6vVg1oy', NULL, '2024-02-14 19:29:19', '2024-02-14 19:29:19', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(156, 'Cullen', 'cingo1030@yahoo.com', NULL, '$2y$10$g8zIEPRY2mhx5xUHWnxr5.F2sT8SrAlucQKj8J4OrULyl9P2iYY2C', NULL, '2024-02-14 20:40:00', '2024-02-14 20:40:00', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(157, 'Yamileth', 'ashraf@fiveboromg.com', NULL, '$2y$10$4L90oRN0pyMvUJ.bdLTyVey79RCaOQJuqdIajVFXbLreHgBetXyqu', NULL, '2024-02-14 22:44:17', '2024-02-14 22:44:17', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(158, 'Elianna', 'jclark@pattersonharbor.com', NULL, '$2y$10$yEeWGY7Ueaw2o3HQfDIllOLC/3FxK9j.nxNQe19V1jScVBC00qaR2', NULL, '2024-02-14 23:22:55', '2024-02-14 23:22:55', '1', 'client', 3, '2024-03-15', 0, 0, '0'),
	(159, 'Estrella', 'shalley@thearcnepa.org', NULL, '$2y$10$/zyKxLEdbd0QNQsLESxDje8Prww8/gXpe6N76aQfe.OdxkI.QzzJC', NULL, '2024-02-15 01:02:01', '2024-02-15 01:02:01', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(160, 'Fabian', 'rd758@verizon.net', NULL, '$2y$10$RR60VYSaoW06Z6vPSVvgB.d7ltqHXT/0AXqPMvv5qK.GWFTPHb1nu', NULL, '2024-02-15 01:27:38', '2024-02-15 01:27:38', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(161, 'Londyn', 'kcherezov@gentell.com', NULL, '$2y$10$slLbCi7PRD/jqTkRN9Ttge/yfhQz6pFxvToaiH4/oieP06p78V..6', NULL, '2024-02-15 03:58:57', '2024-02-15 03:58:57', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(162, 'Zen', 'md.moniruzzaman@dot.ca.gov', NULL, '$2y$10$VXD8bzVuo0PkMIWvQ3zBSudK/CcOmOhTanNpZtfCTbBpUHFEVqtpK', NULL, '2024-02-15 05:04:01', '2024-02-15 05:04:01', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(163, 'Yamileth', 'shellym@jjconstructioninc.com', NULL, '$2y$10$7N3zq6HkM6zT7b4M0GR1YeU8rWZr0OcwokiFN6ljPkKRvu.w2NQkK', NULL, '2024-02-15 06:30:17', '2024-02-15 06:30:17', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(164, 'Beckett', 'FuSmbj.thhqtwh@carnana.art', NULL, '$2y$10$Kpvf50Z1jjleYZDHPT3k6OgmNX50avTRoHE8eXzQr5FLPmvE4yOlK', NULL, '2024-02-15 06:40:48', '2024-02-15 06:40:48', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(165, 'Adam', 'larasthach@gmail.com', NULL, '$2y$10$1OVl6lQrqsEyWrDiGn1qNuvT5NMvg/GYXzOW.TaIvvVzerqeelgz2', NULL, '2024-02-15 09:43:53', '2024-02-15 09:43:53', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(166, 'Lennon', 'smoeller@grand-rapids.mi.us', NULL, '$2y$10$6i1gvgqXPPqmDOZzrcnxO.N0Aswm4o/QB..DQwYLlprceRq2dZdlO', NULL, '2024-02-15 12:05:46', '2024-02-15 12:05:46', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(167, 'Thalia', 'jeromecaffey72@gmail.com', NULL, '$2y$10$b.P8Wqp6Oe17VAYvpLDZfO3WW3FJCy5RIjpPJfX3uAhmY4/GWdXsW', NULL, '2024-02-15 14:59:49', '2024-02-15 14:59:49', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(168, 'Gabrielle', 'bbrandilly@sbcglobal.net', NULL, '$2y$10$rBl6c2rcKufIBlG/j60MaOJkCwS9T/NnsHtYyPv26kpxcK85krL8G', NULL, '2024-02-15 15:47:05', '2024-02-15 15:47:05', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(169, 'Ila', 'nickrespicio@gmail.com', NULL, '$2y$10$e7slXxju1DgCekGWtHkycuTGUfYvPCFyntYrXw3F5m7fDcW/7mWMy', NULL, '2024-02-15 17:14:30', '2024-02-15 17:14:30', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(170, 'Dominick', 'rmlovd@aol.com', NULL, '$2y$10$QpcPwnmvx5Wem5W2sPvGjuhRit4yf5u.OsW7C.n3MTIWyup0ADvni', NULL, '2024-02-15 18:17:18', '2024-02-15 18:17:18', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(171, 'Edgar', 'martha.bailey1959@gmail.com', NULL, '$2y$10$ywv.kjfg4/q7bDh3XOsVqOaq5wPLjyvEDxEcfSPFROwE3FUjpAsCa', NULL, '2024-02-15 19:10:17', '2024-02-15 19:10:17', '1', 'client', 3, '2024-03-16', 0, 0, '0'),
	(172, 'Deborah', 'andres.melgar@sphereco.com', NULL, '$2y$10$bStxemkUhuXFEmFNORukou63icvme4S9s1IcgIOPtCPV2fYopOzRy', NULL, '2024-02-15 20:05:05', '2024-03-20 08:24:27', '1', 'client', 13, '2024-04-19', 0, 0, '0'),
	(174, 'Emmett', 'etony1993@gmail.com', NULL, '$2y$10$Xx0lkpDQxgnEtyBh0g2aaef6xAu3c0iWU1UO0BGaHtQ5C/klyUE3C', NULL, '2024-02-16 17:52:33', '2024-02-16 17:52:33', '1', 'client', 3, '2024-03-17', 0, 0, '0'),
	(175, 'Ayan', 'josiah.stadler@gmail.com', NULL, '$2y$10$jdZxA3Q6EwOo4.wgzLx7Y.cw6RAG3wYntMOKrfObAKukUkg7JpYt2', NULL, '2024-02-16 20:05:10', '2024-02-16 20:05:10', '1', 'client', 3, '2024-03-17', 0, 0, '0'),
	(176, 'Grey', 'jason.hawkinson@motion.com', NULL, '$2y$10$JTmKW.nfAOM298o2nRzvXOeQxkodJZap2uBw1vj8M0jDAdeMv.JF6', NULL, '2024-02-16 20:42:21', '2024-02-16 20:42:21', '1', 'client', 3, '2024-03-17', 0, 0, '0'),
	(179, 'Vincent Bartels', 'adombartels1@gmail.com', NULL, '$2y$10$4I27kMjAur0E.fhMYsvs9uEkjSH8XbSKrZq3zjaQSzSTQTojKkyOK', NULL, '2024-02-19 11:27:55', '2024-02-19 11:27:55', '0201104372', 'client', 3, '2024-03-20', 0, 0, '0'),
	(180, 'EMMANUEL NARNOR', 'kwabenadswork@gmail.com', NULL, '$2y$10$B8ZHEe9qeKrd30z7El7Kq.X0e1qh0LodimPpU1fFH1my2qL01iyG.', NULL, '2024-02-20 13:35:27', '2024-02-20 13:35:27', '233247430818', 'client', 3, '2024-03-21', 0, 0, '0'),
	(181, 'OShReHZIsYWLfaCB', 'peter69bedard8zw@outlook.com', NULL, '$2y$10$e7xETFynp3kBbdjSy59ZEubJrP3z35anrnAzqFX6Ko0wuafnvzPAm', NULL, '2024-02-22 06:16:21', '2024-02-22 06:16:21', '2073852360', 'client', 3, '2024-03-23', 0, 0, '0'),
	(182, 'Seedlings Meadow', 'info@seedlingsmeadow.com', NULL, '$2y$10$Y50uvOU.TObwQ2C1Oi03nOYrCgOdY2IS4i0yhRS9MDgMFiYAAbjim', NULL, '2024-03-06 13:16:58', '2024-03-06 13:16:58', '0592337444', 'client', 3, '2024-04-05', 0, 0, '0'),
	(183, 'Tiffany', 'seivvD.mqdqjjw@kerfuffle.asia', NULL, '$2y$10$.1HjvRn29cPAHosF5b0d2e7.pjsP0OCfk33MgWmrWxV9NoGtIdQ5q', NULL, '2024-03-10 18:27:15', '2024-03-10 18:27:15', '1', 'client', 3, '2024-04-09', 0, 0, '0'),
	(184, 'hnEMAcmdjtlpx', 'eddy_hoffmanmttt@outlook.com', NULL, '$2y$10$ptVhDRdAhui/jiQIKA6wBOQC1fGsmP5Ypot5d.GcsBdTNiuUVlDSe', NULL, '2024-03-13 01:22:39', '2024-03-13 01:22:39', '4589939427', 'client', 3, '2024-04-12', 0, 0, '0'),
	(185, 'ZVMGQRruogXtai', 'snavarronp1992@gmail.com', NULL, '$2y$10$2J9Wv5TTkWBQ3DiWwAOGC.YLGunBm7nSp7P/TkOsvdyolwEp0GADC', NULL, '2024-03-17 16:06:46', '2024-03-17 16:06:46', '3153051125', 'client', 3, '2024-04-16', 0, 0, '0'),
	(187, 'Samuel Berko', 'achillesmachine@gmail.com', NULL, '$2y$10$DZKtaVgY.Vka1YWcwulRVec6X0a98/7x2Q2ewkneVxjwwZo/q25DW', NULL, '2024-03-22 05:20:23', '2024-03-22 05:20:23', '0537654474', 'client', 3, '2024-04-21', 0, 0, '0'),
	(188, 'Samuel Berko', 'bsamuel567@outlook.com', NULL, '$2y$10$B2HmU.etZFfgMfwCiMYN9eYLvPD2SXtkws0FtQF/mPv.6B3LBnI02', NULL, '2024-03-22 05:55:05', '2024-03-22 05:55:05', '0244491492', 'client', 3, '2024-04-21', 0, 0, '0'),
	(189, 'FgBSdVXpIblyoTi', 'lee41sterlingbud@outlook.com', NULL, '$2y$10$14IewdU1H8.XiXn1u1v09OKC4jqy6H0hJbTgMseAJYl7jPAKH20F.', NULL, '2024-03-25 00:46:47', '2024-03-25 00:46:47', '7775158133', 'client', 3, '2024-04-24', 0, 0, '0'),
	(190, 'khayr', 'qtdqwwqjtm.q@monochord.xyz', NULL, '$2y$10$hFSE9faP4IQkSXgkeSXqV.D7CL7/S8wPQn9DnkVUa1f20God56P/2', NULL, '2024-03-27 10:30:46', '2024-03-27 10:30:46', '1', 'client', 3, '2024-04-26', 0, 0, '0'),
	(191, 'Vincent Bartels', 'vincentadom.bartels@gmail.com', NULL, '$2y$10$ipHIJejRyXW.v18jSzI2TeNGqgGOMfugL36/YE8wc4zozD/2bzGMe', NULL, '2024-03-27 12:01:43', '2024-03-27 12:01:43', '0201104372', 'client', 3, '2024-04-26', 0, 0, '0'),
	(192, 'Vincent Bartels', 'vincentadom.bartels@jpcannassociates.com', NULL, '$2y$10$C.BDmEKMW1oFcwO4oEykCuVT76RRTiv.oY27mMoOm1YF56C77YxzK', NULL, '2024-03-27 14:24:50', '2024-03-27 14:24:50', '0201104372', 'client', 3, '2024-04-26', 0, 0, '0'),
	(193, 'oMgGFvpyK', 'deilmaysc2003@gmail.com', NULL, '$2y$10$kHOl6E6f/Iz3UghiAqXLT.tmk7iitoI7Y/i3A4XD6kt9GttX//.B2', NULL, '2024-03-30 06:40:55', '2024-03-30 06:40:55', '2463648862', 'client', 3, '2024-04-29', 0, 0, '0'),
	(196, 'ABIGAIL O OWUSU', 'bigabyent@gmail.com', NULL, '$2y$10$ym2miLoDYonX9v6oSjGNC.RvDCGHt41Gm4C0EwYOu7AlnQ9RtOVzK', NULL, '2024-04-02 15:35:06', '2024-04-02 15:35:06', '0246443578', 'client', 3, '2024-05-02', 0, 0, '0'),
	(197, 'Brylee', 'SIYtwa.qcwdbhh@anaphora.team', NULL, '$2y$10$2SMhIQgsnRs01RXc8OA1HunvqSIY5iWFe7jq9kIDQ2d8cv2FNT6MW', NULL, '2024-04-03 09:14:30', '2024-04-03 09:14:30', '1', 'client', 3, '2024-05-03', 0, 0, '0'),
	(198, 'Joel Toffey', 'edmundtoffey@gmail.com', NULL, '$2y$10$ZIh90DkhNZOpF/CSZbdbR.FTaDc.lC5v3asC71vYJag8I9hk3sX5O', NULL, '2024-04-03 12:05:21', '2024-04-03 12:05:21', '0558313156', 'client', 3, '2024-05-03', 0, 0, '0'),
	(199, 'JONATHAN PRINCE CANN', 'j.cann@jpcannassociates.com', NULL, '$2y$10$K54Z8TYvW6WTmkLyaoRGWucWE9DHJwbLAROheyrjTcKgiL7I73U4i', NULL, '2024-04-04 09:32:03', '2024-04-04 09:32:03', '0302974302', 'client', 3, '2024-05-04', 0, 0, '0'),
	(200, 'JONATHAN PRINCE CANN', 'jonathan.cann@jpcannassociates.com', NULL, '$2y$10$wlGrDDBVwXKxXVQ/dBl1He6vurm3EyBX6lIrbIOSxS.yUfbCcSsGy', NULL, '2024-04-04 09:35:14', '2024-04-04 09:35:14', '0302974302', 'client', 3, '2024-05-04', 0, 0, '0'),
	(201, 'Mike Smith', 'niionak@gmail.com', NULL, '$2y$10$IvgEtyeluE0PNkpvYn5CmOo9ENPHY/fyXeQZJGNVtWP7F0YBYopp2', NULL, '2024-04-04 13:19:52', '2024-04-23 13:59:55', '0244556678', 'client', 3, '2024-05-04', 0, 0, '0'),
	(203, 'eeeeeee', 'edmund.toey@jpcannassociates.com', NULL, '$2y$10$IzgtxhlyFlmkfjFMDIIGb.cgLb6h85iJIIFPf/QorHFFCreY24vVu', NULL, '2024-04-08 20:39:37', '2024-04-08 20:39:37', '0729303852', 'client', 3, '2024-05-08', 0, 0, '0'),
	(204, 'Samuel Ntiamoah', 'samtugah@gmail.com', NULL, '$2y$10$3BoXUQEykfcgYB8sTOfQc.J7rkCJVisWBI5v/oFG2xVS4barRdL1C', NULL, '2024-04-09 08:33:20', '2024-04-09 08:33:20', '0545637422', 'client', 3, '2024-05-09', 0, 0, '0'),
	(205, 'RicardoNeaps', 'kjcueetrbet@poochta.com', NULL, '$2y$10$JPxCtGslTFOOLafi6WX60OB.1wslkLF8FgzTCVuHJnoPn2vVzgGFO', NULL, '2024-04-13 07:53:11', '2024-04-13 07:53:11', '81885564119', 'client', 3, '2024-05-13', 0, 0, '0'),
	(206, 'Lydia Yeboah', 'ceo@soapyfoamy.com', NULL, '$2y$10$qCciIKg8Onk5/GmbcT3Zr.bcKnMwacB1a33Ucq5SeRZTdstCkGtMO', NULL, '2024-04-15 02:02:03', '2024-04-15 02:04:14', '0243446013', 'client', 3, '2024-05-15', 0, 0, '0'),
	(207, 'UDStgfLVcXpsbnCy', 'cammydenton1r0@outlook.com', NULL, '$2y$10$fsH2VB6akxQFyd0/17ZqxuUaUb9uxdTCHZaMXPlHndSJNOE/z1QZK', NULL, '2024-04-20 15:20:48', '2024-04-20 15:20:48', '7410012267', 'client', 3, '2024-05-20', 0, 0, '0'),
	(208, 'etoffema company', 'currytoffey30@gmail.com', NULL, '$2y$10$.h8LPmISuvsudVMLf2KLJebBGb9cLmwDn2UelyCMZbpPRyvHW4K26', NULL, '2024-04-22 11:33:21', '2024-04-22 11:33:21', '0558313156', 'client', 3, '2024-05-22', 0, 0, '0'),
	(209, 'XzYcGuUfIpiwTMP', 'john_stombergnq0q@outlook.com', NULL, '$2y$10$jllN1Mbby8jcQ28gLsy7beiHwEdxOlIJyvPf62ZvRIH7HxbQb1vwi', NULL, '2024-04-23 11:44:19', '2024-04-23 11:44:19', '2273296065', 'client', 3, '2024-05-23', 0, 0, '0'),
	(210, 'Paul Boateng', 'paulboat58@gmail.com', NULL, '$2y$10$nYSvVaqAGLRxB7huEHO4N.vB.gonBFxmKwb4jk6afLMErxKDAzUW6', NULL, '2024-04-25 07:15:22', '2024-04-25 07:15:22', '0248639158', 'client', 3, '2024-05-25', 0, 0, '0'),
	(211, 'JULIUS SOWAH', 'juelzking4@gmail.com', NULL, '$2y$10$IO914Cp2nFBgDvgiVfKsL.X7.nkQC9rU.ZzpNO2Om1GAuRumB9Nrq', NULL, '2024-04-26 05:44:59', '2024-04-26 05:44:59', '0249058596', 'client', 3, '2024-05-26', 0, 0, '0'),
	(212, 'nana mensah', 'gaatssq@gmail.com', NULL, '$2y$10$BsyVl9Q80qrbKdzA2iTc2ObwrUo0uH9uW14h36aK6NUvk3ItX6qYe', NULL, '2024-04-29 12:00:16', '2024-04-29 12:00:16', '0541339758', 'client', 3, '2024-05-29', 0, 0, '0'),
	(213, 'RaymondCausy', 'cycnbawcuKr@poochta.com', NULL, '$2y$10$8d59Gms5JamjV/P2ifLL/eaGKcl5Qlzve/KAQiDPzTkXpmHhRZRa6', NULL, '2024-05-01 05:41:02', '2024-05-01 05:41:02', '89541423436', 'client', 3, '2024-05-31', 0, 0, '0'),
	(214, 'cliffordvosburg', 'biorev@poochta.ru', NULL, '$2y$10$GG1xw23B.AdzovsGDo4xwORYAeFXLE/tOuecPq/DQFWL.wxMOtyuG', NULL, '2024-05-05 15:21:14', '2024-05-05 15:21:14', '249339613', 'client', 3, '2024-06-04', 0, 0, '0'),
	(215, 'Vernontop', 'vvvbxyegpsr@poochta.com', NULL, '$2y$10$n.PbfhMowDGQSRDRcwiX4egmH5mDQ83j.fqcPOeZLu5.YlJtEGY7m', NULL, '2024-05-05 21:17:21', '2024-05-05 21:17:21', '87853265917', 'client', 3, '2024-06-04', 0, 0, '0'),
	(216, 'Nfejdekofhofjwdoe jirekdwjfreohogjkerwkrj rekwlrkfekjgoperrkfoek ojeopkfwkferjgiejfwk okfepjfgrihgoiejfklegjroi jeiokferfekfrjgiorjofeko jeoighirhgioejfoekforjgijriogjeo foefojeigjrigklej jkrjfkrejgkrhglrlrk ghpayroll.net', 'vadimnea66+246d@list.ru', NULL, '$2y$10$pXPe9kC1WEPotYyERZRk2u75LB8SMxggnJbQ6AIvMJP2nur2yRUja', NULL, '2024-05-08 15:17:14', '2024-05-08 15:17:14', '87515648123', 'client', 3, '2024-06-07', 0, 0, '0'),
	(217, 'Mr Daniel', 'recruit@stanrit.com', NULL, '$2y$10$q5b1O8wBNrqr0/t1TfMvnOTbQ5JdRZib0ggVroBoWqabEZlhHy.Bm', NULL, '2024-05-09 18:35:18', '2024-05-09 18:35:18', '233505246500', 'client', 3, '2024-06-08', 0, 0, '0'),
	(218, 'Ivy Oppong-Biney', 'ioppongbiney@ecoplanetbamboo.com', NULL, '$2y$10$E6ylxZcJBGI9sIWJ4LKSJ.a6bFloWIi6/JQC8cAA0ev36pbMb75Fe', NULL, '2024-05-10 09:44:35', '2024-05-10 09:44:35', '0509707784', 'client', 3, '2024-06-09', 0, 0, '0'),
	(219, 'xXwcSetzk', 'akelwallerzf42@gmail.com', NULL, '$2y$10$rAZ102oIBYKelqWt7mGPUuGe4c2Vd/glrk90l0yW.R62yCSYLuzl6', NULL, '2024-05-17 03:50:44', '2024-05-17 03:50:44', '2342485492', 'client', 3, '2024-06-16', 0, 0, '0'),
	(220, 'MaTGPmoYbvF', 'glenda67elmore5xx@outlook.com', NULL, '$2y$10$HXIpEmXwtP3JssqPgmxWDerzzonIMRb2VnwsKeh44oOonfXP47UkC', NULL, '2024-05-20 06:49:37', '2024-05-20 06:49:37', '4658779287', 'client', 3, '2024-06-19', 0, 0, '0'),
	(221, 'Lawrence Osei', 'maxgoldgh@gmail.com', NULL, '$2y$10$SFj6AfsgBn8hPpwr86o/HuPv4DcD85goVMPiNNbVhYd8itCjweAtu', NULL, '2024-05-21 10:15:05', '2024-05-21 10:15:05', '0244815993', 'client', 3, '2024-06-20', 0, 0, '0'),
	(222, 'ivy', 'imawuko@gmail.com', NULL, '$2y$10$LA9FhsKmcP7jk8aqe90hPel1LtZVnHrhCfVOA6j5lOf4ikm1fS8qi', NULL, '2024-05-21 23:42:50', '2024-05-21 23:42:50', '0545518344', 'client', 3, '2024-06-20', 0, 0, '0'),
	(237, 'Ancent Mbithi', 'ancentmbithi@cowango.org', NULL, '$2y$10$6BMZM6hH5RnFIJr3NJbgOOI72/usDsWLpQzWDkllJ4XlIi5MCEJH2', NULL, '2024-06-04 02:52:10', '2024-06-04 02:52:10', '0795974284', 'client', 3, '2024-07-04', 0, 0, '0'),
	(238, 'Dedan', 'wanjirudedan@gmail.com', NULL, '$2y$10$Zlz92Y.EZ7hwSgkaDU3k2Oe3nno.OaXTZaDcQMUTsU.ByMeYST42y', NULL, '2024-06-18 04:27:10', '2024-06-27 09:51:39', '0724654191', 'client', 1, '2024-07-18', 0, 0, '0'),
	(239, 'Mwalyo', 'mbithiconie@gmail.com', NULL, '$2y$10$rRBIbCvmNhbJ2aIbKZm/te2xenW0sSRQABmPlYdVb0vCYOUgzjIK2', NULL, '2024-06-29 05:28:27', '2024-06-29 05:28:27', '0747954284', 'client', 3, '2024-07-29', 0, 0, '0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
