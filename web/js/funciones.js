/**
 * Funciones auxiliares de javascript
 *  e inicio del documento para las fuciones Jquery
 */
$("document").ready(funcionesJquery);

function confirmarBorrar(nombre, id) {
    if (confirm("¿Quieres eliminar el usuario:  " + nombre + "?")) {
        document.location.href = "?orden=Borrar&id=" + id;
    }
}

function confirmarBorrarArchivo(nombre) {
    if (confirm("¿Quieres eliminar el archivo:  " + nombre + "?")) {
        document.location.href = "?orden2=Borrar";
    }
}

function comprobarContrasenas(clave) {
    var expr2 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&()=])([A-Za-z\d$@$!%*?&()=]|[^ ]){8,15}$/;
    if (clave == null || clave.length === 0 || !(expr2.test(clave))) {
        return false;
    }
    return true;
}

function validar() {
    var identificador = document.getElementById("identificador").value;
    var email = document.getElementById("email").value;
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var clave1 = document.getElementById("clave1").value;
    var clave2 = document.getElementById("clave2").value;
    var indice = document.forms[0].plan.selectedIndex;
    var opcion = document.forms[0].plan.options[indice].value;
    var nombre = document.getElementById("nombre").value;

    if (identificador == null || identificador.length < 5 || identificador.length > 10 || /^\s+$/.test(identificador)) {
        alert('[ERROR] Debe introducir un identificador de entre 5 y diez caracteres y válido');
        return;
    }

    if (!(expr.test(email)) || email == null) {
        alert('[ERROR] Debe introducir un correo electrónico válido');
        return;
    }

    if (clave1 !== clave2) {
        alert('[ERROR] Las contraseñas deben ser iguales');
        return;
    }

    if (!comprobarContrasenas(clave1) || !comprobarContrasenas(clave2)) {
        alert('[ERROR] Las contraseñas deben tener entre 8 y 15 caracteres y deben ser seguras');
        return;
    }

    if (opcion == null) {
        alert('[ERROR] Debe introducir un tipo de plan');
        return;
    }
    if (nombre == null) {
        alert('[ERROR] Debe introducir su nombre o alias');
        return;
    }
    document.forms[0].action = "index.php?orden=Alta"
    document.forms[0].submit(); //enviar datos al servidor
}

function confirmarModificar(plan){
   alert('Si modifica su plan '+plan +' ,su usuario querará temporalmente bloqueado, a no ser que sea administrador');
    return;
}
/*Funciones Jquery
/*Funciones Jquery
/*Funciones Jquery
/*Funciones Jquery*/

function funcionesJquery() {
    $(".enterForm").keydown(enviarConEnter);
    $("#mostrar").click(mostrar);
    $("#nota").mouseover(texto);
    $("#nota").mouseout(borrartexto);
    $("#verArchivos a, #verUsuarios a").hover(entramouse, salemouse);
    $("input[type=text],input[type=password],input[type=email]").each(function() { $(this).hover(cambiaBorde, restauraBorde) });
    $("input[type=submit],button,input[type=button]").each(function() { $(this).hover(cambiarFondo, restaurarFondo) });

}

function enviarConEnter() {
    var key = e.which;
    if (key == 13) {
        $(".enterForm").submit();
    }
}

function mostrar() {
    $('#subida').css('visibility', 'visible');
}

function texto() {
    $('#infonota').css('visibility', 'visible');

}

function borrartexto() {
    $('#infonota').css('visibility', 'hidden');

}

function entramouse() {
    $(this).css('color', 'rgba(246, 209, 160, 0.883)');
}

function salemouse() {
    $(this).css('color', '#442299');
}

function cambiaBorde() {
    $(this).css('border', '1px solid rgba(246, 153, 31, 0.883)');
}

function restauraBorde() {
    $(this).css('border', '1px solid #757E82');
}

function cambiarFondo() {
    $(this).addClass("cambiarBotones");
}

function restaurarFondo() {
    $(this).removeClass("cambiarBotones");
}