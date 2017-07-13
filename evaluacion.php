<?php
$titulo = "Evaluacion";
$css = ['estilos/estilos.css'];
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
    echo $query_insertar;
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

    <form action="evaluacion.php" method="POST">

        <div id="banner">
            <?php while ($pregunta = $preguntas->fetch_array(MYSQLI_ASSOC)) { ?>
                <div style="width: 100%; padding-top: 5px;">
                    <label><?php echo $pregunta['pregunta']; ?></label><br>
                    <?php
                    $opciones = explode(',', $pregunta['opciones']);
                    for ($i = 0; $i < count($opciones); $i++) { ?>
                        <label>
                            <input type="radio"
                                   name="<?php echo $pregunta['id']; ?>"
                                   value="<?php echo $opciones[$i]; ?>"
                            />
                            <?php echo $opciones[$i]; ?>
                        </label>
                        <br>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
        <div style="width:100%; position:relative;">
            <button type="submit" class="btn btn-verde btn-grande derecha ">
                Entregar
            </button>
        </div>
    </form>

<?php require('pie.php'); ?>