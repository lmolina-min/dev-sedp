<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/conection.php');
?>

<div class="content-wrapper px-4">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-12">
          <h2 class="m-0 fw-bold text-capitalize">Evaluar empleados</h2>
          <p class="text-secondary">
            <?php
            $cargo = explode(">", $_SESSION["descripcion_nivel_org"]);
            echo ((count($cargo) > 2) ? ucwords(strtolower($cargo[count($cargo) - 1])) : ucwords(strtolower($cargo[0])));
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <form data-toggle="validator" id="myform" name="myform" role="form" method="post" action="registra_evaluacion.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputPassword1">UNIDADES FUNCIONALES</label>
              <select class="form-control" name="empleado" id="empleado" placeholder="Empleado" onChange="habilitaFormato()" required>
                <option></option>
                <?php
                $query2 = $bd->getEmpleadosxEval($_SESSION["nivel_org"], $_SESSION["evaluador"]);
                foreach ($query2 as $query2) {
                  echo "<option value='" . $query2['id'] . "|" . $query2['id_nomina'] . "'";
                  echo ">" . strtoupper($query2['nombre'] . "  " . $query2['apellido']) . " </option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row" id="formato" style="display: none">
          <div class="col-12">
            <div class="card">
              <div class="card-body" id="tablaModelo"></div>
              <div class="card-footer">
                <input type="submit" id="saveChanges" class="btn btn-primary" onclick="" value="Evaluar">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h3 class="card-title">Empleados Evaluados</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>

                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Resultado</th>
                    <th>Enviar a..</th>
                    <th>Retornar a..</th>
                    <th>Revisar</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  $query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
                  foreach ($query as $query) {
                  ?>
                    <tr id='mitr<?= $i ?>' style="" id="celda1" onmouseover='cambiar_color_over(this,<?= $i ?>)' onmouseout="cambiar_color_out(this,<?= $i ?>)" onClick="vercolor(this,<?= $i ?>)">

                      <td><?php echo '18246852'; //$query['cedula'];
                          ?></td>
                      <td><?php echo 'NARYOLIS'; //$query['nombre'];
                          ?></td>
                      <td><?php echo 'CARPIO'; //$query['apellido'];
                          ?></td>
                      <td><?php echo 'ANALISTA III'; //$query['cargo'];
                          ?></td>
                      <!--  
              <td><?php $progres = ($query['puntaje'] * 100) / 20;
                    if ($query['puntaje'] <= 8) {
                      $color = 'bg-danger';
                    } elseif ($query['puntaje'] > 8 && $query['puntaje'] <= 14) {
                      $color = 'bg-warning';
                    } elseif ($query['puntaje'] > 14 && $query['puntaje'] <= 18) {
                      $color = 'bg-primary';
                    } else {
                      $color = 'bg-success';
                    }

                  ?></td> -->
                      <td>
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped <?= $color ?>" role="progressbar" style="width: <?php echo $progres; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo $progres . ' %'; ?></div>
                        </div>
                      </td>
                      <td align="center" onClick="asignar(<?= $id ?>,<?= $idv ?>,'<?= $tipo_c ?>',<?= $i ?>,this)">
                        <a href="#" class="btn bg-gradient-success btn-xs" data-toggle="tooltip" data-html="true" data-placement="left" title='<?php echo $tableresult; ?>'><i class="fas fa-edit"><?php echo $query['to_send']; ?></i></a>

                      </td>
                      <td align="center" onClick="asignar(<?= $id ?>,<?= $idv ?>,'<?= $tipo_c ?>',<?= $i ?>,this)">
                        <a href="#" class="btn bg-gradient-dark btn-xs" data-toggle="tooltip" data-html="true" data-placement="left" title='<?php echo $tableresult; ?>'><i class="fas fa-edit"><?php echo 'JOSE SALAZAR'; ?></i></a>

                      </td>

                      <td align="center">

                        <a href="<?= 'evaluacion_editar.php?id_eval=' . $query['id_eval'] . '&id_nomina=' . $query['id_nomina'] . '&id_emp=' . $query['id']; ?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-edit"></i></a>


                      </td>
                    </tr>

                  <?php
                    $i++;
                  }
                  ?>

                </tbody>
                <tfoot>

                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Resultado</th>
                    <th>Enviar a..</th>
                    <th>Retornar a..</th>
                    <th>Revisar</th>


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
</div>

<script type="application/javascript">
  var table = $('#example1').DataTable({
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
      }

    } /*, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]*/
    //ajax: 'get_data.php',
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  function habilitaFormato() {
    $("#formato").css("display", "block");
  }

  $(document).ready(function() {
    $("#empleado").on('change', function() {
      $("#empleado option:selected").each(function() {
        var ids = $(this).val().split('|');
        id_nomina = ids[1];
        $.post("/apis/evaluation/setFormat.php", {
          id_nomina: id_nomina
        }, function(data) {
          $("#tablaModelo").html(data);
        });
      });
    });
  });
</script>