<?php
    require_once('./acceso/conection.php');
    session_destroy();
     header("location:" .$panel."login.php");
?>