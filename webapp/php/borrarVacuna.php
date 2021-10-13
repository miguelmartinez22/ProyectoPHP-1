<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../config/configuracion.php";

    // Prepare a delete statement
    $sql = "DELETE FROM vacuna WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: listado.php");
            exit();
        } else{
            echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <section>
                <h2 class="mt-5 mb-3">Borrar vacuna</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
                    <div class="alert alert-danger">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>¿Estás seguro/a de que que quieres borrar esta vacuna?</p>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="listarVacuna.php" class="btn btn-secondary ml-2">No</a>
                        </p>
                    </div>
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
</body>
</html>