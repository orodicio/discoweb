<?php
session_start();
include_once 'app/config.php';
include_once 'app/controlerFile.php';
include_once 'app/controlerUser.php';
include_once 'app/modeloUser.php';
include_once 'app/RoutesMapper.php';


loadUserFixture();
$routesMappper = new RoutesMapper();
// Si no hay usuario a Inicio
if (!isset($_SESSION['user'])) {
    $order = $_GET['orden'] ?: '';
    $procRuta = $routesMappper::user($order);
    $procRuta();
    exit;
}

if ($_SESSION['modo'] == GESTIONUSUARIOS) {
    $order = $_GET['orden'] ?: '';
    $procRuta = $routesMappper::user($order);
    $procRuta();
    exit;
}

if ($_SESSION['modo'] == GESTIONFICHEROS) {
    $order = $_GET['orden2'] ?: '';
    $procRuta = $routesMappper::file($order);
    $procRuta();
}



