<?php
    include '../clases/requisicion.php';
    require_once '../servidorcorreo/PHPMailerAutoload.php';

    /*Adquisición de datos*/

    $tipoRecordatorio = $_POST["tipoRecordatorio"];
    $requisicionARecordar = $_POST["requisicionARecordar"];

    $obj_requisicion = new requisicion();

    $requisicion = $obj_requisicion -> GetRequisicion($requisicionARecordar);

    $datosRequisicion = $requisicion -> fetch_assoc();

    /*Información relevante de la requisición*/
    $encargadoDeAprobacion = $datosRequisicion["AsignadaA"];
    $solicitanteDeRequisicion = $datosRequisicion["Id_Empleado"];

    $encargadoDatosPersonales = $obj_requisicion -> GetDatos_EncargadoRequisicion($encargadoDeAprobacion);

    $datosEncargado = $encargadoDatosPersonales -> fetch_assoc();

    /*Informacion general encargado*/ 
    $correoEncargado = $datosEncargado["Correo_Electronico"];
    $nombreEncargado = $datosEncargado["Nombre"];
    $apellido1Encargado = $datosEncargado["Apellido_1"];

    /*Información del correo*/ 
    $asunto = "Notificacion de requisicion pendiente";

    if ($tipoRecordatorio=="Enviadas")
    {
        $mensaje = "Estimado jefe aprobador ".$nombreEncargado." ".$apellido1Encargado.", \n\nPor este medio se le comunica que el empleado #".$solicitanteDeRequisicion." se encuentra en espera de la resolución para la requisición #".$requisicionARecordar.". Favor acceder al sistema y revisar la solicitud a la mayor brevedad posible.";
    } 
    else
    {
        $mensaje = "Estimado aprobador financiero ".$nombreEncargado." ".$apellido1Encargado.", \n\nPor este medio se le comunica que el empleado #".$solicitanteDeRequisicion." se encuentra en espera de la resolución para la requisición #".$requisicionARecordar.". Favor acceder al sistema y revisar la solicitud a la mayor brevedad posible.";
    }

    /*Formateo del correo*/
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
    $mail -> Subject = $asunto; 
    $mail -> Body = $mensaje;
    $mail -> AddAddress($correoEncargado);

    if($mail -> Send())
    {
        echo "<h1>Se ha enviado el recordatorio al empleado #".$encargadoDeAprobacion.". Favor no enviar otro recordatorio en un mínimo de 24 horas o se podrán tomar acciones disciplinarias.</h1><p>Redireccionando a la página principal...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/paginaPrincipal.php';}, 4000);</script>";
    }
    else
    {
        echo "<h1>El recordatorio no se ha podido enviar en este momento. Favor intentar más tarde.</h1><p>Redireccionando a la página principal...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/paginaPrincipal.php';}, 4000);</script>";
    };
?>