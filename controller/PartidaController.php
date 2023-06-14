<?php
require_once(SITE_ROOT . '/helpers/Session.php');
class PartidaController
{
    private $renderer;
    private $partidaModel;
    public function __construct($partidaModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
    }

    public function list()
    {
        $_SESSION['jugando'] = true;
        $this->partidaModel->addPartida($this->partidaModel->getIDUsuarioActual());
        $partidas = $this->partidaModel->getLastPartida($this->partidaModel->getIDUsuarioActual());
        $data = array('partidas' => $partidas);
        $this->renderer->render('nuevaPartida', $data);
    }

    public function jugada()
    {
        $partidas = $this->partidaModel->getLastPartida($this->partidaModel->getIDUsuarioActual());
        $data = array('partidas' => $partidas);
        $this->renderer->render('jugada', $data);
    }
    public function respuesta()
    {
        $arrayDatos = $this->partidaModel->juego();
        $data['mensaje'] = $arrayDatos['arrayDatos']['mensaje'];
        $data['url'] = $arrayDatos['arrayDatos']['url'];
        $data['texto'] = $arrayDatos['arrayDatos']['texto'];
        $data['pregunta'] = $arrayDatos['arrayDatos']['pregunta'];
        $data['puntaje'] = $arrayDatos['arrayDatos']['puntaje'];
        $this->renderer->render('respuesta', $data);
    }

    public function reportarPregunta(){
        echo 'AJAX request received';
        $motivo = $_POST['motivo'];
        $idUsuario = $_POST['idUsuario'];
        $idPregunta = $_POST['idPregunta'];
        var_dump($motivo);
        var_dump($idUsuario);
        var_dump($idPregunta);
        header('location:/register/list');
        $this->partidaModel->reportarPregunta($motivo, $idUsuario, $idPregunta);
    }
}
