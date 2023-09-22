<div class="content-wrapper px-4">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-4">
				<div class="col-12">
					<h2 class="m-0 fw-bold">Perfil de usuario</h2>
					<p class="text-secondary">configuración general</p>
				</div>
			</div>
		</div>
	</div>

	<?php
	$perfil = $bd->getPerfil($_SESSION['empleado']);

	$foto = ($perfil['foto'])
	? 'data:image/jpeg;base64,'.base64_encode($perfil['foto'])
	: '/assets/images/avatars/blank.png';
	?>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-6 mx-auto">
					<div class="card card-secondary shadow">
						<div class="card-header border-0 d-flex flex-column align-items-center">
							<img class="rounded-circle" style="object-fit: fill;" width="120" height="120" src="<?= $foto ?>" alt="Foto de perfil">
						</div>

						<form class="form p-4" action="/apis/usuario/update.php" method="POST">
							<input type="hidden" name="id" value="<?= $perfil['id_usuario'] ?>">
							<div class="card-body">
								<div class="row mb-4">
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="nombreInput">Nombre</label>
										<input class="form-control" readonly type="text" name="nombre" id="nombreInput" value="<?= $formatear->nombre($perfil['nombre'], '') ?>">
									</div>
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="apellidoInput">Apellido</label>
										<input class="form-control" readonly type="text" name="apellido" id="apellidoInput" value="<?= $formatear->nombre($perfil['apellido'], '') ?>">
									</div>
								</div>

								<div class="row mb-4">
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="correoInput">Correo</label>
										<input class="form-control" readonly type="text" name="correo" id="correoInput" value="<?= $perfil['correo'] ?>">
									</div>
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="cedulaInput">Cedula</label>
										<input class="form-control" readonly type="text" name="cedula" id="cedulaInput" value="<?= number_format($perfil['cedula'], 0, ',', '.') ?>">
									</div>
								</div>

								<div class="row mb-4">
									<span class="form-text p-0 mb-2">Cambiar contraseña</span>
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="contraseñaInput">Contraseña</label>
										<input class="form-control" type="password" name="clave" id="contraseñaInput">
									</div>
									<div class="col-md-6">
										<label class="fw-semibold text-muted" for="repetirInput">Repetir</label>
										<input class="form-control" type="password" name="clave_rep" id="repetirInput">
									</div>
								</div>
							</div>

							<div class="card-footer border-0 bg-body">
								<button class="btn btn-primary" type="submit"><i class="fas fa-lock me-2"></i>Cambiar contraseña</button>
								<a onclick="history.back()" class="btn btn-secondary" href="/index.php">Regresar</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>