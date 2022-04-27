<?php
    include '../clases/requisicion_Nicolas.php';
    include '../clases/historial.php';

    $fechaSolicitud = $_POST["CrearRequisicion_FechaSolicitud"];
    $empleadoCreador = $_POST["CrearRequisicion_EmpleadoCreador"];
    $jefeDirecto = $_POST["CrearRequisicion_JefeDirecto"];
    $nombreProducto = $_POST["CrearRequisicion_NombreProducto"];
    $costoAproximado = $_POST["CrearRequisicion_CostoAproximado"];
    $detalleEmpleado = $_POST["CrearRequisicion_DetalleEmpleado"];

    $requisicion = new requisicion_Nicolas();

    $idRequisicion = $requisicion -> GenerarIdRequisicion();

    /*Se crea requisición.*/ 
    $resultadoCreacionRequisicion = $requisicion -> CrearRequisicion($idRequisicion, $fechaSolicitud, $nombreProducto, $costoAproximado, $empleadoCreador, $detalleEmpleado, $jefeDirecto); 

    /*Se crea entrada en el historial*/ 
    $historialObjeto = new historial(); 
    $resultadoCrearEntradaHistorial = $historialObjeto -> adicionarEntradaHistorial('Enviada', $idRequisicion, $jefeDirecto);

    if ($resultadoCreacionRequisicion){
        if ($resultadoCrearEntradaHistorial){
            echo "<h1>Requisición # ".$idRequisicion." ha sido enviada al jefe aprobador".$jefeDirecto." para revisión.</h1><p>Redireccionando a la página de crear requisición...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/nuevaRequisicion.php';}, 3000);</script>";
        } else {
            echo "<h1>Requisición # ".$idRequisicion." ha sido enviada al jefe aprobador".$jefeDirecto." para revisión. No se ha podido introducir un registro en el historial.</h1><p>Redireccionando a la página de crear requisición...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/nuevaRequisicion.php';}, 3000);</script>";
        }
    } else {
        echo "<h1>Nueva requisición no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de crear requisición...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
    }

    
?>