<?php
require ("mod_conn.php");

if(isset($_POST['btn-delete'])){
    $records = $_POST['deleteMark'];

    foreach($records as $checkedRecords){

        // target staff by ID
        $q_targetStaff = mysqli_query($conn, 
        "SELECT staffs.staff_username AS username FROM staffs WHERE staffs.staff_ID = $checkedRecords
        ") or die(mysqli_error($conn));

        $r_targetStaff = mysqli_fetch_assoc($q_targetStaff);
        $target_username = $r_targetStaff['username'];
        
        // delete staff performance
        $q_pf_delete = mysqli_multi_query($conn, 
        "DELETE FROM performance_data WHERE performance_data.pf_userID = $checkedRecords 
        AND performance_data.pf_username = '$target_username'");

        // delete the staff itself
        $q_user_delete = mysqli_query($conn, "DELETE FROM staffs WHERE staff_id = $checkedRecords 
        AND staffs.staff_username = '$target_username'");

    }

    header('Location: ../staff-search.php');
}
?>