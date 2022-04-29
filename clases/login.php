<?php
    include 'conexion.php';
    class Login {

        var $conexion;

        public function __construct()
        {
            $this->conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
        }


        
        public function validar($usuario, $contra){
            
            $sql = "SELECT * FROM empleado WHERE IdUsuario = '".$usuario."';";
            $resultado = $this-> conexion -> query($sql);
            $arrayResultado = $resultado -> fetch_assoc();


            if ($usuario == $arrayResultado["IdUsuario"] && $contra == $arrayResultado["Contrasenna"])
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    
    }

    
?>