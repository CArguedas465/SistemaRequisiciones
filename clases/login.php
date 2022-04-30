<?php
    include_once 'conexion.php';
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

            if ($usuario == $arrayResultado["IdUsuario"] && password_verify($contra,$arrayResultado["Contrasenna"]))
            {
                if ($arrayResultado["Estado"]==0)
                {
                    return false;
                }
                return true;
            }
            else
            {   
                return false;
            }
        }
    
    }

    
?>