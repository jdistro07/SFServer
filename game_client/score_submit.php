<?php
require ("../php/mod_conn.php");

	$userID = $_POST["sf_userID"];
	$username = $_POST["sf_username"];
	$testID = $_POST["sf_testID"];
	$rating = $_POST["sf_rating"];
	$testMode = $_POST["sf_testMode"];

	$insert = mysqli_query($conn, 
		
		"INSERT INTO performance_data (pf_userID, pf_username, pf_testID, pf_testMode, pf_rating)
		VALUES ($userID, '$username', $testID, '$testMode', $rating)

		") or die ("Failed to upload values to database.");

	mysqli_close($conn);
?>