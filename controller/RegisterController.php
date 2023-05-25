<?php

class RegisterController
{  private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer){
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }

    public function list() {
        $this->renderer->render('register');
    }

    public function add(){
        if(!isset($_POST['nickName'])  || !isset($_POST['email']) || !isset($_POST['password']) ||
            !isset($_POST['repassword']) || !isset($_POST['nombre']) || !isset($_POST['ubicacion']) ||
            !isset($_POST['imagenPerfil']) || !isset($_POST['pais']) || !isset($_POST['idGenero']) ||
            !isset($_POST['ciudad'])){
            echo "Cargar todos los campos";
            exit;
        }

        $nickname = $_POST['nickName'];
        $email = $_POST['email'];
        $data["usuario"] = $this->userModel->check_user($nickname, $email);
        if (count($data["usuario"])>0) {
            echo 'Ya existe el mail y/o el usuario';
            exit;
        }

/*

        if ($request->password !== $request->repassword) {

            return redirect()->back()->withErrors(['repassword' => 'Las contraseñas no coinciden.'])->withInput();
            exit;

        }*/
        
        // Validar que la contraseña y su reingreso sean iguales
        //if ($request->password !== $request->repassword) {
         //   $request->validate(['repassword' => 'Las contraseñas no coinciden.']);
        //}

        // Resto del código para agregar el usuario a la base de datos
    }


}