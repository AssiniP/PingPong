<?php
include_once('helpers/MariaDBDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');

//INCLUIR ACA MODELOS Y CONTROLADORES
include_once ('controller/PingPongController.php');
include_once ('controller/LoginController.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');

class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }

    public function getPingPongController(){
        return new PingPongController($this->getRenderer());
    }

    public function getLoginController(){
        return new LoginController($this->getRenderer());
    }

    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        return new MustacheRender('view/partial');
    }

    public function getDatabase() {
        $config = $this->getArrayConfig();
        return new MariaDBDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']);
    }

    public function getRouter() {
        return new Router(
            $this,
            "getPingPongController",
            "list");
    }
}
