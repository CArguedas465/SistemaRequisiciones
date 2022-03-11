var attempt = 3;

function validacion(){

    var usuario     = document.getElementById("usuario").value;
    var contrasenna = document.getElementById("password").value;

    if (usuario=="" || contrasenna==""){
        alert("No puede dejar espacios en blanco");
    } else {
        if(usuario=="camiargue"&&contrasenna=="admin01"){
            alert("Ha accedido al sistema");
            document.getElementById("usuario").value = "";
            document.getElementById("password").value = "";
        } 
        else {
            attempt--;
            if (attempt==0){           
                document.getElementById("usuario").disabled = "true";
                document.getElementById("usuario").placeholder = "No disponible";
                document.getElementById("usuario").value = "No disponible";
                document.getElementById("usuario").style.textAlign = "center";
    
                document.getElementById("password").disabled = "true";
                document.getElementById("password").placeholder = "No disponible";
                document.getElementById("password").type = "text";
                document.getElementById("password").value = "No disponible";
                document.getElementById("password").style.textAlign = "center";
    
                document.getElementById("ingresar").value = "Acceso Denegado";
                document.getElementById("ingresar").style.backgroundColor = "#960f16";
                document.getElementById("ingresar").style.color = "white";
                document.getElementById("ingresar").style.borderColor = "#960f16";
            } else if (attempt<0){
                alert("Usted ha sido bloqueado del sistema. Comuníquese con su administrador.")
                attempt = -1;
            } else {
                alert("Credenciales incorrectas. Usted tiene "+attempt+" intentos restantes");
                document.getElementById("usuario").value = "";
                document.getElementById("password").value = "";
            }
        }
    }
}

function recuperacionContrasenia(){
    if (attempt<0){
        alert("Usted ha sido bloqueado del sistema. Comuníquese con su administrador.")
                attempt = -1;
    }
    alert("Sistema de recuperación de contraseña");
}