<?php
    include_once 'conexion.php';
    class empleado_Carlos {
        var $obj_conexion; 

        public function __construct(){
            $conexion = new conexion(); 

            $this->obj_conexion = $conexion -> establecerConexion();
        }

        public function GetCorreoEmpleado($idEmpleado)
        {
            $sql = "SELECT Correo_Electronico
                    FROM empleado
                    WHERE Id_Empleado = ".$idEmpleado.";";

            $resultado = $this->obj_conexion->query($sql);
            $arrayCorreo = $resultado -> fetch_assoc();

            return $arrayCorreo["Correo_Electronico"];
        }

    }
?>