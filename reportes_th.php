<?php
//session_start();

include_once 'head.php';
include_once 'navbar.php';
include_once 'aside.php';

require_once './acceso/conection.php';

//echo "-------------------------------------------------------------------------------------------".$_POST["nivel_org"];
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

		</div><!-- /.container-fluid -->
	</div><!-- /.container-fluid -->



    <section class="content">
      <div class="container-fluid">
		  	<form  data-toggle="validator" id="myform" name="myform" role="form" method="post" action="reportes_th.php" enctype="multipart/form-data" >
				<div class="row">
				  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">SELECCIONE LA UNIDAD ORGANIZATIVA <?php  //echo "El valor: ".$_SESSION["evaluador"]; //echo $_SESSION['nivel_org']; ?>  </label>
                   <!--    <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca" required> onChange="enviarNivelOrg()-->
                        <select class="form-control" name="nivel_org" id="nivel_org" placeholder="Unidad Administrativa" onchange="enviar_nivel_org(this)"  required>
						    <option></option>	
						  <?php
                             $query2 =$bd->getGerencias('2222222');
                             foreach ($query2 as $query2) {    
								//echo "<option value='".$query2['id']."'";
								echo "<option value='".$query2['id_ger']."'";
								if (isset($_POST["nivel_org"])) {
									if ($query2['id_ger'] === $_POST["nivel_org"]) {
										$id_marca = $query2['id'];
									echo ' selected="selected";';
									}
								}
                                echo ">". strtoupper($query2['des']). " </option>";
                           }
							//echo "----";.
                         ?>
                        </select>	
                    </div>
                  </div>		  
		       </div>	
            </form>
        </div>  
    </section> 
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
		//	echo "------------".$_POST["nivel_org"];
	//capturar el envio del nivel organizativo
    if (isset($_POST["nivel_org"])) {
		$query = $bd->getResultxGerencias($_POST["nivel_org"]);
		//$gerenciaOp = $evaluador["gerenciaop"];

		/*echo '	<section class="content">
							<div class="container-fluid">
					           <div class="row">		
						          <div class="col-12 col-sm-12">	
						              <div id="nivel" class="col-sm-12  alert bg-info" role="alert" style="display: block">
						                  <strong>' .   . '</strong>
					                  </div>	
						          </div>
					          </div>
				            </div>
						 </section>';*/

                       //  echo "eeee". $evaluador;
		
       // if ($evaluador) {




			/*$query = $bd->getEmpleadosEvaluados($evaluador["cedula"]);
			$total_emp = $bd->getDatosEmpleadosxNivelOrg($evaluador["cedula"]);
			$evaluados = count($query);
			foreach ($total_emp as $total_emp) {
				//echo "ddd: " . count($query);
				//print_r($query);
			}

			$progres_eval = $total_emp['total'] != 0 ? round((count($query) * 100) / ($total_emp['total'])) : 0;*/

	?>




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
					  <td><?php 
					  								$progres = $_SESSION['id_perfil']=='7'? $query['puntaje']:($query['puntaje'] * 100) / 20;
													//$progres = ($query['puntaje'] * 100) / 20;
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
															<div class="">
																<div class="text-center <?= $color ?>" role="" ><strong class=""><?php echo $progres . ' ptos'; ?></strong></div>
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

	

				<!-- Main content -->

<?php

			//}
	//	}
?>

<?php
	//}
?>
<input type="hidden" class="form-control" name="perfil" id="perfil" value="<?php echo $_SESSION["id_perfil"] ?>">
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

$(document).ready(function(){
    $("#nivel_org").on('change', function () {
        $("#nivel_org option:selected").each(function () {
            nivel = $(this).val();
			//window.alert(nivel);
          /*  $.post("reportes.php", { nivel_org: nivel }, function(data){
                $("#nivel_org").html(data);
				/*$("#modelo").removeAttr('disabled');*/

				//var textqr=$("#placa").val()+'|'+$("#modelo").val()+'|'+$("#marca").val()+'|'+$("#color").val()+'|'+$("#tipo_co").val()+'|'+$//("#tipo_v").val();
			//window.alert(textqr);
			//var sizeqr=$("#tipo_v").val();
			//var sizeqr= "300";
			//var nombreimg = $("#placa").val();
			parametros={"nivel_org":nivel};
			 $.ajax({
				type: "POST",
				url: "reportes_th.php",
				data: parametros,
				success: function(datos){
					//$("#nivel_org").html(datos);
					document.myform.submit();
				}
				 
			 });
			
            
        });
   });
});

/*$(document).ready(function() {
	// Function to convert an img URL to data URL
	/*function getBase64FromImageUrl(url) {
    var img = new Image();
		img.crossOrigin = "anonymous";
    img.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width =this.width;
        canvas.height =this.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0);
        var dataURL = canvas.toDataURL("image/png");
        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    };
    img.src = url;
	}

	//function enviar_nivel_org(obj){
    $("#nivel_org").on('change', function () {
       $("#nivel_org option:selected").each(function () {
			window.alert(this.value);
			//var porciones = pizza.split(' ');
			/*var nivel_org = $(this).val();//.split('|');
			//window.alert(ids[1]);
            //id_nomina=ids[1];
            $.post("reportes.php", { nivel_org: nivel_org }, function(data){
                //$("#tablaModelo").html(data);
				//$("#tablaModelo").removeAttr('disabled');
            });		
        })
   })
//}
*/
	// DataTable initialisation
	$('#example1').DataTable(
		{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": true,
			"autoWidth": true,
			"buttons": [
				{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
                title: "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO",
				className: 'btn btn-success'
			},
				{
					text: 'PDF',
					extend: 'pdfHtml5',
					filename: 'dt_custom_pdf',
                    title:  'ffff',
				    className: 'btn btn-danger',
					orientation: 'landscape', //portrait
					pageSize: 'A4', //A3 , A5 , A6 , legal , letter
					exportOptions: {
						columns: ':visible',
						search: 'applied',
						order: 'applied'
					},
					customize: function (doc) {
						//Remove the title created by datatTables
						doc.content.splice(0,1);
						//Create a date string that we use in the footer. Format is dd-mm-yyyy
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
						// Logo converted to base64
						// var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
						// The above call should work, but not when called from codepen.io
						// So we use a online converter and paste the string in.
						// Done on http://codebeautify.org/image-to-base64-converter
						// It's a LONG string scroll down to see the rest of the code !!!
					    var logo = "data:image/jpeg;base64,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IGRvdWJAb+AAAAAAAAAAAABCcmRUVW50RiNSbHQAAAAAAAAAAAAAAABCbGQgVW50RiNSbHQAAAAAAAAAAAAAAABSc2x0VW50RiNQeGxAUgAAAAAAAAAAAAp2ZWN0b3JEYXRhYm9vbAEAAAAAUGdQc2VudW0AAAAAUGdQcwAAAABQZ1BDAAAAAExlZnRVbnRGI1JsdAAAAAAAAAAAAAAAAFRvcCBVbnRGI1JsdAAAAAAAAAAAAAAAAFNjbCBVbnRGI1ByY0BZAAAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAIASAAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAHjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAjhCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAgAAAAAABAAAAABAAACQAAAAkAAAAAAOEJJTQQeAAAAAAAEAAAAADhCSU0EGgAAAAADWwAAAAYAAAAAAAAAAAAAALgAAADqAAAAEwBJAE0ARwAtADIAMAAyADEAMQAwADIAMAAtAFcAQQAwADAAMAAxAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAADqAAAAuAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAABAAAAABAAAAAAAAbnVsbAAAAAIAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAuAAAAABSZ2h0bG9uZwAAAOoAAAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNlAAAAEgAAAAdzbGljZUlEbG9uZwAAAAAAAAAHZ3JvdXBJRGxvbmcAAAAAAAAABm9yaWdpbmVudW0AAAAMRVNsaWNlT3JpZ2luAAAADWF1dG9HZW5lcmF0ZWQAAAAAVHlwZWVudW0AAAAKRVNsaWNlVHlwZQAAAABJbWcgAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAALgAAAAAUmdodGxvbmcAAADqAAAAA3VybFRFWFQAAAABAAAAAAAAbnVsbFRFWFQAAAABAAAAAAAATXNnZVRFWFQAAAABAAAAAAAGYWx0VGFnVEVYVAAAAAEAAAAAAA5jZWxsVGV4dElzSFRNTGJvb2wBAAAACGNlbGxUZXh0VEVYVAAAAAEAAAAAAAlob3J6QWxpZ25lbnVtAAAAD0VTbGljZUhvcnpBbGlnbgAAAAdkZWZhdWx0AAAACXZlcnRBbGlnbmVudW0AAAAPRVNsaWNlVmVydEFsaWduAAAAB2RlZmF1bHQAAAALYmdDb2xvclR5cGVlbnVtAAAAEUVTbGljZUJHQ29sb3JUeXBlAAAAAE5vbmUAAAAJdG9wT3V0c2V0bG9uZwAAAAAAAAAKbGVmdE91dHNldGxvbmcAAAAAAAAADGJvdHRvbU91dHNldGxvbmcAAAAAAAAAC3JpZ2h0T3V0c2V0bG9uZwAAAAAAOEJJTQQoAAAAAAAMAAAAAj/wAAAAAAAAOEJJTQQUAAAAAAAEAAAAAThCSU0EDAAAAAAVvgAAAAEAAACgAAAAfgAAAeAAAOxAAAAVogAYAAH/2P/tAAxBZG9iZV9DTQAB/+4ADkFkb2JlAGSAAAAAAf/bAIQADAgICAkIDAkJDBELCgsRFQ8MDA8VGBMTFRMTGBEMDAwMDAwRDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAENCwsNDg0QDg4QFA4ODhQUDg4ODhQRDAwMDAwREQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgAfgCgAwEiAAIRAQMRAf/dAAQACv/EAT8AAAEFAQEBAQEBAAAAAAAAAAMAAQIEBQYHCAkKCwEAAQUBAQEBAQEAAAAAAAAAAQACAwQFBgcICQoLEAABBAEDAgQCBQcGCAUDDDMBAAIRAwQhEjEFQVFhEyJxgTIGFJGhsUIjJBVSwWIzNHKC0UMHJZJT8OHxY3M1FqKygyZEk1RkRcKjdDYX0lXiZfKzhMPTdePzRieUpIW0lcTU5PSltcXV5fVWZnaGlqa2xtbm9jdHV2d3h5ent8fX5/cRAAICAQIEBAMEBQYHBwYFNQEAAhEDITESBEFRYXEiEwUygZEUobFCI8FS0fAzJGLhcoKSQ1MVY3M08SUGFqKygwcmNcLSRJNUoxdkRVU2dGXi8rOEw9N14/NGlKSFtJXE1OT0pbXF1eX1VmZ2hpamtsbW5vYnN0dXZ3eHl6e3x//aAAwDAQACEQMRAD8A9VSSSSUpJJJJSkkkklKSSSSUpJJJJSkkkklKSSSSUpJJJJSkkkklKSSSSU//0PVUkkklKSSSSUpJJReXBjiwbngEtadJPZJTJJeFv+sX1oyckm/qmVRkWP22MN5x62WTsfW5u6qnGZW/2e/Zs/wi1OsYv146Ph42XmdTy667qwbJzRLbS97RjVMZe6zJ/Qejfvo9T/Cf6NT/AHeqBkLK3j8H2BJec/4vvrhlu+2dO6tkPyjTS7KxbLCHWFteuTj+o87rnfQtp3f8L+ZWtPI+tfVXncwMpadQxo3GD+8+zdu/ssYqXN8xDlSI5LJOsRHqP8JkxwM9R+L2aS4vG+umZXa1uVWHscQ0uEaSY4YGKl/jF+tmZjnF6V0u9+LbbWMnLtqMWNY7THoZa33V+o5tlluz9Jsrr/0qXKcxDmZGMLjICyJj9H9708SskDAWfwfQUl490XF+u/WsbJycLqeXYyiourjNEuuDmNbi21vvbbj76Tdd6lzNnsZ/pFl/84vrRjXzV1XKsvqdDGi85DHPHtawN3XY+S17/Z7fUZYrv3eyQJCwx8fg+6pIdDrHU1m5oZcWA2MBkBxHvaP6rkRQLlJJJJKUkkkkp//R9VSSSSUpJJJJTT6pnNwsR1sgPPtrnxj6X9hvvXA29Yz25P2hriWh07DyR52/znq/y9y1+v8AUPtuS5tZmiuWMjgwf0j/AO28f9tsWDcxc/zvMDNmI3x4/TDz/Sm28UOGPidT/Bo/XjpVVvp/WDEG7Gz4rzQ0AbbnDbVkQ36P2xjfSu9v9Mq/4ZV8XF+s31rpewNbfjYfqWUFra2il9dOyrp+K1rmW4+PlNZj1ek/9Fvr+0/zvrLoOj241zL+jZ7d+Fmtc3b311sDJ3bbG7ftNH/DV/y1y7LOt/VXq2TgYr215++qv7VtaXWVB3q43pOe702Y2a59dmQ3/g/Q9Wv07FvfC+bOfB7ciDmwULl+nj/Qyf8AczaufHwysfLLt3aVN2b0Tq1d5r25eBaHPoLmmY9t+LY6s2M/TUvsot/rrt7qqhBx3b8axrbcawz7qbB6uO/X/g3bHfy2LkuofVjrWBhV9RvwnY+PcLbbaw3aMeLTW2q3e72+pvY/Hb7/AGLa+qeY3K6Xb095/T9NPqU/ysW53uZ/6CZjv+2cpN+Ncv73Le7HWWDU1/m/0/8AF+dPLT4Z8J2l+fR0+nY1Lsz18l2zFxGuyL7Dw1jAXud/Ya1zlxOVk5fXesW5IrnK6hb+iolrSAfZjYzXP9Kv9FS2ulv766X615owui19Or0yOquL7j3GNU4S3/0JyWsq/wCKx7Vg4H1a611DDszsfCfkY9TW2sbG5t/6VtT6K9rtztv6R9zPp+nX/wAIh8F5f2sBzz0lnrhv/NR+T/H+dXMz4p8I2jv/AHm9k4f1n+qVNToFGPmCq3I3NrcLLHVvY7pmUx7nPyKcdjr/AFKmN9L9L62/+ZVTodbOn4z+vWhoGKTR0xjtrpyQ335Wyzfvq6XS7f8AQ/pj6P8ARqWRkdd+s/VMbp2W5j88W21st2NaamOIsyWWOrOx+Lhek+2pv02fzPq2eoq/1hz8fJurwungs6bhMFOIw8lgO43WaM/T5lv61e7Z/olb5rMcePh09zJ1j+7+8y8jgGTIZyF48WpB/Tn+hj/wv0v6jnjqWccz7b6r/W37/U3H1JmfU9f+d9f/AITcva/qf18dc6PXfY4Oy6f0WVECXAS27a3b7b2fpPo/T9Sv/BrxBrF0n1J+sB6H1ZjrXRhXxVkjsGk+y7/0Hsdv/wCJfcs/HLhl4Hd0uYxSzYiCTKcfVjJ/52Mf1Zvs6SSStOMpJJJJT//S9VSSSSUpZX1hzzjYgx6TGRlSxkctb/hrf7Lf+rWm5zWNL3kNa0EucdAAOSVx1mS7qOTb1F0hlnsxWntS06O/6673ql8R5n2cJAPryemP/dSZcMOKWuw1adlYAgcDQKpaxaNjVVsrJMNEk6AeJK5+JbZW6L06zL6jWW6NpcDP8oztH9hv6V6vf4yfqwM7pLep4jC7L6dWW2AAE2Y3+Fbx734/9Iq/6+z/AAy3/q705uJiiwj3v4PjP0n/ANv/AM9+mtdb/wAKxSxR98/Nkqh/qh8v+P8AM1M8hI8PSP8A0nxeu76w/WjHo6ZTjepgYgBw3VVOdXj/AGfHeGY32kbvUdmVbG/rT9/2n0vS2V/o1P6nY+Xj/WG2nIpsx7RgZRuptaWPDSyt7PUrfDm+703K51unqH1E6/kW9IDa8fqTA7EseC5jGNsF2Vh+j7GPc1+xlb3/AMzh3fof0u+xD+phdd1LrXUms2B1Gwt3F+12Ze1zmerZ+ks9tD/dZ+k2LW5mYHK55UOD2pEf4rBAXOI68QRfXbHyr+vYlOPU++x/Tcc001NL3uA+0Ps9Otnud7vUcg+r9Yvqtj24VmL6eFnBrsx91TxXeL6Gj7E7Ids9J+JX6v8AR3Mu+0ep6n6L9Grn13b6WZ0TqDm72tqdWWhxYScW8XMr9Wv9JV7L/p1+9S6QzqH1969jnqwa6jpwc/Msr3NY6p9nq42F6MvrY9z22U+q39Ldg1/p/wBNWyxDlJiXKYJUOD2o34VFWQfrJjrxF6D/ABa/VZuL0l/U8xh9fqVXpUtOhZin6PYbX5f8+/8A4P7OuA630jI6T1O7Cv1fU6A7s5sTXY3/AI2v3r3gAAQNAOAuO/xj/V8Z3Tx1Whs5GC0i4Dl1E7nHj/tM79N/xX2hVeYudz6j/ot/4flEJ+1L5clUf3ckfk/xvkfLA1SDVINUgFUt2owfU/8AF51/9o9K/Z+Q6cvpwDNeX0n+j2cN+hHoP/4ve/8AnV1i8P6J1e7ofVKOp1SW1Hbk1jl9Dv55nLfo/wA7X/wtbF7ZRfTkUV5FDhZTc1tlbxw5rhuY4f1mlWsU+KPiHF+Icv7WYkD05PUPP9JIkkkpGk//0/VUkkklPP8A1ozHWup6LQ4izKHqZTh+ZjtPu/7ff+i/z1SLWgBrRtaBDQOwHCHnObg/WLPOaRV9tFT8W5+jXMY0V2Uh/wCa5lnu2Jzl4buL6z8HBc18SyTnzMhIECHpj5d27hiBAV11R2NRul4P2rLaD9Furj4D87/O+g1DdZUfova6dAAZJXSdIwji4oLxF1sOePD9yv8Asf8AVochyxz5REj9XH1ZPL9z/DTlnwRvqdm6AGgACANAAnSSXTNFwPrnh9Mzuktxc9j7H2Wt+yNpcG2+tr7q3vbZWz9F6vq+oz0/RXP9K6PT0rEdi0sj1LG25F77BZZY5gLKa/ZXTXVTVvf7VpdSymO+sGT9tsbScRjK8KuwhoLLWh9+Szf9N1ln6v7f9Eom/Gd9G6s/BwKwviPxDMZz5eJMcPyyjXznzbeHDGhMi5bho9U6bgdUwhiZrXj07DbRfSQLK3OGywe9tldldjW++ty6H6o9L6X0vpXodO3kOeX32WkOse8x7nloYz+baxlexjFkO2u+iQfgVe6DZfXmek0E1vB3fllN5D4jmhLHglMywk8Ax0PTx/LKP6fzKy4YkSkBUt7elTOa1zS1wDmuEFp1BB7FOkt9qPjH1p6Eeh9YsxGg/ZbB6uI4z/Nk/wA3J3e/Hd+i/qenZ+esoBeufXX6vnrfR3ChoOdiTdiHSSQP0lE/92Gez/jfSXkXq1gkPcK3tJDmP9rmkaOa5rvouaqmWHDLTY7PR/D+ZGbH6iPchpK/0v6zID/cu9/xZdeJZb9Xcl3vxwb8En86lx/S08f9p7Xfvfzdv7lK8/8AtGP/AKVn+cFsfUyq7N+tvTjgnccRz7sm5mrWVFjq3Me7/uxu9JLCSJjTdXxKGKfLyJkOKGsdfwfZkkklbecf/9T1VCGVikwLmEkwBuHP3oq+eG4bnU5OVQxrXYj2u3Aag2WProeD/JuYxS4sXHetVX4rZSp+gcqvEsr25ja31EiG2hpbPb+c9u5ArwejPn0sfGdt52sYYn+qF539fepf84D9XcHHG92bSMw18t3XhtdH/bW3MRf8Uja9nWyxoa11eMdBHIy0JctEw45AE9iPHhSJm6D6FRV0wWA4zKBYBINYZuj+wjC+gv8ATFjC+SNgcJkcjavI/wDFMxjfrIC1oBOBZJAj8/GWP10nH+tHU8mg+jkVZ9z6rmgbmvFhcx4P9dOjy0RIwiQKF6BBnpZfdn2V1gGxzWAmAXEDX5pvXp9P1fUb6Z4fI2+H0l5l9b+v0fWP6ldPyy1rchmeyrMojRlopyN23f8A4Kxv6an/AIN/+kTZLGf+M/iN2jb640jT+mWIeyaFmiZcFK4vyt9HuPTL9vrmi3bO3fsdE87dyavH6W6fSqoO3V21rDHxheMdD6P9UcvFss6z1P8AZuQ20trpbWxwdWGsc273VWfSsdYz/ra7j6o9H+ruD07rN/Q+oHqLLafTvljWhpYy17fo11bt7bUMnLwFk6nxh/3SRM/yL14PS+3ofLYjU/Z4Jo2RwSyP++rwv6qdG6H1TL+z9XymdOx24/qNvLqq91gNbfS35TXM9zHvf++rXT2t6R9b6Kvq9lHKrGXVTVfXDRfW91f2iqxrP0VtbZtY63+b/Rfaa9id90gCaoSAv5a/5yPcJ/332tuRjvdsbaxzjIDQ4E6c6KT3sY0ue4NaOXEwF499acUfVf68/tChgbX6tfUatmhLHu251P8Aac3J9n7l1a6X/Gv1SsdJwunMdLc6w32EfRNNAD/d/Wvtx3/9bQ9nWFGxP+RVxb+D3P2nG2l3qs2gwTuEAnsqWT0/6t5dxvy8bCyLnQHWW11PcY0Eve1zl511PotfTP8AFjhb62tuzcunLuEf6XcamH/i8b0q1jdF6N9TsrDNvWOqfs7KFjmihtbHAsEenZ7qrPp/1k4YIkE8RoHh0jxJEyDppp3p9ab9X/qo8OLem4DgzVxFFJgfyvYrmBjdMxa3U9Nqooqnc6vHaxjZP5zmUw33bVxfQOi/V/A+rP1hyOiZ56jTk41lVznMa0NdVTa/Z7a6t3syVwf1a61b9XupUdRxmyA3bk0tAHq0mPVZ+b+kb/O0/wDC/wAhCOAHi4T8vhSjkOlkm/F92fkUVnbZYxjomHOAMfNEXjf+M67EzuuU5lBbdRf0+iymyNC1z8ktc3d7l7GEyePhjE38ygbJHZ//1fVV4p9V8B3UMf6w4jdXuwH2Vjxsqv8AtFP/AIJWva1mdM+rXQuk3WX9Ow68a21uyx7JktJ37TuJ/OUmPJwCXc1X+Cgi6fLfqRXd1DrlV7nks6XgXPpkcM2vpoqH9vOutWx/ih/mOsf8Ti/9TlLuum/VroXShcOn4VeOMloZdsn3NG72mT/LcpdL+r3Rejtub03EZijIDRcGT7gzds3bifo+o9PnmEhIUdar/B1QI1T5l/in/wDFGP8AwhZ/1eMoYVNV/wDjJtovY22m7qGZXbW8S1zXMyGua4FemdM+q/1f6Tkfaem4VeNeWGs2MmdpLXOb7nH9xqVX1W+r9XUv2rXg1tzzY645Andvfu9R/P5+9yJzgykaPqjwq4dB4F8h+sXRMr6vdUu6W9z3Yzy27HeTpbU3e2iyyP8AD43qW0P/AM/+bvXR5H/5IMT/AI9v/t49eg9V6H0jrDa29Txa8oUkuq9QatLhDtpH7yg76u9Ed0pvR3YjD05h3NxtdgO43eO7+ddvQOcERsaxIkforh1L5X9W7fqPXhWj6yUW25huJqdWLyBTsr2D9Veyv+d9b+Wuz+rmd9T34XVMP6tVWUn0HXZDbBbr7XVMduynP/d/NWp/zC+p/wD5VUfcf/JK30/6sdA6YbjgYVeOchnpXbJ9zP3HSfNKeWMr+fyv0/YoRI7Pk31G6Bh/WDNt6fllzGtwTbTYwwWWh1NbLNv0bPbY79HZ7FZ+qPUnfVv6zfZ+p0VAm37Hk2uaC+l8+m27Hud72Y9jnM9T/S49nrfmL1Dpf1Y6B0i85PTcKvGucz0nPZMlhLX7PcT+cxih1D6pfVvqeU/Mz+n1X5FgAfa4HcQ0bG7tpb9FvtROcEyBB4ZBHDt3ef8A8avShkdGo6o0S/p9kW+Ho37ardPzttwx3/8Abi4jGGR9aOsdF6XeDtqopwX+7V1FHqX5V38l9uO30/8AMXs9uFi3YbsG6sWYr6/RfU6SCwjZsdPu+iqPTPqv9X+k5ByunYNWNeWGv1GAztJDnN9xP7qbDMIwqtRfCfNJjZcL/GmAPqxWAIAy6YA/trjfq5b9RK+nuH1iottzvVeWurGRHpe30h+rPZX+8vWep9K6d1bHGL1GhuTQHB4rfMbm/RdpH7yy/wDmF9T/APyqo+4/+SShliIcJ4hrdxUY63o5HS836qW/VvruJ9Wq7Ka68a27IZYLR7rKrK2uacpz3fRxvzVyv1G6BV1/p3Wen2H07RViWYtx/wAHc37V6b/6jv5u79+lemYX1Y6B0+rJpw8KuirNZ6WSxsw9kObsfr+7bYp9K+r/AEboxsPS8RmKbg0W7J9wZu2TuJ+jvcl7oAkI3ZIIJ8O6uHZ8Kzasqj1MXKa6u7FLqXUuM+mQ5z31N/keo99vt/0nq/4RfQqyeo/VP6udTynZef0+q/IeA19rgQ4hujN20t+i1a6GXKJiOlVd/VUY1b//1vVUkkklKSSSSUpJJJJSkkkklKSSSSUpJJJJSkkkklKSSSSUpJJJJSkkkklP/9k4QklNBCEAAAAAAFUAAAABAQAAAA8AQQBkAG8AYgBlACAAUABoAG8AdABvAHMAaABvAHAAAAATAEEAZABvAGIAZQAgAFAAaABvAHQAbwBzAGgAbwBwACAAQwBTADUAAAABADhCSU0EBgAAAAAABwAIAAAAAQEA/+ENw2h0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8APD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcDpDcmVhdGVEYXRlPSIyMDIxLTExLTAxVDA5OjI5OjAxLTA0OjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMS0xMS0wMVQwOTozMjoxMy0wNDowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0xMS0wMVQwOTozMjoxMy0wNDowMCIgZGM6Zm9ybWF0PSJpbWFnZS9qcGVnIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxOTQyNjgxRjE4M0JFQzExOUE1Qjk5OTcxMERFQzEzQiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxODQyNjgxRjE4M0JFQzExOUE1Qjk5OTcxMERFQzEzQiIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjE4NDI2ODFGMTgzQkVDMTE5QTVCOTk5NzEwREVDMTNCIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoxODQyNjgxRjE4M0JFQzExOUE1Qjk5OTcxMERFQzEzQiIgc3RFdnQ6d2hlbj0iMjAyMS0xMS0wMVQwOToyOTowMS0wNDowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoxOTQyNjgxRjE4M0JFQzExOUE1Qjk5OTcxMERFQzEzQiIgc3RFdnQ6d2hlbj0iMjAyMS0xMS0wMVQwOTozMjoxMy0wNDowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSJ3Ij8+/+ICKElDQ19QUk9GSUxFAAEBAAACGAAAAAACEAAAbW50clJHQiBYWVogAAAAAAAAAAAAAAAAYWNzcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEAAPbWAAEAAAAA0y0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAJZGVzYwAAAPAAAAB0clhZWgAAAWQAAAAUZ1hZWgAAAXgAAAAUYlhZWgAAAYwAAAAUclRSQwAAAaAAAAAoZ1RSQwAAAaAAAAAoYlRSQwAAAaAAAAAod3RwdAAAAcgAAAAUY3BydAAAAdwAAAA8bWx1YwAAAAAAAAABAAAADGVuVVMAAABYAAAAHABzAFIARwBCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABYWVogAAAAAAAAb6IAADj1AAADkFhZWiAAAAAAAABimQAAt4UAABjaWFlaIAAAAAAAACSgAAAPhAAAts9wYXJhAAAAAAAEAAAAAmZmAADypwAADVkAABPQAAAKWwAAAAAAAAAAWFlaIAAAAAAAAPbWAAEAAAAA0y1tbHVjAAAAAAAAAAEAAAAMZW5VUwAAACAAAAAcAEcAbwBvAGcAbABlACAASQBuAGMALgAgADIAMAAxADb/7gAOQWRvYmUAZEAAAAAB/9sAhAABAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAgICAgICAgICAgIDAwMDAwMDAwMDAQEBAQEBAQEBAQECAgECAgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwP/wAARCAC4AOoDAREAAhEBAxEB/90ABAAe/8QBogAAAAYCAwEAAAAAAAAAAAAABwgGBQQJAwoCAQALAQAABgMBAQEAAAAAAAAAAAAGBQQDBwIIAQkACgsQAAIBAwQBAwMCAwMDAgYJdQECAwQRBRIGIQcTIgAIMRRBMiMVCVFCFmEkMxdScYEYYpElQ6Gx8CY0cgoZwdE1J+FTNoLxkqJEVHNFRjdHYyhVVlcassLS4vJkg3SThGWjs8PT4yk4ZvN1Kjk6SElKWFlaZ2hpanZ3eHl6hYaHiImKlJWWl5iZmqSlpqeoqaq0tba3uLm6xMXGx8jJytTV1tfY2drk5ebn6Onq9PX29/j5+hEAAgEDAgQEAwUEBAQGBgVtAQIDEQQhEgUxBgAiE0FRBzJhFHEIQoEjkRVSoWIWMwmxJMHRQ3LwF+GCNCWSUxhjRPGisiY1GVQ2RWQnCnODk0Z0wtLi8lVldVY3hIWjs8PT4/MpGpSktMTU5PSVpbXF1eX1KEdXZjh2hpamtsbW5vZnd4eXp7fH1+f3SFhoeIiYqLjI2Oj4OUlZaXmJmam5ydnp+So6SlpqeoqaqrrK2ur6/9oADAMBAAIRAxEAPwDf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/0N/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691//R3+Pfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Lf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/09/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3XvfuvdBJ3v3n1h8auot+d59zbopdnda9cYKfP7oztVHNUNDTJJFTUtFQUVMklXk8xl8hUQ0lFSQK89VVzRxRqWcD2t27b7zdb2226whMl3K2lR/lPoAKkk4ABJ6ammjt4nmlakaip61pM3/wAKwvi/S5fI023/AIrfIPOYSCrmixeYrs11vgqrJ0SOVgrZsO+fyMmNeoQavC0zugNmN7gSwnsx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WUUbCSZXdALKQCQRHsXNm+8tx3MW0XgiSVgWqiNUqCBllJGCeFOkV3t1pesj3EZJUUGSOP2dE2/6BzP5T3/Pid4/+jx7h/8Asy9nv+uhzr/0dl/5xRf9AdJf3Dtn++D/AL0f8/Xv+gcz+U9/z4neP/o8e4f/ALM/fv8AXQ51/wCjsP8AnFF/0B179w7Z/vg/70f8/R8N+/y8/iv2X8R9p/Bzd+x8xkPjjsnH7Lxe3dnwb13dQZSkouv62DIbXjl3bRZiDc9W1DVUyM7S1TNOBaQsCfYctuZd5tN6m5ggu6brIXJfSpqXFG7SNOQT5Y6WyWNtJbLZsn+LilBU+XDPHoNPiL/KX+D3wa7Nynb3xv603Bs7feZ2fkdiZDKZTsjf27qeXbOVymGzNbRLjN0bgyuPilkyGApXEyxiVQhUMFZgVm9858xcw2iWO7XwktlcOBoRe4AgGqqDwY+dOmrXbLOzkMtvGQ5FOJP+Ho1/yS+NfTPy36f3R0T35s6m3x1ru/8Ah0mUw8tXXYutp63EZCnymKy2FzeKqKPMYLM46upleKqpJoplUsmoo7qxNtW63+y30O47bcGO7jrQ4PEUIINQQRxBBHSq4t4bqJoJ01RnogfRf8jj+XF8cO3tg96dS9QbowHZPWeafcOz8zWdt9nZ2lx+VfHV2KaefD5ndNbisghosjMuieKRLte1wCBJuPuDzXutlc7dfbkHtJV0sPDjFRUHiFBGQOB6RQ7PYW8qTRQkSKajJ/z9W5ewUBQU6M+ve99e6//T3+Pfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Tf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/1d/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691//Z";
						// A documentation reference can be found at
						// https://github.com/bpampuch/pdfmake#getting-started
						// Set page margins [left,top,right,bottom] or [horizontal,vertical]
						// or one number for equal spread
						// It's important to create enough space at the top for a header !!!
						doc.pageMargins = [20,60,20,30];
						// Set the font size fot the entire document
						doc.defaultStyle.fontSize = 10;
						// Set the fontsize for the table header
						doc.styles.tableHeader.fontSize = 12;
						// Create a header object with 3 columns
						// Left side: Logo
						// Middle: brandname
						// Right side: A document title
						doc['header']=(function() {
							return {
								columns: [
									{
										image: logo,
										width: 32
									},
									{
										alignment: 'left',
										italics: true,
										text: 'Sistema de Evaluación de Desempeño de Personal',
										fontSize: 15,
										margin: [10,0]
									},
									{
										alignment: 'right',
										fontSize: 13,
										text:  jsDate
									}
								],
								margin: 20
							}
						});

						// Create a footer object with 2 columns
						// Left side: report creation date
						// Right side: current page and total pages
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Created on: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 20
							}
						});
						// Change dataTable layout (Table styling)
						// To use predefined layouts uncomment the line below and comment the custom lines below
						// doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = objLayout;
				}
				},
				{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
                title: "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO ",
				className: 'btn btn-info'
			},
			
			]
		});
