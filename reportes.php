<?php
session_start();
if ($_SESSION["id_perfil"] == 7) {
    $title = "Reportes Talento Humano - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/reports/_talento_humano.php';
    include('views/layouts/main_layout.php');
} 
else {
    $title = "Reportes Gerenciales - Sistema de Evaluación de Desempeño";
    $mainContent = 'views/pages/reports/_gerencial.php';
    include('views/layouts/main_layout.php');
}
?>