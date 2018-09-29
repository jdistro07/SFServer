<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

//$req_type = $_GET['request'];

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
                
                max-height: 70%;
                overflow-y: scroll;
                position : relative;
                
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
            <form action = "php/mod_insert_test.php" method = "post">
                <div class = "form-group">

                    <input class = "form-control" type = "text" name = "test-name" placeholder = "Test Name">
                    
                    <div class="input-group mb-3">
                        <input id = "question_count_value" type="text" class="form-control" placeholder="Question item count" aria-label="Question item count" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id = "question_create_count" class="btn btn-outline-secondary" type="button">Create</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name = "test-type" type="checkbox" value="built-in" id="invalidCheck2">
                            <label class="form-check-label" for="invalidCheck2">Built-in test</label>
                        </div>
                    </div>

                    <button id = "btnPublish" class="btn btn-primary" type="submit">Publish</button>

                </div>

                <div id = "question_container"><!--Test question items goes here--></div>
                
                <div id = "formatted_question"><!--Formatted questions goes here--></div>
            </form>
            </div>
        </div>
    </body>

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
            '<select onchange = "question_values(this.value, this)" style = "width: 200px;" id = "test-type" class = "form-control">'+
            '<option value = "not-set" disabled selected>Question Type</option>'+
            '<option value = "mc">Multiple choice</option>'+
            '<option value = "tf">True or False</option>'+
            '</select>'+

            '<div class="input-group mb-3">'+
            '<div class="input-group-prepend">'+
            '<span class="input-group-text" id="basic-addon3">Question</span>'+
            '</div>'+
            '<input type="text" class="form-control" id="txt_question" aria-describedby="basic-addon3">'+
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
            '<input type="text" class="form-control" name = "choice_a" placeholder="Choice value for A" style = "text-align: center">'+
            '</div>';

            var mc_b = 
            '<div id = "mc_value" class="col">'+
            '<input type="text" class="form-control" name = "choice_b" placeholder="Choice value for B" style = "text-align: center">'+
            '</div>';

            var mc_c = 
            '<div id = "mc_value" class="col">'+
            '<input type="text" class="form-control" name = "choice_c" placeholder="Choice value for C" style = "text-align: center">'+
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
			
            var confirmation = confirm("Confirm publication?");
            
            //alert("Working!");
            var question_number = 0;
            var formattedText;
   
            if(confirmation){
                
                
                // loop through each question item and parse the values for insert
                $('#question_container').children('#question_item').each(function (q_index){

                    var test_mode = $(this).find('#test-type').val();
                    var question = $(this).find('#txt_question').val();
                    var question_answer = $(this).find('#questionAnswer').children('#q_answer').val();

                    //alert(question_answer);

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

                    formattedText = q_index+":"+test_mode+":"+question+":"+choices+":"+question_answer;
                    $(this).parent().parent().find('#formatted_question').append('<input type = "text" name = "formatted_question[]" value = "'+formattedText+'">');

                });
                
            }else{
                
                return false;
                
            }
            
		});

    </script>
</html>