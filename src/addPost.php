<?php
  require "session_auth.php";
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>
 <form action="index.php" method="post">
<div>
<textarea name="post"  required id="post" pattern="[A-Za-z]{3,20}" title="Please enter only alphabets"
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');">              
</textarea>
</div>
<input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
<input type="submit" value="Submit">
</form>

<a href="index.php">Home Page</a>