<!-- Not implemented. Cannot figure out how to implement security against CSRF -->

</!DOCTYPE html>
<html>
<head>
	<title>Delete Post</title>
</head>
<body>
	<?php 
	require 'database.php';
	require 'session_auth.php';


	$post_id=$_POST["post_id"];


	 ?>
	<form action="index.php" method="post">
	<div>
	<textarea name="editedpost" id="post" style="font-family:sans-serif;font-size:1.2em;">
	Enter the new post</textarea>
	<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" /> 
	</div>
	<input type="submit" value="Submit">
	</form>

<a href="index.php">Home Page</a>
</body>
</html>