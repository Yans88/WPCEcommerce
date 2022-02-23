-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 24, 2022 at 05:58 AM
-- Server version: 5.6.51
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idijakba_wpc_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `operator_id` int(24) NOT NULL,
  `id_merchant` int(11) DEFAULT NULL,
  `id_sls` int(11) DEFAULT NULL,
  `fullname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `create_date` date NOT NULL,
  `create_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`operator_id`, `id_merchant`, `id_sls`, `fullname`, `username`, `password`, `email`, `level`, `status`, `deleted_at`, `modified_on`, `modified_by`, `create_date`, `create_user`) VALUES
(1, NULL, NULL, 'admin1', 'virecGxFySbPWafL1ipI9SjFm_arn-wFHyNwMoIeaUs', 'l3LyOW_QyXbXryvNu3K6MnsL2scaPcCRVrHnoBuPaM8', 'admin@mail.com', 1, '1', NULL, '2022-02-23 22:57:55', NULL, '2022-02-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `alamat_pengiriman`
--

CREATE TABLE `alamat_pengiriman` (
  `id_address` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_city` int(11) NOT NULL,
  `kode_pos` varchar(6) NOT NULL,
  `alamat` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `nama_penerima` varchar(64) NOT NULL,
  `nama_alamat` varchar(64) NOT NULL,
  `utama` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nama_area` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id_banner` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blast_notif`
--

CREATE TABLE `blast_notif` (
  `id_notif` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(11) NOT NULL,
  `nama_brand` varchar(255) NOT NULL,
  `ocrcode_b` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_admin`
--

CREATE TABLE `chat_admin` (
  `id_chat` int(24) NOT NULL,
  `id_member` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id_city` int(11) NOT NULL,
  `id_provinsi` int(11) DEFAULT NULL,
  `kode_city` varchar(5) DEFAULT NULL,
  `nama_city` varchar(64) NOT NULL,
  `ocrcode_c` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_notif`
--

CREATE TABLE `history_notif` (
  `id_member` int(11) NOT NULL,
  `id_bn` int(11) DEFAULT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `fcm_token` text,
  `type` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_product`
--

CREATE TABLE `history_product` (
  `id` int(24) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_merchant` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `nama_barang` varchar(64) NOT NULL,
  `img` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `harga` varchar(32) NOT NULL DEFAULT '0',
  `diskon` varchar(11) DEFAULT '0',
  `deskripsi` text,
  `paket` int(11) NOT NULL DEFAULT '0',
  `penjualan` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pot_tier` int(11) DEFAULT '0',
  `cnt` int(11) DEFAULT '0',
  `ket` text,
  `type` int(11) DEFAULT '0',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(11) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_tier`
--

CREATE TABLE `history_tier` (
  `id` int(24) NOT NULL,
  `id_tier` int(11) NOT NULL,
  `nama_tier` varchar(255) NOT NULL,
  `diskon` varchar(11) NOT NULL DEFAULT '0',
  `ket` text,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_tier_member`
--

CREATE TABLE `history_tier_member` (
  `id` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_tier` int(11) DEFAULT '0',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `id_trans_auto`
--

CREATE TABLE `id_trans_auto` (
  `id_trans` int(11) NOT NULL,
  `completed_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `id_merchant` int(11) DEFAULT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level_name` varchar(32) NOT NULL,
  `principal` int(11) DEFAULT '0',
  `category` int(11) DEFAULT '0',
  `product` int(11) DEFAULT '0',
  `paket` int(11) DEFAULT '0',
  `members` int(11) DEFAULT '0',
  `chat` int(11) DEFAULT '0',
  `waiting_payment` int(11) DEFAULT '0',
  `payment_complete` int(11) DEFAULT '0',
  `dikirim` int(11) DEFAULT '0',
  `sampai_tujuan` int(11) DEFAULT '0',
  `complete` int(11) DEFAULT '0',
  `reject` int(11) DEFAULT '0',
  `tagihan` int(11) DEFAULT '0',
  `angsuran` int(11) DEFAULT '0',
  `reporting` int(11) DEFAULT '0',
  `master_bank` int(11) DEFAULT '0',
  `tempo_payment` int(11) DEFAULT '0',
  `banner` int(11) DEFAULT '0',
  `area` int(11) DEFAULT '0',
  `brand` int(11) DEFAULT '0',
  `tier` int(11) DEFAULT '0',
  `province` int(11) DEFAULT '0',
  `level_role` int(11) DEFAULT '0',
  `users` int(11) DEFAULT '0',
  `setting` int(11) DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level_name`, `principal`, `category`, `product`, `paket`, `members`, `chat`, `waiting_payment`, `payment_complete`, `dikirim`, `sampai_tujuan`, `complete`, `reject`, `tagihan`, `angsuran`, `reporting`, `master_bank`, `tempo_payment`, `banner`, `area`, `brand`, `tier`, `province`, `level_role`, `users`, `setting`, `created_by`, `created_at`, `update_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, '2018-10-23 00:00:00', '2019-12-16 20:13:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `list_diskon`
--

CREATE TABLE `list_diskon` (
  `id_diskon` int(64) NOT NULL,
  `id_product` int(11) NOT NULL,
  `diskon` varchar(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `list_member_diskon`
--

CREATE TABLE `list_member_diskon` (
  `id` int(64) NOT NULL,
  `id_diskon` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_bank`
--

CREATE TABLE `master_bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(64) NOT NULL,
  `no_rek` varchar(24) NOT NULL,
  `holder_name` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_chat`
--

CREATE TABLE `master_chat` (
  `id_chat` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `status_count` int(11) NOT NULL DEFAULT '0',
  `status_member` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_payment`
--

CREATE TABLE `master_payment` (
  `id_payment` int(11) NOT NULL,
  `nama_payment` varchar(255) NOT NULL,
  `admin_fee` varchar(32) DEFAULT '0',
  `type` int(11) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id_member` int(11) NOT NULL,
  `id_tier` int(11) DEFAULT '0',
  `gcm_token` text,
  `device` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `address` text,
  `phone` varchar(16) NOT NULL,
  `nama_toko` varchar(255) DEFAULT NULL,
  `photo` text,
  `photo_ktp` text,
  `photo_npwp` text,
  `referensi` varchar(32) DEFAULT NULL,
  `kd_cust` varchar(32) DEFAULT NULL,
  `sales_id` varchar(32) DEFAULT NULL,
  `limit_credit` varchar(32) DEFAULT '0',
  `use_credit` varchar(32) DEFAULT '0',
  `sisa_credit` varchar(32) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `status_by` int(11) DEFAULT NULL,
  `status_date` datetime DEFAULT NULL,
  `tgl_reg` datetime NOT NULL,
  `id_whs` int(11) DEFAULT NULL,
  `ocrcode_p` varchar(32) DEFAULT NULL,
  `ocrcode_c` varchar(32) DEFAULT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id_merchants` int(11) NOT NULL,
  `kd_cust` varchar(24) NOT NULL,
  `nama_merchants` varchar(255) NOT NULL,
  `email` varchar(32) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `photo` text,
  `saldo` varchar(64) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `date_create` datetime DEFAULT NULL,
  `message_id` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `user_id_from` varchar(100) DEFAULT NULL,
  `user_id_to` varchar(100) DEFAULT NULL,
  `dari` varchar(64) NOT NULL,
  `ke` varchar(64) NOT NULL,
  `content` text,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paket_detail`
--

CREATE TABLE `paket_detail` (
  `id_paket_detail` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `qty` int(11) DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `id_merchant` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `paket` int(11) NOT NULL DEFAULT '0',
  `nama_barang` varchar(64) NOT NULL,
  `img` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `harga` varchar(32) NOT NULL DEFAULT '0',
  `diskon` varchar(5) DEFAULT '0',
  `deskripsi` text,
  `penjualan` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pot_tier` int(11) DEFAULT '0',
  `cnt` int(11) DEFAULT '0',
  `create_at` date NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL,
  `kode_provinsi` varchar(15) DEFAULT NULL,
  `nama_provinsi` varchar(64) NOT NULL,
  `ocrcode_p` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recent_v`
--

CREATE TABLE `recent_v` (
  `id_member` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id_sales` int(11) NOT NULL,
  `nama_sales` varchar(64) DEFAULT NULL,
  `slp_code` varchar(32) NOT NULL,
  `password` text,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(64) NOT NULL,
  `setting_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setting_val` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `setting_key`, `setting_val`) VALUES
(1, 'email', ''),
(2, 'pass', ''),
(3, 'content_forgotPass', '<p>Hi,&nbsp;<strong>[#name#]</strong>,</p>\r\n\r\n<p>You have just reset your PesenAja password :</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;email &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;&nbsp;<strong>[#email#]</strong></p>\r\n\r\n<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>Password &nbsp;:&nbsp;<strong>[#new_pass#]</strong>&nbsp;</p>\r\n\r\n<p>Thanks.<br />\r\nBest Regards,</p>\r\n'),
(4, 'content_verifyReg', ''),
(5, 'subj_email_register', 'Register'),
(6, 'subj_email_forgot', 'Forgot Password'),
(7, 'term_condition', '<article class=\"view\" data-frame=\"view\" data-role=\"frame\" style=\"\">\r\n<div class=\"box\">\r\n<h1>Terms and conditions</h1>\r\n\r\n<p>These terms and conditions (&quot;Terms&quot;, &quot;Agreement&quot;) are an agreement between Mobile Application Developer (&quot;Mobile Application Developer&quot;, &quot;us&quot;, &quot;we&quot; or &quot;our&quot;) and you (&quot;User&quot;, &quot;you&quot; or &quot;your&quot;). This Agreement sets forth the general terms and conditions of your use of the PesenAja.com mobile application and any of its products or services (collectively, &quot;Mobile Application&quot; or &quot;Services&quot;).</p>\r\n\r\n<h2>Accounts and membership</h2>\r\n\r\n<p>You must be at least 18 years of age to use this Mobile Application. By using this Mobile Application and by agreeing to this Agreement you warrant and represent that you are at least 18 years of age. If you create an account in the Mobile Application, you are responsible for maintaining the security of your account and you are fully responsible for all activities that occur under the account and any other actions taken in connection with it. We may monitor and review new accounts before you may sign in and use our Services. Providing false contact information of any kind may result in the termination of your account. You must immediately notify us of any unauthorized uses of your account or any other breaches of security. We will not be liable for any acts or omissions by you, including any damages of any kind incurred as a result of such acts or omissions. We may suspend, disable, or delete your account (or any part thereof) if we determine that you have violated any provision of this Agreement or that your conduct or content would tend to damage our reputation and goodwill. If we delete your account for the foregoing reasons, you may not re-register for our Services. We may block your email address and Internet protocol address to prevent further registration.</p>\r\n\r\n<h2>Backups</h2>\r\n\r\n<p>We are not responsible for Content residing in the Mobile Application. In no event shall we be held liable for any loss of any Content. It is your sole responsibility to maintain appropriate backup of your Content. Notwithstanding the foregoing, on some occasions and in certain circumstances, with absolutely no obligation, we may be able to restore some or all of your data that has been deleted as of a certain date and time when we may have backed up data for our own purposes. We make no guarantee that the data you need will be available.</p>\r\n\r\n<h2>Links to other mobile applications</h2>\r\n\r\n<p>Although this Mobile Application may link to other mobile applications, we are not, directly or indirectly, implying any approval, association, sponsorship, endorsement, or affiliation with any linked mobile application, unless specifically stated herein. We are not responsible for examining or evaluating, and we do not warrant the offerings of, any businesses or individuals or the content of their mobile applications. We do not assume any responsibility or liability for the actions, products, services, and content of any other third-parties. You should carefully review the legal statements and other conditions of use of any mobile application which you access through a link from this Mobile Application. Your linking to any other off-site mobile applications is at your own risk.</p>\r\n\r\n<h2>Changes and amendments</h2>\r\n\r\n<p>We reserve the right to modify this Agreement or its policies relating to the Mobile Application or Services at any time, effective upon posting of an updated version of this Agreement in the Mobile Application. When we do, we will send you an email to notify you. Continued use of the Mobile Application after any such changes shall constitute your consent to such changes. Policy was created with <a href=\"https://www.websitepolicies.com/terms-and-conditions-generator\" style=\"color:inherit\" target=\"_blank\" title=\"Create terms and conditions\">WebsitePolicies</a>.</p>\r\n\r\n<h2>Acceptance of these terms</h2>\r\n\r\n<p>You acknowledge that you have read this Agreement and agree to all its terms and conditions. By using the Mobile Application or its Services you agree to be bound by this Agreement. If you do not agree to abide by the terms of this Agreement, you are not authorized to use or access the Mobile Application and its Services.</p>\r\n\r\n<h2>Contacting us</h2>\r\n\r\n<p>If you would like to contact us to understand more about this Agreement or wish to contact us concerning any matter relating to it, you may send an email to info@pesenaja.com</p>\r\n\r\n<p>This document was last updated on November 26, 2019</p>\r\n</div>\r\n</article>\r\n\r\n<p>&nbsp;</p>\r\n'),
(8, 'policy', '<h2>Privacy Policy</h2>\r\n\r\n<p>Pesenaja.com built the Pesenaja.com app as a Free app. This SERVICE is provided by Pesenaja.com at no cost and is intended for use as is.</p>\r\n\r\n<p>This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service.</p>\r\n\r\n<p>If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that we collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>\r\n\r\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at Pesenaja.com unless otherwise defined in this Privacy Policy.</p>\r\n\r\n<p><strong>Information Collection and Use</strong></p>\r\n\r\n<p>For a better experience, while using our Service, we may require you to provide us with certain personally identifiable information. The information that we request will be retained by us and used as described in this privacy policy.</p>\r\n\r\n<p>The app does use third party services that may collect information used to identify you.</p>\r\n\r\n<div>\r\n<p>Link to privacy policy of third party service providers used by the app</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://www.google.com/policies/privacy/\" target=\"_blank\">Google Play Services</a></li>\r\n</ul>\r\n</div>\r\n\r\n<p><strong>Log Data</strong></p>\r\n\r\n<p>We want to inform you that whenever you use our Service, in a case of an error in the app we collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing our Service, the time and date of your use of the Service, and other statistics.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your device&#39;s internal memory.</p>\r\n\r\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\r\n\r\n<p><strong>Service Providers</strong></p>\r\n\r\n<p>We may employ third-party companies and individuals due to the following reasons:</p>\r\n\r\n<ul>\r\n	<li>To facilitate our Service;</li>\r\n	<li>To provide the Service on our behalf;</li>\r\n	<li>To perform Service-related services; or</li>\r\n	<li>To assist us in analyzing how our Service is used.</li>\r\n</ul>\r\n\r\n<p>We want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\r\n\r\n<p><strong>Security</strong></p>\r\n\r\n<p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>\r\n\r\n<p><strong>Links to Other Sites</strong></p>\r\n\r\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\r\n\r\n<p><strong>Children&rsquo;s Privacy</strong></p>\r\n\r\n<p>These Services do not address anyone under the age of 13. We do not knowingly collect personally identifiable information from children under 13. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do necessary actions.</p>\r\n\r\n<p><strong>Changes to This Privacy Policy</strong></p>\r\n\r\n<p>We may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately after they are posted on this page.</p>\r\n\r\n<p><strong>Contact Us</strong></p>\r\n\r\n<p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us at info@pesenaja.com.</p>\r\n'),
(11, 'about_us', ''),
(12, 'address', ''),
(13, 'disc_payment', '0'),
(14, 'disc_va', '12.000');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_wh` int(11) NOT NULL,
  `stok` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_transaksi` int(11) DEFAULT NULL,
  `kode_payment` varchar(15) DEFAULT NULL,
  `id_member` int(11) NOT NULL,
  `id_principle` int(11) NOT NULL,
  `angs_ke` int(11) NOT NULL DEFAULT '0',
  `angsuran` varchar(64) NOT NULL,
  `tgl_tempo` date NOT NULL,
  `status` int(11) DEFAULT '0',
  `status_notif` int(11) DEFAULT '0',
  `status_date` date DEFAULT NULL,
  `status_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tier`
--

CREATE TABLE `tier` (
  `id_tier` int(11) NOT NULL,
  `nama_tier` varchar(255) NOT NULL,
  `diskon` varchar(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(24) NOT NULL,
  `kode_transaksi` varchar(64) DEFAULT NULL,
  `kode_payment` varchar(15) NOT NULL,
  `id_principle` int(11) NOT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `nama_principal` varchar(64) NOT NULL,
  `email_principle` varchar(64) DEFAULT NULL,
  `id_member` int(11) NOT NULL,
  `kd_cust` varchar(32) DEFAULT NULL,
  `id_whs` int(11) DEFAULT NULL,
  `id_sls` int(11) DEFAULT NULL,
  `sales_id` varchar(32) DEFAULT NULL,
  `nama_member` varchar(64) NOT NULL,
  `email_member` varchar(64) NOT NULL,
  `phone_member` varchar(15) DEFAULT NULL,
  `payment` int(11) NOT NULL DEFAULT '1',
  `payment_name` varchar(24) DEFAULT NULL,
  `id_tempo` int(11) DEFAULT NULL,
  `tempo` varchar(15) DEFAULT '0',
  `tempo_type` int(11) DEFAULT NULL,
  `tempo_fee` varchar(32) DEFAULT '0',
  `ttl_tempo_fee` varchar(15) DEFAULT '0',
  `tgl_jth_tempo` datetime DEFAULT NULL,
  `angs` varchar(64) DEFAULT '0',
  `sdh_byr` int(11) DEFAULT '0',
  `status_tempo` int(11) DEFAULT '0',
  `ttl_cart` varchar(64) DEFAULT '0',
  `ttl_bfr_disc` varchar(63) DEFAULT NULL,
  `ttl_all` varchar(64) DEFAULT '0',
  `id_address` int(11) DEFAULT NULL,
  `id_provinsi` int(11) DEFAULT NULL,
  `id_city` int(11) DEFAULT NULL,
  `nama_provinsi` varchar(64) DEFAULT NULL,
  `nama_city` varchar(64) DEFAULT NULL,
  `kode_pos` varchar(8) DEFAULT NULL,
  `alamat_penerima` text,
  `phone_penerima` varchar(15) DEFAULT NULL,
  `nama_penerima` varchar(255) DEFAULT NULL,
  `nama_alamat` varchar(64) DEFAULT NULL,
  `courier` int(11) DEFAULT NULL,
  `courier_service` int(11) DEFAULT '0',
  `ongkir` varchar(15) DEFAULT NULL,
  `id_tier` int(11) DEFAULT '0',
  `diskon` int(11) DEFAULT '0',
  `diskon_payment` int(11) DEFAULT NULL,
  `ttl_disc_payment` varchar(24) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `appr_rej_by` int(11) DEFAULT '0',
  `appr_rej_date` datetime DEFAULT NULL,
  `tXid` varchar(255) DEFAULT NULL,
  `cash_type` int(11) DEFAULT NULL,
  `request_url` text,
  `bank_code` varchar(32) DEFAULT NULL,
  `bank_name` varchar(64) DEFAULT NULL,
  `no_va` int(11) DEFAULT NULL,
  `valid_date` date DEFAULT NULL,
  `valid_time` time DEFAULT NULL,
  `status_pg` int(11) DEFAULT '-1',
  `status_name_pg` varchar(64) DEFAULT NULL,
  `date_pg` datetime DEFAULT NULL,
  `id_bank` int(11) DEFAULT '0',
  `nama_bank` varchar(64) DEFAULT NULL,
  `no_rek` varchar(64) DEFAULT NULL,
  `holder_name` varchar(64) DEFAULT NULL,
  `remark` text,
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_trans` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_principle` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `nama_barang` varchar(63) NOT NULL,
  `img` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  `sisa_stok` int(11) DEFAULT NULL,
  `harga` varchar(15) NOT NULL,
  `harga_asli` varchar(32) DEFAULT NULL,
  `diskon` varchar(11) DEFAULT '0',
  `diskon_product` varchar(11) DEFAULT '0',
  `jml` int(11) NOT NULL,
  `total` varchar(32) DEFAULT '0',
  `deskripsi` text,
  `nama_kategori` varchar(64) DEFAULT NULL,
  `nama_principal` varchar(64) DEFAULT NULL,
  `nama_brand` varchar(64) DEFAULT NULL,
  `nama_area` varchar(64) DEFAULT NULL,
  `note` text,
  `paket` int(11) DEFAULT '0',
  `id_whs` int(11) DEFAULT NULL,
  `nama_whs` varchar(255) DEFAULT NULL,
  `ocrcode_p` varchar(64) DEFAULT NULL,
  `ocrcode_c` varchar(64) DEFAULT NULL,
  `ocrcode_b` varchar(64) DEFAULT NULL,
  `id_sls` int(11) DEFAULT NULL,
  `sales_id` varchar(32) DEFAULT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_paket_detail`
--

CREATE TABLE `transaksi_paket_detail` (
  `id_trans` int(11) NOT NULL,
  `id_paket` int(11) DEFAULT '0',
  `id_product` int(11) NOT NULL,
  `nama_barang` varchar(63) NOT NULL,
  `img` varchar(255) NOT NULL,
  `jml` int(11) NOT NULL,
  `deskripsi` text,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id_whs` int(11) NOT NULL,
  `whs_code` varchar(24) NOT NULL,
  `nama_whs` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id_whs`, `whs_code`, `nama_whs`, `created_at`, `created_by`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(4, 'test1', '150', '2020-02-17 11:53:59', 1, NULL, '2020-02-17 04:54:10', '2020-02-17 11:54:10', 1),
(5, 'CFR5889', '200', '2020-02-17 11:54:39', 1, NULL, '2020-02-17 04:56:15', '2020-02-17 11:56:15', 1),
(6, '1123', 'test warehouse', '2020-02-17 11:58:31', 1, 1, '2020-03-23 06:11:48', '2020-03-23 13:11:48', 1),
(7, 'WHS0812', 'TestWhs', '2020-02-17 18:36:48', 1, NULL, '2020-03-23 06:11:56', '2020-03-23 13:11:56', 1),
(8, 'WH01', 'WH01', '2020-03-23 13:12:15', 1, NULL, '2020-03-23 06:12:15', NULL, NULL),
(9, 'WH02', 'WH02', '2020-03-23 13:12:42', 1, NULL, '2020-03-23 06:12:42', NULL, NULL),
(10, 'WH03', 'WH03', '2020-03-23 13:12:55', 1, NULL, '2020-03-23 06:12:55', NULL, NULL),
(11, 'WH04', 'WH04', '2020-03-23 13:13:16', 1, NULL, '2020-03-23 06:13:16', NULL, NULL),
(12, 'WH05', 'WH05', '2020-03-23 13:13:28', 1, NULL, '2020-03-23 06:13:28', NULL, NULL),
(13, 'WH06', 'WH06', '2020-03-23 13:13:38', 1, NULL, '2020-03-23 06:13:38', NULL, NULL),
(14, 'WH07', 'WH07', '2020-03-23 13:13:51', 1, NULL, '2020-03-23 06:13:51', NULL, NULL),
(15, 'WH08', 'WH08', '2020-03-23 13:14:04', 1, NULL, '2020-03-23 06:14:04', NULL, NULL),
(16, 'WH09', 'WH09', '2020-03-23 13:15:40', 1, NULL, '2020-03-23 06:15:40', NULL, NULL),
(17, 'WH10', 'WH10', '2020-03-23 13:15:51', 1, NULL, '2020-03-23 06:15:51', NULL, NULL),
(18, 'WH20', 'WH20', '2020-03-30 09:43:07', 1, NULL, '2020-03-30 02:43:07', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`operator_id`);

--
-- Indexes for table `alamat_pengiriman`
--
ALTER TABLE `alamat_pengiriman`
  ADD PRIMARY KEY (`id_address`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `blast_notif`
--
ALTER TABLE `blast_notif`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indexes for table `chat_admin`
--
ALTER TABLE `chat_admin`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`);

--
-- Indexes for table `history_product`
--
ALTER TABLE `history_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_tier`
--
ALTER TABLE `history_tier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_tier_member`
--
ALTER TABLE `history_tier_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_diskon`
--
ALTER TABLE `list_diskon`
  ADD PRIMARY KEY (`id_diskon`);

--
-- Indexes for table `list_member_diskon`
--
ALTER TABLE `list_member_diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_bank`
--
ALTER TABLE `master_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `master_chat`
--
ALTER TABLE `master_chat`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indexes for table `master_payment`
--
ALTER TABLE `master_payment`
  ADD PRIMARY KEY (`id_payment`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id_merchants`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `paket_detail`
--
ALTER TABLE `paket_detail`
  ADD PRIMARY KEY (`id_paket_detail`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id_sales`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indexes for table `tier`
--
ALTER TABLE `tier`
  ADD PRIMARY KEY (`id_tier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id_whs`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `operator_id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alamat_pengiriman`
--
ALTER TABLE `alamat_pengiriman`
  MODIFY `id_address` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blast_notif`
--
ALTER TABLE `blast_notif`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_admin`
--
ALTER TABLE `chat_admin`
  MODIFY `id_chat` int(24) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_product`
--
ALTER TABLE `history_product`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_tier`
--
ALTER TABLE `history_tier`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_tier_member`
--
ALTER TABLE `history_tier_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `list_diskon`
--
ALTER TABLE `list_diskon`
  MODIFY `id_diskon` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_member_diskon`
--
ALTER TABLE `list_member_diskon`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_bank`
--
ALTER TABLE `master_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_chat`
--
ALTER TABLE `master_chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_payment`
--
ALTER TABLE `master_payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id_merchants` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paket_detail`
--
ALTER TABLE `paket_detail`
  MODIFY `id_paket_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id_provinsi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id_sales` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tier`
--
ALTER TABLE `tier`
  MODIFY `id_tier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(24) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id_whs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
