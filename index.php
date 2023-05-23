<?php
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

//Lo mismo que tenía el profe, excepto que con una expresion ternaria
$module = isset($_GET['module']) ? $_GET['module'] : 'pingPong';
//aca se puede remplazar con otro metodo que tengan todos sí o sí
$method = isset($_GET['method']) ? $_GET['method'] : 'list';

$router->route($module, $method);