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

// echo "item:  ".$item1;
// echo " valor: ".$valor1."</br>";
// echo "item:  ".$item2;
// echo " valor: ".$valor2."</br>";
// echo "item:  ".$item3;
// echo " valor: ".$valor3."</br>";
// echo "item:  ".$item4;
// echo " valor: ".$valor4."</br>";
// echo "item:  ".$item5;
// echo "valor: ".$valor5."</br>";

session_start();
$_SESSION['alert'] = [
	'message' => 'No se pudo editar la evaluación',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$id_eval = $_POST['id_eval'];
$del_eval_item_factor = $bd->deleteEval_Item_Factor($id_eval);
if ($del_eval_item_factor) {
	$sql = "INSERT INTO se_eval_item_factor (id_eval_emp, id_item_factor) VALUES (" . $id_eval . "," . $item1 . "),(" . $id_eval . "," . $item2 . "),(" . $id_eval . "," . $item3 . "),(" . $id_eval . "," . $item4 . "),(" . $id_eval . "," . $item5 . ")";
	$id_emp_eval = $bd->insertEmp_EvalItem($sql);

	if ($id_emp_eval) {		
		$puntaje = $valor1 + $valor2 + $valor3 + $valor4 + $valor5;
		$update_evaluation = $bd->updateEvaluacion($puntaje, $id_eval);

		if (isset($update_evaluation)) {
			$_SESSION['alert'] = [
				'message' => 'Evaluación editada correctamente',
				'status' => 'success',
				'y' => 'top',
				'x' => 'right',
			];
		}
	}
}
header("location: /evaluaciones.php?page=formato");
?>>