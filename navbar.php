<nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-1 px-4">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto h-100">
    <!-- Profile Dropdown Menu -->
    <li class="nav-item dropdown">
      <img data-toggle="dropdown" role="button" class="border border-secondary" src="./img/avatars/300-1.jpg" width="40" style="border-radius: 100%;">

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header bg-primary disabled"><?= $_SESSION["usuario"] ?></span>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item disabled">
          <i class="fas fa-user mr-2"></i>Perfil
        </a>
        <a href="#" class="dropdown-item disabled">
          <i class="fas fa-gear mr-2"></i>Opciones
        </a>
        <div class="dropdown-divider"></div>
        <a href="cerrar.php" class="dropdown-item">
          <i class="fas fa-arrow-left mr-2"></i>Cerrar sesión
        </a>
        
        <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
      </div>
    </li>
  </ul>
</nav>
