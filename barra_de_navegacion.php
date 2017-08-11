<div id="nav">
    <div class="navbar navbar-inverse">
        <div class="">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Project - DUO</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if (es('admin')) { ?>
                        <li><a href="usuarios.php"><i class="glyphicon glyphicon-menu-hamburger"></i> Usuarios</a></li>
                    <?php }
                    else
                    { ?>
                        <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
                        <li><a href="cursos.php"><i class="glyphicon glyphicon-list"></i> Cursos</a></li>
                        <li><a href="ayuda.php"><i class="glyphicon glyphicon-question-sign"></i> Ayuda</a></li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li><a href="#"><i class="glyphicon glyphicon-user"></i> <?= $_SESSION['usuario'] ?>
                                (<?= $_SESSION['tipo_de_usuario'] ?>)</a></li>
                        <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Cerrar Sesion</a></li>
                    <?php }
                    else
                    { ?>>
                        <li><a href="registro.php"><i class="glyphicon glyphicon-log-in"></i> Registro</a></li>
                        <li><a href="login.php"><i class="glyphicon glyphicon-log-in"></i> Iniciar Sesion</a></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div><!-- /.navbar -->
</div>