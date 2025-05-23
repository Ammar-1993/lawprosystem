-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 11:08 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lawpro_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `advocate_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_no` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `associated_name` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city_id` int(11) DEFAULT NULL,
  `zipcode` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `profile_img` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `is_account_setup` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_user_type` enum('SUPERADMIN','ADVOCATE','STAFF') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ADVOCATE',
  `invitation_status` enum('accepted','sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `accepted_at` datetime DEFAULT NULL,
  `current_package` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` int(11) DEFAULT '0',
  `started_at` date DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `is_expired` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_date` timestamp NULL DEFAULT NULL,
  `is_otp_verify` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `plateform` enum('App','Web') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Web',
  `user_type` enum('Admin','User') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `advocate_id`, `name`, `email`, `password`, `first_name`, `last_name`, `mobile`, `registration_no`, `associated_name`, `address`, `city_id`, `zipcode`, `state_id`, `country_id`, `profile_img`, `is_activated`, `is_account_setup`, `remember_token`, `is_user_type`, `invitation_status`, `accepted_at`, `current_package`, `payment_id`, `started_at`, `expires_at`, `last_login_at`, `last_login_ip`, `is_active`, `is_expired`, `otp`, `otp_date`, `is_otp_verify`, `plateform`, `user_type`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'superadmin@gmail.com', '$2y$10$t4epis8q7jS4WHuZj3N3QeXzZYbnV.T28LqcjFdBQKFnqmXxRuIBe', 'Rinas', 'Al-Ameri', '0505777660', '1234', 'LAW PRO', 'Al Nakhil neighborhood, Bisha', 37410, '876643', 3147, 191, '1746238846.png', 0, 0, '7hUpyDiS4DFwICTFd1lIFG3S8We4dyAd7OMK5l0EHkwj4gzUFf95TpG7mytX', 'ADVOCATE', 'sent', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'Yes', 'No', NULL, NULL, '0', 'Web', 'Admin', '2025-02-16 02:09:55', '2025-05-05 04:00:02'),
