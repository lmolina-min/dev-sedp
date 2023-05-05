<?php
//session_start();
require_once('./acceso/conection.php');
//include_once './Model/bd.php';
//$con = new bd();
//echo $_POST['marca'];
//$id_personal = $_POST['id_personal'];
$id_nomina = $_POST['id_nomina'];


						/*$nivel_personal = 3; */ 
						$oTiutlo = ''; $osubtitulo= ''; $check =''; $onivel =1;	$i=0; $k=0; $j=1;
				        $tabla = '';
	  					$query2 = $bd->getFormatoEval($id_nomina);
                             foreach ($query2 as $query2) {    
									
								$titulo         = $query2['titulo'];
								$subtitulo      = $query2['subtitulo'];
								$descripcion    = $query2['descripcion'];
								$id_item_factor = $query2['id_item_factor'];
								$nivel          = $query2['nivel'];
								$valor          = $query2['valor'];
								$k++;
							/*	$check .=  '
											<th ><div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor."|".$id_item_factor.'" onChange="cambiaColor(\'ti'.$j.'\',this.id,'.$id_item_factor.')" required>
                          						<label for="customRadio'.$k.'" class="custom-control-label">'.$valor.'</label>
												</div></th>';*/
								 
								 $check .=  '
											<th ><div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor."|".$id_item_factor.'" onChange="cambiaColor(\'ti'.$j.'\',this.id,'.$id_item_factor.')" required>
                          						<label for="customRadio'.$k.'" class="custom-control-label"></label>
												</div></th>';
								 
                             //  echo '</br>';
							  if ($onivel == 1){
								  $onivel++;
								  $tabla .= '<div class="card-header">
                							<h3 class="card-title">EVALUACION DE DESEMPEÑO - '. $nivel .'</h3>
										</div>
              							<div class="card-body">';
							  } 
								 
								 
							   if ($titulo != $oTiutlo){
								   $oTiutlo = $titulo;  $i++; 
								 /*   if ($i==0){
										 echo '</table>';
										$i=1;
									}*/
								   
								   
								   $tabla .= '<div class="card-header ">
                							<h3 class="card-title">'.$titulo.'</h3>
              							</div>'; 
								    
								   if ($subtitulo != $osubtitulo){ //echo $subtitulo. '</br>';
								   	   $osubtitulo = $subtitulo;
									   $tabla .=  '
									   			<table id="example1" class="table table-bordered table-striped">
                  									<thead>
                    									<tr class="bg-warning" id="ti'.$j.'" >
                      										<th colspan="4" >'.$subtitulo.'</th>
                      
                    									</tr>
                  									</thead>';
									   	$tabla .=  '<tbody>
                    							<tr>
                      								<td>'.$descripcion.'</td>';
									   
									  
								  }
								   
							   }else{ 
								  $tabla .=  '<td>'.$descripcion.'</td>'; 
								   
								   $i++;
								    if ($i==4){
										   $tabla .=  '</tr>
                  									</tbody>';
										   $tabla .=  '<thead>
                    								<tr align="center">
														'.$check.'
													</tr>
												  </thead>';
										   $tabla .=  '</table>';
										   $check = '';
										   $i = 0;$j++;
									 }
							   }
								
                           }
				 echo $tabla;






//$row = $con->exec($query);*/
 
/*  $q="INSERT INTO sc_datos_personas (cedula, foto, pc_serial,id_vehiculo,id_huellas) VALUES ('" . $_POST['cedula'] . "', '" . $foto . "', '" . $_POST['token'] . "', '" .$id_vehiculo . "','" . $id_huella . "')";*/

//}
?>