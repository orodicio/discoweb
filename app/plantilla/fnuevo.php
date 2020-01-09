<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
// FORMULARIO DE ALTA DE USUARIOS
?>

    <div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>
    <form name='alta' method="post">
        <fieldset>
            <legend>Alta de usuario</legend>
            <label for="identificador">Identificador:</label><input type="text" name="identificador" id="identificador"><br>
            <label for="nombre">Nombre y apellidos:</label><input type="text" name="nombre" id="nombre"><br>
            <label for="email">Correo electrónico</label><input type="email" name="email" id="email"><br>
            <label for="clave1">Contraseña:</label><input type="password" name="clave1" id="clave1"><br>
            <label for="clave2">Repita contraseña:</label><input type="password" name="clave2" id="clave2"><br>
            <label for="plan">Elige tu plan:</label><br>
            <select name="plan" size="3">
                <option value="0" selected>Básico</option>
                <option value="1">Profesional</option>
                <option value="2">Premium</option>
                <option value="3">Master</option>
            </select><br><br>
            <input type="button" value="Enviar" onclick="validar()">
            <input type="submit"  value="Cancelar" formaction="<?= (isset($_SESSION['user'])) ? "index.php?orden=VerUsuarios" : "index.php"?>">
        </fieldset>
    </form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>