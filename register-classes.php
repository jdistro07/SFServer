<html>
    <header>
        <title>Account Registration</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
    </header>

    <body class="container-fluid fill-height">
        <div class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Class Registration</h1>
                <br>
                <form method = "post">
                    <input required = "required" name="classStaff" type="text" placeholder="Class Staff" autofocus/><br>
                    <input required = "required" name="classGrade" type="text" placeholder="Class Grade"/><br>
                    <input required = "required" name="classSection" type="text" placeholder="Class Section"/><br>

                    <input name="register" type="submit" value="Register Class"><br>
                </form>
                <a href="dashboard.html"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

<?php

require ("php/mod_conn.php");

if(isset($_POST['register'])){
    $staff = mysqli_real_escape_string($conn, $_POST['classStaff']);
    $grade = mysqli_real_escape_string($conn, $_POST['classGrade']);
    $section = mysqli_real_escape_string($conn, $_POST['classSection']);
    
    $query = mysqli_query($conn,
"INSERT INTO `class`
(
    `class_staff`, 
 	`class_grade`, 
 	`class_section`
) 
 
VALUES 
(
 	'".$staff."',
 	'".$grade."',
	'".$section."'
)
") or die("Query Error!");
}

?>