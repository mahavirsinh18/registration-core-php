<?php

session_start();
include "connect.php";

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$dob = $_SESSION['dob'];

if(!isset($_SESSION['id'])){
	header("location:login.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<h2>
<b>Welcome <?php echo $name; ?></b>
<br><br>
<b>Your email id is:</b> <i><?php echo $email; ?></i>
<br><br>
<b>Your dob is:</b> <i><?php echo $dob; ?></i>
</h2>
<br>
<div class="">
<form action="logout.php" method="post" class="form-horizontal">
	<button type="submit" name="logout" class="btn btn-outline-primary">Log out</button>
</form>
</div>

</body>
</html>