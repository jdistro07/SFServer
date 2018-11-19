<?php

require 'mod_conn.php';

$result;

if(isset($_GET['search'])){
    $searchKey = mysqli_real_escape_string($conn, $_GET['search']);

    $result = mysqli_query($conn, 
    
    "SELECT 
    tests.*,
    CONCAT(staffs.staff_lname, ', ', staffs.staff_fname, ' ', staffs.staff_mname) AS author
    
    FROM tests LEFT JOIN staffs ON test_staffAuthor = staffs.staff_ID
        
    WHERE 
    tests.test_name LIKE '%$searchKey%' OR
    staffs.staff_fname LIKE '%$searchKey%' OR
    staffs.staff_lname LIKE '%$searchKey%'
    
    ORDER BY tests.test_name ASC
    ") or die("No Results...");

}else{

    $result = mysqli_query($conn, 
    
    "SELECT 
    tests.*,
    CONCAT(staffs.staff_lname, ', ', staffs.staff_fname, ' ', staffs.staff_mname) AS author
    
    FROM tests LEFT JOIN staffs ON test_staffAuthor = staffs.staff_ID
    
    ORDER BY tests.test_name ASC
    ") or die("No Results...");

}

while($assoc_row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "
        
    <td style = \"vertical-align: middle; text-align: center\">
        <input type = \"checkbox\" name = \"testsMark[]\" value = ".$assoc_row['test_ID'].">".$assoc_row['test_ID']."
    </td>

    <td style = \"vertical-align: middle;\">".$assoc_row['test_name']."</td>
    
    <td style = \"vertical-align: middle;\">".$assoc_row['author']."</td>
    
    <td style = \"vertical-align: middle; text-align: center\">
        <a href = \"maketest.php?request=update&testID=".$assoc_row['test_ID']."&owner=".$assoc_row['test_staffAuthor']."\">View</a>
    </td>
    ";
    echo "</tr>";
}
?>