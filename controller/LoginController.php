<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class LoginController{
    private $renderer;
    private $userModel;

    public function __construct($userModel, $renderer) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->renderer->render('login');
    }

    public function authenticate() {
        $errorMsg = [];
        $nickname = $_POST['nickname'];
        $password = md5($_POST['password']);

        $data["usuario"] = $this->userModel->validarLogin($nickname, $password);
        if (count($data["usuario"])>0) {
            if (!$data["usuario"][0]["cuentaValida"]){
                $errorMsg[] = 'Cuenta no validada, verifica tu mail.';
                $data['errorMsg'] = $errorMsg;
                $this->renderer->render('login', $data);
                exit();
            }
            $_SESSION['nickname'] = $nickname;
            $_SESSION['rol'] = $data["usuario"][0]["rol"];
            $_SESSION['logged'] = true;
            //no sé como llamar esta chota pero indica si la persona esta logeada o no (lol)
            header('location: /lobby/list');
            exit();
        } else {
            $errorMsg[] = 'Usuario o contraseña incorrectos.';
            $data['errorMsg'] = $errorMsg;
            $this->renderer->render('login', $data);
            exit();
        }
    }

    public function logout() {
        session_destroy();
        //$this->session->destroy();
        header('location: /');
        exit;
    }
}
