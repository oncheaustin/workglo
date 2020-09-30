-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2019 at 07:57 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gigtodov4emptyscript`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `admin_name` text NOT NULL,
  `admin_user_name` text NOT NULL,
  `admin_email` text NOT NULL,
  `admin_pass` text NOT NULL,
  `admin_image` text NOT NULL,
  `admin_contact` text NOT NULL,
  `admin_country` text NOT NULL,
  `admin_job` text NOT NULL,
  `admin_about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_user_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(9, 'Pat', 'Patrice', 'patson@gigtodo.com', '$2y$10$Qp2gy/nm/ZF0xErCw.OweO7t1oPtQyBVIbk6ed81YKmJRq4vFlid6', '', '76524', 'USA', 'Admin USA', 'In charge of the US');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `work` varchar(255) NOT NULL,
  `work_id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `work`, `work_id`, `date`, `status`) VALUES
(1, 9, 'social_login_settings', 0, 'October 06, 2019 05:01:35', 'updated'),
(2, 9, 'general_settings', 0, 'October 06, 2019 05:01:55', 'updated'),
(3, 9, 'paypal_settings', 0, 'October 06, 2019 05:04:25', 'updated'),
(4, 9, 'stripe_settings', 0, 'October 06, 2019 05:04:38', 'updated'),
(5, 9, 'coinpayments_settings', 0, 'October 06, 2019 05:04:52', 'updated'),
(6, 9, 'paystack_settings', 0, 'October 06, 2019 05:05:03', 'updated'),
(7, 9, 'dusupay_settings', 0, 'October 06, 2019 05:05:15', 'updated'),
(8, 9, 'general_payment_settings', 0, 'October 06, 2019 05:20:33', 'updated'),
(9, 9, 'general_payment_settings', 0, 'October 06, 2019 05:20:42', 'updated');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_info`
--

