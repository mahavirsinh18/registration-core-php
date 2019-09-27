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
  	<style type="text/css">
  		.error {color: red;}
  	</style>
</head>
<body>

<script type="text/javascript">
	function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("stud_image").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
</script>

<div class="container">
	<form action="" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data">

		<input type="hidden" name="update_id" class="update_id" value="0">

		<div class="form-group">
			Name:
			<input type="text" name="name" id="name" class="form-control w-25" value="<?php echo isset($Oldvalue['name']) ? $Oldvalue['name'] : ''; ?>">
			<span id="error"></span>
		</div>

		<div id="gender">
		Gender:
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="gen1" class="custom-control-input" value="Male" <?php echo (isset($Oldvalue['gender']) && $Oldvalue['gender'] == 'Male') ? 'checked' : ''; ?> >
			<label for="gen1" class="custom-control-label">Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" name="gender" id="gen2" class="custom-control-input" value="Female" <?php echo (isset($Oldvalue['gender']) && $Oldvalue['gender'] == 'Female') ? 'checked' : ''; ?> >
			<label for="gen2" class="custom-control-label">Female</label>
		</div>
		</div>
		<span id="error"></span>
		<br>

		<?php $country_id = getCountry(); ?>
		<select name="country_id" id="country_id" class="custom-select w-25">
			<option value="">Select country</option>
			<?php
				foreach($country_id as $key => $country){
					echo "<option value='".$country['id']."'>".$country['country_name']."</option>";
				}
			?>
		</select>
		<br>
		<span id="error"></span>
		<br>

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
			<input type="hidden" name="tmp_image" id="tmp_image">
			<input type="file" name="stud_image" id="stud_image" class="custom-file-input" onchange="PreviewImage();">
			<label for="stud_image" class="custom-file-label">Choose image</label>
		</div>
		<img id="uploadPreview" style="width: 100px; height: 100px;"/>
		<span id="error"></span>
		<br><br>

		<button type="submit" id="submit" value="Submit" class="btn btn-outline-primary">Submit</button>
		<br><br><br>
		<hr>

		<input type="hidden" id="page" value="1">
		<input type="hidden" id="sortdir" value="desc">
		<input type="hidden" id="orderby" value="id">
		<input type="text" name="search" class="form-control w-25" id="search" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : ''; ?>">
		<br>
		<button type="button" onclick="datalist()" name="searchbtn" id="searchbtn" class="btn btn-outline-primary" value="Search">Search</button>
	
		<div id="response"></div>
	</form>
</div>

</body>

<script type="text/javascript">
	$(document).ready(function(){
	$("#myForm").submit(function(event){
		event.preventDefault(); //prevent default action
		var request_method = $(this).attr("method");  //get form method
		var form_data = new FormData(this);

		$('form[id="myForm"]').validate({
			rules: {
				name: 'required',
				gender: 'required',
				country_id: 'required',
				stud_image: 'required'
			},
			messages: {
				name: 'please enter your name',
				gender: '',
				country_id: 'please select country',
				stud_image: 'please choose any image',
			},
			submitHandler: function(form){
				$.ajax({
					url : "connect.php?action=fdata",
					type : request_method,
					data : form_data,
					contentType : false,
					cache : false,
					processData : false,
					success : function(data){
						$("#myForm")[0].reset();
						datalist();
					}
				});
			}
		});
	});
	});

/////listing/////
function datalist(){
	$.ajax({
		type : "post",
		url : "ajax_list.php",
		data:{
			page:$('#page').val(),
			search:$('#search').val(),
			orderby:$('#orderby').val(),
			sortdir:$('#sortdir').val()
		},
		success: function(data){
			$("#response").html(data);
		}
	});
}

////searching
$('#searchbtn').click(function(){
	$('#page').val('1');
	datalist();
});

////pagination
$('body').on('click','.page-link',function(){
	$('#page').val($(this).html());
	datalist();
	return false;
});

////sorting
$('body').on('click','.column',function(){
	$('#orderby').val($(this).attr('data-name'));
	$('#sortdir').val($(this).attr('data-direction'));
	datalist();
});

$(document).ready(function(){
	datalist();
});

/////delete/////
$('body').on('click','.delete',function(){
	if(confirm("Are you sure?")){
		var id = $(this).attr("delete-id");
		//alert(id);
		$.ajax({
	    	type: "post",
	    	url: "ajax_delete.php",
	    	data: {id: id},
	    	success:function(data){
	    		datalist();
	    	}
		});
		return false;
	}
    return false;
});

/////update/////
$('body').on('click','.update',function(){
	$.ajax({
		type: "get",
		url: $(this).attr('href'),
		dataType: 'json',
		success: function(data){
			$('#name').val(data.name);
			$('#gender').val(data.gender);
			$('#country_id').val(data.country_id);
			$('#state_id').val(data.state_id);
			$('#tmp_image').val(data.tmp_image);
			if(data.stud_image != "")
				$('#uploadPreview').attr('src', data.stud_image);
			else
				$('#uploadPreview').attr('src', "");
			$('#update_id').val(data.id);
		}
	});
	return false;
});

</script>

</html>