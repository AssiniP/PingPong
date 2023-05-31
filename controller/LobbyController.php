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
        $data["usuario"] = $this->userModel->getUser($_SESSION['nickname']);
        $this->renderer->render('lobby',$data);
    }

}