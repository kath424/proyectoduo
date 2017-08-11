<?php
$titulo = "Practica";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');

?>

<?php
//obtener capitulo
$query = <<<EOT
SELECT * FROM capitulos 
     WHERE id = {$_GET['id']}
EOT;
$curso = $mysqli->query($query)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{


    $userId = $_SESSION['user_id'];
    $query_insertar = "INSERT INTO estudiante_respuestas (respuesta, usuarios_id, preguntas_id) VALUES ";
    $numItems = count($_POST);
    $i = 0;
    foreach ($_POST as $name => $value)
    {
        $query_insertar .= "( '$value', $userId, $name  ) ";
        if (++$i !== $numItems)
        {
            $query_insertar .= ', ';
        }
    }

    // connectarse a la base de datos
    if (!isset($mysqli))
        require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos
    $mysqli->begin_transaction();
    $resultado = $mysqli->query($query_insertar);

    if (!$resultado)
    {
        echo "No se pudieron guardar sus respuestas <br />";
        echo "Regrese y vuelva a intentar mas tarde;";
    }

    $calificaciones = obtererCalificaciones($_SESSION['user_id'], $mysqli);
    $mysqli->rollback();
    $mostrarResultado = true;
    $calificado = [];
    foreach ($calificaciones as $modulo => $info)
    {
        if ($curso['nombre'] === $modulo)
            $calificado[$modulo] = $calificaciones[$modulo];

    }


}
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// obtener capitulo

$query_preguntas = "SELECT * FROM preguntas "
    . " WHERE capitulos_id = " . $_GET['id'];


$resultado = $mysqli->query($query_preguntas);
if ($resultado)
    $preguntas = $resultado;
else
    $mensaje = "Curso no encontrado";


?>

<div class="row <?= !isset($mostrarResultado) ? '' : 'hidden' ?>">
    <h2 class="text-center">Practica.
        <small>(Los resultados no se guardaran)</small>
    </h2>
    <div class="alert alert-warning <?= !isset($mensaje) ? 'hidden' : '' ?>">
        <p><?= isset($mensaje) ? $mensaje : '' ?></p>
    </div>
    <form class="col-sm-12" action="practica.php?id=<?= $_GET['id'] ?>" method="POST">
        <!-- mostrar todas las preguntas como botones radio-->
        <?php
        $preguntaNum = 1;
        while ($pregunta = $preguntas->fetch_array(MYSQLI_ASSOC))
        { ?>
            <div class="form-group">
                <h4><?= "$preguntaNum.-" . $pregunta['pregunta'] ?></h4>
                <?php
                $opciones = explode(',', $pregunta['opciones']);
                for ($i = 0; $i < count($opciones); $i++)
                { ?>
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
            <button class="btn btn-primary btn-lg pull-right " id="botonEntregarExamen">
                Entregar <i class="glyphicon glyphicon-check"></i>
            </button>
        </div>
    </form>
</div>

<div class="row <?= isset($mostrarResultado) && $mostrarResultado ? '' : 'hidden' ?>">
    <h2 class="text-center">Resultados</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Curso</th>
            <th>Modulo</th>
            <th>Correctas</th>
            <th>Incorrectas</th>
            <th>#Preguntas</th>
            <th>Calificacion</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($calificado as $modulo => $info) { ?>
            <!-- marcar rojo si la evalaucion fue incompleta -->
            <tr class="<?= ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) ? 'bg-danger' : '' ?> ">
                <td><?= $info['curso'] ?> </td>
                <td><?= $modulo ?> </td>
                <td><?= $info['correctas'] ?></td>
                <td><?= $info['incorrectas'] ?></td>
                <td><?= $info['total'] ?></td>
                <td>
                    <?= (($info['correctas'] / ($info['total'])) * 100 . '%') ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
    <a class="btn btn-success pull-right" href="practica.php?id=<?= $_GET['id'] ?>">Reintentar</a>
</div>

<?php require('pie.php'); ?>


