<?php

    require('conexionbd.php');
    if(!isset($_SESSION["username"])){/* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
    }

    $tituloBiblio = $_SESSION['IDbiblioteca'];
    /* echo "<script> alert ('titulo $tituloBiblio') </script>"; */
    $setenciaSQL2 = "SELECT * FROM TABLA_BIBLIOTECAS WHERE titulo ='$tituloBiblio';";

    $resultados2 = mysqli_query($conexion, $setenciaSQL2);
    // printf("Errormessage bilbio: %s\n", mysqli_error($conexion));
    $numerodedialas = mysqli_num_rows($resultados2);
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

    $setenciaSQL3 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
    $resultados3 = mysqli_query($conexion, $setenciaSQL3);
    // printf("Errormessage secc: %s\n", mysqli_error($conexion));
    /* BUSQUEDA del cuadro de la  seleccion */
    $setenciaSQL = "SELECT TABLA_RECURSOS.titulo FROM TABLA_RECURSOS, TABLA_SECCIONES WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND  TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio';";
    $resultados = mysqli_query($conexion, $setenciaSQL);
    // printf("Errormessage bus: %s\n", mysqli_error($conexion));

    echo '
        <!DOCTYPE html>
        <html lang="ES">
            <head>
                <meta charset="UTF-8"/>
                <title>Borrar recurso .-Base de datos multimedia</title>
                <meta name="AUTOR" content="Fco Javier"/>
                <!--Referencia a doc css-->
                <link rel="stylesheet" type="text/css" href="./formatoborrar.css" />

            </head>
            <body>';
            ?>
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
                <?php
                echo '
                <section id="Centro" class="recurso">
                    <h1>Seleccionar Rescurso</h1>';
                    /* Compruebo si hay recursos */
                    if(mysqli_num_rows($resultados) > 0){/* Hay recursos */
                        echo '  <form name="FormularioBorrarRecurso" action="TratarSelecionarRecurso.php" method="POST" >
                                    <select name="ListaRecursos" id="ListaRecursos"  size="25">';
                        while ($fila = mysqli_fetch_assoc($resultados)){
                
                            echo '      <option value="'.$fila["titulo"].'">'.$fila["titulo"].'</option>';
                        }
                        echo '      </select>
                                    <article id="Botonera">
                                        <input type="submit" id="Enviar" value="Modificar">
                                    </article>
                                </form>';
                    }else{ /* No hay recursos */
                        echo ' <p> No hay ningun recurso en la biblioteca<p>';
                    }
    echo '
                </section>
                <footer id="Partedeabajo">
                    <a href="./contacto.html">Contacto</a>
                    <a href="./como_se_hizo.pdf"> Como se hizo</a>
                </footer>
            </body>
        </html>';
        mysqli_close($conexion);
?>