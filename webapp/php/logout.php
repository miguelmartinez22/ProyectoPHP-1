<?php
// inicializar la sesion
session_start();

// Unset all of the session variables
session_unset();

// Destruir las sesiones activas
session_destroy();

// Redirige a la página de login
header("location: login.php");
exit;
?>
