-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2017 at 12:20 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `congvan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_assignment`
--

CREATE TABLE `nv4_vi_dispatch_assignment` (
  `id` mediumint(8) NOT NULL,
  `id_dispatch` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_department` mediumint(8) UNSIGNED NOT NULL,
  `assingtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `completiontime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `userid_command` mediumint(8) NOT NULL DEFAULT '0',
  `userid_follow` mediumint(8) NOT NULL DEFAULT '0',
  `userid_perform` mediumint(8) NOT NULL DEFAULT '0',
  `work_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_department`
--

CREATE TABLE `nv4_vi_dispatch_department` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `depcatid` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` smallint(4) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_department_cat`
--

CREATE TABLE `nv4_vi_dispatch_department_cat` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` smallint(4) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_fields`
--

CREATE TABLE `nv4_vi_dispatch_fields` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_follow`
--

CREATE TABLE `nv4_vi_dispatch_follow` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `id_dispatch` int(11) NOT NULL,
  `id_department` mediumint(8) NOT NULL,
  `list_userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeview` int(11) NOT NULL,
  `list_hitstotal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_rows`
--

CREATE TABLE `nv4_vi_dispatch_rows` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL,
  `idfield` tinyint(4) NOT NULL,
  `idtype` tinyint(4) NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ signer` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_initial` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_important` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `number_dispatch` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_text_come` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `sendtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `receivetime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `processingtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `recipient` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `term_view` int(11) NOT NULL DEFAULT '0',
  `reply` tinyint(4) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_type`
--

CREATE TABLE `nv4_vi_dispatch_type` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nv4_vi_dispatch_user`
--

CREATE TABLE `nv4_vi_dispatch_user` (
  `userid` mediumint(8) UNSIGNED NOT NULL,
  `iddepart` mediumint(8) NOT NULL DEFAULT '0',
  `office` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nv4_vi_dispatch_assignment`
--
ALTER TABLE `nv4_vi_dispatch_assignment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_dispatch` (`id_dispatch`,`id_department`);

--
-- Indexes for table `nv4_vi_dispatch_department`
--
ALTER TABLE `nv4_vi_dispatch_department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depcatid` (`depcatid`,`weight`);

--
-- Indexes for table `nv4_vi_dispatch_department_cat`
--
ALTER TABLE `nv4_vi_dispatch_department_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weight` (`weight`);

--
-- Indexes for table `nv4_vi_dispatch_fields`
--
ALTER TABLE `nv4_vi_dispatch_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nv4_vi_dispatch_follow`
--
ALTER TABLE `nv4_vi_dispatch_follow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_dispatch` (`id_dispatch`,`id_department`);

--
-- Indexes for table `nv4_vi_dispatch_rows`
--
ALTER TABLE `nv4_vi_dispatch_rows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idfield` (`idfield`,`idtype`);

--
-- Indexes for table `nv4_vi_dispatch_type`
--
ALTER TABLE `nv4_vi_dispatch_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nv4_vi_dispatch_user`
--
ALTER TABLE `nv4_vi_dispatch_user`
  ADD UNIQUE KEY `userid` (`userid`,`iddepart`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_assignment`
--
ALTER TABLE `nv4_vi_dispatch_assignment`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_department`
--
ALTER TABLE `nv4_vi_dispatch_department`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_department_cat`
--
ALTER TABLE `nv4_vi_dispatch_department_cat`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_fields`
--
ALTER TABLE `nv4_vi_dispatch_fields`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_follow`
--
ALTER TABLE `nv4_vi_dispatch_follow`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_rows`
--
ALTER TABLE `nv4_vi_dispatch_rows`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nv4_vi_dispatch_type`
--
ALTER TABLE `nv4_vi_dispatch_type`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
