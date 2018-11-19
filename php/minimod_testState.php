<?php
require 'mod_conn.php';

if(isset($_GET['state'])){

    // assign the values for mode
    $value = explode(":",$_GET['state']);
    
    $target_ID = $value[0];
    $modeVal;

    if($value[1] == "broadcast"){
        $modeVal = 1;
    }elseif($value[1] == "private"){
        $modeVal = 0;
    }

    $update_testVisibility = mysqli_query($conn, 
    "UPDATE `tests` 
    SET `test_visibility` = $modeVal 
    WHERE `test_ID` = $target_ID
    ") or die(mysqli_error($conn));

    $q_testName = mysqli_query($conn, 
    "SELECT 
    `test_name`
    
    FROM `tests`
    WHERE `test_ID` = $target_ID
    ") or die(mysqli_error($conn));

    $q_testName = mysqli_fetch_assoc($q_testName);

    if($update_testVisibility){
        echo $q_testName['test_name']." has been set to ".ucfirst($value[1]);
    }

    mysqli_close($conn);
}
?>