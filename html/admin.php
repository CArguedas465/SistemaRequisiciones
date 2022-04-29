<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="../css/StyleMain.css">
    <link rel="stylesheet" href="../css/StyleAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div id="imagenUsuario">
            <img src="../imagenes/stockPerson.jpg" height="100px" width="100px">
        </div>
        <p>Bienvenido</p>
        <?php
            $sql = "SELECT CONCAT(Nombre, ' ', Apellido_1, ' ', Apellido_2) AS Employee FROM Empleado WHERE IdUsuario = '".$_SESSION["username"]."';";
            $conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
            $resultado = $conexion -> query($sql);

            $array = $resultado -> fetch_assoc();
            
            echo '<p>'.$array["Employee"].'</p>';

            $consultaRol = "SELECT Rol FROM Empleado WHERE IdUsuario = '".$_SESSION["username"]."';";
            $resultadoConsultaRol = $conexion -> query($consultaRol);

            $arrayRol = $resultadoConsultaRol -> fetch_assoc();

            if($arrayRol["Rol"]=="1"){
                echo '<a href="paginaPrincipal.php">Página Principal</a>
                      <a href="nuevaRequisicion.php">Nueva Requisición</a>
                      <a href="admin.php" style="pointer-events: none; background-color: gray;">Administración</a>
                      <a href="reportes.php" style="pointer-events: none; background-color: gray;">Reportes</a>
                      <a href="porAprobar.php" style="pointer-events: none; background-color: gray;">Por Aprobar</a>
                      <div id="botonCorreo">
                          <button id="opcionesCorreoElectronico" onclick="emergente_Correo_Abrir()">Opciones de E-mail</button>
                      </div>';
            } elseif ($arrayRol["Rol"] >= "2" and $arrayRol["Rol"] <= "5"){
                echo '<a href="paginaPrincipal.php">Página Principal</a>
                      <a href="nuevaRequisicion.php">Nueva Requisición</a>
                      <a href="admin.php" style="pointer-events: none; background-color: gray;">Administración</a>
                      <a href="reportes.php">Reportes</a>
                      <a href="porAprobar.php">Por Aprobar</a>
                      <div id="botonCorreo">
                          <button id="opcionesCorreoElectronico" onclick="emergente_Correo_Abrir()">Opciones de E-mail</button>
                      </div>';
            } elseif ($arrayRol["Rol"]=="6"){
                echo '<a href="paginaPrincipal.php">Página Principal</a>
                      <a href="nuevaRequisicion.php">Nueva Requisición</a>
                      <a href="admin.php">Administración</a>
                      <a href="reportes.php" style="pointer-events: none; background-color: gray;">Reportes</a>
                      <a href="porAprobar.php" style="pointer-events: none; background-color: gray;">Por Aprobar</a>
                      <div id="botonCorreo">
                          <button id="opcionesCorreoElectronico" onclick="emergente_Correo_Abrir()">Opciones de E-mail</button>
                      </div>';
            }

            $consultaIdUsuario = "SELECT Id_Empleado AS idempleado FROM Empleado WHERE IdUsuario = '".$_SESSION["username"]."';";
            $resultadoConsultaIdUsuario = $conexion -> query($consultaIdUsuario);

            $arrayIdUsuario = $resultadoConsultaIdUsuario -> fetch_assoc();

            $_SESSION["idusuario"] = $arrayIdUsuario["idempleado"];
        ?>
    </nav>
    <section>
        <h1 class="h3">
            Administración
            <span onclick="emergente_CerrarSesion_Abrir()">Cerrar Sesión</span>
        </h1>

        <h2 class="h2">Empleados activos</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaEmpleadosActivos">
                <thead>
                    <tr>
                        <th>IdEmpleado</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>IdUsuario</th>
                        <th>Jefe</th>
                    </tr>
                </thead>
                <tbody onclick="evidenciarSeleccionActivos()">
                    <?php 
                        include '../clases/empleado.php';

                        $empleados = new empleado(); 

                        $resultadoEmpleadosActivos = $empleados -> GetEmpleadosActivos();

                        while ($row = $resultadoEmpleadosActivos->fetch_assoc()){
                            echo "<tr><td>".$row["Id_Empleado"]."</td><td>".$row["Cedula"]."</td><td>".$row["Nombre"]."</td><td>".$row["Apellido_1"]."</td><td>".$row["Apellido_2"]."</td><td>".$row["Correo_Electronico"]."</td><td>".$row["Rol"]."</td><td>".$row["IdUsuario"]."</td><td>".$row["Jefe"]."</td></tr>";
                        }
                    ?>
                    <!--
                    <tr>
                        <td>157488</td>
                        <td>116580465</td>
                        <td>Carlos</td>
                        <td>Arguedas</td>
                        <td>Dávila</td>
                        <td>carlos.arguedas.96@gmail.com</td>
                        <td>Empleado principiante</td>
                        <td>carguedasd465</td>
                        <td>123456</td>
                    </tr>
                    <tr>
                        <td>123456</td>
                        <td>114578963</td>
                        <td>Nicolás</td>
                        <td>Beisswenger</td>
                        <td>Leiva</td>
                        <td>nbeisswengerl963@ulacit.ed.cr</td>
                        <td>Jefe Aprobador</td>
                        <td>nbeisswengerl963</td>
                        <td>****</td>
                    </tr>-->
                </tbody>
            </table>
        </div>
        <div id="divBotonDeshabilitarEmpleado">
            <button class="btn btn-danger" onclick="emergente_DeshabilitarEmpleado_Confirmacion_Abrir()">Deshabilitar Empleado</button>
        </div>
        <h2 class="h2">Empleados inactivos</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaEmpleadosInactivos">
                <thead>
                        <tr>
                            <th>IdEmpleado</th>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>IdUsuario</th>
                            <th>Jefe</th>
                        </tr>
                </thead>
                <tbody onclick="evidenciarSeleccionInactivos()">
                    <?php
                        $resultadoEmpleadosInactivos = $empleados -> GetEmpleadosInactivos(); 

                        while ($row = $resultadoEmpleadosInactivos->fetch_assoc()){
                            echo "<tr><td>".$row["Id_Empleado"]."</td><td>".$row["Cedula"]."</td><td>".$row["Nombre"]."</td><td>".$row["Apellido_1"]."</td><td>".$row["Apellido_2"]."</td><td>".$row["Correo_Electronico"]."</td><td>".$row["Rol"]."</td><td>".$row["IdUsuario"]."</td><td>".$row["Jefe"]."</td></tr>";
                        }

                    ?>
                    <!--
                    <tr>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                    </tr>
                    <tr>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                        <td>Dato 2</td>
                        <td>Dato 1</td>
                    </tr>
                    -->
                </tbody>
            </table>
        </div>
        <div id="divBotonHabilitarEmpleado">
            <button class="btn btn-warning" onclick="emergente_HabilitarEmpleado_Confirmacion_Abrir()">Habilitar Empleado</button>
        </div>
        <h2 class="h4">Agregar Empleado</h2>
        <form>
            <label for="cedula">Cédula: </label>
            <input type="text" id="cedula" name="cedula">
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre">
            <label for="apellido1">Primer apellido: </label>
            <input type="text" id="apellido1" name="apellido1">
            <label for="apellido2">Segundo apellido: </label>
            <input type="text" id="apellido2" name="apellido2">
            <label for="email">Correo Electrónico: </label>
            <input type="text" id="email" name="email">
            <label for="rol">Rol: </label>
            <select name="rol" id="rol">
                <option value="N/A">Seleccione una opción</option>
                <option value="Empleado principiante">Empleado principiante</option>
                <option value="Jefe aprobador">Jefe aprobador</option>
                <option value="Aprobador Financiero 1">Aprobador Financiero 1</option>
                <option value="Aprobador Financiero 2">Aprobador Financiero 2</option>
                <option value="Aprobador Financiero 3">Aprobador Financiero 3</option>
                <option value="Administrador">Administrador</option>
            </select>
            <label for="jefe">Jefe: </label>
            <select name="jefe" id="jefe">
                <option value="N/A">Seleccione una opción</option>
                <?php 
                    $resultadoJefesAprobadores = $empleados -> GetJefesAprobadores();

                    while ($row = $resultadoJefesAprobadores->fetch_assoc()){
                        echo "<option value='".$row["Jefe"]."'>".$row["Jefe"]."</option>";
                    }
                ?>
            </select>
        </form>
        <div id="divBotonAgregarEmpleado">
            <button class="btn btn-success" onclick="emergente_AgregarEmpleado_Confirmacion_Abrir()">Agregar Empleado</button>
        </div>

        <!--Ventanas modales-->

        <!--Confirmación de agregación de empleado, con botones.-->
        <div id="modalAgregarEmpleado_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_AgregarEmpleado_Confirmacion_Cerrar()">&times;</span>
                <h2>Agregar Empleado</h2>
                <p id="nombreEmpleadoConfirmacion"></p>
                <form style="text-align: right" method="POST" action="../scriptsPHP/agregarEmpleado.php">
                    <input type="text" style="display: none;" name="agregarEmpleado_cedula" id="agregarEmpleado_cedula"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_nombre" id="agregarEmpleado_nombre"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_apellido1" id="agregarEmpleado_apellido1"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_apellido2" id="agregarEmpleado_apellido2"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_correo" id="agregarEmpleado_correo"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_rol" id="agregarEmpleado_rol"/>
                    <input type="text" style="display: none;" name="agregarEmpleado_jefe" id="agregarEmpleado_jefe"/>
                    <input type="submit" value="Aceptar" style="width: 75px" class="btn btn-success"></input> 
                    <input type="button" onclick="emergente_AgregarEmpleado_Confirmacion_Cerrar()" class="btn btn-secondary" value="Volver"></button>
                </form>
                <!--<div>
                    <button onclick="emergente_AgregarEmpleado_ConfirmacionFinal_Abrir()" class="btn btn-success">Aceptar</button>
                    <button onclick="emergente_AgregarEmpleado_Confirmacion_Cerrar()" class="btn btn-secondary">Volver</button>
                </div>-->
            </div>
        </div>


        <!--Confirmación de habilitación de empleado, botones-->
        <div id="modalHabilitarEmpleado_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_HabilitarEmpleado_Confirmacion_Cerrar()">&times;</span>
                <h2>Habilitar empleado</h2>
                <p id="numeroEmpleadoConfirmacion_Habilitar"></p>
                <form style="text-align: right" method="POST" action="../scriptsPHP/habilitarEmpleado.php">
                    <input type="text" style="display: none;" name="idempleado_habilitar" id="idempleado_habilitar"/>
                    <input type="submit" value="Aceptar" style="width: 75px" class="btn btn-success"></input> 
                    <input type="button" onclick="emergente_HabilitarEmpleado_Confirmacion_Cerrar()" class="btn btn-secondary" value="Volver"></button>
                </form>
            </div>
        </div>


        <!--Confirmación de deshabilitación de empleado, botones-->
        <div id="modalDeshabilitarEmpleado_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_DeshabilitarEmpleado_Confirmacion_Cerrar()">&times;</span>
                <h2>Deshabilitar empleado</h2>
                <p id = "numeroEmpleadoConfirmacion_Deshabilitar"></p>
                <form style="text-align: right" method="POST" action="../scriptsPHP/deshabilitarEmpleado.php">
                    <input type="text" style="display: none;" name="idempleado_deshabilitar" id="idempleado_deshabilitar"/>
                    <input type="submit" value="Aceptar" style="width: 75px" class="btn btn-success"></input> 
                    <input type="button" onclick="emergente_DeshabilitarEmpleado_Confirmacion_Cerrar()" class="btn btn-secondary" value="Volver"></button>
                </form>
                
            </div>
        </div>

        <!--Ventana modal para opciones de correo electrónico---------------------------------------->
        <div id="modalCorreo" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_Correo_Cerrar()">&times;</span>
                <h2>Cambiar correo electrónico</h2>
                <h3>Nuevo correo:</h3>
                <form action="../scriptsPHP/cambiarCorreo.php" method="post">
                    <input type="text" name="NuevoCorreo" id="nuevoCorreoElectronico">
                
                <p>*La operación de cambio de correo es final. Favor asegurarse 
                    del cambio antes de seleccionar "Cambiar correo".</p>
                
                    <button>Cambiar Correo</button>
                </form>
            </div>
        </div>

        <!--Ventana modal cerrar sesión-->
        <div id="modalCerrarSesion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_CerrarSesion_Cerrar()">&times;</span>
                <h2>Cerrar Sesión</h2>
                <p>¿Seguro que desea cerrar sesión?</p>
                <div style="text-align: right;">
                    <a href="login.html" class="btn btn-success">Aceptar</a>
                    <button onclick="emergente_CerrarSesion_Cerrar()" class="btn btn-secondary">Volver</button>
                </div>
            </div>
        </div>

    </section>
</body>

</html>
<script src="../javascript/ventanasEmergentes_Administracion.js"></script>
<script src="../javascript/ventanasEmergentes_General.js"></script>
<script src="../javascript/admin.js"></script> <!--Ver si se ocupa o no-->
