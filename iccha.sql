-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2023 at 06:51 AM
-- Server version: 5.7.37
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iccha`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int(11) NOT NULL,
  `adesc` text NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`id`, `adesc`, `modified_at`) VALUES
(1, '<p>AboutsS</p>', '2022-11-05 14:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `status`, `created_at`) VALUES
(1, 'admin', '$2y$10$SywMmu2nU3KYzIVSwRzSz.tSA0izvdk0RmSzVBc2xmE5UgPueqKPm', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ad_banner` varchar(255) NOT NULL,
  `ad_name` varchar(150) NOT NULL,
  `ad_link` varchar(150) NOT NULL,
  `above` tinyint(4) NOT NULL DEFAULT '1',
  `below` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL COMMENT '0- Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `ad_banner`, `ad_name`, `ad_link`, `above`, `below`, `status`, `created_at`, `modified_at`) VALUES
(1, 'assets/ads/ICCHA31043.jpg', 'Get up to 20% OFF SPORTS OUTFITS Collection', 'https://www.myntra.com/', 0, 0, 0, '2022-11-05 10:56:06', '2022-11-05 11:49:56'),
(2, 'assets/ads/ICCHA68387.jpg', 'New Arrivals ACCESSORIES Collection', 'https://www.myntra.com/', 0, 0, 0, '2022-11-05 10:56:35', '2022-11-05 11:50:13'),
(3, 'assets/ads/ICCHA13818.jpg', 'NATURAL PROCESS Cosmetic Makeup Professional', 'https://www.myntra.com/', 0, 0, 0, '2022-11-05 10:56:49', '2022-11-05 11:50:29'),
(4, 'assets/ads/ICCHA78018.jpg', 'TRENDING NOW Women&#039;s Lifestyle Collection', 'https://www.myntra.com/', 0, 0, 0, '2022-11-05 10:57:07', '2022-11-23 16:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `areaname` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `cid`, `areaname`, `status`, `created_at`, `modified_at`) VALUES
(3, 1, 'Bengaluru South', 0, '2022-08-12 10:41:16', '2022-08-12 12:52:15'),
(4, 1, 'Bengaluru North', 0, '2022-08-12 15:15:34', ''),
(5, 1, 'Basavanagudi', 0, '2022-08-17 15:50:27', ''),
(6, 1, 'Bengaluru East', 0, '2022-08-17 15:52:18', '2022-08-17 15:52:25'),
(7, 1, 'Bengaluru West', 0, '2022-08-17 15:52:43', ''),
(8, 1, 'Bengaluru Central', 0, '2022-08-17 15:52:56', ''),
(9, 1, 'Bengaluru All', 0, '2022-08-17 15:53:10', ''),
(10, 1, 'Indira Nagar, Bengaluru', 0, '2022-08-17 15:53:44', '2022-08-17 15:55:01'),
(11, 1, 'Jayanagar, Bengaluru', 0, '2022-08-17 15:54:34', '2022-08-17 15:55:12'),
(12, 1, 'Koramangala, Bengaluru', 0, '2022-08-17 15:56:13', '2022-08-17 15:56:24'),
(14, 11, 'Kolkata South', 0, '2022-09-12 13:20:23', '2022-10-17 20:00:59'),
(23, 51, 'Ahmednagar', 0, '2022-11-03 11:08:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `b_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `tdesc` varchar(255) NOT NULL,
  `banner_img` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Acctive, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_img` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0- Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `brand_img`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Nike', 'assets/brand/ICCHA56510.jpg', 0, '2022-11-07 16:25:13', ''),
(2, 'Adidas', 'assets/brand/ICCHA41319.jpg', 0, '2022-11-07 16:25:27', ''),
(3, 'Puma', 'assets/brand/ICCHA31754.jpg', 0, '2022-11-07 16:25:48', ''),
(4, 'Toyota', 'assets/brand/ICCHA81325.jpg', 0, '2022-11-07 16:26:05', ''),
(5, 'Cococola', 'assets/brand/ICCHA16828.jpg', 0, '2022-11-07 16:26:31', ''),
(6, 'Google', 'assets/brand/ICCHA50654.jpg', 0, '2022-11-07 16:29:30', ''),
(7, 'Youtube', 'assets/brand/ICCHA82623.jpg', 0, '2022-11-07 16:31:17', ''),
(8, 'Yahoo', 'assets/brand/ICCHA59225.jpg', 0, '2022-11-07 16:31:29', ''),
(9, 'Adobe', 'assets/brand/ICCHA98182.jpg', 0, '2022-11-07 16:31:55', ''),
(10, 'Benz', 'assets/brand/ICCHA96472.jpg', 0, '2022-11-07 16:32:18', ''),
(11, 'Amazon', 'assets/brand/ICCHA23899.jpg', 0, '2022-11-07 16:33:05', ''),
(12, 'Sony', 'assets/brand/ICCHA81368.jpg', 0, '2022-11-07 16:33:30', '');

-- --------------------------------------------------------

--
-- Table structure for table `brochure`
--

CREATE TABLE `brochure` (
  `id` int(11) NOT NULL,
  `pdf` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cancellation`
--

CREATE TABLE `cancellation` (
  `id` int(11) NOT NULL,
  `cdesc` text NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cancellation`
--

INSERT INTO `cancellation` (`id`, `cdesc`, `modified_at`) VALUES
(1, 'Lorem lipsums, bdbbdd ddnds', '2022-07-28 13:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cname` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ads_image` varchar(255) NOT NULL,
  `page_url` varchar(180) NOT NULL,
  `icons` varchar(100) NOT NULL,
  `showcategory` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 -Show, 1- Not Show',
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive	',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cname`, `image`, `ads_image`, `page_url`, `icons`, `showcategory`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Home and Living', '', 'assets/images/menu/banner-4.jpg', 'home-and-living', 'w-icon-electronics', 1, 0, '2022-11-04 10:23:34', '2022-11-04 12:43:34'),
(2, 'Music and Books', '', 'assets/images/menu/banner-4.jpg', 'music-and-books', 'w-icon-camera', 1, 0, '2022-11-04 10:23:34', ''),
(3, 'Mom and Kids', '', 'assets/images/menu/banner-4.jpg', 'moms-and-kids', 'w-icon-gamepad', 1, 0, '2022-11-04 10:23:34', ''),
(4, 'Exclusive', '', 'assets/images/menu/banner-4.jpg', 'exclusive', '', 1, 1, '2022-11-04 10:23:34', '2022-11-04 14:36:53'),
(5, 'Gift Set', '', 'assets/images/menu/banner-4.jpg', 'gift-set', 'w-icon-heartbeat', 1, 0, '2022-11-04 10:23:34', ''),
(6, 'Personal Tools', '', 'assets/images/menu/banner-4.jpg', 'personal-tools', 'w-icon-electronics', 1, 0, '2022-11-04 10:23:34', ''),
(7, 'Fragrance', '', 'assets/images/menu/banner-4.jpg', 'fragrance', 'w-icon-electronics', 1, 0, '2022-11-04 10:23:34', ''),
(8, 'Skin Care', '', 'assets/images/menu/banner-4.jpg', 'skin-care', 'w-icon-home', 0, 0, '2022-11-04 10:23:34', ''),
(9, 'Health and Wellness', 'assets/category/ICCHA44668.jpg', 'assets/images/menu/banner-4.jpg', 'health-and-wellness-1', 'w-icon-electronics', 1, 0, '2022-11-04 10:23:34', '2022-11-05 12:29:55'),
(10, 'Gadgets', 'assets/category/ICCHA49225.jpg', 'assets/images/menu/banner-4.jpg', 'gadgets-1', 'w-icon-ice-cream', 0, 0, '2022-11-04 10:23:34', '2022-11-05 12:29:31'),
(13, 'Men', 'assets/category/ICCHA90869.jpg', 'assets/images/menu/banner-4.jpg', 'men-1', 'w-icon-tshirt2', 1, 0, '2022-11-04 12:18:21', '2022-11-05 12:29:21'),
(14, 'Woman', 'assets/category/ICCHA16532.jpg', 'assets/category/ICCHA81443.jpg', 'woman', 'w-icon-tshirt2', 1, 0, '2022-11-04 12:18:51', '2022-11-05 15:00:11'),
(15, 'Hair Care', 'assets/category/ICCHA16743.jpg', 'assets/images/menu/banner-4.jpg', 'hair-care-1', 'w-icon-heartbeat', 1, 0, '2022-11-04 12:44:29', '2022-11-05 12:29:05'),
(16, 'Personal Care', 'assets/category/ICCHA55326.jpg', 'assets/category/ICCHA48927.jpg', 'personal-care', 'w-icon-electronics', 0, 0, '2022-11-04 12:46:27', '2022-11-07 10:25:09');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `noofdays` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `sid`, `cname`, `noofdays`, `status`, `created_at`, `modified_date`) VALUES
(1, 1, 'Bengaluru', '10', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(2, 1, 'Mangalore', '2', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(3, 2, 'Chennai', '', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(4, 2, 'Coimbatore', '', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(5, 2, 'Madurai', '', 0, '2022-07-22 05:52:19', '2022-07-25 20:11:12'),
(11, 9, 'Kolkata', '', 0, '2022-09-12 13:19:16', '0000-00-00 00:00:00'),
(12, 9, 'Durgapur', '', 0, '2022-09-12 15:41:58', '0000-00-00 00:00:00'),
(13, 9, 'Asansol', '', 0, '2022-09-12 15:42:13', '0000-00-00 00:00:00'),
(14, 9, 'Bankura', '', 0, '2022-09-12 15:42:42', '0000-00-00 00:00:00'),
(15, 1, 'Mysore', '', 0, '2022-09-12 15:43:17', '0000-00-00 00:00:00'),
(16, 22, 'Mumbai', '', 0, '2022-09-12 15:45:10', '0000-00-00 00:00:00'),
(17, 22, 'Pune', '', 0, '2022-09-12 15:45:23', '0000-00-00 00:00:00'),
(18, 10, 'Amaravati', '', 0, '2022-09-12 15:46:02', '0000-00-00 00:00:00'),
(19, 10, 'Visakhapatnam', '', 0, '2022-09-12 15:46:31', '0000-00-00 00:00:00'),
(20, 32, 'Hyderabad', '', 0, '2022-09-12 15:47:53', '0000-00-00 00:00:00'),
(21, 32, 'Secunderabad', '', 0, '2022-09-12 15:48:34', '0000-00-00 00:00:00'),
(22, 13, 'Patna', '', 0, '2022-09-12 15:49:07', '0000-00-00 00:00:00'),
(23, 13, 'Gaya', '', 0, '2022-09-12 15:49:44', '0000-00-00 00:00:00'),
(24, 34, 'Allahabad', '', 0, '2022-09-12 15:50:48', '0000-00-00 00:00:00'),
(25, 34, 'Agra', '', 0, '2022-09-12 15:51:02', '0000-00-00 00:00:00'),
(26, 34, 'Kanpur', '', 0, '2022-09-12 15:51:14', '0000-00-00 00:00:00'),
(27, 34, 'Varanasi', '', 0, '2022-09-12 15:51:35', '0000-00-00 00:00:00'),
(28, 34, 'Noida', '', 0, '2022-09-12 15:52:52', '0000-00-00 00:00:00'),
(29, 7, 'Delhi All', '', 0, '2022-09-12 15:53:38', '0000-00-00 00:00:00'),
(30, 7, 'NCR', '', 0, '2022-09-12 15:53:52', '0000-00-00 00:00:00'),
(31, 29, 'Jaipur', '', 0, '2022-09-12 15:54:27', '0000-00-00 00:00:00'),
(32, 29, 'Udaipur', '', 0, '2022-09-12 15:54:50', '0000-00-00 00:00:00'),
(33, 9, 'Darjeeling', '', 0, '2022-09-12 15:55:42', '0000-00-00 00:00:00'),
(34, 9, 'Siliguri', '', 0, '2022-09-12 15:55:57', '0000-00-00 00:00:00'),
(35, 9, 'New Jalpaiguri', '', 0, '2022-09-12 15:56:23', '0000-00-00 00:00:00'),
(36, 9, 'Berhampore', '', 0, '2022-09-12 15:57:53', '0000-00-00 00:00:00'),
(37, 9, 'Krishnanagar', '', 0, '2022-09-12 15:58:29', '0000-00-00 00:00:00'),
(38, 9, 'Katwa', '', 0, '2022-09-12 15:58:42', '0000-00-00 00:00:00'),
(39, 9, 'Burdwan (Bardhaman)', '', 0, '2022-09-12 15:59:44', '0000-00-00 00:00:00'),
(40, 9, 'Kalna', '', 0, '2022-09-12 16:00:04', '0000-00-00 00:00:00'),
(41, 14, 'Raipur', '', 0, '2022-09-12 16:01:27', '0000-00-00 00:00:00'),
(42, 15, 'Panjim', '', 0, '2022-09-12 16:02:33', '0000-00-00 00:00:00'),
(43, 15, 'Madgaon', '', 0, '2022-09-12 16:03:01', '0000-00-00 00:00:00'),
(44, 12, 'Guwahati', '', 0, '2022-09-12 16:03:44', '0000-00-00 00:00:00'),
(45, 24, 'Shillong', '', 0, '2022-09-12 16:04:07', '0000-00-00 00:00:00'),
(46, 2, 'Madurai', '', 0, '2022-09-12 16:05:28', '0000-00-00 00:00:00'),
(47, 2, 'Coimbatore', '', 0, '2022-09-12 16:06:11', '0000-00-00 00:00:00'),
(48, 19, 'Ranchi', '', 0, '2022-09-12 16:07:02', '0000-00-00 00:00:00'),
(49, 9, 'Howrah', '', 0, '2022-09-12 16:08:14', '0000-00-00 00:00:00'),
(50, 9, 'Chandannagar', '', 0, '2022-09-12 16:08:49', '0000-00-00 00:00:00'),
(51, 16, 'Ahmedabad', '', 0, '2022-09-12 16:10:03', '0000-00-00 00:00:00'),
(52, 16, 'Surat', '', 0, '2022-09-12 16:10:37', '0000-00-00 00:00:00'),
(53, 16, 'Vadodara', '', 0, '2022-09-12 16:10:55', '0000-00-00 00:00:00'),
(54, 16, 'Rajkot', '', 0, '2022-09-12 16:11:20', '0000-00-00 00:00:00'),
(55, 34, 'Lucknow', '', 0, '2022-09-12 16:11:47', '0000-00-00 00:00:00'),
(56, 20, 'Thiruvananthapuram', '', 0, '2022-09-12 16:12:52', '0000-00-00 00:00:00'),
(57, 20, 'Kochi', '', 0, '2022-09-12 16:13:16', '0000-00-00 00:00:00'),
(58, 20, 'Kannur', '', 0, '2022-09-12 16:13:43', '0000-00-00 00:00:00'),
(59, 17, 'Faridabad', '', 0, '2022-09-12 16:14:54', '0000-00-00 00:00:00'),
(60, 17, 'Gurugram', '', 0, '2022-09-12 16:15:23', '0000-00-00 00:00:00'),
(61, 17, 'Panipat', '', 0, '2022-09-12 16:15:45', '0000-00-00 00:00:00'),
(62, 17, 'Ambala', '', 0, '2022-09-12 16:16:13', '0000-00-00 00:00:00'),
(63, 28, 'Ludhiana', '', 0, '2022-09-12 16:17:48', '0000-00-00 00:00:00'),
(64, 28, 'Amritsar', '', 0, '2022-09-12 16:18:07', '0000-00-00 00:00:00'),
(65, 28, 'Jalandhar', '', 0, '2022-09-12 16:18:28', '0000-00-00 00:00:00'),
(66, 28, 'Patiala', '', 0, '2022-09-12 16:18:49', '0000-00-00 00:00:00'),
(67, 28, 'Mohali', '', 0, '2022-09-12 16:19:18', '0000-00-00 00:00:00'),
(68, 28, 'Pathankot', '', 0, '2022-09-12 16:19:52', '0000-00-00 00:00:00'),
(69, 9, 'Salt Lake City', '', 0, '2022-09-12 16:20:15', '0000-00-00 00:00:00'),
(70, 23, 'Imphal', '', 0, '2022-09-12 16:21:20', '0000-00-00 00:00:00'),
(71, 30, 'Gantok', '', 0, '2022-09-12 16:21:49', '0000-00-00 00:00:00'),
(72, 35, 'Haridwar', '', 0, '2022-09-12 16:24:09', '0000-00-00 00:00:00'),
(80, 1, 'Karnataka', '2 Days', 0, '2022-10-27 10:28:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `co_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `ccode` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`co_id`, `name`, `ccode`, `status`, `created_at`, `modified_at`) VALUES
(2, 'Black', '#000000', 0, '2022-10-20 12:08:21', '2022-11-16 15:30:06'),
(5, 'White', '#fcf7f7', 0, '2022-10-26 15:37:21', '2022-11-16 15:31:17'),
(6, 'Red', '#ed0c0c', 0, '2022-10-26 15:37:21', '2022-11-16 15:29:51'),
(7, 'Yellow', '#e9e325', 0, '2022-10-26 15:37:21', '2022-11-16 15:29:44'),
(8, 'Green', '#10e40c', 0, '2022-10-26 15:37:21', '2022-11-16 15:29:11'),
(9, 'Orange', '#ec7709', 0, '2022-10-26 15:38:39', '2022-11-16 15:28:59'),
(11, 'Pale Yellow', '#e6d40a', 0, '2022-11-03 10:56:53', '2022-11-16 15:28:45'),
(12, 'Light Blue', '#58bcd5', 0, '2022-11-03 10:56:53', '2022-11-16 15:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `email`, `phone`, `address`, `modified_at`, `status`) VALUES
(1, 'support@iccha.com', '919988776666', '', '2022-10-17 17:04:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `cname` varchar(90) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fdesc` text NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(11) NOT NULL,
  `orderid` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `totalamount` float NOT NULL,
  `discount` varchar(5) NOT NULL,
  `invoice_id` varchar(10) NOT NULL,
  `invoice_pdf` varchar(150) NOT NULL,
  `delivery_charges` int(11) NOT NULL,
  `taxamount` float NOT NULL,
  `subtotal` int(11) NOT NULL,
  `pmode` varchar(10) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '-1 - failure, 1 - placed, 2 - shipped, 3 - delivered, 4 -cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oid`, `orderid`, `user_id`, `totalamount`, `discount`, `invoice_id`, `invoice_pdf`, `delivery_charges`, `taxamount`, `subtotal`, `pmode`, `order_date`, `status`) VALUES
(1, 'ICC00001', 1, 363.2, '20', '', '', 100, 54, 300, '2', '2022-12-03 10:57:41', 1),
(2, 'ICC00002', 3, 323.2, '20', '', '', 50, 54, 300, '1', '2022-12-05 10:37:13', 1),
(3, 'ICC00003', 3, 363.2, '20', '', '', 100, 54, 300, '2', '2022-12-05 10:40:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_bills`
--

CREATE TABLE `order_bills` (
  `oid` int(11) NOT NULL,
  `bfname` varchar(30) NOT NULL,
  `bemail` varchar(150) NOT NULL,
  `bphone` varchar(12) NOT NULL,
  `bpincode` int(11) NOT NULL,
  `bstate` int(11) NOT NULL,
  `bcity` int(11) NOT NULL,
  `barea` int(11) NOT NULL,
  `baddress` varchar(255) NOT NULL,
  `sfname` varchar(30) NOT NULL,
  `semail` varchar(150) NOT NULL,
  `sphone` varchar(12) NOT NULL,
  `spincode` int(11) NOT NULL,
  `sstate` int(11) NOT NULL,
  `scity` int(11) NOT NULL,
  `sarea` int(11) NOT NULL,
  `saddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_bills`
--

INSERT INTO `order_bills` (`oid`, `bfname`, `bemail`, `bphone`, `bpincode`, `bstate`, `bcity`, `barea`, `baddress`, `sfname`, `semail`, `sphone`, `spincode`, `sstate`, `scity`, `sarea`, `saddress`) VALUES
(1, 'Demo', 'syed@savithru.com', '9986571768', 560064, 1, 1, 3, 'Bengaluru', '', '', '', 0, 0, 0, 0, ''),
(2, 'John', 'syedonm@gmail.com', '7090099999', 560013, 1, 1, 10, '222 baker street', '', '', '', 0, 0, 0, 0, ''),
(3, 'John', 'syedonm@gmail.com', '7090099999', 560064, 1, 1, 5, '222', 'martin', 'syedonm@gmail.com', '7090099999', 560064, 1, 1, 12, 'mysore');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `oid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pcode` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(180) NOT NULL,
  `purl` varchar(100) NOT NULL,
  `pid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `tax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`oid`, `qty`, `name`, `pcode`, `price`, `image`, `purl`, `pid`, `stock`, `tax`) VALUES
(1, 1, 'Beetroot Lip Balm', 'ICCHA31', 300, 'https://www.gogarbha.com/iccha/assets/products/ICCHA91983.jpg', 'beetroot-lip-balm-1', 9, 11, 18),
(2, 1, 'Beetroot Lip Balm', 'ICCHA31', 300, 'https://www.gogarbha.com/iccha/assets/products/ICCHA91983.jpg', 'beetroot-lip-balm-1', 9, 11, 18),
(3, 1, 'Beetroot Lip Balm', 'ICCHA31', 300, 'https://www.gogarbha.com/iccha/assets/products/ICCHA91983.jpg', 'beetroot-lip-balm-1', 9, 11, 18);

-- --------------------------------------------------------

--
-- Table structure for table `payment_log`
--

CREATE TABLE `payment_log` (
  `oid` int(11) NOT NULL,
  `pay_array` text NOT NULL,
  `pay_id` varchar(120) NOT NULL,
  `order_id` varchar(120) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 - Success,-1 - Failure, 2 - COD'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_log`
--

INSERT INTO `payment_log` (`oid`, `pay_array`, `pay_id`, `order_id`, `hash`, `status`) VALUES
(1, '', '', '', '', 2),
(2, '', '', 'order_Ko6jCZDEMmOgZ5', '', 0),
(3, '', '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pincodes`
--

CREATE TABLE `pincodes` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pincode` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pincodes`
--

INSERT INTO `pincodes` (`id`, `cid`, `pincode`, `amount`, `status`, `created_at`, `modified_at`) VALUES
(1, 1, '560064', 100, 0, '2022-11-16 14:15:03', 2022),
(2, 1, '560013', 50, 0, '2022-11-23 17:29:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `privacypolicy`
--

CREATE TABLE `privacypolicy` (
  `id` int(11) NOT NULL,
  `pdesc` text NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privacypolicy`
--

INSERT INTO `privacypolicy` (`id`, `pdesc`, `modified_at`) VALUES
(1, '<h2 style=\"margin-top:24.5pt;margin-right:0in;margin-bottom:7.5pt;margin-left:\r\n0in;border:none;mso-border-bottom-alt:solid #A4A4A4 .75pt;padding:0in;\r\nmso-padding-alt:0in 0in 0in 0in\"><b>Our Privacy Policy</b></h2>', '2023-01-30 14:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `sub_sub_id` int(11) NOT NULL,
  `brand_id` varchar(30) NOT NULL,
  `ptitle` varchar(180) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `pcode` varchar(30) NOT NULL,
  `overview` text NOT NULL,
  `pspec` text NOT NULL,
  `meta_title` varchar(100) NOT NULL,
  `home_page` int(11) NOT NULL DEFAULT '0' COMMENT '0->no; 1->yes',
  `meta_keywords` text NOT NULL,
  `meta_description` varchar(170) NOT NULL,
  `featuredimg` varchar(200) NOT NULL,
  `modalno` varchar(50) NOT NULL,
  `pbrochure` varchar(200) NOT NULL,
  `cqa` text NOT NULL,
  `newarrivals` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - Show, 1 - Not Show',
  `bestselling` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - Show, 1- Not show',
  `featured` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 - Show, 1- Not show',
  `tax` varchar(50) NOT NULL,
  `youtubelink` varchar(200) NOT NULL,
  `discount` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` varchar(180) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `length` varchar(30) NOT NULL,
  `weight` varchar(30) NOT NULL,
  `breadth` varchar(30) NOT NULL,
  `height` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `subcat_id`, `sub_sub_id`, `brand_id`, `ptitle`, `page_url`, `pcode`, `overview`, `pspec`, `meta_title`, `home_page`, `meta_keywords`, `meta_description`, `featuredimg`, `modalno`, `pbrochure`, `cqa`, `newarrivals`, `bestselling`, `featured`, `tax`, `youtubelink`, `discount`, `created_at`, `modified_at`, `status`, `length`, `weight`, `breadth`, `height`) VALUES
(1, 8, 10, 26, '', 'Rose And Honey Body Wash', 'rose-and-honey-body-wash', 'ICCHA100', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA21700.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-05 09:49:53', 0, '10', '10', '10', '10'),
(2, 8, 10, 26, '', 'Green Apple Shampoo', 'green-apple-shampoo-1', 'ICCHA21', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA75249.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-05 09:49:09', 0, '10', '10', '10', '10'),
(3, 8, 10, 26, '', 'Sun Protection', 'sun-protection', 'ICCHA3', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA46744.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-04 05:33:33', 0, '10', '10', '10', '10'),
(4, 8, 10, 26, '', 'Neem And Tulsi Face Wash', 'neem-and-tulsi-face-wash-1', 'ICCHA4', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA63799.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-04 06:15:15', 0, '10', '10', '10', '10'),
(5, 8, 10, 26, '', 'Set Of 4 Herbal Glycerine Bodywashs', 'set-of-4-herbal-glycerine-bodywashs-1', 'ICCHA5', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA92790.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-04 05:32:25', 0, '10', '10', '10', '10'),
(6, 8, 10, 26, '', 'Set Of 2 Herbal Glycerine Bodywash', 'set-of-2-herbal-glycerine-bodywash', 'ICCHA6', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA48092.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-04 05:26:23', '2022-11-04 06:15:44', 0, '10', '10', '10', '10'),
(7, 16, 38, 0, '', 'Peach Milk And Avacado Moisturiser', 'peach-milk-and-avacado-moisturiser-1', 'ICCHA1', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA43738.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-05 09:35:47', '2022-11-05 09:37:16', 0, '10', '10', '10', '10'),
(8, 16, 38, 0, '', 'Lavender And Ylang Ylang Body Wash', 'lavender-and-ylang-ylang-body-wash', 'ICCHA22', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA87530.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-05 09:35:47', '2022-11-05 09:49:35', 0, '10', '10', '10', '10'),
(9, 16, 37, 0, '', 'Beetroot Lip Balm', 'beetroot-lip-balm-1', 'ICCHA31', '<p><span style=\"font-family: \"Open Sans\", Arial, sans-serif; letter-spacing: normal; text-align: justify; font-weight: normal;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p><p><span style=\"font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; letter-spacing: normal; text-align: justify; font-weight: normal;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><span style=\"font-family: \"Open Sans\", Arial, sans-serif; letter-spacing: normal; text-align: justify;\"><br></span></p>', '<span style=\"font-family: \"Open Sans\", Arial, sans-serif; letter-spacing: normal; text-align: justify;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</span>', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA91983.jpg', 'ABC123', 'assets/products/ICCHA85181.jpg', '1.What', 0, 0, 0, '18', 'kqtD5dpn9C8', '10', '2022-11-05 09:35:47', '2022-12-05 04:47:26', 0, '10', '10', '10', '10'),
(10, 16, 37, 0, '', 'Herbal Hair Oil 18 Herbs', 'herbal-hair-oil-18-herbs', 'ICCHA91', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA53118.jpg', 'ABC123', '', '1.What', 0, 0, 0, '18', '_ysd-zHamjk', '10', '2022-11-05 09:35:47', '2022-11-05 09:48:56', 0, '10', '10', '10', '10'),
(11, 10, 11, 8, '', 'Gadgets1', 'gadgets1', 'ICCHA1238', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA84269.jpg', 'ABC123', '', '1.What', 0, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-23 10:42:12', 0, '10', '10', '10', '10'),
(12, 10, 11, 8, '', 'Gadgets2', 'gadgets2-1', 'ICCHA1239', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA70666.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:32:27', 0, '10', '10', '10', '10'),
(13, 10, 11, 8, '', 'Gadgets3', 'gadgets3-1', 'ICCHA1230', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA79775.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:32:40', 0, '10', '10', '10', '10'),
(14, 10, 11, 8, '', 'Gadgets4', 'gadgets4-1', 'ICCHA1231', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA66616.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:32:57', 0, '10', '10', '10', '10'),
(15, 10, 11, 8, '', 'Gadgets5', 'gadgets5-1', 'ICCHA1232', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA54630.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:33:17', 0, '10', '10', '10', '10'),
(16, 10, 11, 8, '', 'Gadgets6', 'gadgets6-1', 'ICCHA1233', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA13758.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:33:29', 0, '10', '10', '10', '10'),
(17, 10, 11, 8, '', 'Gadgets7', 'gadgets7-1', 'ICCHA1234', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA15746.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:33:45', 0, '10', '10', '10', '10'),
(18, 10, 11, 8, '', 'Gadgets8', 'gadgets8-1', 'ICCHA1235', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA66591.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:33:58', 0, '10', '10', '10', '10'),
(19, 10, 11, 8, '', 'Gadgets9', 'gadgets9-1', 'ICCHA1236', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA12637.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:34:21', 0, '10', '10', '10', '10'),
(20, 10, 11, 8, '', 'Gadgets10', 'gadgets10-1', 'ICCHA1237', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA72222.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 03:32:11', 0, '10', '10', '10', '10'),
(21, 16, 37, 0, '', 'Personal Care1', 'personal-care1-1', 'ICCHA123788', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA83361.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:06:11', 0, '10', '10', '10', '10'),
(22, 16, 37, 0, '', 'Personal Care2', 'personal-care2-1', 'ICCHA123789', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA53752.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:06:27', 0, '10', '10', '10', '10'),
(23, 16, 37, 0, '', 'Personal Care3', 'personal-care3-1', 'ICCHA123780', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA69609.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:06:41', 0, '10', '10', '10', '10'),
(24, 16, 37, 0, '', 'Personal Care4', 'personal-care4-1', 'ICCHA123781', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA95689.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:06:56', 0, '10', '10', '10', '10'),
(25, 16, 37, 0, '', 'Personal Care5', 'personal-care5-1', 'ICCHA123782', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA69571.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:09:02', 0, '10', '10', '10', '10'),
(26, 16, 37, 0, '', 'Personal Care6', 'personal-care6-1', 'ICCHA123783', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA27289.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:08:48', 0, '10', '10', '10', '10'),
(27, 16, 37, 0, '', 'Personal Care7', 'personal-care7-1', 'ICCHA123784', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA46148.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:08:34', 0, '10', '10', '10', '10'),
(28, 8, 10, 0, '', 'Skin Care1', 'skin-care1-1', 'ICCHAS123781', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA57717.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:07:13', 0, '10', '10', '10', '10'),
(29, 8, 10, 0, '', 'Skin Care2', 'skin-care2-1', 'ICCHAS123782', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA46950.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:07:52', 0, '10', '10', '10', '10'),
(30, 8, 10, 0, '', 'Skin Care3', 'skin-care3-1', 'ICCHAS123783', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA80808.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:08:06', 0, '10', '10', '10', '10'),
(31, 8, 10, 0, '', 'Skin Care4', 'skin-care4-1', 'ICCHAS123784', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA85889.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:09:23', 0, '10', '10', '10', '10'),
(32, 8, 10, 0, '', 'Skin Care5', 'skin-care5-1', 'ICCHAS123785', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA82509.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:10:42', 0, '10', '10', '10', '10'),
(33, 8, 10, 0, '', 'Skin Care6', 'skin-care6-1', 'ICCHAS123786', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA49202.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:10:27', 0, '10', '10', '10', '10'),
(34, 8, 10, 0, '', 'Skin Care7', 'skin-care7-1', 'ICCHAS123787', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA40457.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:10:11', 0, '10', '10', '10', '10'),
(35, 8, 10, 0, '', 'Skin Care8', 'skin-care8-1', 'ICCHAS123788', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA11460.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:09:58', 0, '10', '10', '10', '10'),
(36, 8, 10, 0, '', 'Skin Care9', 'skin-care9-1', 'ICCHAS123789', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA72400.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:09:45', 0, '10', '10', '10', '10'),
(37, 8, 10, 0, '', 'Skin Care10', 'skin-care10-1', 'ICCHAS123780', 'Product Description', 'Product Specification', 'Meta Title', 0, 'Meta Keywords', 'Meta Description', 'assets/products/ICCHA75599.jpg', 'ABC123', '', '1.What', 1, 1, 1, '18', '_ysd-zHamjk', '10', '2022-11-07 03:31:24', '2022-11-07 04:07:35', 0, '10', '10', '10', '10');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `p_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `pid`, `p_image`) VALUES
(3, 11, 'assets/products/ICCHA47982.jpg'),
(8, 9, 'assets/products/ICCHA72613.jpg'),
(9, 9, 'assets/products/ICCHA34376.jpg'),
(10, 9, 'assets/products/ICCHA57689.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `pro_size` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `coid` int(11) NOT NULL,
  `selling_price` varchar(50) NOT NULL,
  `stock` varchar(50) NOT NULL,
  `coimg` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`pro_size`, `pid`, `sid`, `coid`, `selling_price`, `stock`, `coimg`, `created_at`) VALUES
(1, 1, 14, 8, '820', '11', '', '2022-11-04 11:56:23'),
(2, 1, 15, 9, '900', '21', '', '2022-11-04 11:56:23'),
(3, 2, 14, 8, '820', '11', '', '2022-11-04 11:56:23'),
(4, 2, 15, 9, '900', '21', '', '2022-11-04 11:56:23'),
(5, 3, 14, 8, '820', '11', '', '2022-11-04 11:56:23'),
(6, 3, 15, 9, '900', '21', '', '2022-11-04 11:56:23'),
(7, 4, 14, 8, '820', '11', '', '2022-11-04 11:56:23'),
(8, 4, 15, 9, '900', '21', '', '2022-11-04 11:56:23'),
(9, 5, 14, 8, '820', '11', '', '2022-11-04 11:56:23'),
(10, 5, 15, 9, '900', '20', '', '2022-11-04 11:56:23'),
(11, 6, 14, 8, '820', '1', '', '2022-11-04 11:56:23'),
(12, 6, 15, 9, '900', '2', '', '2022-11-04 11:56:23'),
(13, 7, 14, 8, '820', '11', '', '2022-11-05 04:05:47'),
(14, 7, 15, 9, '900', '20', '', '2022-11-05 04:05:47'),
(15, 8, 14, 8, '820', '11', '', '2022-11-05 04:05:47'),
(16, 8, 15, 9, '900', '21', '', '2022-11-05 04:05:47'),
(17, 9, 14, 8, '300', '11', '', '2022-11-05 04:05:47'),
(18, 9, 15, 9, '400', '20', '', '2022-11-05 04:05:47'),
(19, 10, 14, 8, '820', '1', '', '2022-11-05 04:05:47'),
(20, 10, 15, 9, '900', '2', '', '2022-11-05 04:05:47'),
(21, 11, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(22, 11, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(23, 12, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(24, 12, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(25, 13, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(26, 13, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(27, 14, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(28, 14, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(29, 15, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(30, 15, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(31, 16, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(32, 16, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(33, 17, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(34, 17, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(35, 18, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(36, 18, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(37, 19, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(38, 19, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(39, 20, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(40, 20, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(41, 21, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(42, 21, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(43, 22, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(44, 22, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(45, 23, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(46, 23, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(47, 24, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(48, 24, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(49, 25, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(50, 25, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(51, 26, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(52, 26, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(53, 27, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(54, 27, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(55, 28, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(56, 28, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(57, 29, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(58, 29, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(59, 30, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(60, 30, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(61, 31, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(62, 31, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(63, 32, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(64, 32, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(65, 33, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(66, 33, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(67, 34, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(68, 34, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(69, 35, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(70, 35, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(71, 36, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(72, 36, 15, 9, '900', '2', '', '2022-11-07 10:01:24'),
(73, 37, 14, 8, '820', '1', '', '2022-11-07 10:01:24'),
(74, 37, 15, 9, '900', '2', '', '2022-11-07 10:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `returnpolicy`
--

CREATE TABLE `returnpolicy` (
  `id` int(11) NOT NULL,
  `rdesp` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returnpolicy`
--

INSERT INTO `returnpolicy` (`id`, `rdesp`, `status`, `created_at`) VALUES
(1, '<h2><b>Refund Policy</b></h2>', 0, '2022-11-03 11:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `review_descp` text NOT NULL,
  `rating` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0->approved,1->unapproved'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `pid`, `review_descp`, `rating`, `user_id`, `created_at`, `status`) VALUES
(1, 9, 'ddd', 3, 1, '2022-11-24 11:58:00', 1),
(2, 9, 'This is my website', 5, 1, '2022-11-24 11:58:57', 1),
(4, 9, 'test', 0, 1, '2022-12-05 10:05:13', 1),
(5, 9, 'test', 3, 1, '2022-12-05 10:05:31', 1),
(6, 9, 'average product', 2, 3, '2022-12-05 10:29:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shippingpolicy`
--

CREATE TABLE `shippingpolicy` (
  `id` int(11) NOT NULL,
  `shippolicy` text NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shippingpolicy`
--

INSERT INTO `shippingpolicy` (`id`, `shippolicy`, `modified_at`) VALUES
(1, 'Lorems ss', '2022-11-03 12:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `s_id` int(11) NOT NULL,
  `sname` varchar(90) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0- Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`s_id`, `sname`, `status`, `created_at`, `modified_at`) VALUES
(6, '15ml', 0, '2022-10-20 12:08:09', ''),
(13, '100ml', 0, '2022-10-26 15:20:33', ''),
(14, '20ml', 0, '2022-10-26 15:20:33', ''),
(15, '30ml', 0, '2022-10-26 15:20:33', ''),
(16, '18.5ml', 0, '2022-11-03 10:57:36', '2022-11-03 10:57:47'),
(17, '19ml', 0, '2022-11-03 10:58:35', ''),
(18, '200ml', 0, '2022-11-03 10:58:35', ''),
(19, '3002ml', 0, '2022-11-03 10:58:35', '2022-11-03 10:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `slider_img`
--

CREATE TABLE `slider_img` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stitle` varchar(180) NOT NULL,
  `stagline` varchar(180) NOT NULL,
  `sliderlink` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider_img`
--

INSERT INTO `slider_img` (`id`, `image`, `stitle`, `stagline`, `sliderlink`, `status`, `created_at`, `modified_date`) VALUES
(3, 'assets/sliders/ICCHA46641.jpg', 'Custom Mens Running Shoes', 'Sale upto 30% off', 'https://www.youtube.com/', 0, '2022-11-04 16:51:39', '2022-11-05 10:41:30'),
(6, 'assets/sliders/ICCHA77048.jpg', 'Mountain Claim Hot &amp; Packback', 'Only untill end of this week', '', 0, '2022-11-05 10:44:26', '');

-- --------------------------------------------------------

--
-- Table structure for table `sociallinks`
--

CREATE TABLE `sociallinks` (
  `id` int(11) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `twitter` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `instagram` varchar(200) NOT NULL,
  `modified_at` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `youtube` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sociallinks`
--

INSERT INTO `sociallinks` (`id`, `facebook`, `twitter`, `linkedin`, `instagram`, `modified_at`, `status`, `youtube`) VALUES
(1, 'https://www.facebook.com/', 'https://twitter.com', 'https://www.linkedin.com/', 'https://www.instagram.com/', '2022-10-17 17:04:52', 0, 'https://www.youtube.com/');

-- --------------------------------------------------------

--
-- Table structure for table `spolicy`
--

CREATE TABLE `spolicy` (
  `id` int(11) NOT NULL,
  `stext` text NOT NULL,
  `modified_at` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `status`, `created_at`, `modified_date`) VALUES
(1, 'Karnataka', 0, '2022-07-22 05:50:49', '2022-07-26 22:10:53'),
(2, 'Tamil Nadu', 0, '2022-07-22 05:50:49', '2022-07-26 22:10:50'),
(7, 'Delhi', 0, '2022-08-16 09:50:58', '0000-00-00 00:00:00'),
(9, 'West Bengal', 0, '2022-08-16 09:54:12', '2022-08-17 15:58:47'),
(10, 'Andhra Pradesh', 0, '2022-08-17 16:12:24', '0000-00-00 00:00:00'),
(11, 'Arunachal Pradesh', 0, '2022-08-17 16:12:43', '0000-00-00 00:00:00'),
(12, 'Assam', 0, '2022-08-17 16:12:58', '0000-00-00 00:00:00'),
(13, 'Bihar', 0, '2022-08-17 16:13:13', '0000-00-00 00:00:00'),
(14, 'Chhattisgarh', 0, '2022-08-17 16:13:25', '0000-00-00 00:00:00'),
(15, 'Goa', 0, '2022-08-17 16:14:11', '0000-00-00 00:00:00'),
(16, 'Gujarat', 0, '2022-08-17 16:14:30', '0000-00-00 00:00:00'),
(17, 'Haryana', 0, '2022-08-17 16:14:43', '0000-00-00 00:00:00'),
(18, 'Himachal Pradesh', 0, '2022-08-17 16:15:03', '0000-00-00 00:00:00'),
(19, 'Jharkhand', 0, '2022-08-17 16:15:17', '0000-00-00 00:00:00'),
(20, 'Kerala', 0, '2022-08-17 16:15:29', '0000-00-00 00:00:00'),
(21, 'Madhya Pradesh', 0, '2022-08-17 16:15:39', '0000-00-00 00:00:00'),
(22, 'Maharashtra', 0, '2022-08-17 16:15:51', '2022-09-12 15:44:36'),
(23, 'Manipur', 0, '2022-08-17 16:16:08', '0000-00-00 00:00:00'),
(24, 'Meghalaya', 0, '2022-08-17 16:16:21', '0000-00-00 00:00:00'),
(25, 'Mizoram', 0, '2022-08-17 16:16:32', '0000-00-00 00:00:00'),
(26, 'Nagaland', 0, '2022-08-17 16:16:42', '0000-00-00 00:00:00'),
(27, 'Odisha', 0, '2022-08-17 16:16:50', '0000-00-00 00:00:00'),
(28, 'Punjab', 0, '2022-08-17 16:17:02', '0000-00-00 00:00:00'),
(29, 'Rajasthan', 0, '2022-08-17 16:17:17', '0000-00-00 00:00:00'),
(30, 'Sikkim', 0, '2022-08-17 16:17:30', '0000-00-00 00:00:00'),
(32, 'Telangana', 0, '2022-08-17 16:17:49', '0000-00-00 00:00:00'),
(33, 'Tripura', 0, '2022-08-17 16:18:00', '0000-00-00 00:00:00'),
(34, 'Uttar Pradesh', 0, '2022-08-17 16:18:18', '0000-00-00 00:00:00'),
(35, 'Uttarakhand', 0, '2022-08-17 16:18:32', '0000-00-00 00:00:00'),
(36, 'Puducherry', 0, '2022-08-17 16:19:29', '0000-00-00 00:00:00'),
(37, 'Andaman and Nicobar Islands', 0, '2022-08-17 16:19:45', '0000-00-00 00:00:00'),
(38, 'Chandigarh', 0, '2022-08-17 16:20:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `sub_img` varchar(200) NOT NULL,
  `page_url` varchar(180) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive	',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `cat_id`, `sname`, `sub_img`, `page_url`, `status`, `created_at`, `modified_at`) VALUES
(1, 13, 'Footwear', '', 'men-footwear', 0, '2022-11-04 10:36:51', '2022-11-04 12:21:36'),
(2, 13, 'Clothing', '', 'men-clothing', 0, '2022-11-04 10:36:51', '2022-11-04 12:20:37'),
(3, 11, 'Men', '', 'men-cosmetics', 0, '2022-11-04 05:17:34', '2022-11-04 11:08:41'),
(4, 11, 'Woman', '', 'woman-cosmetics', 0, '2022-11-04 05:17:34', ''),
(6, 6, 'Men', '', 'personal-tools-men', 0, '2022-11-04 05:28:09', ''),
(7, 6, 'Woman', '', 'personal-tools-woman', 0, '2022-11-04 05:28:09', ''),
(8, 7, 'Men', '', 'fragrance-men', 0, '2022-11-04 05:28:09', ''),
(9, 7, 'Woman', '', 'fragrance-woman', 0, '2022-11-04 05:28:09', ''),
(10, 8, 'Men', '', 'skin-care-men', 0, '2022-11-04 05:28:09', ''),
(11, 8, 'Woman', '', 'skin-care-woman', 0, '2022-11-04 05:28:09', ''),
(12, 9, 'Men', '', 'health-and-wellness-men', 0, '2022-11-04 05:28:09', ''),
(13, 9, 'Woman', '', 'health-and-wellness-woman', 0, '2022-11-04 05:28:09', '2022-11-04 11:17:06'),
(16, 10, 'Men', '', 'gadgets-men', 0, '2022-11-04 06:20:31', ''),
(17, 10, 'Woman', '', 'gadgets-woman', 0, '2022-11-04 06:20:31', ''),
(18, 1, 'Men', '', 'home-decor-men', 0, '2022-11-04 06:20:31', ''),
(19, 1, 'Woman', '', 'home-decor-woman', 0, '2022-11-04 06:20:31', ''),
(20, 2, 'Music Categories\n', '', 'music-and-books-music-categories', 0, '2022-11-04 06:20:31', ''),
(21, 2, 'Vinyle Records\n', '', 'music-and-books-vinyle-records\n', 0, '2022-11-04 06:20:31', ''),
(22, 3, 'Mother\n', '', 'mom-and-kids-mother', 0, '2022-11-04 06:20:31', ''),
(23, 3, 'Infants\n', '', 'music-and-books-infants', 0, '2022-11-04 06:20:31', ''),
(24, 4, 'Exclusive', '', 'exclusive', 0, '2022-11-04 06:20:31', ''),
(25, 5, 'Men', '', 'gift-set-men', 0, '2022-11-04 06:20:31', ''),
(26, 13, 'Accessories', '', 'men-accessories', 0, '2022-11-04 12:01:30', '2022-11-05 12:26:33'),
(27, 14, 'Clothing', '', 'woman-clothing', 0, '2022-11-04 06:52:55', ''),
(28, 14, 'Footwear', '', 'woman-footwear', 0, '2022-11-04 06:52:55', ''),
(29, 2, 'CDS', '', 'music-and-books-cds', 0, '2022-11-04 07:09:40', ''),
(30, 2, 'English', '', 'music-and-books-english', 0, '2022-11-04 07:09:40', ''),
(31, 2, 'Hindi', '', 'music-and-books-hindi', 0, '2022-11-04 07:09:40', ''),
(32, 5, 'Woman', '', 'gift-set-woman', 0, '2022-11-04 07:11:45', ''),
(33, 5, 'Boys', '', 'gift-set-boys', 0, '2022-11-04 07:11:45', ''),
(34, 5, 'Girls', '', 'gift-set-girls', 0, '2022-11-04 07:11:45', ''),
(35, 15, 'Men', '', 'hair-care-men', 0, '2022-11-04 07:14:57', ''),
(36, 15, 'Woman', '', 'hair-care-woman', 0, '2022-11-04 07:14:57', ''),
(37, 16, 'Men', '', 'personal-care-men', 0, '2022-11-04 07:17:03', ''),
(38, 16, 'Woman', '', 'personal-care-woman', 0, '2022-11-04 07:17:03', ''),
(39, 1, 'Bed Linen', '', 'bed-linen', 0, '2022-11-04 12:54:31', ''),
(40, 1, 'Bath', '', 'bath', 0, '2022-11-04 12:54:31', ''),
(41, 1, 'Flooring', '', 'flooring', 0, '2022-11-04 12:54:31', ''),
(42, 1, 'Lamps & Lighting', '', 'lamps-lighting', 0, '2022-11-04 12:54:31', ''),
(43, 1, 'Interior Décor', '', 'interior-décor', 0, '2022-11-04 12:54:31', ''),
(44, 1, 'Cushion & Covers', '', 'cushion-covers', 0, '2022-11-04 12:54:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `subsubcategory`
--

CREATE TABLE `subsubcategory` (
  `id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `ssname` varchar(200) NOT NULL,
  `subsub_img` varchar(200) NOT NULL,
  `page_url` varchar(180) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive	',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subsubcategory`
--

INSERT INTO `subsubcategory` (`id`, `sub_id`, `ssname`, `subsub_img`, `page_url`, `status`, `created_at`, `modified_at`) VALUES
(1, 27, 'Kurtas and Suits', '', 'kurtas-and-suits', 0, '2022-11-04 12:29:51', ''),
(2, 27, 'Kurtis, Tops', '', 'kurtis-tops', 0, '2022-11-04 12:29:51', ''),
(3, 27, 'Sarees', '', 'sarees', 0, '2022-11-04 12:29:51', ''),
(4, 27, 'Leggings, Salwars', '', 'leggings-salwars', 0, '2022-11-04 12:29:51', ''),
(5, 27, 'Skirts and Casuals', '', 'skirts-and-casuals', 0, '2022-11-04 12:29:51', ''),
(6, 27, 'Jackets', '', 'jackets', 0, '2022-11-04 12:29:51', ''),
(7, 27, 'Bra and Panties', '', 'bra-and-panties', 0, '2022-11-04 12:29:51', ''),
(8, 27, 'Jeans', '', 'jeans', 0, '2022-11-04 12:29:51', ''),
(9, 2, 'Shirts', '', 'shirts', 0, '2022-11-04 12:29:51', ''),
(10, 2, 'Trousers', '', 'trousers', 0, '2022-11-04 12:29:51', ''),
(11, 2, 'T-Shirts', '', 't-shirts', 0, '2022-11-04 12:29:51', ''),
(12, 2, 'Shorts', '', 'shorts', 0, '2022-11-04 12:29:51', ''),
(13, 2, 'Nightwear', '', 'nightwear', 0, '2022-11-04 12:29:51', ''),
(14, 2, 'Inner wear ', '', 'inner-wear', 0, '2022-11-04 12:29:51', ''),
(15, 1, 'Shoes', '', 'shoes', 0, '2022-11-04 12:29:51', ''),
(16, 1, 'Sandals', '', 'sandals', 0, '2022-11-04 12:29:51', ''),
(17, 1, 'Socks', '', 'socks', 0, '2022-11-04 12:29:51', ''),
(18, 26, 'Sunglasses', '', 'sunglasses', 0, '2022-11-04 12:29:51', ''),
(19, 26, 'watches', '', 'watches', 0, '2022-11-04 12:29:51', ''),
(20, 26, 'caps', '', 'caps', 0, '2022-11-04 12:29:51', ''),
(21, 26, 'wallets', '', 'wallets', 0, '2022-11-04 12:29:51', ''),
(22, 26, 'belts', '', 'belts', 0, '2022-11-04 12:29:51', ''),
(23, 28, 'Shoes', '', 'shoes-1', 0, '2022-11-04 12:29:51', ''),
(24, 28, 'Sandals', '', 'sandals-1', 0, '2022-11-04 12:29:51', ''),
(25, 28, 'Socks', '', 'socks-1', 0, '2022-11-04 12:29:51', ''),
(26, 11, 'Beuty', '', 'beuty', 0, '2022-11-04 13:03:24', ''),
(27, 11, 'Makeup', '', 'makeup', 0, '2022-11-04 13:03:24', ''),
(28, 11, 'Lipsticks', '', 'lipsticks', 0, '2022-11-04 13:03:24', ''),
(29, 11, 'Luxury Soap', '', 'luxury-soap', 0, '2022-11-04 13:03:24', ''),
(30, 11, 'Body Wash', '', 'body-wash', 0, '2022-11-04 13:03:24', ''),
(31, 11, 'Cream', '', 'cream', 0, '2022-11-04 13:03:24', ''),
(32, 11, 'Hair Oil', '', 'hair-oil', 0, '2022-11-04 13:03:24', ''),
(33, 11, 'Body Oil', '', 'body-oil', 0, '2022-11-04 13:03:24', ''),
(34, 11, 'Tan Remover', '', 'tan-remover', 0, '2022-11-04 13:03:24', ''),
(35, 11, 'Hair Color', '', 'hair-color', 0, '2022-11-04 13:03:24', ''),
(36, 11, 'Sheet Mask', '', 'sheet-mask', 0, '2022-11-04 13:03:24', ''),
(37, 10, 'Luxury Soap', '', 'luxury-soap-1', 0, '2022-11-04 13:03:24', ''),
(38, 10, 'After Shave', '', 'after-shave', 0, '2022-11-04 13:03:24', ''),
(39, 10, 'Shower Gel', '', 'shower-gel', 0, '2022-11-04 13:03:24', ''),
(40, 10, 'Hair Gel', '', 'hair-gel', 0, '2022-11-04 13:03:24', ''),
(41, 10, 'Tan Remover', '', 'tan-remover-1', 0, '2022-11-04 13:03:24', ''),
(42, 37, 'Trimer', '', 'trimer', 0, '2022-11-04 13:03:24', ''),
(43, 37, 'Sun Glass', '', 'sun-glass', 0, '2022-11-04 13:03:24', ''),
(44, 37, 'Watches', '', 'watches-1', 0, '2022-11-04 13:03:24', ''),
(45, 37, 'Walet', '', 'walet', 0, '2022-11-04 13:03:24', ''),
(46, 38, 'Hair Remover', '', 'hair-remover', 0, '2022-11-04 13:03:24', ''),
(47, 38, 'Sun Glass', '', 'sun-glass-1', 0, '2022-11-04 13:03:24', ''),
(48, 38, 'Vanity Bag', '', 'vanity-bag', 0, '2022-11-04 13:03:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `tdesc` text NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `tdesc`, `modified_at`) VALUES
(1, '<p class=\"MsoNormal\"><b><span style=\"font-size:9.0pt;font-family:\" lang=\"EN-US\">TERMS AND CONDITIONSs</span></b></p>', '2023-01-30 14:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `location` varchar(50) NOT NULL,
  `image` varchar(150) NOT NULL,
  `tdesc` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `location`, `image`, `tdesc`, `status`, `created_at`, `modified_at`) VALUES
(3, 'Demo', 'Bengaluru', 'assets/testimonials/sqft922445.jpg', 's', -1, '2022-11-03 11:10:11', '2022-11-03 11:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(80) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `status` tinyint(80) NOT NULL DEFAULT '0' COMMENT '0 -Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `name`, `email`, `phone`, `password`, `otp`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Demo', 'syed@savithru.com', '9986571768', '$2y$10$RnxEDxDX0jRByvDuPagoTOp2EMYrlrrcADkGjsgCTH2qD0PvggGJe', '7279', 0, '2022-11-23 17:47:56', '2022-12-06 16:39:13'),
(2, 'Cruz Wilkins', 'code2ran@gmail.com', '9611033586', '', '6429', 0, '2022-11-30 09:53:59', ''),
(3, 'John', 'john@gmail.com', '9611033586', '', '4297', 0, '2022-12-05 10:26:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0->flat; 1->percentage',
  `title` text NOT NULL,
  `from_date` varchar(150) NOT NULL,
  `to_date` varchar(150) NOT NULL,
  `discount` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `no_of_coupons` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `type`, `title`, `from_date`, `to_date`, `discount`, `status`, `prefix`, `no_of_coupons`, `created_at`, `modified_at`, `user_id`) VALUES
(1, 0, 'ICCHA20', '2022-11-02', '2023-01-05', '20', 0, '', 0, '2022-11-25 14:59:24', '2023-01-09 14:28:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `uid`, `pid`, `created_at`) VALUES
(5, 1, 0, '2022-12-05 17:40:02'),
(6, 3, 11, '2022-12-06 11:20:34'),
(8, 3, 0, '2022-12-06 11:22:59'),
(23, 1, 4, '2022-12-06 17:33:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cid` (`cid`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brochure`
--
ALTER TABLE `brochure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cancellation`
--
ALTER TABLE `cancellation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cname` (`cname`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sid` (`sid`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`co_id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pincdoe` (`cid`);

--
-- Indexes for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ptitle` (`ptitle`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`pro_size`);

--
-- Indexes for table `returnpolicy`
--
ALTER TABLE `returnpolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippingpolicy`
--
ALTER TABLE `shippingpolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `slider_img`
--
ALTER TABLE `slider_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sociallinks`
--
ALTER TABLE `sociallinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spolicy`
--
ALTER TABLE `spolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `sname` (`sname`);

--
-- Indexes for table `subsubcategory`
--
ALTER TABLE `subsubcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_id` (`sub_id`),
  ADD KEY `ssname` (`ssname`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `brochure`
--
ALTER TABLE `brochure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancellation`
--
ALTER TABLE `cancellation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pincodes`
--
ALTER TABLE `pincodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `privacypolicy`
--
ALTER TABLE `privacypolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `pro_size` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `returnpolicy`
--
ALTER TABLE `returnpolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shippingpolicy`
--
ALTER TABLE `shippingpolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `slider_img`
--
ALTER TABLE `slider_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sociallinks`
--
ALTER TABLE `sociallinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spolicy`
--
ALTER TABLE `spolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `subsubcategory`
--
ALTER TABLE `subsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `fk_sid` FOREIGN KEY (`sid`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;

--
-- Constraints for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD CONSTRAINT `fk_pincdoe` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pincodes_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `subsubcategory`
--
ALTER TABLE `subsubcategory`
  ADD CONSTRAINT `subsubcategory_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `subcategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
