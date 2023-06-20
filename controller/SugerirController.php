<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class SugerirController {
    private $renderer;
    private $userModel;

    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $data['preguntas'] = $this->userModel->getQuestionUser($_SESSION['nickname']);
        $data["verCategoria"] = $this->userModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->userModel->getQuestionId(intval($_GET["id"]));
        }
        $this->renderer->render('sugerir', $data);
    }

    public function eliminar() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $this->userModel->delQuestionId($body->idPregunta);
            }
        }
    }

    public function addPregunta(){
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                var_dump($body);
                if(intval($body->idPregunta) == 0) {
                    $this->userModel->addQuestion($body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$body->idCategoria);

                } else {
                    $this->userModel->editQuestionId($body->idPregunta,$body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$body->idCategoria);
                }
            }
        }
    }
}