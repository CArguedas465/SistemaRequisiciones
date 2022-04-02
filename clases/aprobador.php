<?php
    include_once '../clases/conexion.php';

    class aprobador {
        var $obj_conexion;

        public function __construct(){

            $conexion = new conexion();
            $this->obj_conexion = $conexion -> establecerConexion();

        }

        public function DefinirRolAprobacion($costo){

            $sql = "SELECT IdRol FROM rol WHERE ".$costo." BETWEEN rol.RangoInferior AND rol.RangoSuperior;";
            
            $resultadoRol = $this->obj_conexion->query($sql);
            $arrayResultadoRol = $resultadoRol -> fetch_assoc();

            return $arrayResultadoRol["IdRol"];

        }

        public function GetAprobadoresEnRango($rol){
            $sql = "SELECT Id_Empleado FROM empleado WHERE rol = ".$rol.";";
            $resultadoAprobadores = $this->obj_conexion->query($sql);
            return $resultadoAprobadores;
        }
    }
?>