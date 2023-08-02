<!DOCTYPE html>
<?php
    require('conexionbd.php');
    error_reporting(E_ALL);
    if(!isset($_SESSION["username"])){/* No hay sesion activada */
        $_SESSION['error']= "1";
        mysqli_close($conexion);
        /* Mesnaje de error */
        $mensaje = "No hay una sesion iniciada. Por favor inicia una sesion";
        echo "<script> alert ('$mensaje') </script>";
        /* Redireccion a la plagina principal */
        header("Location: ../index.php");
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
    $setenciaSQL = "SELECT titulo FROM TABLA_SECCIONES WHERE bibliotecaTitulo = '$tituloBiblio'";
    $resultados = mysqli_query($conexion, $setenciaSQL);
    if(mysqli_num_rows($resultados) == 0){
        mysqli_close($conexion);
        /* Mesnaje de error */
            $mensaje = "Error no secciones porfavor antes de añadir un recurso crea una.";
        /* Redireccion a la plagina principal */
            header("Location: ./bd1.php");
    }
?>

<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Alta recurso .-Base de datos multimedia</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoAltaRecurso.css" />

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
                        <!--<li><a href="./recursosseccion1.html">Comedia</a></li>
                        <li><a href="./recursosseccion1.html">Accion</a></li>
                        <li><a href="./recursosseccion1.html">Suspense</a></li>
                        <li><a href="./recursosseccion1.html">Animacion</a></li> -->
                    </ul>
                </li>
            </ul>
        </nav>
 
        <section id=Centro>
            <form name="FormularioRecurso" action="procesarRecurso.php" method="POST" enctype="multipart/form-data" onsubmit="return ValidarRecurso()">
                <article id=CentroArriba>
                    <section id="CentroArribaIzq">
                        <label for="SubirArchivo">Subir Recurso </label>
                        <input type="file" id="SubirArchivo" name="SubirArchivo" value="recurso" required>
                    </section>
                    <section id="CentroArribaDrcha">
                        <article>
                            <label for="titulo">Titulo: </label>
                            <input type="text" id="titulo" name="titulo">
                        </article>
                        <article>
                            <label for="Genero">Genero: </label>
                            <select id = "Genero" name="Genero">
                                <option value = "Action">Action</option>
                                <option value = "Comedia" >Comedia</option>
                                <option value = "Suspense">Suspense</option>
                                <option value = "Animacion">Animacion</option>
                            </select>
                        </article>
                        <article>
                            <label for="Subgenero">Subgenero: </label>
                            <select id = "Subgenero" name="Subgenero" >
                                <option value = "Action">Action</option>
                                <option value = "Comedia" >Comedia</option>
                                <option value = "Suspense">Suspense</option>
                                <option value = "Animacion">Animacion</option>
                            </select>
                        </article>
                        <article>
                            <label for="Anio">Fecha estreno: </label>
                            <input type="date" id="Anio" name="Anio">
                        </article>
                        <article>
                            <labe for="Duracion">Duracion: </labe>
                            <input type="number" id="Duracion" name="Duracion" >
                        </article>
                        <article>  
                            <label for="NombreDirector">Director: </label>
                            <input type="text" id="NombreDirector" name="NombreDirector">
                        </article>
                        <article>
                            <label for="Pais" >Pais: </label>
                            <select id = "Pais" name="Pais">
                                <option value = "ESP">ESP</option>
                                <option value = "USA" >USA</option>
                                <option value = "FRA">FRA</option>
                                <option value = "UK">UK</option>
                                <option value = "MX">MX</option>
                            </select>
                        </article>
                        <article>
                            <label for="Protagonista">Protagonista: </label>
                            <input type="text" id="Protagonista" name="Protagonista">
                        </article>
                        <article>
                            <label for="Tipo" >Tipo de archivo: </label>
                            <select id = "Tipo" name="Tipo">
                                <option value = "Audio">Audio</option>
                                <option value = "Video" >Video</option>
                                <option value = "Texto">Texto</option>
                                <option value = "Imagen">Imagen</option>
                            </select>
                        </article>
                        <article>
                            <label for="Seccion" >Seccion: </label>
                            <select id = "Seccion" name="Seccion"> 
                                <?php
                                $resultados = mysqli_query($conexion, $setenciaSQL);
                                // echo "<script> alert ('hola caracola') </script>";
                                    while ($fila = mysqli_fetch_assoc($resultados)){
                                        echo '<option value="'.$fila["titulo"].'">'.$fila["titulo"].'</option>';
                                    }
                                    mysqli_close($conexion);
                                ?>
                            </select>            
                        </article>
                    </section> 
                </article>
                <article id="CentroAbajo">
                    <label for="Descripcion">Descripcion: </label>
                    
                    <textarea id="Descripcion" name="Descripcion" rows="10" cols="50"></textarea>
                </article>
                <article id="Botonera">
                    <input type="submit" id="Enviar" value="Enviar">

                </article>
            </form>
            <script>
                function ValidarRecurso(){
                    /* Comprobacion titutulo */
                        var valor=document.getElementById("titulo").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 30){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Introduzca un titulo "); return false;
                            /* console.log(valid); */
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ0-9_\s]+$/)
                            if (! reg.test(valor)){
                                alert("Introduzca un titulo valido");
                                return false;
                            }
                        }
                    /* debugger; */
                    /* Comprobacion de Genero */
                    var valor=document.getElementById("Genero").selectedIndex;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 12){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Seleccione un Genero"); return false;
                            /* console.log(valid); */
                        }
                    /* Comprobacion de Subgenero Año*/
                    var valor=document.getElementById("Subgenero").selectedIndex;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 12 ){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Seleccione un Subgenero"); return false;
                            /* console.log(valid); */
                        }
                    /* Comprobacion de Año */    
                    var valor=document.getElementById("Anio").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 15){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Seleccione un Año"); return false;
                            /* console.log(valid); */
                        }               
                    /* Comprobacion de Duracion */
                    var valor=document.getElementById("Duracion").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor)){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Introduzca una Duracion"); return false;
                            /* console.log(valid); */
                        }else{
                            var reg = (/^[0-9_\s]+$/)
                            if ( isNaN(valor) /*|| valor < 999  || valor > 0 reg.test(valor) */){
                                alert("Introduzca una Duracion valida");console.log(valor);
                                return false;
                            }
                        }
                    /* Comprobacion de Director */
                        var valor=document.getElementById("NombreDirector").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 40){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Introduzca un Nombre de un Director"); return false;
                            /* console.log(valid); */
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/)
                            if (! reg.test(valor)){
                                alert("Introduzca un Nombre de un Director valido");
                                return false;
                            }
                        }
                    /* Comprobacion de Pais */
                    var valor=document.getElementById("Pais").selectedIndex;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 4 ){/* document.FormularioUsuario.Nombre.value == "d" */
                             alert("Seleccione un Pais"); return false;
                            /* console.log(valid); */
                        }
                    /* Comprobacion de Protagonista */
                        var valor=document.getElementById("Protagonista").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 40){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Introduzca un Nombre de un Protagonista"); return false;
                            /* console.log(valid); */
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/)
                            if (! reg.test(valor)){
                                alert("Introduzca un Nombre de un Protagonista valido");
                                valid = false;
                            }
                        }
                    /* Comprobacion de Tipo de archivo */
                        var valor=document.getElementById("Tipo").selectedIndex;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 8 ){/* document.FormularioUsuario.Nombre.value == "d" */
                             alert("Seleccione un Tipo de archivo"); return false;
                            /* console.log(valid); */
                        }
                    /* Comprobacion de seccion */
                    var valor=document.getElementById("Seccion").selectedIndex;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 30 ){/* document.FormularioUsuario.Nombre.value == "d" */
                            alert("Seleccione una Seccion"); return false;
                            /* console.log(valid); */
                        }
                    /* Comprobacion Descripcion */
                        valor=document.getElementById("Descripcion").value;
                        if(valor == null || valor.length == 0 || /^\s+$/.test(valor)){
                            alert("Introduzca una descripcion valida");
                            return false;
                        }else{
                            var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ0-9_\s]+$/)
                            if (valor.length > 200 ){
                                alert("Descripcion demasiado larga");                            
                                /* console.log(valid); */
                                return false;
                            }
                        }

                    /* console.log(valid); *//* debugger */
                    return true;
                }
            </script>
        </section>
        
        <footer id="Partedeabajo">
            <a href="./contacto.html">Contacto</a>
            <a href="./como_se_hizo.pdf"> Como se hizo</a>
        </footer>
        
    </body>
</html>