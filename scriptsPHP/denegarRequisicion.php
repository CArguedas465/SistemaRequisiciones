<?php
    include_once '../clases/requisicion_Nicolas.php';
    include_once '../clases/historial.php';
    require_once '../servidorcorreo/PHPMailerAutoload.php';
    include_once '../clases/empleado_Carlos.php';



    session_start();
    $idrequisicion = $_POST["DenegarRequisicion_IdRequisicion"];
    $detalleAprobador = $_POST["DenegarRequisicion_DetalleAprobador"];

    $requisicion = new requisicion_Nicolas();

    $idDeCreador = $requisicion -> GetIdDeCreadorDeRequisicion($idrequisicion);

    /*Se deniega la solicitud.*/ 
    $resultadoDenegacion = $requisicion -> DenegarRequisicion($idrequisicion, $_SESSION["idusuario"], $idDeCreador, $detalleAprobador);

    /*Correo de denegación*/ 
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

    $mail -> Subject = 'Rechazo de requisicion #'.$idrequisicion; 
    $mail -> Body = 'Estimado Empleado, su requisicion con numero # '.$idrequisicion.' ha sido rechazada. En caso de que necesite mas detalles, estos pueden ser consultados en la pagina del sistema de requisiciones en el espacio de "Detalle" de la requisición bajo "Requisiciones Rechazadas". De querer ingresar a revisar en este momento, <a href="http://localhost/SistemaRequisiciones/html/login.html">haga click aquí<a/>.';

    $empleado = new empleado_Carlos(); 
    $correocreador = $empleado -> GetCorreoEmpleado($idDeCreador);
    $mail -> AddAddress($correocreador);
    $mail -> Send();

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