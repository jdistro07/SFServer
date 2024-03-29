<?php

require 'mod_conn.php';

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
    
    FROM class LEFT OUTER JOIN staffs ON class.class_staff = staffs.staff_ID 
    
    WHERE 
    staffs.staff_lname LIKE '%$searchKey%'
    OR
    staffs.staff_fname LIKE '%$searchKey%'
    OR
    class_grade LIKE '%$searchKey%'

    ORDER BY staffs.staff_lname ASC
    "
    
    ) or die("No Results...");

    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "
            
        <td style = \"vertical-align: middle; text-align: center\">".$assoc_row['class_ID']."</td>
        <td>".$assoc_row['staff_lname'].", ".$assoc_row['staff_fname']." ".$assoc_row['staff_mname']."</td>
        <td style = \"vertical-align: middle; text-align: center\">Grade ".$assoc_row['class_grade']." - ".$assoc_row['class_section']."</td>
        <td style = \"vertical-align: middle; text-align: center\"><a href = \"class_list.php?id=".$assoc_row['class_ID']."\">View</a> <a href = \"update-classes.php?id=".$assoc_row['class_ID']."\">Update</a></td>

        ";
        echo "</tr>";
    }
}else{
    $result = mysqli_query($conn, 
    
    "SELECT 
    class.class_ID, 
    staffs.staff_lname, 
    staffs.staff_fname,
    staffs.staff_mname, 
    class_grade, 
    class.class_section 
    
    FROM class LEFT OUTER JOIN staffs ON class.class_staff = staffs.staff_ID 

    ORDER BY staffs.staff_lname ASC
    "
    
    ) or die("No Results...");

    while($assoc_row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "
            
        <td style = \"vertical-align: middle; text-align: center\">
            <input type = \"checkbox\" name = \"deleteMark[]\" value = ".$assoc_row['class_ID'].">".$assoc_row['class_ID']."
        </td>
        <td>".$assoc_row['staff_lname'].", ".$assoc_row['staff_fname']." ".$assoc_row['staff_mname']."</td>
        <td style = \"vertical-align: middle; text-align: center\">Grade ".$assoc_row['class_grade']." - ".$assoc_row['class_section']."</td>
        <td style = \"vertical-align: middle; text-align: center\"><a href = \"class_list.php?id=".$assoc_row['class_ID']."\">View</a> <a href = \"update-classes.php?id=".$assoc_row['class_ID']."\">Update</a></td>

        ";
        echo "</tr>";
    }
}
?>