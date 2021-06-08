<?php

	$mysqli = new mysqli('localhost','secad_team12','team12Pass','secad_team12');
	if($mysqli ->connect_errno){
		printf("Database connection failed: %s\n", $mysqli ->connect_error);
		exit();
	}
	 		
	  	
?>

