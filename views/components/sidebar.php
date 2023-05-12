<div class="sidebar">
  <ul class="nav nav-pills nav-sidebar flex-column gap-2" data-widget="treeview" role="menu" data-accordion="false">
    <?php
    $query4 = $bd->getEstatus_eval_x_emp($_SESSION["evaluador"]);
    $finalizado = 0; // 0 - No puede ver, 1 - Puede ver

    if (!$query4) {
      $finalizado = 1;
    } elseif ($query4['estatus'] == 1) {
      $finalizado = 1;
    }

    $menus = $bd->getMenus();
    foreach ($menus as $menu) {
      $modulos = $bd->getModulos($menu['id_menu'], $_SESSION['id_perfil']);
      if (($menu['descripcion'] == 'Evaluaciones' && $finalizado == 0) || ($menu['descripcion'] == 'Reportes' && $_SESSION['id_perfil'] != 2 && $_SESSION['id_perfil'] != 7)) {
        continue;
      } else {
        if (count($modulos) > 0 && $menu['descripcion'] != 'Inicio' && $menu['descripcion'] != 'Reportes') {
    ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-<?= $menu['icon'] ?>"></i>
              <p>
                <?= $menu['descripcion']; ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php foreach ($modulos as $modulo) { ?>
                <li class="nav-item">
                  <a href="<?= $modulo['url_modulo'] ?>" class="nav-link">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p><?= $modulo['nombre'] ?></p>
                  </a>
                </li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        } else {
        ?>
          <li class="nav-item">
            <a href="<?= $menu['url_menu'] ?>" class="nav-link">
              <i class="nav-icon fas fa-<?= $menu['icon'] ?>"></i>
              <p><?= $menu['descripcion']; ?></p>
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