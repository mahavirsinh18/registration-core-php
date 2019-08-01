<?php

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

function getcity1($param){
	echo "<option value='1'>asd<option><option value='2'>sfsdf<option><option value='3'>xcvxcv<option><option value='4'>vxcv<option>";
	exit;
}
?>