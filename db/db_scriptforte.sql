-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2018 at 01:30 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_scriptforte`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_ID` int(11) NOT NULL,
  `class_staff` int(11) NOT NULL,
  `class_grade` int(2) NOT NULL,
  `class_section` char(3) NOT NULL COMMENT 'Class section per grade'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Collection of classes of the school';

-- --------------------------------------------------------

--
-- Table structure for table `performance_data`
--

CREATE TABLE `performance_data` (
  `pf_id` int(11) NOT NULL COMMENT 'Student performance entry ID',
  `pf_userID` int(11) NOT NULL COMMENT 'ID of the student',
  `pf_username` varchar(30) NOT NULL COMMENT 'Username of the test taker',
  `pf_testID` int(11) NOT NULL COMMENT 'ID of the course.',
  `pf_testMode` tinytext NOT NULL COMMENT 'Contians pre-test and post-test modes achieved by the user',
  `pf_rating` decimal(10,2) NOT NULL COMMENT 'Student rating to the course.',
  `pf_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Performance data of each users that finishes the game.';

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL COMMENT 'ID of each question',
  `question_testID` int(11) NOT NULL COMMENT 'ID of the test where the question/s belong to',
  `question_formattedQuestion` varchar(255) NOT NULL COMMENT 'Formatted question text for the client'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Entry of questions for reference table tests';

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_ID` int(11) NOT NULL,
  `staff_fname` varchar(50) NOT NULL,
  `staff_mname` varchar(20) NOT NULL,
  `staff_lname` varchar(80) NOT NULL,
  `staff_birthdate` date NOT NULL,
  `staff_address` varchar(150) NOT NULL,
  `staff_organization` varchar(150) NOT NULL,
  `staff_position` varchar(30) NOT NULL,
  `staff_username` varchar(30) NOT NULL COMMENT 'Unique user names',
  `staff_password` char(60) NOT NULL,
  `staff_accountLevel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Composed of school''s staffs and teachers';

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_ID` int(11) NOT NULL,
  `student_fname` varchar(50) NOT NULL,
  `student_mname` varchar(20) NOT NULL,
  `student_lname` varchar(80) NOT NULL,
  `student_birthdate` date NOT NULL,
  `student_address` varchar(150) NOT NULL,
  `student_classID` int(11) NOT NULL,
  `student_username` varchar(30) NOT NULL,
  `student_password` char(60) NOT NULL,
  `student_accountLevel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Registered students';

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_ID` int(11) NOT NULL COMMENT 'Test entry ID',
  `test_staffAuthor` int(11) NOT NULL COMMENT 'Author of the Test',
  `test_name` text NOT NULL COMMENT 'Name of the test',
  `test_type` tinytext NOT NULL COMMENT 'Type of test (Post-test, Pre-test)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Entry of pre-tests and post-tests';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_ID`);

--
-- Indexes for table `performance_data`
--
ALTER TABLE `performance_data`
  ADD PRIMARY KEY (`pf_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_ID`),
  ADD UNIQUE KEY `staff_username` (`staff_username`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_ID`),
  ADD UNIQUE KEY `student_username` (`student_username`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3966;

--
-- AUTO_INCREMENT for table `performance_data`
--
ALTER TABLE `performance_data`
  MODIFY `pf_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Student performance entry ID', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of each question', AUTO_INCREMENT=750;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2003;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1056;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Test entry ID', AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
