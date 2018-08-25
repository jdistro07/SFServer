<html>
    <header>
        <title>Account Registration</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Staff Registration</h1>
                <br>
                <form method = "post">
                    <input required = "required" name="fname" type="text" placeholder="First Name" autofocus/><br>
                    <input name="mname" type="text" placeholder="Middle Name"/><br>
                    <input required = "required" name="lname" type="text" placeholder="Last Name"/><br>
                    <input required = "required" name="address" type="text" placeholder="Address"/><br>
                    <input class="datePicker" required = "required" name="birthdate" type="date"/><br>
                    <input style = "text-align: center;width:80%; margin: 0px; margin-top: 3px; margin-bottom: 3px; border-radius: 3px; border: 1px solid;" required = "required" id = "class_search" name = "classID" list = "result-class" placeholder="Class"/>
                    <datalist id="result-class">
                    </datalist>
                    <br>

                    <input required = "required" name="username" type="text" placeholder="Username" value=""><br>
                    <input required = "required" name="password" type="password" placeholder="Password"/><br>

                    <input name="register" type="submit" value="Register"><br>
                </form>
                <a href="dashboard.html"><button>Cancel</button></a>
            </center>
        </div>
    </body>

    <script>
    $(document).ready(function(){
        $('#class_search').keyup(function(){
            var searchtext = $('#class_search').val();

            $.get('php/minimod_class-search.php',{search:searchtext}, function(response){
                $('#result-class').html(response);
            });
        });
    })
</script>
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
}

?>