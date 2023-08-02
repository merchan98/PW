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
    $setenciaSQL3 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
    $resultados3 = mysqli_query($conexion, $setenciaSQL3);
    /* BUSQUEDA del cuadro de la  seleccion */
    $setenciaSQL = "SELECT TABLA_RECURSOS.titulo FROM TABLA_RECURSOS, TABLA_SECCIONES WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND  TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio';";
    $resultados = mysqli_query($conexion, $setenciaSQL);

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
            <body>';?>
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
                <?php
        echo'
                <section id="Centro" class="recurso">
                    <h1>Borrar Recurso</h1>';
                    /* Compruebo si hay recursos */
                    if(mysqli_num_rows($resultados) > 0){/* Hay recursos */
                        echo '  <form name="FormularioBorrarRecurso" action="TratarBorrarRecurso.php" method="POST" >
                                    <select name="ListaRecursos" id="ListaRecursos"  size="25">';
                        while ($fila = mysqli_fetch_assoc($resultados)){
                
                            echo '      <option value="'.$fila["titulo"].'">'.$fila["titulo"].'</option>';
                        }
                        echo '      </select>
                                    <article id="Botonera">
                                        <input type="submit" id="Enviar" value="Borrar">
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