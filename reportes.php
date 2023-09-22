<?php
session_start();
if (!isset($_SESSION["autenticado"])) {
    session_destroy();
    header("location: /login.php");
}
elseif (!isset($_GET["page"])) {
    $title = "Resumen en lista - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/reportes/_lista.php';
    include('layouts/MainLayout.php');
}
elseif ($_GET["page"] == 'grafico') {
    $title = "Resumen en gráfico - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/reportes/_grafico.php';
    include('layouts/MainLayout.php');
}
?>