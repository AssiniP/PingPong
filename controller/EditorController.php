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

    public function eliminar() {
        if (!empty($_POST["idPregunta"])) {
            $this->editorModel->delQuestionId($_POST["idPregunta"]);
        }
        $response = ['success' => true];
        echo json_encode($response);
    }

    public function addPregunta(){
       /* $errorMsg = [];
        if (!$this->checkThatUserFormIsNotEmpty()) {
            $errorMsg[] = "Llena todos los campos";
        }
        $response = ['errorMsg' => $errorMsg];


        if (!empty($errorMsg)) {
            // Enviar respuesta con errores en formato JSON
            echo json_encode($response);
        } else {
            // Llamar a la función add() dentro de un bloque try-catch
            $this->editorModel->delQuestionId($_POST["idPregunta"]);
            try{
                // Esta es la funcion que llama a la api
                $this->addApiPregunta();
            } catch (Exception $e) {
            }
            $response = ['success' => true];
            echo json_encode($response);
        }*/
        header('Content-Type: application/json');
        $api = new ApiPreguntas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $jsonData = file_get_contents('php://input');
            if($jsonData!= null){
                $body = json_decode($jsonData);
                $categoria = $api->getCategory($body->idCategoria);
                $usuario = $api->getUsuarioByID($body->idUsuario);
                $api->altaPregunta($body->pregunta,$body->opcion1,$body->opcion2,$body->opcion3,$body->respuestaCorrecta,$categoria['nombre'],$usuario['nick']);
            }
        }

    }
    public function addApiPregunta(){
        $usuarioAprobado = intval($_POST['idUsuario']);
        if($usuarioAprobado == 0){
            $usuarioAprobado = $this->editorModel->getIDUsuarioActual();
        }
        $preguntaData = [
            'idPregunta' => intval($_POST['idPregunta']),
            'idCategoria' => intval($_POST['idCategoria']),
            'idUsuario' => $usuarioAprobado,
            'pregunta' => $_POST['pregunta'],
            'opcion1' => $_POST['opcion1'],
            'opcion2' => $_POST['opcion2'],
            'opcion3' => $_POST['opcion3'],
            'respuestaCorrecta' => $_POST['respuestaCorrecta']];

        // Aca se llama al alta de la api.
        if (!empty($_POST["idReportada"]) && intval($_POST['idReportada']) != 0) {
            // Editar ApiPregunta
        } else {
            // Alta ApiPregunta
        }
    }

    public function delPregunta(){
        //Elimina el reporte y elimino la pregunta
       $this->editorModel->delReporteId($_POST["idReportada"]);
       $idPregunta= inv($_POST["idPregunta"]);
       // Llamo a la api y borro la pregunta de la api
    }

    public function delMotivo(){
        //Elimina el reporte  de la pregunta
        $this->editorModel->delReporteId($_POST["idReportada"]);
    }

    private function checkThatUserFormIsNotEmpty(){
        if(empty($_POST['idCategoria']) || empty($_POST['pregunta']) || empty($_POST['opcion1']) || empty($_POST['opcion2']) ||
            empty($_POST['opcion3']) ||  empty($_POST['respuestaCorrecta'])){
            return false;
        }
        return true;
    }
}
