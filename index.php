<?php

//if there is a valid user ID on session variables, redirect the user back to the dashboard

session_start();

if(isset($_SESSION["user_ID"]) && !empty($_SESSION["user_ID"])){

    // force redirect back to dashboard because the user is still considered logged in
    header('location: dashboard.php');

}

?>

<html>
    <!--Login Module UI WIP-->
    <header>
        <title>Script Forte - Staff Login</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/login.css" rel="stylesheet" type="text/css"/>
    </header>

    <body>
        <div>
            <center>
                <img src="images/game-banner.png"/>
                <center><H4 class="h4header">Staff Login</H4></center>
                <br>
                <form method="POST" action="php/mod_login.php">
                    <center><p class="dbMessage">No match for Username or Password</p></center>
                    <input required placeholder = "Username" name="username" type="text" autofocus><br>
                    <input required placeholder = "Password" name="password" type="password"><br>
                    <hr>
                    <input name="btn_Login" type="submit" value="Login">
                </form>
            </center> 
        </div>
        
    </body>
    
    <footer></footer>
</html>