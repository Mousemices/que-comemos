<?php 
	
	$data = file_get_contents("php://input");
 
	$objData = json_decode($data, true);
	
	$file = "../json/recetaSemanal.json"; 
	$fh = fopen($file, 'w') or die("can't open file");
	fwrite($fh, json_encode($objData));
	fclose($fh);

?>