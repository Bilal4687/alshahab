-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2023 at 10:06 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alshahab`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `attribute_id` bigint(255) NOT NULL,
  `attribute_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`attribute_id`, `attribute_name`, `attribute_type`, `lang`) VALUES
(1, 'Color', 'color', 'en'),
(2, 'Fit', 'Slim Fit', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` bigint(255) NOT NULL,
  `brand_name` text COLLATE utf8_unicode_ci NOT NULL,
  `brand_image` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_image`, `lang`) VALUES
(1, 'Louis Philippe', '-', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(255) NOT NULL,
  `category_name` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` bigint(255) DEFAULT NULL,
  `slug` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_id`, `slug`, `lang`) VALUES
(1, 'Men\'scc', NULL, 'Mens', 'en'),
(2, 'InFormal Shirts', 1, 'Mens-Formal-Shirts', 'en'),
(3, 'edfdsfsd', NULL, NULL, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` bigint(255) NOT NULL,
  `discount_coupon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_value` int(255) NOT NULL,
  `discount_threshold` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `discount_coupon`, `discount_type`, `discount_value`, `discount_threshold`) VALUES
(1, '100OFFEID', 'Percentage', 10, 2000),
(2, '100OFFEID', 'Flat', 200, 2500),
(3, '34957348957', 'Flat', 1000, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `home__sliders`
--

CREATE TABLE `home__sliders` (
  `home_slider_id` bigint(255) NOT NULL,
  `home_slider_title` text COLLATE utf8_unicode_ci NOT NULL,
  `home_slider_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `home_slider_path` text COLLATE utf8_unicode_ci NOT NULL,
  `home_slider_web_url` text COLLATE utf8_unicode_ci NOT NULL,
  `home_slider_mob_url` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `home__sliders`
--

INSERT INTO `home__sliders` (`home_slider_id`, `home_slider_title`, `home_slider_description`, `home_slider_path`, `home_slider_web_url`, `home_slider_mob_url`, `lang`, `created_by`, `created_date`) VALUES
(9, '9vOJcFAm7l', 'sdasdasd', 'onTnJ7uFOg8EbpZlHkcz.jpg', 'UCOPpBVmrl', 'zhLtif9FOV', '-', '-', '2023-06-19 09:57:00'),
(10, 'Z1YvOUYHXX', 'sdasdas', 'jhHnPXJ4EjZEvmDAF6nE.jpg', 'RDl19cxzh4', 'v0els91Qbn', '-', '-', '2023-06-19 10:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(255) NOT NULL,
  `brand_id` bigint(255) NOT NULL,
  `product_name` text COLLATE utf8_unicode_ci NOT NULL,
  `product_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `product_thumbnail` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `brand_id`, `product_name`, `product_description`, `product_thumbnail`, `lang`, `updated_by`, `updated_date`, `created_by`, `created_date`) VALUES
(1, 1, 'Louis Philippe', 'Peach-coloured solid opaque Formal shirt ,has a cutaway collar, button placket, 1 patch pocket, long regular sleeves, curved hem', '-', 'en', NULL, NULL, '1', '15-06-2023');

-- --------------------------------------------------------

--
-- Table structure for table `products__ attributes`
--

CREATE TABLE `products__ attributes` (
  `product_attribute_id` bigint(255) NOT NULL,
  `product_id` bigint(255) NOT NULL,
  `attribute_id` bigint(255) NOT NULL,
  `attribute_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products__ attributes`
--

INSERT INTO `products__ attributes` (`product_attribute_id`, `product_id`, `attribute_id`, `attribute_value`) VALUES
(1, 1, 1, '#000000'),
(2, 1, 1, '#FFFFFF'),
(3, 1, 2, 'Regular Fit'),
(4, 1, 2, 'Slim Fit');

-- --------------------------------------------------------

--
-- Table structure for table `products__categories`
--

CREATE TABLE `products__categories` (
  `product_category_id` bigint(255) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products__categories`
--

INSERT INTO `products__categories` (`product_category_id`, `product_id`, `category_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products__images`
--

CREATE TABLE `products__images` (
  `product_image_id` bigint(255) NOT NULL,
  `product_id` bigint(255) NOT NULL,
  `product_image_path` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products__pricing`
--

CREATE TABLE `products__pricing` (
  `product_price_id` bigint(255) NOT NULL,
  `product_id` bigint(255) NOT NULL,
  `variation_id` bigint(255) NOT NULL,
  `attribute_id` bigint(255) NOT NULL,
  `sale_price` float NOT NULL DEFAULT 0,
  `mrp_price` float NOT NULL DEFAULT 0,
  `discount_percentage` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products__pricing`
--

INSERT INTO `products__pricing` (`product_price_id`, `product_id`, `variation_id`, `attribute_id`, `sale_price`, `mrp_price`, `discount_percentage`) VALUES
(1, 1, 1, 1, 500, 1000, 50),
(2, 1, 1, 2, 500, 1000, 50),
(3, 1, 1, 3, 500, 1000, 50),
(4, 1, 1, 4, 500, 1000, 50),
(5, 1, 2, 2, 600, 1200, 50),
(6, 1, 2, 3, 600, 1200, 50);

-- --------------------------------------------------------

--
-- Table structure for table `products__variations`
--

CREATE TABLE `products__variations` (
  `product_variation_id` bigint(255) NOT NULL,
  `product_id` bigint(255) NOT NULL,
  `variation_id` bigint(255) NOT NULL,
  `variation_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products__variations`
--

INSERT INTO `products__variations` (`product_variation_id`, `product_id`, `variation_id`, `variation_value`) VALUES
(1, 1, 1, 'L'),
(2, 1, 1, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `variation_id` bigint(255) NOT NULL,
  `product_variation_name` text COLLATE utf8_unicode_ci NOT NULL,
  `product_variation_description` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`variation_id`, `product_variation_name`, `product_variation_description`, `lang`) VALUES
(1, 'Size', '(L,XL)', 'en');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `home__sliders`
--
ALTER TABLE `home__sliders`
  ADD PRIMARY KEY (`home_slider_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `products__ attributes`
--
ALTER TABLE `products__ attributes`
  ADD PRIMARY KEY (`product_attribute_id`);

--
-- Indexes for table `products__categories`
--
ALTER TABLE `products__categories`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `products__images`
--
ALTER TABLE `products__images`
  ADD PRIMARY KEY (`product_image_id`);

--
-- Indexes for table `products__pricing`
--
ALTER TABLE `products__pricing`
  ADD PRIMARY KEY (`product_price_id`);

--
-- Indexes for table `products__variations`
--
ALTER TABLE `products__variations`
  ADD PRIMARY KEY (`product_variation_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `attribute_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `home__sliders`
--
ALTER TABLE `home__sliders`
  MODIFY `home_slider_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products__ attributes`
--
ALTER TABLE `products__ attributes`
  MODIFY `product_attribute_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products__categories`
--
ALTER TABLE `products__categories`
  MODIFY `product_category_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products__images`
--
ALTER TABLE `products__images`
  MODIFY `product_image_id` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products__pricing`
--
ALTER TABLE `products__pricing`
  MODIFY `product_price_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products__variations`
--
ALTER TABLE `products__variations`
  MODIFY `product_variation_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `variation_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
