<?php
require '../php/mod_conn.php';
/*Module to list all video files on videos */

$user_id = $_POST['user_id'];
$username = $_POST['username'];

$performance_id = array();

//query the current user
$q_user = mysqli_query($conn, 
"SELECT pf_testID FROM performance_data WHERE pf_userID = $user_id AND pf_username = '$username' AND pf_testMode = 'PRE'
") or die(mysqli_error($conn));

while($row = mysqli_fetch_assoc($q_user)){
    array_push($performance_id, $row['pf_testID']);
}

$cleared_chapters = array_unique($performance_id);

$dir = opendir("../videos/");

while($files = readdir($dir)){

    if($files !== "." && $files !== ".."){

        if(substr($files, 0, 1) == "[" && is_numeric(ltrim(substr($files, 0, 2), '['))){

            preg_match('#\[(.*?)\]#', $files, $match);

            if (in_array($match[1], $cleared_chapters)){
                echo "ID=".$match[1]."|Target=".$files."|LessonName=".preg_replace('/\[.*\]/', '', $files)."<br>";
            }
        }else{
            echo($files."<br>");
        }

    }
}

?>