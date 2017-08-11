<?php

$titulo = "Preguntas de Seguridad";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');
?>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('conneccion.php');
    guardarEstudiante($mysqli, $_POST['nombre'], $_POST['apellido'], $_POST['cedula'], $_POST['usuario'], $_POST['clave'],  $titulo);

    $errors = [];
    $preguntas = $_POST['preguntas'];
    $respuestas = $_POST['respuestas'];
    // guardar las preguntas de seguridad y mandar a pagina de inicio (usuario logeado a este punto)
    $preguntas_values = [];
    $i = 0;
    foreach (array_combine($preguntas, $respuestas) as $preg => $res) {
        if (empty($preg) && !empty($res)) {
            $errors[$i] = "Debe tener pregunta ";
        } else if (!empty($preg) && empty($res)) {
            $errors[$i] = "Debe tener respuesta";
        } else {
            if(!empty($preg) && !empty($res))
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

        <h3>Estas preguntas se usaran para recuperar usuario o clave</h3>

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