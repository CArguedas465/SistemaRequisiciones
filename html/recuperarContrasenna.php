<?php
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recuperación de Contraseña</title>

    <link rel="stylesheet" href="../css/recuperarContrasennaCodigo.css">
</head>
<body>

    <?php
        echo "<script>alert('Ingrese su Usuario y código de recuperación será enviado a su correo electrónico.')</script>";
    ?>

    <div class="texto_General" id="recuperarContrasennaCodigo_Div_Principal">
        <form action="../scriptsPHP/recuperarContrasennaCorreo.php" method="post"> 
            <br><br>
            <h4>Ingresar el Usuario<h4>
            <input type="text" name="Usuario" id="Codigo_Recuperacion">
            <br><br>
            <button id="Boton_Recuperacion">Enviar correo</button>
            <br><br>
        </form>
        <form action="../scriptsPHP/recuperarContrasennaCodigo.php" method="post">
            <h4>Ingresar código de recuperación<h4>
            <input type="text" name="CodigoDeRecuperacion" id="Codigo_Recuperacion">
            <br><br>
            <button id="Boton_Recuperacion">Recuperar</button>
        </form>
    </div>
    
</body>
</html>