<?php
//session_start();

include_once 'head.php';
include_once 'navbar.php';
include_once 'aside.php';
// require_once './acceso/conection.php';
// echo "la sesion del nivel org es:". $_SESSION["nivel_org"];

$bd_servidor	= "localhost";
$bd_nombre		= "test"; //"bd_combustible";//
$bd_puerto		= "3306";
$bd_usuario		= "root";
$bd_clave		= "";
$bd_tipo 		= "mysql";

$bdt = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);


$query2 = $bdt->getNivelOrg($_SESSION["nivel_org"]);
foreach ($query2 as $query2) {
	//id_ger_gral 	 	id_ger 	gerencia 	id_ger_oper 	gerencia_gral_op 	id_div 	division 	departamento 	coordinacion 	oficinas 	
	//$nivel = $query2['gerencia_gral']."/"  ;
	$nivel = $query2['gerencia'];
	$nivel .= $query2['gerencia_gral_op'] != '' ? " --> " . $query2['gerencia_gral_op'] : '';
	$nivel .= $query2['division'] != '' ? " --> " . $query2['division'] : '';
	$nivel .= $query2['departamento'] != '' ? " --> " . $query2['departamento'] : '';
	$nivel .= $query2['coordinacion'] != '' ? " --> " . $query2['coordinacion'] : '';
	$nivel .= $query2['oficinas'] != '' ? " --> " . $query2['oficinas'] : '';

	$cod_nivel = $query2['id_ger'];
	$cod_nivel .= $query2['id_ger_oper'] <> 0 ? " |" . $query2['id_ger_oper'] : '';
	$cod_nivel .= $query2['id_div'] <> 0 ? "|" . $query2['id_div'] : '';
	$cod_nivel .= $query2['id_dep'] <> 0 ? "|" . $query2['id_dep'] : '';
	$cod_nivel .= $query2['id_coord'] <> 0 ? "|" . $query2['id_coord'] : '';
	//echo "<option value='".$query2['id']."'";
	// echo ">". strtoupper($query2['descripcion']). " </option>";
}
//	echo "----".$nivel;
$_SESSION['descripcion_nivel_org'] = $nivel . '|' . $cod_nivel;
require_once './acceso/conection.php';
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
			<?php $i = 1;
			$query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
			$total_emp = $bd->getDatosEmpleadosxNivelOrg($_SESSION["evaluador"]);
			$evaluados = count($query);
			foreach ($total_emp as $total_emp) {
				//echo "ddd: " . count($query);
				//print_r($query);
			}

			$progres_eval = round((count($query) * 100) / ($total_emp['total']));
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
											<small class="info-box-text"><?php echo $query['cargo']; ?></small>
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
		</div><!-- /.container-fluid -->
	<?php } else {


	?>

		<div class="col-12 col-sm-6">
			<div class="info-box">

				<div class="col-sm-12 text-center">
					<input type="text" class="knob" value="<?= $progres_eval; ?>" data-width="<?= $progres_eval; ?>" data-height="<?= $progres_eval; ?>" data-fgColor="#007bff">

					<div class="knob-label">Progreso de las Evaluaciones</div>
				</div><!-- /.col -->

				<!-- /.info-box -->
			</div>

		</div><!-- /.row -->
	</div><!-- /.container-fluid -->


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
									echo  count($query);
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
//echo 
if ($_SESSION["id_perfil"] < 5) {
?>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Monthly Recap Report</h5>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
								<div class="btn-group">
									<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
										<i class="fas fa-wrench"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right" role="menu">
										<a href="#" class="dropdown-item">Action</a>
										<a href="#" class="dropdown-item">Another action</a>
										<a href="#" class="dropdown-item">Something else here</a>
										<a class="dropdown-divider"></a>
										<a href="#" class="dropdown-item">Separated link</a>
									</div>
								</div>
								<button type="button" class="btn btn-tool" data-card-widget="remove">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-8">
									<p class="text-center">
										<strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
									</p>

									<div class="chart">
										<!-- Sales Chart Canvas -->
										<canvas id="salesChart" height="180" style="height: 180px;"></canvas>
									</div>
									<!-- /.chart-responsive -->
								</div>
								<!-- /.col -->
								<div class="col-md-4">
									<p class="text-center">
										<strong>Goal Completion</strong>
									</p>

									<div class="progress-group">
										Add Products to Cart
										<span class="float-right"><b>160</b>/200</span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary" style="width: 80%"></div>
										</div>
									</div>
									<!-- /.progress-group -->

									<div class="progress-group">
										Complete Purchase
										<span class="float-right"><b>310</b>/400</span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger" style="width: 75%"></div>
										</div>
									</div>

									<!-- /.progress-group -->
									<div class="progress-group">
										<span class="progress-text">Visit Premium Page</span>
										<span class="float-right"><b>480</b>/800</span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success" style="width: 60%"></div>
										</div>
									</div>

									<!-- /.progress-group -->
									<div class="progress-group">
										Send Inquiries
										<span class="float-right"><b>250</b>/500</span>
										<div class="progress progress-sm">
											<div class="progress-bar bg-warning" style="width: 50%"></div>
										</div>
									</div>
									<!-- /.progress-group -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</div>
						<!-- ./card-body -->
						<div class="card-footer">
							<div class="row">
								<div class="col-sm-3 col-6">
									<div class="description-block border-right">
										<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
										<h5 class="description-header">$35,210.43</h5>
										<span class="description-text">TOTAL REVENUE</span>
									</div>
									<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-6">
									<div class="description-block border-right">
										<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
										<h5 class="description-header">$10,390.90</h5>
										<span class="description-text">TOTAL COST</span>
									</div>
									<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-6">
									<div class="description-block border-right">
										<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
										<h5 class="description-header">$24,813.53</h5>
										<span class="description-text">TOTAL PROFIT</span>
									</div>
									<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-6">
									<div class="description-block">
										<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
										<h5 class="description-header">1200</h5>
										<span class="description-text">GOAL COMPLETIONS</span>
									</div>
									<!-- /.description-block -->
								</div>
							</div>
							<!-- /.row -->
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
	</section>



	<div class="row">

		<!-- /.col -->
		<div class="col-md-4">
			<p class="text-center">
				<strong>Resumen Coordinaciones</strong>
			</p>

			<div class="progress-group">
				Coordinación de Sistemas
				<span class="float-right"><b>160</b>/200</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-primary" style="width: 80%"></div>
				</div>
			</div>
			<!-- /.progress-group -->

			<div class="progress-group">
				Cordinación de Soporte Técnico
				<span class="float-right"><b>310</b>/400</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-danger" style="width: 75%"></div>
				</div>
			</div>

			<!-- /.progress-group -->
			<div class="progress-group">
				<span class="progress-text">Telecomunicaciones, Redes y Telefonía</span>
				<span class="float-right"><b>480</b>/800</span>
				<div class="progress progress-sm">
					<div class="progress-bar bg-success" style="width: 60%"></div>
				</div>
			</div>

		</div>
		<!-- /.col -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Resultados por Coordinaciones</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="row">
					<div class="col-md-8">
						<div class="chart-responsive">
							<canvas id="pieChart" height="150"></canvas>
						</div>
						<!-- ./chart-responsive -->
					</div>
					<!-- /.col -->
					<div class="col-md-4">
						<ul class="chart-legend clearfix">
							<li><i class="far fa-circle text-primary"></i> Coordinación de Sistemas</li>
							<li><i class="far fa-circle text-danger"></i> Cordinación de Soporte Técnico</li>
							<li><i class="far fa-circle text-success"></i> Telecomunicaciones, Redes y Telefonía</li>

						</ul>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.card-body -->
			<div class="card-footer p-0">
				<ul class="nav nav-pills flex-column">
					<li class="nav-item">
						<a href="#" class="nav-link">
							United States of America
							<span class="float-right text-danger">
								<i class="fas fa-arrow-down text-sm"></i>
								12%</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							India
							<span class="float-right text-success">
								<i class="fas fa-arrow-up text-sm"></i> 4%
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							China
							<span class="float-right text-warning">
								<i class="fas fa-arrow-left text-sm"></i> 0%
							</span>
						</a>
					</li>
				</ul>
			</div>
			<!-- /.footer -->
		</div>
		<!-- /.card -->
	</div>
	<section class="slide fade-6 kenBurns">
		<div class="content">
			<div class="container">
				<div class="wrap">

					<div class="fix-12-12">
						<div class="row">
							<!-- AREA CHART -->

							<!-- /.card -->
							<!-- DONUT CHART -->
							<div class="card card-danger">
								<div class="card-header">
									<h3 class="card-title">Resumen Coordinaciones</h3>

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
									<canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
							<!--   <div class="col">
               <div onload="motorminero()" class="fix-3-12" >
                    <img id="img2" class="img-rounded" src="img/ws.jpeg" style="display: block;margin:auto  ">
                </div>
            </div>
 -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="background" style="background-image:url(img/ws.jpeg)"></div>
	</section>
	<section class="slide fade-6 kenBurns">
		<div class="content">
			<div class="container">
				<div class="wrap">

					<div class="fix-12-12">
						<div class="row">
							<!-- AREA CHART -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">FACTORES DE EVALUACIÓN POR CORDINACIONES</h3>

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
										<canvas id="areaChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
							-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="background" style="background-image:url(img/ws.jpeg)"></div>
	</section>
	<!-- Main content -->
	<section class="slide fade-6 kenBurns">
		<div class="content">
			<div class="container">
				<div class="wrap">

					<div class="fix-12-12">
						<div class="row">

							<!-- /.card -->

							<!-- BAR CHART -->
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Bar Chart</h3>

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
										<canvas id="barChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- STACKED BAR CHART -->
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Stacked Bar Chart</h3>

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
				<!-- /.row -->
			</div><!-- /.container-fluid -->
		</div><!-- /.container-fluid -->
	</section>
<?php
}
?>
</div>
<!--  <img src="img/principal_png.png" style="display:block;margin:auto; " height="50%" width="50%"> -->
</div>
</div>





<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


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





	$(function() {

		//--------------
		//- AREA CHART -
		//--------------

		// Get context with jQuery - using jQuery's .get() method.
		var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

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






		var areaChartData3 = {
			labels: ['COORDINACION I', 'COORDINACION II', 'COORDINACION III', 'COORDINACION IV', 'COORDINACION V'],
			datasets: [{
					label: 'Bajo Desempeño',
					backgroundColor: 'rgba(220,53,69,1)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: [12, 13, 12, 4, 13]
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
					data: [8, 2, 12, 2, 1]
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
					data: [14, 2, 4, 3, 1]
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
					data: [12, 4, 3, 35, 3]
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
			}
		}

		new Chart(stackedBarChartCanvas, {
			type: 'bar',
			data: stackedBarChartData,
			options: stackedBarChartOptions
		})

	})
</script>


<?php
include_once 'footer.php';
include_once 'scripts.php';
?>