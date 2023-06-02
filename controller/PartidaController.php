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

    public function jugar()
    {
        if ($this->session->get('logged')) {
            $pregunta = $this->partidaModel->getPregunta();
            $data = array('preguntas' => $pregunta);
            $partida = $this->partidaModel->getLastPartida(1);
            $pr = $partida[0];
            $partidaId = $pr['id'];
            if (isset($_GET['opcion'])) {
                $opcionSeleccionada = $_GET['opcion'];
                // acá se verífica q la opcion sea correcta pero todavía no sé como c: 
                // Procesar la opción seleccionada y actualizar la lógica según tus necesidades
                // Obtener una nueva pregunta
                $nuevaPregunta = $this->partidaModel->getPregunta();
                $p = $nuevaPregunta[0];
                $preguntaId = $p['id'];
                $nuevaJugada = $this->partidaModel->createJugada($preguntaId, $partidaId);


                $data['preguntas'] = $nuevaPregunta;
            }

            $this->renderer->render('jugar', $data);
        } else {
            header('location: /');
        }
    }
}
