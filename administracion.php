<?php
session_start();
if (!isset($_SESSION["autenticado"])) {
    session_destroy();
    header("location: /login.php");
}
elseif ($_GET["page"] == "procesos") {
    $title = "Administracion de procesos - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/administracion/_procesos.php';
    include('layouts/MainLayout.php');
} 
elseif ($_GET["page"] == "aspectos") {
    $title = "Administracion de aspectos - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/administracion/_aspectos.php';
    include('layouts/MainLayout.php');
}
elseif ($_GET["page"] == "usuarios") {
    $title = "Administracion de usuarios - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/administracion/_usuarios.php';
    include('layouts/MainLayout.php');
}
?>