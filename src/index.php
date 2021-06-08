<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>


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

	// INPUT VALIDATION
	if(isset($_POST["username"]) and isset($_POST["password"])){   

	  	if (empty($_POST["username"]) OR empty($_POST["username"])) {
	  		echo "<script>alert('INPUT MISSING');</script>";
	  		session_destroy();
			header("Refresh:0;url=form.php");
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

		if (secureCheckLogin($username,$password)) {
			$_SESSION["logged"] = TRUE;
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
		
			if(!isset($_SESSION["username"]))
				$_SESSION["username"] = $username;
				
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
	if(isset($_POST["post"])){
		$nocsrftoken = $_POST["nocsrftoken"];
		if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
			echo "<script>alert('Cross site request forgery is detected!');</script>";
			header("Refresh:0;url=logout.php");
			die;
		}
		$_SESSION["post"] = $_POST["post"];
		if (empty($_POST["post"])) {
	  		echo "<script>alert('INPUT MISSING');</script>";
			header("Refresh:0;url=addPost.php");
			die;
	    }
		$post = sanitize_input($_POST["post"]);
	    if (!preg_match("/[A-Za-z]{3,100}/",$post)) {
			echo "<script>alert('INPUT data isnt in correct format.');</script>";
			header("Refresh:0;url=addPost.php");
			die;
	    }else	
	    	addPost($post);


	}

	// INCORRECT FUNCTIONALITY. HENCE,INPUT VALIDATION WAS IGNORED. DONOT USE 
	if(isset($_POST["editedpost"]) AND isset($_POST["post_id"])){
		$editedpost = $_POST["editedpost"];
		$postid = $_POST["post_id"];
		editpost($editedpost,$postid);
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
<h2> Welcome
 <?php 
 	echo htmlentities($_SESSION['username']); 
?> !</h2>

<div class="topnav">
  <a class="active" href="index.php">Home</a>
	<a href="changepasswordform.php">Change password</a>
	<a href="logout.php">Logout</a>
	<a href= "addPost.php">add post</a>
</div>


 
<!-- Puting posts in table -->
 <table id="table" style="width:40%" align="center">
     <tr>
          <th>Posts</th>
     </tr>
     <tr>      
          <?php
             	include 'database.php';
	    		global $mysqli;
	    		$prepared_sql = "select post_id,post_msg from posts;";
	            if(!$stmt = $mysqli->prepare($prepared_sql)){
	                return FALSE;
	            }
	            if(!$stmt->execute()) return false;
	            $post_msg = NULL;
	            $post_id=NULL;
	            if(!$stmt->bind_result($postid,$post_msg)) echo "Binding failed";

	            while($stmt->fetch()){
           ?>
         		 <td><?php echo htmlentities($post_msg)?></td>
				 <td><form action="editpost.php" method="POST" class="form login">
						<button class="button" type="submit">Edit</button>
					        <input type="hidden" name="post_id" value="<?php echo $postid; ?>" />	
					</form>  
				 <td><form action="deletepost.php" method="POST" class="form login">
						<button class="button" type="submit">Delete</button>
					        <input type="hidden" name="post_id"
					         value="<?php echo $postid;?>" />	
  					 </form>						    
			 </tr>
      <?php

      		    }
       ?>

</table>	
</body>
</html>

<?php	
function editpost($editedpost,$postid){
		global $mysqli;
	
		$prepared_sql = "UPDATE posts SET post_msg=? WHERE post_id=?;";
		if(!$stmt = $mysqli ->prepare($prepared_sql))
			echo "Prepared Statement Error";
		$stmt->bind_param("sd",$editedpost,$postid);
		if(!$stmt->execute()) echo "Execute Error";
		error_log($stmt->error);
		if(!$stmt->store_result()) echo "Store result error";
		$result = $stmt;
		if($result ->num_rows ==1)
			return TRUE;
		return FALSE;
}



function addPost($postMsg){
		global $mysqli;
		$result = $mysqli->query('select user_id from users where username="'.$_SESSION['username'].'"');
		$row = mysqli_fetch_assoc($result);
		// error_log(var_dump($_SESSION['username']));
		// error_log(var_dump($user_id->result()));
		$prepared_sql = "insert into posts(user_id,post_msg) values(?,?);";
		if(!$stmt = $mysqli ->prepare($prepared_sql))
			echo "Prepared Statement Error";
		$stmt->bind_param("ds", $row['user_id'],$postMsg);
		if(!$stmt->execute()) echo "Execute Error";
		error_log($stmt->error);
		if(!$stmt->store_result()) echo "Store result error";
		$result = $stmt;
		if($result ->num_rows ==1)
			return TRUE;
		return FALSE;
}

function secureCheckLogin($username, $password) {

		global $mysqli;
		$prepared_sql = "Select * from users where username= ? "." AND password = password(?);";
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
