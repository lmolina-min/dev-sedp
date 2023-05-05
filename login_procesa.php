<?php
session_start();
require_once('./acceso/conection.php');

$usuario = $_POST['usuario']; 
$clave = $_POST['clave']; 

if(isset($_POST['usuario']) && isset($_POST['clave'])){
    $field_usuario = $_POST['usuario'];
    $field_pass = ($_POST['clave']);
    $user = $bd->getLoginUsuario($field_usuario, $field_pass);
    if ($user) {
        echo $_SESSION["usuario"] = $user['login'];
		$_SESSION["nivel_org"] = $user['id_nivel_org'];
        $_SESSION["id_perfil"] = $user['id_perfil'];
		$_SESSION["evaluador"] = $user['evaluador'];
        header("location:" .$panel."principal.php");
    } else {
       header("location:" .$panel."login_error.php");
    }
}
?>