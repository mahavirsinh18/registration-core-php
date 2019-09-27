<?php

include "connect.php";

$limit = 5; 
if (isset($_POST["page"]) && $_POST["page"] != ''){ 
	$page = $_POST["page"];
} 
else { 
 	$page = 1;
}

$start_from = ($page-1) * $limit;

if (!empty($_POST['orderby'])) {
	$orderby = $_POST['orderby'];
	$ordertype = $_POST['sortdir'];
}
else {
	$orderby = 'id';
	$ordertype = 'desc';
}

if (!empty($_POST['search'])) {
	$search_value = $_POST['search'];
	$where = "WHERE `name` LIKE '%$search_value%'";
}	
else {	
	$where = '';	
}	
																							
$sql = "SELECT * FROM `student` $where ORDER BY $orderby $ordertype LIMIT $start_from, $limit";
$result = mysqli_query($conn, $sql);

$sortdir = $_POST['sortdir'];
if($_POST['sortdir']=="DESC")
$sortdir = "ASC";
else
$sortdir = "DESC";

?>

<br><br>

<table class="table table-bordered" id="myTable">		
	<thead>
		<tr>	
			<th class="column" data-name="name" data-direction="<?php echo $sortdir ?>">Name</th>
			<th class="column" data-name="gender" data-direction="<?php echo $sortdir ?>">Gender</th>
			<th class="column" data-name="country_id" data-direction="<?php echo $sortdir ?>">Country</th>
			<th class="column" data-name="state_id" data-direction="<?php echo $sortdir ?>">State</th>
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
				<a class="update" href="ajax_update.php?id=<?php echo $row['id']; ?>">Update</a> | <a class="delete" href="" delete-id="<?php echo $row['id']; ?>">Delete</a>
			</td>
		</tr>
		<?php	
	}
?>
	</tbody>
</table>

<?php

	$page = "";
	$orderby = "";
	$order = "";
	$search = "";

	if (isset($_POST['orderby'])) {
		$orderby = $_POST['orderby'];
	}
	if (isset($_POST['sortdir'])) {
		$order = $_POST['sortdir'];	
	}
	if (isset($_POST['page'])) {
		$page = $_POST['page'];	
	}
	
	if (isset($_POST['search'])) {
		$search = $_POST['search'];	
	}

	$sql = "SELECT COUNT(id) FROM `student` $where";
	$result_db = mysqli_query($conn, $sql); 
	$row_db = mysqli_fetch_row($result_db); 	
	$total_records = $row_db[0];  
	$total_pages = ceil($total_records / $limit); 
	$pageLink = "";

	?><div class="row justify-content-center"><?php
	for($i=1; $i<=$total_pages; $i++){
		$pageLink .= "<a href='' class='btn btn-outline-primary space page-link'>".$i."</a>";
	}	
	echo $pageLink . "";
	?></div><?php

?>
</div>
