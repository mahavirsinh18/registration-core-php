<?php

include "connect.php";

$id = $_GET['id'];

$sql = "DELETE FROM registration WHERE id = $id";

if(!$conn->query($sql) === true){
	die("error" . mysqli_error());
}

header("refresh:1; url=list.php");

?>