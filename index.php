<?php
    session_start();
    if (!isset($_SESSION["is_auth"])) {
        session_destroy();
        header("location: /login.php");
    }
    else {
        $title = "Inicio - Sistema de Evaluación de Desempeño";
        $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/_index.php';
        include($_SERVER['DOCUMENT_ROOT'].'/views/layouts/main_layout.php');
    }
?>
