<?php
$titulo = "Cursos";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
?>

<?php
// connectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// obtener cursos disponibles para este usuario

$query = "select c.* from usuarios  u"
    . " right join cursos_usuarios  cu"
    . " on cu.usuarios_id = u.id"
    . " right join cursos c"
    . " on cu.cursos_id = c.id"
    . " where u.id = {$_SESSION['user_id']}";


$resultado = $mysqli->query($query);
if ($resultado) {
    $cursos = $resultado;
} else {
    $mensaje = "no se pudieron obtener los cursos";
}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['accion']) {
        case "obtenerEstudiante":
            $query_estudiante = "SELECT u.*, c.nombre AS nombre_curso FROM usuarios u"
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
                    . " where er.usuarios_id = " . $estudiante[0]['id']
                    . " group by capitulos_id, correcto";

                $resultado = $mysqli->query($query_respondidas);
                if ($resultado) {
                    $agrupados = [];
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
        default:
            break;


    }
}

?>


<div class="row">
    <div> <?= isset($mensaje) ? $mensaje : '' ?> </div>
    <div class="col-sm-12">
        <h2> Cursos
            <small class="<?= $_SESSION['tipo_de_usuario'] == 'estudiante' ? '' : 'hidden' ?>">Seleccione uno para ver
                los capitulos
            </small>
        </h2>
        <div class="list-group">
            <?php while ($curso = $cursos->fetch_array(MYSQLI_ASSOC)) { ?>

                <a class="list-group-item <?= (isset($_GET['id']) && $curso['id'] === $_GET['id']) ? 'active' : '' ?>"
                   href="cursos.php?id=<?= $curso['id'] ?>&nombre=<?= $curso['nombre'] ?>">
                    <?= $curso["nombre"] ?>
                </a>

            <?php } ?>
        </div>

    </div>
</div>
<?php if (isset($_GET['id']) and $_SESSION['tipo_de_usuario'] == 'estudiante') { ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
            $query_capitulos = "SELECT * FROM capitulos "
                . " WHERE cursos_id = " . $_GET['id'];

            $resultado = $mysqli->query($query_capitulos);
            if ($resultado) {
                $capitulos = $resultado;
            } else {
                $mensaje = "No Capitulos encontrados";
            }
            ?>
            <h2> Capitulos
                <small>Seleccione uno para ver el contenido</small>
            </h2>
            <div class="list-group">
                <?php while ($cap = $capitulos->fetch_array(MYSQLI_ASSOC)) { ?>
                    <a class="list-group-item"
                       href="capitulo_contenido.php?id=<?= $cap['id'] ?>&curso=<?= $_GET['nombre'] ?>&capitulo=<?= $cap['nombre'] ?>&paso=1">
                        <?= $cap['nombre'] ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else if ($_SESSION['tipo_de_usuario'] == 'admin') { ?>
    <div class="row">
        <form class="col-sm-12 form-inline " action="cursos.php" method="POST">
            <!-- accion para saber que hacer en la parte de POST -->
            <input type="text" class="hidden" name="accion" value="obtenerEstudiante">

            <h3> Ingrese numero de cedula para obtener detalles de un estudiante</h3>
            <div class="form-group">
                <label for="cedula" class="control-label">Cedula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="123123"/>
            </div>
            <button class="btn btn-primary " type="submit"> Obtener Informacion <i
                        class="glyphicon glyphicon-search"></i></button>

        </form>
    </div>
<?php if (isset($estudiante)) { ?>
    <div class="row">
        <h2 class="text-capitalize text-center"><?= $estudiante[0]['nombre'] . ', ' . $estudiante[0]['apellido'] ?></h2>
        <div class="col-sm-12 col-md-6">
            <h3>Cursos</h3>
            <div class="list-group">
                <?php foreach ($estudiante as $curso) { ?>
                    <div class="list-group-item"><?= $curso['nombre_curso'] ?></div>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <h3> Agregar curso </h3>
            <form action="cursos.php" method="POST">
                <!-- accion para saber que hacer en la parte de POST -->
                <input type="text" class="hidden" name="accion" value="agregarCurso">
                <input type="text" class="hidden" name="estudiante_id" value="<?= $estudiante[0]['id'] ?>">
                <div class="form-group">
                    <label for="curso" class="control-label">Ingrese nombre del curso:</label>
                    <input id="curso" class="form-control" type="text" name="curso" placeholder="logica">
                    <button class=" pull-right btn btn-primary" type="submit">Agregar <i
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
                <tr>
                    <td><?= $info['curso'] ?> </td>
                    <td><?= $modulo ?> </td>
                    <td><?= $info['correctas'] ?></td>
                    <td><?= $info['incorrectas'] ?></td>
                    <td><?= $info['correctas'] + $info['incorrectas'] ?></td>
                    <td><?= ($info['correctas'] / ($info['correctas'] + $info['incorrectas'])) * 100 ?>%
                    </td>
                    <td class="text-center">
                        <form action="cursos.php" method="POST">
                            <!-- campos ocultos para saber  la accion y para quien es la accion -->
                            <input type="text" class="hidden" name="capitulo" value="<?= $modulo ?>">
                            <input type="text" class="hidden" name="accion" value="reiniciarEvaluacion">
                            <input type="text" class="hidden" name="estudiante_id" value="<?= $estudiante[0]['id'] ?>">
                            <button class="btn btn-danger" type="submit">Reiniciar <i
                                        class="glyphicon glyphicon-refresh"></i></button>
                        </form>

                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
        <?php } ?>
        <?php } ?>
    </div>
</div>
</div>


<?php require('pie.php') ?>

