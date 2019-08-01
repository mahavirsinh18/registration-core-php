<?php

include_once "function.php";



$name = $email = $contact = $gender = $state = $city = $hobbies = $bg_image = $profile_image = $password = $conf_password = $about = $classx = "";

$errorMsg = [];
$OldValue = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$OldValue = $_POST;
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$contact = test_input($_POST['contact']);
	$gender = test_input($_POST['gender']);
	$state = test_input($_POST['state_id']);
	$classx = test_input($_POST['class']);
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

	if($classx == ""){
		$errorMsg['class'] = "*Please enter your class";
		$isValid = false;
	}

	if($password == ""){
		$errorMsg['password'] = "*Please enter password";
		$isValid = false;
	}

	if($conf_password == ""){
		$errorMsg['conf_password'] = "*Please confirm your password";
		$isValid = false;
	}

	if($isValid == true){
		$sql = "INSERT INTO registration (name,email,contact,gender,state_id,city_id,class,bg_image,profile_image,password,conf_password,about) VALUES ('$name','$email','$contact','$gender','$state','$city','$classx','$bg_image','$profile_image','$password','$conf_password','$about')";
		if(mysqli_query($conn, $sql)){
			$last_id = $conn->insert_id;
			foreach ($hobbies as $key => $hobby_id) {
				$sql1 = "INSERT INTO  user (user_id,hobby_id) VALUES ('$last_id','$hobby_id')";
				mysqli_query($conn,$sql1);
			}
			echo "";
		}else{
			$OldValue = [];
			echo "";
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
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal" id="reg" name="reg">
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
			<input type="radio" name="gender" value="M" class="custom-control-input" id="customRadio1">
			<label for="customRadio1" class="custom-control-label"> Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" value="F" class="custom-control-input" id="customRadio2">
			<label for="customRadio2" class="custom-control-label"> Female</label><br><br>
		</div>
		<br>
		<?php $state_id = getState(); ?>
		<select id="state_id" name="state_id" class="custom-select w-25">
			<option value="">Select State</option>
			<?php
				foreach ($state_id as $key => $state) {
					echo "<option value='".$state['id']."'>".$state['state_name']."</option>";	
				}
			?>
		</select>
		<br><br>
		<tr>
			<td>
				<select id="city_id" name="city_id" class="custom-select w-25">
					<option value="">City</option>
				</select>
			</td>
		</tr>
		<br>
		<script type="text/javascript">
		$("#state_id").change(function(e){
			console.log($(this).val());
			var xid = $(this).val();
			if(xid!=''){
				$.ajax({
					type: "GET",
					url: "ajax1.php", 
					data:{id:xid,action:'getcity1'},
					success: function(result){
						$("#city_id").html(result);
			 		}
			 	});	
			}
		});
		</script>
		<br>
		<?php $hobby_id = getHobbies(); 
			foreach ($hobby_id as $key => $hobbies) {
				?>
					<input type="checkbox" name="hobbies[]" value="<?php echo $hobbies['id'] ?>">
    				<?php echo $hobbies['hobby_name'] ?>	
				<?php
			}
		 ?>
		<br><br>
		<?php $class = getclassx(); ?>
		<select id="class" name="class" class="custom-select w-25">
			<option value="">Select Class</option>
			<?php
				foreach ($class as $key => $classx) {
					echo "<option value='".$classx['id']."'>".$classx['class']."</option>";	
				}
			?>
		</select>
		 <br><br>
		 <tr>
			<td>
				<select id="student_no" name="student_no" class="custom-select w-25">
					<option value="">Number of students</option>
				</select>
			</td>
		</tr>
		<br>
		<script type="text/javascript">
		$("#class").change(function(e){
			console.log($(this).val());
			var mid = $(this).val();
			if(mid!=''){
				$.ajax({
					type: "GET",
					url: "ajax1.php", 
					data:{id:mid,action:'getstudent'},
					success: function(result){
						$("#student_no").html(result);
			 		}
			 	});	
			}
		});
		</script>
		 <br>
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