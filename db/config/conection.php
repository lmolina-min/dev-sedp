<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/db/config/core.php');
    $bd = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);
    $bdn = new Database($bd_tipo, $bd_servidor, $bdn_nombre, $bd_usuario, $bd_clave);
?>
