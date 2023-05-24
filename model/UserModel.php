<?php

class UserModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getUsers() {
        return $this->database->query('SELECT * FROM usuario');
    }

    //validar que ni el usuario ni el email ya se encuentren registrados.
    public function check_user($nick_name,$email) {
        return $this->database->query("SELECT * FROM `usuario` WHERE nickname = '".$user_name."' OR email = '".$email."'");
    }

}