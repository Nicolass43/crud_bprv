<?php
session_start();
include_once '../conexion_be.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// verificacion de inicio de sesion
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $usuario =$_SESSION['usuario'];
    $clave =$_POST['clave'];
    $clave = hash('sha512', $clave);
   //valida la clave del usuario
    $validacion = "SELECT clave FROM usuarios WHERE usuario = '$usuario'";

    $sql_eliminar_categoria = "DELETE FROM proveedor_categoria WHERE id_proveedor = '$id'";
    $conexion->query($sql_eliminar_categoria);

    $resultado = $conexion->query($validacion);
    //verifica si la query fue existosa 
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $contrasena_almacenada = $fila['clave'];

        if($clave == $contrasena_almacenada){
            $sql_eliminar_categoria = "DELETE FROM proveedor_categoria WHERE id_proveedor = '$id'";
            $sql_eliminar = "DELETE FROM proveedor WHERE id = '$id'";
            if ($conexion->query($sql_eliminar) === TRUE) {
                
                echo "<script>alert('Proveedor eliminado exitosamente.');</script>";
            } else {
                echo "<script>alert('Error al eliminar el proveedor: " . $conexion->error . "');</script>";
            }
        } else {
            echo "<script>alert('Contraseña incorrecta. No se eliminó el proveedor.');</script>";
        }
    } else {
        echo "<script>alert('Error al obtener la contraseña del usuario: " . $conexion->error . "');</script>";
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
    .container-main{
        margin-top:20vh;
    }
    .crud:hover, 
    .Log_out:hover {
        background-color: #555;
    }

    .Log_out {
        background-color: orange;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px; 
        margin: 20px auto;
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
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
        margin-right: 20px;
    }
    button {
        margin-left: 70px;
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
    </style>
<body>
<nav>
    <div class="nav">
    <a href="../datos/categorias.php" class="crud">Categoria</a> 
        <div class="nav-links">
            <a href="../crud_prv/actualizar.php" class="crud">Editar</a>
            <a href="../datos/proveedores.php" class="crud">Ver</a>
            <a href=../crud_prv/crear.php class="crud">Crear</a>
        </div>
        <div class="icon-circle">
            <img src="../../assets/images/usuario.png" alt="Icono" class="icon">
        </div>
        <a href="../cerra_sesion.php" class="Log_out">Salir</a>
    </div>
</nav>
<div class="container-main">
    <form method="post" action="eliminar.php">
        <label for="id">ID del proveedor:</label>
        <input type="text" name="id" required>
        <br>
        <label for="usuario">Ingrese su usuario</label>
        <input type="text" name="usuario" required>
        <br>
        <label for="clave">Contraseña del usuario:</label>
        <input type="password" name="clave" required>
        <br>
        <button type="submit">Eliminar Proveedor</button>
    </form>
</div>
</body>
</html>
