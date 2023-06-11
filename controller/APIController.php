<?php
include_once ('third-party/APIPreguntas/ApiPreguntas.php');
class APIController
{

    public function __construct() {
    }

    public function list() {
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        $idUsuario = $_GET['usuario'];
        $api->getAll($idUsuario);

    }
}