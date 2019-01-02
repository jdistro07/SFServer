<?php

// module to query built in test
// test type must be given by the client

require '../php/mod_conn.php';

$q_test;
$test_type = $_POST['test_type'];

if($test_type == "Built-in"){

    $q_test = mysqli_query($conn, 

    "SELECT 
    tests.*, 

    staffs.staff_ID, 
    staffs.staff_username,
    staffs.staff_fname, 
    staffs.staff_mname, 
    staffs.staff_lname

    FROM `tests` 
    LEFT JOIN `staffs` ON tests.test_staffAuthor = staffs.staff_ID

    WHERE tests.test_type = '$test_type'

    ORDER BY tests.test_chapter ASC

    ") or die(mysql_error($conn));

}elseif($test_type == "Custom"){

    $q_test = mysqli_query($conn, 

    "SELECT 
    tests.*, 

    staffs.staff_ID, 
    staffs.staff_username,
    staffs.staff_fname, 
    staffs.staff_mname, 
    staffs.staff_lname

    FROM `tests` 
    INNER JOIN `staffs` ON tests.test_staffAuthor = staffs.staff_ID

    WHERE 
    tests.test_type = '$test_type' AND 
    tests.test_visibility = 1

    ") or die(mysql_error($conn));

}

// loop all test items
while($r_test = mysqli_fetch_assoc($q_test)){

    echo "TestID=".$r_test['test_ID']."|Author=".$r_test['staff_fname']." ".$r_test['staff_mname']." ".$r_test['staff_lname']."|Name=".$r_test['test_name']."|TestType=".$r_test['test_type']."|TestChapter=".$r_test['test_chapter'].":";

}

mysqli_close($conn);
?>