(2, NULL, NULL, 'lawyer@gmail.com', '$2y$10$NUXagRwfd8WOnBAMCDV.NOmrba/RFMVsIbKPgd9rrNSaFAKoNBPoW', 'Ahmed', 'Ali', '0777654332', NULL, NULL, '30 Street, markazi, Qaidah', 37410, '876643', 3147, 191, '1746239221.png', 1, 0, 'yxepVZ4gmGwMXsfIlC7ZjSKQDWgstQbNzY3EJ1XgtyGHssNJl8wvJooLrxvF', 'STAFF', 'sent', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'Yes', 'No', NULL, NULL, '0', 'Web', 'User', '2025-02-16 02:17:16', '2025-05-05 01:22:25'),
(3, NULL, NULL, 'employee@gmail.com', '$2y$10$Dzml0ZUFux/DqSl3lvhqfOCRVZjimsZENfT7jyH6h7agikcu/3dUm', 'Sultan', 'Al-Zahrani', '0565666777', NULL, NULL, 'Bisha', 37416, '776544', 3153, 191, '1746239339.png', 1, 0, 'VM9mhB9n9HT6ndxl7wvFs3Hk6JPCJnLbwGAVHQhCYt4mRqyyLe4GDpjW2x5r', 'STAFF', 'sent', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'Yes', 'No', NULL, NULL, '0', 'Web', 'User', '2025-02-17 00:09:36', '2025-05-03 02:28:59'),
(4, NULL, NULL, 'admin@gmail.com', '$2y$10$wwFi67gSsEyiDAT6X./QjuuqJpjtzF7HgHnm9elhhon/ZOBtAW0Pa', 'Faisal', 'Al-Zahrani', '0505777666', NULL, NULL, 'King Abdullah Hospital, Bisha Governorate.', 37410, '610008', 3147, 191, '1746229547.png', 1, 0, 'J2HPyAFBsrNfPDWg1hr93mGelvkG7R8cS1LIg90eWgryziUwI2BY3M2fOkyq', 'STAFF', 'sent', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'Yes', 'No', NULL, NULL, '0', 'Web', 'User', '2025-02-23 22:28:26', '2025-05-05 01:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`email`, `token`, `created_at`) VALUES
('sultan@gmail.com', '$2y$10$.qUwc/FxlY3wb1/QlLvNqu9kwkWelnKdSLozYfXOFG.WXSUehYXtK', '2025-02-26 01:32:06'),
('fia@gmail.com', '$2y$10$SXQiaof3RrH9kTTMnyqHXOgNFkwvL3LKFgUTMwwddmhF8icmRKi4S', '2025-03-25 22:48:07'),
('lawyer@gmail.com', '$2y$10$jl1LSnUqzoAO2kfltppAtOzq1Hi8KP7AVN2Jw1BS.uhJSSW8WdZNC', '2025-03-27 20:38:13'),
('ammar@gmail.com', '$2y$10$Pq0F/q08d8uyb8bAmOWaqOJa52QwoFwFnfVRgK28hhJwOD84SO78S', '2025-03-31 22:16:08'),
('admin@gmail.com', '$2y$10$hzJAgay06cfJn/v4jMps3.PDZXmUTux6ELP4GXYgA/D8N/xvn1sM2', '2025-04-30 17:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`id`, `admin_id`, `role_id`) VALUES
(1, 1, 1),
(17, 3, 4),
(27, 10, 7),
(28, 11, 7),
(29, 12, 7),
(30, 13, 7),
(33, 14, 8),
(34, 15, 8),
(37, 16, 8),
(40, 7, 4),
(42, 8, 8),
(44, 9, 8),
(46, 2, 2),
(47, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `advocate_clients`
--

CREATE TABLE `advocate_clients` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternate_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `reference_name` text COLLATE utf8mb4_unicode_ci,
  `reference_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `client_type` enum('single','multiple') COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advocate_clients`
--

INSERT INTO `advocate_clients` (`id`, `advocate_id`, `first_name`, `middle_name`, `last_name`, `gender`, `email`, `mobile`, `alternate_no`, `address`, `country_id`, `state_id`, `city_id`, `reference_name`, `reference_mobile`, `is_active`, `created_at`, `client_type`, `updated_at`) VALUES
(1, 0, 'Sam', 'Ali', 'Saleh', 'Male', 'client@gmail.com', '0555788444', NULL, 'Al Nakhil neighborhood, Bisha', 191, 3147, 37410, NULL, NULL, 'Yes', '2025-02-15 21:22:40', 'single', '2025-02-24 20:30:53'),
(2, 0, 'Haron', 'A', 'Salem', 'Male', 'haron@gmail.com', '0555444111', NULL, 'Bisha', 191, 3147, 37410, NULL, NULL, 'Yes', '2025-02-16 21:12:00', 'single', '2025-05-04 04:05:41'),
(3, 0, 'Mona', 'A', 'Mohmmed', 'Female', 'mona@gmail.com', '0544333999', '0599000433', 'King Abdullah Hospital, Bisha Governorate.', 191, 3156, 37425, NULL, NULL, 'Yes', '2025-02-22 15:44:56', 'single', '2025-04-13 00:50:24'),
(4, 0, 'Shifa', 'A', 'Saad', 'Female', 'shifa@gmail.com', '0504333277', NULL, 'Al Nakhil neighborhood, Bisha Governorate.', 191, 3155, 37421, NULL, NULL, 'Yes', '2025-02-22 19:30:43', 'single', '2025-05-05 01:17:50'),
(5, 0, 'sabeer', 'A', 'Ahmed', 'Male', 'sabeer@gmail.com', '0555777666', NULL, 'university street', 191, 3163, 37441, NULL, NULL, 'Yes', '2025-03-26 21:23:56', 'single', '2025-05-04 01:40:16'),
(6, 0, 'Fawaz Ali', 'Ali', 'Morshed', 'Male', 'fawaz@gmail.com', '0555777000', NULL, 'Central Market', 191, 3156, 37425, NULL, NULL, 'Yes', '2025-04-27 20:52:46', 'single', '2025-05-05 23:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `all_taxes`
--

CREATE TABLE `all_taxes` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `per` varchar(255) NOT NULL,
  `note` text,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_taxes`
--

INSERT INTO `all_taxes` (`id`, `advocate_id`, `name`, `per`, `note`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Land Tax', '8', 'Land Reform Tax', 'Yes', '2025-05-04 01:47:22', '2025-05-04 01:47:22'),
(2, 1, 'Land', '20', NULL, 'No', '2025-05-04 01:47:14', '2025-05-04 01:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `advocate_id` int(11) NOT NULL,
  `type` enum('new','exists') NOT NULL DEFAULT 'new',
  `date` datetime NOT NULL,
  `time` time NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` text,
  `is_active` enum('OPEN','CANCEL BY CLIENT','CANCEL BY ADVOCATE') NOT NULL DEFAULT 'OPEN',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `advocate_id`, `type`, `date`, `time`, `mobile`, `name`, `note`, `is_active`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 'exists', '2025-02-17 00:00:00', '09:30:00', '0555788444', NULL, 'Discussion with Sam', 'OPEN', '2025-02-16 01:34:48', '2025-02-16 01:34:48'),
(2, 2, 1, 'exists', '2025-02-17 00:00:00', '15:22:00', '0555444111', NULL, 'I will discuss the issue with you.', '', '2025-02-21 00:30:18', '2025-02-17 00:23:28'),
(3, 1, 1, 'exists', '2025-02-21 00:00:00', '10:30:00', '0555788444', NULL, 'Meet for you', 'OPEN', '2025-05-01 20:49:56', '2025-02-21 03:24:36'),
(4, 2, 1, 'exists', '2025-02-21 00:00:00', '19:13:00', '0555444111', NULL, NULL, 'OPEN', '2025-04-08 21:45:19', '2025-02-21 04:13:32'),
(5, NULL, 1, 'new', '2025-02-22 00:00:00', '23:40:00', '0555878111', 'Hamza Mohsen', NULL, 'OPEN', '2025-02-22 18:08:40', '2025-02-22 18:08:40'),
(6, 3, 1, 'exists', '2025-02-24 00:00:00', '08:30:00', '0544333999', NULL, NULL, 'OPEN', '2025-02-23 22:39:57', '2025-02-23 22:39:57'),
(7, 2, 1, 'exists', '2025-04-01 00:00:00', '15:10:00', '0555444111', NULL, 'Done', 'OPEN', '2025-04-11 19:15:30', '2025-02-25 00:10:26'),
(8, 5, 1, 'exists', '2025-04-11 00:00:00', '22:19:00', '0555777666', NULL, NULL, 'OPEN', '2025-04-11 19:23:47', '2025-04-11 19:19:54'),
(9, 4, 1, 'exists', '2025-04-12 00:00:00', '10:25:00', '0504333277', NULL, NULL, 'OPEN', '2025-04-11 19:25:13', '2025-04-11 19:25:13'),
(10, 2, 1, 'exists', '2025-04-15 00:00:00', '10:29:00', '0555444111', NULL, NULL, 'OPEN', '2025-04-15 20:26:44', '2025-04-11 19:29:27'),
(11, 1, 1, 'exists', '2025-04-21 00:00:00', '02:18:00', '0555788444', NULL, NULL, 'OPEN', '2025-05-05 00:11:23', '2025-04-20 21:18:39'),
(12, 3, 1, 'exists', '2025-05-05 00:00:00', '09:15:00', '0544333999', NULL, NULL, 'OPEN', '2025-05-05 17:06:30', '2025-04-20 21:19:33'),
(13, 2, 1, 'exists', '2025-05-06 00:00:00', '08:42:00', '0555444111', NULL, NULL, 'OPEN', '2025-05-06 00:44:08', '2025-05-06 00:44:08');

-- --------------------------------------------------------

--
-- Table structure for table `case_logs`
--

CREATE TABLE `case_logs` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `court_case_id` int(11) NOT NULL,
  `judge_type` int(11) DEFAULT NULL,
  `case_status` int(11) DEFAULT NULL,
  `court_no` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judge_name` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bussiness_on_date` datetime DEFAULT NULL,
  `hearing_date` datetime DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `is_transfer` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `transfer_judge_type` int(11) DEFAULT NULL,
  `transfer_court_no` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_logs`
--

INSERT INTO `case_logs` (`id`, `advocate_id`, `court_case_id`, `judge_type`, `case_status`, `court_no`, `judge_name`, `bussiness_on_date`, `hearing_date`, `remark`, `is_transfer`, `transfer_judge_type`, `transfer_court_no`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-02-20 00:00:00', '2025-02-28 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-16 01:22:29', '2025-02-27 21:10:55'),
(2, 1, 2, 2, 3, '6543', 'Abdallah Saad', '2025-02-20 00:00:00', '2025-02-21 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-17 00:20:21', '2025-02-21 00:35:10'),
(3, 1, 2, 2, 1, '6543', 'Abdallah Saad', '2025-02-21 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-02-21 00:35:10', '2025-02-21 00:35:10'),
(4, 1, 3, 4, 3, '432222', 'Taha Ammar', '2025-02-21 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-02-21 03:31:34', '2025-02-22 18:28:32'),
(5, 1, 4, 4, 2, '769900', 'Taha Ammar', '2025-02-22 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-02-22 19:21:48', '2025-02-22 19:21:48'),
(6, 1, 5, 4, 2, '243366', NULL, '2025-02-23 00:00:00', '2025-02-26 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-22 22:35:46', '2025-02-23 23:47:52'),
(7, 1, 6, 2, 2, '554321', NULL, '2025-02-24 00:00:00', '2025-02-25 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-23 23:36:25', '2025-02-24 22:58:02'),
(8, 1, 5, 4, 2, '243366', NULL, '2025-02-26 00:00:00', '2025-03-28 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-23 23:47:52', '2025-03-28 00:01:22'),
(9, 1, 6, 2, 2, '554321', NULL, '2025-02-25 00:00:00', '2025-02-27 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-24 22:58:02', '2025-02-26 23:39:52'),
(10, 1, 6, 2, 2, '554321', NULL, '2025-02-27 00:00:00', '2025-02-28 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-26 23:39:52', '2025-02-27 21:11:40'),
(11, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-02-28 00:00:00', '2025-03-26 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-02-27 21:10:55', '2025-03-25 22:52:44'),
(12, 1, 6, 2, 2, '554321', NULL, '2025-02-28 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-02-27 21:11:40', '2025-02-27 21:11:40'),
(13, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-03-26 00:00:00', '2025-04-20 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-03-25 22:52:44', '2025-04-20 13:58:55'),
(14, 1, 5, 4, 2, '243366', NULL, '2025-03-28 00:00:00', '2025-04-23 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-03-28 00:01:22', '2025-04-22 22:15:35'),
(15, 1, 7, 7, 3, '554322', NULL, '2025-03-28 00:00:00', '2025-04-01 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-03-28 00:26:08', '2025-03-31 21:13:36'),
(16, 1, 7, 7, 3, '554322', NULL, '2025-04-01 00:00:00', '2025-04-12 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-03-31 21:13:36', '2025-04-12 20:13:13'),
(17, 1, 7, 7, 3, '554322', NULL, '2025-04-12 00:00:00', '2025-04-14 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-04-12 20:13:13', '2025-04-14 20:30:32'),
(18, 1, 7, 7, 3, '554322', NULL, '2025-04-14 00:00:00', '2025-04-15 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-04-14 20:30:32', '2025-04-15 20:25:47'),
(19, 1, 7, 7, 3, '554322', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-04-15 20:25:47', '2025-04-30 17:52:30'),
(20, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-04-20 00:00:00', '2025-04-22 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-04-19 22:26:03', '2025-04-20 13:59:27'),
(21, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-04-22 00:00:00', '2025-05-05 00:00:00', NULL, 'No', NULL, NULL, 1, '2025-04-20 13:59:27', '2025-05-05 17:07:09'),
(22, 1, 5, 4, 2, '243366', NULL, '2025-04-23 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-04-22 22:15:35', '2025-04-22 22:15:35'),
(23, 1, 7, 7, 3, '554322', NULL, '2025-04-30 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-04-30 17:52:30', '2025-04-30 17:52:30'),
(24, 1, 1, 1, 2, '4326', 'Ziad Abdel Latif', '2025-05-05 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-05-05 17:07:09', '2025-05-05 17:07:09'),
(25, 1, 8, 1, 2, '554322', NULL, '2025-05-06 00:00:00', NULL, NULL, 'No', NULL, NULL, 1, '2025-05-05 19:46:16', '2025-05-05 19:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `case_members`
--

CREATE TABLE `case_members` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `case_members`
--

INSERT INTO `case_members` (`id`, `case_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(12, 4, 2, '2025-02-22 19:21:48', '2025-02-22 19:21:48'),
(13, 5, 3, '2025-02-22 22:35:46', '2025-02-22 22:35:46'),
(15, 6, 4, '2025-02-23 23:38:21', '2025-02-23 23:38:21'),
(20, 7, 7, '2025-04-12 16:24:02', '2025-04-12 16:24:02'),
(22, 3, 3, '2025-04-12 19:07:47', '2025-04-12 19:07:47'),
(23, 2, 3, '2025-04-12 19:25:25', '2025-04-12 19:25:25'),
(24, 1, 2, '2025-04-20 13:58:55', '2025-04-20 13:58:55'),
(25, 8, 2, '2025-05-05 19:46:16', '2025-05-05 19:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `case_parties_involves`
--

CREATE TABLE `case_parties_involves` (
  `id` int(11) NOT NULL,
  `court_case_id` int(11) DEFAULT NULL,
  `position` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_advocate` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `case_parties_involves`
--

INSERT INTO `case_parties_involves` (`id`, `court_case_id`, `position`, `party_name`, `party_advocate`, `created_at`, `updated_at`) VALUES
(10, 4, 'Petitioner', 'Ghida Bashir', 'Ahmed Ali', '2025-02-22 19:21:48', '2025-02-22 19:21:48'),
(11, 5, 'Petitioner', 'Kamal Ahmed', 'Sultan Ghalib', '2025-02-22 22:35:46', '2025-02-22 22:35:46'),
(13, 6, 'Petitioner', 'Rahaf Sameer', 'Mohamed Talep', '2025-02-23 23:38:21', '2025-02-23 23:38:21'),
(18, 7, 'Petitioner', 'Rahaf Salem', 'Mohamed Salem', '2025-04-12 16:24:02', '2025-04-12 16:24:02'),
(20, 3, 'Petitioner', 'Mustafa Ghaleb', 'Children\'s rights', '2025-04-12 19:07:47', '2025-04-12 19:07:47'),
(21, 2, 'Petitioner', 'Marram Ali', 'Women\'s rights', '2025-04-12 19:25:25', '2025-04-12 19:25:25'),
(22, 1, 'Petitioner', 'Amin Abdo', 'Human Rights', '2025-04-20 13:58:55', '2025-04-20 13:58:55'),
(23, 8, 'Petitioner', 'عمار النجار', 'سالم الجراح', '2025-05-05 19:46:16', '2025-05-05 19:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `case_statuses`
--

CREATE TABLE `case_statuses` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `case_status_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_statuses`
--

INSERT INTO `case_statuses` (`id`, `advocate_id`, `case_status_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Closed', 'Yes', '2025-02-16 01:02:34', '2025-02-16 01:02:34'),
(2, 1, 'In Processing', 'Yes', '2025-02-16 01:02:49', '2025-03-27 18:40:58'),
(3, 1, 'Pending', 'Yes', '2025-02-16 01:02:57', '2025-02-16 01:02:57'),
(7, 1, 'Ready', 'Yes', '2025-03-27 23:48:36', '2025-04-14 17:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `case_transfers`
--

CREATE TABLE `case_transfers` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `court_case_id` int(11) NOT NULL,
  `from_judge_type` int(11) NOT NULL,
  `to_judge_type` int(11) NOT NULL,
  `from_court_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_court_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judge_name` varchar(255) DEFAULT NULL,
  `transfer_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `case_transfers`
--

INSERT INTO `case_transfers` (`id`, `advocate_id`, `court_case_id`, `from_judge_type`, `to_judge_type`, `from_court_no`, `to_court_no`, `judge_name`, `transfer_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '3542', '4326', 'Ziad Abdel Latif', '2025-02-16 00:00:00', '2025-02-16 02:09:11', '2025-02-16 02:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `case_types`
--

CREATE TABLE `case_types` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `case_type_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_types`
--

INSERT INTO `case_types` (`id`, `advocate_id`, `parent_id`, `case_type_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Murder', 'Yes', '2025-02-16 01:05:00', '2025-04-11 19:04:42'),
(2, 1, 0, 'Theft', 'Yes', '2025-02-16 01:05:40', '2025-02-16 01:05:40'),
(3, 1, 0, 'Drug', 'Yes', '2025-02-16 01:05:56', '2025-02-17 21:13:36'),
(4, 1, 0, 'Marriage', 'Yes', '2025-02-16 01:06:59', '2025-02-16 01:06:59'),
(5, 1, 0, 'Divorce', 'Yes', '2025-02-16 01:07:16', '2025-04-14 17:35:35'),
(10, 1, 0, 'Inheritance', 'Yes', '2025-03-27 23:47:01', '2025-05-04 03:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`) VALUES
(7255, '\'Isa', 327),
(7256, 'Badiyah', 328),
(7257, 'Hidd', 329),
(7258, 'Mahama', 331),
(7259, 'Manama', 332),
(7260, 'Sitrah', 333),
(7261, 'al-Manamah', 334),
(7262, 'al-Muharraq', 335),
(7263, 'ar-Rifa\'a', 336),
(25763, 'Bayan', 2083),
(25764, 'Hawalli', 2083),
(25765, 'Massilah', 2083),
(25766, 'Mushrif', 2083),
(25767, 'Salwa\'', 2083),
(25768, 'Sha\'\'ab', 2083),
(25769, 'Subbah-as-Salim', 2083),
(25770, 'al-Funaytis', 2083),
(25771, 'al-Funaytis-al-Garbiyah', 2083),
(25772, 'al-Jabiriyah', 2083),
(25773, 'al-Karim', 2083),
(25774, 'ar-Rumaythiyah', 2083),
(25775, 'as-Salimiyah', 2083),
(25776, 'Mishref', 2084),
(25777, 'Qadesiya', 2085),
(25778, 'Safat', 2086),
(25779, 'Salmiya', 2087),
(25780, 'A\'qaylah', 2088),
(25781, 'Abu Hulayfah', 2088),
(25782, 'Dahar', 2088),
(25783, 'Desert Area', 2088),
(25784, 'Hadiyah', 2088),
(25785, 'Jabbar-al-\'Ali', 2088),
(25786, 'Shu\'aybah', 2088),
(25787, 'al-Ahmadi', 2088),
(25788, 'al-Fintas', 2088),
(25789, 'al-Fuhayhil', 2088),
(25790, 'al-Mahbulah', 2088),
(25791, 'al-Manqaf', 2088),
(25792, 'al-Wafrah', 2088),
(25793, 'ar-Riqqah', 2088),
(25794, 'as-Sabahiyah', 2088),
(25795, 'az-Zawr', 2088),
(25796, '\'Umayriyah', 2089),
(25797, 'Abraq Khitan', 2089),
(25798, 'Ardiyah', 2089),
(25799, 'Fardaws', 2089),
(25800, 'Jalib ash-Shuyuh', 2089),
(25801, 'Janub-as-Surrah', 2089),
(25802, 'Khitan-al-Janubiyah', 2089),
(25803, 'Qartaba', 2089),
(25804, 'Ray', 2089),
(25805, 'Riqay', 2089),
(25806, 'Sabhan', 2089),
(25807, 'Sarbah-an-Nasr', 2089),
(25808, 'Warmawk', 2089),
(25809, 'al-Andalus', 2089),
(25810, 'al-Farwaniyah', 2089),
(25811, 'ar-Rabbiyah', 2089),
(25812, 'Amgarah', 2090),
(25813, 'Desert Area', 2090),
(25814, 'Nasim', 2090),
(25815, 'Tayma\'', 2090),
(25816, 'Uyawn', 2090),
(25817, 'Waha', 2090),
(25818, 'al-Jahra', 2090),
(25819, 'al-Qusayr', 2090),
(25820, 'as-Sulaybiyah', 2090),
(25821, '\'Abullah-as-Salam', 2091),
(25822, 'Ardhiyah', 2091),
(25823, 'Banayd-al-Qar', 2091),
(25824, 'Health District', 2091),
(25825, 'Kayfan', 2091),
(25826, 'Khalidiyah', 2091),
(25827, 'Mansuriyah', 2091),
(25828, 'Nuzha', 2091),
(25829, 'Qarnadah', 2091),
(25830, 'Shamiyah', 2091),
(25831, 'ad-Da\'iyah', 2091),
(25832, 'ad-Dasma', 2091),
(25833, 'ad-Dawhah', 2091),
(25834, 'al-\'Udayliyah', 2091),
(25835, 'al-Fayha', 2091),
(25836, 'al-Kuwayt', 2091),
(25837, 'al-Qadisiyah', 2091),
(25838, 'ar-Rawdah', 2091),
(25839, 'as-Sulaybihat', 2091),
(25840, 'ash-Shuwaykh Industrial', 2091),
(25841, 'ash-Shuwaykh Reservoir', 2091),
(31241, 'Salalah', 2714),
(31242, 'Azaiba', 2715),
(31243, 'Bawshar', 2715),
(31244, 'Madinat Qabus', 2715),
(31245, 'Masqat', 2715),
(31246, 'Matrah', 2715),
(31247, 'Muscat', 2715),
(31248, 'Muttrah', 2715),
(31249, 'Qurayyat', 2715),
(31250, 'Qurm', 2715),
(31251, 'Ruwi', 2715),
(31252, 'Wadi Al Kabir', 2715),
(31253, 'as-Sib', 2715),
(31254, 'Khasab', 2716),
(31255, 'Rusayl', 2717),
(31256, 'Bahla\'', 2719),
(31257, 'Nizwa', 2719),
(31258, 'Sumayl', 2719),
(31259, '\'Ibri', 2720),
(31260, 'al-Buraymi', 2720),
(31261, 'Al khuwair', 2721),
(31262, 'Barkah', 2721),
(31263, 'Saham', 2721),
(31264, 'Shinas', 2721),
(31265, 'Suhar', 2721),
(31266, 'al-Khaburah', 2721),
(31267, 'al-Masna\'ah', 2721),
(31268, 'ar-Rustaq', 2721),
(31269, 'as-Suwayq', 2721),
(31270, 'Ibra', 2722),
(31271, 'Sur', 2722),
(31272, 'al-Mudaybi', 2722),
(33093, 'Doha', 2920),
(33094, 'Umm Bab', 2921),
(33095, 'ad-Dawhah', 2923),
(33096, 'al-Ghuwayriyah', 2924),
(33097, 'Dukhan', 2925),
(33098, 'al-Jumayliyah', 2925),
(33099, 'al-Khawr', 2926),
(33100, 'Musay\'id', 2927),
(33101, 'al-Wakrah', 2927),
(33102, 'al-Wukayr', 2927),
(33103, 'ar-Rayyan', 2928),
(33104, 'ash-Shahaniyah', 2928),
(33105, 'ar-Ruways', 2929),
(37410, 'Mahayel', 3147),
(37411, 'Abha', 3149),
(37412, 'Abu \'Aris', 3149),
(37413, 'Khamis Mushayt', 3149),
(37414, 'Qal\'at Bishah', 3149),
(37415, 'Ha\'il', 3152),
(37416, 'Jawf', 3153),
(37417, 'Sakakah', 3153),
(37418, 'Jizan', 3154),
(37419, 'Sabya', 3154),
(37420, 'Makkah', 3155),
(37421, 'Rabig', 3155),
(37422, 'al-Hawiyah', 3155),
(37423, 'at-Ta\'if', 3155),
(37424, 'Dar\'iyah', 3156),
(37425, 'Najran', 3156),
(37426, 'Sharurah', 3156),
(37427, '\'Unayzah', 3157),
(37428, 'Buraydah', 3157),
(37429, 'ar-Rass', 3157),
(37430, 'Tabuk', 3158),
(37431, 'Umm Lajj', 3158),
(37432, 'al-Bahah', 3160),
(37433, 'Ara\'ar', 3161),
(37434, 'Rafha', 3161),
(37435, 'Turayf', 3161),
(37436, 'al-Qurayyat', 3161),
(37437, 'Yanbu', 3162),
(37438, 'al-Madinah', 3162),
(37439, '\'Afif', 3163),
(37440, 'ad-Dawadimi', 3163),
(37441, 'ad-Dilam', 3163),
(37442, 'al-Kharj', 3163),
(37443, 'al-Majma\'ah', 3163),
(37444, 'ar-Riyad', 3163),
(37445, 'az-Zulfi', 3163),
(41388, 'Ajman', 3797),
(41389, 'Al Qusais', 3798),
(41390, 'Deira', 3798),
(41391, 'Dubai', 3798),
(41392, 'Jebel Ali', 3798),
(41393, 'Sharjah', 3800),
(41394, 'Khawr Fakkan', 3803),
(41395, 'al-Fujayrah', 3803);

-- --------------------------------------------------------

--
-- Table structure for table `client_parties_invoives`
--

CREATE TABLE `client_parties_invoives` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `advocate_id` int(11) DEFAULT NULL,
  `party_firstname` varchar(255) DEFAULT NULL,
  `party_middlename` varchar(255) DEFAULT NULL,
  `party_lastname` varchar(255) DEFAULT NULL,
  `party_mobile` varchar(255) DEFAULT NULL,
  `party_address` varchar(255) DEFAULT NULL,
  `party_advocate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name`, `phonecode`) VALUES
(17, 'BH', 'Bahrain', 973),
(117, 'KW', 'Kuwait', 965),
(165, 'OM', 'Oman', 968),
(178, 'QA', 'Qatar', 974),
(191, 'SA', 'Saudi Arabia', 966),
(229, 'AE', 'United Arab Emirates', 971);

-- --------------------------------------------------------

--
-- Table structure for table `courts`
--

CREATE TABLE `courts` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `court_type_id` int(11) NOT NULL,
  `court_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `advocate_id`, `court_type_id`, `court_name`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'Criminal Court', 'Yes', '2025-02-16 00:43:36', '2025-05-04 18:43:31'),
(3, 1, 2, 'Personal Status Court', 'Yes', '2025-02-16 00:44:41', '2025-04-13 00:47:41'),
(4, 1, 2, 'Commercial Court', 'Yes', '2025-02-16 00:44:59', '2025-02-16 00:44:59'),
(5, 1, 2, 'Labor Court', 'Yes', '2025-02-16 00:45:17', '2025-02-16 00:45:17'),
(6, 1, 3, 'Appeal Circuits', 'Yes', '2025-02-16 00:46:00', '2025-02-16 00:46:00'),
(8, 1, 3, 'Commercial Circuits', 'Yes', '2025-02-16 00:46:34', '2025-02-18 18:43:42'),
(9, 1, 3, 'Labor Circuits', 'Yes', '2025-02-16 00:46:52', '2025-02-16 00:46:52'),
(10, 1, 4, 'Cassation Circuits', 'Yes', '2025-02-16 00:47:16', '2025-02-16 00:47:16'),
(11, 1, 4, 'General Judiciary Circuits', 'Yes', '2025-02-16 00:47:33', '2025-05-03 02:24:37'),
(14, 1, 2, 'General Court', 'Yes', '2025-03-27 23:39:52', '2025-05-04 20:56:47'),
(15, 1, 2, 'Law Court', 'Yes', '2025-04-11 22:07:47', '2025-04-11 22:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `court_cases`
--

CREATE TABLE `court_cases` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `advo_client_id` int(11) NOT NULL,
  `client_position` enum('Respondent','Petitioner') COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_lawyer` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_number` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_types` int(11) NOT NULL,
  `case_sub_type` int(11) DEFAULT NULL,
  `case_status` int(11) NOT NULL,
  `act` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('High','Medium','Low') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Low',
  `court_no` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `court_type` int(11) NOT NULL,
  `court` int(11) NOT NULL,
  `judge_type` int(11) NOT NULL,
  `judge_name` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filing_number` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filing_date` datetime NOT NULL,
  `registration_number` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_date` datetime NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cnr_number` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_hearing_date` date DEFAULT NULL,
  `next_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `police_station` text COLLATE utf8mb4_unicode_ci,
  `fir_number` text COLLATE utf8mb4_unicode_ci,
  `fir_date` date DEFAULT NULL,
  `is_nb` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `decision_date` date DEFAULT NULL,
  `nature_disposal` text COLLATE utf8mb4_unicode_ci,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `court_cases`
--

INSERT INTO `court_cases` (`id`, `advocate_id`, `advo_client_id`, `client_position`, `party_name`, `party_lawyer`, `case_number`, `case_types`, `case_sub_type`, `case_status`, `act`, `priority`, `court_no`, `court_type`, `court`, `judge_type`, `judge_name`, `filing_number`, `filing_date`, `registration_number`, `registration_date`, `remark`, `description`, `cnr_number`, `first_hearing_date`, `next_date`, `updated_by`, `police_station`, `fir_number`, `fir_date`, `is_nb`, `decision_date`, `nature_disposal`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Petitioner', 'Amin Abdo', 'Human Rights', '20210001', 1, NULL, 2, 'Find Evidences', 'High', '4326', 2, 2, 1, 'Ziad Abdel Latif', '20210022', '2025-02-16 00:00:00', '202155', '2025-02-16 00:00:00', NULL, NULL, '3372', '2025-02-20', '2025-05-05 00:00:00', 1, 'Bisha Police Station', '439988', '2025-02-16', 'No', NULL, NULL, 'Yes', '2025-02-16 01:22:29', '2025-05-05 17:07:09'),
(2, 1, 2, 'Petitioner', 'Marram Ali', 'Women\'s rights', '437890', 4, NULL, 1, 'Haron', 'Medium', '6543', 2, 3, 2, 'Abdallah Saad', '437788', '2025-02-19 00:00:00', '543322', '2025-02-17 00:00:00', 'done', NULL, NULL, '2025-02-20', '2025-02-21 00:00:00', 1, 'Bisha Police Station', '435', '2025-02-17', 'No', '2025-02-21', 'Done', 'No', '2025-02-17 00:20:21', '2025-02-21 00:35:10'),
(3, 1, 2, 'Petitioner', 'Mustafa Ghaleb', 'Children\'s rights', '654333', 3, NULL, 3, 'Ok', 'Medium', '432222', 2, 2, 4, 'Taha Ammar', '876655', '2025-02-21 00:00:00', '776544', '2025-02-21 00:00:00', NULL, NULL, NULL, '2025-02-21', '2025-02-21 00:00:00', 1, 'Bishs Police Station', NULL, NULL, 'No', NULL, NULL, 'Yes', '2025-02-21 03:31:34', '2025-04-12 19:07:47'),
(4, 1, 3, 'Petitioner', 'Ghida Bashir', 'Ahmed Ali', '66543255', 2, NULL, 2, 'Find Evidences', 'Low', '769900', 2, 3, 4, 'Taha Ammar', '65778854', '2025-02-22 00:00:00', '20251144', '2025-02-22 00:00:00', NULL, NULL, NULL, '2025-02-22', '2025-02-22 00:00:00', 1, 'Jizan Police Station', '665533', '2025-02-22', 'Yes', NULL, NULL, 'Yes', '2025-02-22 19:21:48', '2025-02-27 21:12:58'),
(5, 1, 4, 'Petitioner', 'Kamal Ahmed', 'Sultan Ghalib', '20250270', 4, NULL, 2, 'Find Evidences', 'Medium', '243366', 2, 3, 4, NULL, '20250099', '2025-02-23 00:00:00', '20251188', '2025-02-23 00:00:00', NULL, NULL, NULL, '2025-02-23', '2025-04-23 00:00:00', 1, 'Makah Police Station', '32448', '2025-02-23', 'No', NULL, NULL, 'Yes', '2025-02-22 22:35:46', '2025-04-22 22:15:35'),
(6, 1, 2, 'Petitioner', 'Rahaf Sameer', 'Mohamed Talep', '765433', 2, NULL, 2, 'Preparing evidence', 'Low', '554321', 2, 2, 2, NULL, '665433', '2025-02-24 00:00:00', '665432', '2025-02-24 00:00:00', NULL, NULL, NULL, '2025-02-24', '2025-02-28 00:00:00', 1, 'Bisha Police Station', '776544', '2025-02-24', 'Yes', NULL, NULL, 'Yes', '2025-02-23 23:36:25', '2025-03-25 22:50:11'),
(7, 1, 5, 'Petitioner', 'Rahaf Salem', 'Mohamed Salem', '765477', 4, NULL, 3, 'Preparing evidence', 'High', '554322', 2, 3, 7, NULL, '665400', '2025-03-28 00:00:00', '665488', '2025-03-28 00:00:00', NULL, NULL, NULL, '2025-03-28', '2025-04-30 00:00:00', 1, 'Bisha Police Station', '776566', '2025-03-28', 'No', NULL, NULL, 'Yes', '2025-03-28 00:26:08', '2025-04-30 17:52:30'),
(8, 1, 6, 'Petitioner', 'عمار النجار', 'سالم الجراح', '765477', 3, NULL, 2, 'القانون رقم 434 الفصل السابع', 'High', '554322', 2, 2, 1, NULL, '665400', '2025-05-05 00:00:00', '202155', '2025-05-05 00:00:00', NULL, NULL, NULL, '2025-05-06', '2025-05-06 00:00:00', 1, 'شرطة بيشة', '435', '2025-05-05', 'No', NULL, NULL, 'Yes', '2025-05-05 19:46:16', '2025-05-05 19:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `court_types`
--

CREATE TABLE `court_types` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `court_type_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `court_types`
--

INSERT INTO `court_types` (`id`, `advocate_id`, `court_type_name`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 1, 'Court of First Instance', 'Yes', '2025-02-16 00:40:02', '2025-02-16 00:40:02'),
(3, 1, 'Court of Appeal', 'Yes', '2025-02-16 00:40:31', '2025-04-13 00:46:58'),
(4, 1, 'Supreme Court', 'Yes', '2025-02-16 00:40:58', '2025-05-04 03:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `tax_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `inv_status` enum('Due','Partially Paid','Paid') NOT NULL DEFAULT 'Due',
  `due_date` date NOT NULL,
  `inv_date` date NOT NULL,
  `remarks` text,
  `tax_type` varchar(255) DEFAULT NULL,
  `json_content` text,
  `invoice_created_by` int(11) NOT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `advocate_id`, `vendor_id`, `invoice_no`, `sub_total_amount`, `tax_amount`, `total_amount`, `tax_id`, `inv_status`, `due_date`, `inv_date`, `remarks`, `tax_type`, `json_content`, `invoice_created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, 1, '6789', '700.00', '0.00', '700.00', NULL, 'Paid', '2025-02-16', '2025-02-16', NULL, NULL, NULL, 1, 'Yes', '2025-02-16 05:05:26', '2025-05-05 05:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_items`
--

CREATE TABLE `expenses_items` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax` varchar(255) DEFAULT '0',
  `category_id` text NOT NULL,
  `description` text,
  `iteam_qty` int(11) NOT NULL,
  `item_amount` varchar(200) NOT NULL,
  `item_rate` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses_items`
--

INSERT INTO `expenses_items` (`id`, `advocate_id`, `vendor_id`, `invoice_id`, `tax_id`, `tax`, `category_id`, `description`, `iteam_qty`, `item_amount`, `item_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '0', '1', 'food', 2, '400.00', '200', '2025-02-16 05:05:26', '2025-05-05 05:24:04'),
(2, 1, 1, 1, NULL, '0', '2', 'snacks', 3, '300.00', '100', '2025-02-16 05:05:26', '2025-02-16 05:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `expense_cats`
--

CREATE TABLE `expense_cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `advocate_id` int(11) NOT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense_cats`
--

INSERT INTO `expense_cats` (`id`, `name`, `description`, `advocate_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Food', 'iuu', 1, 'Yes', '2025-05-05 02:19:20', '2025-05-05 02:19:20'),
(2, 'Snacks', 'It is ok', 1, 'Yes', '2025-05-05 03:34:58', '2025-05-05 03:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `company_name` text,
  `address` text,
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `date_formet` int(11) DEFAULT NULL,
  `logo_img` text,
  `favicon_img` text,
  `timezone` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `company_name`, `address`, `country`, `state`, `city`, `pincode`, `date_formet`, `logo_img`, `favicon_img`, `timezone`, `updated_at`, `created_at`) VALUES
(1, 'LAW PRO', 'Al Nakhil neighborhood, Bisha', 191, 3147, 37410, 300088, 1, '1746069759_2logo (1).png', '1742937896_1Screenshot 2025-03-26 002126.png', '337', '2025-05-05 03:58:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `tax_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) NOT NULL,
  `inv_status` enum('Due','Partially Paid','Paid') NOT NULL DEFAULT 'Due',
  `due_date` date NOT NULL,
  `inv_date` date NOT NULL,
  `remarks` text,
  `tax_type` varchar(255) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `json_content` text,
  `invoice_created_by` int(11) NOT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `advocate_id`, `client_id`, `invoice_no`, `sub_total_amount`, `tax_amount`, `total_amount`, `inv_status`, `due_date`, `inv_date`, `remarks`, `tax_type`, `tax_id`, `service_id`, `json_content`, `invoice_created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'INV-2025/000014', '750.00', '90.00', '840.00', 'Due', '2025-02-19', '2025-02-16', 'All are done', NULL, 1, NULL, NULL, 1, 'No', '2025-02-16 04:49:16', '2025-03-31 00:12:13'),
(2, 1, 2, 'INV-000015', '1350.00', '108.00', '1458.00', 'Due', '2025-03-31', '2025-03-31', NULL, NULL, 1, NULL, NULL, 1, 'Yes', '2025-03-31 00:08:26', '2025-05-05 04:24:56'),
(3, 1, 2, 'INV-000016', '350.00', '0.00', '350.00', 'Due', '2025-05-07', '2025-05-06', NULL, NULL, NULL, NULL, NULL, 1, 'Yes', '2025-05-06 06:01:29', '2025-05-06 06:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax` varchar(255) DEFAULT '0',
  `item_description` text,
  `iteam_qty` int(11) NOT NULL,
  `item_amount` varchar(200) NOT NULL,
  `item_rate` varchar(255) NOT NULL,
  `hsn` varchar(255) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `advocate_id`, `client_id`, `invoice_id`, `tax_id`, `tax`, `item_description`, `iteam_qty`, `item_amount`, `item_rate`, `hsn`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '0', 'Atty', 2, '300.00', '150.00', NULL, 3, '2025-02-16 04:49:16', '2025-02-16 04:49:16'),
(2, 1, 1, 1, NULL, '0', 'Doc Stamp', 5, '250.00', '50.00', NULL, 2, '2025-02-16 04:49:16', '2025-02-16 04:49:16'),
(3, 1, 1, 1, NULL, '0', 'Counsel', 1, '200.00', '200.00', NULL, 1, '2025-02-16 04:49:16', '2025-02-16 04:49:16'),
(4, 1, 2, 2, NULL, '0', NULL, 3, '450.00', '150.00', NULL, 3, '2025-03-31 00:08:26', '2025-05-02 00:04:44'),
(5, 1, 2, 2, NULL, '0', NULL, 10, '500.00', '50.00', NULL, 2, '2025-03-31 00:08:26', '2025-03-31 00:08:26'),
(6, 1, 2, 2, NULL, '0', NULL, 2, '400.00', '200.00', NULL, 1, '2025-05-05 04:24:56', '2025-05-05 04:24:56'),
(7, 1, 2, 3, NULL, '0', NULL, 1, '200.00', '200.00', NULL, 1, '2025-05-06 06:01:29', '2025-05-06 06:01:29'),
(8, 1, 2, 3, NULL, '0', NULL, 3, '150.00', '50.00', NULL, 2, '2025-05-06 06:01:29', '2025-05-06 06:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `invoice_formet` int(11) NOT NULL DEFAULT '1',
  `prefix` text,
  `client_note` text,
  `term_condition` text,
  `invoice_no` int(255) NOT NULL DEFAULT '0',
  `receipt_no` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `advocate_id`, `invoice_formet`, `prefix`, `client_note`, `term_condition`, `invoice_no`, `receipt_no`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'INV-', NULL, NULL, 16, 0, '2025-05-06 03:01:29', '2025-05-06 03:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `judge_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `advocate_id`, `judge_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fahd Salem', 'Yes', '2025-02-16 00:55:53', '2025-04-14 17:37:04'),
(2, 1, 'Abdallah Saad', 'Yes', '2025-02-16 00:57:00', '2025-04-13 00:48:11'),
(3, 1, 'Ziad Abdel Latif', 'Yes', '2025-02-16 00:58:00', '2025-03-25 22:39:58'),
(4, 1, 'Taha Ammar', 'Yes', '2025-02-18 18:41:54', '2025-02-18 18:41:54'),
(7, 1, 'Gabir Ammar', 'Yes', '2025-03-27 23:42:26', '2025-04-22 22:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `mailsetups`
--

CREATE TABLE `mailsetups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_host` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_port` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mail_driver` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_encryption` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mailsetups`
--

INSERT INTO `mailsetups` (`id`, `mail_host`, `mail_port`, `mail_username`, `mail_email`, `mail_password`, `created_at`, `updated_at`, `mail_driver`, `mail_encryption`) VALUES
(1, 'smtp.gmail.com', '587', 'laworo@gmail.com', '', '12345678', NULL, '2025-05-04 21:50:49', 'smtp', 'SSL');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(10) UNSIGNED NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_mades`
--

CREATE TABLE `payment_mades` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` bigint(200) NOT NULL DEFAULT '0',
  `receiving_date` date NOT NULL,
  `payment_type` enum('Cash','Cheque','Net Banking','Other') NOT NULL DEFAULT 'Cash',
  `reference_number` varchar(255) DEFAULT NULL,
  `cheque_date` datetime DEFAULT NULL,
  `note` text,
  `payment_received_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_mades`
--

INSERT INTO `payment_mades` (`id`, `advocate_id`, `vendor_id`, `invoice_id`, `amount`, `receiving_date`, `payment_type`, `reference_number`, `cheque_date`, `note`, `payment_received_by`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 1, 500, '2025-02-16', 'Cash', '546678', NULL, 'done', 1, '2025-02-16 05:06:39', '2025-02-16 05:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment_receiveds`
--

CREATE TABLE `payment_receiveds` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `receipt_number` int(11) DEFAULT NULL,
  `amount` varchar(200) NOT NULL,
  `receiving_date` datetime NOT NULL,
  `payment_type` enum('Cash','Cheque','Net Banking','Other') NOT NULL DEFAULT 'Cash',
  `cheque_date` date DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `note` text,
  `payment_received_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `description`) VALUES
(1, 'dashboard_list', NULL),
(2, 'client_list', NULL),
(3, 'client_add', NULL),
(4, 'client_edit', NULL),
(5, 'client_delete', NULL),
(6, 'task_list', NULL),
(7, 'task_add', NULL),
(8, 'task_edit', NULL),
(9, 'task_delete', NULL),
(10, 'vendor_list', NULL),
(11, 'vendor_add', NULL),
(12, 'vendor_edit', NULL),
(13, 'vendor_delete', NULL),
(14, 'case_list', NULL),
(15, 'case_add', NULL),
(16, 'case_edit', NULL),
(17, 'appointment_list', NULL),
(18, 'appointment_add', NULL),
(19, 'appointment_edit', NULL),
(20, 'expense_type_list', NULL),
(21, 'expense_type_add', NULL),
(22, 'expense_type_edit', NULL),
(23, 'expense_type_delete', NULL),
(24, 'expense_list', NULL),
(25, 'expense_add', NULL),
(26, 'expense_edit', NULL),
(27, 'expense_delete', NULL),
(28, 'invoice_list', NULL),
(29, 'invoice_add', NULL),
(30, 'invoice_edit', NULL),
(31, 'invoice_delete', NULL),
(32, 'case_type_list', NULL),
(33, 'case_type_add', NULL),
(34, 'case_type_edit', NULL),
(35, 'case_type_delete', NULL),
(36, 'court_type_list', NULL),
(37, 'court_type_add', NULL),
(38, 'court_type_edit', NULL),
(39, 'court_type_delete', NULL),
(40, 'court_list', NULL),
(41, 'court_add', NULL),
(42, 'court_edit', NULL),
(43, 'court_delete', NULL),
(44, 'case_status_list', NULL),
(45, 'case_status_add', NULL),
(46, 'case_status_edit', NULL),
(47, 'case_status_delete', NULL),
(48, 'judge_list', NULL),
(49, 'judge_add', NULL),
(50, 'judge_edit', NULL),
(51, 'judge_delete', NULL),
(52, 'tax_list', NULL),
(53, 'tax_add', NULL),
(54, 'tax_edit', NULL),
(55, 'tax_delete', NULL),
(56, 'invoice_setting_edit', NULL),
(57, 'mail_setup_edit', NULL),
(58, 'general_setting_edit', NULL),
(59, 'service_list', NULL),
(60, 'service_add', NULL),
(61, 'service_edit', NULL),
(62, 'service_delete', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `role_id` int(2) NOT NULL,
  `permission_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES
(63, 1, 1),
(64, 1, 2),
(65, 1, 3),
(66, 1, 4),
(67, 1, 5),
(68, 1, 6),
(69, 1, 7),
(70, 1, 8),
(71, 1, 9),
(72, 1, 10),
(73, 1, 11),
(74, 1, 12),
(75, 1, 13),
(76, 1, 14),
(77, 1, 15),
(78, 1, 16),
(79, 1, 17),
(80, 1, 18),
(81, 1, 19),
(82, 1, 20),
(83, 1, 21),
(84, 1, 22),
(85, 1, 23),
(86, 1, 24),
(87, 1, 25),
(88, 1, 26),
(89, 1, 27),
(90, 1, 59),
(91, 1, 60),
(92, 1, 61),
(93, 1, 62),
(94, 1, 28),
(95, 1, 29),
(96, 1, 30),
(97, 1, 31),
(98, 1, 32),
(99, 1, 33),
(100, 1, 34),
(101, 1, 35),
(102, 1, 36),
(103, 1, 37),
(104, 1, 38),
(105, 1, 39),
(106, 1, 40),
(107, 1, 41),
(108, 1, 42),
(109, 1, 43),
(110, 1, 44),
(111, 1, 45),
(112, 1, 46),
(113, 1, 47),
(114, 1, 48),
(115, 1, 49),
(116, 1, 50),
(117, 1, 51),
(118, 1, 52),
(119, 1, 53),
(120, 1, 54),
(121, 1, 55),
(122, 1, 56),
(123, 1, 57),
(124, 1, 58),
(633, 4, 1),
(634, 4, 2),
(635, 4, 3),
(636, 4, 4),
(637, 4, 5),
(638, 4, 6),
(639, 4, 7),
(640, 4, 8),
(641, 4, 9),
(642, 4, 10),
(643, 4, 11),
(644, 4, 12),
(645, 4, 13),
(646, 4, 17),
(647, 4, 18),
(648, 4, 19),
(649, 2, 1),
(650, 2, 2),
(651, 2, 3),
(652, 2, 4),
(653, 2, 5),
(654, 2, 6),
(655, 2, 7),
(656, 2, 8),
(657, 2, 9),
(658, 2, 14),
(659, 2, 15),
(660, 2, 16),
(661, 2, 17),
(662, 2, 18),
(663, 2, 19),
(664, 2, 59),
(665, 2, 60),
(666, 2, 61),
(667, 2, 62),
(668, 6, 1),
(669, 6, 2),
(670, 6, 3),
(671, 6, 4),
(672, 6, 5),
(673, 6, 6),
(674, 6, 7),
(675, 6, 8),
(676, 6, 9),
(677, 6, 10),
(678, 6, 11),
(679, 6, 12),
(680, 6, 13),
(681, 6, 14),
(682, 6, 15),
(683, 6, 16),
(684, 6, 17),
(685, 6, 18),
(686, 6, 19),
(687, 6, 20),
(688, 6, 21),
(689, 6, 22),
(690, 6, 23),
(691, 6, 24),
(692, 6, 25),
(693, 6, 26),
(694, 6, 27),
(695, 6, 59),
(696, 6, 60),
(697, 6, 61),
(698, 6, 62),
(699, 6, 28),
(700, 6, 29),
(701, 6, 30),
(702, 6, 31),
(703, 6, 32),
(704, 6, 33),
(705, 6, 34),
(706, 6, 35),
(707, 6, 36),
(708, 6, 37),
(709, 6, 38),
(710, 6, 39),
(711, 6, 40),
(712, 6, 41),
(713, 6, 42),
(714, 6, 43),
(715, 6, 44),
(716, 6, 45),
(717, 6, 46),
(718, 6, 47),
(719, 6, 48),
(720, 6, 49),
(721, 6, 50),
(722, 6, 51),
(723, 6, 52),
(724, 6, 53),
(725, 6, 54),
(726, 6, 55),
(727, 6, 58);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `is_active` enum('Yes','No') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AdminSuper', NULL, 'Yes', '2025-02-01 13:50:21', '2025-02-05 14:21:59'),
(2, 'Lawyer', NULL, 'Yes', '2025-02-16 05:13:51', '2025-05-05 06:29:14'),
(4, 'Employee', NULL, 'Yes', '2025-02-16 03:06:25', '2025-05-05 06:28:57'),
(6, 'Admin', NULL, 'Yes', '2025-04-14 22:58:53', '2025-05-05 04:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `amount`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Legal Counselling', '200.00', 'Yes', '2025-02-16 01:40:27', '2025-05-05 00:11:53'),
(2, 'Documentary Stamp', '50.00', 'Yes', '2025-02-16 01:40:51', '2025-05-05 03:56:25'),
(3, 'Attorney Fee', '200.00', 'Yes', '2025-02-16 01:42:38', '2025-05-05 03:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`) VALUES
(327, '\'Isa', 17),
(328, 'Badiyah', 17),
(329, 'Hidd', 17),
(330, 'Jidd Hafs', 17),
(331, 'Mahama', 17),
(332, 'Manama', 17),
(333, 'Sitrah', 17),
(334, 'al-Manamah', 17),
(335, 'al-Muharraq', 17),
(336, 'ar-Rifa\'a', 17),
(2082, 'Al Asimah', 117),
(2083, 'Hawalli', 117),
(2084, 'Mishref', 117),
(2085, 'Qadesiya', 117),
(2086, 'Safat', 117),
(2087, 'Salmiya', 117),
(2088, 'al-Ahmadi', 117),
(2089, 'al-Farwaniyah', 117),
(2090, 'al-Jahra', 117),
(2091, 'al-Kuwayt', 117),
(2713, 'Al Buraimi', 165),
(2714, 'Dhufar', 165),
(2715, 'Masqat', 165),
(2716, 'Musandam', 165),
(2717, 'Rusayl', 165),
(2718, 'Wadi Kabir', 165),
(2719, 'ad-Dakhiliyah', 165),
(2720, 'adh-Dhahirah', 165),
(2721, 'al-Batinah', 165),
(2722, 'ash-Sharqiyah', 165),
(2920, 'Doha', 178),
(2921, 'Jarian-al-Batnah', 178),
(2922, 'Umm Salal', 178),
(2923, 'ad-Dawhah', 178),
(2924, 'al-Ghuwayriyah', 178),
(2925, 'al-Jumayliyah', 178),
(2926, 'al-Khawr', 178),
(2927, 'al-Wakrah', 178),
(2928, 'ar-Rayyan', 178),
(2929, 'ash-Shamal', 178),
(3146, 'Al Khobar', 191),
(3147, 'Aseer', 191),
(3148, 'Ash Sharqiyah', 191),
(3149, 'Asir', 191),
(3150, 'Central Province', 191),
(3151, 'Eastern Province', 191),
(3152, 'Ha\'il', 191),
(3153, 'Jawf', 191),
(3154, 'Jizan', 191),
(3155, 'Makkah', 191),
(3156, 'Najran', 191),
(3157, 'Qasim', 191),
(3158, 'Tabuk', 191),
(3159, 'Western Province', 191),
(3160, 'al-Bahah', 191),
(3161, 'al-Hudud-ash-Shamaliyah', 191),
(3162, 'al-Madinah', 191),
(3163, 'ar-Riyad', 191),
(3796, 'Abu Zabi', 229),
(3797, 'Ajman', 229),
(3798, 'Dubai', 229),
(3799, 'Ras al-Khaymah', 229),
(3800, 'Sharjah', 229),
(3801, 'Sharjha', 229),
(3802, 'Umm al Qaywayn', 229),
(3803, 'al-Fujayrah', 229),
(3804, 'ash-Shariqah', 229);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `rel_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rel_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_type_task_id` int(11) DEFAULT NULL,
  `task_subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `checklist_complete_remarks` text COLLATE utf8mb4_unicode_ci,
  `checklist_complete_signature` text COLLATE utf8mb4_unicode_ci,
  `is_active` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `critical_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `rel_type`, `rel_id`, `customer_id`, `project_type_task_id`, `task_subject`, `project_status`, `priority`, `start_date`, `end_date`, `description`, `checklist_complete_remarks`, `checklist_complete_signature`, `is_active`, `created_at`, `updated_at`, `critical_comment`) VALUES
(3, 'case', 1, NULL, NULL, 'Find Evidence', 'in_progress', 'high', '2025-04-21', '2025-04-22', NULL, NULL, NULL, 'Yes', '2025-04-20 21:45:45', '2025-05-01 21:27:12', NULL),
(4, 'other', 0, NULL, NULL, 'Find Evidence6', 'not_started', 'medium', '2025-05-02', '2025-05-02', NULL, NULL, NULL, 'Yes', '2025-05-01 21:28:28', '2025-05-05 01:14:50', NULL),
(5, 'case', 7, NULL, NULL, 'Find Evidence 7', 'deferred', 'high', '2025-05-05', '2025-05-06', NULL, NULL, NULL, 'Yes', '2025-05-05 18:51:12', '2025-05-05 18:51:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_members`
--

CREATE TABLE `task_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_members`
--

INSERT INTO `task_members` (`id`, `task_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(18, 4, 4, '2025-05-05 01:14:50', '2025-05-05 01:14:50'),
(19, 3, 3, '2025-05-05 03:53:46', '2025-05-05 03:53:46'),
(20, 5, 2, '2025-05-05 18:51:12', '2025-05-05 18:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `advocate_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `alternate_no` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `advocate_id`, `first_name`, `middle_name`, `last_name`, `company_name`, `email`, `mobile`, `alternate_no`, `address`, `country_id`, `state_id`, `city_id`, `gst`, `pan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 0, 'Ali', NULL, 'Saleh', 'Law Pro Financial', 'ali@gmail.com', '0555000333', '0556874221', 'Al Nakhil neighborhood, Bisha', 191, 3147, 37410, NULL, NULL, 'Yes', '2025-05-05 01:28:21', '2025-05-05 01:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone_id` int(10) NOT NULL,
  `country_code` char(2) COLLATE utf8_bin NOT NULL,
  `zone_name` varchar(35) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone_id`, `country_code`, `zone_name`) VALUES
(2, 'AE', 'Asia/Dubai'),
(55, 'BH', 'Asia/Bahrain'),
(137, 'DJ', 'Africa/Djibouti'),
(141, 'DZ', 'Africa/Algiers'),
(145, 'EG', 'Africa/Cairo'),
(196, 'IQ', 'Asia/Baghdad'),
(202, 'JO', 'Asia/Amman'),
(214, 'KW', 'Asia/Kuwait'),
(224, 'LB', 'Asia/Beirut'),
(233, 'LY', 'Africa/Tripoli'),
(234, 'MA', 'Africa/Casablanca'),
(251, 'MR', 'Africa/Nouakchott'),
(284, 'OM', 'Asia/Muscat'),
(298, 'PS', 'Asia/Gaza'),
(299, 'PS', 'Asia/Hebron'),
(305, 'QA', 'Asia/Qatar'),
(337, 'SA', 'Asia/Riyadh'),
(340, 'SD', 'Africa/Khartoum'),
(350, 'SO', 'Africa/Mogadishu'),
(356, 'SY', 'Asia/Damascus'),
(367, 'TN', 'Africa/Tunis'),
(421, 'YE', 'Asia/Aden');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD KEY `admin_password_resets_email_index` (`email`),
  ADD KEY `admin_password_resets_token_index` (`token`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `advocate_clients`
--
ALTER TABLE `advocate_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_taxes`
--
ALTER TABLE `all_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_logs`
--
ALTER TABLE `case_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_members`
--
ALTER TABLE `case_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_parties_involves`
--
ALTER TABLE `case_parties_involves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_statuses`
--
ALTER TABLE `case_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_transfers`
--
ALTER TABLE `case_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_types`
--
ALTER TABLE `case_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_parties_invoives`
--
ALTER TABLE `client_parties_invoives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court_cases`
--
ALTER TABLE `court_cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court_types`
--
ALTER TABLE `court_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_items`
--
ALTER TABLE `expenses_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_cats`
--
ALTER TABLE `expense_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailsetups`
--
ALTER TABLE `mailsetups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`);

--
-- Indexes for table `payment_mades`
--
ALTER TABLE `payment_mades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_receiveds`
--
ALTER TABLE `payment_receiveds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_rel_type_index` (`rel_type`);

--
-- Indexes for table `task_members`
--
ALTER TABLE `task_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_members_task_id_foreign` (`task_id`),
  ADD KEY `task_members_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `idx_country_code` (`country_code`),
  ADD KEY `idx_zone_name` (`zone_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `advocate_clients`
--
ALTER TABLE `advocate_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `all_taxes`
--
ALTER TABLE `all_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `case_logs`
--
ALTER TABLE `case_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `case_members`
--
ALTER TABLE `case_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `case_parties_involves`
--
ALTER TABLE `case_parties_involves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `case_statuses`
--
ALTER TABLE `case_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `case_transfers`
--
ALTER TABLE `case_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `case_types`
--
ALTER TABLE `case_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41396;

--
-- AUTO_INCREMENT for table `client_parties_invoives`
--
ALTER TABLE `client_parties_invoives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `courts`
--
ALTER TABLE `courts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `court_cases`
--
ALTER TABLE `court_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `court_types`
--
ALTER TABLE `court_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses_items`
--
ALTER TABLE `expenses_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_cats`
--
ALTER TABLE `expense_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mailsetups`
--
ALTER TABLE `mailsetups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_mades`
--
ALTER TABLE `payment_mades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_receiveds`
--
ALTER TABLE `payment_receiveds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=728;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3805;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_members`
--
ALTER TABLE `task_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
