<?php

    include_once '../clases/empleado_Carlos.php';
    include_once '../servidorcorreo/PHPMailerAutoload.php';
    include_once '../clases/requisicion.php';

    $tipoReporte = $_POST["TipoReporte"];
    $rangoReporte = $_POST["rangoReporte"];
    $idusuario = $_POST["usuario"];

    $mail = new PHPMailer();

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

    if ($tipoReporte==='Enviada')
    {
        $mail -> Subject = 'Reporte de solicitudes recibidas en los ultimos '.$rangoReporte.' meses.';
        $mensaje = '<h1>Reporte de solicitudes recibidas en los ultimos '.$rangoReporte.' meses para el aprobador número '.$idusuario.'</h1>
                    <p>A continuación se muestra el reporte de requisiciones según el filtro solicitado: </p>
                    <table>
                        <thead>
                            <th>IdRequisicion</th>
                            <th>FechaSolicitud</th>
                            <th>Producto</th>
                            <th>Costo</th>
                            <th>Imagen</th>
                            <th>Detalle</th>
                        </thead>
                        <tbody>';

        $requisicion = new requisicion(); 

        $resultado = $requisicion -> GetRequisicionPorRangoDeFechas_YTipoDeReporte($rangoReporte, $tipoReporte);

        while ($row = $resultado -> fetch_assoc())
        {
            $mensaje .= 
            '<tr>
                <td>'.$row["IdRequisicion"].'</td>
                <td>'.$row["Fecha_Solicitud"].'</td>
                <td>'.$row["Producto"].'</td>
                <td>'.$row["Costo"].'</td>
                <td>'.$row["Imagen"].'</td>
                <td>'.$row["Detalle"].'</td>
            </tr>';
        }

        $mensaje .= '</tbody></table>';

        $mail -> Body = $mensaje;

        $empleado = new empleado_Carlos();

        $correoEmpleado = $empleado -> GetCorreoEmpleado($idusuario);

        $mail -> AddAddress($correoEmpleado);
        
    }
    else if ($tipoReporte==='Aprobada')
    {
        $mail -> Subject = 'Reporte de solicitudes aprobadas en los ultimos '.$rangoReporte.' meses.';
        $mensaje = '<h1>Reporte de solicitudes aprobadas en los ultimos '.$rangoReporte.' meses para el aprobador número '.$idusuario.'</h1>
                    <p>A continuación se muestra el reporte de requisiciones según el filtro solicitado: </p>
                    <table>
                        <thead>
                            <th>IdRequisicion</th>
                            <th>FechaSolicitud</th>
                            <th>Producto</th>
                            <th>Costo</th>
                            <th>Imagen</th>
                            <th>Detalle</th>
                        </thead>
                        <tbody>';

        $requisicion = new requisicion(); 

        $resultado = $requisicion -> GetRequisicionPorRangoDeFechas_YTipoDeReporte($rangoReporte, $tipoReporte);

        while ($row = $resultado -> fetch_assoc())
        {
            $mensaje .= 
            '<tr>
                <td>'.$row["IdRequisicion"].'</td>
                <td>'.$row["Fecha_Solicitud"].'</td>
                <td>'.$row["Producto"].'</td>
                <td>'.$row["Costo"].'</td>
                <td>'.$row["Imagen"].'</td>
                <td>'.$row["Detalle"].'</td>
            </tr>';
        }

        $mensaje .= '</tbody></table>';

        $mail -> Body = $mensaje;

        $empleado = new empleado_Carlos();

        $correoEmpleado = $empleado -> GetCorreoEmpleado($idusuario);

        $mail -> AddAddress($correoEmpleado);

    }
    else //tipoReporte = 'rechazadas'
    {
        $mail -> Subject = 'Reporte de solicitudes rechazadas en los ultimos '.$rangoReporte.' meses.';

        $mensaje = '<h1>Reporte de solicitudes rechazadas en los ultimos '.$rangoReporte.' meses para el aprobador número '.$idusuario.'</h1>
                    <p>A continuación se muestra el reporte de requisiciones según el filtro solicitado: </p>
                    <table>
                        <thead>
                            <th>IdRequisicion</th>
                            <th>FechaSolicitud</th>
                            <th>Producto</th>
                            <th>Costo</th>
                            <th>Imagen</th>
                            <th>Detalle</th>
                        </thead>
                        <tbody>';

        $requisicion = new requisicion(); 

        $resultado = $requisicion -> GetRequisicionPorRangoDeFechas_YTipoDeReporte($rangoReporte, $tipoReporte);

        while ($row = $resultado -> fetch_assoc())
        {
            $mensaje .= 
            '<tr>
                <td>'.$row["IdRequisicion"].'</td>
                <td>'.$row["Fecha_Solicitud"].'</td>
                <td>'.$row["Producto"].'</td>
                <td>'.$row["Costo"].'</td>
                <td>'.$row["Imagen"].'</td>
                <td>'.$row["Detalle"].'</td>
            </tr>';
        }

        $mensaje .= '</tbody></table>';

        $mail -> Body = $mensaje;

        $empleado = new empleado_Carlos();

        $correoEmpleado = $empleado -> GetCorreoEmpleado($idusuario);

        $mail -> AddAddress($correoEmpleado);

    }

    if ($mail -> Send())
    {
        echo "<h1>Reporte generado satisfactoriamente. Favor revisar el correo.</h1><p>Redireccionando a la página de reportes...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/reportes.php';}, 5000);</script>";
    }
    else
    {
        echo "<h1>El reporte no ha podido ser generado en este momento. Favor intentar más tarde.</h1><p>Redireccionando a la página de reportes...</p>";
        echo "<script>window.setTimeout(function() {window.location.href = '../html/reportes.php';}, 5000);</script>";
    }

?>