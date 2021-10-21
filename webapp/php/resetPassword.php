<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "../config/configuracion.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Por favor introduce una nueva contraseña.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña debe tener como minimo 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirma la contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE usuario SET password = ? WHERE id = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/resetPassword.css">
    <title>Resetear Contraseña</title>
</head>
<body>
    <div class="container-fluid">
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
            <h2>Resetear contraseña</h2>
            <p>Por favor completa este formulario para resetear tu contraseña.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
                </div>
            </form>
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
    </div>

    <script type="text/javascript" src="../JS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../JS/popper.min.js"></script>
    <script type="text/javascript" src="../JS/bootstrap.js"></script>
</body>
</html>
