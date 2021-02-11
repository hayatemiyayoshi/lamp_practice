-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 2 月 8 日 23:35
-- サーバのバージョン： 5.7.27
-- PHP のバージョン: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 'histories' 

CREATE TABLE 'histories' (
   'order_id' int(11) NOT NULL AUTO_INCREMENT,
   'user_id' int(11) NOT NULL,
   'created' datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `details`
--

CREATE TABLE 'details' (
   'detail_id' int(11) NOT NULL AUTO_INCREMENT,
   'order_id' int(11) NOT NULL,
   'item_id' int(11) NOT NULL,
   'price' int(11) NOT NULL,
   'amount' int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのインデックス `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`order_id`),

--
-- テーブルのインデックス `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`detail_id`),