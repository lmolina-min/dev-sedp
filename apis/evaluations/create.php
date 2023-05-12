<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

//datos vehiculos
$select_empleado   = explode('|',$_POST['empleado']);

$id_empleado  = $select_empleado[0];

$item_valor   = explode('|',$_POST['customRadio1']);
$item1 = $item_valor[1];
$valor1 = $item_valor[0];

$item_valor   = explode('|',$_POST['customRadio2']);
$item2 = $item_valor[1];
$valor2 = $item_valor[0];

$item_valor   = explode('|',$_POST['customRadio3']);
$item3 = $item_valor[1];
$valor3 = $item_valor[0];

$item_valor   = explode('|',$_POST['customRadio4']);
$item4 = $item_valor[1];
$valor4 = $item_valor[0];

$item_valor   = explode('|',$_POST['customRadio5']);
$item5 = $item_valor[1];
$valor5 = $item_valor[0];

// echo "Id_empleado:  ".$id_empleado."</br>";
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

// $fecha = date("Y-m-d H:i:s");
$estatus = 1;
$puntaje = $valor1+$valor2+$valor3+$valor4+$valor5;	

$data_eval = array(           
	'puntaje' => $puntaje,
    'estatus' => $estatus,
    'id_empleado' => $id_empleado,
);

session_start();
$_SESSION['alert'] = [
	'message' => 'No se pudo registrar la evaluación',
	'status' => 'danger',
	'y' => 'top',
	'x' => 'right',
];

$id_eval = $bd->insertEvaluacion($data_eval);
if ($id_eval) {
	$sql = "insert into se_eval_item_factor (id_eval_emp, id_item_factor) values (".$id_eval.",".$item1."),(".$id_eval.",".$item2."),(".$id_eval.",".$item3."),(".$id_eval.",".$item4."),(".$id_eval.",".$item5.")";
	$id_emp_eval = $bd->insertEmp_EvalItem($sql);
	if ($id_emp_eval) {
		$_SESSION['alert'] = [
			'message' => 'Evaluación registrada correctamente',
			'status' => 'success',
			'y' => 'top',
			'x' => 'right',
		];
	}
	
}

header("location: /evaluaciones.php?page=formato");
