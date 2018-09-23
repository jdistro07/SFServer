<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){
        $query = mysqli_query($conn, "DELETE FROM class WHERE class_ID = $checkedRecords");
    }

    header('Location: ../class-search.php');
}
?>