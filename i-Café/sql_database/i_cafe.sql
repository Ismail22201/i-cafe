-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 02:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `user_emotion` varchar(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `restaurant_id` int(100) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `user_emotion`, `product_id`, `restaurant_id`, `restaurant_name`, `product_name`, `price`, `type`, `quantity`, `image`) VALUES
(173, 0, '', 0, 0, '', '', '0.00', '', 0, ''),
(174, 0, '', 27, 0, '', '', '0.00', '', 0, ''),
(175, 0, '', 0, 3, '', '', '0.00', '', 0, ''),
(176, 0, '', 0, 0, 'Cafe Siddiq - Indo Stall', '', '0.00', '', 0, ''),
(177, 0, '', 0, 0, '', 'Nasi Kak Wok', '0.00', '', 0, ''),
(178, 0, '', 0, 0, '', '', '5.00', '', 0, ''),
(179, 0, '', 0, 0, '', '', '0.00', 'Main Dish', 0, ''),
(180, 0, '', 0, 0, '', '', '0.00', '', 1, ''),
(181, 0, '', 0, 0, '', '', '0.00', '', 0, '1685150045.jpeg'),
(183, 0, '', 0, 0, '', '', '0.00', '', 0, ''),
(184, 0, '', 28, 0, '', '', '0.00', '', 0, ''),
(185, 0, '', 0, 3, '', '', '0.00', '', 0, ''),
(186, 0, '', 0, 0, 'Cafe Siddiq - Indo Stall', '', '0.00', '', 0, ''),
(187, 0, '', 0, 0, '', 'Ayam Butter', '0.00', '', 0, ''),
(188, 0, '', 0, 0, '', '', '6.00', '', 0, ''),
(189, 0, '', 0, 0, '', '', '0.00', 'Main Dish', 0, ''),
(190, 0, '', 0, 0, '', '', '0.00', '', 1, ''),
(191, 0, '', 0, 0, '', '', '0.00', '', 0, '1685150092.jpeg'),
(192, 1, '', 28, 3, 'Cafe Siddiq - Indo Stall', 'Ayam Butter', '6.00', 'Main Dish', 1, '1685150092.jpeg'),
(197, 2, '', 34, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Big', '8.00', 'Main Dish', 1, '1685150506.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(100) NOT NULL,
  `date_ordered` date NOT NULL DEFAULT current_timestamp(),
  `time_ordered` time NOT NULL DEFAULT current_timestamp(),
  `user_id` int(100) NOT NULL,
  `user_emotion` varchar(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `restaurant_id` int(100) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'In Cart',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `date_ordered`, `time_ordered`, `user_id`, `user_emotion`, `product_id`, `restaurant_id`, `restaurant_name`, `product_name`, `price`, `type`, `quantity`, `status`, `image`) VALUES
(100, '2023-05-27', '10:57:11', 2, '', 32, 5, 'Cafe Siddiq - Arab Stall', 'Mandi Rice + Big Chicken', '10.00', 'Main Dish', 1, 'Recieved', '1685150347.jpeg'),
(102, '2023-05-27', '11:03:28', 2, '', 35, 7, 'Cafe Siddiq - Western Stall', 'Chicken Chop', '8.00', 'Main Dish', 1, 'Recieved', '1685150615.jpeg'),
(103, '2023-05-27', '14:54:02', 2, '', 32, 5, 'Cafe Siddiq - Arab Stall', 'Mandi Rice + Big Chicken', '10.00', 'Main Dish', 2, 'Recieved', '1685150347.jpeg'),
(104, '2023-05-27', '14:56:09', 2, '', 27, 3, 'Cafe Siddiq - Indo Stall', 'Nasi Kak Wok', '5.00', 'Main Dish', 1, 'Recieved', '1685150045.jpeg'),
(105, '2023-05-27', '14:56:12', 2, '', 32, 5, 'Cafe Siddiq - Arab Stall', 'Mandi Rice + Big Chicken', '10.00', 'Main Dish', 1, 'Recieved', '1685150347.jpeg'),
(106, '2023-05-27', '14:58:45', 2, '', 34, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Big', '8.00', 'Main Dish', 1, 'Recieved', '1685150506.jpeg'),
(107, '2023-05-27', '16:03:00', 2, '', 35, 7, 'Cafe Siddiq - Western Stall', 'Chicken Chop', '8.00', 'Main Dish', 2, 'Recieved', '1685150615.jpeg'),
(108, '2023-05-27', '16:04:30', 1, '', 27, 3, 'Cafe Siddiq - Indo Stall', 'Nasi Kak Wok', '5.00', 'Main Dish', 1, 'Recieved', '1685150045.jpeg'),
(109, '2023-05-27', '16:05:00', 1, '', 28, 3, 'Cafe Siddiq - Indo Stall', 'Ayam Butter', '6.00', 'Main Dish', 1, 'Recieved', '1685150092.jpeg'),
(110, '2023-05-27', '16:18:21', 3, '', 35, 7, 'Cafe Siddiq - Western Stall', 'Chicken Chop', '8.00', 'Main Dish', 5, 'Recieved', '1685150615.jpeg'),
(113, '2023-05-27', '16:53:03', 0, '', 27, 0, '', '', '0.00', '', 0, 'In Cart', ''),
(123, '2023-05-27', '16:55:17', 0, '', 28, 0, '', '', '0.00', '', 0, 'In Cart', ''),
(131, '2023-05-27', '17:01:13', 1, '', 28, 3, 'Cafe Siddiq - Indo Stall', 'Ayam Butter', '6.00', 'Main Dish', 1, 'In Cart', '1685150092.jpeg'),
(132, '2023-05-28', '15:59:28', 2, '', 37, 7, 'Cafe Siddiq - Western Stall', 'Beef Cheese Burger', '4.00', 'Fast Food', 1, 'Recieved', '1685150754.jpg'),
(133, '2023-05-28', '16:01:34', 2, '', 34, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Big', '8.00', 'Main Dish', 1, 'Recieved', '1685150506.jpeg'),
(134, '2023-05-28', '16:10:22', 2, '', 36, 7, 'Cafe Siddiq - Western Stall', 'French Fries', '3.50', 'Main Dish', 1, 'Recieved', '1685150670.jpeg'),
(135, '2023-05-28', '16:14:23', 2, '', 39, 8, 'Cafe Siddiq - Roti Stall', 'Roti Naan Biasa', '1.50', 'Main Dish', 2, 'Ordered', '1685150874.jpeg'),
(136, '2023-05-28', '16:14:47', 2, '', 34, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Big', '8.00', 'Main Dish', 1, 'In Cart', '1685150506.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `restaurant_id` int(100) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `type` varchar(100) NOT NULL,
  `popularity` int(100) NOT NULL,
  `times_ordered` int(100) NOT NULL,
  `midnight_orders` int(100) NOT NULL,
  `morning_orders` int(100) NOT NULL,
  `afternoon_orders` int(100) NOT NULL,
  `evening_orders` int(100) NOT NULL,
  `night_orders` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `restaurant_id`, `restaurant_name`, `product_name`, `price`, `type`, `popularity`, `times_ordered`, `midnight_orders`, `morning_orders`, `afternoon_orders`, `evening_orders`, `night_orders`, `image`) VALUES
(27, 3, 'Cafe Siddiq - Indo Stall', 'Nasi Kak Wok', '5.00', 'Main Dish', 2, 2, 0, 0, 1, 1, 0, '1685150045.jpeg'),
(28, 3, 'Cafe Siddiq - Indo Stall', 'Ayam Butter', '6.00', 'Main Dish', 1, 1, 0, 0, 0, 1, 0, '1685150092.jpeg'),
(29, 4, 'Cafe Siddiq - Sandwich Stall', 'Small Chicken Sandwich', '5.00', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150186.jpeg'),
(30, 4, 'Cafe Siddiq - Sandwich Stall', 'Big Chicken Sandwich', '7.00', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150225.jpeg'),
(31, 5, 'Cafe Siddiq - Arab Stall', 'Mandi Rice + Small Chicken', '7.00', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150309.jpeg'),
(32, 5, 'Cafe Siddiq - Arab Stall', 'Mandi Rice + Big Chicken', '10.00', 'Main Dish', 4, 4, 0, 1, 3, 0, 0, '1685150347.jpeg'),
(33, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Small', '6.00', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150466.jpeg'),
(34, 6, 'Cafe Siddiq - Shawarma Stall', 'Chicken Shawarma Big', '8.00', 'Main Dish', 2, 2, 0, 0, 1, 1, 0, '1685150506.jpeg'),
(35, 7, 'Cafe Siddiq - Western Stall', 'Chicken Chop', '8.00', 'Main Dish', 8, 8, 0, 1, 0, 7, 0, '1685150615.jpeg'),
(36, 7, 'Cafe Siddiq - Western Stall', 'French Fries', '3.50', 'Main Dish', 1, 1, 0, 0, 0, 1, 0, '1685150670.jpeg'),
(37, 7, 'Cafe Siddiq - Western Stall', 'Beef Cheese Burger', '4.00', 'Fast Food', 1, 1, 0, 0, 1, 0, 0, '1685150754.jpg'),
(38, 8, 'Cafe Siddiq - Roti Stall', 'Roti Canai', '2.00', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150824.jpeg'),
(39, 8, 'Cafe Siddiq - Roti Stall', 'Roti Naan Biasa', '1.50', 'Main Dish', 0, 0, 0, 0, 0, 0, 0, '1685150874.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(100) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `restaurant_name`, `email`, `password`, `image`) VALUES
(3, 'Cafe Siddiq - Indo Stall', 'indo@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(4, 'Cafe Siddiq - Sandwich Stall', 'algeria@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(5, 'Cafe Siddiq - Arab Stall', 'arab@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(6, 'Cafe Siddiq - Shawarma Stall', 'shawarma@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(7, 'Cafe Siddiq - Western Stall', 'west@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(8, 'Cafe Siddiq - Roti Stall', 'roti@gmail.com', '202cb962ac59075b964b07152d234b70', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `address_line2` varchar(100) NOT NULL,
  `address_line3` varchar(100) NOT NULL,
  `card_type` varchar(100) NOT NULL,
  `budget` decimal(65,2) NOT NULL,
  `name_on_card` varchar(100) NOT NULL,
  `card_no` varchar(16) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `security_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
