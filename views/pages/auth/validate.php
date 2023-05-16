<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

if(isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $user = $bd->getLoginUsuario($_POST['usuario'], ($_POST['contraseña']));
    
    session_start();
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
        unset($_SESSION["is_auth"]);
        $_SESSION['alert'] = [
            'message' => 'Datos incorrectos. Intente nuevamente',
            'status' => 'danger',
            'y' => 'top',
            'x' => 'left',
        ];
       header("location: /login.php");
    }
}
?>