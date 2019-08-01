<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	<form method="post">
		Enter the year:
		<input type="text" name="year">
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>

<?php

if($_POST){
	$year = $_POST['year'];
	if(!is_numeric($year)){
		echo "Only numbers allowed";
		return;
	}
	if((0==$year%4) and (0!=$year%100) or (0==$year%400)){
		echo "$year is a leap year";
	}else{
		echo "$year is not a leap year";
	}
}

?>