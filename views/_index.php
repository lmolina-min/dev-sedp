<?php
$nivel_org = $bdn->getNivelOrg($_SESSION["nivel_org"]);

$nivel = '';
$cod_nivel = '';

$gerencia_gral 	= $nivel_org['gerencia_gral'] . " > ";
$gerencia 		= $nivel_org['gerencia'];
$division 		= $nivel_org['division'] != '' ? " > " . $nivel_org['division'] : '';
$departamento 	= $nivel_org['departamento'] != '' ? " > " . $nivel_org['departamento'] : '';
$coordinacion 	= $nivel_org['coordinacion'] != '' ? " > " . $nivel_org['coordinacion'] : '';
$oficinas 		= $nivel_org['oficinas'] != '' ? " > " . $nivel_org['oficinas'] : '';
$nivel 			= $gerencia_gral . $gerencia . $division . $departamento . $coordinacion . $oficinas;

$cod_nivel  = $nivel_org['id_ger_gral'];
$cod_nivel .= $nivel_org['id_ger'] <> 0 ? "|" . $nivel_org['id_ger'] : '';
$cod_nivel .= $nivel_org['id_divi'] <> 0 ? "|" . $nivel_org['id_divi'] : '';
$cod_nivel .= $nivel_org['id_dep'] <> 0 ? "|" . $nivel_org['id_dep'] : '';
$cod_nivel .= $nivel_org['id_coord'] <> 0 ? "|" . $nivel_org['id_coord'] : '';
$cod_nivel .= $nivel_org['id_ofi'] <> 0 ? "|" . $nivel_org['id_ofi'] : '';

$_SESSION['cod_nivel'] = explode('|', $cod_nivel);
$unidad_org = explode(" >", $nivel);
$unidad_org = array_filter(array_map('trim', $unidad_org), 'strlen');
$unidad_org = ucfirst(trim(mb_strtolower((count($unidad_org) == 0) ? $unidad_org[0] : $unidad_org[count($unidad_org) - 1], 'UTF-8')));
$_SESSION['unidad_org'] = $unidad_org;
?>

