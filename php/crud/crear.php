<?php

include '../conexion_be.php';
session_start();

// verifica que el usuario si inicio sesion
if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor, inicia sesión");
            window.location = "index.php"; 
        </script>
    ';
    session_destroy();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut = $_POST['rut'];
    $nombre_fantasia = $_POST['nombre_fantasia'];
    $razon_social = $_POST['razon_social'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $condicion_pago = $_POST['condicion_pago'];

    $categoria = $_POST['id_categoria'];

    // Insertar el proveedor
    $sql = "INSERT INTO proveedor (rut, nombre_fantasia, razon_social, direccion, email, telefono, condicion_pago) 
            VALUES ('$rut', '$nombre_fantasia', '$razon_social', '$direccion', '$email', '$telefono', '$condicion_pago')";

    if ($conexion->query($sql) === TRUE) {
        // Obtener la última ID insertada
        $id_proveedor = $conexion->insert_id;

        // Insertar en la tabla proveedor_categoria
        $sql2 = "INSERT INTO proveedor_categoria (id_proveedor, id_categoria) VALUES ('$id_proveedor', '$categoria')";

        if ($conexion->query($sql2) === TRUE) {
            echo "Proveedor creado exitosamente.";
        } else {
            echo "Error al crear el proveedor: " . $conexion->error;
        }
    } else {
        echo "Error al crear el proveedor: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor</title>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;

            height: 10vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            margin-right: 20px;
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
            margin-top: 20px;
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
</head>
<body>
    <nav>
        <a href="../crud/actualizar.php">Editar</a>
        <a href="../datos/proveedores.php">Ver</a>
        <a href="../crud/eliminar.php">Eliminar</a>
    </nav>
    <h1>Crear Proveedor</h1>

    <form method="post" action="crear.php">
        <label for="rut">RUT:</label>
        <input type="text" name="rut" required>
        <br>
        <label for="razon_social">Razón Social:</label>
        <input type="text" name="razon_social" >
        <br>
        <label for="nombre_fantasia">Nombre Fantasía:</label>
        <input type="text" name="nombre_fantasia" >
        <br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" >
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" >
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" >
        <br>
        <label for="condicion_pago">Condición de Pago:</label>
        <select name="condicion_pago" id="condicion_pago">
            <option value="Credito">Credito</option>
            <option value="Contado">Contado</option>
        </select>
        <br>
        <br>
        <label for="id_categoria">Categoria:</label>
        <select id="Categoria" name="id_categoria">

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
        <button type="submit">Crear Proveedor</button>
    </form>
 
</body>
</html>

