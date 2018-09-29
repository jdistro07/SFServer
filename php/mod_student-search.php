<?php

require 'mod_conn.php';

if(isset($_GET['search'])){
    $searchKey = mysqli_real_escape_string($conn, $_GET['search']);

    $result = mysqli_query($conn, 
    
    "SELECT *
    
    FROM students
    
    WHERE 
    students.student_lname LIKE '%$searchKey%'
    OR
    students.student_fname LIKE '%$searchKey%'

    ORDER BY students.student_lname ASC
    "
    
    ) or die("No Results...");

    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "
            
        <td style = \"vertical-align: middle; text-align: center\">
            <input type = \"checkbox\" name = \"deleteMark[]\" value = ".$assoc_row['student_ID'].">".$assoc_row['student_ID']."
        </td>
        
        <td style = \"vertical-align: middle;\">".$assoc_row['student_lname'].", ".$assoc_row['student_fname']." ".$assoc_row['student_mname']."</td>
        
        <td style = \"vertical-align: middle; text-align: center\">
            <a href = \"user-profile.php?id=".$assoc_row['student_ID']."&user=".$assoc_row['student_username']."&userType=student\">Profile</a>
            <a href = \"user-update.php?id=".$assoc_row['student_ID']."&request=studentupdate\">Update</a>
        </td>
        ";
        echo "</tr>";
    }
}else{
    $result = mysqli_query($conn, 
    
    "SELECT *
    FROM students
    ORDER BY students.student_lname ASC
    "
    
    ) or die("No Results...");

    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "
            
        <td style = \"vertical-align: middle; text-align: center\">
            <input type = \"checkbox\" name = \"deleteMark[]\" value = ".$assoc_row['student_ID'].">".$assoc_row['student_ID']."
        </td>
        
        <td style = \"vertical-align: middle;\">".$assoc_row['student_lname'].", ".$assoc_row['student_fname']." ".$assoc_row['student_mname']."</td>
        
        <td style = \"vertical-align: middle; text-align: center\">
            <a href = \"user-profile.php?id=".$assoc_row['student_ID']."&user=".$assoc_row['student_username']."&userType=student\">Profile</a>
            <a href = \"user-update.php?id=".$assoc_row['student_ID']."&request=studentupdate\">Update</a>
        </td>
        ";
        echo "</tr>";
    }
}
?>