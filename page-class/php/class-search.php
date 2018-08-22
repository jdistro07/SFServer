<?php

require '../../php/mod_conn.php';

if(isset($_GET['search'])){
    $searchKey = $_GET['search'];

    $result = mysqli_query($conn, 
    
    "SELECT 
    class.class_ID, 
    staffs.staff_lname, 
    staffs.staff_fname,
    staffs.staff_mname, 
    class_grade, 
    class.class_section 
    
    FROM class INNER JOIN staffs ON class.class_staff = staffs.staff_ID 
    
    WHERE 
    staffs.staff_lname LIKE '%$searchKey%'
    OR
    staffs.staff_fname LIKE '%$searchKey%'
    OR
    class_grade LIKE '%$searchKey%'
    "
    
    ) or die("No Results...");

    echo "<table>";
    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "
            
        <td>".$assoc_row['class_ID']."</td>
        <td>".$assoc_row['staff_lname'].", ".$assoc_row['staff_fname']." ".$assoc_row['staff_mname']."</td>
        <td>Grade ".$assoc_row['class_grade']." - ".$assoc_row['class_section']."</td>

        ";
        echo "</tr>";
    }
    echo "</table>";
}



?>