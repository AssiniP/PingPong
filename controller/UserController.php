<?php

class UserController {
    private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        session_start();
        if(empty($_SESSION['nickname'])) {
            $this->renderer->render('index');
        } else {
            $data["usuario"] = $this->userModel->getUsers($_SESSION['nickname']);
            $this->renderer->render('users',$data);
        }

    }

}