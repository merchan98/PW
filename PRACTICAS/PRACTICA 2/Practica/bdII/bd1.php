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
    /* Combrimaso que tenemos bicliotece */
    if(isset($_GET['biblioteca'])){    
        /* $esverdad= isset($_GET['biblioteca']);
        echo "<script> alert ('dentro del get$esverdad') </script>"; */
        $_SESSION['IDbiblioteca'] = $_GET['biblioteca'];
        $tituloBiblio = $_SESSION['IDbiblioteca'];
    }else {
        if(!isset($_SESSION['IDbiblioteca'])){/* Volvemos a la seleccion de biblioteca */
        $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error ninguna bibliotecea seleccionada";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./gestorbd.php");
        }
    }
    $tituloBiblio = $_SESSION['IDbiblioteca'];
    /* echo "<script> alert ('titulo $tituloBiblio') </script>"; */
    $setenciaSQL = "SELECT * FROM TABLA_BIBLIOTECAS WHERE titulo ='$tituloBiblio';";

    $resultados2 = mysqli_query($conexion, $setenciaSQL);
    $numerodedialas = mysqli_num_rows($resultados2);
    /* echo "<script> alert ('nuemor $numerodedialas') </script>";
     printf("Errormessage: %s\n", mysqli_error($conexion)); */
    /* Comprobamos si hay una biblioteca */
    if(mysqli_num_rows($resultados2) == 0){
        mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error no existe la bibliotecea seleccionada";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./gestorbd.php");
    }
    /* cojemos la fila de datos de la biblioteca en un array  */
    $filaBiblio = mysqli_fetch_assoc($resultados2);
    /* Guardo la foto de la biblioteca para su posteriro uso */
    $_SESSION['archivoBilioteca']=$filaBiblio['archivo'] ;
    /* Buscarmos recursos de la bibliteca */
    $sentenciaSQL2= "SELECT DISTINCT TABLA_RECURSOS.titulo, TABLA_RECURSOS.descripcion, TABLA_RECURSOS.archivo FROM TABLA_RECURSOS, TABLA_SECCIONES, TABLA_BIBLIOTECAS WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio';";
    $resultados = mysqli_query($conexion, $sentenciaSQL2);
    
    $setenciaSQL3 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
    $resultados3 = mysqli_query($conexion, $setenciaSQL3);
                    // printf("Errormessage: %s\n", mysqli_error($conexion));
                    
?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Bd1.-Base de datos multimedia</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatobd1.css" />
    </head>
    <body>
        <header id="SeccionArriba">
            <img src="<?php echo $filaBiblio['archivo']?>" alt="Logo de la Biblioteca" />
            <h1><?php echo $filaBiblio['titulo']?></h1>
            <section id="GestionUsuarios">
                <article id="NomUsua">
                    <p><?php echo $_SESSION['username']?></p>
                </article>
                <a href="./desconectarUsuario.php" class="BotonDesconectarse"><input type="button" id="buttonDesconecatrse" value="Desconcetarse" /></a>
                <p class="tituloOpciones">Opciones Usuarios</p>
                <article id="OpcUsuario">
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
        <main id="Centro">
            <section id="ColumnaIzq">
                <p id="TextoPredBiblio">
                    <?php echo $filaBiblio['descripcion']?>
                </p>
                <h1>Recursos destacados</h1>
                <article id="ListaRecursos">
                <?php
                    /* $mensaje2 = mysqli_num_rows($resultados);
                    echo "<script> alert ('$mensaje2 a') </script>"; */
                    if(mysqli_num_rows($resultados) > 0){/* Hay recursos */
                        $contador = 0;
                        // echo "<script> alert ('estoy dentro') </script>";
                        while (($filaRecurso = mysqli_fetch_assoc($resultados)) && $contador < 4){
                            echo '  <section id="Recurso">
                                        <img src="'.$filaRecurso['archivo'].'" alt="Imagen Imagen del recurso'.$filaRecurso['titulo'].'">
                                        <article id="TextoRecurso">                                            
                                            <h2><a href="./recurso1.php?recurso='.$filaRecurso['titulo'].'">'.$filaRecurso['titulo'].'</a></h2>
                                            <p>'.$filaRecurso['descripcion'].'</p>
                                        </article>
                                    </section>';/* Revisar por que e cambiado la estructura de editar <p><a href="editarbd.php">Edicion</a></p>*/
                            $contador++;
                        }
                        echo '      ';
                    }else{ /* No hay recursos */
                        echo '<p> No hay ningun Recruso <p>';
                    }
                ?>   
                    <!-- <section id="Recurso">
                        <img src="./imagenes/imagenBibliotecaDigital.png" alt="Imagen del recurso">
                        <article id="TextoRecurso">
                            <h2><a href="./recurso1.html">Dando la nota</a></h2>
                            <p>
                                El argumento se centra en un grupo femenino universitario 
                                de música a capella llamado The Barden Bellas, el cual ha 
                                de competir contra otro grupo del centro educativo para 
                                acceder y ganar los nacionales. 
                            </p>   
                        </article>
                    </section>  
                    <section id="Recurso">
                        <img src="./imagenes/imagenBibliotecaDigital.png" alt="Imagen del recurso">
                        <article id="TextoRecurso">
                            <h2><a href="./recurso1.html">Dando la nota 2</a></h2>
                            <p>
                                El argumento se centra en un grupo femenino universitario 
                                de música a capella llamado The Barden Bellas, despues de ganar
                                tienen que competir contra grupos de todo el mundo. 
                            </p>   
                        </article>
                    </section>
                    <section id="Recurso">
                        <img src="./imagenes/imagenBibliotecaDigital.png" alt="Imagen del recurso">
                        <article id="TextoRecurso">
                            <h2><a href="./recurso1.html">Dando la nota 3</a></h2>
                            <p>
                                El argumento se centra en un grupo femenino universitario 
                                de música a capella llamado The Barden Bellas, despues de 
                                graduarse todas ellas deciden reunirse y cantar de nuevo. 
                            </p>   
                        </article>
                    </section>   
                    -->               
                </article>
            </section>
            <aside id="Informacion">
                <section id="InfoColeccion">
                    <h3>Informacion general de la coleccion</h3>
                    <p>Numero de recursos: <?php echo $filaBiblio['numeroRecursos']?></p>
                    <p>Fuentes:</p>
                    <p>Autores:</p>
                    <p>Y lo que se me ocurra</p>
                </section>
                <h3 class="titulo3">Secciones</h3>
                <section id="OpSeciones">
                    <p><a href="seleccionarSeccion.php">Edicion</a></p>
                    <p><a href="altaSeccion.php">Alta</a></p>
                    <p><a href="borrarSecccion.php"> Borrado</a></p>
                   <!--  <p class="final">(secciones)</p> -->
                </section>
                <h3 class="titulo3">Recurso</h3>    
                <section id="OpRecursos">
                    <p><a href="seleccionarRecurso.php">Edicion</a></p>
                    <p><a href="altarecurso.php">Alta</a></p>
                    <p><a href="borrarRecurso.php"> Borrado</a></p>
                    <!-- <p class="final">(de recurso)</p> -->
                </section>
                
            </aside>
        </main>
        <?php   mysqli_close($conexion);  ?>
        <footer id="Partedeabajo">
            <a href="./contacto.html">Contacto</a>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
        </footer>
        <section></section>
    </body>
</html>