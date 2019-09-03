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

<?php
foreach($data as $row)
{
?>
<div class="container">
<form action="" method="post" class="form-horizontal">
	<div class="form-group">
		Name: <input type="text" name="name" class="form-control w-25" value="<?php echo $row->name ?>">
	</div>
	
	Gender:
	<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" name="gender" value="Male" class="custom-control-input" id="customRadio1" <?php echo ($row->gender == 'Male') ? 'checked' : ''; ?> >
		<label class="custom-control-label" for="customRadio1">Male</label>
	</div>
	<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" name="gender" value="Female" class="custom-control-input" id="customRadio2" <?php echo ($row->gender == 'Female') ? 'checked' : ''; ?> >
		<label class="custom-control-label" for="customRadio2">Female</label>
	</div>
	<br><br>
	<!-- <?php 
		$cities = array("Bhavnagar", "Ahmedabad", "Vadodara", "Surat");
	?>
	<select name="city" class="custom-select w-25">
		<option>Select city</option>
		<?php
		foreach($cities as $city){
			if($row->city == $city){
			?>
			<option value="<?php echo $city; ?>" selected=""><?php echo $city; ?></option>
			<?php
			}
			else
			{
			?>
			<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
			<?php	
			}

		}

		?>
	</select> -->
	<select name="city" class="custom-select w-25">
		<option value="">Select city</option>
		<option value="Bhavnagar" <?php echo ($row->city == 'Bhavnagar') ? 'selected' : ''; ?> >Bhavnagar</option>
		<option value="Ahmedabad" <?php echo ($row->city == 'Ahmedabad') ? 'selected' : ''; ?> >Ahmedabad</option>
		<option value="Vadodara" <?php echo ($row->city == 'Vadodara') ? 'selected' : ''; ?> >Vadodara</option>
		<option value="Surat" <?php echo ($row->city == 'Surat') ? 'selected' : ''; ?> >Surat</option>
	</select>
	<br><br>

	<div class="form-group">
		Contact: <input type="text" name="contact" class="form-control w-25" value="<?php echo $row->contact ?>">
	</div>

	<div class="form-group">
		E-mail: <input type="text" name="email" class="form-control w-25" value="<?php echo $row->email; ?>">
	</div>

	<div class="form-group">
		Password: <input type="text" name="password" class="form-control w-25" value="<?php echo $row->password ?>">
	</div>

	<button type="submit" name="update" value="1" class="btn btn-outline-primary">Update</button>
</form>
</div>
<?php
}
?>

</body>
</html>