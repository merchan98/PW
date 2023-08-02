<?php

    require('conexionbd.php');

    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['ListaRecursos'])){
                /* Creo variable para pasar al siguiente guion*/
                    $_SESSION['tituloSeleccionado'] = $_POST['ListaRecursos'];
                    /* Mensaje al usuario */
                        $mensaje = "Redireccionando a los datos de la biblioteca .....";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la pagina principal */
                        header("Location: ./editarbd.php");
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mensaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la pagina principal */
                header("Location: ./seleccionarBiblioteca.php");
        }

    }else{ /* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location_ ../index.php");
    }

?>