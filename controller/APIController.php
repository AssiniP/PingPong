<?php
include_once ('third-party/APIPreguntas/ApiPreguntas.php');
class APIController
{

    public function __construct() {
    }

    public function list() {
        header('Content-Type: application/json');
        $api = new ApiPreguntas();

            if(isset($_GET['usuario'])){
                $idUsuario = $_GET['usuario'];
                $api->getAll($idUsuario);
            }



    }

    public function altaPregunta()
    {
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                echo $api->altaPregunta($body->pregunta->valor,$body->pregunta->opcion1, $body->pregunta->opcion2,$body->pregunta->opcion3, $body->pregunta->correcta,$body->pregunta->categoria,$body->usuario);
            }


        }
    }

    public  function bajaPregunta(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if(isset($_GET['pregunta'])){
            $idPregunta = $_GET['pregunta'];
            echo $api->bajaPregunta($idPregunta);
        }
    }

    public function editarPregunta(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                echo $api->modificarPregunta($body->pregunta->id,$body->pregunta->valor,$body->pregunta->opcion1, $body->pregunta->opcion2,$body->pregunta->opcion3, $body->pregunta->opcion4, $body->pregunta->correcta,$body->pregunta->categoria);
            }


        }
    }
}