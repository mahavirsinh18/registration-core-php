<?php
	include('config.php');

session_start();

if(isset($_SESSION) && !empty($_SESSION['user']))
{
	$user_id = $_SESSION['user']['id'];
	//echo $user_id;
	$sql_user = "SELECT * FROM `user` WHERE id='$user_id'";
	$res_user = mysqli_query($conn,$sql_user);
	$row_user = mysqli_fetch_assoc($res_user);
	//print_r($row_user);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="js/common.js?v=1"></script>

<style type="text/css">
.column{
	cursor: pointer;
}
.page-number{
	padding: 5px;
	margin: 3px;
}
.page-number.active{
	font-weight: bold;
	color: red;
	font-size: 20px;
}
.reqError{
	color: red;
}
.user_name{
	/*float: right;*/
	margin: 0 0 0 1100px;
}

</style>

<script type="text/javascript">
	function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

     /*function validate() {

            var returnValue;
            var emp_name=document.getElementById("emp_name").value;
            var salary=document.getElementById("salary").value;
            var uploadImage=document.getElementById("uploadImage").value;

 				// Image Extention validation
 			var extension = uploadImage.substr(uploadImage.lastIndexOf('.')+1).toLowerCase();
		    //alert(extension);
		    if(extension=='jpg' || extension=='jpeg' || extension=='gif' ) {
		       // return true;
		    } else {
		        document.getElementById("imageValidation").innerHTML="* Not Allowed Image Extension!.";
		        returnValue=false;
		    }

		    	//Charecter Validation 
            if(emp_name.trim()==""){
				document.getElementById("nameValidation").innerHTML="* Name is required.";
				returnValue=false;
			}
			if (!emp_name.match(/^[a-zA-Z]+$/)){
        		//alert('Only alphabets are allowed');
        	   document.getElementById("nameValidation").innerHTML="* Only alphabets are allowed.";
        	   returnValue=false;
        		//return false;
    		}

    			//number Validation
	    		if(salary.trim()==""){
				document.getElementById("salaryValidation").innerHTML="* Salary is required.";
				returnValue=false;
			}
			if (!salary.match(/^[0-9]+$/)){
        	   document.getElementById("salaryValidation").innerHTML="* Only Number are allowed.";
        	   returnValue=false;
        		//return false;
    		}

			return returnValue;
        }*/
</script>

<form class="employee-form" id="formData" enctype='multipart/form-data' >

	
	<div class="user_name">Welcome:- <b><?php echo $row_user['name']; ?>
		<a href="logout.php">Logout</a>
        <a href="changepassword.php">ChangePassword</a><br>
        <a href="edit_user_page.php">EditUserDetail</a>
	</div>
	<button type="button" class="add-new">Add New</button>
	
	<br><br>
	
		<input type="hidden" name="hidden_id" id="hidden_id" class="edit_id" value="0">

		Employye Name :: <input type="text" name="emp_name" id="emp_name" placeholder="Employee Name" onkeypress="characterKeyPress(event);">
		<span id="nameValidation" class="reqError"></span>
		<br><br>
		Employee Salary :: <input type="text" name="salary" id="salary" placeholder="Enter salary" onkeypress="isNumeric(event);">
		<span id="salaryValidation" class="reqError"></span>
		<br><br>
						<input type="hidden" name="temp_pic" id="temp_pic">
		Profile Pic :: <input type="file" name="profile" id="uploadImage" onchange="PreviewImage();">
		<span id="imageValidation" class="reqError"></span>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img id="uploadPreview" style="width: 100px; height: 100px;"/>
		<br><br> 

		<!-- <img id="uploadPreview" style="width: 100px; height: 100px;" /> -->
		<!-- <input id="uploadImage" type="file" name="myPhoto" onchange="PreviewImage();" /> -->

		<input type="button" name="submit" id="submit" class="submit" value="Submit">
</form>


<input type="text" class="search">
<input type="hidden" class="page" value="1">
<input type="hidden" class="orderby" value="id">
<input type="hidden" class="sortdir" value="desc">
<button type="button" class="search-button">Search</button>

<div class="list"> </div>
	
	<br>
	Upload excel file : 
    <input type="file" name="uploadFile" accept=".xls,.xlsx" value="" />
    <button type="button" name="btn_import" id="btn_import" value="Import">Import</button>


<script type="text/javascript">

		$('body').on('click','#btn_import',function(e){
	        e.preventDefault();
			var formData = new FormData($('#formData')[0]);
			// formData.append('image', $('input[type=file]')[0].files[0]); 
				$.ajax({
	                    url: 'import_action.php',
	                    type: "POST",
	                    data:  formData,
	                    contentType: false,
	                    cache: false,
	                    processData:false,
	                    success: function(data){
	                    	listdata();

	                    	//document.getElementById("formData").reset();
	                    	//listdata();
	                    	//$('#name').val('');
	                        // $('#uploadPreview').attr('src',"");
	                    },
	                    //error: function(){}             
                });
		});

	$('#submit').click(function(){
		homeValidation();		
	});

	function homeValidation(){
		var emp_name = $('#emp_name').val();
		var nameValidation = 0;

		var hidden_id = $('#hidden_id').val()
			
		var profile = $('#uploadImage').val();
		var imageValidation = 0;
		
		var salary  = $('#salary').val();
		var salaryValidation = 0;

		if($.trim(emp_name).length > 0){
		if(characterCheck(emp_name)){
			$('#nameValidation').removeClass('not-valid');
			$('#nameValidation').html("");
			nameValidation = 0;
		}else{
			$('#nameValidation').addClass('not-valid');
			$('#nameValidation').html("* Name is Invalid");	
			nameValidation = 1;
			}
		}else{
			$('#nameValidation').addClass('not-valid');
			$('#nameValidation').html("* Name is required");
			nameValidation = 1;
		}


		if($.trim(salary).length > 0){
			if(numberCheck(salary)){
				salaryValidation = 0;
				$('#salaryValidation').removeClass('not-valid');
				$('#salaryValidation').html("");
			}else{
				salaryValidation = 1;
				$('#salaryValidation').addClass('not-valid');
				$('#salaryValidation').html("* Salary is Invalid");	
				}
			}else{
				salaryValidation = 1;
				$('#salaryValidation').addClass('not-valid');
				$('#salaryValidation').html("* Salary is required");
			}

		
		if(hidden_id == 0)
		{
			//alert(hidden_id);
			if($.trim(profile).length > 0){
			if(imageChack(profile)){
				//alert("hello");
				imageValidation = 0;
				$('#imageValidation').removeClass('not-valid');
				$('#imageValidation').html("");
			}else{
				imageValidation = 1;
				$('#imageValidation').addClass('not-valid');
				$('#imageValidation').html("* Image is Invalid");	
			}
			$('#imageValidation').removeClass('not-valid');
				$('#imageValidation').html("");
			}else{
				imageValidation = 1;
				$('#imageValidation').addClass('not-valid');
				$('#imageValidation').html("* Image is required");
			}
		}	
	

	}

	
	function listdata()
	{
		search = $('.search').val();
		page = $('.page').val();
		orderby = $('.orderby').val();
		sortdir = $('.sortdir').val();
				//alert(id);
    	$.ajax({
        	type:'POST',
        	url: "listdata.php",
        	data: {search:search,
        		   page:page,
        		   orderby:orderby,
        		   sortdir:sortdir
        		  },
        	success:function(data){
        		$('.list').html(data);
        	}
    	});
	}

	$('.search-button').click(function(){
		$('.page').val(1);
		listdata();
	})

	// $('.column').click(function(){
	$('body').on('click','.column',function(){
		$('.orderby').val($(this).attr('data-name'));
		$('.sortdir').val($(this).attr('data-dir'));
		listdata();
	})

	$('body').on('click','.page-number',function(){
		$('.page').val($(this).html());
		
		listdata();
		return false;

	})

	$('.add-new').click(function(){
		$('#emp_name').val("");
		$('#salary').val("");
		$('#uploadPreview').attr('src',"");
		$('.edit_id').val(0);
	})


	$('body').on('click','.edit-link',function(){
		
		$.ajax({
        	type:'GET',
        	url: $(this).attr('href'),
        	dataType:'json',
        	success:function(data){
        		console.log(data);

        		$('#emp_name').val(data.emp_name);
        		$('#salary').val(data.salary);
        		$('#temp_pic').val(data.temp_pic);
        		if(data.profile != "")
        		$('#uploadPreview').attr('src',data.profile);
        		else
        		$('#uploadPreview').attr('src',"");
        		$('.edit_id').val(data.id);

        	}
    	});
		return false;

	})



	$('body').on('click','.delete-link',function(){
		if (confirm("Are you sure?")) {
        	// your deletion code

		var id = $(this).attr("data-id");
				//alert(id);
            	$.ajax({
		        	type:'POST',
		        	url: "delete.php",
		        	data: {'id':id},
		        	//dataType: ''json;
		        	success:function(data){
		        		listdata();
		        	}
		    	});
		    	return false;
    	}
    return false;	

	})

	
	// $("#submit").click(function(){
			
	// 		/*var hidden_id = $("#hidden_id").val();
	// 		var name = $("#name").val();
	// 		var salary = $("#salary").val();
	// 		var profile = $("#uploadImage").val();*/
	// 		var fd = new FormData();
	// 		var files = $('#uploadImage')[0].files[0];
	// 		alert(files);
	// 		fd.append('file',files);
			
	// 		alert(files);
	// 		/*var formData = $('#formData')[0];
	// 		var form = new FormData(formData);*/
	// 		$.ajax({
	// 			url:"emp_action.php",
	// 			type:"POST",
	// 			data:fd,
				
	// 			success:function(data){
	// 				//displyData();
	// 			/*	$('#name').val('');
	// 				$('#hidden_id').val('');*/
	// 			}
	// 		}) 
	// 	});

		$('body').on('click','#submit',function(e){
	        e.preventDefault();
			var formData = new FormData($('#formData')[0]);
			// formData.append('image', $('input[type=file]')[0].files[0]); 
				$.ajax({
	                    url: 'emp_action.php',
	                    type: "POST",
	                    data:  formData,
	                    contentType: false,
	                    cache: false,
	                    processData:false,
	                    success: function(data){
	                    	document.getElementById("formData").reset();
	                    	listdata();
	                    	//$('#name').val('');
	                         $('#uploadPreview').attr('src',"");
	                    },
	                    //error: function(){}             
                });
		});


	$(document).ready(function(){
		listdata();
	})

</script>

<?php
}
else
{
	header('location:login.php');
}
?>