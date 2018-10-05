<title>Updating tests...</title>

<?php

require 'mod_conn.php';

/*
Process order:
1. Update test credentials
2. Delete the marked questions - To avoid updating itself and avoid misorganization upon insert
3. Update existing questions - Update the records while the new ones are not yet being inserted
4. Insert the questions - Insert new questions
*/

//1. Update test credentials
$testTitle = mysqli_real_escape_string($conn, $_POST['test-name']);
$testID = $_POST['testID'];
$testType;

if(isset($_POST['test-type']) == "built-in"){
    $testType = "Built-in";
}else{
    $testType = "Custom";
}

mysqli_query($conn, 
"UPDATE `tests` 
SET `test_name` = '$testTitle',`test_type` = '$testType' 

WHERE 
test_ID = $testID
") or die(mysqli_error($conn));

//2. Delete the marked questions
if(isset($_POST['markedQuestions'])){

    foreach($_POST['markedQuestions'] as $markedQuestions){
        mysqli_query($conn, 
        "DELETE FROM `questions` 

        WHERE 
        question_id = $markedQuestions AND 
        question_testID = $testID") or die(mysqli_error($conn));
    }

}

//3. Update existing questions and insert new questions
if(isset($_POST['questionID'])){

    $formattedQuestion = $_POST['formatted_question'];
    $queue_insert_questions;

    $last_index = 0;

    for($index = 0; $index < count($_POST['questionID']); $index++){

        $question_formatted = mysqli_real_escape_string($conn,$formattedQuestion[$index]);
        $remaining_questionID = $_POST['questionID'][$index];

        mysqli_query($conn, 
        "UPDATE `questions` 
        SET
        `question_formattedQuestion` = '$question_formatted'
                
        WHERE 
        question_id = $remaining_questionID AND
        question_testID = $testID
        ") or die(mysqli_error($conn));

        unset($formattedQuestion[$index]);

        $last_index++;

    }

    if(count($formattedQuestion) > 0){

        $i = 0;

        do{
            //insert the remaining questions
            $q_current = $formattedQuestion[$last_index];
            
            mysqli_query($conn,
            "INSERT INTO `questions`(
                `question_testID`, 
                `question_formattedQuestion`
            ) 
            VALUES (
                $testID,
                '$q_current'
            )
            ") or die(mysqli_error($conn));

            $last_index++;
            $i++;
            
        }while($i < count($formattedQuestion));

    }

}

// query for the owner ID
$q_owner = mysqli_query($conn, 
"SELECT test_staffAuthor AS author FROM tests WHERE test_ID = $testID
") or die (mysqli_error($conn));

$r_owner = mysqli_fetch_assoc($q_owner);
$owner = $r_owner['author'];

echo 
"<script>
    alert('Test updated successfully');
    window.location.href='../maketest.php?request=update&testID=$testID&owner=$owner';
</script>";

?>
