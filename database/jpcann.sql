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


-- Dumping database structure for ghana_payroll
CREATE DATABASE IF NOT EXISTS `ghana_payroll` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ghana_payroll`;

-- Dumping structure for table ghana_payroll.agents
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

-- Dumping data for table ghana_payroll.agents: ~3 rows (approximately)
INSERT INTO `agents` (`id`, `name`, `email`, `phone_no`, `address`, `created_at`, `updated_at`) VALUES
	(1, 'Sandys Lartey', 'sandys.lartey@jpcannassociates.com', '23354249800', '58 Nsawam Road', '2023-11-03 10:45:13', '2023-11-03 10:46:03'),
	(2, 'Ben laryea', 'ben.laryea92@gmail.com', '0244218288', '75 MINISTRIES ROAD', '2024-01-16 16:54:36', '2024-01-16 16:54:36'),
	(3, 'Edmund Toffey', 'edtoffey@proton.me', '0202368640', '75 MINISTRIES ROAD', '2024-01-29 12:58:29', '2024-01-29 12:58:29');

-- Dumping structure for table ghana_payroll.agent_payments
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

-- Dumping data for table ghana_payroll.agent_payments: ~0 rows (approximately)
INSERT INTO `agent_payments` (`id`, `agent_id`, `date`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 1, '2024-01-29', 4.00, '2024-01-29 12:59:59', '2024-01-29 12:59:59');

-- Dumping structure for table ghana_payroll.allowances
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.allowances: ~13 rows (approximately)
INSERT INTO `allowances` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Responsibility Allowance', 'percentage', 12.50, '2023-11-01 12:27:16', '2023-11-01 12:27:16'),
	(2, 4, 'Transport Subsidies', 'percentage', 15.00, '2023-11-01 12:28:12', '2023-11-01 12:28:12'),
	(3, 4, 'Lunch Subsidy', 'percentage', 12.50, '2023-11-01 12:29:02', '2023-11-01 12:29:02'),
	(4, 4, 'Clothing Allowance', 'fixed', 500.00, '2023-11-01 12:29:37', '2024-01-16 17:05:02'),
	(26, 3, 'Launch Subsidy', 'fixed', 200.00, '2024-01-15 08:51:06', '2024-01-15 08:51:06'),
	(27, 3, 'Clothing Allowance', 'fixed', 500.00, '2024-01-15 08:51:37', '2024-01-15 08:51:37'),
	(28, 3, 'Medical Allowance', 'percentage', 15.00, '2024-01-15 08:52:02', '2024-01-15 08:52:02'),
	(31, 109, 'travel allowances', 'fixed', 550.00, '2024-01-16 11:44:08', '2024-01-16 11:44:08'),
	(32, 109, 'performance allowances', 'fixed', 500.00, '2024-01-16 11:44:58', '2024-01-16 11:44:58'),
	(33, 109, 'Fuel Allowance', 'fixed', 500.00, '2024-01-16 11:45:30', '2024-01-16 11:45:30'),
	(34, 109, 'Medical coverage', 'percentage', 30.00, '2024-01-16 11:45:53', '2024-01-16 11:45:53'),
	(36, 109, 'Clothing Allowance', 'fixed', 150.00, '2024-01-16 11:47:57', '2024-01-16 11:47:57'),
	(37, 4, 'Risk Allowance', 'percentage', 15.00, '2024-01-16 17:04:29', '2024-01-16 17:04:29'),
	(38, 172, 'House', 'fixed', 6000.00, '2024-02-15 23:48:32', '2024-02-15 23:48:32'),
	(39, 172, 'Medical', 'fixed', 2000.00, '2024-02-15 23:49:13', '2024-02-15 23:49:13');

-- Dumping structure for table ghana_payroll.attendances
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.attendances: ~5 rows (approximately)
INSERT INTO `attendances` (`id`, `created_at`, `updated_at`, `tenant_id`, `employee_id`, `date`, `punch_in`, `punch_out`, `punch_in_status`, `punch_out_status`) VALUES
	(3, '2024-02-06 10:44:32', '2024-02-06 10:44:32', 4, 158, '2024-02-06', '["2024-02-06 10:44:32"]', NULL, 1, 0),
	(4, '2024-02-12 09:04:34', '2024-02-12 09:04:34', 4, 172, '2024-02-12', '["2024-02-12 09:04:34"]', NULL, 1, 0),
	(5, '2024-02-13 08:17:22', '2024-02-13 08:17:22', 4, 172, '2024-02-13', '["2024-02-13 08:17:22"]', NULL, 1, 0),
	(6, '2024-02-14 09:45:43', '2024-02-14 09:47:26', 4, 172, '2024-02-14', '["2024-02-14 09:45:43","2024-02-14 09:47:26"]', '["2024-02-14 09:45:59"]', 1, 0),
	(7, '2024-02-15 08:24:10', '2024-02-15 08:24:36', 4, 172, '2024-02-15', '["2024-02-15 08:24:10","2024-02-15 08:24:36"]', '["2024-02-15 08:24:21"]', 1, 0);

-- Dumping structure for table ghana_payroll.benefits_in_kinds
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.benefits_in_kinds: ~5 rows (approximately)
INSERT INTO `benefits_in_kinds` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Company Vehicle Only', 'fixed', 500.00, '2023-11-03 11:00:58', '2023-11-03 11:00:58'),
	(2, 4, 'Fuel', 'fixed', 250.00, '2023-11-03 11:01:47', '2023-11-03 11:01:47'),
	(7, 109, 'comapany car', 'fixed', 300.00, '2024-01-16 11:52:58', '2024-01-16 11:52:58'),
	(8, 109, 'staff meals', 'percentage', 15.00, '2024-01-16 11:53:36', '2024-01-16 11:53:36'),
	(9, 4, 'Accommodation', 'fixed', 750.00, '2024-01-16 17:05:58', '2024-01-16 17:05:58'),
	(10, 172, 'Data', 'fixed', 2900.00, '2024-02-15 23:49:53', '2024-02-15 23:49:53');

-- Dumping structure for table ghana_payroll.company_profiles
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
  PRIMARY KEY (`id`),
  KEY `company_profiles_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `company_profiles_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.company_profiles: ~5 rows (approximately)
INSERT INTO `company_profiles` (`id`, `tenant_id`, `name`, `ssni_est`, `address`, `email`, `tel_no`, `logo`, `created_at`, `updated_at`, `tin`, `secondary_email`, `land_line`) VALUES
	(1, 3, 'KACANN', 'CO20064587', '58 Nsawam Road', 'KAKYEA@YAHOO.COM', '+233302974302', '24390878.jpg', '2023-11-01 10:44:40', '2024-01-15 08:46:17', 'CO20064587', 'KAKYEA@YAHOO.COM', '+233302974302'),
	(2, 4, 'JPCANN ASSOCIATES LIMITED', 'JPCANN ASSOCIATES LIMITED', '58 NSAWAM ROAD, KOKOMLEMLE, ACCRA', 'info@jpcannassociates.com', '0501335818', '2131164496.jpg', '2023-11-01 10:51:40', '2024-01-15 14:48:06', 'JPCANN ASSOCIATES LIMITED', 'info@jpcannassociates.com', '0302974302'),
	(23, 109, 'etoffema company', '789655541', 'No.58 NSAWAM ROAD', 'currytoffey30@gmail.com', '0202368640', '1804941686.jpg', '2024-01-16 11:06:19', '2024-02-06 11:51:22', '11233', 'jeoltoffry@gmail.com', '0202368640'),
	(24, 110, 'Cannyzer Global Enterprise', 'A047709180038', 'Elephant Street, Amasaman', 'cannyzer1@gmail.com', '+233545950291', '1928435423.jpg', '2024-01-18 12:02:21', '2024-01-18 12:02:21', 'P00 01812785', 'cannyzer1@gmail.com', NULL),
	(25, 127, 'Fort Sort Innovations LTD', 'K3494234U', 'Westcom Point, Westlands', 'daniel.mutuku404@gmail.com', '0717576900', '1492730179.png', '2024-02-12 06:31:05', '2024-02-13 01:24:19', 'FKN34KK43', 'daniel.mutuku404@gmail.com', '4828838834'),
	(26, 172, 'Truetech', '2309', '6566', 'ancentmbithi@gmail.com', '0795974284', '679167079.png', '2024-02-15 23:39:45', '2024-02-15 23:39:45', '790', 'ancentmbithii8@gmail.com', '909099999');

-- Dumping structure for table ghana_payroll.contracts
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.contracts: ~4 rows (approximately)
INSERT INTO `contracts` (`id`, `tenant_id`, `employee_id`, `file`, `created_at`, `updated_at`) VALUES
	(1, 4, 13, 'Jonathan-prince-cann-.pdf', '2023-11-03 11:11:36', '2023-11-03 11:11:36'),
	(2, 109, 151, 'Joel-toffey-.pdf', '2024-01-16 12:28:29', '2024-01-16 12:28:29'),
	(3, 172, 189, 'Mwalyo-.docx', '2024-02-16 15:35:27', '2024-02-16 15:35:27'),
	(4, 172, 190, 'Philemon-.docx', '2024-02-16 15:40:04', '2024-02-16 15:40:04');

-- Dumping structure for table ghana_payroll.contract_types
CREATE TABLE IF NOT EXISTS `contract_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `contract_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.contract_types: ~20 rows (approximately)
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
	(38, 109, 'Management Department', '2024-01-16 11:59:15', '2024-01-16 11:59:15'),
	(39, 109, 'marketing department', '2024-01-16 11:59:49', '2024-01-16 11:59:49'),
	(40, 109, 'IT Department', '2024-01-16 12:00:49', '2024-01-16 12:00:49'),
	(41, 109, 'Logistic Department', '2024-01-16 12:01:33', '2024-01-16 12:01:33'),
	(42, 109, 'Accounting department', '2024-01-16 12:01:49', '2024-01-16 12:01:49'),
	(43, 110, 'Administration Department', '2024-01-20 11:50:48', '2024-01-20 11:53:13'),
	(44, 110, 'Account Department', '2024-01-20 11:51:30', '2024-01-20 11:51:30'),
	(45, 110, 'Health and safety Department', '2024-01-20 11:51:59', '2024-01-20 11:51:59'),
	(46, 110, 'Human Resource Department', '2024-01-20 11:52:35', '2024-01-20 11:52:35'),
	(47, 110, 'Human Resource Department', '2024-01-20 11:52:35', '2024-01-20 11:52:35'),
	(48, 127, 'Tech', '2024-02-12 06:35:40', '2024-02-12 06:35:40'),
	(49, 172, 'IT Department', '2024-02-15 23:46:33', '2024-02-15 23:46:33'),
	(50, 172, 'Procurement', '2024-02-15 23:46:45', '2024-02-15 23:46:45'),
	(51, 172, 'Accounts', '2024-02-15 23:47:11', '2024-02-15 23:47:11');

-- Dumping structure for table ghana_payroll.deductions
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

-- Dumping data for table ghana_payroll.deductions: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.emails
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.emails: ~5 rows (approximately)
INSERT INTO `emails` (`id`, `tenant_id`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
	(1, 110, 'chriscann2023@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:40', '2024-02-07 11:42:40'),
	(2, 110, 'joefoli.jf5@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:40', '2024-02-07 11:42:40'),
	(3, 110, 'chriscann2023@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:42', '2024-02-07 11:42:42'),
	(4, 110, 'joefoli.jf5@gmail.com', 'Request to attend monthly employees Health and Safety Training', 'You have been selected to attend the employees health and safety training that is scheduled at the end of every month 30th February, 2024. The venue is located within the office premises and the time is 2pm promptly. Thank you!', 0, '2024-02-07 11:42:42', '2024-02-07 11:42:42');

-- Dumping structure for table ghana_payroll.email_settings
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

-- Dumping data for table ghana_payroll.email_settings: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.email_templates
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.email_templates: ~1 rows (approximately)
INSERT INTO `email_templates` (`id`, `tenant_id`, `name`, `template`, `created_at`, `updated_at`) VALUES
	(7, 172, 'Festive Season', 'rrrrrrrrrrrrrrrrrr', '2024-02-16 23:57:26', '2024-02-16 23:58:36');

-- Dumping structure for table ghana_payroll.employees
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  UNIQUE KEY `employees_phone_no_unique` (`phone_no`),
  UNIQUE KEY `employees_staff_no_unique` (`staff_no`),
  UNIQUE KEY `employees_ssn_unique` (`ssn`),
  UNIQUE KEY `employees_account_no_unique` (`account_no`),
  KEY `employees_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `employees_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.employees: ~25 rows (approximately)
INSERT INTO `employees` (`id`, `tenant_id`, `name`, `email`, `phone_no`, `staff_no`, `position`, `dob`, `bank_name`, `branch_name`, `branch_shortcode`, `account_no`, `created_at`, `updated_at`, `password`, `ssn`, `contract_type`, `nok_name`, `nok_phone`, `address`) VALUES
	(13, 4, 'JONATHAN PRINCE CANN', 'j.cann@jpcannassociates.com', '+233241121761', 'JPC1001', 'CEO', '1980-11-03', 'ECOBANK', 'Ring Road', '4006', '400645878952', '2023-11-03 10:54:29', '2024-02-06 08:28:10', '$2y$10$NrGaSle4Syz8ihCDPm7pSOkQQNSV4O/4KQ5VeOngwymNvGJPhQ0Iy', 'CO1254879', 1, 'JO GYATA', '+23345698745', '58 NSAWAM ROAD'),
	(14, 4, 'Sandys Lartey', 'sandys.lartey@jpcannassociates.com', '0504249800', 'JPC1004', 'IT Manager', '1987-05-12', 'Stanbic', 'NIA', '10021', '400400456', '2023-11-03 13:09:44', '2023-11-03 13:11:14', '$2y$10$XiZ96N3ygy6.kemLmwrxX.e9rczWMIPr4vizaoa4oJQ.7luuLITc2', 'CB389854652', 5, 'Uncle Ebo', '+233302974302', '58 Nsawam Road'),
	(15, 4, 'Tracey Cann', 'tracey.cann@jpcannassociates.com', '0501335818', 'JPC1002', 'Director, Business Development', '1981-06-10', 'UBA', 'Ring', '7005', '876985224', '2023-11-03 13:14:47', '2023-11-03 13:14:47', '$2y$10$ZY66.hF0TaqwhxApbYoVYurfJ.LLifn5JneBVwaoLUH7/pvC4PWCK', 'CC45258577', 0, 'Kirtsy', '0501626969', '51 Lower McCarthy Hill'),
	(22, 4, 'Benjamin Laryea', 'benjamin.laryea@jpcannassociates.com', '0501457253', 'JPC1009', 'Account Officer', '1992-06-09', 'Stanbic', 'Makola', '1007', '94000975852', '2023-11-21 11:48:15', '2024-02-12 11:34:12', '$2y$10$SikWJ6oE5Ik2KVah7cFd8uNqC/7q8isrTMg6aC0lqXqaqycgHiVaa', 'KY54587655', 6, 'Joshua Laryea', '0272623315', 'A66/5 Chorkor Chemunaa'),
	(149, 3, 'Enoch Mensah', 'enoch.mensah@jpcannassociates.com', '+233302974302', 'OGSL10001', 'Finance Officer', '1975-02-12', 'Stanbic Bank Ghana', 'ATUABO', '10023', '40054789545', '2024-01-15 08:48:07', '2024-01-15 08:48:07', '$2y$10$HlkvvD9/HWLtd93TXFODs.kxwxju3DL.UaUnzS5ysvkehneXx9ZdO', 'SE5466998788', 0, 'Indhira Ghandi', '+233111111111', '58 Nsawam Road'),
	(150, 4, 'Ernest Awuku', 'ernest.awuku@jpcannassociates.com', '+233244218288', 'JPC1007', 'Training Operations Manager', '1981-11-21', 'ABSA', 'Dansoman', '30107', '1065081', '2024-01-15 14:47:25', '2024-02-14 14:45:25', '$2y$10$GicNSGa6VO2wV1ize1Lc/eQNfzjKXYGNkQFUm/wg9NjF/NJFP3eWi', 'C018111210112', 7, 'Brianna Nana Ama Awukubea Awuku', '+233244218288', 'No. A140/4, Kelee Street, Laterbiokoshie'),
	(151, 109, 'Joel Toffey', 'louistoffegee@gmail.com', '0558313155', '3094453', 'IT DEPARTMENT', '2007-03-20', 'ADB', 'Kokomelmel', '2236', '1254477963', '2024-01-16 12:08:21', '2024-02-06 11:41:21', '$2y$10$FR65AOB1xtYxxamoWVHVYepmKcdQodsaampdzlTwmOqbMTSV2Arv6', '12255', 40, 'Louis Toffey', '0202368643', 'No.58 NSAWAM ROAD'),
	(152, 109, 'Sena Opoku', 'senaopoku@gmail.com', '0558314156', '6730305', 'accounting department', '2001-03-16', 'CBG', 'Circle', '22365', '12544779635', '2024-01-16 12:15:14', '2024-01-16 12:15:14', '$2y$10$nSuEMJ0zP/8xtaEHe6mCoOeeRusy72rJcBxd9y6jDRdn.hKJACGgu', '5598', 0, 'Louis Toffee', '0202368643', 'No.58 NSAWAM ROAD'),
	(155, 4, 'Elma Johnson', 'elma.johnson@jpcannassociates.com', '+233501637305', 'JPC1008', 'Senior Business Development Officer', '', 'Stanbic', 'Accra Main', '190101', '9040000094778', '2024-01-16 17:18:40', '2024-01-16 17:18:40', '$2y$10$Je2s24Xjbh5DRHQq.fO9Ue7PTisbA3o8lctmdqlTVl4XuR6eVygjW', 'JP100001545', 0, 'Micheal Johnson', 'Micheal Johnson', NULL),
	(156, 4, 'Prince Amazing Diamond', 'prince.diamond@jpcannassociates.com', '+233504249700', 'JPC1099', 'Senior Business Development Officer', '', 'Stanbic', 'NIA', '190105', '9040004359512', '2024-01-16 17:18:43', '2024-01-16 17:18:43', '$2y$10$7wY5iHrwxEldCBlrqG9to.W/5AmNbjhKeTZ6V1fl7Y5nOCNriU8Jy', 'JP100001546', 0, 'Bless Kofi Diamond', 'Bless Kofi Diamond', NULL),
	(157, 4, 'Gabriel Gyimah', 'gabriel.gyimah@jpcannassociates.com', '+233501335819', 'JPC1010', 'Transport Officer', '', 'UMB', 'Accra Main', '100101', '0022056217014', '2024-01-16 17:18:45', '2024-01-16 17:18:45', '$2y$10$OPPfOft9sRrbXU.QP76IPeZtOCldmY1rvOySsI9QDko2NV7Mdk9O.', 'JP100001547', 0, 'Comfort Gyimah', 'Comfort Gyimah', NULL),
	(158, 4, 'Emmanuel Brako Apau', 'emmanuel.brakoapau@jpcannassociates.com', '+233501454082', 'JPC1011', 'IT Support Officer', '', 'Stanbic', 'Accra Mall', '190104', '9040009529556', '2024-01-16 17:18:46', '2024-02-05 15:05:14', '$2y$10$3FgTmRijNBNTuaMgW9YmyeK1aHcrOgCrgGsW9QYgisLDqHsWHuEda', 'GHA712274553', 0, 'Samuel Odei Apau', 'Samuel Odei Apau', NULL),
	(159, 4, 'Dorinda Osei Baffour', 'dorinda.oseibaffour@jpcannassociates.com', '+233501622082', 'JPC1013', 'Senior Administrative Assistance', '', 'First Atlantic', 'Head Office', '170101', '0087412701010', '2024-01-16 17:18:47', '2024-01-16 17:18:47', '$2y$10$MnGSdGFUXL6yyK2CYnzksO/bGu4KD5Nab4QEdpaEYvq0W9FgNvQ0.', 'JP100001548', 0, 'Stephen Osei sarfo Ntow', 'Stephen Osei sarfo Ntow', NULL),
	(160, 4, 'Ato Amakye Sam', 'atoamakye.sam@jpcannassociates.com', '+233501569736', 'JPC1014', 'Business Advisory Officer', '', 'Stanbic', 'Tema Community 1', '190118', '9040008697471', '2024-01-16 17:18:49', '2024-02-05 14:42:44', '$2y$10$jeq6hobfaoaXN2xBUKVU3u.a43cZflldRtnqlrKpBTn9gFe20lkry', 'GHA717809634', 0, 'Esi Kumi Sam', 'Esi Kumi Sam', NULL),
	(161, 4, 'Evans Archer Fevlo', 'evansarcher.fevlo@jpcannassociates.com', '+233501622081', 'JPC1015', 'Multi Media and Web Designer', '', 'Access', 'Sefwi Wiawso', '280403', '0301628115571', '2024-01-16 17:18:50', '2024-02-08 09:08:21', '$2y$10$XUakXYnuwHpDuCUvWyNVj.HDIMYxDtoYv4fbIEoLFn2coAfaE2Fzm', 'JP100001549', 0, 'Mary Fevlo', 'Mary Fevlo', NULL),
	(162, 4, 'Mary Arum Arum', 'mary.arum@jpcannassociates.com', '+233500788300', 'JPC1016', 'Training Support Officer', '', 'GCB', 'Circle', '40127', '1391010040912', '2024-01-16 17:18:51', '2024-02-09 09:22:05', '$2y$10$60smgspeRKS2BDWA8q0UyuDQnh./XnErFITy46tgjWy87I73Aduj6', 'GHA-727404962', 0, 'Houma Ruth Charles', 'Houma Ruth Charles', NULL),
	(163, 4, 'Samuel Nanka-Bruce', 'samuel.bruce@jpcannassociates.com', '+233543965319', 'JPC1017', 'Security', '', 'Stanbic', 'Dansoman', '190116', '9040006882425', '2024-01-16 17:18:52', '2024-01-16 17:18:52', '$2y$10$Jq.Rb6T13XTB.W5bra3DG.MqvjpZE/Vy/BD9q8MUMd4MRpAtJHlL6', 'JP100001550', 0, 'Victor Nanka-Bruce', 'Victor Nanka-Bruce', NULL),
	(164, 110, 'Christine Mawutor Folikorkor', 'chriscann2023@gmail.com', '0242819122', '1733668', 'Head of administration', '1986-10-27', 'Absa Bank', 'Hohoe Branch', '040', '0401016023', '2024-01-20 12:11:49', '2024-01-20 12:11:49', '$2y$10$hSLSODTwr4ktusOw0p3LK.H0yHfW64fwQgH4vOmgJZzuuRRDWIBOS', 'D068610270046', 0, 'Joseph Folikorkor', '0257128544', 'Elephant Street, Amasaman'),
	(165, 110, 'Joseph Yao Folikorkor', 'joefoli.jf5@gmail.com', '0257128544', '4834090', 'Head of Safety', '1988-06-16', 'Stanbic Bank', 'Achimota Mall', '904', '9040011109092', '2024-01-20 13:01:23', '2024-01-20 13:01:23', '$2y$10$3PM4J6.1h6y6PgaT9OKpRuVXzIqIYB4TwDTG7DQNIUFX5uEPEAg5a', 'D068806160034', 0, 'Daniel Folikorkor', '0249718532', 'Elephant Street, Amasaman'),
	(170, 110, 'Ruth Cann', 'Ruth.cann@mofad.gov.gh', '0244632515', '5023090', 'Human Resource manager', '1980-10-22', 'Stanbic Bank', 'Achimota Mall', '904', '9040011108082', '2024-01-23 15:02:23', '2024-01-23 15:02:23', '$2y$10$v6d3pgXI84e91B97bDGCiexVcc/vLKlvYSOqAtVKrjzD3Xibc1.7y', 'D068610280045', 0, 'Emmanuel Cann', '+233 24 425 4878', 'Dansoman ssnit flats'),
	(171, 4, 'Francis Tagoe', 'francis.tagoe@jpcannassociates.com', '0265375346', 'JPC19988', 'Assistant Manager, Business Development', '1989-12-04', 'Stanbic', 'NIA', '10021', '9040001245687', '2024-01-29 11:23:42', '2024-02-12 11:19:46', '$2y$10$3AzpjfMJIXxCBQ55hefRsuJuKj5vnVUYMnKUM48oox1UrIstdwZHy', 'JP10066666', 0, 'Vida', 'Aggie', '62 Old Man Road'),
	(172, 4, 'Edmund Toffey', 'edmund.toffey@jpcannassociates.com', '0202368640', 'JPC1045', 'NSP IT', '2001-01-30', 'ADB', 'SPINTEX', '5001', '2546669988', '2024-01-29 12:16:58', '2024-02-09 09:17:25', '$2y$10$nn75ayAWdsH/TM1.aVOs7uFHZPECE6BwpFOASVSCuFHSlhx9KLyNm', 'CX125455455', 5, 'EDWIN TOFFEY', '0240128940', '75 MINISTRIES ROAD'),
	(174, 127, 'Daniel Mutuku', 'daniel.mutuku404@gmail.com', '0717576900', '5204679', 'Software Developer', '2024-02-12', 'Equity', 'Nairobi', '063', '0392439434043', '2024-02-12 06:46:39', '2024-02-12 07:04:52', '$2y$10$RGGKM8N.RThVCBi4FYMtVOpV2YzSFInpbQ3d2fq2hHLx7n8Suczuy', 'SDSK44NVKD3', 0, 'Fred', '0717576900', 'Westcom Point, Westlands'),
	(189, 172, 'Mwalyo', 'marionmbithi@gmail.com', '0795974284', '4487588', 'IT officer', '2007-06-20', 'BANK', 'Nairobi', '215', '000401223345', '2024-02-16 00:00:47', '2024-02-16 16:40:39', '$2y$10$tXexRU9csHQVaqZUn3.q/O8p/0JWjLwAAyb73UnG96faQrzDrsepa', '98766783333', 49, 'Majesty', '0747954284', 'Moi Avenue, Nairobi-Kenya.'),
	(190, 172, 'Philemon', 'phinleymark724@gmail.com', '0747954284', '1545590', 'IT officer', '2024-01-30', 'BANK', 'Nairobi', '215', '1401223345', '2024-02-16 08:08:41', '2024-02-16 16:40:54', '$2y$10$Pi3pFsOhO7pxBUpqHqNIpu5eQk87FgnUXOTVYUxAbcAY4VMj9cqRq', '45456756', 51, 'Majesty', '0729303852', 'Moi Avenue, Nairobi-Kenya.');

-- Dumping structure for table ghana_payroll.employee_assigned_permissions
CREATE TABLE IF NOT EXISTS `employee_assigned_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_assigned_permissions_employee_id_foreign` (`employee_id`),
  KEY `employee_assigned_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `employee_assigned_permissions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employee_assigned_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `employee_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.employee_assigned_permissions: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.employee_groups
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

