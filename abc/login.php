<?php
session_start();

	include "function.php";

	$email = $pass = "";
	$passErr = $emailErr = $loginErr ="" ;


	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$isValid = true;
		
		if(empty($_POST["email"])){
			$emailErr = "Please enter email";
			$isValid = false;
		}else{
			$email = test_input($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      			$emailErr = "Invalid email format"; 
      			$isValid=false;
    		}
		}

		if(empty($_POST["password"])){
			$passErr = "Password is required";
			$isValid = false;
		}else{
			$password = test_input($_POST["password"]);
		}



		if($isValid == true){
			$sql = "SELECT * FROM registration WHERE email = '$email' AND password = '$password' LIMIT 1";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$_SESSION['id'] = $row['id'];
				$_SESSION['name']= $row['name'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['gender'] = $row['gender'];
				$_SESSION['city_id'] = $row['city_id'];
				$_SESSION['state_id'] = $row['state_id'];
				$_SESSION['hobbies'] = $row['hobbies'];
				$_SESSION['about'] = $row['about'];
				header("Location:info.php");
			}
			$loginErr="Please enter valid details";
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
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group">
	E-mail: <input type="text" name="email" class="form-control w-25" value="">
	<span class="error"><?php echo $emailErr; ?></span>
	</div>
	<div class="form-group">
	Password: <input type="password" name="password" class="form-control w-25" value="">
	<span class="error"><?php echo $passErr; ?></span>
	</div>
	<input type="submit" value="Login" class="btn btn-outline-primary">
	<span class="error"><?php echo $loginErr; ?></span>
	</form>
</div>

</body>
</html>