<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$titulo = "Registro";
$css = ["estilos/estilore.css"];
require('encabezado.php');
?>

<?php
require('conneccion.php');

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
    <form action="registro.php" method="post" class="registro">

        <div><label>Nombre:</label>
            <input type="text" name="nombre"></div>

        <div><label>Apellido:</label>
            <input type="text" name="apellido"></div>

        <div><label>Cedula:</label>
            <input type="text" name="cedula"></div>

        <div><label>Nombre Usuario:</label>
            <input type="text" name="usuario"></div>

        <div><label>Contra:</label>
            <input type="password" name="clave"></div>

        <div><label>Repetir Contra:</label>
            <input type="password" name="reclave"></div>


        <div><input type="submit" name="enviar" value="Registrar"></div>

        <div><label>Ya tienes una cuenta?<a href="login.php">Entra Aquí!</a></label>
        </div>
    </form>

<?php require('pie.php'); ?>