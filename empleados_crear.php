<?php
  require_once './acceso/conection.php';
  include_once 'head.php';
  include_once 'navbar.php';
  include_once 'aside.php';
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Empleados</h1>
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
              <form method="POST" action="empleados_insertar.php">

              <div class="card-body">

                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombre</label>
                      <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                    </div> 
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellido</label>
                      <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido">
                    </div>
                  </div>

                   <div class="col-lg-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Cédula</label>
                      <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Cédula">
                    </div>
                  </div>
                </div>

                  

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


  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Empleados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                     <th>Cédula</th>

                  </tr>
                  </thead>
                  <tbody>
                    <?php
                          $query = $bd->getDatosEmpleadosAll();
                            foreach ($query as $query) {
                    ?>
                  <tr>
                    
                    <td><?php echo $query['id_empleados'];?></td>
                    <td><?php echo $query['nombre'];?></td>
                    <td><?php echo $query['apellido'];?></td>
                    <td><?php echo $query['cedula'];?></td>
                   
                    <td>
                      <a href="<?= 'empleados_editar.php?id='.$query['id_empleados']; ?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-edit"></i></a>
                    
                      <a href="<?= 'empleados_eliminar.php?id='.$query['id_empleados']; ?>" class="btn bg-gradient-danger btn-xs"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                   <?php
                      }
                    ?>
                
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Editar</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        
        </div>
        <!-- /.row (main row) -->
      </div>
      </div>
    </section>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 

 <?php
  include_once 'footer.php';
  include_once 'scripts.php';
?>

</body>
</html>