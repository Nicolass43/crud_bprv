<?php

include_once '../conexion_be.php';
session_start();

// verifica que el usuario si inicio sesion
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
    <title>Proveedores</title>
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
        max-width: auto;
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



    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px; 
        margin: 20px auto;
    }

    h1 {
        text-align: center;
        color: #333;
        
    }

    label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    input,
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
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
    }

    .busqueda_main label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .busqueda_main input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
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
    <a href="categorias.php" class="crud">Categoria</a> 
        <div class="nav-links">
            <a href="../crud_prv/actualizar.php" class="crud">Editar</a>
            <a href=../crud_prv/crear.php class="crud">Crear</a>
            <a href="../crud_prv/eliminar.php" class="crud">Eliminar</a>
        </div>
        <div class="icon-circle">
            <img src="../../assets/images/usuario.png" alt="Icono" class="icon">
        </div>
        <a href="../cerra_sesion.php" class="Log_out">Salir</a>
    </div>
    
</nav>
<div class="busqueda_main">  
    <form method="post" action="proveedores.php">
        <!--<label for="id_prv">ID del Proveedor:</label>
        <input type="text" name="id_prv">
        <br> -->
        <!-- filtrar datos por rut -->

        <label for="rut">Rut:</label>
        <input type="text" name="rut">
        <br>
         <!-- filtrar datos nombre fantasia (nombre real) -->
        <label for="nombre_fantasia">Nombre Fantasía:</label>
        <input type="text" name="nombre_fantasia">
        <br>
         <!-- filtrar datos por razon social (nombre legal) -->
        <label for="razon_social">Razón Social:</label>
        <input type="text" name="razon_social">
        <br>
        <!-- filtrar datos por direccion -->
        <!-- <label for="direccion">Dirección:</label>
        <input type="text" name="direccion">
        <br> -->
        <!--  filtrar datos por email -->
        <!--<label for="email">Email:</label>
        <input type="text" name="email">
        <br>
         filtrar datos por telefono -->
        <!-- <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono">
        <br> --> 
        <!--  filtrar datos por tipo de pago -->
        <label for="condicion_pago">Condición de Pago:</label>
        <select name="condicion_pago">
            <option value="" selected disabled>Seleccionar Pago</option>
            <option value="Credito">Crédito</option>
            <option value="Contado">Contado</option>
        </select>
        <br>
        <!-- // filtrar datos por categoria -->
        <label for="categoria">Categoría:</label>
        <select id="Categoria" name="id_categoria">
            <option value="" selected disabled>Seleccionar Categoría</option>
            <option value="1">Ferreteria</option>
            <option value="2">GPS</option>
            <option value="3">Insumo Computacionales</option>
            <option value="4">Arriendo</option>
            <option value="5">Alimentacion</option>
            <option value="6">Aduana</option>
            <option value="7">EPP</option>
            <option value="8">MISC</option>
            <option value="9">Insumos Electricos</option>
            <option value="10">Cortes Laser</option>
            <option value="11">Movilizacion</option>
        </select>
        <br>
        <div class="subir">
            <button type="submit">Buscar Proveedores</button>
        </div>
        <div class="limpiar">
            <button type="submit">Limpiar Filtros</button>
        </div>
    </form>
</div>
<div class="filtros">   
    <?php
        // Verificar si se realizó una búsqueda
        $busqueda_realizada = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || TRUE) {
            // Obtener los valores del formulario
            $id_prv = $_POST['id_prv'];
            $rut = $_POST['rut'];
            $nombre_fantasia = $_POST['nombre_fantasia'];
            $razon_social = $_POST['razon_social'];
            $direccion = $_POST['direccion'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $condicion_pago = $_POST['condicion_pago'];
            $id_categoria = $_POST['id_categoria'];
        
            // Construir la consulta
            $sql = "SELECT pr.id AS 'ID',
                            pr.rut AS 'Rut',
                            pr.nombre_fantasia AS 'Nombre Fantasia', 
                            pr.razon_social AS 'Razon Social', 
                            pr.direccion AS 'Direccion',
                            pr.email AS 'Email', 
                            pr.telefono AS 'Telefono', 
                            pr.condicion_pago AS 'Condicion Pago', 
                            cat.nombre AS 'Categoria'
                    FROM proveedor pr
                    JOIN proveedor_categoria pc ON pr.id = pc.id_proveedor
                    JOIN categoria cat ON pc.id_categoria = cat.id_categoria
                    WHERE (pr.id = '$id_prv' OR '$id_prv' = '')
                    AND (pr.rut LIKE '%$rut%' OR '$rut' = '')
                    AND (pr.nombre_fantasia LIKE '%$nombre_fantasia%' OR '$nombre_fantasia' = '')
                    AND (pr.razon_social LIKE '%$razon_social%' OR '$razon_social' = '')
                    AND (pr.direccion LIKE '%$direccion%' OR '$direccion' = '')
                    AND (pr.email LIKE '%$email%' OR '$email' = '')
                    AND (pr.telefono LIKE '%$telefono%' OR '$telefono' = '')
                    AND (pr.condicion_pago = '$condicion_pago' OR '$condicion_pago' = '')
                    AND (cat.id_categoria = '$id_categoria' OR '$id_categoria' = '')
                    ORDER BY pr.id ASC";
        
            // Ejecutar la consulta
            $resultado = $conexion->query($sql);
        
            // Indicar que se ha realizado una búsqueda
            $busqueda_realizada = true;
        
            // Verificar si la consulta fue exitosa y mostrar los resultados
            if ($resultado->num_rows > 0) {
            } else {
                echo '<script>alert("No se encontraron resultados.");
                window.location = "proveedores.php"</script>';
            }
        }

            // Verificar si la consulta fue exitosa y mostrar los resultados
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

            // Cerrar la conexión
            $conexion->close();
        
    ?>
</div>
</body>
</html>
