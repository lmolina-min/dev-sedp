<nav class="main-header navbar navbar-expand navbar-dark bg-black shadow border-0 px-4 py-1" style="height: 52px !important;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto h-100 border-2">
    <!-- Profile Dropdown Menu -->
    <li class="nav-item dropdown">
      <?php
      $foto = ($_SESSION['foto_perfil'] != null)
      ? 'data:image/jpeg;base64,'.base64_encode($_SESSION['foto_perfil'])
      : '/assets/images/avatars/blank.png';
      ?>
      <img data-toggle="dropdown" role="button" class="border border-info" src="<?= $foto ?>" 
      style="width: 40px; height: 40px; object-position: center center; object-fit: cover; border-radius: 100%;">

      <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
        <span class="dropdown-item dropdown-header bg-secondary disabled"><?= $_SESSION["usuario"] ?></span>

        <div class="dropdown-divider"></div>
        <a href="/usuario.php?page=perfil" class="dropdown-item">
          <i class="fas fa-user mr-2"></i>Perfil
        </a>
        <a href="#" class="dropdown-item disabled">
          <i class="fas fa-gear mr-2"></i>Opciones
        </a>
        <div class="dropdown-divider"></div>
        <a href="/views/auth/logout.php" class="dropdown-item">
          <i class="fas fa-arrow-left mr-2"></i>Cerrar sesión
        </a>
        
        <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
      </div>
    </li>
  </ul>
</nav>
