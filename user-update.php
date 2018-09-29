<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
require ("php/mod_conn.php"); 

//get request values
$id = mysqli_real_escape_string($conn, $_GET['id']);
$requestType = mysqli_real_escape_string($conn, $_GET['request']);

// user-profile redirect extra references
$user_type;

//personal credentials
$q_fname;
$q_mname;
$q_lname;
$q_birthdate;
$q_address;

//staff credentials
$q_position;
$q_organization;

//student credentials
$q_students;
$q_student_class;

//user credentials
$q_username;
$q_password;
$q_account_level;

//query variables for values
$fetch_query;
$fetch_result;

//query for values
if($requestType == "staffupdate"){

    $user_type = "staff";
    
    //get staff data
    $fetch_query = mysqli_query($conn, "
        SELECT * FROM `staffs` WHERE `staff_id` = '$id'
    ");

    while($fetch_result = mysqli_fetch_assoc($fetch_query)){
        //assign values
        //personal credentials
        $q_fname = $fetch_result['staff_fname'];
        $q_mname = $fetch_result['staff_mname'];
        $q_lname = $fetch_result['staff_lname'];
        $q_birthdate = $fetch_result['staff_birthdate'];
        $q_address = $fetch_result['staff_address'];

        //staff credentials
        $q_position = $fetch_result['staff_position'];
        $q_organization = $fetch_result['staff_organization'];

        //user credentials
        $q_username = $fetch_result['staff_username'];
        $q_password = $fetch_result['staff_password'];
        $q_account_level = $fetch_result['staff_accountLevel'];
    }

}else if ($requestType == "studentupdate"){

    $user_type = "student";

    //get student data
    $fetch_query = mysqli_query($conn, "
        SELECT * FROM `students` WHERE `student_id` = '$id'
    ");

    while($fetch_result = mysqli_fetch_assoc($fetch_query)){
        //assign values
        //personal credentials
        $q_fname = $fetch_result['student_fname'];
        $q_mname = $fetch_result['student_mname'];
        $q_lname = $fetch_result['student_lname'];
        $q_birthdate = $fetch_result['student_birthdate'];
        $q_address = $fetch_result['student_address'];

        //user credentials
        $q_student_class = $fetch_result['student_classID'];
        $q_username = $fetch_result['student_username'];
        $q_password = $fetch_result['student_password'];
        $q_account_level = $fetch_result['student_accountLevel'];
    }

}else if($requestType == "classupdate"){
    //class query here   
}
?>

<html>
    <header>
        <?php
        //evaluate title
        echo "<title>";
        if($requestType == "staffupdate" || $requestType == "studentupdate"){

            //staff & student update title
            echo "User Update";

        }else if($requestType == "classupdate"){

            //class update title
            echo "Class Update";

        }else{
            die("Invalid request type to access update module!");
        }
        echo "</title>";
        ?>

        <!--Module HTML references to work properly-->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" class="col-lg-6 col-lg-offset-3">
            <center>
                <?php
                //evaluate title
                echo "<h1>";
                if($requestType == "staffupdate"){

                    //staff update header
                    echo "Staff Update";

                }else if($requestType == "studentupdate"){
                    
                    //student update header
                    echo "Student Update";

                }else if($requestType == "classupdate"){

                    //class update title
                    echo "Class Update";
                    
                }else{
                    die("Invalid request type to access update module!");
                }
                echo "</h1>";
                ?>
                <br>
                <form method = "post">

                    <input value = "<?php echo $q_fname; ?>" required = "required" name="fname" type="text" placeholder="First Name" autofocus/><br>
                    <input value = "<?php echo $q_mname; ?>" name="mname" type="text" placeholder="Middle Name"/><br>
                    <input value = "<?php echo $q_lname; ?>" required = "required" name="lname" type="text" placeholder="Last Name"/><br>
                    <input value = "<?php echo $q_address; ?>" required = "required" name="address" type="text" placeholder="Address"/><br>
                    <input value = "<?php echo $q_birthdate; ?>" class="datePicker" required = "required" name="birthdate" type="date"/><br>
                    
                    <?php 
                    if($requestType == "staffupdate"){
                        // staff registration inputfield for admin access only

                        /*

                        1. position
                        2. organization

                        */
                        echo '<input value = "'.$q_position.'" required = "required" name="position" type="text" placeholder="Position"/><br>';
                        echo '<input value = "'.$q_organization.'" required = "required" name="organization" type="text" placeholder="Organization"/><br>';
                    }else if ($requestType == "studentupdate"){
                        echo '
                        
                        <input value = "'.$q_student_class.'" style = "text-align: center;width:80%; margin: 0px; margin-top: 3px; margin-bottom: 3px; border-radius: 3px; border: 1px solid;" required = "required" id = "class_search" name = "classID" list = "result-class" placeholder="Class"/>
                        <datalist id="result-class">
                        </datalist>
                        
                        ';
                    }
                    ?>

                    <input value = "<?php echo $q_username?>" required = "required" name="username" type="text" placeholder="Username" value=""><br>
                    <input name="password" type="password" placeholder="Change Password"/><br>
                    
                    <?php
                    /*
                        admin element inputfield control
                        select for account level
                    */
                    
                    if( $requestType == "staffupdate"){
                       if($q_account_level == 1){
                            echo('
                                <select style = "text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" name = "access_Level">
                                    <option value = "'.$q_account_level.'">Currently (Administrator)</option>
                            ');
                       }else{
                            echo('
                            <select style = "text-align-last: center; width: 80%; padding-top: 15px; padding-bottom: 15px;" name = "access_Level">
                                <option value = "'.$q_account_level.'">Currently (Teacher)</option>
                            ');
                       }

                       echo('
                            <option value="1">Administrator</option>
                            <option value="2">Teacher</option>
                        </select><br>');
                    }

                    ?>
                    
                    <input onclick = "return confirm('Update the selected user with these information?')" name="update" type="submit" value="Update"><br>

                </form>
                <?php 
                
                //cancel redirect link
                $linktoReturn;

                if($requestType == "staffupdate"){
                    //staff link
                    $linktoReturn = "staff-search.php";
                }else if($requestType == "studentupdate"){
                    //student link
                    $linktoReturn = "student-search.php";
                }else if($requestType == "classupdate"){
                    //class link
                    $linktoReturn = "class-search.php";
                }else{
                    die("Invalid request type to access update module!");
                }
                
                if(!isset($_GET['redirect']) == "userprofile"){
                    echo "<a href = \"".$linktoReturn."\"><button>Cancel</button></a>";
                }else{
                    echo "<a href = \"user-profile.php?id=$id&user=$q_username&userType=$user_type\"><button>Cancel</button></a>";
                }

                
                ?>
            </center>
        </div>
    </body>
</html>

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

<?php

//error messages
$username_exist = "<script>alert(\"Username already exist\")</script>";
$pf_update_query;

//universal variables
$redirect_location;

if(isset($_POST['update'])){

    //staff update
    if($requestType == "staffupdate"){

        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $bdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $organization = mysqli_real_escape_string($conn, $_POST['organization']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $acc_level = mysqli_real_escape_string($conn, $_POST['access_Level']);

        $password;
        $enc_password;

        //update PF Information
        $q_target_staff = mysqli_query($conn, 
        "SELECT 
        staffs.staff_ID,
        staffs.staff_username AS username,
        COUNT(performance_data.pf_id)
        
        FROM `performance_data` INNER JOIN staffs ON staffs.staff_ID = performance_data.pf_userID
        
        WHERE staffs.staff_ID = $id");

        $r_target_staff = mysqli_fetch_assoc($q_target_staff);

        // update if the results is more than 0
        if($count_target_staff = mysqli_num_rows($q_target_staff) > 0){

            $target_staff_id = $r_target_staff['staff_ID'];
            $target_staff_username = $r_target_staff['username'];

            $update_staff_pfdata = mysqli_query($conn, 
            "UPDATE 
            `performance_data` 
            
            SET 
            `pf_username`= '$username'
            
            WHERE 
            performance_data.pf_userID = $target_staff_id AND
            performance_data.pf_username = '$target_staff_username'");

        }

        //redirect location
        $redirect_location = "location: staff-search.php";

        // if the password inputfield has value, change the password and encrypt again then update the database
        if (!empty($_POST['password'])){

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $enc_password = password_hash($password,PASSWORD_BCRYPT);

            $update = mysqli_multi_query($conn,

            "UPDATE `staffs` 

            SET 
            `staff_fname`='".$fname."',
            `staff_mname`='".$mname."',
            `staff_lname`='".$lname."',
            `staff_birthdate`='".$bdate."',
            `staff_address`='".$address."',
            `staff_organization`='".$organization."',
            `staff_position`='".$position."',
            `staff_username`='".$username."',
            `staff_password`='".$enc_password."',
            `staff_accountLevel`='".$acc_level."'
            
            WHERE `staff_ID` = '$id'
            ") or die (mysqli_error($conn));

        }else{

            // if inputfield password is empty then do not update the password
            $update = mysqli_multi_query($conn,

            "UPDATE `staffs` 

            SET 
            `staff_fname`='".$fname."',
            `staff_mname`='".$mname."',
            `staff_lname`='".$lname."',
            `staff_birthdate`='".$bdate."',
            `staff_address`='".$address."',
            `staff_organization`='".$organization."',
            `staff_position`='".$position."',
            `staff_username`='".$username."',
            `staff_accountLevel`='".$acc_level."'
            
            WHERE `staff_ID` = '$id'

            ") or die (mysqli_error($conn));
        }

    }else if($requestType == "studentupdate"){

        //input elemetns for studetnts
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $bdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $classID = mysqli_real_escape_string($conn, $_POST['classID']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        //update PF Information
        $q_target_student = mysqli_query($conn, 
        "SELECT 
        students.students_ID,
        students.students_username AS username,
        COUNT(performance_data.pf_id)
        
        FROM `performance_data` INNER JOIN students ON students.students_ID = performance_data.pf_userID
        
        WHERE students.students_ID = $id");

        $r_target_student = mysqli_fetch_assoc($q_target_student);

        // update if the results is more than 0
        if($count_target_student = mysqli_num_rows($q_target_student) > 0){

            $target_student_id = $r_target_student['staff_ID'];
            $target_student_username = $r_target_student['username'];

            $update_student_pfdata = mysqli_query($conn, 
            "UPDATE 
            `performance_data` 
            
            SET 
            `pf_username`= '$username'
            
            WHERE 
            performance_data.pf_userID = $target_student_id AND
            performance_data.pf_username = '$target_student_username'");

        }

        //redirect location
        $redirect_location = "location: student-search.php";

        // if the password inputfield has value, change the password and encrypt again then update the database
        if (!empty($_POST['password'])){

            $student_enc_password = password_hash($password,PASSWORD_BCRYPT);

            //update student information
            $student_query = mysqli_query($conn,

            "UPDATE `students` 

            SET 
            `student_fname`='".$fname."',
            `student_mname`='".$mname."',
            `student_lname`='".$lname."',
            `student_birthdate`='".$bdate."',
            `student_address`='".$address."',
            `student_classID`='".$classID."',
            `student_username`='".$username."',
            `student_password`='".$student_enc_password."'

            WHERE

            `student_ID` = '".$id."'
        
        ") or die(mysqli_error($conn));

        }else{

            // if inputfield password is empty then do not update the password
            //update student information
            $student_query = mysqli_query($conn,

            "UPDATE `students` 

            SET 
            `student_fname`='".$fname."',
            `student_mname`='".$mname."',
            `student_lname`='".$lname."',
            `student_birthdate`='".$bdate."',
            `student_address`='".$address."',
            `student_classID`='".$classID."',
            `student_username`='".$username."'

            WHERE

            `student_ID` = '".$id."'
            
            ") or die(mysqli_error($conn));
        }
    }

    if(!$_GET['redirect'] == "userprofile"){
        header($redirect_location);
    }else{
        header('location: user-profile.php?id='.$id.'&user='.$username."&userType=".$user_type);
    }

    
}

?>