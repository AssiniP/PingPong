<?php
include_once('helpers/MySqlDatabase.php');

include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('helpers/Logger.php');



include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');

//INCLUIR ACA MODELOS Y CONTROLADORES
include_once ('controller/PingPongController.php');
include_once ('controller/LoginController.php');
include_once('controller/UserController.php');
include_once ('controller/RegisterController.php');
//include_once ('controller/MailValiderController.php');
include_once ('third-party/phpqrcode/qrlib.php');
include_once('controller/LobbyController.php');
include_once ('controller/PartidaController.php');

include_once ('model/UserModel.php');
include_once ('model/PartidaModel.php');
//include_once ('model/EmailModel.php');
//include_once ('model/loginModel.php');

class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }
    public function getUserController() {
        return new UserController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getLoginController() {
        return new LoginController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getPingPongController() {
        return new PingPongController($this->getRenderer());
    }

    public function getRegisterController(){
        return new RegisterController(new UserModel($this->getDatabase()),$this->getRenderer());
    }

    public function getLobbyController(){
        return new LobbyController(new UserModel($this->getDatabase()), $this->getRenderer());
    }

    public function getPartidaController(){
        return new PartidaController(new PartidaModel($this->getDatabase()), $this->getRenderer(), new UserModel($this->getDatabase()));
    }


    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        return new MustacheRender('view/partial');
    }

    public function getDatabase() {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
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

