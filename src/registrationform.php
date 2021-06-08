
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create Account</title>
</head>
<body>
      	<h1>Signup for a new Account</h1>

<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="addnewuser.php" method="POST" class="form login">
                Username:<input type="text" class="text_field" name="username" required
                pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                title="Please enter a valid email as username" 
                placeholder="Your email address"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> <br>

                Password: <input type="password" class="text_field" name="password" required
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                placeholder="Your password"
                title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: ''); form.repassword.pattern =this.value;"/> <br>

        				Retype Password: <input type="password" class="text_field" name="repassword"
        				placeholder="Retype your password" required
        				title="Password does not match"
        				onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/> <br>

                First Name:<input type="text" class="text_field" name="fname" required pattern="[A-Za-z]{3,20}" title="Please enter only alphabets"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> <br>

                Last Name:<input type="text" class="text_field" name="lname" required pattern="[A-Za-z]{3,20}" title="Please enter only alphabets"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> <br>

                <label for="Gender">Select One:</label>
                <select id="gender" name="gender">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select><br>
          
                <label for="DOB">Enter your Date of Birth:
                  <input type="date" name="DOB" max="2020-01-01" required>
                </label> <br>    
                <button class="button" type="submit">
                  SignUp
                </button>
          </form>
          <br>Already have an account?<a href="form.php">Login here</a>

</body>
</html>

