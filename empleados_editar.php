<?php
  require_once './acceso/conection.php';
  include_once 'head.php';
  include_once 'navbar.php';
  include_once 'aside.php';
?>


<body class="hold-transition sidebar-mini">
<div class="wrapper">
  

  <!-- Content Wrapper. Contains page content -->
  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  
      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos del empleado</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
        
      <form method="POST" action="empleados_procesa.php">

        <?php 
          $id_empleados = $_GET['id'];
           $empleados = $bd->getDatosEmpleadosEditar($id_empleados);
              foreach ($empleados as $query) {
        ?>
              <div class="card-body">

                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="">Nombre</label>
                      <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $query['nombre']?>">
                    </div> 
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="">Apellido</label>
                      <input type="text" class="form-control" name="apellido" id="apellido" value="<?php echo $query['apellido']?>">
                    </div>
                  </div>

                   <div class="col-lg-4">
                    <div class="form-group">
                      <label for="">Cédula</label>
                      <input type="text" class="form-control" name="cedula" id="cedula" value="<?php echo $query['cedula']?>">
                    </div>
                  </div>
                </div>

          <input type="hidden" class="form-control" name="id_empleados" id="id_empleados" value="<?php echo $query['id_empleados']?>">
   
              <?php 
                } 
               ?>
     
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">GUARDAR</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

 </section>


  </div>
 


<?php
  include_once 'footer.php';
  include_once 'scripts.php';
?>

</body>
</html>
