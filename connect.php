<?php

$servername = "localhost";
$username = "root";
$password = "root";
$db = "mah";

$conn = mysqli_connect($servername, $username, $password, $db);

if(!$conn){
	die("connection failed" . mysqli_connect_error());
}

function test_input($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>