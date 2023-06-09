<?php
class RouterValidator{
    private $configuration;
    private $router;
    private $database;
    public function __construct($configuration) {
        $this->configuration = $configuration;
        $this->router = $this->configuration->getRouter();
        $this->database = $this->configuration->getDatabase();
    }

    public function validateRoute($module, $method){
        if($module == 'user' && $method == 'validate' || $method == 'getUserData'){
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
            case 'api':
                return true;
            case 'lobby':
            case 'user':
            case 'partida':
            case 'sugerir':
                if($this->userIsLogged()){
                    return true;
                }else {
                    return false;
                }
            case 'admin':
                if($this->userIsLogged() && $this->userRoleIs('Administrador')){
                    return true;
                }else {
                    return false;
                }
            case 'editor':
                if($this->userIsLogged() && $this->userRoleIs('Editor')){
                    return true;
                }else {
                    return false;
                }

        }
    }

    private function userIsLogged(){
        if($_SESSION['logged']){
            return true;
        }
        return false;
    }
    private function userIsPlaying() {
        if (isset($_SESSION['jugando']) && $_SESSION['jugando']) {
            return true;
        }
        return false;
    }

    private function userRoleIs($value){
        if($_SESSION['rol'] == $value){
            return true;
        }
        return false;
    }

    private function checkMethod($method){
        switch($method){
            case 'respuesta':
                if($this->userIsLogged() && $this->userIsPlaying() && $this->questionExists()){
                    return true;
                }
                return false;
            case 'jugada':
            case 'nuevaPartida':
                if($this->userIsLogged() && $this->userIsPlaying()){
                    return true;
                }
                return false;
            default:
                return true;
        }

    }

    private function questionExists()
    {
        if (isset($_GET['opcion']) || isset($_GET['pregunta'])) {
            $pregunta = $_GET['pregunta'];
            $preguntaExistentes = $this->database->query("select count(id) as 'cantidad' from pregunta where id=".$pregunta);
            $value = $preguntaExistentes[0]["cantidad"];
            if (intval($value) == 0) {
                return false;
            }else {
                return true;
            }
        }
        return true;
    }
}