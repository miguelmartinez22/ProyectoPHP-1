<?php
// Incluir archivo de configuración
require_once "../config/configuracion.php";

// Definir las variables e inicializarlas con valores vacíos
$nombre = $nombrelargo = $fabricante = $numdosis = "";
$diasminimos =  $diasmaximos = "";
$nombre_err = $nombrelargo_err = $fabricante_err = $numdosis_err ="";
$diasminimos_err =  $diasmaximos_err = "";

// Procesamiento de datos cuando se envía el formulario
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Obtener el valor del formulario
    $id = $_POST["id"];

    // Validar nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Introduce un nombre.";
    } elseif(!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nombre_err = "Introduce un nombre válido.";
    } else{
        $nombre = $input_nombre;
    }

    // Validar nombre_largo
    $input_nombrelargo = trim($_POST["nombrelargo"]);
    if(empty($input_nombrelargo)){
        $nombrelargo_err = "Introduce un nombre.";
    } elseif(!filter_var($input_nombrelargo, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nombrelargo_err = "Introduce un nombre válido.";
    } else{
        $nombrelargo = $input_nombrelargo;
    }

    // Validar fabricante
    $input_fabricante = trim($_POST["fabricante"]);
    if(empty($input_fabricante)){
        $fabricante_err = "Introduce el fabricante de la vacuna.";
    } else{
        $fabricante = $input_fabricante;
    }

    // Validar numdosis
    $input_numdosis = trim($_POST["numdosis"]);
    if(empty($input_numdosis)){
        $numdosis_err = "Introduce el número de dosis.";
    } elseif(!ctype_digit($input_numdosis)){
        $numdosis_err = "Introduce un valor positivo entero.";
    } else{
        $numdosis = $input_numdosis;
    }

    $diasminimos = trim($_POST["diasminimos"]);
    $diasmaximos = trim($_POST["diasmaximos"]);

    // Revisar los errores de los campos de texto antes de realizar la consulta
    if(empty($nombre_err) && empty($fabricante_err) && empty($nombrelargo_err)&& empty($numdosis_err)){
        // Preparar la sentencia
        $sql = "UPDATE vacuna SET nombre=?, nombre_largo=?, fabricante=?, num_dosis=?, dias_minimos=?, dias_maximos=? WHERE id=?";

        if($stmt = $mysqli->prepare($sql)){
            // Vincular las variables a la sentencia
            $stmt->bind_param("sssiiii", $param_nombre, $param_nombrelargo, $param_fabricante,
                $param_numdosis, $param_diasminimos, $param_diasmaximos, $param_id);

            // Definir los parámetros
            $param_nombre = $nombre;
            $param_nombrelargo = $nombrelargo;
            $param_fabricante = $fabricante;
            $param_numdosis = $numdosis;
            $param_diasminimos = $diasminimos;
            $param_diasmaximos = $diasmaximos;
            $param_id = $id;

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
    }

    // Cerrar conexión
    $mysqli->close();
} else{
    // Comporobar la existencia del parámetro id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Preparar la sentencia
        $sql = "SELECT * FROM vacuna WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Vincular las variables a la sentencia
            $stmt->bind_param("i", $param_id);

            // Definir parámetros
            $param_id = $id;

            // Ejecutar la sentencia
            if($stmt->execute()){
                $result = $stmt->get_result();

                if($result->num_rows == 1){
                    // Guardar los resultados de la sentencia en un array
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // Declarar los valores del array
                    $nombre = $row["nombre"];
                    $nombrelargo = $row["nombre_largo"];
                    $fabricante = $row["fabricante"];
                    $numdosis = $row["num_dosis"];
                    $diasminimos = $row["dias_minimos"];
                    $diasmaximos = $row["dias_maximos"];
                } else{
                    // Si no existe el id redirigir a error.php
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Algo fue mal. Por favor intantalo de nuevo más tarde.";
            }
        }

        // Cerrar sentencia
        $stmt->close();

        // Cerrar conexión
        $mysqli->close();
    }  else{
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
    <title>Actualizar vacuna</title>
    <link rel="stylesheet" href="../css/actualizarVacuna.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
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
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Actualizar Vacuna</h2>
                <p>Por favor, edita los campos de Vacuna que desees modificar.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                        <span class="invalid-feedback"><?php echo $nombre_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Nombre largo</label>
                        <input type="text" name="nombrelargo" class="form-control <?php echo (!empty($nombrelargo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombrelargo; ?>">
                        <span class="invalid-feedback"><?php echo $nombrelargo_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Fabricante</label>
                        <textarea name="fabricante" class="form-control <?php echo (!empty($fabricante_err)) ? 'is-invalid' : ''; ?>"><?php echo $fabricante; ?></textarea>
                        <span class="invalid-feedback"><?php echo $fabricante_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Número de dosis</label>
                        <input type="text" name="numdosis" class="form-control <?php echo (!empty($numdosis_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $numdosis; ?>">
                        <span class="invalid-feedback"><?php echo $numdosis_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Tiempo mínimo</label>
                        <input type="text" name="diasminimos" class="form-control <?php echo (!empty($diasminimos_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $diasminimos; ?>">
                        <span class="invalid-feedback"><?php echo $diasminimos_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Tiempo máximo</label>
                        <input type="text" name="diasmaximos" class="form-control <?php echo (!empty($diasmaximos_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $diasmaximos; ?>">
                        <span class="invalid-feedback"><?php echo $diasmaximos_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <a href="listarVacuna.php" class="btn btn-secondary ml-2">Cancelar</a>
                </form>
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