<?php
    session_start();

    include 'conexion_be.php';

    $correo =$_POST['correo'];
    $clave =$_POST['clave'];
    $clave = hash('sha512', $clave);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'
    AND clave='$clave'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $correo;
        header("location: datos/proveedores.php");
        
        exit;
    }else{
        echo'
            <script>
                alert("La contrasena o el nombre de usuarios son incorrectos, porfavor verifique los datos");
                windows.location = "../index.php";
            </script>
        ';
        exit;

    }
?>