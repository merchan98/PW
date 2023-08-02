<!DOCTYPE html>
<?php
    require('conexionbd.php');

?>
<html lang="ES">
    <head>
        <meta charset="UTF-8"/>
        <title>Alta Gestor.-Base de datos multimedia</title>
        <meta name="AUTOR" content="Fco Javier"/>
        <!--Referencia a doc css-->
        <link rel="stylesheet" type="text/css" href="./formatoAltaUsuario.css" />

    </head>
    <body>
        <header id="SeccionArriba">
            <img src="./imagenes/libro abierto.png" alt="Logo de la Biblioteca" />
            <h1>DigiBliblo Gestor</h1>
            <!-- <p>Nombre de usuario</p> -->
            <?php
            if(isset($_SESSION["username"])){
               echo ' <section id="GestionUsuarios">
                    <article id="NomUsua">
                        <p>'.$_SESSION["username"].'</p>
                    </article>
                    <a href="./desconectarUsuario.php" class="BotonDesconectarse"><input type="button" id="buttonDesconecatrse" value="Desconcetarse" /></a>
                    <p class="tituloOpciones">Opciones Usuarios</p>
                    <article id="OpcUsuario">
                        <p><a href="editargestor.html">Edicion</a></p>
                        <p><a href="altagestor.php">Alta</a></p>
                        <p><a href="borrargestor.php"> Borrado</a></p>
                    </article>
                </section>';
            }else{
                echo '<form name="InicioDeSesion" action="./conectarseUsuario.php" method="POST" >
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario"/>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password"/>
                    <section>
                        <input type="submit" id="Enviar" value="Enviar">
                        <a href="./altagestor.php"><input type="button" id="buttonRegistrase" value="Registrarse" /></a>
                    </section>
                </form>';
            }
            ?>
        </header>
        <section id="Centro">
            <h2>Datos alta Usuario</h2>
            <form name="FormularioUsuario" action="procesarUsuario.php" method="POST" onsubmit="return ValidarUsuario()">
                <article id=CentroArriba>
                    <section id="CentroArribaIzq">
                        <label for="SubirArchivo">Subir Imagen </label>
                        <input type="file" id="SubirArchivo" name="SubirArchivo" value="recurso" hidden/>
                    </section>
                    <section id="CentroArribaDrcha">
                        <article>
                            <label for="Nombre">Nombre: </label>
                            <input type="text" id="Nombre" name="Nombre" >
                        </article>
                        <article>
                            <label for="Apellidos">Apellidos: </label>
                            <input type="text" id="Apellidos" name="Apellidos" >
                        </article>
                        <article>
                            <label for="usuarioAlta">Usuario: </label>
                            <input type="text" id="usuarioAlta" name="usuarioAlta" >
                        </article>
                        <article>
                            <label for="Email">Email: </label>
                            <input type="email" id="Email" name="Email" >
                        </article>
                        <article>
                            <label for="pasword">Contraseña: </label>
                            <input type="password" id="pasword" name="pasword" >
                        </article>
                    </section> 
                </article>
                <article id="Botonera">
                    <input type="submit" id="Enviar" value="Enviar">
                </article>
                
            </form>
            <script>
                function ValidarUsuario(){
                    /* Comprobacion apellidos */
                    /* var valid =true; */
                    var valor=document.getElementById("Nombre").value;
                    if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 50){/* document.FormularioUsuario.Nombre.value == "d" */
                       
                        alert("Introduzca un nombre "); return false;
                        console.log(valid);
                    }else{
                        var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/)
                        if (! reg.test(document.FormularioUsuario.Nombre.value)){
                            alert("Introduzca un nombre valido");
                            valid = false;
                        }
                    }
                    /* Comprobacion apellidos */
                     valor=document.getElementById("Apellidos").value;
                    if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 70){
                        alert("Introduzca un apellido valido");
                        return false;
                    }else{
                        var reg = (/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/)
                        if (! reg.test(valor/* document.FormularioUsuario.Apellidos.value */)){
                            alert("Introduzca un apellido valido");
                            return false;
                            console.log(valid);
                        }
                    }
                    /* Comprobacion usuario */
                    valor=document.getElementById("usuarioAlta").value;
                    
                    if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 9){
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
                    /* Comprobacion email */
                    var valor = document.getElementById("Email").value;
                    if(valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor.length > 70){
                        alert("Introduzca un email");
                        return false;
                    }else{
                        var reg = (/\S+@\S+\.\S+/)
                        if (!(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(valor))){ /* ! reg.test(document.FormularioUsuario.Email.value) */
                            alert("Introduzca un email valido");
                            return false;
                        }
                    }
                    /* Validar Contraseña */
                    valor = document.getElementById("pasword").value;
                    if(valor.length > 6 || valor == null || /^\s+$/.test(valor) || valor.length == 0 ){
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

                    /* console.log(valid); */
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