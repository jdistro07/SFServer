<?php

/* Variables to store for granting access to the web pages and modules

1. Account Level
2. Username
3. User ID

*/

session_start();

if(!isset($_SESSION["username"]) && !isset($_SESSION["user_ID"]) && !isset($_SESSION["user_account_level"])){

    // force redirect back to index
    session_destroy();
    header('location:../index.php');

}

?>