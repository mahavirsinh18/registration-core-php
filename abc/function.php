<?php

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$db = "login";

	$conn = mysqli_connect($servername, $username, $password, $db);

	if(!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}

	function connectme(){
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$db = "login";
	
		$conn = mysqli_connect($servername, $username, $password, $db);

		if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	function getState(){
		$conn=connectme();
		$state_name = [];
		$query = "SELECT id,state_name FROM state";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$state_name[]=$row;
			}
		}
		return $state_name;
	}

	function getCity(){
		$conn=connectme();
		$city_name = [];
		$query = "SELECT id,city_name FROM city";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$city_name[]=$row;
			}
		}
		return $city_name;
	}

	function getHobbies(){
		$conn=connectme();
		$hobby_name = [];
		$query = "SELECT id,hobby_name FROM hobbies";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$hobby_name[]=$row;
			}
		}
		return $hobby_name;
	}

	function getclassx(){
		$conn=connectme();
		$class = [];
		$query = "SELECT id,class FROM class_no";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$class[]=$row;
			}
		}
		return $class;
	}

?>