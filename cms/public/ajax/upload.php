<?php
if(isset($_FILES["file"]["name"]))
{
	if(!$_FILES["file"]["error"])
	{
		$titulo = md5(rand(100, 200));
		$extension = explode(".", $_FILES["file"]["name"]);
		$archivo = $titulo . "." . $extension[1];
		$destino = '../img/temp/blog/'.$archivo;
		$origen = $_FILES["file"]["tmp_name"];
		move_uploaded_file($origen, $destino);
		echo $_POST["ruta"]."/img/temp/blog/".$archivo;
	}
	else
	{
		echo "Error: El archivo temporal no se pudo crear:" . $_FILES["file"]["error"];
	}
}