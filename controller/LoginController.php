<?php
class LoginController{
    private $renderer;
    public function __construct($renderer){
        $this->renderer = $renderer;
    }
    public function showLoginForm(){
        $this->renderer->render('loginForm');
    }
    public function list(){
        $this->renderer->render('pingPong');
    }
}
