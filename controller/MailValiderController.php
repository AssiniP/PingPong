<?php

class MailValiderController
{
    private $emailModel;
    private $renderer;

    public function __construct($emailModel,$renderer) {
        $this->emailModel = $emailModel;
        $this->renderer = $renderer;
    }

    public function list()
    {
        if (isset($_GET['codigo'])) {
            if($_GET['codigo']== '12345'){
                $this->renderer->render('lobby');
            }
        }
    }

    public function enviar(){

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $this->emailModel->enviarMail($email);
        } else {
            $this->renderer->render('pingPong');
        }

    }

    public function validar(){

    }
}