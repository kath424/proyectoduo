<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="=utf-8">
	<meta name="keywords" content="pagina, html5, css3, maquetacion">
	<meta name="description" content="esta es una pagina web con estilos css3">
	<tittle> </tittle>
	<link rel="stylesheet" href="estilos/estilolo.css">
</head>
<body>



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

		$query = "SELECT * FROM   usuarios  WHERE usuario =  '{$_POST['usuario']}'";
		$resultado = $mysqli->query($query);

		if($resultado){// fue exitoso
			$usuario =  $resultado->fetch_object();
			if($usuario->clave == $_POST['clave']){
				// login exitoso , iniciar session y guardar usuario en session
				session_start();
				$_SESSION['user_id'] = $usuario->id;
				$_SESSION['nombre'] = $usuario->nombre;
				$_SESSION['apellido'] = $usuario->apellido;
				$_SESSION['usuario'] = $usuario->usuario;
				$_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;

				header("Location: index.php"); 
    			exit;
			}else{
				$mensaje = "clave incorrecta";
			}
				
		}else{
			$mensaje = "Usuario  incorrecto";
		}
			

	}

?>



	<section id="contenedor">
		<header>

		<h1><a hfer="index.html"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg"></a> </h1>
<?php
	if(isset($mensaje)){// hay un mensaje?  imprimirlo en la pantalla
		echo "<div> $mensaje </div>";
	}
?>
<form action="login.php" method="post" class="login"> 
    <div><label>Username</label><input name="usuario" type="text" ></div> 
    <div><label>Password</label><input name="clave" type="password"></div> 
    <div><input name="login" type="submit" value="Inicio de Sesion"></div>  
    <div><input type="button" id="abc" value="Registrarse!" onclick="location='registro.php'"></div> 
   
</form> 

