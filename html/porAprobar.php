<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Por Aprobar</title>
    <link rel="stylesheet" href="../css/StyleMain.css">
    <link rel="stylesheet" href="../css/StylePorAprobar.css">
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

            $_SESSION["RolUsuario"] = $arrayRol["Rol"];


            /* Creación Variables Globales*/
            $consultaRangoInferior = "SELECT rol.RangoInferior AS RangoInferior FROM rol INNER JOIN empleado ON rol.IdRol = empleado.Rol WHERE empleado.Id_Empleado = ".$_SESSION["idusuario"];
            $resultadoConsultaRangoInferior = $conexion -> query($consultaRangoInferior);
            $arrayRangoInferior = $resultadoConsultaRangoInferior -> fetch_assoc();
            $_SESSION["RangoInferior"] = $arrayRangoInferior["RangoInferior"];

            $consultaRangoSuperior = "SELECT rol.RangoSuperior AS RangoSuperior FROM rol INNER JOIN empleado ON rol.IdRol = empleado.Rol WHERE empleado.Id_Empleado = ".$_SESSION["idusuario"];
            $resultadoConsultaRangoSuperior = $conexion -> query($consultaRangoSuperior);
            $arrayRangoSuperior = $resultadoConsultaRangoSuperior -> fetch_assoc();
            $_SESSION["RangoSuperior"] = $arrayRangoSuperior["RangoSuperior"];



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
            Por Aprobar
            <span onclick="emergente_CerrarSesion_Abrir()">Cerrar Sesión</span>
        </h1>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaRequisicionesPorAprobar">
                <thead>
                    <th>IdRequisición</th>
                    <th>Fecha Solicitud</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>IdEmpleado</th>
                    <th>Detalle</th>
                </thead>  
                <tbody> <!-- Falta asignar JS -->

                    <?php
                        include '../clases/requisicion_Nicolas.php';
                        $requisicion = new requisicion_Nicolas();
                        $resultadoRequisicionesPorAprobar = $requisicion -> GetRequisicionesPorAprobar ($_SESSION["idusuario"]);
                        while ($row = $resultadoRequisicionesPorAprobar -> fetch_assoc()){
                            echo "<tr>
                                <td>".$row["IdRequisicion"]."</td>
                                <td>".$row["Fecha_Solicitud"]."</td>
                                <td>".$row["Producto"]."</td>
                                <td>".$row["Costo"]."</td>
                                <td>".$row["Estado"]."</td>
                                <td><img height=\"100px\" width = \"100px\" src=\"data:image/jpg; base64, ";echo base64_encode($row["Imagen"]); echo "\"></td>
                                <td>".$row["Id_Empleado"]."</td>
                                <td>".$row["Detalle"]."</td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!--Ventanas modales-->

        <!--Ventana modal de detalle de requisición-->
        
        <div id="modalRequisicion" class="modal">
            <div class="modal-content" style="margin: 5% auto 10% 17% ">
                <span id="closeButton" class="closeButton" onclick="emergente_Requisicion_Cerrar()">&times;</span>
                <h2 id="tituloNumeroRequisicion">Requisición # N/A</h2>
                <form>
                    <label for="fecha">Fecha de la solicitud</label>
                    <input type="text" id="fecha" name="fecha" readonly disabled>
                    <label for="empleado">Empleado Solicitante</label>
                    <input type="text" id="empleado" name="empleado" readonly disabled>
                    <label for="producto">Nombre del producto</label>
                    <input type="text" id="producto" name="producto" readonly disabled>
                    <label for="costo">Costo del Producto</label>
                    <input type="text" id="costo" name="costo" readonly disabled>
                    <label for="imagen">Imagen</label>
                    <input type="text" id="imagen" name="imagen" value="Click para ver imagen" onclick="emergente_ImagenProducto_Abrir()" readonly>
                    <br><br>
                    <label for="detalle">Detalle</label>
                    <textarea cols="130" rows="3" id="detalleEmpleado" name="detalleEmpleado" readonly disabled></textarea>
                    <br><br>
                    <label for="detalle">Notas del aprobador</label>
                    <textarea cols="130" rows="3" id="detalleAprobador" name="detalleAprobador"></textarea>
                </form>
                
                <br>
                <div>
                    <button style="float: left;" class="btn btn-secondary" onclick="emergente_Requisicion_Cerrar()">Volver</button>
                    <button style="float: right;" class="btn btn-success" onclick="emergente_AprobarRequisicion_Confirmacion_Abrir()">Aprobar Solicitud</button>
                    <button style="float: right;" class="btn btn-danger" onclick="emergente_DenegarRequisicion_Confirmacion_Abrir()">Denegar Solicitud</button>
                </div>
                
            </div>
        </div>

        <!--Ventana de confirmación de aprobación, con botones.-->
        <div id="modalAprobarRequisicion_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_AprobarRequisicion_Confirmacion_Cerrar()">&times;</span>
                <p>Aprobación</p>
                <p id="numeroRequisicionConfirmacion"></p>
                <form action="../scriptsPHP/aprobarRequisicion.php" method="post">
                    <?php
                        echo '<input style="display: none;" type="text" id="AprobarRequisicion_IdRequisicion" name="AprobarRequisicion_IdRequisicion">'.
                        '<input style="display: none;" type="text" id="AprobarRequisicion_Rol" name="AprobarRequisicion_Rol" value="'.$_SESSION["RolUsuario"].'">'.
                        '<input style="display: none;" type="text" id="AprobarRequisicion_RangoInferior" name="AprobarRequisicion_RangoInferior" value="'.$_SESSION["RangoInferior"].'">'.
                        '<input style="display: none;" type="text" id="AprobarRequisicion_RangoSuperior" name="AprobarRequisicion_RangoSuperior" value="'.$_SESSION["RangoSuperior"].'">'.
                        '<input style="display: none;" type="text" id="AprobarRequisicion_DetalleAprobador" name="AprobarRequisicion_DetalleAprobador">';
                    ?>
                    
                    <!--
                    <input style="display: none;" type="text" id="AprobarRequisicion_IdRequisicion" name="AprobarRequisicion_IdRequisicion">
                    <input style="display: none;" type="text" id="AprobarRequisicion_Rol" name="AprobarRequisicion_Rol" value=<?php echo '"'.$_SESSION["RolUsuario"].'"'?>>
                    <input style="display: none;" type="text" id="AprobarRequisicion_RangoInferior" name="AprobarRequisicion_RangoInferior" value=<?php echo '"'.$_SESSION["RangoInferior"].'"'?>>
                    <input style="display: none;" type="text" id="AprobarRequisicion_RangoSuperior" name="AprobarRequisicion_RangoSuperior" value=<?php echo '"'.$_SESSION["RangoSuperior"].'"'?>>
                    -->


                    <input class="btn btn-success" type="submit" value="Aceptar">
                    <input class="btn btn-secondary" type="button" value="Volver" onclick="emergente_AprobarRequisicion_Confirmacion_Cerrar()">
                </form>
                <!--
                <div>
                    <button onclick="emergente_AprobarRequisicion_ConfirmacionFinal_Abrir()">Aceptar</button>
                    <button onclick="emergente_AprobarRequisicion_Confirmacion_Cerrar()">Volver</button>
                </div>
                    -->
            </div>
        </div>

        <!--Ventana de confirmación de denegación, con botones.-->
        <div id="modalDenegarRequisicion_Confirmacion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_DenegarRequisicion_Confirmacion_Cerrar()">&times;</span>
                <p>Denegación</p>
                <p id="numeroRequisicionDenegacion"></p>
                <form action="../scriptsPHP/denegarRequisicion.php" method="post">
                    <input style="display: none;" type="text" id="DenegarRequisicion_IdRequisicion" name="DenegarRequisicion_IdRequisicion">
                    <input style="display: none;" type="text" id="DenegarRequisicion_DetalleAprobador" name="DenegarRequisicion_DetalleAprobador">
                    <input class="btn btn-success" type="submit" value="Aceptar">
                    <input class="btn btn-secondary" type="button" value="Volver" onclick="emergente_DenegarRequisicion_Confirmacion_Cerrar()">
                </form>
                <!--
                <div>
                    <button onclick="emergente_DenegarRequisicion_ConfirmacionFinal_Abrir()">Aceptar</button>
                    <button onclick="emergente_DenegarRequisicion_Confirmacion_Cerrar()">Volver</button>
                </div>-->
            </div>
        </div>

        <!--Ventana de confirmación de denegación, final-->
        <div id="modalDenegarRequisicion_ConfirmacionFinal" class="modal">
            <div class="modal-content">
                <p>Aprobación</p>
                <p id="DenegacionFinalNumeroRequisicion"></p>
                <div>
                    <button onclick="emergente_DenegarRequisicion_ConfirmacionFinal_Cerrar()">Aceptar</button>
                </div>
            </div>
        </div>

        <!--Ventana de muestra de la imagen-->
        <div id="modalImagenRequisicion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_ImagenProducto_Cerrar()">&times;</span>
                <h2 class="h1">Imagen</h2>
                <div id="espacioParaImagen" style="text-align: center">
                    <img id="imagenAMostrar" height="600px" width ="600px">
                </div>
            </div>
        </div>

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
<script src="../javascript/aprobacionRequisiciones.js"></script>