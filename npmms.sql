-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 11:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12
USE NPMMS;
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
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `remarks` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `stall_no`, `name`, `age`, `address`, `applicant_name`, `stall_no2`, `applicant_age`, `applicant_address`, `tax_certificate_issued_location`, `tax_certificate_issued_date`, `sworn_at`, `email`, `contact`, `status`, `remarks`, `user_id`, `owner_id`) VALUES
(28, '22', 'kim', 12, 'Bayani', 'kim', '12', 12, 'Bayani', 'Bayani', '2023-08-01', '2023-07-18 07:18:28', 'kimjasper6670@gmail.com', '12', 'operated', 'Complete', NULL, NULL),
(29, '14', 'amore Evangelista', 23, 'Evangelista', 'amore Evangelista', '14', 23, 'Evangelista', 'Barcenaga', '2023-08-01', '2023-07-29 13:31:32', 'evangelistaamor24@gmail.com', '09665500165', 'operated', 'complete\r\n', NULL, NULL),
(30, '11', 'amore Evangelista', 22, 'Concepcion', 'amore Evangelista', '11', 22, 'Concepcion', 'Banuton', '2023-08-30', '2023-07-31 18:03:36', 'amore123@gmail.com', '09665500165', 'pending', 'good', NULL, NULL),
(31, '4', 'e', 12, 'Aurora', '12', '12', 12, 'Aurora', 'Buhangin', '2023-09-06', '2023-08-06 15:03:15', '12', '12', 'operated', 'hey', NULL, NULL),
(32, '18', 'amore Evangelista', 21, 'Barcenaga', 'amore Evangelista', '18', 21, 'Barcenaga', 'Concepcion', '2023-11-06', '2023-10-12 03:39:09', 'evangelistaamor24@gmail.com', '09665500165', 'operated', 'approved\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `available_stall`
--

CREATE TABLE `available_stall` (
  `stall_no` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `status` enum('available','unavailable') NOT NULL,
  `size` VARCHAR(100) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_stall`
--

INSERT INTO `available_stall` (`stall_no`, `section`, `status`, `image`) VALUES
(1, 'Corner Stall Dry Goods/Grocery', 'available', 'Stall_image/WIN_20230518_00_27_38_Pro.jpg'),
(3, 'Corner Stall in Grains Section', 'unavailable', 'Stall_image/WIN_20230518_00_27_37_Pro (2).jpg'),
(4, 'Restaurant/Fast Food Section', 'available', 'Stall_image/335611336_3529077580648854_6353160886967740027_n.jpg'),
(5, 'Fruits and Vegetables Section', 'unavailable', 'Stall_image/WIN_20230518_00_27_37_Pro (2).jpg'),
(6, 'Fish Section', 'available', 'Stall_image/Yellow Inspiration Modern Instagram Profile Picture.png'),
(7, 'Meat Section', 'unavailable', 'Stall_image/WIN_20230518_00_27_38_Pro.jpg'),
(8, 'Corner Stall Dry Goods/Grocery', 'available', 'Stall_image/sas.jpg'),
(9, 'Other Stall in Dry Goods, Grocery and Grains Section', 'available', 'Stall_image/1905356c-c2f1-41b6-a856-a97b09daf0ba.jpeg'),
(10, 'Corner Stall in Grains Section', 'unavailable', '../images/sas.jpg'),
(11, 'Restaurant/Fast Food Section', 'available', ''),
(12, 'Fruits and Vegetables Section', 'unavailable', ''),
(13, 'Fish Section', 'available', 'Stall_image/Untitled Project.jpg'),
(14, 'Meat Section', 'available', ''),
(15, 'Corner Stall Dry Goods/Grocery', 'available', '../images/WIN_20230518_00_27_38_Pro.jpg'),
(16, 'Other Stall in Dry Goods, Grocery and Grains Section', 'available', ''),
(17, 'Corner Stall in Grains Section', 'unavailable', ''),
(18, 'Restaurant/Fast Food Section', 'unavailable', ''),
(19, 'Fruits and Vegetables Section', 'unavailable', ''),
(20, 'Fish Section', 'available', 'Stall_image/333954375_525573453023085_891707169399339837_n.jpg'),
(21, 'Corner Stall Dry Goods/Grocery', 'available', '../images/WIN_20230518_00_27_39_Pro.jpg');

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

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(24, 'kim jasper Orbasayan', 'kimjasper6670@gmail.com', 'Please improve checking ', '2023-07-27 07:30:29'),
(25, 'kim Jasper Orbasayan', 'kimjasper667@gmail.com', 'San po kumukuha ng contract', '2023-08-01 21:02:34');

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
(17, 'New Pre-application submitted by. kim jasper Orbasayan', 1, '2023-07-27 13:25:10'),
(18, 'Payment received from kim for the amount of 16727 PHP. Reference Number: REF9ab11e20', 1, '2023-07-18 00:03:27'),
(19, 'New Pre-application submitted by. kim', 1, '2023-07-18 07:18:28'),
(20, 'New Pre-application submitted by. amore Evangelista', 1, '2023-07-29 13:31:32'),
(21, 'New Pre-application submitted by. amore Evangelista', 1, '2023-07-31 18:03:36'),
(22, 'New Feedback from kim Jasper Orbasayan<br> Message : San po kumukuha ng contract', 1, '2023-08-01 21:02:34'),
(23, 'New Pre-application submitted by. 12', 1, '2023-08-06 15:03:15'),
(24, 'Payment received from e for the amount of 8728 PHP. Reference Number: REFa3a5bbd8', 1, '2023-10-04 22:56:31'),
(25, 'New Pre-application submitted by. amore Evangelista', 1, '2023-10-12 03:39:09');

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
  `remarks` varchar(255) NOT NULL,
  `or_generated` varchar(255) NOT NULL,
  `stall_owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `account_name`, `transaction`, `date`, `status`, `amount`, `image`, `remarks`, `or_generated`, `stall_owner_id`) VALUES
(29, 'kim jasper Orbasayan', 'Payment', '2023-10-05', 'Pending', 8728, 'WIN_20230518_00_27_37_Pro.jpg', '', 'REF4da71f23', 41),
(30, 'kim jasper Orbasayan', 'Payment', '2023-10-05', 'Pending', 8728, 'WIN_20230518_00_27_37_Pro.jpg', '', 'REF3831a6a2', 41),
(31, 'kim jasper Orbasayan', 'Payment', '2023-10-05', 'Pending', 8728, 'WIN_20230518_00_27_37_Pro.jpg', '', 'REFa3a5bbd8', 41);

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
(4, 'LHOTA L. MASILANG', 'OIC', 'name');

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
  `product_category` varchar(50) NOT NULL
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

--
-- Dumping data for table `stall`
--

INSERT INTO `stall` (`stall_id`, `stall_number`, `stall_name`, `category`, `status`, `owner_id`) VALUES
(22, '4', 'kimmy', 'Restaurant/Fast Food Section', 'closed', 41);

-- --------------------------------------------------------

--
-- Table structure for table `stall_notifications`
--

CREATE TABLE `stall_notifications` (
  `id` int(11) NOT NULL,
  `stall_owner_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `notification_timestamp` datetime DEFAULT current_timestamp(),
  `notification_date` date DEFAULT NULL,
  `notification_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stall_notifications`
--

INSERT INTO `stall_notifications` (`id`, `stall_owner_id`, `subject`, `message`, `notification_timestamp`, `notification_date`, `notification_sent`) VALUES
(14, 39, 'Your Stall Has a Violation<br>Violation: aa<br>Description: sd', 'Your Stall Has a Violation<br>Violation: aa<br>Description: sd', '2023-08-02 13:03:19', '2023-08-02', 1),
(15, 39, 'Your Stall Has a Violation<br>Violation: aas<br>Description: ass', 'Your Stall Has a Violation<br>Violation: aas<br>Description: ass', '2023-08-02 14:26:43', '2023-08-02', 1),
(16, 39, 'Your Stall Has a Violation<br>Violation: aas<br>Description: D', 'Your Stall Has a Violation<br>Violation: aas<br>Description: D', '2023-08-02 14:37:51', '2023-08-02', 1),
(17, 39, 'Your Stall Has a Violation<br>Violation: aas<br>Description: SD', 'Your Stall Has a Violation<br>Violation: aas<br>Description: SD', '2023-08-02 14:45:02', '2023-08-02', 1),
(18, 40, 'Your Stall Has a Violation<br>Violation: aas<br>Description: d', 'Your Stall Has a Violation<br>Violation: aas<br>Description: d', '2023-08-02 17:41:19', '2023-08-02', 0),
(19, 39, 'Your Stall Has a Violation<br>Violation: sd<br>Description: sd', 'Your Stall Has a Violation<br>Violation: sd<br>Description: sd', '2023-08-02 17:41:41', '2023-08-02', 1),
(20, 39, 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-12$contr', 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-12$contract_end_date$contract_terms', '2023-08-02 18:08:38', '2023-08-02', 1),
(21, 39, 'Your Stall Has a Violation<br>Violation: s<br>Description: d', 'Your Stall Has a Violation<br>Violation: s<br>Description: d', '2023-08-03 06:18:46', '2023-08-03', 1),
(22, 39, 'Your Stall Has a Violation<br>Violation: Sample Violation Type<br>Description: s', 'Your Stall Has a Violation<br>Violation: Sample Violation Type<br>Description: s', '2023-08-03 06:19:59', '2023-08-03', 1),
(23, 39, 'Your Stall Has a Violation<br>Violation: kim<br>Description: kim', 'Your Stall Has a Violation<br>Violation: kim<br>Description: kim', '2023-08-03 06:21:54', '2023-08-03', 1),
(24, 39, 'Your Stall Has a Violation<br>Violation: Over Price<br>Description: sd', 'Your Stall Has a Violation<br>Violation: Over Price<br>Description: sd', '2023-08-03 06:22:18', '2023-08-03', 1),
(25, 39, 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-19$contr', 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-19$contract_end_date$contract_terms', '2023-08-03 06:26:06', '2023-08-03', 1),
(26, 39, 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-19$contr', 'Hi Stall Owner amore EvangelistaYour Contract details is here :<br>:Contract Start: 2023-08-19$contract_end_date$contract_terms', '2023-08-03 06:26:11', '2023-08-03', 1),
(27, 39, 'Stall Owner Termination Notification', 'Dear Stall Owner, your stall ownership has been closed.<br> Remarks: no update about application', '2023-08-08 22:00:20', NULL, 0),
(28, 40, 'Stall Owner Termination Notification', 'Dear Stall Owner,<br><br>We are writing to formally inform you that your stall ownership at Naujan Public Market has been terminated.<br><br>Reason for Termination: no update about application<br><br>If you have any questions or concerns regarding this decision, please do not hesitate to reach out to us. We value your presence at Naujan Public Market and appreciate your understanding in this matter.<br><br>Thank you for your cooperation.<br><br>Sincerely,<br>Naujan Public Market Team', '2023-08-08 22:03:12', NULL, 0),
(29, 41, 'Stall Owner Termination Notification', 'Dear Stall Owner, your stall ownership has been closed.<br> Remarks: ll', '2023-10-11 15:52:12', NULL, 0),
(30, 41, 'Stall Owner Termination Notification', 'Dear Stall Owner, your stall ownership has been closed.<br> Remarks: ll', '2023-10-11 15:52:15', NULL, 0);

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
(39, 14, 'amore Evangelista', 12, 'Evangelista', 'evangelistaamor24@gmail.com', '09665500165', 'closed', 176),
(40, 22, 'Kim Jasper Orbasayan', 12, 'Gutad, Calapan', 'kimjasper6670@gmail.com', '09665500165', 'terminate', 161),
(41, 4, 'e', 21, 'Aurora', 'kimjasper667@gmail.com', '190', 'closed', 177);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `profile`, `name`, `email`, `address`, `username`, `password`, `roles`, `designation`, `status`, `dateCreated`) VALUES
(159, '', 'Amore Evangelista', 'evangelistaamor24@gmail.com', 'Evangelista, naujan', 'amore', 'amore', 'admin', 'admin', 'Active', '2023-07-31 17:20:37'),
(160, '', 'kim Jasper Orbasayan', 'kimjasper667@gmail.com', 'Gutad , Calapan City', 'kim', 'kim', 'staff', 'Stall Manager', 'active', '2023-07-31 17:21:31'),
(161, 'profile/67469963_737082573388845_6461722393537675264_n.jpg', 'Kim Jasper Orbasayan', 'kimjasper6670@gmail.com', 'Gutad, Calapan', 'Kim jasper', '12345', 'admin', 'Administrator', 'active', NULL),
(176, '', 'amore Evangelista', 'evangelistaamor24@gmail.com', 'Evangelista', 'amore Evangelista', '11', 'stall_owner', 'Stall Owner', 'active', '2023-08-01 00:41:05'),
(177, '', 'e', '12', 'Aurora', 'e', 'yey', 'stall_owner', 'Stall Owner', 'closed', '2023-08-06 17:09:17'),
(178, '', 'kim', 'kimjasper6670@gmail.com', 'Bayani', 'kim', '1213', 'stall_owner', 'Stall Owner', 'active', '2023-08-08 15:48:39'),
(179, '', 'kim', 'kimjasper6670@gmail.com', 'Bayani', 'kim', '1213', 'stall_owner', 'Stall Owner', 'active', '2023-08-08 15:59:53'),
(180, '', 'amore Evangelista', 'evangelistaamor24@gmail.com', 'Barcenaga', 'amore Evangelista', 'root', 'stall_owner', 'Stall Owner', 'active', '2023-10-12 05:40:16'),
(181, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'active', NULL);

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

CREATE TABLE `transactions` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`months` varchar(15) NOT NULL,
	`salesCount` int(11) NOT NULL,
	`paidCount` int(11) NOT NULL,
	`unpaidCount` int(11) NOT NULL,
	`stallLeased` int(11) NOT NULL,
	`years` YEAR(4) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
	
INSERT INTO `transactions` (months, salesCount, paidCount, unpaidCount, stallLeased, years) VALUES ('January',0,0,0,0,2023),
('February',0,0,0,0,2023), ('March',0,0,0,0,2023), ('April',0,0,0,0,2023), ('May',0,0,0,0,2023),
('June',0,0,0,0,2023), ('July',0,0,0,0,2023), ('August',0,0,0,0,2023),('September',0,0,0,0,2023),
('October',0,0,0,0,2023), ('November',0,0,0,0,2023),('December',0,0,0,0,2023);

INSERT INTO `transactions` (months, salesCount, paidCount, unpaidCount, stallLeased, years) VALUES ('January',0,0,0,0,2024), 
('February',0,0,0,0,2024), ('March',0,0,0,0,2024), ('April',0,0,0,0,2024), ('May',0,0,0,0,2024), 
('June',0,0,0,0,2024), ('July',0,0,0,0,2024), ('August',0,0,0,0,2024),('September',0,0,0,0,2024),
('October',0,0,0,0,2024), ('November',0,0,0,0,2024),('December',0,0,0,0,2024);


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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `park_rent`
--
ALTER TABLE `park_rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `srp`
--
ALTER TABLE `srp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `stall`
--
ALTER TABLE `stall`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stall_notifications`
--
ALTER TABLE `stall_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stall_owner`
--
ALTER TABLE `stall_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `stall_owner_contract`
--
ALTER TABLE `stall_owner_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `violation`
--
ALTER TABLE `violation`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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

ALTER TABLE `applications`
	MODIFY `remarks` varchar(255) DEFAULT NULL;

ALTER TABLE `srp`
    MODIFY `product_category` varchar(50) DEFAULT NULL;
	
ALTER TABLE `payment_details`
	MODIFY  `remarks` varchar(255) DEFAULT NULL;

ALTER TABLE `stall_notifications`
	MODIFY `subject` varchar(255) NOT NULL;
	
ALTER TABLE `announcements`
	ADD COLUMN `status` VARCHAR(255) DEFAULT NULL;

ALTER TABLE `monthly_payment_details`
  ADD COLUMN `fullname` VARCHAR(255) DEFAULT NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
