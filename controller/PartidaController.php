<?php
require_once (SITE_ROOT . '/helpers/Session.php');
class PartidaController{
    private $renderer;
    private $partidaModel;
    public function __construct($partidaModel, $renderer) {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
    }

    public function list(){
        $this->renderer->render('nuevaPartida');
    }

    public function jugar(){


    }

}