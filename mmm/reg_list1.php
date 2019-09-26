<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "connect.php";
$name = $gender = $country_id = $country = $state_id = $state = $stud_image = "";
$Oldvalue = [];
$Oldvalue = $_POST;
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</head>
<body>

<div class="container">
	<form action="" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-group">
			Name:
			<input type="text" name="name" id="name" class="form-control w-25" value="<?php echo isset($Oldvalue['name']) ? $Oldvalue['name'] : ''; ?>">
			<span id="error"></span>
		</div>

		Gender:
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="gen1" class="custom-control-input" value="Male" <?php echo (isset($Oldvalue['gender']) && $Oldvalue['gender'] == 'Male') ? 'checked' : ''; ?> >
			<label for="gen1" class="custom-control-label">Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="gen2" class="custom-control-input" value="Female" <?php echo (isset($Oldvalue['gender']) && $Oldvalue['gender'] == 'Female') ? 'checked' : ''; ?> >
			<label for="gen2" class="custom-control-label">Female</label>
		</div>
		<span id="error"></span>
		<br><br>

		<?php $country_id = getCountry(); ?>
		<select name="country_id" id="country_id" class="custom-select w-25" required="">
			<option value="">Select country</option>
			<?php
				foreach($country_id as $key => $country){
					echo "<option value='".$country['id']."'>".$country['country_name']."</option>";
				}
			?>
		</select>
		<span id="error"></span>
		<br><br>

		<select name="state_id" id="state_id" class="custom-select w-25">
			<option value="">State</option>
		</select>

		<script>
			$("#country_id").change(function(e){
				var cid = $(this).val();
				if(cid != ''){
					$.ajax({
						type: "GET",
						url: "connect.php",
						data: {id:cid, action:'getState'},
						success: function(result){
							$("#state_id").html(result);
						}
					});
				}
			});
		</script>
		<br><br>

		<div class="custom-file w-25">
			<input type="file" name="stud_image" id="file" class="custom-file-input">
			<label for="file" class="custom-file-label">Choose image</label>
		</div>
		<span id="error"></span>
		<br><br>

		<button type="submit" id="submit" value="Submit" class="btn btn-outline-primary">Submit</button>
		<div id="response"></div>
	</form>
</div>

</body>

<script type="text/javascript">
	$('body').on('click','#submit',function(event){
		event.preventDefault();
		var formData = new FormData($('#myForm')[0]);
		$.ajax({
			url: "connect.php?action=fdata",
			type: "post",
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function(data){
				$("#myForm")[0].reset();
			}
		});
	});

/////listing/////

function datalist(){
	search = $('.search').val();
	page = $('.page').val();
	orderby = $('.orderby').val();
	sortdir = $('.sortdir').val();
	$.ajax({
		type : "post",
		url : "ajax_list.php",
		data : {
			search:search,
    		page:page,
    		orderby:orderby,
    		sortdir:sortdir
    		},
		success: function(data){
			$("#response").html(data);
		}
	});
}
$(document).ready(function){
	datalist();
}

/////validation/////

$("#submit").click(function(){
	formValidation();
});

function formValidation(){
	var name = $('#name').val();
	var gender = $('#gen2').val();
	var country_id = $('#country_id').val();
	var state_id = $('#state_id').val();
	var stud_image = $('#stud_image').val();

	if(name.length < 1){
		$('#name').after('<span class="error">Please enter your name</span>');
	}
	if($('input[type=radio][name=gender]:checked').length == 0){
		$('#gen2').after('<span class="error">Please select gender</span>');
	}
	/*rules : {
		country_id : { required : true }
	}*/
	if(country_id.val() == ""){
		$('#country_id').after('<span class="error">Please select country</span>');
	}
	if(($_FILES["stud_image"]["error"]) == "4"){
		$('#stud_image').after('<span class="error">Please choose any image</span>');
	}
}

</script>
</html>