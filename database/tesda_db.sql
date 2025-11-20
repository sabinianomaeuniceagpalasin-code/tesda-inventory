-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 06:11 PM
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

--
-- Dumping data for table `issued_log`
--

INSERT INTO `issued_log` (`id`, `student_name`, `serial_no`, `property_no`, `form_type`, `issued_date`, `return_date`, `reference_no`, `created_at`, `updated_at`) VALUES
(3, 'Cedric John P. Sadsad', 'SN0001', '00001', 'PAR', '2025-11-15', '2025-11-29', 'SAMPLE1', '2025-11-14 23:36:04', '2025-11-14 23:36:04'),
(4, 'Cedric John P. Sadsad', 'SN0002', '00001', 'PAR', '2025-11-15', '2025-11-29', 'SAMPLE1', '2025-11-14 23:36:04', '2025-11-14 23:36:04');

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

--
-- Dumping data for table `issued_summary`
--

INSERT INTO `issued_summary` (`id`, `property_no`, `item_count`, `student_name`, `issued_by`, `form_type`, `reference_no`, `status`, `created_at`, `updated_at`) VALUES
(1, '00001', 2, 'Cedric John P. Sadsad', '', 'PAR', '1', 'Active', '2025-11-14 23:36:04', '2025-11-18 16:22:41');

-- --------------------------------------------------------

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
  `tool_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `unit_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_inventory`
--

INSERT INTO `property_inventory` (`id`, `property_no`, `tool_name`, `quantity`, `unit_cost`, `created_at`, `updated_at`) VALUES
(1, '00001', 'Printer', 10, '15000.00', NULL, '2025-11-14 20:19:38'),
(2, '00002', 'Photocopier', 25, '300.00', NULL, '2025-11-16 04:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('c35kNVTLoHX8J9xGsQGXPr192iVo4yMbJ7dXKjPX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVg3d3Qxc0N6QzZESzNYbnYxbGQzWmdPeUtIQW9KYWZyRDVHQ1NQcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1763585677),
('cJb7ZcKL1xbIjqLoYsI3SmeMmK0AQVPbyaJ6qxph', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1czaUdMczQ1UFVIWHRxendmeFlVb3NNU0I1NWNsQXZ0UkpHYk8yNyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763624796),
('TRfCJlpZBKNy7CSWaPLt2We5PH7KfflFHOkLDZW8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFhqd3JWWlh6NEs1d25ZRldld2E3eUN4UXllMjZMdHhsRGxkMTZrNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1763639190),
('wO1uIzhNKXenUsiMwtfywmQOvY8WgHl2cDgSAxXd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWE94enYxSXFNSXFLSWFhR2FJQk82aklSRWo0Y3c2QkhyVEVTZUx3YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1763660153);

-- --------------------------------------------------------

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
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id` int NOT NULL,
  `tool_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id`, `tool_name`, `classification`, `source_of_fund`, `date_acquired`, `property_no`, `serial_no`, `stock`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0001', 1, 'SAMPLE DATA', 'Issued', '2025-11-14 20:19:38', '2025-11-14 23:36:04'),
(2, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0002', 1, 'SAMPLE DATA', 'Issued', '2025-11-14 20:19:38', '2025-11-14 23:36:04'),
(3, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0003', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(4, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0004', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(5, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0005', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(6, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0006', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(7, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0007', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(8, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0008', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(9, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0009', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(10, 'Printer', 'IT EQUIPMENT', 'DPWH', '2025-11-15', '00001', 'SN0010', 1, 'SAMPLE DATA', 'Available', '2025-11-14 20:19:38', '2025-11-14 20:19:38'),
(13, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0011', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(14, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0012', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(15, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0013', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(16, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0014', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(17, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0015', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(18, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0016', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(19, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0017', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(20, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0018', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(21, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0019', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(22, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0020', 1, 'SAMPLE1', 'Available', '2025-11-14 23:16:06', '2025-11-14 23:16:06'),
(23, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0021', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(24, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0022', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(25, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0023', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(26, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0024', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(27, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0025', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(28, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0026', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(29, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0027', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(30, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0028', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(31, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0029', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(32, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0030', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(33, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0031', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(34, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0032', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(35, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0033', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(36, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0034', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23'),
(37, 'Photocopier', 'OFFICE EQUIPMENT', 'TESDA', '2025-11-15', '00002', 'SN0035', 1, 'SAMPLE1', 'Available', '2025-11-16 04:43:23', '2025-11-16 04:43:23');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued_log`
--
ALTER TABLE `issued_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued_summary`
--
ALTER TABLE `issued_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `property_inventory`
--
ALTER TABLE `property_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_no` (`property_no`);

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
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_no` (`serial_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
