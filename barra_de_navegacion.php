<!-- Begin Navbar -->
<div id="nav">
    <div class="navbar navbar-inverse">
        <div class="">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Projecto DUO</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="cursos.php">Cursos</a></li>
                    <li><a href="ayuda.php">Ayuda</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li><a href="#"><?= $_SESSION['usuario'] ?> (<?= $_SESSION['tipo_de_usuario'] ?>)</a></li>
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