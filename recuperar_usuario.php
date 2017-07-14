<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$titulo = "Recuperacion de Usuario";
$css = ["estilos/estilos.css"];
require('encabezado.php');

?>

<?php
// buscar por usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = isset($_POST['usuario'])?$_POST['usuario']:null;
    $cedula = isset($_POST['cedula'])?$_POST['cedula']:null;
    $pregunta = isset($_POST['pregunta']) ? $_POST['pregunta'] : null;
    $respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
    $query = null;
    $error = [];
    switch ($_GET['Accion']) {
        case "buscar usuario":
            if (!empty($usuario) && !empty($cedula)) {
                $error[] = "solo ingrese usuario o cedula";
            } else if (!empty($_POST['usuario'])) {
                $mensaje = "Buscar por usuario";
                $query = "SELECT * from usuarios WHERE usuario = '$usuario'";
            } else if (!empty($_POST['cedula'])) {
                $mensaje= "Buscar por Cedula";
                $query = "SELECT * FROM usuarios WHERE usuario = " . $cedula;
            } else {
                $error[] = "Ingrese uno de los dos";
            }

            /// busqueda por usuario o cedula. Obtener fila de usuario
            if (isset($query)) {
                require('conneccion.php');
                $resultado = $mysqli->query($query);
                if ($resultado->num_rows > 0) {
                    // usuario existe, obtener preguntas
                    $usuario_fila = $resultado->fetch_array();
                    $resultado = $mysqli->query("SELECT * FROM preguntas_de_seguridad WHERE usuarios_id = " . $usuario_fila['id']);
                    if ($resultado->num_rows > 0) {
                        $preguntas = $resultado;
                    } else {
                        $error[] = "este usuario no tiene preguntas de seguridad";
                    }


                } else {
                    $error[] = "usuario no encontrado. Intente de nuevo";
                }
            }
            break;
        case "validar respuesta":
            $respuestaCorrecta = $_POST['pregunta'];
            $respuestaUsuario = $_POST['respuesta'];
            if ($respuestaCorrecta === $respuestaUsuario) {
                $respuestaCorrecta = true;
                $mensaje = "Respuesta Correcta";

            }
            break;
        case "nueva clave":
            $mensaje = "actualizar contra";
            $query = "UPDATE usuarios  set clave = '".$_POST['clave']."' where id = ". $_POST['user_id'];
            require('conneccion.php');
            $resultado = $mysqli->query($query);
            if($resultado){
                // contrasenia fue actualizada, mandar usuario a login
                $mensaje="Clave actualizada";
                header('Location: login.php');
                exit;
            }else{
                print($query);
                $mensaje = "error actualizadno contra";
            }
            break;
        default:
            $error[] = "Un error ha ocurrido, Por favor Refresque la pagina";
    }


}

?>


<div id="banner">
    <?= isset($mensaje) ? $mensaje : ''; ?>
    <!--        mostrar errores -->
    <div class="derecha" style="width: 100%; color:red">
        <?php
        if (isset($error))
            foreach ($error as $err) {
                echo "<div<strong>$err</strong></div>";
            }

        ?>
    </div>
    <form action="recuperar_usuario.php?Accion=buscar usuario" method="POST">
        <h3> Ingrese usuario o numero de cedula para recuperar cuenta</h3>
        <div class="izquireda" style="width: 50%;">
            <label for="usuario">Usuario:</label>
            <input id="usuario" name="usuario" placeholder="usuario12345"
                   value="<?= isset($usuario) ? $usuario : '' ?>" />
        </div>
        <div class="izquireda" style="width: 50%;">
            <label for="cedula">Cedula:</label>
            <input id="cedula" name="cedula" placeholder="123432" value="<?= isset($cedula) ? $cedula : '' ?>"/>
        </div>
        <div style="width:100%;">
            <button class="btn btn-grande btn-verde derecha" type="submit">Buscar</button>
        </div>


    </form>
    <br/>

    <!--    ingreso un usuario o cedula valida y contiene preguntas de seguridad, mostrar forma para que el usuario responda una pregunta-->
    <?php if (isset($usuario) && isset($preguntas)) { ?>
        <div class="izquireda" style="width: 100%">
            <h3>Eres : <?= isset($usuario_fila) ? $usuario_fila['nombre'] . ',' . $usuario_fila['apellido'] : '' ?></h3>
        </div>
        <form action="recuperar_usuario.php?Accion=validar respuesta" method="POST">
            <input style="display: none;" name="user_id" value="<?= isset($usuario_fila) ? $usuario_fila['id'] : '' ?>"/>
            <div class="izquireda" style="width: 50%;">
                <label for="pregunta">Selecciona una preguta:</label><br/>
                <select id="pregunta" name="pregunta" style="width: 100%" placeholder="Seleccione pregunta">
                    <?php
                    if (isset($preguntas))
                        while ($pregunta = $preguntas->fetch_array()) {
                            echo "<option value=\"{$pregunta['respuesta']}\">{$pregunta['pregunta']}</option>";
                        }

                    ?>
                </select>

            </div>
            <div class="izquireda" style="width: 50%;">
                <?php if (isset($preguntas)) { ?>
                    <label for="respuesta">Respuesta:</label> <br/>
                    <input id="respuesta" name="respuesta" style="width: 100%" placeholder="mi respuesta"/>
                <?php } ?>
            </div>
            <div style="width: 100%">
                <button class="btn btn-grande btn-verde derecha" type="submit">Validar</button>
            </div>
        </form>

    <?php } ?>

    <!--    respondio la respuesta correctamente, mostrar forma para que pueda ingresar nueva contrasena-->
    <?php if (isset($respuestaCorrecta)) { ?>

        <form action="recuperar_usuario.php?Accion=nueva clave" method="POST">
            <input style="display:none" name="user_id" value="<?= isset($_POST['user_id'])?$_POST['user_id']:'' ?>" />

            <div class="izquireda" style="width: 100%;">
                <label for="clave">Contra:</label>
                <input type="password" id="clave" name="clave" style="width:50%" placeholder="ingresa clave"/>
            </div>
            <div class="izquireda" style="width: 100%;">
                <label for="reClave">Repetir Contra:</label>
                <input type="password" id="reClave" name="reClave" style="width:50%" placeholder="repetir clave"/>
            </div>
            <div style="width: 100%">
                <button class="btn btn-grande btn-verde derecha" type="submit">Validar</button>
            </div>
        </form>

    <?php } ?>
</div>