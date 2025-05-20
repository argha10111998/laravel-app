-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 10:04 AM
-- Server version: 8.0.31-0ubuntu0.20.04.1
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sayan Bhattacharjee', 'arghag43@gmail.com', NULL, '$2y$10$LG6A/g1rf.mz82j3wLJdWOuT3UaKqR1hBCrhxzyPd.RkKtXgTq.S6', NULL, '2024-07-08 08:38:23', '2024-07-08 08:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Camla', 'camla', NULL, '2024-07-08 02:51:14', '2024-07-08 02:51:14'),
(2, 'Adidas', 'adidas', NULL, '2024-07-10 01:08:45', '2024-07-10 01:08:45'),
(3, 'Nike', 'nike', NULL, '2024-07-10 01:09:04', '2024-07-10 01:09:04'),
(4, 'Peter England', 'peter_england', NULL, '2024-07-10 01:09:11', '2024-07-10 01:09:11'),
(5, 'Polo', 'polo', NULL, '2024-07-10 01:09:23', '2024-07-10 01:09:23'),
(6, 'Highlander', 'highlander', NULL, '2024-07-10 01:09:44', '2024-07-10 01:09:44'),
(7, 'Snitch', 'snitch', NULL, '2024-07-10 01:09:51', '2024-07-10 01:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Men', 'men', NULL, 0, '2024-07-08 01:21:02', '2024-07-08 01:21:02'),
(2, 'Men Shirt', 'men_shirts', NULL, 1, '2024-07-10 02:23:16', '2024-07-10 02:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` bigint UNSIGNED NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `color`, `color_code`, `created_at`, `updated_at`) VALUES
(1, 'Black', '#000000', '2024-07-10 03:19:35', '2024-07-10 03:19:35'),
(2, 'Red', '#f70808', '2024-07-10 03:20:07', '2024-07-10 03:20:07'),
(3, 'Yellow', '#f08e4c', '2024-07-10 03:22:32', '2024-07-10 03:22:32'),
(4, 'Green', '#1c5a02', '2024-07-10 03:23:13', '2024-07-10 03:23:13'),
(6, 'Blue', '#05f5cd', '2024-07-10 04:38:13', '2024-07-10 04:38:13'),
(7, 'Pink', '#ffc0fc', '2024-07-10 04:50:18', '2024-07-10 04:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_06_113757_create_admin_registrations_table', 1),
(6, '2024_07_06_175323_create_user_profile_table', 1),
(7, '2024_07_07_073519_create_brands_table', 1),
(8, '2024_07_07_073654_create_category_table', 1),
(9, '2024_07_07_074121_create_product_table', 1),
(10, '2024_07_07_145607_create_size_table', 1),
(12, '2024_07_08_115204_create_product_size_quantity_table', 2),
(14, '2024_07_10_064155_create_color_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regular_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` enum('instock','outofstock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `slug`, `short_description`, `description`, `regular_price`, `sale_price`, `SKU`, `stock_status`, `quantity`, `image`, `images`, `category_id`, `brand_id`, `color_id`, `created_at`, `updated_at`) VALUES
(18, 'Camla Beige Shirt For Men', 'camla_beige_shirt_for_men', 'Yellow self design opaque casual shirt ,has a spread collar, button placket, long regular sleeves, curved hem', 'Yellow self design opaque casual shirt ,has a spread collar, button placket, long regular sleeves, curved hem', '520', '480', 'c3s72304-beige', 'instock', '1', '1720444971.webp', '[\"1720444971_3_1a8f5af5-8343-4746-b2b3-a958bffcabef_900x.webp\",\"1720444971_2_eef1f41a-2b1a-401d-860a-aaa9454af502_900x.webp\",\"1720444971_1_202c9477-3701-4f25-a676-12e47a376e83_900x.webp\"]', 2, 1, 3, '2024-07-08 07:52:51', '2024-07-08 07:52:51'),
(21, 'Cavallo By Linen Club Men\'s Cotton Linen Green Checks Regular Fit Half Sleeve Casual Shirt', 'cavallo_by_linen_club_mens_cotton_linen_green_checks_regular_fit_half_sleeve_casual_shirt', 'Style up with this Casual Shirt from Cavallo by Linen Club from Aditya Birla Group. Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time. ,', 'Style up with this Casual Shirt from Cavallo by Linen Club from Aditya Birla Group. Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time.', '520', '480', '612ck08270-g4', 'instock', '1', '1720606600.jpg', '[\"1720606600_comshck08270-g4_6_1.jpg\",\"1720606600_comshck08270-g4_1_1.jpg\"]', 2, 4, 4, '2024-07-10 04:46:40', '2024-07-10 04:46:40'),
(23, 'Cavallo By Linen Club Men\'s Cotton Linen Pink Checks Regular Fit Full Sleeve Casual Shirt', 'cavallo_by_linen_club_mens_cotton_linen_pink_checks_regular_fit_full_sleeve_casual_shirt', 'Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time.  Cavallo shirts are carefully designed to suit your versatile lifestyle, are perfect for multiple occasions, easy to care and long lasting.', 'Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time.  Cavallo shirts are carefully designed to suit your versatile lifestyle, are perfect for multiple occasions, easy to care and long lasting.', '890', '700', 'f614ck08313-p6', 'instock', '1', '1720607255.jpg', '[\"1720607255_comsf614ck08313-p6_9.jpg\",\"1720607255_comsf614ck08313-p6_4.jpg\",\"1720607255_comsf614ck08313-p6_3.jpg\"]', 2, 2, 7, '2024-07-10 04:57:35', '2024-07-10 04:57:35'),
(24, 'Cavallo By Linen Club Men\'s Cotton Linen Blue Checks Regular Fit Full Sleeve Casual Shirt', 'cavallo_by_linen_club_mens_cotton_linen_blue_checks_regular_fit_full_sleeve_casual_shirt', 'Style up with this Casual Shirt from Cavallo by Linen Club from Aditya Birla Group. Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time.', 'Style up with this Casual Shirt from Cavallo by Linen Club from Aditya Birla Group. Crafted from fine linen cotton blends, this shirt keeps you stylish and comfortable at the same time.', '890', '786', 'f614ck08312-b6', 'instock', '1', '1720611110.jpg', '[\"1720611110_comsf614ck08312-b6_8.jpg\",\"1720611110_comsf614ck08312-b6_7.jpg\",\"1720611110_comsf614ck08312-b6_1.jpg\"]', 2, 5, 6, '2024-07-10 06:01:50', '2024-07-10 06:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `size_id` bigint UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `product_id`, `size_id`, `price`, `created_at`, `updated_at`) VALUES
(15, 18, 5, '3250.00', '2024-07-08 07:52:51', '2024-07-08 07:52:51'),
(16, 18, 6, '2000.00', '2024-07-08 07:52:51', '2024-07-08 07:52:51'),
(17, 21, 5, '6578.00', '2024-07-10 04:46:40', '2024-07-10 04:46:40'),
(18, 21, 6, '12.00', '2024-07-10 04:46:40', '2024-07-10 04:46:40'),
(21, 23, 5, '6578.00', '2024-07-10 04:57:35', '2024-07-10 04:57:35'),
(22, 23, 6, '2698.00', '2024-07-10 04:57:35', '2024-07-10 04:57:35'),
(23, 23, 15, '1569.00', '2024-07-10 04:57:36', '2024-07-10 04:57:36'),
(24, 24, 5, '6587.00', '2024-07-10 12:35:30', '2024-07-10 12:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_size_quantity`
--

CREATE TABLE `product_size_quantity` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `size_id` bigint UNSIGNED NOT NULL,
  `quantity` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_size_quantity`
--

INSERT INTO `product_size_quantity` (`id`, `product_id`, `size_id`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 18, 5, 21, '2024-07-08 07:52:51', '2024-07-08 07:52:51'),
(4, 18, 6, 24, '2024-07-08 07:52:51', '2024-07-08 07:52:51'),
(5, 21, 5, 18, '2024-07-10 04:46:40', '2024-07-10 04:46:40'),
(6, 21, 6, 10, '2024-07-10 04:46:40', '2024-07-10 04:46:40'),
(8, 23, 5, 10, '2024-07-10 04:57:35', '2024-07-10 04:57:35'),
(9, 23, 6, 17, '2024-07-10 04:57:36', '2024-07-10 04:57:36'),
(10, 23, 15, 11, '2024-07-10 04:57:36', '2024-07-10 04:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` bigint UNSIGNED NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `size`, `created_at`, `updated_at`) VALUES
(5, 'Large', '2024-07-08 02:38:57', '2024-07-08 02:38:57'),
(6, 'Small', '2024-07-08 02:46:00', '2024-07-08 02:46:00'),
(15, 'XLarge', '2024-07-08 06:27:48', '2024-07-08 06:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sayan Bhattacharjee', 'benjamin.s@promotedge.com', NULL, '$2y$10$/BdxpruTGrC.25ALy5cNvu4mFbTd4KYQP8U6i4ZI6PpIYJ518bgUK', NULL, '2024-07-08 00:44:46', '2024-07-08 00:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `address1`, `address2`, `city`, `state`, `zip`, `created_at`, `updated_at`) VALUES
(1, 1, 'Behala', 'Behala Silpara Kol-710096', 'Kolkata', 'West Bengal', '700008', '2024-07-08 00:44:46', '2024-07-08 00:44:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_name_unique` (`name`),
  ADD UNIQUE KEY `brand_slug_unique` (`slug`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name_unique` (`name`),
  ADD UNIQUE KEY `category_slug_unique` (`slug`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `color_color_unique` (`color`),
  ADD UNIQUE KEY `color_color_code_unique` (`color_code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name_unique` (`name`),
  ADD UNIQUE KEY `product_slug_unique` (`slug`),
  ADD KEY `product_category_id_foreign` (`category_id`),
  ADD KEY `product_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_size_product_id_size_id_unique` (`product_id`,`size_id`),
  ADD KEY `product_size_size_id_foreign` (`size_id`);

--
-- Indexes for table `product_size_quantity`
--
ALTER TABLE `product_size_quantity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size_quantity_product_id_foreign` (`product_id`),
  ADD KEY `product_size_quantity_size_id_foreign` (`size_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `size_size_unique` (`size`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profile_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_size_quantity`
--
ALTER TABLE `product_size_quantity`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size_quantity`
--
ALTER TABLE `product_size_quantity`
  ADD CONSTRAINT `product_size_quantity_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_quantity_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
