<?php
require 'mod_conn.php';

$redirect;

if(isset($_POST['btn-test-delete'])){
    $redirect = "test_list.php";
}else{
    $redirect = "dashboard.php";
}

if(isset($_POST['btn-testDelete']) || isset($_POST['btn-test-delete'])){
    
    if(isset($_POST['testsMark'])){
        $markedTest = $_POST['testsMark'];

        foreach($markedTest as $marked){
            
            // delete question items
            $q_deleteQuestions = mysqli_query($conn, 
            "DELETE FROM questions WHERE questions.question_testID = $marked
            ") or die(mysqli_error($conn));
            
            // delete test
            $q_deleteTest = mysqli_query($conn, 
            "DELETE FROM tests WHERE tests.test_ID = $marked
            ") or die(mysqli_error($conn));

        }

        // alert the user for successful deletion of tests
        echo 
        "<script>
            alert('Marked tests successfully deleted!');
            window.location.href='../$redirect';
        </script>";
    }else{
        echo 
        "<script>
            alert('No test/s to delete.');
            window.location.href='../$redirect';
        </script>";
    }

}
?>