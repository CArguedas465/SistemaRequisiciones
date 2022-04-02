<?php
    session_start();
    include '../clases/requisicion_Nicolas.php';
    include '../clases/aprobador.php';
    include '../clases/historial.php';

    $idRequisicion = $_POST["AprobarRequisicion_IdRequisicion"];
    $numeroRol = $_POST["AprobarRequisicion_Rol"];
    $rangoInferior = $_POST["AprobarRequisicion_RangoInferior"];
    $rangoSuperior = $_POST["AprobarRequisicion_RangoSuperior"];

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

        $aprobadorFinalIndex = rand(0, sizeOf($aprobadoresArray-1));

        $aprobadorFinal = $aprobadoresArray[$aprobadorFinalIndex];

        /*Jefe Aprobador aprueba la requisición*/ 
        $resultadoAprobacion = $requisicion_Nicolas -> AprobarRequisicion_JefeAprobador($idRequisicion, $aprobadorFinal);

        /*Se adiciona una nueva entrada en el historial*/ 
        $historialObjeto = new historial(); 

        $historialObjeto -> adicionarEntradaHistorial('EnRevision', $idRequisicion, $aprobadorFinal);

        if ($resultadoAprobacion){
            echo "<h1>Requisición # ".$idRequisicion." ha sido preaprobada. Esta ha sido asignada al aprobador financiero".$aprobadorFinal." para evaluación final.</h1><p>Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
        } else {
            echo "<h1>Requisición # ".$idRequisicion." no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de aprobación...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
        }

    }


?>