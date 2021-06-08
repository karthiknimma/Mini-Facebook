<!-- Change password function correctly implemented -->



<?php

	$mysqli = new mysqli('localhost','secad_team12','team12Pass','secad_team12');
	if($mysqli ->connect_errno){
		printf("Database connection failed: %s\n", $mysqli ->connect_error);
		exit();
	}
function changepassword($username, $password) {

		global $mysqli;
		$prepared_sql = "UPDATE users SET password=password(?) WHERE username=?;";
		// echo "DEBUG> prepared_sql = $prepared_sql\n";
		if(!$stmt = $mysqli ->prepare($prepared_sql)) return FALSE;
		$stmt->bind_param("ss", $password,$username);
		if(!$stmt->execute()) return FALSE;
		return TRUE;

	
	}  
	function addNewUser($username, $password,$fname,$lname,$gender,$DOB) {
		try{
		global $mysqli;

		// Checking if username exists
		$result = "select *from users where username = $username";
		$rowcount=mysqli_num_rows($result);
		if($rowcount!=0){
			return false;
		}

		$prepared_sql = "INSERT INTO users(username,password, fname,lname,gender,DOB) VALUES(?, password(?),?,?,?,?);";
		// echo "DEBUG> prepared_sql = $prepared_sql\n";
		if(!$stmt = $mysqli ->prepare($prepared_sql)) return FALSE;
		$stmt->bind_param("ssssss", $username,$password,$fname,$lname,$gender,$DOB);
		if(!$stmt->execute()){
			echo $stmt->error;

			return FALSE;
		}
		return TRUE;
	}catch(Exception $ex){
		error_log($ex->getMessage());
	}

	
	} 		
	  	
?>

