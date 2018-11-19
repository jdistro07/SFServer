<?php
require '../php/mod_conn.php';

$q_user;

//reference credentials
$accPassword = mysqli_real_escape_string($conn, $_POST['accPassword']);
$accID = $_POST['accID'];
$accUsername = $_POST['accUsername'];
$accLevel = $_POST['accLevel'];

// new password
$newPassword = $_POST['newPassword'];

if($accLevel < 3){

    //search on staff table for the password
    $q_user = mysqli_query($conn, 
    "SELECT COUNT(staff_ID) AS userCount, staff_password FROM staffs 
    WHERE staff_ID = $accID AND staff_username = '$accUsername'
    ") or die(mysqli_error($conn));
    
    $r_user = mysqli_fetch_assoc($q_user);

    if($r_user['userCount'] < 1){

        echo "not found!";

    }else{

        // update user password and return a response
        if(password_verify($accPassword, $r_user['staff_password'])){

            $hashedPass = password_hash($newPassword, PASSWORD_BCRYPT);

            mysqli_query($conn, 
            "UPDATE `staffs` 
            SET `staff_password` = '$hashedPass'
            WHERE staff_ID = $accID AND staff_username = '$accUsername'
            ") or die(mysqli_error($conn));

            echo "success";

        }else{
            echo "mismatch";
        }

    }

}else{

    //search on student for the password
    $q_user = mysqli_query($conn, 
    "SELECT COUNT(student_ID) AS userCount, student_password FROM students 
    WHERE student_ID = $accID AND student_username = '$accUsername'
    ") or die(mysqli_error($conn));

    $r_user = mysqli_fetch_assoc($q_user);

    if($r_user['userCount'] < 1){

        echo "not found!";

    }else{

        // update user password and return a response
        if(password_verify($accPassword, $r_user['student_password'])){

            $hashedPass = password_hash($newPassword, PASSWORD_BCRYPT);

            mysqli_query($conn, 
            "UPDATE `students` 
            SET `student_password` = '$hashedPass'
            WHERE student_ID = $accID AND student_username = '$accUsername'
            ") or die(mysqli_error($conn));

            echo "success";

        }else{
            echo "mismatch";
        }

    }

}

?>