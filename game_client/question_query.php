<?php 

require '../php/mod_conn.php';

/*This module is in charge of question queries 

The following will be the general overview of the workflow of this module's functionality:

1. Get ID from the game client
2. Query the test with the ID given by the game
3. Query the questions associated with the test
4. Echo formatted string that includes the test information and the questions ready for client-side text parsing

*/

//1. Get ID from the game client
$test_id_request = $_POST['test_ID_request'];

//2. Query the test with the ID given by the game
$q_test =  mysqli_query($conn, 

"SELECT 

tests.test_ID,
tests.test_name,
tests.test_type

FROM `tests`

WHERE tests.test_ID = $test_id_request

") or die (mysql_error($conn));

$r_test = mysqli_fetch_assoc($q_test);

//display information
echo "Information(TestName=".$r_test['test_name']."|TestType=".$r_test['test_type'].")<ed>";

//3. Query the questions associated with the test
$current_test_id = $r_test['test_ID'];
$q_questions = mysqli_query($conn, 

"SELECT 

question_formattedQuestion

FROM `questions` 

WHERE question_testID = $current_test_id

") or die (mysql_error($conn));


//4. Echo formatted sting that includes the test information and the questions ready for client-side text parsing
//loop to each questions
while($r_questions = mysqli_fetch_assoc($q_questions)){

    echo $r_questions['question_formattedQuestion']."~"; // seperator is ~ to be tested

}

mysqli_close($conn);

?>