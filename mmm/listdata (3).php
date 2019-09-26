<?php
$conn = mysqli_connect('localhost','root','','prectical');

session_start();

if(isset($_SESSION) && !empty($_SESSION['user']))
{

$limit = 4; 
if (isset($_POST["page"]) && $_POST["page"] != '') { 
		$page = $_POST["page"]; 
		//echo $page;
} 
else { 
 	$page = 1;
} 
$start_from = ($page-1) * $limit;
//echo $start_from;

if (!empty($_POST['orderby'])) {
	$orderby = $_POST['orderby'];
	$ordertype = $_POST['sortdir'];
	//echo $orderby;
	//echo $ordertype;
}
else {
	$orderby = 'id';
	$ordertype = 'DESC';
}


if (!empty($_POST['search'])) {
	$search_value = $_POST['search'];
	$where = "WHERE `emp_name` LIKE '%$search_value%' OR `salary` LIKE '%$search_value%'";
}	
else {	
	$where = '';	
}	
																							
$sql = "SELECT * FROM `emp_reg` $where ORDER BY $orderby $ordertype LIMIT $start_from, $limit";

// echo $sql;

$result = mysqli_query($conn, $sql);

$sortdir = $_POST['sortdir'];
if($_POST['sortdir']=="DESC")
$sortdir = "ASC";
else
$sortdir = "DESC";
		
?>

<!DOCTYPE html>
<html>
<head>
	<title>DataList</title>
</head>
<body>
	<h2>List Employee Data</h2>	
		
	<table border="1px" class="table table-borderd table-striped">
		<tr>
			<td class="column" data-name="id" data-dir="<?php echo $sortdir?>"><b>ID</b></td>
			<td class="column" data-name="emp_name" data-dir="<?php echo $sortdir?>"><b>EmpName</b></td>
			<td class="column" data-name="salary" data-dir="<?php echo $sortdir?>"><b>Salary</b></td>
			<td><b>Profile</b></td>
			<td><b>Action</b></td>

		</tr>
		<?php
			//$sql = "SELECT * FROM emp_reg";
			//$res = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($result))
			{
	
		?>

		<tr>
			
			<td> <?php echo $row['id']; ?></td>	
			<td> <?php echo $row['emp_name']; ?></td>	
			<td> <?php echo $row['salary']; ?></td>	
			<td><img src="profile/<?php if($row['profile']!=''){ echo $row['profile'];} else{echo "noimage.jpg";} ?>" heigth="50" width="50"></td>
			
			<td><a class="edit-link" href="updatedat.php?id=<?php echo $row['id']?>">Edit</a>  /

				<a class="delete-link" href="javascript:void(0)" data-id="<?php echo $row['id']?>">Delete</a>

				<!-- <a class="delete-link" href="delete.php?id=<?php //echo $row['id']?>" onclick="return confirm('Are you sure?')" >Delete</a> -->
			</td>	
			
		</tr>


	<?php }

	 ?>

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

	$sql = "SELECT COUNT(id) FROM `emp_reg` $where";
	$result_db = mysqli_query($conn, $sql); 
	$row_db = mysqli_fetch_row($result_db); 
	$total_records = $row_db[0];  
	$total_pages = ceil($total_records/$limit); 
	$pagLink = "";  

	/*if($page>1)
		{
			echo "<a href='index.php?page=".($page-1)."' class='btn btn-danger'>Previous</a> ";
		}*/
	for ($i=1; $i<=$total_pages; $i++) {	
		$active = "";
		if($page==$i)
			$active = 'active';
	    	$pagLink .= "<a href='javascript:void(0)' class='btn btn-success page-number ".$active."'>".$i."</a>";		
	}	
	echo $pagLink . "";  
	
	/*if($i>$page)
		{
			echo "<a href='index.php?page=".($page+1)."'class='btn btn-danger'>Next</a>";		
		}*/
?>
		<br>

		<a class="pdf-link" href="pdf_action.php?search_val=<?php if(isset($search_value)){echo $search_value; } ?>">Generate PDF</a>
		&nbsp; 
		<a class="excel-link" href="excel_action.php?search_val=<?php if(isset($search_value)){echo $search_value; } ?>">Generate Excel</a> 
	</form>
</body>
</html>


<?php
}
else
{
	header('location:login.php');
}
?>