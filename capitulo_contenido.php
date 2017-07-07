<?php require('encabezado.php'); ?>

<?php
	// connectarse a la base de datos
	require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

	// obtener capitulo

	$query_capitulo = "SELECT * FROM capitulos "
			." where id = ".$_GET['id'];


	$capitulo = $mysqli->query($query_capitulo);
	if($capitulo){
		$capitulo = $capitulo->fetch_array(MYSQLI_ASSOC);
	}else{
		$mensaje = "Curso no encontrado";
	}
	

?>

<?php if ( intval($_GET['paso']) <= intval($capitulo['pasos'])) { ?> 

<section id="banner">
	<h3> Curso: <?php echo $capitulo['nombre'];  ?> </h3>
	<img src="img/cursos/logica/modulo1.<?php echo $_GET['paso'] ?>.PNG" 
		style="width:100%;" />

	<div  style="width: 100%"> 
		<?php if( intval($_GET['paso']) > 1) { ?>
		<a class="btn btn-blanco izquierda" href="capitulo_contenido.php?id=<?php echo $_GET['id']; ?>&paso=<?php echo intval($_GET['paso'])-1; ?>"> previous </a>
		<?php } ?>
		<a class="btn btn-verde derecha" href="capitulo_contenido.php?id=<?php echo $_GET['id']; ?>&paso=<?php echo intval($_GET['paso'])+1; ?>"> siguiente </a>
	</div>
</section>

<?php } else { ?>

<section id="banner">
	<div style="text-align: center">
		<h1 > Curso Finalizado </h1>
	</div>
	<div style="text-align: center">
		<a class="btn btn-verde btn-grande " href="evaluacion.php?id=<?php echo $_GET['id'] ?>"> Realizar Evaluacion Ahora</a>
	</div>
</section>

<?php } ?>




