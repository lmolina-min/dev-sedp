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
      <form data-toggle="validator" id="myform" name="myform" role="form" method="post" action="/apis/evaluations/create.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <?php
              $empleados = $bd->getEmpleadosxEval($_SESSION["nivel_org"], $_SESSION["evaluador"]);
              if (count($empleados) > 0) {
              ?>
                <label for="empleado">Empleados por Evaluar:</label>
                <select class="empleados-select2 w-100" name="empleado" id="empleadoSelect" required>
                  <option value="">Seleccione a un empleado</option>
                  <?php
                  foreach ($empleados as $empleado) {
                  ?>
                    <option value="<?= $empleado['id'].'|'.$empleado['id_nomina'] ?>">
                      <?= ucwords(mb_strtolower($empleado['nombre'] . "  " . $empleado['apellido'], 'UTF-8')) ?>
                    </option>;
                  <?php
                  }
                  ?>
                <?php
              } else {
                ?>
                  <p class="text-muted"><i class="fas fa-circle-info me-2"></i>No hay empleados por evaluar</p>
                <?php
              }
                ?>
                </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card card-dark elevation-1" id="evaluacionCard">
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="content mt-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-dark elevation-1">
            <div class="card-header">
              <h4 class="card-title">Empleados Evaluados</h4>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
					        <i class="fas fa-minus"></i>
				        </button>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="tablaEmpleados" class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Empleado</th>
                      <th>Cédula</th>
                      <th>Cargo</th>
                      <th class="text-center">Resultado</th>
                      <th class="text-center">Editar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $evaluaciones = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
                    foreach ($evaluaciones as $eva) {
                    ?>
                      <tr id='emp-<?= $eva['id'] ?>'>
                        <td><span class="text-muted fw-light fs-6"><?= $i ?></span></td>
                        <td>
                          <h6 class="text-dark fw-bold fs-6"><?= ucwords(mb_strtolower($eva['nombre'] . " " . $eva['apellido'], 'UTF-8')) ?></h6>
                        </td>
                        <td><span class="text-muted fw-normal text-muted d-block fs-7"><?= number_format($eva['cedula'], 0, ',', '.') ?></span></td>
                        <td>
                          <?php
                          $cargo = (explode(' ', $eva['cargo'])[0] == 'ANALISTA')
                            ? ucwords(strtolower(explode(' ', $eva['cargo'])[0])) . " " . strtoupper(explode(' ', $eva['cargo'])[1])
                            : ucfirst(strtolower($eva['cargo']));
                          echo $cargo;
                          ?>
                        </td>
                        <?php $progres = ($eva['puntaje'] * 100) / 20;
                        if ($eva['puntaje'] <= 8) {
                          $color = 'bg-danger';
                        } elseif ($eva['puntaje'] > 8 && $eva['puntaje'] <= 14) {
                          $color = 'bg-warning';
                        } elseif ($eva['puntaje'] > 14 && $eva['puntaje'] <= 18) {
                          $color = 'bg-primary';
                        } else {
                          $color = 'bg-success';
                        }
                        ?>
                        <td class="text-center">
                          <span style="display:none"><?= $progres ?></span>
                          <div class="progress elevation-1">
                            <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progres ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                            <a href="/evaluaciones.php?page=editar&id_eval=<?= $eva['id_eval'] ?>&id_nomina=<?= $eva['id_nomina'] ?>&id_emp=<?= $eva['id'] ?>&nombre_emp=<?= $eva['nombre'] . " " . $eva['apellido'] ?>" class="btn btn-sm btn-icon bg-primary"><i class="fas fa-edit"></i></a>
                            <a href="/apis/evaluations/delete.php?id_eval=<?= $eva['id_eval'] ?>" class="btn btn-sm btn-icon bg-danger" onclick="return confirm('¿Estás seguro que deseas eliminar el registro?');"><i class="fas fa-trash"></i></a>
                          </div>
                        </td>
                      </tr>
                    <?php
                      $i++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="application/javascript">
  $(document).ready(function() {
    var table = $('#tablaEmpleados').DataTable({
      language: {
        url: '/plugins/lang/es_ES.json',
      },
    }).buttons().container().appendTo('#tablaEmpleados_wrapper .col-md-6:eq(0)');

    $('.empleados-select2').select2();

    $("#empleadoSelect").on('change', function() {
      if ($(this).val() != '') {
        let ids = $(this).val().split('|');
        $.post("/apis/evaluations/setFormat.php", {
          id_nomina: ids[1] 
        }, 
        function(data) {
           $("#evaluacionCard").html(data);
        });
      } else {
        $("#evaluacionCard").html("");
      }
    });
  });
</script>