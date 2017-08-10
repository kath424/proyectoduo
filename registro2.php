<?php

$titulo = "Preguntas de Seguridad";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');
?>

<?php

function guardarUsuario(mysqli $mysqli, $nombre, $apellido, $cedula, $usuario, $clave)
{
    $query = "INSERT into usuarios(nombre, apellido, cedula, usuario, clave) VALUES
          ('$nombre','$apellido', '$cedula', '$usuario',  '$clave' )";
    $resultado = $mysqli->query($query);

    if ($resultado) {// fue exitoso
        // login
        $query = "SELECT * FROM   usuarios  WHERE usuario =  '$usuario'";
        $resultado = $mysqli->query($query);
        $usuario = $resultado->fetch_object();

        if (!isset($_SESSION))
            session_start();
        // logear usario para que llene las preguntas de recuperacion
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['nombre'] = $usuario->nombre;
        $_SESSION['apellido'] = $usuario->apellido;
        $_SESSION['usuario'] = $usuario->usuario;
        $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;
        $_SESSION['tiempo_de_entrada'] = new DateTime();

        actualizarUltimoLogeo($usuario->id, $_SESSION['tiempo_de_entrada'], $titulo, $mysqli);

        // agregar todos los cursos de la tabla de cursos
        // preparar valores a insertar (id de curso, id de estudiante)
        $query = "SELECT id FROM cursos";
        $cursos = $mysqli->query($query);
        $cursos_stu = [];
        while ($curso = $cursos->fetch_array())
            $cursos_stu[] = "( {$curso['id']} , $usuario->id )";

        $cursos_stu = implode(',', $cursos_stu);
        // agregar cursos
        $query = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES " . $cursos_stu;
        $mysqli->query($query);

    } else {
        $mensaje = "Error al agregar usuario";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('conneccion.php');
    guardarUsuario($mysqli, $_POST['nombre'], $_POST['apellido'], $_POST['cedula'], $_POST['usuario'], $_POST['clave']);

    $errors = [];
    $preguntas = $_POST['preguntas'];
    $respuestas = $_POST['respuestas'];
    // guardar las preguntas de seguridad y mandar a pagina de inicio (usuario logeado a este punto)
    $preguntas_values = [];
    $i = 0;
    foreach (array_combine($preguntas, $respuestas) as $preg => $res) {
        if (empty($preg) && !empty($res)) {
            $errors[$i] = " Debe tener pregunta ";
        } else if (!empty($preg) && empty($res)) {
            $errors[$i] = "Debe tener respuesta";
        } else {
            $preguntas_values[] = "('{$preg}', '{$res}' , {$_SESSION['user_id']} )";
        }

        $i++;
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO preguntas_de_seguridad "
            . " (pregunta, respuesta, usuarios_id) VALUES"
            . implode(',', $preguntas_values);
        // connectarse a la base de datos
        // hace disponible el objecto $mysqli  ya conectado a la base de datos
        require('conneccion.php');
        $resultado = $mysqli->query($query);
        if ($resultado) {
            header('Location: index.php');
            exit;
        } else {
            echo '<div style="color:red;" > Error al guardar preguntas </div>';
        }


    }

}

?>

    <form action="registro2.php" method="POST">
        <?php foreach ($_GET as $llave => $valor) { ?>
            <input class="hidden" name="<?= $llave ?>" value="<?= $valor ?>"/>
        <?php } ?>

        <h3>Estas preguntas se usaran para recuperar usuario o contrasena</h3>

        <?php for ($i = 0; $i < 3; $i++) { ?>
            <div class="form-group <?= isset($errors[$i]) ? 'has-error' : '' ?> ">
                <label for="pregunta<?= $i+1 ?>" class="control-label"> Pregunta <?= $i+1 ?>: </label>
                <input id="pregunta<?= $i+1 ?>" class="form-control" name="preguntas[]"
                       value="<?= isset($_POST['preguntas'][$i]) ? $_POST['preguntas'][$i] : '' ?>">
            </div>
            <div class="form-group <?= isset($errors[$i]) ? 'has-error' : '' ?>">
                <label for="respuesta<?= $i+1 ?>" class="control-label"> Respuesta <?= $i+1 ?>:</label>
                <input id="respuesta<?= $i+1 ?>" class="form-control" name="respuestas[]"
                       value="<?= isset($_POST['respuestas'][$i]) ? $_POST['respuestas'][$i] : '' ?>">
            </div>
            <span class="text-danger"><?= isset($errors[$i]) ? $errors[$i] : '' ?></span>

            <hr/>
        <?php } ?>

        <div>
            <button class="btn btn-primary btn-lg ">
                Guardar <i class="glyphicon glyphicon-floppy-disk"></i>
            </button>
        </div>
    </form>

<?php require('pie.php') ?>