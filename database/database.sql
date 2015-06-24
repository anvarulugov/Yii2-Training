-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2015 at 06:26 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1431609647),
('m130524_201442_init', 1431609650);

-- --------------------------------------------------------

--
-- Table structure for table `postmeta`
--

CREATE TABLE IF NOT EXISTS `postmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) DEFAULT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `posts_meta_postid_fkey_idx` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `postmeta`
--

INSERT INTO `postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(42, 79, 'test_meta', 'asdfasdf asdfasd ************'),
(53, 79, 'dgfdgdgdf', 'asdf adsfasdf ------------- +'),
(65, 79, 'source', 'asdfasdf asdf + asdf'),
(67, 91, 'source', 'test hello'),
(68, 0, 'source', 'http://azamat.uz'),
(69, 94, 'test_meta', 'http://azamat.uz'),
(70, 94, 'source', '123');

-- --------------------------------------------------------

--
-- Table structure for table `postmeta_lang`
--

CREATE TABLE IF NOT EXISTS `postmeta_lang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `meta_id` bigint(20) NOT NULL,
  `meta_lang` varchar(6) NOT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `postmeta_lang`
--

INSERT INTO `postmeta_lang` (`id`, `meta_id`, `meta_lang`, `meta_value`) VALUES
(1, 70, 'en', 'en value2'),
(2, 70, 'uz', 'hhghjfhj'),
(3, 70, 'ru', '1325646'),
(4, 69, 'uz', 'russian'),
(5, 69, 'ru', 'uzbek'),
(6, 69, 'en', 'http://azamat.uz'),
(7, 70, 'en', '123');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_parent` bigint(20) DEFAULT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_author` bigint(20) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_title` text,
  `post_content` longtext,
  `post_password` varchar(200) DEFAULT NULL,
  `post_modified` datetime DEFAULT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'published',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `comment_status` varchar(20) DEFAULT NULL,
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `post_name_UNIQUE` (`post_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `post_parent`, `post_name`, `post_author`, `post_date`, `post_title`, `post_content`, `post_password`, `post_modified`, `post_status`, `post_type`, `comment_status`, `comment_count`) VALUES
(79, NULL, 'toshkent-wiloyatida-sodir-bulgan-iul-transport-hodisasi-natijasida-4-kishi-haetdan-kuz-yumdi-59', 1, '2015-05-19 00:00:00', 'Тошкент вилоятида содир бўлган йўл-транспорт ҳодисаси натижасида 4 киши ҳаётдан кўз юмди', '<h3>asdf asdf asd <strong>fasd </strong><span style="color:#FFFF00"><span style="background-color:#B22222">fasd </span></span><em>fasdfasdfasd </em><u>fasdfasdfa </u><s>sdfasd</s></h3>\r\n', '', '2015-06-14 17:27:54', 'default', 'post', 'default', 0),
(91, NULL, 'asdfasd', 1, '2015-06-14 17:42:23', 'asdfasd', 'asdfa', '', '2015-06-14 17:44:08', 'default', 'post', 'default', 0),
(93, NULL, 'asdf-asdf-asdf', 1, '2015-06-15 20:41:58', 'asdf asdf asdf', 'asdf asdfasdf', '', '2015-06-15 20:42:18', 'default', 'post', 'default', 0),
(94, NULL, 'boshqa-edit-qilingan-title-yozdim', 1, '2015-06-15 20:43:05', 'Boshqa edit qilingan title yozdim', 'Test post maqola matni...', '', '2015-06-20 09:02:00', 'public', 'post', 'default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts_lang`
--

CREATE TABLE IF NOT EXISTS `posts_lang` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `post_lang` varchar(6) NOT NULL,
  `post_title` text,
  `post_content` longtext,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `posts_lang`
--

INSERT INTO `posts_lang` (`ID`, `post_id`, `post_lang`, `post_title`, `post_content`) VALUES
(21, 94, 'uz', 'uz title', 'uz content'),
(22, 94, 'ru', 'ru ttile', 'ru content'),
(23, 94, 'en', 'Boshqa edit qilingan title yozdim', 'Test post maqola matni...');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `term_id` int(7) NOT NULL AUTO_INCREMENT,
  `term_parent` int(7) DEFAULT NULL,
  `term_name` varchar(255) NOT NULL,
  `term_title` text,
  `term_description` text,
  `term_frequency` int(9) DEFAULT NULL,
  `term_language` varchar(10) DEFAULT NULL,
  `term_type` varchar(100) NOT NULL DEFAULT 'tag',
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_id`, `term_parent`, `term_name`, `term_title`, `term_description`, `term_frequency`, `term_language`, `term_type`) VALUES
(1, NULL, 'news', 'News', 'News category', 0, 'en', 'category'),
(2, NULL, 'articles', 'Articles', 'Articles category description', 0, '', 'category'),
(3, NULL, 'sport', 'Sport', NULL, 0, 'en', 'tag'),
(44, NULL, 'tag1', 'Tag1', NULL, 0, NULL, 'tag'),
(51, NULL, 'test-test', 'Test test', NULL, 0, NULL, 'tag'),
(52, NULL, 'test-test', 'Test-test', NULL, 0, NULL, 'tag'),
(54, NULL, 'hello-baby', 'Hello baby', NULL, 0, NULL, 'tag'),
(55, NULL, 'comma', 'Comma', NULL, 0, NULL, 'tag'),
(56, NULL, 'separated', 'Separated', NULL, 0, NULL, 'tag'),
(57, NULL, 'tags', 'Tags', NULL, 0, NULL, 'tag');

-- --------------------------------------------------------

--
-- Table structure for table `term_relations`
--

CREATE TABLE IF NOT EXISTS `term_relations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) NOT NULL,
  `term_id` int(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`object_id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=510 ;

--
-- Dumping data for table `term_relations`
--

INSERT INTO `term_relations` (`id`, `object_id`, `term_id`) VALUES
(425, 79, 1),
(426, 79, 2),
(427, 79, 3),
(428, 79, 44),
(429, 79, 51),
(454, 91, 1),
(455, 91, 54),
(456, 93, 1),
(505, 94, 1),
(506, 94, 2),
(507, 94, 55),
(508, 94, 56),
(509, 94, 57);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '7T1Y5wZWQxBpqqOc2kllZh28A3Nryl1_', '$2y$13$8R8OZRWgwS.daGM3903THOG/rXYFtpqDbxUoFEtHwnmmkYm8ts8yS', NULL, 'admin@admin.loc', 10, 1431609655, 1431609655),
(2, 'test', 'DzN4g9cTgz4LFCSKmTo2PNlkjKVqsA3k', '$2y$13$8R8OZRWgwS.daGM3903THOG/rXYFtpqDbxUoFEtHwnmmkYm8ts8yS', NULL, 'admin@admin.com', 10, 1434285066, 1434285066);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `term_relations`
--
ALTER TABLE `term_relations`
  ADD CONSTRAINT `term_relations_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_relations_ibfk_2` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
