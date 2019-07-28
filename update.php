<?php

include "connect.php";

$roll_no = $name = $email = $mobile = "";

$id = $_REQUEST['id'];

$sql = "SELECT * FROM form WHERE id = $id";
$result = $conn->query($sql);

$errorMsg = [];
$OldValue = $result->fetch_assoc();
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$roll_no = test_input($_POST['roll_no']);
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$mobile = test_input($_POST['mobile']);

	if($isValid == true){
		$sql = "UPDATE form SET roll_no = '$roll_no', name = '$name', email = '$email', mobile = '$mobile' WHERE id = $id";
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
	<form action="update.php?id=<?php echo $OldValue['id']; ?>" method="post">
		<tr>
			<td>Roll No.:</td>
			<td><input type="text" name="roll_no" value="<?php echo isset($OldValue['roll_no']) ? $OldValue['roll_no'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" value="<?php echo isset($OldValue['name']) ? $OldValue['name'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email" value="<?php echo isset($OldValue['email']) ? $OldValue['email'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>Mobile No.:</td>
			<td><input type="text" name="mobile" value="<?php echo isset($OldValue['mobile']) ? $OldValue['mobile'] : ""; ?>"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</form>
</table>

</body>
</html>