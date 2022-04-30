<?php

include 'conexion.php';
    class RecuperarCorreo {
        var $conexion;
        public function __construct()
        {
            $this->conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
        }
    
    
        public function verificar_Uaurio($usuario){
            $sql = "SELECT * FROM empleado WHERE IdUsuario = '".$usuario."';";
            $resultado = $this-> conexion -> query($sql);
            $arrayResultado = $resultado -> fetch_assoc();

            if ($usuario == $arrayResultado["IdUsuario"])
            {
                $generadorCodigoRecuperacion = rand(10000,99999);
                /*Enviar por correo*/
            }
            else
            {
                return false;
            }
        }
    
    
    
    
    }


?>