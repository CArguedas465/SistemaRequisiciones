<?php

include 'conexion.php';
include '../servidorcorreo/PHPMailerAutoload.php';

    class RecuperarCorreo {
        var $conexion;
        public function __construct()
        {
            $this->conexion = mysqli_connect('localhost', 'root', '', 'sistema_requisiciones');
        }
    
    
        public function verificar_Usuario($usuario){
            $sql = "SELECT * FROM empleado WHERE IdUsuario = '".$usuario."';";
            $resultado = $this-> conexion -> query($sql);
            $arrayResultado = $resultado -> fetch_assoc();

            if ($usuario == $arrayResultado["IdUsuario"])
            {
                $generadorCodigoRecuperacion = rand(10000,99999);
                session_start(); 

                $_SESSION["codigoRecuperacion"] = $generadorCodigoRecuperacion;
                $_SESSION["idUsuarioRecuperacion"] = $usuario;

                $mail = new PHPMailer();
                $mail -> isSMTP();
                $mail -> SMTPAuth = true; 
                $mail -> SMTPSecure = 'ssl';
                $mail -> Host = 'smtp.gmail.com';
                $mail -> Port ='465'; //o 587
                $mail -> isHTML(); 
                $mail -> Username = 'requisicionesico2022@gmail.com';
                $mail -> Password = 'ulacit123...';
                $mail -> SetFrom('no-reply@requisicionesico2022.com');

                $mail -> Subject = 'Recuperacion de contrasena para '.$usuario;

                $mail -> Body = 'Su código de recuperación es '.$generadorCodigoRecuperacion.". Favor introdúzcalo en la plataforma
                                para introducir su nueva contraseña.";

                $mail -> AddAddress($arrayResultado["Correo_Electronico"]);

                $mail -> Send();
            
            }
            else
            {
                return false;
            }
        }
    }


?>