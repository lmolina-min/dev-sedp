<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">Gestion de usuarios</h2>
					<p class="text-secondary">Información general</p>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card card-dark shadow">
						<div class="card-header border-0">
						</div>

						<form class="form p-4" action="/apis/usuario/create.php" method="POST">
							<div class="card-body">
								<div class="row mb-4">
									<div class="col-md-1">
										<label class="fw-semibold text-muted" for="nombreInput">Es evaluador</label>
										<div class="form-group d-flex justify-content-between">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" checked name="es_evaluador" id="siEvaluadorInput" value="1">
												<label class="form-check-label" for="inlineRadio1">Si</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="es_evaluador" id="noEvaluadorInput" value="0">
												<label class="form-check-label" for="inlineRadio2">No</label>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="nombreInput">Nombre</label>
										<input class="form-control" type="text" name="nombre" id="nombreInput">
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="apellidoInput">Apellido</label>
										<input class="form-control" type="text" name="apellido" id="apellidoInput">
									</div>
									<div class="col-md-2">
										<label class="fw-semibold text-muted" for="cedulaInput">Cedula</label>
										<input class="form-control" type="text" name="cedula" id="cedulaInput" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="evaluadorInput">Evaluador</label>
										<select class="empleados-select2 w-100" name="id_evaluador" id="evaluadorInput">
											<option value="" selected disabled>Seleccione un evaluador</option>
											<?php $empleados = $bd->getEmpleados(); ?>
											<?php foreach ($empleados as $emp):	?>
											<option value="<?= $emp['id'] ?>">
												<?= $formatear->nombre($emp['nombre'], $emp['apellido'])." (".$emp['cedula'].")" ?>
											</option>
											<?php endforeach ?>
										</select>
									</div>
								</div>								
								
								<div class="row mb-4" id="userRow">
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="usuarioInput">Usuario</label>
										<input class="form-control" type="text" name="usuario" id="usuarioInput">
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="correoInput">Correo</label>
										<input class="form-control" type="email" name="correo" id="correoInput">
									</div>
									<div class="col-md-2">
										<label class="fw-semibold text-muted" for="rolInput">Rol</label>
										<select class="form-control" name="rol" id="rolInput">
											<option value="0">Administrador</option>
											<option value="1">Gerente</option>
											<option value="2">Jefe de Division</option>
											<option value="3">Jefe de Departamento</option>
											<option value="4">Coordinador</option>
											<option value="5" selected>Empleado</option>
										</select>
									</div>
									<div class="col-md-2">
										<label class="fw-semibold text-muted" for="contraseñaInput">Contraseña</label>
										<input class="form-control" type="password" name="clave" id="contraseñaInput">
									</div>
									<div class="col-md-2">
										<label class="fw-semibold text-muted" for="repetirInput">Repetir contraseña</label>
										<input class="form-control" type="password" name="clave_rep" id="repetirInput">
									</div>
								</div>

								<div class="row mb-4">
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="fotoInput">Foto</label>
										<input class="form-control" type="file" name="foto" id="fotoInput">
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="cargoInput">Cargo</label>
										<select class="cargos-select2 w-100" name="id_cargo" id="cargoInput">
											<option value="" selected disabled>Seleccione un cargo</option>
											<?php $cargos = $bd->getCargos();	?>
											<?php foreach ($cargos as $c):	?>
											<option value="<?= $c['id'] ?>">
												<?= $c['descripcion'] ?>
											</option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="ccostoInput">Centro de costo</label>
										<select class="centros-costo-select2 w-100" name="id_ccosto" id="ccostoInput">
											<option value="" selected disabled>Seleccione un centro de costo</option>
											<?php $centros_costo = $bd->getCentrosCosto(); ?>
											<?php foreach ($centros_costo as $ccosto):	?>
											<option value="<?= $ccosto['id'] ?>">
												<?= $ccosto['descripcion'] ?>
											</option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-3">
										<label class="fw-semibold text-muted" for="nominaInput">Nomina</label>
										<select class="nominas-select2 w-100" name="id_nomina" id="nominaInput">
											<option value="" selected disabled>Seleccione una nomina</option>
											<?php $nominas = $bd->getNominas();	?>
											<?php foreach ($nominas as $no):	?>
											<option value="<?= $no['id'] ?>">
												<?= $no['descripcion'] ?>
											</option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>

							<div class="card-footer border-0 bg-body">
								<button class="btn btn-primary" type="submit"><i class="fas fa-save me-2"></i>Crear usuario</button>
								<a onclick="confirm()" class="btn btn-secondary"><i class="fas fa-eraser me-2"></i>Limpiar</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	$(document).ready(function() {
		$('#usuariosTable').DataTable({
			language: {
				url: '/plugins/lang/es_ES.json',
			},
			info: false,
		})

		$('.empleados-select2').select2()
		$('.cargos-select2').select2()
		$('.centros-costo-select2').select2()
		$('.nominas-select2').select2()
		$('.grado-institucional-select2').select2()

		$('input[name="es_evaluador"]').on('change', function(el) {
			console.log($(el.target).val())
			if ($(el.target).val() == 0) {
				$('#userRow').addClass('d-none')
			}
			else {
				$('#userRow').removeClass('d-none')
			}
		})
	})
	
</script>