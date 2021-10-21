<?php
// Procesamiento de datos cuando se envía el formulario
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Incluir archivo de configuración
    require_once "../config/configuracion.php";

    // Preparar la sentencia
    $sql = "DELETE FROM vacuna WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Vincular las variables a la sentencia
        $stmt->bind_param("i", $param_id);

        // Definir parámetros
        $param_id = trim($_POST["id"]);

        // Ejecutar la sentencia
        if($stmt->execute()){
            // Si la sentencia se ejecuta con exito, redirigir a la página deseada
            header("location: listarVacuna.php");
            exit();
        } else{
            echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
        }
    }

    // Cerrar sentencia
    $stmt->close();

    // Cerrar conexión
    $mysqli->close();
} else{
    // Comporobar la existencia del parámetro id
    if(empty(trim($_GET["id"]))){
        // Si no existe el id redirigir a error.php
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Vacuna</title>
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/borrarVacuna.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
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
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5 mb-3">Borrar vacuna</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                            <div class="alert alert-danger">
                                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                                <p>Estas seguro/a de que que quieres borrar esta vacuna?</p>
                                <p>
                                    <input type="submit" value="Yes" class="btn btn-danger">
                                    <a href="listarVacuna.php" class="btn btn-secondary ml-2">No</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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