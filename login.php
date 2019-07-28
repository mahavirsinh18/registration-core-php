<?php

session_start();
include "connect.php";

$email = $password = "";
$errorMsg = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);

	if($email == ""){
		$errorMsg['email'] = "*please enter your email";
		$isValid = false;
	}

	if($password == ""){
		$errorMsg['password'] = "*please enter password";
		$isValid = false;
	}

	if($isValid == true){
		$password = base64_encode($password);
		$sql = "SELECT * FROM curr WHERE email = '$email' AND password = '$password'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$_SESSION['id'] = $row['id'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['dob'] = $row['dob'];
			header("location:curr-page.php");
		}
	}
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

<div class="container">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-horizontal">
	<div class="form-group">
		E-mail:
		<input type="text" name="email" class="form-control w-25">
		<span><?php echo isset($errorMsg['email']) ? $errorMsg['email'] : ""; ?></span>
	</div>
	<div class="form-group">
		Password:
		<input type="text" name="password" class="form-control w-25">
		<span><?php echo isset($errorMsg['password']) ? $errorMsg['password'] : ""; ?></span>
	</div>
	<button type="submit" name="submit" class="btn btn-outline-primary">Log in</button>
</form>
</div>

</body>
</html>