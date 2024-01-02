<?php
session_start();
include_once '../conexion_be.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario ha iniciado sesión
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

// Obtener el ID del proveedor a editar desde la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales del proveedor
    $sql = "SELECT * FROM proveedor WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $proveedor = $resultado->fetch_assoc();
    } else {
        echo "Proveedor no encontrado.";
        exit;
    }
} else {
    echo "ID del proveedor no proporcionado.";
    exit;
}

// Procesar la solicitud de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $rut = $_POST['rut'];
    $nombre_fantasia = $_POST['nombre_fantasia'];
    $razon_social = $_POST['razon_social'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $condicion_pago = $_POST['condicion_pago'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE proveedor 
            SET rut='$rut', nombre_fantasia='$nombre_fantasia', razon_social='$razon_social', 
                direccion='$direccion', email='$email', telefono='$telefono', condicion_pago='$condicion_pago'
            WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Proveedor actualizado exitosamente.";
    } else {
        echo "Error al actualizar el proveedor: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <style>
        /* Agrega estilos CSS según tus necesidades */
    </style>
</head>
<body>
    <h1>Editar Proveedor</h1>

    <form method="post" action="editar.php">
        <!-- Muestra los datos actuales del proveedor en el formulario -->
        <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">
        <label for="rut">RUT:</label>
        <input type="text" name="rut" value="<?php echo $proveedor['rut']; ?>" required>
        <br>
        <label for="nombre_fantasia">Nombre Fantasía:</label>
        <input type="text" name="nombre_fantasia" value="<?php echo $proveedor['nombre_fantasia']; ?>" required>
        <br>

        <button type="submit">Actualizar Proveedor</button>
    </form>
</body>
</html>
