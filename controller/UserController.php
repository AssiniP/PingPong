<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class UserController {
    private $renderer;
    private $userModel;

    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $data["usuario"] = $this->userModel->getAllUsers();
        $this->renderer->render('users', $data);
    }

    public function mostrar(){
        $data["usuario"] = $this->userModel->getUser($_SESSION['nickname']);
        $this->renderer->render('users', $data);
    }

    public function validate(){
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $this->userModel->actualizarCuentaValidada($email);
            header('location: /login/list');
        } else{
            header('location: / ');
        }
    }


    public function seeProfile(){
        if(!empty($_GET['nick'])){
            $data["usuario"] = $this->userModel->getUser($_GET['nick']);
            $this->renderer->render('users', $data);
        }}
}