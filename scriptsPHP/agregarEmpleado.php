<?php
    include '../clases/empleado.php';
        $empleado = new empleado();

        $generarIdEmpleadoNuevo = $empleado -> ComprobacionNuevoIdEmpleado();

        $varIdEmpleado_EmpleadoNuevo = $generarIdEmpleadoNuevo;
        $varCedula_EmpleadoNuevo = $_POST["agregarEmpleado_cedula"];
        $varNombre_EmpleadoNuevo = $_POST["agregarEmpleado_nombre"];
        $varPrimerApellido_EmpleadoNuevo = $_POST["agregarEmpleado_apellido1"];
        $varSegundoApellido_EmpleadoNuevo = $_POST["agregarEmpleado_apellido2"];
        $varCorreoElectronico_EmpleadoNuevo = $_POST["agregarEmpleado_correo"];
        $varRol_EmpleadoNuevo = $_POST["agregarEmpleado_rol"];
        $varIdusuario_EmpleadoNuevo = "ID_Transitivo_No_Valido";
        $varContrasenna_EmpleadoNuevo = "ulacit123...";
        $varJefe_EmpleadoNuevo = $_POST["agregarEmpleado_jefe"];
        $varEstado_EmpleadoNuevo = 1;

        $ingresarNuevoEmpleado = $empleado -> AgregarNuevoEmpleado($varIdEmpleado_EmpleadoNuevo, 
        $varCedula_EmpleadoNuevo,
        $varNombre_EmpleadoNuevo, 
        $varPrimerApellido_EmpleadoNuevo, 
        $varSegundoApellido_EmpleadoNuevo,
        $varCorreoElectronico_EmpleadoNuevo, 
        $varRol_EmpleadoNuevo, 
        $varIdusuario_EmpleadoNuevo,
        $varContrasenna_EmpleadoNuevo,
        $varJefe_EmpleadoNuevo, 
        $varEstado_EmpleadoNuevo);

        $generarIdUsuario = $empleado -> CrearIdUsuario($varIdEmpleado_EmpleadoNuevo);


        if ($ingresarNuevoEmpleado){

            if ($generarIdUsuario){
                echo "<h1>Empleado número ".$varIdEmpleado_EmpleadoNuevo." ha sido sido ingresado al sistema correctamente.</h1><p>Redireccionando a la página de administración...</p>";
                //echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
            } else {
                echo "<h1>Empleado número ".$varIdEmpleado_EmpleadoNuevo." ha sido sido ingresado al sistema correctamente, pero no se generó el ID Usuario.</h1><p>Redireccionando a la página de administración...</p>";
                //echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
            }
        } else {
            echo "<h1>Empleado número ".$varIdEmpleado_EmpleadoNuevo." no ha podido ser adicionado. Intentar más tarde. Redireccionando a la página de administración...</p>";
            //echo "<script>window.setTimeout(function() {window.location.href = '../html/admin.php';}, 3000);</script>";
        }
?>      