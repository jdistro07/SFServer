<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Please wait...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
</html>

<?php

require 'mod_conn.php';
require 'auth-mods/auth-login.php';

$currentUser = $_SESSION["user_ID"];
$test_name = $_POST['test-name'];
$formatted_text = $_POST['formatted_question'];
$test_type;

if(isset($_POST['test-type'])){
    $test_type = "Built-in";
}else{
    $test_type = "Custom";
}

//insert test
$insert_test = mysqli_query($conn, 
"INSERT INTO `tests`(
    `test_staffAuthor`, 
    `test_name`, 
    `test_type`) 

VALUES (
    $currentUser,
    '$test_name',
    '$test_type')

") or die(mysqli_error($conn));

$test_ID = mysqli_query($conn, 
"SELECT @lastID :=(LAST_INSERT_ID()) AS lastID
") or die (mysqli_error($conn));

$r_testID = mysqli_fetch_assoc($test_ID);

if($insert_test){

    for($i = 0; $i < count($formatted_text); $i++){

        $text = $formatted_text[$i];
        $id = $r_testID['lastID'];

        $insert_question = mysqli_query($conn, 
        "INSERT INTO `questions`(
            `question_testID`, 
            `question_formattedQuestion`) 
         VALUES (
            $id,
            '$text')
        
        ") or die(mysqli_error($conn));

    }

    echo "<script>alert('Your test has been published!')</script>";
    header('location:../maketest.php');

}

?>