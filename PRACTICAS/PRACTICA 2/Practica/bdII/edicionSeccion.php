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
    /* Compruebo que se ha ininciado sesion y que existe el elemoento a modificar */
    if(isset ($_SESSION['tituloSeleccionado'])){
        
        $titulo = $_SESSION['tituloSeleccionado'];
        /* Creo la sentencia de consulta a la BD */
        $sentenciaSQL = "SELECT * FROM TABLA_SECCIONES WHERE titulo ='$titulo'";
        $resultado= mysqli_query($conexion, $sentenciaSQL);
        
        if(mysqli_num_rows($resultado) < 0){
            $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mensaje de error */
                $mensaje = "Error no se encuntra la seccion";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la pagina principal */
                header("Location: ./bd1.php");
        }
            /* Guardo las variables para poder utilizarlas en el html */
            $seccion = mysqli_fetch_assoc($resultado);
            $titulo = $seccion['titulo'];
            $numeroRecusos = $seccion['numeroRecursos'];
            $descripcion = $seccion['descripcion'];
            // $subirArchivo = $seccion['archivo'];
    }else{/* Si no hay sesion o no hay elemento */
       /* Mesnaje de error */
       $mensaje = "No hay ningun elemento seleccionado";
       echo "<script> alert ('$mensaje') </script>";
       /* Redireccion a la plagina principal */
       header("Location: ./seleccionarSeccion.php"); 
    }
    if(isset($_SESSION['IDbiblioteca'])){
        $tituloBiblio = $_SESSION['IDbiblioteca'];
    }else{/* Volvemos a la seleccion de biblioteca */
        $_SESSION['error']= "1";
            mysqli_close($conexion);
            /* Mesnaje de error */
                $mensaje = "Error ninguna bibliotecea seleccionada";
                echo "<script> alert ('$mensaje') </script>";
            /* Redireccion a la plagina principal */
                header("Location: ./gestorbd.php");
    }
     /* Hacemos una consulta a la base de datos para saber al secciones disponibles antes de incluir un recurso */
     $setenciaSQL2 = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
     $resultados = mysqli_query($conexion, $setenciaSQL2);
?>
<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Editar Seccion.-Base de datos multimedia</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoAltaSeecion.css" />

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
                            while ($fila = mysqli_fetch_assoc($resultados)){
                                echo '<li><a href="./recursosseccion1.php?seccion='.$fila["titulo"].'">'.$fila["titulo"].'</a></li>';
                            }
                        ?>
                        <!-- <li><a href="./recursosseccion1.html">Comedia</a></li>
                        <li><a href="./recursosseccion1.html">Accion</a></li>
                        <li><a href="./recursosseccion1.html">Suspense</a></li>
                        <li><a href="./recursosseccion1.html">Animacion</a></li> -->
                    </ul>
                </li>
            </ul>
        </nav>
        <section id="Centro">
            <h2>Datos edicion Seccion</h2>
            <form name="FormularioeditarSeccion" action="TratarEditarSeccion.php" method="POST" onsubmit="return ValidarSeccion()">
                <article id=CentroArriba>
                    <!-- <section id="CentroArribaIzq">
                        <label for="SubirArchivo">Subir Imagen </label>
                        <input type="file" id="SubirArchivo" name="SubirArchivo" value="<?php echo $subirArchivo ?>"/> 
                    </section>-->
                    <section id="CentroArribaDrcha">
                        <article>
                            <label for="titulo">Titulo: </label>
                            <input type="text" id="titulo" value="<?php echo $titulo ?>" name="titulo" readonly>
                        </article>
                        
                    </section> 
                </article>
                <article id="CentroAbajo">
                    <label for="Descripcion">Descripcion: </label>
                    <textarea id="Descripcion" name="Descripcion" rows="10" cols="50"><?php echo $descripcion ?> </textarea>
                </article>
                <article id="Botonera">
                    <input type="submit" id="Enviar" value="Enviar">
                </article>
                
            </form>
            <script>
                function ValidarSeccion(){
                    /* Comprobacion titulo */
                        var valor=document.getElementById("titulo").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 30){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Introduzca un titulo "); return false;
                            console.log(valid);
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ0-9_\s]+$/)
                            if (! reg.test(valor)){
                                alert("Introduzca un titulo valido");
                                return false;
                            }
                        }
                    /* debugger; */
                    /* Comprobacion Descripcion */
                        valor=document.getElementById("Descripcion").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor)){
                            alert("Introduzca una descripcion valida");
                            return false;
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ0-9_\s]+$/)
                            if (valor.length > 200 ){
                                alert("Descripcion demasiado larga");
                                
                                console.log(valid);return false;
                            }
                        }
                    /* console.log(valid); *//* debugger */
                    return true;
                }
            </script>
<?php   mysqli_close($conexion);
        unset($_SESSION['tituloSeleccionado']);   ?>
        </section>
        <footer id="Partedeabajo">
            <a href="./contacto.html">Contacto</a>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
        </footer>
    </body>
</html>