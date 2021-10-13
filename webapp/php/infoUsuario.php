<?php
require_once "../config/configuracion.php";

session_name("email");
// Starting session
session_start();

if(isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
    echo "¡Bienvenido <b> " . $_POST['email'] . "!</b>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<h1 class="my-5">Hi, Welcome to our site.</h1>
<p>
    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>
</body>
</html>
