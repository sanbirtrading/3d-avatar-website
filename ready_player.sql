-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2022 at 05:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ready_player`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_ready_id` text NOT NULL,
  `user_glb_file_url` text NOT NULL,
  `user_background` text NOT NULL,
  `notes` text NOT NULL,
  `internal_glb_path` text NOT NULL,
  `recipient_from` text NOT NULL,
  `recipient_to` text NOT NULL,
  `phone_number` int(11) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_ready_id`, `user_glb_file_url`, `user_background`, `notes`, `internal_glb_path`, `recipient_from`, `recipient_to`, `phone_number`, `color`) VALUES
(1, '62a06bdcfb2c1f000986c0e1', 'https://d1a370nemizbjq.cloudfront.net/8a6632ac-595e-43e9-965a-73a0087da645.glb', 'backgroundImages/Picture1.webp', '', 'capturedFile/62a06bdcfb2c1f000986c0e1/8a6632ac-595e-43e9-965a-73a0087da645.glb', '', '', 0, '#000000'),
(2, '62a5f0ed7e1e930009755c99', 'https://d1a370nemizbjq.cloudfront.net/ec76036c-fb38-4f3c-b539-f68525fae598.glb', 'backgroundImages/Picture1.png', '', 'capturedFile/62a5f0ed7e1e930009755c99/ec76036c-fb38-4f3c-b539-f68525fae598.glb', '', '', 0, '#000000'),
(3, '62c023694e188b000950cf84', 'https://d1a370nemizbjq.cloudfront.net/ec66026b-4eae-47dd-9b10-77eaa34b10ae.glb', 'backgroundImages/Picture1.webp', '', 'capturedFile/62c023694e188b000950cf84/ec66026b-4eae-47dd-9b10-77eaa34b10ae.glb', '', '', 0, '#000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
