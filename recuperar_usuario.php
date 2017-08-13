<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$titulo = "Recuperacion de Usuario";
$css = ['estilos/estilologin.css', 'estilos/estilopie.css'];
require('encabezado.php');

?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : null;
    $pregunta = isset($_POST['pregunta']) ? $_POST['pregunta'] : null;
    $respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
    $query = null;
    $error = [];
    switch ($_GET['Accion']) {
        case "buscar usuario":
            if (!empty($usuario) && !empty($cedula)) {
                $error['buscarUsuario'] = "solo ingrese usuario o cedula";
            } else if (!empty($_POST['usuario'])) {
                $mensaje = "Buscar por usuario";
                $query = "SELECT * from usuarios WHERE usuario = '$usuario'";
            } else if (!empty($_POST['cedula'])) {
                $mensaje = "Buscar por Cedula";
                $query = "SELECT * FROM usuarios WHERE usuario = " . $cedula;
            } else {
                $error['buscarUsuario'] = "Ingrese uno de los dos";
            }

            /// busqueda por usuario o cedula. Obtener fila de usuario
            if (isset($query)) {
                require('conneccion.php');
                $resultado = $mysqli->query($query);
                if ($resultado->num_rows > 0) {
                    // usuario existe, obtener preguntas
                    $usuario_fila = $resultado->fetch_array();
                    $query = "SELECT ps.*, rs.id as 'respuestas_id' FROM respuestas_de_seguridad rs "
                        ." LEFT JOIN preguntas_de_seguridad ps"
                        ." ON rs.preguntas_id = ps.id"
                        . " WHERE usuarios_id = " . $usuario_fila['id'];
                    $resultado = $mysqli->query($query);
                    if ($resultado->num_rows > 0) {
                        $preguntas = $resultado;
                    } else {
                        $error['buscarUsuario'] = "este usuario no tiene preguntas de seguridad - no se puede recuperar cuenta";
                    }


                } else {
                    $error['buscarUsuario'] = "usuario no encontrado. Intente de nuevo";
                }
            }
            break;
        case "validar respuesta":
            require('conneccion.php');
            $respuestaCorrectaId = $_POST['pregunta'];
            $resultado = $mysqli->query("SELECT * FROM respuestas_de_seguridad WHERE id = ". $respuestaCorrectaId);
            $respuestaCorrecta = $resultado->fetch_assoc()['respuesta'];
            $respuestaUsuario = $_POST['respuesta'];
            if ($respuestaCorrecta === $respuestaUsuario) {
                $respuestaCorrecta = true;
                $mensaje = "Respuesta Correcta";
            } else {
                $respuestaCorrecta = false;
                $error['respuesta'] = "'{$_POST['respuesta']}' no es correcto. Vuelva a intentar";
                require('conneccion.php');
                $resultado = $mysqli->query("SELECT * FROM preguntas_de_seguridad WHERE usuarios_id = " . $_POST['user_id']);
                $preguntas = $resultado;
                $resultado = $mysqli->query("SELECT * FROM usuarios where id = ". $_POST['user_id']);
                $usuario_fila = $resultado->fetch_array();
            }
            break;
        case "nueva clave":
            $mensaje = "actualizar contra";
            $query = "UPDATE usuarios  SET clave = '" . $_POST['clave'] . "' WHERE id = " . $_POST['user_id'];
            require('conneccion.php');
            $resultado = $mysqli->query($query);
            if ($resultado) {
                // contrasenia fue actualizada, mandar usuario a login
                $mensaje = "Clave actualizada";
                header('Location: login.php');
                exit;
            } else {
                print($query);
                $mensaje = "error actualizadno contra";
            }
            break;
        default:
            $error[] = "Un error ha ocurrido, Por favor Refresque la pagina";
    }


}

?>


    <!--        mostrar errores -->
    <div class="col-sm-12">
        <?php
        if (isset($error)) {
            foreach ($error as $err) {
                echo "<div class='text-danger'><strong>$err</strong></div>";
            }
        }
        ?>
    </div>

    <!--ingresa usuario o cedula valida-->
