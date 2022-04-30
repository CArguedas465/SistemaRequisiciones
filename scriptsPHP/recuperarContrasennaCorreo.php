<?php

    include '../clases/recuperar.php';


    $recuperarCorreo = new RecuperarCorreo();
    $usuario = $_POST["Usuario"];

    $ejecucion = $recuperacion_correo -> verificar_Uaurio($usuario);


?>