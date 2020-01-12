<?php
//formulario para modificar usuarios del administrador
ob_start();
$userid =$_GET["id"];
if(isset($userid)){
	$user = $_SESSION["tusuarios"][$userid];
}else{
	echo "fallooooo";
}
?>
<div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>
<form name='modificar' method="POST" action="index.php?orden=Modificar&id=<?= $userid ?>" id="modificar">
<table>
	<tr>
		<td>Identificador</td>
		<td><input type="text" name="identificador" READONLY value="<?=$userid?>"></td>
	</tr>
		<tr>
		<td>Correo electrónico</td>
		<td><input type="text" name="correo" value="<?=$user[2]?>"></td>
	</tr>
	<tr>
		<td>Contraseña</td>
		<td><input type="password" name="contrasenia" value="<?=$user[0]?>"></td>
	</tr>
	<tr>
		<td>Repetir contraseña</td>
		<td><input type="password" name="repcontrasenia" value="<?=$user[0]?>"></td>
	</tr>
 	<tr>
		<td>Estado</td>
		<td>
			<select size="3" name="estado">
				<?php
					foreach(ESTADOS as $c => $v){
						if($c == $user[4]){
							echo "<option selected='selected' value='$c'>$v</option>";
						}else{
							echo "<option value='$c'>$v</option>";
						}
					}
				?>
			</select>
		</td>
	</tr>
	 	<tr>
		<td>Plan</td>
		<td>
			<select size="4" name="plan">
				<?php
					foreach(PLANES as $c => $v){
						if($c == $user[3]){
							echo "<option selected='selected' value='$c'>$v</option>";
						}else{
							echo "<option value='$c'>$v</option>";
						}
					}
				?>
			</select>
		</td>
	</tr>
</table>
<input type="submit" value="enviar">	<button><a href="index.php">Cancelar</a></button>
</form>
<?php 
$contenido = ob_get_clean();
include_once "principal.php";
?>
