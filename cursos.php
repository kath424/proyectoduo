<?php
$titulo = "Cursos";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');

/*
  TODO: Boton de agregar preguntas a evaluaciones/capitulos.
  TODO: Boton de agregar imagenes/contenido a capitulos.
  TODO: Agregar/quitar cursos.
 */

?>

<?php
// conectarse a la base de datos
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos

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
}
else if ($_SESSION['tipo_de_usuario'] === 'admin')
{
    $query = "SELECT * FROM cursos";
}

$resultado = $mysqli->query($query);
if ($resultado) {
    $cursos = $resultado;
} else {
    $mensaje = "no se pudieron obtener los cursos";
}

// por seguridad solo un admin puede ejecutar cualquiera de estas acciones
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['tipo_de_usuario'] === 'admin'){
    switch($_POST['accion']){
        case "agregarCapitulo":
            $query = "INSERT into capitulos (nombre, cursos_id) VALUES"
                ."('{$_POST['nombre']}', {$_POST['curso_id']})";
            $mysqli->query($query);
            break;
        case "cambiarPuedeRepetir":
            $puedeRepetir = !$_POST['puedeRepetir'];
            $puedeRepetir = $puedeRepetir?1:0;
            $query = "UPDATE capitulos SET "
                ."puede_repetir = $puedeRepetir "
            ."where id = {$_POST['capitulo_id']}";

            $mysqli->query($query);
            break;
        case "eliminarCapitulo":
            $query = "DELETE FROM capitulos "
                ."WHERE id = {$_POST['capitulo_id']}";
            $mysqli->query($query);
            break;
        case "agregarPreguntas":
            break;
        case "agregarImagenes":
            break;
    }
}




?>


<div class="row">
    <div> <?= isset($mensaje) ? $mensaje : '' ?> </div>
    <div class="col-sm-12">
        <h2> Cursos
            <small class="<?= $_SESSION['tipo_de_usuario'] == 'estudiante' ? '' : 'hidden' ?>">
                Seleccione uno para ver los capitulos
            </small>
            <small class="<?= $_SESSION['tipo_de_usuario'] == 'admin' ? '' : 'hidden' ?>">
                Seleccione uno para configurar las evaluaciones
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
                        <a class="list-group-item"
                           href="capitulo_contenido.php?id=<?= $cap['id'] ?>&curso=<?= $_GET['nombre'] ?>&capitulo=<?= $cap['nombre'] ?>&paso=1">
                            <?= $cap['nombre'] ?>
                        </a>
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
                    <?php while (isset($capitulos) &&  $cap = $capitulos->fetch_array(MYSQLI_ASSOC)) { ?>


                        <tr>
                            <td><?= $cap['nombre'] ?></td>
                            <td>
                                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre']?>" method="POST">
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="cambiarPuedeRepetir"/>
                                    <input class="hidden" name="puedeRepetir" value="<?= $cap['puede_repetir'] ?>"/>
                                    <button class="btn btn-<?= $cap['puede_repetir'] ? 'primary' : 'default' ?>">
                                        <?= $cap['puede_repetir'] ? 'SI' : 'NO' ?>
                                    </button>

                                </form>
                            </td>
                            <td class="text-center">
                                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre']?>" method="POST">
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="eliminarCapitulo"/>
                                    <button class="btn btn-danger">Eliminar <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </form>
                                <form action="cursos.php?" method="GET">
                                    <input class="hidden" name="id" value="<?= $_GET['id'] ?>"/>
                                    <input class="hidden" name="nombre" value="<?= $_GET['nombre']?>"/>
                                    <input class="hidden" name="capitulo_id" value="<?= $cap['id'] ?>"/>
                                    <input class="hidden" name="accion" value="agregarPreguntas"/>
                                    <button class="btn btn-primary">Preguntas <i class="glyphicon glyphicon-plus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>


                    <?php } ?>
                </table>
            </div>
            <?php if(isset($_GET['accion']) &&  $_GET['accion'] === 'agregarPreguntas') { ?>
            <div class="col-sm-12">
                <h3>Agregar Preguntas</h3>
                <form action="cursos.php" method="GET">

                </form>
            </div>
            <?php } ?>
            <div class="col-sm-12 col-md-6">
                <h3>Agregar Evaluacion/Capitulo</h3>
                <form action="cursos.php?id=<?= $_GET['id'] ?>&nombre=<?= $_GET['nombre']?>" method="POST">
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

            <div class="clearfix">

        <?php } ?>

    </div>
    </div>
<?php } ?>

<?php require('pie.php') ?>

