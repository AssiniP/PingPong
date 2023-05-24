<?php
class LoginController{
    private $renderer;
    public function __construct($renderer){
        $this->renderer = $renderer;
    }

    function list() {
        $this->renderer->render('loginForm');
    }

    function run()
    {
        $this->model->run();

    }


    /* logging out the user */
    function logout()
    {
        Session::destroy();
        header('location: index');
        exit;
    }
}
