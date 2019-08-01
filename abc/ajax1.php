<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "function.php";

$action = "";

if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
}

switch ($action) {
	case 'getcity1':
	    getcity1($_REQUEST);
		break;
	case 'getcity2':
	    getcity2($_REQUEST);
		break;
	case 'getstudent':
		getstudent($_REQUEST);
		break;
	case 'getpin':
		getpin($_REQUEST);
		break;
	case 'pdata':
		pdata($_POST);
		break;
	case 'mdata':
		mdata($_POST);
		break;
	case 'imgdata':
		imgdata($_POST);
		break;
	default:
		# code...
		break;
}



function getcity1($param){
	$conn=connectme();
	$query = "SELECT * FROM city WHERE state_id = ".$param['id'];
	$result = $conn->query($query);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			//$city[$row['id']] = $row['city_name'];
			echo "<option>".$row['city_name']."</option>";
		}
	}
	//print_r($city);
	//echo json_encode($city);
	exit;
}

function getcity2($param){
	$conn=connectme();
	$query = "SELECT * FROM city WHERE state_id = ".$param['id'];
	$result = $conn->query($query);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo "<option value='".$row['id']."'>".$row['city_name']."</option>";
		}
	}
	exit;
}

function getstudent($param){
	$conn = connectme();
	$query = "SELECT * FROM student WHERE class_id = ".$param['id'];
	$result = $conn->query($query);
	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			echo "<option>".$row['student_no']."</option>";
		}
	}
	exit;
}

function getpin($param){
	$conn = connectme();
	$query = "SELECT * FROM pin WHERE city_id = ".$param['id'];
	$result = $conn->query($query);
	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			echo "<option>".$row['pincode']."</option>";
		}
	}
	exit;
}

function pdata($param){
	$conn = connectme();
	$name = $param['name'];
	$email = $param['email'];
	$contact = $param['contact'];
	$college = $param['college'];
	$query = "INSERT INTO ajax (name, email, contact, college) VALUES ('$name','$email','$contact','$college')";
	if(mysqli_query($conn, $query)){

	}
	exit;
}

function mdata($param){
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES['image']['name']);
	move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);	
	$conn = connectme();
	$name = $param['name'];
	$email = $param['email'];
	$state = $param['state_id'];
	$city = $param['city_id'];
	$query = "INSERT INTO mg (name, email, state_id, city_id, image) VALUES ('$name','$email','$state','$city','$target_file')";
	if(mysqli_query($conn, $query)){

	}
	exit;
}

function imgdata($param){
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES['image']['name']);
	$t = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
	$conn = connectme();
	$query = "INSERT INTO gallery (image) VALUES ('$target_file')";
	if(mysqli_query($conn, $query)){
	}
	include "gallery-content.php";
	exit;
}


//$t = getcity1($param);
?>