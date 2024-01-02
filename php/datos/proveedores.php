<?php
    include '../conexion_be.php';

    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    session_start();

    if(!isset($_SESSION['usuario'])){
        echo'
            <script>
                alert("Por favor deber iniciar sesion");
                window.location = "index.php";
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
    <title>Tabla desde MySQL</title>
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
    </style>
<body>
    <nav>
        <a href=../crud/crear.php>Crear</a>
        <a href="../crud/actualizar.php">Editar</a>
        <a href="../crud/eliminar.php">Eliminar</a>
    </nav>
<?php

$sql = "
SELECT
	pr.id,
    pr.rut,
    pr.nombre_fantasia AS 'nombre fantasia',
    pr.razon_social AS 'razon social',
    pr.direccion,
    pr.email,
    pr.telefono,
    pr.condicion_pago AS 'condicion pago',
    cat.nombre AS 'categoria'
FROM
    proveedor pr 
JOIN
    proveedor_categoria pc ON pr.id = pc.id_proveedor
JOIN
    categoria cat ON pc.id_categoria = cat.id_categoria
ORDER BY pr.id ASC;     
";

$resultado = $conexion->query($sql);

//  Verificar si la consulta fue exitosa
if ($resultado->num_rows > 0) {
    // Generar la tabla HTML
    echo '<table border="1">';
    //  Encabezados de la tabla
    echo '<tr>';
    while ($columna = $resultado->fetch_field()) {
        echo '<th>' . $columna->name . '</th>';
    }
    echo '</tr>';
    //  Datos de la tabla
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

//  Cerrar conexión

?>

</body>
</html>