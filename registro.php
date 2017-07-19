<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// incluir encabezado con titulo y estilos
$titulo = "Registro";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');


// si el usuario mando la forma de registracion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // connectarse a la base de datos
    // hace disponible el objecto $mysqli  ya conectado a la base de datos
    require('conneccion.php');

    $query = "INSERT into usuarios(nombre, apellido, cedula, usuario, clave) VALUES ('{$_POST['nombre']}','{$_POST['apellido']}', '{$_POST['cedula']}', '{$_POST['usuario']}',  '{$_POST['clave']}' )";
    $resultado = $mysqli->query($query);

    if ($resultado) {// fue exitoso
        // login
        $query = "SELECT * FROM   usuarios  WHERE usuario =  '{$_POST['usuario']}'";
        $resultado = $mysqli->query($query);
        $usuario = $resultado->fetch_object();

        // logear usario para que llene las preguntas de recuperacion
        session_start();
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['nombre'] = $usuario->nombre;
        $_SESSION['apellido'] = $usuario->apellido;
        $_SESSION['usuario'] = $usuario->usuario;
        $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;

        // agregar todos los cursos de la tabla de cursos
        // preparar valores a insertar (id de curso, id de estudiante)
        $query = "SELECT id from cursos";
        $cursos = $mysqli->query($query);
        $cursos_stu = [];
        while ($curso = $cursos->fetch_array())
            $cursos_stu[] = "( {$curso['id']} , $usuario->id )";

        $cursos_stu = implode(',', $cursos_stu);
        // agregar cursos
        $query = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES ".$cursos_stu;
        $resultado = $mysqli->query($query);

        // mostrar preguntas de seguridad para recuperacion de cuenta
        header('Location: registro2.php');
        exit;
    } else {
        $mensage = "Error al agregar usuario";
    }

}

?>

<?php

if (isset($mensaje)) {// hay un mensaje?  imprimirlo en la pantalla
    echo "<div> $mensaje </div>";
}
?>
    <form class="form-signin" action="registro.php" method="post" class="registro">
        <h2 class="form-signin-heading">Registro Aqui:</h2>
        <label for="nombre" class="sr-only">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Katherine" />

        <label for="apellido" class="sr-only">Apellido:</label>
        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Acosta" />

        <label for="cedula" class="sr-only">Cedula:</label>
        <input type="text" name="cedula" id="cedula" class="form-control" placeholder="12523" />

        <label for="usuario" class="sr-only">Nombre Usuario:</label>
        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="acosta123" />

        <label for="clave"  class="sr-only">Contra:</label>
        <input type="password" style="margin-bottom: 0" name="clave" id="clave" class="form-control" placeholder="******" />

        <label for="reclave" class="sr-only">Repetir Contra:</label>
        <input type="password" name="reclave" id="reclave" class="form-control" placeholder="******" />

        <!-- hay un mensaje?  imprimirlo en la pantalla-->
        <?php  if (isset($mensaje)) { ?>
            <div class="alert alert-danger" role="alert">
                <strong><?= $mensaje ?></strong>
            </div>
        <?php } ?>

        <div>
            <label>Ya tienes una cuenta?<a href="login.php">Entra Aquí!</a> </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

    </form>

<?php require('pie.php'); ?>