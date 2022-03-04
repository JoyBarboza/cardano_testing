-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2021 at 07:19 AM
-- Server version: 5.7.34
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caesiuml_app`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetAllWithdraw` (IN `email` VARCHAR(100), IN `withdraw_from` DATETIME, IN `withdraw_to` DATETIME, IN `approve_from` DATETIME, IN `approve_to` DATETIME, IN `status` INT, IN `currency` INT)  NO SQL
SELECT 
	withdraws.*,currencies.name as coin_name,currencies.description as coin_description,
    users.email,
    users.first_name as full_name
    FROM withdraws
    INNER JOIN users ON users.id = withdraws.user_id
    INNER JOIN profiles ON users.id = profiles.user_id
    INNER JOIN currencies ON withdraws.currency_id = currencies.id
  WHERE
    ((email IS NULL) OR (users.email = email)) AND
    ((currency IS NULL) OR (withdraws.currency_id = currency))  
    AND
    ((withdraw_from IS NULL) OR (date(withdraws.created_at) >= withdraw_from)) AND
    ((withdraw_to IS NULL) OR (date(withdraws.created_at) <= withdraw_to)) AND
    ((approve_from IS NULL) OR (date(withdraws.updated_at) >= approve_from)) AND
    ((approve_to IS NULL) OR (date(withdraws.updated_at) <= approve_to)) AND
    ((status IS NULL) OR (withdraws.status = status)) 
ORDER by withdraws.created_at DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getFeeCollection` ()  NO SQL
SELECT DATE_FORMAT(t1.created_date,'%Y') as y ,DATE_FORMAT(t1.created_date,'%m')-1 as m ,DATE_FORMAT(t1.created_date,'%d') as d, coalesce(t2.fees,0) as fees FROM ( select * from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) created_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where created_date BETWEEN (NOW() - INTERVAL 30 DAY) AND NOW() ) as t1 LEFT JOIN ( SELECT date(operations.created_at) as created_date, sum(operations.fees) as fees FROM operations WHERE operations.status = 2 and operations.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY operations.created_at, fees )t2 on t2.created_date = t1.created_date group by t1.created_date, t2.fees ORDER BY t1.created_date DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getMyBalance` (IN `user_id` INT(10) UNSIGNED, IN `currency` VARCHAR(4))  NO SQL
SELECT (creditTotal - debitTotal) as balance  from (SELECT IFNULL(SUM(transactions.amount),0) as creditTotal FROM transactions    INNER JOIN currencies ON currencies.id = transactions.currency_id  WHERE  transactions.status = 1 AND  transactions.type = 'Credit' AND currencies.name = currency AND transactions.user_id = user_id) as credit,    (SELECT IFNULL(SUM(transactions.amount), 0) as debitTotal FROM transactions    INNER JOIN currencies ON currencies.id = transactions.currency_id  WHERE transactions.status = 1 AND   transactions.type = 'Debit' AND currencies.name = currency AND transactions.user_id = user_id) as debit$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getTransactionAmount` (IN `currency` VARCHAR(3))  NO SQL
SELECT DATE_FORMAT(t1.created_date,'%Y') as y ,DATE_FORMAT(t1.created_date,'%m')-1 as m ,DATE_FORMAT(t1.created_date,'%d') as d, coalesce(t2.buy, 0) as buy FROM ( select * from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) created_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where created_date BETWEEN (NOW() - INTERVAL 30 DAY) AND NOW() ) as t1 LEFT JOIN ( SELECT date(transactions.created_at) as created_date, currencies.name, sum(transactions.amount) as buy FROM `transactions` INNER JOIN currencies on currencies.id = transactions.currency_id WHERE transactions.type = 'Credit' AND currencies.name = currency GROUP BY date(transactions.created_at), currencies.id )t2 on t2.created_date = t1.created_date group by t1.created_date, t2.name, t2.buy ORDER BY t1.created_date DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BankDeposits`
--

