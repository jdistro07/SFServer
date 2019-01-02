<?php

$result;

// start session if no sessions are found
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require 'mod_conn.php';
$current_user = $_SESSION["username"];

$requestType = "staffupdate";

if(isset($_GET['search'])){
    $searchKey = mysqli_real_escape_string($conn, $_GET['search']);

    $result = mysqli_query($conn, 
    
    "SELECT *
    
    FROM staffs
    
    WHERE 
    staffs.staff_lname LIKE '%$searchKey%'
    OR
    staffs.staff_fname LIKE '%$searchKey%'
    AND 
    staffs.staff_username != '$current_user'

    ORDER BY staffs.staff_lname ASC
    "
    
    ) or die("No Results...");

}else{
    $result = mysqli_query($conn, 
    
    "SELECT *
    FROM staffs
    ORDER BY staffs.staff_lname ASC
    "
    
    ) or die("No Results...");
}

while($assoc_row = mysqli_fetch_assoc($result)){

    $acclvl;

    if($assoc_row['staff_accountLevel'] == 1){
        $acclvl = "Administrator";
    }else{
        $acclvl = "Teacher";
    }

    echo "<tr>";
    echo "
        
    <td style = \"vertical-align: middle; text-align: center\">
        <input type = \"checkbox\" name = \"deleteMark[]\" value = ".$assoc_row['staff_ID'].">".$assoc_row['staff_ID']."
    </td>
    
    <td style = \"vertical-align: middle;\">".$assoc_row['staff_lname'].", ".$assoc_row['staff_fname']." ".$assoc_row['staff_mname']."</td>

    <td align = \"center\" style = \"vertical-align: middle;\">".$acclvl."</td>
    
    <td style = \"vertical-align: middle; text-align: center\">
        <a href = \"user-profile.php?id=".$assoc_row['staff_ID']."&user=".$assoc_row['staff_username']."&userType=staff\">Profile</a>
        <a href = \"user-update.php?id=".$assoc_row['staff_ID']."&request=".$requestType."\">Update</a>
    </td>
    ";
    echo "</tr>";
}
?>