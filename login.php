<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// incluir encabezado con titulo y estilos
$titulo = "Inicio Session";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');


// si el usuario mando la forma de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // connectarse a la base de datos
    require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos
    //ejemplo : $_POST = ['usuario'=> 'adrianplusplus', 'clave' => 'vision' ];
    $query = "SELECT * FROM   usuarios  WHERE usuario = '{$_POST['usuario']}'";
    $resultado = $mysqli->query($query);

    if ($resultado->num_rows > 0) { // verificar si usuario existe
        // fue exitoso, usuario existe
        $usuario = $resultado->fetch_object();

        if ($usuario->clave === $_POST['clave']) { // verificar si la clave es validad
            // login exitoso , iniciar session y guardar usuario en session
            session_start();
            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['apellido'] = $usuario->apellido;
            $_SESSION['usuario'] = $usuario->usuario;
            $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;
            $_SESSION['tiempo_de_entrada'] = time();

            actualizarUltimoLogeo($usuario->id, $_SESSION['tiempo_de_entrada'], $titulo);

            // redijirir a la pagina de inicio
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "clave incorrecta";
        }

    } else {
        $mensaje = "Usuario  incorrecto";
    }

}



?>

    <form class="form-signin" action="login.php" method="POST">
        <h2 class="form-signin-heading">Inicia Sesion Aqui:</h2>
        <label for="usuario" class="sr-only" >Usuario:</label>
        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required autofocus>
        <label for="clave" class="sr-only" >Contraseña:</label>
        <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required>
        <!-- hay un mensaje?  imprimirlo en la pantalla-->
        <?php  if (isset($mensaje)) { ?>
            <div class="alert alert-danger" role="alert">
                <strong><?= $mensaje ?></strong>
            </div>
        <?php } ?>
        <div class="">
            <label> No tienes una cuenta?<a href="registro.php">Entra Aquí!</a> </label>
            <label> <a href="recuperar_usuario.php">Olvide mi Contraseña/Usuario!</a> </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </form>

<?php require('pie.php'); ?>