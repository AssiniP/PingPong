<?php

class UsersController
{
    public function __construct($renderer){
        $this->renderer = $renderer;
    }
    public function list(){
        $this->renderer->render('registerForm');
    }



}