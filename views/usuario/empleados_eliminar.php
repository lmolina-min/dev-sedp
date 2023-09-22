<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$id_empleados   = $_GET['id'];

$EliminarEmpleado = $bd->deleteEmpleados($id_empleados);

if ($EliminarEmpleado){
     header("location:" .$panel."empleados_crear.php");
    } else {
       header("location:" .$panel."empleados_crear.php");
    }
?>