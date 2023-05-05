<?php
//session_start();

include_once 'head.php';
include_once 'navbar.php';
include_once 'aside.php';
//require_once './acceso/conection.php';
//  echo "la sesion del nivel org es:". $_SESSION["nivel_org"];

/*$bd_servidor	= "localhost";
$bd_nombre		= "test"; //"bd_combustible";//
$bd_puerto		= "3306";
$bd_usuario		= "root";
$bd_clave		= "";
$bd_tipo 		= "mysql";

$bdt = new Database($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_clave);*/

//$nivel_org = 511;//$_SESSION["nivel_org"];

/*$query2 = $bdt->getNivelOrg($nivel_org);
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
}*/
//	echo "----".$nivel;
//$_SESSION['descripcion_nivel_org'] = 'ddddd'; //$nivel . '|' . $cod_nivel;
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
        </div><!-- /.container-fluid -->
    </div><!-- /.container-fluid -->
    <?php //$i = 0;
    /*	$nivel_org = $_SESSION["nivel_org"];
			$q = $bd->getCoordinaciones('15372919');


			foreach ($q as $q) {
				//$coord[$i] = $q['des_coord'];
				$coord[$i] = $q['id'].' - '.$q['des_coord'];
				$bdi = $bd->getResultadoxNivel('puntaje <= 8', $q['id']);
				$midatabd[$i] = $bdi['puntaje'];
				$da = $bd->getResultadoxNivel('puntaje > 8 and puntaje <= 14', $q['id']);
				$midatada[$i] = $da['puntaje'];
				$le = $bd->getResultadoxNivel('puntaje > 14 and puntaje <= 18', $q['id']);
				$midatale[$i] = $le['puntaje'];//
				$se = $bd->getResultadoxNivel('puntaje >= 19', $q['id']);
				$midatase[$i] = $se['puntaje'];

				$i++;
			}
*/


    //print_r($midatase);
    /* para obtener cuantos obtuvieron un puntaje segun la escala del formato
			select count(puntaje) from se_evaluacion 
inner join se_empleado
on se_evaluacion.id_empleado = se_empleado.id
where puntaje <= 8 and se_empleado.id_ccosto = 511
			
			*/
    if (isset($_GET["nivel_org"])) {
        $evaluador = $bd->getEvaluadorCoord($_GET["nivel_org"]);

        if ($evaluador) {
            $coordinacion = $evaluador["coordinacion"];
            $evaluador = $evaluador["cedula"];
            $query = $bd->getEmpleadosEvaluados($evaluador);
            $total_emp = $bd->getDatosEmpleadosxNivelOrg($evaluador);

            echo '	<section class="content">
                    <div class="container-fluid">
                       <div class="row">		
                          <div class="col-12 col-sm-12">	
                              <div id="nivel" class="col-sm-12  alert bg-info" role="alert" style="display: block">
                                  <strong>' . $coordinacion . '</strong>
                              </div>	
                          </div>
                      </div>
                    </div>
                 </section>';
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
							$progres_tam = $progres_eval == 0 ? 80:$progres_eval; 
						
				    ?>
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="info-box">

                                    <div class="col-sm-8 text-center">
                                        <input type="text" class="knob" value="<?= $progres_eval; ?>" data-width="<?= $progres_tam; ?>" data-height="<?= $progres_tam; ?>" data-fgColor="#007bff">

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

            <?php } else {


            ?>
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="info-box">

                                    <div class="col-sm-12 text-center">
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
        } else {
            $coordinacion = $bd->getCoordinaciones(0, $_GET["nivel_org"]);
            //foreach ($q as $q) {
            // echo $coordinacion['des_coord'];
            $progres_eval = 80;

            ?>
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="info-box">

                                    <div class="col-sm-8 text-center">
                                        <input type="text" class="knob" value="0" data-width="<?= $progres_eval; ?>" data-height="<?= $progres_eval; ?>" data-fgColor="#007bff">

                                        <div class="knob-label">Progreso de las Evaluaciones</div>
                                    </div><!-- /.col -->

                                    <div class="col-sm-4">
                                        <p class="text-center">
                                            <strong>Totales</strong>
                                        </p>

                                        <div class="progress-group">
                                            Cantidad Empleados Evaluados
                                            <span class="float-right"><b>0</b>/0</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: 90%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Cantidad Empleados por evaluar
                                            <span class="float-right"><b>0</b></span>
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
        <?php
        }

        ?>



        <!--     <img src="img/principal_png.png" style="display:block;margin:auto; " height="50%" width="50%"> -->
        <div class="card-footer">
            <button type="button" class="btn btn-primary" onClick="history.back()">VOLVER</button>
        </div>

        <input type="hidden" class="form-control" name="perfil" id="perfil" value="<?php echo $_SESSION["id_perfil"] ?>">
    <?php
    }

    ?>
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