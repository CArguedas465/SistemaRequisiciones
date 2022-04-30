<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Requisición</title>
    <link rel="stylesheet" href="../css/StyleMain.css">
    <link rel="stylesheet" href="../css/StyleNuevaRequisicion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <br><br><br>
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

            echo '<br><br><br>';

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
    <h1 class="h3">
            Nueva Requisición
            <span onclick="emergente_CerrarSesion_Abrir()">Cerrar Sesión</span>
        </h1>
    <section  style="padding: 25px">
        
        
        <h2>Introducir la información requerida</h2>
        <form action="../scriptsPHP/crearRequisicion.php" method="post" enctype="multipart/form-data" id="formularioCreacionRequisicion">
            <?php 
                $sql = "SELECT Jefe FROM empleado WHERE Id_Empleado = ".$_SESSION["idusuario"].";";
                $jefeDirectoResultado = $conexion -> query($sql);

                $arrayJefeDirecto = $jefeDirectoResultado -> fetch_assoc();
                date_default_timezone_set("Etc/GMT-6");
                echo '<label for="fecha">Fecha de la solicitud</label><input type="text" id="fecha" name="fecha" value="'.date('Y-m-d H:m:s').'" readonly>'.
                '<label for="idempleado">IdEmpleado</label><input type="text" id="idempleado" name="idempleado" value="'.$_SESSION["idusuario"].'" readonly>'.
                '<label for="jefe">Jefe Directo</label><input type="text" id="jefe" name="jefe" value="'.$arrayJefeDirecto["Jefe"].'" readonly>';
            ?>
            <br>
            <label for="producto">Nombre del producto a solicitar</label>
            <input type="text" id="producto" name="producto" autocomplete="off">
            <label for="costo">Costo aproximado</label>
            <input type="text" id="costo" name="costo" autocomplete="off">
            <br>
            <label for="imagen">Adicionar Imagen</label>
            <input type="file" id="imagen" name="imagen" autocomplete="off">
            <br>
            <label for="detalle">Detalle</label>
            <textarea name="detalle" id="detalle" cols="150" rows="10" autocomplete="off"></textarea>
            <div id="realizarSolicitudBoton">
                <input type="button" class="btn btn-success" onclick="validacionRequisicion()" value="Realizar Solicitud"></input>
            </div>
        </form>
        
        
        <!--Ventanas modales-->

        <!-- Ventana modal para confirmación de requisición
        <div id="modalEnviarRequisicion_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_RealizarSolicitud_Confirmacion_Cerrar()">&times;</span>
                <h2>Aprobación</h2>
                <p>¿Seguro que desea crear la requisición con la información introducida?</p>
                <form action="../scriptsPHP/crearRequisicion.php" method="post" enctype="multipart/form-data">
                    <input style="display: none" type="text" id="CrearRequisicion_FechaSolicitud" name="CrearRequisicion_FechaSolicitud"> 
                    <input style="display: none" type="text" id="CrearRequisicion_EmpleadoCreador" name="CrearRequisicion_EmpleadoCreador"> 
                    <input style="display: none" type="text" id="CrearRequisicion_JefeDirecto" name="CrearRequisicion_JefeDirecto"> 
                    <input style="display: none" type="text" id="CrearRequisicion_NombreProducto" name="CrearRequisicion_NombreProducto"> 
                    <input style="display: none" type="text" id="CrearRequisicion_CostoAproximado" name="CrearRequisicion_CostoAproximado"> 
                    <input style="display: none" type="text" id="CrearRequisicion_DetalleEmpleado" name="CrearRequisicion_DetalleEmpleado"> 
                    <input style="display: none" type="file" id="CrearRequisicion_Imagen" name="CrearRequisicion_Imagen"> 
                    <input class="btn btn-secondary" type="button" value="Volver" onclick="emergente_RealizarSolicitud_Confirmacion_Cerrar()">
                    <input class="btn btn-success" type="submit" value="Aceptar">
                </form>
                <div>
                    <button onclick="emergente_RealizarSolicitud_ConfirmacionFinal_Abrir()" class="btn btn-success">Aceptar</button>
                    <button onclick="emergente_RealizarSolicitud_Confirmacion_Cerrar()" class="btn btn-secondary">Volver</button>
                </div>
            </div>
        </div>

        Ventana modal para confirmación de requisición, final
        <div id="modalEnviarRequisicion_ConfirmacionFinal" class="modal">
            <div class="modal-content">
                <p>Aprobación</p>
                <p id="confirmacionFinalNumeroRequisicion"></p>
                <div>
                    <button onclick="emergente_RealizarSolicitud_ConfirmacionFinal_Cerrar()" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </div>-->

        <!--Ventana modal para opciones de correo electrónico-->
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
<script src="../javascript/ventanasEmergentes_General.js"></script>
<script src="../javascript/ventanasEmergentes_NuevaRequisicion.js"></script>