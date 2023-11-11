-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 04:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npmms`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `description` varchar(555) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `Title`, `description`, `image`) VALUES
(16, 'Our Mission', '  Our mission is to provide a safe, clean, and organized market space that meets the needs of both vendors and\r\n            customers alike. We are committed to promoting fair trade, supporting local entrepreneurship, and enhancing\r\n            the overall economic well-being of Naujan..', ''),
(17, 'Our Vision', ' At Naujan Public Market, we strive to create an inclusive and sustainable marketplace that serves as a\r\n            catalyst for economic growth and fosters a sense of pride and unity within our community. We envision a\r\n            thriving marketplace where local businesses flourish, residents find a wide array of quality products, and\r\n            visitors experience the vibrant culture of Naujan.', ''),
(18, 'intro', '   Welcome to the official website of Naujan Public Market! We are thrilled to share with you the vibrant and\r\n            bustling hub of commerce and community that lies at the heart of Naujan, a beautiful municipality nestled\r\n            in the province of Oriental Mindoro, Philippines\r\n', ''),
(19, 'front-introduction', 'Malugod kong pagbati sa inyo sa inyong pagbisita sa Naujan Public Market! Isang mainit na paglalakbay sa mga tunay na kulay at kahanga-hangang karanasan ng ating lokal na pamilihan. Dito sa Naujan Public Market, inyong matatagpuan ang sari-saring mga produkto, sariwang prutas, gulay, isda, at iba pang mga lokal na kagamitan..', ''),
(20, 'address', 'Naujan Public Market, Poblacion, Naujan, Oriental Mindoro, Philippines..', NULL),
(21, 'Contacts', 'Phone: 09665500165\r\n\r\nEmail: info@naujanpublicmarket.com\r\nWebsite: Naujan-Public-Market-ms.com', NULL),
(22, 'Vendor Inquiries', 'Interested in becoming a vendor at Naujan Public Market? Join our dynamic community! For inquiries about vendor opportunities, please contact our Vendor Relations department', NULL),
(23, 'Customer Fedback', 'We highly value your feedback as it helps us improve our services and better meet your needs. If you have any suggestions, comments, or concerns, please let us know..', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `post_date`, `image`, `status`) VALUES
(57, 'Kim Jasper Orbasayan', 'a', '2023-11-11 00:47:28', '../images/654f31907feee_GOMCAM 20230323_1646280577.png', 'hidden'),
(58, 'Kim Jasper Orbasayan', 'as', '2023-11-11 01:24:25', '../images/654f3a3966324_GOMCAM 20230320_1421310726.png', 'hidden'),
(59, '1', 'a', '2023-11-11 01:42:33', '../images/654f3e7912f00_GOMCAM 20230320_1421310726.png', 'posted');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `stall_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `stall_no2` varchar(255) NOT NULL,
  `applicant_age` int(11) NOT NULL,
  `applicant_address` varchar(255) NOT NULL,
  `tax_certificate_issued_location` varchar(255) NOT NULL,
  `tax_certificate_issued_date` date NOT NULL,
  `sworn_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `stall_no`, `name`, `age`, `address`, `applicant_name`, `stall_no2`, `applicant_age`, `applicant_address`, `tax_certificate_issued_location`, `tax_certificate_issued_date`, `sworn_at`, `email`, `contact`, `status`, `remarks`, `user_id`, `owner_id`) VALUES
(36, '15', 'Orbasayana', 22, 'Concepcion', 'Kim jasper Orbasayan', '15', 22, 'Concepcion', 'Concepcion', '2023-11-11', '2023-11-11 06:13:53', 'kimjasper6670@gmail.com', '09665500165', 'operated', 'Complete Requirements for Leased', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `available_stall`
--

CREATE TABLE `available_stall` (
  `stall_no` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `status` enum('available','unavailable') NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_stall`
--

