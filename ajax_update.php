<?php

include "connect.php";

$id = $_GET['id'];

$sql = "SELECT * FROM student WHERE id = $id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);

?>