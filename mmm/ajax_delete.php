<?php

include "connect.php";

$id = $_POST['id'];

$sql = "DELETE FROM student WHERE id = $id";


if(!$conn->query($sql) === true){
	die("error" . mysqli_error());
}

//header("refresh:1; url=ajax_list.php");

?>