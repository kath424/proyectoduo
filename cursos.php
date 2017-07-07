<?php require('encabezado.php'); ?>

<?php 
	// connectarse a la base de datos
	require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

	// obtener cursos disponibles para este estudiante

	$query = "select c.* from usuarios  u"
			." right join cursos_usuarios  cu"
			." on cu.usuarios_id = u.id"
			." right join cursos c"
			." on cu.cursos_id = c.id"
			." where u.id = {$_SESSION['user_id']}";


	$resultado = $mysqli->query($query);
	if($resultado){
		$cursos = $resultado;
	}else{
		$mensaje = "no se pudieron obtener los cursos";
	}
	
?>

<section id="banner">
	<div> <?php echo isset($mensaje)?$mensaje:''; ?> </div>
	<div > 
		<h2> Cursos </h2>
		<ul  ">
			<?php while($curso = $cursos->fetch_array(MYSQLI_ASSOC)) { ?>
			
			<li style="margin-left:20px;" > 
				<a href="cursos.php?id=<?php echo $curso['id']; ?>" >
					<?php echo $curso["nombre"]; ?> 
				</a> 
			</li>

			<?php } ?>
		</ul>	
	</div>

	<?php if(isset($_GET['id'])) { ?>
	<div >
		<?php 
			$query_capitulos = "SELECT * FROM capitulos "
			." where cursos_id = ".$_GET['id'];

			$capitulos = $mysqli->query($query_capitulos);
			if($capitulos){
				$capitulos = $capitulos;
			}else{
				$mensaje = "No Capitulos encontrados";
			}
		 ?>
		<h1> Capitulos </h1>
		<ul>
			<?php while($cap = $capitulos->fetch_array(MYSQLI_ASSOC) ) { ?>
			<li style="margin-left:20px;">
				<a href="capitulo_contenido.php?id=<?php echo $cap['id'];  ?>&paso=1" > 
					<?php echo $cap['nombre'] ?>
				</a>	
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>

</section>


<footer>
        <p> Todos los derecho reservados <br>
        </p>
        	
        </footer>

        </section><!--contenedor-->

	</body>
</html>

