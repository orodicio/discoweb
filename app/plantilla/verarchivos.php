<?php
ob_start();
//tabla para ver los archivos y subir nuevos archivos de los usuarios
?>
    <div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>
    <br>
    <div id="tituloTabla"><h2>Ficheros del Usuario: <?= $_SESSION['user'] ?></h2></div>
<?php if (!empty($justFiles)) { ?>
    <div id="info">
    <h3>Número de
        ficheros: <?= count($justFiles) ?><?= (obtieneNumeroPlan($_SESSION['tipouser']) != 3) ? "/" . LIMITE_FICHEROS[obtieneNumeroPlan($_SESSION['tipouser'])] : "" ?></h3>
    <h3>
        Espacio: <?= number_format((ModeloFicherosDB::FileGetAllSizeByUser($_SESSION['user'])["suma_total"]) / (1024 * 1024), 2) . "MB" ?>
        <?= (obtieneNumeroPlan($_SESSION['tipouser']) != 3) ? "/" . number_format((LIMITE_ESPACIO[obtieneNumeroPlan($_SESSION['tipouser'])]) / (1024 * 1024), 2) . "MB" : "" ?>
    </h3>
<?php } ?>
    </div>
    <table id="verArchivos">
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Tamaño</th>
            <th>Fecha de creacion</th>
            <th colspan="3">Operaciones</th>
        </tr>

        <?php
        if (!empty($justFiles)) {
            foreach ($justFiles as $archivo) : ?>
                <tr>
                    <td><a href="index.php?orden2=Descargar&id=<?= $archivo["nombre"] ?>"><?= $archivo["nombre"] ?></a>
                    </td>
                    <td><?= mime_content_type($directorio . '/' . $archivo["nombre"]) ?></td>
                    <td><?= $archivo['size'] ?></td>
                    <td><?= date("d/m/y H:i:s", filectime($directorio . '/' . $archivo["nombre"])) ?></td>
                    <td><a href="#" class="borrar operacion" data-id="<?= $archivo["nombre"] ?>">Borrar</a></td>
                    <td><a href="#" class="renombrar operacion" data-id="<?= $archivo["nombre"] ?>">Renombrar</a></td>
                    <td>
                        <a href="<?= $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?orden2=Compartir&id=<?= $archivo["hash"] ?>"
                           class="compartir operacion">Compartir</a></td>
                </tr>
            <?php endforeach;
        } else {
            ?>
            <tr>
                <td colspan="5" style="text-align: center;">No tiene ningún fichero aún</td>
            </tr>
        <?php } ?>
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
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= TAMMAXIMOFILE ?>"/>
            <label>Elija el archivo a subir</label><br> <input name="archivo1" type="file" required="required"
                                                               class="letraPeque"/> <br/><br>
            <input type="submit" value="Subir archivo"/>
        </form>
    </div>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>