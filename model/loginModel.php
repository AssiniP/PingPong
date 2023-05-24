<?php

class loginModel
{
    public function __construct($database) {
        $this->database = $database;
        Session::init();
    }

    public function run()
    {

        $nick_name=$_POST['nickname'];
        // Se encripta la pass para validarla
        $password=md5($_POST['password']);

        $res = $this->database->query("SELECT * FROM  usuario U, rol R  WHERE  R.id=U.idRol and  U.nickname = '".$nick_name."' AND U.password = '".$password."'");
        $count = count($res);

        if ($count > 0) {

            Session::init();
            Session::set('rol',$res[0]['rol']);
            Session::set('loggedIn', true);
            Session::set('nickname', $nick_name);
            $this->renderer->render('registerForm');


        }
        else {
            Session::set('loggedIn', false);
           // header('location: '.URL);
            $this->renderer->render('registerForm');
        }


    }



}