CREATE TABLE `app_info` (
  `id` int(100) NOT NULL,
  `version` varchar(255) NOT NULL,
  `r_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_info`
--

INSERT INTO `app_info` (`id`, `version`, `r_date`) VALUES
(1, '1.4.1', 'August 30, 2019 10:05:30 AM');

-- --------------------------------------------------------

--
-- Table structure for table `archived_messages`
--

CREATE TABLE `archived_messages` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `message_group_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_cat`
--

CREATE TABLE `article_cat` (
  `article_cat_id` int(11) NOT NULL,
  `language_id` int(10) NOT NULL,
  `article_cat_title` text NOT NULL,
  `position` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_requests`
--

CREATE TABLE `buyer_requests` (
  `request_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `child_id` int(10) NOT NULL,
  `request_title` text NOT NULL,
  `request_description` text NOT NULL,
  `request_file` text NOT NULL,
  `delivery_time` text NOT NULL,
  `request_budget` text NOT NULL,
  `request_date` text NOT NULL,
  `request_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_reviews`
--

CREATE TABLE `buyer_reviews` (
  `review_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `review_buyer_id` int(10) NOT NULL,
  `buyer_rating` int(10) NOT NULL,
  `buyer_review` text NOT NULL,
  `review_seller_id` int(10) NOT NULL,
  `review_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `proposal_price` varchar(255) NOT NULL DEFAULT '0',
  `proposal_qty` int(10) NOT NULL,
  `coupon_used` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_url` varchar(255) NOT NULL,
  `cat_image` text NOT NULL,
  `cat_featured` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_url`, `cat_image`, `cat_featured`) VALUES
(1, 'graphics-design', 'p1.png', 'yes'),
(2, 'digital-marketing', 'p2.png', 'yes'),
(3, 'writing-translation', 'p3.png', 'yes'),
(4, 'video-animation', 'p4.png', 'yes'),
(6, 'programming-tech', 'p5.png', 'yes'),
(7, 'business', 'p6.png', 'yes'),
(8, 'fun-lifestyle', 'p7.png', 'yes'),
(9, 'music-audio', 'p8.png', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `categories_children`
--

CREATE TABLE `categories_children` (
  `child_id` int(10) NOT NULL,
  `child_url` varchar(255) NOT NULL,
  `child_parent_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories_children`
--

INSERT INTO `categories_children` (`child_id`, `child_url`, `child_parent_id`) VALUES
(1, 'logo-design', 1),
(2, 'business-cards-amp-stationery', 1),
(3, 'illustration', 1),
(4, 'cartoons-caricatures', 1),
(5, 'flyers-posters', 1),
(6, 'book-covers-packaging', 1),
(7, 'web-amp-mobile-design', 1),
(8, 'social-media-design', 1),
(9, 'banner-ads', 1),
(10, 'social-media-marketing', 2),
(11, 'wordpress', 6),
(12, 'photoshop-editing', 1),
(13, '3d-2d-models', 1),
(14, 't-shirts', 1),
(15, 'presentation-design', 1),
(16, 'other', 1),
(17, 'seo', 2),
(18, 'web-traffic', 2),
(19, 'content-marketing', 2),
(20, 'video-marketing', 2),
(21, 'email-marketing', 2),
(22, 'search-display-marketing', 2),
(23, 'marketing-strategy', 2),
(24, 'web-analytics', 2),
(25, 'influencer-marketing', 2),
(26, 'local-listings', 2),
(27, 'domain-research', 2),
(28, 'e-commerce-marketing', 2),
(29, 'mobile-advertising', 2),
(30, 'resumes-cover-letters', 3),
(31, 'proofreading-editing', 3),
(32, 'translation', 3),
(33, 'creative-writing', 3),
(34, 'business-copywriting', 3),
(35, 'research-summaries', 3),
(36, 'articles-blog-posts', 3),
(37, 'press-releases', 3),
(38, 'transcription', 3),
(39, 'legal-writing', 3),
(40, 'other', 3),
(41, 'whiteboard-explainer-videos', 4),
(42, 'intros-animated-logos', 4),
(43, 'promotional-brand-videos', 4),
(44, 'editing-post-production', 4),
(45, 'lyric-music-videos', 4),
(46, 'spokespersons-testimonials', 4),
(48, 'other', 4),
(49, 'voice-over', 9),
(50, 'mixing-mastering', 9),
(51, 'producers-composers', 9),
(52, 'singer-songwriters', 9),
(53, 'session-musicians-singers', 9),
(54, 'jingles-drops', 9),
(55, 'sound-effects', 9),
(56, 'web-programming', 6),
(58, 'website-builders-cms', 6),
(60, 'ecommerce', 6),
(61, 'mobile-apps-web', 6),
(62, 'desktop-applications', 6),
(63, 'support-it', 6),
(64, 'chatbots', 6),
(65, 'data-analysis-reports', 6),
(66, 'convert-files', 6),
(67, 'databases', 6),
(68, 'user-testing', 6),
(69, 'other', 6),
(70, 'virtual-assistant', 7),
(71, 'market-research', 7),
(72, 'business-plans', 7),
(73, 'branding-services', 7),
(74, 'legal-consulting', 7),
(75, 'financial-consulting', 7),
(76, 'business-tips', 7),
(77, 'presentations', 7),
(78, 'career-advice', 7),
(79, 'flyer-distribution', 7),
(80, 'other', 7),
(81, 'online-lessons', 8),
(82, 'arts-crafts', 8),
(83, 'relationship-advice', 8),
(84, 'health-nutrition-fitness', 8),
(85, 'astrology-readings', 8),
(86, 'spiritual-healing', 8),
(87, 'family-genealogy', 8),
(88, 'collectibles', 8),
(89, 'greeting-cards-videos', 8),
(91, 'viral-videos', 8),
(92, 'pranks-stunts', 8),
(93, 'celebrity-impersonators', 8),
(94, 'other', 8),
(102, 'dsdsds', 1),
(103, 'aerobic-exercise', 22);

-- --------------------------------------------------------

--
-- Table structure for table `cats_meta`
--

CREATE TABLE `cats_meta` (
  `id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cats_meta`
--

INSERT INTO `cats_meta` (`id`, `cat_id`, `language_id`, `cat_title`, `cat_desc`) VALUES
(1, 1, 1, 'Graphics & Design', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(2, 2, 1, 'Digital Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(3, 3, 1, 'Writing & Translation', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(4, 4, 1, 'Video & Animation\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(5, 6, 1, 'Programming & Tech\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(6, 7, 1, 'Business\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(7, 8, 1, 'Fun & Lifestyle\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(8, 9, 1, 'Music & Audio', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. '),
(428, 1, 40, '', ''),
(445, 14, 41, '', ''),
(446, 1, 42, '', ''),
(447, 2, 42, '', ''),
(448, 3, 42, '', ''),
(449, 4, 42, '', ''),
(450, 6, 42, '', ''),
(451, 7, 42, '', ''),
(452, 8, 42, '', ''),
(453, 9, 42, '', ''),
(454, 14, 42, '', ''),
(632, 1, 19, '', ''),
(633, 2, 19, '', ''),
(634, 3, 19, '', ''),
(635, 4, 19, '', ''),
(636, 6, 19, '', ''),
(637, 7, 19, '', ''),
(638, 8, 19, '', ''),
(639, 9, 19, '', ''),
(640, 20, 19, '', ''),
(641, 21, 19, '', ''),
(642, 22, 19, '', ''),
(797, 1, 35, '', ''),
(798, 2, 35, '', ''),
(799, 3, 35, '', ''),
(800, 4, 35, '', ''),
(801, 6, 35, '', ''),
(802, 7, 35, '', ''),
(803, 8, 35, '', ''),
(804, 9, 35, '', ''),
(805, 20, 35, '', ''),
(806, 21, 35, '', ''),
(807, 22, 35, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `child_cats_meta`
--

CREATE TABLE `child_cats_meta` (
  `id` int(10) NOT NULL,
  `child_id` int(10) NOT NULL,
  `child_parent_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `child_title` varchar(255) NOT NULL,
  `child_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child_cats_meta`
--

INSERT INTO `child_cats_meta` (`id`, `child_id`, `child_parent_id`, `language_id`, `child_title`, `child_desc`) VALUES
(1, 1, 1, 1, 'Logo Design', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(2, 2, 1, 1, 'Business Cards &amp; Stationery', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(3, 3, 1, 1, 'Illustration', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(4, 4, 1, 1, 'Cartoons Caricatures', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(5, 5, 1, 1, 'Flyers Posters', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(6, 6, 1, 1, 'Book Covers & Packaging', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(7, 7, 1, 1, 'Web &amp; Mobile Design', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(8, 8, 1, 1, 'Social Media Design', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(9, 9, 1, 1, 'Banner Ads', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(10, 10, 2, 1, 'Social Media Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(11, 11, 6, 1, 'WordPress', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(12, 12, 1, 1, 'Photoshop Editing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(13, 13, 1, 1, '3D & 2D Models', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(14, 14, 1, 1, 'T-Shirts', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(15, 15, 1, 1, 'Presentation Design', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(16, 16, 1, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(17, 17, 2, 1, 'SEO', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(18, 18, 2, 1, 'Web Traffic', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(19, 19, 2, 1, 'Content Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(20, 20, 2, 1, 'Video Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(21, 21, 2, 1, 'Email Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(22, 22, 2, 1, 'Search & Display Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(23, 23, 2, 1, 'Marketing Strategy', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(24, 24, 2, 1, 'Web Analytics', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(25, 25, 2, 1, 'Influencer Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(26, 26, 2, 1, 'Local Listings', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(27, 27, 2, 1, 'Domain Research', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(28, 28, 2, 1, 'E-Commerce Marketing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(29, 29, 2, 1, 'Mobile Advertising', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(30, 30, 3, 1, 'Resumes & Cover Letters', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(31, 31, 3, 1, 'Proofreading & Editing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(32, 32, 3, 1, 'Translation', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(33, 33, 3, 1, 'Creative Writing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(34, 34, 3, 1, 'Business Copywriting', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(35, 35, 3, 1, 'Research & Summaries', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(36, 36, 3, 1, 'Articles & Blog Posts', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(37, 37, 3, 1, 'Press Releases', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(38, 38, 3, 1, 'Transcription', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(39, 39, 3, 1, 'Legal Writing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(40, 40, 3, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(41, 41, 4, 1, 'Whiteboard & Explainer Videos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(42, 42, 4, 1, 'Intros & Animated Logos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(43, 43, 4, 1, 'Promotional & Brand Videos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(44, 44, 4, 1, 'Editing & Post Production', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(45, 45, 4, 1, 'Lyric & Music Videos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(46, 46, 4, 1, 'Spokespersons & Testimonials', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(47, 48, 4, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(48, 49, 9, 1, 'Voice Over', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(49, 50, 9, 1, 'Mixing & Mastering', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(50, 51, 9, 1, 'Producers & Composers', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(51, 52, 9, 1, 'Singer-Songwriters', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(52, 53, 9, 1, 'Session Musicians & Singers', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(53, 54, 9, 1, 'Jingles & Drops', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(54, 55, 9, 1, 'Sound Effects', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(55, 56, 6, 1, 'Web Programming', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(56, 58, 6, 1, 'Website Builders & CMS', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(57, 60, 6, 1, 'Ecommerce', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(58, 61, 6, 1, 'Mobile Apps & Web', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(59, 62, 6, 1, 'Desktop applications', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(60, 63, 6, 1, 'Support & IT', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(61, 64, 6, 1, 'Chatbots', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(62, 65, 6, 1, 'Data Analysis & Reports', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(63, 66, 6, 1, 'Convert Files', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(64, 67, 6, 1, 'Databases', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(65, 68, 6, 1, 'User Testing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(66, 69, 6, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(67, 70, 7, 1, 'Virtual Assistant', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(68, 71, 7, 1, 'Market Research', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(69, 72, 7, 1, 'Business Plans', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(70, 73, 7, 1, 'Branding Services', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(71, 74, 7, 1, 'Legal Consulting', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(72, 75, 7, 1, 'Financial Consulting', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(73, 76, 7, 1, 'Business Tips', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(74, 77, 7, 1, 'Presentations', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(75, 78, 7, 1, 'Career Advice', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(76, 79, 7, 1, 'Flyer Distribution', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(77, 80, 7, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(78, 81, 8, 1, 'Online Lessons', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(79, 82, 8, 1, 'Arts & Crafts', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(80, 83, 8, 1, 'Relationship Advice', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(81, 84, 8, 1, 'Health, Nutrition & Fitness', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(82, 85, 8, 1, 'Astrology & Readings', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(83, 86, 8, 1, 'Spiritual & Healing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(84, 87, 8, 1, 'Family & Genealogy', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(85, 88, 8, 1, 'Collectibles', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(86, 89, 8, 1, 'Greeting Cards & Videos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(87, 91, 8, 1, 'Viral Videos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(88, 92, 8, 1, 'Pranks & Stunts', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(89, 93, 8, 1, 'Celebrity Impersonators', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(90, 94, 8, 1, 'Other', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'),
(3514, 1, 1, 40, '', ''),
(3515, 2, 1, 40, '', ''),
(3516, 3, 1, 40, '', ''),
(3517, 4, 1, 40, '', ''),
(3518, 5, 1, 40, '', ''),
(3519, 6, 1, 40, '', ''),
(3520, 7, 1, 40, '', ''),
(3521, 8, 1, 40, '', ''),
(3522, 9, 1, 40, '', ''),
(3523, 10, 2, 40, '', ''),
(3524, 11, 6, 40, '', ''),
(3525, 12, 1, 40, '', ''),
(3526, 13, 1, 40, '', ''),
(3527, 14, 1, 40, '', ''),
(3528, 15, 1, 40, '', ''),
(3529, 16, 1, 40, '', ''),
(3530, 17, 2, 40, '', ''),
(3531, 18, 2, 40, '', ''),
(3532, 19, 2, 40, '', ''),
(3533, 20, 2, 40, '', ''),
(3534, 21, 2, 40, '', ''),
(3535, 22, 2, 40, '', ''),
(3536, 23, 2, 40, '', ''),
(3537, 24, 2, 40, '', ''),
(3538, 25, 2, 40, '', ''),
(3539, 26, 2, 40, '', ''),
(3540, 27, 2, 40, '', ''),
(3541, 28, 2, 40, '', ''),
(3542, 29, 2, 40, '', ''),
(3543, 30, 3, 40, '', ''),
(3544, 31, 3, 40, '', ''),
(3545, 32, 3, 40, '', ''),
(3546, 33, 3, 40, '', ''),
(3547, 34, 3, 40, '', ''),
(3548, 35, 3, 40, '', ''),
(3549, 36, 3, 40, '', ''),
(3550, 37, 3, 40, '', ''),
(3551, 38, 3, 40, '', ''),
(3552, 39, 3, 40, '', ''),
(3553, 40, 3, 40, '', ''),
(3554, 41, 4, 40, '', ''),
(3555, 42, 4, 40, '', ''),
(3556, 43, 4, 40, '', ''),
(3557, 44, 4, 40, '', ''),
(3558, 45, 4, 40, '', ''),
(3559, 46, 4, 40, '', ''),
(3560, 48, 4, 40, '', ''),
(3561, 49, 9, 40, '', ''),
(3562, 50, 9, 40, '', ''),
(3563, 51, 9, 40, '', ''),
(3564, 52, 9, 40, '', ''),
(3565, 53, 9, 40, '', ''),
(3566, 54, 9, 40, '', ''),
(3567, 55, 9, 40, '', ''),
(3568, 56, 6, 40, '', ''),
(3569, 58, 6, 40, '', ''),
(3570, 60, 6, 40, '', ''),
(3571, 61, 6, 40, '', ''),
(3572, 62, 6, 40, '', ''),
(3573, 63, 6, 40, '', ''),
(3574, 64, 6, 40, '', ''),
(3575, 65, 6, 40, '', ''),
(3576, 66, 6, 40, '', ''),
(3577, 67, 6, 40, '', ''),
(3578, 68, 6, 40, '', ''),
(3579, 69, 6, 40, '', ''),
(3580, 70, 7, 40, '', ''),
(3581, 71, 7, 40, '', ''),
(3582, 72, 7, 40, '', ''),
(3583, 73, 7, 40, '', ''),
(3584, 74, 7, 40, '', ''),
(3585, 75, 7, 40, '', ''),
(3586, 76, 7, 40, '', ''),
(3587, 77, 7, 40, '', ''),
(3588, 78, 7, 40, '', ''),
(3589, 79, 7, 40, '', ''),
(3590, 80, 7, 40, '', ''),
(3591, 81, 8, 40, '', ''),
(3592, 82, 8, 40, '', ''),
(3593, 83, 8, 40, '', ''),
(3594, 84, 8, 40, '', ''),
(3595, 85, 8, 40, '', ''),
(3596, 86, 8, 40, '', ''),
(3597, 87, 8, 40, '', ''),
(3598, 88, 8, 40, '', ''),
(3599, 89, 8, 40, '', ''),
(3600, 91, 8, 40, '', ''),
(3601, 92, 8, 40, '', ''),
(3602, 93, 8, 40, '', ''),
(3603, 94, 8, 40, '', ''),
(3608, 1, 1, 41, '', ''),
(3609, 2, 1, 41, '', ''),
(3610, 3, 1, 41, '', ''),
(3611, 4, 1, 41, '', ''),
(3612, 5, 1, 41, '', ''),
(3613, 6, 1, 41, '', ''),
(3614, 7, 1, 41, '', ''),
(3615, 8, 1, 41, '', ''),
(3616, 9, 1, 41, '', ''),
(3617, 10, 2, 41, '', ''),
(3618, 11, 6, 41, '', ''),
(3619, 12, 1, 41, '', ''),
(3620, 13, 1, 41, '', ''),
(3621, 14, 1, 41, '', ''),
(3622, 15, 1, 41, '', ''),
(3623, 16, 1, 41, '', ''),
(3624, 17, 2, 41, '', ''),
(3625, 18, 2, 41, '', ''),
(3626, 19, 2, 41, '', ''),
(3627, 20, 2, 41, '', ''),
(3628, 21, 2, 41, '', ''),
(3629, 22, 2, 41, '', ''),
(3630, 23, 2, 41, '', ''),
(3631, 24, 2, 41, '', ''),
(3632, 25, 2, 41, '', ''),
(3633, 26, 2, 41, '', ''),
(3634, 27, 2, 41, '', ''),
(3635, 28, 2, 41, '', ''),
(3636, 29, 2, 41, '', ''),
(3637, 30, 3, 41, '', ''),
(3638, 31, 3, 41, '', ''),
(3639, 32, 3, 41, '', ''),
(3640, 33, 3, 41, '', ''),
(3641, 34, 3, 41, '', ''),
(3642, 35, 3, 41, '', ''),
(3643, 36, 3, 41, '', ''),
(3644, 37, 3, 41, '', ''),
(3645, 38, 3, 41, '', ''),
(3646, 39, 3, 41, '', ''),
(3647, 40, 3, 41, '', ''),
(3648, 41, 4, 41, '', ''),
(3649, 42, 4, 41, '', ''),
(3650, 43, 4, 41, '', ''),
(3651, 44, 4, 41, '', ''),
(3652, 45, 4, 41, '', ''),
(3653, 46, 4, 41, '', ''),
(3654, 48, 4, 41, '', ''),
(3655, 49, 9, 41, '', ''),
(3656, 50, 9, 41, '', ''),
(3657, 51, 9, 41, '', ''),
(3658, 52, 9, 41, '', ''),
(3659, 53, 9, 41, '', ''),
(3660, 54, 9, 41, '', ''),
(3661, 55, 9, 41, '', ''),
(3662, 56, 6, 41, '', ''),
(3663, 58, 6, 41, '', ''),
(3664, 60, 6, 41, '', ''),
(3665, 61, 6, 41, '', ''),
(3666, 62, 6, 41, '', ''),
(3667, 63, 6, 41, '', ''),
(3668, 64, 6, 41, '', ''),
(3669, 65, 6, 41, '', ''),
(3670, 66, 6, 41, '', ''),
(3671, 67, 6, 41, '', ''),
(3672, 68, 6, 41, '', ''),
(3673, 69, 6, 41, '', ''),
(3674, 70, 7, 41, '', ''),
(3675, 71, 7, 41, '', ''),
(3676, 72, 7, 41, '', ''),
(3677, 73, 7, 41, '', ''),
(3678, 74, 7, 41, '', ''),
(3679, 75, 7, 41, '', ''),
(3680, 76, 7, 41, '', ''),
(3681, 77, 7, 41, '', ''),
(3682, 78, 7, 41, '', ''),
(3683, 79, 7, 41, '', ''),
(3684, 80, 7, 41, '', ''),
(3685, 81, 8, 41, '', ''),
(3686, 82, 8, 41, '', ''),
(3687, 83, 8, 41, '', ''),
(3688, 84, 8, 41, '', ''),
(3689, 85, 8, 41, '', ''),
(3690, 86, 8, 41, '', ''),
(3691, 87, 8, 41, '', ''),
(3692, 88, 8, 41, '', ''),
(3693, 89, 8, 41, '', ''),
(3694, 91, 8, 41, '', ''),
(3695, 92, 8, 41, '', ''),
(3696, 93, 8, 41, '', ''),
(3697, 94, 8, 41, '', ''),
(3702, 1, 1, 42, '', ''),
(3703, 2, 1, 42, '', ''),
(3704, 3, 1, 42, '', ''),
(3705, 4, 1, 42, '', ''),
(3706, 5, 1, 42, '', ''),
(3707, 6, 1, 42, '', ''),
(3708, 7, 1, 42, '', ''),
(3709, 8, 1, 42, '', ''),
(3710, 9, 1, 42, '', ''),
(3711, 10, 2, 42, '', ''),
(3712, 11, 6, 42, '', ''),
(3713, 12, 1, 42, '', ''),
(3714, 13, 1, 42, '', ''),
(3715, 14, 1, 42, '', ''),
(3716, 15, 1, 42, '', ''),
(3717, 16, 1, 42, '', ''),
(3718, 17, 2, 42, '', ''),
(3719, 18, 2, 42, '', ''),
(3720, 19, 2, 42, '', ''),
(3721, 20, 2, 42, '', ''),
(3722, 21, 2, 42, '', ''),
(3723, 22, 2, 42, '', ''),
(3724, 23, 2, 42, '', ''),
(3725, 24, 2, 42, '', ''),
(3726, 25, 2, 42, '', ''),
(3727, 26, 2, 42, '', ''),
(3728, 27, 2, 42, '', ''),
(3729, 28, 2, 42, '', ''),
(3730, 29, 2, 42, '', ''),
(3731, 30, 3, 42, '', ''),
(3732, 31, 3, 42, '', ''),
(3733, 32, 3, 42, '', ''),
(3734, 33, 3, 42, '', ''),
(3735, 34, 3, 42, '', ''),
(3736, 35, 3, 42, '', ''),
(3737, 36, 3, 42, '', ''),
(3738, 37, 3, 42, '', ''),
(3739, 38, 3, 42, '', ''),
(3740, 39, 3, 42, '', ''),
(3741, 40, 3, 42, '', ''),
(3742, 41, 4, 42, '', ''),
(3743, 42, 4, 42, '', ''),
(3744, 43, 4, 42, '', ''),
(3745, 44, 4, 42, '', ''),
(3746, 45, 4, 42, '', ''),
(3747, 46, 4, 42, '', ''),
(3748, 48, 4, 42, '', ''),
(3749, 49, 9, 42, '', ''),
(3750, 50, 9, 42, '', ''),
(3751, 51, 9, 42, '', ''),
(3752, 52, 9, 42, '', ''),
(3753, 53, 9, 42, '', ''),
(3754, 54, 9, 42, '', ''),
(3755, 55, 9, 42, '', ''),
(3756, 56, 6, 42, '', ''),
(3757, 58, 6, 42, '', ''),
(3758, 60, 6, 42, '', ''),
(3759, 61, 6, 42, '', ''),
(3760, 62, 6, 42, '', ''),
(3761, 63, 6, 42, '', ''),
(3762, 64, 6, 42, '', ''),
(3763, 65, 6, 42, '', ''),
(3764, 66, 6, 42, '', ''),
(3765, 67, 6, 42, '', ''),
(3766, 68, 6, 42, '', ''),
(3767, 69, 6, 42, '', ''),
(3768, 70, 7, 42, '', ''),
(3769, 71, 7, 42, '', ''),
(3770, 72, 7, 42, '', ''),
(3771, 73, 7, 42, '', ''),
(3772, 74, 7, 42, '', ''),
(3773, 75, 7, 42, '', ''),
(3774, 76, 7, 42, '', ''),
(3775, 77, 7, 42, '', ''),
(3776, 78, 7, 42, '', ''),
(3777, 79, 7, 42, '', ''),
(3778, 80, 7, 42, '', ''),
(3779, 81, 8, 42, '', ''),
(3780, 82, 8, 42, '', ''),
(3781, 83, 8, 42, '', ''),
(3782, 84, 8, 42, '', ''),
(3783, 85, 8, 42, '', ''),
(3784, 86, 8, 42, '', ''),
(3785, 87, 8, 42, '', ''),
(3786, 88, 8, 42, '', ''),
(3787, 89, 8, 42, '', ''),
(3788, 91, 8, 42, '', ''),
(3789, 92, 8, 42, '', ''),
(3790, 93, 8, 42, '', ''),
(3791, 94, 8, 42, '', ''),
(5353, 1, 1, 19, '', ''),
(5354, 2, 1, 19, '', ''),
(5355, 3, 1, 19, '', ''),
(5356, 4, 1, 19, '', ''),
(5357, 5, 1, 19, '', ''),
(5358, 6, 1, 19, '', ''),
(5359, 7, 1, 19, '', ''),
(5360, 8, 1, 19, '', ''),
(5361, 9, 1, 19, '', ''),
(5362, 10, 2, 19, '', ''),
(5363, 11, 6, 19, '', ''),
(5364, 12, 1, 19, '', ''),
(5365, 13, 1, 19, '', ''),
(5366, 14, 1, 19, '', ''),
(5367, 15, 1, 19, '', ''),
(5368, 16, 1, 19, '', ''),
(5369, 17, 2, 19, '', ''),
(5370, 18, 2, 19, '', ''),
(5371, 19, 2, 19, '', ''),
(5372, 20, 2, 19, '', ''),
(5373, 21, 2, 19, '', ''),
(5374, 22, 2, 19, '', ''),
(5375, 23, 2, 19, '', ''),
(5376, 24, 2, 19, '', ''),
(5377, 25, 2, 19, '', ''),
(5378, 26, 2, 19, '', ''),
(5379, 27, 2, 19, '', ''),
(5380, 28, 2, 19, '', ''),
(5381, 29, 2, 19, '', ''),
(5382, 30, 3, 19, '', ''),
(5383, 31, 3, 19, '', ''),
(5384, 32, 3, 19, '', ''),
(5385, 33, 3, 19, '', ''),
(5386, 34, 3, 19, '', ''),
(5387, 35, 3, 19, '', ''),
(5388, 36, 3, 19, '', ''),
(5389, 37, 3, 19, '', ''),
(5390, 38, 3, 19, '', ''),
(5391, 39, 3, 19, '', ''),
(5392, 40, 3, 19, '', ''),
(5393, 41, 4, 19, '', ''),
(5394, 42, 4, 19, '', ''),
(5395, 43, 4, 19, '', ''),
(5396, 44, 4, 19, '', ''),
(5397, 45, 4, 19, '', ''),
(5398, 46, 4, 19, '', ''),
(5399, 48, 4, 19, '', ''),
(5400, 49, 9, 19, '', ''),
(5401, 50, 9, 19, '', ''),
(5402, 51, 9, 19, '', ''),
(5403, 52, 9, 19, '', ''),
(5404, 53, 9, 19, '', ''),
(5405, 54, 9, 19, '', ''),
(5406, 55, 9, 19, '', ''),
(5407, 56, 6, 19, '', ''),
(5408, 58, 6, 19, '', ''),
(5409, 60, 6, 19, '', ''),
(5410, 61, 6, 19, '', ''),
(5411, 62, 6, 19, '', ''),
(5412, 63, 6, 19, '', ''),
(5413, 64, 6, 19, '', ''),
(5414, 65, 6, 19, '', ''),
(5415, 66, 6, 19, '', ''),
(5416, 67, 6, 19, '', ''),
(5417, 68, 6, 19, '', ''),
(5418, 69, 6, 19, '', ''),
(5419, 70, 7, 19, '', ''),
(5420, 71, 7, 19, '', ''),
(5421, 72, 7, 19, '', ''),
(5422, 73, 7, 19, '', ''),
(5423, 74, 7, 19, '', ''),
(5424, 75, 7, 19, '', ''),
(5425, 76, 7, 19, '', ''),
(5426, 77, 7, 19, '', ''),
(5427, 78, 7, 19, '', ''),
(5428, 79, 7, 19, '', ''),
(5429, 80, 7, 19, '', ''),
(5430, 81, 8, 19, '', ''),
(5431, 82, 8, 19, '', ''),
(5432, 83, 8, 19, '', ''),
(5433, 84, 8, 19, '', ''),
(5434, 85, 8, 19, '', ''),
(5435, 86, 8, 19, '', ''),
(5436, 87, 8, 19, '', ''),
(5437, 88, 8, 19, '', ''),
(5438, 89, 8, 19, '', ''),
(5439, 91, 8, 19, '', ''),
(5440, 92, 8, 19, '', ''),
(5441, 93, 8, 19, '', ''),
(5442, 94, 8, 19, '', ''),
(5443, 102, 1, 19, '', ''),
(5444, 103, 22, 19, '', ''),
(6733, 1, 1, 35, '', ''),
(6734, 2, 1, 35, '', ''),
(6735, 3, 1, 35, '', ''),
(6736, 4, 1, 35, '', ''),
(6737, 5, 1, 35, '', ''),
(6738, 6, 1, 35, '', ''),
(6739, 7, 1, 35, '', ''),
(6740, 8, 1, 35, '', ''),
(6741, 9, 1, 35, '', ''),
(6742, 10, 2, 35, '', ''),
(6743, 11, 6, 35, '', ''),
(6744, 12, 1, 35, '', ''),
(6745, 13, 1, 35, '', ''),
(6746, 14, 1, 35, '', ''),
(6747, 15, 1, 35, '', ''),
(6748, 16, 1, 35, '', ''),
(6749, 17, 2, 35, '', ''),
(6750, 18, 2, 35, '', ''),
(6751, 19, 2, 35, '', ''),
(6752, 20, 2, 35, '', ''),
(6753, 21, 2, 35, '', ''),
(6754, 22, 2, 35, '', ''),
(6755, 23, 2, 35, '', ''),
(6756, 24, 2, 35, '', ''),
(6757, 25, 2, 35, '', ''),
(6758, 26, 2, 35, '', ''),
(6759, 27, 2, 35, '', ''),
(6760, 28, 2, 35, '', ''),
(6761, 29, 2, 35, '', ''),
(6762, 30, 3, 35, '', ''),
(6763, 31, 3, 35, '', ''),
(6764, 32, 3, 35, '', ''),
(6765, 33, 3, 35, '', ''),
(6766, 34, 3, 35, '', ''),
(6767, 35, 3, 35, '', ''),
(6768, 36, 3, 35, '', ''),
(6769, 37, 3, 35, '', ''),
(6770, 38, 3, 35, '', ''),
(6771, 39, 3, 35, '', ''),
(6772, 40, 3, 35, '', ''),
(6773, 41, 4, 35, '', ''),
(6774, 42, 4, 35, '', ''),
(6775, 43, 4, 35, '', ''),
(6776, 44, 4, 35, '', ''),
(6777, 45, 4, 35, '', ''),
(6778, 46, 4, 35, '', ''),
(6779, 48, 4, 35, '', ''),
(6780, 49, 9, 35, '', ''),
(6781, 50, 9, 35, '', ''),
(6782, 51, 9, 35, '', ''),
(6783, 52, 9, 35, '', ''),
(6784, 53, 9, 35, '', ''),
(6785, 54, 9, 35, '', ''),
(6786, 55, 9, 35, '', ''),
(6787, 56, 6, 35, '', ''),
(6788, 58, 6, 35, '', ''),
(6789, 60, 6, 35, '', ''),
(6790, 61, 6, 35, '', ''),
(6791, 62, 6, 35, '', ''),
(6792, 63, 6, 35, '', ''),
(6793, 64, 6, 35, '', ''),
(6794, 65, 6, 35, '', ''),
(6795, 66, 6, 35, '', ''),
(6796, 67, 6, 35, '', ''),
(6797, 68, 6, 35, '', ''),
(6798, 69, 6, 35, '', ''),
(6799, 70, 7, 35, '', ''),
(6800, 71, 7, 35, '', ''),
(6801, 72, 7, 35, '', ''),
(6802, 73, 7, 35, '', ''),
(6803, 74, 7, 35, '', ''),
(6804, 75, 7, 35, '', ''),
(6805, 76, 7, 35, '', ''),
(6806, 77, 7, 35, '', ''),
(6807, 78, 7, 35, '', ''),
(6808, 79, 7, 35, '', ''),
(6809, 80, 7, 35, '', ''),
(6810, 81, 8, 35, '', ''),
(6811, 82, 8, 35, '', ''),
(6812, 83, 8, 35, '', ''),
(6813, 84, 8, 35, '', ''),
(6814, 85, 8, 35, '', ''),
(6815, 86, 8, 35, '', ''),
(6816, 87, 8, 35, '', ''),
(6817, 88, 8, 35, '', ''),
(6818, 89, 8, 35, '', ''),
(6819, 91, 8, 35, '', ''),
(6820, 92, 8, 35, '', ''),
(6821, 93, 8, 35, '', ''),
(6822, 94, 8, 35, '', ''),
(6823, 102, 1, 35, '', ''),
(6824, 103, 22, 35, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_support`
--

CREATE TABLE `contact_support` (
  `contact_id` int(10) NOT NULL,
  `contact_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_support`
--

INSERT INTO `contact_support` (`contact_id`, `contact_email`) VALUES
(1, 'admin-demo@pixinal.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_support_meta`
--

CREATE TABLE `contact_support_meta` (
  `id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `contact_heading` text NOT NULL,
  `contact_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_support_meta`
--

INSERT INTO `contact_support_meta` (`id`, `language_id`, `contact_heading`, `contact_desc`) VALUES
(1, 1, 'Submit A Support Request', 'If you have any questions, please feel free to contact us, Our customer service center is online 24/7.\r\n\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `coupon_title` text NOT NULL,
  `coupon_type` varchar(255) NOT NULL,
  `coupon_price` int(10) NOT NULL,
  `coupon_code` text NOT NULL,
  `coupon_limit` int(10) NOT NULL,
  `coupon_used` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_used`
--

CREATE TABLE `coupons_used` (
  `id` int(100) NOT NULL,
  `proposal_id` varchar(255) NOT NULL,
  `seller_id` varchar(255) NOT NULL,
  `coupon_used` varchar(255) NOT NULL,
  `coupon_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`) VALUES
(1, 'Afghan afghani', '&#065;&#102;'),
(2, 'Albanian lek', '&#076;&#101;&#107;'),
(3, 'Algerian dinar', '&#1583;&#1580;'),
(4, 'Euro', '&#8364;'),
(5, 'Angolan kwanza', '&#075;&#122;'),
(6, 'East Caribbean dollar', '&#036;'),
(7, 'Argentine peso', '&#036;'),
(8, 'Armenian dram', 'AMD'),
(9, 'Aruban florin', '&#402;'),
(10, 'Australian dollar', '&#036;'),
(11, 'Azerbaijani manat', '&#1084;&#1072;&#1085;'),
(12, 'Bahamian dollar', '&#036;'),
(13, 'Bahraini dinar', '.&#1583;.&#1576;'),
(14, 'Bangladeshi taka', '&#2547;'),
(15, 'Barbadian dollar', '&#036;'),
(16, 'Belarusian ruble', '&#112;&#046;'),
(17, 'Belizean dollar', '&#066;&#090;&#036;'),
(18, 'West African CFA franc', 'CFA'),
(19, 'Bermudian dollar', '&#036;'),
(20, 'Bhutanese ngultrum', '&#078;&#117;&#046;'),
(21, 'Bolivian boliviano', '&#036;&#098;'),
(22, 'US dollar', '&#036;'),
(23, 'Bosnia and Herzegovina convertible mark', '&#075;&#077;'),
(24, 'Botswana pula', '&#080;'),
(25, 'Brazilian real', '&#082;&#036;'),
(26, 'Brunei dollar', '&#036;'),
(27, 'Bulgarian lev', '&#1083;&#1074;'),
(28, 'Burmese kyat', '&#075;'),
(29, 'Burundian franc', '&#070;&#066;&#117;'),
(30, 'Cambodian riel', '&#6107;'),
(31, 'Central African CFA franc', '&#070;&#067;&#070;&#065;'),
(32, 'Canadian dollar', '&#036;'),
(33, 'Cape Verdean escudo', '&#036;'),
(34, 'Cayman Islands dollar', '&#036;'),
(35, 'Chilean peso', '&#036;'),
(36, 'Chinese renminbi', '&#165;'),
(37, 'Colombian peso', '&#036;'),
(38, 'Comorian franc', '&#067;&#070;'),
(39, 'Congolese franc', '&#070;&#067;'),
(40, 'New Zealand dollar', 'NZ&#036;'),
(41, 'Costa Rican colón', '&#8353;'),
(42, 'Croatian kuna', '&#107;&#110;'),
(43, 'Cuban peso', '&#8369;'),
(44, 'Netherlands Antilles guilder', '&#402;'),
(45, 'Czech koruna', '&#075;&#269;'),
(46, 'Danish krone', '&#107;&#114;'),
(47, 'Djiboutian franc', '&#070;&#100;&#106;'),
(48, 'Dominican peso', '&#082;&#068;&#036;'),
(49, 'Egyptian pound', 'EGP'),
(50, 'Salvadoran colón', '&#036;'),
(51, 'Eritrean nakfa', 'Nfk'),
(52, 'Ethiopian birr', '&#066;&#114;'),
(53, 'Falkland Islands pound', '&#163;'),
(54, 'Fijian dollar', '&#036;'),
(55, 'CFP franc', '&#070;'),
(56, 'Gambian dalasi', '&#068;'),
(57, 'Georgian lari', '&#4314;'),
(58, 'Ghanian cedi', '&#162;'),
(59, 'Gibraltar pound', '&#163;'),
(60, 'Guatemalan quetzal', '&#081;'),
(61, 'British pound', '&#163;'),
(62, 'Guinean franc', '&#070;&#071;'),
(63, 'Guyanese dollar', '&#036;'),
(64, 'Haitian gourde', '&#071;'),
(65, 'Honduran lempira', '&#076;'),
(66, 'Hong Kong dollar', '&#036;'),
(67, 'Hungarian forint', '&#070;&#116;'),
(68, 'Icelandic króna', '&#107;&#114;'),
(69, 'Indian rupee', '&#8377;'),
(70, 'Indonesian rupiah', '&#082;&#112;'),
(71, 'Iranian rial', '&#65020;'),
(72, 'Iraqi dinar', '&#1593;.&#1583;'),
(73, 'Israeli new sheqel', '&#8362;'),
(74, 'Jamaican dollar', '&#074;&#036;'),
(75, 'Japanese yen ', '&#165;'),
(76, 'Jordanian dinar', '&#074;&#068;'),
(77, 'Kazakhstani tenge', '&#1083;&#1074;'),
(78, 'Kenyan shilling', '&#075;&#083;&#104;'),
(79, 'North Korean won', '&#8361;'),
(80, 'Kuwaiti dinar', '&#1583;.&#1603;'),
(81, 'Kyrgyzstani som', '&#1083;&#1074;'),
(82, 'South Korean won', '&#8361;'),
(83, 'Lao kip', '&#8365;'),
(84, 'Latvian lats', '&#076;&#115;'),
(85, 'Lebanese pound', '&#163;'),
(86, 'Lesotho loti', '&#076;'),
(87, 'Liberian dollar', '&#036;'),
(88, 'Libyan dinar', '?.?'),
(89, 'Swiss franc', '&#067;&#072;&#070;'),
(90, 'Lithuanian litas', '&#076;&#116;'),
(91, 'Macanese pataca', '&#077;&#079;&#080;&#036;'),
(92, 'Macedonian denar', '&#1076;&#1077;&#1085;'),
(93, 'Malagasy ariary', '&#065;&#114;'),
(94, 'Malawian kwacha', '&#077;&#075;'),
(95, 'Malaysian ringgit', '&#082;&#077;'),
(96, 'Maldivian rufiyaa', '.&#1923;'),
(97, 'Mauritanian ouguiya', '&#085;&#077;'),
(98, 'Mauritian rupee', '&#8360;'),
(99, 'Mexican peso', '&#036;'),
(100, 'Moldovan leu', '&#076;'),
(101, 'Mongolian tugrik', '&#8366;'),
(102, 'Moroccan dirham', '&#1583;.&#1605;.'),
(103, 'Mozambican metical', '&#077;&#084;'),
(104, 'Namibian dollar', '&#036;'),
(105, 'Nepalese rupee', '&#8360;'),
(106, 'Nicaraguan córdoba', '&#067;&#036;'),
(107, 'Nigerian naira', '&#8358;'),
(108, 'Norwegian krone', '&#107;&#114;'),
(109, 'Omani rial', '&#65020;'),
(110, 'Pakistani rupee', '&#8360;'),
(111, 'Panamanian balboa', '&#066;&#047;&#046;'),
(112, 'Papua New Guinea kina', '&#075;'),
(113, 'Paraguayan guarani', '&#071;&#115;'),
(114, 'Peruvian nuevo sol', '&#083;&#047;&#046;'),
(115, 'Philippine peso', '&#8369;'),
(116, 'Polish zloty', '&#122;&#322;'),
(117, 'Qatari riyal', '&#65020;'),
(118, 'Romanian leu', '&#108;&#101;&#105;'),
(119, 'Russian ruble', '&#1088;&#1091;&#1073;'),
(120, 'Rwandan franc', '&#1585;.&#1587;'),
(121, 'Samoan t?l?', '&#087;&#083;&#036;'),
(122, 'São Tomé and Príncipe dobra', '&#068;&#098;'),
(123, 'Saudi riyal', '&#65020;'),
(124, 'Serbian dinar', '&#1044;&#1080;&#1085;&#046;'),
(125, 'Seychellois rupee', '&#8360;'),
(126, 'Sierra Leonean leone', '&#076;&#101;'),
(127, 'Singapore dollar', 'S&#036;'),
(128, 'Solomon Islands dollar', '&#036;'),
(129, 'Somali shilling', '&#083;'),
(130, 'South African rand', '&#082;'),
(131, 'Sri Lankan rupee', '&#8360;'),
(132, 'St. Helena pound', '&#163;'),
(133, 'Sudanese pound', '&#163;'),
(134, 'Surinamese dollar', '&#036;'),
(135, 'Swazi lilangeni', '&#076;'),
(136, 'Swedish krona', '&#107;&#114;'),
(137, 'Syrian pound', '&#163;'),
(138, 'New Taiwan dollar', '&#078;&#084;&#036;'),
(139, 'Tajikistani somoni', '&#084;&#074;&#083;'),
(140, 'Tanzanian shilling', 'Sh'),
(141, 'Thai baht ', '&#3647;'),
(142, 'Tongan pa’anga', '&#084;&#036;'),
(143, 'Trinidad and Tobago dollar', '&#036;'),
(144, 'Tunisian dinar', '&#1583;.&#1578;'),
(145, 'Turkish lira', '&#x20BA;'),
(146, 'Turkmenistani manat', '&#109;'),
(147, 'Ugandan shilling', '&#085;&#083;&#104;'),
(148, 'Ukrainian hryvnia', '&#8372;'),
(149, 'United Arab Emirates dirham', '&#1583;.&#1573;'),
(150, 'Uruguayan peso', '&#036;&#085;'),
(151, 'Uzbekistani som', '&#1083;&#1074;'),
(152, 'Vanuatu vatu', '&#086;&#084;'),
(153, 'Venezuelan bolivar', '&#066;&#115;'),
(154, 'Vietnamese dong', '&#8363;'),
(155, 'Yemeni rial', '&#65020;'),
(156, 'Zambian kwacha', '&#090;&#075;'),
(157, 'Zimbabwean dollar', '&#090;&#036;'),
(158, 'Jersey pound', '&#163;'),
(159, 'Libyan dinar', '&#1604;.&#1583;');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_times`
--

CREATE TABLE `delivery_times` (
  `delivery_id` int(10) NOT NULL,
  `delivery_title` text NOT NULL,
  `delivery_proposal_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_times`
--

INSERT INTO `delivery_times` (`delivery_id`, `delivery_title`, `delivery_proposal_title`) VALUES
(1, 'Up to 24 hours', '1 Day'),
(2, 'Up to 2 Days', '2 Days'),
(3, 'Up to 3 Days', '3 Days'),
(4, 'Up to 4 Days', '4 Days'),
(5, 'Up to 5 Days', '5 Days'),
(6, 'Up to 6 Days', '6 Days'),
(7, 'Up to 7 Days', '7 Days');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_types`
--

CREATE TABLE `enquiry_types` (
  `enquiry_id` int(10) NOT NULL,
  `enquiry_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquiry_types`
--

INSERT INTO `enquiry_types` (`enquiry_id`, `enquiry_title`) VALUES
(1, 'Order Support '),
(2, 'Review Removal '),
(3, 'Account Support'),
(4, 'Report A Bug \r\n');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,1) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favourite_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `featured_proposals`
--

CREATE TABLE `featured_proposals` (
  `featured_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `end_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `link_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  `link_title` text NOT NULL,
  `link_url` text NOT NULL,
  `link_section` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`link_id`, `language_id`, `icon_class`, `link_title`, `link_url`, `link_section`) VALUES
(1, 1, '', 'Graphics &amp; Design', '/categories/graphics-design', 'categories'),
(2, 1, '', 'Digital Marketing', '/categories/digital-marketing', 'categories'),
(3, 1, '', 'Writing & Translation\r\n', '/categories/writing-translation', 'categories'),
(4, 1, '', 'Video & Animation\r\n', '/categories/video-animation', 'categories'),
(5, 1, '', 'Music & Audio\r\n', '/categories/music-audio', 'categories'),
(6, 1, '', 'Programming & Tech\r\n', '/categories/programming-tech', 'categories'),
(7, 1, '', 'Business\r\n', '/categories/business', 'categories'),
(8, 1, '', 'Fun & Lifestyle\r\n', '/categories/fun-lifestyle', 'categories'),
(9, 1, 'fa-file-text-o', 'Terms & Conditions', '/terms_and_conditions', 'about'),
(10, 1, 'fa-google-plus-official', 'fa-google-plus-official', '#', 'follow'),
(11, 1, 'fa-twitter', '', '#', 'follow'),
(12, 1, 'fa-facebook', '', '#', 'follow'),
(13, 1, 'fa-linkedin', '', '#', 'follow'),
(14, 1, 'fa-pinterest', '', '#', 'follow'),
(15, 1, 'fa-comments', 'Customer Support', '/customer_support', 'about'),
(16, 1, 'fa-question-circle', 'How It Works', '/how-it-works', 'about'),
(17, 1, 'fa-book', 'Knowledge Bank', '/knowledge_bank', 'about');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) NOT NULL,
  `site_title` text NOT NULL,
  `site_www` int(10) NOT NULL,
  `site_name` text NOT NULL,
  `site_favicon` text NOT NULL,
  `site_logo_type` text NOT NULL,
  `site_logo_text` text NOT NULL,
  `site_logo_image` text NOT NULL,
  `site_logo` text NOT NULL,
  `site_desc` text NOT NULL,
  `site_keywords` text NOT NULL,
  `site_author` text NOT NULL,
  `site_url` text NOT NULL,
  `site_email_address` text NOT NULL,
  `site_copyright` text NOT NULL,
  `site_timezone` varchar(255) NOT NULL,
  `tinymce_api_key` text NOT NULL,
  `recaptcha_site_key` varchar(255) NOT NULL,
  `recaptcha_secret_key` varchar(255) NOT NULL,
  `enable_social_login` text NOT NULL,
  `fb_app_id` text NOT NULL,
  `fb_app_secret` text NOT NULL,
  `g_client_id` text NOT NULL,
  `g_client_secret` text NOT NULL,
  `jwplayer_code` text NOT NULL,
  `level_one_rating` int(10) NOT NULL,
  `level_one_orders` int(10) NOT NULL,
  `level_two_rating` int(10) NOT NULL,
  `level_two_orders` int(10) NOT NULL,
  `level_top_rating` int(10) NOT NULL,
  `level_top_orders` int(10) NOT NULL,
  `approve_proposals` text NOT NULL,
  `proposal_email` text NOT NULL,
  `signup_email` text NOT NULL,
  `relevant_requests` varchar(255) NOT NULL,
  `enable_referrals` text NOT NULL,
  `knowledge_bank` text NOT NULL,
  `referral_money` int(10) NOT NULL,
  `site_currency` varchar(255) NOT NULL,
  `enable_maintenance_mode` varchar(255) NOT NULL,
  `order_auto_complete` int(10) NOT NULL,
  `wish_do_manual_payouts` int(10) NOT NULL,
  `payouts_date` text NOT NULL,
  `payouts_anyday` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_www`, `site_name`, `site_favicon`, `site_logo_type`, `site_logo_text`, `site_logo_image`, `site_logo`, `site_desc`, `site_keywords`, `site_author`, `site_url`, `site_email_address`, `site_copyright`, `site_timezone`, `tinymce_api_key`, `recaptcha_site_key`, `recaptcha_secret_key`, `enable_social_login`, `fb_app_id`, `fb_app_secret`, `g_client_id`, `g_client_secret`, `jwplayer_code`, `level_one_rating`, `level_one_orders`, `level_two_rating`, `level_two_orders`, `level_top_rating`, `level_top_orders`, `approve_proposals`, `proposal_email`, `signup_email`, `relevant_requests`, `enable_referrals`, `knowledge_bank`, `referral_money`, `site_currency`, `enable_maintenance_mode`, `order_auto_complete`, `wish_do_manual_payouts`, `payouts_date`, `payouts_anyday`) VALUES
(2, 'GigToDo - Freelance MarketPlace Script', 0, 'GigToDo', 'gigtodoFav.ico', 'image', '', 'logo1.png', 'logo1.png', 'Start a very successful freelance marketplace business just as big as fiverr, with the GigToDo Script. Purchase Now!', 'freelancer, marketplace', 'Pixinal Studio', 'http://localhost/gigtodov4', 'admin-demo@pixinal.com', 'Â© 2019 Hiregens Pvt Ltd', 'Asia/Karachi', '', '6LcLeawUAAAAABC2pU7vox7ZY2mXmwMo0j2686jQ', '6LcLeawUAAAAABF08vTF1rfIyA9EM3I_FwPW9Jhj', 'no', '', '', '', '', 'https://cdn.jwplayer.com/libraries/I8emXAPx.js', 85, 10, 95, 25, 100, 50, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 1, '22', 'no', 2, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hide_seller_messages`
--

CREATE TABLE `hide_seller_messages` (
  `id` int(10) NOT NULL,
  `hider_id` int(10) NOT NULL,
  `hide_seller_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `home_cards`
--

CREATE TABLE `home_cards` (
  `card_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `card_title` text NOT NULL,
  `card_desc` text NOT NULL,
  `card_link` varchar(255) NOT NULL,
  `card_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_cards`
--

INSERT INTO `home_cards` (`card_id`, `language_id`, `card_title`, `card_desc`, `card_link`, `card_image`) VALUES
(1, 1, 'Logo Design', 'Build Your Brand', 'https://www.gigtodo.com/categories/graphics-design/logo-design', '1 (3).jpg'),
(2, 1, 'Social Media', 'Reach More Customers', 'https://www.gigtodo.com/categories/digital-marketing/social-media-marketing', '2.jpg'),
(3, 1, 'Voice Talent', 'The Perfect Voiceover', 'https://www.gigtodo.com/categories/video-animation', '7.jpg'),
(4, 1, 'Translation', 'Go Global.', 'https://www.gigtodo.com/categories/writing-translation/translation', '4.jpg'),
(5, 1, 'Illustration', 'Color Your Dreams', 'https://www.gigtodo.com/categories/graphics-design/illustration', '5.jpg'),
(6, 1, 'Photoshop Expert', 'Hire A Designer', 'https://www.gigtodo.com/categories/graphics-design/photoshop-editing', '6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `home_section`
--

CREATE TABLE `home_section` (
  `section_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `section_heading` text NOT NULL,
  `section_short_heading` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_section`
--

INSERT INTO `home_section` (`section_id`, `language_id`, `section_heading`, `section_short_heading`) VALUES
(1, 1, 'DON\'T JUST DREAM, DO.', 'Freelance Services. On Demand.');

-- --------------------------------------------------------

--
-- Table structure for table `home_section_slider`
--

CREATE TABLE `home_section_slider` (
  `slide_id` int(100) NOT NULL,
  `slide_name` varchar(255) NOT NULL,
  `slide_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_section_slider`
--

INSERT INTO `home_section_slider` (`slide_id`, `slide_name`, `slide_image`) VALUES
(1, 'Slide 1', '1.png'),
(2, 'Slide 2', '2.jpg'),
(4, 'Slide 3', '3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inbox_messages`
--

CREATE TABLE `inbox_messages` (
  `message_id` int(10) NOT NULL,
  `message_group_id` int(10) NOT NULL,
  `message_sender` int(10) NOT NULL,
  `message_receiver` int(10) NOT NULL,
  `message_offer_id` int(10) NOT NULL,
  `message_desc` text NOT NULL,
  `message_file` text NOT NULL,
  `message_date` text NOT NULL,
  `dateAgo` text NOT NULL,
  `bell` varchar(255) NOT NULL,
  `message_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inbox_sellers`
--

CREATE TABLE `inbox_sellers` (
  `inbox_seller_id` int(10) NOT NULL,
  `message_group_id` int(10) NOT NULL,
  `message_id` int(10) NOT NULL,
  `offer_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `message_status` text NOT NULL,
  `popup` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_bank`
--

CREATE TABLE `knowledge_bank` (
  `article_id` int(11) NOT NULL,
  `language_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `article_url` varchar(255) NOT NULL,
  `article_heading` varchar(255) NOT NULL,
  `article_body` text NOT NULL,
  `right_image` varchar(255) NOT NULL,
  `top_image` varchar(255) NOT NULL,
  `bottom_image` varchar(255) NOT NULL,
  `article_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) NOT NULL,
  `title` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `default_lang` int(10) NOT NULL,
  `direction` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `title`, `image`, `default_lang`, `direction`) VALUES
(1, 'English', 'english.png', 1, 'left');

-- --------------------------------------------------------

--
-- Table structure for table `languages_relation`
--

CREATE TABLE `languages_relation` (
  `relation_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `language_id` int(11) NOT NULL,
  `language_level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages_offers`
--

CREATE TABLE `messages_offers` (
  `offer_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `delivery_time` text NOT NULL,
  `amount` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `my_buyers`
--

CREATE TABLE `my_buyers` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `completed_orders` int(10) NOT NULL,
  `amount_spent` int(10) NOT NULL,
  `last_order_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `my_sellers`
--

CREATE TABLE `my_sellers` (
  `id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `completed_orders` int(10) NOT NULL,
  `amount_spent` int(10) NOT NULL,
  `last_order_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `sender_id` text NOT NULL,
  `order_id` int(10) NOT NULL,
  `reason` text NOT NULL,
  `date` text NOT NULL,
  `bell` varchar(255) NOT NULL DEFAULT 'active',
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `order_number` text NOT NULL,
  `order_duration` text NOT NULL,
  `order_time` text NOT NULL,
  `order_date` text NOT NULL,
  `order_description` text NOT NULL,
  `seller_id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `order_price` varchar(255) NOT NULL DEFAULT '0',
  `order_qty` int(10) NOT NULL,
  `order_fee` varchar(255) NOT NULL DEFAULT '0',
  `order_active` text NOT NULL,
  `complete_time` text NOT NULL,
  `order_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_conversations`
--

CREATE TABLE `order_conversations` (
  `c_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_extras`
--

CREATE TABLE `order_extras` (
  `id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package_attributes`
--

CREATE TABLE `package_attributes` (
  `attribute_id` int(100) NOT NULL,
  `proposal_id` int(100) NOT NULL,
  `package_id` int(100) NOT NULL,
  `attribute_name` text NOT NULL,
  `attribute_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(10) NOT NULL,
  `comission_percentage` int(10) NOT NULL,
  `days_before_withdraw` int(10) NOT NULL,
  `withdrawal_limit` int(10) NOT NULL,
  `featured_fee` int(10) NOT NULL,
  `featured_duration` int(10) NOT NULL,
  `featured_proposal_while_creating` int(10) NOT NULL,
  `processing_feeType` varchar(100) NOT NULL,
  `processing_fee` int(10) NOT NULL,
  `enable_paypal` text NOT NULL,
  `paypal_email` text NOT NULL,
  `paypal_currency_code` text NOT NULL,
  `paypal_app_client_id` text NOT NULL,
  `paypal_app_client_secret` text NOT NULL,
  `paypal_sandbox` text NOT NULL,
  `enable_payoneer` int(10) NOT NULL,
  `enable_stripe` text NOT NULL,
  `stripe_secret_key` text NOT NULL,
  `stripe_publishable_key` text NOT NULL,
  `stripe_currency_code` text NOT NULL,
  `enable_dusupay` text NOT NULL,
  `dusupay_sandbox` text NOT NULL,
  `dusupay_currency_code` text NOT NULL,
  `dusupay_api_key` text NOT NULL,
  `dusupay_secret_key` text NOT NULL,
  `enable_payza` varchar(255) NOT NULL,
  `payza_email` varchar(255) NOT NULL,
  `payza_currency_code` varchar(255) NOT NULL,
  `payza_test` varchar(255) NOT NULL,
  `enable_coinpayments` varchar(255) NOT NULL,
  `coinpayments_merchant_id` text NOT NULL,
  `coinpayments_currency_code` varchar(255) NOT NULL,
  `coinpayments_withdrawal_fee` text NOT NULL,
  `coinpayments_public_key` text NOT NULL,
  `coinpayments_private_key` text NOT NULL,
  `enable_paystack` varchar(255) NOT NULL,
  `paystack_public_key` varchar(255) NOT NULL,
  `paystack_secret_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `comission_percentage`, `days_before_withdraw`, `withdrawal_limit`, `featured_fee`, `featured_duration`, `featured_proposal_while_creating`, `processing_feeType`, `processing_fee`, `enable_paypal`, `paypal_email`, `paypal_currency_code`, `paypal_app_client_id`, `paypal_app_client_secret`, `paypal_sandbox`, `enable_payoneer`, `enable_stripe`, `stripe_secret_key`, `stripe_publishable_key`, `stripe_currency_code`, `enable_dusupay`, `dusupay_sandbox`, `dusupay_currency_code`, `dusupay_api_key`, `dusupay_secret_key`, `enable_payza`, `payza_email`, `payza_currency_code`, `payza_test`, `enable_coinpayments`, `coinpayments_merchant_id`, `coinpayments_currency_code`, `coinpayments_withdrawal_fee`, `coinpayments_public_key`, `coinpayments_private_key`, `enable_paystack`, `paystack_public_key`, `paystack_secret_key`) VALUES
(1, 12, 1, 5, 10, 1, 1, 'fixed', 2, 'no', '', '', '', '', 'on', 1, 'no', '', '', '', 'no', 'on', '', '', '', 'no', '', 'USD', 'off', 'no', '', '', 'sender', '', '', 'no', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(255) NOT NULL,
  `seller_id` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `proposal_id` int(10) NOT NULL,
  `proposal_title` text NOT NULL,
  `proposal_url` text NOT NULL,
  `proposal_cat_id` int(10) NOT NULL,
  `proposal_child_id` int(10) NOT NULL,
  `proposal_price` int(10) NOT NULL,
  `proposal_img1` text NOT NULL,
  `proposal_img2` text NOT NULL,
  `proposal_img3` text NOT NULL,
  `proposal_img4` text NOT NULL,
  `proposal_video` text NOT NULL,
  `proposal_desc` text NOT NULL,
  `buyer_instruction` text NOT NULL,
  `proposal_tags` text NOT NULL,
  `proposal_enable_referrals` varchar(255) NOT NULL,
  `proposal_referral_money` int(10) NOT NULL,
  `proposal_referral_code` varchar(255) NOT NULL,
  `proposal_featured` text NOT NULL,
  `proposal_toprated` text NOT NULL,
  `proposal_seller_id` int(10) NOT NULL,
  `delivery_id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `proposal_rating` int(11) NOT NULL,
  `proposal_views` int(10) NOT NULL,
  `proposal_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposals_extras`
--

CREATE TABLE `proposals_extras` (
  `id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposals_faq`
--

CREATE TABLE `proposals_faq` (
  `id` int(10) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_modifications`
--

CREATE TABLE `proposal_modifications` (
  `modification_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `modification_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_packages`
--

CREATE TABLE `proposal_packages` (
  `package_id` int(100) NOT NULL,
  `proposal_id` int(100) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `revisions` varchar(255) NOT NULL,
  `delivery_time` varchar(255) NOT NULL,
  `price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_referrals`
--

CREATE TABLE `proposal_referrals` (
  `referral_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `order_id` int(100) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `referrer_id` int(10) NOT NULL,
  `buyer_id` varchar(255) NOT NULL,
  `comission` varchar(10) NOT NULL,
  `date` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `date` text NOT NULL,
  `method` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recent_proposals`
--

CREATE TABLE `recent_proposals` (
  `recent_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `referral_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `referred_id` int(10) NOT NULL,
  `comission` int(10) NOT NULL,
  `date` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) NOT NULL,
  `reporter_id` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `additional_information` text NOT NULL,
  `date` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `revenues`
--

CREATE TABLE `revenues` (
  `revenue_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `date` text NOT NULL,
  `end_date` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `work_id` int(10) NOT NULL,
  `payment_method` text NOT NULL,
  `amount` decimal(10,1) NOT NULL,
  `profit` decimal(10,1) NOT NULL,
  `processing_fee` decimal(10,1) NOT NULL,
  `action` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section_boxes`
--

CREATE TABLE `section_boxes` (
  `box_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `box_title` text NOT NULL,
  `box_desc` text NOT NULL,
  `box_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_boxes`
--

INSERT INTO `section_boxes` (`box_id`, `language_id`, `box_title`, `box_desc`, `box_image`) VALUES
(4, 1, 'Your Terms', 'Whatever you need to simplify your to do list, no&lt;br&gt; matter your budget.\r\n', 'time.png'),
(5, 1, 'Your Timeline', 'Find services based on your goals and deadlines,&lt;br&gt; its that simple.', 'desk.png'),
(6, 1, 'Your Safety', 'Your payment is always secure, GigToDo is built to protect your peace of mind.', 'tv.png');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(10) NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `seller_user_name` varchar(255) NOT NULL,
  `seller_email` text NOT NULL,
  `seller_wallet` text NOT NULL,
  `seller_payouts` int(100) NOT NULL,
  `seller_paypal_email` text NOT NULL,
  `seller_payoneer_email` text NOT NULL,
  `seller_m_account_number` bigint(100) NOT NULL,
  `seller_m_account_name` text NOT NULL,
  `seller_pass` text NOT NULL,
  `seller_image` text NOT NULL,
  `seller_cover_image` text NOT NULL,
  `seller_country` text NOT NULL,
  `seller_headline` text NOT NULL,
  `seller_about` text NOT NULL,
  `seller_level` int(10) NOT NULL,
  `seller_language` int(10) NOT NULL,
  `seller_recent_delivery` text NOT NULL,
  `seller_rating` int(10) NOT NULL,
  `seller_offers` int(10) NOT NULL,
  `seller_referral` int(10) NOT NULL,
  `seller_ip` varchar(255) NOT NULL,
  `seller_verification` text NOT NULL,
  `seller_vacation` text NOT NULL,
  `seller_vacation_reason` text NOT NULL,
  `seller_vacation_message` text NOT NULL,
  `seller_register_date` text NOT NULL,
  `enable_sound` varchar(255) NOT NULL DEFAULT 'yes',
  `seller_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller_accounts`
--

CREATE TABLE `seller_accounts` (
  `account_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `withdrawn` int(255) NOT NULL DEFAULT '0',
  `current_balance` int(255) NOT NULL DEFAULT '0',
  `used_purchases` int(255) NOT NULL DEFAULT '0',
  `pending_clearance` int(255) NOT NULL DEFAULT '0',
  `month_earnings` int(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller_languages`
--

CREATE TABLE `seller_languages` (
  `language_id` int(10) NOT NULL,
  `language_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller_levels`
--

CREATE TABLE `seller_levels` (
  `level_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller_levels`
--

INSERT INTO `seller_levels` (`level_id`) VALUES
(1),
(2),
(3),
(4);

-- --------------------------------------------------------

--
-- Table structure for table `seller_levels_meta`
--

CREATE TABLE `seller_levels_meta` (
  `id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller_levels_meta`
--

INSERT INTO `seller_levels_meta` (`id`, `language_id`, `level_id`, `title`) VALUES
(1, 1, 1, 'New Seller'),
(2, 1, 2, 'Level One'),
(3, 1, 3, 'Level Two'),
(4, 1, 4, 'Top Rated A');

-- --------------------------------------------------------

--
-- Table structure for table `seller_payment_settings`
--

CREATE TABLE `seller_payment_settings` (
  `id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  `commission_percentage` int(10) NOT NULL,
  `payout_day` int(100) NOT NULL,
  `payout_time` varchar(255) NOT NULL,
  `payout_anyday` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller_payment_settings`
--

INSERT INTO `seller_payment_settings` (`id`, `level_id`, `commission_percentage`, `payout_day`, `payout_time`, `payout_anyday`) VALUES
(1, 1, 20, 26, '15:00', 0),
(2, 2, 15, 20, '01:00', 0),
(3, 3, 10, 15, '01:00', 0),
(4, 4, 5, 1, '03:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seller_reviews`
--

CREATE TABLE `seller_reviews` (
  `review_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `review_seller_id` int(10) NOT NULL,
  `seller_rating` int(10) NOT NULL,
  `seller_review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller_skills`
--

CREATE TABLE `seller_skills` (
  `skill_id` int(10) NOT NULL,
  `skill_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller_type_status`
--

CREATE TABLE `seller_type_status` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `message_group_id` text NOT NULL,
  `status` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `send_offers`
--

CREATE TABLE `send_offers` (
  `offer_id` int(10) NOT NULL,
  `request_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `delivery_time` text NOT NULL,
  `amount` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `skills_relation`
--

CREATE TABLE `skills_relation` (
  `relation_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `skill_id` int(10) NOT NULL,
  `skill_level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slide_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `slide_name` text NOT NULL,
  `slide_desc` text NOT NULL,
  `slide_image` text NOT NULL,
  `slide_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slide_id`, `language_id`, `slide_name`, `slide_desc`, `slide_image`, `slide_url`) VALUES
(27, 1, '', '', 'cover-boy.png', 'https://www.pixinal.com'),
(32, 1, '', '', 'art-artist-canvas-374054.jpg', 'https://www.pixinal.com'),
(33, 1, '', '', 'art-dark-ethnic-1038041.jpg', 'https://www.gigtodo.com');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(10) NOT NULL,
  `enable_smtp` varchar(255) NOT NULL,
  `host` text NOT NULL,
  `port` text NOT NULL,
  `secure` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `enable_smtp`, `host`, `port`, `secure`, `username`, `password`) VALUES
(1, 'yes', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `spam_words`
--

CREATE TABLE `spam_words` (
  `id` int(10) NOT NULL,
  `word` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spam_words`
--

INSERT INTO `spam_words` (`id`, `word`) VALUES
(1, 'PayPal'),
(2, 'payoneer'),
(3, 'pay'),
(4, 'mobile'),
(5, 'contact'),
(6, 'email'),
(7, 'skype'),
(8, 'number'),
(9, '.com'),
(10, 'direct'),
(12, 'Pay'),
(13, 'Poop'),
(15, 'bad word'),
(16, 'siva'),
(17, 'Machi'),
(18, 'city'),
(19, 'facebook');

-- --------------------------------------------------------

--
-- Table structure for table `starred_messages`
--

CREATE TABLE `starred_messages` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `message_group_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ticket_id` int(10) NOT NULL,
  `enquiry_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `order_number` text NOT NULL,
  `order_rule` text NOT NULL,
  `attachment` text NOT NULL,
  `date` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `term_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `term_title` text NOT NULL,
  `term_link` text NOT NULL,
  `term_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `top_proposals`
--

CREATE TABLE `top_proposals` (
  `id` int(10) NOT NULL,
  `proposal_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unread_messages`
--

CREATE TABLE `unread_messages` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `message_group_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `method` text NOT NULL,
  `amount` int(10) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_info`
--
ALTER TABLE `app_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_messages`
--
ALTER TABLE `archived_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_cat`
--
ALTER TABLE `article_cat`
  ADD PRIMARY KEY (`article_cat_id`);

--
-- Indexes for table `buyer_requests`
--
ALTER TABLE `buyer_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `buyer_reviews`
--
ALTER TABLE `buyer_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `categories_children`
--
ALTER TABLE `categories_children`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `cats_meta`
--
ALTER TABLE `cats_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child_cats_meta`
--
ALTER TABLE `child_cats_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_support`
--
ALTER TABLE `contact_support`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `contact_support_meta`
--
ALTER TABLE `contact_support_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `coupons_used`
--
ALTER TABLE `coupons_used`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_times`
--
ALTER TABLE `delivery_times`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favourite_id`);

--
-- Indexes for table `featured_proposals`
--
ALTER TABLE `featured_proposals`
  ADD PRIMARY KEY (`featured_id`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hide_seller_messages`
--
ALTER TABLE `hide_seller_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_cards`
--
ALTER TABLE `home_cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `home_section`
--
ALTER TABLE `home_section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `home_section_slider`
--
ALTER TABLE `home_section_slider`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `inbox_messages`
--
ALTER TABLE `inbox_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `inbox_sellers`
--
ALTER TABLE `inbox_sellers`
  ADD PRIMARY KEY (`inbox_seller_id`);

--
-- Indexes for table `knowledge_bank`
--
ALTER TABLE `knowledge_bank`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages_relation`
--
ALTER TABLE `languages_relation`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `messages_offers`
--
ALTER TABLE `messages_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `my_buyers`
--
ALTER TABLE `my_buyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_sellers`
--
ALTER TABLE `my_sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_conversations`
--
ALTER TABLE `order_conversations`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `order_extras`
--
ALTER TABLE `order_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_attributes`
--
ALTER TABLE `package_attributes`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`proposal_id`);

--
-- Indexes for table `proposals_extras`
--
ALTER TABLE `proposals_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposals_faq`
--
ALTER TABLE `proposals_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposal_modifications`
--
ALTER TABLE `proposal_modifications`
  ADD PRIMARY KEY (`modification_id`);

--
-- Indexes for table `proposal_packages`
--
ALTER TABLE `proposal_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `proposal_referrals`
--
ALTER TABLE `proposal_referrals`
  ADD PRIMARY KEY (`referral_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `recent_proposals`
--
ALTER TABLE `recent_proposals`
  ADD PRIMARY KEY (`recent_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`referral_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revenues`
--
ALTER TABLE `revenues`
  ADD PRIMARY KEY (`revenue_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_boxes`
--
ALTER TABLE `section_boxes`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `seller_accounts`
--
ALTER TABLE `seller_accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `seller_languages`
--
ALTER TABLE `seller_languages`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `seller_levels`
--
ALTER TABLE `seller_levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `seller_levels_meta`
--
ALTER TABLE `seller_levels_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_payment_settings`
--
ALTER TABLE `seller_payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_reviews`
--
ALTER TABLE `seller_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `seller_skills`
--
ALTER TABLE `seller_skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `seller_type_status`
--
ALTER TABLE `seller_type_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_offers`
--
ALTER TABLE `send_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `skills_relation`
--
ALTER TABLE `skills_relation`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spam_words`
--
ALTER TABLE `spam_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `starred_messages`
--
ALTER TABLE `starred_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `top_proposals`
--
ALTER TABLE `top_proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_info`
--
ALTER TABLE `app_info`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `archived_messages`
--
ALTER TABLE `archived_messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_cat`
--
ALTER TABLE `article_cat`
  MODIFY `article_cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyer_requests`
--
ALTER TABLE `buyer_requests`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyer_reviews`
--
ALTER TABLE `buyer_reviews`
  MODIFY `review_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories_children`
--
ALTER TABLE `categories_children`
  MODIFY `child_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `cats_meta`
--
ALTER TABLE `cats_meta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=808;

--
-- AUTO_INCREMENT for table `child_cats_meta`
--
ALTER TABLE `child_cats_meta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6825;

--
-- AUTO_INCREMENT for table `contact_support`
--
ALTER TABLE `contact_support`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_support_meta`
--
ALTER TABLE `contact_support_meta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons_used`
--
ALTER TABLE `coupons_used`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `delivery_times`
--
ALTER TABLE `delivery_times`
  MODIFY `delivery_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  MODIFY `enquiry_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favourite_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `featured_proposals`
--
ALTER TABLE `featured_proposals`
  MODIFY `featured_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `link_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hide_seller_messages`
--
ALTER TABLE `hide_seller_messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_cards`
--
ALTER TABLE `home_cards`
  MODIFY `card_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `home_section`
--
ALTER TABLE `home_section`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `home_section_slider`
--
ALTER TABLE `home_section_slider`
  MODIFY `slide_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inbox_messages`
--
ALTER TABLE `inbox_messages`
  MODIFY `message_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox_sellers`
--
ALTER TABLE `inbox_sellers`
  MODIFY `inbox_seller_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_bank`
--
ALTER TABLE `knowledge_bank`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages_relation`
--
ALTER TABLE `languages_relation`
  MODIFY `relation_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages_offers`
--
ALTER TABLE `messages_offers`
  MODIFY `offer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_buyers`
--
ALTER TABLE `my_buyers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_sellers`
--
ALTER TABLE `my_sellers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_conversations`
--
ALTER TABLE `order_conversations`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_extras`
--
ALTER TABLE `order_extras`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_attributes`
--
ALTER TABLE `package_attributes`
  MODIFY `attribute_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `proposal_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals_extras`
--
ALTER TABLE `proposals_extras`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals_faq`
--
ALTER TABLE `proposals_faq`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_modifications`
--
ALTER TABLE `proposal_modifications`
  MODIFY `modification_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_packages`
--
ALTER TABLE `proposal_packages`
  MODIFY `package_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_referrals`
--
ALTER TABLE `proposal_referrals`
  MODIFY `referral_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recent_proposals`
--
ALTER TABLE `recent_proposals`
  MODIFY `recent_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `referral_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revenues`
--
ALTER TABLE `revenues`
  MODIFY `revenue_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_boxes`
--
ALTER TABLE `section_boxes`
  MODIFY `box_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `seller_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_accounts`
--
ALTER TABLE `seller_accounts`
  MODIFY `account_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_languages`
--
ALTER TABLE `seller_languages`
  MODIFY `language_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_levels`
--
ALTER TABLE `seller_levels`
  MODIFY `level_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller_levels_meta`
--
ALTER TABLE `seller_levels_meta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller_payment_settings`
--
ALTER TABLE `seller_payment_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller_reviews`
--
ALTER TABLE `seller_reviews`
  MODIFY `review_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_skills`
--
ALTER TABLE `seller_skills`
  MODIFY `skill_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_type_status`
--
ALTER TABLE `seller_type_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `send_offers`
--
ALTER TABLE `send_offers`
  MODIFY `offer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills_relation`
--
ALTER TABLE `skills_relation`
  MODIFY `relation_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slide_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spam_words`
--
ALTER TABLE `spam_words`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `starred_messages`
--
ALTER TABLE `starred_messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `term_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `top_proposals`
--
ALTER TABLE `top_proposals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unread_messages`
--
ALTER TABLE `unread_messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
