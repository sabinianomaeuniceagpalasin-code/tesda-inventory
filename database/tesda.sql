-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 04:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tesda`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_templates`
--

CREATE TABLE `chatbot_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `input_label` varchar(255) DEFAULT NULL,
  `input_type` varchar(255) NOT NULL DEFAULT 'text',
  `sql_query` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_templates`
--

INSERT INTO `chatbot_templates` (`id`, `category`, `template_name`, `input_label`, `input_type`, `sql_query`, `created_at`, `updated_at`) VALUES
(1, 'tools', 'Who was issued this item?', 'Enter Serial Number', 'serial_no', 'SELECT student_name, issued_date, form_type, reference_no\r\nFROM issued_log\r\nWHERE serial_no = :value\r\nORDER BY issued_date DESC\r\nLIMIT 1', NULL, NULL),
(2, 'tools', 'Show tool details', 'Enter Property No or Serial', 'property_or_serial', 'SELECT * FROM tools WHERE property_no = :value OR serial_no = :value LIMIT 1\r\n', NULL, NULL),
(3, 'students', 'Student borrowing history', 'Enter Student Number', 'student_number', 'SELECT student_name, serial_no, property_no, issued_date, return_date, reference_no\r\nFROM issued_log\r\nWHERE student_number = :value\r\nORDER BY issued_date DESC\r\nLIMIT 50\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issued_log`
--

CREATE TABLE `issued_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `property_no` varchar(50) DEFAULT NULL,
  `form_type` enum('ICS','PAR') NOT NULL,
  `issued_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_log`
--

INSERT INTO `issued_log` (`id`, `student_name`, `serial_no`, `property_no`, `form_type`, `issued_date`, `return_date`, `reference_no`) VALUES
(1, 'Cedric John Sadsad', 'SN0001', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00001'),
(2, 'Cedric John Sadsad', 'SN0002', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00001'),
(3, 'Cedric John Sadsad', 'SN0021', '00002', 'PAR', '2025-11-18', '2025-11-25', 'RFN-00002'),
(4, 'Cedric John Sadsad', 'SN0022', '00002', 'PAR', '2025-11-18', '2025-11-25', 'RFN-00002'),
(5, 'Cedric John Sadsad', 'SN0023', '00002', 'PAR', '2025-11-18', '2025-11-25', 'RFN-00002'),
(6, 'Cedric John Sadsad', 'SN0024', '00002', 'PAR', '2025-11-18', '2025-11-25', 'RFN-00002'),
(7, 'Cedric John Sadsad', 'SN0025', '00002', 'PAR', '2025-11-18', '2025-11-25', 'RFN-00002'),
(8, 'Cedric John Sadsad', 'SN0003', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(9, 'Cedric John Sadsad', 'SN0004', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(10, 'Cedric John Sadsad', 'SN0005', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(11, 'Cedric John Sadsad', 'SN0006', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(12, 'Cedric John Sadsad', 'SN0007', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(13, 'Cedric John Sadsad', 'SN0008', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(14, 'Cedric John Sadsad', 'SN0009', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00003'),
(15, 'Juan Dela Cruz', 'SN0010', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00004'),
(16, 'Juan Dela Cruz', 'SN0011', '00001', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00004'),
(17, 'Juan Dela Cruz', 'SN0041', '00003', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00005'),
(18, 'Juan Dela Cruz', 'SN0042', '00003', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00005'),
(19, 'Juan Dela Cruz', 'SN0043', '00003', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00005'),
(20, 'Juan Dela Cruz', 'SN0044', '00003', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00005'),
(21, 'Juan Dela Cruz', 'SN0045', '00003', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00005'),
(22, 'Cedric John Sadsad', 'SN0051', '00004', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00006'),
(23, 'Cedric John Sadsad', 'SN0052', '00004', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00006'),
(24, 'Cedric John Sadsad', 'SN0053', '00004', 'ICS', '2025-11-18', '2025-11-25', 'RFN-00006'),
(25, 'Juan Dela Cruz', 'SN0054', '00004', 'ICS', '2025-11-19', '2025-11-26', 'RFN-00007'),
(26, 'Juan Dela Cruz', 'SN0055', '00004', 'ICS', '2025-11-19', '2025-11-26', 'RFN-00007'),
(27, 'Juan Dela Cruz', 'SN0056', '00004', 'ICS', '2025-11-19', '2025-11-26', 'RFN-00007'),
(28, 'Jewel', 'SN0012', '00001', 'ICS', '2025-11-19', '2025-11-26', 'RFN-00008'),
(29, 'Jewel', 'SN0013', '00001', 'ICS', '2025-11-19', '2025-11-26', 'RFN-00008');

-- --------------------------------------------------------

--
-- Table structure for table `issued_summary`
--

CREATE TABLE `issued_summary` (
  `id` int(10) UNSIGNED NOT NULL,
  `form_type` varchar(100) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `item_count` int(11) DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT 'Issued',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reference_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_summary`
--

INSERT INTO `issued_summary` (`id`, `form_type`, `student_name`, `item_count`, `status`, `created_at`, `updated_at`, `reference_no`) VALUES
(1, 'ICS', 'Cedric John Sadsad', 2, 'Active', '2025-11-18 07:21:03', '2025-11-18 07:21:03', 'RFN-00001'),
(2, 'PAR', 'Cedric John Sadsad', 5, 'Active', '2025-11-18 07:22:31', '2025-11-18 07:22:31', 'RFN-00002'),
(3, 'ICS', 'Cedric John Sadsad', 7, 'Active', '2025-11-18 07:24:43', '2025-11-18 07:24:43', 'RFN-00003'),
(4, 'ICS', 'Juan Dela Cruz', 2, 'Active', '2025-11-18 08:03:13', '2025-11-18 08:03:13', 'RFN-00004'),
(5, 'ICS', 'Juan Dela Cruz', 5, 'Active', '2025-11-18 08:36:50', '2025-11-18 08:36:50', 'RFN-00005'),
(6, 'ICS', 'Cedric John Sadsad', 3, 'Active', '2025-11-18 10:25:30', '2025-11-18 10:25:30', 'RFN-00006'),
(7, 'ICS', 'Juan Dela Cruz', 3, 'Active', '2025-11-19 02:20:29', '2025-11-19 02:20:29', 'RFN-00007'),
(8, 'ICS', 'Jewel', 2, 'Active', '2025-11-19 06:41:39', '2025-11-19 06:41:39', 'RFN-00008');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_20_142328_create_chatbot_templates_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_inventory`
--

CREATE TABLE `property_inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_no` varchar(50) NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_inventory`
--

INSERT INTO `property_inventory` (`id`, `property_no`, `tool_name`, `quantity`, `unit_cost`, `updated_at`) VALUES
(1, '00001', 'PRINTER', 35, 15000.00, '2025-11-18 22:07:23'),
(2, '00002', 'COMPUTER', 20, 55000.00, '2025-11-17 23:19:25'),
(3, '00003', 'PHOTOCOPIER', 5, 20000.00, '2025-11-17 23:55:11'),
(4, '00004', 'AIRCON', 10, 20000.00, '2025-11-18 02:24:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GClpkstRnqawyUEhjJv9MmTNO7WoyAcxCJCv7s4b', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTjgwcXplU2Y0UU9RdE9qNW82dThXZ095bUlaREVqYVZqS3hTUkJzVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGF0Ym90L3RlbXBsYXRlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1763656186),
('sszgjDsnBvoggLzBldhwHooBTQs3ck0n9xTw9hbP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiclQzRFM4ODZXall6Q2pQamxDZXJYUzgxeDBtR2FUeDBFSHc1alI5QSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaXNzdWVkL3ZpZXcvUkZOLTAwMDA4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1763534517);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `batch` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_name`, `student_number`, `batch`) VALUES
(1, 'Cedric John Sadsad', '', NULL),
(4, 'Juan Dela Cruz', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `classification` varchar(255) NOT NULL,
  `source_of_fund` varchar(255) NOT NULL,
  `date_acquired` date NOT NULL,
  `property_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `stock` int(11) DEFAULT 1,
  `remarks` text DEFAULT NULL,
  `status` enum('Available','Borrowed','Issued','For Repair','Damaged','Lost') DEFAULT 'Available',
  `usage_count` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id`, `tool_name`, `classification`, `source_of_fund`, `date_acquired`, `property_no`, `serial_no`, `stock`, `remarks`, `status`, `usage_count`, `created_at`, `updated_at`) VALUES
(1, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0001', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:21:03'),
(2, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0002', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:21:03'),
(3, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0003', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(4, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0004', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(5, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0005', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(6, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0006', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(7, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0007', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(8, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0008', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(9, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0009', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-17 23:24:43'),
(10, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0010', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-18 00:03:13'),
(11, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0011', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-18 00:03:13'),
(12, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0012', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-18 22:41:39'),
(13, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0013', 1, 'TESDA QC', 'Issued', 1, '2025-11-17 23:18:03', '2025-11-18 22:41:39'),
(14, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0014', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(15, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0015', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(16, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0016', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(17, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0017', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(18, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0018', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(19, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0019', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(20, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0020', 1, 'TESDA QC', 'Available', NULL, '2025-11-17 23:18:03', '2025-11-17 23:18:03'),
(21, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0021', 1, 'SYSTEM UNIT TESDA QC', 'Issued', 1, '2025-11-17 23:19:25', '2025-11-17 23:22:31'),
(22, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0022', 1, 'SYSTEM UNIT TESDA QC', 'Issued', 1, '2025-11-17 23:19:25', '2025-11-17 23:22:31'),
(23, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0023', 1, 'SYSTEM UNIT TESDA QC', 'Issued', 1, '2025-11-17 23:19:25', '2025-11-17 23:22:31'),
(24, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0024', 1, 'SYSTEM UNIT TESDA QC', 'Issued', 1, '2025-11-17 23:19:25', '2025-11-17 23:22:31'),
(25, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0025', 1, 'SYSTEM UNIT TESDA QC', 'Issued', 1, '2025-11-17 23:19:25', '2025-11-17 23:22:31'),
(26, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0026', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(27, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0027', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(28, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0028', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(29, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0029', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(30, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0030', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(31, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0031', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(32, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0032', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(33, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0033', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(34, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0034', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(35, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0035', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(36, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0036', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(37, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0037', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(38, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0038', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(39, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0039', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(40, 'COMPUTER', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00002', 'SN0040', 1, 'SYSTEM UNIT TESDA QC', 'Available', NULL, '2025-11-17 23:19:25', '2025-11-17 23:19:25'),
(41, 'PHOTOCOPIER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00003', 'SN0041', 1, 'PHOTOCOPIER TESDA QC', 'Issued', 1, '2025-11-17 23:55:11', '2025-11-18 00:36:50'),
(42, 'PHOTOCOPIER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00003', 'SN0042', 1, 'PHOTOCOPIER TESDA QC', 'Issued', 1, '2025-11-17 23:55:11', '2025-11-18 00:36:50'),
(43, 'PHOTOCOPIER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00003', 'SN0043', 1, 'PHOTOCOPIER TESDA QC', 'Issued', 1, '2025-11-17 23:55:11', '2025-11-18 00:36:50'),
(44, 'PHOTOCOPIER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00003', 'SN0044', 1, 'PHOTOCOPIER TESDA QC', 'Issued', 1, '2025-11-17 23:55:11', '2025-11-18 00:36:50'),
(45, 'PHOTOCOPIER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00003', 'SN0045', 1, 'PHOTOCOPIER TESDA QC', 'Issued', 1, '2025-11-17 23:55:11', '2025-11-18 00:36:50'),
(46, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0046', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 02:23:09', '2025-11-18 02:23:09'),
(47, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0047', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 02:23:09', '2025-11-18 02:23:09'),
(48, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0048', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 02:23:09', '2025-11-18 02:23:09'),
(49, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0049', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 02:23:09', '2025-11-18 02:23:09'),
(50, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-18', '00001', 'SN0050', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 02:23:09', '2025-11-18 02:23:09'),
(51, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0051', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 02:25:30'),
(52, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0052', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 02:25:30'),
(53, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0053', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 02:25:30'),
(54, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0054', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 18:20:29'),
(55, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0055', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 18:20:29'),
(56, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0056', 1, 'AIRCON QC', 'Issued', 1, '2025-11-18 02:24:39', '2025-11-18 18:20:29'),
(57, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0057', 1, 'AIRCON QC', 'Available', NULL, '2025-11-18 02:24:39', '2025-11-18 02:24:39'),
(58, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0058', 1, 'AIRCON QC', 'Available', NULL, '2025-11-18 02:24:39', '2025-11-18 02:24:39'),
(59, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0059', 1, 'AIRCON QC', 'Available', NULL, '2025-11-18 02:24:39', '2025-11-18 02:24:39'),
(60, 'AIRCON', 'IT EQUIPMENT', 'CHED', '2025-11-18', '00004', 'SN0060', 1, 'AIRCON QC', 'Available', NULL, '2025-11-18 02:24:39', '2025-11-18 02:24:39'),
(61, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0061', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(62, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0062', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(63, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0063', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(64, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0064', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(65, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0065', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(66, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0066', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(67, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0067', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(68, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0068', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(69, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0069', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23'),
(70, 'PRINTER', 'IT EQUIPMENT', 'TESDA', '2025-11-19', '00001', 'SN0070', 1, 'PRINTER QC', 'Available', NULL, '2025-11-18 22:07:23', '2025-11-18 22:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `code_expires_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `contact_no`, `role`, `password`, `verification_code`, `is_verified`, `is_approved`, `code_expires_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cedric John P. Sadsad', 'sadsadcedric62@gmail.com', '09958705846', 'Property Custodian', '$2y$12$5TJsieZqioeNB3xBnzGs9.tB7ZmB87zN5LGatHnjNBwHKztYpYJGi', NULL, 1, 1, '2025-11-16 10:36:55', NULL, '2025-11-16 02:26:56', '2025-11-16 10:28:44'),
(2, 'CJ SADSAD', 'sadsad.cedricjohn.06182003@gmail.com', '09958705846', 'Property Custodian', '$2y$12$mad0g9JqSeQSmFYOimlKb.W.YVlh4JXOQVfmSJ2fDt4Ie3LUCBkTu', NULL, 1, 1, '2025-11-17 02:45:31', NULL, '2025-11-16 18:35:32', '2025-11-17 02:38:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatbot_templates`
--
ALTER TABLE `chatbot_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued_log`
--
ALTER TABLE `issued_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reference_serial` (`reference_no`,`serial_no`);

--
-- Indexes for table `issued_summary`
--
ALTER TABLE `issued_summary`
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
  ADD PRIMARY KEY (`email`,`token`);

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
-- AUTO_INCREMENT for table `chatbot_templates`
--
ALTER TABLE `chatbot_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `issued_log`
--
ALTER TABLE `issued_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `issued_summary`
--
ALTER TABLE `issued_summary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_inventory`
--
ALTER TABLE `property_inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
