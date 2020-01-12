<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
//Plantilla para que vea el adiministrador la tabla de usuarios
ob_start();

?>

<table id="verUsuarios">
	<tr>
		<?php
		$auto = $_SERVER['PHP_SELF'];
		// identificador => Nombre, email, plan y Estado
		?>
		<?php foreach ($usuarios as $clave => $datosusuario) : ?>
	<tr>
		<td><?= $clave ?></td>
		<?php for ($j = 0; $j < count($datosusuario); $j++) : ?>
			<td><?= $datosusuario[$j] ?></td>
		<?php endfor; ?>
		<td><a href="#" onclick="confirmarBorrar('<?= $datosusuario[0] . "','" . $clave . "'" ?>);">Borrar</a></td>
		<td><a href="<?= $auto ?>?orden=Modificar&id=<?= $clave ?>">Modificar</a></td>
		<td><a href="<?= $auto ?>?orden=Detalles&id=<?= $clave ?>">Detalles</a></td>
	</tr>
<?php endforeach; ?>
</table>
<br>
<form action='index.php' method="post">
	<!--<input type='hidden' name='orden' value='Cerrar'> <input type='submit'
		value='Cerrar Sesión'>-->
	<input type='submit' value='Cerrar Sesión' formaction="index.php?orden=Cerrar">
	<input type='submit' value='Nuevo usuario' formaction="index.php?orden=Alta">
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";
?>