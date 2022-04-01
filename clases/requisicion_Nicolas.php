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

    }
?>