<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">
					<?= ($_SESSION['rol'] == 10)
						? "Administrador de Talento Humano"
						: $formatear->unidad($_SESSION['unidad_org'], false)
					?>
					</h2>
					<p class="text-secondary">Estadisticas generales</p>
				</div>
			</div>
		</div>
	</div>

	<?php
	$evaluados = $bd->getEmpleadosEvaluacion($_SESSION["empleado"]);
	$empleados = count($bd->getEmpleadosEvaluador($_SESSION["empleado"]));
	
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

						<div class="col-auto">
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
		echo '<p class="text-muted ms-3"><i class="fas fa-circle-info me-2"></i>No hay registro de evaluaciones</p>';
	}

	if (isset($_SESSION['rol']) && $_SESSION['rol'] != 4) {
		switch ($_SESSION["rol"]) {
			case 0: // GERENTE GENERAL
				$enviar_th = 1;
				$titulo_grafica = "gerencia";
				$ref = "detalles.php?d=1&nivel_org=";
				$q = $bd->getGerencias($_SESSION["empleado"]);
				break;

			case 1: // GERENTE
				$enviar_th = 1;
				$titulo_grafica = "división";
				$ref = "detalles.php?d=2&nivel_org=";
				
				$array_dep = $bd->getDepartamentos($_SESSION["empleado"]);
				$array_coord = $bd->getCoordinaciones($_SESSION["empleado"]);
				$array_dep_coord = ($array_dep) ? array_merge($array_dep, $array_coord) : $array_coord;
				
				$q = array_merge($bd->getDivisiones($_SESSION["empleado"]), $array_dep_coord);
				break;

			case 2: // JEFE DE DIVISION
				$enviar_th = 0;
				$titulo_grafica = "coordinación y/o departamento";
				$ref = "detalles.php?d=3&nivel_org=";
				$array_dep = $bd->getDepartamentos($_SESSION["empleado"]);
				$array_coord = $bd->getCoordinaciones($_SESSION["empleado"]);
				$q = $array_dep ? array_merge($array_dep, $array_coord) : $array_coord;
				break;

			case 3: // COORDINADORES / DEPARTAMENTO
				$enviar_th = 0 ;
				$titulo_grafica = "coordinacion";
				$ref = "detalles.php?d=4&nivel_org=";
				$q = $bd->getCoordinaciones($_SESSION["empleado"]);
				break;

			default: // ADMINISTRADOR
				$enviar_th = 1;
				$titulo_grafica = "gerencias";
				$ref = "detalles.php?d=1&nivel_org=";
				$q = $bd->getGerencias($_SESSION["empleado"]);
				break;
		}

		$i = 0;
		foreach ($q as $q) {
			if (substr($q['des'], 0, 3) == 'DEP') {
				$href[$i] = "detalles.php?d=3&nivel_org=";
			}
			elseif (substr($q['des'], 0, 3) == 'COO') {
				$href[$i] = "detalles.php?d=4&nivel_org=";
			}
			else {
				$href[$i] = $ref;
			}

			if ($evaluador = $bd->getEvaluadorCoord($q['nivel_org'])) {
				$evaluador = $evaluador['id'];
				$sin_evaluador = false;
			}
			elseif ($evaluador = $bd->getEvaluadorDiv($q['nivel_org'])) {
				$evaluador = $evaluador['id'];
				$sin_evaluador = false;
			}
			elseif ($evaluador = $bd->getEvaluadorGer($q['nivel_org'])) {
				$evaluador = $evaluador['id'];
				$sin_evaluador = true;			
				$href[$i] = null;				
			}
			else {
				$evaluador = $_SESSION['empleado'];
				$sin_evaluador = true;
				$href[$i] = null;				
			}
			
			$unidad[] = $q['nivel_org'] . '|' . mb_strtoupper($q['des'], 'UTF-8');
			
			$resultados = $bd->getPuntajes($evaluador, $q['nivel_org'], $sin_evaluador);
			$destacados[$i] = 0;
			$esperados[$i] = 0;
			$aceptables[$i] = 0;
			$deficientes[$i] = 0;
			foreach ($resultados as $r) {				
				if ($r['puntaje'] > 18) {
					$destacados[$i] += 1;
				}
				elseif ($r['puntaje'] > 14) {
					$esperados[$i] += 1;
				}
				elseif ($r['puntaje'] > 8) {
					$aceptables[$i] += 1;
				}
				else {
					$deficientes[$i] += 1;
				}
			}
			$i++;
		}
		?>
		<!-- Gráficas de niveles organizativos -->
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card card-dark">
							<div class="card-header">
								<h3 class="card-title">Evaluaciones por <?= strtolower($titulo_grafica) ?></h3>

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
								<div class="chart">
									<canvas id="stackedBarChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
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

	<input type="hidden" class="form-control" name="perfil" id="perfil" value="<?= $_SESSION["rol"] ?>">

	<!-- Boton de aprobación  -->
	<?php
	if ($_SESSION['rol'] <= 1) {
		$cc_sin_evaluar = ($_SESSION['rol'] == 1) 
		? $bd->getEmpSinEvaluar(end($_SESSION['cod_nivel']), $_SESSION['empleado'])
		: $bd->getGerSinEvaluar($_SESSION['empleado']);

		if ($cc_sin_evaluar) {
			$pendiente = true;
			$disabled = 'secondary disabled';
			foreach ($cc_sin_evaluar as $ccosto) {
				$niveles_org[] = $bdn->getNivelOrg($ccosto['id_ccosto']);
			}
			foreach ($niveles_org as $nivel) {
				$pendientes[] = $formatear->nivelOrg($nivel);
			}
		}
		
		$enviado = $bd->getEvaluacionesGerEnviadas(end($_SESSION['cod_nivel']));
	?>
		<div class="d-flex justify-content-center align-items-center flex-row gap-2 w-100 py-4">
			<?php if ($_SESSION['p_estado']): ?>
				<span class="btn btn-lg btn-secondary disabled fs-6" role="alert"><i class="fas fa-hourglass-end me-2"></i>Proceso de Evaluación Finalizado</span>
			<?php else: ?>
				<?php if ($enviado): ?>
					<span class="btn btn-lg btn-secondary disabled" role="alert"><i class="fas fa-check-to-slot me-2"></i>Evaluaciones enviadas</span>
				<?php else: ?>
					<form action="/apis/evaluacion/enviar.php" method="POST">
						<input type="hidden" name="nivel_org" value="<?= end($_SESSION['cod_nivel']) ?>">
						<button type="submit" name="finalizar" class="btn btn-lg btn-<?= $disabled ?? 'primary' ?>">
						<i class="fas fa-check me-2"></i>Enviar evaluaciones
					</button>
				</form>
				<?php endif ?>
				
				<?php if (isset($pendiente)): ?>
					<i class="fas fa-info-circle fs-5 text-secondary" data-toggle="tooltip" data-html="true" data-placement="top" title="<?= 'Pendiente: ' . implode(', ', $pendientes) ?>"></i>
				<?php endif ?>
			<?php endif ?>
		</div>
	<?php
	}
	?>
</div>

<script>
	let evaluacioneTable = $('#evaluacionesTable').DataTable({
		language: {
			url: '/plugins/lang/es_ES.json',
		},
		processing: true,
		info: false,
		lengthChange: false,
		pageLength: 5,
		ordering: true,
	})
	$('#evaluacionesTable td').css('vertical-align', 'middle')

	$(function() {
		$('[data-toggle="tooltip"]').tooltip({
			boundary: "window",
			template: '<div class="tooltip tooltip-custom" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
		});
	})

	function cambiaColor(obj, rad, id) {
		$("#" + obj + "").attr("class", "bg-success");
	}

	function cambiar_color_over(celda, i) {
		celda.style.backgroundColor = "#f8f988";
	}

	function cambiar_color_out(celda, i) {
		if ((i % 2) == 0) {
			$("#mitr" + i).css('backgroundColor', '#f5f5f5');
		} else {
			$("#mitr" + i).css('backgroundColor', '#ffffff');
		}
	}

	var pnum = 15
	var unidad = 'micoord'

	let barCoord = [] 
	barCoord = <?= json_encode($unidad) ?>;

	let deficientes = []
	deficientes = <?= json_encode($deficientes) ?>;

	let aceptables = []
	aceptables = <?= json_encode($aceptables) ?>;

	let esperados = []
	esperados = <?= json_encode($esperados) ?>;

	let destacados = []
	destacados = <?= json_encode($destacados) ?>;

	let micoord = []
	let mi_idcoord = []
	var n = barCoord.length
	for (var i = 0; i < n; i++) {
		var des_coord = barCoord[i].split('|')
		micoord.push(des_coord[1])
		mi_idcoord.push(des_coord[0])
	}

	var areaChartData3 = {
		labels: micoord,
		datasets: [
			{
				label: 'Destacado',
				backgroundColor: 'rgba(40, 167, 69, 1)',
				borderColor: 'rgba(110, 114, 122, 1)',
				pointRadius: false,
				pointColor: 'rgba(110, 114, 122, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: destacados
			},
			{
				label: 'Esperado',
				backgroundColor: 'rgba(0, 123, 255, 1)',
				borderColor: 'rgba(110, 114, 122, 1)',
				pointRadius: false,
				pointColor: 'rgba(110, 114, 122, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: esperados
			},
			{
				label: 'Aceptable',
				backgroundColor: 'rgba(255, 193, 7, 1)',
				borderColor: 'rgba(210, 214, 222, 1)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: aceptables
			},
			{
				label: 'Deficiente',
				backgroundColor: 'rgba(220,53,69,1)',
				borderColor: 'rgba(60,141,188,0.8)',
				pointRadius: false,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: deficientes
			},
		]
	}

	var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
	var barChartData2 = $.extend(true, {}, areaChartData3)
	var stackedBarChartData = $.extend(true, {}, barChartData2)

	var stackedBarChartOptions = {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			xAxes: [{
				stacked: true,
			}],
			yAxes: [{
				stacked: true
			}]
		},
		plugins: {
			labels: {
				display: false,
			},
		},
	}

	var myChart = new Chart(stackedBarChartCanvas, {
		type: 'bar',
		data: stackedBarChartData,
		options: stackedBarChartOptions,
	})

	let href = [];
	href = <?= json_encode($href) ?>

	$('#stackedBarChart').click(
		function(event) {
			var activepoints = myChart.getElementsAtEvent(event)

			if (activepoints.length > 0) {
				var clikedIndex = activepoints[0]["_index"]
				var actual_coord = myChart.data.labels[clikedIndex]
				var cod_coord = actual_coord.split('-')
				if (href[clikedIndex] != null) {
					window.location.href = href[clikedIndex] + mi_idcoord[clikedIndex]
				}
			}
		}
	)
</script>