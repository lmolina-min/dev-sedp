<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');
    session_start();
    session_destroy();
    header("location: /login.php");
?>