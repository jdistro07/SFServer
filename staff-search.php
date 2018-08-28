<html>
<head>
    <title>Staff Accounts List</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="js/jquery.js"></script>
</head>
<body class = "container-fluid fill-height">
    <center>
        <div class="col-lg-6 col-lg-offset-3" id="container">
            <div class = "form-group">
                <input class="form-control" id="txt_searchbox" type = "text" placeholder="Instructor/Class Name" name="txt_search" autofocus>
                <input class="form-control" id="txt_search" type = "button" value="Search" name="btn_search" autofocus>
            </div>

            <div>
                <form action = "../php/mod_staff-delete.php" method = "post">
                    <input style = "margin-bottom: 5px; margin-top: -5px; width: 105px; height: 60px; white-space: normal" class = "btn btn-danger" type = "submit" name = "btn-delete" value = "Delete Record/s">
                    <table class = "table table-hover table-bordered table-sm">
                        <thead class = "thead-dark">
                            <tr>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Menu</th>
                            </tr>
                        </thead>

                        <tbody id = "search-results"><?php require 'php/mod_staff-search.php'; ?></tbody>
                    </table>
                <form>
            </div>
        </div>
    </center>
</body>

<script>
    $(document).ready(function(){
        $('input#txt_search').click(function(){
            var searchtext = $('#txt_searchbox').val();

            $.get('php/mod_staff-search.php',{search:searchtext}, function(response){
                $('#search-results').html(response);
            });
        });
    })
</script>
</html>