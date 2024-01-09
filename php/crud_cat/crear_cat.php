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
// Insertar los datos a la tabla categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cat = $_POST['nombre'];

    $sql_cat = "INSERT INTO categoria (nombre) VALUES ('$nombre_cat')";

    if ($conexion->query($sql_cat) === TRUE) {
        echo '<script>
            alert("Categoría creada correctamente");
            window.location = "../datos/categorias.php";
            </script>';
    } else {
        echo '<script>
            alert("Error en la creación de la categoría");
            window.location = "crear_cat.php";
            </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <a href="../datos/proveedores.php" class="crud">Proveedores</a> 
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
<div class="busqueda_main">
    <form method="post" action="../crud_cat/crear_cat.php">
        <label for="nombre">Nombre categoría</label>
        <input type="text" name="nombre" required>
        <br>
        <div class="subir">
            <button type="submit">Crear categoria</button>
        </div>
    </form>
    
    </div>
</body>
</html>