<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/core/helper/formatear.php');
$formatear = new Formatear();

require_once($_SERVER['DOCUMENT_ROOT'].'/core/helper/reporter.php');
$reporter = new Reporter($bd);

if (!isset($_SESSION["autenticado"])) {
  session_destroy();
  header("location: login.php");
}


//destroy session in 4 minutes, 240ms = 4 minutes
// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 240)) {
//   header("Location: /login.php");
// }
// $_SESSION['LAST_ACTIVITY'] = time(); // the start of the session.
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/favicon/apple-touch-icon.png">
    <title><?= $title ?></title>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/components/styles.php') ?>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed text-sm bg-light">
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/components/alert.php'); ?>

    <div class="wrapper">
      <?php
      include_once($_SERVER['DOCUMENT_ROOT'].'/components/scripts.php');
      include_once($_SERVER['DOCUMENT_ROOT'].'/components/navbar.php');
      include_once($_SERVER['DOCUMENT_ROOT'].'/components/aside.php');
      include($mainContent);
      include_once($_SERVER['DOCUMENT_ROOT'].'/components/footer.php');
      ?>
    </div>
  </body>
</html>
