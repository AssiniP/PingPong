<?php

class LoginController {
    private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->renderer->render('login');
    }

      public function authenticate() {

        $nickname = $_POST['nickname'];
        $password = md5($_POST['password']);

        $data["usuario"] = $this->userModel->validarLogin($nickname, $password);
        // Validar las credenciales del usuario
        if (count($data["usuario"])>0) {
            // Iniciar sesión exitosamente
            session_start();
            $_SESSION['nickname'] = $nickname;
            $this->renderer->render('crearPartida'); // Redirijo al login // Redirigir a la página de inicio después de iniciar sesión
            exit();
        } else {
            echo 'Usuario o contraseña incorrectos.';
        }

    }

    public function logout() {
        session_start();
        session_destroy();
        $this->renderer->render('login'); // Redirijo al login
        exit();
    }
}