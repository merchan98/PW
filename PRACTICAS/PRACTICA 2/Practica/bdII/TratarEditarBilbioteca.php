<?php

    require('conexionbd.php');
    error_reporting(E_ALL);

    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['titulo']) && isset($_POST['Descripcion']) ){
            // if(isset($_POST['SubirArchivo'])){
            //     if(isset($_FILES['SubirArchivo']) && $_FILES['SubirArchivo']['error'] === UPLOAD_ERR_OK){
            //         /* Campos del archivo */
            //         $directorioTemporal = $_FILES['SubirArchivo']['tmp_name'];
            //         $nombreArchivo = $_FILES['SubirArchivo']['name'];
            //         $tamnioArchivo = $_FILES['SubirArchivo']['size'];
            //         $tipoArchivo = $_FILES['SubirArchivo']['type'];
            //         $fileNameCmps = explode(".", $nombreArchivo);
            //         $fileExtension = strtolower(end($fileNameCmps));
            //         /* Por si hay incomparibilidaes con caracteres no permitidos filtramos el nombre */
            //         $nombreArchivoFormateado = md5(time() . $nombreArchivo) . '.' . $fileExtension;
            //         /* Definimos la carpeta de subida */
            //         $directoriasubida = './subidos/';
            //         /* Definimos la ruta completa */
            //         $rutaCompleta = $directoriasubida . $nombreArchivoFormateado;
            //         if(move_uploaded_file($directorioTemporal, $rutaCompleta)){
            //             $mensaje = "El archivo a sido subido stisfatoriamente";
            //             echo "<script> alert ('$mensaje') </script>";
            //             $sentenciaSQL = "UPDATE TABLA_BIBLIOTECAS SET archivo ='$rutaCompleta' WHERE titulo = '$titulo';";
            //             if(mysqli_query($conexion,$sentenciaSQL)){
            //             }else{ /* Falla al insertar */
            //                 $_SESSION['error']= "1";
            //                 mysqli_close($conexion);
            //                 /* Mesnaje de error */
            //                 $mensaje = "Error en la modificacion de la biblioteca archvio";
            //                 echo "<script> alert ('$mensaje') </script>";
            //                 /* Redireccion a la plagina principal */
                            // header("Location: ./seleccionarBilioteca.php");
            //             } 
            //         }
            //         else{
            //             $_SESSION['error']= "1";
            //             mysqli_close($conexion);
            //             /* Mesnaje de error */
            //                 $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
            //                 echo "<script> alert ('$mensaje') </script>";
            //             /* Redireccion a la plagina principal */
                            // header("Location: ./crearbd.php");
            //         }
            //     }else{
            //         $_SESSION['error']= "1";
            //         mysqli_close($conexion);
            //         /* Mesnaje de error */
            //             $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
            //             echo "<script> alert ('$mensaje') </script>";
            //         /* Redireccion a la plagina principal */
                        // header("Location: ./crearbd.php");
            //     }
            // }
            /* Creo variables con los datos */
            $titulo = $_POST['titulo'];
            $numeroRecusos = 0;
            $numeroSecciones = 0;
            $descripcion = $_POST['Descripcion'];
            $subirArchivo = $_POST['SubirArchivo']; //Revisar por que da eeror otros alumnos y gestionar su subida
                /* Insertar en la base de datos */
                $sentenciaSQL = "UPDATE TABLA_BIBLIOTECAS SET descripcion ='$descripcion' WHERE titulo = '$titulo';";
            /* Si no falla la colsuta reedirigimos a la pagina de la base de datos */ 
            if(mysqli_query($conexion,$sentenciaSQL)){
                printf("Errormessage: %s\n", mysqli_error($conexion));
                /* Cierro conexion */
                mysqli_close($conexion);
                /* Mesnaje al usuario */
                $mensaje = "Biblioteca modificada satifatoriamente";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./gestordb.php");
            }else{ /* Falla al insertar */
                printf("Errormessage: %s\n", mysqli_error($conexion));
                $_SESSION['error']= "1";
                mysqli_close($conexion);
                /* Mesnaje de error */
                $mensaje = "Error en la modificacion de la biblioteca";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./seleccionarBilioteca.php");
            } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./seleccionarBilioteca.php");
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