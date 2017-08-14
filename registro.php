<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// incluir encabezado con titulo y estilos
$titulo = "Registro";
$ocultarBanner = true;
$css = ['estilos/estilopie.css', 'estilos/estilologin.css'];
require('encabezado.php');

// verificar que la informacion de la forma sea correcta
function informacionEsIncorrecta()
{

    $errores = [];

    // verificar que ningun campo este vacio
    $campos = ['nombre', 'apellido', 'usuario', 'cedula', 'clave', 'reclave'];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo]))
            $errores[$campo] = $campo . ' no puede estar vacio';
    }

    /* verificar que nombre, apellido sea solo letras */
    if (!ctype_alpha($_POST['nombre']))
        $errores['nombre'] = 'Nombre solo debe contener letras';
    if (!ctype_alpha(($_POST['apellido'])))
        $errores['apellido'] = 'Apellido solo debe contener letras';

    /* verificar que cedula sean solo numeros */
    if (!ctype_digit($_POST['cedula']))
        $errores['cedula'] = 'Cedula solo puede contener numeros';

    /* verificar que las claves coincidan */
    if ($_POST['clave'] !== $_POST['reclave'])
        $errores['reclave'] = 'Claves deben coincidir';


    if (count($errores) > 0)
        return $errores;
    else
        return false;
}

// si el usuario mando la forma de registracion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // connectarse a la base de datos
    // hace disponible el objecto $mysqli  ya conectado a la base de datos
    require('conneccion.php');

    // si la informacion es correcta llamar funcion para guardar usuario
    $errores = informacionEsIncorrecta();
    if (!$errores) { // si no hay errores
        // pasar informacion a la siguiente pagina
        $campos = ['nombre', 'apellido', 'usuario', 'cedula', 'clave', 'reclave'];
        $qs = [];
        foreach ($campos as $campo) {
            $qs[] = $campo . '=' . $_POST[$campo];
        }
        // mostrar preguntas de seguridad para recuperacion de cuenta
        header('Location: registro2.php?' . implode('&', $qs));
        exit;

    }

}

?>


<?php

if (isset($mensaje)) {// hay un mensaje?  imprimirlo en la pantalla
    echo "<div> $mensaje </div>";
}
?>

    <div class="">
        <!--        <div class="panel-heading">-->
        <!--            <div class="panel-title text-center">-->
        <!--                <h1 class="title">Project-DUO</h1>-->
        <!--                <hr/>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="main-login main-center">
            <form class="form-horizontal" action="registro2.php" method="post" class="registro" onsubmit="return confirm('Esta seguro que la informacion ingresada es correcta?');">
                <h2 class="form-signin-heading">Registro Aqui:</h2>
                <div class="form-group <?= isset($errores['nombre']) ? 'has-error' : '' ?>">
                    <label for="nombre" class="sr-only">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa"></i></span>
                        <input name="nombre" id="nombre" class="form-control" placeholder="ingresa nombre"
                               value="<?= issetor($_POST['nombre']) ?>" required autofocus/>
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
                               value="<?= issetor($_POST['apellido']) ?>" required/>
                        <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['apellido']) ? '' : 'hidden' ?>"></span>
                    </div>
                    <span class="help-block">
                        <?= issetor($errores['apellido']) ?>
                    </span>
                </div>

                <div class="form-group  <?= isset($errores['cedula']) ? 'has-error' : '' ?>">
                    <label for="cedula" class="sr-only">Cedula:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-hashtag fa"></i></span>
                        <input name="cedula" id="cedula" class="form-control" placeholder="ingresa numero de cedula"
                               value="<?= issetor($_POST['cedula']) ?>" required/>
                        <span class="glyphicon glyphicon-remove form-control-feedback  <?= isset($errores['cedula']) ? '' : 'hidden' ?>"></span>
                    </div>
                    <span class="help-block">
                        <?= issetor($errores['cedula']) ?>
                    </span>
                </div>

                <div class="form-group <?= isset($errores['usuario']) ? 'has-error' : '' ?>">
                    <label for="usuario" class="sr-only">Nombre Usuario:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa"></i></span>
                        <input name="usuario" id="usuario" class="form-control" placeholder="ingresa nombre de usuario"
                               value="<?= issetor($_POST['usuario']) ?>" required/>
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
                               value="<?= issetor($_POST['clave']) ?>" required/>
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

                <div>
                    <label>Ya tienes una cuenta?<a href="login.php">Entra Aquí!</a> </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block">Registro</button>

            </form>
        </div>
    </div>
<?php require('pie.php'); ?>