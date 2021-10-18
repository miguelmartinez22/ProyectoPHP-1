<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../config/configuracion.php";

    // Prepare a select statement
    $sql = "SELECT * FROM vacuna WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $nombre = $row["nombre"];
                $fabricante = $row["fabricante"];
                $numdosis = $row["num_dosis"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "¡Vaya! Algo ha ido mal, vuelve a intentarlo más tarde.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
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
    <link rel="stylesheet" href="../css/verVacuna.css">
    <title>Ver Vacuna</title>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">Ver Vacuna</h1>
                <div class="form-group">
                    <label>Nombre</label>
                    <p><b><?php echo $row["nombre"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Fabricante</label>
                    <p><b><?php echo $row["fabricante"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Núm. dosis</label>
                    <p><b><?php echo $row["num_dosis"]; ?></b></p>
                </div>
                <p><a href="listarVacuna.php" class="btn btn-primary">Volver</a></p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../JS/jquery-3.4.1.js"></script>
<script type="text/javascript" src="../JS/popper.min.js"></script>
<script type="text/javascript" src="../JS/bootstrap.js"></script>

</body>
</html>
