<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

$nivel_org = $_POST['nivel_org'];

if (!isset($_POST['nivel_org'])) {  
    $_SESSION['alert'] = [
        'message' => 'Debe selecionar una gerencia',
        'status' => 'danger',
        'y' => 'top',
        'x' => 'right',
    ];
}

header('location: /reportes.php?nor='.$nivel_org);
?>