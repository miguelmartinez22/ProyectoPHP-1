<?php
// Incluir archivo de configuración
require_once "../config/configuracion.php";

if(isset($_REQUEST["term"])){
    // Preparar la sentencia
    $sql = "SELECT * FROM usuario WHERE email LIKE ?";

    if($stmt = $mysqli->prepare($sql)){
        // Vincular las variables a la sentencia
        $stmt->bind_param("s", $param_term);

        // Definir los parámetros
        $param_term = $_REQUEST["term"] . '%';

        // Ejecutar la sentencia
        if($stmt->execute()){
            $result = $stmt->get_result();

            // Comprobar el número de filas de la sentencia
            if($result->num_rows > 0){
                // Guardar los resultados de la sentencia en un array
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    echo "<p>" . $row["nombre"] . "</p>";
                }
            } else{
                echo "<p>No se encontraron resultados</p>";
            }
        } else{
            echo "ERROR: No se pudo ejecutar $sql. ";
        }
    }

    // Cerrar sentencia
    $stmt->close();
}

// Cerrar conexión
$mysqli->close();
?>