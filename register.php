<html>
    <header>
        <title>Account Registration</title>
    </header>

    <body>
        <form method = "post">
            <input required = "required" name="fname" type="text" placeholder="First Name"/>
            <input name="mname" type="text" placeholder="Middle Name"/>
            <input required = "required" name="lname" type="text" placeholder="Last Name"/><br>
            <input required = "required" name="birthdate" type="date"/><br>
            <input required = "required" name="address" type="text" placeholder="Address"/><br>
            <input required = "required" name="organization" type="text" placeholder="Organization"/><br>
            <input required = "required" name="position" type="text" placeholder="Position"/><br>
            <input required = "required" name="username" type="text" placeholder="Username" value=""><br>
            <input required = "required" name="password" type="password" placeholder="Password"/><br>
            
            <select name = "access_Level">
                <option value="1">Administrator</option>
                <option value="2">Teacher</option>
                <option value="3">Student</option>
            </select><br>
            
            <input name="register" type="submit" value="Register"><br>

        </form>
        <a href="dashboard.html"><button>Cancel</button></a>
    </body>
</html>

<?php

include ("php/mod_conn.php");

//error messages
$username_exist = "Username already exist!";

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
}

?>