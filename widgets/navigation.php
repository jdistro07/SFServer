<?php 

/* ADMIN ONLY modules

1. General student list
2. General class list
3. General Test list
4. General staff list
5. Staff registration

*/

?>


<html>
    <header>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/global-style.css" rel="stylesheet" type="text/css"/>

    </header>

    <div style = "top: 1%; position: fixed; margin: 0px;" class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">

        <div class="list-group">

            <li class = "list-group-item disabled"><center>Navigation Menu</center></li>
            <a class="list-group-item" href="../dashboard.php">Dashboard</a>
            <li class = "list-group-item active">User Management</li>

            <?php
            
            if($_SESSION['user_account_level'] == 1){

                //admin only User Management Modules
                echo '<a class="list-group-item" href="../staff-search.php">Staff Accounts List</a>';
                echo '<a class="list-group-item" href="../student-search.php">Student Accounts List</a>';
                echo '<a class="list-group-item" href="../register-staff.php">Staff Registration</a>';

            }
            
            ?>
            
            <a class="list-group-item" href="../register-student.php">Students Registration</a>

            <?php 
            
            if($_SESSION['user_account_level'] == 1){

                echo '<li class = "list-group-item active">Classes Management</li>';
                echo '<a class="list-group-item" href="../class-search.php">List of Classes</a>';
                echo '<a class="list-group-item" href="../register-classes.php">Register Classes</a>';

            }
            
            ?>
                    
            <li class = "list-group-item active">Test Management</li>
            <a class="list-group-item" href="../#">Test List</a>
            <a class="list-group-item" href="../#">Make a Test</a>

        </div>
    </div>
</html>