var attempt = 3;

function validacion(){
    var usuario     = document.getElementById("usuario").value;
    var contrasenna = document.getElementById("password").value;
    if(usuario=="camiargu"&&contrasenna=="admin01"){
        alert("Ha accedido al sistema");
    } 
    else {
        attempt = attempt-1;
        alert("Usted tiene "+attempt+" restantes");
        if(attempt==0){
            
        }
    }
}