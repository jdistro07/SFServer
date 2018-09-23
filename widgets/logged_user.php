<html>
    <header>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/global-style.css" rel="stylesheet" type="text/css"/>

        <style>
            #btn-logout{
                width: 200px;
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
                <form method = "get">
                    <center><input id = "btn-logout" onclick = "return confirm('Are you sure to logout?')" class = "btn btn-danger" type = "submit" name = "btn-logout" value = "LOGOUT"></center>
                </form>
            </div>
            
        </div>

    </div>
</html>

<?php 

if(isset($_GET['btn-logout'])){

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

header("location: index.php");

}

?>