<?php
// Inicializar la sesion
session_start();

// Comprueba si el usuario está logeado, si lo está, le redirige a infoUsuario.php
if(isset($_SESSION["login"]) && $_SESSION["login"] === true){
    header("location: infoUsuario.php");
    exit;
}


// Include config file
require_once "../config/configuracion.php";

// Definición de variables inicialización con valores vacíos
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Comprueba si el email está vacio
    if(empty(trim($_POST["email"]))){
        $email_err = "Introduce un email válido.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Comprueba si el campo de contraseña está vacio
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduce tu contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validar credenciales
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM usuario WHERE email = ?";


        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $result = $stmt->get_result();

                // Check if username exists, if yes then verify password
                if($result->num_rows == 1){
                    // Bind result variables
                    $fila = $result->fetch_assoc();
                    if(password_verify($password, $fila["password"])){
                        // Password is correct, so start a new session

                        if(!isset($_SESSION))
                        {
                            session_start();
                        }

                        // Guardamos los datos de las sesiones en variables
                        $_SESSION["login"] = true;
                        $_SESSION["id"] = $fila["id"];
                        $_SESSION["email"] = $fila["email"];

                        if (isset($_COOKIE[$fila["id"]])) {
                            $cont = $_COOKIE[$fila["id"]];
                            setcookie($fila["id"], $cont + 1, time() + 3600);
                        } else {
                            setcookie($fila["id"], 1, time() + 3600);

                        }

                        if ($_SESSION["email"] == "gestor@gmail.com"){
                            header("location: listarVacuna.php");
                        } else {
                            header("location: infoUsuario.php");
                        }

                    } else{
                        // Password is not valid, display a generic error message
                        $login_err = "Email o contraseña incorrectos.";
                    }

                }
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v4.1.1">
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/registro.css">

    <!--Script de AJAX-->
    <script>
        $(document).ready(function(){
            $('.search-box input[type="text"]').on("keyup input", function(){
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if(inputVal.length){
                    $.get("buscarAjax.php", {term: inputVal}).done(function(data){
                        // Display the returned data in browser
                        resultDropdown.html(data);
                    });
                } else{
                    resultDropdown.empty();
                }
            });

            // Set search input value on click of result item
            $(document).on("click", ".result p", function(){
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
            });
        });
    </script>
    <title>Iniciar Sesión</title>
</head>
<body class="text-center">
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
    <section class="col-12 col-lg-6 col-md-6 col-sm-6">
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
            <h1 class="h3 mb-3 mt-3 font-weight-normal" id="titulo">INICIAR SESIÓN</h1>
            <?php
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
            ?>
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Contraseña</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Recuérdame
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>
            <p class="mt-3 mb-3 text-muted"></p>
            <br>
            <p>Si aún no estas registrado <a href="registro.php">hazlo desde aquí</a>.</p>
        </form>
    </section>
</main>
<footer class="text-center text-lg-start">
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
