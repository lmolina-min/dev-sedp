<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$_SESSION['alert'] = [
  'message' => 'Error al aprobar las evaluaciones',
  'status' => 'danger',
  'y' => 'top',
  'x' => 'right',
];
$id_proceso = $_GET['id'];

try {  
  $update_proceso = $bd->updateProceso($id_proceso);

  if (!$update_proceso) {
    throw 'Error al actualizar el proceso';
  }
  $_SESSION['alert'] = [
    'message' => 'Proceso actualizado correctamente',
    'status' => 'success',
    'y' => 'top',
    'x' => 'right',
  ];
  header('location: /administracion.php?page=procesos');

}
catch (\Throwable $th) {
  echo $th;
}
?>