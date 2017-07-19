<!-- Begin Navbar -->
<div id="nav">
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a href="#" class="navbar-brand">Projecto DUO</a>
            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="cursos.php">Cursos</a></li>
                    <li><a href="contactos.php">Contactos</a></li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li><a href="#"><?= $_SESSION['usuario'] ?></a></li>
                        <li><a href="logout.php">Cerrar Sesion</a></li>
                    <?php } else { ?>
                        <li><a href="registro.php">Registro</a></li>
                        <li><a href="login.php">Iniciar Sesion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!-- /.navbar -->
</div>
