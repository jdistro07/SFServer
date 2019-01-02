<?php

require '../php/mod_conn.php';

$account_ID = $_POST['user_ID'];

$q_maxChap = mysqli_query($conn, 
"SELECT 
IFNULL(MAX(tests.test_chapter),0) AS maxChapter

FROM 
performance_data RIGHT JOIN tests ON performance_data.pf_testID = tests.test_ID

WHERE
performance_data.pf_userID = $account_ID AND
performance_data.pf_testMode = 'POST'
") or die(mysqli_error($conn));

$r_maxChap = mysqli_fetch_assoc($q_maxChap);

echo $r_maxChap['maxChapter'];

?>