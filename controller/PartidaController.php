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

    public function list()
    {
        if ($this->session->get('logged')) {
            $this->partidaModel->addPartida($this->getIDUsuarioActual());
            $partidas = $this->partidaModel->getLastPartida($this->getIDUsuarioActual());
            $data = array('partidas' => $partidas);
            $this->renderer->render('nuevaPartida', $data);
        } else {
            header('location: /');
        }
    }

    public function jugar()
    {
        if ($this->session->get('logged')) {
            $pregunta = $this->partidaModel->getPregunta();
            $p = $pregunta[0];
            $preguntaId = $p['id'];
            $data = array('preguntas' => $pregunta);
            $partidaId = $this->getIDPartidaActual();  
            $this->partidaModel->createJugada($preguntaId, $partidaId);
            if (isset($_GET['opcion'])) {
                $opcionSeleccionada = $_GET['opcion'];
                $opcionCorrecta = $p['respuestaCorrecta'];
                if ($opcionSeleccionada == $opcionCorrecta) {
                    $this->partidaModel->updateJugada($preguntaId, $partidaId, true);
                }
            }
            $countRespuestasCorrectas = $this->partidaModel->countRespuestasCorrectas($partidaId);
            $variable = 100 * $countRespuestasCorrectas;
            var_dump($variable);
            $this->renderer->render('jugar', $data);
        } else {
            header('location: /');
        }
    }

    private function getIDUsuarioActual()
    {
        $nickname = $this->session->get('nickname');
        $user = $this->partidaModel->getUserByNickname($nickname);
        return $user[0]['id'];
    }

    private function getIDPartidaActual()
    {
        $partida = $this->partidaModel->getLastPartida($this->getIDUsuarioActual());
        $pr = $partida[0];
        return $pr['id'];
    }


}
