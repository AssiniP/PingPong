<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class LobbyController{
    private $renderer;
    private $userModel;
    private $session;
    public function __construct($userModel, $renderer) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
        $this->session = new Session();
    }
    public function list() {
        $data["usuario"] = $this->userModel->getUser($this->session->get('nickname'));
        $this->renderer->render('lobby',$data);
    }

}