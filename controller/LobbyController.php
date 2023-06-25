<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class LobbyController{
    private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }
    public function list() {
        $data["usuarioInfo"] = $this->userModel->getUserInfo($_SESSION['nickname']);
        $data["usuarioJuego"] = $this->userModel->getUserGameInfo($_SESSION['nickname']);
        $this->renderer->render('lobby',$data);
    }

    public function historial(){
        $data["usuario"] = $this->userModel->getUser($_SESSION['nickname']);
        $data["historial"] = $this->userModel->getHistorial($data["usuario"][0]["id"]);
        $this->renderer->render('historial',$data);
    }

    public function ranking(){
        $data["usuario"] = $this->userModel->getRanking();
        $this->renderer->render('ranking',$data);
    }

}