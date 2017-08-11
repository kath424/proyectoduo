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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="estilos/estilogeneral.css"/>
    <?php foreach ($css as $estilo) { ?>
        <link rel="stylesheet" href="<?= $estilo ?>"/>
    <?php } ?>

</head>
<body>

<?php

function actualizarUltimoLogeo($idUsuario, DateTime $tiempo, $actividad, mysqli $mysqli)
{
    $tiempo_str = $tiempo->format('Y-m-d H:i:s');
    $query = "UPDATE usuarios SET ultimo_logeo = '$tiempo_str' WHERE id = $idUsuario";
    $mysqli->query($query);
    actualizarUltimaActividad($idUsuario, $tiempo, $actividad, $mysqli);

}

function actualizarUltimaActividad($idUsuario, DateTime $tiempo, $actividad, mysqli $mysqli)
{

    $query = "INSERT INTO actividades (detalles, usuarios_id) VALUES "
        . "('$actividad',$idUsuario)";
    $mysqli->query($query);

    $query = "SELECT id from actividades where usuarios_id = $idUsuario ORDER BY tiempo DESC LIMIT 10";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        $ids = [];
        while ($id = $result->fetch_array())
            $ids[] = $id['id'];
        $ids = implode(',', $ids);
        $query = "DELETE FROM actividades WHERE usuarios_id = $idUsuario AND id NOT IN ($ids)";
        $mysqli->query($query);
    }
}

function obtererCalificaciones($userId, mysqli $mysqli)
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

function issetor(&$variable, $defecto = false){
    return isset($variable)?$variable:$defecto;
}

function redirigirSiNoEstaLogeado($locacion = 'login.php'){
    // verificar que el usuario esta logeado
    if(!isset($_SESSION['user_id'])){
        header("Location: $locacion");
        exit;
    }
}

function es($tipoDeUsuario){
    return isset($_SESSION['tipo_de_usuario'] ) && $_SESSION['tipo_de_usuario'] === $tipoDeUsuario;
}

function guardarEstudiante(mysqli $mysqli, $nombre, $apellido, $cedula, $usuario, $clave,  $titulo)
{
    $query = "INSERT into usuarios(nombre, apellido, cedula, usuario, clave, tipo_de_usuario) VALUES "
          ."('$nombre','$apellido', '$cedula', '$usuario',  '$clave', 'estudiante')";
    $resultado = $mysqli->query($query);

    if ($resultado) {// fue exitoso
        // login
        $query = "SELECT * FROM   usuarios  WHERE usuario =  '$usuario'";
        $resultado = $mysqli->query($query);
        $usuario = $resultado->fetch_object();

        if (!isset($_SESSION))
            session_start();
        // logear usario para que llene las preguntas de recuperacion
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['nombre'] = $usuario->nombre;
        $_SESSION['apellido'] = $usuario->apellido;
        $_SESSION['usuario'] = $usuario->usuario;
        $_SESSION['tipo_de_usuario'] = $usuario->tipo_de_usuario;
        $_SESSION['tiempo_de_entrada'] = new DateTime();

         actualizarUltimoLogeo($usuario->id, $_SESSION['tiempo_de_entrada'], $titulo, $mysqli);

        // agregar todos los cursos de la tabla de cursos
        // preparar valores a insertar (id de curso, id de estudiante)
        $query = "SELECT id FROM cursos";
        $cursos = $mysqli->query($query);
        $cursos_stu = [];
        while ($curso = $cursos->fetch_array())
            $cursos_stu[] = "( {$curso['id']} , $usuario->id )";

        $cursos_stu = implode(',', $cursos_stu);
        // agregar cursos
        $query = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES " . $cursos_stu;
        $mysqli->query($query);

    } else {
        return "Error al agregar usuario";
    }
}

function guardarProfesor(mysqli $mysqli, $nombre, $apellido,  $usuario, $clave){
    $query = "INSERT into usuarios(nombre, apellido, usuario, clave, tipo_de_usuario) VALUES "
        ."('$nombre','$apellido', '$usuario',  '$clave', 'profesor')";
    $mysqli->query($query);
    $usuarioId = $mysqli->insert_id;
    // agregar todos los cursos de la tabla de cursos
    // preparar valores a insertar (id de curso, id de estudiante)
    $query = "SELECT id FROM cursos";
    $cursos = $mysqli->query($query);
    $cursos_stu = [];
    while ($curso = $cursos->fetch_array())
        $cursos_stu[] = "( {$curso['id']} , '$usuarioId' )";

    $cursos_stu = implode(',', $cursos_stu);
    // agregar cursos
    $query = "INSERT INTO cursos_usuarios (cursos_id, usuarios_id) VALUES " . $cursos_stu;
    $mysqli->query($query);
}

function guardarUsuario(){};

?>

<?php
// permite accessar $_SESSION para saber si el usuario esta logeado
if (!isset($_SESSION))
    session_start();
// usuario esta logeado?,  actualizar el tiempo de su  ultima actividad
if (isset($_SESSION['user_id'])) {
    require('conneccion.php');
    actualizarUltimaActividad($_SESSION['user_id'], new DateTime(), $titulo, $mysqli);
}
?>


<section class="container clearfix">

    <header class="masthead <?= isset($ocultarBanner)?'hidden':'' ?>">
       <a href="index.php"> <img class="banner" src="img/logo1.jpg" alt="banner"/></a>
    </header>


