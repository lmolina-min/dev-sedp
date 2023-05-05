<?php

require_once('./acceso/conection.php');






//datos vehiculos
$nivel_org = $_POST['nivel_org'];

echo "</br> query:". $nivel_org ;
   
$update_Estutus = $bd->updateEvaluacionxGerencia($nivel_org);

 if ($update_Estutus ){
        session_start();
        $_SESSION['msj'] = 1; 
		header("location:" .$panel."principal.php");				   

  }
?>