<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$_SESSION['alert'] = [
	'message' => 'Error en el envío. Pongase en contacto con el equipo de soporte',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$nivel_org = $_POST['nivel_org'];
$enviada = $bd->updateEvaluaciones($nivel_org);
if ($enviada) {
	$_SESSION['alert'] = [
		'message' => 'Evaluaciones enviadas',
		'status' => 'success',
		'y' => 'top',
		'x' => 'right',
	];
}

header("location: /index.php");