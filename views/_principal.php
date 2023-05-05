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

function des_nivel ($query2){
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
	$des = explode("|", $nivel );
	return $des[count($des)-1];
}

$_SESSION['cod_nivel'] = $cod_nivel;
$_SESSION['descripcion_nivel_org'] = $nivel;
?>

<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h4 class="m-0" style="font-weight: 600;"><?php
						$cargo = explode(">", $_SESSION["descripcion_nivel_org"]);
						print_r((count($cargo) > 2) ? ucwords(strtolower($cargo[count($cargo) - 1])) : $cargo[0]);
						?></h4>
					<p class="text-secondary">Estadisticas generales</p>
				</div>
			</div>
		</div>
	</div>

	<?php
	$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
	$total_emp = $bd->getDatosEmpleadosxNivelOrg($_SESSION["evaluador"]);
	$evaluados = count($query);
	$progres_eval = $total_emp[0]["total"] != 0 ? round((count($query) * 100) / ($total_emp[0]["total"])) : 0;

	if (count($query) < 9) {
	?>
		<section class="content">
			<div class="container-fluid">
				<div class="row mb-4">
					<div class="col-12">
						<div class="card card-secondary">
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
													<img class="rounded-circle <?= $color ?>" style="border: solid 6px;" src="img/avatars/300-<?php echo rand(1, 30); ?>.jpg" alt="Foto de perfil de usuario">
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

		<?php
		$progres_tam = $progres_eval == 0 ? 80 : $progres_eval;
		?>

		<section class="content">
			<div class="container-fluid">
				<div class="row mb-4">
					<div class="col-sm-4">
						<div class="card bg-primary shadow h-100">
							<div class="card-body d-flex flex-column justify-content-center align-items-center">
								<input class="knob" type="text" disabled readonly value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#ffffff" data-bgColor="#007bff">
								<p class="form-text">Progreso de las Evaluaciones</p>
							</div>
						</div>
					</div>

					<div class="col-sm-4">
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

					<div class="col-sm-4">
						<div class="card bg-primary shadow h-100">
							<div class="card-body d-flex flex-column justify-content-center align-items-center">
								<input class="knob" type="text" disabled readonly value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#ffffff" data-bgColor="#007bff">
								<p class="form-text">Progreso de las Evaluaciones</p>
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
				<div class="row">
					<div class="col-12 col-sm-12">
						<div class="info-box">
							<div class="col-sm-8 text-center">
								<input type="text" class="knob" value="<?= $progres_eval; ?>" data-width="<?= $progres_eval; ?>" data-height="<?= $progres_eval; ?>" data-fgColor="#007bff">
								<div class="knob-label">Progreso de las Evaluaciones</div>
							</div>

							<div class="col-sm-4">
								<p class="text-center"><strong>Totales</strong></p>

								<div class="progress-group">
									Cantidad Empleados Evaluados
									<span class="float-right"><b><?php echo $evaluados; ?></b>/<?php echo $total_emp['total']; ?></span>
									<div class="progress progress-sm">
										<div class="progress-bar bg-success" style="width: 90%"></div>
									</div>
								</div>

								<div class="progress-group">
									Cantidad Empleados por evaluar
									<span class="float-right"><b><?php echo ($total_emp['total']) - $evaluados; ?></b></span>
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

		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Resultados de las Evaluaciones</h3>
							</div>

							<div class="card-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Cédula</th>
											<th>Nombre</th>
											<th>Apellido</th>
											<th>Cargo</th>
											<th>Resultado</th>
										</tr>
									</thead>

									<tbody>
										<?php $i = 1;
										foreach ($query as $query) {
										?>
											<tr id='mitr<?= $i ?>' style="" id="celda1" onmouseover='cambiar_color_over(this,<?= $i ?>)' onmouseout="cambiar_color_out(this,<?= $i ?>)" onClick="vercolor(this,<?= $i ?>)">
												<td><?php echo $query['cedula']; ?></td>
												<td><?php echo $query['nombre']; ?></td>
												<td><?php echo $query['apellido']; ?></td>
												<td><?php echo $query['cargo']; ?></td>
												<td><?php $progres = ($query['puntaje'] * 100) / 20;
													if ($query['puntaje'] <= 8) {
														$color = 'bg-danger';
													} elseif ($query['puntaje'] > 8 && $query['puntaje'] <= 14) {
														$color = 'bg-warning';
													} elseif ($query['puntaje'] > 14 && $query['puntaje'] <= 18) {
														$color = 'bg-primary';
													} else {
														$color = 'bg-success';
													} ?>
												</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped <?= $color ?>" role="progressbar" style="width: <?php echo $progres; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo $progres . ' %'; ?></div>
													</div>
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
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	}

	$titulo_graf = "Coordinaciones";
	if (isset($_SESSION['id_perfil']) && $_SESSION["id_perfil"] <> 5) {
		switch ($_SESSION["id_perfil"]) {
			case 100:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalle_gerencia.php?nivel_org=";
				$q = $bd->getGerencias($_SESSION["evaluador"], 0);
				break;

			case 2:
				$titulo_graf = "División";
				$ref = "detalle_division.php?nivel_org=";
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
				$ref = "detalle_coordinacion.php?nivel_org=";
				$q = $bd->getCoordinaciones($_SESSION["evaluador"], 0);
				break;

			case 6:
				$titulo_graf = "Gerencias de Operaciones";
				$ref = "detalle_gerenciaOp.php?nivel_org=";
				$q = $bd->getGerenciasOp($_SESSION["evaluador"]);
				break;

			case 7:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalle_gerencia.php?nivel_org=";
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
				$href[$i] = "detalle_departamento.php?nivel_org=";
			} elseif (substr($q['des'], 0, 3) == 'COO') {
				$href[$i] = "detalle_coordinacion.php?nivel_org=";
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
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card card-secondary">
							<div class="card-header">
								<h3 class="card-title">Evaluaciones por <?php echo $titulo_graf; ?> </h3>

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
</div>

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

		}
	}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


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
		function(event) { //window.alert('vv');
			var activepoints = myChart.getElementsAtEvent(event);
			if (activepoints.length > 0) {
				var clikedIndex = activepoints[0]["_index"];
				var actual_coord = myChart.data.labels[clikedIndex];
				var cod_coord = actual_coord.split('-');
				window.location.href = mihref[clikedIndex] + mi_idcoord[clikedIndex];
			}
		}
	)

	jQuery(function() {})
</script>