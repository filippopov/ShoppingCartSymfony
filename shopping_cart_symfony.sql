-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2017 at 03:19 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_cart_symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address1`, `address2`, `city`, `postal_code`, `created_at`, `updated_at`) VALUES
(13, 'cash', 'cash', 'cash', 'cash', '2017-05-01 16:57:19', '2017-05-01 16:57:19'),
(14, 'opa', 'opa', 'opa', 'opa', '2017-05-01 18:06:14', '2017-05-01 18:06:14'),
(15, 'Last 5', 'Last 10', 'Lastlandiq', '701', '2017-05-01 18:12:44', '2017-05-01 18:12:44'),
(16, 'offAddress1', 'offAddress2', 'off City', '7800', '2017-05-01 18:18:38', '2017-05-01 18:18:38'),
(17, 'alex', 'alex', 'alex', 'alex', '2017-05-01 18:32:23', '2017-05-01 18:32:23'),
(18, 'alex1', 'alex1', 'alex1', 'alex1', '2017-05-01 18:34:29', '2017-05-01 18:34:29'),
(19, 'ergre', 'regreg', 'regreg', 'regreg', '2017-05-07 13:14:50', '2017-05-07 13:26:21'),
(20, 'wefwe', 'wefwef', 'wefwf', 'wefwf', '2017-05-07 13:29:19', '2017-05-07 13:29:19'),
(21, 'wefwef', 'defewf', 'wefwf', 'wfewffw', '2017-05-07 13:40:14', '2017-05-07 13:41:15'),
(22, 'wefwef', 'wefwf', 'wefwf', 'wefwf', '2017-05-07 13:41:49', '2017-05-07 13:41:49'),
(23, 'ergreg', 'ergreg', 'regreg', 'regreg', '2017-05-07 13:49:18', '2017-05-07 13:49:18'),
(24, 'wefwef', 'wfwe', 'wfwef', 'wefwef', '2017-05-08 12:49:24', '2017-05-08 12:49:24'),
(25, 'wefwef', 'wefewf', 'wefwf', 'wefwf', '2017-05-08 13:17:15', '2017-05-08 13:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electronics 1'),
(4, 'Fashion 1'),
(2, 'Home'),
(8, 'Phone'),
(3, 'Sporting Goods'),
(5, 'Test 1');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(11, 'cash', 'cash@mail.bg', '2017-05-01 16:57:19', '2017-05-01 16:57:19'),
(12, 'opa', 'opa@mail.bg', '2017-05-01 18:06:14', '2017-05-01 18:06:14'),
(13, 'Last Lastov', 'last@mail.bg', '2017-05-01 18:12:44', '2017-05-01 18:12:44'),
(14, 'offName', 'off@mail.bg', '2017-05-01 18:18:38', '2017-05-01 18:18:38'),
(15, 'alex', 'alex@mail.bg', '2017-05-01 18:32:23', '2017-05-01 18:32:23'),
(16, 'alex1', 'alex1@abv.bg', '2017-05-01 18:34:29', '2017-05-01 18:34:29'),
(17, 'dgregreg', 'weffwe@mail.bg', '2017-05-07 13:14:50', '2017-05-07 13:26:21'),
(18, 'dsgfwef', 'dfssrf@mail.bg', '2017-05-07 13:29:19', '2017-05-07 13:29:19'),
(19, 'defwefwe', 'test@mail.bg', '2017-05-07 13:40:14', '2017-05-07 13:41:15'),
(20, 'wfwefwe', 'rggeg@mail.bg', '2017-05-07 13:41:49', '2017-05-07 13:41:49'),
(21, 'grrege', 'dasfwef@mail.bg', '2017-05-07 13:49:18', '2017-05-07 13:49:18'),
(22, 'dgfref', 'test@mail.bg', '2017-05-08 12:49:24', '2017-05-08 12:49:24'),
(23, 'efwef', 'rsgreg@mail.bg', '2017-05-08 13:17:15', '2017-05-08 13:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20170422110351'),
('20170501082226'),
('20170501082530'),
('20170501082837'),
('20170506084546'),
('20170508070909'),
('20170508074839'),
('20170508074955'),
('20170510074110');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `paid` smallint(6) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `hash`, `total`, `paid`, `created_at`, `updated_at`, `address_id`, `user_id`) VALUES
(12, 11, '55a0f4ae34acd27dbacc895dbd08c224db2a5379ce2ae42c569c4befebed4c49', '728.74', 1, '2017-05-01 16:57:19', '2017-05-01 16:57:19', 13, 8),
(13, 12, 'ad4d5a82572aa7072627cd9267bbe26d79f0350618fca208349a390db6d9fcd1', '227.99', 1, '2017-05-01 18:06:14', '2017-05-01 18:06:14', 14, 8),
(14, 13, '5cc41960c09de5938603fd7935b0ee93455c66b3b28c3dbffa268653cbf09a3a', '466.87', 1, '2017-05-01 18:12:44', '2017-05-01 18:12:44', 15, 9),
(15, 14, '3de85f144ab852395b45d25a43796540812495058190cdcab1a0354e8d2f71d8', '227.99', 1, '2017-05-01 18:18:38', '2017-05-01 18:18:38', 16, 9),
(16, 15, '40c86a7f8ea4e4c25278ac36b3c720a0ee16284740c8a5360629350ff14b6aba', '-663.97', 1, '2017-05-01 18:32:23', '2017-05-01 18:32:23', 17, 10),
(17, 16, 'aa522cd24778de06dd8b2e6fdd7d0e9fb305c2d18555358c426268d1bda7bfcb', '466.87', 1, '2017-05-01 18:34:29', '2017-05-01 18:34:29', 18, 10),
(18, 17, 'e5d1694071436c78a04357ededd9da5eca575e84b2edaffe2773a12a6c36e073', '150.60', 1, '2017-05-07 13:14:50', '2017-05-07 13:14:50', 19, 1),
(19, 17, '399d824d9efa239208a61af24908c67fa17f93a85e5a676f0ce823e9c60279ab', '119.93', 1, '2017-05-07 13:26:21', '2017-05-07 13:26:21', 19, 1),
(20, 18, '9fff4c6361a98b1ae28e435276b2d52e17f2e1da2f3009e04394a694fdb07a54', '312.09', 1, '2017-05-07 13:29:19', '2017-05-07 13:29:19', 20, 1),
(21, 19, '2e0f2d1bea3adb83fce31f2f83a26eb7fad07c40bab37e53619805cc854bab5a', '312.09', 1, '2017-05-07 13:40:14', '2017-05-07 13:40:14', 21, 1),
(22, 19, 'd295295ba58f048c46d4f42d6d38287338dc713d138df2872feb19d7d69650c9', '282.53', 0, '2017-05-07 13:41:15', '2017-05-07 13:41:15', 21, 1),
(23, 20, '6c1866a4f304657e2d8e4c987cf438781672bc9c36f1199269a665771a075a30', '182.38', 1, '2017-05-07 13:41:49', '2017-05-07 13:41:49', 22, 1),
(24, 21, '6cff88dec4fd40bc23067fa97c1d61bfcffc5ed0404cd7cac95adfe87f8e9ac9', '381.57', 1, '2017-05-07 13:49:18', '2017-05-07 13:49:18', 23, 1),
(25, 22, '5113b7e4a5f63246e1fc779b0d191b42fa4445ebcebf44e18463f70e28d7bfdc', '266.84', 1, '2017-05-08 12:49:24', '2017-05-08 12:49:24', 24, 1),
(26, 23, 'bcc54ad32b99279212155626893c8fa2cd8ceb4eff72cc4efe4b1ad87281d5de', '100.14', 1, '2017-05-08 13:17:15', '2017-05-08 13:17:15', 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders__products`
--

