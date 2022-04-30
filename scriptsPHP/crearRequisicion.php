<?php
    include '../clases/requisicion_Nicolas.php';
    include '../clases/historial.php';
    include_once '../clases/empleado_Carlos.php';
    require_once '../servidorcorreo/PHPMailerAutoload.php';
    error_reporting(0);

    $fechaSolicitud = $_POST["fecha"];
    $empleadoCreador = $_POST["idempleado"];
    $jefeDirecto = $_POST["jefe"];
    $nombreProducto = $_POST["producto"];
    $costoAproximado = $_POST["costo"];
    $detalleEmpleado = $_POST["detalle"];

    $imagen = '';

    if ($_FILES["imagen"]["type"]==="")
    {
        $imagen = addslashes(file_get_contents('../imagenes/sinimagen.png'));
    }
    else
    {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    }
    
    $requisicion = new requisicion_Nicolas();
    

    $idRequisicion = $requisicion -> GenerarIdRequisicion();

    /*Se crea requisición.*/ 
    $resultadoCreacionRequisicion = $requisicion -> CrearRequisicion($idRequisicion, $fechaSolicitud, $nombreProducto, $costoAproximado, $empleadoCreador, $detalleEmpleado, $jefeDirecto, $imagen); 

    /*Se crea entrada en el historial*/ 
    $historialObjeto = new historial(); 
    $resultadoCrearEntradaHistorial = $historialObjeto -> adicionarEntradaHistorial('Enviada', $idRequisicion, $jefeDirecto);

    if ($resultadoCreacionRequisicion){

        /*Se le envía correo al creador de la requisición.*/ 
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
        $mail -> Subject = 'Creacion de requisicion #'.$idRequisicion; 
        $mail -> Body = 'Estimado empleado, su requisición de número '.$idRequisicion.' ha sido creada con éxito, y ha sido enviada a su respectivo jefe aprobador. Favor estar al tanto de las notificaciones por correo sobre los cambios de estado de su requisición. Si quisiera acceder directamente al sistema para revisar el estado y detalles, <a href="http://localhost/SistemaRequisiciones/html/login.html">hacer click aquí<a/>';
        $empleado = new empleado_Carlos(); 

        $correoCreador = $empleado -> GetCorreoEmpleado($empleadoCreador);

        $mail -> AddAddress($correoCreador);

        $mail -> Send();

        /*Se le envía correo al jefe aprobador*/ 
        $mail -> Subject = 'Creacion de requisicion #'.$idRequisicion; 
        $mail -> Body = 'Estimado jefe aprobador, el empleado #'.$empleadoCreador.' ha creado la requisicion con #'.$idRequisicion.' para que sea revisada por su persona. Favor ingresar al sistema a la brevedad posible para evaluar la solicitud. Si quisiera acceder directamente al sistema para revisar el estado y detalles, <a href="http://localhost/SistemaRequisiciones/html/login.html">hacer click aquí<a/>';

        $correoAprobador = $empleado -> GetCorreoEmpleado($jefeDirecto);

        $mail -> clearAllRecipients();
        $mail -> AddAddress($correoAprobador);

        $mail -> Send();

        if ($resultadoCrearEntradaHistorial){
            echo "<h1>Requisición # ".$idRequisicion." ha sido enviada al jefe aprobador ".$jefeDirecto." para revisión.</h1><p>Redireccionando a la página de crear requisición...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/nuevaRequisicion.php';}, 3000);</script>";
        } else {
            echo "<h1>Requisición # ".$idRequisicion." ha sido enviada al jefe aprobador ".$jefeDirecto." para revisión. No se ha podido introducir un registro en el historial.</h1><p>Redireccionando a la página de crear requisición...</p>";
            echo "<script>window.setTimeout(function() {window.location.href = '../html/nuevaRequisicion.php';}, 3000);</script>";
        }
    } else {
        echo "<h1>Nueva requisición no ha podido ser procesada. Intentar más tarde. Redireccionando a la página de crear requisición...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/nuevaRequisicion.php';}, 3000);</script>";
    }
?>