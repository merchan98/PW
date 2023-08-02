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
    /* Comprobamos que tenemos recrusos */
    if(isset($_GET['recurso'])){
        /* Compruebo que hay una sesion iniciada */
        if(isset($_GET['recurso'])){//isset ($_SESSION['tituloSeleccionado'])){
            $tituloRecurso = $_GET['recurso'];
            /* Creo la sentencia de consulta a la BD */
            $sentenciaSQL = "SELECT * FROM TABLA_RECURSOS WHERE titulo ='$tituloRecurso'";
            $resultado= mysqli_query($conexion, $sentenciaSQL);
            // printf("Errormessage: %s\n", mysqli_error($conexion));
            if(mysqli_num_rows($resultado) < 0){
                $_SESSION['error']= "1";
                mysqli_close($conexion);
                /* Mensaje de error */
                    $mensaje = "Error no se encuntra el recurso";
                    echo "<script> alert ('$mensaje') </script>";
                /* Redireccion a la pagina principal */
                    header("Location: ./bd1.php");
            }
                $recurso = mysqli_fetch_assoc($resultado);
                $idRecurso = $recurso['IDRecurso'];
                $titulo = $recurso['titulo'];
                $genero = $recurso['genero'];
                $subgenero = $recurso['subGenero'];
                $anio = $recurso['anio'];
                $duracion = $recurso['duracion'];
                $nombreDirector = $recurso['nombreDirector'];
                $pais = $recurso['pais'];
                $protagonista = $recurso['protagonista'];
                $tipo = $recurso['tipo'];
                $seccionTitulo = $recurso['SeccionTitulo'];
                $descripcion = $recurso['descripcion'];
                $subirArchivo = $recurso['archivo'];
    
    
        }else{/* Si no hay sesion o no hay elemento */
           /* Mesnaje de error */
           $mensaje = "No hay una sesion iniciada o no exite el elemento";
           echo "<script> alert ('$mensaje') </script>";
           /* Redireccion a la plagina principal */
           header("Location: ../index.php"); 
        }
    }else{/* Volvemos a la seleccion de biblioteca */
        $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error ningun recurso seleccionado";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./bd1.php");
    }
    /* Varaibles para el menu de navegacion */
    $tituloBiblio = $_SESSION['IDbiblioteca'];
    $setenciaSQL3 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
    $resultados3 = mysqli_query($conexion, $setenciaSQL3);

