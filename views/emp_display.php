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

<table class="table table-bordered">
	<tr>
		<th>Sr no</th>
		<th>Name</th>
		<th>Gender</th>
		<th>City</th>
		<th>Contact</th>
		<th>E-mail</th>
		<th>Update</th>
		<th>Delete</th>
	</tr>
	<?php

	$i = 1;
	foreach($data as $row)
	{
		echo "<tr>";
		echo "<td>".$i."</td>";
		echo "<td>".$row->name."</td>";
		echo "<td>".$row->gender."</td>";
		echo "<td>".$row->city."</td>";
		echo "<td>".$row->contact."</td>";
		echo "<td>".$row->email."</td>";
		echo "<td><a href='updatedata?id=".$row->id."'>Update</a></td>";
		echo "<td><a href='deletedata?id=".$row->id."'>Delete</a></td>";
		echo "</tr>";
		$i++;
	}

	?>
</table>

</body>
</html>