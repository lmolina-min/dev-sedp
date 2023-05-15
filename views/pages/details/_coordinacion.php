<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/conection.php');

if (isset($_GET["nivel_org"])) {
    $evaluador = $bd->getEvaluadorCoord($_GET["nivel_org"]);
    $coordinacion = $evaluador["coordinacion"];
?>
	<div class="content-wrapper px-4">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-4">
					<div class="col-12">
						<h2 class="m-0 fw-bold"><?= ucfirst(mb_strtolower($coordinacion, "UTF-8")) ?></h2>
						<p class="text-secondary">Detalles Generales</p>
					</div>
				</div>
			</div>
		</div>
<?php
	if ($evaluador) {
		$query = $bd->getEmpleadosEvaluados($evaluador["cedula"]);
		$total_emp = $bd->getDatosEmpleadosxNivelOrg($evaluador["cedula"]);
		$evaluados = count($query);
		$progres_eval = $total_emp[0]["total"] != 0 ? round((count($query) * 100) / ($total_emp[0]["total"])) : 0;
		$progres_tam = $progres_eval == 0 ? 80 : $progres_eval;

		if (count($query) < 9) {
?>
			<section class="content">
				<div class="container-fluid">
					<div class="row mb-4">
						<div class="col-12">
							<div class="card card-dark shadow">
								<div class="card-header">
									<h3 class="card-title">Empleados a cargo</h3>

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
									<div class="d-flex flex-wrap" style="row-gap: 10px;">
										<?php $i = 1;
										foreach ($query as $query) {
											$progres = ($query['puntaje'] * 100) / 20;
											if ($query['puntaje'] <= 8) {
												$color = 'border-danger';
											} elseif ($query['puntaje'] > 8 && $query['puntaje'] <= 14) {
												$color = 'border-warning';
											} elseif ($query['puntaje'] > 14 && $query['puntaje'] <= 18) {
												$color = 'border-primary';
											} else {
												$color = 'border-success';
											}
										?>
											<div class="co-12 col-md-3">
												<div class="info-box h-100 elevation-1">
													<span class="info-box-icon">
														<!-- <i class="fas fa-users"></i> -->
														<?php
													$user = $bd->getDatosEmpleado($query['id']);
													$foto_emp = '/assets/images/avatars/blank.png';
													if ($user) {
														$foto_emp = (file_exists('assets/images/empleados/'.$user['login'].'.jpg'))
														? '/assets/images/empleados/'.$user['login'].'.jpg'
														: '/assets/images/avatars/blank.png';
													}
													?>
													<img class="rounded-circle <?= $color ?>" src="<?= $foto_emp ?>" alt="Foto de perfil de usuario" 
													style="width: 70px; height: 70px; object-position: center center; object-fit: cover; border: solid 4px;">
													</span>

													<div class="info-box-content">
														<span class="info-box-text"><?php echo $query['nombre'] . " " . $query['apellido']; ?></span>
														<small class="info-box-text-content h8"><?php echo $query['cargo']; ?></small>
														<span class="info-box-number">
															<?php echo $progres; ?>
															<small>%</small>
														</span>
													</div>
												</div>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="content">
				<div class="container-fluid">
					<div class="row mb-4">
						<div class="col-sm-6">
							<div class="card bg-primary shadow h-100">
								<div class="card-body d-flex flex-column justify-content-center align-items-center">
									<input class="knob" type="text" disabled readonly value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#ffffff" data-bgColor="#007bff">
									<p class="form-text">Progreso de las Evaluaciones</p>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="card bg-dark shadow h-100">
								<div class="card-body d-flex flex-column justify-content-center align-items-center">
									<p class="text-center"><strong>Totales</strong></p>

									<div class="progress-group">
										Empleados Evaluados
										<span class="ml-4"><?php echo $evaluados; ?>/<?php echo $total_emp[0]['total']; ?></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success" style="width: 90%"></div>
										</div>
									</div>

									<div class="progress-group">
										Empleados por evaluar
										<span class="ml-4"><?php echo ($total_emp[0]['total']) - $evaluados; ?></span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger" style="width: 90%"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php
		} else {
		?>
			<section class="content">
				<div class="container-fluid">
					<div class="row mb-4 h-100">
						<div class="col-sm-3 d-flex flex-column justify-content-between">
							<div class="card bg-primary shadow h-100">
								<div class="card-body d-flex flex-column justify-content-center align-items-center">
									<input class="knob" type="text" disabled readonly value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#ffffff" data-bgColor="#007bff">
									<p class="form-text">Progreso de las Evaluaciones</p>
								</div>
							</div>

							<div class="card bg-dark shadow h-100">
								<div class="card-body d-flex flex-column justify-content-center align-items-center px-4">
									<p class="text-center"><strong>Totales</strong></p>

									<div class="progress-group w-100 px-4">
										<div class="d-flex flex-row justify-content-between">
											Empleados Evaluados
											<span class="ml-4"><?= $evaluados ?>/<?= $total_emp[0]['total'] ?></span>
										</div>
										<div class="progress progress-sm">
											<div class="progress-bar bg-info" role="progressbar" style="width: <?= $progres_tam ?>%;" aria-valuemin="0" aria-valuemax="<?= $total_emp[0]['total'] ?>"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-9">
							<div class="card card-dark shadow">
								<div class="card-header">
									<h3 class="card-title">Empleados a cargo</h3>

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
										<table id="evaluacionesTable" class="table table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Empleado</th>
													<th>Cargo</th>
													<th>Resultado</th>
												</tr>
											</thead>

											<tbody>
												<?php
												$i = 1;
												foreach ($query as $query) {
												?>
													<tr id='emp-<?= $query['id'] ?>'>
														<td><span class="text-muted fw-light fs-6"><?= $i ?></span></td>
														<td>
															<div class="d-flex align-userss-center">
																<div class="d-flex justify-content-start flex-row gap-2">
																	<h6 class="text-dark fw-bold fs-6"><?= ucwords(strtolower($query['nombre']) . " " . strtolower($query['apellido'])) ?></h6>
																	<span class="text-muted fw-normal text-muted d-block fs-7"><?= number_format($query['cedula'], 0, ',', '.') ?>
														</td></span>
									</div>
								</div>
								</td>
								<td>
									<?php
													$cargo = (explode(' ', $query['cargo'])[0] == 'ANALISTA')
														? ucwords(strtolower(explode(' ', $query['cargo'])[0])) . " " . strtoupper(explode(' ', $query['cargo'])[1])
														: ucfirst(strtolower($query['cargo']));
													echo $cargo;
									?>
								</td>
								<td>
									<?php $progres = ($query['puntaje'] * 100) / 20;
													if ($query['puntaje'] <= 8) {
														$color = 'bg-danger';
													} elseif ($query['puntaje'] > 8 && $query['puntaje'] <= 14) {
														$color = 'bg-warning';
													} elseif ($query['puntaje'] > 14 && $query['puntaje'] <= 18) {
														$color = 'bg-primary';
													} else {
														$color = 'bg-success';
													}
									?>
									<div class="progress elevation-1">
										<div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progres ?>%" aria-valuemin="0" aria-valuemax="100"></div>
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
		<?php
		}
	} else {
		$evaluador = $bd->getEvaluadorCoord($_GET["nivel_org"], 0);
        $coordinacion = $evaluador["coordinacion"];
	?>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card-header">
							<h3 class="card-title"><?= ucfirst(mb_strtolower($coordinacion, "UTF-8")) ?></h3>
						</div>
					</div>

					<div class="col-12 col-sm-12">
						<div class="info-box">
							<div class="col-sm-8 text-center">
								<input type="text" class="knob" value="0" data-width="0" data-height="0" data-fgColor="#007bff">

								<div class="knob-label">Progreso de las Evaluaciones</div>
							</div>
							<div class="col-sm-4">
								<p class="text-center"><strong>Totales</strong></p>

								<div class="progress-group">
									Cantidad Empleados Evaluados
									<span class="float-right"><b>0</b>/0</span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-success" style="width: 90%"></div>
									</div>
								</div>
								<div class="progress-group">
									Cantidad Empleados por evaluar
									<span class="float-right"><b>0</b></span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-danger" style="width: 90%"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	}
	?>
		<div class="card-footer">
			<button type="button" class="btn btn-secondary" onclick="history.back()">Volver</button>
		</div>

		<input type="hidden" name="perfil" value="<?= $_SESSION["id_perfil"] ?>">
	</div>
<?php
}
?>


<script>
	var table = $('#evaluacionesTable').DataTable({
		language: { url: '/plugins/lang/es_ES.json',},
		processing: true,
        info: false,
        lengthChange: false,
        pageLength: 5,
	}).buttons().container().appendTo('#evaluacionesTable_wrapper .col-md-6:eq(0)');
</script>