<?php
$titulo = "Capitulo";
$css = ['estilos/estilos.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
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

<?php if (intval($_GET['paso']) <= intval($capitulo['pasos'])) { ?>

    <section id="banner">
        <h3> Curso: <?php echo $capitulo['nombre']; ?> </h3>
        <img src="img/cursos/logica/modulo1.<?php echo $_GET['paso'] ?>.PNG"
             style="width:100%;"/>

    </section>
    <div style="width: 100%; position: relative;">
        <?php if (intval($_GET['paso']) > 1) { ?>
            <a class="btn btn-blanco izquierda"
               href="capitulo_contenido.php?id=<?php echo $_GET['id']; ?>&paso=<?php echo intval($_GET['paso']) - 1; ?>">
                previous </a>
        <?php } ?>
        <a class="btn btn-verde derecha"
           href="capitulo_contenido.php?id=<?php echo $_GET['id']; ?>&paso=<?php echo intval($_GET['paso']) + 1; ?>">
            siguiente </a>
    </div>

    <?php
} else {
    ?>

    <?php
    $respuestas = [];
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

    <section id="banner">
        <div style="text-align: center">
            <h1> Curso Finalizado </h1>
        </div>
        <div style="text-align: center">

            <?php if (!$respuestas->num_rows > 0) { ?>
                <a class="btn btn-verde btn-grande " href="evaluacion.php?id=<?php echo $_GET['id'] ?>"> Realizar
                    Evaluacion Ahora</a>
            <?php } else { ?>
                <div class="btn btn-blanco btn-grande"> Prueba Realizada</div>
            <?php } ?>
        </div>
    </section>

<?php } ?>

<?php require('pie.php'); ?>


