<?php
    include '../clases/empleado.php';

    $empleado = new empleado(); 

    $resultadoDeshabilitacion = $empleado -> HabilitarEmpleado($_POST["idempleado_habilitar"]);
    
    if ($resultadoDeshabilitacion){
        echo "<h1>Empleado # ".$_POST["idempleado_habilitar"]." ha sido deshabilitado correctamente</h1><p>Redireccionando a la página...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
    } else {
        echo "<h1>Empleado # ".$_POST["idempleado_habilitar"]." no ha podido ser habilitado.</h1><p>Redireccionando a la página...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
    }
?>