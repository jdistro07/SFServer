<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

?>

<html>
    <header>
        <title>Class Registration</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src = "js/functions.js"></script>
        <script src = "js/jquery.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" style = "height: 100%;" class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Class Registration</h1>
                <br>
                <form method = "post">
                    <!--<input id = "staff" required = "required" name="classStaff" type="text" placeholder="Class Staff" list = "result-staffs" autofocus/><br>
                    <datalist id="result-staffs"></datalist>-->

                    <h6 align = "left" id = "elementLabel"><span><strong>Assign a Teacher</strong></span></h6>
                    <select style = "margin-top: 2px; text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" required = "required" name="classStaff">
                    
                    <option value = "">-- Assign a Teacher --</option>
                    

                    <?php

                    require_once ("php/mod_conn.php");

                    // list all staffs (Administrator and Teachers) on the select box
                    $q_staffs = mysqli_query(
                        $conn, 
                        "SELECT * FROM staffs ORDER BY staff_lname ASC
                        "
                    ) or die ("<script>Something went wrong retreiving the list of Staff accounts!</script>");
                    
                    while($r_staffs = mysqli_fetch_assoc($q_staffs)){

                        $account_lvl = "";
                        
                        if($r_staffs['staff_accountLevel'] == 1){
                            $account_lvl = "Administrator";
                        }else{
                            $account_lvl = "Teacher";
                        }
                        
                        echo "<option value = \"".$r_staffs['staff_ID']."\">".$r_staffs['staff_lname'].", ".$r_staffs['staff_fname']." ".$r_staffs['staff_mname']." - (".$account_lvl.")</option>";

                    }

                    ?>
                    </select>

                    <h6 align = "left" id = "elementLabel"><span><strong>Class Grade</strong></span></h6>
                    <input onkeyup = "numericOnly(this)" required = "required" name="classGrade" type="text" placeholder="Class Grade"/><br>
                    
                    
                    <h6 align = "left" id = "elementLabel"><span><strong>Class Section</strong></span></h6>
                    <input onkeyup = "textOnly(this)" required = "required" name="classSection" type="text" placeholder="Class Section"/><br>

                    <hr>
                    <input onclick = "return confirm('Approve registration?')" name="register" type="submit" value="Register Class"><br>
                </form>
                <a href="dashboard.php"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

    <script>
    /*$(document).ready(function(){
        $('#staff').keyup(function(){
            var searchtext = $('#staff').val();

            $.get('php/minimod_staff-search.php',{search:searchtext}, function(response){
                $('#result-staffs').html(response);
            });
        });
    })*/
    </script>

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


    if($query){
        echo 
        "<script>
            alert('Class has been created successfully!');
            window.location.href='register-classes.php';
        </script>";
    }

}

?>