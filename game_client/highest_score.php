<?php

require '../php/mod_conn.php';

$username = $_POST['username'];
$userID =  $_POST['userID'];
$test_ID = $_POST['test_ID'];

$q_rating = mysqli_query($conn,
"SELECT 

performance_data.pf_id,
performance_data.pf_testID,

tests.test_name,
tests.test_type,

performance_data.pf_username,
performance_data.pf_testID,
performance_data.pf_testMode,
@pre := MAX(performance_data.pf_rating) AS pre,

@post := (

    SELECT 
    
    @post := MAX(performance_data.pf_rating)
    
    FROM performance_data LEFT JOIN tests ON performance_data.pf_testID = tests.test_ID
    
    WHERE 
    performance_data.pf_testMode = 'POST' AND 
    performance_data.pf_userID = $userID AND
    performance_data.pf_username = '$username' AND
    tests.test_ID = $test_ID
    

) AS post


FROM performance_data LEFT JOIN tests ON performance_data.pf_testID = tests.test_ID

WHERE 

performance_data.pf_testMode = 'PRE' AND
performance_data.pf_username = '$username' AND
performance_data.pf_userID = $userID AND
tests.test_ID = $test_ID

") or die(mysqli_errno($conn));

$r_rating = mysqli_fetch_assoc($q_rating);

echo "Rate_PostTest=".$r_rating['post']."|Rate_PreTest=".$r_rating['pre'];

?>