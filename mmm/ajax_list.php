<?php

include "connect.php";

$page = $sortby = $order = $Search = "";

$limit = 5; 
if (isset($_GET["page"]) && $_GET["page"] != ''){ 
	$page = $_GET["page"];
} 
else { 
 	$page = 1;
}

$start_from = ($page-1) * $limit;

if (!empty($_GET['sortby'])) {
	$orderby = $_GET['sortby'];
	$ordertype = $_GET['order'];
}
else {
	$orderby = 'id';
	$ordertype = 'asc';
}

if (!empty($_GET['search'])) {
	$search_value = $_GET['search'];
	$where = "WHERE `name` LIKE '%$search_value%'";
}	
else {	
	$where = '';	
}	
																							
$sql = "SELECT * FROM `student` $where ORDER BY $orderby $ordertype LIMIT $start_from, $limit";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
	<meta  http-equiv="Content-Type" content="text/html;  charset=utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<style type="text/css">
		.space {margin: 3px;}
	</style>
</head>
<body>

<div class="container">
<form method="get" action="" class="form-inline justify-content-center">
	<input type="text" name="search" class="form-control mr-sm-2" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : ''; ?>">
	<button type="submit" class="btn btn-outline-primary" value="Search">Search</button>
	<br><br>
</form>

<!-- <a href="form.php" class="btn btn-outline-success">Add new record</a> -->
<br><br>

<table class="table table-bordered" id="myTable">		
	<thead>
		<tr>	
			<?php 
				$order = 'desc';

				if (!empty($_GET['order'])) {
					if($_GET['order'] == 'desc') {
						$order = 'asc';
					}
				}

				if (!empty($_GET['search'])) {
					$search = $_GET['search'];
				}else {
					$search = '';
				}

				if (isset($_GET["page"])) {
					$page = $_GET["page"]; 
				}else { 
				 	$page = 1;
				} 																
			?>
			<th><a href="?page=<?php echo $page;?>&sortby=name&order=<?php echo $order;?>&search=<?php echo $search;?>">Name</a></th>
			<th><a href="?page=<?php echo $page;?>&sortby=email&order=<?php echo $order;?>&search=<?php echo $search;?>">Gender</a></th>
			<th><a href="?page=<?php echo $page;?>&sortby=contact&order=<?php echo $order;?>&search=<?php echo $search;?>">Country</a></th>
			<th><a href="?page=<?php echo $page;?>&sortby=city&order=<?php echo $order;?>&search=<?php echo $search;?>">State</a></th>
			<th>Image</th>
			<th>Action</th>
		</tr> 
	</thead> 
	<tbody> 

<?php 
	while ($row = mysqli_fetch_array($result)){ 
	 	?>
		<tr>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['gender']; ?></td>
			<td><?php echo $row['country_id']; ?></td>
			<td><?php echo $row['state_id']; ?></td>
			<td><img src="uploads/<?php if($row['stud_image']!=''){ echo $row['stud_image'];} else{echo "noimage.jpg";} ?>" heigth="50" width="50"></td>		
			<td>
				<a href="ajax_update.php?id=<?php echo $row['id']; ?>">Update</a> | <a href="ajax_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
			</td>
		</tr>
		<?php	
	}
?>
	</tbody>
</table>

<?php

	if (isset($_GET['sortby'])) {
		$sortby = $_GET['sortby'];
	}
	if (isset($_GET['order'])) {
		$order = $_GET['order'];	
	}
	if (isset($_GET['page'])) {
		$page = $_GET['page'];	
	}
	
	if (isset($_GET['search'])) {
		$search = $_GET['search'];	
	}

	$sql = "SELECT COUNT(id) FROM `student` $where";
	$result_db = mysqli_query($conn, $sql); 
	$row_db = mysqli_fetch_row($result_db); 	
	$total_records = $row_db[0];  
	$total_pages = ceil($total_records / $limit); 
	$pageLink = "";

	?><div class="row justify-content-center"><?php
	for($i=1; $i<=$total_pages; $i++){	
		$pageLink .= "<a href='ajax_list.php?page=".$i."&sortby=".$sortby. "&order=".$order."&search=".$search."'class='btn btn-outline-primary space'>".$i."</a>";
	}	
	echo $pageLink . "";
	?></div><?php

?>
</div>

</body>
</html>