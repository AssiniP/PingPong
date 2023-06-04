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
            $this->partidaModel->addPartida($this->partidaModel->getIDUsuarioActual());
            $partidas = $this->partidaModel->getLastPartida($this->partidaModel->getIDUsuarioActual());
            $data = array('partidas' => $partidas);
            $this->renderer->render('nuevaPartida', $data);
        } else {
            header('location: /');
        }
    }

    public function jugar()
    {
        if ($this->session->get('logged')) {
            $pregunta = $this->partidaModel->getPregunta($this->partidaModel->getIDUsuarioActual());
            $data = array('preguntas' => $pregunta);
            $this->renderer->render('jugar', $data);
        } else {
            header('location: /');
        }
    }

    public function respuesta (){
        if (isset($_GET['opcion']) && isset($_GET['pregunta'])) {
            $preguntaId = $_GET['pregunta'];
            $this->partidaModel->createJugada($preguntaId, $this->partidaModel->getIDPartidaActual());
            $opcionSeleccionada = $_GET['opcion'];
            $respuestaCorrecta = $this->partidaModel->getRespuestaCorrecta($preguntaId);
            $idPartida = $this->partidaModel->getIDPartidaActual();
            if (intval($opcionSeleccionada) == intval($respuestaCorrecta)) {
                $data['mensaje'] = "CORRECTO";
                $data['url'] = "/partida/jugar";
                $data['texto'] = "Siguiente Pregunta";
                $this->partidaModel->updateJugada($preguntaId, $idPartida, 1);
            } else {
                $data['mensaje'] = "FIN DEL JUEGO";
                $data['url'] = "/lobby/list";
                $data['texto'] = "Volver al Lobby";
                $this->partidaModel->updateJugada($preguntaId, $idPartida, 0);
            }
            $data['pregunta'] = $this->partidaModel->getPreguntaByID($preguntaId);
            $lastPreguntaID = $this->partidaModel->getLastInsertedPreguntaId();
            $this->partidaModel->setPreguntaUsuario($this->partidaModel->getIDUsuarioActual(), $preguntaId);
            if (intval($lastPreguntaID) == intval($preguntaId)) {
                $this->partidaModel->deleteUsuarioPartida($this->partidaModel->getIDUsuarioActual());
            }
            $respuestasCorrectas = $this->partidaModel->countRespuestasCorrectas($idPartida);
            $this->partidaModel->updatePuntajePartida($idPartida, $respuestasCorrectas);
            $puntaje = $this->partidaModel->obtenerPuntajeDeLaPartida($idPartida);
            $data['puntaje'] = $puntaje;
        } 
        $this->renderer->render('respuesta', $data);
    }




}
