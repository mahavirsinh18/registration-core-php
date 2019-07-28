<?php
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
		<td>Roll No</td>
		<td>Name</td>
		<td>E-mail</td>
		<td>Mobile</td>
		<td>Update</td>
		<td>Delete</td>
	</tr>
	</thead>
	<?php
	$sql = "SELECT * FROM form";
	$result = $conn->query($sql);
	if($result->num_rows > o){
		while($row = $result->fetch_assoc()){
			echo "<tbody>";
			echo "<tr>";
			echo "<td>".$row['roll_no']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['email']."</td>";
			echo "<td>".$row['mobile']."</td>";
			echo "<td><a href='update.php?id=".$row['id']."'>Update</a></td>";
			echo "<td><a href='delete.php?id=".$row['id']."'>Delete</a></td>";
			echo "</tr>";
			echo "</tbody>";
		}
	}else{
		echo "<tr>";
		echo "<td>0 results</td>";
		echo "</tr>";
	}
	?>
</table>
</div>

</body>
</html>