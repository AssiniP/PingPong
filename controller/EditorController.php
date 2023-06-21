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
        $data['preguntas'] = $this->editorModel->getQuestions();
        $data["verCategoria"] = $this->editorModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->editorModel->getQuestionId(intval($_GET["id"]));
        }
        $this->renderer->render('preguntas',$data);
    }
    public function eliminar() {
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $this->editorModel->delQuestionId($body->idPregunta);
            }
        }
    }

    public function addPregunta(){
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $categoria = $api->getCategory($body->idCategoria);
                $usuario = $api->getUsuarioByID($body->idUsuario);
                if ($body->idUsuario == 0) {
                    $usuario =$api->getUsuarioByID($this->editorModel->getIDUsuarioActual());
                }
                $this->editorModel->delQuestionId($body->idPregunta);
                $api->altaPregunta($body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre'],$usuario['nick']);
            }
        }
    }

    public function delPregunta(){
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

    public function delMotivo(){
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
                $api->modificarPregunta($body->idPregunta,$body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre']);
            }
        }
    }
}
