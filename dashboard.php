<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';

?>

<html>
    <header>

        <title>Dashboard</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

    </header>

    <body>

        <div><?php include 'widgets/navigation.php';?></div>

        <div><?php include 'widgets/logged_user.php';?></div>

        <!-- Main contnainer -->
        <div style = "margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">

        <center><h1>Dashboard</h1></center>

        <div class = "form-group">
            <h5 style = "margin-bottom: 0px;"><span>Class Students</span></h5>
            <hr style = "margin-top: 0px; margin-bottom: 5px;">

            <!--List the classes on a combobox where te user is registered into-->
            <?php

            $userid = $_SESSION["user_ID"];

            $q_class = mysqli_query($conn, 
            "SELECT * 
            FROM class
            WHERE class_staff = $userid

            ") or die (mysqli_error($conn));

            echo "<select class = 'form-control'>";

            echo "<option value = \"\" disabled selected>Your classes...</option>";

            while($r_class = mysqli_fetch_assoc($q_class)){

                echo "<option value = ".$r_class['class_ID'].">Grade: ".$r_class['class_grade']." - ".$r_class['class_section']."</option>";

            }

            echo "</select>";

            ?>
        </div>

            <div>
                <table style = "max-height: 300px; border-color: black; border-width: 3px;" class = "table table-hover table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Class & Section</th>
                            <th>Overall Consistency</th>
                        <tr>
                    </thead>

                    <tbody></tbody>
                </table>
            <div>

        </div>

    </body>
</html>