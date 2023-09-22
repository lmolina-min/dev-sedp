<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$item_valor   = explode('|', $_POST['customRadio1']);
$item1 = $item_valor[1];
$valor1 = $item_valor[0];

$item_valor   = explode('|', $_POST['customRadio2']);
$item2 = $item_valor[1];
$valor2 = $item_valor[0];

$item_valor   = explode('|', $_POST['customRadio3']);
$item3 = $item_valor[1];
$valor3 = $item_valor[0];

$item_valor   = explode('|', $_POST['customRadio4']);
$item4 = $item_valor[1];
$valor4 = $item_valor[0];

$item_valor   = explode('|', $_POST['customRadio5']);
$item5 = $item_valor[1];
$valor5 = $item_valor[0];


session_start();
$_SESSION['alert'] = [
	'message' => 'No se pudo editar la evaluación',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$id_evaluacion = $_POST['id_evaluacion'];
$borrada = $bd->deleteEvaluacionCalificacion($id_evaluacion);

if ($borrada) {	
	$creada = $bd->insertEvaluacionCalificacion($id_evaluacion, $item1, $item2, $item3, $item4, $item5);

	if ($creada) {		
		$puntaje = $valor1 + $valor2 + $valor3 + $valor4 + $valor5;
		$actualizada = $bd->updateEvaluacion($puntaje, $id_evaluacion);
		
		if (($actualizada)) {
			$_SESSION['alert'] = [
				'message' => 'Evaluación editada correctamente',
				'status' => 'success',
				'y' => 'top',
				'x' => 'right',
			];
		}
	}
}
header("location: /evaluaciones.php");
?>