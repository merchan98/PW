<?php

    require('conexionbd.php');
    error_reporting(E_ALL);

    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['titulo']) && isset($_POST['Descripcion']) ){
            
            /* Creo variables con los datos */
            $titulo = $_POST['titulo'];
            $numeroRecusos = 0;
            $descripcion = $_POST['Descripcion'];
                /* Insertar en la base de datos */
                $sentenciaSQL = "UPDATE TABLA_SECCIONES SET descripcion ='$descripcion' WHERE titulo = '$titulo';"; 
            /* Si no falla la colsuta reedirigimos a la pagina de la base de datos */ 
            if(mysqli_query($conexion,$sentenciaSQL)){
                /* Cierro conexion */
                mysqli_close($conexion);
                /* Mesnaje al usuario */
                $mensaje = "Seccion modificada satifatoriamente";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./bd1.php");
            }else{ /* Falla al insertar */
                $_SESSION['error']= "1";
                mysqli_close($conexion);
                /* Mesnaje de error */
                $mensaje = "Error en el alta del seccion";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./seleccionarSeccion.php");
            } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./seleccionarSeccion.php");
        }

    }else{ /* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de erro */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
    }


?>