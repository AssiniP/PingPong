<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class UserController {
    private $renderer;
    private $userModel;
    private $session;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
        $this->session = new Session();
    }

    public function list() {
        if($this->session->get('logged')){
            $data["usuario"] = $this->userModel->getAllUsers();
            $this->renderer->render('users', $data);
        }else{
            header('location: /');
        }
    }

    public function mostrar(){
        if($this->session->get('logged')){
            $data["usuario"] = $this->userModel->getUser($this->session->get('nickname'));
            $this->renderer->render('users', $data);
        }else{
            header('location: /');
        }
    }

    public function validate(){

        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $this->userModel->actualizarCuentaValidada($email);
            $data["usuario"] = $this->userModel->validarMail($email);
            $this->renderer->render('login', $data);

        } else {
            header('location: /');
        }
    }


    public function seeProfile(){
        if($this->session->get('logged')){
            if(!empty($_GET['nick'])){
                $data["usuario"] = $this->userModel->getUser($_GET['nick']);
                $this->renderer->render('users', $data);
            }
        }else{
            header('location: /');
        }

}}