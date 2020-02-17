<!DOCTYPE html>
<html>

<head>
    <!--palntilla común para todas las páginas: header, footer y contenido-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD DE USUARIOS</title>
    <link href="web/css/common.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="web/css/body.css">
    <link rel="stylesheet" href="web/css/header.css">
    <link rel="stylesheet" href="web/css/footer.css">
    <link rel="stylesheet" href="web/css/acceso.css">
    <link rel="stylesheet" href="web/css/modificarUsuarioAdmin.css">
    <link rel="stylesheet" href="web/css/nuevoUsuario.css">
    <link rel="stylesheet" href="web/css/verArchivos.css">
    <link rel="stylesheet" href="web/css/verusuarios.css">
    <link rel="icon" type="image/png" sizes="32x32" href="web/img/favicono.png">
    <script src="web/lib/jquery.js"></script>
    <script type="text/javascript" src="web/js/funciones.js"></script>
</head>

<body>
<section>
    <header>
        <div id="logo"><img src="./web/img/boladiscoteca.png" alt="boladiscoteca"/></div>
        <h1>MI DISCO EN LA NUBE <span class="letratexto">versión 1.0</span></h1>
    </header>
    <article>
        <?= $contenido ?>
    </article>
    <footer>
        <div id="copy">
            <p>Copyrigth:nuestracreaciones</p>
        </div>
        <div id="nombres">
            <p>Creadores: Olalla Rodicio y Diego Camargo</p>
        </div>
        <div id="atribucion">Iconos diseñados por <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a>
            from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>
    </footer>
</section>
</body>

</html>