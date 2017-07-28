<?php
$titulo = "Pagina Inicial";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
/*
  TODO: mostrar las ultimas 10 actividades de un estudiante al administrador.
*/
?>

<?php
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

if ($_SESSION['tipo_de_usuario'] == 'estudiante') {
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
                            <?php
                            if ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) {
                                echo "N/A";
                            } else {
                                echo ($info['correctas'] / ($info['total'])) * 100 . '%';
                            }
                            ?>
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

<?php } else if ($_SESSION['tipo_de_usuario'] == 'admin') {
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
                if ($resultado) {
                    $estudiante = [];
                    while ($est = $resultado->fetch_array(MYSQLI_ASSOC))
                        $estudiante[] = $est;

                    // obtener evaluacione del estudiante
                    $agrupados = obtererCalificaciones($estudiante[0]['id'], $mysqli);

                    if (!$agrupados) {
                        $mensaje = "No has tomado ninguna evaluacion";
                    }
                }
                $query = "SELECT * FROM actividades where usuarios_id = {$estudiante[0]['id']}";
                $resultado = $mysqli->query($query);
                $actividades = [];
                if($resultado->num_rows > 0){
                    while($act = $resultado->fetch_array(MYSQL_ASSOC)) {
                        $act['tiempo'] = new DateTime($act['tiempo']);
                        $actividades[] = $act;
                    }
                }
                break;

            case "agregarCurso":
                $obtenerCursoQuery = "SELECT * FROM cursos WHERE nombre = '" . $_POST['curso'] . "'";
                $resultado = $mysqli->query($obtenerCursoQuery);
                $curso = $resultado->fetch_array(MYSQLI_ASSOC);

                // agregar curso a estudiante
                $agregarCursoQuery = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES ("
                    . $curso['id'] . " , "
                    . $_POST['estudiante_id']
                    . " );";

                $resutado = $mysqli->query($agregarCursoQuery);

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

            case "quitarClase":
                $query = "DELETE FROM cursos_usuarios 
                  WHERE usuarios_id = {$_POST['estudiante_id']} 
                  AND cursos_id = {$_POST['curso_id']}
                ";
                $resultado = $mysqli->query($query);
                break;

            default:
                break;


        }
    }

    ?>


    <div class="row">
        <form class="col-sm-12 form-inline " action="index.php" method="POST">
            <!-- accion para saber que hacer en la parte de POST -->
            <input class="hidden" name="accion" value="obtenerEstudiante">

            <h3> Ingrese numero de cedula para obtener detalles de un estudiante</h3>
            <div class="form-group">
                <label for="cedula" class="control-label">Cedula:</label>
                <input class="form-control" id="cedula" name="cedula" placeholder="123123"/>
            </div>
            <button class="btn btn-primary "> Obtener Informacion <i
                        class="glyphicon glyphicon-search"></i></button>

        </form>
    </div>
    <?php if (isset($estudiante)) { ?>
        <h2 class="text-capitalize text-center"><?= $estudiante[0]['nombre'] . ', ' . $estudiante[0]['apellido'] ?></h2>

        <div class="row">
            <div class="col-sm-12 ">
                <h3>Ultimas 10 activiades</h3>
                <table class="table table-bordered">
                    <?php foreach ($actividades as $act) { ?>
                        <tr>
                            <td><?= $act['tiempo']->format('d/m/Y g:i:s A') ?></td>
                            <td ><?= $act['detalles']?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h3>Cursos</h3>
                <table class="table table-bordered">
                    <?php foreach ($estudiante as $curso) { ?>
                        <tr>
                            <td><?= $curso['nombre_curso'] ?></td>
                            <td class="text-center">
                                <form action="index.php" method="POST">
                                    <!-- campos ocultos para saber  la accion y para quien es la accion -->
                                    <input class="hidden" name="curso_id" value="<?= $curso['curso_id'] ?>">
                                    <input class="hidden" name="accion" value="quitarClase">
                                    <input class="hidden" name="estudiante_id" value="<?= $estudiante[0]['id'] ?>">
                                    <button class="btn btn-danger">Quitar <i
                                                class="glyphicon glyphicon-trash"></i></button>
                                </form>


                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-sm-12 col-md-6">
                <h3> Agregar curso </h3>
                <form action="index.php" method="POST">
                    <!-- accion para saber que hacer en la parte de POST -->
                    <input class="hidden" name="accion" value="agregarCurso">
                    <input class="hidden" name="estudiante_id" value="<?= $estudiante[0]['id'] ?>">

                    <div class="form-group">
                        <label for="curso" class="control-label">Ingrese nombre del curso:</label>
                        <input id="curso" class="form-control" name="curso" placeholder="logica">
                        <button class=" pull-right btn btn-primary">Agregar <i
                                    class="glyphicon glyphicon-plus"></i></button>
                    </div>

                </form>
            </div>
        </div>
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
                                <?php
                                if ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) {
                                    echo "N/A";
                                } else {
                                    echo ($info['correctas'] / ($info['total'])) * 100 . '%';
                                }
                                ?>
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

<?php } ?>

<?php require('pie.php'); ?>