<?php
$mysqli = new mysqli('localhost', 'root','', 'projecto_duo_db');

if($mysqli->connect_errno){
	echo "fallo al conectarse a MySQL: " . mysqli_connect_error();
}

