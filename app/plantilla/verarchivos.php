<?php
ob_start();
//tabla para ver los archivos y subir nuevos archivos de los usuarios
?>
    <div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<br>
    <div id="tituloTabla"><h2>Ficheros del Usuario: <?=$_SESSION['user']?></h2></div>
    <table id="verArchivos">
        <tr><th>Nombre</th>
            <th>Tipo</th>
            <th>Tamaño</th>
            <th>Fecha de creacion</th>
            <th colspan="3">Operaciones</th>
            <?php
            $auto = $_SERVER['PHP_SELF'];
            // Nombre archivo => tipo, fecha y tamaño
            ?>
        </tr>
            <?php foreach($justFiles as $archivo) : ?>
        <tr>
            <td> <a href="app/ficheros_usuarios/<?=$_SESSION['user'].'/'.$archivo?>" download="<?=$archivo?>"><?= $archivo ?></a></td>
            <td><?= mime_content_type(RUTA_FICHEROS.'/'.$_SESSION['user'].'/'.$archivo) ?></td>
            <td><?= filesize(RUTA_FICHEROS.'/'.$_SESSION['user'].'/'.$archivo).' bytes'?></td>
            <td><?= date("d/m/y H:i:s",filectime(RUTA_FICHEROS.'/'.$_SESSION['user'].'/'.$archivo))?></td>
            <td><a href="#"
                   onclick="confirmarBorrarArchivo('<?= $archivo?>);">Borrar</a></td>
            <td><a href="<?= $auto?>?orden2=Renombrar&id=<?= $archivo ?>">Renombrar</a></td>
            <td><a href="<?= $auto?>?orden2=Compartir&id=<?= $archivo?>">Compartir</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <form action='index.php' method="post">
        <input type='submit' value='Cerrar Sesión' formaction="index.php?orden2=Cerrar">
        <input type='submit' value='Modificar Datos' formaction="index.php?orden2=cambiarModo">
    </form>
    <br>
    <button id="mostrar">Subir Fichero...</button>
    <br><br>
    <div id="subida">
    <form name="f1" enctype="multipart/form-data" action="index.php?orden2=Subir" method="post">
    <!--<input type="hidden" name="MAX_FILE_SIZE" value="100000" />  100Kbytes -->
    <label>Elija el archivo a subir</label><br> <input name="archivo1" type="file" required="required" class="letraPeque"/> <br /><br>
    <input type="submit" value="Subir archivo" />
    </form>
    </div>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>