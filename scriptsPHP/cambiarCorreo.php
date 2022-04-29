<?php
    include '../clases/correo.php';
    session_start();

    $correo = new Correo();
    $nuevoCorreo = $_POST["NuevoCorreo"];
    $usuario = $_SESSION['username'];

    $ejecucion = $correo -> guardarNuevoCorreo($usuario, $nuevoCorreo);
    
    echo "<script>window.setTimeout(function() {window.location.href = '../html/paginaPrincipal.php';}, 0);</script>";

?>