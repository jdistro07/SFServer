<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){

        // target student by ID
        $q_targetStaff = mysqli_query($conn, 
        "SELECT students.student_username AS username FROM students WHERE students.student_ID = $checkedRecords
        ") or die(mysqli_error($conn));

        $r_targetStaff = mysqli_fetch_assoc($q_targetStaff);
        $target_username = $r_targetStaff['username'];
        
        // delete student performance
        $q_pf_delete = mysqli_multi_query($conn, 
        "DELETE FROM performance_data WHERE performance_data.pf_userID = $checkedRecords 
        AND performance_data.pf_username = '$target_username'") or die(mysqli_error($conn));

        // delete the student itself
        $q_user_delete = mysqli_query($conn, "DELETE FROM students WHERE student_id = $checkedRecords 
        AND students.student_username = '$target_username'") or die(mysqli_error($conn));

    }

    header('Location: ../student-search.php');
}
?>