<?php

    require('conexionbd.php');

    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['ListaRecursos'])){
                /* Creo variables con los datos */
                    $titulo = $_POST['ListaRecursos'];
                    //Revisar borrar los archivos
                /* Borrar en la base de datos */
                    $sentenciaSQL = "DELETE FROM TABLA_BIBLIOTECAS WHERE titulo ='$titulo'"; 
            /* Si no falla la consulta reedirigimos a la pagina de la base de datos */ 
                if(mysqli_query($conexion,$sentenciaSQL)){
                    /* Cierro conexion */
                        mysqli_close($conexion);
                    /* Mensaje al usuario */
                        $mensaje = "Biblioteca eliminada satifatoriamente";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la pagina principal */
                        header("Location: ./gestorbd.php");
                }else{ /* Falla al insertar */
                    $_SESSION['error']= "1";
                    mysqli_close($conexion);
                    /* Mensaje de error */
                        $mensaje = "Error en el borrado de la biblioteca";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la pagina principal */
                        header("Location: ./borrarbd.php");
                } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mensaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la pagina principal */
                header("Location: ./borrarbd.php");
        }

    }else{ /* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
    }

?>