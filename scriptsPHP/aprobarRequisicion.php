<?php
    session_start();
    include_once '../clases/requisicion_Nicolas.php';
    include_once '../clases/aprobador.php';
    include_once '../clases/historial.php';
    require_once '../servidorcorreo/PHPMailerAutoload.php';
    include_once '../clases/empleado_Carlos.php';

    $idRequisicion = $_POST["AprobarRequisicion_IdRequisicion"];
    $numeroRol = $_POST["AprobarRequisicion_Rol"];
    $rangoInferior = $_POST["AprobarRequisicion_RangoInferior"];
    $rangoSuperior = $_POST["AprobarRequisicion_RangoSuperior"];
    $detalleAprobador = $_POST["AprobarRequisicion_DetalleAprobador"];

    $requisicion_Nicolas = new requisicion_Nicolas();

    $costo = $requisicion_Nicolas -> GetCostoRequisicion($idRequisicion);

    $idDeCreador = $requisicion_Nicolas -> GetIdDeCreadorDeRequisicion($idRequisicion);

    $mail = new PHPMailer();
    $mail -> isSMTP();
    $mail -> SMTPAuth = true; 
    $mail -> SMTPSecure = 'ssl';
    $mail -> Host = 'smtp.gmail.com';
    $mail -> Port ='465'; //o 587
    $mail -> isHTML(); 
    $mail -> Username = 'requisicionesico2022@gmail.com';
    $mail -> Password = 'ulacit123...';
    $mail -> SetFrom('no-reply@requisicionesico2022.com');

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

        $mail -> Subject = 'Pre-aprobacion de requisicion #'.$idRequisicion; 
        $mail -> Body = 'Estimado Empleado, su requisicion con numero # '.$idRequisicion.' fue pre-aprobada de manera exitosa, y ha sido enviada al aprobador #'.$aprobadorFinal.' para su aprobacion final. Favor estar al tanto de las notificaciones por correo sobre los cambios de estado de su requisición. \n\n Si quisiera acceder directamente al sistema para revisar el estado y detalles, <a href="http://localhost/SistemaRequisiciones/html/login.html">hacer click aquí<a/>.';

        $empleado = new empleado_Carlos(); 
        $correocreador = $empleado -> GetCorreoEmpleado($idDeCreador);
        $mail -> AddAddress($correocreador);
        $mail -> Send();

        $mail -> Subject = 'Asignacion de requisicion #'.$idRequisicion; 
        $mail -> Body = 'Estimado Aprobador Financiero, la requisicion con numero # '.$idRequisicion.' ha sido asignada a su persona para aprobacion final. Favor ingresar al sistema y gestionar la requisición nombrada a la brevedad posible. Si desea ingresar ahora, <a href="http://localhost/SistemaRequisiciones/html/login.html">hacer click aquí<a/>.';
        
        $correoAprobadorFinal = $empleado -> GetCorreoEmpleado($aprobadorFinal);
        $mail -> clearAllRecipients();
        $mail -> AddAddress($correoAprobadorFinal);
        $mail -> Send();

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

        $mail -> Subject = 'Aprobación de la requisición #'.$idRequisicion; 
        $mail -> Body = 'Estimado Empleado, su requisicion con numero # '.$idRequisicion.' fue aprobada de manera exitosa. En caso de que necesite mas detalles, estos pueden ser consultados en la pagina del sistema de requisiciones en el espacio de "Detalle" de la requisición bajo "Requisiciones Aprobadas". De querer ingresar a revisar en este momento, <a href="http://localhost/SistemaRequisiciones/html/login.html">haga click aquí<a/>.';
        $empleado = new empleado_Carlos(); 

        $correocreador = $empleado -> GetCorreoEmpleado($idDeCreador);

        $mail -> clearAllRecipients();
        $mail -> AddAddress($correocreador);

        $mail -> Send();

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