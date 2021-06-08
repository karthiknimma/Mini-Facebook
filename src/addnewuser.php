<!-- Mark as Complete functionality -->

<?php
  require 'database.php';
  // require 'session_auth.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	if (empty($_POST["username"]) OR empty($_POST["password"]) OR empty($_POST["fname"]) OR empty($_POST["lname"]) OR empty($_POST["gender"]) OR empty($_POST["DOB"])) {

  		echo "<script>alert('INPUT MISSING');</script>";
		header("Refresh:0;url=registrationform.php");
		die;
    }
	$username = sanitize_input($_POST["username"]);
    if (!preg_match("/^[\w.-]+@[\w-]+(.[\w-]+)*$/",$username)) {
      regeXCheckFail();
    }	
	$password=sanitize_input($_POST["password"]);
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/",$password)) {
      regeXCheckFail();
    }		
	$fname = sanitize_input($_POST["fname"]);
    if (!preg_match("/[A-Za-z]{3,20}/",$fname)) {
      regeXCheckFail();
    }		
	$lname = sanitize_input($_POST["lname"]);
    if (!preg_match("/[A-Za-z]{3,20}/",$lname)) {
      regeXCheckFail();
    }		
	$gender = sanitize_input($_POST["gender"]);		
	$DOB = sanitize_input($_POST["DOB"]);
	
	// echo "DEBUG:addNewUser.php->Got: Username=$username;password=$password\n<br>";
	if(addNewUser($username,$password,$fname,$lname,$gender,$DOB)){
		echo "<h4> User account created successfully</h4>";
	}else{
		echo "<h4>Error:Cannot create account. </h4>";
	}

  }else{
  	  	echo "<script>alert('Bad Request');</script>";
		header("Refresh:0;url=registrationform.php");
		die;

  } 
	function regeXCheckFail(){
		echo "<script>alert('INPUT data isnt in correct format.Redirecting now.');</script>";
		header("Refresh:0;url=registrationform.php");
		die;
	}
	function sanitize_input($data){
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
?>
<a href="form.php">Home</a> 