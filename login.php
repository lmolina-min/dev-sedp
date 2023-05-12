<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/images/favicon/favicon.ico">
    <title>Sistema de Evaluación de Desempeño</title>
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/plugins/adminlte/css/adminlte.min.css">

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      }
      html, body {
        height: 100%;
        width: 100%;
      }
    </style>
  </head>

  <body>
    <?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'].'/views/components/alert.php');
    session_destroy();
    session_unset();
    ?>

    <div class="d-flex flex-row w-100 h-100">
      <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center bg-body">
        <div class="d-flex flex-column align-items-center border-0 mb-4">
          <img src="/assets/images/logos/logo.png" alt="Logo de Minerven" width="125">
          <h4 class="text-center text-uppercase fw-bold mb-3">Minerven</h4>
          <p class="text-muted fs-6">Ingrese sus datos</p>
        </div>
        <div class="px-4">
          <form method="POST" action="/views/pages/auth/validate.php" class="d-flex flex-column align-items-center">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
            </div>

            <div class="input-group mb-4">
              <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-4 rounded-1">Iniciar sesión</button>
          </form>

          <p class="text-center">
            <a href="http://192.168.1.20/intranet" class="link link-dark link-underline link-underline-opacity-0"><i class="fas fa-arrow-left me-1"></i>Regresar</a>
          </p>
        </div>
      </div>

      <div class="d-none d-lg-block col-lg-6">
        <div class="bg-dark w-100 h-100"></div>
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