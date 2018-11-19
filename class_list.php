<?php

require "php/mod_conn.php";
require_once "php/auth-mods/auth-login.php";

// query class values
$class_id = $_GET["id"];

// query class data
$q_class = mysqli_query(
    $conn,
    "SELECT * FROM class WHERE class_ID = $class_id"
) or die(mysqli_error($conn));

$r_class = mysqli_fetch_assoc($q_class);
?>

<html>
    <header>
        <title>Class List of <?php echo "Grade ".$r_class["class_grade"]." - ".$r_class["class_section"]; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

        <script src = "js/jquery.js"></script>
    </header>

    <body>
        <div><?php include 'widgets/navigation.php';?></div>
        <div><?php include 'widgets/logged_user.php';?></div>

        <div style = "height: 840px; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">
            <center><h1><?php echo "Grade ".$r_class["class_grade"]." - ".$r_class["class_section"];?></h1></center>
            <div style = "max-height: 445px; overflow-y: auto;">
                <table style = "border-color: black; border-width: 3px;" class = "table table-hover table-bordered table-sm">
                    <thead class = "thead-dark">
                        <tr>
                            <th style = "vertical-align: middle; text-align: center">Student ID</th>
                            <th style = "vertical-align: middle; text-align: center">Student Name</th>
                            <th style = "vertical-align: middle; text-align: center">Menu</th>
                        </tr>
                    </thead>

                    <tbody id = "search-results">
                    <?php
                    $result = mysqli_query($conn, 
    
                    "SELECT *
                    FROM students
                    WHERE student_classID = $class_id
                    ORDER BY students.student_lname ASC
                    "
                    
                    ) or die("No Results...");
                
                    while($assoc_row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "
                            
                        <td style = \"vertical-align: middle; text-align: center\">
                            ".$assoc_row['student_ID']."
                        </td>
                        
                        <td style = \"vertical-align: middle;\">".$assoc_row['student_lname'].", ".$assoc_row['student_fname']." ".$assoc_row['student_mname']."</td>
                        
                        <td style = \"vertical-align: middle; text-align: center\">
                            <a href = \"user-profile.php?id=".$assoc_row['student_ID']."&user=".$assoc_row['student_username']."&userType=student\">Profile</a>
                            <a href = \"user-update.php?id=".$assoc_row['student_ID']."&request=studentupdate\">Update</a>
                        </td>
                        ";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>