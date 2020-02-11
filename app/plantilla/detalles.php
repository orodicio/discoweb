<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
//Detalles no cuenta con hoja css: su estilo se consigue a través de las demás.
ob_start();
// DETALLES
?>

<div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>
<h1>Detalles de <?=$user?></h1>
<p>Nombre: <?=$tablaAmostrar[2]?></p>
    <p>Correo electrónico: <?=$tablaAmostrar[3]?></p>
    <p>Tipo de plan: <?=PLANES[$tablaAmostrar[4]]?></p>
    <p>Estado <?=ESTADOS[$tablaAmostrar[5]]?></p>
    <p>Número de ficheros: <?=$tablaAmostrar[6]?></p>
    <p>Espacio ocupado:: <?=$tablaAmostrar[7]?> MB</p>
<form method="get" action="index.php?orden=VerUsuarios">
    <input type="submit" value="volver">
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";
?>