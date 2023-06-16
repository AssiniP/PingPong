<?php

class RegisterController
{  private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list(){
        $data["verGenero"] = $this->userModel->getAllGenero();
        $this->renderer->render('register',$data);
    }

    public function validateFields()
    {
        $errorMsg = [];

        if (!$this->checkThatUserFormIsNotEmpty()) {
            $errorMsg[] = "Llena todos los campos";
        }
        if (!$this->checkMatchingPassword()) {
            $errorMsg[] = "Las contraseñas no coinciden";
        }

        if (count($this->checkEmailAndNick()) > 0) {
            $errorMsg[] = 'Ya existe el mail y/o el usuario';
        }

        if (!$this->checkUbicacionMapa()) {
            $errorMsg[] = "Marcar la Ubicacion del Mapa con click Derecho";
        }

        $response = ['errorMsg' => $errorMsg];

        if (!empty($errorMsg)) {
            // Enviar respuesta con errores en formato JSON
            echo json_encode($response);
        } else {
            // Llamar a la función add() dentro de un bloque try-catch
            $response = ['success' => true];
            echo json_encode($response);
            try{
                $this->add();
            } catch (Exception $e) {
            }
        }
    }

    private function add(){
        $imgType = strtolower(pathinfo($_FILES["imagenPerfil"]["name"], PATHINFO_EXTENSION));
        $imgPath = $_POST['nickName'] . "." . $imgType;
        $fullPath = SITE_ROOT . "/public/foto-perfil/" . $imgPath;
        move_uploaded_file($_FILES['imagenPerfil']['tmp_name'], $fullPath);
        $userData = [
            'nickName' => $_POST['nickName'],
            'password' => md5($_POST['password']),
            'email' => $_POST['email'],
            'nombre' => $_POST['nombre'],
            'imagenPerfil' => $imgPath,
            'pais' => $_POST['pais'],
            'latitud' => $_POST['latitud'],
            'fechaNacimiento' => $_POST['fechaNacimiento'],
            'longitud' => $_POST['longitud'],
            'idGenero' => $_POST['idGenero'],
            'ciudad' => $_POST['ciudad'],
            'idRol' => 3];

           $this->userModel->addUser($userData);
           $this->userModel->enviarMail($_POST['email']);
           $this->userModel->generateQR($_POST['nickName']);
    }

    private function checkThatUserFormIsNotEmpty(){
        if(empty($_POST['nickName']) || empty($_POST['email']) || empty($_POST['password']) ||
            empty($_POST['repassword']) || empty($_POST['nombre']) || empty($_POST['fechaNacimiento']) ||
            $_FILES['imagenPerfil']['error'] == 4 || empty($_POST['pais']) || empty($_POST['idGenero']) ||
            empty($_POST['ciudad'])){
            return false;
        }
        return true;
    }

    private function checkMatchingPassword(){
        if($_POST['password'] != $_POST['repassword']){
            return false;
        }
        return true;
    }


    private function checkUbicacionMapa(){
        if(empty($_POST['latitud'] ) || empty($_POST['longitud'])){
            return false;
        }
        return true;
    }

    private function checkEmailAndNick(){
        $nickname = $_POST['nickName'];
        $email = $_POST['email'];
        $data["usuario"] = $this->userModel->check_user($nickname, $email);
        return $data["usuario"];
    }
}