<?php

    /* Mostramos un mensaje de que cerramos sesion */
    $mensaje = "Cerrando Sesion....";
    echo "<script> alert ('$mensaje') </script>";

    /* Emepamos o reanudamos la sesion */
    session_start();
    /* Destruimos la sesiones iniciadas */
    if(session_destroy()){
        /* Borramos las variables */
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['IDbiblioteca']);//Crear un if se borra en gestionbd.php tb
        unset($_SESSION['archivoBilioteca']);//Crear un if se borra en gestionbd.php tb
        unset($_SESSION['IDSeccion']);//Crear un if se borra en gestionbd.php tb

        /* Devolvemos al usuario a la pagina principal */
        header("Location: ../index.php");
    }


?>