<?php
    include 'conexion.php';
    class Login {

        var $conexion;

        public function __construct()
        {
            $this->conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
        }

        public function validar($usuario, $contra)
        {
            $sql = "SELECT COUNT(*) FROM Empleado WHERE IdUsuario = '".$usuario."' AND Contrasenna = '".$contra."';";
            $resultado = $this -> conexion -> query($sql);

            if (!$resultado){
                trigger_error('Invalid query:'.$resultado->error);
            }

            $array = $resultado -> fetch_assoc();

            return $array["COUNT(*)"];
        }
    }

    
?>