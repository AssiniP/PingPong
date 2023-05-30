<?php
require_once( SITE_ROOT . '/helpers/Session.php');
class LoginController{
    private $renderer;
    private $userModel;
    private $session;
    public function __construct($userModel, $renderer) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
        $this->session = new Session();
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
            $this->session->set('nickname', $nickname);
            $this->session->set('rol', $data["usuario"][0]["rol"]);
            //no sé como llamar esta chota pero indica si la persona esta logeada o no (lol)
            $this->session->set('logged', true);
            header('location: /lobby/list');
            exit();
        } else {
            $errorMsg[] = 'Usuario o contraseña incorrectos.';
            $data['errorMsg'] = $errorMsg;
            $this->renderer->render('login', $data);
            exit;
        }
    }

    public function logout() {
        $this->session->destroy();
        header('location: /');
        exit;
    }
}
