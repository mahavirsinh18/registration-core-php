<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
<table class="table table-bordered">
	<thead>
	<tr>
		<td>Name</td>
		<td>E-mail</td>
		<td>DOB</td>
		<td>Update</td>
		<td>Delete</td>
	</tr>
	</thead>
	<?php
	$sql = "SELECT id,name,email,dob FROM curr";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo "<tbody>";
			echo "<tr>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['email']."</td>";
			echo "<td>".$row['dob']."</td>";
			echo "<td><a href='curr-update.php?id=".$row['id']."'>Update</a></td>";
			echo "<td><a href='curr-delete.php?id=".$row['id']."'>Delete</a></td>";
			echo "</tr>";
			echo "</tbody>";
		}
	}

	?>
</table>
</div>

</body>
</html>