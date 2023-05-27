<?php
include_once('helpers/MySqlDatabase.php');

include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');


include_once('third-party/mustache/src/Mustache/Autoloader.php');


include_once('helpers/MariaDBDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');

//INCLUIR ACA MODELOS Y CONTROLADORES
include_once ('controller/PingPongController.php');
include_once ('controller/LoginController.php');
include_once('controller/UserController.php');
include_once('controller/GenerarQRController.php');
include_once ('controller/RegisterController.php');
include_once ('controller/MailValiderController.php');
include_once ('third-party/phpqrcode/qrlib.php');

include_once ('model/UserModel.php');
include_once ('model/EmailModel.php');
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

    public function getGenerarQRController() {
        return new GenerarQRController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }


    public function getPingPongController() {
        return new PingPongController($this->getRenderer());
    }

    public function getMailValiderController() {
        return new MailValiderController(new EmailModel(),$this->getRenderer());
    }


    public function getRegisterController(){
        return new RegisterController(new UserModel($this->getDatabase()),$this->getRenderer());
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