-- Dumping data for table ghana_payroll.employee_groups: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.employee_payslips
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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.employee_payslips: ~110 rows (approximately)
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
	(75, 151, 0, 'basic_salary', 0.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 0.00),
	(76, 151, 31, 'allowance', 550.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 550.00),
	(77, 151, 32, 'allowance', 500.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 500.00),
	(78, 151, 33, 'allowance', 500.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 500.00),
	(79, 151, 34, 'allowance', 0.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 0.00),
	(80, 151, 36, 'allowance', 150.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 150.00),
	(81, 151, 7, 'benefit', 300.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 300.00),
	(82, 151, 8, 'benefit', 0.00, '2024-01-16 13:07:11', '2024-01-16 13:07:11', 0.00),
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
	(133, 189, 0, 'basic_salary', 75000.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 0.00),
	(134, 189, 38, 'allowance', 6000.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 6000.00),
	(135, 189, 39, 'allowance', 2000.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 2000.00),
	(136, 189, 10, 'benefit', 2900.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 2900.00),
	(137, 189, 17, 'statutory_ded', 2300.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 2300.00),
	(138, 189, 4, 'nonstatutory_ded', 5000.00, '2024-02-16 00:01:08', '2024-02-16 00:01:08', 5000.00),
	(139, 190, 0, 'basic_salary', 80000.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 0.00),
	(140, 190, 38, 'allowance', 6000.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 6000.00),
	(141, 190, 39, 'allowance', 2000.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 2000.00),
	(142, 190, 10, 'benefit', 2900.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 2900.00),
	(143, 190, 17, 'statutory_ded', 2300.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 2300.00),
	(144, 190, 18, 'statutory_ded', 0.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 0.00),
	(145, 190, 4, 'nonstatutory_ded', 5000.00, '2024-02-16 08:09:00', '2024-02-16 08:09:00', 5000.00);

