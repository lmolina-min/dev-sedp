<?php
session_start();
if ($_GET["d"] == 1) {
    $title = "Detalles de Gerencia - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/detalles/_gerencia.php';
    include('layouts/MainLayout.php');
} 
elseif ($_GET["d"] == 2) {
    $title = "Detalles de División - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/detalles/_division.php';
    include('layouts/MainLayout.php');
}
elseif ($_GET["d"] == 3) {
    $title = "Detalles de Departamento - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/detalles/_departamento.php';
    include('layouts/MainLayout.php');
}
elseif ($_GET["d"] == 4) {
    $title = "Detalles de Coordinación - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/detalles/_coordinacion.php';
    include('layouts/MainLayout.php');
}
?>