<?php
$titulo = "Cursos";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');

?>

<?php
    // verificar que el usuario esta logeado
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    }
?>

<?php
// conectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

// por seguridad solo un admin puede ejecutar cualquiera de estas acciones
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['tipo_de_usuario'] === 'admin') {
    switch ($_POST['accion']) {
        case "eliminarCurso":
            $query = "DELETE FROM cursos WHERE id = " . $_POST['curso_id'];
            $mysqli->query($query);
            if (count($mysqli->error_list) > 0)
                echo "ERROR: " . $mysqli->error;
            break;
        case "agregarCurso":
            $query = "INSERT into cursos (nombre) VALUES "
                . " ('{$_POST['nombre']}')";
            $mysqli->query($query);
            // agregar curso a todos los estudiantes
            $curso_id = $mysqli->insert_id;
            $query_estudiantes = "SELECT id from usuarios where tipo_de_usuario = 'estudiante'";
            $resultado = $mysqli->query($query_estudiantes);
            $agregar_clases_query = "INSERT into cursos_usuarios (usuarios_id,cursos_id) VALUES ";
            $valores = [];
            while($stu = $resultado->fetch_array(MYSQLI_ASSOC)){
                $valores[] = "({$stu['id']} , $curso_id)";
            }
            $agregar_clases_query .= " ".implode(',',$valores);
            $mysqli->query($agregar_clases_query);
            break;
        case "agregarCapitulo":
            $query = "INSERT into capitulos (nombre, cursos_id) VALUES"
                . "('{$_POST['nombre']}', {$_POST['curso_id']})";
            $mysqli->query($query);
            break;
        case "cambiarPuedeRepetir":
            $puedeRepetir = (bool)$_POST['puedeRepetir'];
            $puedeRepetir = (!$puedeRepetir)?1:0;

            $query = "UPDATE capitulos SET "
                . "puede_repetir = $puedeRepetir "
                . "where id = {$_POST['capitulo_id']}";

            $mysqli->query($query);
            break;
        case "eliminarCapitulo":
            $query = "DELETE FROM capitulos "
                . "WHERE id = {$_POST['capitulo_id']}";
            $mysqli->query($query);
            break;
        case "agregarPreguntas":
            $query = "INSERT INTO preguntas (capitulos_id,pregunta,opciones,respuesta) VALUES ";
            $values = [];
            for ($i = 0; $i < count($_POST['pregunta']); $i++) {
                $values[] = "( {$_POST['capitulo_id']},'{$_POST['pregunta'][$i]}','{$_POST['opciones'][$i]}' ,'{$_POST['respuesta'][$i]}' )";
            }
            $query .= implode(',', $values);
            $mysqli->query($query);
            break;
        case "agregarContenido":
            echo "agregarContenido";

            // crear carpeta donde guardar el contenido del curso
            $carpetaDeContenido = 'img/cursos/' . $_POST['nombre'] . '/';
            if (!file_exists($carpetaDeContenido))
                mkdir($carpetaDeContenido, 0777, true);


            $archivo = $_FILES['archivos'];
            for ($i = 0; $i < count($archivo['name']); $i++) {
                move_uploaded_file($archivo['tmp_name'][$i], $carpetaDeContenido . $archivo['name'][$i]);
            }
            //actualizar numero de pasos en base de datos
            $query = "UPDATE capitulos SET pasos = " . count($archivo['name'])
                . " WHERE id = " . $_POST['capitulo_id'];
            $mysqli->query($query);
            break;
    }
}


// obtener cursos disponibles para este usuario
if ($_SESSION['tipo_de_usuario'] === 'estudiante') {
    $query = <<<EOT
    select c.* from usuarios  u
        left join cursos_usuarios  cu
        on cu.usuarios_id = u.id
        left join cursos c
        on cu.cursos_id = c.id
        where u.id = {$_SESSION['user_id']}
EOT;
} else if ($_SESSION['tipo_de_usuario'] === 'admin') {
    $query = "SELECT * FROM cursos";
}

$resultado = $mysqli->query($query);
if ($resultado) {
    $cursos = $resultado;
} else {
    $mensaje = "no se pudieron obtener los cursos";
}

?>

<div class="row">
    <div> <?= isset($mensaje) ? $mensaje : '' ?> </div>
