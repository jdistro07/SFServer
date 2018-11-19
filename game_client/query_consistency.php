<?php

require '../php/mod_conn.php';

$username = $_POST['client_username'];
$accountID = $_POST['client_user_ID'];

$score_query = mysqli_query($conn,
"SELECT AVG(pf_rating) FROM `performance_data` WHERE pf_userID = $accountID AND pf_username = '$username'
") or die (mysqli_error($conn));

$score_query_result = mysqli_fetch_assoc($score_query);

echo round($score_query_result['AVG(pf_rating)'],2);

mysqli_close($conn);

?>