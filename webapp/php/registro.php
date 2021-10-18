<?php
// Include config file
require_once "../config/configuracion.php";

// Definición de variables inicialización con valores vacíos
$dni = $nombre = $apellido = $email = $password = $confirm_password = $hospital = "";
$dni_err = $nombre_err = $apellido_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validar dni
    if(empty(trim($_POST["dni"]))){
        $dni_err = "Introduce tu dni.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dni FROM usuario WHERE dni = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_dni);

            // Set parameters
            $param_dni = trim($_POST["dni"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $dni_err = "Este dni ya está registrado.";
                } else{
                    $dni = trim($_POST["dni"]);
                }
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validar nombre
    if(empty(trim($_POST["nombre"]))){
        $nombre_err = "Introduce un nombre.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dni FROM usuario WHERE nombre = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_nombre);

            // Set parameters
            $param_nombre = trim($_POST["nombre"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                $nombre = trim($_POST["nombre"]);
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }


    // Validar apellido
    if(empty(trim($_POST["apellido"]))){
        $apellido_err = "Introduce tu primer apellido.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dni FROM usuario WHERE apellidos = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_apellido);

            // Set parameters
            $apellido_email = trim($_POST["apellido"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                $apellido = trim($_POST["apellido"]);
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }


    // Validar email
    if(empty(trim($_POST["email"]))){
        $email_err = "Introduce una dirección de correo electrónico.";
    } elseif(!preg_match('/^\S+@\S+\.\S+$/', trim($_POST["email"]))){
        $email_err = "El email sólo puede contener letras, números y ciertos carácteres especiales.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dni FROM usuario WHERE email = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $email_err = "Este email ya está registrado";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validar contraseña
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validar confirmación de contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Validar hospital
    if(empty(trim($_POST["hospital"]))){
        $hospital_err = "Introduce un hospital de los mostrados abajo.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dni FROM usuario WHERE hospital = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_hospital);

            // Set parameters
            $param_hospital = trim($_POST["hospital"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                $hospital = trim($_POST["hospital"]);
                if(($hospital != "Isabel Zendal") && ($hospital != "Hospital del Sureste") && ($hospital != "Gregorio Marañón") && ($hospital != "Wanda Metropolitano") && ($hospital != "Wizink Center")){
                    $hospital_err = "Ese hospital no está en la lista";
                }
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }

    //Crear vacunas
    $vacuna1 = date('d-m-Y', strtotime('+1 week'));
    $vacuna2 = date('d-m-Y', strtotime('+5 week'));

    // Check input errors before inserting in database
    if(empty($dni_err) && empty($nombre_err) && empty($apellido_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($hospital_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO usuario (dni, nombre, apellidos, email, password, hospital, vacuna1, vacuna2) VALUES (?, ?, ?, ?, ?, ?,  STR_TO_DATE(?, '%d,%m,%Y'), STR_TO_DATE(?, '%d,%m,%Y'))";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssss", $param_dni, $param_nombre, $param_apellido, $param_email, $param_password, $param_hospital, $param_vacuna1, $param_vacuna2);

            // Set parameters
            $param_dni = $dni;
            $param_nombre = $nombre;
            $param_apellido = $apellido;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash
            $param_hospital = $hospital;
            $param_vacuna1 = $vacuna1;
            $param_vacuna2 = $vacuna2;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
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
    <title>Registro</title>
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/registro.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
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
        <section class="col-8 col-lg-8 col-md-8 col-sm-8">
            <h2>REGISTRARSE</h2>
            <p>Rellena el siguiente formulario para crear una cuenta.</p>
            <?php
            if(isset($_POST["email"])){
                echo "<p>Hola, " . $_POST["email"];
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                <div class="form-group">
                    <label>DNI</label>
                    <input type="text" name="dni" class="form-control <?php echo (!empty($dni_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dni; ?>">
                    <span class="invalid-feedback"><?php echo $dni_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                    <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellido" class="form-control <?php echo (!empty($apellido_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $apellido; ?>">
                    <span class="invalid-feedback"><?php echo $apellido_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Hospital</label>
                    <input type="text" name="hospital" class="form-control <?php echo (!empty($hospital_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $hospital; ?>">
                    <span class="invalid-feedback"><?php echo $hospital_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                </div>
                <p>¿Ya estás registrado? <a href="login.php">Inicia sesión aquí</a>.</p>
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
</div>

<script type="text/javascript" src="../JS/jquery-3.4.1.js"></script>
<script type="text/javascript" src="../JS/popper.min.js"></script>
<script type="text/javascript" src="../JS/bootstrap.js"></script>

</body>
</html>
