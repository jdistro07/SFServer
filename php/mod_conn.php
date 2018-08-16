<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db_scriptforte';

$conn = mysqli_connect($host,$username,$password,$dbname) or die('Database not found!');
#echo "Database found!";

?>