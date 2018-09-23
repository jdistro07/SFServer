<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

?>

<html>
<head>
    <title>Class Management</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="js/jquery.js"></script>
</head>
<body class = "container-fluid fill-height">

        <div><?php include ("widgets/navigation.php");?></div>
        <div><?php include ("widgets/logged_user.php");?></div>

        <div style = "overflow-y: auto; margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">
            <center><h1>CLASS LIST</h1></center>

            <div class = "form-group">
                <input class="form-control" id="txt_searchbox" type = "text" placeholder="Instructor/Class Name" name="txt_search" autofocus>
                <input class="form-control" id="txt_search" type = "button" value="Search" name="btn_search" autofocus>
            </div>

            <div>
                <form action = "../php/mod_class-delete.php" method = "post">
                        <input onclick = "return confirm('Deletion of the selected data is permanent and cannot be retrieved. Confirm deleting the selected records?')" id = "button" style = "margin-bottom: 5px; margin-top: -5px; width: 105px; height: 60px; white-space: normal" class = "btn btn-normal" type = "submit" name = "btn-delete" value = "Delete Record/s">
                        
                    <div style = "max-height: 445px; overflow-y: auto;">
                        <table style = "border-color: black; border-width: 3px;" class = "table table-hover table-bordered table-sm">
                            <thead class = "thead-dark">
                                <tr>
                                    <th style = "vertical-align: middle; text-align: center">Class ID</th>
                                    <th style = "vertical-align: middle; text-align: center">Staff Name</th>
                                    <th style = "vertical-align: middle; text-align: center">Class Grade & Section</th>
                                    <th style = "vertical-align: middle; text-align: center">Menu</th>
                                </tr>
                            </thead>

                            <tbody id = "search-results"><?php require 'php/mod_class-search.php'; ?></tbody>
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

            $.get('php/mod_class-search.php',{search:searchtext}, function(response){
                $('#search-results').html(response);
            });
        });
    })
</script>
</html>