<?php

require 'mod_conn.php';

$result;

if(isset($_GET['search'])){
    $searchKey = mysqli_real_escape_string($conn, $_GET['search']);

    $result = mysqli_query($conn, 
    
    "SELECT students.*, IFNULL(CONCAT('Grade ',class.class_grade,' - ',class.class_section), 'Not enrolled!') AS grade
    
    FROM students LEFT JOIN class ON students.student_classID = class.class_ID
    
    WHERE 
    students.student_lname LIKE '%$searchKey%'
    OR
    students.student_fname LIKE '%$searchKey%'

    ORDER BY students.student_lname ASC
    "
    
    ) or die("No Results...");
}else{
    $result = mysqli_query($conn, 
    
    "SELECT students.*, IFNULL(CONCAT('Grade ',class.class_grade,' - ',class.class_section), 'Not enrolled!') AS grade
    FROM students LEFT JOIN class ON students.student_classID = class.class_ID
    ORDER BY students.student_lname ASC
    "
    
    ) or die("No Results...");
}

while($assoc_row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "
        
    <td style = \"vertical-align: middle; text-align: center\">
        <input type = \"checkbox\" name = \"deleteMark[]\" value = ".$assoc_row['student_ID'].">".$assoc_row['student_ID']."
    </td>
    
    <td style = \"vertical-align: middle;\">".$assoc_row['student_lname'].", ".$assoc_row['student_fname']." ".$assoc_row['student_mname']."</td>
    
    <td align = \"center\" style = \"vertical-align: middle;\">".$assoc_row['grade']."</td>

    <td style = \"vertical-align: middle; text-align: center\">
        <a href = \"user-profile.php?id=".$assoc_row['student_ID']."&user=".$assoc_row['student_username']."&userType=student\">Profile</a>
        <a href = \"user-update.php?id=".$assoc_row['student_ID']."&request=studentupdate\">Update</a>
    </td>
    ";
    echo "</tr>";
}
?>