<?php
$nivel_org = $_SESSION["nivel_org"];
$query2 = $bdn->getNivelOrg($nivel_org);

$nivel = '';
$cod_nivel = '';
foreach ($query2 as $query) {
	$gerencia_gral = $query['gerencia_gral'] . " > ";
	$gerencia = $query['gerencia'];
	$gerenciaop = $query['gerencia_gral_op'] != '' ? " > " . $query['gerencia_gral_op'] : '';
	$division = $query['division'] != '' ? " > " . $query['division'] : '';
	$departamento = $query['departamento'] != '' ? " > " . $query['departamento'] : '';
	$coordinacion = $query['coordinacion'] != '' ? " > " . $query['coordinacion'] : '';
	$oficinas = $query['oficinas'] != '' ? " > " . $query['oficinas'] : '';
	$nivel = $gerencia_gral . $gerencia . $gerenciaop . $division . $departamento . $coordinacion . $oficinas;

	$cod_nivel = $query['id_ger'];
	$cod_nivel .= $query['id_ger_oper'] <> 0 ? " |" . $query['id_ger_oper'] : '';
	$cod_nivel .= $query['id_div'] <> 0 ? "|" . $query['id_div'] : '';
	$cod_nivel .= $query['id_dep'] <> 0 ? "|" . $query['id_dep'] : '';
	$cod_nivel .= $query['id_coord'] <> 0 ? "|" . $query['id_coord'] : '';
}
$_SESSION['cod_nivel'] = $cod_nivel;

function des_nivel($query2)
{
	$nivel = '';
	$cod_nivel = '';
	foreach ($query2 as $query2) {
		$gerencia_gral = $query2['gerencia_gral'] . "|";
		$gerencia = $query2['gerencia'];
		$gerenciaop = $query2['gerencia_gral_op'] != '' ? "|" . $query2['gerencia_gral_op'] : '';
		$division = $query2['division'] != '' ? "|" . $query2['division'] : '';
		$departamento = $query2['departamento'] != '' ? "|" . $query2['departamento'] : '';
		$coordinacion = $query2['coordinacion'] != '' ? "|" . $query2['coordinacion'] : '';
		$oficinas = $query2['oficinas'] != '' ? "|" . $query2['oficinas'] : '';
		$nivel = $gerencia_gral . $gerencia . $gerenciaop . $division . $departamento . $coordinacion . $oficinas;
	}
	$des = explode("|", $nivel);
	return $des[count($des) - 1];
}

$_SESSION['descripcion_nivel_org'] = $nivel;
?>

