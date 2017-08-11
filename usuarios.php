<?php
$titulo = "Cursos";
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
                    <td>
                        <form action="usuarios.php" method="POST">
                            <input class="hidden" name="accion" value="borrarUsuario"/>
                            <input class="hidden" name="user_id" value="<?= $usuario['id'] ?>"/>
                            <button class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
