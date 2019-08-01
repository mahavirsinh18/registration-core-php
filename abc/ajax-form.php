<?php

/*$conn = mysqli_connect("localhost","root","root");
$db = mysqli_select_db("login",$conn);*/

include "function.php";

$errorMsg = [];
$OldValue = [];

$OldValue = $_POST;
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$college = $_POST['college'];

$isValid = true;

if($name = ""){
	$errorMsg['name'] = "*Please enter your name";
	$isValid = false;
}

if($email = ""){
	$errorMsg['email'] = "*Please enter your email";
	$isValid = false;
}

if($contact = ""){
	$errorMsg['contact'] = "*Please enter your contact";
	$isValid = false;
}

if($college = ""){
	$errorMsg['college'] = "*Please enter your college";
	$isValid = false;
}

/*if($isValid == true){
	
	if(!mysqli_query($conn,$query)){
		echo "";
	}else{
		$OldValue = [];
	}
}
print_r($errorMsg);*/

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

<form action="" method="post" id="sub" name="sub">
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" value="<?php echo isset($OldValue['name']) ?  $OldValue['name'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email" id="email" value="<?php echo isset($OldValue['email']) ?  $OldValue['email'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>Contact:</td>
			<td><input type="text" name="contact" id="contact" value="<?php echo isset($OldValue['contact']) ?  $OldValue['contact'] : ""; ?>"></td>
		</tr>
		<tr>
			<td>College:</td>
			<td><input type="text" name="college" id="college" value="<?php echo isset($OldValue['college']) ?  $OldValue['college'] : ""; ?>"></td>
		</tr>
		<tr>
			<td><button type="button" name="submit" id="submit">Submit</button></td>
		</tr>
	</table>
	<div id="area"></div>
</form>

</body>

<script type="text/javascript">
	$("#submit").click(function(e){
		/*var str = $("#sub").serialize();*/

		var name = $("#name").val();
		var email = $("#email").val();
		var contact = $("#contact").val();
		var college = $("#college").val();

		console.log(name, email, contact, college);

		var data1 = 'name='+ name + '&email='+ email + '&contact='+ contact + '&college='+ college;
		if(name==''||email==''||contact==''||college==''){
			alert("Please enter the given fields");
		}else{
			$.ajax({
				type:"post",
				url:"ajax1.php?action=pdata",
				data:data1,
				success:function(result){
					alert(result);
				}
			});
		}
	});

		/*var data = {
			name:name,
			email:email,
			contact:contact,
			college:college
		};*/

		//console.log(str);
		//console.log(data);
</script>

</html>