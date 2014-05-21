-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 7, 2014 at 12:20 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.25

-- --------------------------------------------------------

--
-- Table structure for table `user_account_balance`
--

DROP TABLE IF EXISTS `user_account_balance`;
CREATE TABLE `user_account_balance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_request`
--

DROP TABLE IF EXISTS `withdrawal_request`;
CREATE TABLE `withdrawal_request` (
  `withdraw_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `added_date` datetime NOT NULL,
  `status` enum('Pending','Rejected','Paid') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`withdraw_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;