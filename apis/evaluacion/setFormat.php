<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');
$id_nomina = $_POST['id_nomina'];

$oTiutlo = ''; 
$osubtitulo= ''; 
$check =''; 
$onivel =1;	
$i=0; 
$k=0; 
$j=1;
$tabla = '';
$query2 = $bd->getFormatoEval($id_nomina);

foreach ($query2 as $query2) {    								
	$titulo         = $query2['titulo'];
	$subtitulo      = $query2['subtitulo'];
	$descripcion    = $query2['descripcion'];
	$id_item_factor = $query2['id_calificacion'];
	$nivel          = $query2['nivel'];
	$valor          = $query2['valor'];
	$k++;
								 
	$check .=  '
	<th>
		<div class="custom-control custom-radio">
			<input style="cursor: pointer;" class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor."|".$id_item_factor.'" onchange="chgEvaluationCheckbox(\'ti'.$j.'\',this.id,'.$id_item_factor.')" required>
        	<label for="customRadio'.$k.'" class="custom-control-label"></label>
		</div>
	</th>';
	
	if ($onivel == 1) {
		$onivel++;
		$tabla .= '
		<div class="card-header">
            <h3 class="card-title">EVALUACIÓN DE DESEMPEÑO - '. strtoupper($nivel) .'</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="maximize">
					<i class="fas fa-expand"></i>
				</button>
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
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
                    <tr class="bg-secondary" id="ti'.$j.'" >
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
		if ($i==4) {
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
<div class="card-footer text-center">
    <input type="submit" id="saveChanges" class="d-none d-sm-inline btn btn-lg btn-primary fw-bold fs-4" value="Confirmar Evaluación">
    <input type="submit" id="saveChanges" class="d-inline d-sm-none btn btn-lg btn-primary fw-bold fs-4 w-100" value="Evaluar">
</div>
';
echo $tabla;
