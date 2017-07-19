<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ANSI">
    <meta name="keywords" content="pagina, html5, css3, maquetacion">
    <meta name="description" content="esta es una pagina web con estilos css3">
    <title><?= isset($titulo) ? $titulo : '' ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <?php foreach ($css as $estilo) { ?>
        <link rel="stylesheet" href="<?= $estilo ?>"/>
    <?php } ?>

</head>
<body>
<?php
// permite accessar $_SESSION para saber si el usuario esta logeado
if (!isset($_SESSION))
    session_start();
?>

<style >
    /* bootstrap 3 helpers */
    .navbar-form input, .form-inline input {
        width:auto;
    }

    header {
        height:250px;
        background-image: url("img/logo1.jpg");
        margin-bottom: 0;
        min-height: 50%;
        background-repeat: no-repeat;
        background-position: center;
        -webkit-background-size: cover;
        background-size: cover;
    }

    #nav.affix {
        position: fixed;
        top: 0;
        width: 100%;
        z-index:10;
    }
    .jumbotron {

        background-color: transparent;
        margin-bottom: 0;
        min-height: 50%;
        background-repeat: no-repeat;
        background-position: center;
        -webkit-background-size: cover;
        background-size: cover;
    }
    .jumbotron > h1{
        color:transparent;
    }

</style>


<!--<header>-->
<!--    <h1>-->
<!--        <a href="index.php"><img src="img/logo1.jpg" width="780" height="200" alt="logo1.jpg">-->
<!--        </a>-->
<!--    </h1>-->
<!--</header>-->

<section class="container">

    <header class="masthead">

    </header>


