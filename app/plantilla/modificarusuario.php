<?php
//formulario para modificar usuarios del administrador
ob_start();
$userid =$_GET["id"];
if(isset($userid)){
	$user =modeloUserDB::UserGet($userid);
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
        <td>Nombre</td>
        <td><input type="text" name="nombre" value="<?=$user[2]?>"></td>
    </tr>
		<tr>
		<td>Correo electrónico</td>
		<td><input type="text" name="correo" value="<?=$user[3]?>"></td>
	</tr>
	<tr>
		<td>Contraseña</td>
		<td><input type="password" name="contrasenia"></td>
	</tr>
	<tr>
		<td>Repetir contraseña</td>
		<td><input type="password" name="repcontrasenia"></td>
	</tr>
 	<tr <?php if ($_SESSION['tipouser']!="Máster"){echo "hidden";}?>>
		<td>Estado</td>
		<td>
			<select size="3" name="estado">
				<?php
					foreach(ESTADOS as $c => $v){
						if($c == $user[5]){
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
</table>
<input type="submit" value="enviar">	<input type="submit"  value="Cancelar" formaction="index.php?orden=<?=($_SESSION['tipouser']=="Máster")?'VerUsuarios': 'cambiarModo'?>">
</form>
<?php 
$contenido = ob_get_clean();
include_once "principal.php";
?>
