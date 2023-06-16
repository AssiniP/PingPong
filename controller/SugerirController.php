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
        $this->renderer->render('sugerir', $data);
    }

    public function eliminar() {
        $this->userModel->delQuestionId($_GET["id"]);
        header('location: /sugerir/list');
    }

    public function editar() {
        header('location: /sugerir/editar&id='.$_GET["id"]);
    }


}