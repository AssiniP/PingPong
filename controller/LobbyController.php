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
        if($this->session->get('logged')){
            $this->renderer->render('lobby');
        }else{
            header('location: /');
        }
    }

}