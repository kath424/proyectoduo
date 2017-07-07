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
	<ul>
		<?php while($curso = $cursos->fetch_array(MYSQLI_ASSOC)) { ?>
		
		<li> <?php echo $curso["nombre"]; ?> </li>

		<?php } ?>
	</ul>	
</section>


<footer>
        <p> Todos los derecho reservados <br>
        </p>
        	
        </footer>

        </section><!--contenedor-->

	</body>
</html>

