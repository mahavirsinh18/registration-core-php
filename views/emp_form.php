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
<form action="" method="post" class="form-horizontal">
	<div class="form-group">
		Name: <input type="text" name="name" class="form-control w-25">
		<?php echo form_error('name'); ?>
	</div>
	
	Gender:
	<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" name="gender" value="Male" class="custom-control-input" id="customRadio1">
		<label class="custom-control-label" for="customRadio1">Male</label>
	</div>
	<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" name="gender" value="Female" class="custom-control-input" id="customRadio2">
		<label class="custom-control-label" for="customRadio2">Female</label>
	</div>
	<?php echo form_error('gender'); ?>
	<br><br>

	<select name="city" class="custom-select w-25">
		<option>Select city</option>
		<option value="Bhavnagar">Bhavnagar</option>
		<option value="Ahmedabad">Ahmedabad</option>
		<option value="Vadodara">Vadodara</option>
		<option value="Surat">Surat</option>
	</select>
	<?php echo form_error('city'); ?>
	<br><br>

	<div class="form-group">
		Contact: <input type="text" name="contact" class="form-control w-25">
		<?php echo form_error('contact'); ?>
	</div>

	<div class="form-group">
		E-mail: <input type="text" name="email" class="form-control w-25">
		<?php echo form_error('email'); ?>
	</div>

	<div class="form-group">
		Password: <input type="text" name="password" class="form-control w-25">
		<?php echo form_error('password'); ?>
	</div>

	<button type="submit" class="btn btn-outline-primary">Submit</button>
</form>
</div>

</body>
</html>