-- Dumping structure for table ghana_payroll.employee_permissions
CREATE TABLE IF NOT EXISTS `employee_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_permissions_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `employee_permissions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.employee_permissions: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.expenses
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_tenant_id_foreign` (`tenant_id`),
  KEY `expenses_type_id_foreign` (`type_id`),
  KEY `expenses_employee_id_foreign` (`employee_id`),
  CONSTRAINT `expenses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.expenses: ~6 rows (approximately)
INSERT INTO `expenses` (`id`, `tenant_id`, `type_id`, `employee_id`, `date`, `purpose`, `amount`, `payment_status`, `approval_status`, `created_at`, `updated_at`) VALUES
	(4, 4, 4, 172, 'vist a client', 'vist a client', 150.00, 1, 1, '2024-01-29 14:02:53', '2024-01-29 14:05:53'),
	(5, 4, 3, 172, '2024-02-05', 'food to eat', 2000.00, 1, 1, '2024-02-05 15:02:01', '2024-02-06 12:28:35'),
	(6, 4, 1, 150, '2024-01-30', 'Training at Kumasi for SIC', 1500.00, 0, 1, '2024-02-06 12:29:03', '2024-02-12 11:54:40'),
	(7, 4, 6, 158, '2024-02-06', 'Fuel used in corporate errands.', 250.00, 1, 1, '2024-02-06 12:29:38', '2024-02-06 12:34:02'),
	(8, 172, 21, 190, '2024-02-16', 'ddddddddddddd', 3400.00, 0, 2, '2024-02-16 10:57:07', '2024-02-17 00:52:22'),
	(9, 172, 22, 189, '2024-02-17', 'ddddddddddd', 8000.00, 0, 1, '2024-02-16 11:08:59', '2024-02-16 11:26:18');

