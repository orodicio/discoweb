

<?php 
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ACCESO' method="POST" action="index.php" class="enterForm" id="acceso">
	<table>
		<tr>
			<td>Usuario</td>
			<td><input type="text" name="user"
				value="<?= $user ?>"></td>
		</tr>
		<tr>
			<td>Contraseña:</td>
			<td><input type="password" name="clave"
				value="<?= $clave ?>"></td>
		</tr>
	</table>
	<br>
	<div id ="botones">
		<input type="submit" name="orden" value="Entrar"><br><br>
			<div id="nota">
				<a href="index.php?orden=Alta"><img src="./web/img/nota.png" alt="nota"></a>
				<div id="infonota"><p>darse de alta</p></div>
			</div>
	</div>
</form>

<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>
   