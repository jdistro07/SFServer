<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
require ("php/mod_conn.php");

$current_logged_user = $_SESSION["user_ID"];

?>

<html>
    <header>
        <title>Student Account Registration</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.js"></script>
        <script src = "js/functions.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Student Registration</h1>
                <br>
                <form method = "post">
                    <input onkeyup = "textOnly(this)" required = "required" name="fname" type="text" placeholder="First Name" autofocus/><br>
                    <input onkeyup = "textOnly(this)" name="mname" type="text" placeholder="Middle Name"/><br>
                    <input onkeyup = "textOnly(this)" required = "required" name="lname" type="text" placeholder="Last Name"/><br>
                    <input required = "required" name="address" type="text" placeholder="Address"/><br>
                    <input class="datePicker" required = "required" name="birthdate" type="date"/><br>

                    <select style = "text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" required = "required" name = "classID">

                        <option value = "">-- Select a class --</option>
                        <?php

                        $q_classes;

                        /*

                        1. Admin - display all classes
                        2. Teacher - display classes where the account is registered in

                        */
                        if($_SESSION["user_account_level"] == 1){

                            // admin contents
                            $q_classes = mysqli_query(
                                $conn,
                                "SELECT * FROM class ORDER BY class_grade ASC
                                "
                            );

                        }else{

                            $q_classes = mysqli_query(
                                $conn,
                                "SELECT * FROM class 
                                WHERE class_staff = $current_logged_user
                                ORDER BY class_grade ASC
                                "
                            );

                        }

                        // loop per result
                        while($r_classes = mysqli_fetch_assoc($q_classes)){
                            echo 
                            "<option value = '".$r_classes['class_ID']."'>
                                Grade ".$r_classes['class_grade']." - ".$r_classes['class_section'].
                            "</option>";
                        }

                        ?>

                    </select>

                    <br>

                    <input onkeyup = "usernameChars(this)" required = "required" name="username" type="text" placeholder="Username" value=""><br>
                    <input id = "password" required = "required" name="password" type="password" placeholder="Password"/><br>
                    <input id = "confpassword" required = "required" name="confpassword" type="password" placeholder="Confirm Password"/><br>

                    <input onclick = "return regValidate('password', 'confpassword')" name="register" type="submit" value="Register"><br>
                </form>
                <a href="dashboard.php"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

<?php

//error messages
$username_exist = "<script>alert(\"Username already exist\")</script>";

if(isset($_POST['register'])){
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $bdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $classID = mysqli_real_escape_string($conn, $_POST['classID']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $acc_level = 3;

    $enc_pass = password_hash($password,PASSWORD_BCRYPT); // encrypt password

    //find the same username to students table
    $find_query = mysqli_query($conn, "SELECT `staff_username` FROM staffs WHERE `staff_username` = '$username'") or die ("Search duplicate username to students table have failed and was aborted!");
    $find_result = mysqli_fetch_assoc($find_query);

    if($find_result > 0){
        die($username_exist);
    }

    $query = mysqli_query($conn,
    "INSERT INTO `students`
    (
        `student_fname`, 
        `student_mname`, 
        `student_lname`, 
        `student_birthdate`, 
        `student_address`, 
        `student_classID`,  
        `student_username`, 
        `student_password`, 
        `student_accountLevel`
    ) 
    VALUES 
    (
        \"$fname\",
        \"$mname\",
        \"$lname\",
        \"$bdate\",
        \"$address\",
        \"$classID\",
        \"$username\",
        \"$enc_pass\",
        \"$acc_level\"
    )
    ") or die($username_exist);

    if($query){
        echo 
        "<script>
            alert('Student registered successfully!');
            window.location.href='register-student.php';
        </script>";
    }
}

?>