-- Dumping structure for table ghana_payroll.expense_types
CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `expense_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.expense_types: ~8 rows (approximately)
INSERT INTO `expense_types` (`id`, `tenant_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Hotel Accommodation', '2023-11-01 12:24:51', '2023-11-01 12:24:51'),
	(2, 4, 'Transport Allowance', '2023-11-01 12:25:05', '2023-11-01 12:25:05'),
	(3, 4, 'Meals', '2023-11-01 12:25:16', '2023-11-01 12:25:16'),
	(4, 4, 'Medical Claims', '2023-11-01 12:25:26', '2023-11-01 12:25:26'),
	(6, 4, 'Fuel Allocation', '2023-11-21 12:55:37', '2023-11-21 12:55:37'),
	(8, 4, 'Overtime', '2023-11-21 12:56:11', '2023-11-21 12:56:11'),
	(10, 4, 'Per Diem', '2023-11-21 12:56:22', '2023-11-21 12:56:22'),
	(20, 109, 'electricity', '2024-01-16 11:57:13', '2024-01-16 11:57:13'),
	(21, 172, 'Transport', '2024-02-15 23:47:25', '2024-02-15 23:47:25'),
	(22, 172, 'Labour', '2024-02-15 23:47:35', '2024-02-15 23:47:35');

-- Dumping structure for table ghana_payroll.failed_jobs
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

-- Dumping data for table ghana_payroll.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.jobs
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

