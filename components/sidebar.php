<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/core/config/menu.php') 
?>
<div class="sidebar">
  <ul class="nav nav-pills nav-sidebar flex-column gap-2" data-widget="treeview" role="menu" data-accordion="false">
    <?php
    foreach ($modulos as $modulo) {
      if ($modulo['roles'] == null || in_array($_SESSION['rol'], $modulo['roles'])) {
        if (isset($modulo['sub'])) {
    ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-<?= $modulo['icono'] ?>"></i>
              <p>
                <?= $modulo['titulo']; ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php 
              foreach ($modulo['sub'] as $sub) {
                if ($sub['roles'] == null || in_array($_SESSION['rol'], $sub['roles'])) {
              ?>
                  <li class="nav-item">
                    <a href="<?= $sub['ruta'] ?>" class="nav-link">
                      <i class="fas fa-circle nav-icon" style="font-size: 5px;"></i>
                      <p><?= $sub['titulo'] ?></p>
                    </a>
                  </li>
              <?php
                }
              }
              ?>
            </ul>
          </li>
        <?php
        } else {
        ?>
          <li class="nav-item">
            <a href="<?= $modulo['ruta'] ?>" class="nav-link">
              <i class="nav-icon fas fa-<?= $modulo['icono'] ?>"></i>
              <p><?= $modulo['titulo']; ?></p>
            </a>
          </li>
    <?php
        }
      }
    }
    ?>
  </ul>

  <div class="sidebar-custom text-center pt-2">
    <span class="bg-success px-1" style="font-size: 11px;">Destacado</span>
    <span class="bg-primary px-1" style="font-size: 11px;">Esperado</span>
    <span class="bg-warning px-1" style="font-size: 11px;">Aceptable</span>
    <span class="bg-danger px-1" style="font-size: 11px;">Deficiente</span>
  </div>
</div>