var rIndex;

var tabla = document.getElementById('tablaRequisicionesPorAprobar');

for (var i = 0; i < tabla.rows.length; i++)
    {
        tabla.rows[i].onclick = function()
        {
            rIndex = this.rowIndex;
            console.log(rIndex);
            leerFila();
        }
    }

var numero, fecha, empleado, producto, costo, imagen, detalle;

function leerFila(){
    
    var coleccion = tabla.getElementsByTagName("tr");

    numero = coleccion.item(rIndex).cells.item(0).textContent;
    fecha = coleccion.item(rIndex).cells.item(1).textContent;
    empleado = coleccion.item(rIndex).cells.item(6).textContent;
    producto = coleccion.item(rIndex).cells.item(2).textContent;
    costo = coleccion.item(rIndex).cells.item(3).textContent;
    imagen = coleccion.item(rIndex).cells.item(5).textContent;
    detalle = coleccion.item(rIndex).cells.item(7).textContent;

    document.getElementById('tituloNumeroRequisicion').innerText = "Requisición # " + numero;
    document.getElementById('fecha').value = fecha;
    document.getElementById('empleado').value = empleado;
    document.getElementById('producto').value = producto;
    document.getElementById('costo').value = costo;
    document.getElementById('detalleEmpleado').value = detalle;

    emergente_Requisicion_Abrir();

}

/*Ventanas Emergentes*/ 

function emergente_Requisicion_Abrir(){

    var modal = document.getElementById('modalRequisicion');
    modal.style.display = 'block'; 
}

function emergente_Requisicion_Cerrar(){
    var modal = document.getElementById('modalRequisicion');
    modal.style.display = 'none'; 
}

function emergente_AprobarRequisicion_Confirmacion_Abrir(){
    
    var modal = document.getElementById('modalAprobarRequisicion_Confirmacion');
    modal.style.display = 'block';
    document.getElementById('AprobarRequisicion_DetalleAprobador').value = document.getElementById('detalleAprobador').value;;
    document.getElementById('AprobarRequisicion_IdRequisicion').value=numero;
    document.getElementById('numeroRequisicionConfirmacion').innerHTML = "¿Desea aprobar la solicitud número " +  numero + "?";
}

function emergente_AprobarRequisicion_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalAprobarRequisicion_Confirmacion');
    modal.style.display = 'none';
}

function emergente_AprobarRequisicion_ConfirmacionFinal_Abrir(){

    emergente_Requisicion_Cerrar();
    emergente_AprobarRequisicion_Confirmacion_Cerrar();

    var modal = document.getElementById('modalAprobarRequisicion_ConfirmacionFinal');
    modal.style.display = 'block';

    document.getElementById('confirmacionFinalNumeroRequisicion').innerHTML = "Requisición "+ numero + " del empleado " + empleado + " ha sido aprobada.";
}

function emergente_AprobarRequisicion_ConfirmacionFinal_Cerrar(){
    var modal = document.getElementById('modalAprobarRequisicion_ConfirmacionFinal');
    modal.style.display = 'none';
}

/*-----------*/ 

function emergente_DenegarRequisicion_Confirmacion_Abrir(){

    var modal = document.getElementById('modalDenegarRequisicion_Confirmacion');
    modal.style.display = 'block';

    document.getElementById('DenegarRequisicion_IdRequisicion').value = numero;
    document.getElementById('DenegarRequisicion_DetalleAprobador').value = document.getElementById('detalleAprobador').value;
    document.getElementById('numeroRequisicionDenegacion').innerHTML = "¿Desea denegar la solicitud número " +  numero + "?";
}

function emergente_DenegarRequisicion_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalDenegarRequisicion_Confirmacion');
    modal.style.display = 'none';
}

function emergente_DenegarRequisicion_ConfirmacionFinal_Abrir(){

    emergente_Requisicion_Cerrar();
    emergente_DenegarRequisicion_Confirmacion_Cerrar();

    var modal = document.getElementById('modalDenegarRequisicion_ConfirmacionFinal');
    modal.style.display = 'block';

    document.getElementById('DenegacionFinalNumeroRequisicion').innerHTML = "Requisición "+ numero + " del empleado " + empleado + " ha sido denegada.";
}

function emergente_DenegarRequisicion_ConfirmacionFinal_Cerrar(){
    var modal = document.getElementById('modalDenegarRequisicion_ConfirmacionFinal');
    modal.style.display = 'none';
}

function emergente_ImagenProducto_Abrir(){

    var imagen = tabla.rows.item(rIndex).cells.item(5).innerHTML;

    document.getElementById('espacioParaImagen').innerHTML = imagen.replace('<img height="100px" width="100px"', '<img height="600px" width="600px"');

    var modal = document.getElementById('modalImagenRequisicion');
    modal.style.display = 'block';
}

function emergente_ImagenProducto_Cerrar(){
    var modal = document.getElementById('modalImagenRequisicion');
    modal.style.display = 'none';
}