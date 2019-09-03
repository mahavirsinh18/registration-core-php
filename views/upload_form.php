<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php echo $error; ?>

<?php echo form_open_multipart('upload/do_upload'); ?>

<form>
<input type="file" name="userfile" size="20">

<br><br>

<input type="submit" name="" value="upload">
</form>

</body>
</html>