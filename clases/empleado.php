<?php
    include_once 'conexion.php';
    class empleado {
        var $obj_conexion; 

        public function __construct(){
            $conexion = new conexion(); 

            $this->obj_conexion = $conexion -> establecerConexion();
        }

        public function ExisteIdUsuario($idUsuario)
        {
            $sql = "SELECT COUNT(*) As Conteo 
                    FROM empleado
                    WHERE IdUsuario = '".$idUsuario."';";

            $resultado = $this -> obj_conexion -> query($sql);

            $existe = $resultado -> fetch_assoc(); 

            return $existe["Conteo"];
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



        /* ------------------------------------------------------------------------------------------------------------- */
        public function ComprobacionNuevoIdEmpleado(){
            while(true){
                $generadorIdEmpleado = rand(10000,99999);
                $sql = "SELECT COUNT(*) AS Conteo FROM Empleado WHERE Id_Empleado = ".$generadorIdEmpleado.";";
                $comprobacionNuevoIdEmpleado = $this -> obj_conexion->query($sql);
                $arrayResultado = $comprobacionNuevoIdEmpleado -> fetch_assoc();

                if($arrayResultado["Conteo"] == "0"){
                   return $generadorIdEmpleado;
                }
            }
        }

        public function GetIdJefe($nombreJefe, $apellido_1Jefe, $apellido_2Jefe){
            $sql = "SELECT Id_Empleado FROM Empleado WHERE Nombre = '".$nombreJefe."' AND Apellido_1 = '".$apellido_1Jefe."' AND Apellido_2 = '".$apellido_2Jefe."';";
            $resultadoIdJefe = $this->obj_conexion->query($sql);

            $arrayResultadoIdJefe = $resultadoIdJefe -> fetch_assoc();

            return $arrayResultadoIdJefe["Id_Empleado"];
        }

        public function GetRolEmpleado($nombreRol){
            $sql = "SELECT IdRol FROM Rol WHERE NombreRol = '".$nombreRol."';";
            $resultadoIdRolEmpleado = $this->obj_conexion->query($sql);

            $arrayresultadoIdRolEmpleado = $resultadoIdRolEmpleado -> fetch_assoc();

            return $arrayresultadoIdRolEmpleado["IdRol"];
        }


        public function AgregarNuevoEmpleado($varIdEmpleado_EmpleadoNuevo, 
                                             $varCedula_EmpleadoNuevo,
                                             $varNombre_EmpleadoNuevo, 
                                             $varPrimerApellido_EmpleadoNuevo, 
                                             $varSegundoApellido_EmpleadoNuevo,
                                             $varCorreoElectronico_EmpleadoNuevo, 
                                             $varRol_EmpleadoNuevo, 
                                             $varIdusuario_EmpleadoNuevo,
                                             $varContrasenna_EmpleadoNuevo,
                                             $varJefe_EmpleadoNuevo, 
                                             $varEstado_EmpleadoNuevo){

            /* Encriptado de contraseña Inicio */
            $varContrasenna_Encriptada = password_hash($varContrasenna_EmpleadoNuevo, PASSWORD_DEFAULT);
            /* Encriptado de contraseña Fin */
           
            $sql = "INSERT INTO empleado VALUES (".$varIdEmpleado_EmpleadoNuevo.",".
                                                   $varCedula_EmpleadoNuevo.",'".
                                                   $varNombre_EmpleadoNuevo."','".
                                                   $varPrimerApellido_EmpleadoNuevo."','".
                                                   $varSegundoApellido_EmpleadoNuevo."','".
                                                   $varCorreoElectronico_EmpleadoNuevo."',".
                                                   $varRol_EmpleadoNuevo.",'".
                                                   $varIdusuario_EmpleadoNuevo."','".
                                                   $varContrasenna_Encriptada."',".
                                                   $varJefe_EmpleadoNuevo.",". 
                                                   $varEstado_EmpleadoNuevo.",
                                                   0);";
            $agregarNuevoEmpleado = $this -> obj_conexion->query($sql);
            return $agregarNuevoEmpleado;
        }



        public function CrearIdUsuario($varIdEmpleado_EmpleadoNuevo){

            $sql = "SELECT CONCAT(LOWER(SUBSTR(nombre, 1, 1)), LOWER(apellido_1), LOWER(SUBSTR(apellido_2, 1, 1)), SUBSTR(cedula, 7,9)) AS ID_USUARIO FROM empleado WHERE id_empleado = ".$varIdEmpleado_EmpleadoNuevo.";";
            $resultadoCrearIdUsuario = $this -> obj_conexion->query($sql);
            $arrayResultadoIdUsuario = $resultadoCrearIdUsuario -> fetch_assoc();

            $sql = "UPDATE empleado SET idUsuario = '".$arrayResultadoIdUsuario["ID_USUARIO"]."' WHERE id_empleado = ".$varIdEmpleado_EmpleadoNuevo.";";
            echo $sql;
            $ingresoIdUsuario= $this -> obj_conexion->query($sql);

            return $ingresoIdUsuario;
        }

        public function AgregarIntento($idUsuario)
        {
            $sql = "UPDATE empleado SET intentos = intentos + 1 WHERE IdUsuario = '".$idUsuario."';";

            return $this -> obj_conexion -> query($sql);
        }

        public function ReiniciarIntentos($idUsuario)
        {
            $sql = "UPDATE empleado SET intentos = 0 WHERE IdUsuario = '".$idUsuario."';";

            return $this -> obj_conexion -> query($sql);
        }

        public function GetIntentosDeEmpleado($idUsuario)
        {
            $sql = "SELECT intentos
                    FROM empleado 
                    WHERE IdUsuario = '".$idUsuario."';";

            $resultado = $this -> obj_conexion -> query($sql);
            $intentosArray = $resultado -> fetch_assoc(); 

            $intentos = $intentosArray["intentos"];

            return $intentos;
        }

        public function InactivarUsuario($idUsuario)
        {
            $sql = "UPDATE empleado SET Estado = 0 
                    WHERE IdUsuario = '".$idUsuario."';";

            $this -> obj_conexion -> query($sql);
        }
    }
?>