-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 02:55 PM
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
-- Database: `makendsc_decor`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `session_details` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `activity` varchar(55) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `username`, `session_details`, `ip`, `activity`, `timestamp`) VALUES
(57, 'admin', 'a:3:{i:0;s:80:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0\";i:1;O:8:\"stdClass\":30:{s:18:\"browser_name_regex\";s:6:\"~^.*$~\";s:20:\"browser_name_pattern\";s:1:\"*\";s:7:\"browser\";s:15:\"Default Browser\";s:7:\"version\";s:1:\"0\";s', '127.0.0.1', 'Login', '2024-03-02 12:35:29'),
(58, 'admin', 'a:3:{i:0;s:80:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0\";i:1;O:8:\"stdClass\":30:{s:18:\"browser_name_regex\";s:6:\"~^.*$~\";s:20:\"browser_name_pattern\";s:1:\"*\";s:7:\"browser\";s:15:\"Default Browser\";s:7:\"version\";s:1:\"0\";s', '127.0.0.1', 'Login', '2024-03-04 08:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_meta` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `admin_meta`, `date_time`) VALUES
(1, 'admin', 'admin@admin.com', 'admin@123', '', '2024-03-02 12:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `entity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `options` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `field_id`, `priority`, `entity_type`, `entity_id`, `label`, `name`, `type`, `options`, `created_at`) VALUES
(40, 7, 0, 'theam', 'field_1709800426752', 'Product', 'product', 'sidebarListParent', '', '2024-03-07 08:34:53'),
(43, 9, 12, 'product', 'field_1709805318124', 'Show Logo', 'show_logo', 'radio', 'true:Show\nfalse:Hide', '2024-03-07 09:56:12'),
(44, 9, 0, 'product', 'field_1709805541790', 'Product Title', 'product_title', 'text', '', '2024-03-07 09:59:11'),
(45, 9, 1, 'product', 'field_1709805559634', 'SR. No', 'serial_number', 'number', '', '2024-03-07 10:00:27'),
(47, 9, 4, 'product', 'field_1709805699193', 'Shade', 'shade', 'text', '', '2024-03-07 10:07:23'),
(48, 9, 8, 'product', 'field_1709805783727', 'Wash care Icons', 'wash_care', 'checkbox', 'bucket:Bucket\niron:Iron\np:P', '2024-03-07 10:07:23'),
(49, 9, 9, 'product', 'field_1709805786993', 'End use', 'end_use', 'text', '', '2024-03-07 10:07:23'),
(50, 9, 6, 'product', 'field_1709805749247', 'Weight (GSM)', 'weight', 'number', '', '2024-03-07 10:07:23'),
(51, 9, 5, 'product', 'field_1709805710907', 'Composition', 'composition', 'text', '', '2024-03-07 10:07:23'),
(52, 9, 3, 'product', 'field_1709805677564', 'Quality', 'quality', 'text', '', '2024-03-07 10:07:23'),
(53, 9, 10, 'product', 'field_1709805787643', 'message', 'message', 'text', '', '2024-03-07 10:07:23'),
(54, 9, 11, 'product', 'field_1709806024842', 'Qr Code url', 'qr_code', 'text', '', '2024-03-07 10:07:23'),
(57, 9, 2, 'product', 'field_1710094455810', 'Price Code', 'price_code', 'text', '', '2024-03-10 18:14:32'),
(58, 9, 7, 'product', 'field_1710095064526', 'width (CM)', 'width', 'number', '', '2024-03-10 18:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `data_meta`
--

CREATE TABLE `data_meta` (
  `id` int(11) NOT NULL,
  `field_ID` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`meta_value`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `data_meta`
--

INSERT INTO `data_meta` (`id`, `field_ID`, `meta_key`, `meta_value`) VALUES
(1, '', 'product', '{\"product_title\":\"Classic Sheers\",\"serial_number\":\"28\",\"price_code\":\"B\",\"quality\":\"Sheer SRD 75051P\",\"shade\":\"66582\",\"composition\":\"100% Polyester\",\"weight\":\"73\",\"width\":\"140\",\"wash_care-bucket\":\"bucket\",\"wash_care-iron\":\"iron\",\"end_use\":\"ICON\",\"message\":\"Alos available in Flame Retardent (NFPA 710)\",\"qr_code\":\"https://makends.com\",\"show_logo\":\"true\"}'),
(2, '', 'product', '{\"product_title\":\"Test product\",\"serial_number\":\"2\",\"price_code\":\"C\",\"quality\":\"Classic bloom 902G41\",\"shade\":\"pink\",\"composition\":\"80% polyster, 20%cotton\",\"weight\":\"30\",\"width\":\"79\",\"wash_care-bucket\":\"bucket\",\"wash_care-iron\":\"iron\",\"end_use\":\"ICON NONE\",\"message\":\"Not available in Flame Retardent (GC308 710)\",\"qr_code\":\"www.google.com\",\"show_logo\":\"false\"}');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `name`, `label`) VALUES
(7, 'theam', 'Theam'),
(9, 'product', 'Product');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_data` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `modalNumber` varchar(55) NOT NULL,
  `hsnCode` int(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `product_meta` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `modalNumber`, `hsnCode`, `name`, `description`, `product_meta`, `price`, `quantity`, `date_added`) VALUES
(2, '23', 233, 'name', 'Desc', NULL, '30.00', 20, '2024-03-04 07:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(350) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `password` varchar(255) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_entity_id` (`entity_id`),
  ADD KEY `custom_fields_ibfk_1` (`field_id`);

--
-- Indexes for table `data_meta`
--
ALTER TABLE `data_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `data_meta`
--
ALTER TABLE `data_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD CONSTRAINT `custom_fields_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
