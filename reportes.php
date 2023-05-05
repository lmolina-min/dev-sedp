<?php
session_start();
echo $_SESSION["id_perfil"];
    if ($_SESSION["id_perfil"] == 7) {
        header("location:" .$panel."reportes_th.php");
    } else {
       header("location:" .$panel."reportes_ger.php");
    }

?>