<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
require ("php/mod_conn.php");

$class_id = $_GET['id'];

//query corresponding entry by class ID
$class_entry = mysqli_query($conn,

"SELECT * FROM class WHERE class_ID = '$class_id'"

) or die(mysqli_error($conn));

$class_query_result = mysqli_fetch_assoc($class_entry);

?>

<html>
    <header>
        <title>Class Update Information</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <script src = "js/jquery.js"></script>
    </header>

    <body class="container-fluid fill-height">
        <div id = "divContainer" style = "height: 100%;" class="col-lg-6 col-lg-offset-3">
            <center>
                <h1>Class Registration</h1>
                <br>
                <form method = "post">
                    <input value = "<?php echo $class_query_result['class_staff']; ?>"  id = "staff" required = "required" name="classStaff" type="text" placeholder="Class Staff" list = "result-staffs" autofocus/><br>
                    <datalist id="result-staffs"></datalist>
                    <input value = "<?php echo $class_query_result['class_grade']; ?>" required = "required" name="classGrade" type="text" placeholder="Class Grade"/><br>
                    <input value = "<?php echo $class_query_result['class_section']; ?>" required = "required" name="classSection" type="text" placeholder="Class Section"/><br>

                    <input onclick = "return confirm('Confirm updating the selected class?')" name="register" type="submit" value="Update Class Information"><br>
                </form>
                <a href="class-search.php"><button>Cancel</button></a>
            </center>
        </div>
    </body>
</html>

    <script>
    $(document).ready(function(){
        $('#staff').keyup(function(){
            var searchtext = $('#staff').val();

            $.get('php/minimod_staff-search.php',{search:searchtext}, function(response){
                $('#result-staffs').html(response);
            });
        });
    })
    </script>

<?php

if(isset($_POST['register'])){

    $staff = mysqli_real_escape_string($conn, $_POST['classStaff']);
    $grade = mysqli_real_escape_string($conn, $_POST['classGrade']);
    $section = mysqli_real_escape_string($conn, $_POST['classSection']);
    
    $query = mysqli_query($conn,
    "UPDATE `class` 
    SET 

    `class_staff`='$staff',
    `class_grade`='$grade',
    `class_section`='$section' 

    WHERE class_ID = $class_id

    ") or die(mysqli_error($conn));

    header("location: class-search.php");

}


?>