<?php

include "connect.php";

$roll_no = $name = $email = $mobile = "";

$errorMsg = [];
$OldValue = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$roll_no = test_input($_POST['roll_no']);
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$mobile = test_input($_POST['mobile']);

	if($isValid == true){
		$sql = "INSERT INTO form (roll_no,name,email,mobile) VALUES ('$roll_no','$name','$email','$mobile')";
		if(mysqli_query($conn, $sql)){
			echo "";
		}else{
			$OldValue = [];
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	
</head>
<body>

<table>
	<form action="" method="post">
		<tr>
			<td>Roll No.:</td>
			<td><input type="text" name="roll_no"></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name"></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Mobile No.:</td>
			<td><input type="text" name="mobile"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</form>
</table>

</body>
</html>