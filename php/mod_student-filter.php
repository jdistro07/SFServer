<?php
/* Module for dashboard filtering students by grade */
require 'mod_conn.php';

if(isset($_GET['filter']) && !empty($_GET['filter'])){
    
    $filter = $_GET['filter'];

    $q_class_student = mysqli_query($conn,
    "SELECT 
    students.*,
    class.class_ID,
    CONCAT('Grade ',class.class_grade, ' - ', class.class_section) AS gradeLevel

    FROM `students` LEFT JOIN class ON students.student_classID = class.class_ID

    WHERE
    students.student_classID = $filter

    ORDER BY students.student_lname ASC
    ") or die(mysqli_error($conn));

    while($r_class_student = mysqli_fetch_assoc($q_class_student)){

        echo '<tr>';
        echo '<td><a style = "text-decoration: none" href = "user-profile.php?id='.$r_class_student['student_ID'].'&user='.$r_class_student['student_username'].'&userType=student">'.$r_class_student['student_lname'].", ".$r_class_student['student_fname']." ".$r_class_student['student_mname'].'</a></td>';
        echo '<td class = "text-center">'.$r_class_student['gradeLevel'].'</td>';
        echo '</tr>';

    }
}else{

    echo "<i>No students...</i>";

}


?>