<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<?php
						$cargo = explode(">", $_SESSION["descripcion_nivel_org"]);
						$cargo = ucfirst(trim(strtolower((count($cargo) == 0) ? $cargo[0] : $cargo[count($cargo) - 1])));
					?>
					<h2 class="m-0 fw-bold"><?= $cargo ?></h2>
					<p class="text-secondary">Estadisticas generales</p>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="row">
		<div class="col-5">
			<div class="card card-info">
				<div class="card-header">
					<h4 class="card-title">Enviar mensajes</h4>
				</div>

				<div class="card-body">
					<form action="/correo.php?enviar=aprobar-solicitud" method="POST">
						<input class="form-control mb-3" type="email" name="correo" placeholder="correo">
						<button class="btn btn-sm btn-primary" type="submit">Enviar</button>
					</form>
				</div>
			</div>
		</div>
	</div> -->

	<?php
	$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
	$total_emp = $bd->getDatosEmpleadosxNivelOrg($_SESSION["evaluador"]);
	$evaluados = count($query);
	$progres_eval = $total_emp[0]["total"] != 0 ? round((count($query) * 100) / ($total_emp[0]["total"])) : 0;
	$progres_tam = $progres_eval == 0 ? 80 : $progres_eval;
	if (count($query) > 0) {
		if (count($query) < 9) {
	?>
			<!-- Lista de empleados -->
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

			<!-- Estadisticas de evaluación -->
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
			<!-- Estadisticas de evaluación y tabla de empleados -->
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
										<table id="evaluacionesTable" class="table table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Empleado</th>
													<th>Cédula</th>
													<th>Cargo</th>
													<th>Resultado</th>
												</tr>
											</thead>
				
											<tbody style="height: 300px !important;">
												<?php
												$i = 1;
												foreach ($query as $query) {
												?>
													<tr id='emp-<?= $query['id'] ?>'>
														<td><span class="text-muted fw-light fs-6"><?= $i ?></span></td>
														<td>
															<div class="d-flex flex-row align-items-center gap-2">
																<div class="widget-user-image">
																	<img class="img-circle elevation-1" width="30" src="/assets/images/avatars/blank.png" alt="Foto de empleado">
																</div>
																<h6 class="text-dark fw-bold fs-6 m-0"><?= ucwords(mb_strtolower($query['nombre']." ".$query['apellido'], 'UTF-8')) ?></h6>
															</div>
														</td>
														<td><span class="text-muted fw-normal text-muted d-block fs-7"><?= number_format($query['cedula'], 0, ',', '.') ?></span></td>
														<td>
															<?php
																$cargo = (explode(' ', $query['cargo'])[0] == 'ANALISTA') 
																? ucwords(strtolower(explode(' ', $query['cargo'])[0]))." ".strtoupper(explode(' ', $query['cargo'])[1])
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
															<span style="display:none"><?= $progres ?></span>
															<div class="progress elevation-1">
																<div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progres ?>%" aria-valuemin="0" aria-valuemax="100">
																</div>
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
	}
	else {
		echo '<p class="text-muted ms-3"><i class="fas fa-circle-info me-2"></i>No tiene empleados a su cargo</p>';
	}
	$titulo_graf = "Coordinaciones";
	$enviar_th = 0;
	if (isset($_SESSION['id_perfil']) && $_SESSION["id_perfil"] <> 5) {
		switch ($_SESSION["id_perfil"]) {
			case 100:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalles.php?d=".$_SESSION["id_perfil"]."&nivel_org=";
				$q = $bd->getGerencias($_SESSION["evaluador"], 0);
				break;

			case 2:
				$qgo = $bd->getGerenciasOp($_SESSION["evaluador"]);

				if (!$qgo) {
					$enviar_th = 1;
				}
				$titulo_graf = "División";
				$ref = "detalles.php?d=".$_SESSION["id_perfil"]."&nivel_org=";
				$q = $bd->getDivisiones($_SESSION["evaluador"], 1);
				break;

			case 3:
				$q = null;
				if ($array_dep = $bd->getDepartamentos($_SESSION["evaluador"], 1)) {
					$q = $array_dep;
				}

				if ($array_coord = $bd->getCoordinaciones($_SESSION["evaluador"], 0)) {
					$q = $array_dep ? array_merge($array_dep, $array_coord) : $array_coord;
				}
				break;

			case 4:
				$ref = "detalles.php?d=".$_SESSION["id_perfil"]."&nivel_org=";
				$q = $bd->getCoordinaciones($_SESSION["evaluador"], 0);
				break;

			case 6:
				$titulo_graf = "Gerencias de Operaciones";
				$enviar_th = 1;
				$ref = "detalles.php?d=".$_SESSION["id_perfil"]."&nivel_org=";
				$q = $bd->getGerenciasOp($_SESSION["evaluador"]);
				break;

			case 7:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalles.php?d=".$_SESSION["id_perfil"]."&nivel_org=";
				$q = $bd->getGerencias('2222222'); //se debe consultar la cedula del gerente general o evaluador de los gerentes
				break;

			default:
				$msj = "";
		}

		$i = 0;
		$nivel_org = $_SESSION["nivel_org"];

		$unidad = "";
		foreach ($q as $q) {
			$eval = $bd->getEvaluadorCoord($q['id']);

			if ($eval) {
				$evaluador = $eval['cedula'];
				$sinUni = 1;
			} else {
				$evaluador = $_SESSION["evaluador"];
				$sinUni = 0;
			}

			if (substr($q['des'], 0, 3) == 'DEP') {
				$href[$i] = "detalles.php?d=3&nivel_org=";
			} elseif (substr($q['des'], 0, 3) == 'COO') {
				$href[$i] = "detalles.php?d=4&nivel_org=";
			} else {
				$href[$i] = $ref;
			}

			$longi = strpos($q['des'], 'GERENCIA DE') === false ? 9 : 12;
			$unidad = substr($q['des'], $longi);

			$coord[$i] = $q['id'] . '|' . $q['des'];
			$bdi = $bd->getResultadoxNivel('puntaje <= 8', $q['id'], $evaluador, $sinUni);
			$midatabd[$i] = $bdi['puntaje'];

			$da = $bd->getResultadoxNivel('(puntaje > 8 and puntaje <= 14)', $q['id'], $evaluador, $sinUni);
			$midatada[$i] = $da['puntaje'];
			$le = $bd->getResultadoxNivel('(puntaje > 14 and puntaje <= 18)', $q['id'], $evaluador, $sinUni);

			$midatale[$i] = $le['puntaje'];
			$se = $bd->getResultadoxNivel('puntaje >= 19', $q['id'], $evaluador, $sinUni);
			$midatase[$i] = $se['puntaje'];
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
								<h3 class="card-title">Evaluaciones por <?= strtolower($titulo_graf) ?></h3>

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

	<input type="hidden" class="form-control" name="perfil" id="perfil" value="<?php echo $_SESSION["id_perfil"] ?>">

	<!-- Boton de aprobación  -->
	<?php
	$tableresult = '<div class="info-box-text">Unidades sin completar el proceso de evaluación</div>';
	$des = '';
	$disabled = 'disabled';
	$finalizado = 0;
	if ($enviar_th) {
		$query3 = $bd->getEmpSinEval($cod_nivel);
		foreach ($query3 as $query3) {
			$des = des_nivel($bdn->getNivelOrg($query3['id_ccosto']));
			$tableresult .= '<div class="">' . $des . '</div>';
		}
		
		if ($des == '') {
			$query4 = $bd->getEstatus_eval_gerencias($cod_nivel);
			if (count($query4) > 0) {
				$finalizado = 1;
			}
			$disabled = '';
			$tableresult =  '';
			// $tableresult =  '<div class="text-white">Todas las unidades completaron el proceso de evaluación</div>';
		}
		?>
		<div class="row">
			<div class="col-12">
				<div class="d-flex align-items-center justify-content-center flex-row gap-2 w-100">
				<?php
				if ($finalizado == 0) {
				?>
					<form action="/apis/evaluations/uploadAll.php" method="POST">
						<input type="hidden" name="nivel_org" value="<?= $cod_nivel ?>">
						<button type="submit" id="btnAprobar" class="btn btn-primary <?= $disabled ?>">
							<i class="fas fa-circle-check me-2"></i>Aprobar y Enviar
						</button>
					</form>
					<?php
					if ($tableresult != '') {
					?>
					<i class="fas fa-info-circle fs-5 text-secondary"
					data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $tableresult ?>'></i>
					<?php
					}
					?>
				<?php
				} else {
				?>
					<span class="alert bg-secondary text-muted text-center" role="alert">Proceso de Evaluación Finalizado</span>
				<?php
				}
				?>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</div>

<script>
	var table = $('#evaluacionesTable').DataTable({
		language: { url: '/plugins/lang/es_ES.json',},
		processing: true,
        info: false,
        lengthChange: false,
        pageLength: 5,
		ordering: true,
	}).buttons().container().appendTo('#evaluacionesTable_wrapper .col-md-6:eq(0)');

	$(function() {
		$('[data-toggle="tooltip"]').tooltip({
			boundary: "window",
			template: '<div class="tooltip tooltip-custom" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
		});
	});

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

	var pnum = 15;
	var coord = 'micoord';

	let barCoord = <?php echo json_encode($coord); ?>;

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
	var n = barCoord.length;
	for (var i = 0; i < n; i++) {
		var des_coord = barCoord[i].split('|');
		micoord.push(des_coord[1]);
		mi_idcoord.push(des_coord[0]);
	}

	var areaChartData3 = {
		labels: micoord,
		datasets: [{
				label: 'Deficiente',
				backgroundColor: 'rgba(220,53,69,1)',
				borderColor: 'rgba(60,141,188,0.8)',
				pointRadius: false,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: midatabd
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
				data: midatada
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
				data: midatale
			},
			{
				label: 'Destacado',
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
</script>