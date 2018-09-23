<?php

// module to query built in test
// test type must be given by the client

require '../php/mod_conn.php';

// variables to store data from client
$test_type = $_POST['test_type'];

    // staff query
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

") or die(mysql_error($conn));

// loop all test items
while($r_test = mysqli_fetch_assoc($q_test)){

    echo "TestID=".$r_test['test_ID']."|Author=".$r_test['staff_fname']." ".$r_test['staff_mname']." ".$r_test['staff_lname']."|Name=".$r_test['test_name']."|TestType=".$r_test['test_type'].":";

}
?>