<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$nombre         = $_POST['nombre'];
$apellido       = $_POST['apellido'];
$cedula         = $_POST['cedula'];

$data = array(
                'nombre'          => $nombre,
                'apellido'        => $apellido,
                'cedula'          => $cedula
            );

$insert_Empleados = $bd->insertEmpleados($data);

 if ($insert_Empleados){
     header("location:" .$panel."empleados_crear.php");
    } else {
       header("location:" .$panel."empleados_crear.php");
    }
?>