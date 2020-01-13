<?php
session_start();
include_once 'app/config.php';
include_once 'app/controlerFile.php';
include_once 'app/controlerUser.php';
include_once 'app/modeloUser.php';
include_once 'app/RoutesMapper.php';


loadUserFixture();
$routesMappper = new RoutesMapper();

$order = $_GET['orden'] ?: $_GET['orden2'];
// Si no hay usuario a Inicio
if (!isset($_SESSION['user'])) {
    $routesMappper::user($order)->execute();
    exit;
}

if ($_SESSION['modo'] == GESTIONUSUARIOS) {
    $routesMappper::user($order)->execute();
    exit;
}

if ($_SESSION['modo'] == GESTIONFICHEROS) {
    $routesMappper::file($order)->execute();
}

