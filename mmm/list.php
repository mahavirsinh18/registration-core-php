<?php

include "connect.php";

// $orderBy = "name";
// $order = "asc";

// if(!empty($_GET["orderby"])) {
// 	$orderBy = $_GET["orderby"];
// }
// if(!empty($_GET["order"])) {
// 	$order = $_GET["order"];
// }

// $sql = "SELECT * FROM registration ORDER BY " . $orderBy . " " . $order;
// $result = mysqli_query($conn, $sql);

// $emailNextOrder = "asc";
// $cityNextOrder = "asc";
// $nameNextOrder = "desc";

// if($orderBy == "email" and $order == "asc"){
// 	$emailNextOrder = "desc";
// }

// if($orderBy == "city" and $order == "asc"){
// 	$cityNextOrder = "desc";
// }

// if($orderBy == "name" and $order == "desc"){
// 	$nameNextOrder = "asc";
// }

?>

<!DOCTYPE html>
<html>
<head>
	<meta  http-equiv="Content-Type" content="text/html;  charset=utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<form class="form-inline justify-content-center" action="" method="post">
		<input type="text" name="search" class="form-control mr-sm-2">
		<button type="submit" name="submit" class="btn btn-outline-primary" value="Search">Search</button>
	</form>
	<br>
	<table class="table table-bordered" id="myTable">
		<thead>
			<tr>
				<th onclick="sortTable(0)">Name</th>
				<th>E-mail</th>
				<th>Contact</th>
				<th>Gender</th>
				<th onclick="sortTable(1)">City</th>
				<th>Image</th>
				<th>Action</th>
			</tr>
		</thead>

		<?php

		$search_value = isset($_POST["search"]);
		$sql = "SELECT * FROM registration WHERE name LIKE '%$search_value%' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo "<tbody>";
					echo "<tr>";
						echo "<td>".$row['name']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['contact']."</td>";
						echo "<td>".$row['gender']."</td>";
						echo "<td>".$row['city']."</td>";
						echo "<td><img src='mmm/uploads'".$row['pro_image']."></td>";
						echo "<td><a href='update.php?id=".$row['id']."'>Update</a> | <a href='delete.php?id=".$row['id']."'>Delete</a></td>";
					echo "</tr>";
				echo "</tbody>";
				// echo "<tbody><tr><td>$row['name']</td><td>$row['email']</td><td>$row['contact']</td><td>$row['gender']</td><td>$row['city']</td><td><img src=mmm/uploads/$row['pro_image']></td></tr></tbody>";
			}
		}

		?>
	</table>

	<ul class="pagination justify-content-center">
		<li class="page-item"><a class="page-link" href="">Previous</a></li>
		<li class="page-item"><a class="page-link" href="">1</a></li>
		<li class="page-item"><a class="page-link" href="">2</a></li>
		<li class="page-item"><a class="page-link" href="">3</a></li>
		<li class="page-item"><a class="page-link" href="">Next</a></li>
	</ul>

	<script>
		function sortTable(n) {
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("myTable");
			switching = true;
			dir = "asc";
			while (switching) {
				switching = false;
				rows = table.rows;
				for (i = 1; i < (rows.length - 1); i++) {
					shouldSwitch = false;
					x = rows[i].getElementsByTagName("TD")[n];
      				y = rows[i + 1].getElementsByTagName("TD")[n];
      				if (dir == "asc") {
        				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        					shouldSwitch= true;
          					break;
        				}
        			}else if(dir == "desc"){
        				if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        					shouldSwitch = true;
          					break;
        				}
        			}
				}
				if (shouldSwitch) {
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      				switching = true;
      				switchcount ++;
				}else{
					if (switchcount == 0 && dir == "asc") {
       	 			dir = "desc";
        			switching = true;
      				}
				}
			}
		}
	</script>
</div>

</body>
</html>