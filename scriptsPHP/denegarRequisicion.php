<?php
    include_once '../clases/requisicion_Nicolas.php';
    include_once '../clases/historial.php';

    session_start();
    $idrequisicion = $_POST["DenegarRequisicion_IdRequisicion"];
    $detalleAprobador = $_POST["DenegarRequisicion_DetalleAprobador"];

    $requisicion = new requisicion_Nicolas();

    $idDeCreador = $requisicion -> GetIdDeCreadorDeRequisicion($idrequisicion);

    /*Se deniega la solicitud.*/ 
    $resultadoDenegacion = $requisicion -> DenegarRequisicion($idrequisicion, $_SESSION["idusuario"], $idDeCreador, $detalleAprobador);

    /*Se crea una entrada en el historial*/

    $historialObjeto = new historial(); 

    $resultadoDenegacion_EntradaHistorial = $historialObjeto -> adicionarEntradaHistorial('Rechazada', $idrequisicion, $idDeCreador);

    if ($resultadoDenegacion){
        if ($resultadoDenegacion_EntradaHistorial){
            echo "<h1>Requisición # ".$idrequisicion." ha sido denegada por ".$_SESSION["idusuario"]."</h1><p>Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
        } else {
            echo "<h1>Requisición # ".$idrequisicion." ha sido denegada por ".$_SESSION["idusuario"].". No se ha podido introducir un registro en el historial.</h1><p>Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
        }
    } else {
        echo "<h1>Requisición # ".$idrequisicion." no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de aprobación...</p>";
        echo $resultadoDenegacion->error;
        echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
    }


?>