<?php
    include '../clases/empleado.php';

    $empleado = new empleado(); 

    $resultadoDeshabilitacion = $empleado -> DeshabilitarEmpleado($_POST["idempleado_deshabilitar"]);
    
    if ($resultadoDeshabilitacion){
        echo "<h1>Empleado # ".$_POST["idempleado_deshabilitar"]." ha sido deshabilitado correctamente</h1><p>Redireccionando a la página...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
    } else {
        echo "<h1>Empleado # ".$_POST["idempleado_deshabilitar"]." no ha podido ser deshabilitado</h1><p>Redireccionando a la página...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
    }
?>