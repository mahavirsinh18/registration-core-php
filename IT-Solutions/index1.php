<?php

if(isset($_REQUEST['q']) && $_REQUEST['q'])
{
	//print_r($_REQUEST['q']);
	$data = file_get_contents('https://data.gov.sg/api/action/datastore_search?resource_id=bdb377b8-096f-4f86-9c4f-85bad80ef93c&q='.urlencode($_REQUEST['q']));

	/*print "<pre>";
	print_r($data);*/
	if($data)
	{
		$arr = json_decode($data,true);
		$data = $arr['result']['records'];
	}
	else
	{

	}

	?> 
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Entity Name</th>
				<th>UEN Number</th>
				<th>Entity Type</th>
				<th>Issue Date</th>
				<th>UEN Status</th>
				<th>Street Name</th>
				<th>Postal Code</th>
			</tr>
		</thead> <?php
		$first_array = array();
		$second_array = array();
		foreach($data as $row){

			if($row['entity_name'] == $_REQUEST['q']){
				$first_array[] = $row;
	  		}
	  		else
	  		{
	  			$second_array[] = $row;
	  		}
		} 
	/*print_r($first_array); 
	echo "<br>";
	print_r($second_array); die();*/
	?>

	<?php 
	$page = "";
	$limit = 5;
	?>

	<?php
		if($row['entity_name'] == $_REQUEST['q'])
		{
			foreach($first_array as $row)
			{
			 ?>
				<tbody>
					<tr>
						<td><?php echo $row['entity_name']; ?></td>
						<td><?php echo $row['uen']; ?></td>
						<td><?php echo $row['entity_type']; ?></td>
						<td><?php echo $row['uen_issue_date']; ?></td>
						<td><?php echo $row['uen_status']; ?></td>
						<td><?php echo $row['reg_street_name']; ?></td>
						<td><?php echo $row['reg_postal_code']; ?></td>
					</tr>
				</tbody>
			<?php 
			}
		}
		else
		{
		$total_records = COUNT($second_array);
		$total_pages = ceil($total_records / $limit);
		$i = 0;
		foreach($second_array as $row)
			{
			
			if($i < $limit){
			 ?>
				<tbody>
					<tr>
						<td><?php echo $row['entity_name']; ?></td>
						<td><?php echo $row['uen']; ?></td>
						<td><?php echo $row['entity_type']; ?></td>
						<td><?php echo $row['uen_issue_date']; ?></td>
						<td><?php echo $row['uen_status']; ?></td>
						<td><?php echo $row['reg_street_name']; ?></td>
						<td><?php echo $row['reg_postal_code']; ?></td>
					</tr>
				</tbody>
			<?php $i++;
			}
		}

		}

	?> </table> <?php
}

$pageLink = "";

	?><div class="row justify-content-center"><?php
	for($i=1; $i<=$total_pages; $i++){
		$active = "";
		if($page == $i)
			$active = 'active';
		$pageLink .= "<a href='' class='btn btn-outline-primary space page-link ".$active."'>".$i."</a>";
	}	
	echo $pageLink . "";
	?></div> <?php
?>
