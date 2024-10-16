-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 02:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatroom`
--

CREATE TABLE `chatroom` (
  `id` int(11) NOT NULL,
  `userid_1` int(11) NOT NULL,
  `userid_2` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1,
  `isFollowed` int(11) NOT NULL DEFAULT 0,
  `user_left` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatroom`
--

INSERT INTO `chatroom` (`id`, `userid_1`, `userid_2`, `timestamp`, `isActive`, `isFollowed`, `user_left`) VALUES
(210, 288, 287, '2024-10-08 21:48:05', 1, 1, NULL),
(211, 290, 287, '2024-10-10 09:05:47', 0, 0, 290),
(212, 290, 287, '2024-10-11 19:58:54', 0, 0, 290);

-- --------------------------------------------------------

--
-- Table structure for table `followed`
--

CREATE TABLE `followed` (
  `id` int(11) NOT NULL,
  `chatroom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followed`
--

INSERT INTO `followed` (`id`, `chatroom_id`) VALUES
(42, 210);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chatroom_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chatroom_id`, `sender_id`, `message`, `timestamp`) VALUES
(323, 210, 287, 'boss', '2024-10-08 21:48:08'),
(324, 210, 288, 'boss', '2024-10-08 21:48:10'),
(325, 210, 287, 'add', '2024-10-08 21:48:12'),
(326, 210, 288, 'tika', '2024-10-08 21:48:13'),
(327, 210, 287, 'dara boss', '2024-10-08 21:48:28'),
(328, 211, 287, '\"\'', '2024-10-10 09:06:11'),
(329, 211, 287, '\"--//', '2024-10-10 09:06:25'),
(330, 211, 287, '//', '2024-10-10 09:06:27'),
(331, 211, 287, '//--', '2024-10-10 09:06:29'),
(332, 212, 287, 'asdasd?', '2024-10-11 19:58:59'),
(333, 212, 290, 'asd', '2024-10-11 19:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `availability` tinyint(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_image`, `price`, `availability`) VALUES
(9, '+1 Inbox', 'img/inbox_add.png', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `gender` varchar(20) DEFAULT 'Male',
  `coins` int(11) DEFAULT 1,
  `inbox_limit` int(255) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `nickname`, `gender`, `coins`, `inbox_limit`) VALUES
(1, 262, 'Girl', 'Female', 5000, 289),
(12, 263, 'test', 'Female', 213, 10),
(20, 278, 'vv', 'Male', 213, 10),
(21, 280, 'gaga', 'Male', 1, 10),
(22, 281, 'rrr', 'Male', 1, 10),
(23, 282, 'tt', 'Male', 1, 10),
(24, 283, 'caca', 'Male', 1, 10),
(25, 284, 'mm', 'Male', 1, 10),
(26, 285, 'oo', 'Male', 1, 10),
(27, 286, 'bb', 'Male', 1, 10),
(28, 287, 'asd', 'Female', 1, 10),
(29, 288, 'choy', 'Male', 13993, 11),
(30, 289, 'Admin', 'Male', 0, 5),
(31, 290, 'asd123', 'Male', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'student',
  `username` varchar(25) NOT NULL DEFAULT 'user',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `username`, `email`, `password`, `created_at`) VALUES
