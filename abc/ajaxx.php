<?php
include "function.php";

$action = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}

switch ($action) {
	case 'getcity':
	    getcity($_REQUEST);
		break;
	default:
		# code...
		break;
}

function getcity($param){
	echo "<option value='".$city['id']."'>".$city['city_name']."</option>";
	exit;
}
?>