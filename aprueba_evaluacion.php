<?php
//session_start();
  require_once './acceso/conection.php';
  include_once 'head.php';
  include_once 'navbar.php';
  include_once 'aside.php';


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
<?php
        if (isset($_SESSION['msj'])) {
                        $cent = (int) $_SESSION['msj'];
                        $premsj = '¡Bien hecho!';
                        $clase = 'alert alert-success alert-dismissible';
                        switch ($cent) {
                        case 1: 
                          $msj = "Evaluación realizada con éxito!!!";  
                          unset($_SESSION['msj']);
                       // echo "el centinela es: ". $cent;
                          break;
                        case 2: 
                          $msj = "Registro modificado con éxito!!!"; 
                          unset($_SESSION['msj']);
                          break;
                         case 3: 
                          $msj = "Registro eliminado con éxito!!!"; 
                          unset($_SESSION['msj']);     
                          break; 
                         case 4:
                           $clase = 'alert alert-danger alert-dismissible';
                           $premsj = '¡Alerta!';
                           $msj = "No se pudo realizar el registro, por favor revise."; 
                           unset($_SESSION['msj']);     
                           break; 
                          case 5:
                            $clase = 'alert alert-danger alert-dismissible';
                            $premsj = '¡Alerta!';
                            $msj = "El registro no se puede eliminar"; 
                             unset($_SESSION['msj']);     
                          break; 
                         default:
                          $msj = "";
                        
                        }
    ?>
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                    <!-- general form elements --> 
            
                        <div id="msj_alert" class="<?=$clase;?>" role="alert" style="display: block"  >
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong><?=$premsj;?></strong>  <?=$msj;?>
                        </div>
                    </div>
                  </div>
                </div>
            </section>
        <?php 
                        
                }/*else{$msj = ""; 
                          unset($_SESSION['msj']); }*/?>

  <section class="content">
      <div class="container-fluid">
		  	<form  data-toggle="validator" id="myform" name="myform" role="form" method="post" action="registra_evaluacion.php" enctype="multipart/form-data" >
				<div class="row">
				  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">UNIDADES FUNCIONALES <?php  //echo "El valor: ".$_SESSION["evaluador"]; //echo $_SESSION['nivel_org']; ?>  </label>
                   <!--    <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca" required> -->
                        <select class="form-control" name="empleado" id="empleado" placeholder="Empleado" onChange="habilitaFormato()" required>
						    <option></option>	
						  <?php
                             $query2 = $bd->getEmpleadosxEval($_SESSION["nivel_org"],$_SESSION["evaluador"]);
                             foreach ($query2 as $query2) {    
								//echo "<option value='".$query2['id']."'";
								echo "<option value='".$query2['id']."|".$query2['id_nomina']."'";
                                echo ">". strtoupper($query2['nombre']."  ".$query2['apellido']). " </option>";
                           }
							//echo "----";.
                         ?>
                        </select>	
                    </div>
                  </div>		  
		       </div>	
		  
		  
        <div class="row" id="formato" style="display: none">
          <div class="col-12">
            <div class="card">

				<div class="card-body" id="tablaModelo">  </div>
				  
				  

				  </br>
                <div class="card-footer">
                  <!-- <button type="submit" class="btn btn-primary">GUARDAR</button> -->
					<input type="submit" id="saveChanges" class="btn btn-primary" onclick="" value="Evaluar">
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


<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Empleados Evaluados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
			 <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr >

                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
					  <th>Resultado</th>
					  <th>Enviar a..</th>
					  <th>Retornar a..</th>
                     <th>Revisar</th>

                  </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                          $query = $bd->getEmpleadosEvaluados($_SESSION["evaluador"]);
                            foreach ($query as $query) { 
                    ?>
                  <tr id='mitr<?=$i?>'  style=""  id="celda1" onmouseover='cambiar_color_over(this,<?=$i?>)' onmouseout="cambiar_color_out(this,<?=$i?>)" onClick="vercolor(this,<?=$i?>)">
              
                    <td ><?php echo '18246852';//$query['cedula'];?></td>
                    <td><?php echo 'NARYOLIS';//$query['nombre'];?></td>
                    <td><?php echo 'CARPIO';//$query['apellido'];?></td>
                    <td><?php echo 'ANALISTA III';//$query['cargo'];?></td>
					   <!--  
					  <td><?php $progres = ($query['puntaje']*100)/20;
								if($query['puntaje'] <= 8){
									$color = 'bg-danger';
								}elseif($query['puntaje'] > 8 && $query['puntaje'] <= 14){
									$color = 'bg-warning';
								}elseif($query['puntaje'] > 14 && $query['puntaje'] <= 18){
									$color = 'bg-primary';
								}else{
									$color = 'bg-success';
								}
								
						  ?></td> -->
					<td >
						<div class="progress">
  							<div class="progress-bar progress-bar-striped <?=$color?>" role="progressbar" style="width: <?php echo $progres;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo $progres. ' %';?></div>
						</div>
                    </td>
                    <td  align="center" onClick="asignar(<?=$id?>,<?=$idv?>,'<?=$tipo_c?>',<?=$i?>,this)"  >
						<a href="#" class="btn bg-gradient-success btn-xs" data-toggle="tooltip" data-html="true" data-placement="left" title='<?php echo $tableresult;?>' ><i class="fas fa-edit"><?php echo $query['to_send'];?></i></a>

                    </td>	
                    <td  align="center" onClick="asignar(<?=$id?>,<?=$idv?>,'<?=$tipo_c?>',<?=$i?>,this)"  >
						<a href="#" class="btn bg-gradient-dark btn-xs" data-toggle="tooltip" data-html="true" data-placement="left" title='<?php echo $tableresult;?>' ><i class="fas fa-edit"><?php echo 'JOSE SALAZAR';?></i></a>

                    </td>	
                   
                    <td align="center">
						
                      <a href="<?= 'evaluacion_editar.php?id_eval='.$query['id_eval'].'&id_nomina='.$query['id_nomina'].'&id_emp='.$query['id']; ?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-edit"></i></a>
                    

                    </td>
                  </tr>
					 
                   <?php
                    $i++;  }
                    ?>
                
                  </tbody>
                  <tfoot>
					  
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
					  <th>Resultado</th>
					  <th>Enviar a..</th>
					  <th>Retornar a..</th>
                     <th>Revisar</th>

                  
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
		
    }/*, "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]*/
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