/*SUGERENCIA: Se puede similar la base de datos a partir de un archivo JSON.*/
/*Probablemente vamos a tener que trabajar con APIs para trabajar con el back end. Para probar el API, probablemente
vamos a tener que usar POSTMAN. Investigar.*/ 
/*Para la otra semana, traer la Base de Datos hecha. Mínimo tercera forma normal.*/ 
var attempt = 3;

function validacion(){

    var usuario     = document.getElementById("usuario").value;
    var contrasenna = document.getElementById("password").value;

    if (usuario=="" || contrasenna==""){
        alert("No puede dejar espacios en blanco");
    } else {
        /*Claves se encriptan en la base de datos; NUNCA DEBEN SER ACCESIBLES EN EL FRONT END. SEGURIDAD.*/ 
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
                /*Modificar alerta para que no diga la cantidad de intentos restantes.*/
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
    } else {
        alert("Sistema de recuperación de contraseña");
    }  
}