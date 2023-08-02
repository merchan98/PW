<?php
    require('conexionbd.php');
    /* Elimino antiguos valores */
    unset($_SESSION['IDbiblioteca']);
    unset($_SESSION['archivoBilioteca']);
    if(!isset($_SESSION["username"])){/* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
    }
    /* Busco la biblioteca */
    $setenciaSQL = "SELECT titulo, archivo FROM TABLA_BIBLIOTECAS";
    $resultados = mysqli_query($conexion, $setenciaSQL);
?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Base de datos multimedia (Index)</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoGestorbd.css" />

    </head>
    <body>
        <header id="SeccionArriba">
            <img src="./imagenes/libro abierto.png" alt="Logo de la Biblioteca" />
            <h1>DigiBliblo Gestor</h1>
            <!-- <p>Nombre de usuario</p> -->
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
        <section id="Centro">
            <article id="CentroIzquierda">
                <a href="./crearbd.php"><h2>Crear Biblioteca digital</h2></a>
            </article>
            <article id="CentroDerecha">
                <h2>Biblioteca dadas de alta</h2>
                <?php
                    if(mysqli_num_rows($resultados) > 0){/* Hay recursos */
                            echo '<section id="ListaBibliotecas">';
                        while ($fila = mysqli_fetch_assoc($resultados)){
                            
                            echo '  <article id="fila"> 
                                        <img src="'.$fila['archivo'].'" alt="Imagen Biblioteca'.$fila['titulo'].'">
                                        <section id="filaDerecha">
                                            <p><a href="./bd1.php?biblioteca='.$fila['titulo'].'">'.$fila['titulo'].'</a></p>
                                            <article id="OpcBiblio">
                                                <p><a href="borrardb.php"> Borrado</a></p>
                                                <p><a href="seleccionarBiblioteca.php">Edicion</a></p>
                                            </article>
                                        </section>
                                    </article>';/* Revisar por que e cambiado la estructura de editar <p><a href="editarbd.php">Edicion</a></p>*/
                        }
                        echo '      ';
                    }else{ /* No hay recursos */
                        echo '<p> No hay ninguna biblioteca<p>';
                    }
                ?>
                <!--<section id="ListaBibliotecas">
                    <article id="fila">
                        <img src="./imagenes/logoPelicula.png" alt="Imagen Biblioteca 1">
                        <section id="filaDerecha">
                            <p><a href="./bd1.html"> Peliculas</a></p>
                            <article id="OpcBiblio">
                                <p><a href="borrardb.html"> Borrado</a></p>
                                <p><a href="./editarbd.html">Edicion</a></p>
                            </article>
                        </section>
                    </article>
                    <article id="fila">
                        <img src="./imagenes/logoPelicula.png" alt="Imagen Biblioteca 2">
                        <section id="filaDerecha">
                            <p><a href="./bd1.html"> Series</a></p>
                            <article id="OpcBiblio">
                                <p><a href="borrardb.html"> Borrado</a></p>
                                <p><a href="./editarbd.html">Edicion</a></p>
                            </article>
                        </section>
                    </article>
                    <article id="fila">
                        <img src="./imagenes/logoPelicula.png" alt="Imagen Biblioteca 3">
                        <section id="filaDerecha">
                            <p><a href="./bd1.html"> Documentales</a></p>
                            <article id="OpcBiblio">
                                <p><a href="borrardb.html"> Borrado</a></p>
                                <p><a href="./editarbd.html">Edicion</a></p>
                            </article>
                        </section>
                    </article>    
                </section>-->
            </article>
        </section>
        <?php   mysqli_close($conexion);  ?>
        <footer id="Partedeabajo">
            <!-- <p> -->
            <a href="./contacto.html">Contacto</a>
            <p>-</p>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
            <!-- </p> -->
        </footer>
    </body>
    </body>
</html>
