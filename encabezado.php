<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="keywords" content="pagina, html5, css3, maquetacion">
    <meta name="description" content="esta es una pagina web con estilos css3">
    <title><?= isset($titulo) ? $titulo : '' ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="estilos/estilogeneral.css"/>
    <?php foreach ($css as $estilo) { ?>
        <link rel="stylesheet" href="<?= $estilo ?>"/>
    <?php } ?>

</head>
<body>

<?php
function actualizarUltimoLogeo($idUsuario, $tiempo, $actividad)
{
    $tiempo = date('Y-m-d H:i:s',$tiempo);
    $query = "UPDATE usuarios SET ultimo_logeo = '$tiempo', ultima_actividad = '$tiempo',  ultima_actividad_descripcion = '$actividad' WHERE id = $idUsuario";
    require('conneccion.php');
    $mysqli->query($query);

}

function actualizarUltimaActividad($idUsuario, $tiempo, $actividad){
    $tiempo = date('Y-m-d H:i:s',$tiempo);
    $query = "UPDATE usuarios SET  ultima_actividad = '$tiempo', ultima_actividad_descripcion = '$actividad' WHERE id = $idUsuario ";
    require('conneccion.php');
    $mysqli->query($query,MYSQLI_ASYNC);
}

?>

<?php
// permite accessar $_SESSION para saber si el usuario esta logeado
if (!isset($_SESSION))
    session_start();
    // usuario esta logeado?,  actualizar el tiempo de su  ultima actividad
    if(isset($_SESSION['user_id'])){
        actualizarUltimaActividad($_SESSION['user_id'], time(), $titulo);
    }
?>


<section class="container">

    <header class="masthead">
        <img class="banner" src="img/logo1.jpg" alt="banner"/>
    </header>


