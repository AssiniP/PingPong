<?php

class MailValiderController
{
    private $renderer;
    private $userModel;
    public function __construct($renderer, $userModel) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list()
    {
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            if($email == "humano.naraesther@gmail.com") $this->renderer->render('login');
            else  $this->renderer->render('mailValider');
        } else {
            $this->renderer->render('pingPong');
        }

    }
}