<?php
    include 'conexion.php';

    class requisicion_Nicolas{

        var $obj_conexion; 

        public function __construct(){
            $conexion = new conexion(); 

            $this->obj_conexion = $conexion->establecerConexion();
        }

        public function GetRequisicionesPorAprobar($idusuario){
            $sql = "SELECT IdRequisicion, Fecha_Solicitud, Producto, Costo, Estado, Imagen, Id_Empleado, Detalle FROM requisicion WHERE AsignadaA = '".$idusuario."';";
            $requisicionesPorAprobarResult = $this->obj_conexion->query($sql);

            return $requisicionesPorAprobarResult;
        }

        public function GetCostoRequisicion($idrequisicion){
            $sql = "SELECT Costo FROM requisicion WHERE IdRequisicion = ".$idrequisicion.";";
            $costoDeRequisicion = $this ->obj_conexion->query($sql);

            $arrayCosto = $costoDeRequisicion -> fetch_assoc();

            return $arrayCosto["Costo"];
        }

        public function GetIdDeCreadorDeRequisicion($idrequisicion){
            $sql = "SELECT Id_Empleado FROM requisicion WHERE IdRequisicion = ".$idrequisicion.";";
            $empleadoCreador = $this -> obj_conexion->query($sql);

            $arrayCreador = $empleadoCreador -> fetch_assoc();

            return $arrayCreador["Id_Empleado"];
        }

        public function AprobarRequisicion_JefeAprobador($idrequisicion, $aprobadorAsignado){
            $sql = "UPDATE requisicion SET Estado = 'EnRevision', AsignadaA = ".$aprobadorAsignado." WHERE IdRequisicion = ".$idrequisicion.";";

            $resultadoAprobacion = $this->obj_conexion->query($sql);

            return $resultadoAprobacion;
        }



    }
?>