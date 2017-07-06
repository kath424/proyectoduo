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

		<h1><a hfer="index.html"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg"></a> </h1>
		        

			<nav>

		<ul>
			<li>
				<div class="contenedor_general">

					<div class="contenedor_uno">
						<p class="texto_uno"><a href="/">Inicio</p>
					</div>

					<div class="contenedor_dos">
						<p class="texto_dos">Inicio</p>
					</div>

				</div>
			</li>




			<li>
				<div class="contenedor_general">

					<div class="contenedor_uno">
						<p class="texto_uno">Informacion</p>
					</div>

					<div class="contenedor_dos">
						<p class="texto_dos">Informacion</p>
					</div>

				</div>
			</li>


			<li>
				<div class="contenedor_general">

					<div class="contenedor_uno">
						<p class="texto_uno">Contactos</p>
					</div>

					<div class="contenedor_dos">
						<p class="texto_dos">Contactos</p>
					</div>

				</div>
			</li>


			<li>
				<div class="contenedor_general">

					<?php
					if (isset($_SESSION['user_id'])) {

					?>
						<div class="contenedor_uno">
							<p class="texto_uno"><a href="#">
								<?php echo $_SESSION['usuario']; ?>
							</p>
						</div>

						<div class="contenedor_dos">
							<p class="texto_dos">
								<?php echo $_SESSION['usuario']; ?>
							</p>
						</div>

					<?php
					 } else {
					?>
					 	 <div class="contenedor_uno">
							<p class="texto_uno"><a href="registro.php">Registro</p>
						</div>

						<div class="contenedor_dos">
							<p class="texto_dos">Registro</p>
						</div>
					<?php
					 }
					?>

					

				</div>
			</li>


			<li>
				<div class="contenedor_general">

					<?php
					if (isset($_SESSION['user_id'])) {

					?>
						<div class="contenedor_uno">
							<p class="texto_uno"><a href="logout.php">
								Cerrar Session
							</p>
						</div>

						<div class="contenedor_dos">
							<p class="texto_dos">
								Cerrar Session
							</p>
						</div>

					<?php
					 } else {
					?>
					 	 <div class="contenedor_uno">
						<p class="texto_uno"><a href="login.php">Inicio Sesion</p>
						</div>

						<div class="contenedor_dos">
							<p class="texto_dos">Inicio Sesion</p>
						</div>
					<?php
					 }
					?>

					

				</div>
			</li>

		</ul>

	</nav>
	
		
			
		</header>
		<section id="banner">
			
		</section>

        <section id="noticias">
        <article id="noticia1"></article>
        <article id="noticia2"></article>
        <article id="noticia3"></article>
        <div class="espacio"></div>
        	
        </section>

        <section id="tienda">
        <article id="producto1"></article>
        <article id="producto2"></article>
        <article id="producto3"></article>
        <article id="producto4"></article>
        <div class="espacio"></div>

        	
        </section>
        <section id="marcas">
        	
        </section>
        <footer>
        <p> Todos los derecho reservados <br>
        </p>
        	
        </footer>

        </section><!--contenedor-->


	</body>
</html>