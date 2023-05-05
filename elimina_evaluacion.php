<?php
session_start();
require_once('./acceso/conection.php');

$id_eval   = $_GET['id_eval'];
// id_eval_emp 	id_item_factor 	
$sql = "DELETE FROM se_eval_item_factor WHERE id_eval_emp = ". $id_eval ."";
$EliminarEvaluacion = $bd->deleteEvaluacion($sql);
if ($EliminarEvaluacion){
	$sql = "DELETE FROM se_evaluacion WHERE id_eval = ". $id_eval ."";
	$EliminarEvaluacion = $bd->deleteEvaluacion($sql);
	if ($EliminarEvaluacion){
		session_start();
		$_SESSION['msj']= 3;
     	header("location:" .$panel."formato_evaluacion.php");
    } else {
       echo "hola";
		header("location:" .$panel."formato_evaluacion.php");
    }
}
?>