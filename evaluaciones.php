<?php
session_start();
if (!isset($_SESSION["autenticado"])) {
    session_destroy();
    header("location: /login.php");
}
elseif (!isset($_GET["page"])) {
    $title = "Evaluaciones - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/evaluaciones/_index.php';
    include('layouts/MainLayout.php');
} 
elseif ($_GET["page"] == "editar") {
    $title = "Editar evaluación - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/evaluaciones/_edit.php';
    include('layouts/MainLayout.php');
}
elseif ($_GET["page"] == "aprobar") {
    $title = "Aprobar evaluaciones - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/evaluaciones/_aprove.php';
    include('layouts/MainLayout.php');
}
?>