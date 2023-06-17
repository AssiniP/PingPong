<?php
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
        $data="";
        $this->renderer->render('editor',$data);
    }
    public function sugeridas()
    {
        $data="";
        $this->renderer->render('editarSugeridas',$data);
    }
    public function reportadas()
    {
        $data="";
        $this->renderer->render('editarReportadas',$data);
    }
}
