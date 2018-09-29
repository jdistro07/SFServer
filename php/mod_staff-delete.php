<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){

        //echo $checkedRecords."<br>";
        
        $query = mysqli_multi_query($conn, 
        "SELECT @username := staffs.staff_username AS username FROM staffs WHERE staffs.staff_ID = $checkedRecords;
        
        DELETE FROM performance_data WHERE performance_data.pf_userID = $checkedRecords AND performance_data.pf_username = @username;
        
        DELETE FROM staffs WHERE staff_id = $checkedRecords AND staffs.staff_username = @username");

    }

    header('Location: ../staff-search.php');
}
?>