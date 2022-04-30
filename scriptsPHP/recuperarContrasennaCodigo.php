<?php
    include_once '../clases/empleado.php';
    session_start();
    $contraNueva = $_POST["contraseniaNueva"];
    $codigoRecuperacionIntroducido = $_POST["CodigoDeRecuperacion"];
    $codigoRecuperacionReal = $_SESSION["codigoRecuperacion"];
    $usuarioSolicitanteDeRecuperacion = $_SESSION["idUsuarioRecuperacion"];

    if ($codigoRecuperacionIntroducido==$codigoRecuperacionReal)
    {
        $varContrasenna_Encriptada = password_hash($contraNueva, PASSWORD_DEFAULT);

        $empleado = new empleado(); 

        $resultado = $empleado -> ActualizarContrasenna($usuarioSolicitanteDeRecuperacion, $varContrasenna_Encriptada);

        if ($resultado)
        {
            $_SESSION["codigoRecuperacion"] = ''; 
            $_SESSION["idUsuarioRecuperacion"] = '';
            echo "<h1>La contraseña ha sido reestablecida exitosamente.</h1><p>Redireccionando a la página de login...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/login.html';}, 0);</script>";
        }
        else
        {
            $_SESSION["codigoRecuperacion"] = ''; 
            $_SESSION["idUsuarioRecuperacion"] = '';
            echo "<h1>La contraseña no ha podido ser reestablecida. Favor intentar más tarde.</h1><p>Redireccionando a la página de login...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/login.html';}, 4000);</script>"; 
        }
    }
    else
    {
        $_SESSION["codigoRecuperacion"] = ''; 
        $_SESSION["idUsuarioRecuperacion"] = '';
        echo "<h1>El código introducido no calza con el que fue enviado al correo. Intentar nuevamente.</h1><p>Redireccionando a la página de login...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/login.php';}, 4000);</script>";
    }
?>