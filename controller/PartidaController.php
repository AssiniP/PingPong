<?php
require_once(SITE_ROOT . '/helpers/Session.php');
class PartidaController
{
    private $renderer;
    private $partidaModel;
    private $session;
    public function __construct($partidaModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
        $this->session = new Session();
    }

    public function list() {
        if ($this->session->get('logged')) {
            $this->partidaModel->addPartida();
            if ($this->session->get('logged')) {
                $idUsuario = 1; // Reemplaza esto con la forma de obtener el ID del usuario
                $partidas = $this->partidaModel->getLastPartida($idUsuario);
                $data = array('partidas' => $partidas);
                $this->renderer->render('nuevaPartida', $data);
            } else {
                header('location: /');
            }
        }
    }

     public function jugar() {
        if ($this->session->get('logged')) {
            if ($this->session->get('logged')) {
                $pregunta = $this->partidaModel->getPregunta();
                $data = array('preguntas' => $pregunta);
                $this->renderer->render('jugar', $data);
            } else {
                header('location: /');
            }
        }
    }
    
    
}
