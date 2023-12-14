-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 10:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voetbaltoernooi`
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `user_id`) VALUES
(1, 'Test', 2),
(2, 'Test 2', 2),
(3, 'Lars\'s z\'n team', 2),
(4, 'Sander\'s z\'n team', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `password`, `email`, `admin`) VALUES
(1, 'Lars', 'van Holland', '$2y$10$MHypkNxBc21bHqW.HOddTOuYwBCpd/./Iu60EN', 'lars@gmail.com', 0),
(2, 'test', 'test', '$2y$10$qkwRytCx1fpCfSkI5.tzBOtU7YzipDyaZiE4UpbI.5GnOs3mZkYPq', 'test@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_team`
--

CREATE TABLE `user_has_team` (
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wedstrijd`
--

CREATE TABLE `wedstrijd` (
  `id` int(11) NOT NULL,
  `datum` varchar(45) NOT NULL,
  `score_a` int(11) NOT NULL DEFAULT 0,
  `score_b` int(11) NOT NULL DEFAULT 0,
  `team_a_id` int(11) NOT NULL,
  `team_b_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `wedstrijd`
--

INSERT INTO `wedstrijd` (`id`, `datum`, `score_a`, `score_b`, `team_a_id`, `team_b_id`) VALUES
(1, '2023-12-15', 0, 0, 1, 2),
(2, '2023-12-15', 0, 0, 2, 1),
(3, '2023-12-15', 0, 0, 3, 4),
(4, '2023-12-15', 0, 0, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_team_user1_idx` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_has_team`
--
ALTER TABLE `user_has_team`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `fk_user_has_team_team1_idx` (`team_id`),
  ADD KEY `fk_user_has_team_user_idx` (`user_id`);

--
-- Indexes for table `wedstrijd`
--
ALTER TABLE `wedstrijd`
  ADD PRIMARY KEY (`id`,`team_a_id`,`team_b_id`),
  ADD KEY `fk_wedstrijd_team1_idx` (`team_a_id`),
  ADD KEY `fk_wedstrijd_team2_idx` (`team_b_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wedstrijd`
--
ALTER TABLE `wedstrijd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_has_team`
--
ALTER TABLE `user_has_team`
  ADD CONSTRAINT `fk_user_has_team_team1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_team_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wedstrijd`
--
ALTER TABLE `wedstrijd`
  ADD CONSTRAINT `fk_wedstrijd_team1` FOREIGN KEY (`team_a_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_wedstrijd_team2` FOREIGN KEY (`team_b_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
