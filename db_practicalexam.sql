-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 07:07 AM
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
(9, 'Men Shoes', 'uwuwuw'),
(11, 'Men Shoes', 'The quick brown fox jump over the lazy dog.'),
(12, 'Men Shoes', 'Amethyst Mcclure'),
(13, 'Men Shoes', 'asdfs'),
(14, 'Men Shoes', 'Trainer Shoes Usa siya ka sapatos'),
(15, 'Men Shoes', 'Pang Court siya nga sapatos.'),
(16, 'Men Shoes', 'Pang Court siya nga sapatos.'),
(17, 'Women Shoes', 'Pang Girl nga Sapatos'),
(18, 'Men Shoes', 'Pang Court siya nga sapatos.'),
(19, 'Men Shoes', 'Pang Tiguwang siya nga sapatos.'),
(20, 'Men Shoes', 'Pang Choy2 siya nga sapatos.'),
(21, 'Men Shoes', 'Pang Dagan siya nga sapatos nig gukdon kas iro.'),
(22, 'Men Shoes', 'Pang Dagan siya nga sapatos nig gukdon kas iro.'),
(23, 'Men Shoes', 'Kini nga sapatos dali ra magka hugaw');

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
(9, 'Edon Edon', 5000.00, 123, 11, 'uploads/Buy campus.jpg'),
(12, 'Trainer shoes', 5000.00, 123, 14, 'uploads/Trainer shoes.jpg'),
(13, 'GSM Blue Shoes', 10000.00, 100, 15, 'uploads/Adidas Grand Court.jpg'),
(14, 'Run Falcon 5', 5000.00, 100, 16, 'uploads/Runfalcon 5.jpg'),
(17, '70s Running Shoes', 1000.00, 20, 19, 'uploads/70s running shoes.jpg'),
(18, 'Divisoria Shoes', 5000.00, 201, 20, 'uploads/mens samba.jpg'),
(19, 'Mens Running Shoes', 5000.00, 201, 21, 'uploads/Mens Running Shoes.jpg'),
(21, 'Grand Court', 4300.00, 100, 23, 'uploads/Adidas Grand Court.jpg');

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
(5, 'uwuStaff', 'student@gmail.com', '$2y$10$UjpTKp4WALQf8Afs0LqcV.hyoGFfyqd9wJ43YfdvRDOWj3yg.2U/q', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
