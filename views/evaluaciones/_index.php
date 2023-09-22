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
      <form data-toggle="validator" id="myform" name="myform" role="form" method="post" action="/apis/evaluacion/create.php" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <?php
              $empleados = $bd->getEmpleadosxEval($_SESSION["empleado"]);
              if (count($empleados) > 0) {
              ?>
                <label for="empleado">Empleados por Evaluar:</label>
                <select class="empleados-select2 w-100" name="empleado" id="empleadoSelect" required>
                  <option value="" selected disabled>Seleccione a un empleado</option>
                  <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['id'].'|'.$empleado['id_nomina'] ?>"><?= $formatear->nombre($empleado['nombre'], $empleado['apellido']) ?></option>
                  <?php endforeach ?>
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
                <table id="empleadosTable" class="table table-hover table-striped">
                  <?php $enviado = $bd->getEvaluacionesGerEnviadas(end($_SESSION['cod_nivel'])); ?>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Empleado</th>
                      <th>Cédula</th>
                      <th>Cargo</th>
                      <th class="text-center">Resultado</th>
                      <?php if (!$enviado && $_SESSION['p_estado'] == 0): ?>
                      <th class="text-center">Editar</th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $evaluaciones = $bd->getEmpleadosEvaluacion($_SESSION["empleado"]);
                    foreach ($evaluaciones as $eva) {
                    ?>
                      <tr>
                        <td><span class="text-muted fw-light fs-6"><?= $i ?></span></td>
                        <td>
                          <h6 class="text-dark fw-bold fs-6"><?= $formatear->nombre($eva['nombre'], $eva['apellido']) ?></h6>
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
                          <div class="progress elevation-1">
														<div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progres ?>%" aria-valuemin="0" aria-valuemax="100">
															<span class="fw-semibold" style="font-size: 10px;"><?= $progres ?> <small>%</small></span>
														</div>
                          </div>
                        </td>
                        <?php if (!$enviado && $_SESSION['p_estado'] == 0): ?>
                        <td class="text-center">
                          <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                            <a class="btn btn-sm btn-icon bg-secondary" href="/evaluaciones.php?page=editar&id_evaluacion=<?= $eva['id_evaluacion'] ?>&id_nomina=<?= $eva['id_nomina'] ?>&id_empleado=<?= $eva['id_empleado'] ?>&empleado=<?= $formatear->nombre($eva['nombre'], $eva['apellido']) ?>"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-sm btn-icon bg-danger" href="/apis/evaluacion/delete.php?id_evaluacion=<?= $eva['id_evaluacion'] ?>" onclick="return confirm('¿Estás seguro que deseas eliminar el registro?');"><i class="fas fa-trash"></i></a>
                          </div>
                        </td>
                        <?php endif ?>
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
    let empleadosTable = $('#empleadosTable').DataTable({
      language: {
        url: '/plugins/lang/es_ES.json',
      },
    }).buttons().container().appendTo('#tablaEmpleados_wrapper .col-md-6:eq(0)');

    $('.empleados-select2').select2();

    $("#empleadoSelect").on('change', function() {
      if ($(this).val() != '') {
        let ids = $(this).val().split('|');
        $.post("/apis/evaluacion/setFormat.php", {
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