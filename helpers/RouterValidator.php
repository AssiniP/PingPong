<?php
require_once('helpers/Session.php');
class RouterValidator{
    private $configuration;
    private $router;
    private $session;
    public function __construct($configuration) {
        $this->configuration = $configuration;
        $this->router = $this->configuration->getRouter();
        $this->session = new Session();
    }

    public function validateRoute($module, $method){
        if($module == 'user' && $method == 'validate'){
            $this->router->route($module, $method);
            exit();
        }

        if($this->checkModule($module) && $this->checkMethod($method)){
            $this->router->route($module, $method);
        } else{
            header('location: /');
        }
    }

    private function checkModule($module){
        switch ($module) {
            case 'login':
            case 'pingPong':
            case 'register':
                return true;
            case 'partida':
            case 'lobby':
            case 'user':
                if($this->userIsLogged()){
                    return true;
                }
                return false;
        }
    }

    private function userIsLogged(){
        if($this->session->get('logged')){
            return true;
        }
        return false;
    }

    //clases al pepe, las dejo porque las pense
    private function userRoleIs($value){
        if($this->session->get('rol') == $value){
            return true;
        }
        return false;
    }

    private function checkMethod($method){
        return true;
    }
}