<?php
    include_once 'conexion.php';

    class requisicion{

        var $obj_conexion; 

        public function __construct(){
            $conexion = new conexion(); 

            $this->obj_conexion = $conexion->establecerConexion();
        }

        public function GetRequisicionesEnviadas($idusuario){
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, AsignadaA FROM requisicion WHERE Estado = 'Enviada' AND Id_Empleado = '".$idusuario."';";
            $requisicionesEnviadasResult = $this->obj_conexion->query($sql);

            return $requisicionesEnviadasResult;
        }

        public function GetRequisicionesEnRevision($idusuario){
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, AsignadaA FROM requisicion WHERE Estado = 'EnRevision' AND Id_Empleado = '".$idusuario."';";
            $requisicionesEnviadasResult = $this->obj_conexion->query($sql);

            return $requisicionesEnviadasResult;
        }

        public function GetRequisicionesRechazadas($idusuario){
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, AsignadaA FROM requisicion WHERE Estado = 'Rechazada' AND Id_Empleado = '".$idusuario."';";
            $requisicionesEnviadasResult = $this->obj_conexion->query($sql);

            return $requisicionesEnviadasResult;
        }

        public function GetRequisicionesAprobadas($idusuario){
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, AsignadaA FROM requisicion WHERE Estado = 'Aprobada' AND Id_Empleado = '".$idusuario."';";
            $requisicionesEnviadasResult = $this->obj_conexion->query($sql);

            return $requisicionesEnviadasResult;
        }

        public function GetRequisicion($idRequisicion){
            $sql = "SELECT *
                    FROM requisicion
                    WHERE IdRequisicion = ".$idRequisicion.";";

            return $this-> obj_conexion -> query($sql);
        }

        public function GetDatos_EncargadoRequisicion($idEncargado){
            $sql = "SELECT *
                    FROM empleado
                    WHERE Id_Empleado = ".$idEncargado.";";

            return $this->obj_conexion -> query($sql);
        }

        public function GetRequisicionesDeEmpleado($idSolicitante)
        {
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, CONCAT(emp.Nombre, ' ', emp.Apellido_1, ' ' , emp.Apellido_2) AS 'AsignadaA', req.Estado 
                    FROM requisicion req 
                    JOIN empleado emp ON (emp.Id_Empleado = req.AsignadaA) 
                    WHERE req.Id_empleado = ".$idSolicitante.";";

            return $this->obj_conexion->query($sql);
        }

        public function GetRequisicionesPorNombre($idSolicitante, $nombreAprobador)
        {
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, CONCAT(emp.Nombre, ' ', emp.Apellido_1, ' ' , emp.Apellido_2) AS 'AsignadaA', req.Estado 
                    FROM requisicion req 
                    JOIN empleado emp ON (emp.Id_Empleado = req.AsignadaA) 
                    WHERE req.Id_empleado = ".$idSolicitante." AND emp.Nombre = '".$nombreAprobador."';";
                    
            return $this -> obj_conexion -> query($sql);
        }

        public function GetRequisicionesPorFecha($idSolicitante, $fechaInferior, $fechaSuperior)
        {
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Imagen, Detalle, CONCAT(emp.Nombre, ' ', emp.Apellido_1, ' ' , emp.Apellido_2) AS 'AsignadaA', req.Estado 
                    FROM requisicion req 
                    JOIN empleado emp ON (emp.Id_Empleado = req.AsignadaA) 
                    WHERE req.Id_empleado = ".$idSolicitante." AND (req.Fecha_Solicitud BETWEEN '".$fechaInferior."' AND '".$fechaSuperior."');";

            return $this -> obj_conexion -> query($sql);
        }

        public function GetRequisicionPorRangoDeFechas_YTipoDeReporte($rango, $tipoReporte)
        {
            if ($tipoReporte == 'Enviada')
            {
                $sql = "SELECT * 
                    FROM requisicion
                    WHERE (fecha_solicitud BETWEEN DATE_ADD(SYSDATE(), INTERVAL -".$rango." MONTH) AND SYSDATE());";
            } 
            else
            {
                $sql = "SELECT * 
                        FROM requisicion
                        WHERE (fecha_solicitud BETWEEN DATE_ADD(SYSDATE(), INTERVAL -".$rango." MONTH) AND SYSDATE()) AND Estado = '".$tipoReporte."';";
            }

            return $this->obj_conexion -> query($sql);
        }
    }
?>