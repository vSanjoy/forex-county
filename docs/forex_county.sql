-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2023 at 02:04 PM
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
-- Database: `forex_county`
--

-- --------------------------------------------------------

--
-- Table structure for table `fc_banks`
--

CREATE TABLE `fc_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_code` varchar(10) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `bank_image` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1->Active | 0->Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_banks`
--

INSERT INTO `fc_banks` (`id`, `bank_name`, `bank_code`, `country_id`, `bank_image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sdsadasd', '123', 11, 'bank_image.png', '1', '2023-01-24 23:49:07', '2023-01-24 23:50:57', NULL),
(2, 'Test', '2321', 1, 'bank_image.png', '1', '2023-01-24 23:52:50', '2023-02-01 01:23:03', NULL),
(3, 'Test', 'sdasdasd', 9, 'bank_image.png', '1', '2023-01-25 00:00:33', '2023-01-25 00:00:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_cms`
--

CREATE TABLE `fc_cms` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `short_title` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_cms`
--

INSERT INTO `fc_cms` (`id`, `page_name`, `title`, `slug`, `short_title`, `short_description`, `description`, `featured_image`, `meta_title`, `meta_keywords`, `meta_description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', 'Home', 'home', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2023-02-01 00:39:07', '2023-02-01 00:47:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_countries`
--

CREATE TABLE `fc_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `countryname` varchar(255) DEFAULT NULL,
  `countrycode` varchar(3) DEFAULT NULL,
  `code` varchar(2) DEFAULT NULL,
  `country_code_for_phone` varchar(5) DEFAULT NULL,
  `require_account_holder` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_account_number` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_iban_number` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_uk_short_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_ach_routing_number` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_account_type` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_beneficiary_bank` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_ifsc_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_country` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_city` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_address` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_postal_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `image` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_countries`
--

INSERT INTO `fc_countries` (`id`, `countryname`, `countrycode`, `code`, `country_code_for_phone`, `require_account_holder`, `require_account_number`, `require_iban_number`, `require_uk_short_code`, `require_ach_routing_number`, `require_account_type`, `require_beneficiary_bank`, `require_ifsc_code`, `require_country`, `require_city`, `require_address`, `require_postal_code`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Afghanistan', 'AFG', 'AF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'af.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:41:57', NULL),
(2, 'Åland', 'ALA', 'AX', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ax.png', '1', '2023-01-20 05:54:08', '2023-02-17 05:27:16', NULL),
(3, 'Albania', 'ALB', 'AL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'al.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:42:19', NULL),
(4, 'Algeria', 'DZA', 'DZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'dz.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:42:36', NULL),
(5, 'American Samoa', 'ASM', 'AS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'as.png', '1', '2023-01-20 05:54:08', '2023-02-17 05:27:30', NULL),
(6, 'Andorra', 'AND', 'AD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ad.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:44:58', NULL),
(7, 'Angola', 'AGO', 'AO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ao.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:45:17', NULL),
(8, 'Anguilla', 'AIA', 'AI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ai.png', '1', '2023-01-20 05:54:08', '2023-02-17 05:51:38', NULL),
(9, 'Antarctica', 'ATA', 'AQ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'aq.png', '1', '2023-01-20 05:54:08', '2023-02-17 05:51:53', NULL),
(10, 'Antigua and Barbuda', 'ATG', 'AG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ag.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:45:39', NULL),
(11, 'Argentina', 'ARG', 'AR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ar.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:46:24', NULL),
(12, 'Armenia', 'ARM', 'AM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'am.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:46:39', NULL),
(13, 'Aruba', 'ABW', 'AW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'aw.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:00:40', NULL),
(14, 'Australia', 'AUS', 'AU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'au.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:46:59', NULL),
(15, 'Austria', 'AUT', 'AT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'at.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:47:48', NULL),
(16, 'Azerbaijan', 'AZE', 'AZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'az.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:48:08', NULL),
(17, 'Bahamas', 'BHS', 'BS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bs.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:48:23', NULL),
(18, 'Bahrain', 'BHR', 'BH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bh.jpg', '1', '2023-01-20 05:54:08', '2023-01-23 05:52:17', NULL),
(19, 'Bangladesh', 'BGD', 'BD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bd.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:50:12', NULL),
(20, 'Barbados', 'BRB', 'BB', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bb.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:55:21', NULL),
(21, 'Belarus', 'BLR', 'BY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'by.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:55:51', NULL),
(22, 'Belgium', 'BEL', 'BE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'be.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:56:06', NULL),
(23, 'Belize', 'BLZ', 'BZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bz.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:56:17', NULL),
(24, 'Benin', 'BEN', 'BJ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bj.png', '1', '2023-01-20 05:54:08', '2023-01-23 05:56:29', NULL),
(25, 'Bermuda', 'BMU', 'BM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bm.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:01:23', NULL),
(26, 'Bhutan', 'BTN', 'BT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bt.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:51:20', NULL),
(27, 'Bolivia', 'BOL', 'BO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bo.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:51:42', NULL),
(28, 'Bonaire', 'BES', 'BQ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bq.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:03:54', NULL),
(29, 'Bosnia and Herzegovina', 'BIH', 'BA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ba.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:52:30', NULL),
(30, 'Botswana', 'BWA', 'BW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bw.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:52:51', NULL),
(31, 'Bouvet Island', 'BVT', 'BV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bv.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:04:29', NULL),
(32, 'Brazil', 'BRA', 'BR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'br.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:53:07', NULL),
(33, 'British Indian Ocean Territory', 'IOT', 'IO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'io.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:04:48', NULL),
(34, 'British Virgin Islands', 'VGB', 'VG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'vg.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:05:08', NULL),
(35, 'Brunei', 'BRN', 'BN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bn.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:53:26', NULL),
(36, 'Bulgaria', 'BGR', 'BG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bg.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:53:40', NULL),
(37, 'Burkina Faso', 'BFA', 'BF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bf.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:53:56', NULL),
(38, 'Burundi', 'BDI', 'BI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bi.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:54:12', NULL),
(39, 'Cambodia', 'KHM', 'KH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kh.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:54:33', NULL),
(40, 'Cameroon', 'CMR', 'CM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cm.png', '1', '2023-01-20 05:54:08', '2023-01-23 06:54:54', NULL),
(41, 'Canada', 'CAN', 'CA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ca.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:03:48', NULL),
(42, 'Cape Verde', 'CPV', 'CV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cv.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:04:10', NULL),
(43, 'Cayman Islands', 'CYM', 'KY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ky.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:04:36', NULL),
(44, 'Central African Republic', 'CAF', 'CF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:05:28', NULL),
(45, 'Chad', 'TCD', 'TD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'td.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:05:23', NULL),
(46, 'Chile', 'CHL', 'CL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cl.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:05:40', NULL),
(47, 'China', 'CHN', 'CN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:05:57', NULL),
(48, 'Christmas Island', 'CXR', 'CX', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cx.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:06:18', NULL),
(49, 'Cocos [Keeling] Islands', 'CCK', 'CC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cc.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:06:41', NULL),
(50, 'Colombia', 'COL', 'CO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'co.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:06:21', NULL),
(51, 'Comoros', 'COM', 'KM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'km.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:07:04', NULL),
(52, 'Cook Islands', 'COK', 'CK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ck.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:07:19', NULL),
(53, 'Costa Rica', 'CRI', 'CR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cr.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:07:07', NULL),
(54, 'Croatia', 'HRV', 'HR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'hr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:07:44', NULL),
(55, 'Cuba', 'CUB', 'CU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cu.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:08:16', NULL),
(56, 'Curacao', 'CUW', 'CW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cw.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:07:28', NULL),
(57, 'Cyprus', 'CYP', 'CY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cy.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:08:35', NULL),
(58, 'Czech Republic', 'CZE', 'CZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:08:51', NULL),
(59, 'Democratic Republic of the Congo', 'COD', 'CD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cd.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:09:12', NULL),
(60, 'Denmark', 'DNK', 'DK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'dk.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:09:21', NULL),
(61, 'Djibouti', 'DJI', 'DJ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'dj.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:10:11', NULL),
(62, 'Dominica', 'DMA', 'DM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'dm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:10:23', NULL),
(63, 'Dominican Republic', 'DOM', 'DO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'do.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:10:35', NULL),
(64, 'East Timor', 'TLS', 'TL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tl.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:10:46', NULL),
(65, 'Ecuador', 'ECU', 'EC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ec.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:03', NULL),
(66, 'Egypt', 'EGY', 'EG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'eg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:14', NULL),
(67, 'El Salvador', 'SLV', 'SV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sv.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:24', NULL),
(68, 'Equatorial Guinea', 'GNQ', 'GQ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gq.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:35', NULL),
(69, 'Eritrea', 'ERI', 'ER', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'er.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:45', NULL),
(70, 'Estonia', 'EST', 'EE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ee.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:11:54', NULL),
(71, 'Ethiopia', 'ETH', 'ET', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'et.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:12:08', NULL),
(72, 'Falkland Islands', 'FLK', 'FK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fk.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:08:47', NULL),
(73, 'Faroe Islands', 'FRO', 'FO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fo.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:09:02', NULL),
(74, 'Fiji', 'FJI', 'FJ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fj.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:12:38', NULL),
(75, 'Finland', 'FIN', 'FI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fi.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:12:51', NULL),
(76, 'France', 'FRA', 'FR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:13:53', NULL),
(77, 'French Guiana', 'GUF', 'GF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:09:22', NULL),
(78, 'French Polynesia', 'PYF', 'PF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:09:37', NULL),
(79, 'French Southern Territories', 'ATF', 'TF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:09:52', NULL),
(80, 'Gabon', 'GAB', 'GA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ga.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:14:13', NULL),
(81, 'Gambia', 'GMB', 'GM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:14:24', NULL),
(82, 'Georgia', 'GEO', 'GE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ge.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:14:36', NULL),
(83, 'Germany', 'DEU', 'DE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'de.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:14:53', NULL),
(84, 'Ghana', 'GHA', 'GH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gh.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:16:01', NULL),
(85, 'Gibraltar', 'GIB', 'GI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gi.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:10:54', NULL),
(86, 'Greece', 'GRC', 'GR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:16:25', NULL),
(87, 'Greenland', 'GRL', 'GL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gl.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:11:09', NULL),
(88, 'Grenada', 'GRD', 'GD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gd.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:16:43', NULL),
(89, 'Guadeloupe', 'GLP', 'GP', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gp.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:11:31', NULL),
(90, 'Guam', 'GUM', 'GU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gu.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:12:00', NULL),
(91, 'Guatemala', 'GTM', 'GT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gt.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:17:04', NULL),
(92, 'Guernsey', 'GGY', 'GG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gg.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:12:29', NULL),
(93, 'Guinea', 'GIN', 'GN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:17:22', NULL),
(94, 'Guinea-Bissau', 'GNB', 'GW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:17:31', NULL),
(95, 'Guyana', 'GUY', 'GY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gy.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:17:41', NULL),
(96, 'Haiti', 'HTI', 'HT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ht.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:17:50', NULL),
(97, 'Heard Island and McDonald Islands', 'HMD', 'HM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'hm.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:12:48', NULL),
(98, 'Honduras', 'HND', 'HN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'hn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:18:05', NULL),
(99, 'Hong Kong', 'HKG', 'HK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'hk.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:13:03', NULL),
(100, 'Hungary', 'HUN', 'HU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'hu.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:18:19', NULL),
(101, 'Iceland', 'ISL', 'IS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'is.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:19:59', NULL),
(102, 'India', 'IND', 'IN', '+91', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'in.png', '1', '2023-01-20 05:54:08', '2023-02-20 00:35:30', NULL),
(103, 'Indonesia', 'IDN', 'ID', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'id.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:20:17', NULL),
(104, 'Iran', 'IRN', 'IR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ir.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:20:29', NULL),
(105, 'Iraq', 'IRQ', 'IQ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'iq.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:20:37', NULL),
(106, 'Ireland', 'IRL', 'IE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ie.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:20:47', NULL),
(107, 'Isle of Man', 'IMN', 'IM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'im.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:13:55', NULL),
(108, 'Israel', 'ISR', 'IL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'il.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:20:56', NULL),
(109, 'Italy', 'ITA', 'IT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'it.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:21:07', NULL),
(110, 'Ivory Coast', 'CIV', 'CI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ci.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:21:29', NULL),
(111, 'Jamaica', 'JAM', 'JM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'jm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:21:39', NULL),
(112, 'Japan', 'JPN', 'JP', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'jp.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:21:48', NULL),
(113, 'Jersey', 'JEY', 'JE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'je.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:14:21', NULL),
(114, 'Jordan', 'JOR', 'JO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'jo.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:22:03', NULL),
(115, 'Kazakhstan', 'KAZ', 'KZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:22:13', NULL),
(116, 'Kenya', 'KEN', 'KE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ke.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:22:23', NULL),
(117, 'Kiribati', 'KIR', 'KI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ki.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:22:34', NULL),
(118, 'Kosovo', 'XKX', 'XK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'xk.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:14:47', NULL),
(119, 'Kuwait', 'KWT', 'KW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:22:56', NULL),
(120, 'Kyrgyzstan', 'KGZ', 'KG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:23:08', NULL),
(121, 'Laos', 'LAO', 'LA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'la.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:23:20', NULL),
(122, 'Latvia', 'LVA', 'LV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lv.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:23:31', NULL),
(123, 'Lebanon', 'LBN', 'LB', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lb.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:23:43', NULL),
(124, 'Lesotho', 'LSO', 'LS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ls.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:23:53', NULL),
(125, 'Liberia', 'LBR', 'LR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:24:03', NULL),
(126, 'Libya', 'LBY', 'LY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ly.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:25:50', NULL),
(127, 'Liechtenstein', 'LIE', 'LI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'li.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:26:22', NULL),
(128, 'Lithuania', 'LTU', 'LT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lt.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:26:55', NULL),
(129, 'Luxembourg', 'LUX', 'LU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lu.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:27:15', NULL),
(130, 'Macao', 'MAC', 'MO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mo.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:15:12', NULL),
(131, 'Macedonia', 'MKD', 'MK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mk.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:28:21', NULL),
(132, 'Madagascar', 'MDG', 'MG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:28:55', NULL),
(133, 'Malawi', 'MWI', 'MW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:30:21', NULL),
(134, 'Malaysia', 'MYS', 'MY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'my.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:30:43', NULL),
(135, 'Maldives', 'MDV', 'MV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mv.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:31:58', NULL),
(136, 'Mali', 'MLI', 'ML', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ml.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:32:14', NULL),
(137, 'Malta', 'MLT', 'MT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mt.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:32:23', NULL),
(138, 'Marshall Islands', 'MHL', 'MH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mh.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:32:32', NULL),
(139, 'Martinique', 'MTQ', 'MQ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mq.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:16:48', NULL),
(140, 'Mauritania', 'MRT', 'MR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:32:55', NULL),
(141, 'Mauritius', 'MUS', 'MU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mu.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:33:03', NULL),
(142, 'Mayotte', 'MYT', 'YT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'yt.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:17:13', NULL),
(143, 'Mexico', 'MEX', 'MX', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mx.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:34:12', NULL),
(144, 'Micronesia', 'FSM', 'FM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'fm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:34:21', NULL),
(145, 'Moldova', 'MDA', 'MD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'md.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:34:36', NULL),
(146, 'Monaco', 'MCO', 'MC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mc.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:34:50', NULL),
(147, 'Mongolia', 'MNG', 'MN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:35:05', NULL),
(148, 'Montenegro', 'MNE', 'ME', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'me.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:35:15', NULL),
(149, 'Montserrat', 'MSR', 'MS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ms.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:17:33', NULL),
(150, 'Morocco', 'MAR', 'MA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ma.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:35:54', NULL),
(151, 'Mozambique', 'MOZ', 'MZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:36:45', NULL),
(152, 'Myanmar [Burma]', 'MMR', 'MM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:36:54', NULL),
(153, 'Namibia', 'NAM', 'NA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'na.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:37:03', NULL),
(154, 'Nauru', 'NRU', 'NR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:37:10', NULL),
(155, 'Nepal', 'NPL', 'NP', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'np.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:38:18', NULL),
(156, 'Netherlands', 'NLD', 'NL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nl.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:38:26', NULL),
(157, 'New Caledonia', 'NCL', 'NC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nc.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:18:28', NULL),
(158, 'New Zealand', 'NZL', 'NZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:38:45', NULL),
(159, 'Nicaragua', 'NIC', 'NI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ni.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:38:54', NULL),
(160, 'Niger', 'NER', 'NE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ne.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:39:02', NULL),
(161, 'Nigeria', 'NGA', 'NG', '+234', 'Y', 'Y', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'ng.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:39:12', NULL),
(162, 'Niue', 'NIU', 'NU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nu.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:19:37', NULL),
(163, 'Norfolk Island', 'NFK', 'NF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'nf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:20:15', NULL),
(164, 'North Korea', 'PRK', 'KP', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kp.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:39:43', NULL),
(165, 'Northern Mariana Islands', 'MNP', 'MP', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mp.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:20:39', NULL),
(166, 'Norway', 'NOR', 'NO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'no.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:03', NULL),
(167, 'Oman', 'OMN', 'OM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'om.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:14', NULL),
(168, 'Pakistan', 'PAK', 'PK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pk.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:22', NULL),
(169, 'Palau', 'PLW', 'PW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:32', NULL),
(170, 'Palestine', 'PSE', 'PS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ps.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:20:58', NULL),
(171, 'Panama', 'PAN', 'PA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pa.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:39', NULL),
(172, 'Papua New Guinea', 'PNG', 'PG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:40:47', NULL),
(173, 'Paraguay', 'PRY', 'PY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'py.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:41:02', NULL),
(174, 'Peru', 'PER', 'PE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pe.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:41:11', NULL),
(175, 'Philippines', 'PHL', 'PH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ph.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:41:19', NULL),
(176, 'Pitcairn Islands', 'PCN', 'PN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pn.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:21:25', NULL),
(177, 'Poland', 'POL', 'PL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pl.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:44:36', NULL),
(178, 'Portugal', 'PRT', 'PT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pt.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:44:45', NULL),
(179, 'Puerto Rico', 'PRI', 'PR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pr.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:21:48', NULL),
(180, 'Qatar', 'QAT', 'QA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'qa.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:45:02', NULL),
(181, 'Republic of the Congo', 'COG', 'CG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'cg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:45:11', NULL),
(182, 'Réunion', 'REU', 'RE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 're.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:22:04', NULL),
(183, 'Romania', 'ROU', 'RO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ro.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:45:28', NULL),
(184, 'Russia', 'RUS', 'RU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ru.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:45:37', NULL),
(185, 'Rwanda', 'RWA', 'RW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'rw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:45:44', NULL),
(186, 'Saint Barthélemy', 'BLM', 'BL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'bl.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:22:37', NULL),
(187, 'Saint Helena', 'SHN', 'SH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sh.jpg', '1', '2023-01-20 05:54:08', '2023-02-17 06:23:08', NULL),
(188, 'Saint Kitts and Nevis', 'KNA', 'KN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:46:12', NULL),
(189, 'Saint Lucia', 'LCA', 'LC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lc.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:46:21', NULL),
(190, 'Saint Martin', 'MAF', 'MF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'mf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:23:56', NULL),
(191, 'Saint Pierre and Miquelon', 'SPM', 'PM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'pm.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:24:12', NULL),
(192, 'Saint Vincent and the Grenadines', 'VCT', 'VC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'vc.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:46:45', NULL),
(193, 'Samoa', 'WSM', 'WS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ws.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:46:54', NULL),
(194, 'San Marino', 'SMR', 'SM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sm.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:24:30', NULL),
(195, 'São Tomé and Príncipe', 'STP', 'ST', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'st.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:01', NULL),
(196, 'Saudi Arabia', 'SAU', 'SA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sa.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:09', NULL),
(197, 'Senegal', 'SEN', 'SN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:16', NULL),
(198, 'Serbia', 'SRB', 'RS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'rs.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:31', NULL),
(199, 'Seychelles', 'SYC', 'SC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sc.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:39', NULL),
(200, 'Sierra Leone', 'SLE', 'SL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sl.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:47:47', NULL),
(201, 'Singapore', 'SGP', 'SG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:01', NULL),
(202, 'Sint Maarten', 'SXM', 'SX', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sx.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:24:51', NULL),
(203, 'Slovakia', 'SVK', 'SK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sk.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:18', NULL),
(204, 'Slovenia', 'SVN', 'SI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'si.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:25', NULL),
(205, 'Solomon Islands', 'SLB', 'SB', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sb.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:35', NULL),
(206, 'Somalia', 'SOM', 'SO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'so.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:43', NULL),
(207, 'South Africa', 'ZAF', 'ZA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'za.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:50:51', NULL),
(208, 'South Georgia and the South Sandwich Islands', 'SGS', 'GS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'gs.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:25:09', NULL),
(209, 'South Korea', 'KOR', 'KR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'kr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:51:11', NULL),
(210, 'South Sudan', 'SSD', 'SS', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ss.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:25:24', NULL),
(211, 'Spain', 'ESP', 'ES', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'es.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:11', NULL),
(212, 'Sri Lanka', 'LKA', 'LK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'lk.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:18', NULL),
(213, 'Sudan', 'SDN', 'SD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sd.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:25', NULL),
(214, 'Suriname', 'SUR', 'SR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:36', NULL),
(215, 'Svalbard and Jan Mayen', 'SJM', 'SJ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sj.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:25:42', NULL),
(216, 'Swaziland', 'SWZ', 'SZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:51', NULL),
(217, 'Sweden', 'SWE', 'SE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'se.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:52:57', NULL),
(218, 'Switzerland', 'CHE', 'CH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ch.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:53:04', NULL),
(219, 'Syria', 'SYR', 'SY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'sy.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:53:11', NULL),
(220, 'Taiwan', 'TWN', 'TW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tw.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:53:24', NULL),
(221, 'Tajikistan', 'TJK', 'TJ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tj.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:54:01', NULL),
(222, 'Tanzania', 'TZA', 'TZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:54:08', NULL),
(223, 'Thailand', 'THA', 'TH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'th.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:54:14', NULL),
(224, 'Togo', 'TGO', 'TG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tg.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:54:19', NULL),
(225, 'Tokelau', 'TKL', 'TK', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tk.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:25:57', NULL),
(226, 'Tonga', 'TON', 'TO', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'to.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:55:01', NULL),
(227, 'Trinidad and Tobago', 'TTO', 'TT', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tt.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:55:07', NULL),
(228, 'Tunisia', 'TUN', 'TN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:55:13', NULL),
(229, 'Turkey', 'TUR', 'TR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tr.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:55:21', NULL),
(230, 'Turkmenistan', 'TKM', 'TM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tm.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:55:32', NULL),
(231, 'Turks and Caicos Islands', 'TCA', 'TC', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tc.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:26:15', NULL),
(232, 'Tuvalu', 'TUV', 'TV', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'tv.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:56:12', NULL),
(233, 'U.S. Minor Outlying Islands', 'UMI', 'UM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'um.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:26:29', NULL),
(234, 'U.S. Virgin Islands', 'VIR', 'VI', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'vi.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:26:43', NULL),
(235, 'Uganda', 'UGA', 'UG', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ug.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:56:38', NULL),
(236, 'Ukraine', 'UKR', 'UA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ua.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:57:28', NULL),
(237, 'United Arab Emirates', 'ARE', 'AE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ae.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:57:19', NULL),
(238, 'United Kingdom', 'GBR', 'GB', '+44', 'Y', 'Y', 'N', 'Y', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'gb.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:57:07', NULL),
(239, 'United States', 'USA', 'US', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'us.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:58:13', NULL),
(240, 'Uruguay', 'URY', 'UY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'uy.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:58:21', NULL),
(241, 'Uzbekistan', 'UZB', 'UZ', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'uz.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:58:35', NULL),
(242, 'Vanuatu', 'VUT', 'VU', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'vu.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:58:42', NULL),
(243, 'Vatican City', 'VAT', 'VA', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'va.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:59:15', NULL),
(244, 'Venezuela', 'VEN', 'VE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 've.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:59:22', NULL),
(245, 'Vietnam', 'VNM', 'VN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'vn.png', '1', '2023-01-20 05:54:08', '2023-01-23 07:59:41', NULL),
(246, 'Wallis and Futuna', 'WLF', 'WF', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'wf.png', '1', '2023-01-20 05:54:08', '2023-02-17 06:26:59', NULL),
(247, 'Western Sahara', 'ESH', 'EH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'eh.png', '1', '2023-01-20 05:54:08', '2023-01-23 08:00:09', NULL),
(248, 'Yemen', 'YEM', 'YE', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'ye.png', '1', '2023-01-20 05:54:08', '2023-01-23 08:00:17', NULL),
(249, 'Zambia', 'ZMB', 'ZM', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'zm.png', '1', '2023-01-20 05:54:08', '2023-01-23 08:00:34', NULL),
(250, 'Zimbabwe', 'ZWE', 'ZW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'zw.png', '1', '2023-01-20 05:54:08', '2023-01-23 08:00:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_currencies`
--

CREATE TABLE `fc_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `three_digit_currency_code` varchar(100) DEFAULT NULL,
  `country_code_for_phone` varchar(5) DEFAULT NULL,
  `require_account_holder` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_account_number` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_iban_number` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_uk_short_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_ach_routing_number` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_account_type` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_beneficiary_bank` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `require_ifsc_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_country` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_city` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_address` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `require_postal_code` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'N=>No, Y=>Yes',
  `exchange_rate` text DEFAULT NULL,
  `available_transfer_option` text DEFAULT NULL COMMENT 'Keys of the array with comma separated values',
  `is_euro_available` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `available_euro_transfer_option` text DEFAULT NULL COMMENT 'Keys of the array with comma separated values',
  `is_usd_available` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `available_usd_transfer_option` text DEFAULT NULL COMMENT 'Keys of the array with comma separated values',
  `bank_image` varchar(255) DEFAULT NULL,
  `serial_number` int(11) DEFAULT NULL,
  `show_in_sender` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `show_in_receiver` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_currencies`
--

INSERT INTO `fc_currencies` (`id`, `country_id`, `currency`, `three_digit_currency_code`, `country_code_for_phone`, `require_account_holder`, `require_account_number`, `require_iban_number`, `require_uk_short_code`, `require_ach_routing_number`, `require_account_type`, `require_beneficiary_bank`, `require_ifsc_code`, `require_country`, `require_city`, `require_address`, `require_postal_code`, `exchange_rate`, `available_transfer_option`, `is_euro_available`, `available_euro_transfer_option`, `is_usd_available`, `available_usd_transfer_option`, `bank_image`, `serial_number`, `show_in_sender`, `show_in_receiver`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 238, 'Great Britain Pound', 'GBP', '+44', 'Y', 'Y', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1\",\"2\":\"1.2\",\"3\":\"00550\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null}}', 'N', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null}}', 'N', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null}}', NULL, 1, 'Y', 'Y', '1', '2023-01-20 05:54:08', '2023-01-24 06:13:53', NULL),
(2, 76, 'EURO', 'EUR', '+234', 'Y', 'Y', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1.2\",\"2\":\"1\",\"3\":\"00455\",\"4\":\"1356\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null}}', 'N', '{\"3\":{\"id\":\"3\",\"avaliable_in\":null,\"description\":null}}', 'N', '[]', '', 2, 'Y', 'Y', '1', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(3, 161, 'Naira', 'NGN', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"550\",\"2\":\"450\",\"3\":\"1\",\"4\":\"1354.11\",\"5\":\"1\",\"6\":\"17.05\",\"7\":\"1\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null},\"3\":{\"id\":\"3\",\"avaliable_in\":null,\"description\":null}}', 'N', NULL, 'N', NULL, '', 3, 'N', 'Y', '1', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(4, 209, 'KRW', 'KRW', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1574\",\"2\":\"1574\",\"3\":\"1574\",\"4\":\"1574\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":\"Send GBP for KRW\"},\"3\":{\"id\":\"3\",\"avaliable_in\":null,\"description\":\"Transfer GBP for KRW\"}}', 'N', NULL, 'N', NULL, NULL, 4, 'N', 'Y', '1', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(5, 111, 'JMD', 'JMD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1\",\"2\":\"1\",\"3\":\"582.1\",\"4\":\"210.7\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":\"GBP for JMD\",\"description\":\"Send GBP for JMD\"},\"3\":{\"id\":\"3\",\"avaliable_in\":\"GBP JMD\",\"description\":\"Send GBP for JMD\"}}', 'N', NULL, 'N', NULL, NULL, 5, 'N', 'Y', '0', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(6, 84, 'GH', 'GH', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1\",\"2\":\"1\",\"3\":\"582\",\"4\":\"1354\",\"5\":\"0.36\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":\"GBP for GH\",\"description\":\"GBP for GH\"}}', 'N', NULL, 'N', NULL, NULL, 6, 'N', 'Y', '0', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(7, 207, 'ZAR', 'ZAR', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1\",\"2\":\"1\",\"3\":\"584.2\",\"4\":\"1354.1\",\"5\":\"210.3\",\"6\":\"7.05\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null},\"3\":{\"id\":\"3\",\"avaliable_in\":null,\"description\":null}}', 'N', NULL, 'N', NULL, NULL, 6, 'N', 'Y', '1', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(8, 32, 'BRL', 'BRL', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"7.1\",\"2\":\"6.03\",\"3\":\"6.19\",\"4\":\"2.17\",\"7\":\"14.7\",\"8\":\"7.07\",\"9\":null,\"10\":null}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":\"1111\",\"description\":\"Send a bank transfer and add your receiver\"},\"3\":{\"id\":\"3\",\"avaliable_in\":\"44444\",\"description\":\"Send a Swift transfer\"}}', 'N', NULL, 'N', NULL, NULL, 8, 'N', 'Y', '1', '2023-01-20 05:54:08', '2023-01-23 08:19:58', NULL),
(9, 47, 'GBP', 'CNY', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"8.10\",\"2\":\"1.18\",\"3\":\"0\",\"4\":\"0\",\"5\":\"0\",\"6\":\"11.70\",\"7\":\"0\",\"8\":\"0\"}', '{\"1\":{\"id\":\"1\",\"avaliable_in\":null,\"description\":null},\"3\":{\"id\":\"3\",\"avaliable_in\":null,\"description\":null}}', 'N', NULL, 'N', NULL, NULL, 87, 'Y', 'Y', '1', '2023-01-20 05:54:08', '2023-01-20 05:54:08', NULL),
(10, 239, 'GBP', 'USD', NULL, 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '{\"1\":\"1.18\",\"2\":\"1.00\",\"3\":\"692\",\"4\":\"0.00075\",\"5\":\"0\",\"6\":\"0\",\"7\":\"0\",\"8\":\"0\",\"9\":\"0\"}', '[]', 'N', NULL, 'N', NULL, NULL, 2, 'Y', 'Y', '1', '2023-01-20 05:54:08', '2023-01-23 04:04:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_failed_jobs`
--

CREATE TABLE `fc_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_migrations`
--

CREATE TABLE `fc_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_migrations`
--

INSERT INTO `fc_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_12_122406_create_website_settings_table', 1),
(6, '2023_01_12_122434_create_roles_table', 1),
(7, '2023_01_12_122540_create_user_roles_table', 1),
(8, '2023_01_17_112803_create_cms_table', 1),
(9, '2023_01_19_082506_create_countries_table', 1),
(10, '2023_01_20_095338_create_currencies_table', 1),
(11, '2023_01_24_061931_create_transfer_fees_table', 2),
(12, '2023_01_23_053738_create_banks_table', 3),
(13, '2023_01_24_091343_create_money_transfers_table', 3),
(14, '2023_01_30_114712_create_roles_table', 3),
(15, '2023_01_31_061439_create_role_pages_table', 4),
(16, '2023_01_31_122526_create_role_permissions_table', 5),
(17, '2023_01_31_062834_create_user_details_table', 6),
(18, '2023_02_03_095219_create_recipients_table', 7),
(19, '2023_02_20_122753_create_temporary_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `fc_money_transfers`
--

CREATE TABLE `fc_money_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `bank_account_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `recipient_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `transfer_no` varchar(255) DEFAULT NULL,
  `send_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `send_currency` varchar(255) DEFAULT NULL,
  `sender_country_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sender_currency_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `transfer_fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `exchange_rate` double(8,2) NOT NULL DEFAULT 0.00,
  `received_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `received_currency` varchar(255) DEFAULT NULL,
  `recipient_currency_id` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(255) DEFAULT NULL,
  `reference_note` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `transfer_datetime` datetime DEFAULT NULL,
  `transactionId` varchar(255) DEFAULT NULL,
  `xref_code` text DEFAULT NULL,
  `responseCode` int(11) NOT NULL DEFAULT 10 COMMENT '0 - Successful / authorised transaction., 2 - Card referred., 4 - Card declined – keep card., 5 - Card declined.',
  `payment_state` varchar(255) DEFAULT NULL,
  `authorisationCode` text DEFAULT NULL,
  `responseMessage` text DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL,
  `transfer_bank_reference_id` text DEFAULT NULL,
  `amount_paid` text DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `payment_type` enum('B','O') NOT NULL DEFAULT 'B' COMMENT 'B - Bank Transfer / O - Online Payment',
  `payment_status` enum('P','U','V') NOT NULL DEFAULT 'U' COMMENT 'P - Paid / U - Unpaid / V - Paid but in verification',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Pending / 1 - Completed / 2 - More details required / 3 - Cancelled / 4 - Proceed to pay / 5 - In verification',
  `forex_country_transfer_status` enum('P','U') NOT NULL DEFAULT 'U' COMMENT 'P - Paid / U - Unpaid',
  `from_home` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Not coming from home page / 1 - From home page',
  `transfer_fee_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL COMMENT 'Reason for cancellation or any other status',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_money_transfers`
--

INSERT INTO `fc_money_transfers` (`id`, `user_id`, `bank_account_id`, `recipient_id`, `transfer_no`, `send_amount`, `send_currency`, `sender_country_id`, `sender_currency_id`, `transfer_fees`, `exchange_rate`, `received_amount`, `received_currency`, `recipient_currency_id`, `reference`, `reference_note`, `note`, `transfer_datetime`, `transactionId`, `xref_code`, `responseCode`, `payment_state`, `authorisationCode`, `responseMessage`, `transaction_time`, `transfer_bank_reference_id`, `amount_paid`, `account_holder_name`, `payment_type`, `payment_status`, `status`, `forex_country_transfer_status`, `from_home`, `transfer_fee_id`, `reason`, `deleted_at`, `created_at`, `updated_at`) VALUES
(237, 1, 1, 1, 'FC-00000237', '32.00', 'GBP', 238, 2, '0.00', 458.00, '14656.00', 'NGN', 2, NULL, 'funding', NULL, '2023-01-18 16:43:11', '38599172', '19061100NP08DM50PV48ZGD', 65803, 'finished', NULL, '3DS NOT AUTHENTICATED', '2019-06-10 23:39:17', NULL, NULL, NULL, 'O', 'U', 2, 'U', 0, 2, 'Hello Harrison, I noticed that you initiated a transaction on our platform. Our rates have changed but will do this one off if you are able to complete the transaction before 10am today.\r\n\r\nThank you\r\n\r\nBenjamin Alegba', NULL, '2019-06-09 19:50:49', '2020-10-08 03:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `fc_password_resets`
--

CREATE TABLE `fc_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_personal_access_tokens`
--

CREATE TABLE `fc_personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_recipients`
--

CREATE TABLE `fc_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `account_holder_name` varchar(150) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `email_verification_code` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `country` int(10) UNSIGNED NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `type` enum('P','B') NOT NULL DEFAULT 'B',
  `iban_number` varchar(255) DEFAULT NULL,
  `ach_routing_number` varchar(255) DEFAULT NULL,
  `account_type` enum('C','S') DEFAULT NULL COMMENT 'C - Checking / S - Savings',
  `beneficiary_bank` varchar(255) DEFAULT NULL,
  `beneficiary_bank_code` varchar(255) DEFAULT NULL,
  `currency` int(10) UNSIGNED NOT NULL,
  `delivery_method` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Null / 1 - Bank Deposit / 2 - Cash Pickup / 3 - Swift',
  `swift_bic` varchar(255) DEFAULT NULL,
  `deleted_by_user` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y - Yes / N - No',
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_roles`
--

CREATE TABLE `fc_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `is_admin` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_roles`
--

INSERT INTO `fc_roles` (`id`, `name`, `slug`, `is_admin`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'super-admin', '1', '1', '2023-01-20 05:28:55', '2023-01-20 05:28:55', NULL),
(4, 'Country Editor', 'country-editor-1', '1', '1', '2023-01-31 07:07:32', '2023-01-31 13:22:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_role_pages`
--

CREATE TABLE `fc_role_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `routeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_role_pages`
--

INSERT INTO `fc_role_pages` (`id`, `routeName`) VALUES
(1, 'auth.forgot-password'),
(2, 'auth.reset-password'),
(3, 'account.dashboard'),
(4, 'account.profile'),
(5, 'account.'),
(6, 'account.change-password'),
(7, 'account.settings'),
(8, 'auth.logout'),
(9, 'cms.list'),
(10, 'cms.create'),
(11, 'cms.edit'),
(12, 'cms.'),
(13, 'cms.change-status'),
(14, 'cms.delete'),
(15, 'country.list'),
(16, 'country.create'),
(17, 'country.edit'),
(18, 'country.'),
(19, 'country.change-status'),
(20, 'country.delete'),
(21, 'currency.list'),
(22, 'currency.create'),
(23, 'currency.edit'),
(24, 'currency.'),
(25, 'currency.change-status'),
(26, 'currency.delete'),
(27, 'currency.transfer-fees.transfer-fees-list'),
(28, 'currency.transfer-fees.transfer-fees-create'),
(29, 'currency.transfer-fees.transfer-fees-edit'),
(30, 'currency.transfer-fees.'),
(31, 'currency.transfer-fees.transfer-fees-change-status'),
(32, 'currency.transfer-fees.transfer-fees-delete'),
(33, 'bank.list'),
(34, 'bank.create'),
(35, 'bank.edit'),
(36, 'bank.'),
(37, 'bank.change-status'),
(38, 'bank.delete'),
(39, 'money-transfer.list'),
(40, 'money-transfer.create'),
(41, 'money-transfer.edit'),
(42, 'money-transfer.'),
(43, 'money-transfer.change-status'),
(44, 'money-transfer.delete'),
(45, 'role.list'),
(46, 'role.create'),
(47, 'role.edit'),
(48, 'role.change-status'),
(49, 'role.delete'),
(50, 'moneyTransfer.list'),
(51, 'moneyTransfer.create'),
(52, 'moneyTransfer.edit'),
(53, 'moneyTransfer.change-status'),
(54, 'moneyTransfer.delete'),
(55, 'money-transfer.view'),
(56, 'user.list'),
(57, 'user.create'),
(58, 'user.edit'),
(59, 'user.change-status'),
(60, 'user.delete');

-- --------------------------------------------------------

--
-- Table structure for table `fc_role_permissions`
--

CREATE TABLE `fc_role_permissions` (
  `role_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_temporary_users`
--

CREATE TABLE `fc_temporary_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL COMMENT 'Token for further steps of signup',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_transfer_fees`
--

CREATE TABLE `fc_transfer_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `fees` double(10,2) NOT NULL DEFAULT 0.00,
  `fee_type` enum('F','P') NOT NULL DEFAULT 'F' COMMENT 'F => Flat, P => Percentage',
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_transfer_fees`
--

INSERT INTO `fc_transfer_fees` (`id`, `currency_id`, `country_id`, `fees`, `fee_type`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 10, 239, 30.00, 'F', 'dsfdsfdsf', '<p>zs zxcxz cxz cxc v xcvxc bg dfdgdfgdfgd</p>', '1', '2023-01-24 04:45:42', '2023-01-25 00:18:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_users`
--

CREATE TABLE `fc_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL COMMENT 'Id from countries table',
  `address` text DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `verification_code` int(11) DEFAULT NULL COMMENT 'Verification code for registration',
  `otp` int(11) DEFAULT NULL COMMENT 'OTP for verification for forgot password',
  `type` enum('SA','A','U','C','AD') NOT NULL DEFAULT 'C' COMMENT 'SA=>Super Admin, A=>Sub Admin, U=>User, C=>Customer, AG=>Agent',
  `agree` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'N=>No, Y=>Yes',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Inactive, 1=>Active',
  `lastlogintime` int(11) DEFAULT NULL,
  `sample_login_show` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Y=>Yes, N=>No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_users`
--

INSERT INTO `fc_users` (`id`, `nickname`, `title`, `first_name`, `last_name`, `full_name`, `username`, `email`, `email_verified_at`, `phone_no`, `password`, `profile_pic`, `country_id`, `address`, `role_id`, `remember_token`, `auth_token`, `device_token`, `verification_code`, `otp`, `type`, `agree`, `status`, `lastlogintime`, `sample_login_show`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, NULL, NULL, 'John', 'Doe', 'John Doe', NULL, 'admin@admin.com', NULL, '9876543210', '$2y$10$sUrnG16e1TkaNca4Oj9oD.0.0awm5Y9KXv4J/Zospm003MLsWcCya', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'SA', 'Y', '1', 1676955628, 'Y', '2023-02-24 07:27:30', '2023-02-24 07:27:30', NULL),
(3, NULL, NULL, 'Adamas', 'Gomes', 'Adamas Gomes', NULL, 'adamas@yopmail.com', NULL, '9876543210', '$2y$10$oEt/yQXdl3J.cvkkqkb0kOtIYhV31w9E2nrkhL9CfMCsD34OjiLou', NULL, 102, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', 'Y', '1', NULL, 'N', '2023-02-24 07:33:34', '2023-02-24 07:33:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fc_user_details`
--

CREATE TABLE `fc_user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('P','B') NOT NULL DEFAULT 'P',
  `is_email_verified` enum('Y','N') NOT NULL DEFAULT 'N',
  `email_verification_code` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country_code` varchar(50) DEFAULT NULL,
  `is_phone_verified` enum('Y','N') NOT NULL DEFAULT 'N',
  `phone_verification_code` text DEFAULT NULL,
  `country` int(10) UNSIGNED NOT NULL,
  `city` varchar(150) DEFAULT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `building_name` varchar(255) DEFAULT NULL,
  `flat_suit` varchar(255) DEFAULT NULL,
  `business_country` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `company_type` varchar(255) DEFAULT NULL,
  `role_in_company` varchar(255) DEFAULT NULL,
  `registration_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `business_address` text DEFAULT NULL,
  `business_city` varchar(255) DEFAULT NULL,
  `business_post_code` varchar(255) DEFAULT NULL,
  `is_two_step_verification_active` enum('Y','N') NOT NULL DEFAULT 'N',
  `photo_id_proof` varchar(255) DEFAULT NULL,
  `is_photo_id_proof_verified` enum('Y','N') NOT NULL DEFAULT 'N',
  `occupation` varchar(255) DEFAULT NULL,
  `proof_of_address` varchar(255) DEFAULT NULL,
  `proof_of_bank_account_details` varchar(255) DEFAULT NULL,
  `proof_of_last_10_transction_in_bank_account` varchar(255) DEFAULT NULL,
  `proof_of_money_in_bank_account` varchar(255) DEFAULT NULL,
  `fackbook_id` text DEFAULT NULL,
  `google_id` text DEFAULT NULL,
  `is_profile_complete` enum('Y','N') NOT NULL DEFAULT 'N',
  `from_currency` varchar(255) DEFAULT NULL,
  `to_currency` varchar(255) DEFAULT NULL,
  `amount_limit` varchar(255) DEFAULT NULL,
  `blockpass_recordid` varchar(255) DEFAULT NULL,
  `blockpass_refid` varchar(255) DEFAULT NULL,
  `blockpass_approved` enum('Y','N') NOT NULL DEFAULT 'N',
  `blockpass_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`blockpass_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_user_roles`
--

CREATE TABLE `fc_user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_website_settings`
--

CREATE TABLE `fc_website_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `website_title` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `pinterest_link` varchar(255) DEFAULT NULL,
  `googleplus_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `rss_link` varchar(255) DEFAULT NULL,
  `dribble_link` varchar(255) DEFAULT NULL,
  `tumblr_link` varchar(255) DEFAULT NULL,
  `default_meta_title` text DEFAULT NULL,
  `default_meta_keywords` text DEFAULT NULL,
  `default_meta_description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `footer_address` text DEFAULT NULL,
  `copyright_text` text DEFAULT NULL,
  `tag_line` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fc_website_settings`
--

INSERT INTO `fc_website_settings` (`id`, `from_email`, `to_email`, `website_title`, `phone_no`, `fax`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `pinterest_link`, `googleplus_link`, `youtube_link`, `rss_link`, `dribble_link`, `tumblr_link`, `default_meta_title`, `default_meta_keywords`, `default_meta_description`, `address`, `footer_address`, `copyright_text`, `tag_line`, `logo`, `footer_logo`) VALUES
(1, 'admin@admin.com', 'admin@admin.com', 'Forex County Admin', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'logo.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fc_banks`
--
ALTER TABLE `fc_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fc_banks_country_id_foreign` (`country_id`);

--
-- Indexes for table `fc_cms`
--
ALTER TABLE `fc_cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_countries`
--
ALTER TABLE `fc_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_currencies`
--
ALTER TABLE `fc_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_failed_jobs`
--
ALTER TABLE `fc_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fc_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fc_migrations`
--
ALTER TABLE `fc_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_money_transfers`
--
ALTER TABLE `fc_money_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_password_resets`
--
ALTER TABLE `fc_password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `fc_personal_access_tokens`
--
ALTER TABLE `fc_personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fc_personal_access_tokens_token_unique` (`token`),
  ADD KEY `fc_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `fc_recipients`
--
ALTER TABLE `fc_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fc_recipients_user_id_foreign` (`user_id`);

--
-- Indexes for table `fc_roles`
--
ALTER TABLE `fc_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_role_pages`
--
ALTER TABLE `fc_role_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_temporary_users`
--
ALTER TABLE `fc_temporary_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_transfer_fees`
--
ALTER TABLE `fc_transfer_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_users`
--
ALTER TABLE `fc_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_user_details`
--
ALTER TABLE `fc_user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fc_user_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `fc_website_settings`
--
ALTER TABLE `fc_website_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fc_banks`
--
ALTER TABLE `fc_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fc_cms`
--
ALTER TABLE `fc_cms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fc_countries`
--
ALTER TABLE `fc_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `fc_currencies`
--
ALTER TABLE `fc_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fc_failed_jobs`
--
ALTER TABLE `fc_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_migrations`
--
ALTER TABLE `fc_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fc_money_transfers`
--
ALTER TABLE `fc_money_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `fc_personal_access_tokens`
--
ALTER TABLE `fc_personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_recipients`
--
ALTER TABLE `fc_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_roles`
--
ALTER TABLE `fc_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fc_role_pages`
--
ALTER TABLE `fc_role_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `fc_temporary_users`
--
ALTER TABLE `fc_temporary_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fc_transfer_fees`
--
ALTER TABLE `fc_transfer_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fc_users`
--
ALTER TABLE `fc_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fc_user_details`
--
ALTER TABLE `fc_user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_website_settings`
--
ALTER TABLE `fc_website_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fc_banks`
--
ALTER TABLE `fc_banks`
  ADD CONSTRAINT `fc_banks_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `fc_countries` (`id`);

--
-- Constraints for table `fc_recipients`
--
ALTER TABLE `fc_recipients`
  ADD CONSTRAINT `fc_recipients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fc_user_details`
--
ALTER TABLE `fc_user_details`
  ADD CONSTRAINT `fc_user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fc_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
