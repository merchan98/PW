<?php

    require('conexionbd.php');

    /* Si el usuario a iniciado sesion y es correcta */
    if(isset($_SESSION["username"])){
        /* Comprobamos que se han introduciodo todo los datos*/
        if(isset($_POST['titulo']) && isset($_POST['Genero']) && isset($_POST['Subgenero'])
            && isset($_POST['Anio']) && isset($_POST['Duracion']) && isset($_POST['NombreDirector'])
            && isset($_POST['Pais']) && isset($_POST['Protagonista']) && isset($_POST['Tipo'])
            && isset($_POST['Descripcion'])){
                /* Creo variable con el titulo */
                $titulo = $_POST['titulo']; 
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
                //             $sentenciaSQL = "UPDATE TABLA_USUARIOS SET archivo ='$rutaCompleta' WHERE titulo = '$titulo';";
                //             if(mysqli_query($conexion,$sentenciaSQL)){
                //             }else{ /* Falla al insertar */
                //                 $_SESSION['error']= "1";
                //                 mysqli_close($conexion);
                //                 /* Mesnaje de error */
                //                 $mensaje = "Error en la modificacion de la biblioteca archvio";
                //                 echo "<script> alert ('$mensaje') </script>";
                //                 /* Redireccion a la plagina principal */
                //                header("Location: ./seleccionarRecurso.php");
                //             } 
                //         }
                //         else{
                //             $_SESSION['error']= "1";
                //             mysqli_close($conexion);
                //             /* Mesnaje de error */
                //                 $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
                //                 echo "<script> alert ('$mensaje') </script>";
                //             /* Redireccion a la plagina principal */
                //                header("Location: ./seleccionarRecurso.php");
                //         }
                //     }else{
                //         $_SESSION['error']= "1";
                //         mysqli_close($conexion);
                //         /* Mesnaje de error */
                //             $mensaje = "Error en la subida del archivo ". $_FILES['SubirArchivo']['error'];
                //             echo "<script> alert ('$mensaje') </script>";
                //         /* Redireccion a la plagina principal */
                //            header("Location: ./seleccionarRecurso.php");
                //     }
                    
                // }
                /* Creo variables con los datos */                    
                    $genero = $_POST['Genero'];
                    $subgenero = $_POST['Subgenero'];
                    $anio = $_POST['Anio'];
                    $duracion = $_POST['Duracion'];
                    $nombreDirector = $_POST['NombreDirector'];
                    $pais = $_POST['Pais'];
                    $protagonista = $_POST['Protagonista'];
                    $tipo = $_POST['Tipo'];
                    $descripcion = $_POST['Descripcion'];
                    $seccion = $_POST['Seccion'];
                    $subirArchivo = './imagenes/imagenBibliotecaDigital.png';
                   //Revisar por que da eeror otros alumnos y gestionar su subida
                /* Insertar en la base de datos */
                    $sentenciaSQL = "UPDATE TABLA_RECURSOS SET genero ='$genero', subGenero ='$subgenero', anio ='$anio', duracion = '$duracion', nombreDirector ='$nombreDirector', pais ='$pais', protagonista ='$protagonista', tipo ='$tipo', descripcion ='$descripcion', SeccionTitulo ='$seccion' WHERE titulo = '$titulo';"; 
            /* Si no falla la colsuta reedirigimos a la pagina de la base de datos */ 
                if(mysqli_query($conexion,$sentenciaSQL)){
                    /* Cierro conexion */
                        mysqli_close($conexion);
                    /* Mesnaje al usuario */
                        $mensaje = "Recuso modificado satifatoriamente";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la plagina principal */
                        header("Location: ./bd1.php");
                }else{ /* Falla al insertar */
                    $_SESSION['error']= "1";
                    mysqli_close($conexion);
                    /* Mesnaje de error */
                        $mensaje = "Error en la modificacion del recurso";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la plagina principal */
                        header("Location: ./altarecurso.php");
                } 
        }else{ /* No se ha rellenado algun campo */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error falta algun dato";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./altarecurso.php");
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