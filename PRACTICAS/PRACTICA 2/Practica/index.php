<?php
    require('./bdII/conexionbd.php');
    error_reporting(E_ALL);
    /* Busco la biblioteca */
    $setenciaSQL = "SELECT titulo, archivo FROM TABLA_BIBLIOTECAS";
    $resultados = mysqli_query($conexion, $setenciaSQL);
    // printf("Errormessage: %s\n", mysqli_error($conexion));
?>

<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Base de datos multimedia (Index)</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./bdII/formatoIndex.css" />

    </head>
    <body>
        <header id="SeccionArriba">
            <img src="./bdII/imagenes/libro abierto.png" alt="Logo de la Biblioteca" />
            <h1>DigiBliblo Gestor</h1>
<!--             onsubmit="return ValidarIncioSesion()"-->
            <form name="InicioDeSesion" action="./bdII/conectarseUsuario.php" method="POST" >
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario"/>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"/>
                <section>
                    <input type="submit" id="Enviar" value="Enviar">
                    <a href="./bdII/altagestor.php"><input type="button" id="buttonRegistrase" value="Registrarse" /></a>
                </section>
                <!-- <a href="./bdII/gestorbdII.html"><input type="button" id="button1" value="Enviar" /></a> -->
            </form>
            <script>
                function ValidarIncioSesion(){
                    /* Comprobacion usuario */
                    valor=document.getElementById("usuario").value;
                    if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length < 9){
                        alert("Introduzca un usuario valido o mas corto(max 9 caract)");
                        return false;
                    }else{
                        var reg = (/^[a-zA-Z0-9_\s]+$/)
                        if (!reg.test(valor/* document.FormularioUsuario.Apellidos.value */) ){
                            alert("Introduzca un usuario valido");
                            return false;
                            console.log(valid);
                        }
                    }
                    /* Validar Contraseña */
                    valor = document.getElementById("password").value;
                    if(valor.length < 6 || valor == null || valor.length == 0 ||  /^\s+$/.test(valor)){
                        alert("Introduce una Contraseña o la contraseña es demsasiado corta");
                        return false;
                    }else{
                        /* Validacion por si hay caracter no validos */
                        /* var i = 0;
                            while (i < contrasenia.length) {
                                if (contrasenia.charAt(i) == " "){
                                    alert("La contraseña no puede contener espacios.");
                                    document.formulario_altausuario.contrasenia.focus();
                                    return false;
                                }
                                i++;
                            } */
                    }

                }
            </script>
        </header>
        <section id="Centro">
            <article id="CentroIzquierda">
                <img src="./bdII/imagenes/estanteraiTio.png" alt="Imagen de una bliblioteca digital"/>
            </article>
            <article id="CentroDerecha">
                <h2>Biblioteca dadas de alta</h2>
                <?php
                    if(mysqli_num_rows($resultados) > 0){/* Hay recursos */
                            echo '<section id="ListaBibliotecas">';
                        while ($fila = mysqli_fetch_assoc($resultados)){
                            
                            echo '  <article id="fila"> 
                                        <img src="bdII/'.$fila['archivo'].'" alt="Imagen Biblioteca'.$fila['titulo'].'">
                                        <section id="filaDerecha">
                                            <p>'.$fila['titulo'].'</p>
                                        </section>
                                    </article>';/* Revisar por que e cambiado la estructura de editar <p><a href="editarbd.php">Edicion</a></p>*/
                        }
                        echo '      ';
                    }else{ /* No hay recursos */
                        echo '<p> No hay ninguna biblioteca<p>';
                    }
                ?>
                <!-- <section id="fila">
                    <img src="./bdII/imagenes/logoPelicula.png" alt="Imagen Biblioteca 1">
                    <p>Peliculas</p>
                </section>
                <section id="fila">
                    <img src="./bdII/imagenes/logoPelicula.png" alt="Imagen Biblioteca 2">
                    <p>Documentales</p>
                </section>
                <section id="fila">
                    <img src="./bdII/imagenes/logoPelicula.png" alt="Imagen Biblioteca 1">
                    <p>Series</p>
                </section> -->
            </article>
        </section>
        <footer id="Partedeabajo">
            <!-- <p> -->
            <a href="./bdII/contacto.html">Contacto</a>
            <p>-</p>
            <a href="./bdII/como_se_hizo.pdf"> Como se hizo</a>
            <!-- </p> -->
        </footer>
    </body>
</html>

