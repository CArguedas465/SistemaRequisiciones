<?php

include 'conexion.php';
    class Correo {
        var $conexion;
        public function __construct()
        {
            $this->conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
        }

        public function guardarNuevoCorreo($usuario, $nuevoCorreo){
            
            echo var_dump($nuevoCorreo);
            if($nuevoCorreo == ""){
                echo "<script>alert('Cambio inválido, se debe introducir un correo electrónico.')</script>";
            }
            else{
                $sql = "UPDATE empleado SET Correo_Electronico = '".$nuevoCorreo."' WHERE IdUsuario = '".$usuario."';";
                $ejecucion_query = $this -> conexion -> query($sql);
                
                echo "<script>alert('Nuevo correo electrónico ingresado correctamente.')</script>";
            }
            
        }
    
    
    }
?>