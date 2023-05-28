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
            $this->renderer->render('pingPong');
        } else {
            $data["usuario"] = $this->userModel->getUsers($_SESSION['nickname']);
            $this->renderer->render('users',$data);
        }

    }

    public function mostrar(){
        session_start();
        if(empty($_SESSION['nickname'])) {
            $this->renderer->render('pingPong');
        } else {
            $data["usuario"] = $this->userModel->getUsers($_SESSION['nickname']);
            $this->renderer->render('lobby',$data);
        }
    }

    public function validate(){
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $data["usuario"] = $this->userModel->validarMail($email);
            $this->renderer->render('lobby', $data);
        } else {
            $this->renderer->render('pingPong');
        }
    }

}