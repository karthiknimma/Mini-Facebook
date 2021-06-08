<!-- Marked as Complete -->


<?php
  require "session_auth.php";
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Change Password</title>
</head>
<body>
      	<h1>Change password,SECAD</h1>

<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="changepassword.php" method="POST" class="form login">
                Username:<!-- <input type="text" class="text_field" name="username" />  --><?php echo htmlentities($_SESSION['username']); ?><br>
 				 New Password: <input type="password" class="text_field" name="newpassword" required
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                placeholder="Your password"
                title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: ''); form.repassword.pattern =this.value;"/>
                 <br>

				Retype Password: <input type="password" class="text_field" name="repassword"
				placeholder="Retype your password" required
				title="Password does not match"
				onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/>
				 <br>

                <button class="button" type="submit">
                  Change Password
                </button>
                <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
          </form>
          <a href="index.php">Home Page</a>

</body>
</html>

