<nav class="navegacion">

    <ul>
        <li>
            <div class="contenedor_general">
                <a href="index.php">
                    <div class="contenedor_uno">
                        <p class="texto_uno">Inicio</p>
                    </div>

                    <div class="contenedor_dos">
                        <p class="texto_dos">Inicio </p>
                    </div>
                </a>
            </div>
        </li>

        <!-- <li>
            <div class="contenedor_general">

                <div class="contenedor_uno">
                    <p class="texto_uno"><a href="informacion.php">Informacion </a></p>
                </div>

                <div class="contenedor_dos">
                    <p class="texto_dos"><a href="informacion.php">Informacion</a></p>
                </div>

            </div>
        </li> -->

        <li>
            <div class="contenedor_general">
                <a href="cursos.php">
                    <div class="contenedor_uno">
                        <p class="texto_uno"> Cursos </p>
                    </div>

                    <div class="contenedor_dos">
                        <p class="texto_dos"> Cursos </p>
                    </div>
                </a>
            </div>
        </li>


        <li>
            <div class="contenedor_general">
                <a href="contactos.php">
                    <div class="contenedor_uno">
                        <p class="texto_uno">Contactos</p>
                    </div>

                    <div class="contenedor_dos">
                        <p class="texto_dos">Contactos</p>
                    </div>
                </a>
            </div>
        </li>


        <li>
            <div class="contenedor_general">

                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="#">
                        <div class="contenedor_uno">
                            <p class="texto_uno"> <?php echo $_SESSION['usuario']; ?> </p>
                        </div>

                        <div class="contenedor_dos">
                            <p class="texto_dos"> <?php echo $_SESSION['usuario']; ?> </p>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="registro.php">
                        <div class="contenedor_uno">
                            <p class="texto_uno"> Registro </p>
                        </div>

                        <div class="contenedor_dos">
                            <p class="texto_dos"> Registro </p>
                        </div>
                    </a>
                <?php } ?>


            </div>
        </li>


        <li>
            <div class="contenedor_general">

                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="logout.php">
                        <div class="contenedor_uno">
                            <p class="texto_uno"> Cerrar Session </p>
                        </div>
                        <div class="contenedor_dos">
                            <p class="texto_dos"> Cerrar Session </p>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="login.php">
                        <div class="contenedor_uno">
                            <p class="texto_uno"> Inicio Sesion </p>
                        </div>
                        <div class="contenedor_dos">
                            <p class="texto_dos"> Inicio Sesion </p>
                        </div>
                    </a>
                <?php } ?>


            </div>
        </li>
    </ul>

</nav>