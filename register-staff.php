<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

?>

<html>
    <header>
        <title>Staff Account Registration</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src = "js/functions.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Staff Registration</h1>
                <br>
                <form method = "post">
                    <h6 align = "left" id = "elementLabel"><span><strong>First Name</strong></span></h6>
                    <input onkeyup = "textOnly(this)" id = "fname" required = "required" name="fname" type="text" placeholder="First Name" autofocus/><br>    
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Middle Name</strong> <i>(optional)</i></span></h6>
                    <input onkeyup = "textOnly(this)" name="mname" type="text" placeholder="Middle Name"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Last Name</strong></span></h6>
                    <input onkeyup = "textOnly(this)" required = "required" name="lname" type="text" placeholder="Last Name"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Address</strong></span></h6>
                    <input required = "required" name="address" type="text" placeholder="Address"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Birth Date</strong></span></h6>
                    <input class="datePicker" required = "required" name="birthdate" type="date"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Position</strong></span></h6>
                    <input onkeyup = "textOnly(this)" required = "required" name="position" type="text" placeholder="Position"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Organization</strong></span></h6>
                    <input required = "required" name="organization" type="text" placeholder="Organization"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Username</strong> <i>(must be unique)</i></span></h6>
                    <input onkeyup = "usernameChars(this)" required = "required" name="username" type="text" placeholder="Username" value=""><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Password</strong></span></h6>
                    <input id = "password" required = "required" name="password" type="password" placeholder="Password"/><br>
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Confirm Password</strong></span></h6>
                    <input id = "confpassword" required = "required" name="confpassword" type="password" placeholder="Confirm Password"/><br>
                    

                    <h6 align = "left" id = "elementLabel"><span><strong>Account Access Level</strong></span></h6>
                    <select style = "text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" name = "access_Level">
                        <option value="1">Administrator</option>
                        <option value="2">Teacher</option>
                    </select><br>
                    
                    <hr>
                    <input onclick = "return regValidate('password', 'confpassword')" name="register" type="submit" value="Register"><br>

                </form>
                <a href="dashboard.php"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

<?php

require ("php/mod_conn.php");

//error messages
$username_exist = "<script>alert(\"Username already exist\")</script>";

if(isset($_POST['register'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $bdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $acc_level = mysqli_real_escape_string($conn, $_POST['access_Level']);

    $enc_pass = password_hash($password,PASSWORD_BCRYPT);

    //find the same username to students table
    $find_query = mysqli_query($conn, "SELECT `student_username` FROM students WHERE `student_username` = '$username'") or die ("Search duplicate username to students table have failed and was aborted!");
    $find_result = mysqli_fetch_assoc($find_query);

    if($find_result > 0){
        die($username_exist);
    }

    $query = mysqli_query($conn,
    "INSERT INTO `staffs`
    (
        `staff_fname`, 
        `staff_mname`, 
        `staff_lname`, 
        `staff_birthdate`, 
        `staff_address`, 
        `staff_organization`, 
        `staff_position`, 
        `staff_username`, 
        `staff_password`, 
        `staff_accountLevel`
    ) 
    VALUES 
    (
        \"$fname\",
        \"$mname\",
        \"$lname\",
        \"$bdate\",
        \"$address\",
        \"$organization\",
        \"$position\",
        \"$username\",
        \"$enc_pass\",
        \"$acc_level\"
    )
    ") or die($username_exist);

    if($query){
        echo 
        "<script>
            alert('Staff registered successfully!');
            window.location.href='register-staff.php';
        </script>";
    }
}



?>