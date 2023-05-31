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
        $this->renderer->render('nuevaPartida');
    }

    public function jugar(){


    }

}