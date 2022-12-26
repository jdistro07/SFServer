INSERT INTO `staffs` (`staff_ID`, `staff_fname`, `staff_mname`, `staff_lname`, `staff_birthdate`, `staff_address`, `staff_organization`, `staff_position`, `staff_username`, `staff_password`, `staff_accountLevel`) VALUES
(2024, 'A', 'Sample', 'Staff', '2019-01-01', 'Sample address', 'Sample organization', 'Sample position', 'admin', '$2y$10$043mlnmkrSuKS.s7l2cpbe6v0j8iKsbUwhKY0JaMYc4uUTO37ROJ6', 1);

-- Teacher
INSERT INTO `staffs` (`staff_ID`, `staff_fname`, `staff_mname`, `staff_lname`, `staff_birthdate`, `staff_address`, `staff_organization`, `staff_position`, `staff_username`, `staff_password`, `staff_accountLevel`) VALUES (NULL, 'Sample', '', 'Teacher', '2022-12-26', 'Sample address', 'Organization', 'Teacher', 'teacher1', '$2y$10$pU2BDsLnlOy7ys8SkWEZ3uq1Iqfc2bOulfy1H7ylhY04vtBpNLmiG', '2');

-- Class
INSERT INTO `class` (`class_ID`, `class_staff`, `class_grade`, `class_section`) VALUES ('1', '2025', '4', 'A');

-- Student
INSERT INTO `students` (`student_ID`, `student_fname`, `student_mname`, `student_lname`, `student_birthdate`, `student_address`, `student_classID`, `student_username`, `student_password`, `student_accountLevel`) VALUES (NULL, 'Sample', '', 'Student 2', '2022-12-26', 'Sample address', '1', 'student2', '$2y$10$iDCO2/l5VgRkaM/EWVgAgu7uBCUWqwiaGzclIHZxosICQgeiPpEY2', '3');