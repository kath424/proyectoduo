<?php
$titulo = "Evaluacion";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // name =  id de la pregunta
    // value = respuesta
    $userId = $_SESSION['user_id'];
    $query_insertar = "INSERT INTO estudiante_respuestas (respuesta, usuarios_id, preguntas_id) VALUES ";
    $numItems = count($_POST);
    $i = 0;
    foreach ($_POST as $name => $value) {
        $query_insertar .= "( '$value', $userId, $name  ) ";
        if (++$i !== $numItems) {
            $query_insertar .= ', ';
        }
    }

    // connectarse a la base de datos
    require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

    $resultado = $mysqli->query($query_insertar);

    if (!$resultado) {
        echo "No se pudieron guardar sus respuestas <br />";
        echo "Regrese y vuelva a intentar mas tarde;";
    } else {
        echo "Sus respuestas se guardaron correctamente";
    }
    header("Location: index.php");
    exit;

}
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// obtener capitulo

$query_preguntas = "SELECT * FROM preguntas "
    . " WHERE capitulos_id = " . $_GET['id'] . " LIMIT 5";


$resultado = $mysqli->query($query_preguntas);
if ($resultado) {
    $preguntas = $resultado;
} else {
    $mensaje = "Curso no encontrado";
}


?>
    <div class="row">
        <form class="col-sm-12" action="evaluacion.php" method="POST">
            <!-- mostrar todas las preguntas como botones radio-->
            <?php
            $preguntaNum = 1;
            while ($pregunta = $preguntas->fetch_array(MYSQLI_ASSOC)) { ?>
                <div class="form-group">
                    <h4><?= "$preguntaNum.-" . $pregunta['pregunta'] ?></h4>
                    <?php
                    $opciones = explode(',', $pregunta['opciones']);
                    for ($i = 0; $i < count($opciones); $i++) { ?>
                        <label for="pregunta<?= $pregunta['id'] . 'opcion' . $i ?>">
                            <input type="radio"
                                   name="<?= $pregunta['id'] ?>"
                                   value="<?= $opciones[$i] ?>"
                                   id="pregunta<?= $pregunta['id'] . 'opcion' . $i ?>"
                            />
                            <?= $opciones[$i] ?>
                        </label>
                        <br>
                    <?php } ?>
                </div>
                <?php $preguntaNum++;
            } ?>


            <div>
                <button type="submit" class="btn btn-primary btn-lg pull-right ">
                    Entregar <i class="glyphicon glyphicon-check"></i>
                </button>
            </div>
        </form>
    </div>

<?php require('pie.php'); ?>