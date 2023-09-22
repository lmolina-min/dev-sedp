<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">Gestion de procesos</h2>
					<p class="text-secondary">Inicio y cierre</p>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-5 mx-auto">
					<div class="card card-dark shadow">
						<div class="card-header border-0">
							<h3 class="card-title">Proceso de evaluación</h3>
						</div>

						<form class="form p-4" action="/apis/proceso/create.php" method="POST">
							<div class="card-body">
								<div class="row mb-4">
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="inicioInput">Inicio</label>
										<input class="form-control" lang="es" type="date" name="fecha_inicio" id="inicioInput">
									</div>
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="cierreInput">Cierre</label>
										<input class="form-control" lang="es" type="date" name="fecha_final" id="cierreInput">
									</div>
								</div>
							</div>

							<div class="col-12 text-center">
								<button class="btn btn-lg btn-<?= ($_SESSION['p_estado'] == 0) ? 'secondary disabled' : 'primary' ?>" type="submit"><i class="fas fa-check-to-slot me-2"></i>Iniciar proceso</button>
								<?php if ($_SESSION['p_estado'] == 0): ?>
									<span class="form-text text-muted"><i class="fas fa-warning me-1"></i>Hay un proceso de evaluación activo actualmente!</span>
								<?php endif ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<hr class="hr my-2">

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
				<div class="card card-dark elevation-1">
            <div class="card-header">
              <h4 class="card-title">Procesos registrados</h4>
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
                <table id="procesosTable" class="table table-sm table-borderless table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Inicio</th>
                      <th>Cierre</th>
                      <th>Periodo</th>
                      <th>Cerrar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $procesos = $bd->getProcesos();
                    foreach ($procesos as $p) {
                    ?>
                      <tr>
                        <td><span class="text-muted fw-light fs-6"><?= $i ?></span></td>
                        <td><?= $p['fecha_inicio'] ?></td>
                        <td><?= $p['fecha_final'] ?></td>
                        <td><?= $p['periodo'] ?></td>
                        <td width="120">
							<?php if ($p['estado'] == 0): ?>
							<a class="btn btn-lg btn-success w-100" href="/apis/proceso/update.php?id=<?= $p['id'] ?>"><i class="fas fa-lock-open me-2"></i>Cerrar</a>
							<?php else: ?>
							<a class="btn btn-lg btn-dark disabled w-100" href="#"><i class="fas fa-lock me-2"></i>Cerrado</a>
							<?php endif ?>
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

<script>
	$(document).ready(function() {
		$('#procesosTable').DataTable({
			language: {
				url: '/plugins/lang/es_ES.json',
			},
			info: false,
		})

		$('#procesosTable td').css('vertical-align', 'middle')

		$('.empleados-select2').select2()
		$('.cargos-select2').select2()
		$('.centros-costo-select2').select2()
		$('.nominas-select2').select2()
		$('.grado-institucional-select2').select2()

		$('input[name="es_evaluador"]').on('change', function(el) {
			console.log($(el.target).val())
			if ($(el.target).val() == 0) {
				$('#userRow').addClass('d-none')
			}
			else {
				$('#userRow').removeClass('d-none')
			}
		})
	})
	
</script>