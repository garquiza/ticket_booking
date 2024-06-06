-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 12:21 PM
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
-- Database: `ticket_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `busbooking`
--

CREATE TABLE `busbooking` (
  `id` int(11) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `departure_time` time NOT NULL,
  `return_time` time DEFAULT NULL,
  `passenger_quantity` int(11) NOT NULL,
  `selected_seats` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `busbooking`
--

INSERT INTO `busbooking` (`id`, `service_type`, `destination`, `departure_date`, `return_date`, `departure_time`, `return_time`, `passenger_quantity`, `selected_seats`, `name`, `email`, `phone`, `booking_date`) VALUES
(1, 'one_way', 'Manila', '2024-06-02', '0000-00-00', '16:00:00', '00:00:00', 1, '19', 'Mochi Suna', 'Mochi@gmail.com', '123456789', '2024-06-02 06:57:52'),
(20, 'round_trip', 'Rizal - Manila', '2024-06-06', '2024-06-11', '15:20:00', '07:20:00', 4, '21,22,23,24', 'Mochi Suna', 'MochiSuna@test.test', '1111', '2024-06-06 05:15:15'),
(21, 'one_way', 'Tanay', '2024-06-06', '0000-00-00', '21:10:00', '00:00:00', 2, '6,10', 'MochiKOY', 'Mochitest@gmail.com', '32631231', '2024-06-06 10:07:15'),
(22, 'round_trip', 'Antipolo - Quezon', '2024-06-06', '2024-06-08', '19:13:00', '00:20:00', 2, '26,36', 'Luna', 'lunaxmi@text.test', '09123456789', '2024-06-06 10:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `manage_bus`
--

CREATE TABLE `manage_bus` (
  `id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_type` enum('round_trip','one_way') NOT NULL,
  `bus_driver` varchar(255) NOT NULL,
  `bus_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_bus`
--

INSERT INTO `manage_bus` (`id`, `location_name`, `location_type`, `bus_driver`, `bus_number`) VALUES
(17, 'Lower Antipolo', 'one_way', 'Ynares', '55'),
(18, 'La Union - Baguio', 'round_trip', 'Liza', '08'),
(19, 'Tacloban', 'one_way', 'Sinio', '12'),
(20, 'Rizal - Manila', 'round_trip', 'San Pedro', '04'),
(21, 'Tanay', 'one_way', 'Bingo', '05'),
(22, 'Antipolo - Quezon', 'round_trip', 'Mang Inasal', '22');

-- --------------------------------------------------------

--
-- Table structure for table `manage_movie`
--

CREATE TABLE `manage_movie` (
  `id` int(11) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_movie`
--

INSERT INTO `manage_movie` (`id`, `movie_name`, `movie_time`) VALUES
(21, 'Cinema 3 - Happy Three Friends', '03:05:00'),
(22, 'Cinema 3 - Happy Three Friends', '17:15:00'),
(26, 'Cinema 1 - Alone Together', '14:10:00'),
(27, 'Cinema 1 - Alone Together', '17:00:00'),
(28, 'Cinema 1 - Alone Together', '10:30:00'),
(29, 'Inside Out', '20:20:00'),
(30, 'Inside Out', '10:30:00'),
(31, 'Inside Out', '22:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `moviebooking`
--

CREATE TABLE `moviebooking` (
  `id` int(11) NOT NULL,
  `select_movie` varchar(255) NOT NULL,
  `movie_date` date NOT NULL,
  `movie_time` time NOT NULL,
  `ticket_quantity` int(11) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moviebooking`
--

INSERT INTO `moviebooking` (`id`, `select_movie`, `movie_date`, `movie_time`, `ticket_quantity`, `seats`, `name`, `email`, `phone`) VALUES
(29, 'Cinema 1 - Alone Together', '2024-06-06', '17:00:00', 1, 'C4', 'Mochi Suna', 'MochiSuna@test.test', '1111'),
(30, 'Inside Out', '2024-06-07', '10:30:00', 1, 'F1', 'Sadness', 'SadNess@huhu.cry', '0912837468');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `bus_feature` tinyint(1) DEFAULT 0,
  `cinema_feature` tinyint(1) DEFAULT 0,
  `logo` varchar(255) DEFAULT '',
  `color` varchar(20) DEFAULT '',
  `footer_text` varchar(255) DEFAULT '',
  `site_name` varchar(100) DEFAULT '',
  `h1_text` varchar(255) DEFAULT NULL,
  `p_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `bus_feature`, `cinema_feature`, `logo`, `color`, `footer_text`, `site_name`, `h1_text`, `p_text`) VALUES
(1, 0, 1, '', '', '', 'COMPANY', 'Bus', 'Lorem ipsum do lor et al');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin-developer','admin-client','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'devadmin', 'dev123', 'admin-developer'),
(2, 'clientadmin', 'client123', 'admin-client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `busbooking`
--
ALTER TABLE `busbooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_bus`
--
ALTER TABLE `manage_bus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_movie`
--
ALTER TABLE `manage_movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moviebooking`
--
ALTER TABLE `moviebooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `busbooking`
--
ALTER TABLE `busbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `manage_bus`
--
ALTER TABLE `manage_bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `manage_movie`
--
ALTER TABLE `manage_movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `moviebooking`
--
ALTER TABLE `moviebooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