-- Dumping data for table ghana_payroll.jobs: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.leaves
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
  PRIMARY KEY (`id`),
  KEY `leaves_tenant_id_foreign` (`tenant_id`),
  KEY `leaves_employee_id_foreign` (`employee_id`),
  CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `leaves_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.leaves: ~6 rows (approximately)
INSERT INTO `leaves` (`id`, `tenant_id`, `created_at`, `updated_at`, `employee_id`, `type`, `date_from`, `date_to`, `remaining_days`, `reasons`, `status`) VALUES
	(24, 127, '2024-02-13 00:48:10', '2024-02-13 01:35:06', 174, '2', '2024-02-01', '2024-02-03', '21', 'jjjj', 1),
	(25, 172, '2024-02-16 08:27:03', '2024-02-16 23:02:24', 189, '4', '2024-02-19', '2024-02-23', '90', 'Have fun', 1),
	(26, 172, '2024-02-16 08:27:06', '2024-02-16 08:27:06', 189, '4', '2024-02-19', '2024-02-23', '90', 'Have fun', 0),
	(27, 172, '2024-02-16 10:02:18', '2024-02-16 10:49:30', 190, '4', '2024-02-17', '2024-02-23', '90', 'fff', 1),
	(29, 172, '2024-02-16 10:02:58', '2024-02-17 22:22:31', 190, '5', '2024-02-17', '2024-02-29', '14', 'ffffffff', 2),
	(31, 172, '2024-02-16 23:20:42', '2024-02-16 23:20:42', 189, '5', '2024-02-26', '2024-02-27', '14', 'ddddddddd', 0);

-- Dumping structure for table ghana_payroll.leave_types
CREATE TABLE IF NOT EXISTS `leave_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `type_name` varchar(20) NOT NULL,
  `leave_days` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table ghana_payroll.leave_types: ~4 rows (approximately)
INSERT INTO `leave_types` (`id`, `tenant_id`, `type_name`, `leave_days`, `created_at`, `updated_at`) VALUES
	(1, 127, 'Maternity.', 90, '2024-02-12 23:33:35', '2024-02-12 23:33:35'),
	(2, 127, 'Annual', 21, '2024-02-12 23:30:47', '2024-02-12 23:30:47'),
	(4, 172, 'Maternity', 90, '2024-02-15 23:47:52', '2024-02-15 23:47:52'),
	(5, 172, 'Paternity', 14, '2024-02-15 23:48:09', '2024-02-15 23:48:09');

-- Dumping structure for table ghana_payroll.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.migrations: ~62 rows (approximately)
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
	(63, '2024_02_16_204133_create_employee_permissions_table', 28),
	(64, '2024_02_16_204435_create_employee_assigned_permissions_table', 28);

-- Dumping structure for table ghana_payroll.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.model_has_roles: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.non_statutory_deductions
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.non_statutory_deductions: ~3 rows (approximately)
INSERT INTO `non_statutory_deductions` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Staff Welfare', 'fixed', 50.00, '2023-11-01 12:25:54', '2023-11-01 12:25:54'),
	(2, 4, 'Staff Loan Deductions', 'fixed', 1000.00, '2024-01-29 11:32:51', '2024-01-29 11:38:22'),
	(3, 4, 'Union Dues', 'percentage', 5.00, '2024-01-29 11:35:43', '2024-01-29 11:35:43'),
	(4, 172, 'Loan', 'fixed', 5000.00, '2024-02-15 23:50:35', '2024-02-15 23:50:35');

-- Dumping structure for table ghana_payroll.packages
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

