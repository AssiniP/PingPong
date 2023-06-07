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
            case 'lobby':
            case 'user':
            case 'partida':
                if($this->userIsLogged()){
                    return true;
                }
                return false;
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

    //funciones al pepe, las dejo porque las pense
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
            default:
                return true;
        }

    }

    private function questionExists()
    {
        if (isset($_GET['opcion']) || isset($_GET['pregunta'])) {
            $pregunta = $_GET['pregunta'];
            $opcion = $_GET['opcion'];
            $preguntaExistentes = $this->database->query("select count(id) as 'cantidad' from pregunta order by id;");
            $value = $preguntaExistentes[0]["cantidad"];
            if ($opcion < 1 || $opcion > 4 || intval($value) < intval($pregunta)) {
                return false;
            }

            return true;
        }
    }
}