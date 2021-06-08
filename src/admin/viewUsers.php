
<?php
  require 'session_auth.php';
  require 'database.php';
  $nocsrftoken = $_POST["nocsrftoken"];
  if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
       echo "<script>alert('Cross site request forgery is detected!');</script>";
      header("Refresh:0;url=logout.php");
      die;
  }

?>

<html>
<body>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
 <table id="table" style="width:40%" align="center">
     <tr>
          <th>Name of User</th>
     </tr>
     <tr>      

        <?php 

            $prepared_sql = "select username from users;";
            if(!$stmt = $mysqli->prepare($prepared_sql)){
                return FALSE;
            }
            if(!$stmt->execute()) return false;
            $username = NULL;
            if(!$stmt->bind_result($username)) echo "Binding failed";

            while($stmt->fetch()){
            ?>  
                 <td><?php echo htmlentities($username)?></td>
        </tr>
        <?php
            }
        ?>


</table>
</div>  
<a href="index.php">Home page</a>       
</body>
</html>
