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
        $preguntas = $this->partidaModel->getPreguntasConOpciones();
        $data = array('preguntas' => $preguntas);
        $this->renderer->render('partida', $data);
    }

    public function crearPartida(){
        $idUsuario = 1; /* x defecto 1 xq se q van a mover la sesión de los controller. */
        $this->partidaModel->insertPartida($idUsuario);
        header('location: /partida/list');
    }
}