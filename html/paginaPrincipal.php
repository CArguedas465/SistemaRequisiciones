<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="../css/StyleMain.css">
    <link rel="stylesheet" href="../css/StylePaginaPrincipal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body id="body">
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
            Página Principal
            <span onclick="emergente_CerrarSesion_Abrir()">Cerrar Sesión</span>
        </h1>
        <div style="text-align: right; margin: 20px;">
            <button onclick="emergente_BusquedaEspecifica_Abrir()" class="btn btn-success">Búsqueda específica</button>
        </div>
        <h2>Requisiciones Enviadas</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaRequisicionesEnviadas">
                <thead>
                    <th>IdRequisición</th>
                    <th>Fecha Solicitud</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Imagen</th>
                    <th>Detalle</th>
                    <th>Asignada A</th>
                </thead>
                <tbody onclick="requisicionesEnviadasSeleccion()">
                    <?php
                        include '../clases/requisicion.php';

                        $requisicion = new requisicion();

                        $resultadoRequisicionesEnviadas = $requisicion -> GetRequisicionesEnviadas($_SESSION["idusuario"]);

                        while ($row = $resultadoRequisicionesEnviadas->fetch_assoc()){
                            echo "<tr><td>".$row["IdRequisicion"]."</td><td>".$row["Fecha_Solicitud"]."</td><td>".$row["Producto"]."</td><td>".$row["Costo"]."</td><td>".$row["Imagen"]."</td><td>".$row["Detalle"]."</td><td>".$row["AsignadaA"]."</td></tr>";
                        }
                    ?>
                    <!--
                    <tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagen asd</td>
                        <td>Descripción de Detalle 1</td>
                        <td>123456</td>
                    </tr> 
                    <tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagen dfg</td>
                        <td>Descripción de Detalle 1</td>
                        <td>123456</td>
                    </tr> 
                    <tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagengjfg</td>
                        <td>Descripción de Detalle 1</td>
                        <td>123456</td>
                    </tr> 
                    <tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagenfghf</td>
                        <td>Descripción de Detalle 1</td>
                        <td>123456</td>
                    </tr>--> 
                </tbody>
            </table>
        </div>
        <h2>Requisiciones En Revisión</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaRequisicionesEnRevision">
                <thead>
                    <th>IdRequisición</th>
                    <th>Fecha Solicitud</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Imagen</th>
                    <th>Detalle</th>
                    <th>Asignada A</th>
                </thead>
                <tbody onclick="requisicionesEnRevisionSeleccion()">
                <?php

                        $requisicion = new requisicion();

                        $resultadoRequisicionesEnRevision = $requisicion -> GetRequisicionesEnRevision($_SESSION["idusuario"]);

                        while ($row = $resultadoRequisicionesEnRevision->fetch_assoc()){
                            echo "<tr><td>".$row["IdRequisicion"]."</td><td>".$row["Fecha_Solicitud"]."</td><td>".$row["Producto"]."</td><td>".$row["Costo"]."</td><td>".$row["Imagen"]."</td><td>".$row["Detalle"]."</td><td>".$row["AsignadaA"]."</td></tr>";
                        }
                    ?>
                    <!--tr>
                        <td>848912</td>
                        <td>3/30/2022</td>
                        <td>Mouse</td>
                        <td>30000</td>
                        <td>Imagen 2</td>
                        <td>Descripción de Detalle 2</td>
                        <td>123456</td>
                    </tr>-->
                </tbody>
            </table>
        </div>
        <h2>Requisiciones Rechazadas</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaRequisicionesRechazadas">
                <thead>
                    <th>IdRequisición</th>
                    <th>Fecha Solicitud</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Imagen</th>
                    <th>Detalle</th>
                    <th>Asignada A</th>
                </thead>
                <tbody onclick="requisicionesRechazadasSeleccion()">
                 <?php

                        $requisicion = new requisicion();

                        $resultadoRequisicionesRechazadas = $requisicion -> GetRequisicionesRechazadas($_SESSION["idusuario"]);

                        while ($row = $resultadoRequisicionesRechazadas->fetch_assoc()){
                            echo "<tr><td>".$row["IdRequisicion"]."</td><td>".$row["Fecha_Solicitud"]."</td><td>".$row["Producto"]."</td><td>".$row["Costo"]."</td><td>".$row["Imagen"]."</td><td>".$row["Detalle"]."</td><td>".$row["AsignadaA"]."</td></tr>";
                        }
                    ?>
                    <!--tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagen 3</td>
                        <td>Descripción de Detalle 3</td>
                        <td>123456</td>
                    </tr>-->
                </tbody>
            </table>
        </div>
        <h2>Requisiciones Aprobadas</h2>
        <div class="scrollableTableDiv">
            <table class="table table-borderless" id="tablaRequisicionesAprobadas">
                <thead>
                    <th>IdRequisición</th>
                    <th>Fecha Solicitud</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Imagen</th>
                    <th>Detalle</th>
                    <th>Asignada A</th>
                </thead>
                <tbody onclick="requisicionesAprobadasSeleccion()">
                <?php

                        $requisicion = new requisicion();

                        $resultadoRequisicionesAprovadas = $requisicion -> GetRequisicionesAprobadas($_SESSION["idusuario"]);

                        while ($row = $resultadoRequisicionesAprovadas->fetch_assoc()){
                            echo "<tr><td>".$row["IdRequisicion"]."</td><td>".$row["Fecha_Solicitud"]."</td><td>".$row["Producto"]."</td><td>".$row["Costo"]."</td><td>".$row["Imagen"]."</td><td>".$row["Detalle"]."</td><td>".$row["AsignadaA"]."</td></tr>";
                        }
                    ?>
                    <!--tr>
                        <td>1232185</td>
                        <td>3/30/2022</td>
                        <td>Silla</td>
                        <td>175000</td>
                        <td>Imagen 4</td>
                        <td>Descripción de Detalle 4</td>
                        <td>123456</td>
                    </tr>-->
                </tbody>
            </table>
        </div>
        
        <!--Ventanas modales-->

        <!--Ventana de muestra de la imagen-->
        <div id="modalImagenPagPrincipal" class="modal" style="z-index: 2;">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_ImagenProducto_Cerrar()">&times;</span>
                <h2 class="h1">Imagen</h2>
                <div id="espacioParaImagen">
                    <p>Párrafo de muestra</p>
                </div>
            </div>
        </div>

        <!--Ventana de muestra de detalle-->
        <div id="modalDetallePagPrincipal" class="modal" style="z-index: 2;">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_DetalleProducto_Cerrar()">&times;</span>
                <h2 class="h1">Detalle</h2>
                <textarea id="espacioParaDetalle" cols="75" rows="6" readonly disabled></textarea>
            </div>
        </div>

        <!--Ventana modal de búsqueda-->
        <div id="modalBusquedaEspecifica" class="modal" style="z-index: 1;">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_BusquedaEspecifica_Cerrar()">&times;</span>
                <h2 class="h4">Búsqueda Específica</h2>
                <form>
                    <label for="busqueda">Búsqueda</label>
                    <input type="text" id="busqueda" name="busqueda">
                    <label for="criterio">Criterio de Búsqueda</label>
                    <select name="criterio" id="criterio">
                        <option value="N/A">Seleccione criterio</option>
                        <option value="fecha">Por Fecha</option>
                        <option value="nombre">Por Nombre</option>
                    </select>
                    <br>
                    <label for="rango" style="display: block; text-align: left;"><b>Rango Fechas</b></label>
                    <br>
                    <div id="rango" style="text-align: left;">
                        <label for="inferior">Desde</label>
                        <input type="date" name="inferior" id="inferior">
                        <label for="superior">Hasta</label>
                        <input type="date" name="superior" id="superior">
                        <input type="button" value="Buscar" class="btn btn-success">
                    </div>
                    <br>
                    <div class="scrollableTableDiv scrollableDivBusqueda">
                        <table class="table table-borderless" id="tablaBusquedaEspecifica">
                            <thead>
                                <th>IdRequisición</th>
                                <th>Fecha Solicitud</th>
                                <th>Producto</th>
                                <th>Costo</th>
                                <th>Imagen</th>
                                <th>Detalle</th>
                                <th>Asignada A</th>
                            </thead>
                            <tbody onclick="requisicionesBusquedaGeneralSeleccion()">
                                <tr>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                </tr>
                                <tr>
                                    <td>y</td>
                                    <td>y</td>
                                    <td>y</td>
                                    <td>y</td>
                                    <td>y</td>
                                    <td>y</td>
                                    <td>y</td>
                                </tr>
                                <tr>
                                    <td>z</td>
                                    <td>z</td>
                                    <td>z</td>
                                    <td>z</td>
                                    <td>z</td>
                                    <td>z</td>
                                    <td>z</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </form>
            </div>
        </div>

        <!--Ventana modal opciones de correo-->
        <div id="modalCorreo" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_Correo_Cerrar()">&times;</span>
                <h2>Cambiar correo electrónico</h2>
                <h3>Nuevo correo:</h3>
                <input type="text" id="nuevoCorreoElectronico">
                <p>*La operación de cambio de correo es final. Favor asegurarse 
                    del cambio antes de seleccionar "Cambiar correo".</p>
                <div>
                    <button>Cambiar Correo</button>
                </div>
            </div>
        </div>

        <!--Ventana modal cerrar sesión-->
        <div id="modalCerrarSesion" class="modal">
            <div class="modal-content">
                <span id="closeButton" class="closeButton" onclick="emergente_CerrarSesion_Cerrar()">&times;</span>
                <h2>Cerrar Sesión</h2>
                <p>¿Seguro que desea cerrar sesión?</p>
                <div style="text-align: right;">
                    <a href="login.html" target="_blank" class="btn btn-success">Aceptar</a>
                    <button onclick="emergente_CerrarSesion_Cerrar()" class="btn btn-secondary">Volver</button>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<script src="../javascript/ventanasEmergentes_General.js"></script>
<script src="../javascript/ventanasEmergentes_Principal.js"></script>