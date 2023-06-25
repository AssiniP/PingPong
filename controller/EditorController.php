<?php
require_once( SITE_ROOT . '/helpers/Session.php');
include_once ('third-party/APIPreguntas/ApiPreguntas.php');
class EditorController{
    private $renderer;
    private $editorModel;

    public function __construct($EditorModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->editorModel = $EditorModel;
    }

    public function list()
    {
        $this->renderer->render('editor');
    }

    /// Preguntas Sugeridas
    public function sugeridas()
    {
        $data['preguntas'] = $this->editorModel->getQuestions();
        $data["verCategoria"] = $this->editorModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->editorModel->getQuestionId(intval($_GET["id"]));
        }
        $this->renderer->render('editarSugeridas',$data);
    }
    /// Preguntas Reportadas
    public function reportadas()
    {
        $data['preguntas'] = $this->editorModel->getQuestionsReportada();
        $data["verCategoria"] = $this->editorModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->editorModel->getQuestionIdReportadas(intval($_GET["id"]));
        }
        $this->renderer->render('editarReportadas',$data);
    }
   /// ABM Preguntas
    public function preguntas()
    {
        $data['preguntas'] = $this->editorModel->getQuestionsAPI();
        $data["verCategoria"] = $this->editorModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->editorModel->getQuestionIdAPI(intval($_GET["id"]));
        }
        $this->renderer->render('preguntas',$data);
    }

    //Eliminar de pregunta_sugerida
    public function eliminarSugerida() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $this->editorModel->delQuestionId($body->idPregunta);
            }
        }
    }

    //Guardar de pregunta_sugerida Elimina de Sugerida y Agrega a la API
    public function guardarSugerida(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $categoria = $api->getCategory($body->idCategoria);
                if ($body->idUsuario == 0) {
                    $usuario =$api->getUsuarioByID($this->editorModel->getIDUsuarioActual());
                } else {
                    $usuario = $api->getUsuarioByID($body->idUsuario);
                }
                $this->editorModel->delQuestionId($body->idPregunta);
                $api->altaPregunta($body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre'],$usuario['nick']);


            }
        }
    }

    //Elimina de pregunta API
    public function eliminarAPI(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $categoria = $api->getCategory($body->idCategoria);
                //Elimina el reporte  de la pregunta
                $this->editorModel->delReporteId($body->idReportada);
                // Updatea la pregunta por si tuvo alguna correccion del reporte.
                $api->bajaPregunta($body->idPregunta);
            }
        }
    }


    //Guardar de pregunta API
    public function guardarAPI(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $categoria = $api->getCategory($body->idCategoria);
                if ($body->idUsuario == 0) {
                    $usuario =$api->getUsuarioByID($this->editorModel->getIDUsuarioActual());
                } else {
                    $usuario = $api->getUsuarioByID($body->idUsuario);
                }
                //Elimina el reporte  de la pregunta
                $this->editorModel->delReporteId($body->idReportada);
                if ($body->idPregunta == 0){
                    // Da de alta
                    $api->altaPregunta($body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre'],$usuario['nick']);
                } else {
                    // Updatea la pregunta por si tuvo alguna correccion.
                    $api->modificarPregunta($body->idPregunta,$body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre']);
                }
            }
        }
    }
}
