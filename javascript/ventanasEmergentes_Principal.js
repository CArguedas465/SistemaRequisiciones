var requisicionEnviada_Fila, requisicionEnviada_Columna;
var requisicionEnRevision_Fila, requisicionEnRevision_Columna;
var requisicionRechazada_Fila, requisicionRechazada_Columna;
var requisicionAprobada_Fila, requisicionAprobada_Columna;
var requisicionBusquedaEspecifica_Fila, requisicionBusquedaEspecifica_Columna;

var imagen, detalle;

var tabla = document.getElementById('tablaRequisicionesEnviadas');
asignacionEventos(tabla);
tabla = document.getElementById('tablaRequisicionesEnRevision');
asignacionEventos(tabla);
tabla = document.getElementById('tablaRequisicionesRechazadas');
asignacionEventos(tabla);
tabla = document.getElementById('tablaRequisicionesAprobadas');
asignacionEventos(tabla);
tabla = document.getElementById('tablaBusquedaEspecifica');
asignacionEventos(tabla);

function asignacionEventos(tabla){
    for (var i = 0; i < tabla.rows.length; i++) {
        for (var j=0; j<tabla.rows[i].cells.length; j++)
        {
            tabla.rows[i].cells[j].onclick = function()
            {
                switch(tabla.id){
                    case 'tablaRequisicionesEnviadas':
                        requisicionEnviada_Fila = this.parentElement.rowIndex;
                        console.log(requisicionEnviada_Fila);
                        requisicionEnviada_Columna = this.cellIndex;
                        console.log(requisicionEnviada_Columna);
                        break;
                    case 'tablaRequisicionesEnRevision':
                        requisicionEnRevision_Fila = this.parentElement.rowIndex;
                        console.log(requisicionEnRevision_Fila);
                        requisicionEnRevision_Columna = this.cellIndex;
                        console.log(requisicionEnRevision_Columna);
                        break; 
                    case 'tablaRequisicionesRechazadas':
                        requisicionRechazada_Fila = this.parentElement.rowIndex;
                        console.log(requisicionRechazada_Fila);
                        requisicionRechazada_Columna = this.cellIndex;
                        console.log(requisicionRechazada_Columna);
                        break;
                    case 'tablaRequisicionesAprobadas': 
                        requisicionAprobada_Fila = this.parentElement.rowIndex;
                        console.log(requisicionAprobada_Fila);
                        requisicionAprobada_Columna = this.cellIndex;
                        console.log(requisicionAprobada_Columna);
                        break;
                    case 'tablaBusquedaEspecifica':
                        requisicionBusquedaEspecifica_Fila = this.parentElement.rowIndex;
                        console.log(requisicionBusquedaEspecifica_Fila);
                        requisicionBusquedaEspecifica_Columna = this.cellIndex;
                        console.log(requisicionBusquedaEspecifica_Columna);
                        break;
                }
            }
        }
    }
}

function requisicionesEnviadasSeleccion(){
    if (requisicionEnviada_Columna==4){
        emergente_ImagenProducto_Abrir('tablaRequisicionesEnviadas', requisicionEnviada_Fila, requisicionEnviada_Columna);
    } else if (requisicionEnviada_Columna==5){
        emergente_DetalleProducto_Abrir('tablaRequisicionesEnviadas', requisicionEnviada_Fila, requisicionEnviada_Columna);
    }
}

function requisicionesEnRevisionSeleccion(){
    if (requisicionEnRevision_Columna==4){
        emergente_ImagenProducto_Abrir('tablaRequisicionesEnRevision', requisicionEnRevision_Fila, requisicionEnRevision_Columna);
    } else if (requisicionEnRevision_Columna==5){
        emergente_DetalleProducto_Abrir('tablaRequisicionesEnRevision', requisicionEnRevision_Fila, requisicionEnRevision_Columna);
    }
}

function requisicionesRechazadasSeleccion(){
    if (requisicionRechazada_Columna==4){
        emergente_ImagenProducto_Abrir('tablaRequisicionesRechazadas', requisicionRechazada_Fila, requisicionRechazada_Columna);
    } else if (requisicionRechazada_Columna==5){
        emergente_DetalleProducto_Abrir('tablaRequisicionesRechazadas', requisicionRechazada_Fila, requisicionRechazada_Columna);
    }
}

function requisicionesAprobadasSeleccion(){
    if (requisicionAprobada_Columna==4){
        emergente_ImagenProducto_Abrir('tablaRequisicionesAprobadas', requisicionAprobada_Fila, requisicionAprobada_Columna);
    } else if (requisicionAprobada_Columna==5){
        emergente_DetalleProducto_Abrir('tablaRequisicionesAprobadas', requisicionAprobada_Fila, requisicionAprobada_Columna);
    }
}

function requisicionesBusquedaGeneralSeleccion(){
    if (requisicionBusquedaEspecifica_Columna==4){
        emergente_ImagenProducto_Abrir('tablaBusquedaEspecifica', requisicionBusquedaEspecifica_Fila, requisicionBusquedaEspecifica_Columna);
    } else if (requisicionBusquedaEspecifica_Columna==5){
        emergente_DetalleProducto_Abrir('tablaBusquedaEspecifica', requisicionBusquedaEspecifica_Fila, requisicionBusquedaEspecifica_Columna);
    }
}

function emergente_ImagenProducto_Abrir(idTabla, fila, columna){

    var tabla = document.getElementById(idTabla);

    var espacioImagen = document.getElementById('espacioParaImagen');

    espacioImagen.innerHTML = tabla.rows.item(fila).cells.item(columna).textContent;

    var modal = document.getElementById('modalImagenPagPrincipal');
    modal.style.display = 'block';
}

function emergente_ImagenProducto_Cerrar(){
    var modal = document.getElementById('modalImagenPagPrincipal');
    modal.style.display = 'none';

}

function emergente_DetalleProducto_Abrir(idTabla, fila, columna){
    var tabla = document.getElementById(idTabla);

    var espacioDetalle = document.getElementById('espacioParaDetalle');

    espacioDetalle.value = tabla.rows.item(fila).cells.item(columna).textContent;

    var modal = document.getElementById('modalDetallePagPrincipal');
    modal.style.display = 'block';
}

function emergente_DetalleProducto_Cerrar(){
    var modal = document.getElementById('modalDetallePagPrincipal');
    modal.style.display = 'none';
}

function emergente_BusquedaEspecifica_Abrir(){
    var modal = document.getElementById('modalBusquedaEspecifica');
    modal.style.display = 'block';
}

function emergente_BusquedaEspecifica_Cerrar(){
    var modal = document.getElementById('modalBusquedaEspecifica');
    modal.style.display = 'none';
}