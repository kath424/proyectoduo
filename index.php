<?php
$titulo = "Pagina Inicial";
$css = ['estilos/estilopie.css'];
require('encabezado.php');
require('barra_de_navegacion.php');
?>

<?php
require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos


$agrupados = obtererCalificaciones($_SESSION['user_id'], $mysqli);

?>


    <div class="col-sm-12  <?= $agrupados? '' : 'hidden' ?> ">
        <h2 class="h2">Evaluaciones </h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Curso</th>
                <th>Modulo</th>
                <th>Correctas</th>
                <th>Incorrectas</th>
                <th>#Preguntas</th>
                <th>Calificacion</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($agrupados as $modulo => $info) { ?>
                <tr class="<?= ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) ? 'bg-danger' : '' ?> ">
                    <td><?= $info['curso'] ?> </td>
                    <td><?= $modulo ?> </td>
                    <td><?= $info['correctas'] ?></td>
                    <td><?= $info['incorrectas'] ?></td>
                    <td><?= $info['total'] ?></td>
                    <td>
                        <?php
                        if ($info['total'] !== ($info['correctas'] + $info['incorrectas'])) {
                            echo "N/A";
                        } else {
                            echo ($info['correctas'] / ($info['total'])) * 100 . '%';
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
    <div class="col-sm-12 <?= !$agrupados? '' : 'hidden' ?>">
        <h1 class="h1">No has tomado ninguna evaluacion</h1>
    </div>


<?php require('pie.php'); ?>