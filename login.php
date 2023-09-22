<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/assets/images/favicon/favicon.ico">
  <title>Sistema de Evaluación y Desempeño</title>
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/plugins/adminlte/css/adminlte.min.css">
  <link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css"></link>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    html,
    body {
      height: 100%;
      width: 100%;
    }

    .bg-mark {
      /* position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      padding: 0;
      margin: 0; */
      background: url("/assets/images/login-bg.png");
      background-position: bottom center;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body>
  <?php
  session_start();
  include_once($_SERVER['DOCUMENT_ROOT'] . '/components/alert.php');
  session_destroy();
  session_unset();
  ?>

  <div class="row h-100 m-0 p-0 bg-white">
    <div class="col-12 d-flex flex-column justify-content-center align-items-center bg-mark px-0">
      <div class="row h-100 pb-4">
        <div class="card border-0 bg-white shadow-none elevation-0 align-self-center px-2 my-4">
          <div class="card-header bg-white border-0 d-flex flex-column align-items-center">
            <img src="/assets/images/logos/logo-new.png" alt="Logo de Minerven" width="170">
            <!-- <h4 class="text-uppercase text-dark" style="font-weight: 700;">Minerven</h4> -->
          </div>

          <div class="card-body bg-white p-4">
            <form method="POST" action="/views/auth/validate.php" class="d-flex flex-column align-items-center">
              <div class="form-floating mb-3">
                <input pattern="[a-zA-Z0-9]+" style="border: none; border-bottom: 1px solid #010101; border-radius: 0;" type="text" class="form-control shadow-none" id="usuario" name="usuario" placeholder="Usuario">
                <Label for="usuario" class="text-muted" style="font-size: 12px;"><i class="fas fa-user me-2"></i>Usuario</Label>
              </div>
              
              <div class="form-floating mb-3">
                <input style="border: none; border-bottom: 1px solid #010101; border-radius: 0;" type="password" class="form-control shadow-none" id="contraseña" name="contraseña" placeholder="Contraseña">
                <Label for="contraseña" class="text-muted" style="font-size: 12px;"><i class="fas fa-lock me-2"></i>Contraseña</Label>
              </div>

              <button type="submit" name="ingresar" value="ingresar" class="btn bg-black w-100 my-3 rounded-0">Iniciar sesión</button>
            </form>
          </div>

          <div class="card-footer pt-0 border-0 bg-white text-center">
            <a href="http://192.168.1.20/intranet" class="fw-light fs-6 text-center text-muted">Volver a la Intranet</a>
          </div>
        </div>
      </div>
    </div>

    <div class="d-none d-md-none col-6 bg-black p-0">
      <div id="carouselExampleFade" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img style="object-fit: cover !important; height: 100vh !important;" src="/assets/images/test.jpg" class="d-block w-100" alt="Imagenes de Minerven">
          </div>
          <div class="carousel-item">
            <img style="object-fit: cover !important; height: 100vh !important;" src="/assets/images/test.jpg" class="d-block w-100" alt="Imagenes de Minerven">
          </div>
          <div class="carousel-item">
            <img style="object-fit: cover !important; height: 100vh !important;" src="/assets/images/test.jpg" class="d-block w-100" alt="Imagenes de Minerven">
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="/plugins/jquery/jquery.min.js"></script>
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(() => {
      $("#alertMessage").fadeIn(5)
      setTimeout(function() {
        $("#alertMessage").fadeOut(1500);
      }, 4000)
    })
  </script>
</body>

</html>