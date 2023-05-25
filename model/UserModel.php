<?php

class UserModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getUsers() {
        return $this->database->query('SELECT * FROM usuario');
    }

    //validar que ni el usuario ni el email ya se encuentren registrados.
    public function check_user($nickname,$email) {
        return $this->database->query("SELECT * FROM `usuario` WHERE nickname like '".$nickname."' OR email like '".$email."'");
    }

    //validar que el usuario y la password existan
    public function validarLogin(String $nickname, String $password){
        return $this->database->query("SELECT * FROM usuario WHERE nickname like '".$nickname."' and password like '".$password."'");
    }

    public function addUser($userData){
        //deberia cambiar imagen perfil por otra cosa
        $query = "INSERT INTO usuario (nickname, password, nombre, email, ubicacion, imagenPerfil,
                     pais, idRol, idGenero, fechaRegistro, ciudad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        $this->database->insertUser($query, $userData);
    }
}