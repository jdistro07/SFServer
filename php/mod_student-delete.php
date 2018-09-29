<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){

        $query = mysqli_multi_query($conn, 
        "SELECT @username := students.student_username AS username FROM students WHERE students.student_ID = $checkedRecords;

        DELETE FROM performance_data WHERE performance_data.pf_userID = $checkedRecords AND performance_data.pf_username = @username;
        
        DELETE FROM students WHERE students.student_ID = $checkedRecords AND students.student_username = @username");

    }

    header('Location: ../student-search.php');
}
?>