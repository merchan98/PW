<?php
    require('conexionbd.php');
    error_reporting(E_ALL);
    /* Comprobamos si hay sesion */
        if(!isset($_SESSION["username"])){/* No hay sesion activada */
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
            $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
            echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
            header("Location: ../index.php");
        }
    /* FIN COMPROBAR SESION */
    /* COMPROBAR  BIBLIOTECA */
        $tituloBiblio = $_SESSION['IDbiblioteca'];
    /*FIN COMPROBAR  BIBLIOTECA */
    
    /* Tabla de navegacion */
        $setenciaSQL3 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
        $resultados3 = mysqli_query($conexion, $setenciaSQL3);
                    // printf("Errormessage: %s\n", mysqli_error($conexion));
    /* FIN Tabla de navegacion */
    /* COMPROGACION SECCION */
        /* Campuramos la secciones que se refiere */
        if(isset($_GET['seccion'])){    
            /* $esverdad= isset($_GET['biblioteca']);
            echo "<script> alert ('dentro del get$esverdad') </script>"; */
            $_SESSION['IDSeccion'] = $_GET['seccion'];
            $tituloSeccion = $_SESSION['IDSeccion'];
        }else {
            if(!isset($_SESSION['IDSeccion'])){/* Volvemos a la seleccion de biblioteca */
            $_SESSION['error']= "1";
                mysqli_close($conexion);
                /* Mesnaje de error */
                    $mensaje = "Error ninguna seccion seleccionada";
                    echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la plagina principal */
                    header("Location: ./bd1.php");
            }
        }
        $tituloSeccion = $_SESSION['IDSeccion'];
        $setenciaSQL = "SELECT titulo FROM TABLA_SECCIONES WHERE titulo = '$tituloSeccion' AND bibliotecaTitulo = '$tituloBiblio'";
        $resultados2 = mysqli_query($conexion, $setenciaSQL);
        /* Comprobamos si hay una biblioteca */
            if(mysqli_num_rows($resultados2) == 0){
                mysqli_close($conexion);
                    /* Mesnaje de error */
                        $mensaje = "Error no existe la seccion seleccionada";
                        echo "<script> alert ('$mensaje') </script>";
                    /* Redireccion a la plagina principal */
                     
                    header("Location: ./bd1.php");
            }
            /* cojemos la fila de datos de la biblioteca en un array  */
            $filaSeccion = mysqli_fetch_assoc($resultados2);
    /* FIN COMPROGACION SECCION */

 

                    
?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Seccion 1 .- Base de datos multimedia (Index)</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoRecursosSeccion.css" />
        
    </head>
    <body>
    <header id="SeccionArriba">
            <img src="<?php echo $_SESSION['archivoBilioteca']?>" alt="Logo de la Biblioteca" />
            <h1><?php echo $_SESSION['IDbiblioteca']?></h1>
            <section id="GestionUsuarios">
                <article id="NomUsua">
                    <p><?php echo $_SESSION['username']?></p>
                </article>
                <a href="./desconectarUsuario.php" class="BotonDesconectarse"><input type="button" id="buttonDesconecatrse" value="Desconcetarse" /></a>
                <p class="tituloOpciones">Opciones Usuarios</p>
                <article id="OpcUsuario">
                    <!-- <p><a href="editargestor.php">Edicion</a></p> -->
                    <p><a href="editargestor.html">Edicion</a></p>
                    <p><a href="altagestor.php">Alta</a></p>
                    <p><a href="borrargestor.php"> Borrado</a></p>
                </article>
            </section>
        </header>
        <nav id="MenuSeleciones">
            <ul>
                <li><a href="#">Menu de Secciones</a>
                    <ul>
                        <?php
                            while ($fila = mysqli_fetch_assoc($resultados3)){
                                echo '<li><a href="./recursosseccion1.php?seccion='.$fila["titulo"].'">'.$fila["titulo"].'</a></li>';
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
        <h2>Recursos de la <?php echo $filaSeccion['titulo']?></h2>
        <section id="centro">
        <?php
            /* Buscarmos recursos de la bibliteca */
                $sentenciaSQL5= "SELECT DISTINCT TABLA_RECURSOS.titulo, TABLA_RECURSOS.descripcion FROM TABLA_RECURSOS, TABLA_SECCIONES, TABLA_BIBLIOTECAS 
                WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio' AND TABLA_SECCIONES.titulo = '$tituloSeccion';";
                $resultados5 = mysqli_query($conexion, $sentenciaSQL5);
                // printf("Errormessage busa recur: %s\n", mysqli_error($conexion));
            /* FIN Buscarmos recursos de la bibliteca */
                if(mysqli_num_rows($resultados5) > 0){/* Hay recursos */
                    //  while(($fila = mysqli_fetch_assoc($resultados5)) && $contador < 4){
                    for($i = 1; $i < 4; $i++){
                        echo  '<article id="fila1">';
                        for($j = 1; $j < 4 && $fila = mysqli_fetch_assoc($resultados5); $j++){
                            echo '<section id="recurso1">';
                            echo '<h3><a href="./recurso1.php?recurso='.$fila["titulo"].'">Dando la nota</a></h3>';
                            echo '<p>'.$fila["descripcion"].'</p>';
                            echo '</section>';
                        }
                        echo '</article>';
                    }
                }else{ /* No hay recursos */
                    echo ' <p> No hay ningun recruso en la seccion<p>';
                }
        ?>
        </section>
        <section id="IndiceAabajo">
        <?php 
            if(mysqli_num_rows($resultados5) > 9){
                echo '<p><a href="./recursosseccion1.php">1</a>
                </p>';
            }           
            ?>
        </section>
        <footer id="Partedeabajo">
            <a href="./contacto.html">Contacto</a>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
        </footer>
    </body>
</html>