INSERT INTO `available_stall` (`stall_no`, `section`, `status`, `size`, `image`) VALUES
(1, 'Corner Stall Dry Goods/Grocery', 'available', NULL, 'Stall_image/WIN_20230518_00_27_38_Pro.jpg'),
(3, 'Corner Stall in Grains Section', 'unavailable', NULL, 'Stall_image/WIN_20230518_00_27_37_Pro (2).jpg'),
(4, 'Restaurant/Fast Food Section', 'available', NULL, 'Stall_image/335611336_3529077580648854_6353160886967740027_n.jpg'),
(5, 'Fruits and Vegetables Section', 'unavailable', NULL, 'Stall_image/WIN_20230518_00_27_37_Pro (2).jpg'),
(6, 'Fish Section', 'available', NULL, 'Stall_image/Yellow Inspiration Modern Instagram Profile Picture.png'),
(7, 'Meat Section', 'unavailable', NULL, 'Stall_image/WIN_20230518_00_27_38_Pro.jpg'),
(8, 'Corner Stall Dry Goods/Grocery', 'available', NULL, 'Stall_image/sas.jpg'),
(9, 'Other Stall in Dry Goods, Grocery and Grains Section', 'available', NULL, 'Stall_image/1905356c-c2f1-41b6-a856-a97b09daf0ba.jpeg'),
(10, 'Corner Stall in Grains Section', 'unavailable', '6347', 'Stall_image/sample report.jpg'),
(11, 'Restaurant/Fast Food Section', 'unavailable', NULL, ''),
(12, 'Fruits and Vegetables Section', 'unavailable', NULL, ''),
(13, 'Fish Section', 'available', NULL, 'Stall_image/Untitled Project.jpg'),
(14, 'Meat Section', 'available', NULL, ''),
(15, 'Corner Stall Dry Goods/Grocery', 'unavailable', NULL, '../images/WIN_20230518_00_27_38_Pro.jpg'),
(16, 'Other Stall in Dry Goods, Grocery and Grains Section', 'available', NULL, ''),
(17, 'Corner Stall in Grains Section', 'unavailable', NULL, ''),
(18, 'Restaurant/Fast Food Section', 'unavailable', NULL, ''),
(19, 'Fruits and Vegetables Section', 'unavailable', NULL, ''),
(20, 'Fish Section', 'available', NULL, 'Stall_image/333954375_525573453023085_891707169399339837_n.jpg'),
(21, 'Corner Stall Dry Goods/Grocery', 'available', NULL, '../images/WIN_20230518_00_27_39_Pro.jpg'),
(56, 'Corner Stall in Grains Section', 'available', '3923', 'Stall_image/Capture.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `payment_due` date DEFAULT NULL,
  `notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_notif_stall`
--

CREATE TABLE `general_notif_stall` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `maintenance_type` varchar(200) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `description` text NOT NULL,
  `status` varchar(250) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_payment_details`
--

CREATE TABLE `monthly_payment_details` (
  `id` int(11) NOT NULL,
  `monthly_rental` decimal(10,2) DEFAULT NULL,
  `extension_rental` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `stall_extension_fee` decimal(10,2) DEFAULT NULL,
  `penalty_25` decimal(10,2) DEFAULT NULL,
  `interest_2` decimal(10,2) DEFAULT NULL,
  `or_no` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `read_status`, `created_at`) VALUES
(30, 'New Pre-application submitted by. Kim jasper Orbasayan', 1, '2023-11-11 06:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `park_rent`
--

CREATE TABLE `park_rent` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `plate_no` varchar(10) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `time_out` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `or_generated` varchar(255) NOT NULL,
  `stall_owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `receipt_no` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder_log`
--

CREATE TABLE `reminder_log` (
  `id` int(11) NOT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `reminder_date` datetime DEFAULT NULL,
  `email_sent` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `content`, `title`, `type`) VALUES
(1, 'HON. HENRY JOEL C. TEVES', 'mayor', 'leese'),
(2, 'HON. HENRY JOEL C. TEVES', 'LESSEE', 'LESSEE'),
(3, 'JAY MARK Y. BACAY', 'admin', 'name'),
(4, 'LHOTA L. MASILANG', 'OIC', 'name'),
(5, 'recipient_payment/sample.jpeg', 'Payment', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `srp`
--

CREATE TABLE `srp` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stall`
--

CREATE TABLE `stall` (
  `stall_id` int(11) NOT NULL,
  `stall_number` varchar(50) DEFAULT NULL,
  `stall_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stall_notifications`
--

CREATE TABLE `stall_notifications` (
  `id` int(11) NOT NULL,
  `stall_owner_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `notification_timestamp` datetime DEFAULT current_timestamp(),
  `notification_date` date DEFAULT NULL,
  `notification_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stall_notifications`
--

INSERT INTO `stall_notifications` (`id`, `stall_owner_id`, `subject`, `message`, `notification_timestamp`, `notification_date`, `notification_sent`) VALUES
(33, 85, 'Your Stall Has a Violation<br>Violation: aas<br>Description: as', 'Your Stall Has a Violation<br>Violation: aas<br>Description: as', '2023-11-11 07:21:21', '2023-11-11', 1),
(34, 85, 'Your Stall Has a Violation<br>Violation: sd<br>Description: a', 'Your Stall Has a Violation<br>Violation: sd<br>Description: a', '2023-11-11 07:21:33', '2023-11-11', 1),
(35, 85, 'Hi Stall Owner OrbasayanaYour Contract details is here :<br>:Contract Start: 2023-11-11<br>Contract end date: 2025-10-11<br>Contract terms: All be must be Ssttled', 'Hi Stall Owner OrbasayanaYour Contract details is here :<br>:Contract Start: 2023-11-11<br>Contract end date: 2025-10-11<br>Contract terms: All be must be Ssttled', '2023-11-11 07:22:21', '2023-11-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stall_owner`
--

CREATE TABLE `stall_owner` (
  `id` int(11) NOT NULL,
  `stall_no` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stall_owner`
--

INSERT INTO `stall_owner` (`id`, `stall_no`, `name`, `age`, `address`, `email`, `contact`, `status`, `user_id`) VALUES
(85, 15, 'Orbasayana', 22, 'Concepcion', 'kimjasper6670@gmail.com', '09665500165', 'operate', 203);

-- --------------------------------------------------------

--
-- Table structure for table `stall_owner_contract`
--

CREATE TABLE `stall_owner_contract` (
  `id` int(11) NOT NULL,
  `stall_owner_id` int(11) DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `contract_start_date` date DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `contract_terms` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stall_owner_contract`
--

INSERT INTO `stall_owner_contract` (`id`, `stall_owner_id`, `contract_date`, `contract_start_date`, `contract_end_date`, `contract_terms`) VALUES
(41, 85, '2023-11-11', '2023-11-11', '2025-10-11', 'All be must be Ssttled');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `months` varchar(15) NOT NULL,
  `salesCount` int(11) NOT NULL,
  `paidCount` int(11) NOT NULL,
  `unpaidCount` int(11) NOT NULL,
  `stallLeased` int(11) NOT NULL,
  `years` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `months`, `salesCount`, `paidCount`, `unpaidCount`, `stallLeased`, `years`) VALUES
(1, 'January', 0, 0, 0, 0, 2023),
(2, 'February', 0, 0, 0, 0, 2023),
(3, 'March', 0, 0, 0, 0, 2023),
(4, 'April', 0, 0, 0, 0, 2023),
(5, 'May', 0, 0, 0, 0, 2023),
(6, 'June', 0, 0, 0, 0, 2023),
(7, 'July', 0, 0, 0, 0, 2023),
(8, 'August', 0, 0, 0, 0, 2023),
(9, 'September', 0, 0, 0, 0, 2023),
(10, 'October', 0, 0, 0, 0, 2023),
(11, 'November', 0, 0, 3, 0, 2023),
(12, 'December', 0, 0, 0, 0, 2023),
(13, 'January', 0, 0, 0, 0, 2024),
(14, 'February', 0, 0, 0, 0, 2024),
(15, 'March', 0, 0, 0, 0, 2024),
(16, 'April', 0, 0, 0, 0, 2024),
(17, 'May', 0, 0, 0, 0, 2024),
(18, 'June', 0, 0, 0, 0, 2024),
(19, 'July', 0, 0, 0, 0, 2024),
(20, 'August', 0, 0, 0, 0, 2024),
(21, 'September', 0, 0, 0, 0, 2024),
(22, 'October', 0, 0, 0, 0, 2024),
(23, 'November', 0, 0, 3, 0, 2024),
(24, 'December', 0, 0, 0, 0, 2024),
(25, 'January', 0, 0, 0, 0, 2023),
(26, 'February', 0, 0, 0, 0, 2023),
(27, 'March', 0, 0, 0, 0, 2023),
(28, 'April', 0, 0, 0, 0, 2023),
(29, 'May', 0, 0, 0, 0, 2023),
(30, 'June', 0, 0, 0, 0, 2023),
(31, 'July', 0, 0, 0, 0, 2023),
(32, 'August', 0, 0, 0, 0, 2023),
(33, 'September', 0, 0, 0, 0, 2023),
(34, 'October', 0, 0, 0, 0, 2023),
(35, 'November', 0, 0, 3, 0, 2023),
(36, 'December', 0, 0, 0, 0, 2023),
(37, 'January', 0, 0, 0, 0, 2024),
(38, 'February', 0, 0, 0, 0, 2024),
(39, 'March', 0, 0, 0, 0, 2024),
(40, 'April', 0, 0, 0, 0, 2024),
(41, 'May', 0, 0, 0, 0, 2024),
(42, 'June', 0, 0, 0, 0, 2024),
(43, 'July', 0, 0, 0, 0, 2024),
(44, 'August', 0, 0, 0, 0, 2024),
(45, 'September', 0, 0, 0, 0, 2024),
(46, 'October', 0, 0, 0, 0, 2024),
(47, 'November', 0, 0, 3, 0, 2024),
(48, 'December', 0, 0, 0, 0, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `roles` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `profile`, `name`, `email`, `address`, `username`, `password`, `roles`, `designation`, `status`, `dateCreated`) VALUES
(159, '', 'Amore Evangelistaa', 'evangelistaamor24@gmail.com', 'Evangelista, naujan', 'amore', 'amore', 'admin', 'admin', 'active', '2023-07-31 17:20:37'),
(203, NULL, 'Orbasayana', 'kimjasper6670@gmail.com', 'Concepcion', 'Orbasayana', 'stall', 'stall_owner', 'Stall Owner', 'active', '2023-11-11 07:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `violation`
--

CREATE TABLE `violation` (
  `violation_id` int(11) NOT NULL,
  `violation_type` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stall_owner_id` int(11) DEFAULT NULL,
  `violation_date` date DEFAULT NULL,
  `stall_number` int(11) NOT NULL,
  `appeal` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `remediation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violation`
--

INSERT INTO `violation` (`violation_id`, `violation_type`, `description`, `stall_owner_id`, `violation_date`, `stall_number`, `appeal`, `remarks`, `remediation`) VALUES
(31, 'aas', 'as', 85, '2023-11-11', 15, NULL, '', ''),
(32, 'sd', 'a', 85, '2023-11-11', 15, NULL, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_applications_user` (`user_id`),
  ADD KEY `FK_applications_stall_owner` (`owner_id`);

--
-- Indexes for table `available_stall`
--
ALTER TABLE `available_stall`
  ADD PRIMARY KEY (`stall_no`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_notif_stall`
--
ALTER TABLE `general_notif_stall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `park_rent`
--
ALTER TABLE `park_rent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stall_owner` (`stall_owner_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `reminder_log`
--
ALTER TABLE `reminder_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srp`
--
ALTER TABLE `srp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stall`
--
ALTER TABLE `stall`
  ADD PRIMARY KEY (`stall_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `stall_notifications`
--
ALTER TABLE `stall_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stall_owner_id` (`stall_owner_id`);

--
-- Indexes for table `stall_owner`
--
ALTER TABLE `stall_owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stall_owner_contract`
--
ALTER TABLE `stall_owner_contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stall_owner_id` (`stall_owner_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `violation`
--
ALTER TABLE `violation`
  ADD PRIMARY KEY (`violation_id`),
  ADD KEY `stall_owner_id` (`stall_owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `general_notif_stall`
--
ALTER TABLE `general_notif_stall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `park_rent`
--
ALTER TABLE `park_rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminder_log`
--
ALTER TABLE `reminder_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `srp`
--
ALTER TABLE `srp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `stall`
--
ALTER TABLE `stall`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `stall_notifications`
--
ALTER TABLE `stall_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `stall_owner`
--
ALTER TABLE `stall_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `stall_owner_contract`
--
ALTER TABLE `stall_owner_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `violation`
--
ALTER TABLE `violation`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `FK_applications_stall_owner` FOREIGN KEY (`owner_id`) REFERENCES `monthly_payment_details` (`id`),
  ADD CONSTRAINT `FK_applications_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  ADD CONSTRAINT `monthly_payment_details_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `stall_owner` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `fk_stall_owner` FOREIGN KEY (`stall_owner_id`) REFERENCES `stall_owner` (`id`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `stall_owner` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stall`
--
ALTER TABLE `stall`
  ADD CONSTRAINT `stall_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `stall_owner` (`id`);

--
-- Constraints for table `stall_notifications`
--
ALTER TABLE `stall_notifications`
  ADD CONSTRAINT `stall_notifications_ibfk_1` FOREIGN KEY (`stall_owner_id`) REFERENCES `stall_owner` (`id`);

--
-- Constraints for table `stall_owner`
--
ALTER TABLE `stall_owner`
  ADD CONSTRAINT `stall_owner_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `stall_owner_contract`
--
ALTER TABLE `stall_owner_contract`
  ADD CONSTRAINT `stall_owner_contract_ibfk_1` FOREIGN KEY (`stall_owner_id`) REFERENCES `stall_owner` (`id`);

--
-- Constraints for table `violation`
--
ALTER TABLE `violation`
  ADD CONSTRAINT `violation_ibfk_1` FOREIGN KEY (`stall_owner_id`) REFERENCES `stall_owner` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
