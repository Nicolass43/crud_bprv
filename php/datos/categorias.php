<?php
include_once '../conexion_be.php';
session_start();

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor, inicia sesión");
            window.location = "../../index.php"; 
        </script>
    ';
    session_destroy();
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>
<style>
    body {
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        height: 100vh;
    }

    nav {
        background-color: #333;
        color: #fff;
        padding: 15px;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center; 
        width: 80%;
        margin: 0 auto;
    }
    .nav-links {
        display: flex;
        align-items: center;
        margin: 0;
    }


    .crud, .Log_out {
        color: #fff;
        text-decoration: none;
        padding: 10px;
        margin: 0 10px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .crud:hover, .Log_out:hover {
        background-color: #555;
    }

    .Log_out {
        background-color: orange;
    }

    .resultado_filtros{
        width: 90%;
        height: 100%;
        border-collapse: collapse;
        margin-top: 10vh; /* Espacio para la barra de navegación */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        max-height: 20vh;
        max-width: 50%;
        overflow-y: auto;

    }

    .resultado_filtros th,
    .resultado_filtros td {
        padding: 4px;
        text-align: left;
        border: 1px solid #ddd; /* Ajusta el color y la opacidad según sea necesario */
    }

    .resultado_filtros th {
        background-color: #3498db;
        color: #fff;
    }

    .resultado_filtros tr:hover {
        background-color: #f5f5f5;
    }
    .icon-circle {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 50%;
        padding: 5px;
        margin-left: 110vh;
    }

    .icon {
        width: 30px;
        height: 30px;
    }
    .busqueda_main {
        margin-top: 10vh;
        margin-right: 5vh;
        margin-left: 5vh;
        display: flex;
        flex-direction: column;
        align-items: flex-start; 
    }
    
    .busqueda_main form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px; 
        margin: 20px auto;
    }

    .busqueda_main label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }
    .busqueda_main input, .busqueda_main select {
        margin-top:20px;
        width: 100%;
        padding: 10px;
        margin-bottom: 5px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .subir button{
        margin-top: 20px;
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .limpiar button{  
        margin-top: 20px;
        background-color: red;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }  
</style>

<body>
<nav>
    <div class="nav">
    <a href="proveedores.php" class="crud">Proveedores</a> 
        <div class="nav-links">
            <a href="../crud_cat/actualizar_cat.php" class="crud">Editar</a>
            <a href=../crud_cat/crear_cat.php class="crud">Crear</a>
            <a href="../crud_cat/eliminar.php_cat" class="crud">Eliminar</a>
        </div>
        <div class="icon-circle">
            <img src="../../assets/images/usuario.png" alt="Icono" class="icon">
        </div>
        <a href="../cerra_sesion.php" class="Log_out">Salir</a>
    </div>
</nav>
    <?php
    // Mostrar los datos de la tabla
    $sql_mos = "SELECT 
                id_categoria AS 'ID',
                nombre AS 'Nombre' 
                FROM categoria";

    $resultado = $conexion->query($sql_mos);

    if ($resultado->num_rows > 0) {
        echo '<table border="1" class="resultado_filtros">';
        // Encabezados de la tabla
        echo '<tr>';
        while ($columna = $resultado->fetch_field()) {
            echo '<th>' . $columna->name . '</th>';
        }
        echo '</tr>';
        // Datos de la tabla
        while ($fila = $resultado->fetch_assoc()) {
            echo '<tr>';
            foreach ($fila as $valor) {
                echo '<td>' . $valor . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No se encontraron resultados.";
    }

    $conexion->close();
    ?>

</body>
</html>
