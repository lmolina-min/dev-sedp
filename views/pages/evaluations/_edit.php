<?php
$id_eval = $_GET['id_eval'];
$id_nomina = $_GET['id_nomina'];
$id_emp = $_GET['id_emp'];
$nombre_emp = $_GET['nombre_emp'];
?>

<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">Evaluación de <?= ucwords(strtolower($nombre_emp)) ?></h2>
					<p class="text-secondary">Formato de edición</p>
				</div>
			</div>
		</div>
	</div>


	<section class="content">
		<div class="container-fluid">
			<form data-toggle="validator" id="myform" name="myform" role="form" method="POST" action="/apis/evaluations/edit.php" enctype="multipart/form-data">
				<div class="row" id="formato">
					<div class="col-12">
						<div class="card card-dark elevation-1">
							<?php
							$query1 = $bd->getFormatoEditar($id_nomina, $id_eval);
							$i = 0;
							foreach ($query1 as $query1) {
								$item_factor_actual[$i]  = $query1['id_item_factor'];
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
							$query2 = $bd->getFormatoEval($id_nomina);
							foreach ($query2 as $query2) {
								$titulo         = $query2['titulo'];
								$subtitulo      = $query2['subtitulo'];
								$descripcion    = $query2['descripcion'];
								$id_item_factor = $query2['id_item_factor'];
								$nivel          = $query2['nivel'];
								$valor          = $query2['valor'];
								$k++;

								if (($item_factor_actual[$j - 1]) === $id_item_factor) {
									$checked = 'checked';
								} else {
									$checked = '';
								}

								$check .=  '
								<th>
									<div class="custom-control custom-radio">
										<input class="custom-control-input" type="radio" id="customRadio' . $k . '" name="customRadio' . $j . '" value="' . $valor . "|" . $id_item_factor . '" onchange="chgEvaluationCheckbox(\'ti' . $j . '\',this.id,' . $id_item_factor . ')" required ' . $checked . '>
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
							<input type="hidden" name="id_eval" value="'.$id_eval.'">
							<div class="card-footer text-center">
								<button type="submit" class="btn btn-lg btn-primary fw-bold fs-4">Guardar</button>
								<button type="button" class="btn btn-lg btn-outline-secondary fw-bold fs-4" onclick="history.back()">Volver</button>
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