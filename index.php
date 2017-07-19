<?php
$titulo = "Pagina Inicial";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos
$agrupados = [];
$query_respondidas = "select cur.nombre as curso,  c.nombre as modulo, c.numero,  "
    . " case when p.respuesta = er.respuesta then 'correcto' else 'incorrecto' end as correcto,"
    . " count(*) as conteo"
    . " from estudiante_respuestas er "
    . " left join preguntas p"
    . " on p.id = er.preguntas_id"
    . " left join capitulos c"
    . " on p.capitulos_id = c.id"
    . " left join cursos cur"
    . " on c.cursos_id = cur.id"
    . " where er.usuarios_id = " . $_SESSION['user_id']
    . " group by capitulos_id, correcto";

$resultado = $mysqli->query($query_respondidas);
if ($resultado) {

    while ($pregunta = $resultado->fetch_array(MYSQLI_ASSOC)) {
        if (!isset($agrupados[$pregunta['modulo']])) {
            $agrupados[$pregunta['modulo']] = [
                'curso' => $pregunta['curso'],
                'numero' => $pregunta['numero'],
                'correctas' => 0,
                'incorrectas' => 0,
            ];
        }
        if ($pregunta['correcto'] == 'correcto') {
            $agrupados[$pregunta['modulo']]['correctas'] = $pregunta['conteo'];
        } else {
            $agrupados[$pregunta['modulo']]['incorrectas'] = $pregunta['conteo'];
        }
    }
} else {
    $mensaje = "No has tomado ninguna evaluacion";
}

// agrupar por capitulo (1 set de preguntas por capitulo)


?>


    <div class="col-sm-12  <?= intval($resultado->num_rows) > 0 ? '' : 'hidden' ?> ">
        <h2>Evaluaciones </h2>
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
            <?php foreach ($agrupados as $modulo => $info) { ?>
                <tr>
                    <td><?= $info['curso'] ?> </td>
                    <td><?= $modulo ?> </td>
                    <td><?= $info['correctas'] ?></td>
                    <td><?= $info['incorrectas'] ?></td>
                    <td><?= $info['correctas'] + $info['incorrectas'] ?></td>
                    <td><?= ($info['correctas'] / ($info['correctas'] + $info['incorrectas'])) * 100 ?>%</td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
    <div class="col-sm-12 <?= intval($resultado->num_rows) == 0 ? '' : 'hidden' ?>">
        <h1>No has tomado ninguna evaluacion</h1>
    </div>
    <!--     <section id="noticias">
            <article id="noticia1"></article>
            <article id="noticia2"></article>
            <article id="noticia3"></article>
            <div class="espacio"></div>

        </section>

        <section id="tienda">
            <article id="producto1"></article>
            <article id="producto2"></article>
            <article id="producto3"></article>
            <article id="producto4"></article>
            <div class="espacio"></div>


        </section>
        <section id="marcas">

        </section> -->

<?php require('pie.php'); ?>