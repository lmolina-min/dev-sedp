<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/conection.php');

if (isset($_GET["nivel_org"])) {
	$eva = $bd->getEvaluadorCoord($_GET["nivel_org"]);
	$coordinacion = $eva["coordinacion"];
?>
	<div class="content-wrapper px-4">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-4">
					<div class="col-12">
						<div class="d-flex flex-row justify-content-between align-items-center">
							<h2 class="m-0 fw-bold">
								<?= ucfirst(mb_strtolower($coordinacion, "UTF-8")) ?>
								<p class="fw-normal fs-6 text-secondary"><?= $formatear->nombre($eva['nombre'], $eva['apellido']) ?><?= ' C.I.'.number_format($eva['cedula'], 0, ',', '.') ?></p>
							</h2>

							<button type="button" class="btn btn-secondary" onclick="history.back()"><i class="fas fa-arrow-left me-2"></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		if ($eva) {
			$evaluados = $bd->getEmpleadosEvaluacion($eva["id"]);
			$empleados = count($bd->getEmpleadosEvaluador($eva["id"]));
				
			$total_evaluado = count($evaluados);
			$progres_eval = $total_evaluado != 0 ? round(($total_evaluado * 100) / ($empleados)) : 0;
				
			$total_falt = $total_evaluado != 0 ? round((($empleados - $total_evaluado) * 100) / ($empleados)) : 0;
				
			$enviado = $bd->getEvaluacionesGerEnviadas(end($_SESSION['cod_nivel']));
			if ($total_evaluado > 0) {
				if ($total_evaluado < 9) {
		?>
					<!-- Lista de empleados -->
					<section class="content">
						<div class="container-fluid">
							<div class="row mb-4">
								<div class="col-12">
									<div class="card card-dark shadow">
										<div class="card-header">
											<h3 class="card-title">Empleados evaluados</h3>

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
												<?php
												$i = 1;
												foreach ($evaluados as $empleado) {
													$progres = ($empleado['puntaje'] * 100) / 20;

													if ($empleado['puntaje'] == 0) {
														$color = 'border-secondary';
													} elseif ($empleado['puntaje'] <= 8) {
														$color = 'border-danger';
													} elseif ($empleado['puntaje'] > 8 && $empleado['puntaje'] <= 14) {
														$color = 'border-warning';
													} elseif ($empleado['puntaje'] > 14 && $empleado['puntaje'] <= 18) {
														$color = 'border-primary';
													} else {
														$color = 'border-success';
													}
												?>
													<div class="co-12 col-md-3">
														<div class="info-box h-100 elevation-1">
															<span class="info-box-icon">
																<?php
																$foto = ($empleado['foto'] != null)
																	? 'data:image/jpeg;base64,' . base64_encode($empleado['foto'])
																	: '/assets/images/avatars/blank.png';
																?>
																<img class="rounded-circle <?= $color ?>" src="<?= $foto ?>" alt="Foto de perfil de usuario" style="width: 70px; height: 70px; object-position: center center; object-fit: contain; border: solid 4px;">
															</span>

															<div class="info-box-content">
																<span class="info-box-text"><?= $formatear->nombre($empleado['nombre'], $empleado['apellido']) ?></span>
																<small class="info-box-text-content"><?= $empleado['cargo'] ?></small>
																<?php if ($empleado['estado'] == 0) : ?>
																	<a href="#" class="info-box-number btn btn-xs btn-outline-secondary w-100"><i class="fas fa-clipboard-list me-2"></i>Evaluar</a>
																<?php else : ?>
																	<span class="info-box-number"><?= $progres ?><small>%</small></span>
																<?php endif ?>
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

					<!-- Estadisticas de evaluación -->
					<?php if (!$enviado): ?>
					<section class="content">
						<div class="container-fluid">
							<div class="row mb-4">
								<div class="col-sm-6">
									<div class="card bg-primary shadow h-100">
										<div class="card-body d-flex flex-column justify-content-center align-items-center">
											<input class="knob" type="text" disabled readonly value="<?= $progres_eval ?>" data-width="80" data-height="80" data-fgColor="#ffffff" data-bgColor="#007bff">
											<p class="form-text text-white">Progreso de las Evaluaciones</p>
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="card bg-dark shadow h-100">
										<div class="card-body d-flex flex-column justify-content-center align-items-center">
											<p class="text-center"><strong>Totales</strong></p>

											<div class="progress-group">
												Empleados Evaluados
												<span class="ml-4"><?= $total_evaluado ?>/<?= $empleados ?></span>
												<div class="progress progress-sm">
													<div class="progress-bar bg-success" style="width: <?= $progres_eval ?>%"></div>
												</div>
											</div>

											<div class="progress-group">
												Empleados por evaluar
												<span class="ml-4"><?= $empleados - $total_evaluado ?></span>
												<div class="progress progress-sm">
													<div class="progress-bar bg-danger" style="width: <?= $total_falt ?>%"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php endif ?>
				<?php
				} else {
				?>
					<!-- Estadisticas de evaluación y tabla de empleados -->
					<section class="content">
						<div class="container-fluid">
							<div class="row mb-4 h-100">
								<?php if (!$enviado): ?>
								<div class="col-sm-3 d-flex flex-column justify-content-between">
									<div class="card bg-primary shadow h-100">
										<div class="card-body d-flex flex-column justify-content-center align-items-center">
											<input class="knob" type="text" disabled readonly value="<?= $progres_eval ?>" data-width="80" data-height="80" data-fgColor="#ffffff" data-bgColor="#007bff">
											<p class="form-text">Progreso de las Evaluaciones</p>
										</div>
									</div>

									<div class="card bg-dark shadow h-100">
										<div class="card-body d-flex flex-column justify-content-center align-items-center">
											<p class="text-center"><strong>Totales</strong></p>

											<div class="progress-group">
												Empleados Evaluados
												<span class="ml-4"><?= $total_evaluado ?>/<?= $empleados ?></span>
												<div class="progress progress-sm">
													<div class="progress-bar bg-success" style="width: <?= $progres_eval ?>%"></div>
												</div>
											</div>

											<div class="progress-group">
												Empleados por evaluar
												<span class="ml-4"><?= $empleados - $total_evaluado ?></span>
												<div class="progress progress-sm">
													<div class="progress-bar bg-danger" style="width: <?= $total_falt ?>%"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php endif ?>

								<div class="col-sm-9">
									<div class="card card-secondary shadow">
										<div class="card-header">
											<h3 class="card-title">Empleados evaluados</h3>

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
															<th>Empleado</th>
															<th class="text-center">Cédula</th>
															<th class="text-center">Cargo</th>
															<th class="text-center">Resultado</th>
														</tr>
													</thead>

													<tbody style="height: 300px !important;">
														<?php
														$i = 1;
														foreach ($evaluados as $empleado) {
														?>
															<tr id='emp-<?= $empleado['id'] ?>'>
																<td>
																	<div class="d-flex flex-row align-items-center gap-2">
																		<div class="widget-user-image">
																			<?php
																			$foto = ($empleado['foto'] != null)
																				? 'data:image/jpeg;base64,' . base64_encode($empleado['foto'])
																				: '/assets/images/avatars/blank.png';
																			?>
																			<img class="img-circle elevation-1" width="30" src="<?= $foto ?>" alt="Foto de empleado">
																		</div>
																		<h6 class="text-dark fw-bold fs-6 m-0"><?= $formatear->nombre($empleado['nombre'], $empleado['apellido']) ?></h6>
																	</div>
																</td>
																<td class="text-center"><span class="text-muted fw-normal text-muted d-block fs-7"><?= number_format($empleado['cedula'], 0, ',', '.') ?></span></td>
																<td class="text-center">
																	<?php
																	$cargo = (explode(' ', $empleado['cargo'])[0] == 'ANALISTA')
																		? ucwords(strtolower(explode(' ', $empleado['cargo'])[0])) . " " . strtoupper(explode(' ', $empleado['cargo'])[1])
																		: ucfirst(strtolower($empleado['cargo']));
																	echo $cargo;
																	?>
																</td>
																<td width="120" class="text-center">
																	<?php $progres = ($empleado['puntaje'] * 100) / 20;
																	if ($empleado['puntaje'] == 0) {
																		$color = 'bg-secondary';
																	} elseif ($empleado['puntaje'] <= 8) {
																		$color = 'bg-danger';
																	} elseif ($empleado['puntaje'] > 8 && $empleado['puntaje'] <= 14) {
																		$color = 'bg-warning';
																	} elseif ($empleado['puntaje'] > 14 && $empleado['puntaje'] <= 18) {
																		$color = 'bg-primary';
																	} else {
																		$color = 'bg-success';
																	}
																	?>
																	<?php if ($empleado['estado'] == 0) : ?>
																		<a href="#" class="btn btn-xs btn-outline-secondary w-100"><i class="fas fa-clipboard-list me-2"></i>Evaluar</a>
																	<?php else : ?>
																		<div class="progress elevation-1">
																			<div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progres ?>%" aria-valuemin="0" aria-valuemax="100">
																				<span class="fw-semibold" style="font-size: 10px;"><?= $progres ?> <small>%</small></span>
																			</div>
																		</div>
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
				<?php
				}
			} else {
				echo '<p class="text-muted ms-3"><i class="fas fa-circle-info me-2"></i>No hay registro de empleados</p>';
			}
		}
		?>
		<input type="hidden" name="perfil" value="<?= $_SESSION["rol"] ?>">
	</div>
<?php
}
?>

<script>
	var evaluacionesTable = $('#evaluacionesTable').DataTable({
		language: {
			url: '/plugins/lang/es_ES.json',
		},
		processing: true,
		info: false,
		lengthChange: false,
		pageLength: 5,
	})
</script>