CREATE TABLE `BankDeposits` (
  `id` int(11) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `reference_no` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `approved_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency_id` int(11) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci,
  `status` enum('approved','rejected','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `deposit_coin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit_address` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BankDeposits`
--

INSERT INTO `BankDeposits` (`id`, `uid`, `reference_no`, `amount`, `approved_amount`, `currency_id`, `remarks`, `status`, `description`, `deposit_coin`, `deposit_address`, `created_at`, `updated_at`) VALUES
(3, 24, 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 150.47, 150.47, 1, 'Mahendran Sivanesan', 'approved', NULL, NULL, NULL, '2021-05-13 09:53:00', '2021-05-13 10:46:16'),
(4, 39, 'Internal transfer 60628842422', 9.00, 9.00, 1, 'testing', 'approved', NULL, NULL, NULL, '2021-05-13 13:38:09', '2021-05-13 13:40:27'),
(5, 41, '60640576890', 50.00, 50.00, 1, 'Caesium purchase', 'approved', NULL, NULL, NULL, '2021-05-13 13:46:59', '2021-05-13 13:47:34'),
(6, 39, '60640678379', 4801.00, 4801.00, 1, 'Sent 4801 , pls let me know ASAP. Thanks', 'approved', NULL, NULL, NULL, '2021-05-13 13:47:43', '2021-05-13 13:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('FLAT','PERCENT') COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `currency_id`, `name`, `display_name`, `description`, `type`, `amount`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(2, 1, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(3, 1, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(4, 2, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(5, 2, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(6, 2, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(7, 3, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(8, 3, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(9, 3, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(10, 4, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(11, 4, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(12, 4, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(13, 5, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(14, 5, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(15, 5, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(16, 6, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(17, 6, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(18, 6, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(19, 7, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(20, 7, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(21, 7, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(22, 8, 'SITEFEE', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(23, 8, 'TAX', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43'),
(24, 8, 'OTHERS', NULL, NULL, 'PERCENT', 0.00, NULL, '2018-01-30 06:59:43', '2018-01-30 06:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `coin_addresses`
--

CREATE TABLE `coin_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `coin_id` int(11) NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `flag_icon` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `calling_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `nationality`, `flag_icon`, `calling_code`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', 'Afghan', 'af.png', '+93', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(2, 'AL', 'Albania', 'Albanian', 'al.png', '+355', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(3, 'DZ', 'Algeria', 'Algerian', 'dz.png', '+213', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(4, 'AD', 'Andorra', 'Andorran', 'ad.png', '+376', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(5, 'AO', 'Angola', 'Angolan', 'ao.png', '+244', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(6, 'AG', 'Antigua and Barbuda', 'Antiguans, Barbudans', 'ag.png', '+1268', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(7, 'AR', 'Argentina', 'Argentinean', 'ar.png', '+54', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(8, 'AM', 'Armenia', 'Armenian', 'am.png', '+374', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(9, 'AU', 'Australia', 'Australian', 'au.png', '+61', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(10, 'AT', 'Austria', 'Austrian', 'at.png', '+43', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(11, 'AZ', 'Azerbaijan', 'Azerbaijani', 'az.png', '+994', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(12, 'BH', 'Bahrain', 'Bahraini', 'bh.png', '+973', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(13, 'BD', 'Bangladesh', 'Bangladeshi', 'bd.png', '+880', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(14, 'BB', 'Barbados', 'Barbadian', 'bb.png', '+1246', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(15, 'BY', 'Belarus', 'Belarusian', 'by.png', '+375', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(16, 'BE', 'Belgium', 'Belgian', 'be.png', '+32', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(17, 'BZ', 'Belize', 'Belizean', 'bz.png', '+501', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(18, 'BJ', 'Benin', 'Beninese', 'bj.png', '+229', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(19, 'BT', 'Bhutan', 'Bhutanese', 'bt.png', '+975', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(20, 'BA', 'Bosnia and Herzegovina', 'Bosnian, Herzegovinian', 'ba.png', '+387', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(21, 'BW', 'Botswana', 'Motswana (singular), Batswana (plural)', 'bw.png', '+267', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(22, 'BR', 'Brazil', 'Brazilian', 'br.png', '+55', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(23, 'BG', 'Bulgaria', 'Bulgarian', 'bg.png', '+359', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(24, 'BF', 'Burkina Faso', 'Burkinabe', 'bf.png', '+226', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(25, 'BI', 'Burundi', 'Burundian', 'bi.png', '+257', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(26, 'KH', 'Cambodia', 'Cambodian', 'kh.png', '+855', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(27, 'CM', 'Cameroon', 'Cameroonian', 'cm.png', '+237', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(28, 'CA', 'Canada', 'Canadian', 'ca.png', '+1', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(29, 'CV', 'Cape Verde', 'Cape Verdian', 'cv.png', '+238', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(30, 'CF', 'Central African Republic', 'Central African', 'cf.png', '+236', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(31, 'TD', 'Chad', 'Chadian', 'td.png', '+235', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(32, 'CL', 'Chile', 'Chilean', 'cl.png', '+56', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(33, 'CN', 'China', 'Chinese', 'cn.png', '+86', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(34, 'CO', 'Colombia', 'Colombian', 'co.png', '+57', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(35, 'KM', 'Comoros', 'Comoran', 'km.png', '+269', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(36, 'CR', 'Costa Rica', 'Costa Rican', 'cr.png', '+506', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(37, 'HR', 'Croatia', 'Croatian', 'hr.png', '+385', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(38, 'CU', 'Cuba', 'Cuban', 'cu.png', '+53', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(39, 'CY', 'Cyprus', 'Cypriot', 'cy.png', '+357', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(40, 'CZ', 'Czech Republic', 'Czech', 'cz.png', '+420', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(41, 'DK', 'Denmark', 'Danish', 'dk.png', '+45', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(42, 'DJ', 'Djibouti', 'Djibouti', 'dj.png', '+253', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(43, 'DM', 'Dominica', 'Dominican', 'dm.png', '+1767', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(44, 'DO', 'Dominican Republic', 'Dominican', 'do.png', '+1809', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(45, 'EC', 'Ecuador', 'Ecuadorean', 'ec.png', '+593', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(46, 'EG', 'Egypt', 'Egyptian', 'eg.png', '+20', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(47, 'SV', 'El Salvador', 'Salvadoran', 'sv.png', '+503', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(48, 'GQ', 'Equatorial Guinea', 'Equatorial Guinean', 'gq.png', '+240', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(49, 'ER', 'Eritrea', 'Eritrean', 'er.png', '+291', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(50, 'EE', 'Estonia', 'Estonian', 'ee.png', '+372', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(51, 'ET', 'Ethiopia', 'Ethiopian', 'et.png', '+251', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(52, 'FJ', 'Fiji', 'Fijian', 'fj.png', '+679', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(53, 'FI', 'Finland', 'Finnish', 'fi.png', '+358', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(54, 'FR', 'France', 'French', 'fr.png', '+33', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(55, 'GA', 'Gabon', 'Gabonese', 'ga.png', '+241', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(56, 'GE', 'Georgia', 'Georgian', 'ge.png', '+995', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(57, 'DE', 'Germany', 'German', 'de.png', '+49', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(58, 'GH', 'Ghana', 'Ghanaian', 'gh.png', '+233', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(59, 'GR', 'Greece', 'Greek', 'gr.png', '+30', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(60, 'GD', 'Grenada', 'Grenadian', 'gd.png', '+1473', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(61, 'GT', 'Guatemala', 'Guatemalan', 'gt.png', '+502', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(62, 'GN', 'Guinea', 'Guinean', 'gn.png', '+224', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(63, 'GW', 'Guinea-Bissau', 'Guinea-Bissauan', 'gw.png', '+245', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(64, 'GY', 'Guyana', 'Guyanese', 'gy.png', '+592', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(65, 'HT', 'Haiti', 'Haitian', 'ht.png', '+509', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(66, 'HN', 'Honduras', 'Honduran', 'hn.png', '+504', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(67, 'HU', 'Hungary', 'Hungarian', 'hu.png', '+36', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(68, 'IS', 'Iceland', 'Icelander', 'is.png', '+354', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(69, 'IN', 'India', 'Indian', 'in.png', '+91', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(70, 'ID', 'Indonesia', 'Indonesian', 'id.png', '+62', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(71, 'IQ', 'Iraq', 'Iraqi', 'iq.png', '+964', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(72, 'IE', 'Ireland', 'Irish', 'ie.png', '+353', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(73, 'IL', 'Israel', 'Israeli', 'il.png', '+972', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(74, 'IT', 'Italy', 'Italian', 'it.png', '+39', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(75, 'JM', 'Jamaica', 'Jamaican', 'jm.png', '+1876', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(76, 'JP', 'Japan', 'Japanese', 'jp.png', '+81', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(77, 'JO', 'Jordan', 'Jordanian', 'jo.png', '+962', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(78, 'KZ', 'Kazakhstan', 'Kazakhstani', 'kz.png', '+76', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(79, 'KE', 'Kenya', 'Kenyan', 'ke.png', '+254', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(80, 'KI', 'Kiribati', 'I-Kiribati', 'ki.png', '+686', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(81, 'KW', 'Kuwait', 'Kuwaiti', 'kw.png', '+965', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(82, 'LV', 'Latvia', 'Latvian', 'lv.png', '+371', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(83, 'LB', 'Lebanon', 'Lebanese', 'lb.png', '+961', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(84, 'LS', 'Lesotho', 'Mosotho', 'ls.png', '+266', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(85, 'LR', 'Liberia', 'Liberian', 'lr.png', '+231', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(86, 'LI', 'Liechtenstein', 'Liechtensteiner', 'li.png', '+423', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(87, 'LT', 'Lithuania', 'Lithuanian', 'lt.png', '+370', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(88, 'LU', 'Luxembourg', 'Luxembourger', 'lu.png', '+370', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(89, 'MG', 'Madagascar', 'Malagasy', 'mg.png', '+261', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(90, 'MW', 'Malawi', 'Malawian', 'mw.png', '+265', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(91, 'MY', 'Malaysia', 'Malaysian', 'my.png', '+60', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(92, 'MV', 'Maldives', 'Maldivan', 'mv.png', '+960', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(93, 'ML', 'Mali', 'Malian', 'ml.png', '+223', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(94, 'MT', 'Malta', 'Maltese', 'mt.png', '+356', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(95, 'MH', 'Marshall Islands', 'Marshallese', 'mh.png', '+692', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(96, 'MR', 'Mauritania', 'Mauritanian', 'mr.png', '+222', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(97, 'MU', 'Mauritius', 'Mauritian', 'mu.png', '+230', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(98, 'MX', 'Mexico', 'Mexican', 'mx.png', '+52', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(99, 'MC', 'Monaco', 'Monegasque', 'mc.png', '+377', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(100, 'MN', 'Mongolia', 'Mongolian', 'mn.png', '+976', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(101, 'MA', 'Morocco', 'Moroccan', 'ma.png', '+212', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(102, 'MZ', 'Mozambique', 'Mozambican', 'mz.png', '+258', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(103, 'NA', 'Namibia', 'Namibian', 'na.png', '+264', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(104, 'NR', 'Nauru', 'Nauruan', 'nr.png', '+674', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(105, 'NP', 'Nepal', 'Nepalese', 'np.png', '+977', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(106, 'NL', 'Netherlands', 'Dutch', 'nl.png', '+31', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(107, 'NZ', 'New Zealand', 'New Zealander', 'nz.png', '+64', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(108, 'NI', 'Nicaragua', 'Nicaraguan', 'ni.png', '+505', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(109, 'NE', 'Niger', 'Nigerien', 'ne.png', '+227', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(110, 'NG', 'Nigeria', 'Nigerian', 'ng.png', '+234', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(111, 'NO', 'Norway', 'Norwegian', 'no.png', '+47', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(112, 'OM', 'Oman', 'Omani', 'om.png', '+968', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(113, 'PK', 'Pakistan', 'Pakistani', 'pk.png', '+92', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(114, 'PW', 'Palau', 'Palauan', 'pw.png', '+680', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(115, 'PA', 'Panama', 'Panamanian', 'pa.png', '+507', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(116, 'PG', 'Papua New Guinea', 'Papua New Guinean', 'pg.png', '+675', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(117, 'PY', 'Paraguay', 'Paraguayan', 'py.png', '+595', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(118, 'PE', 'Peru', 'Peruvian', 'pe.png', '+51', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(119, 'PH', 'Philippines', 'Filipino', 'ph.png', '+63', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(120, 'PL', 'Poland', 'Polish', 'pl.png', '+48', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(121, 'PT', 'Portugal', 'Portuguese', 'pt.png', '+351', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(122, 'QA', 'Qatar', 'Qatari', 'qa.png', '+974', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(123, 'RO', 'Romania', 'Romanian', 'ro.png', '+40', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(124, 'RW', 'Rwanda', 'Rwandan', 'rw.png', '+250', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(125, 'KN', 'Saint Kitts and Nevis', 'Kittian and Nevisian', 'kn.png', '+1869', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(126, 'LC', 'Saint Lucia', 'Saint Lucian', 'lc.png', '+1758', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(127, 'WS', 'Samoa', 'Samoan', 'ws.png', '+685', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(128, 'SM', 'San Marino', 'Sammarinese', 'sm.png', '+378', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(129, 'ST', 'Sao Tome and Principe', 'Sao Tomean', 'st.png', '+239', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(130, 'SA', 'Saudi Arabia', 'Saudi Arabian', 'sa.png', '+966', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(131, 'SN', 'Senegal', 'Senegalese', 'sn.png', '+221', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(132, 'SC', 'Seychelles', 'Seychellois', 'sc.png', '+248', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(133, 'SL', 'Sierra Leone', 'Sierra Leonean', 'sl.png', '+232', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(134, 'SG', 'Singapore', 'Singaporean', 'sg.png', '+65', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(135, 'SK', 'Slovakia', 'Slovak', 'sk.png', '+421', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(136, 'SI', 'Slovenia', 'Slovene', 'si.png', '+386', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(137, 'SB', 'Solomon Islands', 'Solomon Islander', 'sb.png', '+677', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(138, 'SO', 'Somalia', 'Somali', 'so.png', '+252', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(139, 'ZA', 'South Africa', 'South African', 'za.png', '+27', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(140, 'ES', 'Spain', 'Spanish', 'es.png', '+34', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(141, 'LK', 'Sri Lanka', 'Sri Lankan', 'lk.png', '+94', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(142, 'SD', 'Sudan', 'Sudanese', 'sd.png', '+249', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(143, 'SR', 'Suriname', 'Surinamer', 'sr.png', '+597', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(144, 'SZ', 'Swaziland', 'Swazi', 'sz.png', '+268', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(145, 'SE', 'Sweden', 'Swedish', 'se.png', '+46', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(146, 'CH', 'Switzerland', 'Swiss', 'ch.png', '+41', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(147, 'TJ', 'Tajikistan', 'Tadzhik', 'tj.png', '+992', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(148, 'TH', 'Thailand', 'Thai', 'th.png', '+66', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(149, 'TG', 'Togo', 'Togolese', 'tg.png', '+228', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(150, 'TO', 'Tonga', 'Tongan', 'to.png', '+676', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(151, 'TT', 'Trinidad and Tobago', 'Trinidadian', 'tt.png', '+1868', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(152, 'TN', 'Tunisia', 'Tunisian', 'tn.png', '+216', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(153, 'TR', 'Turkey', 'Turkish', 'tr.png', '+90', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(154, 'TM', 'Turkmenistan', 'Turkmen', 'tm.png', '+993', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(155, 'TV', 'Tuvalu', 'Tuvaluan', 'tv.png', '+688', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(156, 'UG', 'Uganda', 'Ugandan', 'ug.png', '+256', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(157, 'UA', 'Ukraine', 'Ukrainian', 'ua.png', '+380', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(158, 'AE', 'United Arab Emirates', 'Emirian', 'ae.png', '+971', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(159, 'GB', 'United Kingdom', 'British', 'gb.png', '+44', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(160, 'US', 'United States', 'American', 'us.png', '+1', '2020-04-16 06:28:59', '2020-04-16 06:28:59'),
(161, 'UY', 'Uruguay', 'Uruguayan', 'uy.png', '+598', '2020-04-16 06:28:59', '2020-04-16 06:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `cp_ipns`
--

CREATE TABLE `cp_ipns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipn_version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ipn_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `ipn_mode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `ipn_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `status_text` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency1` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency2` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount1` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount2` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `fee` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8_unicode_ci,
  `send_tx` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `received_amount` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `received_confirms` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cp_ipns`
--

INSERT INTO `cp_ipns` (`id`, `ipn_version`, `ipn_id`, `ipn_mode`, `merchant`, `ipn_type`, `txn_id`, `status`, `status_text`, `currency1`, `currency2`, `amount1`, `amount2`, `fee`, `buyer_name`, `item_name`, `item_number`, `invoice`, `custom`, `send_tx`, `received_amount`, `received_confirms`, `created_at`, `updated_at`) VALUES
(1, '1.0', 'ea7223337249a43317c57ec83359c354', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4F5SVUQY7WBVYAFLCGGL9J', 0, 'Waiting for buyer funds...', 'USD', 'XMR', '10', '0.02099', '0.0001', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:54:42', '2021-05-08 08:54:42'),
(2, '1.0', '6e938e7e641bab48859d753e897feab0', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2SGADJZ9EHI3U1H6ZD7RLJ', 0, 'Waiting for buyer funds...', 'USD', 'LTC', '10', '0.0286', '0.00014', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:55:37', '2021-05-08 08:55:37'),
(3, '1.0', '757c14ca17b22a4e77a96dbc66807878', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE5YPUMOLJLSS6DM2HNYLMEN', 0, 'Waiting for buyer funds...', 'USD', 'BNB', '10', '0.01573', '8.0E-5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:56:40', '2021-05-08 08:56:40'),
(4, '1.0', '52af4c67b7836e0051cc61f27a662981', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4IGFXKWWQ3RFMIA65J5SCI', 0, 'Waiting for buyer funds...', 'USD', 'DASH', '10', '0.02392', '0.00012', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:57:38', '2021-05-08 08:57:38'),
(5, '1.0', '087c5ba48a579a138275fc854c59b29c', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1ZMALSC3KDEJ5AQTWUWP49', 0, 'Waiting for buyer funds...', 'USD', 'BTC', '10', '0.00017', '1.0E-6', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:58:33', '2021-05-08 08:58:33'),
(6, '1.0', 'de6404fcd570f99d94cc02c1794bf8da', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE5R3I3OTIISDUSPFW5I0RY4', 0, 'Waiting for buyer funds...', 'USD', 'BCH', '10', '0.00706', '4.0E-5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 08:58:36', '2021-05-08 08:58:36'),
(7, '1.0', 'e7eea9343da7c75899b6a16a7c8a7fcf', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE6L2CEG68VHSVMNKFZAWWAS', 0, 'Waiting for buyer funds...', 'USD', 'BTC', '100', '0.00169', '8.0E-6', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 09:00:47', '2021-05-08 09:00:47'),
(8, '1.0', '508cb5f629a99f54987abdbf4658e876', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE7AS9SNY2CCFZ7ROM4IOTWL', 0, 'Waiting for buyer funds...', 'USD', 'ETH', '100', '0.02798', '0.00014', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 09:04:32', '2021-05-08 09:04:32'),
(9, '1.0', 'e6745e91fed2f40e1ba5bfa9aeaacdcb', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2DBDRZHTQ24563APTGUHY2', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '10', '29.38', '19.51', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 09:09:29', '2021-05-08 09:09:29'),
(10, '1.0', '30231229f6ccd7c5c4b54f2f5ec66988', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE3J8FR6OTDCKJULSINF3E04', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '100', '120.45', '21.8', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 09:25:29', '2021-05-08 09:25:29'),
(11, '1.0', 'cad3e858e9b6e07a24271210a689c823', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2SGADJZ9EHI3U1H6ZD7RLJ', -1, 'Cancelled / Timed Out', 'USD', 'LTC', '10', '0.0286', '0.00014', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 10:27:46', '2021-05-08 10:27:46'),
(12, '1.0', '6ed73b27be3511e86ac9751aa6e1441e', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4IGFXKWWQ3RFMIA65J5SCI', -1, 'Cancelled / Timed Out', 'USD', 'DASH', '10', '0.02392', '0.00012', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 10:54:38', '2021-05-08 10:54:38'),
(13, '1.0', '18c2ac6cb13f00d7d3c47d14ee10fe15', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4F5SVUQY7WBVYAFLCGGL9J', -1, 'Cancelled / Timed Out', 'USD', 'XMR', '10', '0.02099', '0.0001', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 11:56:37', '2021-05-08 11:56:37'),
(14, '1.0', '4ad6b3e531ca9fc1db7d86fa0de2a9d9', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2DBDRZHTQ24563APTGUHY2', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '10', '29.38', '19.51', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 13:10:57', '2021-05-08 13:10:57'),
(15, '1.0', '99dcc33698e8fb4238f88badd2128ac3', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE7AS9SNY2CCFZ7ROM4IOTWL', -1, 'Cancelled / Timed Out', 'USD', 'ETH', '100', '0.02798', '0.00014', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 13:25:40', '2021-05-08 13:25:40'),
(16, '1.0', 'b4f73b8541bf2d2663189efbb686177d', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE3J8FR6OTDCKJULSINF3E04', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '100', '120.45', '21.8', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 13:25:40', '2021-05-08 13:25:40'),
(17, '1.0', 'b15656872437accfbd3262e6a3077b6f', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE5R3I3OTIISDUSPFW5I0RY4', -1, 'Cancelled / Timed Out', 'USD', 'BCH', '10', '0.00706', '4.0E-5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 13:56:44', '2021-05-08 13:56:44'),
(18, '1.0', 'f315d41ac4e70db4e4877909124478bd', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1ZMALSC3KDEJ5AQTWUWP49', -1, 'Cancelled / Timed Out', 'USD', 'BTC', '10', '0.00017', '1.0E-6', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 16:21:51', '2021-05-08 16:21:51'),
(19, '1.0', '11d6583f8e8847e872558ecb2491a8e7', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE6L2CEG68VHSVMNKFZAWWAS', -1, 'Cancelled / Timed Out', 'USD', 'BTC', '100', '0.00169', '8.0E-6', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-08 16:31:35', '2021-05-08 16:31:35'),
(20, '1.0', 'd7fb3fa5f9a443e018d46c54acc6e478', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4SKOTEVWUFO6WEOJGJWP6O', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '200', '260.7', '62.75', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 03:22:26', '2021-05-09 03:22:26'),
(21, '1.0', 'e9877ac486126de281ba21a613e6615a', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE6ESRXXIZKJPT2GR4PVWCHU', 0, 'Waiting for buyer funds...', 'USD', 'LTC', '200', '0.57251', '0.00286', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 03:23:38', '2021-05-09 03:23:38'),
(22, '1.0', 'c6f088d57d0cda7e8ece66f0ed60ae11', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE6ESRXXIZKJPT2GR4PVWCHU', -1, 'Cancelled / Timed Out', 'USD', 'LTC', '200', '0.57251', '0.00286', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 04:54:24', '2021-05-09 04:54:24'),
(23, '1.0', 'f0514454837c7456be0a48146961a507', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1XLDHGLA2F0W2NMVG1MZSU', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '100', '128.38', '29.53', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 05:31:12', '2021-05-09 05:31:12'),
(24, '1.0', '312a5c6744ab5e06851e30512e002a0f', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1XLDHGLA2F0W2NMVG1MZSU', 0, 'Waiting for buyer funds... (100/128.38 received with 3 confirms)', 'USD', 'USDT.ERC20', '100', '128.38', '29.53', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '100', '3', '2021-05-09 05:50:40', '2021-05-09 05:50:40'),
(25, '1.0', 'c5bd03529e259759fa8f1831edec9715', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE4SKOTEVWUFO6WEOJGJWP6O', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '200', '260.7', '62.75', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 07:23:37', '2021-05-09 07:23:37'),
(26, '1.0', 'afd2c1521f307407fc9a1e009d92a59d', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE5YPUMOLJLSS6DM2HNYLMEN', -1, 'Cancelled / Timed Out', 'USD', 'BNB', '10', '0.01573', '8.0E-5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-09 08:57:41', '2021-05-09 08:57:41'),
(27, '1.0', '3af0a2117f57084237f588b544470752', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1XLDHGLA2F0W2NMVG1MZSU', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '100', '128.38', '29.53', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '100', '3', '2021-05-09 09:34:39', '2021-05-09 09:34:39'),
(28, '1.0', '9ad0c67b7c053e5e8c63b44e411fa20c', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2263V8EGMV3FM0BW6LIIWN', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '100', '162', '63.29', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 10:38:49', '2021-05-11 10:38:49'),
(29, '1.0', '5ae7c7673b6e68b580283f685cbdc1db', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE62RICNGNWIJ9RTDB2HRPFH', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '1000', '1053.06', '65.97', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 10:46:34', '2021-05-11 10:46:34'),
(30, '1.0', '61bd45e5c62286e67250e9579b16b5f2', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0T7HRRVTMATRO8AZW5CK5Y', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '10000', '10026.65', '155.71', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 10:47:37', '2021-05-11 10:47:37'),
(31, '1.0', '7d1a36c8ea3ca87a458135ea3d9c3eea', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE7WQHOMRFKHDQRU57HF89JV', 0, 'Waiting for buyer funds...', 'USD', 'USDT.BEP2', '100', '99.86', '0.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 11:07:36', '2021-05-11 11:07:36'),
(32, '1.0', 'c873911a2d65e288faf56d83b30e8aa6', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2RA6MZHOF9DQJTIV2DZ75Y', 0, 'Waiting for buyer funds...', 'USD', 'USDT.BEP20', '100', '99.86', '1', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 11:08:47', '2021-05-11 11:08:47'),
(33, '1.0', 'd297d25d0927cee4b613c3b9c049fae7', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2BCTD2RHFVS93YD0PFQSO6', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '100', '191.79', '92.99', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 14:31:39', '2021-05-11 14:31:39'),
(34, '1.0', 'bf32499b0f24eddae939a181dcf0d1a6', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2263V8EGMV3FM0BW6LIIWN', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '100', '162', '63.29', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 14:38:44', '2021-05-11 14:38:44'),
(35, '1.0', 'aef98548f2e2df9f0966b56fbe950742', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0T7HRRVTMATRO8AZW5CK5Y', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '10000', '10026.65', '155.71', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 14:48:46', '2021-05-11 14:48:46'),
(36, '1.0', '817e5b58300e15a787516439070ddbbf', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE62RICNGNWIJ9RTDB2HRPFH', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '1000', '1053.06', '65.97', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 14:48:47', '2021-05-11 14:48:47'),
(37, '1.0', 'd5c2784228805aef457fb7f0b19f9a15', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2HGCAYBEPTXLG1NA9PATHL', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '10', '99.89', '90.01', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 14:49:37', '2021-05-11 14:49:37'),
(38, '1.0', 'cb4c7c8f7cd890d0a562ff78c87b251b', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE3KDE0FZXIBDPISSGAUWH0I', 0, 'Waiting for buyer funds...', 'USD', 'ETH', '4025.62', '1.00965', '0.00505', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 15:33:43', '2021-05-11 15:33:43'),
(39, '1.0', '8d83e2646df2cea1ddfdbc0eb0a89d39', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE07UJLEORX6WBJVX4VFZRID', 0, 'Waiting for buyer funds...', 'USD', 'BTC', '56170', '1.00626', '0.005031', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 15:41:47', '2021-05-11 15:41:47'),
(40, '1.0', 'ba3429aae9e72e349e24d4995c45134e', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2BCTD2RHFVS93YD0PFQSO6', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '100', '191.79', '92.99', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 18:30:57', '2021-05-11 18:30:57'),
(41, '1.0', '916e44b810665f653f0d3164e57028b9', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2HGCAYBEPTXLG1NA9PATHL', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '10', '99.89', '90.01', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 18:48:41', '2021-05-11 18:48:41'),
(42, '1.0', 'fb7a090413e73a5b7e64070951a94abc', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE3KDE0FZXIBDPISSGAUWH0I', -1, 'Cancelled / Timed Out', 'USD', 'ETH', '4025.62', '1.00965', '0.00505', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 19:47:56', '2021-05-11 19:47:56'),
(43, '1.0', '33366aeb50e4e9b5c599a1f49070ae2c', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE07UJLEORX6WBJVX4VFZRID', -1, 'Cancelled / Timed Out', 'USD', 'BTC', '56170', '1.00626', '0.005031', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-11 23:04:35', '2021-05-11 23:04:35'),
(44, '1.0', 'fed49ded4663fdb7df5e03ba7cbb1589', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE2RA6MZHOF9DQJTIV2DZ75Y', -1, 'Cancelled / Timed Out', 'USD', 'USDT.BEP20', '100', '99.86', '1', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-12 11:06:45', '2021-05-12 11:06:45'),
(45, '1.0', 'caa970bd3af06490e1970f2d16866af5', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE7WQHOMRFKHDQRU57HF89JV', -1, 'Cancelled / Timed Out', 'USD', 'USDT.BEP2', '100', '99.86', '0.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-12 11:07:42', '2021-05-12 11:07:42'),
(46, '1.0', '6caee811a14faa304fba2b053edcc218', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 0, 'Waiting for buyer funds...', 'USD', 'USDT.BEP20', '150', '150.47', '1.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-13 09:54:40', '2021-05-13 09:54:40'),
(47, '1.0', '36cef807e5572acc1de5616692c73ebe', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0RSKKFCMQ4R9P6BLGAPWJZ', 0, 'Waiting for buyer funds...', 'USD', 'USDT.BEP20', '150', '150.47', '1.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-13 09:55:37', '2021-05-13 09:55:37'),
(48, '1.0', '0769217970ef977be594de0423585280', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 1, 'Funds received and confirmed, sending to you shortly...', 'USD', 'USDT.BEP20', '150', '150.47', '1.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '150.47', '50', '2021-05-13 10:06:41', '2021-05-13 10:06:41'),
(49, '1.0', 'de9eb66532c52ea1ef64005718f9bd2b', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 100, 'Complete', 'USD', 'USDT.BEP20', '150', '150.47', '1.5', 'CoinPayments API', NULL, NULL, NULL, NULL, '0xf921a8a168f90851ea883b82d1ae6ccf6b269048450132fd17b5c1cb8a15ab84', '150.47', '50', '2021-05-13 10:25:41', '2021-05-13 10:25:41'),
(50, '1.0', 'e0734301ab901598ad991a07575e6ab1', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1IRMWLF2D7UDAECATH2F6Z', 0, 'Waiting for buyer funds...', 'USD', 'USDT.ERC20', '100', '142.18', '43.48', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-13 10:45:37', '2021-05-13 10:45:37'),
(51, '1.0', 'deff0bde35a4348dd64597f22c8ad976', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE1IRMWLF2D7UDAECATH2F6Z', -1, 'Cancelled / Timed Out', 'USD', 'USDT.ERC20', '100', '142.18', '43.48', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-13 14:34:37', '2021-05-13 14:34:37'),
(52, '1.0', 'd358003295da4efadddc1b174845d507', 'hmac', '4b643fbecf7b8472c8d3b6508d964c76', 'api', 'CPFE0RSKKFCMQ4R9P6BLGAPWJZ', -1, 'Cancelled / Timed Out', 'USD', 'USDT.BEP20', '150', '150.47', '1.5', 'CoinPayments API', NULL, NULL, NULL, NULL, NULL, '0', '0', '2021-05-14 09:55:29', '2021-05-14 09:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `cp_log`
--

CREATE TABLE `cp_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cp_log`
--

INSERT INTO `cp_log` (`id`, `type`, `log`, `created_at`, `updated_at`) VALUES
(1, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ADA\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:53:59', '2021-05-07 10:53:59'),
(2, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ADA\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:54:59', '2021-05-07 10:54:59'),
(3, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ADA\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:57:11', '2021-05-07 10:57:11'),
(4, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ADA\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:57:49', '2021-05-07 10:57:49'),
(5, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"USDT\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:59:10', '2021-05-07 10:59:10'),
(6, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 10:59:56', '2021-05-07 10:59:56'),
(7, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"No \'buyer_email\' set! If you cannot obtain the buyer\'s email and want to handle refunds on your own you can use your own email instead.\",\"result\":[]}}', '2021-05-07 11:10:19', '2021-05-07 11:10:19'),
(8, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-07 11:11:19', '2021-05-07 11:11:19'),
(9, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ETH\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-07 11:11:36', '2021-05-07 11:11:36'),
(10, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"500\",\"currency1\":\"USD\",\"currency2\":\"USDT\",\"buyer_email\":\"soar05@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-07 16:23:29', '2021-05-07 16:23:29'),
(11, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"1\",\"currency1\":\"USD\",\"currency2\":\"ETH\",\"buyer_email\":\"soar05@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-07 16:25:36', '2021-05-07 16:25:36'),
(12, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"100\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"jasonktrade.jk@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 06:19:09', '2021-05-08 06:19:09'),
(13, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"100\",\"currency1\":\"USD\",\"currency2\":\"ETH\",\"buyer_email\":\"jasonktrade.jk@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 06:19:31', '2021-05-08 06:19:31'),
(14, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"1000\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"jasonktrade.jk@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 06:23:19', '2021-05-08 06:23:19'),
(15, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"USDT\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 07:35:37', '2021-05-08 07:35:37'),
(16, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"0.0001\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Transaction amount must be greater than 0\",\"result\":[]}}', '2021-05-08 07:36:13', '2021-05-08 07:36:13'),
(17, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"100\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 07:36:27', '2021-05-08 07:36:27'),
(18, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"100\",\"currency1\":\"USD\",\"currency2\":\"BTC\",\"buyer_email\":\"loges23waran23@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 08:34:39', '2021-05-08 08:34:39'),
(19, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"USDT\",\"buyer_email\":\"rohanjha1992@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 08:46:35', '2021-05-08 08:46:35'),
(20, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ADA\",\"buyer_email\":\"rohanjha1992@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Invalid currency code for currency2\",\"result\":[]}}', '2021-05-08 08:46:51', '2021-05-08 08:46:51'),
(21, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"USDT\",\"buyer_email\":\"rohanjha1992@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Receiver does not accept that coin!\",\"result\":[]}}', '2021-05-08 08:48:38', '2021-05-08 08:48:38'),
(22, 'API_CALL_ERROR', '{\"request\":{\"amount\":\"10\",\"currency1\":\"USD\",\"currency2\":\"ETH\",\"buyer_email\":\"rohanjha1992@gmail.com\",\"version\":1,\"cmd\":\"create_transaction\",\"key\":\"b826fae787fac1e14e37f4f6794779a327d7266369eddb8e9f821342a64264e8\",\"format\":\"json\",\"ipn_url\":\"https:\\/\\/caesiumlab.com\\/en\\/payment\\/notification\"},\"response\":{\"error\":\"Amount too small, there would be nothing left!\",\"result\":[]}}', '2021-05-08 08:49:47', '2021-05-08 08:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `cp_transactions`
--

CREATE TABLE `cp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency1` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `buyer_email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8_unicode_ci,
  `ipn_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `confirms_needed` tinyint(3) UNSIGNED NOT NULL,
  `timeout` int(10) UNSIGNED NOT NULL,
  `status_url` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `qrcode_url` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cp_transactions`
--

INSERT INTO `cp_transactions` (`id`, `amount`, `currency1`, `currency2`, `address`, `buyer_email`, `buyer_name`, `item_name`, `item_number`, `invoice`, `custom`, `ipn_url`, `txn_id`, `confirms_needed`, `timeout`, `status_url`, `qrcode_url`, `created_at`, `updated_at`) VALUES
(1, '0.00017000', 'USD', 'BTC', '3MPigRu9gyKynwtmjPA8Z9FNVBRV9wxTyJ', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE1ZMALSC3KDEJ5AQTWUWP49', 2, 27000, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE1ZMALSC3KDEJ5AQTWUWP49&key=611fbb8d84ee2ba4d0af5435ca732908', 'https://www.coinpayments.net/qrgen.php?id=CPFE1ZMALSC3KDEJ5AQTWUWP49&key=611fbb8d84ee2ba4d0af5435ca732908', '2021-05-08 08:46:10', '2021-05-08 08:46:10'),
(2, '0.02099000', 'USD', 'XMR', '89jT8t7Q7jtdawFQ5DxexqWUM2BXSraYhJPqDFr9U1n6hCDvNXTTVhXMMnDksHZYVnCiYbVHv992sh47GAfVmSecPoEor2Z', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE4F5SVUQY7WBVYAFLCGGL9J', 3, 10800, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE4F5SVUQY7WBVYAFLCGGL9J&key=20bc8bd8e20eb3ffca87d1a5b7f437e5', 'https://www.coinpayments.net/qrgen.php?id=CPFE4F5SVUQY7WBVYAFLCGGL9J&key=20bc8bd8e20eb3ffca87d1a5b7f437e5', '2021-05-08 08:47:25', '2021-05-08 08:47:25'),
(3, '0.02392000', 'USD', 'DASH', 'XrUK7hjTYZmeoEDePm6SqcPfbYjDJYywxf', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE4IGFXKWWQ3RFMIA65J5SCI', 3, 7200, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE4IGFXKWWQ3RFMIA65J5SCI&key=079c684c33f42f43adfb4941312d20e2', 'https://www.coinpayments.net/qrgen.php?id=CPFE4IGFXKWWQ3RFMIA65J5SCI&key=079c684c33f42f43adfb4941312d20e2', '2021-05-08 08:47:51', '2021-05-08 08:47:51'),
(4, '0.02860000', 'USD', 'LTC', 'MKhLZE9xuCTmTRhadoe4qNhQdEwaYMY4Vi', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2SGADJZ9EHI3U1H6ZD7RLJ', 3, 5400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2SGADJZ9EHI3U1H6ZD7RLJ&key=69c1622edb78ab3395d872c2f0263225', 'https://www.coinpayments.net/qrgen.php?id=CPFE2SGADJZ9EHI3U1H6ZD7RLJ&key=69c1622edb78ab3395d872c2f0263225', '2021-05-08 08:48:16', '2021-05-08 08:48:16'),
(5, '0.01573000', 'USD', 'BNB', 'bnb1nf37u6yag0z3ajfn0qm6lnp3p9dulk8rnrcyhk', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE5YPUMOLJLSS6DM2HNYLMEN', 10, 86400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE5YPUMOLJLSS6DM2HNYLMEN&key=b0564d55dfa49dd5dfb29e6a630d24a6', 'https://www.coinpayments.net/qrgen.php?id=CPFE5YPUMOLJLSS6DM2HNYLMEN&key=b0564d55dfa49dd5dfb29e6a630d24a6', '2021-05-08 08:48:57', '2021-05-08 08:48:57'),
(6, '0.00706000', 'USD', 'BCH', 'bitcoincash:qr236qq8fgcumqd49mvjpxrxau2l7vhs2yqkekhnfl', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE5R3I3OTIISDUSPFW5I0RY4', 3, 18000, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE5R3I3OTIISDUSPFW5I0RY4&key=9b5f41504b3bda7f032641290481fce4', 'https://www.coinpayments.net/qrgen.php?id=CPFE5R3I3OTIISDUSPFW5I0RY4&key=9b5f41504b3bda7f032641290481fce4', '2021-05-08 08:49:29', '2021-05-08 08:49:29'),
(7, '0.00169000', 'USD', 'BTC', '3PsMHPdtL5SoxQDo5uqN2iwPosXRGeBfaJ', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE6L2CEG68VHSVMNKFZAWWAS', 2, 27000, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE6L2CEG68VHSVMNKFZAWWAS&key=8cccae8875556e0c98c4fef214bd22a4', 'https://www.coinpayments.net/qrgen.php?id=CPFE6L2CEG68VHSVMNKFZAWWAS&key=8cccae8875556e0c98c4fef214bd22a4', '2021-05-08 08:53:51', '2021-05-08 08:53:51'),
(8, '0.02798000', 'USD', 'ETH', '0xf64aaea745c88db9ff509e766dd04792babb3564', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE7AS9SNY2CCFZ7ROM4IOTWL', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE7AS9SNY2CCFZ7ROM4IOTWL&key=088b9ae9f17bc2efa5599cb287fe1417', 'https://www.coinpayments.net/qrgen.php?id=CPFE7AS9SNY2CCFZ7ROM4IOTWL&key=088b9ae9f17bc2efa5599cb287fe1417', '2021-05-08 08:54:30', '2021-05-08 08:54:30'),
(9, '29.38000000', 'USD', 'USDT.ERC20', '0xb0aca1d17b184cb070cca3ce18d22ab6a9fcefd4', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2DBDRZHTQ24563APTGUHY2', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2DBDRZHTQ24563APTGUHY2&key=55ae5f3817624d30483094481ad8f934', 'https://www.coinpayments.net/qrgen.php?id=CPFE2DBDRZHTQ24563APTGUHY2&key=55ae5f3817624d30483094481ad8f934', '2021-05-08 09:03:15', '2021-05-08 09:03:15'),
(10, '120.45000000', 'USD', 'USDT.ERC20', '0x150d2f353fe34f4a454ef87bfbd722031efc117c', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE3J8FR6OTDCKJULSINF3E04', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE3J8FR6OTDCKJULSINF3E04&key=d7f599d81551b73a8e4f35154a36d66e', 'https://www.coinpayments.net/qrgen.php?id=CPFE3J8FR6OTDCKJULSINF3E04&key=d7f599d81551b73a8e4f35154a36d66e', '2021-05-08 09:17:07', '2021-05-08 09:17:07'),
(11, '260.70000000', 'USD', 'USDT.ERC20', '0x8cda69ba6a8d5355844279fe0ff85037f2c5c1de', 'mac.fbis@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE4SKOTEVWUFO6WEOJGJWP6O', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE4SKOTEVWUFO6WEOJGJWP6O&key=f44b8b92c3bbe7c87aa9c77ce33dcec8', 'https://www.coinpayments.net/qrgen.php?id=CPFE4SKOTEVWUFO6WEOJGJWP6O&key=f44b8b92c3bbe7c87aa9c77ce33dcec8', '2021-05-09 03:17:39', '2021-05-09 03:17:39'),
(12, '0.57251000', 'USD', 'LTC', 'MP3skxCb7hJo7Z6zmG1SZX3MmHdap6EWNb', 'mac.fbis@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE6ESRXXIZKJPT2GR4PVWCHU', 3, 5400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE6ESRXXIZKJPT2GR4PVWCHU&key=f0ed81d4b24144feaf6603e60facaa20', 'https://www.coinpayments.net/qrgen.php?id=CPFE6ESRXXIZKJPT2GR4PVWCHU&key=f0ed81d4b24144feaf6603e60facaa20', '2021-05-09 03:18:44', '2021-05-09 03:18:44'),
(13, '128.38000000', 'USD', 'USDT.ERC20', '0x0ef1d10d9b2efac0daf3239614c26b5642e11767', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE1XLDHGLA2F0W2NMVG1MZSU', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE1XLDHGLA2F0W2NMVG1MZSU&key=c29ef2110ec8cfb2c247880fb07db0e4', 'https://www.coinpayments.net/qrgen.php?id=CPFE1XLDHGLA2F0W2NMVG1MZSU&key=c29ef2110ec8cfb2c247880fb07db0e4', '2021-05-09 05:27:37', '2021-05-09 05:27:37'),
(14, '162.00000000', 'USD', 'USDT.ERC20', '0xe1acd157a9bc6494d7ab35b49d865c1b438e3a27', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2263V8EGMV3FM0BW6LIIWN', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2263V8EGMV3FM0BW6LIIWN&key=8b4048733ba941d61d2857972b17cbb1', 'https://www.coinpayments.net/qrgen.php?id=CPFE2263V8EGMV3FM0BW6LIIWN&key=8b4048733ba941d61d2857972b17cbb1', '2021-05-11 10:30:21', '2021-05-11 10:30:21'),
(15, '1053.06000000', 'USD', 'USDT.ERC20', '0x5a2da23f525b1265e5519acf1bf525c19a230daa', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE62RICNGNWIJ9RTDB2HRPFH', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE62RICNGNWIJ9RTDB2HRPFH&key=a97154033c79e0b8bd31f7e9e8ff25c7', 'https://www.coinpayments.net/qrgen.php?id=CPFE62RICNGNWIJ9RTDB2HRPFH&key=a97154033c79e0b8bd31f7e9e8ff25c7', '2021-05-11 10:37:11', '2021-05-11 10:37:11'),
(16, '10026.65000000', 'USD', 'USDT.ERC20', '0x09c3c37d547f1d60dd29086a2a7894da71e4d7e2', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE0T7HRRVTMATRO8AZW5CK5Y', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE0T7HRRVTMATRO8AZW5CK5Y&key=a9a4dc1a4177bf0d90c4574862b564f3', 'https://www.coinpayments.net/qrgen.php?id=CPFE0T7HRRVTMATRO8AZW5CK5Y&key=a9a4dc1a4177bf0d90c4574862b564f3', '2021-05-11 10:38:57', '2021-05-11 10:38:57'),
(17, '99.86000000', 'USD', 'USDT.BEP20', '0x3dad0c8e3ca5a506c6075ee8ed02d61ca203a1f3', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2RA6MZHOF9DQJTIV2DZ75Y', 50, 86400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2RA6MZHOF9DQJTIV2DZ75Y&key=2e59d33ad61f199e765379957f9a9710', 'https://www.coinpayments.net/qrgen.php?id=CPFE2RA6MZHOF9DQJTIV2DZ75Y&key=2e59d33ad61f199e765379957f9a9710', '2021-05-11 11:00:10', '2021-05-11 11:00:10'),
(18, '99.86000000', 'USD', 'USDT.BEP2', 'bnb1utjsjt2xnzc6s4va3fj677w0splnrw6chx0n62', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE7WQHOMRFKHDQRU57HF89JV', 10, 86400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE7WQHOMRFKHDQRU57HF89JV&key=480a181525d8447d6fc62b29b3737810', 'https://www.coinpayments.net/qrgen.php?id=CPFE7WQHOMRFKHDQRU57HF89JV&key=480a181525d8447d6fc62b29b3737810', '2021-05-11 11:00:35', '2021-05-11 11:00:35'),
(19, '191.79000000', 'USD', 'USDT.ERC20', '0xe677d6a915f972709fdccbed1ae55d9c16c5f490', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2BCTD2RHFVS93YD0PFQSO6', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2BCTD2RHFVS93YD0PFQSO6&key=b8578ef8fc31cd3eee086c587f3ba3c8', 'https://www.coinpayments.net/qrgen.php?id=CPFE2BCTD2RHFVS93YD0PFQSO6&key=b8578ef8fc31cd3eee086c587f3ba3c8', '2021-05-11 14:20:47', '2021-05-11 14:20:47'),
(20, '99.89000000', 'USD', 'USDT.ERC20', '0x345b106a46154cb3a5a8384d02b8d6be9cb7431e', 'rohanjha1992@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE2HGCAYBEPTXLG1NA9PATHL', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE2HGCAYBEPTXLG1NA9PATHL&key=27810607b65fe351bc82a1470dc0e6f3', 'https://www.coinpayments.net/qrgen.php?id=CPFE2HGCAYBEPTXLG1NA9PATHL&key=27810607b65fe351bc82a1470dc0e6f3', '2021-05-11 14:39:25', '2021-05-11 14:39:25'),
(21, '1.00965000', 'USD', 'ETH', '0x22d8c6f143f13ee4c065c1cf16e3b8555ec23f73', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE3KDE0FZXIBDPISSGAUWH0I', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE3KDE0FZXIBDPISSGAUWH0I&key=89ce89e62a5ad22ea4bbaa3edaea806f', 'https://www.coinpayments.net/qrgen.php?id=CPFE3KDE0FZXIBDPISSGAUWH0I&key=89ce89e62a5ad22ea4bbaa3edaea806f', '2021-05-11 15:27:21', '2021-05-11 15:27:21'),
(22, '1.00626000', 'USD', 'BTC', '3J3hoWcDmxN7qUcSoxTQEJvAnJpWDWzxDH', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE07UJLEORX6WBJVX4VFZRID', 2, 27000, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE07UJLEORX6WBJVX4VFZRID&key=c563d09afe89629d219c2d067a76f954', 'https://www.coinpayments.net/qrgen.php?id=CPFE07UJLEORX6WBJVX4VFZRID&key=c563d09afe89629d219c2d067a76f954', '2021-05-11 15:29:11', '2021-05-11 15:29:11'),
(23, '150.47000000', 'USD', 'USDT.BEP20', '0xdc2ab0e9fc58500e3c9d898ad89c7492fb86838e', 'mac.fbis@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE0RSKKFCMQ4R9P6BLGAPWJZ', 50, 86400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE0RSKKFCMQ4R9P6BLGAPWJZ&key=dcb1acfa39be4703ed09fc097ec50ca1', 'https://www.coinpayments.net/qrgen.php?id=CPFE0RSKKFCMQ4R9P6BLGAPWJZ&key=dcb1acfa39be4703ed09fc097ec50ca1', '2021-05-13 09:46:03', '2021-05-13 09:46:03'),
(24, '150.47000000', 'USD', 'USDT.BEP20', '0x806ce9b938e6537b06745fe46b57a4f7218e5dcc', 'mac.fbis@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 50, 86400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE0OTNLKBEMNKDBPHKNTYKJV&key=6e544c88ba9e5400fdeae04af52cde84', 'https://www.coinpayments.net/qrgen.php?id=CPFE0OTNLKBEMNKDBPHKNTYKJV&key=6e544c88ba9e5400fdeae04af52cde84', '2021-05-13 09:46:56', '2021-05-13 09:46:56'),
(25, '142.18000000', 'USD', 'USDT.ERC20', '0x3ad811807563820eff3fd023daefba54a69a27c9', 'loges23waran23@gmail.com', NULL, NULL, NULL, NULL, NULL, 'https://caesiumlab.com/en/payment/notification', 'CPFE1IRMWLF2D7UDAECATH2F6Z', 3, 14400, 'https://www.coinpayments.net/index.php?cmd=status&id=CPFE1IRMWLF2D7UDAECATH2F6Z&key=0b98733cde7e6cfcce8302373e5755df', 'https://www.coinpayments.net/qrgen.php?id=CPFE1IRMWLF2D7UDAECATH2F6Z&key=0b98733cde7e6cfcce8302373e5755df', '2021-05-13 10:28:33', '2021-05-13 10:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `cp_transfers`
--

CREATE TABLE `cp_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `ref_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_withdrawals`
--

CREATE TABLE `cp_withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ipn_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  `ref_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `withdraw` tinyint(4) NOT NULL DEFAULT '0',
  `kyc_verified_amount` float NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `description`, `withdraw`, `kyc_verified_amount`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'US Dollar', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(2, 'MSC', 'Masonicoin', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(3, 'BTC', 'Bitcoin', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(4, 'DASH', 'Dash Coin', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(5, 'ETH', 'Etherium', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(6, 'XMR', 'Monereo', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(7, 'BCH', 'Bitcoin Cash', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(8, 'LTC', 'Litecoin', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(9, 'CSM', 'CSM', 1, 10, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(10, 'BNB', 'BinanceCoin', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(11, 'USDT', 'Tether', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(12, 'ADA', 'Cardano', 0, 0, 1, NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_coin_details`
--

CREATE TABLE `deposit_coin_details` (
  `id` int(11) NOT NULL,
  `coin` varchar(100) DEFAULT NULL,
  `address` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit_coin_details`
--

INSERT INTO `deposit_coin_details` (`id`, `coin`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin(BTC)', '1MBYyA1scVWRUSa8vXuBDLVpaDNk1t6k4F', 1, '2021-05-14 11:48:46', '2021-05-17 11:49:49'),
(2, 'Ethereum (ETH)-ERC20', '0x021038ef18bb0a37a352f8975c60166c0bba160c', 1, '2021-05-14 11:48:46', '2021-05-14 11:49:00'),
(3, 'USDT-ERC20', '0x021038ef18bb0a37a352f8975c60166c0bba160c', 1, '2021-05-14 11:48:46', '2021-05-14 11:49:00'),
(4, 'USDT-TRC20', 'TVGexX1coUzZVzirytxtDGnqipJc87SVd6', 1, '2021-05-14 11:48:46', '2021-05-14 11:49:00'),
(5, 'USDT-BEP2', 'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23', 1, '2021-05-14 11:48:46', '2021-05-14 11:49:00'),
(6, 'USDT-BEP20(BSC)', '0x021038ef18bb0a37a352f8975c60166c0bba160c', 1, '2021-05-14 11:48:46', '2021-05-14 11:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PHOTO, PAN_CARD, PASSPORT, BANK_ACCOUNT',
  `location` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => Rejected, 1=> Pending, 2=> Approved',
  `remarks` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `name`, `location`, `status`, `remarks`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 13, 'PHOTO', 'JDZAfU4IWlxebQUmRttxObv1ZUDoSeP87NhzyDT5.jpg', 1, NULL, NULL, '2021-05-07 13:47:25', '2021-05-07 13:47:25'),
(2, 13, 'DOC_PHOTO', 'ZWoZSgxoeWhXPugd5CGIjk2oNinR2Sk1tac7cIBs.jpg', 1, NULL, NULL, '2021-05-07 13:47:25', '2021-05-07 13:47:25'),
(3, 14, 'PHOTO', 'cqCU8XT14nQ0V1507bf0KQmVJDxSLSV2JjCw0uVq.jpg', 1, NULL, NULL, '2021-05-07 18:15:18', '2021-05-07 18:15:18'),
(4, 14, 'DOC_PHOTO', '6IWybMUYrGUR001GHGEPh3Cl1MA36GzX80C3EyFk.jpg', 1, NULL, NULL, '2021-05-07 18:15:18', '2021-05-07 18:15:18'),
(5, 19, 'PHOTO', 'X44DoE9XwjO3hNuiU10hZH1z820T1mUF3VjWZrRR.jpg', 1, NULL, NULL, '2021-05-08 07:01:43', '2021-05-08 07:01:43'),
(6, 19, 'DOC_PHOTO', 'MDKbWv5pCjMK5dIFHjJuSsjnzTPVgEmV4foNAUVM.jpg', 1, NULL, NULL, '2021-05-08 07:01:43', '2021-05-08 07:01:43'),
(7, 22, 'PHOTO', 'YIQ96w42yaHfNdgkPeDIp2nbf4AL0CZuMJxC6wQc.jpg', 1, NULL, NULL, '2021-05-08 13:46:02', '2021-05-08 13:46:02'),
(8, 22, 'DOC_PHOTO', 'tgFkSxt3Zxqnwl0gffaMeIflmua1UlaoTZ69kFSA.jpg', 1, NULL, NULL, '2021-05-08 13:46:02', '2021-05-08 13:46:02'),
(9, 1, 'PHOTO', 'r186HNXObb6OGfArUViduENuEywZEw1Ky82ROT8D.png', 1, NULL, NULL, '2021-05-12 04:45:23', '2021-05-12 04:45:23'),
(10, 29, 'PHOTO', 'bfNYGJcdxcm8FOONzaEo19orPQKmv3tuYexKQ861.jpg', 1, NULL, NULL, '2021-05-12 15:56:44', '2021-05-12 15:56:44'),
(11, 29, 'DOC_PHOTO', 'bDj0lLXPisfN8LTdpBV8XtIz73nw7dC6oBrDrV3F.jpg', 1, NULL, NULL, '2021-05-12 15:56:44', '2021-05-12 15:56:44'),
(12, 12, 'PHOTO', 'MF2Df5MHd2DdXrsPvQSZnSVpBZJZObUWSw8dqYDM.jpg', 1, NULL, '2021-05-13 06:43:25', '2021-05-13 06:39:45', '2021-05-13 06:43:25'),
(13, 12, 'DOC_PHOTO', 'Oxkk7hA63GJYMYVJwFeKuS7MRgjKYyKwkeB4y0Ey.jpg', 1, NULL, '2021-05-13 06:43:25', '2021-05-13 06:39:45', '2021-05-13 06:43:25'),
(14, 12, 'PHOTO', '2OiGyuB6lviBkc1zNeQC1ursrxkn44BjogjZ7yW6.jpg', 1, NULL, NULL, '2021-05-13 06:43:25', '2021-05-13 06:43:25'),
(15, 12, 'DOC_PHOTO', 'MieI8hcknaPo367tiinRt10kYs9rkGGqd8u4Hymr.jpg', 1, NULL, NULL, '2021-05-13 06:43:25', '2021-05-13 06:43:25'),
(16, 34, 'PHOTO', 'm83TSQvnZTeDlZIRy59IFEa4uPm9IWlqUHXJ8ntM.jpg', 1, NULL, NULL, '2021-05-13 06:53:55', '2021-05-13 06:53:55'),
(17, 34, 'DOC_PHOTO', 'RPxm8OzK71hvimpTPbGk9d7wCuMG8uPZqywcINFt.jpg', 1, NULL, NULL, '2021-05-13 06:53:55', '2021-05-13 06:53:55'),
(18, 24, 'PHOTO', '68cuUm3YOrzL0h3wFHRPkHa72WxjykyrKjjwo0c0.jpg', 1, NULL, NULL, '2021-05-13 11:02:42', '2021-05-13 11:02:42'),
(19, 24, 'DOC_PHOTO', 'YMaDZeV5l31mVaoCePdoFmTmE3EgTMpcZE5eTjVC.jpg', 1, NULL, NULL, '2021-05-13 11:02:42', '2021-05-13 11:02:42'),
(20, 38, 'PHOTO', 'FkKrhYKKqJ43eAdGQZHDLHrQIVBN36ERrMvcjw44.jpg', 1, NULL, NULL, '2021-05-13 12:09:33', '2021-05-13 12:09:33'),
(21, 38, 'DOC_PHOTO', 'VZ2zmacOGw9vbgoJlxzB374iRcUnqu1vu98tq9kN.jpg', 1, NULL, NULL, '2021-05-13 12:09:33', '2021-05-13 12:09:33'),
(22, 48, 'PHOTO', '7n7067pX4OzNwc4tcF91KQlhT8zVgi7RvnTWjfzo.jpg', 1, NULL, NULL, '2021-05-19 14:23:34', '2021-05-19 14:23:34'),
(23, 48, 'DOC_PHOTO', 'ZbeQCPa2YpwK8sfxxdkiVBX1eI9tKSM2ctvMYWmq.jpg', 1, NULL, NULL, '2021-05-19 14:23:34', '2021-05-19 14:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `email_otps`
--

CREATE TABLE `email_otps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` text,
  `email_otp` varchar(20) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_otps`
--

INSERT INTO `email_otps` (`id`, `user_id`, `email`, `email_otp`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '600043', 'withdraw', '2021-05-12 05:10:09', '2021-05-12 05:10:09'),
(2, 1, NULL, '252795', 'withdraw', '2021-05-12 05:10:53', '2021-05-12 05:10:53'),
(3, 1, NULL, '386295', 'withdraw', '2021-05-13 11:45:59', '2021-05-13 11:45:59'),
(4, 1, NULL, '899493', 'withdraw', '2021-05-13 11:48:14', '2021-05-13 11:48:14'),
(5, 1, NULL, '259047', 'withdraw', '2021-05-13 11:48:44', '2021-05-13 11:48:44'),
(6, 1, NULL, '169668', 'withdraw', '2021-05-13 11:49:26', '2021-05-13 11:49:26'),
(7, 1, NULL, '817706', 'withdraw', '2021-05-13 12:23:00', '2021-05-13 12:23:00'),
(8, NULL, 'panditpiyali61 1@gmail.com', '886632', 'register', '2021-05-15 09:27:50', '2021-05-15 09:27:50'),
(9, NULL, 'panditpiyali61@gmail.com', '683410', 'register', '2021-05-15 09:34:09', '2021-05-15 09:34:09'),
(10, NULL, 'sandiyavoo@gmail.com', '733608', 'register', '2021-05-16 03:54:22', '2021-05-16 03:54:22'),
(11, NULL, 'sandiyavoo@gmail.com', '549072', 'register', '2021-05-16 03:58:46', '2021-05-16 03:58:46'),
(12, NULL, 'sandiyavoo@gmail.com', '352544', 'register', '2021-05-16 04:19:56', '2021-05-16 04:19:56'),
(13, NULL, 'Sandiyavoo@gmail.com', '597119', 'register', '2021-05-16 04:29:52', '2021-05-16 04:29:52'),
(14, NULL, 'Sandiyavoo@gmail.com', '396923', 'register', '2021-05-16 04:54:10', '2021-05-16 04:54:10'),
(15, NULL, 'Sandiyavoo@gmail.com', '306156', 'register', '2021-05-16 12:04:39', '2021-05-16 12:04:39'),
(16, NULL, 'Sandiyavoo@gmail.com', '889540', 'register', '2021-05-16 12:19:14', '2021-05-16 12:19:14'),
(17, NULL, 'Sandiyavoo@gmail.com', '937982', 'register', '2021-05-16 12:19:15', '2021-05-16 12:19:15'),
(18, NULL, 'Sandiyavoo@gmail.com', '475420', 'register', '2021-05-16 12:27:35', '2021-05-16 12:27:35'),
(19, NULL, 'Sandiyavoo@gmail.com', '250663', 'register', '2021-05-16 12:30:50', '2021-05-16 12:30:50'),
(20, NULL, 'Shobysandi@gmail.com', '463936', 'register', '2021-05-16 12:38:37', '2021-05-16 12:38:37'),
(21, NULL, 'sandiyavoo@gmail.com', '528195', 'register', '2021-05-16 12:42:49', '2021-05-16 12:42:49'),
(22, NULL, 'sandiyavoo@gmail.com', '944448', 'register', '2021-05-16 13:10:55', '2021-05-16 13:10:55'),
(23, NULL, 'Kuhanram93@gmail.com', '652221', 'register', '2021-05-16 13:14:09', '2021-05-16 13:14:09'),
(24, NULL, 'alvinsandiyavoo@gmail.com', '898653', 'register', '2021-05-16 13:15:26', '2021-05-16 13:15:26'),
(25, NULL, 'loges23waran23@gmail.com', '608797', 'register', '2021-05-17 06:12:14', '2021-05-17 06:12:14'),
(26, NULL, 'testlo32159@gmail.com', '813905', 'register', '2021-05-17 06:13:48', '2021-05-17 06:13:48'),
(27, NULL, 'Sandiyavoo@gmail.com', '742333', 'register', '2021-05-17 11:30:25', '2021-05-17 11:30:25'),
(28, NULL, 'Sandiyavoo@gmail.com', '156741', 'register', '2021-05-17 11:30:27', '2021-05-17 11:30:27'),
(29, 1, NULL, '897420', 'withdraw', '2021-05-17 11:35:57', '2021-05-17 11:35:57'),
(30, 1, NULL, '957270', 'withdraw', '2021-05-17 11:36:02', '2021-05-17 11:36:02'),
(31, NULL, 'panditpiyali61@gmail.com', '331686', 'register', '2021-05-17 13:14:29', '2021-05-17 13:14:29'),
(32, NULL, 'sandiyavoo@gmail.com', '620023', 'register', '2021-05-17 13:56:08', '2021-05-17 13:56:08'),
(33, NULL, 'sddeva43@gmail.com', '693546', 'register', '2021-05-18 10:19:58', '2021-05-18 10:19:58'),
(34, NULL, 'thavaramk@gmail.com', '193378', 'register', '2021-05-19 14:14:05', '2021-05-19 14:14:05'),
(35, NULL, 'maravis.murlc87@gmail.com', '904508', 'register', '2021-05-20 05:42:45', '2021-05-20 05:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `envs`
--

CREATE TABLE `envs` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `envs`
--

INSERT INTO `envs` (`id`, `key`, `value`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'eyJpdiI6IlFnNm1XcGJhUXNKN25tR1lneUpPRUE9PSIsInZhbHVlIjoiU1hxMkNDdVdid05ob3FYdzhBckdtQT09IiwibWFjIjoiZjg0NjgwZWJjMDliZDQ1YTViMTc0N2YxZDJjYTg2YWExMDY1OWE4ODFjNGYzNzA5MzFiMmI2ODAxMGYyMjQ3YSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(2, 'app_env', 'eyJpdiI6IkFJTnlHcVdCM1F6cklMY0pYM29uMHc9PSIsInZhbHVlIjoiU21LT0RVN3J6b0pOVlVyUExhRWowZz09IiwibWFjIjoiNzNlMDJhZGI5YmIxMDU0ZTc4ZDU3NTUwZDA2NDJiNDgwMzZkNTI4ODZhMjgxMzFkZWRhMThjOTEwZWQ4Y2U4ZiJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(3, 'app_key', 'eyJpdiI6Imt6UTJRTGRmZmpBV201OG9uQ0kyZ1E9PSIsInZhbHVlIjoib0pkM090ZnNWeVdsOWJSNXR3dVhSam5yYytxVGJ2OUpBdEczVTdGbVpXKzR3MjVqWTYra0tUUGlyRGZBZ29vdURLbjZHcjJDWk5PM0FuTlhTVUdQa0E9PSIsIm1hYyI6ImYyZjQ1ODUzMTEyNGMxMTQ4OWE1MDA0ODQ3YjAxNzc0NzYwNDJlOGMxMzg5OGNhMmU5ZTMzMTMxNDFhOGNmMDMifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(4, 'app_debug', 'eyJpdiI6IlQ0VDM4XC8zZHMzcm9PT0VTTzFLZFNRPT0iLCJ2YWx1ZSI6IlwvZWcrQ1wvd0VKSE5iOW1cLzNJS0w2eFE9PSIsIm1hYyI6ImQ1Y2ZmYzBhM2FlZjg1N2UyNTBmOWQxY2UwZTkzYTNhZWM0N2Q5NDc5OGYxZDhlZDhkODhjOWNhNjZiNWFiNTAifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(5, 'app_log_level', 'eyJpdiI6IkhNcmxSWkRyMEpiNDRseCtCOXhUM3c9PSIsInZhbHVlIjoiVXhLeWxpczV3cVVoRys5NXFER0xKQT09IiwibWFjIjoiNDgxNmM0NTdlMmFhZjgyZjZiNjViMGQ3NjQ3NWVlYTM3ZTU0N2E1ODE3Y2FhZmFhY2FiYzIyNzE4ZTA2OTI5OCJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(6, 'app_url', 'eyJpdiI6InNqUTJBQndKb3pcL0NwUDM0MHhHd3lnPT0iLCJ2YWx1ZSI6IndoTmpOalMxb3lQQnNZSlFcL3l1aTNCUGxHNDhkWEdnT2Z3K3IzZ3lCVTBjPSIsIm1hYyI6IjUyMTcyYTM2YWQ3MGZkNzFlOTlkZDgwODVmN2ZmMDJhMjE1ZjlmMzBkZmMxMTkyZTc4N2Q0OTU3ZDU4MjQ1MGEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(7, 'log_channel', 'eyJpdiI6Ik94OXZXZWZhYnFPbEtjYlBQNVFmTGc9PSIsInZhbHVlIjoidVNFcnczRlBtR3hJNFQ4XC9pa2g5RFE9PSIsIm1hYyI6IjEwNDBlNzQyZmFlMTk2YjIzYTY2ZThjMjA4MGExMTc3NzFkZTcwZGMzOWY3NDYwMWVjNTI2YWY3ZDUwNzgyZjkifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(8, 'db_connection', 'eyJpdiI6Ik9KMXVpVUErY2RPanMyalwvYXZ5SG1BPT0iLCJ2YWx1ZSI6IkE0Zk5GTkZoK1lQbmZBTHNxVG5Id3c9PSIsIm1hYyI6IjM1MTE2OGU3ZWZlZWY0ZGVmNWFhZjNkMTRiMzUwMWJmYTIyZmY5Y2UwZTVmMGQ0ZWNiY2I3Y2Q1OGZhOWIzM2MifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(9, 'db_host', 'eyJpdiI6InhtXC9idE5NYVM2NjV1cmxybTY0d2tBPT0iLCJ2YWx1ZSI6Ill2U21KRVpnRkxvSldQditlWEVROGc9PSIsIm1hYyI6IjNmMzhhNDU2ODU4YWEyYjA2YzBjODk5NzI3ODkzMGYxMmQ4MWQxZTA1YThmY2NjODUxOTI2ZWZjZDhkNTI1OTEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(10, 'db_port', 'eyJpdiI6IjkzU2doS2pxNkZnY1BnenV1UEFabGc9PSIsInZhbHVlIjoiVnZiVzJkQjYwTlN6TExLeDBDcmFFZz09IiwibWFjIjoiYzc1YTEwMDU5ZDQwYmUwNTAwMTE0Y2Y3MzczYzMyZTcxZDRjZDAxNDMyZDRhYmUxMTNlMmEwZjI2ZDNmMzQ2MyJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(11, 'db_database', 'eyJpdiI6IitRZFEzYjVseFBFVzlJYjJhZ05BTmc9PSIsInZhbHVlIjoiWjFPZzlGdU5wY1ZRNDVKY3Irck1PZz09IiwibWFjIjoiN2YxZTk4N2Q4ZTIxYWM1OGE5YTRjMzE2ZTJmOGEzNWRmYWYwMmYxNDQ0NGY5ZWU0M2I3OTM2MDMyMWM2ZWQ4YyJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(12, 'db_username', 'eyJpdiI6ImthNjMwSUZaeStNVW5QTnlkU0NHWUE9PSIsInZhbHVlIjoibFptaGp2Y1BVSTJIcXI0bWNcLzk4Y3c9PSIsIm1hYyI6ImI0NzVhYjNiYzlmZmNlMmEyNWVjODIwMDJiZDU1OTY3ZTFjMDQ5YzJjMzk1NGU3MDllMzU2NGE5MGFmZmRmZjEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(13, 'db_password', 'eyJpdiI6Inp5dGZMS2ZUZzltS0Rwb3BEbVB4a3c9PSIsInZhbHVlIjoiOFJ2UStwNjJPK29MNzVYZnA5OEhJZz09IiwibWFjIjoiODAwZmI1YTliODA1ZjYzZjIzNDFiMGFkZDRlYjFlMDExMzg5NjM2ZGI0NThmYjA4NjhhNzJiNWI4MWU1Y2JlNSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(14, 'broadcast_driver', 'eyJpdiI6IkZWelhTZWU4bG5iV1ptcmhibWl0N2c9PSIsInZhbHVlIjoiMU1RYzJ2aTZcL0dzck45Mk14ZXpyR1E9PSIsIm1hYyI6IjExNDM3MTI2YWFiYzRlODBmYmUyOGE2NTdmNzg3NTEzMDMyYzVmZDkxNTM1NDQ0OGZiZWYyNzQ5M2UxMzhmZTUifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(15, 'cache_driver', 'eyJpdiI6ImtBcmJkeHJjcHpaRGFNYTVwZXR6TXc9PSIsInZhbHVlIjoidWtoZE1iOFZxVjlnYlN2WUJ4VWQyZz09IiwibWFjIjoiZWE2YzJhZTIyN2QxNDk2NjAxYTA5ZjIxYTdjYzM5ZjQwZDMzYmFjYmM0NDU5NTNkYTY1ZGI2OTFmYTUzN2NmYSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(16, 'session_driver', 'eyJpdiI6Ik1DNW51RkpuaFE4QWdyenhJXC9aZ3BBPT0iLCJ2YWx1ZSI6ImV4eXJOWFdrVFVudVBXc28reXpkN3c9PSIsIm1hYyI6IjNlODZmMGY0ZTg5YmU0MTY1MGEyNDE2MDJhZGNmYzNiMTBhNDc3ODIyMzI1NmJkNmYzMDYxN2M5MzViN2ZmM2QifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(17, 'session_lifetime', 'eyJpdiI6IkU2WWtSejVnQ0JWeVwvR3VCcjJXZU5nPT0iLCJ2YWx1ZSI6IjBjS1UydkthUmxjNk5BcUJpaFZJSHc9PSIsIm1hYyI6ImQ5Mjg3NDI5NzIyNGM4YTRhYjkwZTVjZDI1MTcxNmZiZTk2OGE3NGM3ZWU3NmZmOGIzOTY2OWRjMjVjNzdhNzEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(18, 'queue_driver', 'eyJpdiI6Ildua25iSWlLaUZ5QTJ1dlBkRXFGZ3c9PSIsInZhbHVlIjoiMkgxTVwvTXg1SVwvbURWNDFaZHpuaVJnPT0iLCJtYWMiOiJmMjUwZGRmMmVkZjY3ODNmOWYwMTgxZTM1NDcwNmQ3NGQxY2FiNjExNTgyOGU4YTgxM2FkZWJmZGJmZWE0OGQyIn0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(19, 'redis_host', 'eyJpdiI6ImJGMFFGV0x6UGpSdUxiN0RhaUZTR0E9PSIsInZhbHVlIjoiQ2RLbFR2T0taSVM3b2w2anNmTGVjZz09IiwibWFjIjoiNDExYzQzNWNhMmM2MTA2NThkYjI1YWJkZDVlZDljMzJkNDQ2MWVlZmI0MmY4OGI3MTM4MTNmODI0Y2UyZGRmOCJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(20, 'redis_password', 'eyJpdiI6IjJoT2lKdVVFbmIwazF3cndITVNsUmc9PSIsInZhbHVlIjoiMHA4OHdIdVwvcGVNRTdEMkdnY01PR2c9PSIsIm1hYyI6IjgxNDRjM2QxNWJmOGQwMTAxMjE0MWZkOGEzNDk0ZWIzMGM5N2U3MmJlODdhMThkY2U5MWZkMmE4OWY1YjkzZGQifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(21, 'redis_port', 'eyJpdiI6IkdTNU9FSGVxSjZCVndPaWtMNWcxaVE9PSIsInZhbHVlIjoiUWxwUnI4QUFIdFllVE5QYStPVlZ1dz09IiwibWFjIjoiY2NmMjBhY2E4NmQwODBmZTJjM2M1NWZjNWFiYTY1NGJmZjZjNjA1ZDU5ODg4NGMxNDBlZWI5NmY0MTNlYzdiZiJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(22, 'mail_driver', 'eyJpdiI6IlRhNDQzRnA3VlBGVEFGckdPc29iTVE9PSIsInZhbHVlIjoiV1pObko3R040a1Nmc0hQTHZTeUQwZz09IiwibWFjIjoiMjQ2ZGRhNmY1NmZjZWE4ZmIyOTA0N2JkMDNmZjMwNWRhMTc4N2Q2N2Y4YzZlZjg2YmIwNWE4ZTFkN2ZiOGY4YSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(23, 'mail_host', 'eyJpdiI6IjNIeXduc2Ria2hwd1BHWmJUQ0lsTkE9PSIsInZhbHVlIjoiS3JBSEFtVWpSNDFQWERyMFRURkRKUTh1a3Rkb3loVWlwazlTQVZQK1ZHZz0iLCJtYWMiOiIxY2ViMDAwYmUxNzA4YWNhYjkxODE0ZDg3NDY4OTZjZDhjMTc2OGY1ZjZlNWU2NGQyMWI0ZWUzMjQ0ZTY3MGZlIn0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(24, 'mail_port', 'eyJpdiI6IjBcL25mSmJMV0tENDhvWkRyZWx0MytnPT0iLCJ2YWx1ZSI6Ik9YY1ZVU09rYmlUQktxanVkWmxLaUE9PSIsIm1hYyI6ImY4NDE4MWU1ZThjMmM4ZWQzMDNmNjVhOTM3NDdiZTBmNmJhZTQ5ZGQyZWVlZDNkMGQ4NzAzM2UxZWFjZTgzMmEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(25, 'mail_username', 'eyJpdiI6Imd1b014S3d3cU42TWpsaldJOStwQ2c9PSIsInZhbHVlIjoicGFkSVMrRFY0SG93Rk9SaXFDYmJOdz09IiwibWFjIjoiYzczZWYyOTk5MTlmMDAxMTFmMjUzMmEzMmY1MWM2MTdhZTcxYzE3ZDBjYWIxM2ZlZDg0YjdkOTdjZTRjMjc1MCJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(26, 'mail_password', 'eyJpdiI6IkttTHlYTEE5bzJaVU9ZNmZJclhSYmc9PSIsInZhbHVlIjoiWklLWUxpVTlFRElZblB5NUNjbWZmSTRlWVNZVFViWStXMkg5M3hmR2tMclBpR1U5aWp2NEFMeE5Vd25ZTGhhU0dVc3dXNEQ1VWVnSTdZWHF0dXRPQWhWbGxnUGx0MTg4MWRKbjJtaE5cL3ZrPSIsIm1hYyI6ImQ5Y2I3NDU0NTM5YzNiMWQ0NzkzNDBjMmE3NWEyODA4N2JjODM4MTRkMGQ5M2M5ZWQ4YjNjNDhiOGRjMmQ0MjEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(27, 'mail_encryption', 'eyJpdiI6Im9Gd3RTcnRmdU9sck1vRG9jRTZUb3c9PSIsInZhbHVlIjoiUkwwMVJlckJLN3p3S2l0Mkx5UHRVZz09IiwibWFjIjoiNGZkZWRjNDQ3ZjhjYTc5NGRmMzQ2Y2E2OWYxMmFjYTdlNTI5MGJjMTBmZWM0ZTE4ZmQ0ZTIwZTk1NWY1MTY1NiJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(28, 'pusher_app_id', 'eyJpdiI6IklydExIUzVGSFFVZVh5QlA2VHA4d2c9PSIsInZhbHVlIjoiYmhZS1lmNERmNElmdEtwMTdQS3hUUT09IiwibWFjIjoiMzVjMmRjYTE5MGMwZWYxYTM1YTE4MzNlNTllZjY0ZWQ2YTcwYzNlMjJkNjYxMmZmZDhlZjIzZGI0Njc3OWM0ZSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(29, 'pusher_app_key', 'eyJpdiI6InJEaWlmWkN2RkhPVkFYUTJyQVwvZ3JnPT0iLCJ2YWx1ZSI6IlVrZys4R1FjTEJ4c1NXeFdhNFdcL2hBPT0iLCJtYWMiOiJiODc2Y2VhNTc2OWRlMWEyNzJmMzgyZGJjZmU2MWRjMWQ3MWVmNTU1MmMxMTYxMWFlNjk1OTUzNGI4ZGNiMTQ1In0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(30, 'pusher_app_secret', 'eyJpdiI6IlBPcDJTZTBwNmIzU1wvSURmbm1jNFNRPT0iLCJ2YWx1ZSI6IlJ5aXh5YmtQcXB1ZzhtaHRibW1vc2c9PSIsIm1hYyI6ImJjZGE3OTZiYmVkYzk4MzkyMzJlY2NiYWFiZmM1NGNjYWQ3MjE1MmRkY2Y0ZDAxODlkY2Y2OTQ1YTYyNGYyY2QifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(31, 'pusher_app_cluster', 'eyJpdiI6IkpzaVBPUDZYWURLclhLa2tIYmxCbXc9PSIsInZhbHVlIjoib0psTFMzcmRXQXF0dnJrOERwZWJOUT09IiwibWFjIjoiMDU0NTVkNWNjZGQ4NDQ3NTVkYzc1Y2Q2MGI5YTZmODQwZjQwNmE1Nzc4YmJhMTlkZjlkZWVkYzM5NzQ3MDQ2NSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(32, 'coinpayments_db_prefix', 'eyJpdiI6InlIdVVXRkluTUc0RXJQUzZ1eitBN2c9PSIsInZhbHVlIjoiVk1PK0hqdzd0a25GdlNJWEhpZTRkUT09IiwibWFjIjoiNzEzZjdmYWIyNWZmYTBiYmUzNThhNTM2MDRkZmFjNTUwNDI1MDAzM2JhZmFiZGNmNzMzZjUxNWJhNGRjYzYwNCJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(33, 'coinpayments_merchant_id', 'eyJpdiI6Ik45VDhwQkZ5XC9ZeFwvcTRiR1d5a01uZz09IiwidmFsdWUiOiJRTURBdHFiUG1IaHJqR1dGVVAzVlhOT2pRTW5MNDExQ0VNcmkzZDhiNitOU0IweVwvODdGdklLQk1CTFdtVEpQbCIsIm1hYyI6ImJhMTU1ZWQzODUzYmQ3Mjk0NWQzNjNlMzE5MDI1NjhlNjgzNGRlZTNhOGQ4ZGQ3NGY4M2NmODQ2NTI0N2U5MjMifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(34, 'coinpayments_public_key', 'eyJpdiI6Ik5HZ3BpY0JLeExpc0tqaWNYbkVvaHc9PSIsInZhbHVlIjoiSHhoN1JrTlwvMGdcL0FYYktRZGh4VlpyYVBvVFFJVnlvN3JMdGhtT0djcU5UQk9Vc3ZmWGVtcmpBM01CRGhxRUgzNjNkdHZ6eCtPUVZwK0hHZzJFbWtMMW5MWFVERTk2OUVsMDZcL1dOR0RwcDA9IiwibWFjIjoiYzBlYTM3OTk2NjNhMGJmMjM0MWUwZTQyM2JkMTgzOGQ1NDU3YTM0OWI1MzliNTJkM2I5ZmIzYzI3YmY5NTRmMSJ9', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(35, 'coinpayments_private_key', 'eyJpdiI6ImQ1amhFTjZ5REVUd0g4emNYR2lmSlE9PSIsInZhbHVlIjoicUNpQkwzdXU3XC9nUFJcL1FcL1c4YUxVV1BGNUYycFRVaFU2NURnNWFGVWNaQlRhMUNVeU1uOTdSbEVWQUpNUE9waGJ4WUxoMFNHcDFQWnV0V1RBMVFFd05NYnlQMXNKalFcL201VFAwNTFtTXVBPSIsIm1hYyI6ImYyMzVlZTQwZTA4MzNjOTU2ODNiNWRhMjYwZjQxMzQxOTdlNjdlNGI2ZmU4OTMyMGU5MGNiMTc3NWVlYzhkMWEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(36, 'coinpayments_ipn_secret', 'eyJpdiI6Ikdna1JRU3JEK0RPS2VFYjlaY0piSUE9PSIsInZhbHVlIjoiSUNRXC9iSlI5ZVVPRzdCNFwvVThtbkpQUHNrMUtMdnl2TUFMSHNuZDRLamE0PSIsIm1hYyI6Ijg1OGM4NmExMzUzZjU4ZWU4MmYxNzhmZjgyMTA2MjYyOWY1OThlMDE0ZTBiMzhjYTdkNjk2ZDVjOGQxZjM2ZDEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(37, 'coinpayments_ipn_url', 'eyJpdiI6IlBPVktBaVkybm5kckpDUWxSNW9IR1E9PSIsInZhbHVlIjoidFA5N2NGbUhrb3RCSGxSVk1LZFdzS1FRM0hDU29wM0R4am4wbkk4aE5pVlptK2RtYzRyQVlYTFlQaHpnU3NVaXlibEo3ZWVFaDI5SFQ0anZxWllGdVE9PSIsIm1hYyI6ImVhY2FkMDdhZmRkMzRjZmNhMzljM2UwMzcyMjIzZmEyYjUyZDIzYmJhMTBlNjc3MGNhY2I3YmEzMTA3YTM4YmQifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(38, 'coinpayments_api_format', 'eyJpdiI6InY3MHg0UFhmMzhWUnZHMUs3OW1YZ3c9PSIsInZhbHVlIjoibUExYjVTRW5nSVpRMHlacjdXQkJcL1E9PSIsIm1hYyI6IjI5NGMzODQ0Zjg0ZTEwZDdkMjgwY2IzNTUwMmQxMWZlZDZkZGM3MjMyNzQxOWE1OTcwZmEwZjc1NzllOTlkMzEifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(39, 'paypal_mode', 'eyJpdiI6ImgwU0tQb1RGTnozbTNqcGRaN0wrZ2c9PSIsInZhbHVlIjoiXC8rcVlxeFNHN0dZUmg3NURDN1wvSG1nPT0iLCJtYWMiOiI5NTI2YmYxM2VjZTJjZGUwYzU1NmM0N2ExZTBkYzczNTk3Y2JmNDg5ODFmMTQzMWUwOGNkOWQ2MTg0NDA0MjU1In0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(40, 'paypal_client_sendbox', 'eyJpdiI6Im83Y2NhekQ4bkZMd0F0emhNeFZwMXc9PSIsInZhbHVlIjoiM1oyZUlXT2pacGpmM0pOeXIwenlwNjNjZ0NiT0dqcU16czlVeHJJc29teFpRVVwvaXp6aUpldjUyTndSQ3JPSmRzMkl3ZndmM2hocUloOWpvWCt1OGkxczBETzZ0SVwvRE1maUdyNno4UUp1SVlibXlROTdHXC8xamlsd1AyYUhOeUYiLCJtYWMiOiIyMTkyMDljYmJiYjBiZjU3OWRmN2E5M2E0MWVhYWE4YWY3YWU3MjJjMzYzZjY5ZTAzNTI4MzJlZDQ5NDM1ZTY5In0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(41, 'paypal_client_production', 'eyJpdiI6IkdZUzNoZE0yY0ZPOVlRNG5FMGozY1E9PSIsInZhbHVlIjoiekltUlwvV2s3dDZwMWNRaG1qMm9reDRmZGFNUVJTR2R6cFFiTFBXdXVBUHRETDVpUzRvNjVseG9Wb0ZOMTBsOTdYK2N3V3ZCejF2bm96ZXd5NWUwMDdsN0lCVktEZElTYXpyTXpab0Y5b0p5R1p3XC8rVWU2K2s0Y1BIWERcL2ZHOTEiLCJtYWMiOiI1ZDM0NDNlOTRjZTc4YmM5OTlmNzIyMTg3ZGYxNGE5ODg1ZTFjYTUzNTZiZDhlZTY4NWU3MjhiYjg0YmI0NzM2In0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(42, 'token_name', 'eyJpdiI6IlJaMWFUT2NWMzNFRXE5Ym9cLytBN1wvUT09IiwidmFsdWUiOiJwMVVmOHBYMHpjYWN0VnhoSWNYMjh3PT0iLCJtYWMiOiJjMWNhMmE5YmI1ZTEyODI5YTA2MzE2YWZmODQ2ZjExNjUyZGQ2MmZhNzMwNWIzMjZkMmU2NjE4MDc1ZjJkNmRjIn0=', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(43, 'token_symbol', 'eyJpdiI6IkY0WG5pcXAxREdCd3M2M2JkaVRkbnc9PSIsInZhbHVlIjoiXC9xOWpCcDVhbUd1OWpZK1JVV1RDeGc9PSIsIm1hYyI6IjhmYjdhYTgyNGNmY2ZkYTE3ZDhhMjA2OTI2NjBiNmQyNGFmMzQwYjVlY2Q4M2UyNTk4MmZjOGMyNjZjNWJlMGQifQ==', 0, NULL, '2021-03-25 17:24:43', '2021-04-22 12:36:14'),
(44, 'app_name', 'eyJpdiI6IkdEQTVDUjRKUUt6ZXlTb0pHeHA4OFE9PSIsInZhbHVlIjoieUhmMGRCYXNSUzN6R2VWc2w3eDFkQT09IiwibWFjIjoiMmM4YmM2MDdjMmI0MzIzYTgzYTU2ZjRmOGIzMGI0OTdjNThiMWQ0NzdiZWU2NTYwOTQ5MWZlNjA0ZmMzNDcxYyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(45, 'app_env', 'eyJpdiI6IndLcGl0NzlXYVZKZTQxbklPN1h6Z2c9PSIsInZhbHVlIjoiOG5KdER2K1Npb1lmNHl1NytUZ3ZTZz09IiwibWFjIjoiY2JlYzkwMWY5YTRiZDAwYzViNjliMTEwYjVkNDRmNGEwMDA2N2EwYTZmMzQyODVhMGIwMzI4NTRkZWNmYmNjMyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(46, 'app_key', 'eyJpdiI6ImM0cUhmUFJkUFFTdVpyRUVlNjYyRUE9PSIsInZhbHVlIjoicEZBaGZ2ZktJbEhqYmk3a0FXOFk0YlJmVmtqdzljTXB3MnN6RER0TFhuR2ZnaHkrYlcweEhsQnFPS01zVGh5M0VtN2tmTTZkQm1LRzUyYzFMTnFDOGc9PSIsIm1hYyI6IjIwZjU2ZDcyMmQzMTFmNjkyY2Y3ZWU2OGY2YmMyMjhjOTYxMDU3Nzg0MGY4N2YzN2RiNTE1YzE1M2M4YzlmNzUifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(47, 'app_debug', 'eyJpdiI6InU1cndsMnBJY0x1Q2VSQjlOTHU0Snc9PSIsInZhbHVlIjoiakwrWDV2XC96VHExQThDZ3A0clNlNXc9PSIsIm1hYyI6IjQxZWNhMjQwMjU1MTMyNWFjOTMxMDRlYmZlNzcyNDI3OTZlZmZmYjZiMzg1YzllY2JhYjg2YzEzNjI2MTZlOGMifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(48, 'app_log_level', 'eyJpdiI6Ik1JUjlkSHFmQ0YzakZBSldjQno0YUE9PSIsInZhbHVlIjoiRlMyY2JURjdlUkVZSkxBYlhFR2lLUT09IiwibWFjIjoiMWYyNTVmMmUzZGVhMjlmNzBkZWFjNmQxYzkyODA0Mzk2ZjRjMWNmOTEwMGUxMjU2NjliMTBhODNkZjZjYzA4NiJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(49, 'app_url', 'eyJpdiI6IkFFQjF1TlVZSUx1TVc5SEplb2oyQlE9PSIsInZhbHVlIjoiZGhZYzJlYmd3d0hQaU94eDdlTHpkdHNEZ0xJT0FKOW5aM1JPY1laNHZyWT0iLCJtYWMiOiI5NDYwMjQ3OGJhNDUwN2VhYzVjYWFkZDViYmExYzViMTk1YjljYTA3YTg4YjIxNTE3NGEyZmFhY2VjYTQ3MTY2In0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(50, 'log_channel', 'eyJpdiI6ImJrNjdFWWVyRXc5WDhXWVwvSlhMV2pnPT0iLCJ2YWx1ZSI6Ik5GMUV3emJTemFOTm5wYjFDQUN2VGc9PSIsIm1hYyI6ImFkNWJiOGZjNWVlZDkwYzY1YjBlYjExYzgzNmI0NjRkYmFlM2M4NzQ0ZjA4ODIyYmZiY2JiMGMzMWE2MzE4OTgifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(51, 'db_connection', 'eyJpdiI6InIzSVRvU1JUcDJ0MXRJME1aVzhGN3c9PSIsInZhbHVlIjoiazhVWFBVVEVDQWtmUEZYSzZhVWdqdz09IiwibWFjIjoiMjc1MTQ4OGFlOWMwNGJjNmU1YmYwNmFlODNhOGQzOTdkNjU4OGVmOTE0OWJhMjM5YjIzMmZlYjZmMjFhNzI2OCJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(52, 'db_host', 'eyJpdiI6ImhEMWFXOUN0cTA5dUVvUm11WUtEU0E9PSIsInZhbHVlIjoiSVZOQjFDUTBBWXJIdlJucGZtR05jUT09IiwibWFjIjoiZjI3MDllOGE5M2ZiZjg5NDlkOGJkNWNhNTEyYzgwMjhkODE2MTFkNDk0NGQ0NjQwMGE4ZTZmYjNlZDZkZGI2YSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(53, 'db_port', 'eyJpdiI6IkxwclhlTUJXUTJmc2IwNGFFb1hTQ2c9PSIsInZhbHVlIjoiQ3VDYnJMSEtrTllZT3pnOG1aaFlWUT09IiwibWFjIjoiMDQyOGUwYmI0MDgxYmJkNWY2MGY2NzA3YTRmYjQ0ODUyZTZjNDI2MDk3ZjQ3NTY4OWY2NDFhNzljOWQxMzY1MyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(54, 'db_database', 'eyJpdiI6ImpIS2REUldLMDgwNU1xazJDck03SEE9PSIsInZhbHVlIjoiRGVyVlpJVGRsNEZXaFB2cnBHdzhLZz09IiwibWFjIjoiNDBiNzI4ZTI3YWUwNWYzMjMyNTFjMWQ1ODg3ZmFjMzI5ZGFkMTI2NjllYWJiYmZlNTAyNzI3NjZjN2RkNzQ4MSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(55, 'db_username', 'eyJpdiI6Im1BY0UrUnZWaFlCZkNiNG5GOCtuRXc9PSIsInZhbHVlIjoiSlwvU05UakUrbEFmOThrRVRYTmMzVmc9PSIsIm1hYyI6ImY0YWQ5ZDE5YjgwM2Q2N2U3MGE1MzgxZTE1M2EzNzBlODM3ZmEyMjgzMmY3N2NlYjFlNDcyMTlmNjFlYmZhM2IifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(56, 'db_password', 'eyJpdiI6IlVJc1U0NitkYmxyK0hYSW9zR3V6MEE9PSIsInZhbHVlIjoiQWZIMHVKcGo5bjBIbjdSSHNhd2lIQT09IiwibWFjIjoiMGM1NWUxZDhmZDE2NzczNjg0ZmMxYTEyMjBkZGQ4NjYxOWEyYWZiYmVlMWUzMzgzODc4MWMxNmQ3MTYxNGE0NSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(57, 'broadcast_driver', 'eyJpdiI6IkNockpmMVlaQ0ZlSHhvRlNLbmFnWHc9PSIsInZhbHVlIjoiV3U5UVAzODR5NVR2alhnTXBRM1R5UT09IiwibWFjIjoiNWVhNjE4MTQ4NGQzMTRiMzQyZGNjNGUyYzBlNjBjOTJlYzE4Njk5NGZmNTRkM2ExZTcyYjk4MGIwYzQ4NTA5MyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(58, 'cache_driver', 'eyJpdiI6ImNqQkx2eWZUdDBuMkpmM1dJeWpUelE9PSIsInZhbHVlIjoiNVBLWlF1UFZBRks0dCtkZnNhMGdQZz09IiwibWFjIjoiNDdlNmMwYTkzMjRlZWRlZDBhYTk0NGUzY2E2ZDRhNWVmOGQ2MWQ2OWMwMDE1MDc4YTY2MWMwNjk1YjBiNDc1NSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(59, 'session_driver', 'eyJpdiI6Im9YYTJ0QndtN2ZhY2xXRHhZYWFMSkE9PSIsInZhbHVlIjoicDVvYzVsU1wvOW5nVmt3OTdFWFcxNmc9PSIsIm1hYyI6Ijk4MzJjNGExODRhYzk5NmYwMDdmN2YxODg4OWE4ODkxMDU0YmI0YjRmNmE5YjM3NTQ0OGQzN2NiOWYyZWZhM2MifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(60, 'session_lifetime', 'eyJpdiI6ImIycXdJT1lYS1FDSGJUVENFd2tBaWc9PSIsInZhbHVlIjoiZzRqRDdDVWV1OEhmNXhYUk5RWnp0dz09IiwibWFjIjoiM2M2YjdkYWM1NTRmZmViMGQzNjM2MDY0OGQ4MjZmMzAyMzA4YWRmYzIwYzFjYmZlYzIyYzljMWVkYTJhOTIyMyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(61, 'queue_driver', 'eyJpdiI6IlhTendUdEhiZGRZZFZvM0VuWmlncUE9PSIsInZhbHVlIjoibk8yM1VrNzhhQkNMQnhQdWlCSDg1UT09IiwibWFjIjoiMDAxYWY2M2Q4ZTgzYTliOTk3MTc4ZmUzMWMyZmVkYWZlYjEzOGEyNWFjYmJkMmM0N2U1YWRkYWI5ZjMzMjJmYyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(62, 'redis_host', 'eyJpdiI6ImZLVm5oS2RIa1V2RG1MVTJTRHF2aFE9PSIsInZhbHVlIjoiQXltTDBpSUpXZnVwKzAyNmtWeFZrZz09IiwibWFjIjoiYjQ4MDkzZDlhMzI5OTA5NjE1NzdhNDJiMDE4MzRlZWQxYWU3Yjg4NjRkNDBlMTQyZTVmMjJiOGRlNWY5MTRmMCJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(63, 'redis_password', 'eyJpdiI6IlFpVzZKV1pvemNpYW56U1NFUHpGQUE9PSIsInZhbHVlIjoiUXNNVTh3QVwvMzFSdEFWbG5zV1FybWc9PSIsIm1hYyI6ImQ2ZmU2ZmQ1ZGJhMzQ5ZWFhMmJjNWQxYjllMDc4YjRiNDk1ODljZDU5NTBmODkzZTM1ODBjOGZkZDZmNjAyZGUifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(64, 'redis_port', 'eyJpdiI6ImxPOW9OSDVDdVdcLzdcL1lcL1RPTHkzWnc9PSIsInZhbHVlIjoicHZCRzBYMkdZSzFWWGJFT3RkVEdRUT09IiwibWFjIjoiYWVjM2RjMWZjN2ExOWRjNjVhNzhiYjI1ODUyNzAxMGU1ZDdiNjcyZGE1MWEyN2E3YTg4ZDhjYmIyMTZmNTQ1ZCJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(65, 'mail_driver', 'eyJpdiI6Im5BbHNqV2tOS2ppSUlVWWZvR2h3MVE9PSIsInZhbHVlIjoiQWM2Qk5UclJubzRqOE5kT1M0VUtyUT09IiwibWFjIjoiNDg0MmY2YmVkMDYxMzJjY2E0OTc4ZmY4NmNlMTllMzQxYmQyN2M5M2M3OTY4NmE4ZDEwNWY3NTlhZDliMjNkZiJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(66, 'mail_host', 'eyJpdiI6IllGVUhBZ0hUVGpGVVVCeVhoMVZ6MVE9PSIsInZhbHVlIjoiVGUrdDVBS04wek9Qa3NVYnd2U1hUeTBobkVDOXZIamgxYVNSVXIxcHBucz0iLCJtYWMiOiI0YmI0YjZhNjdhMmU0ZWEyZDRiMTk1Nzk5MDUzNjk4MDFmZWZjZjNkNTNlZTc1NGYzZjg1YTUwMTc4Y2FlY2NlIn0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(67, 'mail_port', 'eyJpdiI6IjVkUWlKZXp5TmhyN3BIbUtTUlU4WHc9PSIsInZhbHVlIjoidytUVnBJSTd6YW0zYTA5dUJiaFNDZz09IiwibWFjIjoiOGFhYzc2M2Y1Y2ViNzAzNDcxYTY5OGJjZTQ4NWJmYzAyOWY0MjMzMzhmNmYwNWIzNDNmOGM2OTM2NjJkNzM5YiJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(68, 'mail_username', 'eyJpdiI6Im03eTczXC8zdmZ3REJ5QXg0RzB5b2NRPT0iLCJ2YWx1ZSI6IjF1TGlcL1ZObnhzdk82dG4yNFwvZE10VUJuTkRsRHMxclJhSWdvTzMzcmR2Yz0iLCJtYWMiOiI4ODE3MzM1MWZlY2EwNzcyNzgyMmM1MjZhNDYwZGNmM2Y5YTA0NWI2ODVjZGFkYzgxOWI3NzBmYmQ1ZGQwNGFlIn0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(69, 'mail_password', 'eyJpdiI6IjJLWmY2YlhqU1hxbjY3RlZLMmZmVnc9PSIsInZhbHVlIjoieUY5clkrNDdKQmdOcE1mcG1saitjWW5JQThFazdiV0ZLbFpmd2FtUHdOWGJ2cVwvazJ2M0x1aGU4V0xSRmYzNXAxTnQ5eUk2UXR4TjFITW11eFlrOVNmOGlnbGFobGRwRG5Yam9ieTVmV0RRVnhHRWxTbGNmMVhyUDRVTWFoNTdYIiwibWFjIjoiZGRiMzVkZGI4NGNmODNmYzdjODE0YjQyODBjNzAxMjlhOTk4YTc0MGJlYTYwNDVjNGNjNmE2YzdkM2Q0YWFjMSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(70, 'mail_encryption', 'eyJpdiI6Ilc3SlFBaUJ4ZnNxVlYyWW1aQlwvSjl3PT0iLCJ2YWx1ZSI6IldKdlZDNVo3UDRBRWRoYTVrR1lGaHc9PSIsIm1hYyI6IjVlNDkzMjBiY2VlY2U0YzcxZWI1YTU0ZDE1OThlYjJlYjYwMjg5NjA1MjhmNDA3Y2UyMzkyNWIwZDA4ZGI5NjUifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(71, 'pusher_app_id', 'eyJpdiI6IktEYjNOUWVKcFprRmpLQ2x5T2wyZ2c9PSIsInZhbHVlIjoiQmlkY1dVVEtGVExiK0VBTjdlMllqUT09IiwibWFjIjoiODJiNWIyOWRmMjMwYWNmZGMxZmVlZDA2OTIyZjQxYzY3ZjliNjhhYjRiNWY0ZWQyMDA1ZTk5NmE4OTE0MDkwOCJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(72, 'pusher_app_key', 'eyJpdiI6IncwUFY3WnJ5b0NcL0orczJIVnVhZ21nPT0iLCJ2YWx1ZSI6IjJRbVNTd3d6VDZSN25WRndHdE52RGc9PSIsIm1hYyI6IjQyMWViZGEzMmM3NGRkYzllMzUxYzlkMDgzMDkwMThkZWZiMGE4ZjNlOGM4MzY2MzA4NzYwNTg3ZTE5OGE0MjQifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(73, 'pusher_app_secret', 'eyJpdiI6InZnY0RRWnA1c3lPczE4Z0piOFZuQXc9PSIsInZhbHVlIjoiSlBVVis1OTRPZVU1YWlyMkpkWHBLdz09IiwibWFjIjoiYWViMWZiZGQ3NDMxOGU1MzQxYWM1OTVhZmQyMzIxYzY1NWY0MTI5Yjg4MGQ0Mzg2NDFjZTIzM2M2OWU2YWQyYyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(74, 'pusher_app_cluster', 'eyJpdiI6InNRcW4wQW1KbVl0WHk5enhWaU9uaGc9PSIsInZhbHVlIjoiNHI5U1NwbUh0NjJ1QitjMDlOdnNsZz09IiwibWFjIjoiN2M1NmFmMTM4MGNjMzczYzA3NmQ0YTM4ZDMyNzUwYTQ4NjVhYWE4N2RlYWQ0Y2UzNWMwY2NmNzJmNWIzMjg0OCJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(75, 'coinpayments_db_prefix', 'eyJpdiI6IklOUTJVVE5hZWJBYXNzYm9QS3prMGc9PSIsInZhbHVlIjoiRlhaNE9Db3orQ2VZVXlCM3Rva1VWQT09IiwibWFjIjoiZTg2YzQ1YjI3OGQwNDRjMGM4Yzk4OWIxMTU2NDQ4NDkyZWRlMDhiNjFlZTc1MjRlNzkyYmY1MzQ5NTcwOTllNyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(76, 'coinpayments_merchant_id', 'eyJpdiI6Im1SRGczQmp4MTJIMDVYWklKZFhwU0E9PSIsInZhbHVlIjoicUd5R3Jta3ZmS2lDREJzTk53SGVtdzZOWUptdUxDVURXYWJmQ3REZ3dJOEo5QTJRQzNKMlZjZzY3U0RvUWx3QiIsIm1hYyI6IjdmODM4YmI5ZTRlZDdmZjBkMWZiODIyYmQ4ZjNiODJkZmQ5ZDE4YmZhYWNiY2VkYzFkYzU4MjhjZDIwYWQ3MjQifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(77, 'coinpayments_public_key', 'eyJpdiI6Ikd0MU5lZWFhXC9UdWZQeTg5MVBvaERRPT0iLCJ2YWx1ZSI6Ik5jbE9qWE9ZTXlJa1dQdGdrXC9hcVphaFwvdVpUZ3pQMjZwMUVSckZaSmdaOWFMRnBXSHRsQjlackRqNXhRcjBaRmtaYWg4UWhQdUl4cXIrakdiZURzWHRlQTFjNENmdFwvWExWRnQwaE5zcG1rPSIsIm1hYyI6IjEyNGU4OWJhMmQ0OWFkOWM4OTUyMGI1ZGZkMTI1NzA5Y2U2NjI3OWVjYTRmNWM4NDI0N2NmNTdmMmY5NTZjZDEifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(78, 'coinpayments_private_key', 'eyJpdiI6IldJY2U3RDRBblFTeXc0WlBIdzV0Ymc9PSIsInZhbHVlIjoiU3lVVllQZnBuRE5laE1HcXdJbTdtcTI3MzRRZytmQUU0U2l4OUVTSE12c1NHNUlHdmVyOHBPWlU1eTRcL1FlWGNGOTRLZUJQUTBRelBEc0E2XC9TOGEybUNKMHdhSVN0OWR2d0FPOHM3dWx2ND0iLCJtYWMiOiIzYWEwMTIzY2Y0YTNlNDVlOTA4YTc3NzUxOGM2MDIxYWY3MTBlYWMxZDY0N2EyMmJmZTg3YTQ5Y2I1ODk2NjIyIn0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(79, 'coinpayments_ipn_secret', 'eyJpdiI6IkVhazY2bjRWU1ZmMXNNMExIU0UzUWc9PSIsInZhbHVlIjoiS2hMWE15TGtNdUI5XC9OTkZNNWVrMnE3NHI2ZzE4ODRiVEY1cU16ZXpGczA9IiwibWFjIjoiY2RkMTFlMDVhYWNhOTgwYzQ2MzlkM2EzMTU4NjNhYTk5YjY3OWU5NDFmZTQzNzM0ODg1OGFjNTk3NGQyZDFjNSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(80, 'coinpayments_ipn_url', 'eyJpdiI6IkdXV09PU0lvRHkwTkl3YU9XeTRSakE9PSIsInZhbHVlIjoibzFBS3BDZmNQZzQzTmY5UDloV2N5S2tjdElGc2VxRFZIM1lBR2grbUt5U1pJTlwvZU9kTjZCT05hNERBT3lGV1UiLCJtYWMiOiIyZmQyYzQxYzMzZmM2MWRjYmUyMDUyY2FhMTU0YjkzMmIwMjBmZjJkNDU4NDUxYjIzYzk2MmM5ODIzZTYxZWQ0In0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(81, 'coinpayments_api_format', 'eyJpdiI6IncrNnA5MTFhN1hqSExYcllnUllyaVE9PSIsInZhbHVlIjoiZEo2YjB0YWZRUHNOalN2ZFo5cmZRZz09IiwibWFjIjoiMDAzM2Y3ZGQ0MDkyOGY5NGM0NDRjM2FhMDIwYzRhMDUzMDU5YjgyZjhkNGFhNjQ3MDMxZjMzYjMxMDk2ZDdlOSJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(82, 'paypal_mode', 'eyJpdiI6ImdPT2VvU3BpTVFlMWRmVk1cLzdIeVB3PT0iLCJ2YWx1ZSI6IjdsQllkbDJzSUZKQmFXc24xaGphTWc9PSIsIm1hYyI6Ijg1MjkwMWUxM2VhMjVhY2VhOTQyNWEwNDhjYTQ3ODA4N2M2MzcyMWEzZDJkZjBlNDMxODcwNjE1ZmE2ZTk2ZDgifQ==', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(83, 'paypal_client_sendbox', 'eyJpdiI6IlpcL2RoN2FCcjdSUWlTNnphb3JTSXlnPT0iLCJ2YWx1ZSI6IjZVQlVndFY0Q3BhdlQ1Mys4T21UdEs2MTRxMnlkN2xyZ2N5KzRnVFVCWkcwNjhsenFaUDdHKzVoQjFDelV3XC95Z016RUNZcFlhcWtiY05wM01zekJ4SmZEZ3I0Rjk2RVJiM0srZllJTlZxNVdcL05GemZPeXF2cEZOd3FCVURHNXciLCJtYWMiOiI1MGRlMTg0YzJlMzgxOTA4OTY3MjJjNjJiZWMzYWRmNjIwNzdmOGIyYWM0MjQwNjhiMjFkZmVlNDNkY2UzMWExIn0=', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(84, 'paypal_client_production', 'eyJpdiI6ImN3XC80K3BXZUtUQWJocE9HTWpaSFl3PT0iLCJ2YWx1ZSI6IkUxZnFnQUd3anZUZTVvZG5XNDNFOXY2WXdDZ1lOMXRuOHYyeDROMHFlT3BUTGE1Z0lTY2xCWGFJa0V0aVRCUVlNM0txSlA0VDh1SFJcL21SelFyXC9GWHl1T1lnWkNcL21NMmg5VFArMURidVJ3bVFwTEVTc1EyMjQ2K1BrQWhyMkxIIiwibWFjIjoiYzAyNDlhZDYwNDFhY2JhNWMzZmRmZDRjYTg3NjgzNzQ0MzA5MzM2ZjE4YTE3MDlkNGZlNDY5MTdkN2I5MjFmYyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(85, 'token_name', 'eyJpdiI6ImJkektxdnVkM3JGYWxYM3hZRXZReHc9PSIsInZhbHVlIjoiSWdxd2ZRYjBCRWZ6RURtN3pUVHAwQT09IiwibWFjIjoiNzc3Y2IxMDAxOGJmMTNkYjljNDY2ZWU4NTI0NmMzYzVmNGNiYTE2ZTQ1OGMyNDBiNGVhZTk2NmJkZDA0NmRiYyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(86, 'token_symbol', 'eyJpdiI6ImhYOXplamdidjZyRmd3UjQwV2VTY1E9PSIsInZhbHVlIjoiczdzQW9jUFNQTUhNWlQ1WHZJalpNQT09IiwibWFjIjoiYTZmMDQxZTcxYzhiODZiNDliYWQ3M2U4ZWNmY2IwYWE3MjI2MTBmYmMwMmI1MGIwMjkwMjk1NTg2OTZjOTMyNyJ9', 0, NULL, '2021-04-22 11:28:45', '2021-04-22 12:36:14'),
(87, 'app_name', 'eyJpdiI6InpoS09IVVA2a1NQN2Q4V1dsWm00N0E9PSIsInZhbHVlIjoibUVFQVFFUkhxOWJnYlZRRXgxQ3A1QT09IiwibWFjIjoiNGI5NDM2OWNlODVkMjkxMTMyNzExY2ViZTI3YzZlZDQ3YmZmNWY2MWY4ODFkY2FlYjhlN2M1ZTgyYTBjNGQ4MyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(88, 'app_env', 'eyJpdiI6InU4WWNsQTdzY3luWnNFQ2htNFJmdGc9PSIsInZhbHVlIjoiK0RXSEZjZXF3THAxbktmN1Q4dU9zQT09IiwibWFjIjoiMzU5YTlmNGQxOGRlYjFkNzBmMzVmM2RjOTUyZTc5NDg3NTlkYTEwYmNjNzBkM2RiNGY0MDU2NzIyYzcwNjE5ZiJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(89, 'app_key', 'eyJpdiI6ImVRdlFqZTlub3E0ckQwU2YxYlwvZVl3PT0iLCJ2YWx1ZSI6IkVvN2FmUVVwamJPZlwvdnNzOTU4T0d2bm9za0l2TTU4Y0o5cmpYNmUrWEp2eXYrSzVmN2NseEtpaVdUdno1MEs5ZjB1K1RoWFRuY2tlRkRONDFPMzhcL0E9PSIsIm1hYyI6IjE5Zjk3NjE3NjQyZGQ3MmRhYTNiZDE3NzdlYjdhMmNkNDI1MTE3OTA5OTgyZDc0NWQxZDI0YTQ3ZjVkMDJmODUifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(90, 'app_debug', 'eyJpdiI6IlRSXC9tcTFMZTJpWkpRV1RQT3lxSXh3PT0iLCJ2YWx1ZSI6IlNBcGFETDY2N0tsVDR3ZTRSdkdESnc9PSIsIm1hYyI6Ijk1ZTVlMzkzZjQ2ODI3MmM0Mjg1ZGY3MzhiODQ1M2E1NGExYzA4YmVhY2RkZGEyZmZhODk4NjJkY2FhZmE2ZWEifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(91, 'app_log_level', 'eyJpdiI6IkJOTStTVVVkbVJWOHRxQkliUElxcHc9PSIsInZhbHVlIjoiUmdTcVwvdnJkc0lcL2pIdU5cLzZsa1R5QT09IiwibWFjIjoiNmQyNWE5MDUyMTllMWU3ODcwZjg4M2UxMDI1ZjFkOWM5MDI0ODZjNzE5ZjU1ODllMWVkZmNlZjhkYzc0N2I4YSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(92, 'app_url', 'eyJpdiI6IlwvMjJoNk5nWFo4Mzg3Sko3QWNESUt3PT0iLCJ2YWx1ZSI6IjF6dmI0bUtFRG9XKzdtUndCdU5WMGxyWGxpQlVwanZBXC9Nd2o4ZWZ5QmhvPSIsIm1hYyI6IjRlODE1MjQ4YzlmMzAxOTA2YTg1M2FhMjBhMTMxN2E2MGExZTM0MzdmMWRkOGQ1ZGEwY2JiMDZhYTczZmYzYTUifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(93, 'log_channel', 'eyJpdiI6IkFTcTlXeTFNemV4NkpuSEJjQkhYQlE9PSIsInZhbHVlIjoiUlA3SGdzT1RlTWdrTFlzY2NBeHFwUT09IiwibWFjIjoiMjMxNTc4N2YyMjE2YmI1MmQ0Y2U1Zjg5MGEwNzcxZjgyNThkYzFlMjUwYzZlZDFjZjU0M2I2NDkwN2M3OWQzOCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(94, 'db_connection', 'eyJpdiI6IndjU0tQejZUUEg0dmg0bzNjaTJyNnc9PSIsInZhbHVlIjoiZllqV0VkZWRjZHFpUEhmWThHU0RtUT09IiwibWFjIjoiYjg5NTM4NTM3ZWMwZGEwOWU3MzFiYzI5YTAxNTMwOTQ0NjI1MmRmODNhZThhMzhjYmY1Zjk4MWI4NGE1NmNlMyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(95, 'db_host', 'eyJpdiI6IjNZTHlRQ29tM3JRZjNPbWVmaDBPMnc9PSIsInZhbHVlIjoiWDExd2V0WE9ZZFo2NVM3UUdIMDBIQT09IiwibWFjIjoiMzJkMTA0ZDZlNzNjMzA5ZTdlOGU0OTUzZTJlZTAwZGVhMDhlZTI3MDBmNGFhNjRlY2M3YWNjOGI4MjM4YzlkMCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(96, 'db_port', 'eyJpdiI6Ikh4YU44Y0ZMVks2dWJ0RFFJYjJlNmc9PSIsInZhbHVlIjoiTVljR0U5NU53SnA2NkswelJqSnA5QT09IiwibWFjIjoiNDZlOGYwNmEyZTRjYzkxOTg3M2JmMTYzYmUyOGMyNzVhNGNlNzVkMDhlODUyODNhNWFlZDQ4NjYyMzY2MDE4ZCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(97, 'db_database', 'eyJpdiI6Ik1BdTRiK01Yd0VUOUt2anZFQktPY2c9PSIsInZhbHVlIjoidjY2Um5HVjVubHNORzZhWXRIcnNGdz09IiwibWFjIjoiMDJjZmM4ZGUxNGZkNmU0MTY3YWI2NTkwNDA3NWIxYTg5ODBhOGQzYmY3YzFkNjA4ZDZlYzM0NjBmNGI5ZTEyNCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(98, 'db_username', 'eyJpdiI6IlNzZGplWUFpRXlzV2JmV0dtNU5cL3VBPT0iLCJ2YWx1ZSI6Ino0dVZ0WUpqalwvRGRnVDhFNVhEbDV3PT0iLCJtYWMiOiJkMGIxMGMzYmYxOGRjYjA2ZTYyYTY2ZTJjMDJiYzFlMTVmNDA5ZWE5YzhmNWIwMjNhOTIwYWEwZTI4YTkwMDc4In0=', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(99, 'db_password', 'eyJpdiI6InQyeVZCSmRDN2dJOWRMMjdrUnhNTXc9PSIsInZhbHVlIjoieVlVOEJncDROeWxiZU51UXErQW5PQT09IiwibWFjIjoiMTQ4Yjk2MGU2ZmNiYTIxYmNkMGNiYWExM2E1MDJiOWY5MzAyZTk4M2Y0YmY1YzdjYjZlMmI2MDk5NDBiOWNiNyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(100, 'broadcast_driver', 'eyJpdiI6ImRBRXd0VExkWjQ2ZStJSHVTNFVkeWc9PSIsInZhbHVlIjoiUldOU1hzcER3aU05NGNrMERzYWlLUT09IiwibWFjIjoiN2JlMDNmNGQyMzc5YWJlZTY2M2NhMzZlNzkxNmJmOWJjNDE5ODk3MzBlYjc4MjQ4NjFhNDQyNmJhYzUwY2Y3ZCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(101, 'cache_driver', 'eyJpdiI6InArb1l0REdXWDVOZDNweU9HM0RBc3c9PSIsInZhbHVlIjoiQUgzTHB5SzR1N2xydk5NXC9VR3Q4NUE9PSIsIm1hYyI6ImU2MDRmZjFjNzIxNWQ3NzJkZmNmN2QwZGE0NDg1ZTk1MmJiMTZkNmE3ZjNkNWM4YjQxYTljMWYwZjdlOTJjNDMifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(102, 'session_driver', 'eyJpdiI6IjFVSThwdTgySWhLdGhnTnVaU2pEakE9PSIsInZhbHVlIjoieUlPWDVVcGpBOWNFS1ZqWE12S2E3dz09IiwibWFjIjoiZGEzNmM0MjkwZDc2MWI0MGY4NzhkZjhhMDU4NjA4MDk5YjIzNDRjZjkxZjRiZmZjOGI5NDE5NGYxMzJjZTRjNiJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(103, 'session_lifetime', 'eyJpdiI6Ikpxa1lkMWdUbG5rSWNsblhHbEJhNkE9PSIsInZhbHVlIjoiUUkyRDFFc2RCcDlaWmQwK3hEOVRDZz09IiwibWFjIjoiNzYwM2U1YzQzODAxYzg4NGUwZjIxMTJiMTRkYTQ4NjY2Y2I0MTY1ZDE2NDQ0MDJjOTc5NmY0NmM1OTM5ZTcxNyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(104, 'queue_driver', 'eyJpdiI6InVSa1dwNHFXSG1jWUVkN2o4aFFzUVE9PSIsInZhbHVlIjoidFQxUmZvMjBaeGtpR2VYQXZ6Z05HUT09IiwibWFjIjoiMjdlMjlkODJkM2VlMjRiYWJlM2QzNDI2MGY4YTgxZGE0ZDMyNmI3MGNjMGVkNjAyZjQ3YjZlM2UxOTdjMDVkNCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(105, 'redis_host', 'eyJpdiI6Iko1RkxDbFAzN3M5NWFvXC9sTUxXYURnPT0iLCJ2YWx1ZSI6IlVNR1V5WG1NZzNJbFhcL3dkT3RWNkdnPT0iLCJtYWMiOiJiYmZiYzczYWEyNjYyZmUzM2VmNzNhZmFhZTAyYzNiMmJkNTc0ODVjYTY3OWNjMGI0OGY4MzkzOWVhMjVjOGQ4In0=', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(106, 'redis_password', 'eyJpdiI6InRqeUFQVVYwZUFQaHZEWDNYbEJoenc9PSIsInZhbHVlIjoid09jMndNNXRRV2l4VWdVRnJGSUF6UT09IiwibWFjIjoiMTA3NDA4MTk0OGQ5NTQxNzY5NGI1NTlkNjUwYTQ5ZTNiMzgyNzE5NDQ3NmJmMjljZTVkMjUxMjJjYTRkZDEyMCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(107, 'redis_port', 'eyJpdiI6Ijg1cElCU2Y1WUMySkxwUEY5YXJEVkE9PSIsInZhbHVlIjoiS1B0cFRpQmp2OHQrTEl4UHc2WDc0QT09IiwibWFjIjoiY2Y5YTA1ZmMyMDViYmY0ZGFlZmVmNDFmZmEzMGQ3N2QxMzA3YzNlYjU0NmYyMDc2NTlkZmNhMGIwNmZiZDUwNCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(108, 'mail_driver', 'eyJpdiI6Im1yb0o0eDVEd21TdjIwSFJyXC9NMEhBPT0iLCJ2YWx1ZSI6ImJ5ZnJpTEV1NmJQeWg4cDBjSUFGSmc9PSIsIm1hYyI6ImUyN2M5NmZmZGM5YTUzMDNjOGIxNzM4ZWFlN2NiZmE1NGEzODY1MGQzNzRjMWQwN2RlNWZhMDc0NjA5ZTdlOTgifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(109, 'mail_host', 'eyJpdiI6Ik1cL2JrMENzQ0dtWG4rV1pQUjI2T01nPT0iLCJ2YWx1ZSI6IkpcL25YaWprUkN0RGxwZ095YmF6SXVWNmtaMjMycW1TVTFqS0t1N3dobmNJPSIsIm1hYyI6ImEyNThjYTBkM2Q0YWRhZjdkZjk1NTY3MzJiOGUwN2QwYTY1ZjFmYTZlZWExMjkyNjM1NWQwM2I1MWVmNjVkN2QifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(110, 'mail_port', 'eyJpdiI6IkpZNGx2NEo0eHJzQWdxUk53RW55U1E9PSIsInZhbHVlIjoiKzVYazRaWXNpY0R6dXdqcUJsSkhHdz09IiwibWFjIjoiZDM0OThjM2VlYjdkNzFhOGQwN2U5YmRmZWViNWZjOTRhMmZhMjk0Mzc4NjJmNjU3NzhlOGNjNzNjYTM0ZWIzOSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(111, 'mail_username', 'eyJpdiI6IkpLQkdcL1FscXd0c3lQdm5YQmN2TWxBPT0iLCJ2YWx1ZSI6IkZMOGVsR01OZWRHSkpCK0M2U2ppMFNXUkZJcndFMDh2MHkzS2VqeExsVmc9IiwibWFjIjoiNDY2NTBjM2NlODM2NGFmZWVjMDI2NzUyOTAxYTI3NTZlZDM3ZTU0YWM2M2U2Yzc1MzBlNmRlYzk4MDE1NjE4YSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(112, 'mail_password', 'eyJpdiI6IlBxQWtqMkZqUkxIR1BcL3RlSTNhNFVBPT0iLCJ2YWx1ZSI6IjdkMGRra0k1Rkg0dkQ2a3F3eUc1NGpkT1d3d1ZkSGZ6UmljN25Ccnc0bkwraDBiU0tJMkdKMjRnenBlZllOWnM3VENEWDhjb1BmTnl1M0hyXC9FWjV2WnpadmZIRmtCVHpQU3MyRG1Kc2Flbkp3SEhcL1A2V3IyNnkzamJWSkRSYnAiLCJtYWMiOiJjZTMzYWZkNGEyZGY0Yjk1MDgwM2YyYzgzMTU2NDVkY2RiZjAwZjgyMWMwNGI0OGVmMTU1MWY4ZTlkNGRmMjhjIn0=', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(113, 'mail_encryption', 'eyJpdiI6IkFkdjl6TGtZd09WanlpZ3FqOENsd3c9PSIsInZhbHVlIjoiTUFJNFRZTWI4S0VnY1BUdFdBOEJDUT09IiwibWFjIjoiZDYzZTVmY2RiMzA3ZWE0MTNmYWMwMDIxZDhmNzQxMTg5MmRmMjhmNTY3MzE0M2MxMjJkNGE4MmVhNDdmOTJkNCJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(114, 'pusher_app_id', 'eyJpdiI6Ik9UYTVqSXdMMUkwTFhVK1ZTMFV0b3c9PSIsInZhbHVlIjoiZ1BoRkM5b1I0dk52R0lrSUlQUjlIQT09IiwibWFjIjoiYjZjZDQ2ODY2M2JjNjg1OWE0YTgyZjViOWUzNDIxNWVjODlhNjliMmJmOTVhNzEwZmRiY2JkOTUzNThmZDczYiJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(115, 'pusher_app_key', 'eyJpdiI6ImxlQk9PVTJpTFRjQWtaZ0tJYyt6dFE9PSIsInZhbHVlIjoiTDc3ZGt4TWdJdFc3bkR6YkVIMU5HZz09IiwibWFjIjoiZWIyOWEyMGNhMTdmNzM0YjgzNDc4MTVmZjUwZjY0MmEzNTQ3ZWQ1YzM5MjFhMDExOWU5YzBjYWVmZDZiNDJmMyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(116, 'pusher_app_secret', 'eyJpdiI6IkhUYmlGMHMrZHREUzNYWW5XenIzcGc9PSIsInZhbHVlIjoiV2p5V1J6bDE3VjZzNVdZb0UxRFpKQT09IiwibWFjIjoiNjEzYzVlMGU0MzU2NDM0MGZiNmRhMTI1MGVlMWViYTJmNGEyZTFhNDkxYzA3MmFjZDBjYzVlNTU1ZTk0MTI1OSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(117, 'pusher_app_cluster', 'eyJpdiI6IllKSjk2TXZQemlGXC9oejNBQVwva2VmZz09IiwidmFsdWUiOiJ6aVRtSG9WdExtUDhQa0hKRWRtSnRRPT0iLCJtYWMiOiIzNWU0ODVkZGY1NmMyYmYzZmU2MWYwZTlhY2RhNjc5MGQyMzg5ZDZiNjkwYTgxMDk1NWMyNTZmMTFlZDMzNjM5In0=', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(118, 'coinpayments_db_prefix', 'eyJpdiI6ImhNODQ1cjl2ZTUzTlJGdDRpbVNFR1E9PSIsInZhbHVlIjoiam44bVZ4eW54VERFZTRyaVZuQWVQZz09IiwibWFjIjoiZDhmOWQ4MzI1NDFlODY0NmU0MGU0NzQ4OTViZTRjZGI1ODk0OWI2MGVhMzAwMDg4NGI3OTAzYjFhNTNlOGM5YSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(119, 'coinpayments_merchant_id', 'eyJpdiI6IklrMlwvdldxc0FWVHFtSG1NcnlGY2lRPT0iLCJ2YWx1ZSI6InJXMXpRWklRM1cxZnVrWloxOTNjbVwvY3QxMmJKVXV4ZnpXMjZHdkZQXC9Ka0s0U2tpYUlJN3RlSGIxSlM1bVh4cSIsIm1hYyI6IjJjNTc3ZTU5Y2Q5YjVlYTQwYTZiMThjOTRmOWIzMTk5OGU5MmE1ODU1ZmU4N2JiNWVmNWViMTYwYjQ2MDliOGIifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(120, 'coinpayments_public_key', 'eyJpdiI6IlI5alMyT1RzWGZ0azNHeVdDT0twM1E9PSIsInZhbHVlIjoiMkM3RndWTCtpSFpyQzBJMlJ2Y1g4WkFQdGJFOU5ienR4TTNqK3RrbmIwSGFveTluWktESzZsV3VaeVwvXC9yamlcL1FyUVVFWlBJeTdIWmV1RnJxS0JmWVNzdlFZdEVodFVZZCtGTmpRK1wvc0hZPSIsIm1hYyI6IjdmNTY4ZjI3NjI1ZDRkMDcyYjg1MmM0ZDA4NzI3NWY3NWU1NDE3YWQ1YWFjOTM5Y2I1NTA3ZGRiNzQ4ZmMxOGUifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(121, 'coinpayments_private_key', 'eyJpdiI6IjhWUTdIQkd3OWhXSlRIaVRZbmFuNlE9PSIsInZhbHVlIjoiQXlzbHExbXVWK0M5Tzk2YWZIajVoOEliWUV1NUlEcnRSelBKVDJMVFF2YUFESGNweHFTemxvQWgwT3hZZmVqaHU4Wk1KNFlHZ2ZBYVZLMEZjQlErNlJZMks3K25pa2tYWUtDSkszQ2JMbkU9IiwibWFjIjoiNjc2MzQwZGRmYzEwNzUwZWVkOTY1MDA2NGMxOWVlMzVlOTAzY2Q4YzhjNjVhZDFlZmE3MjA1YTkzZDU3NmY4MSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(122, 'coinpayments_ipn_secret', 'eyJpdiI6ImJibkloOEI0Zm5UVEFpc0VZUjJaYUE9PSIsInZhbHVlIjoickpIZW40c3k1bHlvRGVcL1M0bmppbU1tU3QxdkdaZUpUXC8zTVZTUyt3RWlVPSIsIm1hYyI6IjRhYjdkZWY3MDMyNWZjMTc2ODUxNmUwNmI3ZmZjMmM5MjBjN2U4MWY1YTk1YzMyNGVjZDcxNjg4MDA4MTY0MGMifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(123, 'coinpayments_ipn_url', 'eyJpdiI6IitMUEt6b0czbms2aldhMjRaT0JIS3c9PSIsInZhbHVlIjoicDBCa09HRndJMVROQmhxRWV1b1E2RDB3Y3RCZ3ZTNk1PY21SWXQ2c1dQQjFoZHF0dHFXNnpQNEMyNDA1MGFpdiIsIm1hYyI6IjU3NWFlNmI1ZDY3M2FmZDdiNmE0Zjg0MGJhNzVlNDQ0MTI2NmQ5MDdjYTExMTRhN2YyZjhjOGVmZTJhOGNlOTUifQ==', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(124, 'coinpayments_api_format', 'eyJpdiI6IlBnc2U2Z2RLZGF6Z21jMEQ3REcxbFE9PSIsInZhbHVlIjoiUG8zRVMyYW9TVmtvbUxtR1d5YWJxUT09IiwibWFjIjoiYWNhZjViNzUyNGY3YTFjY2IzYzRlN2EzMTY3YjMwNDRkODk0NWJjMGQ1YmJlZDEzOGI3NDM1Njg0ZmZlZjdiOSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(125, 'paypal_mode', 'eyJpdiI6Ikk2RDlCQ1FjdnVIMERLZlRNNjJ3TGc9PSIsInZhbHVlIjoiVlB4b2w5SmFIeFQ3aVFNZGxjd2VBZz09IiwibWFjIjoiODI2M2JiNWJlODE3NWRmMTNhMjZjNzRjNWRlYTEwZjI3Mzg3YmFjZDBiNGEwZWY0YjgyMzNlMDc2NzQ1ZGU5OSJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(126, 'paypal_client_sendbox', 'eyJpdiI6IjRRVVh1SlJ6V1wvMXlPTm56dVBGVW5BPT0iLCJ2YWx1ZSI6IjNkXC9veTBDemRsS0phMnptNFJRQW80d1pxZ3BiS3JcL04zQXdEWmZQSzR1dEQ2WFVaSnhIc2xSVnZUbCsySDUrQ1NROEFLZjZRXC9LWThCZTBcLzRLTzFDeERMazQ5YTJaY1BjQ3ZYTFVoT2l5VjRPbFwvMEFFSVdTV1hLVGZlVFc3MTYiLCJtYWMiOiIxYjdiM2QzOTBkNGYzZWIxNTU1NGRhYmM3M2JlNzMwZDdhM2IxMTFjNWU4ODgyZDg1MjFlZTcyYTc5MDBkZjBjIn0=', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(127, 'paypal_client_production', 'eyJpdiI6ImgxVXhPK0JKNFZ5QjROS0ExRWVRQVE9PSIsInZhbHVlIjoiblBObWRZeng3bW1xaitOZnVOMlhYQ0YyakNcL1hKMVVPYUxwcFUxRjdBTmpMNXgrMnRTRnFCbWZxeDhxUjRVUVc4c2lTZ245dThpZ1daYjhtZGtuZWpOeW4yVjFyWENPWGtFUW1WZUFVN0dadzczVmdPUVZ0bkZXNnlpNFV5Z3dLIiwibWFjIjoiMGIzMThjNTFmNjYyOWE4MmY4MDZmOTNhMzZlYjg0NGZhNTY1OGJkOWNjZDU4NTE2ZDUzY2QyZTAxMjg5NjI0NyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(128, 'token_name', 'eyJpdiI6IlFpNVNEMnlMS2NoUGtvMjlTTVdjcmc9PSIsInZhbHVlIjoiNHBRNmkzZ1p4ZmdIVklCYnlWRlZGUT09IiwibWFjIjoiM2IyYWY4NjEzNWVkNWQ5ZDEwYmZiZDAxMzc3ZGM3NWMzNmM5N2JjNTFhOGU4MGQ3NTRlN2I4MjU4NmNkMmNjYyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(129, 'token_symbol', 'eyJpdiI6IlZFT2lhNWRPMVJFWnhxNWk5ZHNZVWc9PSIsInZhbHVlIjoidUVSeWljbnRWVTVOcGlocnVyV3BQQT09IiwibWFjIjoiOTE3NzJjOTdlOGNhNDc0MzA3MDQ2ZmQ3YTVmN2YyZjVlYTYyNjAxNjdkNzcyOWNhNDdjNDhjNGRkMDEwNTc4MyJ9', 0, NULL, '2021-04-22 11:31:45', '2021-04-22 12:36:14'),
(130, 'app_name', 'eyJpdiI6IkI3VzVtcGpkT1BuMnpKQjNicDFHM3c9PSIsInZhbHVlIjoib3F6cnEzZEh6Z1Y3XC9BNGNDTEVBZXc9PSIsIm1hYyI6IjdmNzM5YzgzNmQ3ZWQzMzY0NGFjYzZiYjcxNTRjZGMxZjUzYWRiZmFiZTdiZDg4MjNiY2M4YzcwNjc5ZDViY2EifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(131, 'app_env', 'eyJpdiI6ImJIbzRMYmtXYkJCQWo5Q0ZFdE9qMEE9PSIsInZhbHVlIjoiRkUzaUVLNStTM2xBc2VqNlhIVnVyUT09IiwibWFjIjoiMjk2YWVlNTViNDRiZmMxMzIwYTc1Y2M5YzUzNjVjYTFmNGQ0OTdiODAyNTAyZTcxMjM2ZTEyNmRkN2ZkNmMzMCJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(132, 'app_key', 'eyJpdiI6IjJlY01vYk5QQkpLVkZFZk44Z0FXYWc9PSIsInZhbHVlIjoiZlwvU1drRmFpeDROTnA2MUJCbUs5aW1wZzJuSmpSUkNOZ0RwWkVTM0NOSmhPa1cwOUREVjhqV0dLVlA4ZEZxQnNkeUhLM2dhREJpWkhyNFNYV0hhY0d3PT0iLCJtYWMiOiI5N2YwMDg1OGM4MjQyZGFjM2YwYjc1MmU2NmM0YjE0OWEzYjgyMzZjZDdjNmRmZmEyMzg2YTJkMWQxZDc3MzE5In0=', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(133, 'app_debug', 'eyJpdiI6IlIya20wRFBROFAxK0RaUXoxSUM3dUE9PSIsInZhbHVlIjoiWG1Sa1RsVnE0NmM0bmV6VFZQTUZlUT09IiwibWFjIjoiNTg4NWE0NmYwZDBhMzg3ZmE2OGE5ZjYyYjcwOTk0OTE3ZDVmZjIxMGQ1MDZkM2I3YzY4NDRmMDYxOTI3NmE5YSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(134, 'app_log_level', 'eyJpdiI6IlNLblwvU1B1aEV5TkkyeTJqUFwvSGhHZz09IiwidmFsdWUiOiJ3eVhiTk5pbkhoXC85Vk5mRmdwMCt6UT09IiwibWFjIjoiYjJiODY5ZjVlNzc3ZTNlMWRmNDg4MDI5YjJlOTg2NWM0MWE3MzNkOTQ0MjM1NjUxYTI1N2RhMDA2YTVjM2U4NiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(135, 'app_url', 'eyJpdiI6IkdcL3NnU0paaldONlNCQ3FmanY0MjdRPT0iLCJ2YWx1ZSI6IkRUYWhyOGZ1aTNxQkJkdHhzQmhlQ3NReXdRdzhEYjRtZGljMURyVEttUkU9IiwibWFjIjoiODRhOWQxYmM1YjZjMmY1ODkwM2IyZDRiYzE1NGU0ZWFkZTRiMzgwNGZjOTIwZGZhMDE5M2ZlN2E1YTZlMzBhZiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(136, 'log_channel', 'eyJpdiI6IjZpSElmalZRSkZvQ2RtajBmY0hIYnc9PSIsInZhbHVlIjoiUTQ0eVVlbkZRUnlMQzJJMEQwVHlnZz09IiwibWFjIjoiYTM5OWU1YzMxNTkwYjMwN2NiYWE1MzBjNTQwNGViMTMxZDFiYTAxN2RiNDQxY2E2MmMxOGI5MWM2ZTcyZjk0MCJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(137, 'db_connection', 'eyJpdiI6IjNUOGR4WGtUdzMxOWl5RjZjcWl0MWc9PSIsInZhbHVlIjoiTHhqb2JXaXFkUG9UamhEVkxlVERjdz09IiwibWFjIjoiYmVlMGI4YjA4MDU3YTU2MmU4NDE3N2FkNTgzMGFkOGRiZGI3Y2YxNWVlM2VkYjVmMGZkMzBhZjljMTM1YThkYSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(138, 'db_host', 'eyJpdiI6Ik5ySUZuRjI1XC82T3JDZkRVZkZJXC9tUT09IiwidmFsdWUiOiJYaFAzYlpQRGNHUEtjVFo5ZlFHNE53PT0iLCJtYWMiOiI3NzZkYmFlMzBiOTVkZmQ2MGMxYzQ0NTQ0ZDA5MjBlMjllYTAyM2EyOWI5OWI1MzdjMzExMzc2ZWY5NDU3MzY3In0=', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(139, 'db_port', 'eyJpdiI6IlFGZlBSR20rVFwvZG1UcnZaNGhuK0t3PT0iLCJ2YWx1ZSI6IklPeDc5Z2tSNlhtRE55eFhETms4eUE9PSIsIm1hYyI6IjkzZmI3M2YyMjg5NDI4N2ZjMzE3ZjM1MjFkMjE3NDFiZjk1ZGFhNjczMjA3ZjhjZmQ3ZmE5ODFlMjZhZWZkZWEifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(140, 'db_database', 'eyJpdiI6Ijd5cGx4aVQrRVpEb3JIZGVPMFBQc1E9PSIsInZhbHVlIjoiaURyWmRjQmQrVmJnZUFNcWJ3ZGkrdz09IiwibWFjIjoiMDBlYjlkZDMzMGRkOGNkMzI3OTgxN2U4NjMxOTg5M2Y5NjE2ZGZmODZmNTllZTkzODA0NDY2MTU0NzQyOGEwOCJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(141, 'db_username', 'eyJpdiI6IlBGMnFGdElVd0JvVktkT1lKNGF6aFE9PSIsInZhbHVlIjoibU9qM0FrK3JKZEFhVG83VzRJTjQ1dz09IiwibWFjIjoiMTI3Yzk3ZTRlOGYzNDg5OWE5MjdjNjRhZjBiNGE0NWIzMmViNDdhMzYxYzliYjk0YWRhOTViZTYxZGRkYTEzNiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(142, 'db_password', 'eyJpdiI6IjNTbU12RFlhOUJcL01QZnV3RldUVnFnPT0iLCJ2YWx1ZSI6Ikx4NHlkbWY2VVBzOXBaNnZOVWtsQXc9PSIsIm1hYyI6ImVmNGIxZWE0YjNiNjg4NWQ3ZDM5OGNmOWJlNzhkMGNkM2M0YjE1NDA4NGIwYTU5OThkMWEyZTY4MzRhNjJmODUifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(143, 'broadcast_driver', 'eyJpdiI6IkhnVUg3NUNubnFkUWZHRkVwMnZHRlE9PSIsInZhbHVlIjoiMEJ6Z0Z2SWlMNFZIYXY2bWNRT082Zz09IiwibWFjIjoiYzNmODVhYTI4YmQwZDVjZmYxYzA3NWNiNmUxY2QwODZjYTI4MjI4NDFjZWQ2MTM3ZjZiNzEwNWRmNTdjNjc3NiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(144, 'cache_driver', 'eyJpdiI6Ik1OcUErQlNaVkR1S0txTmRXa055dFE9PSIsInZhbHVlIjoibkh2MEt3NnpnUVBpZDdjbjllWCtiZz09IiwibWFjIjoiNDRmNTNlZjY3NmYyZmM4NTcyZTljYWM2MmJjOGMxYjMxYzNhZmFhMGQzNjFhOTA5MTM1ZmM3OTAwMmZmOGNiZiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(145, 'session_driver', 'eyJpdiI6InRWUTE1TjF5eTl3TVRTaERTNXVaZ3c9PSIsInZhbHVlIjoiWDl3bmdjcVcrcjk3N2dLckRXRFdyUT09IiwibWFjIjoiOGY0Njg4MTJhZTA1YTBiYzRiZWUzMzIxMzA4OTIzNmJhNTY5YTkzZmMxM2IzMWQ4NzExOTBiNDcxZjFiZDA0YSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(146, 'session_lifetime', 'eyJpdiI6InFyZnplMG1uOUN3cWZrV3EybTV0TWc9PSIsInZhbHVlIjoiY2NCWVJMSFVFUUVoMDlCcVYranpPQT09IiwibWFjIjoiYWViY2EzOTc3ODE0NDUxMTRiMjVhOGZkZWNiYWJkYzY0NGI3YWFjNGE2ZWI3MDQwMDQ1ZGUyYzczNDZmZGIyNSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(147, 'queue_driver', 'eyJpdiI6ImNNTVUxN05RQThDWkF0MFZ3WTNWV1E9PSIsInZhbHVlIjoibkhucXdZU005NWhwWTlpZzcwVThwUT09IiwibWFjIjoiMjM2Mjc5ODY4ZDE3Y2IwYWIzNGQ1YzdjY2IzNmUzYjZiNzM4OWQ2ZGM4ZDQzZTE3OTc4MjQwNDI2MmVkYTBkYiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(148, 'redis_host', 'eyJpdiI6IjhUQXYzZ1p4dXhJYlJ5MTh3STJFREE9PSIsInZhbHVlIjoieTZZZDRFUEx2RjkxMmkxbUEzRUsrdz09IiwibWFjIjoiMTc5YWE3MmQ3M2MwNTU5YjMzMDVlMmExMmE2N2MxOTcxNGQzODI1YjljNTYyOWQ4MDU2YmY4ZjU5Yzc4NTQ3NiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(149, 'redis_password', 'eyJpdiI6ImlLTzRaTmJRV0lhWkpQSVd0cFlSdUE9PSIsInZhbHVlIjoieWw3RDhPN09YZEdMZ2piemhKTDI5UT09IiwibWFjIjoiMDM5MzczODZiM2ZhNjY5ZDE0NTgzOGU4YjFkM2RhZjUyN2MxMzI2MmQ2ZWM1NTZjOTBhZTI4YzljNjEwOWViNyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(150, 'redis_port', 'eyJpdiI6InJxRVwvRTRlTXBYVVYrWDFpenpqajlnPT0iLCJ2YWx1ZSI6IlwveVIweXZ0SFwvd0FYNUhscUdFOXNzUT09IiwibWFjIjoiMDA3ZmZlZmU2NzFkODRmYThkZTQwNWJkMjkyYTg1Y2ZmOGY0YzdlZGRkZTVhNjQ2ZDA4MmQ0ZDZhMDQwZWExZCJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(151, 'mail_driver', 'eyJpdiI6ImFkNVwvTGxpVGtSclEyZnQ5T1pXUG5RPT0iLCJ2YWx1ZSI6IjJHRDViaTl3cEVpb2IwVUJFUTZ1RkE9PSIsIm1hYyI6ImU5NDYxNmQ0ZDVjYmI1NmMxNmM3YjJkN2VhMDFhODA2ZTg2NGE1ZGVkOGVhYjQ4N2Q0ZGEyZDJjMzVhMzUxM2MifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(152, 'mail_host', 'eyJpdiI6IkN4eHJvdkkrQWtnajZmeUxucVBHeXc9PSIsInZhbHVlIjoiQlp5bFM3cjdrSFhGcHdId1oxQ2l0aHc3ME45clNtcGl6Skhsc2V5Q1wvZEU9IiwibWFjIjoiMDQxMDlhMWU5NmViYzQ4Mzk1ZDlmYmZhNDg5ZTg4MTNhM2ZlOTlmNDkyMDZiOWRhZmRjODZhN2NkYzUwOGU4YSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(153, 'mail_port', 'eyJpdiI6Inl3ZHJxUUJmVnlpRDFsXC9CMUp5ZmdRPT0iLCJ2YWx1ZSI6ImYyUUJqMUhoZjN5Qk96aVM4dVR3Z0E9PSIsIm1hYyI6ImZlMWQ4M2Y5YTA1N2IzNjdjMjg5MTg2NTAxNjRmZmQwNzUwMmRiZThlNjJkMmJlZDI3ZjQyZGYxZWM4Zjk4MGUifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(154, 'mail_username', 'eyJpdiI6IlV2VHV4YlBOZkkwYmNOUjNUNUhcL0V3PT0iLCJ2YWx1ZSI6IjJpS2pkemlmNXhjNkVyRm5WMTlhZk9wdEE3MmpKMTlYd3RIK0pxRHBsSHc9IiwibWFjIjoiMGQxZGQxZDc5YjJmODA1NDZiNmFkZTliNTY1MTA0NzhlMjE0ZDUzNzhiY2VhMWYwOWE5NTViZDUxYTAyOTRjMSJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(155, 'mail_password', 'eyJpdiI6ImUwNCtrK2dLdUNYXC9uYU9kXC9aM0ZFZz09IiwidmFsdWUiOiJnQVJvWFpFaXpPVlVoSFcyK1dkYWN1SjBXQk5wS250OXV1TUdBSnhSWGV5aVhEeDlIeWlBaEpXR29PNUczVytVdFlLdUhVMHh5ZWphcTVmMnJtZGQ5UVRnMzBUbk5CaTFPcjVcLzV2NE44TDZ6clpKSWxLdjRBdENwd3dPT3gxR3oiLCJtYWMiOiIxMzI3NjZkOTJhN2E2NzA0MDYzZTI4M2NhNGNhMjU1ZjQyNjgxMGEyMjdlMTA5NDk4OTFhODg3NjFmZjNmNDdkIn0=', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(156, 'mail_encryption', 'eyJpdiI6IlBmMkhmV0M4eUFubzlGSW51b3ZLSFE9PSIsInZhbHVlIjoiSURadHBOK0ZzckFjYWhOakZSejB6UT09IiwibWFjIjoiMTE1ZDI0NWI4MDFkNzg0NmM0NGJmZjdjMGY5NDZkZWJmODAzYTQ4NmU5ZjZiYjk3M2I3MmM2ODgzMTM4NmQwYyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(157, 'pusher_app_id', 'eyJpdiI6IjRvcDVaemY3NVpOMEplNk1oekZiSVE9PSIsInZhbHVlIjoiWFp0eDBFVEt1Q01Ob2R4S1VrcWs4QT09IiwibWFjIjoiYTFlZjBjZTZjNjYwYzE3MmNlN2JlZjEwMjhiMDkyMjA2NDZhZGMwZDFmODRkOGQ5NjNlMDUzMDFjZWE1YTNhMyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(158, 'pusher_app_key', 'eyJpdiI6IlJ6N3I0UzRueHhwdVJiclFlZ2xXdWc9PSIsInZhbHVlIjoiSlhialwvU0NzR3Mwb3d1VFNOeWNZaWc9PSIsIm1hYyI6IjdmM2JkYmE2ZGMxZGJhOGU3ZTM3ZDcwZjEwZmNkZGMwOTU4YzJmMTJhMGUwODI5MzEzMjRlN2M3NGY4MWI4ZDIifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(159, 'pusher_app_secret', 'eyJpdiI6IjNGeFwvblVYNlR4d0tuS1RCMVh3cnRRPT0iLCJ2YWx1ZSI6IlJqZDFjSno3RDFsckJGZGZkUTV5M3c9PSIsIm1hYyI6IjUxZDFlZDRhYWNmNDJlOTBmMjg4MTE2OWNhZWNhNzAzYzlkZDU3ZTBhNDlhMDIzNTI1YWIzOTRlZGJlNTIxMjUifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(160, 'pusher_app_cluster', 'eyJpdiI6Im5oT3hUK0N1dFwvb1ZMbUtUYytLalBRPT0iLCJ2YWx1ZSI6IjRiNTVKMkhwZlRzZ3p4NGJGdTZKTUE9PSIsIm1hYyI6IjE5N2VjMTk3YjQxZjk4ZjUzOTNmY2I5YTk0ZWJmYTUxMjNjZjMyZmY3ZDU3Mjk2YjgxNTBmYWEzYThhMzA5YmMifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(161, 'coinpayments_db_prefix', 'eyJpdiI6IlZseTVmdGlCVklOUHBYcitLWVEzNVE9PSIsInZhbHVlIjoiVVJuTGRMUStxZmJQWmhcL21YSjBVNGc9PSIsIm1hYyI6Ijc5YTRiMzI5ZTk3NGMwZTZhZjk4ZGE4N2JiNTQzNmRjYzgzMmM0MDRiNjlkZjIxOTQ3YmViMjQ4ZmRmZjcyY2IifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(162, 'coinpayments_merchant_id', 'eyJpdiI6IjBVN0Q3Mjg3V0hTTm1VZyt5YkZzbnc9PSIsInZhbHVlIjoiRWxacnIzMHVkaDFnQWh2cDZXTGFMR1Q4b3hrbjNXcFRwU1BFcDlKNGIxRnJ6TndaZVYwOUIxNk9zZGhEbXlwNyIsIm1hYyI6ImZhNjM5ZmQ4MTUwODFlN2JlNDM2MGZhYzkwNjE2ZjhhNzE1ZDc1MTg0ZGM1MTRhNGRiYmM0MmQyOTYxNzkyNGYifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(163, 'coinpayments_public_key', 'eyJpdiI6Iml4WFh6SU9DeWtnMWZDS1lOemxQd2c9PSIsInZhbHVlIjoiM2RJanMzNlFZQm80Q1dqbzRWWE5VZ0MrNnIzOTJOa3hhbWl3ZWtGY1dhTFhRWGdGbU1pUm4zV09XT0Q3c3V5bXJzeWRXMGpERG9VRm5kY3ZISWZmd1MzaHhBVWpFQ21WcnM2djhadjlIbGc9IiwibWFjIjoiZjRiZDBkOTI3ODVlNjhmZjVkODIxNGZkODEzMGUyYmRlNDVmYTBiOGNjODlkODkyZDUxYTM2MmY4MTJjMGUxMyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(164, 'coinpayments_private_key', 'eyJpdiI6IkhxbEtkNTV4WWNiM2xqdWR6UTU4VVE9PSIsInZhbHVlIjoiaWR5TE5XNmtLcFhHd0s2Z2JlaWdyTnNaRUIzdHRBZitiWVFWbjB0RWZEY0QybWl3a2UwR1lYXC9kekRBQmdZM1AzUWdxcmJERXFPbG91QlBJemt5UzZWQU96VWtNcjdzY0ljY1NrQUdyRVBvPSIsIm1hYyI6IjkyMjcyNTA2YThhMWMzYTE0ODM0ZjZkZmZmZWQxZmQ4YzM5MzBkMjI1ODE1MTE5NTE1Njg3N2RkNDcxODI1ZmMifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(165, 'coinpayments_ipn_secret', 'eyJpdiI6IldpaGp2dEc3SVVqWHcwblk0eXZkSnc9PSIsInZhbHVlIjoid2hrK0pEaDE1UitcL3ZOQ3RoeGhDeFFjcHExNWlldWhrVDVkTTFVMWhuVmM9IiwibWFjIjoiMjkzMGQyZjZjZWJiZDY1Y2JjZDdjZDU3ODQwOWRjNjU3OTEwZjkwMTEyMTRhM2EzNTA1YmJhN2QxNDdlMDI4YyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(166, 'coinpayments_ipn_url', 'eyJpdiI6IkEwMDNkWlRJMW9sUks4NVwvOUkzT2x3PT0iLCJ2YWx1ZSI6IlwvV1ZWclwvTHgyQ1llWVVFSjVvWVRXUHVUT0hJWWNuQ0dYMUxhUldrVXZ5TTdpXC84U01xdjc3Tmd2aDU5SSszXC9TIiwibWFjIjoiMWNmZTY5NDA5NjIwMmE5YTU2NDZiOGViOWFlZDUyYTgxMTEwNTNjZjZiM2U4NGExZTE0NjUyODdkYWI4NDEzMiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(167, 'coinpayments_api_format', 'eyJpdiI6Ik5vOEJCUHVYNVlRT2ZiWmtDNGx4Znc9PSIsInZhbHVlIjoiMGR4UnMreWg2TUhDN3BlelpOMUlMZz09IiwibWFjIjoiMDY2ZjI2N2MxNzRiOTRhYzY3MzNlZTU2Y2YzZDMxMzAzZmY1OTg1YjM1M2FhN2I5NGZmNDMxZjI4MWQ0ZTE4ZiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(168, 'paypal_mode', 'eyJpdiI6Ik5NbnplWDA3WWFPYk0rNE9IbzFseVE9PSIsInZhbHVlIjoieW1nNUs4NkJjUG96V3V1TFBzbUFyUT09IiwibWFjIjoiNzRkMDU3NDI4ZmYxODU0NzhhNjBhMjAwZjNlOGZmN2I5NjZlYzcxNDdlYjJiYjIzMDk3ZjMzNGFiOTQzZGE3MiJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(169, 'paypal_client_sendbox', 'eyJpdiI6IktNUGlodFN2Sm4zZHBYd0lkTEUwQmc9PSIsInZhbHVlIjoiMXh2dkVMV3hHSUJGUWVhcnQzS1g0NUw2K3lrelkxaVhzaHFuUlpZZms1UlZPUGJwKzd1VHFJZlh2cTFcL05CWURlT2FpWWF1MmZcLzNMRHF0YWdsVlwvOW9uaVwvejZkblhIaitsQlwvVXFZV3ZIK1wvTjJHUUludmdCWTdxaXZkZWl2eDQiLCJtYWMiOiIxMDZmZGM5NzczNDFiODE5MjU1MjY1NDM1NzRlMDdmZjA5YjllNGYwYjNiMTQwYzM5ZDFmM2FhMzdiNWI4YzNjIn0=', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(170, 'paypal_client_production', 'eyJpdiI6ImFlNnMxSU9XM3g1elB6Wk43OHBkSlE9PSIsInZhbHVlIjoiTVl4N2MyUktqaFI3TWJOU2gzV05LdmVBTWMyeDBQODAraFlVYnB4d1JKUHhlbUFuN1pBZFN4aVNcL2wyRmRUcWozWDVMVVFHWFpTU2xkTXlPS090WVpqWmo4T0FtR2tyVVI2bG9Wc2FZN1dpbEdBK3hvXC9ZXC8ycjdWRzdmcGIzazciLCJtYWMiOiI1MGI1M2NiMjdhYjM0ZDk1OWZiYjVhYmYxZWE0NzFhOWJlOGI2MDM0MTY5NjU3NjNlOGMyY2JmNWFjYjJiOWI3In0=', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14');
INSERT INTO `envs` (`id`, `key`, `value`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(171, 'token_name', 'eyJpdiI6IjNKWUZIRDhYZVkrKzZKN2FpXC9va1ZRPT0iLCJ2YWx1ZSI6IlFKaWtDUnVSbjVMZjF2eUsraDlpcVE9PSIsIm1hYyI6IjA2YzcyMTNkOGI4ZWExNjZmNDcxMzgxZDUzYjFiM2IwMGRhOGFlYTE3MmQ5ZmNhNTdmZmVhYjg3M2E2NjVjYWQifQ==', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14'),
(172, 'token_symbol', 'eyJpdiI6InZCd2J1UFRTTk8xbCtRS3lUMHZ1dXc9PSIsInZhbHVlIjoiREZEdnJoZ2JHMlUyQ0pTcWYrUnQ1UT09IiwibWFjIjoiZDgzZTRiZDhlMmYwYjhhZmI1YTg1ODkzYjU5M2JjYjZjZDA1NDJlMDM2ZjVmNDZjMDY4M2RhNjIyMTE4NjhjMyJ9', 1, NULL, '2021-04-22 12:36:14', '2021-04-22 12:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Initiated, 1 => Success, 2 => Canceled',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `reference_no` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `transaction_id`, `address`, `reference_no`, `remarks`, `confirm`, `created_at`, `updated_at`) VALUES
(1, 20, 1, '3MPigRu9gyKynwtmjPA8Z9FNVBRV9wxTyJ', 'CPFE1ZMALSC3KDEJ5AQTWUWP49', 'USDDeposit', 2, '2021-05-08 08:46:10', '2021-05-08 16:21:51'),
(2, 20, 2, '89jT8t7Q7jtdawFQ5DxexqWUM2BXSraYhJPqDFr9U1n6hCDvNXTTVhXMMnDksHZYVnCiYbVHv992sh47GAfVmSecPoEor2Z', 'CPFE4F5SVUQY7WBVYAFLCGGL9J', 'USDDeposit', 2, '2021-05-08 08:47:25', '2021-05-08 11:56:37'),
(3, 20, 3, 'XrUK7hjTYZmeoEDePm6SqcPfbYjDJYywxf', 'CPFE4IGFXKWWQ3RFMIA65J5SCI', 'USDDeposit', 2, '2021-05-08 08:47:51', '2021-05-08 10:54:38'),
(4, 20, 4, 'MKhLZE9xuCTmTRhadoe4qNhQdEwaYMY4Vi', 'CPFE2SGADJZ9EHI3U1H6ZD7RLJ', 'USDDeposit', 2, '2021-05-08 08:48:16', '2021-05-08 10:27:46'),
(5, 20, 5, 'bnb1nf37u6yag0z3ajfn0qm6lnp3p9dulk8rnrcyhk', 'CPFE5YPUMOLJLSS6DM2HNYLMEN', 'USDDeposit', 2, '2021-05-08 08:48:57', '2021-05-09 08:57:41'),
(6, 20, 6, 'bitcoincash:qr236qq8fgcumqd49mvjpxrxau2l7vhs2yqkekhnfl', 'CPFE5R3I3OTIISDUSPFW5I0RY4', 'USDDeposit', 2, '2021-05-08 08:49:29', '2021-05-08 13:56:44'),
(7, 10, 7, '3PsMHPdtL5SoxQDo5uqN2iwPosXRGeBfaJ', 'CPFE6L2CEG68VHSVMNKFZAWWAS', 'USDDeposit', 2, '2021-05-08 08:53:51', '2021-05-08 16:31:35'),
(8, 10, 8, '0xf64aaea745c88db9ff509e766dd04792babb3564', 'CPFE7AS9SNY2CCFZ7ROM4IOTWL', 'USDDeposit', 2, '2021-05-08 08:54:30', '2021-05-08 13:25:40'),
(9, 20, 9, '0xb0aca1d17b184cb070cca3ce18d22ab6a9fcefd4', 'CPFE2DBDRZHTQ24563APTGUHY2', 'USDDeposit', 2, '2021-05-08 09:03:15', '2021-05-08 13:10:57'),
(10, 10, 10, '0x150d2f353fe34f4a454ef87bfbd722031efc117c', 'CPFE3J8FR6OTDCKJULSINF3E04', 'USDDeposit', 2, '2021-05-08 09:17:07', '2021-05-08 13:25:40'),
(11, 24, 11, '0x8cda69ba6a8d5355844279fe0ff85037f2c5c1de', 'CPFE4SKOTEVWUFO6WEOJGJWP6O', 'USDDeposit', 2, '2021-05-09 03:17:39', '2021-05-09 07:23:37'),
(12, 24, 12, 'MP3skxCb7hJo7Z6zmG1SZX3MmHdap6EWNb', 'CPFE6ESRXXIZKJPT2GR4PVWCHU', 'USDDeposit', 2, '2021-05-09 03:18:44', '2021-05-09 04:54:24'),
(13, 10, 13, '0x0ef1d10d9b2efac0daf3239614c26b5642e11767', 'CPFE1XLDHGLA2F0W2NMVG1MZSU', 'USDDeposit', 2, '2021-05-09 05:27:37', '2021-05-09 09:34:39'),
(14, 20, 14, '0xe1acd157a9bc6494d7ab35b49d865c1b438e3a27', 'CPFE2263V8EGMV3FM0BW6LIIWN', 'USDDeposit', 2, '2021-05-11 10:30:21', '2021-05-11 14:38:44'),
(15, 20, 15, '0x5a2da23f525b1265e5519acf1bf525c19a230daa', 'CPFE62RICNGNWIJ9RTDB2HRPFH', 'USDDeposit', 2, '2021-05-11 10:37:11', '2021-05-11 14:48:47'),
(16, 20, 16, '0x09c3c37d547f1d60dd29086a2a7894da71e4d7e2', 'CPFE0T7HRRVTMATRO8AZW5CK5Y', 'USDDeposit', 2, '2021-05-11 10:38:57', '2021-05-11 14:48:46'),
(17, 20, 17, '0x3dad0c8e3ca5a506c6075ee8ed02d61ca203a1f3', 'CPFE2RA6MZHOF9DQJTIV2DZ75Y', 'USDDeposit', 2, '2021-05-11 11:00:10', '2021-05-12 11:06:45'),
(18, 20, 18, 'bnb1utjsjt2xnzc6s4va3fj677w0splnrw6chx0n62', 'CPFE7WQHOMRFKHDQRU57HF89JV', 'USDDeposit', 2, '2021-05-11 11:00:35', '2021-05-12 11:07:42'),
(19, 10, 22, '0xe677d6a915f972709fdccbed1ae55d9c16c5f490', 'CPFE2BCTD2RHFVS93YD0PFQSO6', 'USDDeposit', 2, '2021-05-11 14:20:47', '2021-05-11 18:30:57'),
(20, 20, 23, '0x345b106a46154cb3a5a8384d02b8d6be9cb7431e', 'CPFE2HGCAYBEPTXLG1NA9PATHL', 'USDDeposit', 2, '2021-05-11 14:39:25', '2021-05-11 18:48:41'),
(21, 10, 25, '0x22d8c6f143f13ee4c065c1cf16e3b8555ec23f73', 'CPFE3KDE0FZXIBDPISSGAUWH0I', 'USDDeposit', 2, '2021-05-11 15:27:21', '2021-05-11 19:47:56'),
(22, 10, 26, '3J3hoWcDmxN7qUcSoxTQEJvAnJpWDWzxDH', 'CPFE07UJLEORX6WBJVX4VFZRID', 'USDDeposit', 2, '2021-05-11 15:29:11', '2021-05-11 23:04:35'),
(23, 24, 31, '0xdc2ab0e9fc58500e3c9d898ad89c7492fb86838e', 'CPFE0RSKKFCMQ4R9P6BLGAPWJZ', 'USDDeposit', 0, '2021-05-13 09:46:03', '2021-05-13 09:46:03'),
(24, 24, 32, '0x806ce9b938e6537b06745fe46b57a4f7218e5dcc', 'CPFE0OTNLKBEMNKDBPHKNTYKJV', 'USDDeposit', 1, '2021-05-13 09:46:56', '2021-05-13 10:25:41'),
(25, 10, 33, '0x3ad811807563820eff3fd023daefba54a69a27c9', 'CPFE1IRMWLF2D7UDAECATH2F6Z', 'USDDeposit', 0, '2021-05-13 10:28:33', '2021-05-13 10:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presales`
--

CREATE TABLE `presales` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_coin_unit` int(11) NOT NULL,
  `unit_price` float(8,2) NOT NULL,
  `discount_percent` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sold_coin` double NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `presales`
--

INSERT INTO `presales` (`id`, `start_date`, `end_date`, `total_coin_unit`, `unit_price`, `discount_percent`, `sold_coin`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2021-05-13', '2021-05-14', 55110, 0.15, 0.10, 55110, 1, NULL, '2021-05-09 05:23:15', '2021-05-13 14:24:41'),
(5, '2021-05-14', '2021-05-31', 110000, 0.15, 0.12, 0, 1, NULL, '2021-05-13 13:46:39', '2021-05-14 11:46:14'),
(6, '2021-06-01', '2021-07-31', 275000, 0.15, 0.14, 0, 1, NULL, '2021-05-13 13:47:26', '2021-05-15 10:35:12'),
(7, '2021-08-01', '2021-08-31', 559890, 0.15, 0.15, 0, 1, NULL, '2021-05-13 13:48:41', '2021-05-13 14:15:38'),
(8, '2021-04-15', '2021-05-02', 1000000, 0.15, 0.10, 1201924, 1, NULL, '2021-05-13 13:48:41', '2021-05-19 06:12:29'),
(9, '2021-09-01', '2021-09-30', 1000000, 0.20, 0.20, 0, 1, NULL, '2021-05-13 13:48:41', '2021-05-13 14:15:38'),
(10, '2021-10-01', '2021-10-31', 1000000, 0.25, 0.25, 0, 1, NULL, '2021-05-13 13:48:41', '2021-05-13 14:15:38'),
(11, '2021-11-01', '2021-11-30', 1000000, 0.35, 0.35, 0, 1, NULL, '2021-05-13 13:48:41', '2021-05-13 14:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ide_no` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `account_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'individual',
  `locale` char(2) COLLATE utf8_unicode_ci DEFAULT 'en',
  `account_address_jpc` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kyc_verified` tinyint(4) NOT NULL DEFAULT '0',
  `is_kyc_verified_amount` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `company`, `ide_no`, `pin_code`, `address`, `state`, `city`, `country_id`, `account_type`, `locale`, `account_address_jpc`, `kyc_verified`, `is_kyc_verified_amount`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '395-60-9056', '3264', 'Sakae', 'Aichi-ken', 'Nagoya', 76, 'individual', 'en', NULL, 0, 0, '2018-01-12 13:35:31', '2021-04-22 10:50:39'),
(10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 1, 0, '2021-05-07 10:09:20', '2021-05-19 05:57:20'),
(11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-07 10:13:48', '2021-05-17 06:29:51'),
(12, 12, NULL, '801010146039', '47100', '61, Jalan PH 2/3, Taman Puchong Hartamas,', 'Selangor', 'Puchong', 91, 'individual', 'en', NULL, 1, 0, '2021-05-07 10:25:54', '2021-05-19 05:56:27'),
(13, 13, NULL, '700601086311', '47130', '2, Kekwa Apartment, Jln 5b, Taman Putra Perdana', 'Selangor', 'Puchong', 91, 'individual', 'en', NULL, 1, 0, '2021-05-07 13:30:09', '2021-05-19 05:49:02'),
(14, 14, NULL, '730619016685', '81200', 'No 50 jln dato hj mohd said kg pasir', 'Johor', 'Johor bahru', 91, 'individual', 'en', NULL, 1, 0, '2021-05-07 13:54:54', '2021-05-19 05:49:21'),
(15, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-07 15:31:41', '2021-05-17 06:29:03'),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 05:20:14', '2021-05-08 05:20:14'),
(17, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 05:31:30', '2021-05-17 06:28:56'),
(18, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 05:45:21', '2021-05-17 06:28:49'),
(19, 19, NULL, '650611715705', '81100', 'No 16 Lorong 2 Jalan bunga antoi kg.majidi baru.', 'Johor', 'Johor bahru', 91, 'individual', 'en', NULL, 1, 0, '2021-05-08 06:50:53', '2021-05-19 05:54:37'),
(20, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 07:57:34', '2021-05-17 06:28:34'),
(21, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 12:25:35', '2021-05-17 06:28:27'),
(22, 22, NULL, '900516015451', '86000', 'No 7, Jalan Kiaramas 3, Taman Kiaramas,', 'Johor', 'Kluang', 91, 'individual', 'en', NULL, 0, 0, '2021-05-08 13:38:49', '2021-05-17 06:27:50'),
(23, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-08 15:36:22', '2021-05-17 06:27:42'),
(24, 24, NULL, NULL, NULL, NULL, NULL, NULL, 91, 'individual', 'en', NULL, 0, 0, '2021-05-09 03:12:18', '2021-05-19 05:53:50'),
(25, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-09 11:11:03', '2021-05-09 11:11:03'),
(26, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-09 16:03:53', '2021-05-17 06:27:19'),
(27, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-10 05:54:07', '2021-05-17 06:27:10'),
(28, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-10 06:37:36', '2021-05-17 06:27:02'),
(29, 29, NULL, '690228075051', '14000', '22I, JALAN SEJAHTERA PERMAI, TAMAN SEJAHTERA PERMAI', 'PULAU PINANG', 'BUKIT MERTAJAM', 91, 'individual', 'en', NULL, 0, 0, '2021-05-10 09:10:31', '2021-05-17 06:26:53'),
(30, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-11 03:34:19', '2021-05-17 06:26:44'),
(31, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-11 06:45:33', '2021-05-11 06:45:33'),
(32, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-11 14:51:03', '2021-05-17 06:26:34'),
(33, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-12 15:22:52', '2021-05-17 06:26:26'),
(34, 34, NULL, '750808016703', '81000', '85, jalan perpaduan taman mas', 'Johor', 'Kulai', 91, 'individual', 'en', NULL, 0, 0, '2021-05-13 06:33:27', '2021-05-17 06:26:16'),
(35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 10:06:00', '2021-05-13 10:06:00'),
(36, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 11:20:32', '2021-05-17 06:25:50'),
(37, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 11:43:38', '2021-05-13 11:43:38'),
(38, 38, NULL, '750331075094', '56000', '69, Jln Midah 12 Tmn Midah', 'KL', 'KL', 91, 'individual', 'en', NULL, 0, 0, '2021-05-13 11:44:39', '2021-05-17 06:25:26'),
(39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 11:51:18', '2021-05-17 06:24:49'),
(40, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 1, 0, '2021-05-13 13:18:39', '2021-05-19 05:57:40'),
(41, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 13:37:04', '2021-05-17 06:25:06'),
(42, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 13:45:50', '2021-05-13 13:45:50'),
(43, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-13 17:25:10', '2021-05-17 06:24:31'),
(44, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-17 11:31:45', '2021-05-17 11:31:45'),
(45, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-17 13:15:21', '2021-05-17 13:15:21'),
(46, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-17 13:17:44', '2021-05-17 13:17:44'),
(47, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-18 10:21:02', '2021-05-18 10:21:02'),
(48, 48, NULL, '1', '76450', '46,JALAN PRI 17, Taman Paya Rumput Indah', 'Melaka', 'MELAKA', 91, 'individual', 'en', NULL, 0, 0, '2021-05-19 14:15:21', '2021-05-19 14:23:34'),
(49, 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'individual', 'en', NULL, 0, 0, '2021-05-20 05:43:30', '2021-05-20 05:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

CREATE TABLE `recipients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message_id` int(10) UNSIGNED NOT NULL,
  `placeholder` enum('inbox','sent','trash','spam','important','draft') COLLATE utf8_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_starred` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roi_investments`
--

CREATE TABLE `roi_investments` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_investment` decimal(30,8) NOT NULL,
  `amount_return` decimal(30,8) NOT NULL,
  `price` decimal(30,2) NOT NULL DEFAULT '0.00',
  `duration` int(11) NOT NULL,
  `percentage` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roi_plans`
--

CREATE TABLE `roi_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super', 'Super Admin', NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(2, 'admin', 'Administrator', NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31'),
(3, 'subscriber', 'Subscriber', NULL, '2018-01-12 13:35:31', '2018-01-12 13:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'wire_transfer', '*******************************************\r\nBitcoin(BTC)\r\nAddress\r\n1MBYyA1scVWRUSa8vXuBDLVpaDNk1t6k4F\r\n\r\n*******************************************\r\nEthereum (ETH)-ERC20\r\nAddress\r\n0x021038ef18bb0a37a352f8975c60166c0bba160c\r\n\r\n*******************************************\r\nUSDT-ERC20\r\nAddress\r\n0x021038ef18bb0a37a352f8975c60166c0bba160c\r\n\r\n*******************************************\r\nUSDT-TRC20\r\nAddress\r\nTVGexX1coUzZVzirytxtDGnqipJc87SVd6\r\n\r\n******************************************\r\nUSDT-BEP2\r\nAddress\r\nbnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23\r\nMEMO\r\n103095669\r\n\r\n*******************************************\r\nUSDT-BEP20(BSC)\r\nAddress\r\n0x021038ef18bb0a37a352f8975c60166c0bba160c', '2020-04-16 07:41:57', '2021-05-13 12:44:45'),
(2, 'msc_withdraw_fee_percentage', '2', '2020-04-16 07:41:57', '2020-04-16 07:47:06'),
(3, 'coin_value', '3', '2020-04-23 00:00:00', '2020-04-23 00:00:00'),
(4, 'min_amount_cloud_mining', '2', '2020-04-23 00:00:00', '2020-04-23 00:00:00'),
(5, 'max_amount_cloud_mining', '10', '2020-04-23 00:00:00', '2020-04-23 00:00:00'),
(6, 'REFERRAL_BONUS', '0.10', '2021-04-12 23:18:44', '2021-04-12 23:18:44'),
(7, 'LEVEL_2_REFERRAL_BONUS', '0.05', '2021-04-12 23:18:44', '2021-04-12 23:18:44'),
(8, 'LEVEL_3_REFERRAL_BONUS', '0.05', '2021-04-12 23:18:44', '2021-04-12 23:18:44'),
(9, 'dev_server_on', '0', '2021-04-12 23:18:44', '2021-04-12 23:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `tickers`
--

CREATE TABLE `tickers` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(11) NOT NULL,
  `buy_price` double NOT NULL,
  `sale_price` double NOT NULL,
  `last_price` double NOT NULL,
  `buy_inr_price` double NOT NULL,
  `sell_inr_price` double NOT NULL,
  `last_inr_price` double NOT NULL,
  `synced_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `track_logins`
--

CREATE TABLE `track_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('Credit','Debit') COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `currency_id`, `reference_no`, `type`, `source`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(34, 24, 1, 'TXN1620902776609d037856e83', 'Credit', 'Bankdeposit', NULL, 150.47, 1, '2021-05-13 10:46:16', '2021-05-13 10:46:16'),
(37, 24, 9, 'HASH1620905668609d0ec417547', 'Credit', 'Purchase CSM', 'CSM has been purchased', 1500, 1, '2021-05-13 11:34:28', '2021-05-13 11:34:28'),
(38, 24, 1, 'TXN1620905668609d0ec41754e', 'Debit', 'Purchase CSM', 'USD deducted for purchasing CSM coin', 150, 1, '2021-05-13 11:34:28', '2021-05-13 11:34:28'),
(39, 10, 9, 'REF1620905668609d0ec4178b6', 'Credit', 'Referral Bonus', 'Referral Bonus From ', 150, 1, '2021-05-13 11:34:28', '2021-05-13 11:34:28'),
(44, 39, 1, 'TXN1620913227609d2c4babad7', 'Credit', 'Bankdeposit', NULL, 9, 1, '2021-05-13 13:40:27', '2021-05-13 13:40:27'),
(45, 41, 1, 'TXN1620913654609d2df6e8132', 'Credit', 'Bankdeposit', NULL, 50, 1, '2021-05-13 13:47:34', '2021-05-13 13:47:34'),
(46, 39, 1, 'TXN1620913759609d2e5fd400b', 'Credit', 'Bankdeposit', NULL, 4801, 1, '2021-05-13 13:49:19', '2021-05-13 13:49:19'),
(47, 39, 9, 'HASH1620913876609d2ed4a8b02', 'Credit', 'Purchase CSM', 'CSM has been purchased', 48100, 1, '2021-05-13 13:51:16', '2021-05-13 13:51:16'),
(48, 39, 1, 'TXN1620913876609d2ed4a8b11', 'Debit', 'Purchase CSM', 'USD deducted for purchasing CSM coin', 4810, 1, '2021-05-13 13:51:16', '2021-05-13 13:51:16'),
(49, 38, 9, 'REF1620913876609d2ed4a8e9a', 'Credit', 'Referral Bonus', 'Referral Bonus From ', 4810, 1, '2021-05-13 13:51:16', '2021-05-13 13:51:16'),
(50, 41, 9, 'HASH1620914966609d331684368', 'Credit', 'Purchase CSM', 'CSM has been purchased', 500, 1, '2021-05-13 14:09:26', '2021-05-13 14:09:26'),
(51, 41, 1, 'TXN1620914966609d331684374', 'Debit', 'Purchase CSM', 'USD deducted for purchasing CSM coin', 50, 1, '2021-05-13 14:09:26', '2021-05-13 14:09:26'),
(52, 12, 9, 'REF1620914966609d331684677', 'Credit', 'Referral Bonus', 'Referral Bonus From ', 50, 1, '2021-05-13 14:09:26', '2021-05-13 14:09:26'),
(65, 13, 9, 'TXN162140326660a4a682d591b', 'Credit', 'Admindeposit', 'Bonus Referral 5%', 962, 1, '2021-05-19 05:47:46', '2021-05-19 05:47:46'),
(66, 13, 9, 'TXN162140458060a4aba45e7e0', 'Credit', 'Admindeposit', 'Ambassador Bonus', 50000, 1, '2021-05-19 06:09:40', '2021-05-19 06:09:40'),
(67, 14, 9, 'TXN162140462160a4abcd37588', 'Credit', 'Admindeposit', 'Ambassador Bonus', 50000, 1, '2021-05-19 06:10:21', '2021-05-19 06:10:21'),
(68, 12, 9, 'TXN162140466260a4abf657805', 'Credit', 'Admindeposit', 'Referral Bonus 5%', 962, 1, '2021-05-19 06:11:02', '2021-05-19 06:11:02'),
(69, 21, 9, 'TXN162140469460a4ac16b0a25', 'Credit', 'Admindeposit', 'Ambassador Bonus', 50000, 1, '2021-05-19 06:11:34', '2021-05-19 06:11:34'),
(70, 34, 9, 'TXN162140474960a4ac4db7d62', 'Credit', 'Admindeposit', 'Ambassador Bonus', 50000, 1, '2021-05-19 06:12:29', '2021-05-19 06:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `verification_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `referred_by` int(10) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `phone_no`, `username`, `email`, `password`, `status`, `verification_token`, `remember_token`, `referral`, `referred_by`, `verified_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'System', NULL, NULL, '1234567890', 'admin', 'caesiumlab@gmail.com', '$2y$10$TMbLvj/gXoxA1UQzW6.bvu3aTQe5YgI5kQKtZUgd5wGqjvi3ridym', 1, '1515764131-ptA8NIvWCFhJo9JPPhA4ZmFe82eeDvFNKePXbi0d3fowiEyvql6xGDyDFh59rwk0uZp4bj-5a58b9a36ad7e-ct4y', 'SfEG417wWZVwVPGM2SEubwnZ7JZKooQtu23DyRS9jQ1K3uYnTay1cUg8s5M5', 'csm', NULL, '2018-01-12 13:35:31', NULL, '2018-01-12 13:35:31', '2021-05-06 13:54:32'),
(10, 'Logeswaran Krishnan', NULL, NULL, '60149922420', '111', 'loges23waran23@gmail.com', '$2y$10$lrNqMS10IDaF6OGX9Zj52eL28drniA1bq1x4Y7.PR9RytB0F5gw8K', 1, '1620382160-xnGHYKi9UeHE3hTRe3cGgcP0QuXFku6n1lQMdVSNfBw1bbVKYMjdte8aK22EJTidt07fZf-609511d034ea7-byj1', 'HjGUHJsTcLW33ZsXrOjkd8Hytd3kWtNaAgg0koDYhxE4xCUUeACADWx0sd3t', 'LogeswaranKrishnan', 1, '2021-05-07 10:10:26', NULL, '2021-05-07 10:09:20', '2021-05-07 10:11:53'),
(11, 'Maha Kanesh Krishnan', NULL, NULL, '+60148325258', '11', 'maha2508@icloud.com', '$2y$10$R/Y0nLJbwJ2kCNS5ZXPH3ea/fuoWa5qYr1c.yIB5qIuFjY7N5Wa1i', 1, '1620382428-CLHOrpQb9IoUGZnTNpc9KPK4LqN07a1ZRwSjfj5cRKkIaFL2xsJV9v7smN9OnElbB9E5dt-609512dc9eafb-w2n1', 'cHrefGIOzBEigDEqkJyupdOWxS5ynUg73SmKEZWyqv8eOnHc5d9zUfN6Oem0', 'MahaKaneshKrishnan', 10, '2021-05-07 10:18:14', NULL, '2021-05-07 10:13:48', '2021-05-07 10:18:14'),
(12, 'Kong Yoon Chean', NULL, NULL, '0169105218', '801010146039', 'jasonktrade.jk@gmail.com', '$2y$10$ES5irA5AF4fNiEUwOXoPeO8Pxn6L8FW0PQws/SqpOMiGBP78N26zm', 1, '1620383154-08ALzZGPSr1nU6YLZ54ONslCNTeGJK1i9LfyVJBxGHoSJpwjZfDYoS9oeKhHxZO1dw8r5r-609515b264485-dPD5', 'ern4lFRAV9N5j581NAIoSJk46V85xVbQLteI3ScpUjssm8zU4Nmx3vcqlaC6', 'KongYoonChean', 10, '2021-05-07 13:14:38', NULL, '2021-05-07 10:25:54', '2021-05-13 06:39:45'),
(13, 'Aylwin M WL', NULL, NULL, '60146211261', '700601086311', 'soar05@gmail.com', '$2y$10$8jCBS83a1e1TB3P3dGndRer6n60DV9URrthwJKY7cKBcZjWR1vWaK', 1, '1620394209-czVkTvawUpyTZKBVyBNdsW32FlhaFWgiNOZA983zbMzzPpJ2RpaGCL7JF4mBhG8q0zKMXF-609540e1820b9-In38', 'vj4Qu0zM7CE08PmwEq9SzM7uvdh9hqpjZpeTWXxS0arspw0CBHtOeiFFLNL5', 'Aylwin', 12, '2021-05-07 13:32:02', NULL, '2021-05-07 13:30:09', '2021-05-08 03:57:22'),
(14, 'ZAHARUDDIN BIN ABDUL', NULL, NULL, '601111779959', '730619016685', 'zahar.timesurvey@gmail.com', '$2y$10$QN4qRa8jwtt7CXQAnG61z.nmLo8fKLk75lWmx6pYq6iC2qIR7XURu', 1, '1620395694-319U7FYAahNIMK26QWsCoZMsTkQMy1AoO0GdUNxtfSFxizX32g8UkOj0laJljDQIdgUNKG-609546ae96718-Alad', 'ouXeciwaSisjEuM0txR8Ku64jV1X7PmxCDa1jOtLmPjwiMB1EimQO6ktaDnH', 'ZAHARUDDINBINABDUL', 12, '2021-05-07 13:56:02', NULL, '2021-05-07 13:54:54', '2021-05-08 03:56:44'),
(15, 'Husin bin sulaiman', NULL, NULL, '+60127485967', '650626015963', 'husinsulaiman1965@gmail.com', '$2y$10$tZXNytDSuj/MBbpibwXhMO.4/xAsz7FCndrkCYhfHwX4xaUrQKysK', 1, '1620401501-w71HymgIlebfOJAE7EYqvhSvaqPspj9DeHwdcgVp5we8WhDTa2UhfCDqKv6xNkHUYz95mC-60955d5d9b7b5-coXo', NULL, 'Husinbinsulaiman', 14, '2021-05-07 15:35:36', NULL, '2021-05-07 15:31:41', '2021-05-07 15:35:36'),
(16, 'Yuwarajan', NULL, NULL, '+60192733775', '99999999', 'yuwarajan@gmail.com', '$2y$10$2oDsBwligvAgBVcGyLeqS.hU75nDoP4WYtF5hX3XnoDXVo21vSrYy', 1, '1621078394-OqolcXVMxkb5VxbYfIO5dOOyf7yrwvAwLPB377PmfBe925yq4Zo4mnhNCUN7pldC3bnVAG-609fb17ab77af-ApH5', 'HVbJOIRg5SMVQnRuCjJnJ0lv50HEmtEyqwNLZyTFKPnuDXFQ2Rqb8ivrnxHp', 'Yuwarajan', 10, '2021-05-16 03:39:25', NULL, '2021-05-08 05:20:14', '2021-05-16 03:39:25'),
(17, 'Partiban Ilangovan', NULL, NULL, '0182224013', '860809595193', 'livetrading8108@gmail.com', '$2y$10$UIentCac7Bcv8RcKiS6iBu4KRnW9l8LDIFvWftEG4NRHOLMA.U0ju', 1, '1620451890-9WfUD12yQg37irVxuA2KkOEtmq9cLinIMql6qj7ZWkTekTuRKSuCnsQHLBth5B2Kokw37t-60962232402d5-IJ91', NULL, 'PartibanIlangovan', 11, '2021-05-08 06:38:39', NULL, '2021-05-08 05:31:30', '2021-05-08 06:38:39'),
(18, 'Tennis supramanium', NULL, NULL, '0127101211', '770411016017', 'vstennis11@gmail.com', '$2y$10$cgaF50ltAah2y8u6Y/ceNu1enaYJxbJxELjAd5pfCjx.hvXERtUe.', 1, '1620452721-M45pDncMitVOXtN8rS3P13965w6tGfVlFH4kkMwYF046Z1IkFZGpvtlExMTbDXkHag6Xo5-609625716e0b1-j6HT', NULL, 'Tennissupramanium', 17, '2021-05-08 05:45:32', NULL, '2021-05-08 05:45:21', '2021-05-08 05:45:32'),
(19, 'Ishak Bin Mohd', NULL, NULL, '601111997005', 'ibmjb', 'ishakjb1965@gmail.com', '$2y$10$rC/thUjCoXpqaRvt95c3AOBa2wFyaUFWFMMFnIzZDjA3g8karTtaG', 1, '1620456653-A24UKNlmDb4hzUqaZy6enLc11sQz1pW0Yuce29CCeIAA8f4rejvaNiEfWxCwqwlEYNAjFk-609634cd54888-Q1oN', 'rNzVUWVuV4dLUx9Caq8Al7c5IKJcPgAI9VZsPV9hU3T9UQFHU8eGXsRK9Gsy', 'IshakBinMohd', 14, '2021-05-08 06:52:27', NULL, '2021-05-08 06:50:53', '2021-05-08 06:52:27'),
(20, 'Rohan Kumar', NULL, NULL, '8100009773', NULL, 'rohanjha1992@gmail.com', '$2y$10$SbBtsACTSWFz2bPDgy7L9eSZrBSi4UPaOgivxtuBT3yl2sd9lvfcS', 1, '1620460654-W2JogIz6tz9Aus4HlbNniObIcecqrhC3RhTJUsH7LzlLOKdNSgnR8xjXmQlDWzGY4xAuSA-6096446ec9002-Rq7g', NULL, 'rohankumar', 10, '2021-05-08 07:58:16', NULL, '2021-05-08 07:57:34', '2021-05-17 06:28:34'),
(21, 'Chukwuka Okaro', NULL, NULL, '08033772721', NULL, 'okaroworld@gmail.com', '$2y$10$FMr/cPXBcZXVqCCRp/9G1etQCuudvD/Vrbuy2HZ/W9SwuHJ2pUExS', 1, '1620476735-2ldfjOGGOGfmF1AAkQnka7sEvXswC3jXlIPppY8W23RmvYx4t0ZhaTgPwrEkW1wlbJiF9X-6096833fe727b-sPPw', NULL, 'chukwukaokaro', 12, '2021-05-08 16:44:16', NULL, '2021-05-08 12:25:35', '2021-05-17 06:28:27'),
(22, 'Muhammad Naquidin Salihan', NULL, NULL, '+60177600650', NULL, 'nikecrypto01@gmail.com', '$2y$10$u9R6zKKVaw16.IG8Cfl66.pfjeS7qX3P49yhA2zfVTKM44fazz/YK', 1, '1620481129-1DxTPCZyXFXxkS4To9iMxK3nCXMaWR6Io05qFQZmWd9jeAvYqu1nfI1IOv6FFJiy0TwAOu-609694690bde8-WnPR', NULL, 'muhammadnaquidinbinsalihan', 14, '2021-05-08 15:20:26', NULL, '2021-05-08 13:38:49', '2021-05-17 06:27:50'),
(23, 'KAMAL DIN BIN MASTOR', NULL, NULL, '+60187919266', NULL, 'kaymas234@gmail.com', '$2y$10$jxx8y2eZGraHWs4x.aavOupDEbztj8VTkdL39tq2.6sGqf1X6EU7G', 1, '1620488182-Oo5zRaUlsfd2H4cej5ylwl6nIraZHKJKw9XORYNyhCBx20G2ZOukTtPQA2waGKc80rglDG-6096aff63fe4d-Z5IQ', '3HxgcZNP4nMqHowcsxiqYKJ5meIJQdIdHGSUYHaiXVH9N7fzPAS4KHOJ5Y6b', 'kamaldinbinmastor', 14, '2021-05-08 22:25:51', NULL, '2021-05-08 15:36:22', '2021-05-17 06:27:42'),
(24, 'Mahendran Sivanesan', NULL, NULL, '60123279311', NULL, 'mac.fbis@gmail.com', '$2y$10$nRR2viT50sLeFacz.KEz7.GrGw3ZYqlQCa0jMO1e8mciIe1VzhUSO', 1, '1620529938-wNsSFHTgG99xTqPJlfh6pZWW7cLYqXGP67A7rQqx0jpHVBWcZGCTSYLrAKqIBuSDJuHuoP-60975312baa0f-MVNx', 'mM5dehbS8O8DmMlsvFACQ5WNwIFERSH73uxnCFpopR7K1JYRW67GbTPYwK47', 'mahendransivanesan', 10, '2021-05-09 03:14:15', NULL, '2021-05-09 03:12:18', '2021-05-17 06:27:32'),
(25, 'Jalil bin ithnin', NULL, NULL, '0107135245', NULL, 'jalilpremium777@gmail.com', '$2y$10$TeEDKeaGjciF7xEq5BKz1.l.dM1KaHkpnnjXIL3F3QSve2K6cvYHC', 1, '1620558663-MeDidLU4EJKjYt67SZ9snRIWAYo81Dt2qyhfde3LhOx8IzrIOw7oinMCcAR4cSKVCIoeFV-6097c3479eb12-w7K0', 'Qm5GMvcfVZC98YHhgg1QvjDt0cwjE0bJRvEQC57EQhzYh4P7c6nZNZWzwHX6', 'jalilbinithnin', 23, '2021-05-17 04:40:10', NULL, '2021-05-09 11:11:03', '2021-05-17 04:40:10'),
(26, 'Muhamad Talib bin kandar', NULL, NULL, '0127809271', NULL, 'tycosuasa@gmail.com', '$2y$10$e08AjmEfJbeO8X3BebZ7YuvQ6/NWHe3vBtE3HNgDl7TWIxHOfk5Pu', 1, '1620576233-t4vjLraCbZsu6WmFHjMhqk4cwphcbYQznl5vDLkZKc5Z7Sr4wOK7Geh1LE1XU09XS6prJZ-609807e9282c8-qyIg', 'ZzIbTc7ZbX19cV9sgGfhV5lQjYbcRxffXlZUGfnJ3P0SoYJJrIburcqbR47u', 'muhamadtalibbinkandar', 14, '2021-05-09 16:05:19', NULL, '2021-05-09 16:03:53', '2021-05-17 06:27:19'),
(27, 'Reveedren Theethappan', NULL, NULL, '60196698925', NULL, 'revee60@gmail.com', '$2y$10$EvzEFQ9LNyIgn3f8X5BjFOhe1YN6RHzZ2K45dn9MHQVLwqGE2YzWa', 1, '1620626047-Qp3pPv83p8C5ggZqnZhL0Hf8hi70icrVQl1WEUTXOQDxRKVv6ignFqVTYrBdGPLRvdcxq2-6098ca7f10738-d8ye', NULL, 'reveedrentheethappan', 10, '2021-05-10 05:55:27', NULL, '2021-05-10 05:54:07', '2021-05-17 06:27:10'),
(28, 'Uda shanker', NULL, NULL, '60178732131', NULL, 'udashanker61@gmail.com', '$2y$10$Qd/DYwURfS21HLCnVtSqqO4RUkSSAZfASUstwFgwyivOoI/FY4BRm', 1, '1620628656-J4JLq55yU4a30ekKeMffH2ccpJUtVn8x5V54bDK23oFyan1pMCgOuvSOh2zpF4EBi3CAPp-6098d4b079320-R4uo', 'MbGTKyHSsrBk69uK07QzYzGtyJDa7Z03aFmg644lt8r8rWVN3hjKjtnrJVFN', 'udashanker', 27, '2021-05-17 06:21:47', NULL, '2021-05-10 06:37:36', '2021-05-17 06:27:02'),
(29, 'HARINAAT CHANDRAN A/L V K SUPPIAH', NULL, NULL, '0164049494', NULL, 'chandranalvksuppiah@gmail.com', '$2y$10$TYp3UM5NdSXJeFrq8tKQDuR16BE7wSaPIY6eqYFCdj07qQ7VtHy3O', 1, '1620637831-wKp6Yz0uXUsGbDNVdeN8jxGWej9haxJPKUDDWx7DBG6t865mqngaJkJmP2WLmFPiFHzm5U-6098f88728760-C30t', 'PlqU3oAivb5G0MUGL1X1vWDVFu0c2pCGbwqkyDuxNk3UwVufxwxTosKBzlgD', 'harinaatchandrana/lvksuppiah', 10, '2021-05-10 13:28:27', NULL, '2021-05-10 09:10:31', '2021-05-17 06:26:53'),
(30, 'Gnanasegaran A/L Subaramany @ Subramaniam', NULL, NULL, '601126360714', NULL, 'ganaseg197@gmail.com', '$2y$10$b9y1dt5.y2gKhjVHDY2Zv.AV7ZD98QgAOy4fY.RlXJeTqvwUfKPze', 1, '1620704059-7RcAIJ7V0Q6vscfnvdneb53nFXRctty68SceVmwcmvpKoDU3QT9HyhmjkxLukqZxDxtiPP-6099fb3bcf807-uX3m', 'mFjm31De8VKTkJi14XYe4wCB1ZEqXbdd2AJeCMIh5v0zy9R3ePZUqg1wrhEL', 'gnanasegarana/lsubaramany@subramaniam', 10, '2021-05-11 06:08:57', NULL, '2021-05-11 03:34:19', '2021-05-17 06:26:44'),
(31, 'Thiagaraj Jaigobi', NULL, NULL, '0149048057', NULL, 'drum_thiagu@yahoo.com', '$2y$10$9R9n.QL6oXhizijynbgmbuJEtckcQdztcoBBYne7lLdtfoBE/xrxS', 1, '1620715533-Me1darN9KaZMv7YMcjdKBGQ9hyB9Jtqza75VqVnU24RNwKHzxpaRL98scspym21wTkUXoP-609a280d8c4a8-E9WY', 'kZpUfWWpT5dBDpF66PDNlRosx2V4doghPM1b2lAoHzkWeYnJFAHH47wPhIoA', 'thiagarajjaigobi', 10, '2021-05-17 06:21:40', NULL, '2021-05-11 06:45:33', '2021-05-17 06:21:40'),
(32, 'RAVIKIRAN', NULL, NULL, '9642550905', NULL, 'ravikiran647@gmail.com', '$2y$10$u9MICdxvo9QFDySizBM5vuc.mBBqsvMjFm5Tlx3R02aLA/c5xkWGq', 1, '1620744663-sSO2XkoI2N0b5GPaPEozsdK40EXbJDQnZ8okdBl00hQSMTn0XSe6Ac2Mq6chbGhKYtOgDy-609a99d71262d-lIvG', 'kWB9K51egIgnCY9uNoZJqvMV1oprxgSQL2o2BaBtnyJbVL7Ey8SNxYrKQEup', 'ravikiran', 10, '2021-05-11 16:58:03', NULL, '2021-05-11 14:51:03', '2021-05-17 06:26:34'),
(33, 'Prabakaran', NULL, NULL, '0149922851', NULL, 'm.7.prabakaran@gmail.com', '$2y$10$cXk0mlWyrivO2HOE5cQ75u8WV7bvzQ4AdoH8xxcHdwWn.OcOEJdPu', 1, '1620832972-lBo7DCsKJzYxQCx4n9gffThtPdMAyrEq3cBcgAPa2FBJd9XImHbOxv5v9MBB7vJ6oRbqoL-609bf2cc47969-n6X9', 'KozqQXEgxW8RlgteJpFGhXKiitLetJxpJlP3LxJzd1whlQUdHPE1LUV7r0gj', 'prabakaran', 10, '2021-05-12 15:24:18', NULL, '2021-05-12 15:22:52', '2021-05-17 06:26:26'),
(34, 'BenzChin', NULL, NULL, '0198786727', NULL, 'benchin2678@gmail.com', '$2y$10$zu5HHvlNgik17ZFci6OQhe1AXi.Fq/vGTrJf1PlemhxCw3brd9nL2', 1, '1620887607-D0rKsZRzX7txfPYbsmaosUxOCR1pHapYN5T8ZXG8S1kIQNzEVASc6jngclTf7IvdpZOGEG-609cc837e994b-IsKg', 'QVkVJy1Bbows0e8lcBTFb9ExAnV38aW1MgYKPW6NNsqYR6bLimn2jcsGfQPF', 'benzchin', 12, '2021-05-13 06:35:04', NULL, '2021-05-13 06:33:27', '2021-05-17 06:26:16'),
(35, 'Andy', NULL, NULL, '+60128993018', NULL, 'bigsweep33@yahoo.com', '$2y$10$2TDUdHdylE5QU.M3wQDVo.zghrvUbXYK0/Lakm7.CmFUiOASGBui2', 1, '1620900360-9oxwQKGPLv5hL3dh14GI4ke6fmK55WkgvotkZYkzl0h7xpl90eSdYVGz0A5OxF7Hkj0RZi-609cfa0849461-l9s9', '8xUjgOd4TlG1YB7oRvzj2pkjFAmz2gy4Th0XewdMc8U29u6WVnAPIDF2zcyu', 'andy', 24, '2021-05-17 06:20:30', NULL, '2021-05-13 10:06:00', '2021-05-17 06:20:30'),
(36, 'Andy Bong', NULL, NULL, '60128993018', NULL, 'bigsweep333@yahoo.com.sg', '$2y$10$X8taPfcSeor6dwok8MZaDeTpaqZcQhdxgPTpblT.mFRJNmxmdnPd.', 1, '1620904832-JlNWD1iPQ1iZIpPxVC0itbgO6KpgMcnY8ds74zl2WDAACNY8qF52IhgMCRWn2FV4JS71Xa-609d0b805c6aa-Zluq', NULL, 'andybong', 24, '2021-05-17 06:20:23', NULL, '2021-05-13 11:20:32', '2021-05-17 06:25:50'),
(37, 'Piyali Pandit', NULL, NULL, '5896587458', NULL, 'panditpiyali6@gmail.com', '$2y$10$Q.o/XBre0ppxCBz5kIs78OLH9NGqo5cN9dXZMv8ufhostTyKY5cV2', 1, '1620906218-pPyUFT3yuKQfzVWw2IitShjDAmYUS5tDHyzX6ZRDXoOq3zjygYBjE2SIDcvy2rKDQtn7Hh-609d10ea37d82-ZGhv', '4G1sNuUhXzw7NKFMbInneMnvksauD6E8czB5j8Nb5NVN65vcjcuQQ7g7oVye', 'piyalipandit', 1, '2021-05-14 11:34:13', NULL, '2021-05-13 11:43:38', '2021-05-14 11:34:13'),
(38, 'HM KAH', NULL, NULL, '+60146211261', NULL, 'blueteamist@gmail.com', '$2y$10$O4PHNURdP9uttyiaqvUq0.L75fQGAsnuvEkZzUma18T9yGybdf4hW', 1, '1620906279-KLypMKg3455hSvKgGCpzdadKQRyHBI7fCOPZNedSLIFA6MTbfVGYao3U2Gv3sAK9EGnJpl-609d1127e7596-GhWq', '7uX63QD2Gp4Um4Ho5P3GwksGQJxyrzl555EAwHnTGEuYteAV3TUofXUhJtbk', 'hmkah', 13, '2021-05-13 11:44:47', NULL, '2021-05-13 11:44:39', '2021-05-18 03:22:56'),
(39, 'HIO MY', NULL, NULL, '60162081261', NULL, 'coinpercuma@gmail.com', '$2y$10$t1SmzF.YoecMSEXyjrf6KuJ0WAiAnlG3WIE5SQCorKQlM2AT9yTom', 1, '1620906678-pfA6v22Humx1ijuXsM89CIAzRJoIgsAEjdpWPDU6g82uiVT8evuPtNfhobnqmhMxfpGblV-609d12b6e3ede-fA85', 'edgNUloHm5tfZQJxYqpz93VylKCTSLvwFEGfGOeAoaNKbfPCalToK54aZXMx', 'hiomy', 38, '2021-05-13 11:51:25', NULL, '2021-05-13 11:51:18', '2021-05-18 03:25:45'),
(40, 'Ratanie Logeswaran', NULL, NULL, '60188745532', NULL, 'logeswaran23@yahoo.com', '$2y$10$NXpIQcBKL6jloi/yF1acX.fDB6RbMGCIvinbHAWueDELQhXe5lrIu', 1, '1620911919-IuVBkKKtEj0UUoM1HuYrSTgADJcMudailfSi5Q0qoFSjvTYxevly0XqpZINYXPRLfmdhY1-609d272f7b311-ePWu', NULL, 'ratanielogeswaran', 10, '2021-05-17 06:21:18', NULL, '2021-05-13 13:18:39', '2021-05-17 06:21:18'),
(41, 'Kelvin kwa', NULL, NULL, '0168283235', NULL, 'kiwikwa1@gmail.com', '$2y$10$6oCkBnd8fruQoo.1wNROgu/Wp7NjGkSBmfu1Ch2wV5kjFipwyY2jy', 1, '1620913024-T9NZarx20tkVCkeaFA6TY6PFhtHByLUYpBGNCRdZ0TjHZjqQmiSY6zyeGSVKeTzKvLH4lW-609d2b808b666-T9k5', 'xMN5mVG2rwuoM8llPMprgtwOiIaGCT9IL6x7pqI7GdzcR7CvZoS84q1UopjX', 'kelvinkwa', 12, '2021-05-13 13:37:13', NULL, '2021-05-13 13:37:04', '2021-05-17 06:25:06'),
(42, 'Piyali', NULL, NULL, '5866585785', NULL, 'panditpiyali61@yahoo.com', '$2y$10$GCi1SsNztPlSn3TfjEDQMezvuYOEGzPoYBEAI7Lxs7rGrYz6i1r3K', 1, '1620913550-dCBOjAaohSMyn2DXOYjrro2KbYiSRIoTRajtmlX7jX959HNQaf74j42GQWeTJvsUV1AHO8-609d2d8ee69a4-l6wa', 'hZtvoN6xxa0DMYRBXRvr4TQzKe1buWfQ6cjIbHgLfBtCcHtfnM2VyxOr5bXb', 'piyali', 1, NULL, NULL, '2021-05-13 13:45:50', '2021-05-13 13:45:50'),
(43, 'Ed Asmadi Mohd Saidin', NULL, NULL, '01118774348', NULL, 'ed.asmadi@gmail.com', '$2y$10$qDowjJ/4U0DlVsep63YAAuPKvvwyiikjxzuX871pSiXlkOftXnfm.', 1, '1620926710-peSJFjwBzf0U9NSs1Qan53ZdubZQHJZkdsweer0Wwo7TgfSW2SBNxp1XlsdlbKAZEVaulL-609d60f67e3b9-raMu', NULL, 'edasmadimohdsaidin', 14, '2021-05-13 17:31:14', NULL, '2021-05-13 17:25:10', '2021-05-17 06:24:31'),
(44, 'Sandiyavoo', NULL, NULL, '+60192765136', NULL, 'sandiyavoo@gmail.com', '$2y$10$fdYNlS4P82w41h7qynjUSOvZgZOzrrhk6ruxFFoVay.yNueFVC5P2', 1, '1621251105-dhF1JM6THfGQIY9WN13JY6dgR1lzWaFyOMEi0oWUk4xF9pHjlYkFAJ6heFVQ0M3nzA1Aq4-60a25421b79fd-gcv0', 'Nw3SgQsgFt4IWXEPwdXlSkjNjyXYQBMf0wbff2uZNfca3ltbWuEOQ9wiHAR2', 'sandiyavoo', 16, '2021-05-17 13:23:02', NULL, '2021-05-17 11:31:45', '2021-05-17 13:23:02'),
(45, 'pandit piyali', NULL, NULL, '2545856552', NULL, 'panditpiyali@gmail.com', '$2y$10$bQ9R8Gc/DawBBc7ArjvYmOo.uINY1GY68M/Qm7Ukq3Vemr54Co6qO', 1, '1621257321-qGfiu4hLIuz0UzaqZlSkRGJfzjpuBCd0gDRwLfzJBvDKQlwbxdQky5cbO1cIr0nfR6pKen-60a26c6921a46-a5Mt', NULL, 'panditpiyali', 1, NULL, NULL, '2021-05-17 13:15:21', '2021-05-17 13:15:21'),
(46, 'pandit piyali', NULL, NULL, '9876584585', NULL, 'panditpiyali61@gmail.com', '$2y$10$4RCeM281qn0ORluQ.xCI2.HvTELVbmS3eiJYmgA6ZadBvLmsfRJBS', 1, '1621257464-wnX0wKLES7uj64s7zMS216X1lIAamo4TqAKwKntdqGBqximAgHaGa6dqmeI6O21eVcCCSe-60a26cf8f09d0-GAxj', NULL, 'panditpiyali_2', 1, '2021-05-17 13:17:44', NULL, '2021-05-17 13:17:44', '2021-05-17 13:17:44'),
(47, 'Samuel Devacharyam', NULL, NULL, '0172367725', NULL, 'sddeva43@gmail.com', '$2y$10$EBiuCPRWF0gC3UO0MG3QfOsmWA4JINzpnKjWv4J0ZrU5K3bCCy8I2', 1, '1621333262-qHewcfRIGxtYopfaeT5jQalR0W416KnSKicePtz3JtP0NNcp9T62aoebV8Gk9qD809SySd-60a3950e06544-RTDx', NULL, 'samueldevacharyam', 44, '2021-05-18 10:21:02', NULL, '2021-05-18 10:21:02', '2021-05-18 10:21:02'),
(48, 'THAVARAM', NULL, NULL, '+60136813534', NULL, 'thavaramk@gmail.com', '$2y$10$WJxHf4kPzusBVWHFbfMBuu2qkl.ctgabAiG0.dZ4hiDSn81lnqdjG', 1, '1621433721-5NPbdMjmT9c8nRSCOyiEe2uS4RMK91xBjGvSdkr2hflAws5EP3hVUDMnqlRCOk75Ogwytt-60a51d7936312-pr90', 'PlH56tkokzLuGkStFLaZiAKpM7GxArUl2KvzxjFYfji41HxIMqKnZluW28ka', 'thavaram', 10, '2021-05-19 14:15:21', NULL, '2021-05-19 14:15:21', '2021-05-19 14:23:34'),
(49, 'SIVARAM RAJENDRAN', NULL, NULL, '0149942338', NULL, 'maravis.murlc87@gmail.com', '$2y$10$.7eJWiO5Wb02MppF4eaApOsSKB2GQ4GcNo2QAlis1yKbQCiGjcr.a', 1, '1621489410-ZYRMaWeP027OblNPS2KEcK2hB2kLYHp9SoVmNNgXD5MtdLPi4TkF7X946TpgWkfpjTcS7f-60a5f702ebf5e-ZCkP', 'IGbEeUeUbvBX0b7tH2red6rwcU5syZsytNLP8YO4Z54nwh2Bibyg3vQb5FZZ', 'sivaramrajendran', 10, '2021-05-20 05:43:30', NULL, '2021-05-20 05:43:30', '2021-05-20 05:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_metas`
--

CREATE TABLE `user_metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `meta_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_metas`
--

INSERT INTO `user_metas` (`id`, `user_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 12, 'google2fa', 'OKQSRM2GV5R3O5JU', '2021-05-07 13:19:18', '2021-05-07 13:19:18'),
(2, 12, 'google2fa_on', 'off', '2021-05-07 13:19:18', '2021-05-07 13:19:18'),
(3, 14, 'google2fa', 'GBEF2HAGK7NQBCNN', '2021-05-07 18:15:54', '2021-05-07 18:15:54'),
(4, 14, 'google2fa_on', 'off', '2021-05-07 18:15:54', '2021-05-07 18:15:54'),
(5, 19, 'google2fa', 'QEAVXUXP5MP7D2MR', '2021-05-08 07:22:51', '2021-05-08 07:22:51'),
(6, 19, 'google2fa_on', 'off', '2021-05-08 07:22:51', '2021-05-08 07:22:51'),
(7, 32, 'google2fa', 'PWU7RUUGEVMDEOEP', '2021-05-12 06:14:19', '2021-05-12 06:14:19'),
(8, 32, 'google2fa_on', 'off', '2021-05-12 06:14:19', '2021-05-12 06:14:19'),
(9, 10, 'google2fa', 'ZTDX527X5UDRBD2M', '2021-05-12 07:46:50', '2021-05-12 07:46:50'),
(10, 10, 'google2fa_on', 'off', '2021-05-12 07:46:50', '2021-05-12 07:46:50'),
(11, 13, 'google2fa', 'PAIKUPT4N46OWIBW', '2021-05-12 18:00:42', '2021-05-12 18:00:42'),
(12, 13, 'google2fa_on', 'off', '2021-05-12 18:00:42', '2021-05-12 18:00:42'),
(13, 38, 'google2fa', 'RCUGAKAKRZWDKHBM', '2021-05-13 11:58:08', '2021-05-13 11:58:08'),
(14, 38, 'google2fa_on', 'off', '2021-05-13 11:58:08', '2021-05-13 11:58:08'),
(15, 1, 'google2fa', 'WUST2ZRF2V3RXBOB', '2021-05-14 04:37:20', '2021-05-14 04:37:20'),
(16, 1, 'google2fa_on', 'off', '2021-05-14 04:37:20', '2021-05-14 04:37:20'),
(17, 23, 'google2fa', '5T7WNSB5HGKUZQG7', '2021-05-15 18:58:04', '2021-05-15 18:58:04'),
(18, 23, 'google2fa_on', 'off', '2021-05-15 18:58:04', '2021-05-15 18:58:04'),
(19, 39, 'google2fa', 'C3UL4RTOH32VTLGA', '2021-05-18 03:26:28', '2021-05-18 03:26:28'),
(20, 39, 'google2fa_on', 'off', '2021-05-18 03:26:28', '2021-05-18 03:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `net_amount` double NOT NULL,
  `fees` double NOT NULL,
  `remarks` mediumtext COLLATE utf8_unicode_ci,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `t_hash` mediumtext COLLATE utf8_unicode_ci,
  `decline_reason` mediumtext COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `BankDeposits`
--
ALTER TABLE `BankDeposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charges_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `coin_addresses`
--
ALTER TABLE `coin_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `cp_ipns`
--
ALTER TABLE `cp_ipns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_ipns_ipn_id_unique` (`ipn_id`);

--
-- Indexes for table `cp_log`
--
ALTER TABLE `cp_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transactions_txn_id_unique` (`txn_id`);

--
-- Indexes for table `cp_transfers`
--
ALTER TABLE `cp_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transfers_ref_id_unique` (`ref_id`);

--
-- Indexes for table `cp_withdrawals`
--
ALTER TABLE `cp_withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_withdrawals_ref_id_unique` (`ref_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_coin_details`
--
ALTER TABLE `deposit_coin_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `envs`
--
ALTER TABLE `envs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_code_unique` (`code`),
  ADD KEY `invoices_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_author_id_foreign` (`author_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `presales`
--
ALTER TABLE `presales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profiles_ide_no_unique` (`ide_no`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `recipients`
--
ALTER TABLE `recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipients_user_id_foreign` (`user_id`),
  ADD KEY `recipients_message_id_foreign` (`message_id`);

--
-- Indexes for table `roi_investments`
--
ALTER TABLE `roi_investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roi_plans`
--
ALTER TABLE `roi_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickers`
--
ALTER TABLE `tickers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `track_logins`
--
ALTER TABLE `track_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_verification_token_unique` (`verification_token`),
  ADD UNIQUE KEY `users_referral_unique` (`referral`),
  ADD UNIQUE KEY `users_phone_no_username_email_unique` (`phone_no`,`username`,`email`),
  ADD UNIQUE KEY `users_phone_no_unique` (`phone_no`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_metas`
--
ALTER TABLE `user_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_metas_user_id_foreign` (`user_id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BankDeposits`
--
ALTER TABLE `BankDeposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `coin_addresses`
--
ALTER TABLE `coin_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `cp_ipns`
--
ALTER TABLE `cp_ipns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `cp_log`
--
ALTER TABLE `cp_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cp_transfers`
--
ALTER TABLE `cp_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_withdrawals`
--
ALTER TABLE `cp_withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `deposit_coin_details`
--
ALTER TABLE `deposit_coin_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `email_otps`
--
ALTER TABLE `email_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `envs`
--
ALTER TABLE `envs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presales`
--
ALTER TABLE `presales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `recipients`
--
ALTER TABLE `recipients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roi_investments`
--
ALTER TABLE `roi_investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roi_plans`
--
ALTER TABLE `roi_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tickers`
--
ALTER TABLE `tickers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track_logins`
--
ALTER TABLE `track_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_metas`
--
ALTER TABLE `user_metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
