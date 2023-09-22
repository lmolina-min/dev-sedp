<?php
session_start();
if (!isset($_SESSION["autenticado"])) {
    session_destroy();
    header("location: /login.php");
}
elseif ($_GET["page"] == "perfil") {
    $title = "Perfil - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/usuario/_perfil.php';
    include('layouts/MainLayout.php');
} 
elseif ($_GET["page"] == "opciones") {
    $title = "Opciones - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/usuario/_opciones.php';
    include('layouts/MainLayout.php');
}
?>