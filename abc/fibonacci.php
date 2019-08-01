<?php

$count = 0;
$x = 0;
$y = 1;

echo $x.",";
echo $y.",";

while($count < 10){
	$z = $y + $x;
	echo $z.",";

	$x = $y;
	$y = $z;
	$count = $count + 1;
}

?>