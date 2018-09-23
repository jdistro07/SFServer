<?php

require 'mod_conn.php';

if(isset($_GET['search'])){
    $searchKey = mysql_real_escape_string($_GET['search']);

    $result = mysqli_query($conn, 
    
    "SELECT * 
    
    FROM `staffs` 
    
    WHERE
    
    staff_fname LIKE '%$searchKey%'
    OR
    staff_mname LIKE '%$searchKey%'
    OR
    staff_lname LIKE '%$searchKey%'

    ORDER BY staff_lname ASC
    "
    
    ) or die("No Results...");

    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "
            
        <option value='".$assoc_row['staff_ID']."'>
        
        ".$assoc_row['staff_lname'].", ".$assoc_row['staff_fname']." ".$assoc_row['staff_mname']."
        
        <option>
        
        <br>
        ";
    }
}
?>