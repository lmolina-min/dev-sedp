<?php
//session_start();
//  echo "la sesion del nivel org es:". $_SESSION["nivel_org"];

/*$bd_servidor	= "localhost";
$bd_nombre		= "bd_nivel_org"; //"bd_combustible";//
$bd_puerto		= "3306";
$bd_usuario		= "root";
$bd_clave		= "";
$bd_tipo 		= "mysql";

$bdt = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);*/

$nivel_org = $_SESSION["nivel_org"];

$query2 = $bdn->getNivelOrg($nivel_org);
require_once './lib/my_php_functions/functions.php';

/*foreach ($query2 as $query2) {
	//id_ger_gral 	 	id_ger 	gerencia 	id_ger_oper 	gerencia_gral_op 	id_div 	division 	departamento 	coordinacion 	oficinas 	
	$gerencia_gral = $query2['gerencia_gral'] . " --> ";
	$gerencia = $query2['gerencia'];
	$gerenciaop = $query2['gerencia_gral_op'] != '' ? " --> " . $query2['gerencia_gral_op'] : '';
	$division = $query2['division'] != '' ? " --> " . $query2['division'] : '';
	$departamento = $query2['departamento'] != '' ? " --> " . $query2['departamento'] : '';
	$coordinacion = $query2['coordinacion'] != '' ? " --> " . $query2['coordinacion'] : '';
	$oficinas = $query2['oficinas'] != '' ? " --> " . $query2['oficinas'] : '';
	$nivel = $gerencia_gral . $gerencia . $gerenciaop . $division . $departamento . $coordinacion . $oficinas;

	$cod_nivel = $query2['id_ger'];
	$cod_nivel .= $query2['id_ger_oper'] <> 0 ? " |" . $query2['id_ger_oper'] : '';
	$cod_nivel .= $query2['id_div'] <> 0 ? "|" . $query2['id_div'] : '';
	$cod_nivel .= $query2['id_dep'] <> 0 ? "|" . $query2['id_dep'] : '';
	$cod_nivel .= $query2['id_coord'] <> 0 ? "|" . $query2['id_coord'] : '';
	//echo "<option value='".$query2['id']."'";
	// echo ">". strtoupper($query2['descripcion']). " </option>";
}*/

