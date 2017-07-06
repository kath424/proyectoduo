<?php 

session_start(); // Accessar session (si hay alguna)

// no hay sesion
if (!isset($_SESSION['user_id'])) {
 	// mandar usuario a login
	header("Location: login.php"); 
	exit;

} else { // Cancel the session:
	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.

}

$mensaje= "Session cerrada. Vuelva a iniciar sesssion";
header("Location: login.php"); 
// hacer que el titulo de pagin diga session cerrada:
//$page_title = 'session cerrada';
//include ('includes/header.html');

// mensaje
//echo "<h1>Logged Out!</h1>
//<p>You are now logged out!</p>";

//include ('includes/footer.html');
?>