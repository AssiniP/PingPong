<?php
define ('SITE_ROOT', realpath(dirname(__FILE__)));
require_once('helpers/Session.php');
$session = new Session();
include_once('Configuration.php');
$configuration = new Configuration();

//Lo mismo que tenía el profe, excepto que con una expresion ternaria
$module = isset($_GET['module']) ? $_GET['module'] : 'pingPong';
//aca se puede remplazar con otro metodo que tengan todos sí o sí
$method = isset($_GET['method']) ? $_GET['method'] : 'list';

//la fumancheada empieza aca abajo
include_once('helpers/RouterValidator.php');
$validator = new RouterValidator($configuration);
$validator->validateRoute($module, $method);
