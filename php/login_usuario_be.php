<?php
    session_start();

    include_once 'conexion_be.php';
    
    $usuario =$_POST['usuario'];
    $clave =$_POST['clave'];
    $clave = hash('sha512', $clave);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'
    AND clave='$clave'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $usuario;
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