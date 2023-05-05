<?php 
	session_start();
  require_once 'acceso/conection.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/favicon/favicon.ico">
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <title><?php echo $title ?></title>

    <!-- Styles -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <style>
      .tooltip-custom .tooltip-inner {
        background-color: #008584 !important;
        max-width:100%;
      }

      .bs-tooltip-top .arrow::before,
      .bs-tooltip-auto[x-placement^="top"] .arrow::before {
        border-top-color: #801515 !important;
      }

      .bs-tooltip-right .arrow::before,
      .bs-tooltip-auto[x-placement^="right"] .arrow::before {
        border-right-color: #801515 !important;
      }

      .bs-tooltip-bottom .arrow::before,
      .bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
        border-bottom-color: #801515 !important;
      }

      .bs-tooltip-left .arrow::before,
      .bs-tooltip-auto[x-placement^="left"] .arrow::before {
        border-left-color: #801515 !important;
      }
          
      .veryLongTooltip .tooltip-inner {
        /* This will make the max-width relative to the tooltip's container, by default this is body */
        max-width: 100%;     
        /* This will remove any limits, but should still wrap if overflowing the viewport */
        /* max-width: none; */ 
      }
    </style>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">
      <?php
      include_once('navbar.php');
      include_once('aside.php');
      include_once('scripts.php');

      include($mainContent);

      include_once('footer.php');
      ?>
    </div>
  </body>
</html> 