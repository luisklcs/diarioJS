<!DOCTYPE html>
<html lang="es">

<head>
	<title>Iniciar sesión | Estados judiciales</title>
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="views/assets/img/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(assets/images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Iniciar sesión
						<p class="login100-form-title-2">Estados judiciales</p>
					</span>
				</div>

				<form class="login100-form validate-form" action="" method="POST">
					<div class="wrap-input100 validate-input m-b-26" style="text-align: center;" data-validate="Correo requerido">
						<span class="label-input100">Correo</span>
						<input class="input100" type="email" name="mail" placeholder="Ingrese su correo" required>
						<span class="focus-input100"></span>
					</div>
					<br>

					<div class="wrap-input100 validate-input m-b-18" data-validate="Se requiere la contraseña">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="pass" placeholder="Ingrese su contraseña" required>
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<br>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Ingresar
						</button>
					</div>
				</form>
				<div class="alert alert-primary" role="alert">
			<?php # print_r($_POST); ?>
		</div>

			</div>
			
		</div>

		
		
	</div>



</body>

</html>

<?php
$dir = dirname(__DIR__);

if ($_POST) {
	

	require 'Controller/sessionController.php';
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];

	$obj = new sessionController();
	$data = $obj->IniciarSession($mail, $pass);

}


?>