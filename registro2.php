<?php

// antes de cargar el contenido
// si no esta logeado, mandar a login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$titulo = "Preguntas de Seguridad";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;
    // guardar las preguntas de seguridad y mandar a pagina de inicio (usuario logeado a este punto)
    $preguntas_values = [];
    if ((empty($_POST['pregunta1']) && !empty($_POST['respuesta1']))) {
        $pregunta1_error = " Debe tener pregunta ";
        $error = true;
    } else if ((!empty($_POST['pregunta1']) && empty($_POST['respuesta1']))) {
        $pregunta1_error = " Debe tener respuesta ";
        $error = true;
    } else {
        $preguntas_values[] = "('{$_POST['pregunta1']}', '{$_POST['respuesta1']}' , {$_SESSION['user_id']} )";
    }

    // pregunta2
    if ((empty($_POST['pregunta2']) && !empty($_POST['respuesta2']))) {
        $pregunta2_error = " Debe tener pregunta ";
        $error = true;
    } else if ((!empty($_POST['pregunta2']) && empty($_POST['respuesta2']))) {
        $pregunta2_error = " Debe tener respuesta ";
        $error = true;
    } else {
        $preguntas_values[] = "('{$_POST['pregunta2']}', '{$_POST['respuesta2']}' , {$_SESSION['user_id']} )";
    }

    // pregunta 3
    if ((empty($_POST['pregunta3']) && !empty($_POST['respuesta3']))) {
        $pregunta3_error = " Debe tener pregunta ";
        $error = true;
    } else if ((!empty($_POST['pregunta3']) && empty($_POST['respuesta3']))) {
        $pregunta3_error = " Debe tener respuesta ";
        $error = true;
    } else {
        $preguntas_values[] = "('{$_POST['pregunta3']}', '{$_POST['respuesta3']}' , {$_SESSION['user_id']}  )";
    }

    if (!$error) {
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
            echo '<div style="color:red;" > Error trying to save questions </div>';
        }


    }

}

?>

<form action="registro2.php" method="POST">
    <h3>Estas preguntas se usaran para recuperar usuario o contrasena</h3>
    <div class="form-group <?= isset($pregunta1_error) ? 'has-error' : '' ?> " >
        <label for="pregunta1" class="control-label"> Pregunta1</label>
        <input id="pregunta1" class="form-control" name="pregunta1" value="<?= isset($_POST['pregunta1']) ? $_POST['pregunta1'] : '' ?>">
    </div>
    <div class="form-group <?= isset($pregunta1_error) ? 'has-error' : '' ?>">
        <label for="respuesta1" class="control-label"> Respuesta</label>
        <input id="respuesta1" class="form-control" name="respuesta1" value="<?= isset($_POST['respuesta1']) ? $_POST['respuesta1'] : '' ?>">
    </div>
    <span class="text-danger"><?= isset($pregunta1_error) ? $pregunta1_error : '' ?></span>

    <hr/>

    <div class="form-group <?= isset($pregunta2_error) ? 'has-error' : '' ?>">
        <label for="pregunta2" class="control-label"> Pregunta2</label>
        <input id="pregunta2" class="form-control"  name="pregunta2" value="<?= isset($_POST['pregunta2']) ? $_POST['pregunta2'] : '' ?>">
    </div>
    <div class="form-group <?= isset($pregunta2_error) ? 'has-error' : '' ?>">
        <label for="respuesta2" class="control-label"> Respuesta</label>
        <input id="respuesta2" class="form-control"  name="respuesta2" value="<?= isset($_POST['respuesta2']) ? $_POST['respuesta2'] : '' ?>">
    </div>
    <div class="text-danger"><?= isset($pregunta2_error) ? $pregunta2_error : '' ?></div>

    <hr/>

    <div class="form-group <?= isset($pregunta3_error) ? 'has-error' : '' ?>">
        <label for="pregunta3" class="control-label"> Pregunta3</label>
        <input id="pregunta3" class="form-control"  name="pregunta3" value="<?= isset($_POST['pregunta3']) ? $_POST['pregunta3'] : '' ?>">
    </div>
    <div class="form-group <?= isset($pregunta3_error) ? 'has-error' : '' ?>">
        <label for="respuesta3" class="control-label"> Respuesta</label>
        <input id="respuesta3" class="form-control"  name="respuesta3" value="<?= isset($_POST['respuesta3']) ? $_POST['respuesta3'] : '' ?>">
    </div>
    <div class="text-danger"><?= isset($pregunta3_error) ? $pregunta3_error : '' ?></div>
    <div>
        <button type="submit" class="btn btn-primary btn-lg ">
            Guardar
        </button>
    </div>
</form>

<?php require('pie.php') ?>