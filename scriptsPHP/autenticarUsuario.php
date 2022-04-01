<?php
    include '../clases/login.php';
    
    if ((!empty($_POST["usuario"])) and (!empty($_POST["password"]))){
        
        $login = new Login();
        $usuario = $_POST["usuario"];
        $contra = $_POST["password"];

        $validacion = $login -> validar($usuario, $contra);

        if ($validacion==0){
            echo '<script> alert("Credenciales incorrectas."); </script>';
        } 
        else
        {
            session_start();
            $_SESSION['username'] = $usuario;
            echo '<script> alert("Login correcto."); </script>';
            echo "<script>window.setTimeout(function() {window.location.href = '../html/paginaPrincipal.php';}, 50);</script>";
        }
    }  
    else
    {
        echo '<script> alert("Debe rellenar toda la información solicitada"); </script>';
    }



    
?>