<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$id        = $_POST['id'];
$clave     = $_POST['clave'];
$clave_rep = $_POST['clave_rep'];


session_start();
if ($clave == $clave_rep) {
    $clave = password_hash($clave, PASSWORD_BCRYPT);
    $actualizada = $bd->updateClave($id, $clave);

    if ($actualizada) {
        $_SESSION['alert'] = [
          'message' => 'Contraseña cambiada correctamente',
          'status' => 'success',
          'y' => 'top',
          'x' => 'right',
        ];
    }
    else {
        $_SESSION['alert'] = [
            'message' => 'Error al cambiar de contraseña',
            'status' => 'danger',
            'y' => 'top',
            'x' => 'right',
        ];
    }    
}
else {
    $_SESSION['alert'] = [
        'message' => 'Las contraseñas no coinciden',
        'status' => 'danger',
        'y' => 'top',
        'x' => 'right',
    ];
}

header('location: /usuario.php?page=perfil');
?>