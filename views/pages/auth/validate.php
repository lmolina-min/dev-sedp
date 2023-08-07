<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

unset($_SESSION["is_auth"]);

$_SESSION['alert'] = [
    'message' => 'Datos incorrectos. Intente nuevamente',
    'status' => 'danger',
    'y' => 'top',
    'x' => 'right',
];

if(isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $user = $bd->getUsuario($_POST['usuario'], ($_POST['contraseña']));
    
    if ($user) {
        $_SESSION["is_auth"] = true;
        $_SESSION["usuario"] = $user['login'];
		$_SESSION["nivel_org"] = $user['id_nivel_org'];
        $_SESSION["id_perfil"] = $user['id_perfil'];
		$_SESSION["evaluador"] = $user['evaluador'];
        $_SESSION['alert'] = [
            'message' => 'Bienvenido '.$_SESSION["usuario"],
            'status' => 'info',
            'y' => 'top',
            'x' => 'right',
        ];
        header("location: /index.php");
    }
    else {
        header("location: /login.php");
    }
}
else {
   header("location: /login.php");
}
?>