<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    $tiempo = date('Y-m-d H:i:s', $tiempo);
    $query = "UPDATE usuarios SET ultimo_logeo = '$tiempo', ultima_actividad = '$tiempo',  ultima_actividad_descripcion = '$actividad' WHERE id = $idUsuario";
    require('conneccion.php');
    $mysqli->query($query);

}

function actualizarUltimaActividad($idUsuario, $tiempo, $actividad)
{
    $tiempo = date('Y-m-d H:i:s', $tiempo);
    $query = "UPDATE usuarios SET  ultima_actividad = '$tiempo', ultima_actividad_descripcion = '$actividad' WHERE id = $idUsuario ";
    require('conneccion.php');
    $mysqli->query($query, MYSQLI_ASYNC);
}

function obtererCalificaciones($userId, $mysqli)
{
    // connectarse a la base de datos

    $agrupados = [];

    $query_respondidas = <<<EOT
select
  u.id as usuario_id
  ,u.nombre
  ,u.apellido
  ,u.cedula
  ,c.id as curso_id
  ,cur.nombre as curso
  ,c.nombre as modulo
  ,c.numero
  ,case when p.respuesta = er.respuesta then 'correcto' else 'incorrecto' end as correcto
  ,count(*) as conteo
  ,(select count(*) from preguntas preg where preg.capitulos_id = c.id ) as total
from estudiante_respuestas er
  left join preguntas p
    on p.id = er.preguntas_id
  left join capitulos c
    on p.capitulos_id = c.id
  left join cursos cur
    on c.cursos_id = cur.id
  left join usuarios u
    on u.id = er.usuarios_id
where er.usuarios_id =  $userId
group by er.usuarios_id, c.id, correcto
EOT;

    $resultado = $mysqli->query($query_respondidas);
    if ($resultado) {

        while ($pregunta = $resultado->fetch_array(MYSQLI_ASSOC)) {
            if (!isset($agrupados[$pregunta['modulo']])) {
                $agrupados[$pregunta['modulo']] = [
                    'curso' => $pregunta['curso'],
                    'numero' => $pregunta['numero'],
                    'correctas' => 0,
                    'incorrectas' => 0,
                    'total' => intval($pregunta['total'])
                ];
            }
            if ($pregunta['correcto'] == 'correcto') {
                $agrupados[$pregunta['modulo']]['correctas'] = intval($pregunta['conteo']);
            } else {
                $agrupados[$pregunta['modulo']]['incorrectas'] = intval($pregunta['conteo']);
            }
        }
        return $agrupados;

    } else {
        return false;
    }
// agrupar por capitulo (1 set de preguntas por capitulo)

}


?>

<?php
// permite accessar $_SESSION para saber si el usuario esta logeado
if (!isset($_SESSION))
    session_start();
// usuario esta logeado?,  actualizar el tiempo de su  ultima actividad
if (isset($_SESSION['user_id'])) {
    actualizarUltimaActividad($_SESSION['user_id'], time(), $titulo);
}
?>


<section class="container">

    <header class="masthead">
        <img class="banner" src="img/logo1.jpg" alt="banner"/>
    </header>