</div>
<div class="row">

    <?php if ($_SESSION['tipo_de_usuario'] == 'estudiante') { ?>
        <div class="col-sm-12">
            <h2> Cursos
                <small>
                    Seleccione uno para ver los capitulos
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
    <?php } else if ($_SESSION['tipo_de_usuario'] == 'admin') { ?>
        <div class="col-sm-12 col-md-6">
            <h2>Cursos
                <small>
                    Seleccione uno para configurar las evaluaciones
                </small>
            </h2>
            <table class="table table-bordered">
                <tr>
                    <th>Nombre</th>
                    <th class="text-center"><i class="glyphicon glyphicon-cog"></i></th>
                </tr>
                <?php while (isset($cursos) && $curso = $cursos->fetch_array(MYSQLI_ASSOC)) { ?>
                    <tr>
                        <td><?= $curso['nombre'] ?></td>
                        <td class="text-center">
                            <form action="cursos.php" method="POST">
                                <input class="hidden" name="curso_id" value="<?= $curso['id'] ?>"/>
                                <input class="hidden" name="accion" value="eliminarCurso"/>
                                <button class="btn btn-danger">Eliminar <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </form>
                            <form action="cursos.php" method="GET">
                                <input class="hidden" name="id" value="<?= $curso['id'] ?>"/>
                                <input class="hidden" name="nombre" value="<?= $curso['nombre'] ?>"/>
                                <button class="btn btn-primary">Editar <i class="glyphicon glyphicon-pencil"></i>
                                </button>
                            </form>
                        </td>
                    </tr>


                <?php } ?>
            </table>
        </div>
        <div class="col-sm-12 col-md-6">
            <h3>Agregar Curso </h3>
            <form action="cursos.php" method="POST">
                <!-- accion para saber que hacer en la parte de POST -->
                <input class="hidden" name="accion" value="agregarCurso"/>

                <div class="form-group">
                    <label for="curso" class="control-label">Ingrese nombre del Curso:</label>
                    <input id="curso" class="form-control" name="nombre" placeholder="Ingles I">
                    <button class=" pull-right btn btn-primary">Agregar <i
                                class="glyphicon glyphicon-plus"></i></button>
                </div>
            </form>
        </div>
    <?php } ?>

</div>

