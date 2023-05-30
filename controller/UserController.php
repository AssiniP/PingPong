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
            $this->userModel->actualizarCuentaValidada($email);
            $data["usuario"] = $this->userModel->validarMail($email);
            session_start();
            $_SESSION['nickname'] = $data["usuario"][0]["nickName"];
            $rol = $data["usuario"][0]["rol"];
            $_SESSION['rol'] = $rol;
            $this->renderer->render('lobby', $data);
        } else {
            $this->renderer->render('pingPong');
        }
    }


    public function seeProfile(){
        session_start();
        if(empty($_SESSION['nickname'])) {
            $this->renderer->render('pingPong');
        } else {
            if(!empty($_GET['nick'])) {
                $data["usuario"] = $this->userModel->getUsers($_GET['nick']);
                $this->renderer->render('users', $data);
            }
    }

}}