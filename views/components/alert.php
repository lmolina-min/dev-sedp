<?php
if (isset($_SESSION['alert'])) {
  switch ($_SESSION['alert']['status']) {
    case 'success':
      $icon = 'fas fa-check-circle';
      break;
    case 'warning':
      $icon = 'fas fa-circle-exclamation';
      break;
    case 'danger':
      $icon = 'fas fa-circle-xmark';
      break;
    default:
      $icon = 'fas fa-circle-info';
      break;
  }
?>
  <!-- y: top, bottom  -->
  <!-- x: left, right  -->
  <div id="alertMessage" class="alert alert-dismissible alert-<?= $_SESSION['alert']['status'] ?? 'info' ?>" role="alert" 
    style="position: fixed; <?php echo $_SESSION['alert']['y'] ?? 'top'; ?>: 60px; <?php echo $_SESSION['alert']['x'] ?? 'right'; ?>: 10px; z-index: 2000;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span><i class="<?= $icon ?> me-2"></i><?= $_SESSION['alert']['message'] ?? 'Contacte con el equipo de soporte' ?></span>
  </div>
<?php
}
unset($_SESSION['alert']);
?>