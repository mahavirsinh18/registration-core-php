<?php

include "connect.php";

$name = $email = $password = $contact = $city = $gender = $pro_image =  "";

$errorMsg = [];
$OldValue = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$contact = test_input($_POST['contact']);
	$city = $_POST['city'];
	$gender = isset($_POST['gender']);
	$pro_image = isset($_FILES['pro_image']);

	$target_dir = "uploads/";
	
	$target_file = $target_dir . basename($_FILES['pro_image']['name']);

	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$uploadOk = 1;
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$fileErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	$bg_image = "";
	if($uploadOk){
		move_uploaded_file($_FILES["pro_image"]["tmp_name"], $target_file);	
		$pro_image = $target_file;
	}

	if($name == ""){
		$errorMsg['name'] = "* required";
		$isValid = false;
	}

	if($email == ""){
		$errorMsg['email'] = "* required";
		$isValid = false;
	}

	if($password == ""){
		$errorMsg['password'] = "* required";
		$isValid = false;
	}

	if($contact == ""){
		$errorMsg['contact'] = "* required";
		$isValid = false;
	}

	if($city == ""){
		$errorMsg['city'] = "* required";
		$isValid = false;
	}

	if($gender == ""){
		$errorMsg['gender'] = "* required";
		$isValid = false;
	}

	if($pro_image == ""){
		$errorMsg['pro_image'] = "* required";
		$isValid = false;
	}

	if($isValid == true){
		$sql = "INSERT INTO registration (name,email,password,contact,city,gender,pro_image) VALUES ('$name','$email','$password','$contact','$city','$gender','$pro_image')";
		if(mysqli_query($conn, $sql)){
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-group">
			Name: <input type="text" name="name" class="form-control w-25" value="<?php echo isset($OldValue['name']) ? $OldValue['name'] : ''; ?>">
			<span><?php echo isset($errorMsg['name']) ? $errorMsg['name'] : ''; ?></span>
		</div>

		<div class="form-group">
			E-mail: <input type="text" name="email" class="form-control w-25" value="<?php echo isset($OldValue['email']) ? $OldValue['email'] : ''; ?>">
			<span><?php echo isset($errorMsg['email']) ? $errorMsg['email'] : ''; ?></span>
		</div>

		<div class="form-group">
			Password: <input type="password" name="password" class="form-control w-25" value="<?php echo isset($OldValue['password']) ? $OldValue['password'] : ''; ?>">
			<span><?php echo isset($errorMsg['password']) ? $errorMsg['password'] : ''; ?></span>
		</div>

		<div class="form-group">
			Contact: <input type="text" name="contact" class="form-control w-25" value="<?php echo isset($OldValue['contact']) ? $OldValue['contact'] : ''; ?>">
			<span><?php echo isset($errorMsg['contact']) ? $errorMsg['contact'] : ''; ?></span>
		</div>
		<br>

		<select name="city" class="custom-select w-25">
			<option>--Select city--</option>
			<option value="Bhavnagar" <?php echo (isset($OldValue['city']) && $OldValue['city'] == "Bhavnagar") ? 'selected' : ''; ?> >Bhavnagar</option>
			<option value="Ahmedabad" <?php echo (isset($OldValue['city']) && $OldValue['city'] == "Ahmedabad") ? 'selected' : ''; ?> >Ahmedabad</option>
			<option value="Vadodara" <?php echo (isset($OldValue['city']) && $OldValue['city'] == "Vadodara") ? 'selected' : ''; ?> >Vadodara</option>
			<option value="Rajkot" <?php echo (isset($OldValue['city']) && $OldValue['city'] == "Rajkot") ? 'selected' : ''; ?> >Rajkot</option>
			<option value="Surat" <?php echo (isset($OldValue['city']) && $OldValue['city'] == "Surat") ? 'selected' : ''; ?> >Surat</option>
		</select>
		<span><?php echo isset($errorMsg['city']) ? $errorMsg['city'] : ''; ?></span>
		<br><br>

		Gender:
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="radio1" class="custom-control-input" value="Male" <?php echo (isset($OldValue['gender']) && $OldValue['gender'] == "Male") ? 'checked' : ''; ?> >
			<label for="radio1" class="custom-control-label">Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="radio2" class="custom-control-input" value="Female" <?php echo (isset($OldValue['gender']) && $OldValue['gender'] == "Female") ? 'checked' : ''; ?> >
			<label for="radio2" class="custom-control-label">Female</label>
		</div>
		<span><?php echo isset($errorMsg['gender']) ? $errorMsg['gender'] : ''; ?></span>
		<br><br>

		<div class="custom-file w-25">
			<input type="file" name="pro_image" id="pro_image" class="custom-file-input">
			<label for="pro_image" class="custom-file-label">Choose image</label>
		</div>
		<span><?php echo isset($errorMsg['pro_image']) ? $errorMsg['pro_image'] : ''; ?></span>
		<br><br>

		<button type="submit" name="submit" value="Submit" class="btn btn-outline-primary">Submit</button>
		<br><br>

		<a href="list.php">Go to listing--></a>
	</form>
</div>

</body>
</html>