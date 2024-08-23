-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 04:03 PM
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
-- Database: `iwatch`
--

-- --------------------------------------------------------

--
-- Table structure for table `crimereports`
--

CREATE TABLE `crimereports` (
  `ReportID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  `Location` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Attachment` varchar(255) DEFAULT NULL,
  `status` enum('submitted','viewed') DEFAULT 'submitted',
  `ImagePath` varchar(255) DEFAULT NULL,
  `ReportSeen` tinyint(1) DEFAULT 0,
  `Latitude` double DEFAULT NULL,
  `Longitude` double DEFAULT NULL,
  `CrimeStatus` enum('Resolved','Pending','Requiring Court') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crimereports`
--

INSERT INTO `crimereports` (`ReportID`, `UserID`, `Date`, `Location`, `Description`, `Attachment`, `status`, `ImagePath`, `ReportSeen`, `Latitude`, `Longitude`, `CrimeStatus`) VALUES
(27, 1, '2024-08-09 13:59:25', 'arua main market', 'car crashed', NULL, '', 'uploads/accident.jfif', 1, 0.3241456, 32.5648037, 'Pending'),
(29, 6, '2024-08-12 13:17:54', 'kampala nankulabye', 'car crashhhhh', NULL, '', 'uploads/accident.jfif', 1, 0.3244032, 32.5943296, 'Pending'),
(30, 1, '2024-08-12 13:29:48', 'kampala', 'car accident', NULL, '', 'uploads/accident.jfif', 1, 0.3244032, 32.5943296, 'Pending'),
(36, 1, '2024-08-13 10:35:40', 'arua', 'war zone', NULL, 'submitted', '', 1, 0.3375104, 32.5943296, 'Pending'),
(37, 6, '2024-08-13 11:55:34', 'AWINDIRI MARKET ', 'UNKNOWN GUN MEN SHOOTING PEOPLE', NULL, '', '', 1, 0.3375104, 32.5943296, 'Pending'),
(38, 15, '2024-08-16 13:34:09', 'Makerere Kavule', 'Makerere Demonstration', NULL, 'submitted', '', 1, 0.3243597, 32.5649994, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Status` enum('Active','Disabled') DEFAULT 'Active',
  `LastActiveDate` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `PhoneNumber`, `Status`, `LastActiveDate`) VALUES
(1, '0786443972', 'Disabled', NULL),
(3, '0785443344', 'Active', NULL),
(6, '0762566013', 'Active', NULL),
(9, '07822251807', 'Active', NULL),
(15, '0784483282', 'Active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crimereports`
--
ALTER TABLE `crimereports`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crimereports`
--
ALTER TABLE `crimereports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crimereports`
--
ALTER TABLE `crimereports`
  ADD CONSTRAINT `crimereports_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
