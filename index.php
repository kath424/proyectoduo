<?php
$titulo = "Pagina Inicial";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');


?>

<?php
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

if (isset($_SESSION['tipo_de_usuario']) && es( 'estudiante')) {
    /*********** es un estudiante, mostrar sus evaluaciones tomadas si ha tomado alguna ******/

    $agrupados = obtererCalificaciones($_SESSION['user_id'], $mysqli);

    ?>

    <!--
    mostrar tabla si hay evaluaciones ('$agrupados' contiente algo),
    mostrar menesaje de lo contrario
    -->
    <div class="row">
        <div class="col-sm-12  <?= $agrupados ? '' : 'hidden' ?> ">
            <h2 class="h2">Evaluaciones </h2>
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
        </div>

        <div class="col-sm-12 <?= !$agrupados ? '' : 'hidden' ?>">
            <h1 class="h1">No has tomado ninguna evaluacion</h1>
        </div>
    </div>

<?php } else if (isset($_SESSION['tipo_de_usuario']) && es('admin')) {
    /********** es un administrador, mostrar campos para buscar informacion acerca de un estudiante ******/
    ?>

    <?php
    /**** funciones para administrar estudiantes *****/
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['accion']) {
            case "obtenerEstudiante":
                $query_estudiante = "SELECT u.*, c.nombre AS nombre_curso, c.id AS curso_id FROM usuarios u"
                    . " LEFT JOIN cursos_usuarios cu"
                    . " ON  u.id = cu.usuarios_id"
                    . " LEFT JOIN cursos c"
                    . " ON cu.cursos_id  = c.id"
                    . " WHERE u.cedula = " . $_POST['cedula'];

                $resultado = $mysqli->query($query_estudiante);
                if ($resultado->num_rows > 0) {
                    $estudiante = [];
                    while ($est = $resultado->fetch_array(MYSQLI_ASSOC))
                        $estudiante[] = $est;

                    // obtener evaluacione del estudiante
                    $agrupados = obtererCalificaciones($estudiante[0]['id'], $mysqli);

                    if (!$agrupados) {
                        $mensaje = "No has tomado ninguna evaluacion";
                    }
                    $query = "SELECT * FROM actividades where usuarios_id = {$estudiante[0]['id']}";
                    $resultado = $mysqli->query($query);
                    $actividades = [];
                    if ($resultado->num_rows > 0) {
                        while ($act = $resultado->fetch_array(MYSQLI_ASSOC)) {
                            $act['tiempo'] = new DateTime($act['tiempo']);
                            $actividades[] = $act;
                        }
                    }
                } else {
                    $cedulaIncorrecta = "Cedula incorrecta. Intente de nuevo";

                }

                break;

            case "reiniciarEvaluacion":
                $respuestasIdsQuery = "SELECT er.id FROM capitulos c "
                    . " LEFT JOIN preguntas p"
                    . " ON c.id = p.capitulos_id"
                    . " LEFT JOIN estudiante_respuestas er"
                    . " ON p.id = er.preguntas_id"
                    . " WHERE c.nombre = " . '"' . $_POST['capitulo'] . '"'
                    . " AND "
                    . "er.usuarios_id = " . $_POST['estudiante_id'];
                $resultado = $mysqli->query($respuestasIdsQuery);
                $ids = [];
                while ($id = $resultado->fetch_array(MYSQLI_ASSOC))
                    $ids[] = $id['id'];

                $reiniciarEvaluacionQuery = "DELETE FROM estudiante_respuestas "
                    . "WHERE id IN ( " . implode(',', $ids) . ")";
                $resultado = $mysqli->query($reiniciarEvaluacionQuery);
                break;

            default:
                break;


        }
    }

    ?>


    <div class="row">
        <form class="col-sm-12  " action="index.php" method="POST">
            <!-- accion para saber que hacer en la parte de POST -->
            <input class="hidden" name="accion" value="obtenerEstudiante">

            <h3 class="text-center"> Ingrese numero de cedula para obtener detalles de un estudiante</h3>
            <div class="form-group col-sm-4 col-sm-offset-4 <?= isset($cedulaIncorrecta)?'has-error':''?> ">
                <label for="cedula" class="control-label">Cedula:</label>
                <input class="form-control" id="cedula" name="cedula" placeholder="123123"/>

                <?php if (isset($cedulaIncorrecta)) { ?>
                    <div class="text-danger" >
                        <?= $cedulaIncorrecta ?>
                    </div>
                <?php } ?>
                <button class="btn btn-primary pull-right"> Obtener Informacion <i
                            class="glyphicon glyphicon-search"></i></button>
            </div>

        </form>

    </div>
    <?php if (isset($estudiante)) { ?>
        <h2 class="text-capitalize text-center"><?= $estudiante[0]['nombre'] . ', ' . $estudiante[0]['apellido'] ?></h2>
        <!-- muestra 10 ultimas actividades-->
        <div class="row">
            <div class="col-sm-12 ">
                <h3>Ultimas 10 activiades</h3>
                <table class="table table-bordered">
                    <?php foreach ($actividades as $act) { ?>
                        <tr>
                            <td><?= $act['tiempo']->format('d/m/Y g:i:s A') ?></td>
                            <td><?= $act['detalles'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <!-- muestra evaluaciones-->
        <div class="row">
            <div class="col-sm-12">
                <h3>Evaluaciones</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Modulo</th>
                        <th>Correctas</th>
                        <th>Incorrectas</th>
                        <th>#Preguntas</th>
                        <th>Calificacion</th>
                        <th class="text-center"><i class="glyphicon glyphicon-cog"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($agrupados as $modulo => $info) { ?>
                        <tr class="<?= ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) ? 'bg-danger' : '' ?> ">
                            <td><?= $info['curso'] ?> </td>
                            <td><?= $modulo ?> </td>
                            <td><?= $info['correctas'] ?></td>
                            <td><?= $info['incorrectas'] ?></td>
                            <td><?= $info['total'] ?></td>
                            <td>
                                <?= (($info['correctas'] / ($info['total'])) * 100 . '%') ?>
                            </td>
                            </td>
                            <td class="text-center">
                                <form action="index.php" method="POST">
                                    <!-- campos ocultos para saber  la accion y para quien es la accion -->
                                    <input type="text" class="hidden" name="capitulo" value="<?= $modulo ?>">
                                    <input type="text" class="hidden" name="accion" value="reiniciarEvaluacion">
                                    <input type="text" class="hidden" name="estudiante_id"
                                           value="<?= $estudiante[0]['id'] ?>">
                                    <button class="btn btn-danger">Reiniciar <i
                                                class="glyphicon glyphicon-refresh"></i></button>
                                </form>

                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>

        </div>
    <?php } // termina - if(isset($estudiante)) ?>

<?php } else { ?>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active">
                <img src="img/carrusel/imagen1.jpg" style="width:100%;">
            </div>

            <div class="item">
                <img src="img/carrusel/imagen2.jpg" style="width:100%;">
            </div>

            <div class="item">
                <img src="img/carrusel/imagen3.jpg" style="width:100%;">
            </div>

        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- 16:9 aspect ratio -->
    <div class="embed-responsive embed-responsive-16by9">
        <iframe width="560" height="315"
                src="https://www.youtube.com/embed/DYE1rkjvSbI?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1"
                frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="well">
                <img src="img/personas/albert.jpg" alt="albert einstein" class="img-circle" style="width:100%">
                <p class="text-">Nunca consideres el estudio como una obligación,
                    sino como una oportunidad para penetrar en el bello
                    y maravilloso mundo del saber.</p>
                <p class="text-right"><strong>-Albert Einstein</strong></p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="well">
                <img src="img/personas/aristoteles.jpg" alt="aristoteles" class="img-circle" style="width:100%">
                <p class="">La inteligencia consiste no sólo en el conocimiento,
                    sino también en la destreza de aplicar los conocimientos en la práctica.
                </p>
                <p class="text-right"><strong>-Aristoteles</strong></p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="well">
                <img src="img/personas/newton.jpg" alt="issac newton" class="img-circle" style="width:100%">
                <p class="">Si he hecho descubrimientos invaluables ha sido más por
                    tener paciencia que cualquier otro talento.
                </p>
                <p class="text-right"><strong>-Issac Newton</strong></p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="well">
                <img src="img/personas/pitagoras.jpg" alt="pitagoras" class="img-circle" style="width:100%">
                <p class="">Prefiero el bastón de la experiencia que el carro rápido de
                    la fortuna. El filósofo viaja a pie.
                </p>
                <p class="text-right"><strong>-Pitagoras</strong></p>
                <p></p>
            </div>
        </div>
    </div>
<?php } ?>

<?php require('pie.php'); ?>
<script>
    $(function(){
        window.scrollTo(0,document.body.scrollHeight);
    })
</script>
