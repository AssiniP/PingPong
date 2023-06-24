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

    public function empezarJugada(){
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $idPregunta = $data['idPregunta'];
        $this->partidaModel->empezarJugada($idPregunta);
    }
    public function respuesta()
    {
        $arrayDatos = $this->partidaModel->juego();
        $data['mensaje'] = $arrayDatos['arrayDatos']['mensaje'];
        $data['url'] = $arrayDatos['arrayDatos']['url'];
        $data['texto'] = $arrayDatos['arrayDatos']['texto'];
        $data['pregunta'] = $arrayDatos['arrayDatos']['pregunta'];
        $data['puntaje'] = $arrayDatos['arrayDatos']['puntaje'];
        $data['preguntaId'] = $arrayDatos['arrayDatos']['preguntaId'];
        $data['usuarioId'] = $arrayDatos['arrayDatos']['usuarioId'];
        $this->renderer->render('respuesta', $data);
    }

    public function terminarPartida(){
        $url = $_GET['url'];
        $_SESSION['jugando'] = false;
        header('location:' . $url);
    }

    public function reportarPregunta(){
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $motivo = $data['motivo'];
        $idUsuario = $data['idUsuario'];
        $idPregunta = $data['idPregunta'];
        var_dump($motivo);
        var_dump($idUsuario);
        var_dump($idPregunta);
        $this->partidaModel->reportarPregunta($motivo, $idUsuario, $idPregunta);
    }

    public function usarTrampita()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $idUsuario = $data['idUsuario'];

        $tieneTrampitas = $this->partidaModel->verificarTrampitas($idUsuario);

        if ($tieneTrampitas) {
            $this->partidaModel->trampitaUsada($idUsuario);
        }

        $response = array('tieneTrampita' => $tieneTrampitas);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function comprarTrampita(){
        $this->partidaModel->comprarTrampita();
    }
}
