<?php 

//initialize modules on start
require 'php/auth-mods/auth-login.php';
$userid = $_SESSION["user_ID"];

?>

<html>
    <header>
        <title>Dashboard</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/class-search.css" rel="stylesheet" type="text/css"/>

        <script src = "js/jquery.js"></script>
    </header>

    <body>

        <div><?php include 'widgets/navigation.php';?></div>

        <div><?php include 'widgets/logged_user.php';?></div>

        <!-- Main contnainer -->
        <div style = "margin: 0 auto;" class="col-lg-6 col-lg-offset-3" id="container">

            <center><h1>Dashboard</h1></center>

            <!--Test list table-->
            <div>
                <h4 style = "margin: 2px 2px 2px 2px;">Test list</h4>
                <hr style = "margin: 2px 2px 5px 2px;"/>
            </div>
            <form action = "../php/mod_deleteTest.php" method = "POST">
                <input class = "btn btn-danger" type = "submit" value = "Delete" name = "btn-testDelete">

                <div style = "overflow-y: auto; max-height: 300px; 300px; border-color: black; border-width: 3px;">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Test Name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Type</th>
                            <th scope="col">Availability</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                            <!--Loop tests published by the current logged user-->
                            <?php
                            $q_ownedTests = mysqli_query($conn, 
                            "SELECT 
                            tests.*,
                            CONCAT(
                                staffs.staff_lname,
                                ', ',
                                staffs.staff_fname,
                                ' ',
                                staffs.staff_mname
                            ) AS authorName
                            
                            FROM tests LEFT JOIN staffs ON tests.test_staffAuthor = staffs.staff_ID
                            
                            WHERE 
                            tests.test_staffAuthor = $userid ORDER BY tests.test_name ASC
                            ") or die(mysqli_error($conn));

                            while($r_ownedTests = mysqli_fetch_assoc($q_ownedTests)){
                                echo '<tr>';
                                echo '<th scope="row"><input type = "checkbox" name = "testsMark[]" value = '.$r_ownedTests['test_ID'].'></th>';
                                echo '<td style = "width: 300px;"><a style = "text-decoration: none;" href = "maketest.php?request=update?testID='.$r_ownedTests['test_ID'].'&owner='.$userid.'">'.$r_ownedTests['test_name'].'</a></td>';
                                echo '<td>'.$r_ownedTests['authorName'].'</td>';
                                echo '<td>'.$r_ownedTests['test_type'].'</td>';

                                // show combobox only for custom tests
                                if($r_ownedTests['test_type'] == "Custom"){
                                    echo '
                                    <td align = "center">
                                        <select>
                                            <option value = "private">Private/Hidden</option>
                                            <option value = "broadcast">Show</option>
                                        </select>
                                    </td>';
                                }else{
                                    echo '<td align = "center"><i>In-game</i></td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </body>
</html>