(262, 'student', 'Girl', 'myst1275@gmail.com', '$2y$10$nxazjNtK.2cxTBRXdwIdqOM2yFv1sKOspau/PeW61xPs1ovHYniCG', '2024-09-30 10:51:06'),
(263, 'student', 'test', 'test@test.test', '$2y$10$vFEz.FMJ.4RLsDLzdqsl7ugLrYI/jWi.4niKo5ZVQbeYAN4tyomWG', '2024-10-03 16:26:14'),
(272, 'student', 'qq', 'q@q.q', '$2y$10$PpUiYIhbbtyc3aUCYJNX1.haBToTCtuVUbTcnxvgaC78EC/73co9q', '2024-10-03 16:45:45'),
(273, 'student', 'gg', 'gg@gg.gg', '$2y$10$fxhdq7Gs9H75xdt2MVBOJe/8six6J39lLVufTpZP5VJzGarYKnABa', '2024-10-03 16:49:50'),
(274, 'student', 'cc', 'cc@cc.cc', '$2y$10$U3uE5O9GS9gu89BMEbFZx.N8fzC/gNDhTDwxTEiy6unPDBoz5pefS', '2024-10-03 16:51:44'),
(275, 'student', '123', 'sad@dawd.sd', '$2y$10$32TzC1GVGqRRerPSk0xpEud45t/JcwQAhp4uqbKuLFstluy408C9C', '2024-10-03 16:56:25'),
(276, 'student', 'ff', 'bbc@please.change', '$2y$10$9YpS9z4uZwMgMC0PDf6uk.Ejtoz5P0e6teCUB9eWZJw.0IO52/.eW', '2024-10-03 16:58:20'),
(277, 'student', 'vv', 'vsdv@asasd.sddss', '$2y$10$.3hAbRM2Cw3kL8nCPs7g7OPouRkOrKX5LuFMr2PpXO/dZ/zovjPC.', '2024-10-03 17:00:42'),
(278, 'student', 'vv', 'vsdv@asasd.sddsssa', '$2y$10$TZfBNFxGj2KcN50BSRkeSO9V0chpaGj7glcUdJx.bG9oVyoEjFjOy', '2024-10-03 17:04:04'),
(279, 'student', 'zz', 'vv@ff.ff', '$2y$10$zZV47XMoMHfBFZ.Z1dQlr.DGaZJzmfxyd7TA4NYqHgw3699WSLDoq', '2024-10-03 17:08:17'),
(280, 'student', 'gaga', 'ga.ga@ga.ga', '$2y$10$t3TEkbDWUftdckm1y5VW1efsU07JrXw6Fogr6STQlSdze7N0qibFi', '2024-10-03 17:09:32'),
(281, 'student', 'rrr', 'vvvvvv@vvv.vv', '$2y$10$NaOvIb0AjYaUmaMW0Wt5QO0JZfCN37/J4KYwZlwN5ty90OEnRwSbW', '2024-10-03 17:40:07'),
(282, 'student', 'tt', 'rr@rr.rr', '$2y$10$BfOqVMSmHLTtu1smCocEB.SW2jZJyMsclR74Glp3vdntQT6iHwyxS', '2024-10-03 17:40:26'),
(283, 'student', 'caca', 'ca@ca.ca', '$2y$10$XWO3wKQ4.NYy3dPMM0OpnuY7XFeH/3C.9BH0gJsDzzJjImvRu86Wa', '2024-10-03 17:41:18'),
(284, 'student', 'mm', 'mmm@please.change', '$2y$10$T59qv9K.1p0/rtjByiLNFesU/2wLtLpS5w/YguizKf5E8cEyRp9tO', '2024-10-03 17:42:45'),
(285, 'student', 'oo', 'oo@oo.oo', '$2y$10$0a1sBs4nMrbJUQ.JjhHI6eF.IWRWRCkCx3ICqzWVaGZXIrYJKA3MO', '2024-10-03 17:43:59'),
(286, 'student', 'bb', 'bbb@bb.bb', '$2y$10$cN1yXt2DI/C2vx4/zx7ATuaISIKq12CxOOxwNavFbLpMO4Xc8g5EO', '2024-10-03 17:45:43'),
(287, 'student', 'asd', 'asd@asd', '$2y$10$gcIp/59qWfF3ZzCT8EnxQuJyqepZzDsw427aH.MZ99riDMiw13Hq6', '2024-10-05 15:23:06'),
(288, 'student', 'choy', '123@123', '$2y$10$zhlgAClSBpN6.pL5wRgIY.IvPv6LX9J6oz2SjudK.RyuvyUqIyBei', '2024-10-05 15:23:20'),
(289, 'student', 'Admin', 'rondinabrybry1@gmail.com', '$2y$10$v6hBmqwCAH3Biw3E5feUMO/T4.9a/f7skqUmApGCGuewZxMNunBWC', '2024-10-06 17:42:47'),
(290, 'student', 'asd123', 'asd@123', '$2y$10$/Viulq0FsLwoT0PT/XI/VelD8v0dZKoing8a7das/0epA17jYHvTe', '2024-10-08 12:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `voucher_code` varchar(255) NOT NULL,
  `voucher_value` int(11) NOT NULL,
  `expired` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `voucher_code`, `voucher_value`, `expired`) VALUES
(1, 'xxx123', 5000, 1),
(2, 'VGSAU', 10, 1),
(3, 'K4QPO', 10, 1),
(4, '5YI70', 10, 1),
(5, 'WYM6X', 10, 0),
(6, '1637X', 10, 0),
(7, '0VHJU', 10, 0),
(8, '3J819', 10, 0),
(9, 'VM6C8', 10, 0),
(10, '3P4UW', 10, 0),
(11, 'RSZON', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `waitlist`
--

CREATE TABLE `waitlist` (
  `id` int(11) NOT NULL,
  `finder_id` int(11) DEFAULT NULL,
  `preferred` varchar(20) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_1` (`userid_1`),
  ADD KEY `userid_2` (`userid_2`),
  ADD KEY `user_left` (`user_left`);

--
-- Indexes for table `followed`
--
ALTER TABLE `followed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chatroom_id` (`chatroom_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `chatroom_id` (`chatroom_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waitlist`
--
ALTER TABLE `waitlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `finder_id` (`finder_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatroom`
--
ALTER TABLE `chatroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `followed`
--
ALTER TABLE `followed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `waitlist`
--
ALTER TABLE `waitlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=925;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD CONSTRAINT `chatroom_ibfk_1` FOREIGN KEY (`userid_1`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatroom_ibfk_2` FOREIGN KEY (`userid_2`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatroom_ibfk_3` FOREIGN KEY (`user_left`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `followed`
--
ALTER TABLE `followed`
  ADD CONSTRAINT `followed_ibfk_1` FOREIGN KEY (`chatroom_id`) REFERENCES `chatroom` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`chatroom_id`) REFERENCES `chatroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `ffa` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`);

--
-- Constraints for table `waitlist`
--
ALTER TABLE `waitlist`
  ADD CONSTRAINT `waitlist_ibfk_1` FOREIGN KEY (`finder_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
