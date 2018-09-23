<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){
        $query = mysqli_query($conn, "DELETE FROM students WHERE student_id = $checkedRecords");
    }

    header('Location: ../student-search.php');
}
?>