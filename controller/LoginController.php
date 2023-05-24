<?php
class LoginController{
    private $renderer;
    private $userModel;
    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    function list() {
        $this->renderer->render('loginForm');
    }

    function authenticate() {
        $nickname = $_POST['nickname'];
        $password = md5($_POST['password']);
        var_dump($password);
        var_dump($nickname);

        $data['user']= $this->userModel->validarLogin($nickname, $password);

        var_dump($data);
/*
        // Validar las credenciales del usuario
        if ($nickname === 'admin' && $password === 'admin123') {
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
        }*/
    }

    function logout() {
        session_start();
        session_destroy();
        $this->renderer->render('loginForm'); // Redirijo al login
        exit();
    }
}
