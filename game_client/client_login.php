<?php
require ("../php/mod_conn.php");

    $username = mysqli_real_escape_string($conn, $_POST['client_username']);
    $password = mysqli_real_escape_string($conn, $_POST['client_password']);
    $hashed_pass;
    $outputstring;

    $query = mysqli_query($conn, 

    "SELECT * FROM `staffs`
    WHERE staff_username = '".$username."' 
    LIMIT 1
    
    ")or die("An error has occured searching to staffs table...");

    $result = mysqli_fetch_assoc($query);

    //verify if staff or student
    if($result > 0){

        $hashed_pass = $result["staff_password"];

        $outputstring = "ID=".$result['staff_ID']."|Name=".$result['staff_fname']." ".$result['staff_mname']." ".$result['staff_lname']."|Position=".$result['staff_position']."|Username=".$result['staff_username']."|AccountLevel=".$result['staff_accountLevel'];

    }else if($result <= 0){ 

        // If no result from staff, search the students table
        $query_students = mysqli_query($conn, 

        "SELECT * FROM `students` INNER JOIN class
        WHERE student_username = '".$username."' AND students.student_classID = class.class_ID
        LIMIT 1
        
        ")or die("An error has occured searching to students table...");

        $result_student = mysqli_fetch_assoc($query_students);
        $hashed_pass = $result_student["student_password"];

        $outputstring = "ID=".$result_student['student_ID']."|Name=".$result_student['student_fname']." ".$result_student['student_mname']." ".$result_student['student_lname']."|Username=".$result_student['student_username']."|AccountLevel=".$result_student['student_accountLevel']."|Class=".$result_student['class_grade']."".$result_student['class_section'];



    }else{
        echo("No query result");
    }
    

    //verify password
    if(password_verify($password,$hashed_pass)){
        echo "Login granted:".$outputstring;
    }else{
        echo "Login denied";
    }
?>