<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$titulo = "Inicio Session";
$css = ['estilos/estilolo.css'];
require('encabezado.php');
?>

<?php

// si el usuario mando la forma de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // connectarse a la base de datos
    require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

    $query = "SELECT * FROM   usuarios  WHERE usuario =  '{$_POST['usuario']}'";
    $resultado = $mysqli->query($query);

    if ($resultado->num_rows > 0) {// fue exitoso
        $usuario = $resultado->fetch_object();
        if ($usuario->clave == $_POST['clave']) {
            // login exitoso , iniciar session y guardar usuario en session
            session_start();
            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['apellido'] = $usuario->apellido;
            $_SESSION['usuario'] = $usuario->usuario;
            $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;

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

<?php

if (isset($mensaje)) {// hay un mensaje?  imprimirlo en la pantalla
    echo "<div> $mensaje </div>";
}
?>
    <form action="login.php" method="post" class="login">

        <div><label>Usuario:</label>
            <input name="usuario" type="text"></div>

        <div><label>Contraseña:</label>
            <input name="clave" type="password"></div>

        <div><input name="login" type="submit" value="Inicia Sesion"></div>

        <div><label>No tienes una cuenta?<a href="registro.php">Entra Aquí!</a></label>
        </div>
        <div><label><a href="recuperar_usuario.php">Olvide mi Contraseña/Usuario!</a></label>
        </div>

    </form>

<?php require('pie.php'); ?>