<?php

    require('conexionbd.php');
    error_reporting(E_ALL);
    // $mensaje = "Inicio php";
    //                     echo "<script> alert ('$mensaje') </script>";

    /* Si el usuario no a iniciado sesion */
    // if(!isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['Nombre']) && isset($_POST['Email']) && isset($_POST['Apellidos'])
            && isset($_POST['pasword']) && isset($_POST['usuarioAlta']) ){
                /* Creo variables con los datos */
                    $nombre = $_POST['Nombre'];
                    $apellidos = $_POST['Apellidos'];
                    $usuario = $_POST['usuarioAlta'];
                    $email = $_POST['Email'];
                    $password = $_POST['pasword'];
                    // $subirArchivo = './imagenes/imagenBibliotecaDigital.png'; //Revisar por que da eeror otros alumnos y gestionar su subida
                
                    /* Insertar en la base de datos */
                    $sentenciaSQL = "INSERT INTO TABLA_USUARIOS (nombre, apellidos, usuario, email, pasword ) VALUES ('$nombre' , '$apellidos' , '$usuario' , '$email' , '$password' );"; 
            /* Si no falla la colsulta reedirigimos a la pagina de la base de datos */ 
                /* $peticion = mysqli_query($conexion,$sentenciaSQL);
                $mensaje2 = mysqli_error($conexion);
                    printf("Errormessage: %s\n", mysqli_error($conexion));
                    echo "<script> alert ('$mensaje2 a') </script>";
                    echo "<script> alert ('$peticion b') </script>"; */

                if(mysqli_query($conexion,$sentenciaSQL)){
                    /* Cierro conexion */
                    mysqli_close($conexion);
                    /* Mesnaje al usuario */
                        $mensaje = "Usuario añadido satifatoriamente";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la plagina principal */
                        header("Location: ../index.php");
                }else{ /* Falla al insertar y redirigimos otra vez al formulario */
                    $_SESSION['error']= "1";
                    /* Mesnaje de error */
                    $mensaje = "Error en el alta del recurso";
                    $mensaje2 = mysqli_error($conexion);
                    echo "<script> alert ('$mensaje2') </script>";
                    mysqli_close($conexion);
                    /* Redireccion a la plagina principal */
                        header("Location: ./altagestor.php");
                } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje d') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./altagestor.php");
        }

    // }else{ /* Hay sesion activada */
    //     $_SESSION['error']= "1";
    //     mysqli_close($conexion);
    //     /* Mesnaje de erro */
    //     $mensaje = "Ya hay una sesion activada, porfavor cierre sesion antes de dar de alta al usuario";
    //     echo "<script> alert ('$mensaje') </script>";
    //     /* Redireccion a la plagina principal */
    //     header("Location: ../index.php");
    // }
