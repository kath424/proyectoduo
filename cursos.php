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

<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		switch ($_POST['accion']) {
			case "obtenerEstudiante":
				$query_estudiante = "select u.*, c.nombre as nombre_curso from usuarios u"
					." left join cursos_usuarios cu"
					." on  u.id = cu.usuarios_id"
					." left join cursos c"
					." on cu.cursos_id  = c.id"
					." where u.cedula = " . $_POST['cedula'];

				$resultado = $mysqli->query($query_estudiante);
				if($resultado){
					$estudiante = [];
					while($est = $resultado->fetch_array(MYSQLI_ASSOC))
						$estudiante[] = $est;

					// obtener evaluacione del estudiante 
					$query_respondidas = "select cur.nombre as curso,  c.nombre as modulo, c.numero,  "
					." case when p.respuesta = er.respuesta then 'correcto' else 'incorrecto' end as correcto,"
					." count(*) as conteo"
					." from estudiante_respuestas er "
					." left join preguntas p"
					." on p.id = er.preguntas_id"
					." left join capitulos c"
					." on p.capitulos_id = c.id"
					." left join cursos cur"
					." on c.cursos_id = cur.id"
					." where er.usuarios_id = ". $estudiante[0]['id']
					." group by capitulos_id, correcto";

					$resultado = $mysqli->query($query_respondidas);
					if($resultado){
						$agrupados = [];
						while($pregunta = $resultado->fetch_array(MYSQLI_ASSOC)){
							if(!isset($agrupados[$pregunta['modulo']])){
								$agrupados[$pregunta['modulo']] = [
								'curso'=>$pregunta['curso'], 
								'numero'=>$pregunta['numero'],
								'correctas'=>0,
								'incorrectas'=>0,
								];
							}
							if($pregunta['correcto'] == 'correcto'){
								$agrupados[$pregunta['modulo']]['correctas'] = $pregunta['conteo'];
							}else{
								$agrupados[$pregunta['modulo']]['incorrectas'] = $pregunta['conteo']; 
							}
						}
					}else{
						$mensaje ="No has tomado ninguna evaluacion";
					}
				}
				break;
			
			case "agregarCurso":
				$obtenerCursoQuery = "select * from cursos where nombre = '".$_POST['curso'] . "'";
				$resultado = $mysqli->query($obtenerCursoQuery);
				$curso = $resultado->fetch_array(MYSQLI_ASSOC);

				// agregar curso a estudiante
				$agregarCursoQuery = "insert into cursos_usuarios (cursos_id, usuarios_id) VALUES (" 
					. $curso['id'] . " , "
					. $_POST['estudiante_id']
					. " );";

				$resutado = $mysqli->query($agregarCursoQuery);

				break;

			case "reiniciarEvaluacion":
			$respuestasIdsQuery = "select er.id from capitulos c "
				." left join preguntas p"
				." on c.id = p.capitulos_id"
				." left join estudiante_respuestas er"
				." on p.id = er.preguntas_id"
				." where c.nombre = ".'"'.$_POST['capitulo'].'"'
				." and "
				."er.usuarios_id = ". $_POST['estudiante_id'];
			$resultado = $mysqli->query($respuestasIdsQuery);
			$ids = [];
			while($id = $resultado->fetch_array(MYSQLI_ASSOC))
				$ids[] =  $id['id'];

			$reiniciarEvaluacionQuery = "delete from estudiante_respuestas "
				."where id in ( ". implode(',', $ids) .")";
			$resultado = $mysqli->query($reiniciarEvaluacionQuery);
			default:
				break;
		

		}
	}

 ?>


<section id="banner">
	<div> <?php echo isset($mensaje)?$mensaje:''; ?> </div>
	<div > 
		<h2> Cursos </h2>
		<ul >
			<?php while($curso = $cursos->fetch_array(MYSQLI_ASSOC)) { ?>
			
			<li style="margin-left:20px;" > 
				<a href="cursos.php?id=<?php echo $curso['id']; ?>" >
					<?php echo $curso["nombre"]; ?> 
				</a> 
			</li>

			<?php } ?>
		</ul>	
	</div>

	<?php if(isset($_GET['id']) and $_SESSION['tipo_de_usuario'] == 'estudiante' ) { ?>
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
	<?php }else if(isset($_GET['id']) and $_SESSION['tipo_de_usuario'] == 'admin' ) { ?>
		<form action="cursos.php?id=<?php echo $_GET['id']; ?>" method="POST"> 
			<div>
				<label>Ingrese numero de cedula</label>
				<input type="text" name="cedula" placeholder="123123" >
				<!-- accion para saber que hacer en la parte de POST -->
				<input type="text" name="accion" value="obtenerEstudiante" style="display: none">
			</div>
			<div>
				<input name="login" type="submit" value="Obtener Informacion" />
			</div>
		</form>
		<?php if(isset($estudiante)) { ?>
		<h2><?php echo $estudiante[0]['nombre']. ' , ' . $estudiante[0]['apellido']; ?></h2>
		<h3>Cursos</h3>
		<table>
			<thead>
				<th>nombre</th>
			</thead>
			<tbody>
				<?php foreach ($estudiante as $curso) {  ?>
				<tr>
					<td><?php echo $curso['nombre_curso'];?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<form action="cursos.php?id=<?php echo $_GET['id']; ?>" method="POST">
			<p> Agregar curso </p>
			<div>
				<label>Ingrese nombre del curso</label>
				<input type="text" name="curso" placeholder="logica" >
				<!-- accion para saber que hacer en la parte de POST -->
				<input type="text" name="accion" value="agregarCurso" style="display: none">
				<input type="text" name="estudiante_id" value="<?php echo $estudiante[0]['id'] ?>" style="display: none">
			</div>
			<div>
				<input name="login" type="submit" value="Agregar" />
			</div>
		</form>
		<hr />
		<h3>Evaluaciones</h3>
		<table class="calificaciones">
            <thead>
                <th >Curso</th>
                <th >Modulo</th>
                <th >Correctas</th>
                <th >Incorrectas</th>
                <th >#Preguntas</th>
                <th >Calificacion</th>
                <th >Acciones
            </thead>
            <tbody>
                <?php foreach ($agrupados as $modulo => $info) { ?> 
                <tr>
                    <td ><?php echo $info['curso']; ?> </td>
                    <td ><?php echo $modulo; ?> </td>
                    <td ><?php echo $info['correctas']; ?></td>
                    <td ><?php echo $info['incorrectas']; ?></td>
                    <td ><?php echo $info['correctas'] + $info['incorrectas']; ?></td>
                    <td ><?php echo ($info['correctas'] / ($info['correctas'] + $info['incorrectas']) )*100; ?>%</td>
                    <td >
                    	<form action="cursos.php?id=<?php echo $_GET['id']; ?>" method="POST" > 
                    		<input type="submit" value="Reiniciar">
                    		<input type="text" name="estudiante_id" value="<?php echo $estudiante[0]['id']; ?>" style="display: none">
                    		<input type="text" name="capitulo" value="<?php echo $modulo; ?>" style="display: none">
                    		<input type="text" name="accion"  value="reiniciarEvaluacion" style="display: none">
                    	</form>

                    </td>
                </tr>
                <?php } ?>
                
            </tbody>
        </table>
        <?php } ?>
	<?php } ?>

</section>


<footer>
        <p> Todos los derecho reservados <br>
        </p>
        	
        </footer>

        </section><!--contenedor-->

	</body>
</html>

