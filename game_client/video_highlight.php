<?php

require '../php/mod_conn.php';

$user_name = $_POST['username'];
$user_id = $_POST['user_ID'];
$testID = $_POST['testID'];

// count all user pre performance
$q_pre_count = mysqli_query($conn, 
"SELECT 
COUNT(pf_testMode) AS pre

FROM performance_data

WHERE 
pf_userID = $user_id AND 
pf_username = '$user_name' AND
pf_testID = $testID AND
pf_testMode = 'PRE'

") or die (mysqli_error($conn));

$r_pre_count = mysqli_fetch_assoc($q_pre_count);

$q_post_count = mysqli_query($conn, 
"SELECT 
COUNT(pf_testMode) AS post

FROM performance_data

WHERE 
pf_userID = $user_id AND 
pf_username = '$user_name' AND
pf_testID = $testID AND
pf_testMode = 'POST'

") or die (mysqli_error($conn));

$r_post_count = mysqli_fetch_assoc($q_post_count);

// if pre test > 1
if($r_pre_count['pre'] > 0 && $r_post_count['post'] == 0){

    echo "Highlight";

}else{
    echo "No result:[pre]:".$r_pre_count['pre']."[post]:".$r_post_count['post']."[userid]:".$user_id."[username]:".$user_name."[test]:".$testID;
}

?>