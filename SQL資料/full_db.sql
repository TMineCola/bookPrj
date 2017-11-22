-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2017 年 11 月 22 日 03:26
-- 伺服器版本: 10.1.25-MariaDB
-- PHP 版本： 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `se_mid`
--

-- --------------------------------------------------------

--
-- 資料表結構 `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `msg` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uID` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `push` int(11) NOT NULL DEFAULT '0',
  `seen` int(255) NOT NULL DEFAULT '0',
  `language` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `book`
--

INSERT INTO `book` (`id`, `title`, `msg`, `uID`, `author`, `push`, `seen`, `language`) VALUES
(4, 'new book', 'good !!!!', '1', 'ABCC', 4, 13, 1),
(5, '657575757576', '765765765765', '2', 'JCC', 2, 5, 3),
(8, 'OldManAndSea', 'JJ Lin', '1', 'Cola', 0, 8, 0),
(9, '摳你機哇', '霓虹得斯', '1', 'Message', 1, 1, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `bkID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `msg` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `comment`
--

INSERT INTO `comment` (`id`, `bkID`, `uID`, `msg`) VALUES
(2, 4, 1, '87678689769876'),
(9, 5, 2, 'CC'),
(10, 5, 2, 'CC');

-- --------------------------------------------------------

--
-- 資料表結構 `push`
--

CREATE TABLE `push` (
  `number` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `bkID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `push`
--

INSERT INTO `push` (`number`, `uID`, `bkID`) VALUES
(2, 1, 4),
(3, 1, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `unpush`
--

CREATE TABLE `unpush` (
  `number` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `bkID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `unpush`
--

INSERT INTO `unpush` (`number`, `uID`, `bkID`) VALUES
(1, 1, 4);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `loginID` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(10) NOT NULL,
  `push` int(11) NOT NULL DEFAULT '0',
  `Admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`id`, `loginID`, `password`, `name`, `push`, `Admin`) VALUES
(1, 'jc', '123', 'JH', 0, 1),
(2, 'user', '123', 'Beauty', 0, 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `push`
--
ALTER TABLE `push`
  ADD PRIMARY KEY (`number`);

--
-- 資料表索引 `unpush`
--
ALTER TABLE `unpush`
  ADD PRIMARY KEY (`number`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用資料表 AUTO_INCREMENT `push`
--
ALTER TABLE `push`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `unpush`
--
ALTER TABLE `unpush`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
