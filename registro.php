<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="=utf-8">
	<meta name="keywords" content="pagina, html5, css3, maquetacion">
	<meta name="description" content="esta es una pagina web con estilos css3">
	<tittle> </tittle>
	<link rel="stylesheet" href="estilos/estilore.css">
	
</head>
<body>



	<section id="contenedor">
		<header>

		<h1><a hfer="index.html"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg"></a> </h1>



	
<?php 
	// antes de cargar el contenido
	// si ya esta logeado,  redirijir usuario a la pagina incial
	session_start();
	if(isset($_SESSION['user_id'])){
		header("Location: index.php"); 
    	exit;
	}

	// si el usuario mando la forma de registracion
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		// connectarse a la base de datos
		require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

		$query = "INSERT into usuarios(nombre, apellido, cedula, usuario, clave) VALUES ('{$_POST['nombre']}','{$_POST['apellido']}', '{$_POST['cedula']}', '{$_POST['usuario']}',  '{$_POST['clave']}' )";

		$resultado = $mysqli->query($query);
		if($resultado){// fue exitoso
			$mensaje = "Usuario fue agregado exitosamente";
		}else{
			$mensage = "Error al agregar usuario";
		}

	}

?>


<?php
	if(isset($mensaje)){// hay un mensaje?  imprimirlo en la pantalla
		echo "<div> $mensaje </div>";
	}
?>
<form action="registro.php" method="post" class="registro"> 

<div><label>Nombre:</label> 
<input type="text" name="nombre"></div>

<div><label>Apellido:</label> 
<input type="text" name="apellido"></div> 

<div><label>Cedula:</label> 
<input type="text" name="cedula"></div> 

<div><label>Nombre Usuario:</label> 
<input type="text" name="usuario"></div> 
<div>

<div><label>Contra:</label> 
<input type="password" name="clave"></div> 

<div><label>Repetir Contra:</label> 
<input type="password" name="reclave"></div> 
 
 <div><label>Ya tienes una cuenta?<a href="login.php" >Entra Aquí!</a></label>
</form>


<input type="submit" name="enviar" value="Registrar">
</div> 

 
</form> 

