-- Scarfity Database Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 1. Table structure for table `products`
CREATE TABLE `products` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping initial product data
INSERT INTO `products` (`id`, `name`, `price`, `image`, `type`) VALUES
(1, 'Layali Veil', 200, 'printed1.jpeg', 'printed'),
(2, 'Safa Wear', 200, 'printed2.jpeg', 'printed'),
(3, 'Riwaq Hijab', 250, 'printed3.jpeg', 'printed'),
(4, 'Areej Veil', 240, 'printed4.jpeg', 'printed'),
(5, 'Hijab Luxe', 230, 'printed5.jpeg', 'printed'),
(6, 'Floral Print', 270, 'printed6.jpeg', 'printed'),
(7, 'Velvet Hijab', 280, 'printed7.jpeg', 'printed'),
(8, 'Lumi Veil', 240, 'printed8.jpeg', 'printed'),
(9, 'Aura Veil', 230, 'printed9.jpeg', 'printed'),
(10, 'Pure Modest', 270, 'printed10.jpeg', 'printed'),
(11, 'Elegant Veil', 240, 'printed11.jpeg', 'printed'),
(12, 'Daily Veil', 200, 'printed12.jpeg', 'printed'),
(13, 'simple print hijab', 250, 'printed13.jpeg', 'printed'),
(14, 'flower hijab', 180, 'printed14.jpeg', 'printed'),
(15, 'Chic Print Hijab', 220, 'printed15.jpeg', 'printed'),
(16, 'FERN Classic', 130, 'basic1.jpeg', 'plain'),
(17, 'burgundy classic', 170, 'basic2.jpeg', 'plain'),
(18, 'brown classic', 140, 'basic3.jpeg', 'plain'),
(19, 'night blue Classic', 130, 'basic4.jpeg', 'plain'),
(20, 'black classic', 170, 'basic5.jpeg', 'plain'),
(21, 'mint Classic', 130, 'basic6.jpeg', 'plain'),
(22, 'coffee classic', 170, 'basic7.jpeg', 'plain'),
(23, 'chiffon classic', 140, 'basic8.jpeg', 'plain'),
(24, 'baby pink Classic', 130, 'basic9.jpeg', 'plain'),
(25, 'baby blue classic', 170, 'basic10.jpeg', 'plain'),
(26, ' night blue Classic', 130, 'basic11.jpeg', 'plain'),
(27, 'chili classic', 170, 'basic12.jpeg', 'plain'),
(28, 'white classic', 140, 'basic13.jpeg', 'plain'),
(29, 'yellow Classic', 130, 'basic14.jpeg', 'plain'),
(30, 'lilac classic', 170, 'basic15.jpeg', 'plain');

-- 2. Table structure for table `orders`
CREATE TABLE `orders` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `user_name` varchar(100) NOT NULL,
  `second_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `address` text NOT NULL,
  `governorate` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Table structure for table `order_items`
CREATE TABLE `order_items` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. Table structure for table `contact_messages`
CREATE TABLE `contact_messages` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping Admin User (Secure Data)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`) VALUES
(1, 'Admin', 'admin@scarfity.com', '$2y$10$tU/V5Rd/oh9H5WAT7A6tN.36bxEdDg/fK4OWTPhhjUHp93MH6aYVO', 1);

COMMIT;