<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');
$nivel_org = $_POST['nivel_org'];
$update_estutus = $bd->updateEvaluacionxGerencia($nivel_org);

session_start();
if ($update_estutus) {
  $_SESSION['alert'] = [
    'message' => 'Evaluaciones aprobadas correctamente',
    'status' => 'success',
    'y' => 'top',
    'x' => 'right',
  ];
}
else {
  $_SESSION['alert'] = [
    'message' => 'Error al aprobar las evaluaciones',
    'status' => 'danger',
    'y' => 'top',
    'x' => 'right',
  ];
}

header('location: /index.php');
?>