?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Recurso .-Base de datos multimedia</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoRecurso.css" />

    </head>
    <body>
        <header id="SeccionArriba">
            <img src="<?php echo $_SESSION['archivoBilioteca']?>" alt="Logo de la Biblioteca" />
            <h1><?php echo $_SESSION['IDbiblioteca']?></h1>
            <section id="GestionUsuarios">
                <article id="NomUsua">
                    <p><?php echo $_SESSION['username']?></p>
                </article>
                <a href="./bd/desconectarUsuario.php" class="BotonDesconectarse"><input type="button" id="buttonDesconecatrse" value="Desconcetarse" /></a>
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
        <section id=Centro>
            <form name="FormularioRecurso" action="procesarRecurso.php" method="POST" >
                <article id=CentroArriba>
                    <section id="CentroArribaIzq">
                       <a href="#"><label for="SubirArchivo">Recurso </label></a>
                        <!-- <input type="file" id="SubirArchivo" name="SubirArchivo"> -->
                    </section>
                    <section id="CentroArribaDrcha">
                        <article>
                            <label for="titulo">Titulo: </label>
                            <input type="text" id="titulo" name="titulo" value="<?php echo $titulo ?>" readonly>
                        </article>
                        <article>
                            <label for="Genero">Genero: </label>
                            <select id = "Genero" name="Genero" >
                                <option value = "<?php echo $genero ?>" selected><?php echo $genero ?></option> 
                            </select>
                        </article>
                        <article>
                            <label for="Subgenero">Subgenero: </label>
                            <select id = "Subgenero" name="Subgenero" >
                                <option value = "<?php echo $subgenero ?>" selected><?php echo $subgenero ?></option>
                            </select>
                        </article>
                        <article>
                            <label for="Año">Fecha estreno: </label>
                            <input type="date" id="Año" name="Año" value="<?php echo $anio ?>" readonly>
                        </article>
                        <article>
                            <labe for="Duracion">Duracion: </labe>
                            <input type="number" id="Duracion" name="Duracion" value="<?php echo $duracion ?>" min="1" max="999" readonly>
                        </article>
                        <article>  
                            <label for="NombreDirector">Director: </label>
                            <input type="text" id="NombreDirector" name="NombreDirector" value="<?php echo $nombreDirector ?>" readonly>
                        </article>
                        <article>
                            <label for="Pais">Pais: </label>
                            <select id = "Pais" name="Pais">
                                <option value = "<?php echo $pais ?>" selected><?php echo $pais ?></option>
                            </select>
                        </article>
                        <article>
                            <label for="Protagonista">Protagonista: </label>
                            <input type="text" id="Protagonista" name="Protagonista" value="<?php echo $protagonista ?>" readonly> 
                        </article>
                        <article>
                            <label for="Tipo" >Tipo de archivo: </label>
                                <select id = "Tipo" name="Tipo">
                                    <option value = "<?php echo $tipo ?>" selected><?php echo $tipo ?></option>
                                </select>
                        </article>
                        <article>
                            <label for="Seccion">Seccion: </label>
                                <select id = "Seccion" name="Seccion">
                                    <option value = "<?php echo $seccionTitulo ?>" selected><?php echo $seccionTitulo ?></option>
                                </select>
                        </article>
                    </section> 
                </article>
                <article id="CentroAbajo">
                    <label for="Descripcion"> Descripcion: </label>
                    
                    <textarea id="Descripcion" name="Descripcion" rows="7" cols="50" readonly><?php echo $descripcion ?></textarea>
                </article>
            </form>
            <article id="Botonera">
                <?php
                $setenciaSQL = "SELECT TABLA_RECURSOS.titulo FROM TABLA_RECURSOS, TABLA_SECCIONES 
                WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND  TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio';";
                    /* Calculo haber si hay recrusos anterior */
                    $recrusoAnterior = $idRecurso - 1;
                    $sentenciaSQL3 = "SELECT TABLA_RECURSOS.titulo FROM TABLA_RECURSOS, TABLA_SECCIONES WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND  TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio' AND TABLA_RECURSOS.IDRecurso ='$recrusoAnterior';";
                    $resultadoAnte= mysqli_query($conexion, $sentenciaSQL3);
                    // printf("Errormessage: %s\n", mysqli_error($conexion));
                    /* Compruebo si la solcuion esta vacio o no si lo esta es que no hay anterior */
                    if(mysqli_num_rows($resultadoAnte) > 0){
                        $filaRecurso = mysqli_fetch_assoc($resultadoAnte);
                        echo '<a href="./recurso1.php?recurso='.$filaRecurso['titulo'].'">Anterior</a>';
                    }
                    /* Calculo haber si hay recruso posterior */
                    $recrusoPosterior = $idRecurso + 1;
                    $sentenciaSQL4 = "SELECT TABLA_RECURSOS.titulo FROM TABLA_RECURSOS, TABLA_SECCIONES WHERE TABLA_RECURSOS.SeccionTitulo = TABLA_SECCIONES.titulo AND  TABLA_SECCIONES.bibliotecaTitulo = '$tituloBiblio' AND TABLA_RECURSOS.IDRecurso ='$recrusoPosterior';";
                    $resultadoPost= mysqli_query($conexion, $sentenciaSQL4);
                    // printf("Errormessage: %s\n", mysqli_error($conexion));
                    /* Compruebo si la solcuion esta vacio o no si lo esta es que no hay anterior */
                    if(mysqli_num_rows($resultadoPost) > 0){
                        $filaRecurso = mysqli_fetch_assoc($resultadoPost);
                        echo '<a href="./recurso1.php?recurso='.$filaRecurso['titulo'].'">Siguiente</a>';
                    }
                ?>
            </article>
        </section>
        <?php   mysqli_close($conexion);  ?>
        <footer id="Partedeabajo">
            <a href="./contacto.html">Contacto</a>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
        </footer>

    </body>
</html>
