<?php 

$servername = "localhost";
$username= "root";
$password = "";
$db = "mmm";

$conn = mysqli_connect($servername,$username,$password,$db);

if(!$conn){
	die("not connected"  . mysqli_error());
}

function test_input($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>