-- Dumping data for table ghana_payroll.packages: ~5 rows (approximately)
INSERT INTO `packages` (`id`, `name`, `price`, `annual_price`, `module`, `created_at`, `updated_at`, `staff_no`, `is_system`, `is_hidden`) VALUES
	(1, 'Enterprise', 1000.00, 10000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-05 20:35:41', '2024-02-13 05:58:24', 100, 0, 0),
	(2, 'Corporate', 750.00, 7500.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-05 20:36:02', '2024-02-13 05:58:47', 50, 0, 0),
	(3, 'SME+', 500.00, 5000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-07-12 17:53:55', '2024-02-13 05:58:59', 30, 1, 0),
	(12, 'SME', 300.00, 3000.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2023-08-08 22:15:31', '2024-02-13 05:59:12', 15, 0, 0),
	(13, 'Sole', 0.00, 0.00, 'hr,payroll,attendance,contracts,leaves,projects,tasks,bulky_sms,bulky_email,expenses,trainings', '2024-01-29 12:44:47', '2024-02-06 11:51:25', 2, 0, 0);

-- Dumping structure for table ghana_payroll.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.password_reset_tokens: ~2 rows (approximately)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('sandys.lartey@jpcannassociates.com', 'FhiHgpQzU6iX4iFQkHnP6nNODGswJ8497jy1SljjrL4AeQPJeOwLFF2LnOOI9uuG', '2024-02-06 12:29:08'),
	('superadmin@ghpayroll.net', 'yrZIqgDoYTvsHCZtn2es75L1XCYi1IkZJ1ChCwV9OxsG0X6nIVFOo8LHTZIyPVBq', '2024-01-15 13:55:32');

-- Dumping structure for table ghana_payroll.payment_modes
CREATE TABLE IF NOT EXISTS `payment_modes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.payment_modes: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.pay_slips
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.pay_slips: ~8 rows (approximately)
INSERT INTO `pay_slips` (`id`, `tenant_id`, `employee_id`, `basic_salary`, `paye`, `net_pay`, `pay_period`, `paid_on`, `paid_status`, `allowances`, `benefits`, `statutory_deductions`, `nonstatutory_deductions`, `created_at`, `updated_at`) VALUES
	(3, 3, 149, 1000.00, 218.53, 1566.47, '2024-01', NULL, 0, '[{"name":"Launch Subsidy","value":200,"id":26},{"name":"Clothing Allowance","value":500,"id":27},{"name":"Medical Allowance","value":150,"id":28}]', '[]', '[{"name":"SSF - Employee","value":55,"id":12},{"name":"Union Dues","value":10,"id":13}]', '[]', '2024-01-15 08:55:15', '2024-01-15 08:55:15'),
	(4, 109, 151, 0.00, 256.15, 1743.85, '2024-01', NULL, 0, '[{"name":"travel allowances","value":550,"id":31},{"name":"performance allowances","value":500,"id":32},{"name":"Fuel Allowance","value":500,"id":33},{"name":"Medical coverage","value":0,"id":34},{"name":"Clothing Allowance","value":150,"id":36}]', '[{"name":"comapany car","value":300,"id":7},{"name":"staff meals","value":0,"id":8}]', '[]', '[]', '2024-01-16 13:07:30', '2024-01-16 13:07:30'),
	(5, 110, 164, 1000.00, 176.30, 823.70, '2024-01', NULL, 0, '[]', '[]', '[]', '[]', '2024-01-20 12:21:16', '2024-01-20 12:21:16'),
	(6, 110, 165, 1300.00, 133.65, 1166.35, '2024-01', NULL, 0, '[]', '[]', '[]', '[]', '2024-01-20 13:05:03', '2024-01-20 13:05:03'),
	(7, 110, 170, 3000.00, 431.15, 2568.85, '2024-01', NULL, 0, '[]', '[]', '[{"name":"SSNIT","value":0,"id":14}]', '[]', '2024-01-23 15:07:35', '2024-01-23 15:07:35'),
	(8, 4, 13, 1000.00, 504.65, 2315.35, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":150,"id":1},{"name":"Transport Subsidies","value":100,"id":2},{"name":"Lunch Subsidy","value":125,"id":3},{"name":"Clothing Allowance","value":500,"id":4},{"name":"Risk Allowance","value":100,"id":37}]', '[{"name":"Company Vehicle Only","value":500,"id":1},{"name":"Fuel","value":250,"id":2},{"name":"Accommodation","value":750,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":50,"id":1},{"name":"Staff Loan Deductions","value":500,"id":2},{"name":"Union Dues","value":50,"id":3}]', '2024-01-29 13:06:10', '2024-02-06 08:34:17'),
	(9, 4, 172, 1000.00, 229.55, 1015.45, '2024-01', NULL, 0, '[{"name":"Responsibility Allowance","value":50,"id":1},{"name":"Transport Subsidies","value":50,"id":2},{"name":"Lunch Subsidy","value":50,"id":3},{"name":"Clothing Allowance","value":100,"id":4},{"name":"Risk Allowance","value":50,"id":37}]', '[{"name":"Company Vehicle Only","value":0,"id":1},{"name":"Fuel","value":0,"id":2},{"name":"Accommodation","value":0,"id":9}]', '[{"name":"Social Security - Employee","value":55,"id":1}]', '[{"name":"Staff Welfare","value":0,"id":1},{"name":"Staff Loan Deductions","value":0,"id":2},{"name":"Union Dues","value":0,"id":3}]', '2024-01-29 14:13:38', '2024-01-29 14:13:38'),
	(10, 127, 174, 49999.99, 12806.15, 34443.84, '2024-01', NULL, 0, '[]', '[]', '[{"name":"SSF - Employee","value":2750,"id":15}]', '[]', '2024-02-13 06:51:19', '2024-02-13 06:51:19'),
	(13, 172, 189, 75000.00, 25391.15, 53208.85, '2024-07', NULL, 0, '[{"name":"House","value":6000,"id":38},{"name":"Medical","value":2000,"id":39}]', '[{"name":"Data","value":2900,"id":10}]', '[{"name":"NSSF","value":2300,"id":17}]', '[{"name":"Loan","value":5000,"id":4}]', '2024-02-16 16:39:55', '2024-02-16 16:39:55'),
	(14, 172, 189, 75000.00, 25391.15, 53208.85, '2024-02', NULL, 0, '[{"name":"House","value":6000,"id":38},{"name":"Medical","value":2000,"id":39}]', '[{"name":"Data","value":2900,"id":10}]', '[{"name":"NSSF","value":2300,"id":17}]', '[{"name":"Loan","value":5000,"id":4}]', '2024-02-16 16:40:12', '2024-02-16 16:40:12'),
	(17, 172, 190, 80000.00, 27141.15, 56458.85, '2024-02', NULL, 0, '[{"name":"House","value":6000,"id":38},{"name":"Medical","value":2000,"id":39}]', '[{"name":"Data","value":2900,"id":10}]', '[{"name":"NSSF","value":2300,"id":17},{"name":"SSF - Employee","value":0,"id":18}]', '[{"name":"Loan","value":5000,"id":4}]', '2024-02-17 22:42:02', '2024-02-17 22:42:02');

-- Dumping structure for table ghana_payroll.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.permissions: ~14 rows (approximately)
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

-- Dumping structure for table ghana_payroll.personal_access_tokens
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

-- Dumping data for table ghana_payroll.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.projects
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.projects: ~6 rows (approximately)
INSERT INTO `projects` (`id`, `created_at`, `updated_at`, `tenant_id`, `title`, `start_date`, `due_date`, `priority`, `team_leader`, `project_team`, `progress`, `notes`) VALUES
	(1, '2023-11-03 11:08:45', '2023-11-03 11:08:45', 4, 'Payroll Ghana Customisation', '2023-11-03', '2023-11-06', 'high', 13, '["13"]', 50.00, 'Contact Daniel to make the few changes suggested'),
	(3, '2024-01-16 12:51:33', '2024-01-16 12:51:33', 109, 'it department work on the website', '2024-01-17', '2024-01-23', 'medium', 151, '["151"]', 50.00, NULL),
	(4, '2024-01-29 11:59:15', '2024-01-29 11:59:29', 4, 'Performance Management & Appraisal', '2024-01-29', '2024-01-29', 'high', 150, '["14","15","171"]', 43.00, 'Testing our Project and Task functionalities on PayrollGhana'),
	(10, '2024-02-16 15:11:36', '2024-02-17 00:39:21', 172, 'MArio', '2024-02-17', '2024-02-20', 'high', 189, '["189","190"]', 13.00, 'eeeeeeeeeeffffffffff'),
	(11, '2024-02-16 15:12:38', '2024-02-17 00:39:31', 172, '555555', '2024-02-22', '2024-02-22', '--Choose Here--', 189, '["189","190"]', 50.00, 'dddddddddd');

-- Dumping structure for table ghana_payroll.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.roles: ~6 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(3, 'Superadmin', 'web', '2023-07-12 21:08:35', '2023-07-12 21:08:35'),
	(4, 'Finance Manager', 'web', '2023-07-18 10:46:48', '2023-07-18 10:46:48'),
	(5, 'Admin', 'web', '2023-08-05 14:23:27', '2023-08-05 14:23:27'),
	(6, 'IT Support', 'web', '2023-10-11 12:01:07', '2023-10-11 12:01:07'),
	(7, 'HR', 'web', '2023-11-03 10:40:50', '2023-11-03 10:40:50'),
	(8, 'Agents', 'web', '2024-01-16 16:44:44', '2024-01-16 16:44:44');

-- Dumping structure for table ghana_payroll.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.role_has_permissions: ~41 rows (approximately)
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
	(8, 8);

-- Dumping structure for table ghana_payroll.salary_types
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

-- Dumping data for table ghana_payroll.salary_types: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.statutory_deductions
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.statutory_deductions: ~8 rows (approximately)
INSERT INTO `statutory_deductions` (`id`, `tenant_id`, `name`, `type`, `value`, `created_at`, `updated_at`) VALUES
	(1, 4, 'SSF - Employee', 'percentage', 5.50, '2023-11-01 12:26:30', '2023-11-01 12:26:30'),
	(12, 3, 'SSF - Employee', 'percentage', 5.50, '2024-01-15 08:52:28', '2024-01-15 08:52:28'),
	(13, 3, 'Union Dues', 'fixed', 10.00, '2024-01-15 08:52:49', '2024-01-15 08:52:49'),
	(14, 110, 'SSNIT', 'percentage', 13.50, '2024-01-20 14:05:23', '2024-01-20 14:05:23'),
	(15, 127, 'SSF - Employee', 'percentage', 5.50, '2024-02-13 06:50:26', '2024-02-13 06:50:26'),
	(16, 110, 'SSF - Employee', 'percentage', 5.50, '2024-02-15 16:06:42', '2024-02-15 16:06:42'),
	(17, 172, 'NSSF', 'fixed', 2300.00, '2024-02-15 23:50:12', '2024-02-15 23:50:12'),
	(18, 172, 'SSF - Employee', 'percentage', 5.50, '2024-02-16 06:23:32', '2024-02-16 06:23:32');

-- Dumping structure for table ghana_payroll.subscriptions
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

-- Dumping data for table ghana_payroll.subscriptions: ~3 rows (approximately)
INSERT INTO `subscriptions` (`id`, `tenant_id`, `package_id`, `type`, `amount_paid`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
	(1, 4, 2, 'monthly', 20.00, '2023-12-01 00:00', '2023-12-31', '2023-11-03 11:20:09', '2023-11-03 11:20:09'),
	(2, 4, 2, 'monthly', 20.00, '2023-12-31 00:00', '2024-01-30', '2023-11-21 11:33:09', '2023-11-21 11:33:09'),
	(4, 127, 1, 'annual', 10000.00, '2024-03-13 00:00', '2025-03-13', '2024-02-13 06:36:00', '2024-02-13 06:36:00');

-- Dumping structure for table ghana_payroll.subscription_plans
CREATE TABLE IF NOT EXISTS `subscription_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_days` int NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.subscription_plans: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.tasks
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.tasks: ~2 rows (approximately)
INSERT INTO `tasks` (`id`, `created_at`, `updated_at`, `tenant_id`, `project_id`, `title`, `assigned_to`, `priority`, `status`, `notes`) VALUES
	(1, '2023-11-03 11:09:54', '2024-02-17 00:51:44', 4, 10, 'Make changes', 189, 'low', 'inprogress', 'Make changes as suggested'),
	(3, '2024-01-29 12:01:04', '2024-02-17 00:50:44', 4, 10, 'Distribute 360 Appraisal', 189, 'high', 'complete', 'Kindly send the link for Staff 360 Appraisal on Teams so staff can complete the forms and submit by close of day today.');

-- Dumping structure for table ghana_payroll.tax_bands
CREATE TABLE IF NOT EXISTS `tax_bands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `min` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_bands_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `tax_bands_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.tax_bands: ~0 rows (approximately)

-- Dumping structure for table ghana_payroll.trainings
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.trainings: ~9 rows (approximately)
INSERT INTO `trainings` (`id`, `tenant_id`, `name`, `type`, `start_date`, `end_date`, `description`, `status`, `created_at`, `updated_at`, `vendor`, `time`, `location`) VALUES
	(1, 4, 'Cybersecurity Awareness', 'compulsory', '2023-11-06', '2023-11-07', 'Please check your mail for details', 0, '2023-11-03 11:14:11', '2024-01-29 12:04:11', 'JPCann', '08:00', 'Accra'),
	(2, 4, 'Code of Conduct & Ethics', 'compulsory', '2023-11-22', '2023-11-23', 'Please be on time', 0, '2023-11-21 12:14:23', '2023-11-21 12:14:23', 'OGSL', '09:30', 'Accra'),
	(3, 109, 'ADVANCED PROJECT MANAGEMENT SKILLS', 'compulsory', '2024-01-16', '2024-01-23', 'ADVANCED PROJECT MANAGEMENT SKILLS', 0, '2024-01-16 12:41:15', '2024-01-16 12:41:15', 'tbs', '21:00', 'jpcann associates'),
	(4, 110, 'Health and safety Training Sessions', 'compulsory', '2024-02-01', '2024-02-05', 'To educate workers on the importance of health and safety at work with its regulations and compliance. This sessions involves with taken each participants through a physical hands-on demonstrations.', 0, '2024-01-20 13:33:38', '2024-01-20 13:33:38', 'Cannyzer Global Enterprise', '09:00', 'Around Office Premises'),
	(5, 4, 'Performance  Appraisal Training', 'compulsory', '2024-01-28', '2024-01-29', 'Compulsory for all supervisors and managers', 0, '2024-01-29 12:05:11', '2024-01-29 12:05:11', 'JPCann', '08:00', 'Accra'),
	(6, 4, 'Growth Mindset', 'compulsory', '2024-02-05', '2024-02-05', 'Attend training', 0, '2024-02-06 12:06:21', '2024-02-06 12:19:47', 'JPCann', '08:00', 'JPCann Premises'),
	(7, 127, 'Demo', 'compulsory', '2024-02-12', '2024-02-14', 'kskewe', 0, '2024-02-12 10:59:58', '2024-02-12 10:59:58', 'Demo', '13:59', 'Virtual'),
	(8, 127, 'Demo', 'compulsory', '2024-02-12', '2024-02-12', 'DSKDKk', 0, '2024-02-12 12:01:25', '2024-02-12 12:01:25', 'Demo', '15:06', 'Virtual'),
	(9, 110, 'Health and safety Training', 'compulsory', '2024-02-14', '2024-02-16', 'Employees will be taken through a physical demonstration on accident related cases at work and how to handle reporting and action of cases.', 0, '2024-02-12 13:01:37', '2024-02-12 13:01:37', 'Cannyzer Global Enterprise', '09:00', 'At the Office Premises'),
	(11, 172, 'Credit Card', 'optional', '2024-02-17', '2024-02-19', 'fffffffffffffffffffffgg', 0, '2024-02-16 13:34:28', '2024-02-17 00:57:22', 'Ancent Events', '19:34', 'Kitundut');

-- Dumping structure for table ghana_payroll.training_requests
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
  PRIMARY KEY (`id`),
  KEY `training_requests_training_id_foreign` (`training_id`),
  KEY `training_requests_employee_id_foreign` (`employee_id`),
  CONSTRAINT `training_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `training_requests_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.training_requests: ~30 rows (approximately)
INSERT INTO `training_requests` (`id`, `created_at`, `updated_at`, `employee_id`, `training_id`, `approval_status`, `completion_status`, `certificate`, `is_invited`) VALUES
	(1, '2023-11-21 12:15:00', '2024-01-16 12:36:24', 14, 2, 1, 1, '#14-sandys-lartey_code-of-conduct-&-ethics.pdf', 1),
	(2, '2023-11-21 12:15:00', '2023-11-21 12:17:06', 22, 2, 1, 1, '#22-benjamin-laryea_code-of-conduct-&-ethics.pdf', 1),
	(3, '2024-01-16 17:24:38', '2024-01-16 17:27:12', 150, 1, 1, 1, NULL, 1),
	(4, '2024-01-16 17:24:56', '2024-02-06 12:21:23', 15, 1, 1, 1, '#15-tracey-cann_cybersecurity-awareness.pdf', 1),
	(5, '2024-01-16 17:25:19', '2024-01-29 14:07:18', 22, 1, 1, 1, NULL, 1),
	(6, '2024-01-20 13:34:17', '2024-01-20 13:34:17', 164, 4, 1, 0, NULL, 1),
	(7, '2024-01-20 13:34:18', '2024-01-20 13:34:18', 165, 4, 1, 0, NULL, 1),
	(8, '2024-01-23 15:16:49', '2024-01-23 15:16:49', 170, 4, 1, 0, NULL, 1),
	(9, '2024-01-29 12:05:55', '2024-02-06 12:21:31', 14, 5, 1, 1, NULL, 1),
	(10, '2024-01-29 12:05:56', '2024-01-29 12:05:56', 22, 5, 1, 0, NULL, 1),
	(11, '2024-01-29 12:05:58', '2024-02-06 12:21:41', 150, 5, 1, 1, NULL, 1),
	(12, '2024-01-29 12:05:58', '2024-01-29 12:05:58', 14, 5, 1, 0, NULL, 1),
	(13, '2024-01-29 12:05:59', '2024-01-29 12:05:59', 155, 5, 1, 0, NULL, 1),
	(14, '2024-01-29 12:05:59', '2024-01-29 12:05:59', 22, 5, 1, 0, NULL, 1),
	(15, '2024-01-29 12:06:01', '2024-01-29 12:06:01', 150, 5, 1, 0, NULL, 1),
	(16, '2024-01-29 12:06:02', '2024-01-29 12:06:02', 155, 5, 1, 0, NULL, 1),
	(17, '2024-01-29 14:03:46', '2024-01-29 14:09:36', 172, 1, 1, 1, '#172-edmund-toffey_cybersecurity-awareness.pdf', 0),
	(18, '2024-01-29 14:03:58', '2024-01-29 14:05:17', 172, 2, 2, 0, NULL, 0),
	(19, '2024-01-29 14:04:07', '2024-02-06 12:22:41', 172, 5, 1, 1, NULL, 0),
	(20, '2024-02-06 12:07:36', '2024-02-06 12:07:36', 14, 6, 0, 0, NULL, 1),
	(21, '2024-02-06 12:07:38', '2024-02-06 12:07:38', 150, 6, 0, 0, NULL, 1),
	(22, '2024-02-06 12:07:39', '2024-02-06 12:07:39', 158, 6, 0, 0, NULL, 1),
	(23, '2024-02-06 12:07:41', '2024-02-06 12:07:41', 172, 6, 0, 0, NULL, 1),
	(24, '2024-02-06 12:10:56', '2024-02-06 12:22:04', 158, 5, 1, 1, NULL, 0),
	(25, '2024-02-06 12:11:03', '2024-02-06 12:11:35', 158, 2, 2, 0, NULL, 0),
	(26, '2024-02-06 12:11:10', '2024-02-06 12:24:14', 158, 1, 1, 1, '#158-emmanuel-brako-apau_cybersecurity-awareness.pdf', 0),
	(27, '2024-02-12 11:03:12', '2024-02-12 12:09:03', 174, 7, 1, 0, NULL, 1),
	(28, '2024-02-12 12:02:05', '2024-02-12 12:15:54', 174, 8, 1, 0, NULL, 0),
	(29, '2024-02-12 13:02:24', '2024-02-12 13:02:24', 164, 9, 1, 0, NULL, 1),
	(30, '2024-02-12 13:02:28', '2024-02-12 13:02:28', 164, 9, 1, 0, NULL, 1);

-- Dumping structure for table ghana_payroll.users
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
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ghana_payroll.users: ~125 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone_number`, `type`, `package_id`, `expiry_date`, `role_id`, `is_system`, `agent_id`) VALUES
	(1, 'Superadmin', 'superadmin@ghpayroll.net', NULL, '$2y$10$6P8zt4fkmdg4cwNzWHs3au82GQMThLG1nFN12TROZklWZVFtB.3nS', NULL, '2023-10-31 01:47:26', '2023-10-31 01:47:26', '0717576900', 'superadmin', 3, '2023-11-30', 0, 1, '0'),
	(2, 'Jonathan Can', 'advisor3ghana@gmail.com', NULL, '$2y$10$nvYJ/jjCMnIL.GjhXoSL3OjVX1N.Nfa6VKD/4KJim0O62pWGV4I1m', NULL, '2023-11-01 10:18:00', '2023-11-01 10:18:00', '0501335817', 'superadmin', NULL, NULL, 3, 0, '0'),
	(3, 'Kobina Akyea', 'KAKYEA@YAHOO.COM', NULL, '$2y$10$3zza6Awez.LiE997zIWG..9TdwZOOFfpULCizxOcNQI53rlEO7fou', NULL, '2023-11-01 10:44:40', '2024-01-15 08:33:44', '0501335817', 'client', 2, '2024-12-31', 0, 0, '1'),
	(4, 'Tracey Cann', 'tracey.cann@jpcannassociates.com', NULL, '$2y$10$RgLlwpfGwzFUtdt6qxkPSeXZgj6amUGx/LwIVacwLB1aDObZax6CK', NULL, '2023-11-01 10:51:40', '2024-01-29 12:39:11', '0501335818', 'client', 2, '2024-12-31', 0, 0, '1'),
	(25, 'Benjamin laryea', 'ben.laryea1992@gmail.com', NULL, '$2y$10$jppJMUqDm4C2plnbrHwanuUtAJC409eECfivubqmiMH1HdoI.AjlW', NULL, '2023-11-21 11:29:59', '2023-11-21 11:29:59', '0501457253', 'client', 3, '2023-12-21', 0, 0, '0'),
	(41, 'Winston', 'michelle@hultine.com', NULL, '$2y$10$sZRmMRQ28UrXxY5mrt4NJO5WC2nk7VOzRpVyvOHYChq47iIiyNInG', NULL, '2023-12-01 15:04:36', '2024-01-16 16:56:09', '1', 'client', 3, '2023-12-31', 0, 0, '2'),
	(47, 'Aviana', 'esopro32@gmail.com', NULL, '$2y$10$TP.UwPuuu2wSq0OM8VOJdeJs.cAnLREIAu7NHfczp.1OlgObCa1Ra', NULL, '2023-12-02 19:07:45', '2023-12-02 19:07:45', '1', 'client', 3, '2024-01-01', 0, 0, '0'),
	(53, 'wydFEpKVWnKk', 'info@diamondfactoryofannarbor.com', NULL, '$2y$10$ItGQ2GASKJcVrWf9ka/M6.xelIGAmOCtuIdzodRNaVC3BguHskg5m', NULL, '2023-12-07 23:38:06', '2023-12-07 23:38:06', '1', 'client', 3, '2024-01-06', 0, 0, '0'),
	(54, 'mJBrQJIvEDfE', 'be_nelson@live.com', NULL, '$2y$10$2GmvuIqBg1io9FmlinwHcOcBIu7DtqcVHtFEQPDOla7EB3kws.ST6', NULL, '2023-12-08 23:36:10', '2023-12-08 23:36:10', '1', 'client', 3, '2024-01-07', 0, 0, '0'),
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
	(109, 'Edmund Toffey', 'currytoffey30@gmail.com', NULL, '$2y$10$Qe7B.7z5.MRiaKIzz1xh0uBrXYisuoFxtPhsmZkdxjGtx/QtRZtX.', NULL, '2024-01-16 10:29:34', '2024-02-06 11:38:03', '0558313156', 'client', 2, '2024-02-15', 0, 0, '3'),
	(110, 'Ebenezer Cann', 'cannyzer1@gmail.com', NULL, '$2y$10$o8EglIjGPvwrcTNWNG3wb.8OLQHLjFmDqyn3r3waR/edJeuk337X2', NULL, '2024-01-18 11:51:42', '2024-01-18 11:51:42', '0545950291', 'client', 3, '2024-02-17', 0, 0, '0'),
	(111, 'John Kofi Nketia', 'johnnananketia@gmail.com', NULL, '$2y$10$5yMMkA7zdsrgY5ZOZaoffO7jE/eDnECXiv.2kAI1M7YTigcs9Kyjy', NULL, '2024-01-18 12:43:35', '2024-01-18 12:43:35', '0557089074', 'client', 3, '2024-02-17', 0, 0, '0'),
	(112, 'Kyle', 'RwjiUA.mqbwhjw@sandcress.xyz', NULL, '$2y$10$CKWgaUGxoEv8Z3aK61A4Xes7fINCN.qubqNyWX5oGMifkpK04nzLq', NULL, '2024-01-25 00:07:24', '2024-01-25 00:07:24', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(113, 'Zara', 'jfrousso@globetrotter.qc.ca', NULL, '$2y$10$5Lrvfps1lUzf5J2OEl7Mkehy8S.DNuLeWpYJikNMStpULz2xksug.', NULL, '2024-01-25 18:13:20', '2024-01-25 18:13:20', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(114, 'Angie', 'mikem@landstarcak.com', NULL, '$2y$10$Al/F0KQPeIJs7pue4JKj4uyexerN9zfiX7j4jwJefMDCh315kDJbm', NULL, '2024-01-25 23:12:07', '2024-01-25 23:12:07', '1', 'client', 3, '2024-02-24', 0, 0, '0'),
	(115, 'Brooks', 'toniandamandacleaning@gmail.com', NULL, '$2y$10$dg3l...7vt4vRfIXQ7ABNe5tsKSH9kkpB/.fafvCxo/bCmB2/E1Ky', NULL, '2024-01-26 01:37:34', '2024-01-26 01:37:34', '1', 'client', 3, '2024-02-25', 0, 0, '0'),
	(116, 'EBTndNhXUSZtq', 'vladimirbp5@outlook.com', NULL, '$2y$10$NTMwQ.XGIEnLc1DXR8tvg.sHNCe30oipHmeoXOGYq8Yp1xkqUFPfG', NULL, '2024-01-26 19:13:36', '2024-01-26 19:13:36', '2651012405', 'client', 3, '2024-02-25', 0, 0, '0'),
	(117, 'Joel Toffey', 'edtoffey@proton.me', NULL, '$2y$10$VyMrP4jI3IvDtr3pHVIzruuMbrIfrMAUdXcpEgdkvE.ugRjS.KoDW', NULL, '2024-01-29 13:56:11', '2024-01-29 13:56:11', '0202368640', 'client', 3, '2024-02-28', 0, 0, '0'),
	(118, 'vJlGwqTfsDX', 'kgoodman9438@gmail.com', NULL, '$2y$10$bBPDU6XofiRsbWxYbOq0IOKlccaS.wlhpmc4aEedMZX851p7ucuiu', NULL, '2024-02-05 13:18:49', '2024-02-05 13:18:49', '6343768111', 'client', 3, '2024-03-06', 0, 0, '0'),
	(119, 'Chelsea Tiban-Ye', 'chelsea.tibanye@jpcannassociates.com', NULL, '$2y$10$XYeyM3NNOs2SbZs/N5JZHOKjAjiGMDWGRB0kenJYunCJg.kh7dssC', NULL, '2024-02-06 08:56:13', '2024-02-06 08:56:13', '0501890182', 'superadmin', NULL, NULL, 4, 0, '0'),
	(120, 'Edmund Toffey', 'edmund.toffey@jpcannassociates.com', NULL, '$2y$10$je2jY5vgUVBG9V.jcuPOo.4kKAL3ZTrwssQF4OUHr9mQSr5EHEDSK', NULL, '2024-02-06 08:59:54', '2024-02-07 09:58:12', '0558313156', 'superadmin', NULL, NULL, 5, 0, '0'),
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
	(172, 'Ancent Mbithi', 'ancentmbithi8@gmail.com', NULL, '$2y$10$piUURi.sHiwVvIObsuc6IeymGCYbrmEPR2VUZNypFs24blUaawTjO', NULL, '2024-02-15 23:34:57', '2024-02-15 23:34:57', '0795974284', 'client', 3, '2024-03-17', 0, 0, '0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
