<?php
    include_once '../clases/login.php';
    include_once '../clases/empleado.php';

    session_start();
    $_SESSION["modoBusqueda"] = -1;
    $_SESSION["resultadoBusqueda"] = -1;
    
    if ((!empty($_POST["usuario"])) and (!empty($_POST["password"]))){
        
        $login = new Login();
        $usuario = $_POST["usuario"];
        $contra = $_POST["password"];


        $validacion = $login -> validar($usuario, $contra);
        
        
        if ($validacion == false)
        {
            echo '<script > alert("Credenciales incorrectas o usuario bloqueado/inactivo.");</script>';
            include_once '../clases/empleado.php';

            $empleado = new empleado();

            $conteoUsuario = $empleado -> ExisteIdUsuario($usuario);

            if ($conteoUsuario==1)
            {
                $empleado -> AgregarIntento($usuario);

                $intentos = $empleado -> GetIntentosDeEmpleado($usuario);

                if ($intentos == 3)
                {
                    echo '<script> alert("Este usuario será inactivado debido a que ha alcanzado los tres intentos de ingreso. Contactar al administrador"); </script>';
                    $empleado -> InactivarUsuario($usuario);
                    echo "<script>window.setTimeout(function() {window.location.href = '../html/login.html';}, 50);</script>";
                    return;
                } 
                else if ($intentos > 3)
                {
                    echo '<script> alert("Este usuario ha sido inactivado debido a que ha sobrepasado los tres intentos de ingreso. Contactar al administrador."); </script>';
                    echo "<script>window.setTimeout(function() {window.location.href = '../html/login.html';}, 50);</script>";
                    return;
                }
            }
            echo "<script>window.setTimeout(function() {window.location.href = '../html/login.html';}, 50);</script>";
        } 
        else
        {
            $empleado = new empleado();

            $conteoUsuario = $empleado -> ExisteIdUsuario($usuario);

            if ($conteoUsuario==1)
            {
                $empleado -> ReiniciarIntentos($usuario);
            }
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