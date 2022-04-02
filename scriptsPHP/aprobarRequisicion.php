<?php
    session_start();
    include_once '../clases/requisicion_Nicolas.php';
    include_once '../clases/aprobador.php';
    include_once '../clases/historial.php';

    $idRequisicion = $_POST["AprobarRequisicion_IdRequisicion"];
    $numeroRol = $_POST["AprobarRequisicion_Rol"];
    $rangoInferior = $_POST["AprobarRequisicion_RangoInferior"];
    $rangoSuperior = $_POST["AprobarRequisicion_RangoSuperior"];
    $detalleAprobador = $_POST["AprobarRequisicion_DetalleAprobador"];

    $requisicion_Nicolas = new requisicion_Nicolas();

    $costo = $requisicion_Nicolas -> GetCostoRequisicion($idRequisicion);

    $idDeCreador = $requisicion_Nicolas -> GetIdDeCreadorDeRequisicion($idRequisicion);

    if($numeroRol=="2"){
        $aprobador = new aprobador(); 

        $rolAprobacion = $aprobador -> DefinirRolAprobacion($costo);

        /*Toma matriz de aprobadores como resultado*/ 
        $aprobadoresMatriz = $aprobador -> GetAprobadoresEnRango($rolAprobacion);

        $aprobadoresArray = array();

        /*Introduce los aprobadores en un arreglo unidimensional/vector*/ 
        while ($row = $aprobadoresMatriz->fetch_array()){
            array_push($aprobadoresArray, $row[0]);
        }

        /*Revisa si entre los apropadores canditados está el id de empleado de la persona que creo la requisición.*/
        $coincidencia = array_search($idDeCreador, $aprobadoresArray, false);

        if ($coincidencia!=false){
            unset($aprobadoresArray[$coincidencia]);
        }

        $aprobadorFinalIndex = rand(0, sizeOf($aprobadoresArray)-1);

        $aprobadorFinal = $aprobadoresArray[$aprobadorFinalIndex];

        /*Jefe Aprobador aprueba la requisición*/ 
        $resultadoAprobacion = $requisicion_Nicolas -> AprobarRequisicion_JefeAprobador($idRequisicion, $aprobadorFinal, $detalleAprobador);

        /*Se adiciona una nueva entrada en el historial*/ 
        $historialObjeto = new historial(); 

        $resultadoAprobacion_EntradaHistorial = $historialObjeto -> adicionarEntradaHistorial('EnRevision', $idRequisicion, $aprobadorFinal);

        if ($resultadoAprobacion){
            if ($resultadoAprobacion_EntradaHistorial){
                echo "<h1>Requisición # ".$idRequisicion." ha sido preaprobada. Esta ha sido asignada al aprobador financiero".$aprobadorFinal." para evaluación final.</h1><p>Redireccionando a la página de aprobación...</p>";
                echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
            } else {
                echo "<h1>Requisición # ".$idRequisicion." ha sido preaprobada. Esta ha sido asignada al aprobador financiero".$aprobadorFinal." para evaluación final. No se ha podido introducir un registro en el historial.</h1><p>Redireccionando a la página de aprobación...</p>";
                echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
            }
        } else {
            echo "<h1>Requisición # ".$idRequisicion." no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
        }

    } elseif ($numeroRol>=3 and $numeroRol<=5){
        /*Aprobador financiero aprueba la requisición*/
        $resultadoAprobacion = $requisicion_Nicolas -> AprobarRequisicion_AprobadorFinanciero($idRequisicion, $idDeCreador, $detalleAprobador);

        /*Se adiciona una nueva entrada en el historial*/ 
        $historialObjeto = new historial(); 

        $resultadoAprobacion_EntradaHistorial = $historialObjeto -> adicionarEntradaHistorial('Aprobada', $idRequisicion, $idDeCreador);

        if ($resultadoAprobacion){
            if ($resultadoAprobacion_EntradaHistorial){
                echo "<h1>Requisición # ".$idRequisicion." ha sido aprobada por el aprobador ".$_SESSION["idusuario"]."</h1><p>Redireccionando a la página de aprobación...</p>";
                echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
            } else {
                echo "<h1>Requisición # ".$idRequisicion." ha sido aprobada por el aprobador ".$_SESSION["idusuario"].". No se ha podido ingresar una entrada en el historial</h1><p>Redireccionando a la página de aprobación...</p>";
                echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
            }
        } else {
            echo "<h1>Requisición # ".$idRequisicion." no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/porAprobar.php';}, 3000);</script>";
        }     
    }
?>