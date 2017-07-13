<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ANSI">
    <meta name="keywords" content="pagina, html5, css3, maquetacion">
    <meta name="description" content="esta es una pagina web con estilos css3">
    <title><?php echo isset($titulo) ? $titulo : '' ?></title>
    <?php foreach ($css as $styleSheet) { ?>
        <link rel="stylesheet" href="<?php echo $styleSheet; ?>"/>
    <?php } ?>
</head>
<body>
<?php
// permite accessar $_SESSION para saber si el usuario esta logeado
if (!isset($_SESSION))
    session_start();
?>


<section id="contenedor">
    <header>
        <h1>
            <a href="index.php"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg">
            </a>
        </h1>
    </header>
