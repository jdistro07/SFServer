<html>
    <header>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/global-style.css" rel="stylesheet" type="text/css"/>

        <style>
            #btn-logout, #btn_profile{
                width: 200px;
                margin: 5px; auto, auto, auto;
            }
        </style>
    </header>

    <div style = "right: 3px; top: 1%; position: fixed; margin: 0px;" class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">
        
        <div style = "background-color: white; max-height: 300px; height: 300px;" class = "container">

            <div style = "padding: 10 0 5px 0;">
                <center><h4>Welcome <?php if($_SESSION['user_account_level'] == 1){echo "Administrator";}else{echo "Teacher";}?></h4></center>
            </div>

            <div>

                <p>
                    <?php 

                    // modules
                    require 'php/mod_conn.php';

                    //query current logged user by session
                    $userID = $_SESSION['user_ID'];
                    $username = $_SESSION['username'];

                    $q_logged_user = mysqli_query($conn, 

                    "SELECT * FROM `staffs` 
                    WHERE staffs.staff_ID = $userID AND staffs.staff_username = '$username';
                    ");

                    $r_user = mysqli_fetch_assoc($q_logged_user);

                    $fname = $r_user['staff_fname'];
                    $mname = $r_user['staff_mname'];

                    
                    echo "<table>";
                        echo "<tbody>";

                            echo "<tr>";
                                echo "<td style = \"padding: 0 20px 0 0;\">Name:</td>";
                                echo "<td>".$r_user['staff_fname']." ".$r_user['staff_mname']." ".$r_user['staff_lname']."</td>";
                            echo "</tr>";

                            echo "<tr>";
                                echo "<td style = \"padding: 0 20px 0 0;\">Organization:</td>";
                                echo "<td>".$r_user['staff_organization']."</td>";
                            echo "</tr>";

                            echo "<tr>";
                                echo "<td style = \"padding: 0 20px 0 0;\">Position:</td>";
                                echo "<td>".$r_user['staff_position']."</td>";
                            echo "</tr>";

                        echo "</tbody>"; 
                    echo "</table>";
                    ?>
                </p>

            </div>

            <div>
                <center><a href = "user-profile.php?id=<?php echo $_SESSION["user_ID"];?>&user=<?php echo $_SESSION["username"];?>&userType=staff&accproperty=owner"><button id = "btn_profile" type="button" class="btn btn-primary">PROFILE</button></a><center>
                <form action = "php/mod_logout.php" method = "get">
                    <center><input id = "btn-logout" onclick = "return confirm('Are you sure to logout?')" class = "btn btn-danger" type = "submit" name = "btn-logout" value = "LOGOUT"></center>
                </form>
            </div>
            
        </div>

    </div>
</html>
