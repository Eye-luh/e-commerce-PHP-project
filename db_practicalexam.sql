-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 07:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_practicalexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `categoryName` varchar(250) DEFAULT NULL,
  `categoryDesc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `categoryName`, `categoryDesc`) VALUES
(40, 'Men\'s Shoes', 'formal polished black leather shoes'),
(41, 'Men\'s Shoes', 'Chestnut Brown Derby'),
(42, 'Men\'s Shoes', 'breathable perforated leather upper'),
(43, 'Women\'s Shoes', 'premium tan leather finish loafer'),
(44, 'Women\'s Shoes', 'Black Leather Chelsea Boots'),
(45, 'Men\'s Slipper', 'after-sport o casual use'),
(46, 'Men\'s Slipper', 'flip-flops'),
(47, 'Women\'s Slipper', 'floral-patterned slides'),
(48, 'Men\'s Shoes', 'black performance running shoes'),
(49, 'Women\'s Shoes', 'gold & white lifestyle sneakers'),
(50, 'Women\'s Shirt', 'Women\'s Sports Shirt'),
(51, 'Men\'s Shirt', 'classic black cotton t-shirt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customerID` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `bday` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customerID`, `fullname`, `email`, `phone`, `address`, `bday`, `user_id`, `created_at`) VALUES
(1, 'Rejallejon', 'RMRUFIN@gmail.com', '09123123123', '', '2025-12-24', 8, '2025-12-14 11:23:58'),
(2, 'aila', 'MAN@gmail.com', '09632578545', 'Merida', '2004-06-26', 16, '2025-12-18 16:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('active','purchased','removed') DEFAULT 'active',
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_name`, `price`, `quantity`, `category_id`, `image_path`) VALUES
(32, 'Classic Men\'s Formal Oxford - Midnight Black', 5000.00, 20, 40, 'uploads/1766078751_1766019383_formal1.jpg'),
(33, 'Modern Executive Derby - Chestnut Brown', 5000.00, 18, 40, 'uploads/1766078889_1766019429_formal2.jpg'),
(34, 'Men’s Urban Comfort Hybrid Sneaker', 3999.00, 36, 40, 'uploads/1766079536_1766019682_casual1.jpg'),
(36, 'Women’s Classic Heritage Loafer', 4555.00, 34, 43, 'uploads/1766080153_1766019723_casual2.jpg'),
(37, 'Urban Explorer Black Chelsea Boots', 6222.00, 27, 43, 'uploads/1766080278_1766019751_boots1.jpg'),
(38, 'Performance Comfort Sport Slides', 399.00, 56, 45, 'uploads/1766080374_1766019817_sandals1.jpg'),
(39, 'Beach Ready Lightweight Flip-Flops', 299.00, 52, 45, 'uploads/1766080455_1766019858_sandals2.jpg'),
(40, 'Adidas Adilette Comfort Floral Slides', 399.00, 41, 47, 'uploads/1766080600_SSS2_ADHQ8848_4066748622726_1.jpg'),
(41, 'Nike Air Zoom Pegasus Performance', 599.00, 53, 40, 'uploads/1766080797_1766019935_sports1.jpg'),
(42, 'Adidas Superstar White & Gold Edition', 2888.00, 28, 43, 'uploads/1766080916_1_686262_ZM_SSHERO.jpg'),
(43, 'Adidas Originals Women\'s Cropped Sport Top', 1999.00, 43, 50, 'uploads/1766081116_adidas---Women\'s Shirt.jpg'),
(44, 'Adidas Originals Trefoil Classic Tee', 1999.00, 27, 51, 'uploads/1766081190_download.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `userPassword` varchar(250) DEFAULT NULL,
  `userType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `userName`, `email`, `userPassword`, `userType`) VALUES
(2, 'eds', 'eds@gmail.com', '$2y$10$iCv.kAL8.a90OlXIE7Fitu89wVMgegiy0cDUliKCla/kr.SbAfaj2', 'Admin'),
(3, 'hello', 'hello@gmail.com', '$2y$10$LWGR2Jpk.G6KUWMGfbduCeZiKOLrkA7kqt1X0fBY8Jc8KQxNnIV5C', 'Staff'),
(4, 'PinakaAdmin', 'admin@gmail.com', '$2y$10$Ukp.4hvr.3iL.2XH5gLaqey20Hd2ByxzjOLkiLBGL53KY43Q1oTrC', 'Admin'),
(5, 'uwuStaff', 'student@gmail.com', '$2y$10$UjpTKp4WALQf8Afs0LqcV.hyoGFfyqd9wJ43YfdvRDOWj3yg.2U/q', 'Staff'),
(7, 'uwu', 'uwu@gmail.com', '$2y$10$NnXXgWD4Tjug71Cq11PimeEsVSN2EGItXvZ.vX1YhtxAA4ng3UHpC', 'Customer'),
(8, 'RMRUFIN', 'RMRUFIN@gmail.com', '$2y$10$f2r60DmS9pawHxQyDcRkTOKYzIza0EGD3/TJBvO5fKWm2KgYyla9.', 'Customer'),
(9, 'ai123', 'MAN@gmail.com', '$2y$10$CbuV/KsGAGlQcfsBEhebXeu5ioXvfzH4CANG/nyWmwn/UN0LjMQsi', 'Admin'),
(16, 'ai12345', 'MAN@gmail.com', '$2y$10$Dgv16j8K5Ug0SZvJAGsNxubiW1X3F3RWQbgf/yCW6J5S7Zpv8nADu', 'Customer'),
(17, 'aila', 'mantong@gmail.com', '$2y$10$qG50EcCS9FdWXXBaMt8XCO23ycjXzW25CWWKM4viED8YBGpKAwtKK', 'Customer'),
(19, 'ailaf', 'mantong@gmail.com', '$2y$10$nf2fa8Zj8OUzrDmi46h/2eM7Cz5mFOVKy7cOdyDg5ypxFyG0z13MG', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_logs`
--

CREATE TABLE `tbl_user_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `userType` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Logged In'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_logs`
--

INSERT INTO `tbl_user_logs` (`log_id`, `user_id`, `username`, `userType`, `remarks`, `login_time`, `logout_time`, `status`) VALUES
(4, 9, 'ai123', 'ADMIN', 'brownout', '2025-12-16 11:08:13', '2025-12-16 11:08:39', 'Logged Out'),
(8, 9, 'ai123', 'ADMIN', '', '2025-12-17 00:12:02', '2025-12-17 02:36:23', 'Logged Out'),
(9, 9, 'ai123', 'Admin', NULL, '2025-12-17 02:43:59', '2025-12-17 02:51:39', 'Logged Out'),
(10, 9, 'ai123', 'Admin', NULL, '2025-12-17 03:03:46', '2025-12-17 03:08:38', 'Logged Out'),
(13, 9, 'ai123', 'Admin', NULL, '2025-12-17 06:55:10', '2025-12-17 08:20:03', 'Logged Out'),
(14, 9, 'ai123', 'Admin', NULL, '2025-12-17 08:21:02', '2025-12-17 08:22:23', 'Logged Out'),
(16, 13, 'aila', 'Staff', NULL, '2025-12-17 08:25:51', '2025-12-17 08:26:15', 'Logged Out'),
(18, 9, 'ai123', 'Admin', NULL, '2025-12-18 15:25:49', '2025-12-18 15:56:27', 'Logged Out'),
(19, 9, 'ai123', 'Admin', NULL, '2025-12-18 15:56:36', '2025-12-18 16:11:40', 'Logged Out'),
(20, 16, 'ai12345', 'Customer', NULL, '2025-12-18 16:12:43', '2025-12-18 16:13:45', 'Logged Out'),
(21, 16, 'ai12345', 'Customer', NULL, '2025-12-18 16:14:16', '2025-12-18 16:34:15', 'Logged Out'),
(22, 16, 'ai12345', 'Customer', NULL, '2025-12-18 16:34:22', '2025-12-18 16:36:50', 'Logged Out'),
(23, 16, 'ai12345', 'Customer', NULL, '2025-12-18 16:37:14', '2025-12-18 17:00:48', 'Logged Out'),
(24, 9, 'ai123', 'Admin', NULL, '2025-12-18 17:00:55', '2025-12-18 17:01:54', 'Logged Out'),
(25, 17, 'aila', 'Customer', NULL, '2025-12-18 17:03:31', '2025-12-18 17:05:55', 'Logged Out'),
(26, 9, 'ai123', 'Admin', NULL, '2025-12-18 17:06:09', '2025-12-18 17:06:38', 'Logged Out'),
(27, 17, 'aila', 'Customer', NULL, '2025-12-18 17:06:45', '2025-12-18 17:07:13', 'Logged Out'),
(28, 9, 'ai123', 'Admin', NULL, '2025-12-18 17:07:24', '2025-12-18 17:08:14', 'Logged Out'),
(29, 19, 'ailaf', 'Staff', NULL, '2025-12-18 17:08:25', '2025-12-18 18:07:35', 'Logged Out'),
(30, 9, 'ai123', 'Admin', NULL, '2025-12-18 18:07:43', '2025-12-18 18:27:21', 'Logged Out');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_customer` (`customerID`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_logs`
--
ALTER TABLE `tbl_user_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_user_logs`
--
ALTER TABLE `tbl_user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customerID`) REFERENCES `tbl_customers` (`customerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
