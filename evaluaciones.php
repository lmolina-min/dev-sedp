<?php
session_start();
if ($_GET["page"] == "formato") {
    $title = "Formato de evaluación - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/pages/evaluations/_format.php';
    include('views/layouts/main_layout.php');
} 
elseif ($_GET["page"] == "editar") {
    $title = "Editar evaluación - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/pages/evaluations/_edit.php';
    include('views/layouts/main_layout.php');
}
elseif ($_GET["page"] == "aprobar") {
    $title = "Aprobar evaluaciones - Sistema de Evaluación de Desempeño";
    $mainContent = $_SERVER['DOCUMENT_ROOT'].'/views/pages/evaluations/_aprove.php';
    include('views/layouts/main_layout.php');
}
?>