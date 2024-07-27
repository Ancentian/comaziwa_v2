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

-- Dumping structure for table comaziwa.assets
CREATE TABLE IF NOT EXISTS `assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `asset_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL,
  `current_value` decimal(15,2) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `file` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assets_asset_name_unique` (`asset_name`),
  KEY `assets_tenant_id_foreign` (`tenant_id`),
  KEY `assets_category_id_foreign` (`category_id`),
  CONSTRAINT `assets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `asset_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assets_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.assets: ~1 rows (approximately)
INSERT INTO `assets` (`id`, `tenant_id`, `category_id`, `asset_name`, `purchase_date`, `purchase_price`, `current_value`, `location`, `status`, `description`, `file`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 'Super bike', '2024-07-03', 45000.00, 36000.00, 'Nairobi County', '1', 'ffffffffff', '1721132007_4-days-naro-moru-route-hiking-gallery-4.jpg', '2024-07-16 12:13:27', '2024-07-16 12:43:00');

-- Dumping structure for table comaziwa.asset_categories
CREATE TABLE IF NOT EXISTS `asset_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_categories_category_name_unique` (`category_name`),
  KEY `asset_categories_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `asset_categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.asset_categories: ~2 rows (approximately)
INSERT INTO `asset_categories` (`id`, `tenant_id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Super Bike', 'Test', '2024-07-16 11:35:32', '2024-07-16 13:06:17');

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
	(8, '2024-02-17 10:18:44', '2024-02-17 10:18:53', 4, 172, '2024-02-17', '["2024-02-17 10:18:44"]', '["2024-02-17 10:18:53"]', 0, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.banks: ~3 rows (approximately)
INSERT INTO `banks` (`id`, `tenant_id`, `bank_name`, `created_at`, `updated_at`) VALUES
	(1, 239, 'KCB', '2024-06-29 14:10:34', '2024-06-29 14:10:35'),
	(4, 239, 'ABSA', '2024-07-21 17:27:41', '2024-07-21 17:27:41'),
	(5, 241, 'KCB', '2024-07-21 17:27:49', '2024-07-21 17:27:49');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.collection_centers: ~4 rows (approximately)
INSERT INTO `collection_centers` (`id`, `tenant_id`, `center_name`, `grader_id`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Makima', 180, '2024-06-29 10:46:48', '2024-06-29 10:46:48'),
	(2, 239, 'Makimaa', 180, '2024-06-29 10:47:30', '2024-06-29 10:47:30'),
	(3, 239, 'Embu', 180, '2024-07-21 14:56:37', '2024-07-21 14:56:37'),
	(4, 241, 'Kanja', 181, '2024-07-21 18:48:47', '2024-07-21 18:48:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.company_profiles: ~6 rows (approximately)
INSERT INTO `company_profiles` (`id`, `tenant_id`, `name`, `ssni_est`, `address`, `email`, `tel_no`, `logo`, `created_at`, `updated_at`, `tin`, `secondary_email`, `land_line`, `tax_settings`) VALUES
	(1, 3, 'KACANN', 'CO20064587', '58 Nsawam Road', 'KAKYEA@YAHOO.COM', '+233302974302', '24390878.jpg', '2023-11-01 10:44:40', '2024-01-15 08:46:17', 'CO20064587', 'KAKYEA@YAHOO.COM', '+233302974302', '2'),
	(2, 4, 'JPCANN ASSOCIATES LIMITED', 'JPCANN ASSOCIATES LIMITED', '58 NSAWAM ROAD, KOKOMLEMLE, ACCRA', 'info@jpcannassociates.com', '0501335818', '2131164496.jpg', '2023-11-01 10:51:40', '2024-01-15 14:48:06', 'JPCANN ASSOCIATES LIMITED', 'info@jpcannassociates.com', '0302974302', '2'),
	(41, 237, 'Coding Sniper', '765', '109', 'it@cowango.org', '0746054572', '', '2024-06-04 02:52:10', '2024-06-04 02:52:10', '456', 'ancentmbithi8@gmail.com', '00012', '2'),
	(42, 238, 'Newdawn Nonwoven', 'NFTGHJT56EDF344', '24779 00100', 'dedank660@gmail.com', '0724654191', '', '2024-06-18 04:27:10', '2024-06-18 04:27:10', '455FTDSEFGGYU67', 'dedank660@gmail.com', NULL, '2024'),
	(43, 239, 'Ancent', '244343', 'Moi Avenue, Nairobi-Kenya.', 'testmeail@ancent.com', '0747954284', '', '2024-06-29 05:28:27', '2024-06-29 05:28:27', 'Fortsort', 'testmfail@ancent.com', '0450012', '2024'),
	(45, 241, 'Test Cooperative', '34561', 'Moi Avenue, Nairobi-Kenya.', 'testmail@ancent.com', '0747954284', '', '2024-07-21 17:18:22', '2024-07-21 17:18:22', '7890', 'testmail@ancent.com', '30012', '2024'),
	(46, 242, 'Elisha Coop', '00012', 'Moi Avenue, Nairobi-Kenya.', 'l@ancent.com', '0747954200', '', '2024-07-26 08:26:03', '2024-07-26 08:26:03', '9099', 'ail@ancent.com', '000121', '2024');

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
	(4, 238, 179, 'Liz-kagotho-.pdf', '2024-06-19 09:04:29', '2024-06-19 09:04:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.contract_types: ~18 rows (approximately)
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
	(49, 237, 'IT Department', '2024-06-04 03:10:09', '2024-06-04 03:10:09'),
	(50, 238, 'ICT', '2024-06-18 04:38:52', '2024-06-18 04:38:52'),
	(51, 238, 'Production', '2024-06-18 04:39:03', '2024-06-18 04:39:03'),
	(52, 238, 'Reception', '2024-06-18 04:39:22', '2024-06-18 04:39:22'),
	(53, 238, 'Sales & Marketing', '2024-06-18 04:39:43', '2024-06-18 04:39:43'),
	(54, 238, 'Embroidery', '2024-06-18 04:39:58', '2024-06-18 04:39:58'),
	(55, 238, 'Management', '2024-06-19 09:16:47', '2024-06-19 09:16:47'),
	(56, 239, 'Milk Collection', '2024-06-29 09:57:58', '2024-06-29 09:57:58'),
	(57, 239, 'Administration', '2024-06-29 09:58:08', '2024-06-29 09:58:08'),
	(60, 241, 'Milk Collection', '2024-07-21 17:27:26', '2024-07-21 17:27:26'),
	(61, 241, 'Administration', '2024-07-21 17:27:32', '2024-07-21 17:27:32');

-- Dumping structure for table comaziwa.deductions
CREATE TABLE IF NOT EXISTS `deductions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned DEFAULT NULL,
  `deduction_id` bigint unsigned DEFAULT NULL,
  `center_id` bigint unsigned DEFAULT NULL,
  `deduction_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deductions_tenant_id_foreign` (`tenant_id`),
  KEY `deductions_farmer_id_foreign` (`farmer_id`),
  KEY `deductions_deduction_id_foreign` (`deduction_id`),
  KEY `deductions_center_id_foreign` (`center_id`),
  CONSTRAINT `deductions_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `deductions_deduction_id_foreign` FOREIGN KEY (`deduction_id`) REFERENCES `deduction_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `deductions_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `deductions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.deductions: ~8 rows (approximately)
INSERT INTO `deductions` (`id`, `tenant_id`, `farmer_id`, `deduction_id`, `center_id`, `deduction_type`, `amount`, `date`, `user_id`, `user_role`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 1, 1, 'individual', 1000.00, '2024-07-11', 239, NULL, '2024-07-21 13:36:21', '2024-07-21 13:36:21'),
	(3, 239, 2, 1, 1, 'individual', 1000.00, '2024-07-01', 239, NULL, '2024-07-26 10:20:03', '2024-07-26 10:20:03'),
	(4, 239, 1, 1, 1, 'individual', 1000.00, '2024-07-09', 239, NULL, '2024-07-26 10:20:47', '2024-07-26 10:20:47'),
	(5, 239, 2, 1, 1, 'individual', 1000.00, '2024-06-30', 239, NULL, '2024-07-27 03:09:07', '2024-07-27 03:09:07'),
	(6, 239, 2, 4, 1, 'individual', 2500.00, '2024-05-27', 239, NULL, '2024-07-27 03:10:09', '2024-07-27 03:10:09'),
	(7, 239, NULL, 5, NULL, 'general', 200.00, '2024-07-11', 239, NULL, '2024-07-27 05:12:05', '2024-07-27 05:12:05'),
	(8, 239, NULL, 6, NULL, 'general', 20.00, '2024-07-11', 239, NULL, '2024-07-27 05:12:05', '2024-07-27 05:12:05'),
	(9, 239, NULL, 7, NULL, 'general', 350.00, '2024-07-11', 239, NULL, '2024-07-27 05:12:05', '2024-07-27 05:12:05');

-- Dumping structure for table comaziwa.deduction_types
CREATE TABLE IF NOT EXISTS `deduction_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `deduction_types_name_unique` (`name`),
  KEY `deduction_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `deduction_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.deduction_types: ~4 rows (approximately)
INSERT INTO `deduction_types` (`id`, `tenant_id`, `name`, `type`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Ai Science', 'individual', 1000.00, '2024-07-12 06:55:36', '2024-07-12 07:22:47'),
	(4, 239, 'Test', 'individual', 2500.00, '2024-07-12 12:38:43', '2024-07-12 12:38:43'),
	(5, 239, 'Office Ded', 'general', 200.00, '2024-07-13 16:20:11', '2024-07-13 16:20:11'),
	(6, 239, 'Fine', 'general', 20.00, '2024-07-13 16:20:31', '2024-07-13 16:20:31'),
	(7, 239, 'Credit Card', 'general', 350.00, '2024-07-13 17:59:24', '2024-07-13 17:59:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.employees: ~21 rows (approximately)
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
	(171, 4, 'Francis Tagoe', 'francis.tagoe@jpcannassociates.com', '0501454083', 'JPC19988', 'Assistant Manager, Business Development', '1989-12-03', 'Stanbic', 'NIA', '10021', '9040002634389', '2024-01-29 11:23:42', '2024-04-15 07:50:15', '$2y$10$3AzpjfMJIXxCBQ55hefRsuJuKj5vnVUYMnKUM48oox1UrIstdwZHy', 'JP10066666', 0, 'Priscilla Tagoe', '0557354118', 'Homowo Street', 0),
	(172, 4, 'Edmund Toffey', 'edmund.toffey@jpcannassociates.com', '0202368640', 'JPC1045', 'NSP IT', '2001-01-30', 'ADB', 'SPINTEX', '5001', '2546669988', '2024-01-29 12:16:58', '2024-03-01 09:49:22', '$2y$10$nn75ayAWdsH/TM1.aVOs7uFHZPECE6BwpFOASVSCuFHSlhx9KLyNm', 'CX125455455', 5, 'EDWIN TOFFEY', '0240128940', '75 MINISTRIES ROAD', 1),
	(177, 4, 'Jona Cann', 'jonathan.cann@jpcannassociates.com', '0501335817', '7650241', 'COORDINATOR', '1971-03-01', 'Ecobank', 'Ridge', '124555', '140002545878', '2024-04-04 09:46:12', '2024-04-04 09:48:25', '$2y$10$u/PrbSIejFjLdA65kSlJ8evf3YOY0wG/uabdqyjN28ROd.NZ3ds/y', 'SE25478988', 0, 'Peter', '+233501335817', '58 Nsawam Road', 1),
	(178, 237, 'Ancent Mwalyo', 'marionmbithi@gmail.com', '0705974284', '3028777', 'Software Developer', '2000-02-04', 'KCB', 'Nairobi', '215', '12712233001', '2024-06-04 03:12:57', '2024-06-04 03:12:57', '$2y$10$3TQ0NqdH/Nsck.vjRqtHmOk8gyf1GM4yMU5D/XixJpfAjBJtlvxK.', '100987', 0, 'Majesty', '0729303852', '759', 0),
	(179, 238, 'LIZ KAGOTHO', 'liz@gmail.com', '0725452430', '8636122', 'operator', '1995-05-19', 'family bank', 'limuru', '000', '047000011111', '2024-06-19 08:57:30', '2024-06-19 08:57:30', '$2y$10$aUHk6Ct0Dv6OLHxpPUakb.3VwWRZv.0d1XgUyG9pWGE//pWBZE.zy', '111', 0, 'kagotho', '0', '0', 0),
	(180, 239, 'Milk Grader', 'ancent.mario8@gmail.com', '0747954284', '5899136', 'Grader', '2024-06-01', 'KCB', 'Nairobi', '215', '000401223345', '2024-06-29 09:59:34', '2024-06-29 09:59:34', '$2y$10$yeoQpBRpmFRRxwP8SIuxF.hkkiLV5QbmnI1PLwFxd/QlwdPly32oq', '45456785', 0, 'Majesty', '0729303852', 'Moi Avenue, Nairobi-Kenya.', 0),
	(181, 241, 'Data Testing', 'ambithi@ect.ac.ke', '0795428432', '5875877', 'IT officer', '2024-07-23', 'ABSA', 'Nairobi', '215', '50000401223345', '2024-07-21 17:29:19', '2024-07-21 17:29:19', '$2y$10$C/4DH2/kdCytz/t4pXvCFOPWjX/o38n3aiiiXRC4NGr61qkF05hOy', '45456789887766', 0, 'Majesty', '0747954284', 'Moi Avenue, Nairobi-Kenya.', 0);

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
	(129, 13, 3, 'nonstatutory_ded', 50.00, '2024-01-29 13:05:45', '2024-01-29 15:50:22', 5.00);

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

-- Dumping data for table comaziwa.expenses: ~10 rows (approximately)
INSERT INTO `expenses` (`id`, `tenant_id`, `type_id`, `employee_id`, `date`, `purpose`, `amount`, `payment_status`, `approval_status`, `supervisor`, `created_at`, `updated_at`) VALUES
	(4, 4, 4, 172, 'vist a client', 'vist a client', 150.00, 1, 1, NULL, '2024-01-29 14:02:53', '2024-01-29 14:05:53'),
	(5, 4, 3, 172, '2024-02-05', 'food to eat', 2000.00, 1, 1, NULL, '2024-02-05 15:02:01', '2024-02-06 12:28:35'),
	(6, 4, 1, 150, '2024-01-30', 'Training at Kumasi for SIC', 1500.00, 1, 1, NULL, '2024-02-06 12:29:03', '2024-02-26 16:13:51'),
	(7, 4, 6, 158, '2024-02-06', 'Fuel used in corporate errands.', 250.00, 1, 1, NULL, '2024-02-06 12:29:38', '2024-02-06 12:34:02'),
	(9, 4, 2, 172, '2024-02-20', 'Testing', 150.00, 1, 1, NULL, '2024-02-19 19:21:33', '2024-02-26 16:13:40'),
	(10, 4, 10, 158, '2024-02-26', 'Compay errand', 100.00, 0, 2, NULL, '2024-02-27 12:46:03', '2024-03-13 12:28:49'),
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

-- Dumping data for table comaziwa.expense_types: ~12 rows (approximately)
INSERT INTO `expense_types` (`id`, `tenant_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Hotel Accommodation', '2023-11-01 12:24:51', '2023-11-01 12:24:51'),
	(2, 4, 'Transport Allowance', '2023-11-01 12:25:05', '2023-11-01 12:25:05'),
	(3, 4, 'Meals', '2023-11-01 12:25:16', '2023-11-01 12:25:16'),
	(4, 4, 'Medical Claims', '2023-11-01 12:25:26', '2023-11-01 12:25:26'),
	(6, 4, 'Fuel Allocation', '2023-11-21 12:55:37', '2023-11-21 12:55:37'),
	(8, 4, 'Overtime', '2023-11-21 12:56:11', '2023-11-21 12:56:11'),
	(10, 4, 'Per Diem', '2023-11-21 12:56:22', '2023-11-21 12:56:22'),
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.farmers: ~5 rows (approximately)
INSERT INTO `farmers` (`id`, `tenant_id`, `fname`, `mname`, `lname`, `id_number`, `farmerID`, `contact1`, `contact2`, `gender`, `join_date`, `dob`, `center_id`, `location`, `marital_status`, `status`, `education_level`, `bank_id`, `bank_branch`, `acc_name`, `acc_number`, `mpesa_number`, `nok_name`, `nok_phone`, `relationship`, `created_at`, `updated_at`) VALUES
	(1, 239, 'Ancent', 'Njoki', 'Mutuma', '33366869', 'MDC/002', '099877788', '888888', 'male', '2024-06-03', '2024-05-27', 1, 'TRM', 'single', '1', '4', 1, 'Meru', 'Alice Nkatha', '44444444', '4444444444', 'Majesty', '0747954284', 'brother', '2024-06-29 14:02:10', '2024-07-01 02:57:09'),
	(2, 239, 'Philemon', NULL, 'Makori', '33366878', 'MDC/0023', '07869996886', NULL, 'male', '2024-07-02', '2024-06-30', 1, 'MERU', 'single', '1', '4', 4, 'Embu', 'Alice Nkatha', '444444444454', '4444444444', 'Majesty', '0729303852', 'mother', '2024-07-01 02:54:40', '2024-07-15 18:26:15'),
	(3, 241, 'Data', NULL, 'Testing', '98765454', '3456', '078696886', '888888', 'male', '2024-07-01', '2024-06-30', 4, 'Embu', 'married', '1', '1', 4, 'Embu', 'Alice Nkatha', '45545554', '444444444409', 'Majesty', '0747954284', 'brother', '2024-07-21 18:50:58', '2024-07-21 18:50:58'),
	(4, 241, 'Data', NULL, 'Testing', '45646455', 'COWA/002', '070096886', NULL, 'male', '2024-07-03', '2024-07-24', 4, 'TRM', 'single', '1', '0', 5, 'Meru', 'Dorothy', '545554555466', '444444444409', 'Maxwell', '0747954284', 'brother', '2024-07-21 18:55:00', '2024-07-21 18:55:00'),
	(5, 239, 'Dedan', NULL, 'Wanjiru', '0765454', 'NKDCMBT023', '0786696886', NULL, 'male', '2024-07-02', '2024-07-01', 3, 'MERU', 'married', '1', '4', 1, 'Dagoretti', 'Alice Nkatha', '342112', '554444444', 'Majesty', '0747954284', 'brother', '2024-07-23 13:19:04', '2024-07-23 13:19:04');

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
	(1, 239, 3, 1, 'Credit Card', 4.00, 200.00, 300.00, '1', NULL, '2024-07-02 17:31:37', '2024-07-27 09:28:02', 'rrrrrrrrrrrr', 5.00),
	(2, 239, 4, 1, 'Molasses 20L', 11.00, 4500.00, 5000.00, '1', NULL, '2024-07-02 19:01:12', '2024-07-26 14:34:28', '44444444444', 5.00),
	(3, 239, 5, 3, 'Cat Feeds', 21.00, 590.00, 650.00, '1', NULL, '2024-07-03 15:42:08', '2024-07-27 04:30:14', NULL, 5.00),
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

-- Dumping data for table comaziwa.leaves: ~12 rows (approximately)
INSERT INTO `leaves` (`id`, `tenant_id`, `created_at`, `updated_at`, `employee_id`, `type`, `date_from`, `date_to`, `remaining_days`, `reasons`, `status`, `supervisor_id`) VALUES
	(33, 4, '2024-02-25 08:13:01', '2024-03-13 12:24:48', 158, '4', '2024-02-26', '2024-03-01', '21', 'Attending a church function.', 2, NULL),
	(34, 4, '2024-02-25 08:13:04', '2024-03-13 12:24:56', 158, '4', '2024-02-26', '2024-03-01', '21', 'Attending a church function.', 2, NULL),
	(36, 4, '2024-03-12 08:15:20', '2024-03-13 12:26:23', 161, '4', '2024-03-25', '2024-04-02', '21', 'Want to use this period to go for medical checkup in Takoradi.', 2, NULL),
	(37, 4, '2024-03-12 08:15:22', '2024-03-13 12:26:35', 161, '4', '2024-03-25', '2024-04-02', '21', 'Want to use this period to go for medical checkup in Takoradi.', 2, NULL),
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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.migrations: ~62 rows (approximately)
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
	(82, '2024_07_03_185602_add_field_to_inventories_table', 45),
	(83, '2024_07_12_055310_create_deduction_types_table', 46),
	(84, '2024_07_12_055829_create_deductions_table', 47),
	(85, '2024_07_12_084042_create_deduction_types_table', 48),
	(86, '2024_07_12_084222_create_deductions_table', 48),
	(87, '2024_07_13_182326_create_deductions_table', 49),
	(88, '2024_07_16_051739_create_share_contributions_table', 50),
	(89, '2024_07_16_125829_create_asset_categories_table', 51),
	(90, '2024_07_16_130056_create_assets_table', 51),
	(91, '2024_07_16_161619_create_milk_spillages_table', 52),
	(92, '2024_07_17_195245_create_payments_table', 53),
	(93, '2024_07_18_095711_create_share_settings_table', 54),
	(94, '2024_07_18_121222_create_share_settings_table', 55),
	(95, '2024_07_18_170518_create_share_settings_table', 56),
	(97, '2024_07_20_203435_add_field_to_milk_collections_table', 58),
	(98, '2024_07_19_134718_create_payments_table', 59),
	(99, '2024_07_26_171955_add_field_to_store_sales_table', 60),
	(100, '2024_07_27_064812_add_field_to_payments_table', 61),
	(101, '2024_07_27_065123_create_store_collections_table', 61),
	(102, '2024_07_27_071518_create_store_collections_table', 62);

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
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `milk_collections_tenant_id_foreign` (`tenant_id`),
  KEY `milk_collections_farmer_id_foreign` (`farmer_id`),
  KEY `milk_collections_center_id_foreign` (`center_id`),
  KEY `milk_collections_user_id_foreign` (`user_id`),
  CONSTRAINT `milk_collections_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collections_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collections_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.milk_collections: ~17 rows (approximately)
INSERT INTO `milk_collections` (`id`, `tenant_id`, `farmer_id`, `center_id`, `collection_date`, `morning`, `evening`, `rejected`, `total`, `user_id`, `created_at`, `updated_at`, `payment_status`) VALUES
	(1, 241, 3, 4, '2024-07-15', 23.00, 0.00, 0.00, 23.00, 181, '2024-07-22 16:29:28', '2024-07-22 16:29:28', 0),
	(2, 241, 4, 4, '2024-07-15', 45.00, 0.00, 0.00, 45.00, 181, '2024-07-22 16:29:28', '2024-07-22 16:29:28', 0),
	(3, 239, 1, 1, '2024-07-16', 20.00, 45.00, 0.00, 65.00, 180, '2024-07-23 02:15:49', '2024-07-27 19:50:19', 1),
	(4, 239, 2, 1, '2024-07-16', 405.00, 19.00, 0.00, 424.00, 180, '2024-07-23 02:15:49', '2024-07-27 19:50:19', 1),
	(5, 239, 1, 1, '2024-07-24', 68.00, 25.00, 0.00, 93.00, 180, '2024-07-23 02:16:28', '2024-07-27 19:50:19', 1),
	(6, 239, 2, 1, '2024-07-24', 89.00, 0.00, 0.00, 89.00, 180, '2024-07-23 02:16:28', '2024-07-27 19:50:19', 1),
	(7, 239, 1, 1, '2024-06-30', 12.00, 19.00, 0.00, 31.00, 180, '2024-07-23 02:16:55', '2024-07-27 04:01:22', 1),
	(8, 239, 2, 1, '2024-06-30', 34.00, 6.00, 0.00, 40.00, 180, '2024-07-23 02:16:55', '2024-07-27 04:01:22', 1),
	(9, 239, 1, 1, '2024-05-14', 34.00, 19.00, 0.00, 53.00, 180, '2024-07-23 02:17:48', '2024-07-23 02:17:48', 0),
	(10, 239, 2, 1, '2024-05-14', 12.00, 8.00, 0.00, 20.00, 180, '2024-07-23 02:17:48', '2024-07-23 02:17:48', 0),
	(11, 239, 1, 1, '2024-04-23', 45.00, 19.00, 0.00, 64.00, 180, '2024-07-23 02:47:41', '2024-07-23 02:47:41', 0),
	(12, 239, 2, 1, '2024-04-23', 29.00, 12.00, 0.00, 41.00, 180, '2024-07-23 02:47:41', '2024-07-23 02:47:41', 0),
	(13, 239, 5, 3, '2024-06-11', 56.00, 88.00, 0.00, 144.00, 180, '2024-07-23 13:19:36', '2024-07-23 13:19:36', 0),
	(14, 239, 5, 3, '2024-05-27', 56.00, 54.00, 0.00, 110.00, 180, '2024-07-23 13:21:13', '2024-07-23 13:21:13', 0),
	(16, 239, 1, 1, '2024-04-08', 5.00, 0.00, 0.00, 5.00, 180, '2024-07-24 15:36:20', '2024-07-24 15:36:20', 0),
	(17, 239, 2, 1, '2024-04-08', 4.00, 0.00, 0.00, 4.00, 180, '2024-07-24 15:36:20', '2024-07-24 15:36:20', 0),
	(18, 239, 1, 1, '2024-07-25', 340.00, 0.00, 0.00, 340.00, 180, '2024-07-27 19:20:15', '2024-07-27 19:50:19', 1),
	(19, 239, 2, 1, '2024-07-25', 340.00, 0.00, 0.00, 340.00, 180, '2024-07-27 19:20:15', '2024-07-27 19:50:19', 1),
	(20, 239, 1, 1, '2024-07-29', 45.00, 0.00, 0.00, 45.00, 180, '2024-07-27 19:42:54', '2024-07-27 19:50:19', 1),
	(21, 239, 2, 1, '2024-07-29', 56.00, 0.00, 0.00, 56.00, 180, '2024-07-27 19:42:54', '2024-07-27 19:50:19', 1),
	(22, 239, 1, 1, '2024-07-26', 3.00, 0.00, 0.00, 3.00, 180, '2024-07-27 19:46:03', '2024-07-27 19:50:19', 1),
	(23, 239, 2, 1, '2024-07-26', 2.00, 0.00, 0.00, 2.00, 180, '2024-07-27 19:46:03', '2024-07-27 19:50:19', 1),
	(24, 239, 1, 1, '2024-07-27', 34.00, 0.00, 0.00, 34.00, 180, '2024-07-27 19:49:50', '2024-07-27 19:50:19', 1),
	(25, 239, 2, 1, '2024-07-27', 46.00, 0.00, 0.00, 46.00, 180, '2024-07-27 19:49:50', '2024-07-27 19:50:19', 1);

-- Dumping structure for table comaziwa.milk_spillages
CREATE TABLE IF NOT EXISTS `milk_spillages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `center_id` bigint unsigned DEFAULT NULL,
  `is_cooperative` tinyint(1) NOT NULL DEFAULT '0',
  `quantity` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milk_spillages_center_id_foreign` (`center_id`),
  KEY `milk_spillages_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `milk_spillages_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_spillages_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.milk_spillages: ~2 rows (approximately)
INSERT INTO `milk_spillages` (`id`, `tenant_id`, `center_id`, `is_cooperative`, `quantity`, `date`, `comments`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 239, NULL, 1, 78.00, '2024-07-18', 'Test', 239, '2024-07-17 03:42:52', '2024-07-27 16:36:46'),
	(2, 239, 1, 0, 60.00, '2024-07-18', NULL, 239, '2024-07-17 05:48:21', '2024-07-27 16:34:38');

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

-- Dumping structure for table comaziwa.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned NOT NULL,
  `center_id` bigint unsigned NOT NULL,
  `total_milk` double(8,2) NOT NULL,
  `milk_rate` double(8,2) NOT NULL,
  `gross_pay` double(8,2) DEFAULT NULL,
  `store_deductions` double(8,2) NOT NULL,
  `individual_deductions` double(8,2) NOT NULL,
  `general_deductions` double(8,2) NOT NULL,
  `shares_contribution` double(8,2) DEFAULT NULL,
  `previous_dues` double(8,2) DEFAULT NULL,
  `pay_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonus_rate` double(8,2) DEFAULT NULL,
  `generated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_tenant_id_foreign` (`tenant_id`),
  KEY `payments_farmer_id_foreign` (`farmer_id`),
  KEY `payments_center_id_foreign` (`center_id`),
  CONSTRAINT `payments_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.payments: ~12 rows (approximately)
INSERT INTO `payments` (`id`, `tenant_id`, `farmer_id`, `center_id`, `total_milk`, `milk_rate`, `gross_pay`, `store_deductions`, `individual_deductions`, `general_deductions`, `shares_contribution`, `previous_dues`, `pay_period`, `bonus_rate`, `generated_by`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 1, 31.00, 100.00, 3100.00, 0.00, 0.00, 0.00, 500.00, 0.00, '2024-06', 2.00, 239, '2024-07-27 04:01:22', '2024-07-27 04:01:22'),
	(2, 239, 2, 1, 40.00, 100.00, 4000.00, 0.00, 1000.00, 0.00, 500.00, 0.00, '2024-06', 2.00, 239, '2024-07-27 04:01:22', '2024-07-27 04:01:22'),
	(3, 239, 1, 1, 158.00, 100.00, 15800.00, 650.00, 2000.00, 570.00, 500.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 09:28:55', '2024-07-27 09:28:55'),
	(4, 239, 2, 1, 148.00, 100.00, 14800.00, 600.00, 1000.00, 570.00, 500.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 09:28:55', '2024-07-27 09:28:55'),
	(5, 239, 1, 1, 340.00, 100.00, 34000.00, 650.00, 2000.00, 570.00, 0.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 19:21:28', '2024-07-27 19:21:28'),
	(6, 239, 2, 1, 340.00, 100.00, 34000.00, 600.00, 1000.00, 570.00, 0.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 19:21:28', '2024-07-27 19:21:28'),
	(7, 239, 1, 1, 45.00, 100.00, 4500.00, 650.00, 2000.00, 570.00, 490.00, 0.00, '2024-07', 2.00, 239, '2024-07-27 19:44:09', '2024-07-27 19:44:09'),
	(8, 239, 2, 1, 56.00, 100.00, 5600.00, 600.00, 1000.00, 570.00, 500.00, 0.00, '2024-07', 2.00, 239, '2024-07-27 19:44:09', '2024-07-27 19:44:09'),
	(9, 239, 1, 1, 3.00, 230.00, 690.00, 650.00, 2000.00, 570.00, 0.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 19:46:33', '2024-07-27 19:46:33'),
	(10, 239, 2, 1, 2.00, 230.00, 460.00, 600.00, 1000.00, 570.00, 500.00, 0.00, '2024-07', 0.00, 239, '2024-07-27 19:46:33', '2024-07-27 19:46:33'),
	(11, 239, 1, 1, 34.00, 100.00, 3400.00, 650.00, 2000.00, 570.00, 0.00, 0.00, '2024-07', 2.00, 239, '2024-07-27 19:50:19', '2024-07-27 19:50:19'),
	(12, 239, 2, 1, 46.00, 100.00, 4600.00, 600.00, 1000.00, 570.00, 500.00, 0.00, '2024-07', 2.00, 239, '2024-07-27 19:50:19', '2024-07-27 19:50:19');

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
	(8, 4, 13, 1000.00, 504.65, 2315.35, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":150,"id":1},{"name":"Transport Subsidies","value":100,"id":2},{"name":"Lunch Subsidy","value":125,"id":3},{"name":"Clothing Allowance","value":500,"id":4},{"name":"Risk Allowance","value":100,"id":37}]', '[{"name":"Company Vehicle Only","value":500,"id":1},{"name":"Fuel","value":250,"id":2},{"name":"Accommodation","value":750,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":50,"id":1},{"name":"Staff Loan Deductions","value":500,"id":2},{"name":"Union Dues","value":50,"id":3}]', '2024-01-29 13:06:10', '2024-02-06 08:34:17'),
	(9, 4, 172, 1000.00, 229.55, 1015.45, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":50,"id":1},{"name":"Transport Subsidies","value":50,"id":2},{"name":"Lunch Subsidy","value":50,"id":3},{"name":"Clothing Allowance","value":100,"id":4},{"name":"Risk Allowance","value":50,"id":37}]', '[{"name":"Company Vehicle Only","value":0,"id":1},{"name":"Fuel","value":0,"id":2},{"name":"Accommodation","value":0,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":0,"id":1},{"name":"Staff Loan Deductions","value":0,"id":2},{"name":"Union Dues","value":0,"id":3}]', '2024-01-29 14:13:38', '2024-01-29 14:13:38');

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

-- Dumping structure for table comaziwa.share_contributions
CREATE TABLE IF NOT EXISTS `share_contributions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `center_id` bigint unsigned NOT NULL,
  `farmer_id` bigint unsigned NOT NULL,
  `share_value` double(8,2) NOT NULL,
  `issue_date` date NOT NULL,
  `mode_of_contribution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `share_contributions_tenant_id_foreign` (`tenant_id`),
  KEY `share_contributions_farmer_id_foreign` (`farmer_id`),
  KEY `share_contributions_center_id_foreign` (`center_id`),
  CONSTRAINT `share_contributions_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `collection_centers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `share_contributions_farmer_id_foreign` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `share_contributions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.share_contributions: ~30 rows (approximately)
INSERT INTO `share_contributions` (`id`, `tenant_id`, `center_id`, `farmer_id`, `share_value`, `issue_date`, `mode_of_contribution`, `user_id`, `description`, `created_at`, `updated_at`) VALUES
	(1, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:21:55', '2024-07-21 13:21:55'),
	(2, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:21:55', '2024-07-21 13:21:55'),
	(3, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:22:34', '2024-07-21 13:22:34'),
	(4, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:22:34', '2024-07-21 13:22:34'),
	(5, 239, 1, 1, 1600.00, '2024-07-15', 'cash', NULL, '4444444444', '2024-07-21 13:23:38', '2024-07-21 13:23:38'),
	(6, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:24:22', '2024-07-21 13:24:22'),
	(7, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:24:22', '2024-07-21 13:24:22'),
	(8, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:27:57', '2024-07-21 13:27:57'),
	(9, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:27:57', '2024-07-21 13:27:57'),
	(10, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:41:22', '2024-07-21 13:41:22'),
	(11, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 13:41:22', '2024-07-21 13:41:22'),
	(12, 239, 1, 1, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 14:32:42', '2024-07-21 14:32:42'),
	(13, 239, 1, 2, 500.00, '2024-07-21', 'milk', NULL, NULL, '2024-07-21 14:32:42', '2024-07-21 14:32:42'),
	(14, 239, 1, 1, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 03:12:14', '2024-07-27 03:12:14'),
	(15, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 03:12:14', '2024-07-27 03:12:14'),
	(16, 239, 1, 1, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 03:58:51', '2024-07-27 03:58:51'),
	(17, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 03:58:51', '2024-07-27 03:58:51'),
	(18, 239, 1, 1, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 04:01:22', '2024-07-27 04:01:22'),
	(19, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 04:01:22', '2024-07-27 04:01:22'),
	(20, 239, 1, 1, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 09:28:55', '2024-07-27 09:28:55'),
	(21, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 09:28:55', '2024-07-27 09:28:55'),
	(22, 239, 1, 1, 3400.00, '2024-07-27', 'cash', NULL, '55555555', '2024-07-27 19:17:41', '2024-07-27 19:17:41'),
	(23, 239, 1, 1, 1510.00, '2024-07-27', 'cash', NULL, '3333333333', '2024-07-27 19:19:29', '2024-07-27 19:19:29'),
	(24, 239, 1, 1, 0.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:21:28', '2024-07-27 19:21:28'),
	(25, 239, 1, 2, 0.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:21:28', '2024-07-27 19:21:28'),
	(26, 239, 1, 1, 490.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:44:09', '2024-07-27 19:44:09'),
	(27, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:44:09', '2024-07-27 19:44:09'),
	(28, 239, 1, 1, 0.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:46:33', '2024-07-27 19:46:33'),
	(29, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:46:33', '2024-07-27 19:46:33'),
	(30, 239, 1, 2, 500.00, '2024-07-27', 'milk', NULL, NULL, '2024-07-27 19:50:19', '2024-07-27 19:50:19');

-- Dumping structure for table comaziwa.share_settings
CREATE TABLE IF NOT EXISTS `share_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `shares_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shares_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction_amount` double(8,2) NOT NULL,
  `accumulative_amount` double(8,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `share_settings_shares_code_unique` (`shares_code`),
  KEY `share_settings_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `share_settings_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.share_settings: ~1 rows (approximately)
INSERT INTO `share_settings` (`id`, `tenant_id`, `shares_name`, `shares_code`, `deduction_amount`, `accumulative_amount`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
	(2, 239, 'Coop', '7895711', 500.00, 12000.00, 1, 'H', '2024-07-18 14:08:07', '2024-07-18 14:08:07');

-- Dumping structure for table comaziwa.store_collections
CREATE TABLE IF NOT EXISTS `store_collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collected_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_on` date DEFAULT NULL,
  `vehicle_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_collections_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `store_collections_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.store_collections: ~1 rows (approximately)
INSERT INTO `store_collections` (`id`, `tenant_id`, `transaction_id`, `collected_by`, `id_number`, `collection_on`, `vehicle_no`, `created_at`, `updated_at`) VALUES
	(1, 239, '6752528', 'Ancent', '33366878', '2024-07-25', '6666666', '2024-07-27 04:30:14', '2024-07-27 04:30:14'),
	(2, 239, '8837234', 'Ancent', '33366878', '2024-07-27', '6666666', '2024-07-27 09:28:03', '2024-07-27 09:28:03');

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
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

-- Dumping data for table comaziwa.store_sales: ~6 rows (approximately)
INSERT INTO `store_sales` (`id`, `tenant_id`, `center_id`, `farmer_id`, `category_id`, `item_id`, `order_date`, `qty`, `unit_cost`, `total_cost`, `payment_mode`, `description`, `user_id`, `status`, `created_at`, `updated_at`, `transaction_id`) VALUES
	(1, 239, 1, 1, 5, 3, '2024-07-16', 1, 650.00, 650.00, '1', NULL, 239, 0, '2024-07-21 13:37:54', '2024-07-21 13:37:54', '234'),
	(2, 239, 1, 2, 3, 1, '2024-07-10', 1, 300.00, 300.00, '2', NULL, 239, 0, '2024-07-21 13:40:16', '2024-07-21 13:40:16', '235'),
	(3, 239, 3, 5, 5, 3, '2024-07-24', 1, 650.00, 650.00, '1', NULL, 239, 0, '2024-07-26 14:34:28', '2024-07-26 14:34:28', '9860228'),
	(4, 239, 3, 5, 4, 2, '2024-07-24', 1, 5000.00, 5000.00, '1', NULL, 239, 0, '2024-07-26 14:34:28', '2024-07-26 14:34:28', '9860228'),
	(5, 239, 3, 5, 5, 3, '2024-07-16', 1, 650.00, 650.00, '1', NULL, 239, 0, '2024-07-27 04:29:25', '2024-07-27 04:29:25', '3562612'),
	(6, 239, 3, 5, 5, 3, '2024-07-16', 1, 650.00, 650.00, '1', NULL, 239, 0, '2024-07-27 04:30:14', '2024-07-27 04:30:14', '6752528'),
	(7, 239, 1, 2, 3, 1, '2024-07-27', 2, 300.00, 600.00, '1', NULL, 239, 0, '2024-07-27 09:28:02', '2024-07-27 09:28:02', '8837234');

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
	(2, 4, 2, 'monthly', 20.00, '2023-12-31 00:00', '2024-01-30', '2023-11-21 11:33:09', '2023-11-21 11:33:09');

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
	(5, 4, 'Performance  Appraisal Training', 'compulsory', '2024-01-28', '2024-01-29', 'Compulsory for all supervisors and managers', 0, '2024-01-29 12:05:11', '2024-01-29 12:05:11', 'JPCann', '08:00', 'Accra'),
	(6, 4, 'Growth Mindset', 'compulsory', '2024-02-05', '2024-02-05', 'Attend training', 0, '2024-02-06 12:06:21', '2024-02-06 12:19:47', 'JPCann', '08:00', 'JPCann Premises'),
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
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table comaziwa.users: ~9 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone_number`, `type`, `package_id`, `expiry_date`, `role_id`, `is_system`, `agent_id`) VALUES
	(1, 'Superadmin', 'superadmin@gmail.com', NULL, '$2y$10$6P8zt4fkmdg4cwNzWHs3au82GQMThLG1nFN12TROZklWZVFtB.3nS', NULL, '2023-10-31 01:47:26', '2023-10-31 01:47:26', '0717576900', 'superadmin', 3, '2023-11-30', 0, 1, '0'),
	(2, 'Jonathan Can', 'advisor3ghana@gmail.com', NULL, '$2y$10$nvYJ/jjCMnIL.GjhXoSL3OjVX1N.Nfa6VKD/4KJim0O62pWGV4I1m', NULL, '2023-11-01 10:18:00', '2023-11-01 10:18:00', '0501335817', 'superadmin', NULL, NULL, 3, 0, '0'),
	(3, 'Kobina Akyea', 'KAKYEA@YAHOO.COM', NULL, '$2y$10$3zza6Awez.LiE997zIWG..9TdwZOOFfpULCizxOcNQI53rlEO7fou', NULL, '2023-11-01 10:44:40', '2024-01-15 08:33:44', '0501335817', 'client', 2, '2024-12-31', 0, 0, '1'),
	(4, 'Tracey Cann', 'tracey.cann@jpcannassociates.com', NULL, '$2y$10$LC9tjGixKDzyoqhpcCfROOGSvPoRqVaOAiVqsSw0xvha7g9/92G.2', NULL, '2023-11-01 10:51:40', '2024-04-08 12:59:03', '0501335818', 'client', 2, '2024-12-31', 0, 0, '1'),
	(25, 'Demo', 'it@cowango.org', NULL, '$2y$10$6P8zt4fkmdg4cwNzWHs3au82GQMThLG1nFN12TROZklWZVFtB.3nS', NULL, '2023-11-21 11:29:59', '2024-02-28 15:52:35', '0501457253', 'client', 13, '2024-03-29', 0, 0, '0'),
	(237, 'Ancent Mbithi', 'ancentmbithi@cowango.org', NULL, '$2y$10$6BMZM6hH5RnFIJr3NJbgOOI72/usDsWLpQzWDkllJ4XlIi5MCEJH2', NULL, '2024-06-04 02:52:10', '2024-06-04 02:52:10', '0795974284', 'client', 3, '2024-07-04', 0, 0, '0'),
	(238, 'Dedan', 'wanjirudedan@gmail.com', NULL, '$2y$10$Zlz92Y.EZ7hwSgkaDU3k2Oe3nno.OaXTZaDcQMUTsU.ByMeYST42y', NULL, '2024-06-18 04:27:10', '2024-06-27 09:51:39', '0724654191', 'client', 1, '2024-07-18', 0, 0, '0'),
	(239, 'Mwalyo', 'mbithiconie@gmail.com', NULL, '$2y$10$rRBIbCvmNhbJ2aIbKZm/te2xenW0sSRQABmPlYdVb0vCYOUgzjIK2', NULL, '2024-06-29 05:28:27', '2024-06-29 05:28:27', '0747954284', 'client', 3, '2025-07-29', 0, 0, '0'),
	(241, 'Ancent Mwalyo', 'mbithimarion@gmail.com', NULL, '$2y$10$fL06e085Ldwjr.kzMMeLMOKbBy/Ty7m84g.dBpFp8aVR7EkTiI6Ei', NULL, '2024-07-21 17:18:22', '2024-07-21 17:18:22', '07954284', 'client', 3, '2024-08-20', 0, 0, '0'),
	(242, 'Elisha Juma', 'ejuma@ect.ac.ke', NULL, '$2y$10$/NqzVi3iXeauvMm.D6Ig0uDPUEwOJDqc76B0TXT0B26vm0hNQn1W2', NULL, '2024-07-26 08:26:03', '2024-07-26 08:26:03', '0747954290', 'client', 3, '2024-08-25', 0, 0, '0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
