<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

session_start();
$_SESSION['alert'] = [
	'message' => 'No se pudo eliminar la evaluación',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$id_eval = $_GET['id_eval'];
$del_eval_item_factor = $bd->deleteEval_Item_Factor($id_eval);
if ($del_eval_item_factor) {
	$del_evaluation = $bd->deleteEvaluacion($id_eval);
	if ($del_evaluation) {
		$_SESSION['alert'] = [
			'message' => 'Evaluación eliminada correctamente',
			'status' => 'success',
			'y' => 'top',
			'x' => 'right',
		];
	}
}

header("location: /evaluaciones.php?page=formato");