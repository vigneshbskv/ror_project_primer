-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 07:32 PM
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
-- Database: `medical_pres`
--

-- --------------------------------------------------------

--
-- Table structure for table `medication_data`
--

CREATE TABLE `medication_data` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medicine_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`medicine_data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_data`
--

INSERT INTO `medication_data` (`record_id`, `patient_id`, `medicine_data`, `created_at`) VALUES
(1, 1, '[{\"medicine_1\":\"vicks\",\"dosage_1\":\"53\"}]', '2024-08-05 14:08:33'),
(2, 1, '[{\"medicine_1\":\"medi2\",\"dosage_1\":\"4\"}]', '2024-08-04 14:08:33'),
(3, 2, '[{\"medicine_1\":\"vicks\",\"dosage_1\":\"500mg\"},{\"medicine_2\":\"penciline\",\"dosage_2\":\"200mg\"}]', '2024-08-05 15:17:48'),
(4, 4, '[{\"medicine_1\":\"medi2\",\"dosage_1\":\"23\"},{\"medicine_2\":\"penciline\",\"dosage_2\":\"43\"},{\"medicine_3\":\"vicks\",\"dosage_3\":\"4\"}]', '2024-08-06 17:10:28'),
(6, 4, '[{\"medicine_1\":\"gfhg\",\"dosage_1\":\"4\"},{\"medicine_2\":\"penciline\",\"dosage_2\":\"4\"}]', '2024-08-06 17:21:18');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(200) NOT NULL,
  `age` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_name`, `age`, `created_at`) VALUES
(1, 'patient 1', 20, '2024-08-06 14:14:44'),
(2, 'vignesh', 26, '2024-08-06 15:14:25'),
(3, 'test_patient', 34, '2024-08-06 15:15:14'),
(4, 'suresh', 45, '2024-08-06 17:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$z5sEB0dCtc0GBYTyFeBJPuajTwjeU64QJABmGjlWuxM/z9QXx37hS', '2024-08-05 11:24:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medication_data`
--
ALTER TABLE `medication_data`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_data` (`patient_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medication_data`
--
ALTER TABLE `medication_data`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medication_data`
--
ALTER TABLE `medication_data`
  ADD CONSTRAINT `patient_data` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
