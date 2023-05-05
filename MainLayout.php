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

    <?php include_once('styles.php') ?>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">
      <?php
      include_once('navbar.php');
      include_once('aside.php');
      
      include($mainContent);
      
      include_once('footer.php');
      include_once('scripts.php');
      ?>
    </div>
  </body>
</html> 