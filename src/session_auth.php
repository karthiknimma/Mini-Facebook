<?php
	$lifetime = 15*60;
	$path = "/";
	$domain = "secad-team12.minifacebook.com";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
	session_start(); 
	$mysqli = new mysqli('localhost','secad_team12','team12Pass','secad_team12');	
	if($mysqli ->connect_errno){
		printf("Database connection failed: %s\n", $mysqli ->connect_error);
		exit();
	}	
	if(isset($_POST["username"]) and isset($_POST["password"])){   
		if (secureCheckLogin($_POST["username"],$_POST["password"])) {
			$_SESSION["logged"] = TRUE;
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
				
		}else{
			echo "<script>alert('Invalid username/password');</script>";
			session_destroy();
			header("Refresh:0; url=form.php");
			die();
		}
	}	

	if(!isset($_SESSION["logged"]) or $_SESSION["logged"] != TRUE){
			echo "<script>alert('Please login FIRST!');</script>";
			session_destroy();
			header("Refresh:0; url=form.php");
			die();		
	}
	if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
		echo "<script>alert('Sesssion hijacking detected!');</script>";
		session_destroy();
		header("Refresh:0; url=form.php");
		die();
	}
?>