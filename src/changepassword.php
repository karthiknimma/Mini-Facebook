<!-- mark as complete -->

<?php
  require 'session_auth.php';
  require 'database.php';

	$username = $_SESSION['username'];
	$nocsrftoken = $_POST["nocsrftoken"];

	if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
		echo "<script>alert('Cross site request forgery is detected!');</script>";
		header("Refresh:0;url=logout.php");
		die;
	}

	if(isset($_SESSION["username"]) AND isset($_POST["newpassword"])){
	  	if (empty($_SESSION["username"]) OR empty($_POST["newpassword"])) {

	  		echo "<script>alert('INPUT MISSING');</script>";
			header("Refresh:0;url=logout.php");
			die;
	    }	
		$username = sanitize_input($_SESSION["username"]);
	    if (!preg_match("/^[\w.-]+@[\w-]+(.[\w-]+)*$/",$username)) {
			header("Refresh:0;url=changepasswordform.php");
			die;

	    }	
		$newpassword=sanitize_input($_POST["newpassword"]);
		if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/",$newpassword)) {
	  			regeXCheckFail();
		}	

		// echo "DEBUG:change password.php->Got: Username=$username;newpassword=$newpassword\n<br>";
		if(changepassword($username,$newpassword)){
			echo "<h4> password changed successfully</h4>";
		}else{
			echo "<h4>Error:Cannot change password</h4>";
		}
	}else{
		echo "No provided username/password to change.";
		exit();
	}
	function regeXCheckFail(){
		echo "<script>alert('Password  isnt in correct format.Redirecting now.');</script>";
		header("Refresh:0;url=changepasswordform.php");
		die;
	}
	function sanitize_input($data){
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>