<?php

include_once "function.php";

$pincode = $city = "";

$errorMsg = [];
$OldValue = [];
$isValid = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$OldValue = $_POST;
	$pincode = test_input($_POST['pincode']);
	$city = test_input($_POST['city_id']);

	if($pincode == ""){
		$errorMsg['pincode'] = "";
		$isValid = false;
	}

	if($city == ""){
		$errorMsg['city_id'] = "";
		$isValid = false;
	}
}

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
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
	<?php $city_id = getCity(); ?>
	<select id="city_id" name="city_id" class="custom-select w-25">
		<option value="">Select City</option>
		<?php
			foreach ($city_id as $key => $city) {
				echo "<option value='".$city['id']."'>".$city['city_name']."</option>";
			}
		?>
	</select>
	<br><br>
	<tr>
		<td>
			<select id="pincode" name="pincode" class="custom-select w-25">
				<option value="">Pincode</option>
			</select>
		</td>
	</tr>
	<br>
	<script type="text/javascript">
	$("#city_id").change(function(e){
		console.log($(this).val());
		var iid = $(this).val();
		if(iid!=''){
			$.ajax({
				type: "GET",
				url: "ajax1.php", 
				data:{id:iid,action:'getpin'},
				success: function(result){
					$("#pincode").html(result);
		 		}
		 	});	
		}
	});
	</script>
	</form>
	</div>

</body>

</html>