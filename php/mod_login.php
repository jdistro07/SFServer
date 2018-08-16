<?php
include ("mod_conn.php");

if(isset($_POST['btn_Login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM `staffs` WHERE staff_username = '$username' LIMIT 1")or die("An error has occured...");
    $result = mysqli_fetch_assoc($query);

    $hashed_pass = $result["staff_password"];

    if(password_verify($password,$hashed_pass)){
        header("location:../dashboard.html");
    }else{
        header('location:../index.html');
    }
}

?>