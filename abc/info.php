<?php
session_start();
ini_set("display_errors", "1");
  error_reporting(E_ALL);
include_once "function.php";

	$name = $_SESSION['name'];
	$email = $_SESSION['email'];
	$gender = $_SESSION['gender'];
	$city = $_SESSION['city_id'];
	$state = $_SESSION['state_id'];
	//$hobby_name = $_SESSION['hobby_name'];
	$about = $_SESSION['about'];
	//$bg_image = $_SESSION['bg_image'];
	//$profile_image = $_SESSION['profile_image'];

	if(!isset($_SESSION['id'])){
		header("Location:login.php");
	}

	$user_id = $_SESSION['id'];
	$query = "SELECT registration.state_id, state.state_name FROM registration INNER JOIN state ON registration.state_id = state.id WHERE registration.id = $user_id";
	$result = $conn->query($query);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$state = $row['state_name'];
	}

	$query = "SELECT registration.city_id, city.city_name FROM registration INNER JOIN city ON registration.city_id = city.id WHERE registration.id = $user_id";
	$result = $conn->query($query);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$city = $row['city_name'];
	}

	function getHobbies1(){
		$conn=connectme();
		$hobby_name = [];
		$user_id = $_SESSION['id'];
		$query = "SELECT hobbies.id, hobbies.hobby_name FROM hobbies JOIN user ON hobbies.id = user.hobby_id WHERE user_id = $user_id";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$hobby_name[]=$row;
			}
		}
		return $hobby_name;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Wellcome <?php echo $name; ?></title>
	<style>
		body {background-color: powderblue;}
		.img1 {
			position: relative;
			top: 0;
			left: 0;
			border: 2px solid black;
			border-radius: 20px;
			box-shadow: 2px 2px 6px black;
		}
		.img2 {
			width: 150px;
			position: absolute;
			top: 190px;
			left: 370px;
			border: 2px solid black;
			border-radius: 50%;
		}
		.form1 {
			position: absolute;
			top: 300px;
			left: 730px;
		}
		.form2 {
			position: absolute;
			top: 300px;
			left: 800px;
		}
		.btn {
			background-color: black;
			color: white;
			border: 1px solid black;
			border-radius: 4px;
			font-size: 18px;
			box-shadow: 2px 2px 4px black;
		}
		.btn:hover{
			background-color: black;
			color: blue;
		}
		div{
			border: 5px solid black;
			text-align: center;
		}
		.name {
			border-bottom: 1px solid black;
			color: blue;
		}
	</style>
</head>

<body>

	<div>
	<h3>
		<img src="uploads/pic3.jpg" class="img1">
		<br>
		<img src="uploads/facebook.png" class="img2">
		<br><br>
		<i>Name:</i> <span class="name"><?php echo $name; ?></span>
		<br><br>
		<i>E-mail:</i> <span class="name"><?php echo $email; ?></span>
		<br><br>
		<i>Gender:</i> <span class="name"><?php echo $gender; ?></span>
		<br><br>
		<i>City:</i> <span class="name"><?php echo $city; ?></span>
		<br><br>
		<i>State:</i> <span class="name"><?php echo $state; ?></span>
		<br><br>
		<i>Hobbies:</i>
		<span class="name">
		<?php
			$hobby_name = getHobbies1();
			foreach ($hobby_name as $key => $hobbies) {
				echo $hobbies['hobby_name'].", ";
			}
		?> 
		</span>
		<br><br>
		<i>About:</i> <span class="name"><?php echo $about; ?></span>
		<br><br>
		<form method="post" action="edit.php" enctype="multipart/form-data" class="form1">
			<input type="submit" name="edit" value="Edit" class="btn">
		</form>
		<br>
		<form method="post" action="logout.php" enctype="multipart/form-data" class="form2">
			<input type="submit" name="logout" value="Log out" class="btn">
		</form>
	</h3>
	</div>

</body>

</html>