<?php
session_start();
if ($_GET["d"] == 100 || $_GET["d"] == 7) {
    $title = "Detalles de Gerencia - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/details/_gerencia.php';
    include('views/layouts/main_layout.php');
} 
elseif ($_GET["d"] == 2) {
    $title = "Detalles de División - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/details/_division.php';
    include('views/layouts/main_layout.php');
}
elseif ($_GET["d"] == 3) {
    $title = "Detalles de Departamento- Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/details/_departamento.php';
    include('views/layouts/main_layout.php');
}
elseif ($_GET["d"] == 4) {
    $title = "Detalles de Coordinación - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/details/_coordinacion.php';
    include('views/layouts/main_layout.php');
}
elseif ($_GET["d"] == 6) {
    $title = "Detalles de Gerencias Operativas - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/details/_ger_operativas.php';
    include('views/layouts/main_layout.php');
}
?>