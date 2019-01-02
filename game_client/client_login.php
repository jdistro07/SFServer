<?php
require ("../php/mod_conn.php");

    $username = mysqli_real_escape_string($conn, $_POST['client_username']);
    $password = mysqli_real_escape_string($conn, $_POST['client_password']);
    $hashed_pass;
    $outputstring;

    $q_maxChapter;

    $query = mysqli_query($conn, 

    "SELECT * FROM `staffs`
    WHERE staff_username = '".$username."' 
    LIMIT 1
    
    ")or die("An error has occured searching to staffs table...");

    $result = mysqli_fetch_assoc($query);

    //verify if staff or student
    if($result > 0){

        $hashed_pass = $result["staff_password"];

        $outputstring = "ID=".$result['staff_ID']."|Name=".$result['staff_fname']." ".substr($result['staff_lname'], 0, 1).".|Position=".$result['staff_position']."|Username=".$result['staff_username']."|AccountLevel=".$result['staff_accountLevel'];

        $userID = $result['staff_ID'];

        // query for user's highest chapter finished
        $q_maxChapter = mysqli_query($conn, 
        "SELECT 
        IFNULL(MAX(tests.test_chapter),0) AS maxChapter

        FROM 
        performance_data RIGHT JOIN tests ON performance_data.pf_testID = tests.test_ID

        WHERE
        performance_data.pf_userID = $userID") or die (mysqli_error($conn));

    }else if($result <= 0){ 

        // If no result from staff, search the students table
        $query_students = mysqli_query($conn, 

        "SELECT * FROM `students` INNER JOIN class
        WHERE student_username = '".$username."' AND students.student_classID = class.class_ID
        LIMIT 1
        
        ")or die("An error has occured searching to students table...");

        $result_student = mysqli_fetch_assoc($query_students);
        $hashed_pass = $result_student["student_password"];

        $userID = $result_student['student_ID'];

        // query for user's highest chapter finished
        $q_maxChapter = mysqli_query($conn, 
        "SELECT 
        IFNULL(MAX(tests.test_chapter),0) AS maxChapter

        FROM 
        performance_data RIGHT JOIN tests ON performance_data.pf_testID = tests.test_ID

        WHERE
        performance_data.pf_userID = $userID") or die (mysqli_error($conn));

        $outputstring = "ID=".$result_student['student_ID']."|Name=".$result_student['student_fname']." ".substr($result_student['student_lname'], 0, 1).".|Username=".$result_student['student_username']."|AccountLevel=".$result_student['student_accountLevel']."|Class=".$result_student['class_grade']."".$result_student['class_section'];



    }else{
        echo("No query result");
    }
    
    //verify password
    if(password_verify($password,$hashed_pass)){

        $r_maxChapter = mysqli_fetch_assoc($q_maxChapter) or die (mysqli_error($conn));

        echo "Login granted:".$outputstring."|maxChapter=".$r_maxChapter['maxChapter'];
    }else{
        echo "Login denied";
    }

    mysqli_close($conn);
?>