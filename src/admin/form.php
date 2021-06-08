<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login page - Admin</title>
</head>
<body>
    <h1>ADMIN LOGIN</h1>

<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="index.php" method="POST" class="form login">
                Username:<input type="text" class="text_field" name="username" required
                pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                title="Please enter a valid email as username" 
                placeholder="Your email address"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> <br>

                Password: <input type="password" class="text_field" name="password" required
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                placeholder="Your password"
                title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/> <br>
                
                <button class="button" type="submit">
                  Login
                </button>
          </form><br>

</body>
</html>

