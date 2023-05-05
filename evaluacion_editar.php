<?php
//session_start();
  require_once './acceso/conection.php';
  include_once 'head.php';
  include_once 'navbar.php';
  include_once 'aside.php';
  $id_eval = $_GET['id_eval'];
  $id_nomina = $_GET['id_nomina'];
  $id_emp = $_GET['id_emp'];

?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Bienvenido: <a href="#"><?php print_r($_SESSION["usuario"]);?></a></li>
              <li class="breadcrumb-item active"> </li>
            </ol>
          </div><!-- /.col -->
			</div>
		  <div class="row mb-2">
          <div class="col-sm-12">
                          <div id="nivel" class="alert bg-info" role="alert" style="display: block"  >
              
                              <strong><?php print_r($_SESSION["descripcion_nivel_org"]);?></strong>
                        </div>   
          </div><!-- /.col -->			
			
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


  <section class="content">
      <div class="container-fluid">
		  	<form  data-toggle="validator" id="myform" name="myform" role="form" method="post" action="evaluacion_procesa.php" enctype="multipart/form-data" >
				<div class="row">
				  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">EMPLEADO: <?php  echo $id_emp; ?>  </label>
                   <!--    <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca" required> -->

                    </div>
                  </div>		  
		       </div>	
		  
		  
        <div class="row" id="formato" >
          <div class="col-12">
            <div class="card">

<?php
	  					$query1 = $bd->getFormatoEditar($id_nomina, $id_eval); //print_r($query1);
				       // echo "valor 1: " .$query1[0][0];
				             $i=0;
                             foreach ($query1 as $query1) {    
									
								$item_factor_actual[$i]  = $query1['id_item_factor'];
								 $i++;
								/*$subtitulo      = $query1['subtitulo'];
								$descripcion    = $query1['descripcion'];*/
							 }
				      //print_r($item_factor_actual);
						/*$nivel_personal = 3; */ 
						$oTiutlo = ''; $osubtitulo= ''; $check =''; $onivel =1;	$i=0; $k=0; $j=1;
				        $tabla = ''; $checked = '';
	  					$query2 = $bd->getFormatoEval($id_nomina);
                             foreach ($query2 as $query2) {    
									
								$titulo         = $query2['titulo'];
								$subtitulo      = $query2['subtitulo'];
								$descripcion    = $query2['descripcion'];
								$id_item_factor = $query2['id_item_factor'];
								$nivel          = $query2['nivel'];
								$valor          = $query2['valor'];
								$k++;
								
								 if(($item_factor_actual[$j-1]) === $id_item_factor){
									 $checked = 'checked';
									 
								 }else{
									 $checked = '';
								 }
								 //echo "el indice a usar es: " .$j;
								/* $check .=  '
											<th ><div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor."|".$id_item_factor.'" onChange="cambiaColor(\'ti'.$j.'\',this.id,'.$id_item_factor.')" required '. $checked .'>
                          						<label for="customRadio'.$k.'" class="custom-control-label">'.$valor.'</label>
												</div></th>';*/
								 
								 
								 $check .=  '
											<th ><div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor."|".$id_item_factor.'" onChange="cambiaColor(\'ti'.$j.'\',this.id,'.$id_item_factor.')" required '. $checked .'>
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

				//echo "el indice a usar es: " .$j;




//$row = $con->exec($query);*/
 
/*  $q="INSERT INTO sc_datos_personas (cedula, foto, pc_serial,id_vehiculo,id_huellas) VALUES ('" . $_POST['cedula'] . "', '" . $foto . "', '" . $_POST['token'] . "', '" .$id_vehiculo . "','" . $id_huella . "')";*/

//}
?>
				  
				  

				  </br>
			  <input type="hidden" class="form-control" name="id_eval" id="id_eval" value="<?php echo $id_eval;?>">
                <div class="card-footer">
                  <!-- <button type="submit" class="btn btn-primary">GUARDAR</button> -->
					 <button type="submit" class="btn btn-primary">GUARDAR</button>
                     <button type="button" class="btn btn-primary" onClick="history.back()">VOLVER</button>
                </div>				  

            <!-- /.card -->
            </form>
        </div>
        <!-- /.row (main row) -->
      </div>
      </div>
    </section>

  <!--<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio'.$k.'" name="customRadio'.$j.'" value="'.$valor.'" onChange="cambiaColor(\'ti'.$j.'\',this.name,'.$id_item_factor.')">
                          						<label for="customRadio'.$k.'" class="custom-control-label">'.$valor.'</label>
												</div>
   /.content -->



  </div>
  <!-- /.content-wrapper -->


<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script type="application/javascript">

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
		
    }, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
//ajax: 'get_data.php',
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');	
	
	
function cambiaColor(obj,rad,id){// window.alert($("#"+rad+"").attr("class"));
	$("#"+obj+"").attr("class","bg-success");	
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

function cambiar_color_over(celda,i){  //window.alert (celda.style.backgroundColor);
   celda.style.backgroundColor="#f8f988";
}
function cambiar_color_out(celda,i){//window.alert (i%2); 
   //celda.style.backgroundColor="#acbad5";
	if ((i%2)==0){
		$("#mitr"+i).css('backgroundColor','#f5f5f5');
	}else{
		$("#mitr"+i).css('backgroundColor','#ffffff');
	}
	
}		
	
	
function habilitaFormato(){// window.alert($("#"+rad+"").attr("class"));
	$("#formato").css("display", "block");
	//$("#"+obj+"").attr("class","bg-success");	
	//window.alert(rad);
	//window.alert($("#empleado").val());				   
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

function accion(){
	//$('#msj_alert').css("display", "block");
        $("#msj_alert").fadeIn(5);
    setTimeout(function () {
        $("#msj_alert").fadeOut(1500);
    }, 4000);
     // $("#msj_alert").fadeIn("slow");
   //window.alert('hoooooo');
}	

$(document).ready(function(){
    $("#empleado").on('change', function () {
        $("#empleado option:selected").each(function () {
			//var porciones = pizza.split(' ');
			var ids = $(this).val().split('|');
			//window.alert(ids[1]);
            id_nomina=ids[1];
            $.post("crea_tabla_formato.php", { id_nomina: id_nomina }, function(data){
                $("#tablaModelo").html(data);
				//$("#tablaModelo").removeAttr('disabled');
            });			
        });
   });
});	
</script>
 <?php
  include_once 'footer.php';
  include_once 'scripts.php';
?>

</body>
</html>