<?php

    include_once 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $clave = hash('sha512', $clave);

    $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, clave)
              VALUES ('$nombre_completo', '$correo', '$usuario', '$clave')";
    
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo'
            <script>
                alert("Este correo ya esta registrado, intente con un correo diferente");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo'
            <script>
                alert("Este usuario ya esta registrado, intente con un nombre de usuario diferente");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    
    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar == TRUE){
        echo'
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../index.php";
            </script>
            ';
    }else{
        echo'
            <script>
                alert("Intentelo nuevamente, usuario no almacenado");
                window.location = "../index.php";
            </script>
            ';
    }
    mysqli_close($conexion);
?>