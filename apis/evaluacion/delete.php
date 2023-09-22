<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

session_start();
$_SESSION['alert'] = [
	'message' => 'No se pudo eliminar la evaluación',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$id_evaluacion = $_GET['id_evaluacion'];
$del_eval_calif = $bd->deleteEvaluacionCalificacion($id_evaluacion);
if ($del_eval_calif) {
	$del_evaluacion = $bd->deleteEvaluacion($id_evaluacion);
	if ($del_evaluacion) {
		$_SESSION['alert'] = [
			'message' => 'Evaluación eliminada correctamente',
			'status' => 'success',
			'y' => 'top',
			'x' => 'right',
		];
	}
}

header("location: /evaluaciones.php");