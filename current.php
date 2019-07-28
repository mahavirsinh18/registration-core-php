<?php

include "connect.php";

$name = $email = $password = $dob = "";

$errorMsg = [];
$OldValue = [];
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
		$sql = "INSERT INTO curr (name,email,password,dob) VALUES ('$name','$email','$password','$dob')";
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
  	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
</head>
<body>

<div class="container">
<form action="" method="post" name="registration" id="registration" class="form-horizontal">
	<div class="form-group">
		Name:
		<input type="text" name="name"  value="<?php echo isset($OldValue['name']) ? $OldValue['name'] : ""; ?>" class="form-control w-25">
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
<script type="text/javascript">
	$(function() {
  $("form[name='registration']").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      email: "Please enter a valid email address"
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});
</script>
</html>