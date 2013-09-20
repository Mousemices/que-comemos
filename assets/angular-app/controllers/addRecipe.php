<?php

	$data = file_get_contents("php://input");
	$file = "../json/recetas.json"; 
	
	//todo esto para borrar el ] del json y poder meter luego el contenido del forlario:
	$fh = fopen($file, 'r+') or die("can't open file");
	$stat = fstat($fh);
	ftruncate($fh, $stat['size']-1);
	fclose($fh); 
	
	//escribe el $_post del formulario en el fichero, al final del mismo.
	$id = intval($_POST['lastRecipeId'] + 1);
	
	$formatedData = ",";
	$formatedData .= "{";
	$formatedData .= "\"id\": " . $id . "," ;
	$formatedData .= "\"name\": \"" . $_POST['name'] . "\"," ;
	$formatedData .= "\"tag\": \"" . $_POST['tag'] . "\"," ;
	$formatedData .= "\"ingredients\": \"" . $_POST['ingredients'] . "\"" ;
	$formatedData .= "}";
	$formatedData .= "]";
	
	file_put_contents($file, $formatedData, FILE_APPEND | LOCK_EX);
	
	header("Location: ../../../");
	

?>