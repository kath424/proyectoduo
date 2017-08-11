<?php
$titulo = "Capitulo";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');

redirigirSiNoEstaLogeado();
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// obtener capitulo

$query_capitulo = "SELECT * FROM capitulos "
    . " WHERE id = " . $_GET['id'];


$capitulo = $mysqli->query($query_capitulo);
if ($capitulo) {
    $capitulo = $capitulo->fetch_array(MYSQLI_ASSOC);
} else {
    $mensaje = "Curso no encontrado";
}


?>

<!-- si estamos en un paso del capitulo, mostrar contenido-->
<?php if (intval($_GET['paso']) <= intval($capitulo['pasos'])) { ?>

    <div class="row">
        <div class="col-sm-12">
            <h3> Curso: <?= $capitulo['nombre'] ?> </h3>
            <img src="img/cursos/<?= $_GET['curso'] ?>/<?= $_GET['capitulo'] ?>.<?= $_GET['paso'] ?>.PNG"
                 style="width:100%;"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 btn-group-lg">
            <?php if (intval($_GET['paso']) > 1) { ?>
                <a class="btn btn-primary pull-left"
                   href="capitulo_contenido.php?id=<?= $_GET['id'] ?>&curso=<?= $_GET['curso'] ?>&capitulo=<?= $_GET['capitulo'] ?>&paso=<?= intval($_GET['paso']) - 1 ?>">
                    <i class="glyphicon glyphicon-arrow-left"></i> Previo </a>
            <?php } ?>
            <a class="btn btn-primary pull-right"
               href="capitulo_contenido.php?id=<?= $_GET['id'] ?>&curso=<?= $_GET['curso'] ?>&capitulo=<?= $_GET['capitulo'] ?>&paso=<?= intval($_GET['paso']) + 1 ?>">
                Siguiente  <i class="glyphicon glyphicon-arrow-right"></i> </a>
        </div>
    </div>

    <!--terminamos de ver el contenido, mostrar boton para tomar prueva-->
<?php } else { ?>

    <?php
    // ver si el usuario ya tiene respuestas para este curso-capitulo (ya tomo la prueva anteriormente)
    //$respuestas = [];
    $respuestas_query = "SELECT er.id FROM estudiante_respuestas er"
        . " LEFT JOIN preguntas p"
        . " ON er.preguntas_id = p.id"
        . " WHERE "
        . " usuarios_id = " . $_SESSION['user_id']
        . " AND"
        . " capitulos_id = " . $_GET['id'];

    $resultado = $mysqli->query($respuestas_query);
    if ($resultado) {
        $respuestas = $resultado;
    }

    ?>

    <div class="row">
        <div class="text-center">
            <h1> Curso Finalizado </h1>
        </div>
        <div class="text-center">

            <!-- Hay respuestas, mostrar boton prueva realizada -->
            <?php if (isset($respuestas) && $respuestas->num_rows > 0) { ?>
                <div class="btn btn-warning btn-lg"> Prueba Realizada</div>

                <!-- no hay respuestas, mostrar boton para comenzar prueva -->
            <?php } else { ?>
                <a class="btn btn-primary btn-lg " href="evaluacion.php?id=<?= $_GET['id'] ?>">
                    Realizar Evaluacion Ahora</a>
            <?php } ?>
        </div>
    </div>

<?php } ?>

<?php require('pie.php'); ?>


