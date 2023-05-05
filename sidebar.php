<div class="sidebar">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <?php
    $p = $_SESSION["id_perfil"];
    $query4 = $bd->getEstatus_eval_x_emp($_SESSION["evaluador"]); 
    $finalizado = 0; // 0 - No puede ver, 1 - Puede ver

    if(!$query4) {
      $finalizado = 1;
    } elseif($query4['estatus'] == 1){
      $finalizado = 1;
    }

    $menus = $bd->getMenus();
    foreach ($menus as $menu) {
      $modulos = $bd->getModulos($menu['id_menu'], $_SESSION['id_perfil']);
      if (($menu['descripcion'] == 'Evaluaciones') && $finalizado == 0) {
        continue;
      } 
      else {
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
</div>