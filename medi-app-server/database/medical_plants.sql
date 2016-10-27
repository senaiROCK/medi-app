-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2016 at 12:36 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical_plants`
--

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `plant_id` int(11) NOT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `plant_scientific_name` varchar(50) NOT NULL,
  `plant_description` text,
  `plant_pic` varchar(100) NOT NULL,
  `plant_created` varchar(50) DEFAULT NULL,
  `plant_updated` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`plant_id`, `plant_name`, `plant_scientific_name`, `plant_description`, `plant_pic`, `plant_created`, `plant_updated`) VALUES
(24, 'Senai ROCK', 'senayrakon', 'It can help you rock and roll to the world !', 'senaiROCK.jpg', 'October 27, 2016, 6:25 am', 'October 27, 2016, 6:35 am'),
(25, 'The Code', 'dacoderon', 'It will help you write code !', 'code.jpg', 'October 27, 2016, 6:31 am', 'October 27, 2016, 6:35 am');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) DEFAULT NULL,
  `user_email_address` varchar(100) DEFAULT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_firstname` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `user_profile_photo` varchar(100) NOT NULL DEFAULT 'user_default.png',
  `user_is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_email_address`, `user_password`, `user_firstname`, `user_lastname`, `user_profile_photo`, `user_is_admin`, `user_created`, `user_updated`) VALUES
(1, 'hans', 'hans.nanol@gmail.com', '123', 'Hans Louie', 'Nanol', 'fuck_you.jpg', 1, '2016-10-15 04:12:57', '0000-00-00 00:00:00'),
(2, 'user', 'user@gmail.com', '123', 'User First', 'User Last', 'user_default.png', 0, '2016-10-26 18:28:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`plant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`user_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `plant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
