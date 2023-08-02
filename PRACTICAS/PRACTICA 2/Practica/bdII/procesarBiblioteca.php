<?php

    require('conexionbd.php');
    error_reporting(E_ALL);
    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['titulo']) && isset($_POST['Descripcion'])){
            /* Condificon por is se ha subido mal el archivo */
            // if(isset($_FILES['SubirArchivo']) && $_FILES['SubirArchivo']['error'] === UPLOAD_ERR_OK){
            //     /* Campos del archivo */
            //     $directorioTemporal = $_FILES['SubirArchivo']['tmp_name'];
            //     $nombreArchivo = $_FILES['SubirArchivo']['name'];
            //     $tamnioArchivo = $_FILES['SubirArchivo']['size'];
            //     $tipoArchivo = $_FILES['SubirArchivo']['type'];
            //     $fileNameCmps = explode(".", $nombreArchivo);
            //     $fileExtension = strtolower(end($fileNameCmps));
            //     /* Por si hay incomparibilidaes con caracteres no permitidos filtramos el nombre */
            //     $nombreArchivoFormateado = md5(time() . $nombreArchivo) . '.' . $fileExtension;
            //     /* Definimos la carpeta de subida */
            //     $directoriasubida = './subidos/';
            //     /* Definimos la ruta completa */
            //     $rutaCompleta = $directoriasubida . $nombreArchivoFormateado;
            //     if(move_uploaded_file($directorioTemporal, $rutaCompleta)){
            //         $mensaje = "El archivo a sido subido stisfatoriamente";
            //         echo "<script> alert ('$mensaje') </script>";
            //     }
            //     else{
            //         $_SESSION['error']= "1";
            //         mysqli_close($conexion);
            //         /* Mesnaje de error */
            //             $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
            //             echo "<script> alert ('$mensaje') </script>";
            //         /* Redireccion a la plagina principal */
            //             // header("Location: ./crearbd.php");
            //     }
            // }else{
            //     $_SESSION['error']= "1";
            //     mysqli_close($conexion);
            //     /* Mesnaje de error */
            //         $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
            //         echo "<script> alert ('$mensaje') </script>";
            //     /* Redireccion a la plagina principal */
            //         // header("Location: ./crearbd.php");
            // }
            /* Creo variables con los datos */
            $titulo = $_POST['titulo'];
            $numeroRecusos = 0;
            $numeroSecciones = 0;
            $descripcion = $_POST['Descripcion'];
            $subirArchivo = './imagenes/logoPelicula.png';//$rutaCompleta; Revisar por que da eeror otros alumnos y gestionar su subida
            $mensaje = "he deifindo las variables";
            /* Insertar en la base de datos */
                $sentenciaSQL = "INSERT INTO TABLA_BIBLIOTECAS(titulo, descripcion, numeroSecciones, numeroRecursos, archivo) VALUES ('$titulo' , '$descripcion' , '$numeroSecciones' , '$numeroRecusos' , '$subirArchivo');"; 
            /* Si no falla la colsuta reedirigimos a la pagina de la base de datos */ 
            if(mysqli_query($conexion,$sentenciaSQL)){
                $mensaje2 = mysqli_error($conexion);
                    printf("Errormessage: %s\n", mysqli_error($conexion));
                    echo "<script> alert ('$mensaje2 a') </script>";
                /* Cierro conexion */
                mysqli_close($conexion);
                /* Mesnaje al usuario */
                $mensaje = "Biblioteca añadida satifatoriamente";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./gestorbd.php");
            }else{ /* Falla al insertar */
                $_SESSION['error']= "1";
                $mensaje2 = mysqli_error($conexion);
                    printf("Errormessage: %s\n", mysqli_error($conexion));
                    echo "<script> alert ('$mensaje2 a') </script>";
                mysqli_close($conexion);
                /* Mesnaje de error */
                $mensaje = "Error en el alta de la biblioteca";
                echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                header("Location: ./crearbd.php");
            } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./crearbd.php");
        }

    }else{ /* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de erro */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ./index.php");
    }

?>