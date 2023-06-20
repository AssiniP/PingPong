<?php

class RegisterController
{  private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list(){
        $data["paises"] = $this->userModel->getPaises();
        $data["verGenero"] = $this->userModel->getAllGenero();
        $this->renderer->render('register',$data);
    }

    public function validateFields()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if ($jsonData != null) {
                $body = json_decode($jsonData);
                if (count($this->checkEmailAndNick($body->nickName ,$body->email )) > 0) {
                    $errorMsg = 'Ya existe el mail y/o el usuario';
                    $response = ['errorMsg' => $errorMsg];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }else {
                    $this->add($body);
                    header('Content-Type: application/json');
                    $response = ['success' => true];
                    echo json_encode($response);
                }
            }
        }
    }

    private function add($body){
        $imgType = strtolower(pathinfo($_FILES["imagenPerfil"]["name"], PATHINFO_EXTENSION));
        $imgPath = $body->nickName . "." . $imgType;
        $fullPath = SITE_ROOT . "/public/foto-perfil/" . $imgPath;
        move_uploaded_file($_FILES['imagenPerfil']['tmp_name'], $fullPath);

        $this->userModel->addUser($body,$imgPath);
        $this->userModel->enviarMail($body->email);
        $this->userModel->generateQR($body->nickName);
    }

    private function checkEmailAndNick($nickname, $email){
        $data["usuario"] = $this->userModel->check_user($nickname, $email);
        return $data["usuario"];
    }
}