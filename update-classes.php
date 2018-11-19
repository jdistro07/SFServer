<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
require ("php/mod_conn.php");

$class_id = $_GET['id'];

//query corresponding entry by class ID
$class_entry = mysqli_query($conn,

"SELECT * FROM class WHERE class_ID = '$class_id'"

) or die(mysqli_error($conn));

$class_query_result = mysqli_fetch_assoc($class_entry);

?>

<html>
    <header>
        <title>Class Update Information</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src = "js/jquery.js"></script>
        <script src = "js/functions.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" style = "height: 100%;" class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Class Registration</h1>
                <br>
                <form method = "post">

                    <select style = "text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" required = "required" name="classStaff">
                    
                    <?php
                    
                    // list all staffs and select the one currently assigned
                    $q_staffs = mysqli_query(
                        $conn, 
                        "SELECT * FROM staffs ORDER BY staff_lname ASC
                        "
                    ) or die ("<script>Something went wrong retreiving the list of Staff accounts!</script>");
                    
                    while($r_staffs = mysqli_fetch_assoc($q_staffs)){

                        $account_lvl = "";
                        $currentStaff = "";
                        
                        if($r_staffs['staff_accountLevel'] == 1){
                            $account_lvl = "Administrator";
                        }else{
                            $account_lvl = "Teacher";
                        }
                        
                        if($r_staffs['staff_ID'] == $class_query_result['class_staff']){
                            $currentStaff = "selected";
                        }

                        echo "<option value = \"".$r_staffs['staff_ID']."\" $currentStaff>".$r_staffs['staff_lname'].", ".$r_staffs['staff_fname']." ".$r_staffs['staff_mname']." - (".$account_lvl.")</option>";

                    }

                    ?>
                    
                    </select>

                    <input onkeyup = "numericOnly(this)" value = "<?php echo $class_query_result['class_grade']; ?>" required = "required" name="classGrade" type="text" placeholder="Class Grade"/><br>
                    <input onkeyup = "textOnly(this)" value = "<?php echo $class_query_result['class_section']; ?>" required = "required" name="classSection" type="text" placeholder="Class Section"/><br>

                    <input onclick = "return confirm('Confirm updating the selected class?')" name="register" type="submit" value="Update Class Information"><br>
                </form>
                <a href="class-search.php"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

<?php

if(isset($_POST['register'])){

    $staff = mysqli_real_escape_string($conn, $_POST['classStaff']);
    $grade = mysqli_real_escape_string($conn, $_POST['classGrade']);
    $section = mysqli_real_escape_string($conn, $_POST['classSection']);
    
    $query = mysqli_query($conn,
    "UPDATE `class` 
    SET 

    `class_staff`='$staff',
    `class_grade`='$grade',
    `class_section`='$section' 

    WHERE class_ID = $class_id

    ") or die(mysqli_error($conn));

    if($query){
        echo 
        "<script>
            alert('Class has been updated successfully!');
            window.location.href='class-search.php';
        </script>";
    }

}


?>