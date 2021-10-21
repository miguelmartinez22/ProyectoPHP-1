<?php
// Incluir archivo de configuración
require_once "../config/configuracion.php";

// Definir las variables e inicializarlas con valores vacíos
$nombre = $nombreLargo = $fabricante = $numDosis = "";
$tiempoMinimo = $tiempoMaximo = "";
$nombre_error = $nombreLargo_error = $fabricante_error = $numDosis_error = "";
$tiempoMinimo_error = $tiempoMaximo_error = "";

// Procesamiento de datos cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validar nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_error = "Introduce un nombre.";
    } elseif(!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nombre_error = "Please enter a valid name.";
    } else{
        $nombre = $input_nombre;
    }

    // Validar nombreLargo
    $input_nombreLargo = trim($_POST["nombreLargo"]);
    if(empty($input_nombreLargo)){
        $nombreLargo_error = "Introduce el nombre científico.";
    } else{
        $nombreLargo = $input_nombreLargo;
    }

    // Validar fabricante
    $input_fabricante = trim($_POST["fabricante"]);
    if(empty($input_fabricante)){
        $fabricante_error = "Introduce el fabricante.";
    } else{
        $fabricante = $input_fabricante;
    }

    // Validar numDosis
    $input_numDosis = trim($_POST["numDosis"]);
    if(empty($input_numDosis)){
        $numDosis_error = "Introduce el número de dosis necesarias.";
    } elseif(!ctype_digit($input_numDosis)){
        $numDosis_error = "Please enter a positive integer value.";
    } else{
        $numDosis = $input_numDosis;
    }

    // Validar tiempo minimo
    $input_tiempoMinimo = trim($_POST["tiempoMinimo"]);
    if(empty($input_tiempoMinimo)){
        $tiempoMinimo_error = "Introduce el tiempo mínimo de espera para la segunda dosis.";
    } elseif(!ctype_digit($input_tiempoMinimo)){
        $tiempoMinimo_error = "Please enter a positive integer value.";
    } else{
        $tiempoMinimo = $input_tiempoMinimo;
    }

    // Validar tiempo maximo
    $input_tiempoMaximo = trim($_POST["tiempoMaximo"]);
    if(empty($input_tiempoMaximo)){
        $tiempoMaximo_error = "Please enter the salary amount.";
    } elseif(!ctype_digit($input_tiempoMaximo)){
        $tiempoMaximo_error = "Please enter a positive integer value.";
    } else{
        $tiempoMaximo = $input_tiempoMaximo;
    }

    // Comprueba si hay errores antes de insertar los datos en la BBDD
    if(empty($nombre_error) && empty($nombreLargo_error) && empty($fabricante_error) && empty($numDosis_error) && empty($tiempoMinimo_error) && empty($tiempoMaximo_error)){
        // Prepare an insert statement
        $sql = "INSERT INTO vacuna (nombre, nombre_largo, fabricante, num_dosis, dias_minimos, dias_maximos) VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Vincular las variables a la sentencia
            mysqli_stmt_bind_param($stmt, "sssiii", $param_nombre, $param_nombreLargo, $param_fabricante, $param_numDosis, $param_tiempoMinimo, $param_tiempoMaximo);

            // Definir los parámetros
            $param_nombre = $nombre;
            $param_nombreLargo = $nombreLargo;
            $param_fabricante = $fabricante;
            $param_numDosis = $numDosis;
            $param_tiempoMinimo = $tiempoMinimo;
            $param_tiempoMaximo = $tiempoMaximo;

            // Ejecutar la sentencia
            if(mysqli_stmt_execute($stmt)){
                // Si la sentencia se ejecuta con exito, redirigir a la página deseada
                header("location: listarVacuna.php");
                exit();
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }
        }

        // Cerrar sentencia
        $stmt->close();
    }

    // Cerrar conexión
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Vacuna</title>
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/crearVacuna.css">
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
        <section class="col-12 col-lg-8 col-md-8 col-sm-8">
            <h2 class="mt-3" style="text-align: center">CREAR VACUNA</h2>
            <p style="text-align: center">Rellena todos los datos de la vacuna</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>" placeholder="Nombre vacuna">
                    <span class="invalid-feedback"><?php echo $nombre_error;?></span>
                </div>
                <div class="form-group">
                    <label>Nombre largo</label>
                    <input type="text" name="nombreLargo" class="form-control <?php echo (!empty($nombreLargo_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombreLargo; ?>">
                    <span class="invalid-feedback"><?php echo $nombreLargo_error;?></span>
                </div>
                <div class="form-group">
                    <label>Fabricante</label>
                    <textarea name="fabricante" class="form-control <?php echo (!empty($fabricante_error)) ? 'is-invalid' : ''; ?>"><?php echo $fabricante; ?></textarea>
                    <span class="invalid-feedback"><?php echo $fabricante_error;?></span>
                </div>
                <div class="form-group">
                    <label>Numero Dosis</label>
                    <input type="text" name="numDosis" class="form-control <?php echo (!empty($numDosis_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $numDosis; ?>">
                    <span class="invalid-feedback"><?php echo $numDosis_error;?></span>
                </div>
                <div class="form-group">
                    <label>Tiempo mínimo</label>
                    <input type="text" name="tiempoMinimo" class="form-control <?php echo (!empty($tiempoMinimo_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $tiempoMinimo; ?>">
                    <span class="invalid-feedback"><?php echo $tiempoMinimo_error;?></span>
                </div>
                <div class="form-group">
                    <label>Tiempo Máximo</label>
                    <input type="text" name="tiempoMaximo" class="form-control <?php echo (!empty($tiempoMaximo_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $tiempoMaximo; ?>">
                    <span class="invalid-feedback"><?php echo $tiempoMaximo_error;?></span>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="listarVacuna.php" class="btn btn-secondary ml-2">Cancelar</a>
            </form>
        </section>
    </main>
    <footer class="text-center text-lg-start">
        <!-- Contenedor -->
        <div class="container p-4">
            <!--Fila-->
            <div class="row">
                <!--Columna-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h2 class="text-uppercase">Contacto</h2>

                    <p><h3><i class="fas fa-envelope-open-text"></i>  vacunacion.covid@madrid.org</h3></p>
                    <p><h3><i class="fas fa-phone"></i>  600 01 00 23</h3></p>
                </div>

                <!--Columna-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h2 class="text-uppercase">Lista de hospitales</h2>

                    <p><h3><i class="fas fa-hospital"></i>  Isabel Zendal</h3></p>
                    <p><h3><i class="fas fa-hospital"></i>  Hospital del Sureste</h3></p>
                    <p><h3><i class="fas fa-hospital"></i>  Gregorio Marañón</h3></p>
                    <p><h3><i class="fas fa-syringe"></i>  Wanda Metropolitano</h3></p>
                    <p><h3><i class="fas fa-microphone-alt"></i>  Wizink Center</h3></p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.4);">
            © 2021 Copyright:
            <a class="text-dark" href="https://www.comunidad.madrid/">Comunidad de Madrid</a>
        </div>
    </footer>
</div>

<script type="text/javascript" src="../JS/jquery-3.4.1.js"></script>
<script type="text/javascript" src="../JS/popper.min.js"></script>
<script type="text/javascript" src="../JS/bootstrap.js"></script>
</body>
</html>