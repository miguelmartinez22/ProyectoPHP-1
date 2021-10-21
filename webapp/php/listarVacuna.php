<?php
require_once "../config/configuracion.php";

// inicilizar la sesion
session_start();

// Verifica que el usuario ha iniciado sesión. En caso contrario lo redirige a esa página
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true || $_SESSION["email"] !== "gestor@gmail.com"){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/f33f57c2f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/listarVacuna.css">
    <style>
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
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
        <section class="col-12 col-lg-10 col-md-10 col-sm-10">
            <div class="mt-5 mb-3 clearfix">
                <h2 class="pull-left">Detalles de vacuna</h2>
                <a href="crearVacuna.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Añade una nueva vacuna</a>
            </div>
            <?php
            // Fichero de configuración
            require_once "../config/configuracion.php";

            // Attempt select query execution
            $sql = "SELECT * FROM vacuna";
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Nombre</th>";
                    echo "<th>Nombre completo</th>";
                    echo "<th>Fabricante</th>";
                    echo "<th>Número de dosis</th>";
                    echo "<th>Días mínimos</th>";
                    echo "<th>Días máximos</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_array()){
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['nombre_largo'] . "</td>";
                        echo "<td>" . $row['fabricante'] . "</td>";
                        echo "<td>" . $row['num_dosis'] . "</td>";
                        echo "<td>" . $row['dias_minimos'] . "</td>";
                        echo "<td>" . $row['dias_maximos'] . "</td>";
                        echo "<td>";
                        echo '<a href="verVacuna.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo '<a href="actualizarVacuna.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                        echo '<a href="borrarVacuna.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    $result->free();
                } else{
                    echo '<div class="alert alert-danger"><em>No se han encontrado vacunas creadas.</em></div>';
                }
            } else{
                echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
            }

            // Close connection
            $mysqli->close();
            ?>
</div>
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
