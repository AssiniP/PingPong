<?php
require_once (SITE_ROOT . '/helpers/Session.php');
class PartidaController{
    private $renderer;
    private $partidaModel;
    private $session;
    public function __construct($partidaModel, $renderer) {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
        $this->session = new Session();
    }

    public function list(){
        if($this->session->get('logged')){
            $this->renderer->render('nuevaPartida');
        } else{
            header('location: /');
        }
    }

    public function jugar(){


    }

}