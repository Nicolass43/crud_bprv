<?php
session_start();
include_once '../conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Recuperar datos del proveedor si se envía una ID
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proveedor_solicitado = $_POST['id_prv'];

    $sql_proveedor = "SELECT nombre_fantasia, razon_social, direccion, email, telefono, condicion_pago FROM proveedor WHERE id = '$id_proveedor_solicitado'";

    $resultado_proveedor = $conexion->query($sql_proveedor);

    if ($resultado_proveedor->num_rows > 0) {
        $proveedor = $resultado_proveedor->fetch_assoc();
    }
}
    // Proceso de actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
        // Comparar y actualizar campos
        $nombre_fantasia_form = $_POST['nombre_fantasia'];
        $razon_social_form = $_POST['razon_social'];
        $direccion_form = $_POST['direccion'];
        $email_form = $_POST['email'];
        $telefono_form = $_POST['telefono'];
        $condicion_pago_form = $_POST['condicion_pago'];
    
        // Comparación y actualización para el campo nombre_fantasia
        if ($nombre_fantasia_form != $proveedor['nombre_fantasia']) {
            $sql_actualizar_nombre_fantasia = "UPDATE proveedor SET nombre_fantasia = '$nombre_fantasia_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_nombre_fantasia);
        }
    
        // Comparación y actualización para el campo razon_social
        if ($razon_social_form != $proveedor['razon_social']) {
            $sql_actualizar_razon_social = "UPDATE proveedor SET razon_social = '$razon_social_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_razon_social);
        }
    
        // Comparación y actualización para el campo direccion
        if ($direccion_form != $proveedor['direccion']) {
            $sql_actualizar_direccion = "UPDATE proveedor SET direccion = '$direccion_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_direccion);
        }
    
        // Comparación y actualización para el campo email
        if ($email_form != $proveedor['email']) {
            $sql_actualizar_email = "UPDATE proveedor SET email = '$email_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_email);
        }
    
        // Comparación y actualización para el campo telefono
        if ($telefono_form != $proveedor['telefono']) {
            $sql_actualizar_telefono = "UPDATE proveedor SET telefono = '$telefono_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_telefono);
        }
    
        // Comparación y actualización para el campo condicion_pago
        if ($condicion_pago_form != $proveedor['condicion_pago']) {
            $sql_actualizar_condicion_pago = "UPDATE proveedor SET condicion_pago = '$condicion_pago_form' WHERE id = '$id_proveedor_solicitado'";
            $conexion->query($sql_actualizar_condicion_pago);
        }
            if (isset($_POST['guardar_cambios']) == TRUE)
                 {
                echo '<script>
                alert("Proveedor editado exitosamente.");
                window.location = "../datos/proveedores.php";
                </script>';
                
                 }
            
    
                }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
</head>
<style>
    nav {
        background-color: #333;
        color: #fff;
        padding: 15px;
        text-align: center;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-links {
        display: flex;
        align-items: center;
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
        background-color: orange; /* Cambia el color de fondo a naranja */
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
        margin-bottom: 20px;
        margin-right: 20px;
    }

    label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    input, select {
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
<body>
<nav>
    <div class="nav">
        <div class="nav-links">
            <a href="../crud/crear.php" class="crud">Crear</a>
            <a href="../datos/proveedores.php" class="crud">Ver</a>
            <a href="../crud/eliminar.php" class="crud">Eliminar</a>
        </div>
        <a href="../cerra_sesion.php" class="Log_out">Log Out</a>
    </div>
</nav>
<div action="actualizar.php">
<form method="post" >
    <label for="id_prv">Ingrese la ID del proveedor:</label>
    <input type="text" name="id_prv" required>
    <button type="submit">Buscar Proveedor</button>
</form>

<?php
if (isset($error_proveedor_no_encontrado)) {
    echo "<p>$error_proveedor_no_encontrado</p>";
}

if (isset($proveedor)) {
    ?>
    <form method="post" >
        <input type="hidden" name="id_prv" value="<?php echo $id_proveedor_solicitado?>" >
        <label for="nombre_fantasia">Nombre Fantasia:</label>
        <input type="text" name="nombre_fantasia" value="<?php echo $proveedor['nombre_fantasia']; ?>" >
        <br>
        <label for="razon_social">Razon Social:</label>
        <input type="text" name="razon_social" value="<?php echo $proveedor['razon_social']; ?>" >
        <br>
        <label for="direccion">Direccion:</label>
        <input type="text" name="direccion" value="<?php echo $proveedor['direccion']; ?>" >
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $proveedor['email']; ?>" >
        <br>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $proveedor['telefono']; ?>" >
        <br>
        <label for="condicion_pago">Condición de Pago:</label>
        <select name="condicion_pago" id="condicion_pago">
            <option value="Credito" <?php echo ($proveedor['condicion_pago'] == 'Credito') ? 'selected' : ''; ?>>Credito</option>
            <option value="Contado" <?php echo ($proveedor['condicion_pago'] == 'Contado') ? 'selected' : ''; ?>>Contado</option>
        </select>
        <button type="submit" name="guardar_cambios">Guardar Cambios</button>
    </form>
    </div>
    <?php
}
    ?>
    <?php


if (isset($exito_actualizacion)) {
    echo "<p>$exito_actualizacion</p>";
}

if (isset($error_actualizacion)) {
    echo "<p>$error_actualizacion</p>";
}
?>
</body>
</html>
