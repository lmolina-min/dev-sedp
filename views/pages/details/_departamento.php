<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/conection.php');

if (isset($_GET["nivel_org"])) {
    $evaluador = $bd->getEvaluadorDep($_GET["nivel_org"]);
	$departamento = $evaluador["departamento"];
?>
	<div class="content-wrapper px-4">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-4">
					<div class="col-12">
						<h2 class="m-0 fw-bold"><?= ucfirst(mb_strtolower($departamento, "UTF-8")) ?></h2>
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
							<div class="card card-secondary shadow">
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
							<div class="card card-secondary shadow">
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
										<table id="tablaEvaluaciones" class="table table-hover table-striped">
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

			<section class="content">
				<div class="container-fluid">
					<div class="row">
					</div>
				</div>
			</section>
		<?php
		}
		if (isset($_SESSION['id_perfil']) && $_SESSION["id_perfil"] <> 5) {
			$q = null;

			if ($array_coord = $bd->getCoordinaciones($evaluador["cedula"], 0)) {
				$q = $array_coord;
				$ref = "detalles.php?d=4&nivel_org=";
			}
			$i = 0;
			$nivel_org = $_SESSION["nivel_org"];

			if ($q) {
				foreach ($q as $q) {
					$eval = $bd->getEvaluadorCoord($q['id']);
					if ($eval) {
						$evaluador = $eval['cedula'];
						$sinUni = 1;
					} else {
						$eval =  $bd->getEvaluadorDiv($_GET["nivel_org"]);
						$evaluador = $eval['cedula'];
						$sinUni = 0;
					}
					if (substr($q['des'], 0, 3) == 'DEP') {
						$href[$i] = "detalles.php?d=3&nivel_org=";
					} elseif (substr($q['des'], 0, 3) == 'COO') {
						$href[$i] = "detalles.php?d=4&nivel_org=";
					}
					$coord[$i] = $q['id'] . '|' . $q['des'];
					$bdi = $bd->getResultadoxNivel('puntaje <= 8', $q['id'], $evaluador, $sinUni);
					$midatabd[$i] = $bdi['puntaje'];
					$da = $bd->getResultadoxNivel('puntaje > 8 and puntaje <= 14', $q['id'], $evaluador, $sinUni);
					$midatada[$i] = $da['puntaje'];
					$le = $bd->getResultadoxNivel('puntaje > 14 and puntaje <= 18', $q['id'], $evaluador, $sinUni);
					$midatale[$i] = $le['puntaje']; //
					$se = $bd->getResultadoxNivel('puntaje >= 19', $q['id'], $evaluador, $sinUni);
					$midatase[$i] = $se['puntaje'];
					$i++;
				}
			}
		?>
			<section class="content">
				<div class="container-fluid" id="grafica" style="display: none">
					<div class="row">
						<div class="col-12">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Evaluaciones por Coordinaciones</h3>

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
	} else {
		$evaluador = $bd->getEvaluadorDep($_GET["nivel_org"], 0);
		$departamento = $evaluador["departamento"];
	?>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card-header">
							<h3 class="card-title"><?= ucfirst(mb_strtolower($departamento, "UTF-8")) ?></h3>
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

	var pnum = 15;
	var coord = 'micoord';

	jQuery(function() {
		let coord = [];
		coord = <?php echo json_encode($coord); ?>;
		if (coord.length) {
			$("#grafica").css("display", "block");
		}

		let midatabd = [];
		midatabd = <?php echo json_encode($midatabd); ?>;
		let midatada = [];
		midatada = <?php echo json_encode($midatada); ?>;
		let midatale = [];
		midatale = <?php echo json_encode($midatale); ?>;
		let midatase = [];
		midatase = <?php echo json_encode($midatase); ?>;

		let micoord = []; //['COORDINACION I', 'COORDINACION II', 'COORDINACION III', 'COORDINACION IV', 'COORDINACION V'];
		let mi_idcoord = [];
		var n = coord.length;
		for (var i = 0; i < n; i++) {
			var des_coord = coord[i].split('|');
			micoord.push(des_coord[1]);
			mi_idcoord.push(des_coord[0]);
		}

		var areaChartData3 = {
			labels: micoord,
			datasets: [{
					label: 'Bajo Desempeño',
					backgroundColor: 'rgba(220,53,69,1)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: midatabd //[pnum, 13, 12, 4, 13]
				},
				{
					label: 'Desempeño Aceptable',
					backgroundColor: 'rgba(255, 193, 7, 1)',
					borderColor: 'rgba(210, 214, 222, 1)',
					pointRadius: false,
					pointColor: 'rgba(210, 214, 222, 1)',
					pointStrokeColor: '#c1c7d1',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(220,220,220,1)',
					data: midatada
				},
				{
					label: 'Lo esperado',
					backgroundColor: 'rgba(0, 123, 255, 1)',
					borderColor: 'rgba(110, 114, 122, 1)',
					pointRadius: false,
					pointColor: 'rgba(110, 114, 122, 1)',
					pointStrokeColor: '#c1c7d1',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(220,220,220,1)',
					data: midatale
				},
				{
					label: 'Supera las Expectativas',
					backgroundColor: 'rgba(40, 167, 69, 1)',
					borderColor: 'rgba(110, 114, 122, 1)',
					pointRadius: false,
					pointColor: 'rgba(110, 114, 122, 1)',
					pointStrokeColor: '#c1c7d1',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(220,220,220,1)',
					data: midatase
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
		}

		var myChart = new Chart(stackedBarChartCanvas, {
			type: 'bar',
			data: stackedBarChartData,
			options: stackedBarChartOptions
		})

		let mihref = [];
		mihref = <?php echo json_encode($href); ?>;
		$('#stackedBarChart').click(
			function(event) {
				var activepoints = myChart.getElementsAtEvent(event);
				if (activepoints.length > 0) {
					var clikedIndex = activepoints[0]["_index"];
					var actual_coord = myChart.data.labels[clikedIndex];
					var cod_coord = actual_coord.split('-');
					window.location.href = mihref[clikedIndex] + mi_idcoord[clikedIndex];
				}
			}
		)
	})
</script>
