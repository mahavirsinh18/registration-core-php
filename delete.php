<?php

include "connect.php";

$id = $_GET['id'];

$sql = "DELETE FROM form WHERE id = $id";
if(!$conn->query($sql) === true){
	echo "error" . $conn->error;
}

header("refresh:1; url=list.php");

?>