-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2025 at 06:25 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tesda_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issued_log`
--

CREATE TABLE `issued_log` (
  `id` int NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `serial_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `property_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `form_type` enum('ICS','PAR') COLLATE utf8mb4_general_ci NOT NULL,
  `issued_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issued_summary`
--

CREATE TABLE `issued_summary` (
  `id` bigint NOT NULL,
  `property_no` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `item_count` int NOT NULL DEFAULT '1',
  `student_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `issued_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `form_type` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `reference_no` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Active','Archive') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `classification` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `source_of_fund` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_acquired` date NOT NULL,
  `property_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `serial_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int DEFAULT '1',
  `remarks` text COLLATE utf8mb4_general_ci,
  `status` enum('Available','Borrowed','Issued','For Repair','Damaged','Lost') COLLATE utf8mb4_general_ci DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-----------------------------------------

--
-- Table structure for table `maintenance_records`
--

CREATE TABLE `maintenance_records` (
  `id` int UNSIGNED NOT NULL,
  `property_no` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `issue_problem` text NOT NULL,
  `date_reported` date NOT NULL,
  `repair_cost` decimal(10,2) DEFAULT NULL,
  `expected_completion` date DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tokenable_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_inventory`
--

CREATE TABLE `property_inventory` (
  `id` int NOT NULL,
  `property_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `unit_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_inventory`
--

INSERT INTO `property_inventory` (`id`, `property_no`, `item_name`, `quantity`, `unit_cost`, `created_at`, `updated_at`) VALUES
(1, '00001', 'Printer', 10, '15000.00', NULL, '2025-11-14 20:19:38'),
(2, '00002', 'Photocopier', 25, '300.00', NULL, '2025-11-16 04:43:23');

-- --------------------------------------------------------

--

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_name`, `student_number`, `batch`, `created_at`, `updated_at`) VALUES
(1, 'Cedric John P. Sadsad', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_no` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verification_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_expires_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `is_approved` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `full_name`, `contact_no`, `role`, `verification_code`, `code_expires_at`, `is_verified`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, NULL, 'sadsadcedric62@gmail.com', NULL, '$2y$12$ogMH0sKg7TNo6i.Ju52Fz.9weP.5ZjlSa5bg6NA1ksVbMSBMUSf4u', NULL, 'Cedric John P. Sadsad', '09958705846', 'Property Custodian', NULL, NULL, 1, 1, '2025-11-14 20:17:28', '2025-11-16 04:41:34'),
(2, NULL, 'measabiniano@gmail.com', NULL, '$2y$12$1XyCqmNiWUP0m1OeqmXIPeE45S6Gjf6qY76qxiOuZW3q8SHpZmPJu', NULL, 'Eunice Sabiniano', '095672222176', 'Property Custodian', NULL, '2025-11-16 12:45:35', 1, 0, '2025-11-16 04:35:35', '2025-11-16 04:36:48');

--
-- Indexes for dumped tables
--



--
-- Indexes for table `issued_log`
--
ALTER TABLE `issued_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_issued_log_property` (`property_no`);

--
-- Indexes for table `issued_summary`
--
ALTER TABLE `issued_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_issued_summary_property` (`property_no`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_no` (`serial_no`),
  ADD KEY `fk_items_property` (`property_no`);

--
-- Indexes for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`id`);
-

--
-- Indexes for table `property_inventory`
--
ALTER TABLE `property_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_no` (`property_no`),
  ADD UNIQUE KEY `property_no_2` (`property_no`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


--
-- AUTO_INCREMENT for table `issued_log`
--
ALTER TABLE `issued_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `issued_summary`
--
ALTER TABLE `issued_summary`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `property_inventory`
--
ALTER TABLE `property_inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


-- Constraints for dumped tables
--

--
-- Constraints for table `issued_log`
--
ALTER TABLE `issued_log`
  ADD CONSTRAINT `fk_issued_log_property` FOREIGN KEY (`property_no`) REFERENCES `property_inventory` (`property_no`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `issued_summary`
--
ALTER TABLE `issued_summary`
  ADD CONSTRAINT `fk_issued_summary_property` FOREIGN KEY (`property_no`) REFERENCES `property_inventory` (`property_no`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_property` FOREIGN KEY (`property_no`) REFERENCES `property_inventory` (`property_no`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
