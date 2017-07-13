<?php

// antes de cargar el contenido
// si ya esta logeado,  redirijir usuario a la pagina incial
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$titulo = "Recuperacion de Usuario";
$css = ["estilos/estilore.css"];
require('encabezado.php');

?>

<?php

// get security questions

?>
