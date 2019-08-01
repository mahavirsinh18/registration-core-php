<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "function.php";

/*$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES['image']['name']);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));*/

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

<form action="" method="post" name="form1" id="form1">
		Name
		<input type="text" name="name" id="name">
		<br><br>
		E-mail
		<input type="text" name="email" id="email">
		<br><br>
		<?php $state_id = getState(); ?>
		<select id="state_id" name="state_id">
			<option value="">Select State</option>
			<?php
			foreach ($state_id as $key => $state) {
				echo "<option value='".$state['id']."'>".$state['state_name']."</option>";	
			}
		?>
		</select>
		<br><br>
		<select id="city_id" name="city_id">
			<option value="">City</option>
		</select>
		<br><br>
		<script type="text/javascript">
		$("#state_id").change(function(e){
			console.log($(this).val());
			var zid = $(this).val();
			if(zid!=''){
				$.ajax({
					type: "post",
					url: "ajax1.php", 
					data:{id:zid,action:'getcity2'},
					success: function(result){
						$("#city_id").html(result);
			 		}
			 	});	
			}
		});
		</script>
		<input type="file" name="image" id="image">
		<br><br>
		<button type="button" name="submit" id="submit">Submit</button>
</form>

</body>

<script type="text/javascript">
	$("#submit").click(function(e){

		var name = $("#name").val();
		var email = $("#email").val();
		var state = $("#state_id").val();
		var city = $("#city_id").val();
		var image = $("#image").val();

		console.log($('input[type=file]')[0].files[0]);
		var formData = new FormData();
		formData.append("name",name);
		formData.append("email",email);
		formData.append("state_id",state);
		formData.append("city_id",city);
		formData.append('image', $('input[type=file]')[0].files[0]);
		var data2 = 'name='+ name + '&email='+ email + '&state_id='+ state + '&city_id='+ city + '&image='+ image;
		if(name==''||email==''||state==''||city==''||image==''){ 
			alert("Please enter the given fields");
		}else{
			$.ajax({
				processData:false,
				contentType:false,
				type:"post",
				url:"ajax1.php?action=mdata",
				data:formData,
				success:function(result){
					alert(result);
				}
			});
		}
	});
</script>

</html>