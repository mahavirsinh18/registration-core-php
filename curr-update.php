<?php

include "connect.php";

$name = $email = $password = $dob = "";

$id = $_REQUEST['id'];
$sql = "SELECT * FROM curr WHERE id = $id";
$result = $conn->query($sql);

$errorMsg = [];
$OldValue = $result->fetch_assoc();
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	//$OldValue = $_POST;
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$dob = test_input($_POST['dob']);

	if($name == ""){
		$errorMsg['name'] = "*name is required";
		$isValid = false;
	}

	if($email == ""){
		$errorMsg['email'] = "*email is required";
		$isValid = false;
	}

	if($password == ""){
		$errorMsg['password'] = "*password is required";
		$isValid = false;
	}

	if($dob == ""){
		$errorMsg['dob'] = "";
		$isValid = false;
	}

	if($isValid == true){
		$password = base64_encode($password);
		$sql = "UPDATE curr SET name = '$name',email = '$email',password = '$password',dob = '$dob' WHERE id = $id";
		if(mysqli_query($conn,$sql)){
			echo "";
		}else{
			$OldValue = [];
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
<form action="curr-update.php?id=<?php echo $OldValue['id']; ?>" method="post" class="form-horizontal">
	<div class="form-group">
		Name:
		<input type="text" name="name" value="<?php echo isset($OldValue['name']) ? $OldValue['name'] : ""; ?>" class="form-control w-25">
		<span><?php echo isset($errorMsg['name']) ? $errorMsg['name'] : ""; ?></span>
	</div>
	<div class="form-group">
		E-mail:
		<input type="text" name="email" value="<?php echo isset($OldValue['email']) ? $OldValue['email'] : ""; ?>" class="form-control w-25">
		<span><?php echo isset($errorMsg['email']) ? $errorMsg['email'] : ""; ?></span>
	</div>
	<div class="form-group">
		Password:
		<input type="password" name="password" value="<?php echo isset($OldValue['password']) ? $OldValue['password'] : ""; ?>" class="form-control w-25">
		<span><?php echo isset($errorMsg['password']) ? $errorMsg['password'] : ""; ?></span>	
	</div>
	<div class="form-group">
		DOB:
		<input type="date" name="dob" class="form-control w-25" value="<?php echo isset($OldValue['dob']) ? $OldValue['dob'] : ""; ?>">
	</div>
		<button type="submit" name="button" class="btn btn-outline-primary">Submit</button>
</form>
</div>

</body>
</html>