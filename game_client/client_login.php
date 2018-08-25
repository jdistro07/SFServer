<?php
require ("../php/mod_conn.php");

    $username = mysqli_real_escape_string($conn, $_POST['client_username']);
    $password = mysqli_real_escape_string($conn, $_POST['client_password']);

    $query = mysqli_query($conn, 

    "SELECT * FROM `staffs`
    WHERE staff_username = '".$username."' 
    LIMIT 1
    
    ")or die("An error has occured searching to staffs table...");

    $result = mysqli_fetch_assoc($query);

    //verify if staff or student
    if($result > 0){
        echo $result['staff_username'];
        $hashed_pass = $result["staff_password"];
        echo "Query Result: Staff account<br>";
    }else if($result < 0){ 
        // If no result from staff, search the students table
        $query_students = mysqli_query($conn, 

        "SELECT * FROM `students`
        WHERE student_username = '".$username."' 
        LIMIT 1
        
        ")or die("An error has occured searching to students table...");

        $result_student = mysqli_fetch_assoc($query_students);
        $hashed_pass = $result_student["student_password"];

        echo "Query Result: Student account<br>";
    }else{
        echo("No query result");
    }
    
    if(password_verify($password,$hashed_pass)){
        echo "Login granted!";
    }else{
        echo "Login denied!";
    }
?>