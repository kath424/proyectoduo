<?php

$titulo = "Preguntas de Seguridad";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');
?>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('conneccion.php');
    $mysqli->begin_transaction();
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
        $query = "INSERT INTO respuestas_de_seguridad "
            . " (preguntas_id, respuesta, usuarios_id) VALUES "
            . implode(',', $preguntas_values);
        // connectarse a la base de datos
        // hace disponible el objecto $mysqli  ya conectado a la base de datos
        $resultado = $mysqli->query($query);
        if ($resultado) {
            $mysqli->commit();
            header('Location: index.php');
            exit;
        } else {
            echo '<div style="color:red;" > Error al guardar preguntas </div>';
            $_SESSION = []; // limpiar variables.
        }


    }

}

require('conneccion.php');
// obtener lista de preguntas de seguridad
$query = "SELECT * FROM preguntas_de_seguridad";
$resultado = $mysqli->query($query);
if($resultado->num_rows > 0)
    $preguntas = $resultado->fetch_all(MYSQLI_ASSOC);

?>

    <form action="registro2.php" method="POST" onsubmit="return confirm('Esta seguro que la informacion ingresada es correcta?');">
        <?php foreach ($_GET as $llave => $valor) { ?>
            <input class="hidden" name="<?= $llave ?>" value="<?= $valor ?>"/>
        <?php } ?>

        <h3>Estas preguntas se usaran para recuperar usuario o clave</h3>

        <?php for ($i = 0; $i < 3; $i++) { ?>
            <div class="form-group <?= isset($errors[$i]) ? 'has-error' : '' ?> ">
                <label for="pregunta<?= $i+1 ?>" class="control-label"> Pregunta <?= $i+1 ?>: </label>
                <select id="pregunta" class="form-control" name="preguntas[]" placeholder="Seleccione pregunta">
                    <option value="">Seleccione pregunta</option>
                    <?php
                    if (isset($preguntas)) {
                        foreach ($preguntas as $pregunta) {
                            echo "<option value=\"{$pregunta['id']}\">{$pregunta['pregunta']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group <?= isset($errors[$i]) ? 'has-error' : '' ?>">
                <label for="respuesta<?= $i+1 ?>" class="control-label"> Respuesta <?= $i+1 ?>:</label>
                <input id="respuesta<?= $i+1 ?>" class="form-control" name="respuestas[]"
                       value="<?= isset($_POST['respuestas'][$i]) ? $_POST['respuestas'][$i] : '' ?>" >
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