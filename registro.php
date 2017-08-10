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


// si el usuario mando la forma de registracion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // connectarse a la base de datos
    // hace disponible el objecto $mysqli  ya conectado a la base de datos
    require('conneccion.php');

    // verificar que la informacion de la forma sea correcta
    function informacionEsIncorrecta(){

        $errores = [];

        /* verificar que nombre, apellido sea solo letras */
        if(!ctype_alpha($_POST['nombre']))
            $errores['nombre'] = 'Nombre solo debe contener letras';
        if(!ctype_alpha(($_POST['apellido'])))
            $errores['apellido'] = 'Apellido solo debe contener letras';

        /* verificar que cedula sean solo numeros */
        if(!ctype_alpha($_POST['cedula']))
            $errores['cedula'] = 'Cedula solo puede contener numeros';

        /* verificar que las claves coincidan */
        if($_POST['clave'] !== $_POST['reclave'])
            $errores['reclave'] = 'Claves deben coincidir';

        if(count($errores) > 0)
            return $errores;
        else
            return false;
    }

    function guardarUsuario(mysqli $mysqli){
        $query = "INSERT into usuarios(nombre, apellido, cedula, usuario, clave) VALUES ('{$_POST['nombre']}','{$_POST['apellido']}', '{$_POST['cedula']}', '{$_POST['usuario']}',  '{$_POST['clave']}' )";
        $resultado = $mysqli->query($query);

        if ($resultado) {// fue exitoso
            // login
            $query = "SELECT * FROM   usuarios  WHERE usuario =  '{$_POST['usuario']}'";
            $resultado = $mysqli->query($query);
            $usuario = $resultado->fetch_object();

            // logear usario para que llene las preguntas de recuperacion
            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['apellido'] = $usuario->apellido;
            $_SESSION['usuario'] = $usuario->usuario;
            $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;
            $_SESSION['tiempo_de_entrada'] = new DateTime();

            actualizarUltimoLogeo($usuario->id, $_SESSION['tiempo_de_entrada'], $titulo, $mysqli);

            // agregar todos los cursos de la tabla de cursos
            // preparar valores a insertar (id de curso, id de estudiante)
            $query = "SELECT id FROM cursos";
            $cursos = $mysqli->query($query);
            $cursos_stu = [];
            while ($curso = $cursos->fetch_array())
                $cursos_stu[] = "( {$curso['id']} , $usuario->id )";

            $cursos_stu = implode(',', $cursos_stu);
            // agregar cursos
            $query = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES " . $cursos_stu;
            $resultado = $mysqli->query($query);

            // mostrar preguntas de seguridad para recuperacion de cuenta
            header('Location: registro2.php');
            exit;
        }
        else {
            $mensaje = "Error al agregar usuario";
        }
    }

    // si la informacion es correcta llamar funcion para guardar usuario
    $errores = informacionEsIncorrecta();
    if(!$errores){
        guardarUsuario($mysqli);
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
            <form class="form-horizontal" action="registro.php" method="post" class="registro">
                <h2 class="form-signin-heading">Registro Aqui:</h2>
                <div class="form-group <?= isset($errores['nombre'])?'has-error':'' ?>" >
                    <label for="nombre" class="sr-only">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" ></i></span>
                        <input name="nombre" id="nombre" class="form-control" placeholder="ingresa nombre" value="<?= issetor($_POST['nombre']) ?>"/>
                    </div>
                    <span  class="help-block">
                        <?= isset($errores['nombre'])?$errores['nombre']:'' ?>
                    </span>
                </div>

                <div class="form-group  <?= isset($errores['apellido'])?'has-error':'' ?>">
                    <label for="apellido" class="sr-only">Apellido:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" ></i></span>
                        <input name="apellido" id="apellido" class="form-control" placeholder="ingresa apellido" value="<?= issetor($_POST['apellido']) ?>"/>
                    </div>
                    <span  class="help-block">
                        <?= isset($errores['apellido'])?$errores['apellido']:'' ?>
                    </span>
                </div>

                <div class="form-group  <?= isset($errores['cedula'])?'has-error':'' ?>">
                    <label for="cedula" class="sr-only">Cedula:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-hashtag fa" ></i></span>
                        <input name="cedula" id="cedula" class="form-control" placeholder="ingresa numero de cedula" value="<?= issetor($_POST['cedula']) ?>"/>
                    </div>
                    <span  class="help-block">
                        <?= isset($errores['cedula'])?$errores['cedula']:'' ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="usuario" class="sr-only">Nombre Usuario:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" ></i></span>
                        <input name="usuario" id="usuario" class="form-control" placeholder="ingresa nombre de usuario" value="<?= issetor($_POST['usuario']) ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="clave" class="sr-only">Contra:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa" ></i></span>
                        <input type="password" name="clave" id="clave" class="form-control" placeholder="ingresa clave" value="<?= issetor($_POST['clave']) ?>"/>
                    </div>
                </div>

                <div class="form-group  <?= isset($errores['reclave'])?'has-error':'' ?>">
                    <label for="reclave" class="sr-only">Repetir Contra:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa" ></i></span>
                        <input type="password" name="reclave" id="reclave" class="form-control" placeholder="confirma clave" value="<?= issetor($_POST['reclave']) ?>"/>
                    </div>
                    <span  class="help-block">
                        <?= isset($errores['reclave'])?$errores['reclave']:'' ?>
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
                <button class="btn btn-lg btn-primary btn-block">Entrar</button>

            </form>
        </div>
    </div>
<?php require('pie.php'); ?>