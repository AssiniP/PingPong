<?php
require_once( SITE_ROOT . '/helpers/Session.php');
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
    public function sugeridas()
    {
        $data['preguntas'] = $this->editorModel->getQuestions();
        $data["verCategoria"] = $this->editorModel->getAllCategoria();
        if(isset($_GET["id"])) {
            $data['editarPregunta'] = $this->editorModel->getQuestionId(intval($_GET["id"]));
        }
        $this->renderer->render('editarSugeridas',$data);
    }
    public function reportadas()
    {
        $data="";
        $this->renderer->render('editarReportadas',$data);
    }

    public function eliminar() {
        $this->editorModel->delQuestionId($_GET["id"]);
        header('location: /editor/sugeridas');
    }

    public function validateFields() {
        $errorMsg = [];
        if (!$this->checkThatUserFormIsNotEmpty()) {
            $errorMsg[] = "Llena todos los campos";
        }
        $response = ['errorMsg' => $errorMsg];


        if (!empty($errorMsg)) {
            // Enviar respuesta con errores en formato JSON
            echo json_encode($response);
        } else {
            // Llamar a la función add() dentro de un bloque try-catch

            try{
                $this->addPregunta();
            } catch (Exception $e) {
            }
            $response = ['success' => true];
            echo json_encode($response);
        }
    }
    public function addPregunta(){
        $preguntaEdit = isset($_POST['idPregunta']) ? intval($_POST['idPregunta']): intval('0');
        $preguntaData = [
            'idPregunta' => $preguntaEdit,
            'idCategoria' => intval($_POST['idCategoria']),
            'idUsuario' => intval($this->editorModel->getIDUsuarioActual()),
            'pregunta' => $_POST['pregunta'],
            'opcion1' => $_POST['opcion1'],
            'opcion2' => $_POST['opcion2'],
            'opcion3' => $_POST['opcion3'],
            'respuestaCorrecta' => $_POST['respuestaCorrecta']];

        if($preguntaEdit == 0) {
            $this->editorModel->addQuestion($preguntaData);
        } else {
            $this->editorModel->editQuestionId($preguntaData);
        }
    }

    private function checkThatUserFormIsNotEmpty(){
        if(empty($_POST['idCategoria']) || empty($_POST['pregunta']) || empty($_POST['opcion1']) || empty($_POST['opcion2']) ||
            empty($_POST['opcion3']) ||  empty($_POST['respuestaCorrecta'])){
            return false;
        }
        return true;
    }

}
