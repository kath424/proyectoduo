<?php
$titulo = "Usuarios";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');

redirigirSiNoEstaLogeado();
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && es('admin'))
{
    require('conneccion.php');
    switch ($_POST['accion'])
    {
        case "agregarUsuario":
            guardarProfesor($mysqli,$_POST['nombre'],$_POST['apellido'],  $_POST['usuario'], $_POST['clave']);
            $_POST = [];
            break;
        case "borrarUsuario":
            $query = "DELETE FROM usuarios where id = {$_POST['user_id']}";
            $resultado = $mysqli->query($query);
            break;
        case "modificarClaveUsuario":
            break;

    }
}

// obtener lista de usuarios solo si es admin(seguridad)
if (es('admin'))
{
    require('conneccion.php');
    $query = "SELECT * FROM usuarios";
    $resultado = $mysqli->query($query);
    if ($resultado->num_rows > 0)
    {
        $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    else
    {
        $mensaje = "no se puieron obener los usuarios, intente mas tarde";
    }
}
else
{
    echo '<h1 class="text-danger text-center text-uppercase">no authorizado para ver esta pagina</h1>';
    exit;
}

?>

<div class="row">
    <div><?= issetor($mensaje) ?></div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h3>Usuarios</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Rol</th>
                <th>Usuario</th>
                <th>Cedula</th>
                <th class="text-center"><i class="glyphicon glyphicon-cog"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['apellido'] ?></td>
                    <td><?= $usuario['tipo_de_usuario'] ?></td>
                    <td><?= $usuario['usuario'] ?></td>
                    <td><?= $usuario['cedula'] ?></td>
                    <td class="text-center">
                            <form action="usuarios.php" method="POST">
                                <input class="hidden" name="accion" value="borrarUsuario"/>
                                <input class="hidden" name="user_id" value="<?= $usuario['id'] ?>"/>
                                <button class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                            </form>

                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-sm-12">
        <p class="h3">Agregar Profesor</p>
        <form class="" action="usuarios.php" method="POST" >
            <input class="hidden" name="accion" value="agregarUsuario" />
            <div class="form-group <?= isset($errores['nombre']) ? 'has-error' : '' ?>">
                <label for="nombre" class="sr-only">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user fa"></i></span>
                    <input name="nombre" id="nombre" class="form-control" placeholder="ingresa nombre"
                           value="<?= issetor($_POST['nombre']) ?>"/>
                    <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['nombre']) ? '' : 'hidden' ?>"></span>
                </div>
                <span class="help-block">
                        <?= issetor($errores['nombre']) ?>
                    </span>
            </div>

            <div class="form-group  <?= isset($errores['apellido']) ? 'has-error' : '' ?>">
                <label for="apellido" class="sr-only">Apellido:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user fa"></i></span>
                    <input name="apellido" id="apellido" class="form-control" placeholder="ingresa apellido"
                           value="<?= issetor($_POST['apellido']) ?>"/>
                    <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['apellido']) ? '' : 'hidden' ?>"></span>
                </div>
                <span class="help-block">
                        <?= issetor($errores['apellido']) ?>
                    </span>
            </div>

            <div class="form-group <?= isset($errores['usuario']) ? 'has-error' : '' ?>">
                <label for="usuario" class="sr-only">Nombre Usuario:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user fa"></i></span>
                    <input name="usuario" id="usuario" class="form-control" placeholder="ingresa nombre de usuario"
                           value="<?= issetor($_POST['usuario']) ?>"/>
                    <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['usuario']) ? '' : 'hidden' ?>"></span>
                </div>
                <span class="help-block">
                        <?= issetor($errores['usuario']) ?>
                    </span>
            </div>

            <div class="form-group <?= isset($errores['clave']) ? 'has-error' : '' ?>">
                <label for="clave" class="sr-only">Contra:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock fa"></i></span>
                    <input type="password" name="clave" id="clave" class="form-control" placeholder="ingresa clave"
                           value="<?= issetor($_POST['clave']) ?>"/>
                    <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['clave']) ? '' : 'hidden' ?>"></span>
                </div>
                <span class="help-block">
                        <?= issetor($errores['clave']) ?>
                    </span>
            </div>

            <div class="form-group  <?= isset($errores['reclave']) ? 'has-error' : '' ?>">
                <label for="reclave" class="sr-only">Repetir Contra:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock fa"></i></span>
                    <input type="password" name="reclave" id="reclave" class="form-control"
                           placeholder="confirma clave" value="<?= issetor($_POST['reclave']) ?>"/>
                    <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['reclave']) ? '' : 'hidden' ?>"></span>
                </div>
                <span class="help-block">
                        <?= issetor($errores['reclave']) ?>
                    </span>
            </div>

            <!-- hay un mensaje?  imprimirlo en la pantalla-->
            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?= $mensaje ?></strong>
                </div>
            <?php } ?>

            <button class="btn btn-lg btn-primary btn-block">Agregar</button>

        </form>

    </div>
</div>

<?php require('pie.php'); ?>