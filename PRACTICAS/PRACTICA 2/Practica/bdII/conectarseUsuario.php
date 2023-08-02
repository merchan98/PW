<?php

    require('conexionbd.php');
    error_reporting(E_ALL);

    /* Compruebo si el usuario a introducido toso los datos */
    if(isset($_POST['usuario']) && isset($_POST['password'])){

        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $sentenciaSQL = "SELECT * FROM TABLA_USUARIOS WHERE usuario = '$usuario' AND pasword = '$password';";
        $resultado = mysqli_query($conexion, $sentenciaSQL);

        /* Compruebo los daotos del resultado */
        if(mysqli_num_rows($resultado) > 0){
            session_start();

            $datosUsuario = mysqli_fetch_assoc($resultado);
            //Si creamos mas ahi que elimniarlas en desconcetarUsuario.php!!!!!!!
            $_SESSION['username'] = $datosUsuario["usuario"];
            $_SESSION['email'] = $datosUsuario["email"];
            
            $mensaje = "Incio de sesion correcto";
            echo "<script> alert ('$mensaje') </script>";
            mysqli_close($conexion);
            header("Location: ./gestorbd.php");

        }else{ /* Si no sale menor significa que el usuario no esta registrado oq ue es incorrecto */
            $_SESSION['error']="1";
            mysqli_close($conexion);
            /* Mesnaje de error */
            $mensaje = "Usuario o contraseña incorrectos o no registrados. Porfavor vuelva a intentarlo.";
            echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
            header("Location: ../index.php");
        }

    }else{/* Error en los datos */
        $_SESSION['error']="1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
    }


?>