<?php if (!isset($preguntas) && !isset($respuestaCorrecta)) { ?>

    <h3> Ingrese usuario o numero de cedula para recuperar cuenta</h3>
    <form class="form-inline <?= isset($error['buscarUsuario']) ? 'has-error' : '' ?>"
          action="recuperar_usuario.php?Accion=buscar usuario" method="POST">
        <div class="form-group">
            <label for="usuario" class="control-label">Usuario:</label>
            <input id="usuario" class="form-control" name="usuario" placeholder="usuario12345"
                   value="<?= isset($usuario) ? $usuario : '' ?>"/>
        </div>
        <div class="form-group ">
            <label for="cedula" class="control-label">Cedula:</label>
            <input id="cedula" class="form-control" name="cedula" placeholder="123432"
                   value="<?= isset($cedula) ? $cedula : '' ?>"/>

        </div>
        <button class="btn  btn-primary" type="submit">Buscar <i class="glyphicon glyphicon-search"></i></button>
        <div class="help-block">
            <?= isset($error['buscarUsuario']) ? $error['buscarUsuario'] : '' ?>
        </div>

    </form>

<?php } ?>

    <!--    ingreso un usuario o cedula valida y contiene preguntas de seguridad, mostrar forma para que el usuario responda una pregunta-->
<?php if (isset($usuario_fila) && isset($preguntas)) { ?>
    <h3 class="text-capitalize col-sm-12">Eres
        : <?= isset($usuario_fila) ? ( $usuario_fila['nombre'] . ', ' . $usuario_fila['apellido'] ) : '' ?></h3>
    <form action="recuperar_usuario.php?Accion=validar respuesta" method="POST">
        <input class="hidden" name="user_id" value="<?= isset($usuario_fila) ? $usuario_fila['id'] : '' ?>"/>

        <div class="form-group col-sm-12 col-lg-6">
            <label for="pregunta">Selecciona una preguta:</label>
            <select id="pregunta" class="form-control" name="pregunta" placeholder="Seleccione pregunta" autofocus>
                <option value=""></option>
                <?php
                if (isset($preguntas)) {
                    while ($pregunta = $preguntas->fetch_array()) {
                        echo "<option value=\"{$pregunta['respuestas_id']}\">{$pregunta['pregunta']}</option>";
                    }
                }
                ?>
            </select>

        </div>
        <div class="form-group col-sm-12 col-lg-6 <?= isset($error['respuesta']) ? 'has-error' : '' ?>">
            <?php if (isset($preguntas)) { ?>
                <label for="respuesta" class="control-label">Respuesta:</label>
                <input id="respuesta" class="form-control" name="respuesta" placeholder="mi respuesta"/>
                <div class="help-block">
                    <?= isset($error['respuesta']) ? $error['respuesta'] : '' ?>
                </div>
            <?php } ?>
        </div>

        <div class="col-sm-12 btn-group-lg text-right">
            <a class="btn btn-warning  " href="recuperar_usuario.php">Cancelar <i
                        class="glyphicon glyphicon-remove"></i></a>
            <button class="btn btn-primary  " type="submit">Validar <i class="glyphicon glyphicon-arrow-right"></i>
            </button>
        </div>
    </form>

<?php } ?>

    <!--    respondio la respuesta correctamente, mostrar forma para que pueda ingresar nueva contrasena-->
<?php if (isset($respuestaCorrecta) && $respuestaCorrecta) { ?>
    <h3 class="text-capitalize col-sm-12">Crea una nueva clave</h3>
    <form action="recuperar_usuario.php?Accion=nueva clave" method="POST">
        <input style="display:none" name="user_id" value="<?= isset($_POST['user_id']) ? $_POST['user_id'] : '' ?>"/>

        <div class="form-group col-sm-12 col-lg-6">
            <label for="clave">Contra:</label>
            <input type="password" class="form-control" id="clave" name="clave" placeholder="ingresa clave"/>
        </div>
        <div class="form-group col-sm-12 col-lg-6">
            <label for="reClave">Repetir Contra:</label>
            <input type="password" class="form-control" id="reClave" name="reClave" placeholder="repetir clave"/>
        </div>
        <div class="col-sm-12 btn-group-lg text-right">
            <a class="btn btn-warning  " href="recuperar_usuario.php">Cancelar <i
                        class="glyphicon glyphicon-remove"></i></a>
            <button class="btn btn-primary  " type="submit">Validar <i class="glyphicon glyphicon-save"></i></button>
        </div>
    </form>

<?php } ?>


<?php require('pie.php') ?>