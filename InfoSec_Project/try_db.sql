-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 07:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `try_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(5) NOT NULL,
  `service_type` enum('Pet Grooming','Vet Consultation') NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `special_instructions` text NOT NULL,
  `pet_profile_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `service_type`, `preferred_date`, `preferred_time`, `special_instructions`, `pet_profile_id`, `user_id`) VALUES
(1, 'Vet Consultation', '2025-03-01', '10:00:00', 'My dog has a history of allergies.', 1, 2),
(2, 'Pet Grooming', '2025-03-02', '14:00:00', 'Please use hypoallergenic shampoo.', 2, 2),
(3, 'Vet Consultation', '2025-03-03', '09:00:00', 'My cat is very anxious and might need calming medication.', 3, 3),
(4, 'Pet Grooming', '2025-03-04', '11:00:00', 'Trim nails and clean ears.', 4, 4),
(5, 'Vet Consultation', '2025-03-05', '12:00:00', 'My dog has been eating less lately.', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pet_profile`
--

CREATE TABLE `pet_profile` (
  `pet_id` int(5) NOT NULL,
  `pet_name` varchar(50) NOT NULL,
  `species` varchar(100) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `pet_owner_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_profile`
--

INSERT INTO `pet_profile` (`pet_id`, `pet_name`, `species`, `breed`, `gender`, `date_of_birth`, `pet_owner_id`) VALUES
(1, 'Bella', 'Dog', 'Labrador Retriever', 'Female', '2021-03-15', 2),
(2, 'Whiskers', 'Cat', 'Siamese', 'Male', '2023-06-10', 2),
(3, 'Max', 'Cat', 'German Shepherd', 'Male', '2020-11-25', 3),
(4, 'Luna', 'Cat', 'Persian', 'Female', '2019-08-30', 4),
(5, 'Rocky', 'Dog', 'Beagle', 'Male', '2022-02-14', 5),
(6, 'Daisy', 'Dog', 'Golden Retriever', 'Female', '2018-05-06', 6),
(7, 'Takaw', 'Dog', 'Dog', 'Female', '2021-09-02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNum` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `contactNum`, `address`, `pass`, `role`) VALUES
(1, 'Abigail Allado', 'alladoa@gmail.com', '09348572391', 'Quezon City', '$2y$10$NLzsjAmmHOH3mt2IfkJj0.9DPzvPsFj43/KcVSIStp0AT0XN2XhKm', 'admin'),
(2, 'Charlie A. Lozano', 'carolineloz@gmail.com', '09122384901', '523 Padre Faura Street, Ermita, Manila', '$2y$10$bZhAkT/cFW114h7k58oLRu0DB/UEahRF3JHW29qAje1lALFgO9Wy2', 'client'),
(3, 'Raven L. Dalgan', 'ravend@gmail.com', '09995478912', '5647 Evangelista Street, Quiapo', '$2y$10$x1HgxNPDs.35uKGj0403C.ktIUcB6IzXRFnqKkYhOo3Sa8tp/I3IW', 'client'),
(4, 'Hazel S. Bongalos', 'bongaloshazel@gmail.com', '09324324234', '894 Quezon Boulevard 1000, Manila', '$2y$10$WuPlGLpKTKi4OpAO4KvYCuDQ7DxeIQNCVOOGBpYRyz0h4Gf1jAlYm', 'client'),
(5, 'Leilan J. Bautista', 'leilanbl@gmail.com', '09874366507', 'Consuelo Building, 629 N. Reyes Street, Manila', '$2y$10$uBhhgiuOzllCCaV7q3q.jO336iZufIYMbAoHDhk091aHWSP92Q8aO', 'client'),
(6, 'Jorge A. Mallari', 'mallarijorge@gmail.com', '09239750989', '172 Amploco, Manila', '$2y$10$4c5zqoFZf82KRm68Asy06uFn4vAV5UPGuY7sq/QCrUsWzSaQYj8Su', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `pet_profile_id` (`pet_profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_profile`
--
ALTER TABLE `pet_profile`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `pet_owner_id` (`pet_owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pet_profile`
--
ALTER TABLE `pet_profile`
  MODIFY `pet_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`pet_profile_id`) REFERENCES `pet_profile` (`pet_id`);

--
-- Constraints for table `pet_profile`
--
ALTER TABLE `pet_profile`
  ADD CONSTRAINT `pet_profile_ibfk_1` FOREIGN KEY (`pet_owner_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
