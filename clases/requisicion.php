<?php
    include 'conexion.php';

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
    }
?>