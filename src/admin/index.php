<?php
	$lifetime = 15*60;
	$path = "/";
	$domain = "secad-team12.minifacebook.com";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
	session_start(); 
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
  	$_SESSION["nocsrftoken"] = $rand;


  	// INPUT VALIDATION
 
	if(isset($_POST["username"]) and isset($_POST["password"])){   

	  	if (empty($_POST["username"]) OR empty($_POST["username"])) {

	  		echo "<script>alert('INPUT MISSING');</script>";
			header("Refresh:0;url=form.php.php");
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
	    // end input validation
		$mysqli = new mysqli('localhost','secad_team12','team12Pass','secad_team12');
		if($mysqli ->connect_errno){
			printf("Database connection failed: %s\n", $mysqli ->connect_error);
			exit();
		}	
			if (secureCheckLogin($username,$password)) {
				$_SESSION["logged"] = TRUE;
				$_SESSION["username"] = $username;
				$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
				
				// Session variable for SuperUsers
				$_SESSION["role"] = "superuser";				
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
 
	function regeXCheckFail(){
		echo "<script>alert('INPUT data isnt in correct format.Redirecting now.');</script>";
		header("Refresh:0;url=form.php");
		die;
	}
	function sanitize_input($data){
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}


?>
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<br>
<form action="viewUsers.php" method="POST" class="form login">
	<button class="button" type="submit">View Users</button>
        <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />	
</form>
<a href="logout.php">Logout</a>
<?php	

function secureCheckLogin($username, $password) {

		global $mysqli;
		$prepared_sql = "Select * from superusers where username= ? "." AND password = password(?);";
		if(!$stmt = $mysqli ->prepare($prepared_sql))
			echo "Prepared Statement Error";
		$stmt->bind_param("ss", $username,$password);
		if(!$stmt->execute()) echo "Execute Error";
		if(!$stmt->store_result()) echo "Store result error";
		$result = $stmt;
		if($result ->num_rows ==1)
			return TRUE;
		return FALSE;
	
	}  		
	  	
?>

