<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$id_empleados   = $_POST['id_empleados'];
$nombre         = $_POST['nombre'];
$apellido       = $_POST['apellido'];
$cedula         = $_POST['cedula'];

$data = array(
                'id_empleados'    => $id_empleados,
                'cedula'          => $cedula,
                'nombre'          => $nombre,
                'apellido'        => $apellido 
            );

$update_Empleados = $bd->updateDatosEmpleados($data);

 if ($update_Empleados){
     header("location:" .$panel."empleados_crear.php");
    } else {
       header("location:" .$panel."empleados_editar.php");
    }
?>