-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2024 at 10:28 AM
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
-- Database: `card-fraud-detection`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@example.com', '$2y$10$Cw2uYbIljKOIMETnFn5HHuN7ayeXZVC.TFeY6ywePpphm1Am4NY1y', '2024-02-27 23:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `CardNumber` varchar(20) NOT NULL,
  `CardName` varchar(255) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `LastUsed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` tinyint(1) NOT NULL,
  `DateIssued` timestamp NOT NULL DEFAULT current_timestamp(),
  `initial_deposit` decimal(10,2) DEFAULT 0.00,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `CardNumber`, `CardName`, `ExpiryDate`, `LastUsed`, `Status`, `DateIssued`, `initial_deposit`, `customer_id`) VALUES
(2, '961981797094236', 'absam absam', '2028-02-29', '2024-02-28 23:00:00', 1, '2024-02-29 09:59:19', 0.00, NULL),
(3, '293426450944262', 'ibrahim sobande', '2028-02-29', '2024-02-28 23:00:00', 1, '2024-02-29 10:05:39', 50000.00, NULL),
(4, '627382756046704', 'adewale absam', '2028-02-29', '2024-02-28 23:00:00', 1, '2024-02-29 22:53:12', 20000.00, 9);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 1,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `FirstName`, `LastName`, `Email`, `Phone`, `Country`, `State`, `Status`, `createdat`, `address`) VALUES
(7, 'ibrahim', 'sobande', 'frosh@gmail.com', '08162108410', 'Nigeria', 'Ogun', 1, '2024-02-29 09:22:09', 'olomore'),
(8, 'absam', 'absam', 'absam@gmail.com', '08162108410', 'Nigeria', 'Ogun', 1, '2024-02-29 09:22:42', 'olomore'),
(9, 'adewale', 'absam', 'new@gmail.com', '08162108410', 'Nigeria', 'Ogun', 1, '2024-02-29 22:52:56', 'olomore');

-- --------------------------------------------------------

--
-- Table structure for table `payment_checkout`
--

CREATE TABLE `payment_checkout` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `cvv` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `card_id`, `message`, `created_at`) VALUES
(1, 3, 'thbljjbbvk', '2024-02-29 22:10:30'),
(2, 4, 'there was an error making my payment today', '2024-02-29 22:55:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cards_customers` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `payment_checkout`
--
ALTER TABLE `payment_checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_checkout`
--
ALTER TABLE `payment_checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `fk_cards_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
