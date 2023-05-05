<?php
    include_once 'config/core.php';
    $bd = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);
    $bdn = new Database($bd_tipo, $bd_servidor, $bdn_nombre, $bd_usuario, $bd_clave); //conexion para bd nivel organizativo
?>