<?php if (isset($_GET['id'])) { ?>
    <div class="row">

        <?php
        $query_capitulos = "SELECT * FROM capitulos "
            . " WHERE cursos_id = " . $_GET['id'];

        $resultado = $mysqli->query($query_capitulos);
        if ($resultado->num_rows > 0) {
            $capitulos = $resultado;
        } else {
            $mensaje = "Curso sin evaluaciones";
        }
        ?>

        <?php if (isset($capitulos) && $_SESSION['tipo_de_usuario'] === 'estudiante') { ?>
            <div class="col-sm-12">
                <h2> Capitulos
                    <small>Seleccione uno para ver el contenido</small>
                </h2>
                <div class="list-group">
                    <?php while ($cap = $capitulos->fetch_array(MYSQLI_ASSOC)) { ?>
                        <?php if ($cap['puede_repetir']) { // es de practica ?>
                            <a class="list-group-item"
                               href="practica.php?id=<?= $cap['id'] ?>">
                                <?= $cap['nombre'] ?> (Practica) <small>Click para empezar</small>
                            </a>

                        <?php } else { ?>
                            <a class="list-group-item"
                               href="capitulo_contenido.php?id=<?= $cap['id'] ?>&curso=<?= $_GET['nombre'] ?>&capitulo=<?= $cap['nombre'] ?>&paso=1">
                                <?= $cap['nombre'] ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } else if ($_SESSION['tipo_de_usuario'] === 'admin') { ?>
            <div class="col-sm-12 col-md-6">
                <h3> Evaluaciones/Capitulos </h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Nombre</th>
                        <th>De Practica</th>
                        <th class="text-center"><i class="glyphicon glyphicon-cog"></i></th>
                    </tr>
                    <?php while (isset($capitulos) && $cap = $capitulos->fetch_array(MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?= $cap['nombre'] ?></td>
                            <td>
                                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>"
                                      method="POST">
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="cambiarPuedeRepetir"/>
                                    <input class="hidden" name="puedeRepetir" value="<?= $cap['puede_repetir'] ?>"/>
                                    <button class="btn btn-<?= $cap['puede_repetir'] ? 'primary' : 'default' ?>">
                                        <?= $cap['puede_repetir'] ? 'SI' : 'NO' ?>
                                    </button>

                                </form>
                            </td>
                            <td class="text-center">
                                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>"
                                      method="POST">
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="eliminarCapitulo"/>
                                    <button class="btn btn-danger">Eliminar <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </form>
                                <form action="cursos.php?" method="GET">
                                    <input class="hidden" name="id" value="<?= $_GET['id'] ?>"/>
                                    <input class="hidden" name="nombre" value="<?= $_GET['nombre'] ?>"/>
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="agregarPreguntas"/>
                                    <button class="btn btn-primary">Preguntas <i class="glyphicon glyphicon-plus"></i>
                                    </button>
                                </form>
                                <form action="cursos.php?" method="GET">
                                    <input class="hidden" name="id" value="<?= $_GET['id'] ?>"/>
                                    <input class="hidden" name="nombre" value="<?= $_GET['nombre'] ?>"/>
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="nombre_capitulo" value="<?= $cap['nombre'] ?>"/>
                                    <input class="hidden" name="accion" value="agregarContenido"/>
                                    <button class="btn btn-primary">Contenido <i class="glyphicon glyphicon-plus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>


                    <?php } ?>
                </table>
            </div>

            <?php if (isset($_GET['accion']) && $_GET['accion'] === 'agregarPreguntas') { ?>
                <div class="col-sm-12">
                    <h3>Agregar Preguntas</h3>
                    <form action="cursos.php" method="GET">
                        <?php foreach ($_GET as $llave => $valor) { ?>
                            <input class="hidden" name="<?= $llave ?>" value="<?= $valor ?>"/>
                        <?php } ?>
                        <div class="form-group form-inline">
                            <label for="numPreguntas">Numero De Preguntas</label>
                            <input id="numPreguntas" type="number" class="form-control" name="numPreguntas"
                                   value="<?= isset($_GET['numPreguntas']) ? $_GET['numPreguntas'] : '' ?>" max="10"
                                   min="1">
                            <button class="btn btn-primary">Crear Preguntas</button>
                        </div>
                    </form>
                    <?php if (isset($_GET['numPreguntas'])) { ?>
                        <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>" method="POST">
                            <?php foreach ($_GET as $llave => $valor) { ?>
                                <input class="hidden" name="<?= $llave ?>" value="<?= $valor ?>"/>
                            <?php } ?>
                            <input class="hidden" name="accion" value="agregarPreguntas"/>
                            <?php for ($i = 0; $i < intval($_GET['numPreguntas']); $i++) { ?>
                                <div class="form-group <?= isset($pregunta3_error) ? 'has-error' : '' ?>">
                                    <label for="pregunta<?= $i ?>" class="control-label"> Pregunta <?= $i + 1 ?></label>
                                    <input id="pregunta<?= $i ?>" class="form-control" name="pregunta[]"
                                           placeholder="como te llamas?">
                                </div>
                                <div class="form-group <?= isset($pregunta3_error) ? 'has-error' : '' ?>">
                                    <label for="opciones<?= $i ?>" class="control-label"> Opciones <?= $i + 1 ?>
                                        <small>separadas con coma</small>
                                    </label>
                                    <input id="opciones<?= $i ?>" class="form-control" name="opciones[]"
                                           placeholder="adrian, katherine">
                                </div>
                                <div class="form-group <?= isset($pregunta3_error) ? 'has-error' : '' ?>">
                                    <label for="respuesta<?= $i ?>" class="control-label">
                                        Respuesta <?= $i + 1 ?></label>
                                    <input id="respuesta<?= $i ?>" class="form-control" name="respuesta[]"
                                           placeholder="adrian">
                                </div>
                            <?php } ?>
                            <div>
                                <button class="btn btn-primary btn-lg">
                                    Guardar
                                </button>
                                <a class="btn btn-warning btn-lg"
                                   href="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['accion']) && $_GET['accion'] === 'agregarContenido') { ?>
                <div class="col-sm-12">
                    <h2>Agregar Imagenes</h2>
                    <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>" method="POST"
                          enctype="multipart/form-data">
                        <?php foreach ($_GET as $llave => $valor) { ?>
                            <input class="hidden" name="<?= $llave ?>" value="<?= $valor ?>"/>
                        <?php } ?>
                        <div class="form-group">
                            <label for="archivos">Seleccione Imagenes para este contenido.</label>
                            <input id="archivos" name="archivos[]" class="form-control" type="file" multiple/>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-lg">
                                Agregar
                            </button>
                            <a class="btn btn-warning btn-lg"
                               href="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            <?php } ?>
            <div class="col-sm-12 col-md-6">
                <h3>Agregar Evaluacion/Capitulo</h3>
                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre'] ?>" method="POST">
                    <!-- accion para saber que hacer en la parte de POST -->
                    <input class="hidden" name="accion" value="agregarCapitulo">
                    <input class="hidden" name="curso_id" value="<?= $_GET['id'] ?>">

                    <div class="form-group">
                        <label for="curso" class="control-label">Ingrese nombre del Capitulo:</label>
                        <input id="curso" class="form-control" name="nombre" placeholder="capitulo3">
                        <button class=" pull-right btn btn-primary">Agregar <i
                                    class="glyphicon glyphicon-plus"></i></button>
                    </div>

                </form>
            </div>

            <div class="clearfix"></div>

        <?php } ?>

    </div>
<?php } ?>

<?php require('pie.php') ?>
<script>
    $(function(){
        window.scrollTo(0,document.body.scrollHeight);
    })
</script>
