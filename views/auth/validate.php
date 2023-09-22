<?php
session_destroy();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');


$_SESSION['alert'] = [
    'message' => 'Datos incorrectos. Intente nuevamente',
    'status' => 'danger',
    'y' => 'top',
    'x' => 'right',
];

if(isset($_POST['ingresar'])) {
    $usuario    = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $data = $bd->getUsuario($usuario);
    
    if (password_verify($contraseña, $data['clave'])) {
        $_SESSION['autenticado'] = true;
        $_SESSION['usuario']     = $data['usuario'];
        $_SESSION['rol']         = $data['rol'];
		$_SESSION['foto_perfil'] = $data['foto'] ?? null;
		$_SESSION['nivel_org']   = $data['nivel_org'] ?? null;
        $_SESSION['empleado']    = $data['empleado']  ?? null;
		$_SESSION['evaluador']   = $data['evaluador'] ?? null;
       
        if ($data["estado"] != 1) {
            $_SESSION['alert'] = [
                'message' => 'Usuario bloqueado. Consulte al equipo de soporte',
                'status'  => 'warning',
                'y'       => 'top',
                'x'       => 'right',
            ];
            header("location: /login.php");
        }
        else {
            $proceso = $bd->getProcesoActivo();

            if ($proceso) {
                $_SESSION['proceso']        = $proceso['id'];
                $_SESSION['p_estado']       = $proceso['estado'];
                $data = [
                    'id_usuario' => $data['id'],
                    'ip'         => $_SERVER['REMOTE_ADDR'],
                    'navegador'  => getNombreNavegador($_SERVER['HTTP_USER_AGENT'])
                ];
    
                $conexion = $bd->insertConexion($data, false);
                if ($conexion) {
                    $_SESSION["id_conexion"] = $conexion;
                    
                    $_SESSION['alert'] = [
                        'message' => 'Bienvenido '.$_SESSION["usuario"],
                        'status' => 'primary',
                        'y' => 'top',
                        'x' => 'right',
                    ];
                    header("location: /index.php");	 
                }
            }
        }
    }
    else {
        header("location: /login.php");
    }
}
else {
   header("location: /login.php");
}

function getNombreNavegador($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

    return 'Other';
}
?>