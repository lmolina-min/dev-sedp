<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/db/Database.php');

	// Base de datos del sistema
	$bd_servidor	= "localhost";
	$bd_nombre		= "sedp_dev";
	$bd_puerto		= "3306";
	$bd_usuario		= "root";
	$bd_clave		= "1234";
	$bd_tipo 		= "mysql";
	
	// Base de datos de niveles organizativos
	$bdn_nombre		= "sedp_dev_no";

	// Inicialización de las bases de datos
    $bd = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);
    $bdn = new Database($bd_tipo, $bd_servidor, $bdn_nombre, $bd_usuario, $bd_clave);
?>