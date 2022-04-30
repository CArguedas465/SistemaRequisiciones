<?php

    include '../clases/recuperar.php';


    $recuperarCorreo = new RecuperarCorreo();
    $usuario = $_POST["Usuario"];

    $ejecucion = $recuperarCorreo -> verificar_Usuario($usuario);

    echo "<script>window.setTimeout(function() {window.location.href = '../html/recuperarContrasenna.php';}, 0);</script>";

?>