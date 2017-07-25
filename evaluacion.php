<?php
$titulo = "Evaluacion";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
/*
  TODO: Si evaluacion es de practica, no guardar resultado en la base de datos.
  TODO: Mostra comparativo de respuestas correctas vs. respuestas de usuario.
 */
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // verificar que el estudiante tomo menos de 2 horas para hacer el examen
    $tiempoTomadoParaPrueva = time() - $_SESSION['empezo_prueva']->getTimeStamp();
    $unaHora = 60*60;
    if($tiempoTomadoParaPrueva >= $unaHora){
        // se paso de tiempo
        $mensaje = "Tiempo limite excedido, Comienza de nuevo";
        //
    }else{
        // tardo menos de 2 horas, guardar informacion y mandar al inicio
        // name =  id de la pregunta
        // value = respuesta
        $mensaje = "Tiempo fue menor a 2 horas";

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



}
else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    //entro al examen

    // si no ha empezado la evaluacion, iniciar tiempo
    if(! isset($_SESSION['empezo_prueva'])){
        $_SESSION['empezo_prueva'] = new DateTime();
        // refrescar session
        actualizarUltimoLogeo($_SESSION['user_id'], $_SESSION['empezo_prueva'], $titulo, $mysqli);
    }
}
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// obtener capitulo

$query_preguntas = "SELECT * FROM preguntas "
    . " WHERE capitulos_id = " . $_GET['id'] ;


$resultado = $mysqli->query($query_preguntas);
if ($resultado) {
    $preguntas = $resultado;
} else {
    $mensaje = "Curso no encontrado";
}


?>
    <h2 class="text-center">Tiempo Restante : <span id="tiempoRestante"></span><small>(mm:ss)</small> </h2>
    <div class="alert alert-warning <?= !isset($mensaje)?'hidden':'' ?>">
        <p><?= isset($mensaje)?$mensaje:'' ?></p>
    </div>
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
                <button type="submit" class="btn btn-primary btn-lg pull-right " id="botonEntregarExamen">
                    Entregar <i class="glyphicon glyphicon-check"></i>
                </button>
            </div>
        </form>
    </div>



<?php require('pie.php'); ?>

<script>
    function ponerTiempoRestanteEnPantalla() {
        var inicioEvaluacion = parseInt(<?= $_SESSION['empezo_prueva']->getTimestamp() ?>);

        var ahora = parseInt((new Date).getTime() / 1000);

        var tiempoRestante = 60*60 - ( ahora - inicioEvaluacion);

        if(tiempoRestante <= 0 ){
            $("#botonEntregarExamen").click();
        }

        var minutes = Math.floor(tiempoRestante / 60);
        var seconds = tiempoRestante % 60;

        //Anteponiendo un 0 a los minutos si son menos de 10
        minutes = minutes < 10 ? '0' + minutes : minutes;

        //Anteponiendo un 0 a los segundos si son menos de 10
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var result = minutes + ":" + seconds ;  // 161:30
        $("#tiempoRestante").html(result)
    }
    ponerTiempoRestanteEnPantalla();
    setInterval(ponerTiempoRestanteEnPantalla,1000);


</script>
