<?php
    define ("DB_HOST", "localhost");
    define ("DB_NAME", "db31032280_pw1920");
    define ("DB_USUARIO", "pw31032280");
    define ("DB_PASWORD" , "31032280");
    define ("TABLA_USUARIOS" , "usuarios");
    define ("TABLA_RECURSOS" , "recursos");
    define ("TABLA_SECCIONES" , "secciones");
    define ("TABLA_BIBLIOTECAS" , "bibliotecas");
    /* DEMAS tablas */

    $conexion = mysqli_connect(DB_HOST,DB_USUARIO, DB_PASWORD, DB_NAME);

    if(!$conexion){
        $_SESSION['error']="1";
        $mensaje = "Error en la concexion ";
        $mesnaje2 = mysqli_errno();
                 echo "<script> alert ('$mensaje') </script>";
        header("Location: ../index.php");
    }else{
        session_start();
    }

?>