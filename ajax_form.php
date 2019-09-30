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
            document.getElementById("previewImage").src = oFREvent.target.result;
        };
    };
</script>

<div class="container">
	<form action="" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data">

		<input type="hidden" name="update_id" id="update_id" class="update_id" value="0">

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
			<input type="hidden" name="ex_image" id="ex_image">
			<input type="file" name="stud_image" id="stud_image" class="custom-file-input" onchange="PreviewImage();">
			<label for="stud_image" class="custom-file-label">Choose image</label>
		</div>
		<img id="previewImage" style="width: 100px; height: 100px; border-radius: 15px;"/>
		<br>
		<span id="imageValidation"></span>
		<br><br>

		<button type="submit" id="submit" value="Submit" class="btn btn-outline-primary">Submit</button>
		<br><br><br>
		<hr>

		<input type="hidden" id="page" value="1">
		<input type="hidden" id="sortdir" value="desc">
		<input type="hidden" id="orderby" value="id">
		<input type="text" name="search" class="form-control w-25" id="search" value="">
		<br>
		<button type="button" onclick="datalist()" name="searchbtn" id="searchbtn" class="btn btn-outline-primary" value="Search">Search</button>
			
		<div id="response"></div>
		
	</form>
</div>

</body>

<script type="text/javascript">
	$(document).ready(function(){
		$('form[id="myForm"]').validate({
			rules: {
				name: 'required',
				gender: 'required',
				country_id: 'required',
				//stud_image: 'required'
			},
			messages: {
				name: 'please enter your name',
				gender: '',
				country_id: 'please select country',
				//stud_image: 'please choose any image',
			},
			submitHandler: function(form){
				// var request_method = $(this).attr("method");  //get form method
				var form_data = new FormData(form);
				// new FormData($('form[id="myForm"]'))
		
				$.ajax({
					url : "connect.php?action=fdata",
					type : 'post',
					data : form_data,
					contentType : false,
					cache : false,
					processData : false,
					success : function(data){
						$('#stud_image').val("");
						$('.bootstrap-filestyle :input').val('');
						$('#previewImage').attr('src',"");
						$("#myForm")[0].reset();
						datalist();
					}
				});
				return false;
			}
		});
	
	});

////image validation
$('#submit').click(function(){
	formValidation();		
});

function formValidation(){
	var update_id = $('#update_id').val();
	var stud_image = $('#stud_image').val();
	var imageValidation = 0;

	if(update_id == 0){
		if($.trim(stud_image).length > 0){
			if(imageCheck(stud_image)){
				imageValidation = 0;
				$('#imageValidation').removeClass('error');
				$('#imageValidation').html("");
			}else{
				imageValidation = 1;
				$('#imageValidation').addClass('error');
				$('#imageValidation').html("");	
			}
			$('#imageValidation').removeClass('error');
			$('#imageValidation').html("");
		}else{
			imageValidation = 1;
			$('#imageValidation').addClass('error');
			$('#imageValidation').html("Please choose image");
		}
	}
}

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
		type: 'GET',
		url: $(this).attr('href'),
		dataType: 'json',
		success: function(data){
			$('#update_id').val(data.id);
			$('#name').val(data.name);
			$('#country_id').val(data.country_id).trigger('change');
			//$('#state_id').val(data.state_id);
			// $('#ex_image').val(data.ex_image);
			
			if(data.stud_image != ""){
				$('#previewImage').attr('src','uploads/' + data.stud_image);
			}else{
				$('#previewImage').attr('src', "");
			}
			
			if(data.gender == 'Male'){
				$('#gen1').attr('checked', true).click();
			}
			else{
				$('#gen2').attr('checked', true).click();
			}
		}
	});
	return false;
});

/*$('body').on('click','#excelbtn',function(){
	$.ajax({
		type: 'POST',
		url: 'excel_action.php',
		data: {
			search:$('#search').val()
		},
		success: function(data){
			$('#response').html(data);
		}
	});
});*/

</script>

</html>