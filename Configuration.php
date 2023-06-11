<?php
//Ni puta idea de por qué esta esto acá pero no los toco
//Tendriamos qué ver en qué lugar nos pide esto así los volamos lol
include_once('helpers/Logger.php');
include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once ('third-party/phpqrcode/qrlib.php');

class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }
    public function getUserController() {
        include_once('controller/UserController.php');
        include_once ('model/UserModel.php');
        return new UserController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getLoginController() {
        include_once ('controller/LoginController.php');
        include_once ('model/UserModel.php');
        return new LoginController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getPingPongController() {
        include_once ('controller/PingPongController.php');
        return new PingPongController($this->getRenderer());
    }

    public function getRegisterController(){
        include_once ('controller/RegisterController.php');
        include_once ('model/UserModel.php');
        return new RegisterController(new UserModel($this->getDatabase()),$this->getRenderer());
    }

    public function getLobbyController(){
        include_once('controller/LobbyController.php');
        include_once ('model/UserModel.php');
        return new LobbyController(new UserModel($this->getDatabase()), $this->getRenderer());
    }

    public function getPartidaController(){
        include_once ('controller/PartidaController.php');
        include_once ('model/PartidaModel.php');
        include_once ('model/UserModel.php');
        return new PartidaController(new PartidaModel($this->getDatabase()), $this->getRenderer());
    }

    public function getAPIController()
    {
        include_once('controller/APIController.php');
        return new APIController();
    }

    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        include_once("helpers/MustacheRender.php");
        return new MustacheRender('view/partial');
    }

    public function getDatabase() {
        include_once('helpers/MySqlDatabase.php');
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']);
    }

    public function getRouter() {
        include_once('helpers/Router.php');
        return new Router(
            $this,
            "getPingPongController",
            "list");
    }
}