CREATE TABLE `orders__products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders__products`
--

INSERT INTO `orders__products` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(13, 12, 1, 1),
(14, 12, 2, 3),
(15, 12, 3, 2),
(16, 13, 2, 1),
(17, 14, 2, 2),
(18, 14, 3, 1),
(19, 15, 2, 1),
(20, 16, 2, -3),
(21, 17, 2, 2),
(22, 17, 3, 1),
(23, 18, 3, 1),
(24, 18, 14, 2),
(25, 18, 15, 1),
(26, 19, 14, 1),
(27, 19, 15, 1),
(28, 20, 3, 3),
(29, 20, 14, 4),
(30, 20, 15, 2),
(31, 21, 3, 3),
(32, 21, 14, 4),
(33, 21, 15, 2),
(34, 22, 3, 3),
(35, 22, 14, 2),
(36, 22, 15, 2),
(37, 23, 3, 3),
(38, 23, 14, 2),
(39, 23, 15, 1),
(40, 24, 3, 2),
(41, 24, 14, 3),
(42, 24, 15, 3),
(43, 25, 2, 1),
(44, 25, 15, 1),
(45, 26, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `failed` smallint(6) NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `failed`, `transaction_id`, `created_at`, `updated_at`) VALUES
(4, 12, 0, 'change this value when use app for validate card', '2017-05-01 16:57:19', '2017-05-01 16:57:19'),
(5, 13, 0, 'change this value when use app for validate card', '2017-05-01 18:06:14', '2017-05-01 18:06:14'),
(6, 14, 0, 'change this value when use app for validate card', '2017-05-01 18:12:44', '2017-05-01 18:12:44'),
(7, 15, 0, 'change this value when use app for validate card', '2017-05-01 18:18:38', '2017-05-01 18:18:38'),
(8, 16, 0, 'change this value when use app for validate card', '2017-05-01 18:32:23', '2017-05-01 18:32:23'),
(9, 17, 0, 'change this value when use app for validate card', '2017-05-01 18:34:29', '2017-05-01 18:34:29'),
(10, 18, 0, 'change this value when use app for validate card', '2017-05-07 13:14:50', '2017-05-07 13:14:50'),
(11, 19, 0, 'change this value when use app for validate card', '2017-05-07 13:26:21', '2017-05-07 13:26:21'),
(12, 20, 0, 'change this value when use app for validate card', '2017-05-07 13:29:19', '2017-05-07 13:29:19'),
(13, 21, 0, 'change this value when use app for validate card', '2017-05-07 13:40:14', '2017-05-07 13:40:14'),
(14, 22, 1, NULL, '2017-05-07 13:41:15', '2017-05-07 13:41:15'),
(15, 23, 0, 'change this value when use app for validate card', '2017-05-07 13:41:49', '2017-05-07 13:41:49'),
(16, 24, 0, 'change this value when use app for validate card', '2017-05-07 13:49:18', '2017-05-07 13:49:18'),
(17, 25, 0, 'change this value when use app for validate card', '2017-05-08 12:49:24', '2017-05-08 12:49:24'),
(18, 26, 0, 'change this value when use app for validate card', '2017-05-08 13:17:15', '2017-05-08 13:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_second_hand` smallint(6) NOT NULL,
  `promotion_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `title`, `slug`, `description`, `price`, `image`, `stock`, `created_at`, `updated_at`, `user_id`, `deleted_at`, `is_second_hand`, `promotion_price`) VALUES
(1, 1, 'Smart phone', 'smart-phone', 'smart phone', '22.99', 'Product11.png', 1, '2017-04-24 00:02:10', '2017-04-23 00:02:20', NULL, NULL, 0, '0.00'),
(2, 1, 'Smart Tv', 'smart-tv', 'smart tv', '222.99', 'Product11.png', 9, '2017-04-23 00:46:21', '2017-04-23 00:46:24', NULL, NULL, 0, '0.00'),
(3, 2, 'table', 'table', 'table', '15.89', 'Product11.png', 8, '2017-04-23 00:47:30', '2017-04-23 00:47:32', NULL, NULL, 0, '0.00'),
(4, 2, 'Chair', 'chair', 'chair', '13.99', 'Product11.png', 10, '2017-04-23 00:48:33', '2017-04-23 00:48:35', NULL, NULL, 0, '0.00'),
(5, 3, 'Sneakers', 'sneakers', 'sneakers', '22.89', 'Product11.png', 10, '2017-04-23 00:49:44', '2017-04-23 00:49:46', NULL, NULL, 0, '0.00'),
(9, 2, 'test image', 'test-image', 'dsgreg', '12.99', 'Product11.png', 3, '2017-05-06 18:01:45', '2017-05-06 18:01:45', NULL, NULL, 0, '0.00'),
(10, 2, 'test-product', 'test-product', 'wesrfwefwef', '14.99', '090c9c5fcdf888c5e76356b1dc99ed10.png', 3, '2017-05-07 08:26:54', '2017-05-07 08:26:54', NULL, NULL, 0, '0.00'),
(11, 2, 'tets chupq', 'tets-chupq', 'greg', '14.99', '6410cc158b8d3d23328eb9e3e25d4888.png', 2, '2017-05-07 09:35:00', '2017-05-07 09:35:00', NULL, NULL, 1, '0.00'),
(12, 2, 'test this', 'test-this', 'wef wefw', '12.99', '1f9fcc99544d1f7f764f245d5c461f12.png', 2, '2017-05-07 10:08:12', '2017-05-07 10:08:12', NULL, NULL, 0, '0.00'),
(13, 3, 'tv samsung1', 'tv-samsung1', 'fret retete yesss', '100.15', '7c738ec8e94712921aa8704db903a80f.png', 121, '2017-05-07 10:21:19', '2017-05-07 10:41:24', NULL, NULL, 1, '0.00'),
(14, 1, 'My product', 'my-product', 'dsfdsf wefwef', '14.78', '61df64210b4331f3dc4459fb0ae009fd.png', 12, '2017-05-07 12:21:44', '2017-05-07 12:21:44', 11, NULL, 0, '0.00'),
(15, 1, 'Dragan Product', 'dragan-product', 'wefwe wefewfw', '100.15', 'afa5b8f25d07cc35586be40f23137eaa.png', 10, '2017-05-07 13:03:26', '2017-05-07 13:03:26', 2, NULL, 0, '0.00'),
(16, 1, 'product pagination', 'product-pagination', 'fwefwe', '12.99', 'ff5fea2a4f30b8102a9b3e676124df37.png', 3, '2017-05-07 21:56:07', '2017-05-07 21:56:07', NULL, NULL, 0, '0.00'),
(17, 2, 'home product', 'home-product', 'wfwefwef', '12.99', '3502ff9044d8f15c0eb75b2f888ecdc2.png', 12, '2017-05-07 23:15:29', '2017-05-07 23:15:29', NULL, NULL, 0, '0.00'),
(18, 4, 'watch 1', 'watch-1', 'test', '20.00', 'Product11.png', 10, '2017-05-10 12:56:41', '2017-05-10 12:57:10', NULL, NULL, 0, '0.00'),
(19, 2, 'oggggwes', 'oggggwes', 'effew', '12.99', 'deb35161dc6102328353c313404f5259.png', 3, '2017-05-10 12:58:55', '2017-05-10 12:58:55', NULL, NULL, 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `promotion_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_promotion` smallint(6) DEFAULT NULL,
  `percentages` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(2, 'ROLE_ADMIN'),
(3, 'ROLE_EDITOR'),
(1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `virtual_cash` decimal(10,2) DEFAULT NULL,
  `is_ban` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `virtual_cash`, `is_ban`) VALUES
(1, 'Filip', 'filip@mail.bg', '$2y$13$1FdOOr4yw5hSoH4Tf0u.UezJiXaY8G.gtVb.Z2S3fEJMpJqA6KCpS', '251.45', 0),
(2, 'Dragan', 'dragan@mail.bg', '$2y$13$J73ehPBLabmSNpr4VSb3r.aCcieQRe79EfLVXxG1GWyw7p0T9ei0a', '1485.73', 0),
(3, 'ivan', 'ivan@mail.bg', '$2y$13$fQq7XSNMn2WyP5wMSp/9SucnMWtsVDLC8F.eAKAvnir1Zj26BxfyO', '1000.00', 0),
(4, 'petq', 'petq@mail.bg', '$2y$13$mAVcn.FwVScb3JLV80DXIOzUZNYsXaO96w5AT3c/CfedcoAfQccXa', '1000.00', 0),
(5, 'sasho', 'sash@mail.bg', '$2y$13$59N8DpPjgpZF.uCZLSz5xu9eCmMAn7ySt9ztegfVWAIiXDYtQO/tO', '1000.00', 0),
(6, 'adqwed', 'maafdwe@mail.bg', '$2y$13$aYIfEplGQnCrjJ04e2DhH.Wa2O6tOC.TmNdfxJ.hMkPBxAfmLv45e', '1000.00', 0),
(7, 'virtualCash', 'virtualCash@abv.bg', '$2y$13$o65gz.ZdnwfJ.0nFdqrYvuXUIf5bUOjVVfmZMdalCohtkS7p7RZeO', '1000.00', 0),
(8, 'Petrov', 'petrov@abv.bg', '$2y$13$gdgd6XrRi34EXtDOmXS4tu5635IiB2p1ZDHUS4rTPNOfp/U.wpwBC', '43.27', 0),
(9, 'lastTest', 'last@mail.bg', '$2y$13$mFSbhyoyNbi7CRRGPKg5C.UCAsFgJ.EK5ZJhlH2GM1iemZ7T5XbBe', '305.14', 1),
(10, 'Alex1', 'alex@mail.bg', '$2y$13$w/RG.751685rLEx7bYqzjeHk2T3UADmrGpe9K8b/heuyOoLZil76q', '1197.10', 0),
(11, 'testProducts', 'test@abvvv.bg', '$2y$13$FAhdELe70T5KqtmcBBRQT.lzD56Mh2JwRkJ.GRx2XkzjXN93hvdmO', '1044.34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3AF346685E237E06` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEE9395C3F3` (`customer_id`),
  ADD KEY `IDX_E52FFDEEF5B7AF75` (`address_id`),
  ADD KEY `IDX_E52FFDEEA76ED395` (`user_id`);

--
-- Indexes for table `orders__products`
--
ALTER TABLE `orders__products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EFBA5E628D9F6D38` (`order_id`),
  ADD KEY `IDX_EFBA5E624584665A` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_65D29B328D9F6D38` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D34A04AD2B36786B` (`title`),
  ADD UNIQUE KEY `UNIQ_D34A04AD989D9B62` (`slug`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04ADA76ED395` (`user_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EA1B3034E8D9F699` (`promotion_name`),
  ADD KEY `IDX_EA1B30344584665A` (`product_id`),
  ADD KEY `IDX_EA1B303412469DE2` (`category_id`),
  ADD KEY `IDX_EA1B3034A76ED395` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_57698A6A5E237E06` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `IDX_54FCD59FA76ED395` (`user_id`),
  ADD KEY `IDX_54FCD59FD60322AC` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `orders__products`
--
ALTER TABLE `orders__products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_E52FFDEEF5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);

--
-- Constraints for table `orders__products`
--
ALTER TABLE `orders__products`
  ADD CONSTRAINT `FK_EFBA5E624584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_EFBA5E628D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK_65D29B328D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `FK_D34A04ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `FK_EA1B303412469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `FK_EA1B30344584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_EA1B3034A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `FK_54FCD59FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_54FCD59FD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
