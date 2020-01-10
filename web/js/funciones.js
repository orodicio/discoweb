/**
 * Funciones auxiliares de javascripts 
 */
$("document").ready(funcionesJquery);
function confirmarBorrar(nombre,id){
  if (confirm("¿Quieres eliminar el usuario:  "+nombre+"?"))
  {
   document.location.href="?orden=Borrar&id="+id;
  }
}
function confirmarBorrarArchivo(nombre){
    if (confirm("¿Quieres eliminar el archivo:  "+nombre+"?"))
    {
        document.location.href="?orden2=Borrar";
    }
}
function comprobarContrasenas(clave){
    var expr2 =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&()=])([A-Za-z\d$@$!%*?&()=]|[^ ]){8,15}$/;
    if( clave == null || clave.length === 0 || !(expr2.test(clave))){
        return false;
    }
    return true;
}

function validar(){
    var identificador = document.getElementById("identificador").value;
    var email = document.getElementById("email").value;
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var clave1= document.getElementById("clave1").value;
    var clave2= document.getElementById("clave2").value;
    var indice =document.forms[0].plan.selectedIndex;
    var opcion = document.forms[0].plan.options[indice].value;
    var nombre = document.getElementById("nombre").value;

    if( identificador == null ||identificador.length< 5||identificador.length> 10|| /^\s+$/.test(identificador) ) {
        alert('[ERROR] Debe introducir un identificador de entre 5 y diez caracteres y válido');
        return;
    }

    if( !(expr.test(email))|| email == null ) {
        alert('[ERROR] Debe introducir un correo electrónico válido');
        return;
    }

    if(clave1 !== clave2){
        alert('[ERROR] Las contraseñas deben ser iguales');
        return;
    }

    if(!comprobarContrasenas(clave1)||!comprobarContrasenas(clave2)){
        alert('[ERROR] Las contraseñas deben tener entre 8 y 15 caracteres y deben ser seguras');
        return;
    }

    if(opcion == null){
        alert('[ERROR] Debe introducir un tipo de plan');
        return;
    }
    if(nombre == null){
        alert('[ERROR] Debe introducir su nombre o alias');
        return;
    }
    document.forms[0].action="index.php?orden=Alta"
    document.forms[0].submit(); //enviar datos al servidor
}
function funcionesJquery() {
    $(".enterForm").keydown(enviarConEnter);
    $("#mostrar").click(mostrar);

    }
function enviarConEnter() {
    var key = e.which;
    if (key == 13) {
        $(".enterForm").submit();
    }
}
function mostrar(){
        $('#subida').css('visibility','visible');
}