$_SESSION['descripcion_nivel_org'] = $nivel; //. '|' . $cod_nivel;
//require_once './acceso/conection.php';
?>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">

				<div class="col-12 col-sm-12">
					<div class="info-box">

						<div class="col-sm-8">
							<h4 class="info-box-text font-weight-bold text-secondary">SISTEMA DE EVALUACIÓN DE DESEMPEÑO DE PERSONAL</h4>
						</div><!-- /.col -->
						<div class="col-sm-4">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item">Bienvenido: <a href="#"><?php print_r($_SESSION["usuario"]); ?></a></li>
							</ol>
						</div><!-- /.col -->

						<!-- /.info-box -->
					</div>
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
			<div class="row mb-2">
				<div class="col-sm-12">
					<div id="nivel" class="alert bg-info" role="alert" style="display: block">

						<strong><?php print_r($_SESSION["descripcion_nivel_org"]); ?></strong>
					</div>
				</div><!-- /.col -->

			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div><!-- /.container-fluid -->


	<?php
	if (isset($_SESSION['msj'])) {
		$cent = (int) $_SESSION['msj'];
		$premsj = '¡Bien hecho!';
		$clase = 'alert alert-success alert-dismissible';
		switch ($cent) {
			case 1:
				$msj = "Las Evaluaciones fueron aprobadas y enviadas a la Gerencia de Talento Humano!!!";
				unset($_SESSION['msj']);

				/* default:
                          $msj = "";*/
		}
		//echo "----------------------------------------------------------------".$msj;
	?>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
						<!-- general form elements -->

						<div id="msj_alert" class="<?= $clase; ?>" role="alert" style="display: block">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong><?= $premsj; ?></strong> <?= $msj; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php

	}
	?>



	<?php
	/*echo "</br>gerencia: ".$gerencia;
	echo "</br>gerenciaop :".$gerenciaop;
	echo "</br>division ".$division;
	echo "</br>departamento ".$departamento;
	echo "</br>coordinacion ".$coordinacion;
	echo "</br>oficinas ".$oficinas;*/


	//print_r($midatase);
	/* para obtener cuantos obtuvieron un puntaje segun la escala del formato
			select count(puntaje) from se_evaluacion 
inner join se_empleado
on se_evaluacion.id_empleado = se_empleado.id
where puntaje <= 8 and se_empleado.id_ccosto = 511
			
			*/
	$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
	$total_emp = $bd->getDatosEmpleadosxNivelOrg($_SESSION["evaluador"]);
	$evaluados = count($query);
	foreach ($total_emp as $total_emp) {
		//echo "ddd: " . count($query);
		//print_r($query);
	}

	$progres_eval = $total_emp['total'] != 0 ? round((count($query) * 100) / ($total_emp['total'])) : 0;

	if (count($query) < 9) {


	?>
		<section class="content">
			<div class="container-fluid">
				<!-- Info boxes -->
				<div class="row">

					<?php $i = 1;
					//$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
					//echo  count($query);
					foreach ($query as $query) {
						$progres = ($query['puntaje'] * 100) / 20;
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
						<div class="col-12 col-sm-6 col-md-3">
							<div class="info-box">
								<span class="info-box-icon <?= $color ?> elevation-1"><i class="fas fa-users"></i></span>

								<div class="info-box-content">
									<span class="info-box-text"><?php echo $query['nombre'] . " " . $query['apellido']; ?></span>
									<small class="info-box-text-content h8"><?php echo $query['cargo']; ?></small>
									<span class="info-box-number">
										<?php echo $progres; ?>
										<small>%</small>
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
					<?php }
					?>

					<!-- /.col -->
				</div>

			</div>
		</section>

		<?php
		$progres_tam = $progres_eval == 0 ? 80 : $progres_eval;

		?>

		<section class="content">
			<div class="container-fluid">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-12 col-sm-12">
						<div class="info-box">

							<div class="col-sm-8 text-center">
								<input type="text" class="knob" value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#007bff">

								<div class="knob-label">Progreso de las Evaluaciones --</div>

							</div><!-- /.col -->
							<div class="col-sm-4">
								<p class="text-center">
									<strong>Totales</strong>
								</p>

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
								<!-- /.progress-group -->
							</div>
							<!-- /.info-box -->

						</div>
					</div><!-- /.row -->
				</div>

			</div>
		</section>
	<?php } else {


	?>
		<section class="content">
			<div class="container-fluid">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-12 col-sm-12">
						<div class="info-box">

							<div class="col-sm-8 text-center">
								<input type="text" class="knob" value="<?= $progres_eval; ?>" data-width="<?= $progres_eval; ?>" data-height="<?= $progres_eval; ?>" data-fgColor="#007bff">

								<div class="knob-label">Progreso de las Evaluaciones</div>

							</div><!-- /.col -->
							<div class="col-sm-4">
								<p class="text-center">
									<strong>Totales</strong>
								</p>

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
								<!-- /.progress-group -->
							</div>
							<!-- /.info-box -->

						</div>
					</div><!-- /.row -->
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

										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										//$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
										//echo  count($query);
										foreach ($query as $query) {
										?>
											<tr id='mitr<?= $i ?>' style="" id="celda1" onmouseover='cambiar_color_over(this,<?= $i ?>)' onmouseout="cambiar_color_out(this,<?= $i ?>)" onClick="vercolor(this,<?= $i ?>)">

												<td><?php echo $query['cedula']; ?></td>
												<td><?php echo $query['nombre']; ?></td>
												<td><?php echo $query['apellido']; ?></td>
												<td><?php echo $query['cargo']; ?></td>
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
							<!-- /.card-body -->
						</div>
						<!-- /.card -->

					</div>
					<!-- /.row (main row) -->
				</div>
			</div>
		</section>
	<?php

	}
	?>

	<?php
	//echo "</BR>: ". $_SESSION["id_perfil"].'----'.$nivel_org;
	/*echo "</BR>: ". $query2['id_div'];
echo "</BR>: ".$_SESSION["evaluador"];
echo "</BR>: ".$_SESSION["nivel_org"];*/
	$titulo_graf = "Coordinaciones";
	$enviar_th = 0;
	if (isset($_SESSION['id_perfil']) && $_SESSION["id_perfil"] <> 5) {
		//$href = '';
		switch ($_SESSION["id_perfil"]) {
			case 100:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalle_gerencia.php?nivel_org=";
				$q = $bd->getGerencias($_SESSION["evaluador"], 0);
				// echo "el centinela es: ". $cent;
				break;
			case 2:
				//echo '---------------------------------------------------------------------aqui'.$_SESSION["nivel_org"];
				//$enviar_th = $nivel_org <> 2000?1:0;//si el gerente es de la gerencia general de operaciones
				$qgo = $bd->getGerenciasOp($_SESSION["evaluador"]);

				if (!$qgo) {
					$enviar_th = 1;
				}
				$titulo_graf = "División";
				$ref = "detalle_division.php?nivel_org=";
				$q = $bd->getDivisiones($_SESSION["evaluador"], 1);
				//echo '---------------------------------------------------------------------avv'.count($q);
				break;
			case 3:
				/*$href = "detalle_coordinacion.php?nivel_org=";
			$dep = $bd->getDep($query2['id_div']);
			//echo "</BR>: id dep : ".$dep["id_dep"];
			if ($dep && $dep["id_dep"] != 0) {
				$q = $bd->getDepartamentos($_SESSION["evaluador"], 1);
				//echo "dep: ".$q['des'];
			} else {
				$q = $bd->getCoordinaciones($_SESSION["evaluador"], 0);
			}*/
				$q = null;
				if ($array_dep = $bd->getDepartamentos($_SESSION["evaluador"], 1)) {
					//; 
					//echo "wwwwwwwwwww";
					$q = $array_dep;
					//$href_dep = "detalle_departamento.php?nivel_org=";
				}

				if ($array_coord = $bd->getCoordinaciones($_SESSION["evaluador"], 0)) {
					//echo "wwwwwwwwwww".$evaluador["cedula"];
					//; 
					//if($array_dep){
					$q = $array_dep ? array_merge($array_dep, $array_coord) : $array_coord;
					//$href_coord = "detalle_coordinacion.php?nivel_org=";
					//}else{
					//	$q = $array_coord;
					//}

					//$q = array_merge($array_dep, $array_coord);
				}

				//siempre y cuando tenga departamento
				break;
			case 4:
				$ref = "detalle_coordinacion.php?nivel_org=";
				$q = $bd->getCoordinaciones($_SESSION["evaluador"], 0);
				break;

			case 6:
				//echo '---------------------------------------------------------------------aqui'.$_SESSION["nivel_org"];
				$titulo_graf = "Gerencias de Operaciones";
				$enviar_th = 1;
				$ref = "detalle_gerenciaOp.php?nivel_org=";
				$q = $bd->getGerenciasOp($_SESSION["evaluador"]);
				break;

			case 7:
				$titulo_graf = "Gerencias Funcionales";
				$ref = "detalle_gerencia.php?nivel_org=";
				$q = $bd->getGerencias('2222222'); //se debe consultar la cedula del gerente general o evaluador de los gerentes
				break;
				//case 5:

				//  break; 
			default:
				$msj = "";
		}

		// array_merge(array1, array2, array3...)
		$i = 0;
		$nivel_org = $_SESSION["nivel_org"];


		$unidad = "";
		if ($q) {
			foreach ($q as $q) {
				//echo "</br>-----".$q['id'] ;

				/*	if($_SESSION["id_perfil"] == 3){
			
			$evaluador = $_SESSION["evaluador"];
		}else{*/
				$eval = $bd->getEvaluadorCoord($q['id']);

				//}
				if ($eval) {
					$evaluador = $eval['cedula'];
					$sinUni = 1;
				} else {
					$evaluador = $_SESSION["evaluador"];
					$sinUni = 0;
				}
				//echo "</br>-----".$q['des'];
				//echo  "</br>sub: ".substr($q['des'],0,3);
				if (substr($q['des'], 0, 3) == 'DEP') {
					$href[$i] = "detalle_departamento.php?nivel_org=";
					//echo "</br>".'dep';
				} elseif (substr($q['des'], 0, 3) == 'COO') {
					$href[$i] = "detalle_coordinacion.php?nivel_org=";
					//echo 'coord';
				} else {
					$href[$i] = $ref;
				}
				//echo "</br>".$q['des'];
				//echo "</br>".strpos($q['des'],'GERENCIA DE');
				$longi = strpos($q['des'], 'GERENCIA DE') === false ? 9 : 12;
				$unidad = substr($q['des'], $longi);;
				//echo "----".$unidad;

				$coord[$i] = $q['id'] . '|' . $q['des'];
				$bdi = $bd->getResultadoxNivel('puntaje <= 8', $q['id'], $evaluador, $sinUni);
				$midatabd[$i] = $bdi['puntaje'];
				//echo "</br>-----";
				$da = $bd->getResultadoxNivel('(puntaje > 8 and puntaje <= 14)', $q['id'], $evaluador, $sinUni);
				$midatada[$i] = $da['puntaje'];
				$le = $bd->getResultadoxNivel('(puntaje > 14 and puntaje <= 18)', $q['id'], $evaluador, $sinUni);

				$midatale[$i] = $le['puntaje']; //
				$se = $bd->getResultadoxNivel('puntaje >= 19', $q['id'], $evaluador, $sinUni);
				$midatase[$i] = $se['puntaje'];
				//print_r($coord);
				$i++;
			}
		}
	?>

		<!-- Main content -->

		<section class="content" id="grafica" style="display: none">
			<div class="container-fluid">

				<div class="row">

					<div class="col-12">
						<div class="card">

							<div class="card-header">
								<h3 class="card-title">Resumen de evaluaciones por <?php echo $titulo_graf; ?> </h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<button type="button" class="btn btn-tool" data-card-widget="remove">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="chart">
									<canvas id="stackedBarChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->

					</div>
				</div>
				<!-- /.col (RIGHT) -->
			</div>


		</section>
	<?php
	}
	?>
	<input type="hidden" class="form-control" name="perfil" id="perfil" value="<?php echo $_SESSION["id_perfil"] ?>">









	<?php
	//echo '----------------------------------------------------------------------'.$cod_nivel;
	$tableresult =  '<div class="info-box-text font-weight-bold ">UNIDADES SIN COMPLETAR EL PROCESO DE EVALUACIÓN</div>';
	$des = '';
	$disabled = 'disabled';
	$finalizado = 0;
	if ($enviar_th) {
		$query3 = $bd->getEmpSinEval($cod_nivel);
		foreach ($query3 as $query3) {
			$des = des_nivel($bdn->getNivelOrg($query3["id_ccosto"]));
			$tableresult .= '<div class="">' . $des . '</div>';
		}

		if ($des == '') {
			$query4 = $bd->getEstatus_eval_gerencias($cod_nivel);
			foreach ($query4 as $query4) {
				$finalizado = 1;
			}
			$disabled = '';
			$tableresult =  '<div class="info-box-text font-weight-bold ">TODAS LAS UNIDADES COMPLETARON EL PROCESO DE EVALUACIÓN</div>';
		}
		//echo '----------------------------------------------------------------------'.$finaliado;
	?>

		<form id="myform" name="myform" role="form" method="post" action="actualiza_estatus.php" enctype="multipart/form-data">
			<section class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-12">
							<div class="info-box justify-content-center">
								<?php
								if ($finalizado == 0) {


								?>
									<div class="">
										<a href="#" id="btn_aprobar" onclick="document.myform.submit()" class="btn bg-gradient-primary <?php echo $disabled; ?>"><i class="fas fa-edit">Aprobar y Enviar</i></a>
										<a href="#" class="btn btn-outline-warning" data-toggle="tooltip" data-html="true" data-placement="top" title='<?php echo $tableresult; ?>'>Info</a>
									</div>
								<?php
								} else {
								?>
									<div id="msj_aprobado" class="alert alert-info alert-dismissible" role="alert" style="display: block">
										<strong>Proceso de Evaluación Finalizado...</strong>
									</div>

								<?php
								}
								?>

							</div>
						</div>
					</div>
				</div>
</div>
</section>
<input type="hidden" class="form-control" name="nivel_org" id="nivel_org" value="<?php echo $cod_nivel; ?>">
</form>
<?php

	}
?>
<!--  <img src="img/principal_png.png" style="display:block;margin:auto; " height="50%" width="50%"> -->
</div>

<script>
	/*$('.knob').knob({
'min':0,
'max':50,
'width':250,
'height': 250,
'cursor' : false,

});*/

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

	$(function() {
		$('[data-toggle="tooltip"]').tooltip({
			boundary: "window",
			template: '<div class="tooltip tooltip-custom" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
		});
	});


	$(document).ready(function() {
		$("#btn_aprobar").on('click', function() {
			// $("#marca option:selected").each(function () {
			marca = $(this).val();
			$.post("actualiza_eval_gerencia.php", {
				marca: marca
			}, function(data) {
				$("#modelo").html(data);
				$("#modelo").removeAttr('disabled');
			});
		});
		//});
	});


	function cambiaColor(obj, rad, id) { // window.alert($("#"+rad+"").attr("class"));
		$("#" + obj + "").attr("class", "bg-success");
		//window.alert(rad);
		//window.alert($("#"+rad+"").val());				   
		/*$("#adicional").removeAttr('disabled');
		var grupo = $("#grupo").val();
		if (grupo < 4){
			$("#cc").css("display", "block");
			$("#un").css("display", "block");
			$("#car").css("display", "block");
		}else{
			$("#cc").css("display", "none");
			$("#un").css("display", "none");
			$("#car").css("display", "none");
			$("#tipoU").css("display", "none");
		}*/
	}

	function cambiar_color_over(celda, i) { //window.alert (celda.style.backgroundColor);
		celda.style.backgroundColor = "#f8f988";
	}

	function cambiar_color_out(celda, i) { //window.alert (i%2); 
		//celda.style.backgroundColor="#acbad5";
		if ((i % 2) == 0) {
			$("#mitr" + i).css('backgroundColor', '#f5f5f5');
		} else {
			$("#mitr" + i).css('backgroundColor', '#ffffff');
		}

	}


	function accion() {
		//$('#msj_alert').css("display", "block");
		$("#msj_alert").fadeIn(5);
		setTimeout(function() {
			$("#msj_alert").fadeOut(1500);
		}, 4000);
		// $("#msj_alert").fadeIn("slow");
		//window.alert('hoooooo');
	}

	var pnum = 15;
	var coord = 'micoord';

	jQuery(function() {

		//--------------
		//- AREA CHART -
		//--------------

		// Get context with jQuery - using jQuery's .get() method.
		/*var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

				var areaChartData = {
					labels: ['CALIDAD DE TRABAJO', 'CUMPLIMIENTO DE NORMAS', 'LEALTAD INSTITUCIONAL', 'INICIATIVA', 'TRABAJO EN EQUIPO'],
					datasets: [{
							label: 'SISTEMA',
							backgroundColor: 'rgba(60,141,188,0.9)',
							borderColor: 'rgba(60,141,188,0.8)',
							pointRadius: false,
							pointColor: '#3b8bba',
							pointStrokeColor: 'rgba(60,141,188,1)',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(60,141,188,1)',
							data: [3, 3, 2, 4, 3]
						},
						{
							label: 'SOPORTE',
							backgroundColor: 'rgba(210, 214, 222, 1)',
							borderColor: 'rgba(210, 214, 222, 1)',
							pointRadius: false,
							pointColor: 'rgba(210, 214, 222, 1)',
							pointStrokeColor: '#c1c7d1',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [3, 2, 2, 2, 1]
						},
						{
							label: 'TELECOMUNICACIONES',
							backgroundColor: 'rgba(110, 114, 122, 1)',
							borderColor: 'rgba(110, 114, 122, 1)',
							pointRadius: false,
							pointColor: 'rgba(110, 114, 122, 1)',
							pointStrokeColor: '#c1c7d1',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [4, 2, 4, 3, 3]
						},
					]
				}

				var areaChartOptions = {
					maintainAspectRatio: false,
					responsive: true,
					legend: {
						display: true
					},
					scales: {
						xAxes: [{
							gridLines: {
								display: false,
							}
						}],
						yAxes: [{
							gridLines: {
								display: false,
							}
						}]
					}
				}

				// This will get the first returned node in the jQuery collection.
				new Chart(areaChartCanvas, {
					type: 'line',
					data: areaChartData,
					options: areaChartOptions
				})
				//-------------
				//- DONUT CHART -
				//-------------
				// Get context with jQuery - using jQuery's .get() method.
				var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
				var donutData = {
					labels: [
						'Coordinación de Sistemas',
						'Cordinación de Soporte Técnico',
						'Telecomunicaciones, Redes y Telefonía',

					],
					datasets: [{
						data: [160, 410, 360],
						backgroundColor: ['#007bff', '#dc3545', '#28a745'],
					}]
				}
				var donutOptions = {
					maintainAspectRatio: false,
					responsive: true,
				}
				//Create pie or douhnut chart
				// You can switch between pie and douhnut using the method below.
				new Chart(donutChartCanvas, {
					type: 'doughnut',
					data: donutData,
					options: donutOptions
				})
				//-------------
				//- PIE CHART -
				//-------------
				// Get context with jQuery - using jQuery's .get() method.
				var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
				var pieData = donutData;
				var pieOptions = {
					maintainAspectRatio: false,
					responsive: true,
				}
				//Create pie or douhnut chart
				// You can switch between pie and douhnut using the method below.
				new Chart(pieChartCanvas, {
					type: 'pie',
					data: pieData,
					options: pieOptions
				})






				var areaChartData2 = {
					labels: ['FACTOR I', 'FACTOR II', 'FACTOR III', 'FACTOR IV', 'FACTOR V'],
					datasets: [{
							label: 'OBRERO',
							backgroundColor: 'rgba(60,141,188,0.9)',
							borderColor: 'rgba(60,141,188,0.8)',
							pointRadius: false,
							pointColor: '#3b8bba',
							pointStrokeColor: 'rgba(60,141,188,1)',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(60,141,188,1)',
							data: [3, 3, 2, 4, 3]
						},
						{
							label: 'EMPLEADO',
							backgroundColor: 'rgba(210, 214, 222, 1)',
							borderColor: 'rgba(210, 214, 222, 1)',
							pointRadius: false,
							pointColor: 'rgba(210, 214, 222, 1)',
							pointStrokeColor: '#c1c7d1',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [3, 2, 2, 2, 1]
						},
						{
							label: 'ALTO NIVEL Y DIRECCIÓN',
							backgroundColor: 'rgba(110, 114, 122, 1)',
							borderColor: 'rgba(110, 114, 122, 1)',
							pointRadius: false,
							pointColor: 'rgba(110, 114, 122, 1)',
							pointStrokeColor: '#c1c7d1',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [4, 2, 4, 3, 3]
						},
					]
				}




				//-------------
				//- BAR CHART -
				//-------------
				var barChartCanvas = $('#barChart').get(0).getContext('2d')
				var barChartData = $.extend(true, {}, areaChartData2)
				var temp0 = areaChartData2.datasets[0]
				var temp1 = areaChartData2.datasets[1]
				barChartData.datasets[0] = temp1
				barChartData.datasets[1] = temp0

				var barChartOptions = {
					responsive: true,
					maintainAspectRatio: false,
					datasetFill: false
				}

				new Chart(barChartCanvas, {
					type: 'bar',
					data: barChartData,
					options: barChartOptions
				})


		*/

		let coord = <?php echo json_encode($coord); ?>;
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
		// micoord = <?php echo json_encode($coord); ?>;
		var n = coord.length;
		for (var i = 0; i < n; i++) {
			var des_coord = coord[i].split('|');
			micoord.push(des_coord[1]);
			mi_idcoord.push(des_coord[0]);
		}

		//window.alert(micoord);//[2]
		//coord='fdddd';		
		/*	<a href="index.php" class="brand-link">
			<img src="dist/img/Logo.jpg" alt="Logo" class="brand-image elevation-3" >
			<span class="brand-text font-weight-light">MINERVEN</span>
		  </a> */
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
		} //---------------------
		//- STACKED BAR CHART -
		//---------------------
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
			/*onClick: (e) => {
				
				window.alert(Chart.stackedBarChartCanvas.labels[0]);
			}*/
		}

		var myChart = new Chart(stackedBarChartCanvas, {
			type: 'bar',
			data: stackedBarChartData,
			options: stackedBarChartOptions
			/*onClick: (e) => {
				window.alert('stackedBarChartCanvas');
			}*/
		})



		/*	var canvas = document.getElementById('stackedBarChart');
		canvas.onclick = function (evt) {

			window.alert(stackedBarChartCanvas);
   
		};*/
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

					//window.alert(href);
				}
				/*else{
							window.alert('no');	
						}*/

			}

		)

	})
</script>