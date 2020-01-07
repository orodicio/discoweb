<?php
ob_start();

?>
    <table>
        <tr>
            <?php
            $auto = $_SERVER['PHP_SELF'];
            // Nombre archivo => tipo, fecha y tamaño
            ?>
            <?php foreach ($archivosUsuario as $archivo => $datosarchivo) : ?>
        <tr>
            <td><?= $archivo ?></td>
            <?php for  ($j=0; $j < count($datosarchivo); $j++) :?>
                <td><?=$datosarchivo[$j] ?></td>
            <?php endfor;?>
            <td><a href="#"
                   onclick="confirmarBorrarArchivo('<?= $archivo?>);">Borrar</a></td>
            <td><a href="<?= $auto?>?orden2=Renombrar&id=<?= $archivo ?>">Renombrar</a></td>
            <td><a href="<?= $auto?>?orden2=Compartir&id=<?= $archivo?>">Compartir</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <form action='index.php' method="post">
        <!--<input type='hidden' name='orden' value='Cerrar'> <input type='submit'
            value='Cerrar Sesión'>-->
        <input type='submit' value='Cerrar Sesión' formaction="index.php?orden2=Cerrar">
        <input type='submit' value='Subir' formaction="index.php?orden2=Subir">
        <input type='submit' value='Modificar Datos' formaction="index.php?orden2=Modificar">
    </form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>