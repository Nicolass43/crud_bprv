<?php
session_start();
include_once 'conexion_be.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor, inicia sesión");
            window.location = "index.php"; // Puedes cambiar la página de redirección
        </script>
    ';
    session_destroy();
    die();
}

// Procesar la solicitud para eliminar un proveedor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $contrasena_usuario = $_POST['clave'];

    // Obtener la contraseña almacenada del usuario (deberías tenerla almacenada de manera segura en tu base de datos)
    $sql = "SELECT clave FROM usuarios WHERE id = {$_SESSION['usuario']['id']}";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $contrasena_almacenada = $fila['clave'];

        // Verificar si la contraseña proporcionada por el usuario coincide con la almacenada
        if (password_verify($contrasena_usuario, $contrasena_almacenada)) {
            // Eliminar el proveedor de la base de datos
            $sql_eliminar = "DELETE FROM proveedor WHERE id = $id";
            if ($conexion->query($sql_eliminar) === TRUE) {
                echo "Proveedor eliminado exitosamente.";
            } else {
                echo "Error al eliminar el proveedor: " . $conexion->error;
            }
        } else {
            echo "Contraseña incorrecta. No se eliminó el proveedor.";
        }
    } else {
        echo "Error al obtener la contraseña del usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Proveedor</title>
</head>
<style>
        nav {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 0 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #555;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
<body>
<nav>
        <a href=../crud/crear.php>Crear</a>
        <a href="../crud/actualizar.php">Editar</a>
        <!-- <a href="../crud/eliminar.php">Eliminar</a> -->
        <a href="../datos/proveedores.php">Ver</a>
    </nav>
    <form method="post" action="eliminar.php">
        <label for="id">ID del proveedor:</label>
        <input type="text" name="id" required>
        <br>
        <label for="contrasena_usuario">Contraseña del usuario:</label>
        <input type="password" name="contrasena_usuario" required>
        <br>
        <button type="submit">Eliminar Proveedor</button>
    </form>

</body>
</html>
