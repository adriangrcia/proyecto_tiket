<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Login - StartUI</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- Estilos -->
	<link rel="stylesheet" href="public/css/separate/pages/login.min.css">
	<link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/main.css">
</head>
<body>

	<div class="page-center">
		<div class="page-center-in">
			<div class="container-fluid">
				<!-- Formulario mejorado -->
				<form class="sign-box" action="login.php" method="post" autocomplete="off">
					<div class="sign-avatar">
						<img src="public/img/avatar-sign.png" alt="Avatar Login">
					</div>
					<header class="sign-title">Sign In</header>
					
					<?php if (isset($_GET['logout'])): ?>
    					<div class="alert alert-success text-center">✅ Sesión cerrada correctamente</div>
					<?php endif; ?>


					<!-- Campo Email -->
					<div class="form-group">
						<label for="email" class="sr-only">E-Mail</label>
						<input type="email" id="email" name="email" class="form-control" placeholder="E-Mail" required>
					</div>

					<!-- Campo Password -->
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" required minlength="6">
					</div>

					<!-- Opciones -->
					<div class="form-group d-flex justify-content-between align-items-center">
						<div class="checkbox">
							<input type="checkbox" id="signed-in" name="remember">
							<label for="signed-in">Keep me signed in</label>
						</div>
						<div class="reset">
							<a href="reset-password.html">Forgot password?</a>
						</div>
					</div>

					<!-- Botón login -->
					<button type="submit" class="btn btn-primary btn-rounded btn-block">Sign In</button>

					<p class="sign-note mt-3">New to our website? <a href="sign-up.html">Sign up</a></p>
				</form>
			</div>
		</div>
	</div><!--.page-center-->

	<!-- Scripts -->
	<script src="public/js/lib/jquery/jquery.min.js"></script>
	<script src="public/js/lib/tether/tether.min.js"></script>
	<script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="public/js/plugins.js"></script>
	<script src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>

	<script>
		$(function() {
			$('.page-center').matchHeight({
				target: $('html')
			});

			$(window).resize(function(){
				setTimeout(function(){
					$('.page-center').matchHeight({ remove: true });
					$('.page-center').matchHeight({
						target: $('html')
					});
				},100);
			});
		});
	</script>
	<script src="public/js/app.js"></script>
</body>
</html>
