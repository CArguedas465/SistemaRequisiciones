<?php
    include_once '../clases/requisicion.php';
    session_start();

    $busqueda = $_POST["busqueda"];
    $criterio = $_POST["criterio"];
    $inferior = $_POST["inferior"];
    $superior = $_POST["superior"];
    $usuarioEnSesion = $_POST["usuarioEnSesion"];

    $requisicion = new requisicion();

    if ($criterio == 'nombre')
    {
        $resultadosNombreArray = array();

        $_SESSION["modoBusqueda"] = 0;
        $resultado = $requisicion -> GetRequisicionesPorNombre($usuarioEnSesion, $busqueda);
        $cont = 0;
        $resultadoNombreArray = array();
        while ($row = $resultado -> fetch_assoc())
        {
            $resultadosNombreArray[$cont] = array($row["IdRequisicion"], $row["Fecha_Solicitud"], $row["Producto"], $row["Costo"], $row["Imagen"], $row["Detalle"], $row["AsignadaA"], $row["Estado"]);
            $cont++;
        }
        $_SESSION["resultadoBusqueda"] = $resultadosNombreArray;
    }
    else
    {
        $_SESSION["modoBusqueda"] = 1;
        $resultado = $requisicion -> GetRequisicionesPorFecha($usuarioEnSesion, $inferior, $superior);
        $cont = 0;
        $resultadoNombreArray = array();
        while ($row = $resultado -> fetch_assoc())
        {
            $resultadosNombreArray[$cont] = array($row["IdRequisicion"], $row["Fecha_Solicitud"], $row["Producto"], $row["Costo"], $row["Imagen"], $row["Detalle"], $row["AsignadaA"], $row["Estado"]);
            $cont++;
        }
        $_SESSION["resultadoBusqueda"] = $resultadosNombreArray;
    }

    echo "<script>window.setTimeout(function() {window.location.href = '../html/paginaPrincipal.php';}, 0);</script>";
?>