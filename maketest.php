<?php 

// initialize modules on start
require 'php/auth-mods/auth-login.php';
require 'php/mod_conn.php';

$req_type = $_GET['request'];

// test credentials for update
$test_ID;
$test_owner;

// variables for test credentials from the DB
$testName;
$test_type;
$current_testID;

if($req_type == "update"){

    $test_ID = $_GET['testID'];
    $test_owner = $_GET['owner'];
    
    // fetch test credentials from the DB and set the test credential values
    $q_db_testCredentials = mysqli_query($conn, 
    "SELECT test_ID, test_name as testName, test_type FROM tests WHERE tests.test_ID = $test_ID AND test_staffAuthor = $test_owner
    ") or die (mysqli_error($conn));

    $r_db_testCredentials = mysqli_fetch_assoc($q_db_testCredentials);

    $testName = $r_db_testCredentials['testName'];
    $testType = $r_db_testCredentials['test_type'];
    $current_testID = $r_db_testCredentials['test_ID'];

}
?>

<html>
    <header>

        <title>Make Test</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>
        <script src = "js/jquery.js"></script>
        
        <style>
            
            #question_item{
                border-style: solid;
                border-color: black;
                border-width: thin;
                
                padding: 20px;
                box-shadow: 0px 0px 10px 2px silver;
                
                background-color: ghostwhite;
            }
            
            #question_container{
                
                min-height:620px;
                max-height: 620px;
                overflow-y: auto;
                position: relative;
                
            }
            
        </style>

    </header>

    <body>

        <div><?php include 'widgets/navigation.php';?></div>

        <div><?php include 'widgets/logged_user.php';?></div>

        <!-- Main contnainer -->
        <div style = "margin: 0 auto; height: 880px;" class="col-lg-6 col-lg-offset-3" id="container">

            <center><h1>Make Test</h1></center>

            <div>
                <!--Form redirect-->
                <?php 
                if($req_type == "create"){
                    echo "<form action = \"php/mod_insert_test.php\" method = \"post\">";}
                else{
                    echo "<form action = \"php/mod_update_test.php?testID=$test_ID&owner=$test_owner\" method = \"post\">";
                }
                ?>
                <div class = "form-group">

                    <input required class = "form-control" type = "text" name = "test-name" placeholder = "Test Name" <?php if($req_type == "update"){echo "value = \"".$testName."\"";}?>>
                    
                    <div class="input-group mb-3">
                        <input id = "question_count_value" type="text" class="form-control" placeholder="Question item count" aria-label="Question item count" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id = "question_create_count" class="btn btn-outline-secondary" type="button">Create</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name = "test-type" type="checkbox" value="built-in" id="invalidCheck2" 

                            <?php 
                            if($req_type == "update"){
                                if($testType == "Built-in"){
                                    echo "checked";
                                }
                            }?>> <!-- <== DO NOT REMOVE THIS CLOSING ANGLED BRACKET -->

                            <label class="form-check-label" for="invalidCheck2">Built-in test</label>
                        </div>
                    </div>

                    <button id = "btnPublish" class="<?php if($req_type == "update"){echo "btn btn-warning";}else{echo "btn btn-primary";}?>" type="submit"><?php if($req_type == "update"){echo "Update";}else{echo "Publish";}?></button>

                </div>

                <!--Test question items goes here-->
                <div  id = "question_container">
                    <?php
                    // query each test question items if request type is update
                    if($req_type == "update"){

                        $q_questionItems = mysqli_query($conn, 
                        "SELECT * FROM `questions` WHERE questions.question_testID = $current_testID
                        ") or die(mysqli_error($conn));

                        while($r_questionItems = mysqli_fetch_assoc($q_questionItems)){

                            $questionValues = explode(":", $r_questionItems['question_formattedQuestion']);
                            
                            if($questionValues[1] == "mc"){
                                dbQuestion_panels($r_questionItems['question_id'], $questionValues[1], $questionValues[2], $questionValues[6], array(substr($questionValues[3],2),substr($questionValues[4],2), substr($questionValues[5],2)));
                            }else{  
                                dbQuestion_panels($r_questionItems['question_id'], $questionValues[1], $questionValues[2], $questionValues[5]);
                            }
                            
                        }

                    }
                    ?>
                </div>
                
                <div hidden id = "formatted_question"><!--Formatted questions goes here--></div>
                <div hidden id = "questionID"><!--Question IDs goes here--></div>
                <input hidden name = "testID" value = "<?php echo $test_ID;?>">
            </form>
            </div>
        </div>
    </body>

    <?php
    // panels
    function dbQuestion_panels($question_ID, $questionType, $questionText, $questionAnswer, $mcValues = array()){

        // question panel vars
        $cmb_qType;
        $txt_questionValues;
        $answer_value;

        // set combobox
        if($questionType == "mc" && count($mcValues) >= 0){

            // question type combo box
            $cmb_qType = 
            '<span class = "badge badge-secondary">Question Type</span>'.
            '<span class = "badge badge-success">Registered</span>'.
            '<select required onchange = "question_values(this.value, this)" style = "width: 200px;" id = "test-type" class = "form-control">'.
            '<option value = "mc" selected>Multiple choice</option>'.
            '<option value = "tf">True or False</option>'.
            '</select>';

            // question values concatinated
            $txt_questionValues = 
            '<div id = "mc_value" class="col">'.
            '<input required type="text" class="form-control" value = "'.trim(htmlspecialchars($mcValues[0])).'" name = "choice_a" placeholder="Choice value for A" style = "text-align: center">'.
            '</div>';

            $txt_questionValues .=
            '<div id = "mc_value" class="col">'.
            '<input required type="text" class="form-control" value = "'.trim(htmlspecialchars($mcValues[1])).'" name = "choice_b" placeholder="Choice value for B" style = "text-align: center">'.
            '</div>';

            $txt_questionValues .= 
            '<div id = "mc_value" class="col">'.
            '<input required type="text" class="form-control" value = "'.trim(htmlspecialchars($mcValues[2])).'" name = "choice_c" placeholder="Choice value for C" style = "text-align: center">'.
            '</div>';

            //set answer values default the answers from the current test
            $answer_value = 
            '<span class = "badge badge-success">Question Answer</span>'.
            '<select class = "form-control" id = "q_answer">';
            
            switch($questionAnswer){
                case "A":

                $answer_value .= 
                '<option value = "A" selected>A</option>'.
                '<option value = "B">B</option>'.
                '<option value = "C">C</option>';
                break;

                case "B":
                
                $answer_value .= 
                '<option value = "A">A</option>'.
                '<option value = "B" selected>B</option>'.
                '<option value = "C">C</option>';
                break;

                case "C":
                
                $answer_value .= 
                '<option value = "A">A</option>'.
                '<option value = "B">B</option>'.
                '<option value = "C" selected>C</option>';
                break;
            }

            $answer_value .= '</select>';


        }else{
            
            // question type combo box
            $cmb_qType = 
            '<span class = "badge badge-secondary">Question Type</span>'.
            '<span class = "badge badge-success">Registered</span>'.
            '<select required onchange = "question_values(this.value, this)" style = "width: 200px;" id = "test-type" class = "form-control">'.
            '<option value = "mc">Multiple choice</option>'.
            '<option value = "tf" selected>True or False</option>'.
            '</select>';

            $txt_questionValues = "";

            //set answer values default the answers from the current test
            $answer_value = 
            '<span class = "badge badge-success">Question Answer</span>'.
            '<select class = "form-control" id = "q_answer">';
            
            switch($questionAnswer){
                case "T":

                $answer_value .= 
                '<option value = "T" selected>True</option>'.
                '<option value = "F">False</option>';
                break;

                case "F":
                
                $answer_value .= 
                '<option value = "T">True</option>'.
                '<option value = "F" selected>False</option>';
                break;
            }

            $answer_value .= '</select>';
            

        }

        echo $questionPanel = 
        '<div id = "question_item" class = "form-group">'.
        '<hr size = "30" style = "margin: 0 0 0 0;">'.

        '<input id = "deleteMark" value = "'.$question_ID.'" onclick = "markDelete_handler(this)" type="checkbox" class="close" aria-label="Close">'.
        '<span aria-hidden="true">&times;</span>'.
        '</button>'.
        $cmb_qType.
    
        '<div class="input-group mb-3">'.
        '<div class="input-group-prepend">'.
        '<span class="input-group-text" id="basic-addon3">Question</span>'.
        '</div>'.
        '<input required type="text" class="form-control" id="txt_question" aria-describedby="basic-addon3" value = "'.$questionText.'">'.
        '<input hidden required type="text" name = "questionID[]" class="form-control" id="txt_ID" aria-describedby="basic-addon3" value = "'.$question_ID.'">'.
        '</div>'.
        '<div id = "questionValue" class="form-row">'.$txt_questionValues.'</div>'.
        '<div id = "questionAnswer">'.$answer_value.'</div>'.
        '</div>';
    }
    ?>

    <script>

        var question_count = 0;

        $(document).ready(function(){

            var element = 
            '<div id = "question_item" class = "form-group">'+

            '<hr size = "30" style = "margin: 0 0 0 0;">'+

            '<button onclick = "remove_question(this)" id = "delete" type="button" class="close" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
            '</button>'+

            '<span class = "badge badge-secondary">Question Type</span>'+
            '<select required onchange = "question_values(this.value, this)" style = "width: 200px;" id = "test-type" class = "form-control">'+
            '<option value = "not-set" disabled selected>Question Type</option>'+
            '<option value = "mc">Multiple choice</option>'+
            '<option value = "tf">True or False</option>'+
            '</select>'+

            '<div class="input-group mb-3">'+
            '<div class="input-group-prepend">'+
            '<span class="input-group-text" id="basic-addon3">Question</span>'+
            '</div>'+
            '<input required type="text" class="form-control" id="txt_question" aria-describedby="basic-addon3">'+
            '</div>'+
            '<div id = "questionValue" class="form-row"></div>'+
            '<div id = "questionAnswer"></div>'
            '</div>';
            
            $('#question_create_count').click('load', function(){
                
                var questioncount = $('#question_count_value').val();
                
                for(var i = 0; i < questioncount; i++){
                    
                    $('#question_container').append(element);
                    
                }
                
            });
            
        });
        
        function markDelete_handler(ele){

            var confirmation;

            if($(ele).prop('checked') == true){

                confirmation = confirm("Mark this question for deletion?");
                
                // change color as a representation of "Marked for deletion"
                $(ele).parent('#question_item').css("background-color", "#e74c3c");

            }else{
                // change color to default if not marked
                $(ele).parent('#question_item').css("background-color", "ghostwhite");
            }

            if(!confirmation){
                $(ele).prop('checked', false);
                $(ele).parent('#question_item').css("background-color", "ghostwhite");
            }
            
            
        }
        
        function remove_question(ele){

            var confirmation = confirm("Delete this item?");
            
            if(confirmation){
                
                $(ele).parent('#question_item').remove();
                
            }else{
                
                return false;
                
            }
                
        }
        
        function question_values(value, ele){
            
            //control clean up
            $(ele).parent('#question_item').children("#questionValue").children('#mc_value').remove();
            $(ele).parent('#question_item').children("#questionAnswer").children('span, #q_answer').remove();
            
            var mc_a = 
            '<div id = "mc_value" class="col">'+
            '<input required type="text" class="form-control" name = "choice_a" placeholder="Choice value for A" style = "text-align: center">'+
            '</div>';

            var mc_b = 
            '<div id = "mc_value" class="col">'+
            '<input required type="text" class="form-control" name = "choice_b" placeholder="Choice value for B" style = "text-align: center">'+
            '</div>';

            var mc_c = 
            '<div id = "mc_value" class="col">'+
            '<input required type="text" class="form-control" name = "choice_c" placeholder="Choice value for C" style = "text-align: center">'+
            '</div>';
            
            var tf_answer =
                '<span class = "badge badge-success">Question Answer</span>'+
                '<select class = "form-control" id = "q_answer">'+
                '<option value = "T">True</option>'+
                '<option value = "F">False</option>'+
                '</select>';
            
            var mc_answer =
                '<span class = "badge badge-success">Question Answer</span>'+
                '<select class = "form-control" id = "q_answer">'+
                '<option value = "A">A</option>'+
                '<option value = "B">B</option>'+
                '<option value = "C">C</option>'+
                '</select>';

            if(value == "mc"){

                $(ele).parent('#question_item').children("#questionValue").append(mc_a+mc_b+mc_c);
                $(ele).parent('#question_item').children("#questionAnswer").append(mc_answer);

            }else if(value == "tf"){

                $(ele).parent('#question_item').children("#questionAnswer").append(tf_answer);
                
            }
            
        }
        
        $('#btnPublish').on('click', function(){

            // clean up
            $(this).parent().parent().find('#formatted_question').children('input').remove();

            var confirmation = confirm("Confirm publication?");
            
            var question_number = 0;
            var formattedText;
   
            if(confirmation){

                // store ID of marked questions into q_IDs array and send the array to mod_update.php
                var q_IDs = [];

                $('#question_container').children('#question_item').find('#deleteMark').map(function(){

                    if($(this).prop('checked') == true){
                        q_IDs.push($(this).val()); // push/add IDs into the array
                    }

                });

                for(let i = 0; i < q_IDs.length; i++){
                    $(this).parent().parent().find('#questionID').append('<input type = "text" name = "markedQuestions[]" value = "'+q_IDs[i]+'">');
                }
                
                // loop through each question item and parse the values for insert
                $('#question_container').children('#question_item').each(function (q_index){

                    // delete marked panels
                    var deleteMarker = $(this).find('#deleteMark').prop('checked');
                    
                    if(deleteMarker){
                        $(this).find('#deleteMark').parent().remove();
                    }

                    // set and parse question values
                    var test_mode = $(this).find('#test-type').val();
                    var question = $(this).find('#txt_question').val();
                    var question_answer = $(this).find('#questionAnswer').children('#q_answer').val();

                    //choices
                    var choices;

                    if(test_mode == "mc"){

                        choices = $(this).children('#questionValue').find('input[name ^= "choice"]').map(function(index, elem){

                            var letter = String.fromCharCode(64 + (index+1));
                            return letter+". "+$(this).val();

                        }).get().join(':');

                    }else{

                        choices = "True:False"

                    }
                    console.log(choices);

                    formattedText = q_index+":"+test_mode+":"+question+":"+choices+":"+question_answer;
                    $(this).parent().parent().find('#formatted_question').append('<input type = "text" name = "formatted_question[]" value = "'+htmlspecialchars(formattedText)+'">');

                });
                
            }else{
                
                return false;
                
            }

            function htmlspecialchars(str) {
                if (typeof(str) == "string") {
                    str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
                    str = str.replace(/"/g, "&quot;");
                    str = str.replace(/'/g, "&#039;");
                    str = str.replace(/</g, "&lt;");
                    str = str.replace(/>/g, "&gt;");
                }
                return str;
            }
            
		});

    </script>
</html>
