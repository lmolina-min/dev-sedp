<?php
if (isset($_SESSION['alert'])) {
?>
  <!-- y: top, bottom  -->
  <!-- x: left, right  -->
  <div id="alertMessage" class="alert alert-dismissible alert-<?= $_SESSION['alert']['status'] ?? 'info' ?>" role="alert" 
    style="position: fixed; <?php echo $_SESSION['alert']['y'] ?? 'top'; ?>: 60px; <?php echo $_SESSION['alert']['x'] ?? 'right'; ?>: 10px; z-index: 2000;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span><?= $_SESSION['alert']['message'] ?? 'Contacte con el equipo de soporte' ?></span>
  </div>
<?php
}
unset($_SESSION['alert']);
?>