//});

/*$('#example1').DataTable({        
        language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
                title: "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO",
				className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
                title: "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO ",
				className: 'btn btn-danger'
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
                title: "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO ",
				className: 'btn btn-info'
			},
            
		]	        
    }) 
/*$(document).ready(function() {    
 
	
	$("#nivel_org").on('change', function () {
        $("#nivel_org option:selected").each(function () {
            nivel = $(this).val();
			/*window.alert(nivel);
            $.post("reportes.php", { nivel_org: nivel }, function(data){
                $("#nivel_org").html(data);
				/*$("#modelo").removeAttr('disabled');*/

				//var textqr=$("#placa").val()+'|'+$("#modelo").val()+'|'+$("#marca").val()+'|'+$("#color").val()+'|'+$("#tipo_co").val()+'|'+$//("#tipo_v").val();
			//window.alert(textqr);
			//var sizeqr=$("#tipo_v").val();
			//var sizeqr= "300";
			//var nombreimg = $("#placa").val();
			/*parametros={"nivel_org":nivel};
			 $.ajax({
				type: "POST",
				url: "reportes.php",
				data: parametros,
				success: function(datos){
					//$("#nivel_org").html(datos);
					document.myform.submit();
				}
				 
			 });
			
            
        });
   });

});*/

/*	var table = $('#example1').DataTable({
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

		} , 
        buttons: [{
      extend: "pdfHtml5",
      filename: function() {
        return "MyPDF"      
      },      
      title: function() {
       // var searchString = table.search();        
        return  "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO \n"// + <?php echo json_encode($gerenciaOp); ?>;
      },
      extend: "excelHtml5",
      filename: function() {
        return "MyPDF"      
      },      
      title: function() {
       // var searchString = table.search();        
        return  "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO \n" + <?php echo json_encode($gerenciaOp); ?>;
      },
      extend: "print",
      filename: function() {
        return "MyPDF"      
      },      
      title: function() {
       // var searchString = table.search();        
        return  "SISTEMA DE EVALAUCIÓN DE DESEMPEÑO \n" + <?php echo json_encode($gerenciaOp); ?>;
      },
    }],
		//ajax: 'get_data.php',
	}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  
  
/*$(document).ready( function () {
  var table = $('#example1').DataTable({
    dom: "Bfrtip",    
    buttons: [{
      extend: "pdfHtml5",
      filename: function() {
        return "MyPDF"      
      },      
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : <?php echo json_encode($gerenciaOp); ?>
      }
    }],
  });
} );*/

	function cambiaColor(obj, rad, id) { // window.alert($("#"+rad+"").attr("class"));
		$("#" + obj + "").attr("class", "bg-success");

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

 

</script>


<?php
include_once 'footer.php';
include_once 'scripts.php';
?>