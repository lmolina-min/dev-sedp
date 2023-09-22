<?php
$id_evaluacion = $_GET['id_evaluacion'];
$id_nomina = $_GET['id_nomina'];
$id_empleado = $_GET['id_empleado'];
$empleado = $_GET['empleado'];
?>

<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">Evaluación de <?= $empleado ?></h2>
					<p class="text-secondary">Formato de edición</p>
				</div>
			</div>
		</div>
	</div>


	<section class="content">
		<div class="container-fluid">
			<form data-toggle="validator" method="POST" action="/apis/evaluacion/edit.php" enctype="multipart/form-data">
				<div class="row" id="formato">
					<div class="col-12">
						<div class="card card-dark elevation-1">
							<?php
							$formato_editar = $bd->getFormatoEditar($id_nomina, $id_evaluacion);
							$i = 0;
							foreach ($formato_editar as $formato_editar) {
								$calif_actual[$i]  = $formato_editar['id_calificacion'];
								$i++;
							}

							$oTiutlo = '';
							$osubtitulo = '';
							$check = '';
							$onivel = 1;
							$i = 0;
							$k = 0;
							$j = 1;
							$tabla = '';
							$checked = '';
							$formato_eval = $bd->getFormatoEval($id_nomina);
							foreach ($formato_eval as $formato_eval) {
								$titulo          = $formato_eval['titulo'];
								$subtitulo       = $formato_eval['subtitulo'];
								$descripcion     = $formato_eval['descripcion'];
								$id_calificacion = $formato_eval['id_calificacion'];
								$nivel           = $formato_eval['nivel'];
								$valor           = $formato_eval['valor'];
								$k++;

								if (($calif_actual[$j - 1]) === $id_calificacion) {
									$checked = 'checked';
								} else {
									$checked = '';
								}

								$check .=  '
								<th>
									<div class="custom-control custom-radio">
										<input class="custom-control-input" type="radio" id="customRadio' . $k . '" name="customRadio' . $j . '" value="' . $valor . "|" . $id_calificacion . '" onchange="chgEvaluationCheckbox(\'ti' . $j . '\',this.id,' . $id_calificacion . ')" required ' . $checked . '>
                    <label for="customRadio' . $k . '" class="custom-control-label"></label>
									</div>
								</th>';

								if ($onivel == 1) {
									$onivel++;
									$tabla .= '
									<div class="card-header d-flex flex-row justify-content-between align-items-center">
										<h4 class="w-100 fs-6 fw-bold m-0">EVALUACIÓN DE DESEMPEÑO - '. strtoupper($nivel) .'</h4>
										<div class="text-end card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="maximize">
												<i class="fas fa-expand"></i>
											</button>
										</div>
									</div>
									<div class="card-body">';
								}


								if ($titulo != $oTiutlo) {
									$oTiutlo = $titulo;
									$i++;
									$tabla .= '<h5 class="fs-6 fw-semibold">'.ucfirst(strtolower($titulo)).'</h5>'; 

									if ($subtitulo != $osubtitulo) {
										$osubtitulo = $subtitulo;
										$tabla .=  '
										<div class="table-responsive">
										<table class="table table-bordered elevation-1">
											<thead>
												<tr style="background-color: #78b4f3;" id="ti'.$j.'" >
													  <th colspan="4"><span class="fw-normal fs-6">'.$subtitulo.'</span></th>
												</tr>
											</thead>';
										$tabla .=  '
											<tbody>
												<tr>
													  <td width="100"><p class="bg-light">'.$descripcion.'</p></td>';
									}
								} else {
									$tabla .=  '<td width="100"><p class="bg-light">'.$descripcion.'</p></td>'; 
									$i++;
									if ($i == 4) {
										$tabla .=  '
												</tr>
											</tbody>';
										$tabla .=  '
											<thead>
												<tr align="center">
													'.$check.'
												</tr>
											</thead>';
										$tabla .=  '
										</table>
										</div>';
										$check = '';
										$i = 0;
										$j++;
									}
								}
							}
							
							$tabla .= '
							</div>
							<input type="hidden" name="id_evaluacion" value="'.$id_evaluacion.'">
							<div class="card-footer text-center">
								<button type="submit" class="btn btn-lg btn-primary fw-bold fs-4">Guardar</button>
								<button type="button" class="btn btn-lg btn-secondary fw-bold fs-4" onclick="history.back()">Volver</button>
							</div>';
							
							echo $tabla;
							?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>