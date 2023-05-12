<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

if (!isset($_SESSION["is_auth"])) {
  session_destroy();
  header("location: login.php");
}


// destroy session in 15 minutes, 900ms = 15 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
  header("Location: /login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // the start of the session.
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/favicon/apple-touch-icon.png">
    <title><?= $title ?></title>

    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/styles.php') ?>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed text-sm">
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/alert.php'); ?>

    <div class="wrapper">
      <?php
      include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/navbar.php');
      include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/aside.php');
      include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/scripts.php');
      include($mainContent);
      include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/footer.php');
      ?>
    </div>
  </body>
</html>