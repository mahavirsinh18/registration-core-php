<?php

function triangle($n){
	$k = 2 * $n - 2;
	for($i = 0; $i < $n; $i++){
		for($j = 0; $j < $k; $j++)
			echo "&nbsp";
		$k = $k - 1;
		for($j = 0; $j <= $i; $j++){
			echo " *";
		}
		echo "<br>";
	}
}
$n = 5;
triangle($n);

/*for ($i=1; $i<=5; $i++) 	       
{ 	 
for ($k=5; $k>$i; $k--)	 
{	  ;
echo " &nbsp";	  
}	
for($j=1;$j<=$i;$j++)	  
{	  	
echo "* ";	  
}	  	
echo "<br/>";	
}*/

?>