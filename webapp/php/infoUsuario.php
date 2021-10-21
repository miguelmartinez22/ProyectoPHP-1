<?php
require_once "../config/configuracion.php";

// inicilizar la sesion
session_start();

// Verifica que el usuario ha iniciado sesión. En caso contrario lo redirige a esa página
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

$idEstudio = $_SESSION["id"];

$sql = "SELECT dni, nombre, apellidos, email, hospital, vacuna1, vacuna2 FROM usuario WHERE id = ?";

if($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $idEstudio);

    if($stmt->execute()) {
        // Store result
        $result = $stmt->get_result();

        // Check if username exists, if yes then verify password
        if ($result->num_rows == 1) {
            // Bind result variables
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $dni = $row["dni"];
            $nombre = $row["nombre"];
            $apellidos = $row["apellidos"];
            $hospital = $row["hospital"];
            $vacuna1 = $row["vacuna1"];
            $vacuna2 = $row["vacuna2"];
        }
    } else{
        echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
    }

    // Close statement
    $stmt->close();
}
// Close connection
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/infoUsuario.css">
    <title>Proyecto sitio web con PHP. Javier Martinez y Miguel Martinez</title>
</head>
<body>
    <header>
        <div class="row" id="row1">
            <div class="col-lg-3 col-md-4 col-sm-3 col-12" id="logo">
                <article>
                    <img class="col-lg-7 col-md-9" id="imagenCM" src="../images/Logotipo_del_Gobierno_de_la_Comunidad_de_Madrid.png" alt="Comunidad de Madrid">
                </article>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-9 col-12" id="titulo">
                <h1 class="">VACUNACIÓN COVID-19 2021-22</h1>
            </div>
        </div>
    </header>
    <main>
        <h1 class="my-5" style="text-align: center">Hola, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Estos son tus datos de vacunación.</h1>
        <!-- <p>Has ingresado <b><?php echo $_COOKIE[$_SESSION["email"]]; ?></b> veces</p> -->
        <section class="col-12 col-lg-10 col-md-10 col-sm-10" style="margin: auto">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Hospital de vacunación</th>
                    <th>Fecha 1ª vacuna</th>
                    <th>Fecha 2ª vacuna</th>
                </tr>
                <tr>
                    <td><?php echo $row["dni"]; ?></td>
                    <td><?php echo $row["nombre"]; ?></td>
                    <td><?php echo $row["apellidos"]; ?></td>
                    <td><?php echo $row["hospital"]; ?></td>
                    <td><?php echo $row["vacuna1"]; ?></td>
                    <td><?php echo $row["vacuna2"]; ?></td>
                </tr>
            </table>
        </section>

        <section class="col-12 col-lg-10 col-md-10 col-sm-10 mr-5" id="botonera" style="margin: auto; text-align: center">
            <a href="resetPassword.php" class="btn btn-warning" >Restablece tu contraseña</a>
            <a href="logout.php" class="btn btn-danger ml-3">Salir</a>
        </section>
    </main>
    <footer class="text-center text-lg-start mt-2">
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row">
                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h2 class="text-uppercase">Contacto</h2>

                    <p><h3><i class="fas fa-envelope-open-text"></i>  vacunacion.covid@madrid.org</h3></p>
                    <p><h3><i class="fas fa-phone"></i>  600 01 00 23</h3></p>
                </div>

                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h2 class="text-uppercase">Lista de hospitales</h2>

                    <p><h3><i class="fas fa-hospital"></i>  Isabel Zendal</h3></p>
                    <p><h3><i class="fas fa-hospital"></i>  Hospital del Sureste</h3></p>
                    <p><h3><i class="fas fa-hospital"></i>  Gregorio Marañón</h3></p>
                    <p><h3><i class="fas fa-syringe"></i>  Wanda Metropolitano</h3></p>
                    <p><h3><i class="fas fa-microphone-alt"></i>  Wizink Center</h3></p>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.4);">
            © 2021 Copyright:
            <a class="text-dark" href="https://mdbootstrap.com/">Comunidad de Madrid</a>
        </div>
        <!-- Copyright -->
    </footer>

    <script type="text/javascript" src="../JS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../JS/popper.min.js"></script>
    <script type="text/javascript" src="../JS/bootstrap.js"></script>
</body>
</html>
