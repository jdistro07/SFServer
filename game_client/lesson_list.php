<?php

/*Module to list all video files on videos/ */

$dir = opendir("../videos/");

while($files = readdir($dir)){

    if($files !== "." && $files !== ".."){

        echo($files."<br>");

    }

}

?>