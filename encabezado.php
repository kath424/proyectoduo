<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="=utf-8">
	<meta name="keywords" content="pagina, html5, css3, maquetacion">
	<meta name="description" content="esta es una pagina web con estilos css3">
	<tittle> </tittle>
	<link rel="stylesheet" href="estilos/estilos.css">
</head>
<body>
	<?php
		// permite accessar $_SESSION para saver si el usuario esta logeado
		session_start();
	?>


	<section id="contenedor">
		<header>

			<h1>
				<a hfer="index.html"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg">
				</a> 
			</h1>


			<nav class="navegacion">

				<ul>
					<li>
						<div class="contenedor_general">

							<div class="contenedor_uno">
								<p class="texto_uno"><a href="index.php">Inicio</a></p>
							</div>

							<div class="contenedor_dos">
								<p class="texto_dos"><a href="index.php">Inicio </a></p>
							</div>

						</div>
					</li>




					<li>
						<div class="contenedor_general">

							<div class="contenedor_uno">
								<p class="texto_uno"><a href="informacion.php">Informacion </a></p>
							</div>

							<div class="contenedor_dos">
								<p class="texto_dos"><a href="informacion.php">Informacion</a></p>
							</div>

						</div>
					</li>


					<li>
						<div class="contenedor_general">

							<div class="contenedor_uno">
								<p class="texto_uno"><a href="contactos.php">Contactos</a></p>
							</div>

							<div class="contenedor_dos">
								<p class="texto_dos"><a href="contactos.php">Contactos</a></p>
							</div>

						</div>
					</li>


					<li>
						<div class="contenedor_general">

							<?php if (isset($_SESSION['user_id'])) {  ?>
								<div class="contenedor_uno">
									<p class="texto_uno">
										<a href="#">
										<?php echo $_SESSION['usuario']; ?>
										</a>
									</p>
								</div>

								<div class="contenedor_dos">
									<p class="texto_dos">
										<a href="#">
										<?php echo $_SESSION['usuario']; ?>
										</a>
									</p>
								</div>

								<?php } else { ?>
								<div class="contenedor_uno">
									<p class="texto_uno">
										<a href="registro.php">Registro</a>
									</p>
								</div>

								<div class="contenedor_dos">
									<p class="texto_dos">
										<a href="registro.php">Registro</a>
									</p>
								</div>
								<?php } ?>



						</div>
					</li>


					<li>
						<div class="contenedor_general">

							<?php
							if (isset($_SESSION['user_id'])) {
							?>
								<div class="contenedor_uno">
									<p class="texto_uno">
										<a href="logout.php"> Cerrar Session </a>
									</p>
								</div>

								<div class="contenedor_dos">
									<p class="texto_dos">
										<a href="logout.php">  Cerrar Session </a>
									</p>
								</div>

							<?php
							} else {
							?>
								<div class="contenedor_uno">
									<p class="texto_uno">
										<a href="login.php">Inicio Sesion</a>
									</p>
								</div>
								<div class="contenedor_dos">
									<p class="texto_dos">
										<a href="login.php">Inicio Sesion</a>
									</p>
								</div>
								<?php
							}
							?>


						</div>
					</li>

				</ul>

			</nav>
		</header>
