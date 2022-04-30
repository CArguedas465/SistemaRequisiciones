function validacionRequisicion()
{
    var fechaCampo = document.getElementById('fecha');
    var empleadoCreadorCampo = document.getElementById('idempleado');
    var jefeDirectoCampo = document.getElementById('jefe');
    var nombreProductoCampo = document.getElementById('producto');
    var costoCampo = document.getElementById('costo');
    var detalleCampo = document.getElementById('detalle');

    if(nombreProductoCampo.value==""||
    costoCampo.value=="")
    {
        alert("Debe llenar todos los campos obligatorios (Nombre del producto y costo aproximado)");
        return;
    }

    if (Number.isNaN(Number.parseFloat(costoCampo.value))){
        alert("El costo aproximado debe ser un valor numérico.");
        return;
    }

    if (costoCampo.value.length > 9){
        alert("El costo aproximado no puede exceder los nueve dígitos (máximo 100,000,000).");
        return;
    }

    if (Number.parseFloat(costoCampo.value)==0){
        alert("El costo aproximado no puede ser cero.");
        return;
    }

    if (Number.parseFloat(costoCampo.value) > 100000000){
        alert("El costo aproximado no puede exceder cien millones");
        return;
    }

    if (Number.parseFloat(costoCampo.value) < 0){
        alert("El costo no puede ser un número negativo.");
        return;
    }

    if (nombreProductoCampo.value.length > 50){
        alert("El largo del nombre del producto no puede exceder los 50 caracteres.");
        return;
    }

    var form = document.getElementById('formularioCreacionRequisicion'); 
    form.submit();
}

function emergente_RealizarSolicitud_Confirmacion_Abrir(){

    var fechaCampo = document.getElementById('fecha');
    var empleadoCreadorCampo = document.getElementById('idempleado');
    var jefeDirectoCampo = document.getElementById('jefe');
    var nombreProductoCampo = document.getElementById('producto');
    var costoCampo = document.getElementById('costo');
    var detalleCampo = document.getElementById('detalle');

    if (nombreProductoCampo.value==""||
        costoCampo.value=="")
    {
        alert("Debe llenar todos los campos obligatorios (Nombre del producto y costo aproximado)");
    } else 
    {
        if (Number.isNaN(Number.parseFloat(costoCampo.value))){
            alert("El costo aproximado debe ser un valor numérico.");
            return;
        }

        if (costoCampo.value.length > 9){
            alert("El costo aproximado no puede exceder los nueve dígitos (máximo 100,000,000).");
            return;
        }

        if (Number.parseFloat(costoCampo.value) > 100000000){
            alert("El costo aproximado no puede exceder cien millones");
            return;
        }

        if (Number.parseFloat(costoCampo.value) < 0){
            alert("El costo no puede ser un número negativo.");
            return;
        }

        if (nombreProductoCampo.value.length > 50){
            alert("El largo del nombre del producto no puede exceder los 50 caracteres.");
            return;
        }
         
    
        var fecha = document.getElementById('fecha').value;
        var empleadoCreador = document.getElementById('idempleado').value;
        var jefeDirecto = document.getElementById('jefe').value;
        var nombreProducto = document.getElementById('producto').value;
        var costo = document.getElementById('costo').value;
        var detalle = document.getElementById('detalle').value;
        var imagen = document.getElementById('imagen').file;

        document.getElementById('CrearRequisicion_FechaSolicitud').value = fecha;
        document.getElementById('CrearRequisicion_EmpleadoCreador').value = empleadoCreador;
        document.getElementById('CrearRequisicion_JefeDirecto').value = jefeDirecto;
        document.getElementById('CrearRequisicion_NombreProducto').value = nombreProducto;
        document.getElementById('CrearRequisicion_CostoAproximado').value = costo;
        document.getElementById('CrearRequisicion_DetalleEmpleado').value = detalle;
        document.getElementById('CrearRequisicion_Imagen').file = imagen;

        var modal = document.getElementById('modalEnviarRequisicion_Confirmacion');
        modal.style.display = 'block';
    }

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
