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
    <center>
        <div class="col-lg-6 col-lg-offset-3" id="container">
            <div class = "form-group">
                <input class="form-control" id="txt_searchbox" type = "text" placeholder="Class Name" name="txt_search" autofocus>
                <input class="form-control" id="txt_search" type = "button" value="Search Class" name="btn_search" autofocus>
            </div>

            <div>
                <table class = "table table-hover table-bordered table-sm">
                    <thead class = "thead-dark">
                        <tr>
                            <th>Class ID</th>
                            <th>Staff Name</th>
                            <th>Class Grade & Section</th>
                        </tr>
                    </thead>

                    <tbody id = "search-results"></tbody>
                </table>
            </div>
        </div>
    </center>
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