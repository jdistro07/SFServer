<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

?>

<html>
<head>
    <title>Test Management</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="js/jquery.js"></script>
</head>
<body class = "container-fluid fill-height">

        <div><?php include ("widgets/navigation.php");?></div>
        <div><?php include ("widgets/logged_user.php");?></div>

        <div style = "height: 700px; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">
            <center><h1>GENERAL TEST LIST</h1></center>

            <div class = "form-group">
                <input class="form-control" id="txt_searchbox" type = "text" placeholder="Author Name" name="txt_search" autofocus>
                <input class="form-control" id="txt_search" type = "button" value="Search" name="btn_search" autofocus>
            </div>

            <div>
                <form action = "php/mod_deleteTest.php" method = "post">
                        <input onclick = "return confirm('Deletion of the selected data is permanent and cannot be retrieved. Confirm deleting the selected records?')" id = "button" style = "margin-bottom: 5px; margin-top: -5px; width: 105px; height: 60px; white-space: normal" class = "btn btn-normal" type = "submit" name = "btn-test-delete" value = "Delete Record/s">
                        
                    <div style = "max-height: 445px; overflow-y: auto;">
                        <table style = "border-color: black; border-width: 3px;" class = "table table-hover table-bordered table-sm">
                            <thead class = "thead-dark">
                                <tr>
                                    <th style = "vertical-align: middle; text-align: center">Test ID</th>
                                    <th style = "vertical-align: middle; text-align: center">Test Name</th>
                                    <th style = "vertical-align: middle; text-align: center">Author</th>
                                    <th style = "vertical-align: middle; text-align: center">Menu</th>
                                </tr>
                            </thead>

                            <tbody id = "search-results"><?php require 'php/mod_testSearch.php'; ?></tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
</body>

<script>
    $(document).ready(function(){
        $('input#txt_search').click(function(){
            var searchtext = $('#txt_searchbox').val();

            $.get('php/mod_testSearch.php',{search:searchtext}, function(response){
                $('#search-results').html(response);
            });
        });

        $('#txt_searchbox').on('keyup', function(event){

            event.preventDefault();

            if(event.keyCode == 13){
                $('#txt_search').click();
            }

        });
    })
</script>
</html>