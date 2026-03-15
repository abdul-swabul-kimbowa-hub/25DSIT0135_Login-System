-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2026 at 06:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_number`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'STU-2026-0223-6780', 'Mujuzi', 'phillip', 'phillipmj@gmail.com', '$2y$10$3Ltd2qsIM3friidcoudVbe984Bn0T3TjpttjDgCjLKQH0NtBh84fe', '2026-02-23 07:54:01'),
(2, 'STU-2026-0223-2663', 'Nabukenya Hlima', 'Hadijah', 'hh.nabkenya@gmail.com', '$2y$10$DRWY/LRt4W0RkPhSsKHAOuT7cZUMD48M3IsYfy.iBsaEul2K0xL2S', '2026-02-23 11:02:54'),
(3, 'STU-2026-1349', 'andrew', 'paul', 'andrewpaul@gmail.com', '$2y$10$O9z3LlgK5SMOsuuyKaoZaurRrE1dMXR53lr1VAfI0X2PW3ODU/uRS', '2026-02-23 11:42:25'),
(4, 'STU-2026-9969', 'mujuzib', 'phil', 'phillsphantom4@gmail.com', '$2y$10$eDf.wybGrPYNm7vBBXzME.1ej9nw3nMbV7H.yATKgVaJQAuMivSOi', '2026-02-23 12:41:35'),
(5, 'STU-2026-1826', 'godfrey', 'aron', 'aron@gmail.com', '$2y$10$pMD5TTAcphv7eR93GhRNhO8HxZOAABEds4DrN0EGOZZ0m.OTrBUxC', '2026-02-23 16:35:37'),
(7, 'STU-2026-6215', 'boy', 'child', 'boy@gmail.com', '$2y$10$qA4OWMrI2FdmUoJlk7zMrOvdFMaHnIjvTr2hLHB8KGNswZoR4KoUy', '2026-03-02 11:01:06'),
(8, 'STU-2026-2465', 'abdul', 'swabul', 'abdul2@gmail.com', '$2y$10$gywkVugmaC/KpU1M5vwJn.fPqAys9X4uudQlvtgR6lE5ljYmpH/7.', '2026-03-03 09:56:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
