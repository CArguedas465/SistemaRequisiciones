var activoSeleccionado = 0, inactivoSeleccionado = 0;
var activosSeleccionPrevia = 0, inactivosSeleccionPrevia = 0;

var tabla = document.getElementById('tablaEmpleadosActivos');

for (var i = 0; i < tabla.rows.length; i++)
    {
        tabla.rows[i].onclick = function()
        {
            activoSeleccionado = this.rowIndex;
            console.log(activoSeleccionado);
        }
    }

var tabla2 = document.getElementById('tablaEmpleadosInactivos');

for (var i = 0; i < tabla2.rows.length; i++)
    {
        tabla2.rows[i].onclick = function()
        {
            inactivoSeleccionado = this.rowIndex;
            console.log(inactivoSeleccionado);
        }
    }

function evidenciarSeleccionActivos(){
    var tabla = document.getElementById('tablaEmpleadosActivos');
    if (activosSeleccionPrevia == 0){
        tabla.rows.item(activoSeleccionado).style.backgroundColor = "#fcfcfc";
        tabla.rows.item(activoSeleccionado).style.color = "#black";
        activosSeleccionPrevia = activoSeleccionado;
    }

    if (activosSeleccionPrevia!=activoSeleccionado){
        tabla.rows.item(activosSeleccionPrevia).style.backgroundColor = "#b4b4b4";
        tabla.rows.item(activoSeleccionado).style.backgroundColor = "#fcfcfc";
        tabla.rows.item(activoSeleccionado).style.color = "#black";
        activosSeleccionPrevia = activoSeleccionado;
    }
}

function evidenciarSeleccionInactivos(){
    var tabla = document.getElementById('tablaEmpleadosInactivos');
    if (inactivosSeleccionPrevia == 0){
        tabla.rows.item(inactivoSeleccionado).style.backgroundColor = "#fcfcfc";
        tabla.rows.item(inactivoSeleccionado).style.color = "#black";
        inactivosSeleccionPrevia = inactivoSeleccionado;
    }

    if (inactivosSeleccionPrevia!=inactivoSeleccionado){
        tabla.rows.item(inactivosSeleccionPrevia).style.backgroundColor = "#b4b4b4";
        tabla.rows.item(inactivoSeleccionado).style.backgroundColor = "#fcfcfc";
        tabla.rows.item(inactivoSeleccionado).style.color = "#black";
        inactivosSeleccionPrevia = inactivoSeleccionado;
    }
}

/*Preconfirmación de Agregar Empleado*/

function emergente_AgregarEmpleado_Confirmacion_Abrir(){

    if (document.getElementById('cedula').value=="" ||
        document.getElementById('nombre').value=="" ||
        document.getElementById('apellido1').value=="" ||
        document.getElementById('email').value=="" ||
        document.getElementById('rol').value=="N/A" ||
        document.getElementById('jefe').value=="N/A"){
            alert("Debe llenar todos los campos solicitados.");
    } else {
        if(!Number.isInteger(Number.parseInt(document.getElementById('cedula').value))){
            alert("La cédula debe ser un valor numérico.")
            return;
        }
        
        document.getElementById('nombreEmpleadoConfirmacion').innerHTML = "¿Seguro que desea adicionar al empleado "+document.getElementById('nombre').value+" "+ document.getElementById('apellido1').value+" al sistema?";

        document.getElementById('agregarEmpleado_cedula').value = document.getElementById('cedula').value;
        document.getElementById('agregarEmpleado_nombre').value = document.getElementById('nombre').value;
        document.getElementById('agregarEmpleado_apellido1').value = document.getElementById('apellido1').value;
        document.getElementById('agregarEmpleado_apellido2').value = document.getElementById('apellido2').value;
        document.getElementById('agregarEmpleado_correo').value = document.getElementById('email').value; 
        document.getElementById('agregarEmpleado_rol').value = document.getElementById('rol').value;
        document.getElementById('agregarEmpleado_jefe').value = document.getElementById('jefe').value;

        var modal = document.getElementById('modalAgregarEmpleado_Confirmacion');
        modal.style.display = 'block';
    }
}

function emergente_AgregarEmpleado_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalAgregarEmpleado_Confirmacion');
    modal.style.display = 'none';
}

/*Confirmación Final de Agregar Empleado*/

function emergente_AgregarEmpleado_ConfirmacionFinal_Abrir(){
    emergente_AgregarEmpleado_Confirmacion_Cerrar();
    var modal = document.getElementById('modalAgregarEmpleado_ConfirmacionFinal');
    modal.style.display = 'block';
}

function emergente_AgregarEmpleado_ConfirmacionFinal_Cerrar(){
    var modal = document.getElementById('modalAgregarEmpleado_ConfirmacionFinal');
    modal.style.display = 'none';
}

/*Preconfirmación de Habilitar Empleado*/

function emergente_HabilitarEmpleado_Confirmacion_Abrir(){

    if (inactivoSeleccionado==0){
        alert("Debe seleccionar a un empleado de la tabla.")
        return;
    }

    var tabla = document.getElementById('tablaEmpleadosInactivos');

    var coleccion = tabla.rows;

    document.getElementById('numeroEmpleadoConfirmacion_Habilitar').innerHTML = "¿Habilitar empleado "+coleccion.item(inactivoSeleccionado).cells.item(0).textContent+"?";
    document.getElementById('idempleado_habilitar').value = coleccion.item(inactivoSeleccionado).cells.item(0).textContent;

    var modal = document.getElementById('modalHabilitarEmpleado_Confirmacion');
    modal.style.display = 'block';
}

function emergente_HabilitarEmpleado_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalHabilitarEmpleado_Confirmacion');
    modal.style.display = 'none';
}

/*Preconfirmación de Deshabilitar Empleado*/

function emergente_DeshabilitarEmpleado_Confirmacion_Abrir(){

    if (activoSeleccionado==0){
        alert("Debe seleccionar a un empleado de la tabla.")
        return;
    }

    var tabla = document.getElementById('tablaEmpleadosActivos');

    var coleccion = tabla.rows;

    document.getElementById('numeroEmpleadoConfirmacion_Deshabilitar').innerHTML = "¿Deshabilitar empleado "+coleccion.item(activoSeleccionado).cells.item(0).textContent+"?";
    document.getElementById('idempleado_deshabilitar').value = coleccion.item(activoSeleccionado).cells.item(0).textContent;

    var modal = document.getElementById('modalDeshabilitarEmpleado_Confirmacion');
    modal.style.display = 'block';
}

function emergente_DeshabilitarEmpleado_Confirmacion_Cerrar(){
    var modal = document.getElementById('modalDeshabilitarEmpleado_Confirmacion');
    modal.style.display = 'none';
}