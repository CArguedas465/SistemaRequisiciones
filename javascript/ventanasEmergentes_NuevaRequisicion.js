function emergente_RealizarSolicitud_Confirmacion_Abrir(){
    var modal = document.getElementById('modalEnviarRequisicion_Confirmacion');
    modal.style.display = 'block';
}

function emergente_RealizarSolicitud_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalEnviarRequisicion_Confirmacion');
    modal.style.display = 'none';
}

function emergente_RealizarSolicitud_ConfirmacionFinal_Abrir(){

    emergente_RealizarSolicitud_Confirmacion_Cerrar();

    var modal = document.getElementById('modalEnviarRequisicion_ConfirmacionFinal');
    modal.style.display = 'block';
}

function emergente_RealizarSolicitud_ConfirmacionFinal_Cerrar(){
    var modal = document.getElementById('modalEnviarRequisicion_ConfirmacionFinal');
    modal.style.display = 'none';
}