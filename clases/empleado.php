<?php
    include 'conexion.php';
    class empleado {
        var $obj_conexion; 

        public function __construct(){
            $conexion = new conexion(); 

            $this->obj_conexion = $conexion -> establecerConexion();
        }

        public function GetEmpleadosActivos(){
            $sql = "SELECT Id_Empleado, Cedula, Nombre, Apellido_1, Apellido_2, Correo_Electronico, Rol.NombreRol AS Rol, IdUsuario, Jefe 
            FROM empleado
            INNER JOIN Rol ON empleado.Rol = Rol.IdRol
            WHERE Estado = 1;";

            $empleadosActivosResult = $this->obj_conexion->query($sql);

            return $empleadosActivosResult;
        }

        public function GetEmpleadosInactivos(){
            $sql = "SELECT Id_Empleado, Cedula, Nombre, Apellido_1, Apellido_2, Correo_Electronico, Rol.NombreRol AS Rol, IdUsuario, Jefe 
            FROM empleado
            INNER JOIN Rol ON empleado.Rol = Rol.IdRol
            WHERE Estado = 0;";
            
            $empleadosInactivosResult = $this->obj_conexion->query($sql);

            return $empleadosInactivosResult;
        }

        public function GetJefesAprobadores(){
            $sql = "SELECT CONCAT(Nombre, ' ', Apellido_1, ' ', Apellido_2) AS Jefe
            FROM empleado
            WHERE rol = 2; ";

            $jefesAprobadoresResult = $this->obj_conexion->query($sql);

            return $jefesAprobadoresResult;
        }

        public function DeshabilitarEmpleado($idempleado){
            $sql = "UPDATE empleado SET Estado = 0 WHERE Id_Empleado = ".$idempleado."";
            
            $deshabilitarEmpleadoResult = $this->obj_conexion->query($sql);

            return $deshabilitarEmpleadoResult;
        }

        public function HabilitarEmpleado($idempleado){
            $sql = "UPDATE empleado SET Estado = 1 WHERE Id_Empleado = ".$idempleado."";

            $habilitarEmpleadoResult = $this->obj_conexion->query($sql);

            return $habilitarEmpleadoResult;
        }
    }
?>