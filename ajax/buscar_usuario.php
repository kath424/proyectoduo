<?php

$query = "SELECT * from usuarios where "
    . "{$_GET['campo']} LIKE '%{$_GET['valor']}%'";

require ('../conneccion.php');
$resultado = $mysqli->query($query);

if($resultado->num_rows > 0){
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
    $resultado = json_encode($resultado);
    echo $resultado;
}else{
    echo "[]";
}