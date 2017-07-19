<?php

session_start(); // Accessar session (si hay alguna)

// checar si el usuario esta logeado
if (isset($_SESSION['user_id'])) {// hay session, eliminarla
    $_SESSION = []; // limpiar variables.
    session_destroy(); // borrar la session.
}
// siempre mandar usuario a login
$mensaje = "Session cerrada. Vuelva a iniciar sesssion";
header("Location: login.php");
