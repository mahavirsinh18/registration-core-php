<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);
include "function.php";

$id = $_REQUEST['id'];

$name = $email = $contact = $gender = $state = $city = $hobbies = $bg_image = $profile_image = $password = $conf_password = $about = "";

$sql = "SELECT * FROM registration WHERE id=$id";
$result = $conn->query($sql);
$OldValue = $result->fetch_assoc();          
$errorMsg = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$OldValue = $_POST;
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$contact = test_input($_POST['contact']);
	$gender = test_input($_POST['gender']);
	$state = test_input($_POST['state_id']);
	$city = test_input($_POST['city_id']);
	$hobbies = $_POST['hobbies'];
	$bg_image = $_POST['bg_image'];
	$profile_image = $_POST['profile_image'];
	$password = test_input($_POST['password']);
	$conf_password = test_input($_POST['conf_password']);
	$about = test_input($_POST['about']);

	$target_dir = "uploads/";

	$target_file = $target_dir . basename($_FILES['bg_image']['name']);
	$target_file = $target_dir . basename($_FILES['profile_image']['name']);

	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	$uploadOk = 1;
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$fileErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	$bg_image = "";
	if($uploadOk){
		move_uploaded_file($_FILES["bg_image"]["tmp_name"], $target_file);	
		$bg_image = $target_file;
	}

	$profile_image = "";
	if($uploadOk){
		move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);	
		$profile_image = $target_file;
	}

	if($bg_image == ""){
		$errorMsg['bg_image'] = "*Please enter bg_image";
		$isValid = false;
	}

	if($profile_image == ""){
		$errorMsg['profile_image'] = "*Please enter profile_image";
		$isValid = false;
	}

	if($name == ""){
		$errorMsg['name'] = "*Please enter name";
		$isValid = false;
	}

	if($email == ""){
		$errorMsg['email'] = "*Please enter your email";
		$isValid = false;
	}

	if($contact == ""){
		$errorMsg['contact'] = "*Please enter your contact number";
		$isValid = false;
	}

	if($gender == ""){
		$errorMsg['gender'] = "*Please enter your gender";
		$isValid = false;
	}

	if($state == ""){
		$errorMsg['state_id'] = "*Please enter state";
		$isValid = false;
	}

	if($city == ""){
		$errorMsg['city_id'] = "*Please enter your city";
		$isValid = false;
	}

	/*if($hobbies == ""){
		$errorMsg['hobby_id'] = "*Please enter your hobbies";
		$isValid = false;
	}*/

	if($password == ""){
		$errorMsg['password'] = "*Please enter password";
		$isValid = false;
	}

	if($conf_password == ""){
		$errorMsg['conf_password'] = "*Please confirm your password";
		$isValid = false;
	}

	if($isValid == true){
		$sql = "UPDATE registration SET name = '$name', email = '$email', contact = '$contact', gender = '$gender', state_id = '$state', city_id = '$city', bg_image = '$bg_image', profile_image = '$profile_image', password = '$password', conf_password = '$conf_password', about = '$about' WHERE id = $id";
		if(mysqli_query($conn, $sql)){
			$last_id = $conn->insert_id;
			foreach ($hobbies as $key => $hobby_id) {
				$sql1 = "INSERT INTO  user (user_id,hobby_id) VALUES ('$last_id','$hobby_id')";
				mysqli_query($conn,$sql1);
			}
			header("location:info.php");
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
	<form action="edit.php?id=<?php echo $OldValue['id']; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			Name: <input type="text" name="name" value="<?php echo isset($OldValue['name']) ?  $OldValue['name'] : ""; ?>" class="form-control w-25">
			<span><?php echo isset($errorMsg['name']) ?  $errorMsg['name'] : ""; ?></span>
		</div>

		<div class="form-group">
			E-mail: <input type="text" name="email" value="<?php echo isset($OldValue['email']) ?  $OldValue['email'] : ""; ?>" class="form-control w-25">
			<span><?php echo isset($errorMsg['email']) ?  $errorMsg['email'] : ""; ?></span>
		</div>

		<div class="form-group">
			Contact: <input type="text" name="contact" value="<?php echo isset($OldValue['contact']) ?  $OldValue['contact'] : ""; ?>" class="form-control w-25">
			<span><?php echo isset($errorMsg['contact']) ?  $errorMsg['contact'] : ""; ?></span>
		</div>

		Gender:
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" value="M" class="custom-control-input" id="customRadio1" <?php echo (isset($OldValue['gender']) && $OldValue['gender']=='M')?'checked':''; ?> >
			<label for="customRadio1" class="custom-control-label"> Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" value="F" class="custom-control-input" id="customRadio2" <?php echo (isset($OldValue['gender']) && $OldValue['gender']=='F')?'checked':''; ?> >
			<label for="customRadio2" class="custom-control-label"> Female</label><br><br>
		</div>
		<br>
		<?php $state_id = getState(); ?>
		<select id="state_id" name="state_id" class="custom-select w-25">
			<option value="">Select State</option>
			<?php
				foreach ($state_id as $key => $state) {
					if(isset($OldValue['state_id']) && $OldValue['state_id']==$state['id']){
						echo "<option value='".$state['id']."' selected=''>".$state['state_name']."</option>";
					}else{
						echo "<option value='".$state['id']."'>".$state['state_name']."</option>";
					}
				}		
			?>
		</select>
		<br><br>
		<?php $city_id = getCity(); ?>
		<select id="city_id" name="city_id" class="custom-select w-25">
			<option value="">Select City</option>
			<?php
				foreach ($city_id as $key => $city) {
					if(isset($OldValue['city_id']) && $OldValue['city_id']==$city['id']){
						echo "<option value='".$city['id']."' selected=''>".$city['city_name']."</option>";
					}else{
						echo "<option value='".$city['id']."'>".$city['city_name']."</option>";
					}
				}
			?>
		</select>
		<br><br>
		<?php $hobby_id = getHobbies(); 
			foreach ($hobby_id as $key => $hobbies) {
				if(in_array($hobbies['id'],$hobbies)){
					echo "checked";
				}else{
					echo "";
				}
				?>
					<input type="checkbox" name="hobbies[]" value="<?php echo $hobbies['id'] ?>">
    				<?php echo $hobbies['hobby_name'] ?>	
				<?php
			}
		 ?>
		 <br><br>
		 <div class="custom-file w-25">
			<input type="file" name="bg_image" class="custom-file-input" id="customFile"><br>
			<label class="custom-file-label" for="customFile">Background image</label><br>
		</div>
		<br>
		<div class="custom-file w-25">
			<input type="file" name="profile_image" class="custom-file-input" id="customFile"><br>
			<label class="custom-file-label" for="customFile">Profile image</label><br>
		</div>
		<br>
		<div class="form-group">
			Password: <input type="password" name="password" value="<?php echo isset($OldValue['password']) ?  $OldValue['password'] : ""; ?>" class="form-control w-25">
			<span><?php echo isset($errorMsg['password']) ?  $errorMsg['password'] : ""; ?></span>
		</div>

		<div class="form-group">
			Confirm password: <input type="password" name="conf_password" value="<?php echo isset($OldValue['conf_password']) ?  $OldValue['conf_password'] : ""; ?>" class="form-control w-25">
			<span><?php echo isset($errorMsg['conf_password']) ?  $errorMsg['conf_password'] : ""; ?></span>
		</div>

		<div class="form-group">
      		<label for="about">About us:</label>
      		<textarea class="form-control w-50" rows="5" id="about" name="about"></textarea>
    	</div>

    	<input type="submit" value="Submit" class="btn btn-outline-primary">
	</form>		
</div>

</body>

</html>