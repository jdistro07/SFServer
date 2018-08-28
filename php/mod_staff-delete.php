<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){
        $query = mysqli_query($conn, "DELETE FROM staffs WHERE staff_id = $checkedRecords");
    }

    header('Location: ../staff-search.php');
}
?>